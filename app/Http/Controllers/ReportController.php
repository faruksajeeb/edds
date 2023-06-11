<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Area;
use App\Models\Market;
use App\Models\Option;
use App\Models\Question;
use App\Models\SubQuestion;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveyReportExport;
use App\Models\UserResponseDetail;
use Exception;
use PDF;
use DB;

class ReportController extends Controller
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;

        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
    public function surveyReport(Request $request)
    {
        $data = [];
        if ($request->submit_btn) {
            try {
                if ($request->report_type == 'question_wise') {
                    // $this->questionWiseSurveyReport($request);
                    $exportType = $request->submit_btn;
                    $query = UserResponseDetail::select(
                        'user_responses.id',
                        'user_responses.response_date',
                        'registered_users.full_name',
                        'registered_users.mobile_no',
                        'questions.value as question',
                        'sub_questions.value as sub_question',
                        'user_response_details.response',
                        'user_response_details.question_id',
                        'user_response_details.sub_question_id',
                        'questions.category_id',
                        'options.option_value as category_name',
                        'areas.value as area_name',
                        'markets.value as market_name',
                    );
                    $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
                    $query->leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
                    $query->leftJoin('options', 'options.id', '=', 'questions.category_id');
                    $query->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_response_details.sub_question_id');
                    $query->leftJoin('registered_users', 'registered_users.id', '=', 'user_responses.registered_user_id');
                    $query->leftJoin('areas', 'areas.id', '=', 'user_responses.area_id');
                    $query->leftJoin('markets', 'markets.id', '=', 'user_responses.market_id');

                    if ($request->division != '') {
                        $query->where('user_responses.response_division', $request->division);
                    }
                    if ($request->district != '') {
                        $query->where('user_responses.response_district', $request->district);
                    }
                    // if ($request->thana != '') {
                    //     $query->where('registered_users.thana', $request->thana);
                    // }
                    // if ($request->area_id != '') {
                    //     $query->where('user_responses.area_id', $request->area_id);
                    // }
                    // if ($request->market_id != '') {
                    //     $query->where('user_responses.market_id', $request->market_id);
                    // }

                    if ($request->address_address != '') {
                        $query->where('user_responses.formatted_address', $request->address_address);
                    }
                    
                    if ($request->category_id != '') {
                        // $query->leftJoin('options','options.id','=','questions.category_id');
                        $query->where('questions.category_id', $request->category_id);
                    }
                    if ($request->question_id != '') {
                        $query->where('user_response_details.question_id', $request->question_id);
                    }
                    if ($request->sub_question_id != '') {
                        $query->where('user_response_details.sub_question_id', $request->sub_question_id);
                    }

                    $query->whereBetween('user_responses.response_date', [$request->date_from, $request->date_to]);
                    $query->orderBy('user_responses.id');
                    $query->groupBy('user_responses.id');
                    $query->groupBy('user_response_details.question_id');
                    $query->where('user_responses.status', 2);
                    $records = $query->get();
                    // dd($records);
                    if (count($records) <= 0) {
                        // No Data Found!                
                        return redirect('survey-report')->with('warning', 'SORRY! No Records Found.');
                    }
                    $customResult = array();
                    foreach ($records as $val) :
                        $categoryId = $val->category_id ? $val->category_id : 'not_assigned';
                        $questionId = $val->question_id ? $val->question_id : 'not_assigned';
                        $customResult[$categoryId]['category_name'] = $val->category_name;
                        $customResult[$categoryId]['category_records'][$questionId]['question'] = $val->question;
                        $customResult[$categoryId]['category_records'][$questionId]['question_id'] = $val->question_id;
                        $customResult[$categoryId]['category_records'][$questionId]['records'][] = $val;
                    endforeach;
                    $records = $customResult;

                    $data = array(
                        'report_type' => $request->report_type,
                        'report_format' => $exportType,
                        'division' => $request->division ? $request->division : 'All',
                        'district' => $request->district ? $request->district : 'All',
                        'thana' => $request->thana ? $request->thana : 'All',
                        'date_from' => $request->date_from,
                        'date_to' => $request->date_to,
                        'records' => $records,
                    );
                    if ($exportType == 'pdf') {
                        //   dd($data);
                        # Generate PDF                
                        $pdf = PDF::loadView('report.question_wise_survey_report_export', $data);
                        $pdf->set_paper('letter', 'landscape');
                        // $pdf->set_paper('A4', 'portrait');
                        return $pdf->download('surver_report_' . time() . '.pdf');
                    } else if ($exportType == 'export') {
                        # Generate Excel

                        return Excel::download(new SurveyReportExport($data), 'surver_report_' . time() . '.xlsx');
                    } else {
                        # view
                        //return view('report.question_wise_survey_report_export', $data);
                    }
                } elseif ($request->report_type == 'sub_question_wise') {
                    //$this->subQuestionWiseSurveyReport($request);

                    $exportType = $request->submit_btn;
                    $query = UserResponseDetail::select(
                        'user_responses.response_date',
                        'registered_users.full_name',
                        'registered_users.mobile_no',
                        'questions.value as question',
                        'sub_questions.value as sub_question',
                        'user_response_details.response',
                        'user_response_details.question_id',
                        'user_response_details.sub_question_id',
                        'questions.category_id',
                        'options.option_value as category_name',
                        'areas.value as area_name',
                        'markets.value as market_name',
                    );
                    $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
                    $query->leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
                    $query->leftJoin('options', 'options.id', '=', 'questions.category_id');
                    $query->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_response_details.sub_question_id');
                    $query->leftJoin('registered_users', 'registered_users.id', '=', 'user_responses.registered_user_id');
                    $query->leftJoin('areas', 'areas.id', '=', 'user_responses.area_id');
                    $query->leftJoin('markets', 'markets.id', '=', 'user_responses.market_id');

                    if ($request->division != '') {
                        $query->where('registered_users.division', $request->division);
                    }
                    if ($request->district != '') {
                        $query->where('registered_users.district', $request->district);
                    }
                    if ($request->thana != '') {
                        $query->where('registered_users.thana', $request->thana);
                    }
                    if ($request->area_id != '') {
                        $query->where('user_responses.area_id', $request->area_id);
                    }
                    if ($request->market_id != '') {
                        $query->where('user_responses.market_id', $request->market_id);
                    }
                    if ($request->category_id != '') {
                        // $query->leftJoin('options','options.id','=','questions.category_id');
                        $query->where('questions.category_id', $request->category_id);
                    }
                    if ($request->question_id != '') {
                        $query->where('user_response_details.question_id', $request->question_id);
                    }
                    if ($request->sub_question_id != '') {
                        $query->where('user_response_details.sub_question_id', $request->sub_question_id);
                    }

                    $query->whereBetween('user_responses.response_date', [$request->date_from, $request->date_to]);

                    // dd($records);
                    $query->where('user_responses.status', 2);
                    $records = $query->get();

                    if (count($records) <= 0) {
                        // No Data Found!                
                        return redirect('survey-report')->with('warning', 'SORRY! No Records Found.');
                    }

                    $customResult = array();
                    foreach ($records as $val) :
                        $categoryId = $val->category_id ? $val->category_id : 'not_assigned';
                        $questionId = $val->question_id ? $val->question_id : 'not_assigned';
                        $subQuestionId = $val->sub_question_id ? $val->sub_question_id : 'not_assigned';
                        $customResult[$categoryId]['category_name'] = $val->category_name;
                        $customResult[$categoryId]['category_records'][$questionId]['question'] = $val->question;
                        $customResult[$categoryId]['category_records'][$questionId]['sub_records'][$subQuestionId]['sub_question'] = $val->sub_question;
                        $customResult[$categoryId]['category_records'][$questionId]['sub_records'][$subQuestionId]['records'][] = $val;
                    endforeach;
                    $records = $customResult;

                    $data = array(
                        'report_type' => $request->report_type,
                        'report_format' => $exportType,
                        'division' => $request->division ? $request->division : 'All',
                        'district' => $request->district ? $request->district : 'All',
                        'thana' => $request->thana ? $request->thana : 'All',
                        'date_from' => $request->date_from,
                        'date_to' => $request->date_to,
                        'records' => $records,
                    );
                    if ($exportType == 'pdf') {
                        //   dd($data);
                        # Generate PDF                
                        $pdf = PDF::loadView('report.survey_report_export', $data);
                        // $pdf->set_paper('letter', 'landscape');
                        $pdf->set_paper('A4', 'portrait');
                        return $pdf->download('surver_report_' . time() . '.pdf');
                    } else if ($exportType == 'export') {
                        # Generate Excel

                        return Excel::download(new SurveyReportExport($data), 'surver_report_' . time() . '.xlsx');
                    } else {
                        # view
                        // dd($data);
                        //return view('report.survey_report_export', $data);
                    }
                }
            } catch (Exception $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        }
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

        # Cache Category
        $cacheName = 'active-categories';
        // $this->webspice->forgetCache($cacheName);
        if (!$this->webspice->getCache($cacheName)) {
            $categories = Option::where(['option_group_name' => 'category', 'status' => 1])->get();
            $this->webspice->createCache($cacheName, $categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }

        # Cache Questions
        $cacheName = 'active-questions';
        if (!$this->webspice->getCache($cacheName)) {
            $questions = Question::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $questions);
        } else {
            $questions = $this->webspice->getCache($cacheName);
        }

        # Cache Sub Questions
        $cacheName = 'active-sub_questions';
        if (!$this->webspice->getCache($cacheName)) {
            $sub_questions = SubQuestion::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $sub_questions);
        } else {
            $sub_questions = $this->webspice->getCache($cacheName);
        }

        $data['areas'] = $areas;
        $data['markets'] = $markets;
        $data['categories'] = $categories;
        $data['questions'] = $questions;
        $data['sub_questions'] = $sub_questions;
        return view('report.survey_report', $data);
    }

    protected function questionWiseSurveyReport($request)
    {
    }
    public function subQuestionWiseSurveyReport($request)
    {

        $exportType = $request->submit_btn;
        $query = UserResponseDetail::select(
            'user_responses.response_date',
            'registered_users.full_name',
            'registered_users.mobile_no',
            'questions.value as question',
            'sub_questions.value as sub_question',
            'user_response_details.response',
            'user_response_details.question_id',
            'user_response_details.sub_question_id',
            'questions.category_id',
            'options.option_value as category_name',
            'areas.value as area_name',
            'markets.value as market_name',
        );
        $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
        $query->leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
        $query->leftJoin('options', 'options.id', '=', 'questions.category_id');
        $query->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_response_details.sub_question_id');
        $query->leftJoin('registered_users', 'registered_users.id', '=', 'user_responses.registered_user_id');
        $query->leftJoin('areas', 'areas.id', '=', 'user_responses.area_id');
        $query->leftJoin('markets', 'markets.id', '=', 'user_responses.market_id');

        if ($request->division != '') {
            $query->where('registered_users.division', $request->division);
        }
        if ($request->district != '') {
            $query->where('registered_users.district', $request->district);
        }
        if ($request->thana != '') {
            $query->where('registered_users.thana', $request->thana);
        }
        if ($request->area_id != '') {
            $query->where('user_responses.area_id', $request->area_id);
        }
        if ($request->market_id != '') {
            $query->where('user_responses.market_id', $request->market_id);
        }
        if ($request->category_id != '') {
            // $query->leftJoin('options','options.id','=','questions.category_id');
            $query->where('questions.category_id', $request->category_id);
        }
        if ($request->question_id != '') {
            $query->where('user_response_details.question_id', $request->question_id);
        }
        if ($request->sub_question_id != '') {
            $query->where('user_response_details.sub_question_id', $request->sub_question_id);
        }
        $query->where('user_responses.status', 2);
        $query->whereBetween('user_responses.response_date', [$request->date_from, $request->date_to]);
        $records = $query->get();
        // dd($records);
        if (count($records) <= 0) {
            // No Data Found!                
            return redirect('survey-report')->with('warning', 'SORRY! No Records Found.');
        }
        $customResult = array();
        foreach ($records as $val) :
            $categoryId = $val->category_id ? $val->category_id : 'not_assigned';
            $questionId = $val->question_id ? $val->question_id : 'not_assigned';
            $subQuestionId = $val->sub_question_id ? $val->sub_question_id : 'not_assigned';
            $customResult[$categoryId]['category_name'] = $val->category_name;
            $customResult[$categoryId]['category_records'][$questionId]['question'] = $val->question;
            $customResult[$categoryId]['category_records'][$questionId]['sub_records'][$subQuestionId]['sub_question'] = $val->sub_question;
            $customResult[$categoryId]['category_records'][$questionId]['sub_records'][$subQuestionId]['records'][] = $val;
        endforeach;
        $records = $customResult;

        $data = array(
            'report_format' => $exportType,
            'division' => $request->division ? $request->division : 'All',
            'district' => $request->district ? $request->district : 'All',
            'thana' => $request->thana ? $request->thana : 'All',
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'records' => $records,
        );
        if ($exportType == 'pdf') {
            //   dd($data);
            # Generate PDF                
            $pdf = PDF::loadView('report.survey_report_export', $data);
            $pdf->set_paper('letter', 'landscape');
            return $pdf->download('surver_report_' . time() . '.pdf');
        } else if ($exportType == 'export') {
            # Generate Excel

            return Excel::download(new SurveyReportExport($data), 'surver_report_' . time() . '.xlsx');
        } else {
            # view

        }
    }

    public function districtWiseWarningsReport(Request $request)
    {
        $selectedCategory ='Poultry';
        if($request->category){
            $selectedCategory = $request->category;
        }
        $regionWiseColorMapRecords = DB::select("
        SELECT district, SUM(CASE WHEN category='Poultry' THEN response ELSE 0 END) TOTAL_POULTRY,
        SUM(CASE WHEN category='Wild Bird' THEN response ELSE 0 END) TOTAL_WILD_BIRD,
        COUNT(DISTINCT(CASE WHEN category='LBM Worker' THEN response_id END)) TOTAL_LBM_WORKER
        FROM(
        SELECT user_response_details.*,
        user_responses.status,user_responses.registered_user_id, user_responses.response_date,
        questions.category_id,
        options.option_value AS category,
        registered_users.division, registered_users.district
        FROM user_response_details
        LEFT JOIN user_responses ON user_responses.id = user_response_details.response_id
        LEFT JOIN questions ON questions.id = user_response_details.question_id
        LEFT JOIN `options` ON options.id = questions.category_id
        LEFT JOIN registered_users ON registered_users.id = user_responses.registered_user_id
        ) TBL_RES
        WHERE status=2
        GROUP BY district");

        // $data = [65, 59, 80, 81, 56, 55, 40,80];
        // dd($data);
         # Cache Category
         $cacheName = 'categories';
         // $this->webspice->forgetCache($cacheName);
         if (!$this->webspice->getCache($cacheName)) {
             $categories = Option::where(['option_group_name' => 'category'])->get();
             $this->webspice->createCache($cacheName, $categories);
         } else {
             $categories = $this->webspice->getCache($cacheName);
         }

        $webspice = $this->webspice;
        return view('report.district_wise_warnings_report', compact('regionWiseColorMapRecords','categories','selectedCategory', 'webspice'));
    }
    public function divisionWiseCountingReport()
    {
        $googleMapResult = DB::select("
            SELECT division, SUM(CASE WHEN category='Poultry' THEN response ELSE 0 END) TOTAL_POULTRY,
            SUM(CASE WHEN category='Wild Bird' THEN response ELSE 0 END) TOTAL_WILD_BIRD,
            COUNT(DISTINCT(CASE WHEN category='LBM Worker' THEN response_id END)) TOTAL_LBM_WORKER
            FROM(
            SELECT user_response_details.*,
            user_responses.status,user_responses.registered_user_id, user_responses.response_date,
            questions.category_id,
            options.option_value AS category,
            registered_users.division
            FROM user_response_details
            LEFT JOIN user_responses ON user_responses.id = user_response_details.response_id
            LEFT JOIN questions ON questions.id = user_response_details.question_id
            LEFT JOIN `options` ON options.id = questions.category_id
            LEFT JOIN registered_users ON registered_users.id = user_responses.registered_user_id
            ) TBL_RES
            WHERE status = 2 
            GROUP BY division");
            $webspice = $this->webspice;
        return view('report.division_wise_counting_report',compact('googleMapResult','webspice'));
    }
}
