<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegisteredUserExport;
use Illuminate\Support\Facades\Cache;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    public $webspice;
    public $tableName;
    protected $registered_users;


    public function __construct(RegisteredUser $registered_users, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->registered_users = $registered_users;
        $this->tableName = 'responses';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('registered_user.view');
        // $registered_users = Cache::remember('responses-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->registered_users->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->registered_users->orderBy('created_at', 'desc');
        }
        # Start Filter Section        

        if ($request->respondent_type != null) {
            $query->where('respondent_type', $request->respondent_type);
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
        if ($request->search_respodent != null) {
            $query->where('respondent_type', $request->search_respodent);
        }
        if ($request->search_gender != null) {
            $query->where('gender', $request->search_gender);
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            // $query->whereHas('registered_user', function ($query) use($searchText){
            $query->where(function ($query) use ($searchText) {
                $query->where('full_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('mobile_no', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('gender', 'LIKE', '%' . $searchText . '%');
            });
        }

        # End Filter Section

        # Export Section
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'Registered User List';
            $this->export($title, $type, $query);
        }

        $registered_users = $query->paginate(5);

        return view('registered_user.index', compact('registered_users'));
    }

    public function export(string $title, string $type, object $query)
    {
        ini_set('max_execution_time', 30 * 60); //30 min
        ini_set('memory_limit', '2048M');

        $type = ($type == 'export') ? 'xlsx' : $type;
        $fileName = str_replace(' ', '_', strtolower($title)) . '_' . date('Y_m_d_h_s_i') . '.' . $type;

        $writer = SimpleExcelWriter::streamDownload($fileName);
        $writer->addHeader([$title]);
        $writer->addHeader(['#','Full Name', 'Email', 'Mobile No.', 'Gender',  'Respondent Type','Division','District','Thana']);
        $i = 0;
        foreach ($query->lazy(1000) as $val) {
            //$writer->addRow($val->toArray()); // for all fields
            $writer->addRow([
                $i + 1,
                // Date::dateTimeToExcel($val->response_date),
                $val->full_name,
                $val->email,
                $val->mobile_no,
                $val->gender,
                $val->respondent_type,
                $val->division,
                $val->district,
                $val->thana
            ]);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer ery 1000 rows
                // break;
            }
            $i++;
        }

        return $writer->toBrowser();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        #permission verfy
        $this->webspice->permissionVerify('registered_user.create');
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            // $respondents = Cache::get('respondent-options')->where('status',1);
            $respondents = Cache::get('active-respondent-options');
        }

        return view('registered_user.create', [
            'respondents' => $respondents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('registered_user.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $registered_user = $this->registered_users->findOrFail($id);
            if (!is_null($registered_user)) {
                $registered_user->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('registered_user.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $registered_user = RegisteredUser::withTrashed()->findOrFail($id);
            $registered_user->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function verify($id)
    {

        #permission verify
        $this->webspice->permissionVerify('registered_user.verify');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $registered_user = RegisteredUser::findOrFail($id);
            $registered_user->status = 2; //verified 
            $registered_user->verified_at = $this->webspice->now('datetime24');
            $registered_user->verified_by = $this->webspice->getUserId();
            // $registered_user->save();
            $registered_user->saveQuietly(); #without dispatching any events.
            # Log
            $this->webspice->log('registered_users', $registered_user->id, "FORCE DELETED");
            # Cache Update
            $this->webspice->forgetCache('registered_users');
            // return redirect()->route('registered_users.index', ['status' => 'success'])->withSuccess(__('Data verified successfully.'));
            return redirect()->back()->withSuccess(__('Data verified successfully.'));
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('registered_users.index');
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('registered_user.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $registered_user = RegisteredUser::withTrashed()->findOrFail($id);
            $registered_user->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('registered_user.restore');
        try {
            $registered_users = RegisteredUser::onlyTrashed()->get();
            foreach ($registered_users as $registered_user) {
                $registered_user->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('registered_users.index');
    }
}
