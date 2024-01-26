<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\Tip;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TipExport;

use Illuminate\Validation\Rule;
use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

class TipController extends Controller
{
    public $webspice;
    protected $tips;
    public $tableName;
    public function __construct(Tip $tips, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->tips = $tips;
        $this->tableName = 'tbl_tips';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('tips.view');
        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->tips->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->tips->orderBy('created_at', 'desc');
        }

        if ($request->search_status != null) {

            $query->where('status', $request->search_status);
        }

        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('tips_english', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('tips_bangla', 'LIKE', '%' . $searchText . '%');
            });
        }

        # Export
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Tip List';
            // $this->export($request->submit_btn,$query,$title);
            $fileName = str_replace(' ', '_', strtolower($title));
            if ($type == 'csv') {
                return Excel::download(new TipExport($query->get(), $title), $fileName . '_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            return Excel::download(new TipExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $tips = $query->paginate(7);

        return view('tips.index', compact('tips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('tips.create');

        return view('tips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('tips.create');

        $request->validate(
            [
                'tips_english' => [
                    'required',
                    Rule::unique('tbl_tips')->where(function ($query) use ($request) {
                        return $query->where('tips_english', $request->value);
                    }), new EnglishCharacters
                ],
                'tips_bangla' => ['required', new BanglaCharacters]
            ]
        );
        try {
            $tip = new tip();
            $tip->tips_english = $request->tips_english;
            $tip->tips_bangla = $request->tips_bangla;
            $tip->created_at = $this->webspice->now('datetime24');
            $tip->created_by = $this->webspice->getUserId();
            $tip->status = 7;
            $tip->save();
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
        $this->webspice->permissionVerify('tips.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $editInfo = $this->tips->find($id);

        return view('tips.edit', compact('editInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        # permission verfy
        $this->webspice->permissionVerify('tips.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'tips_english' => [
                    'required',
                    Rule::unique('tbl_tips')->ignore($id, 'id')->where(function ($query) use ($request) {
                        return $query->where('tips_english', $request->value);
                    }), new EnglishCharacters
                ],
                'tips_bangla' => ['required', new BanglaCharacters]
            ]
        );
        try {
            $market = $this->tips->find($id);

            $market->tips_english = $request->tips_english;
            $market->tips_bangla = $request->tips_bangla;
            $market->updated_at = $this->webspice->now('datetime24');
            $market->updated_by = $this->webspice->getUserId();
            $market->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
            return back();
        }


        return redirect('tips');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('tips.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $tip = $this->tips->findOrFail($id);
            if (!is_null($tip)) {
                $tip->status = -7;
                $tip->save();
                $tip->delete();
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
        $this->webspice->permissionVerify('tips.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $tip = tip::withTrashed()->findOrFail($id);
            $tip->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('tips.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $tips = tip::withTrashed()->findOrFail($id);
            $tips->status = 7;
            $tips->save();
            $tips->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('tips.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('tips.restore');
        try {
            $tips = tip::onlyTrashed()->get();
            foreach ($tips as $v) {
                $v->status = 7;
                $v->save();
                $v->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('tips.index');
    }
}
