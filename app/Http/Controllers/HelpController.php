<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\Help;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HelpExport;
use App\Models\Question;
use Illuminate\Validation\Rule;
use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

class HelpController extends Controller
{
    public $webspice;
    protected $helps;
    public $tableName;
    public function __construct(Help $helps, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->helps = $helps;
        $this->tableName = 'tbl_help';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('help.view');
        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->helps->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->helps->orderBy('created_at', 'desc');
        }
        $query->with('question');

        if ($request->search_status != null) {

            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('help_english', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('help_bangla', 'LIKE', '%' . $searchText . '%');
            });
        }

        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Help List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new HelpExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new HelpExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $helps = $query->paginate(5);

        return view('helps.index', compact('helps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('help.create');
        $questions = Question::where(['status' => 7])->get();
        return view('helps.create',[
            'questions' => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('help.create');

        $request->validate(
            [
                'page_name' => 'required',
                'help_english' => [
                    'required',
                    Rule::unique('tbl_help')->where(function ($query) use ($request) {
                        return $query->where('help_english', $request->value);
                    }), new EnglishCharacters
                ],
                'help_bangla' => ['required', new BanglaCharacters]
            ]
        );
        try {
            $Help = new Help();
            $Help->help_english = $request->help_english;
            $Help->help_bangla = $request->help_bangla;
            $Help->question_id = $request->question_id;
            $Help->page_name = $request->page_name;
            $Help->created_at = $this->webspice->now('datetime24');
            $Help->created_by = $this->webspice->getUserId();
            $Help->status = 7;
            $Help->save();
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
        $this->webspice->permissionVerify('help.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $editInfo = $this->helps->find($id);
        $questions = Question::where(['status' => 7])->get();
        return view('helps.edit', compact('editInfo','questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        # permission verfy
        $this->webspice->permissionVerify('help.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'page_name' => 'required',
                'help_english' => [
                    'required',
                    Rule::unique('tbl_help')->ignore($id, 'id')->where(function ($query) use ($request) {
                        return $query->where('help_english', $request->value);
                    }), new EnglishCharacters
                ],
                'help_bangla' => ['required', new BanglaCharacters]
            ]
        );
        try {
            $market = $this->helps->find($id);

            $market->help_english = $request->help_english;
            $market->help_bangla = $request->help_bangla;
            $market->question_id = $request->question_id;
            $market->page_name = $request->page_name;
            $market->updated_at = $this->webspice->now('datetime24');
            $market->updated_by = $this->webspice->getUserId();
            $market->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
            return back();
        }


        return redirect('helps');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('help.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $help = $this->helps->findOrFail($id);
            if (!is_null($help)) {
                $help->status = -7;
                $help->save();
                $help->delete();
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
        $this->webspice->permissionVerify('help.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $Help = Help::withTrashed()->findOrFail($id);
            $Help->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('help.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $help = Help::withTrashed()->findOrFail($id);
            if($help){
                $help->status = 7;
                $help->save();
                $help->restore();
            }           
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('helps.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('help.restore');
        try {
            $helps = Help::onlyTrashed()->get();
            foreach ($helps as $v) {
                $v->status = 7;
                $v->save();
                $v->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('helps.index');
    }
}
