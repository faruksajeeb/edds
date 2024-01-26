<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\Healthcare;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HealthcareExport;
use App\Traits\MasterData;
use Illuminate\Validation\Rule;
use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

use App\Imports\HealthcareListImport;
use Illuminate\Support\Facades\Session;

class HealthcareController extends Controller
{
    use MasterData;
    public $webspice;
    protected $healthcares;
    public $tableName;
    public function __construct(Healthcare $healthcares, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->healthcares = $healthcares;
        $this->tableName = 'tbl_healthcare';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('healthcare.view');

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->healthcares->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->healthcares->orderBy('created_at', 'desc');
        }
        $query->with('center_type');
        if ($request->search_center_type != null) {
            $query->where('type', $request->search_center_type);
        }
        if ($request->search_status != null) {

            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('hospital_name_english', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('hospital_name_bangla', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('latitude', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('longitude', 'LIKE', '%' . $searchText . '%');
            });
        }

        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Healthcare List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new HealthcareExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new HealthcareExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $healthcares = $query->paginate(7);
        $centerTypes = $this->getActiveHealthcareType();
        return view('healthcare.index', compact('healthcares', 'centerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('healthcare.create');
        $centerTypes = $this->getActiveHealthcareType();
        return view('healthcare.create', compact('centerTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('healthcare.create');

        $request->validate(
            [
                'center_type' => 'required',
                'hospital_name_english' => [
                    'required',
                    Rule::unique('tbl_healthcare')->where(function ($query) use ($request) {
                        return $query->where('hospital_name_english', $request->value)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    }), new EnglishCharacters
                ],
                'hospital_name_bangla' => ['required', new BanglaCharacters],
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180'
            ]
        );
        try {
            $healthcare = new Healthcare();
            $healthcare->type = $request->center_type;
            $healthcare->hospital_name_english = $request->hospital_name_english;
            $healthcare->hospital_name_bangla = $request->hospital_name_bangla;
            $healthcare->latitude = $request->latitude;
            $healthcare->longitude = $request->longitude;
            $healthcare->address = $request->address;
            $healthcare->created_at = $this->webspice->now('datetime24');
            $healthcare->created_by = $this->webspice->getUserId();
            $healthcare->status = 7;
            $healthcare->save();
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
        $this->webspice->permissionVerify('healthcare.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $editInfo = $this->healthcares->find($id);
        $centerTypes = $this->getActiveHealthcareType();
        return view('healthcare.edit', compact('editInfo', 'centerTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        # permission verfy
        $this->webspice->permissionVerify('healthcare.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'center_type' => 'required',
                'hospital_name_english' => [
                    'required',
                    Rule::unique('tbl_healthcare')->ignore($id, 'id')->where(function ($query) use ($request) {
                        return $query->where('hospital_name_english', $request->value)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    }), new EnglishCharacters
                ],
                'hospital_name_bangla' => ['required', new BanglaCharacters],
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]
        );
        try {
            $market = $this->healthcares->find($id);

            $market->type = $request->center_type;
            $market->hospital_name_english = $request->hospital_name_english;
            $market->hospital_name_bangla = $request->hospital_name_bangla;
            $market->latitude = $request->latitude;
            $market->longitude = $request->longitude;
            $market->updated_at = $this->webspice->now('datetime24');
            $market->updated_by = $this->webspice->getUserId();
            $market->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
            return back();
        }


        return redirect('healthcares');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('healthcare.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $healthcare = $this->healthcares->findOrFail($id);
            if (!is_null($healthcare)) {
                $healthcare->status = -7;
                $healthcare->save();
                $healthcare->delete();
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
        $this->webspice->permissionVerify('healthcare.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $healthcare = Healthcare::withTrashed()->findOrFail($id);
            $healthcare->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('healthcare.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $healthcare = Healthcare::withTrashed()->findOrFail($id);
            if($healthcare){
                $healthcare->status = 7;
                $healthcare->save();
                $healthcare->restore();
            }            
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('healthcares.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('healthcare.restore');
        try {
            $healthcares = Healthcare::onlyTrashed()->get();
            foreach ($healthcares as $v) {
                $v->status = 7;
                $v->save();
                $v->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('healthcares.index');
    }


    public function import(Request $request)
    {

        if ($request->all()) {
            $request->validate(
                [
                    'import_file' => 'required | mimes:xls,xlsx,csv'
                ]
            );
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            try {
                if ($request->hasFile('import_file')) {
                    # Import Uploaded Data
                    try {
                        $import = new HealthcareListImport();
                        // Excel::import(new MarketImport, $request->file('import_file'));
                        Excel::import($import, $request->file('import_file'));
                        // Excel::queueImport(new MarketListImport, $request->file('import_file'));
                        if ($import->getRowCount() == 0) {
                            return back()->with('error', "No data found. Imported file empty.");
                        }
                        Webspice::versionUpdate();
                        Webspice::forgetCache('markets');
                        Webspice::log('markets', $import->getInsertedRowCount(), 'IMPORTED');

                        Session::flash('error', $import->getErrorRow());
                        if ($import->getExistingRowCount() > 0) {
                            Session::flash('warning', $import->getExistingRowCount() . ' data already Exist!');
                        }
                        return back()->with('success', $import->getInsertedRowCount() . ' Data imported successfully!');
                    } catch (Exception $e) {
                        return back()->with('error', $e->getMessage());
                    }
                } else {
                    return back()->with('error', 'Upload file not found!');
                }
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        return view('healthcare.import', [
           
        ]);
    }
}
