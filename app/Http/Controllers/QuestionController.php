<?php

namespace App\Http\Controllers;

use App\Exports\QuestionExport;
use App\Interfaces\Crud;
use App\Lib\Webspice;
use App\Models\Answer;
use App\Models\Question;
use App\Models\RespondentType;
use App\Traits\MasterData;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use DB;

use Illuminate\Support\Facades\URL;

use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

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
        $this->tableName = 'tbl_q';
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
            $query = $this->questions->orderBy('tbl_q.deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            //$query = $this->questions->orderBy('created_at', 'desc');
            $query = $this->questions->orderBy('tbl_q.sl_order', 'asc');
        }
        $query->with('category');
        $query->leftJoin('tbl_a as ans', function ($join) {
            $join->on('tbl_q.relation_id', '=', 'ans.id')
                ->where('tbl_q.related_to', '=', 'answare');
        })->leftJoin('tbl_q as ques', function ($join) {
            $join->on('tbl_q.relation_id', '=', 'ques.id')
                ->where('tbl_q.related_to', '=', 'question');
        });


        if ($request->search_related_to != null) {
            $query->where('tbl_q.related_to', $request->search_related_to);
        }

        if ($request->search_status != null) {
            $query->where('tbl_q.status', $request->search_status);
        }
        if ($request->search_category != null) {
            $query->where('tbl_q.category_id', $request->search_category);
        }
        if ($request->search_respondent_type != null) {
            $query->whereRaw("FIND_IN_SET(?, tbl_q.respondent_type)", $request->search_respondent_type);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('tbl_q.question', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('tbl_q.question_bangla', 'LIKE', '%' . $searchText . '%');
            });
        }
        $query->select('tbl_q.*', 'ans.answare as aRelName', 'ans.answare_bangla as aRelNameBangla', 'ques.question as qRelName');
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
        $perPage = request()->input('perPage', 10);
        // dd($query->toSql());         
        $questions = $query->paginate($perPage);
        $categories = $this->getCategory();
        $respondent_types = RespondentType::all();
        return view('question.index', compact('questions', 'categories', 'respondent_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        #permission verfy
        $this->webspice->permissionVerify('question.create');
        $questions = Question::where('status', 7)->get();
        $answers = Answer::where('status', 7)->get();
        $categories = $this->getActiveCategory();
        $respondent_types = RespondentType::where('status', 7)->get();
        return view('question.create', [
            'categories' => $categories,
            'questions' => $questions,
            'answers' => $answers,
            'respondent_types' => $respondent_types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        #permission verfy
        $this->webspice->permissionVerify('question.create');

        $request->validate(
            [
                'question' => ['required', 'min:3', 'max:1000', 'unique:tbl_q', new EnglishCharacters],
                'question_bangla' => ['required', 'min:3', 'max:1000', 'unique:tbl_q', new BanglaCharacters],
                'category_id' => 'required',
                'related_to' => 'required',
                'answare_type' => 'required',
                'input_type' => Rule::requiredIf(fn () => ($request->answare_type == 'input')),
                'relation_id' => Rule::requiredIf(fn () => ($request->related_to != 'level1')),
                'is_required' => 'required'
            ]
        );
        try {
            $question = new Question();
            $question->question = $request->question;
            $question->question_bangla = $request->question_bangla;
            $question->category_id = $request->category_id;
            $question->respondent_type = implode(",", $request->respondent_type);
            $question->related_to = $request->related_to;
            $question->answare_type = $request->answare_type;
            $question->input_type = $request->input_type;
            $question->relation_id = $request->relation_id;
            $question->is_required = $request->is_required;
            $question->info = $request->info;
            $question->info_bangla = $request->info_bangla;
            $question->sub_info = $request->sub_info;
            $question->sub_info_bangla = $request->sub_info_bangla;
            $question->created_at = $this->webspice->now('datetime24');
            $question->created_by = $this->webspice->getUserId();
            $question->status = 7;
            $question->save();
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

        $questions = Question::where('status', 7)->get();
        $answers = Answer::where('status', 7)->get();
        $categories = $this->getActiveCategory();
        $respondent_types = RespondentType::where('status', 7)->get();
        return view('question.edit', [
            'questionInfo' => $questionInfo,
            'questions' => $questions,
            'answers' => $answers,
            'categories' => $categories,
            'respondent_types' => $respondent_types,
            'currentPage' =>  request()->query('page', 1)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        # permission verfy
        $this->webspice->permissionVerify('question.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                //     'value' => ['required','min:3','max:1000',Rule::unique('questions')->ignore($id, 'id')->where(function ($query) use($request,$respondent) {
                //         return $query->where('value', $request->value)
                //             ->where('respondent', $respondent);
                //     })],
                'question' => ['required', 'min:3', 'max:1000', new EnglishCharacters, Rule::unique('tbl_q')->ignore($id, 'id')->where(function ($query) use ($request) {
                    return $query->where('question_bangla', $request->question_bangla)
                        ->where('question', $request->question)
                        ->where('relation_id', $request->relation_id);
                })],

                'question_bangla' => ['required', 'min:3', 'max:1000', new BanglaCharacters],

                // 'question' => 'required|min:1|max:1000|unique:tbl_q,question,' . $id,
                // 'question_bangla' => 'required|min:1|max:1000|unique:tbl_q,question_bangla,' . $id,
                'category_id' => 'required',
                'respondent_type' => 'required',
                'related_to' => 'required',
                'answare_type' => 'required',
                'input_type' => Rule::requiredIf(fn () => ($request->answare_type == 'input')),
                'relation_id' => Rule::requiredIf(fn () => ($request->related_to != 'level1')),
                'is_required' => 'required'
            ]
        );
        try {
            // dd($request->respondent_type);
            $question = $this->questions->find($id);
            $question->question = $request->question;
            $question->question_bangla = $request->question_bangla;
            $question->category_id = $request->category_id;
            $question->respondent_type = implode(",", $request->respondent_type);
            $question->related_to = $request->related_to;
            $question->answare_type = $request->answare_type;
            $question->input_type = $request->input_type;
            $question->relation_id = $request->relation_id;
            $question->is_required = $request->is_required;
            $question->info = $request->info;
            $question->info_bangla = $request->info_bangla;
            $question->sub_info = $request->sub_info;
            $question->sub_info_bangla = $request->sub_info_bangla;
            $question->updated_at = $this->webspice->now('datetime24');
            $question->updated_by = $this->webspice->getUserId();
            $question->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect(route('questions.index', ['page' => $request->input('currentPage', 1)]));
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        # permission verfy
        $this->webspice->permissionVerify('question.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = $this->questions->findOrFail($id);
            if (!is_null($question)) {
                $question->status = -7;
                $question->save();
                $question->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }

    public function forceDelete($id): RedirectResponse
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
    public function restore($id): RedirectResponse
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $question = Question::withTrashed()->findOrFail($id);
            $question->status = 7;
            $question->save();
            $question->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }

    public function restoreAll(): RedirectResponse
    {
        #permission verfy
        $this->webspice->permissionVerify('question.restore');
        try {
            $questions = Question::onlyTrashed()->get();
            foreach ($questions as $question) {
                $question->status = 7;
                $question->save();
                $question->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('questions.index');
    }
}
