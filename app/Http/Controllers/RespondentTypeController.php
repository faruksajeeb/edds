<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\Help;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RespondentTypeExport;
use App\Models\Question;
use App\Models\RespondentType;
use Illuminate\Validation\Rule;
use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

class RespondentTypeController extends Controller
{
    public $webspice;
    protected $respondent_types;
    public $tableName;
    public function __construct(RespondentType $respondent_types, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->respondent_types = $respondent_types;
        $this->tableName = 'tbl_respopndent';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('respondent_type.view');
        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->respondent_types->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->respondent_types->orderBy('created_at', 'desc');
        }
        if ($request->search_status != null) {

            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('option', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('label', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('label_bangla', 'LIKE', '%' . $searchText . '%')
                    ;
            });
        }

        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Respondent Type List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new RespondentTypeExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new RespondentTypeExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $respondent_types = $query->paginate(5);

        return view('respondent_type.index', compact('respondent_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('respondent_type.create');
        $questions = Question::where(['status' => 7])->get();
        return view('respondent_type.create',[
           
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('respondent_type.create');

        $request->validate(
            [
                'option' => ['required', new EnglishCharacters,'unique:tbl_respopndent'],
                'label' => ['required', new EnglishCharacters,'unique:tbl_respopndent'],
                'label_bangla' => ['required', new BanglaCharacters,'unique:tbl_respopndent'],
                'sms_code' => ['unique:tbl_respopndent']
            ]
        );
        try {
            $respondent_type = new RespondentType();
            $respondent_type->option = $request->option;
            $respondent_type->label = $request->label;
            $respondent_type->label_bangla = $request->label_bangla;
            $respondent_type->sms_code = $request->sms_code;
            $respondent_type->created_at = $this->webspice->now('datetime24');
            $respondent_type->created_by = $this->webspice->getUserId();
            $respondent_type->status = 7;
            $respondent_type->save();
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
        $this->webspice->permissionVerify('respondent_type.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $editInfo = $this->respondent_types->find($id);     
        return view('respondent_type.edit', compact('editInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        # permission verfy
        $this->webspice->permissionVerify('respondent_type.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'option' => ['required', new EnglishCharacters,'unique:tbl_respopndent,option,'.$id],
                'label' => ['required', new EnglishCharacters,'unique:tbl_respopndent,label,'.$id],
                'label_bangla' => ['required', new BanglaCharacters,'unique:tbl_respopndent,label_bangla,'.$id],
                'sms_code' => ['unique:tbl_respopndent,sms_code,'.$id],
            ]
        );
        try {
            $respondent_type = $this->respondent_types->find($id);
            $respondent_type->option = $request->option;
            $respondent_type->label = $request->label;
            $respondent_type->label_bangla = $request->label_bangla;
            $respondent_type->sms_code = $request->sms_code;
            $respondent_type->updated_at = $this->webspice->now('datetime24');
            $respondent_type->updated_by = $this->webspice->getUserId();
            $respondent_type->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
            return back();
        }


        return redirect('respondent_types');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('respondent_type.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $respondent_type = $this->respondent_types->findOrFail($id);
            if (!is_null($respondent_type)) {
                $respondent_type->status = -7;
                $respondent_type->save();
                $respondent_type->delete();
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
        $this->webspice->permissionVerify('respondent_type.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $respondent_type = RespondentType::withTrashed()->findOrFail($id);
            $respondent_type->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('respondent_type.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $respondent_type = RespondentType::withTrashed()->findOrFail($id);
            if($respondent_type){
                $respondent_type->status = 7;
                $respondent_type->save();
                $respondent_type->restore();
            }           
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('respondent_types.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('respondent_type.restore');
        try {
            $respondent_types = RespondentType::onlyTrashed()->get();
            foreach ($respondent_types as $v) {
                $v->status = 7;
                $v->save();
                $v->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('respondent_types.index');
    }
}
