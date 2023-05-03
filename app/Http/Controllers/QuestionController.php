<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;

class QuestionController extends Controller
{
    public $webspice;
    protected $user;
    protected $questions;
    protected $userid;
    public $tableName;
    

    public function __construct(Question $questions)
    {
        $this->webspice = new Webspice();
        $this->questions = $questions;
        $this->tableName = 'questions';
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    
    public function index(Request $request)
    {
         #permission verfy
         $this->webspice->permissionVerify('question.view');

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
        $questions = $query->paginate(10);
        return view('question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
