<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\Area;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AreaExport;
use Illuminate\Support\Facades\Cache;

class AreaController extends Controller
{
    public $webspice;
    public $tableName;
    protected $areas;


    public function __construct(Area $areas, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->areas = $areas;
        $this->tableName = 'areas';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('area.view');
        // $areas = Cache::remember('areas-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->areas->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->areas->orderBy('created_at', 'desc');
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
        // $query->with('option');
        if (in_array($type=$request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Area List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new AreaExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new AreaExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $areas = $query->paginate(5);
        // });     
        return view('area.index', compact('areas'));
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
        $this->webspice->permissionVerify('area.create');
        return view('area.create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('area.create');

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:areas',
                'latitude' => 'required',
                'longitude' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->areas->create($data);
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
        $this->webspice->permissionVerify('area.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $areaInfo = $this->areas->find($id);
      
        return view('area.edit', [
            'areaInfo' => $areaInfo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('area.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:areas,value,' . $id,
                'latitude' => 'required',
                'longitude' => 'required'
            ],
            [
                'value.required' => 'Value field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $area = $this->areas->find($id);
            $area->value = $request->value;
            $area->value_bangla = $request->value_bangla;
            $area->latitude = $request->latitude;
            $area->longitude = $request->longitude;
            $area->updated_at = $this->webspice->now('datetime24');
            $area->updated_by = $this->webspice->getUserId();
            $area->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('areas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('area.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $area = $this->areas->findOrFail($id);
            if (!is_null($area)) {
                $area->delete();
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
        $this->webspice->permissionVerify('area.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $area = Area::withTrashed()->findOrFail($id);
            $area->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('area.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $area = Area::withTrashed()->findOrFail($id);
            $area->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('areas.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('area.restore');
        try {
            $areas = Area::onlyTrashed()->get();
            foreach ($areas as $area) {
                $area->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('areas.index');
    }
}
