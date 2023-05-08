<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\Question;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuestionExport;
use Illuminate\Support\Facades\Cache;

class QuestionController extends Controller
{
    public $webspice;
    public $tableName;
    protected $questions;


    public function __construct(Question $questions, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->questions = $questions;
        $this->tableName = 'questions';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('question.view');
        // $questions = Cache::remember('questions-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->questions->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->questions->orderBy('created_at', 'desc');
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
        $query->with('option');
        if (in_array($type=$request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Question List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new QuestionExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new QuestionExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $questions = $query->paginate(5);
        // });

        return view('question.index', compact('questions'));
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
        $this->webspice->permissionVerify('question.create');
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            // $respondents = Cache::get('respondent-options')->where('status',1);
            $respondents = Cache::get('active-respondent-options');
        }

        return view('question.create', [
            'respondents' => $respondents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('question.create');

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:questions',
                'respondent_id' => 'required',
                'input_method' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'respondent_id.required' => 'Respondent field is required.',
                'input_method.required' => 'Input method field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'respondent_id' => $request->respondent_id,
            'input_method' => $request->input_method,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->questions->create($data);
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
        $this->webspice->permissionVerify('question.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $questionInfo = $this->questions->find($id);
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            // $respondents = Cache::get('respondent-options')->where('status',1);
            $respondents = Cache::get('active-respondent-options');
        }
        return view('question.edit', [
            'questionInfo' => $questionInfo,
            'respondents' => $respondents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('question.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:questions,value,' . $id,
                'respondent_id' => 'required',
                'input_method' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'respondent_id.required' => 'Respondent field is required.',
                'input_method.required' => 'Input method field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $question = $this->questions->find($id);
            $question->value = $request->value;
            $question->value_bangla = $request->value_bangla;
            $question->respondent_id = $request->respondent_id;
            $question->input_method = $request->input_method;
            $question->updated_at = $this->webspice->now('datetime24');
            $question->updated_by = $this->webspice->getUserId();
            $question->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('questions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('question.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = $this->questions->findOrFail($id);
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
        $this->webspice->permissionVerify('question.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $permission = Question::withTrashed()->findOrFail($id);
            $permission->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $permission = Question::withTrashed()->findOrFail($id);
            $permission->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $permissions = Question::onlyTrashed()->get();
            foreach ($permissions as $permission) {
                $permission->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }
}
