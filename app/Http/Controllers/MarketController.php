<?php

namespace App\Http\Controllers;

use App\Exports\MarketExport;
use App\Imports\MarketImport;
use App\Imports\MarketListImport;
use App\Lib\Webspice;
use App\Models\Area;
use App\Models\Market;
use App\Rules\BanglaCharacters;
use App\Rules\EnglishCharacters;
use App\Traits\MasterData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class MarketController extends Controller
{
    use MasterData;
    public $webspice;
    public $tableName;
    protected $markets;

    public function __construct(Market $markets, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->markets = $markets;
        $this->tableName = 'markets';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('market.view');
        // $markets = Cache::remember('areas-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->markets->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->markets->orderBy('created_at', 'desc');
        }
        if ($request->search_area != null) {
            $query->where('area_id', $request->search_area);
        }
        if ($request->search_status != null) {

            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('value', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('value_bangla', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('latitude', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('longitude', 'LIKE', '%' . $searchText . '%')
                    ;
            });
        }
        # elequent join with question model
        $query->with('area');
        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Market List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new MarketExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new MarketExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $markets = $query->paginate(7);
        // });

        $areas = MasterData::getArea();

        return view('market.index', compact('markets', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        #permission verfy
        $this->webspice->permissionVerify('market.create');
        $areas = MasterData::getActiveArea();

        return view('market.create', [
            'areas' => $areas,
        ]);
    }
    public function import(Request $request)
    {

        #permission verfy
        $this->webspice->permissionVerify('market.import');
        if (!Cache::has('active-areas')) {
            $areas = Area::where(['status' => 1])->get();
            Cache::forever('active-areas', $areas);
        } else {
            // $areas = Cache::get('markets')->where('status',1);
            $areas = Cache::get('active-areas');
        }

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
                        $import = new MarketListImport();                    
                        // Excel::import(new MarketImport, $request->file('import_file'));
                        Excel::import( $import, $request->file('import_file'));
                        // Excel::queueImport(new MarketListImport, $request->file('import_file'));
                        if($import->getRowCount()==0){
                            return back()->with('error', "No data found. Imported file empty.");
                        }
                        Webspice::versionUpdate();
                        Webspice::forgetCache('markets');
                        Webspice::log('markets',$import->getInsertedRowCount(), 'IMPORTED');   

                        Session::flash('error', $import->getErrorRow());
                        if($import->getExistingRowCount()>0){
                            Session::flash('warning', $import->getExistingRowCount().' data already Exist!');
                        }
                        return back()->with('success', $import->getInsertedRowCount().' Data imported successfully!');
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

        return view('market.import', [
            'areas' => $areas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('market.create');

        $request->validate(
            [
                'value' => [
                    'required','min:3','max:1000', new EnglishCharacters,
                    Rule::unique('markets')->where(function ($query) use($request) {
                        return $query->where('value', $request->value)
                            ->where('area_id', $request->area_id)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    })
                ],
                'value_bangla'=> ['required', new BanglaCharacters],
                'area_id' => 'required',
                'latitude' => 'required|numeric||between:-90,90',
                'longitude' => 'required|numeric||between:-180,180',
            ],
            [
                'value.required' => 'Value field is required.',
                'area_id.required' => 'Area field is required.',
                'value.required' => 'This value has already been taken for another record (area,value,lat,long).',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'area_id' => $request->area_id,
            'market_address' => $request->market_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'sms_code' => $request->sms_code,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->markets->create($data);
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
        $this->webspice->permissionVerify('market.edit');
        
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $marketInfo = $this->markets->find($id);

        $areas = MasterData::getActiveArea();
        return view('market.edit', [
            'marketInfo' => $marketInfo,
            'areas' => $areas,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('market.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => [
                    'required','min:3','max:1000', new EnglishCharacters,
                    Rule::unique('markets')->ignore($id, 'id')->where(function ($query) use($request) {
                        return $query->where('value', $request->value)
                            ->where('area_id', $request->area_id)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    })
                ],
                'value_bangla'=> ['required', new BanglaCharacters],
                'area_id' => 'required',
                'latitude' => 'required|numeric||between:-90,90',
                'longitude' => 'required|numeric||between:-180,180',
                'sms_code' => 'unique:markets,sms_code,'.$id
            ],
            [
                'value.required' => 'Value field is required.',
                'area_id.required' => 'Area field is required.',
                'value.unique' => 'This value has already been taken for another record (area,value,lat,long).',
            ]
        );
        try {
            $market = $this->markets->find($id);
            $market->value = $request->value;
            $market->value_bangla = $request->value_bangla;
            $market->area_id = $request->area_id;
            $market->market_address = $request->market_address;
            $market->latitude = $request->latitude;
            $market->longitude = $request->longitude;
            $market->sms_code = $request->sms_code;
            $market->updated_at = $this->webspice->now('datetime24');
            $market->updated_by = $this->webspice->getUserId();
            $market->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('markets');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('market.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $market = $this->markets->findOrFail($id);
            if (!is_null($market)) {
                $market->status = -7;
                $market->save();
                $market->delete();
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
        $this->webspice->permissionVerify('market.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $market = Market::withTrashed()->findOrFail($id);
            $market->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('market.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $market = Market::withTrashed()->findOrFail($id);
            $market->status = 7;
            $market->save();
            $market->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('markets.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('market.restore');
        try {
            $markets = Market::onlyTrashed()->get();
            foreach ($markets as $market) {
                $market->status = 7;
                $market->save();
                $market->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('markets.index');
    }
}
