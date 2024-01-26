<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnswerExport;
use App\Models\RespondentType;
use Illuminate\Support\Facades\Cache;

use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

class AnswerController extends Controller
{
    public $webspice;
    public $tableName;
    protected $answers;


    public function __construct(Answer $answers, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->answers = $answers;
        $this->tableName = 'tbl_a';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('answer.view');
        // $answers = Cache::remember('questions-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->answers->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->answers->orderBy('sl_order', 'ASC');
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }

        if ($request->search_respondent_type != null) {
            $query->whereRaw("FIND_IN_SET(?,respondent_type)", $request->search_respondent_type);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('answare', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('answare_bangla', 'LIKE', '%' . $searchText . '%');
            });
        }
        # elequent join with question model
        $query->with('question');
        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Answer List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new AnswerExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new AnswerExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }
        $perPage = request()->input('perPage', 5);
        $answers = $query->paginate($perPage);
        // });
        $respondent_types = RespondentType::all();
        return view('answer.index', compact('answers','respondent_types'));
    }

    public function export(String $type, $query, String $title)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        #permission verfy
        $this->webspice->permissionVerify('answer.create');

        // if (!Cache::has('active-questions')) {
        $questions = Question::where(['status' => 7])->get();
        //     Cache::forever('active-questions', $questions);
        // } else {
        //     // $questions = Cache::get('questions')->where('status',1);
        //     $questions = Cache::get('active-questions');
        // }
        $respondent_types = RespondentType::where('status', 7)->get();
        return view('answer.create', [
            'questions' => $questions,
            'respondent_types' => $respondent_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('answer.create');

        $request->validate(
            [
                'answare' => ['required','min:3','max:1000', 'unique:tbl_a', new EnglishCharacters],
                'answare_bangla' => ['required','min:3','max:1000', 'unique:tbl_a', new BanglaCharacters],
                'question_id' => 'required',
                'respondent_type' => 'required',
            ]
        );

        $data = array(
            'answare' => $request->answare,
            'answare_bangla' => $request->answare_bangla,
            'question_id' => $request->question_id,
            'respondent_type' => implode(",", $request->respondent_type),
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
            'status' => 7,
        );

        try {
            $this->answers->create($data);
        } catch (Exception $e) {
            $this->webspice->insertOrFail('error', $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('answer.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $answerInfo = $this->answers->find($id);
        // if (!Cache::has('active-questions')) {
            $questions = Question::where(['status' => 7])->get();
        //     Cache::forever('active-questions', $questions);
        // } else {
        //     // $questions = Cache::get('questions')->where('status',1);
        //     $questions = Cache::get('active-questions');
        // }
        $respondent_types = RespondentType::where('status', 7)->get();
        return view('answer.edit', [
            'answerInfo' => $answerInfo,
            'questions' => $questions,
            'respondent_types' => $respondent_types,
            'currentPage' =>  request()->query('page', 1)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('answer.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'answare' => ['required','min:3','max:1000','unique:tbl_a,answare,' . $id, new EnglishCharacters],
                'answare_bangla' => ['required','min:3','max:1000','unique:tbl_a,answare_bangla,' . $id, new BanglaCharacters],
                'question_id' => 'required',
                'respondent_type' => 'required',
            ]
        );
        try {
            $answer = $this->answers->find($id);
            $answer->answare = $request->answare;
            $answer->answare_bangla = $request->answare_bangla;
            $answer->question_id = $request->question_id;
            $answer->respondent_type = implode(",", $request->respondent_type);
            $answer->updated_at = $this->webspice->now('datetime24');
            $answer->updated_by = $this->webspice->getUserId();
            $answer->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        // return redirect('answers');
        return redirect(route('answers.index', ['page' => $request->input('currentPage', 1)]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('answer.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $answer = $this->answers->findOrFail($id);
            if (!is_null($answer)) {
                $answer->status = -7;
                $answer->save();
                $answer->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
        return response()->json(['error' => 'Unauthenticated.'], 401);
        #permission verfy
        $this->webspice->permissionVerify('answer.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $answer = Answer::withTrashed()->findOrFail($id);
            $answer->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('answer.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $answer = Answer::withTrashed()->findOrFail($id);
            $answer->status = 7;
            $answer->save();
            $answer->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('answers.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('answer.restore');
        try {
            $answers = Answer::onlyTrashed()->get();
            foreach ($answers as $answer) {
                $answer->status = 7;
                $answer->save();
                $answer->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('answers.index');
    }
}
