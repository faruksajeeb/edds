<?php

namespace App\Http\Controllers;

use App\Interfaces\Crud;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use App\Models\Question;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuestionExport;
use App\Traits\MasterData;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;



class QuestionController extends Controller implements Crud
{
    use MasterData;

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
            // $query = $this->questions->orderBy('created_at', 'desc');
            $query = $this->questions->orderBy('sl_order', 'asc');
        }
        if ($request->search_category != null) {
            $query->where('category_id', $request->search_category);
        }
        if ($request->search_respondent != null) {
            $query->where('respondent', $request->search_respondent);
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
        $query->with('category','subQuestions');
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Question List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'pdf') {

                return Excel::download(new QuestionExport($query->get(), $title), $fileName . '_' . time() . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            }
            if ($type == 'csv') {
                return Excel::download(new QuestionExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new QuestionExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }
        // $query->has('subQuestions'); # It means, get which questions has sub qestions.
        $perPage = request()->input('perPage', 5); 
        $questions = $query->paginate($perPage);

        $categories = MasterData::getCategory();
        $respondents = MasterData::getRespondent();
        return view('question.index', compact('questions', 'categories', 'respondents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        #permission verfy
        $this->webspice->permissionVerify('question.create');

        $categories = MasterData::getActiveCategory();
        $respondents = MasterData::getActiveRespondent();

        return view('question.create', [
            'categories' => $categories,
            'respondents' => $respondents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        #permission verfy
        $this->webspice->permissionVerify('question.create');
        $respondent = implode(",", $request->respondent);
        $request->validate(
            [
                // 'value' => [
                //     'required','min:1','max:1000',
                //     Rule::unique('questions')->where(function ($query) use($request,$respondent) {
                //         return $query->where('value', $request->value)
                //             ->where('respondent', $respondent);
                //     })
                // ],
                // 'value_bangla' => [
                //     'required','min:1','max:1000',
                //     Rule::unique('questions')->where(function ($query) use($request,$respondent) {
                //         return $query->where('value_bangla', $request->value_bangla)
                //             ->where('respondent', $respondent);
                //     })
                // ],
                'value' => 'required|min:1|max:1000|unique:questions',
                'value_bangla' => 'required|min:1|max:1000|unique:questions',
                'category_id' => 'required',
                'respondent' => 'required',
                'input_method' => 'required',
                'input_type' => 'required',
                'is_required' => 'required',
                'image_require' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'value.unique' => 'This question has already been taken for this respondent (' . $respondent . ')',
                'value_bagla.required' => 'Value Bangla field is required.',
                'value_bagla.unique' => 'This question value bangla has already been taken for this respondent (' . $respondent . ')',
                'category_id.required' => 'Category field is required.',
                'respondent.required' => 'Respondent field is required.',
                'input_method.required' => 'Input method field is required.',
                'input_type.required' => 'Input type field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'category_id' => $request->category_id,
            'respondent' => $respondent,
            'input_method' => $request->input_method,
            'input_type' => $request->input_type,
            'is_required' => $request->is_required,
            'image_require' => $request->image_require,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $question = $this->questions->create($data);
            # if sub questions
            // if($request->get('sub_question_value') !=''){
            // $question->subQuestions()->create([
            //     'value' => 'test_sub',
            //     'value_bangla' => 'test_sub_bangla',
            //     'created_at' => $this->webspice->now('datetime24'),
            //     'created_by' => $this->webspice->getUserId(),
            // ]);
            // }
        } catch (Exception $e) {
            $this->webspice->insertOrFail('error', $e->getMessage());
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('question.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        # permission verfy
        $this->webspice->permissionVerify('question.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $questionInfo = $this->questions->find($id);

        $categories = MasterData::getActiveCategory();
        $respondents = MasterData::getActiveRespondent();

        return view('question.edit', [
            'questionInfo' => $questionInfo,
            'categories' => $categories,
            'respondents' => $respondents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : RedirectResponse
    {
        # permission verfy
        $this->webspice->permissionVerify('question.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);
        $respondent = implode(",", $request->respondent);
        $request->validate(
            [
                //     'value' => ['required','min:3','max:1000',Rule::unique('questions')->ignore($id, 'id')->where(function ($query) use($request,$respondent) {
                //         return $query->where('value', $request->value)
                //             ->where('respondent', $respondent);
                //     })],
                //     'value_bangla' => ['required','min:3','max:1000',Rule::unique('questions')->ignore($id, 'id')->where(function ($query) use($request,$respondent) {
                //         return $query->where('value_bangla', $request->value_bangla)
                //             ->where('respondent', $respondent);
                //     })],
                'value' => 'required|min:1|max:1000|unique:questions,value,' . $id,
                'value_bangla' => 'required|min:1|max:1000|unique:questions,value_bangla,' . $id,
                'category_id' => 'required',
                'respondent' => 'required',
                'input_method' => 'required',
                'input_type' => 'required',
                'is_required' => 'required',
                'image_require' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'value.unique' => 'This question has already been taken for this respondent (' . $respondent . ')',
                'value_bangla.required' => 'Value Bangla field is required.',
                'value_bangla.unique' => 'This question value bangla has already been taken for this respondent (' . $respondent . ')',
                'category_id.required' => 'Category field is required.',
                'respondent.required' => 'Respondent field is required.',
                'value.unique' => 'This value has already been taken for another record.',
                'input_method.required' => 'Input method field is required.',
                'input_type.required' => 'Input type field is required.',
            ]
        );
        try {
            $question = $this->questions->find($id);
            $question->value = $request->value;
            $question->value_bangla = $request->value_bangla;
            $question->category_id = $request->category_id;
            $question->respondent = $respondent;
            $question->input_method = $request->input_method;
            $question->input_type = $request->input_type;
            $question->is_required = $request->is_required;
            $question->image_require = $request->image_require;
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
    public function destroy(string $id) : RedirectResponse
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


    public function forceDelete($id) : RedirectResponse
    {
        abort(403, 'SORRY! unauthenticated access!');
        #permission verfy
        $this->webspice->permissionVerify('question.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = Question::withTrashed()->findOrFail($id);
            $question->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id) : RedirectResponse
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = Question::withTrashed()->findOrFail($id);
            $question->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }

    public function restoreAll() : RedirectResponse
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $questions = Question::onlyTrashed()->get();
            foreach ($questions as $question) {
                $question->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }
}
