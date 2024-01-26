<?php

namespace App\Http\Controllers;
use App\Lib\Webspice;
use App\Models\Market;
use App\Models\Option;
use App\Models\RespondentType;
use App\Models\SmsResponse;
use Illuminate\Http\Request;
use DB;
use Spatie\SimpleExcel\SimpleExcelWriter;

class SmsResponseController extends Controller
{
    public $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request){
        #permission verfy
        $this->webspice->permissionVerify('sms_response.view');
        $query = SmsResponse::orderBy('created_at','DESC');
        $query->with('market','respondent','category');       

        if($request->search_respondent_type){
            $query->whereHas('respondent', function ($query) use ($request) {
                $query->where('id', $request->search_respondent_type);
            });
        }
        if($request->search_category){
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('id', $request->search_category);
            });
        }
        if($request->search_market){
            $query->whereHas('market', function ($query) use ($request) {
                $query->where('id', $request->search_market);
            });
        }

        if (($request->date_from != null) && ($request->date_to != null)) {
            $dateFrom = "$request->date_from 00:00:01";
            $dateTo = "$request->date_to 23:59:59";
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

         # Export Section
         if (in_array($type = $request->submit_btn, array('export', 'csv', 'pdf'))) {
            $title = 'SMS Response List';
            $this->export($title, $type, $query);
        }

        $perPage = request()->input('perPage', 10);
        $sms_responses = $query->paginate($perPage);
        
        $respondent_types = RespondentType::all();
        $categories = Option::where('option_group_name','category')->get();
        $markets = Market::all();

        return view('sms_response.index', compact('sms_responses','respondent_types','categories','markets'));
    }

    public function export(string $title, string $type, object $query)
    {
        ini_set('max_execution_time', 30 * 60); //30 min
        ini_set('memory_limit', '2048M');

        $type = ($type == 'export') ? 'xlsx' : $type;
        $fileName = str_replace(' ', '_', strtolower($title)) . '_' . date('Y_m_d_h_s_i') . '.' . $type;

        $writer = SimpleExcelWriter::streamDownload($fileName);
        $writer->addHeader([$title]);
        $writer->addHeader(['#',
            'Contact No',
            'Respondent Type',
            'Address',
            'Item',
            'Quantity',
            'Created At'
        ]);
        $i = 0;
        foreach ($query->lazy(1000) as $val) {
            //$writer->addRow($val->toArray()); // for all fields
            $writer->addRow([
                $i + 1,
                // Date::dateTimeToExcel($val->response_date),
                $val->contact_no,
                optional($val->respondent)->label,
                optional($val->market)->value,
                optional($val->category)->option_value,
                $val->quantity,
                // optional($val->registered_user)->full_name,
                // ucfirst(optional($val->registered_user)->gender),
                // optional($val->registered_user)->email,
                // optional($val->registered_user)->mobile_no,
                // optional($val->registered_user)->respondent_type,
                // Webspice::excelStatus($val->status),
                // $val->created_at,
                // $val->updated_at,
                $this->webspice->date_excel_to_real($val->created_at),
            ]);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer ery 1000 rows
                // break;
            }
            $i++;
        }

        return $writer->toBrowser();
    }
}