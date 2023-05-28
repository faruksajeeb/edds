<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\UserResponse;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserResponseExport;
use App\Models\Area;
use App\Models\Market;
use Illuminate\Support\Facades\Cache;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;
class UserResponseController extends Controller
{
    public $webspice;
    public $tableName;
    protected $user_responses;


    public function __construct(UserResponse $user_responses, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->user_responses = $user_responses;
        $this->tableName = 'responses';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('user_response.view');
        // $user_responses = Cache::remember('responses-page-' . request('page', 1), 60*60, function () use($request) {

        $fileTag = '';

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->user_responses->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->user_responses->orderBy('created_at', 'desc');
        }
        $query->with('registered_user', 'area', 'market');

        # Start Filter Section        
        $query->whereHas('registered_user', function ($query) use ($request) {
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
        });
        if ($request->search_area != null) {
            $query->where('area_id', $request->search_area);
        }
        if ($request->search_market != null) {
            $query->where('market_id', $request->search_market);
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->whereHas('registered_user', function ($query) use ($searchText) {
                $query->where('full_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('mobile_no', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('response_date', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('gender', 'LIKE', '%' . $searchText . '%');
            });
        }
        if (($request->date_from != null) && ($request->date_to != null)) {
            $query->whereBetween('response_date', [$request->date_from, $request->date_to]);
        } elseif ($request->date_from != null) {
            $query->where('response_date', '>=', $request->date_from);
        } elseif ($request->date_to != null) {
            $query->where('response_date', '<=', $request->date_to);
        }
        # End Filter Section

        # Export Section
        if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = $fileTag . 'User Response List';
            $this->export($title, $type, $query);
        }

        $user_responses = $query->paginate(5);

        # Cache Area
        $cacheName = 'active-areas';
        if (!$this->webspice->getCache($cacheName)) {
            $areas = Area::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $areas);
        } else {
            $areas = $this->webspice->getCache($cacheName);
        }

        # Cache Market
        $cacheName = 'active-markets';
        if (!$this->webspice->getCache($cacheName)) {
            $markets = Market::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $markets);
        } else {
            $markets = $this->webspice->getCache($cacheName);
        }
        return view('user_response.index', compact('user_responses', 'areas', 'markets'));
    }

    public function export(string $title, string $type, object $query)
    {
        ini_set('max_execution_time', 30 * 60); //30 min
        ini_set('memory_limit', '2048M');

        $type = ($type == 'export') ? 'xlsx' : $type;
        $fileName = str_replace(' ', '_', strtolower($title)) . '_' . date('Y_m_d_h_s_i') . '.' . $type;

        $writer = SimpleExcelWriter::streamDownload($fileName);
        $writer->addHeader([$title]);
        $writer->addHeader(['#', 'Response Date', 'Full Name', 'Email', 'Mobile No.', 'Respondent Type']);
        $i = 0;
        foreach ($query->lazy(1000) as $val) {
            //$writer->addRow($val->toArray()); // for all fields
            $writer->addRow([
                $i + 1,
                // Date::dateTimeToExcel($val->response_date),
                "$val->response_date",
                isset($val->registered_user->full_name) ? $val->registered_user->full_name : '',
                isset($val->registered_user->email) ? $val->registered_user->email : '',
                isset($val->registered_user->mobile_no) ? $val->registered_user->mobile_no : '',
                isset($val->registered_user->respondent_type) ? $val->registered_user->respondent_type : ''
                // $this->webspice->date_excel_to_real($val->created_at),
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
        $this->webspice->permissionVerify('user_response.create');
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            // $respondents = Cache::get('respondent-options')->where('status',1);
            $respondents = Cache::get('active-respondent-options');
        }

        return view('user_response.create', [
            'respondents' => $respondents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('user_response.create');

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:responses',
                'respondent_id' => 'required',
                'input_method' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'respondent_id.required' => 'Respondent field is required.',
                'input_method.required' => 'Input method field is required.',
            ]
        );

        $data = array(
            'value' => $request->value,
            'value_bangla' => $request->value_bangla,
            'respondent_id' => $request->respondent_id,
            'input_method' => $request->input_method,
            'created_at' => $this->webspice->now('datetime24'),
            'created_by' => $this->webspice->getUserId(),
        );

        try {
            $this->user_responses->create($data);
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
        $id = $this->webspice->encryptDecrypt('decrypt', $id);
        $user_response = UserResponse::find($id);
        view('user_response.index', compact('user_response'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('user_response.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $user_responseInfo = $this->user_responses->find($id);
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            // $respondents = Cache::get('respondent-options')->where('status',1);
            $respondents = Cache::get('active-respondent-options');
        }
        return view('user_response.edit', [
            'responseInfo' => $user_responseInfo,
            'respondents' => $respondents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('user_response.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'value' => 'required|min:3|max:1000|unique:responses,value,' . $id,
                'respondent_id' => 'required',
                'input_method' => 'required',
            ],
            [
                'value.required' => 'Value field is required.',
                'respondent_id.required' => 'Respondent field is required.',
                'input_method.required' => 'Input method field is required.',
                'value.unique' => 'This value has already been taken for another record.'
            ]
        );
        try {
            $user_response = $this->user_responses->find($id);
            $user_response->value = $request->value;
            $user_response->value_bangla = $request->value_bangla;
            $user_response->respondent_id = $request->respondent_id;
            $user_response->input_method = $request->input_method;
            $user_response->updated_at = $this->webspice->now('datetime24');
            $user_response->updated_by = $this->webspice->getUserId();
            $user_response->save();
        } catch (Exception $e) {
            $this->webspice->updateOrFail('error', $e->getMessage());
        }

        return redirect('responses');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('user_response.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $user_response = $this->user_responses->findOrFail($id);
            if (!is_null($user_response)) {
                $user_response->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('user_response.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $user_response = UserResponse::withTrashed()->findOrFail($id);
            $user_response->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function verify($id)
    {

        #permission verify
        $this->webspice->permissionVerify('user_response.verify');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $user_response = UserResponse::findOrFail($id);
            $user_response->status = 2; //verified 
            $user_response->verified_at = $this->webspice->now('datetime24');
            $user_response->verified_by = $this->webspice->getUserId();
            // $user_response->save();
            $user_response->saveQuietly(); #without dispatching any events.
            # Log
            $this->webspice->log('user_responses', $user_response->id, "FORCE DELETED");
            # Cache Update
            $this->webspice->forgetCache('user_responses');
            // return redirect()->route('user_responses.index', ['status' => 'success'])->withSuccess(__('Data verified successfully.'));
            return redirect()->back()->withSuccess(__('Data verified successfully.'));
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('user_responses.index');
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('user_response.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $user_response = UserResponse::withTrashed()->findOrFail($id);
            $user_response->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('user_response.restore');
        try {
            $user_responses = UserResponse::onlyTrashed()->get();
            foreach ($user_responses as $user_response) {
                $user_response->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('user_responses.index');
    }
}
