<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\SubAnswer;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubAnswerExport;
use Illuminate\Support\Facades\Cache;

class SubAnswerController extends Controller
{
    public $webspice;
    public $tableName;
    protected $sub_answers;


    public function __construct(SubAnswer $sub_answers, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->sub_answers = $sub_answers;
        $this->tableName = 'sub_answers';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_answer.view');
        // $sub_answers = Cache::remember('answers-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->sub_answers->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->sub_answers->orderBy('created_at', 'desc');
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('value', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('value_bangla', 'LIKE', '%' . $searchText . '%');
            });
        }
        # elequent join with question model
        $query->with('answer');
        # Export
        if (in_array($type=$request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'SubAnswer List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new SubAnswerExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new SubAnswerExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $sub_answers = $query->paginate(5);
        // });

        return view('sub_answer.index', compact('sub_answers'));
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
        $this->webspice->permissionVerify('sub_answer.create');
        if (!Cache::has('active-answers')) {
            $answers = Answer::where(['status' => 1])->get();
            Cache::forever('active-answers', $answers);
        } else {
            // $answers = Cache::get('sub_answers')->where('status',1);
            $answers = Cache::get('active-answers');
        }

        return view('sub_answer.create', [
            'answers' => $answers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_answer.create');

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:sub_answers',
                'answer_id' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'answer_id.required' => 'Answer field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'answer_id' => $request->answer_id,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->sub_answers->create($data);
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
        $this->webspice->permissionVerify('sub_answer.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $sub_answerInfo = $this->sub_answers->find($id);
        if (!Cache::has('active-answers')) {
            $answers = Answer::where(['status' => 1])->get();
            Cache::forever('active-answers', $answers);
        } else {
            // $answers = Cache::get('sub_answers')->where('status',1);
            $answers = Cache::get('active-answers');
        }
        return view('sub_answer.edit', [
            'sub_answerInfo' => $sub_answerInfo,
            'answers' => $answers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('sub_answer.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:sub_answers,value,' . $id,
                'answer_id' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'answer_id.required' => 'Answer field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $question = $this->sub_answers->find($id);
            $question->value = $request->value;
            $question->value_bangla = $request->value_bangla;
            $question->answer_id = $request->answer_id;
            $question->updated_at = $this->webspice->now('datetime24');
            $question->updated_by = $this->webspice->getUserId();
            $question->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('sub_answers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('sub_answer.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = $this->sub_answers->findOrFail($id);
            if (!is_null($question)) {
                $question->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_answer.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $sub_answer = SubAnswer::withTrashed()->findOrFail($id);
            $sub_answer->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_answer.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $sub_answer = SubAnswer::withTrashed()->findOrFail($id);
            $sub_answer->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('sub_answers.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_answer.restore');
        try {
            $sub_answers = SubAnswer::onlyTrashed()->get();
            foreach ($sub_answers as $sub_answer) {
                $sub_answer->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('sub_answers.index');
    }
}
