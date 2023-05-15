<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\Market;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MarketExport;
use Illuminate\Support\Facades\Cache;

class MarketController extends Controller
{
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
        $query->with('area');
        # Export
        if (in_array($type=$request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Market List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new MarketExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new MarketExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $markets = $query->paginate(5);
        // });

        return view('market.index', compact('markets'));
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
        $this->webspice->permissionVerify('market.create');
        if (!Cache::has('active-areas')) {
            $areas = Area::where(['status' => 1])->get();
            Cache::forever('active-areas', $areas);
        } else {
            // $areas = Cache::get('markets')->where('status',1);
            $areas = Cache::get('active-areas');
        }

        return view('market.create', [
            'areas' => $areas
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
                'value' => 'required|min:3|max:1000|unique:markets',
                'area_id' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'area_id.required' => 'Area field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'area_id' => $request->area_id,
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
        if (!Cache::has('active-areas')) {
            $areas = Area::where(['status' => 1])->get();
            Cache::forever('active-areas', $areas);
        } else {
            // $areas = Cache::get('markets')->where('status',1);
            $areas = Cache::get('active-areas');
        }
        return view('market.edit', [
            'marketInfo' => $marketInfo,
            'areas' => $areas
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
                'value' => 'required|min:3|max:1000|unique:markets,value,' . $id,
                'area_id' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'area_id.required' => 'Area field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $market = $this->markets->find($id);
            $market->value = $request->value;
            $market->value_bangla = $request->value_bangla;
            $market->area_id = $request->area_id;
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
                $market->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
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
                $market->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('markets.index');
    }
}