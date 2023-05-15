<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\SubQuestion;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubQuestionExport;
use Illuminate\Support\Facades\Cache;

class SubQuestionController extends Controller
{
    public $webspice;
    public $tableName;
    protected $sub_questions;


    public function __construct(SubQuestion $sub_questions, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->sub_questions = $sub_questions;
        $this->tableName = 'sub_questions';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_question.view');
        // $sub_questions = Cache::remember('questions-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->sub_questions->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->sub_questions->orderBy('created_at', 'desc');
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
        $query->with('question');
        # Export
        if (in_array($type=$request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'SubQuestion List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new SubQuestionExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new SubQuestionExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $sub_questions = $query->paginate(10);
        // });

        return view('sub_question.index', compact('sub_questions'));
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
        $this->webspice->permissionVerify('sub_question.create');
        if (!Cache::has('active-questions')) {
            $questions = Question::where(['status' => 1])->get();
            Cache::forever('active-questions', $questions);
        } else {
            // $questions = Cache::get('sub_questions')->where('status',1);
            $questions = Cache::get('active-questions');
        }

        return view('sub_question.create', [
            'questions' => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_question.create');

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:sub_questions',
                'question_id' => 'required',
                'input_method' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'question_id.required' => 'Question field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'question_id' => $request->question_id,
            'input_method' => $request->input_method,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->sub_questions->create($data);
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
        $this->webspice->permissionVerify('sub_question.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $sub_questionInfo = $this->sub_questions->find($id);
        if (!Cache::has('active-questions')) {
            $questions = Question::where(['status' => 1])->get();
            Cache::forever('active-questions', $questions);
        } else {
            // $questions = Cache::get('sub_questions')->where('status',1);
            $questions = Cache::get('active-questions');
        }
        return view('sub_question.edit', [
            'sub_questionInfo' => $sub_questionInfo,
            'questions' => $questions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('sub_question.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:sub_questions,value,' . $id,
                'question_id' => 'required',
                'input_method' => 'required',
                'input_method.required' => 'Input method field is required.',
            ],
            [
                'value.required' => 'Value field is required.',
                'question_id.required' => 'Question field is required.',
                'input_method.required' => 'Input method field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $question = $this->sub_questions->find($id);
            $question->value = $request->value;
            $question->value_bangla = $request->value_bangla;
            $question->question_id = $request->question_id;
            $question->input_method = $request->input_method;
            $question->updated_at = $this->webspice->now('datetime24');
            $question->updated_by = $this->webspice->getUserId();
            $question->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('sub_questions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('sub_question.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = $this->sub_questions->findOrFail($id);
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
        $this->webspice->permissionVerify('sub_question.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $sub_question = SubQuestion::withTrashed()->findOrFail($id);
            $sub_question->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_question.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $sub_question = SubQuestion::withTrashed()->findOrFail($id);
            $sub_question->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('sub_questions.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('sub_question.restore');
        try {
            $sub_questions = SubQuestion::onlyTrashed()->get();
            foreach ($sub_questions as $sub_question) {
                $sub_question->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('sub_questions.index');
    }
}