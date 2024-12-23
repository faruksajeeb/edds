<?php

namespace App\Http\Controllers;

use App\Exports\AreaExport;
use App\Lib\Webspice;
use App\Models\Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->search_division != null) {
            $query->where('division', $request->search_division);
        }
        if ($request->search_district != null) {
            $query->where('district', $request->search_district);
        }
        if ($request->search_thana != null) {
            $query->where('thana', $request->search_thana);
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


        // $query->with('option');
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Area List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new AreaExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new AreaExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $areas = $query->paginate(7);
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
                'division' => 'required|min:2|max:1000',
                'district' => 'required|min:2|max:1000',
                'thana' => 'required|min:2|max:1000',
                'value' => [
                    'required', 'min:3', 'max:1000',
                    Rule::unique('areas')->where(function ($query) use ($request) {
                        return $query->where('value', $request->value)
                            ->where('division', $request->division)
                            ->where('district', $request->district)
                            ->where('thana', $request->thana)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    }),
                ],
                'value_bangla' => 'required|min:3|max:1000',
                'latitude' => 'required|numeric||between:-90,90',
                'longitude' => 'required|numeric||between:-180,180',
            ],
            [
                'value.unique' => 'This area name has already been taken (unique combination:division,district,thana,area name english,lat,long).',
            ]
        );
        try {
            $input = $request->all();
            $input['created_by'] = $this->webspice->getUserId();
            $this->areas->create($input);
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
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
    public function update(Request $request, Area $area)
    {
        # permission verfy
        $this->webspice->permissionVerify('area.edit');

        # decrypt value
        // $id = $this->webspice->encryptDecrypt('decrypt', $id);
        $id = $area->id;

        $request->validate(
            [
                'division' => 'required|min:2|max:1000',
                'district' => 'required|min:2|max:1000',
                'thana' => 'required|min:2|max:1000',
                'value' => [
                    'required', 'min:3', 'max:1000',
                    Rule::unique('areas')->ignore($id, 'id')->where(function ($query) use ($request) {
                        return $query->where('value', $request->value)
                            ->where('division', $request->division)
                            ->where('district', $request->district)
                            ->where('thana', $request->thana)
                            ->where('latitude', $request->latitude)
                            ->where('longitude', $request->longitude);
                    }),
                ],
                'value_bangla' => 'required|min:3|max:1000',
                'latitude' => 'required|numeric||between:-90,90',
                'longitude' => 'required|numeric||between:-180,180',
            ], [
                'value.unique' => 'This area name has already been taken for another record (unique combination:division,district,thana,area name english,lat,long).',
            ]
        );
        try {
            $input = $request->all();
            $input['updated_by'] = $this->webspice->getUserId();
            $area->update($input);
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
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
                $area->status = -7;
                $area->save();
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
            $area->status = 7;
            $area->save();
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
                $area->status = 7;
                $area->save();
                $area->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('areas.index');
    }
}
