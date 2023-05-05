<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use App\Models\Question;
use Exception;
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
            $query = $this->questions->orderBy('created_at', 'desc');
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
            // return $query->paginate(5);
            $questions = $query->paginate(5);
        // });
   
        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('question.create');
        return view('question.create');
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
                'value' => 'required|regex:/^[a-zA-Z0-9._ ]+$/u|min:3|max:1000|unique:questions',
            ],
            [
                'value.required' => 'Value field is required.'
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );


        try {
            $question = $this->questions->create($data);
            if ($question) {
                $this->webspice->log($this->tableName, $question->id, "INSERTED");
                # Cache Update
                $this->webspice->forgetCache($this->tableName);
                $this->webspice->insertOrFail('success');
            } else {
                $this->webspice->insertOrFail('error');
            }
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
        return view('question.edit', [
            'questionInfo' => $questionInfo,
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
                'value' => 'required|regex:/^[a-zA-Z0-9._ ]+$/u|min:3|max:1000|unique:questions,value,' . $id,
            ],
            [
                'value.required' => 'Value field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );

        $question = $this->questions->find($id);

        $question->value = $request->value;
        $question->value_bangla = $request->value_bangla;
        $question->updated_at = $this->webspice->now('datetime24');
        $question->updated_by = $this->webspice->getUserId();
        try {
            $result = $question->save();
            if ($result) {
                #Log
                $this->webspice->log($this->tableName, $id, "UPDATED");
                # Cache Update
                $this->webspice->forgetCache($this->tableName);
                #Message
                $this->webspice->updateOrFail('success');
            } else {
                $this->webspice->updateOrFail('error');
            }
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

        $id = $this->webspice->encryptDecrypt('decrypt', $id);
        $question = $this->questions->find($id);
        try {
            if (!is_null($question)) {
                $result = $question->delete();
            }
            if ($result) {
                # Log
                $this->webspice->log($this->tableName, $id, "DELETED");
                $this->webspice->deleteOrFail('success');
            } else {
                $this->webspice->deleteOrFail('error');
            }
        } catch (Exception $e) {
            $this->webspice->deleteOrFail('error', $e->getMessage());
        }
        return back();
    }
}
