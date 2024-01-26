<?php

namespace App\Http\Controllers;

use App\Exports\SurveyReportExport;
use App\Lib\Webspice;
use App\Models\Answer;
use App\Models\Area;
use App\Models\Division;
use App\Models\Market;
use App\Models\Option;
use App\Models\Question;
use App\Models\SubQuestion;
use App\Models\UserResponseDetail;
use DB;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
        $distance = 0;
        if ($request->submit_btn) {
            $request->validate(
                [
                    'date_from' => 'required',
                    'date_to' => 'required',
                ]
            );

            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            
            if($request->distance){
                $distance = $request->distance;
            }
            $ConditionalWhere = "";
            $status = "";
            if($request->status){
                $status = " AND user_responses.status=".$request->status;
            }

            // $divisionName = "";
            // $districtName = "";
            // if($request->division_name){                
            //     $division = explode("|",$request->division_name);
            //     $divisionName = $division[1];
            //     session(['divisionName' => $divisionName ? $divisionName : 'All']);
            //     $ConditionalWhere .= " AND (areas.division = '$divisionName' OR user_responses.response_division='$divisionName' )";
            // }

            // if($request->district_name){                
            //     $district = explode("|",$request->district_name);
            //     $districtName = $district[1];
            //     session(['districtName' => $districtName ? $districtName : 'All']);
            //     $ConditionalWhere .= " AND (areas.district = '$districtName' OR user_responses.response_district='$districtName' )";
            // }           

            if ($request->area_id) {               
                $area = Area::find($request->area_id);
                // dd($area);
                // $ConditionalWhere = " AND ((areas.latitude >= '$area->latitude' AND areas.longitude <= '$area->longitude') OR (user_responses.response_location_latitude >= '$area->latitude' AND user_responses.response_location_longitude<= '$area->longitude') )";
                // $ConditionalWhere = " AND (CASE WHEN user_responses.area_id!=0 THEN (areas.latitude >= '$area->latitude' AND areas.longitude <= '$area->longitude') ELSE (user_responses.response_location_latitude >= '$area->latitude' AND user_responses.response_location_longitude<= '$area->longitude') END)";                
                
                /* $ConditionalWhere = " AND (CASE 
                WHEN user_responses.area_id!=0 
                THEN user_responses.area_id = $request->area_id 
                ELSE (user_responses.response_location_latitude >= '$area->latitude' AND user_responses.response_location_longitude<= '$area->longitude') END)";
                
                */
               
                
                $ConditionalWhere = " AND (CASE 
                WHEN user_responses.area_id!=0 
                THEN user_responses.area_id = $request->area_id 
                ELSE (6371 * acos(cos(radians($area->latitude)) * cos(radians(user_responses.response_location_latitude)) * cos(radians(user_responses.response_location_longitude) - radians($area->longitude)) + sin(radians($area->latitude)) * sin(radians(user_responses.response_location_latitude))) <= $distance) 
                END)";
            }

            if ($request->market_id) {
                $market = Market::find($request->market_id);
                // dd($market);
                // $ConditionalWhere = " AND ((markets.latitude >= '$market->latitude' AND markets.longitude <= '$market->longitude') OR (user_responses.response_location_latitude >= '$market->latitude' AND user_responses.response_location_longitude<= '$market->longitude') )";
                // $ConditionalWhere = " AND (CASE WHEN (user_responses.market_id!=0 OR user_responses.market_id!=-100) THEN user_responses.market_id=$request->market_id ELSE (user_responses.response_location_latitude >= '$market->latitude' AND user_responses.response_location_longitude<= '$market->longitude') END)";
                $ConditionalWhere = " AND (CASE 
                WHEN (user_responses.market_id!=0 OR user_responses.market_id!=-100) 
                THEN user_responses.market_id=$request->market_id 
                ELSE (6371 * acos(cos(radians($market->latitude)) * cos(radians(user_responses.response_location_latitude)) * cos(radians(user_responses.response_location_longitude) - radians($market->longitude)) + sin(radians($market->latitude)) * sin(radians(user_responses.response_location_latitude))) <= $distance) 
                END)";
            }

           

            $sql = "SELECT user_responses.*,
            areas.value AS area_name,
            areas.value_bangla AS area_name_bangla,
            markets.value AS market_name,
            markets.value_bangla AS market_name_bangla
            FROM user_responses
            LEFT JOIN areas ON areas.id = user_responses.area_id
            LEFT JOIN markets ON markets.id = user_responses.market_id
            WHERE user_responses.response_date BETWEEN  '$dateFrom' AND '$dateTo' $status
            $ConditionalWhere
            ORDER BY user_responses.response_date ASC 
            ";
            
            session(['area_id'=>$request->area_id]);
            session(['market_id'=>$request->market_id]);
            session(['distance'=>$request->distance]);
            session(['date_from'=>$request->date_from]);
            session(['date_to'=>$request->date_to]);
            session(['status'=>$request->status]);
            session(['heading'=>$request->heading]);
            session(['item'=>$request->item]);
            // dd($sql);
            $resArrOne = DB::select($sql);
            if (count($resArrOne) <= 0) {
                // No Data Found!
                return redirect('survey-report')->with('warning', 'SORRY! No Records Found.');
            }

            $report_html = array();
            $recordCount = 1;
            

            foreach ($resArrOne as $val) {
                # get question and answare'
                $result = "SELECT user_response_details.*,
                tbl_q.question, tbl_q.question_bangla, tbl_q.related_to, tbl_q.relation_id, 
                tbl_a_2.answare AS res_answer, /*heading*/
                tbl_a_2.answare_bangla AS res_answer_bangla,
                tbl_q_2.related_to AS is_heading,
                tbl_a.answare, tbl_a.answare_bangla,
                tbl_q.report_heading, tbl_q.report_heading_bangla,
                GROUP_CONCAT(response) AS responses,
                GROUP_CONCAT(tbl_a.answare) AS responses_english,
                GROUP_CONCAT(tbl_a.answare_bangla) AS responses_bangla
                FROM user_response_details
                LEFT JOIN tbl_q ON user_response_details.question_id = tbl_q.id
                LEFT JOIN tbl_a ON tbl_a.id=user_response_details.sub_question_id
                LEFT JOIN tbl_a AS tbl_a_2 ON (tbl_a_2.id = tbl_q.relation_id AND tbl_q.related_to='answare')
                LEFT JOIN tbl_q AS tbl_q_2 ON tbl_q_2.id = tbl_a_2.question_id
                WHERE user_response_details.response_id = ".$val->id." 
                AND tbl_q.relation_id IS NOT NULL
                AND user_response_details.response!=''
                GROUP BY question_id
                ORDER BY tbl_q.sl_order
                ";
                // dd($result);
                $answer = DB::select($result);

                // $result_2 = "SELECT user_response_details.*,
                // tbl_q.question, tbl_q.question_bangla, tbl_q.relation_id, tbl_a_2.answare AS res_answer, tbl_a_2.answare_bangla AS res_answer_bangla,
                // tbl_a.answare, tbl_a.answare_bangla,
                // tbl_q.report_heading, tbl_q.report_heading_bangla,
                // GROUP_CONCAT(response) AS responses,
                // GROUP_CONCAT(tbl_a.answare) AS responses_english,
                // GROUP_CONCAT(tbl_a.answare_bangla) AS responses_bangla
                // FROM user_response_details
                // LEFT JOIN tbl_q ON user_response_details.question_id = tbl_q.id
                // LEFT JOIN tbl_a ON tbl_a.id=user_response_details.sub_question_id
                // LEFT JOIN tbl_a AS tbl_a_2 ON (tbl_a_2.id = tbl_q.relation_id AND tbl_q.related_to='answare')
                // WHERE user_response_details.response_id = ".$val->id."
                // AND (user_response_details.response=''
                // OR user_response_details.response IS NULL)
                // AND user_response_details.sub_question_id = 0
                // GROUP BY question_id
                // ORDER BY tbl_q.sl_order
                // ";
                // $answer_2 = DB::select($result_2);

                # generate answare
                $user_response = array();
                $user_answer = "";
                $res_key = "";
                $other_flag = false;
                // dd($answer);
                foreach ($answer as $ans) {
                    if ($ans->is_heading == 'level1') {
                        $res_key = ucwords($ans->res_answer);
                        
                       

                        if (strtolower($res_key) == 'your physical illness') {
                            $user_response[$res_key][] = array("q" => ucwords($ans->responses_english), "a" => '');
                        }

                        continue;
                    }

                    $response_text = $ans->responses;

                    if ($response_text == 'না') {
                        $response_text = 'No';
                    } else if ($response_text == 'হা') {
                        $response_text = 'Yes';
                    }

                    $response_text = $response_text;

                    if($request->item){
                        if(strtolower($request->item) !=strtolower($ans->res_answer) ){
                            continue;
                        }
                    }

                    if (strtolower($ans->res_answer) == 'other' && $other_flag) {
                        $user_response[$res_key][] = array("q" => ucwords($other_flag), "a" => ucwords($response_text));
                        $other_flag = false;
                    } elseif (strtolower($ans->res_answer) == 'other') {
                        $other_flag = $response_text;
                    } elseif (strtolower($ans->res_answer) == NULL) {
                        $user_response[$res_key][] = array("q" => ucwords($ans->report_heading), "a" => ucwords($response_text));
                    } else {
                        $user_response[$res_key][] = array("q" => ucwords($ans->res_answer), "a" => ucwords($response_text));
                    }
                }
               
                $user_result_set = array();
                foreach ($user_response as $k => $v) {
                    if($request->heading){
                        if(strtolower($request->heading) !=strtolower($k) ){
                            continue;
                        }
                    }
                    $user_result_set[] = array('heading' => $k, 'answer' => $v);
                }
                // dd($user_result_set);
                $location = "";
                if ($val->formatted_address) {
                    $location = $val->formatted_address;
                } else {
                    $location = $val->area_name . ', ' . $val->market_name;
                }

                // $images = array();
                // foreach ($answer_2 as $ans1) {
                //     if ((!$ans1->responses || $ans1->responses == NULL) && $ans->sub_question_id == 0) {
                //         $remoteImageURL = 'http://103.247.238.105/edds_app/tmp_img/' . $ans1->response_id . '_' . $ans1->question_id . '.jpg';
                //         $images[] = $remoteImageURL;
                //     }
                // }
                $report_html[] = array(
                    'sl' => $recordCount, 
                    'response_date' => $val->response_date, 
                    'created_at' => $val->created_at, 
                    'location' => $location, 
                    'responses' => $user_result_set, 
                    // 'images' => $images
                );

                $recordCount++;
            } // first iteration end

            // dd($report_html);
            $exportType = $request->submit_btn;
          
            $data = array(
                'report_format' => $exportType,
                // 'divisionName' => $divisionName ? $divisionName : 'All',
                // 'district' => $request->district ? $request->district : 'All',
                // 'thana' => $request->thana ? $request->thana : 'All',
                'area_id' => $request->area_id,
                'market_id' => $request->market_id,
                'distance' => $distance,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'records' => $report_html,
            );


            if ($exportType == 'pdf') {
                ini_set('pcre.backtrack_limit', 100000000);
                
                // $pdf = PDF::init(['orientation' => 'L']);
                #For big HTML

                // $pdf = PDF::LoadView('report.survey_report_export', $data);
                $pdf = PDF::chunkLoadView('<html-separator/>','report.survey_report_export', $data);


                // $pdf->set_paper('A4', 'portrait');
                $fileName = 'surver_report_' . time() . '.pdf';
                // return $pdf->stream($fileName);
                return $pdf->download($fileName);
            } else if ($exportType == 'export') {
                # Generate Excel
                return Excel::download(new SurveyReportExport($data), 'surver_report_' . time() . '.xlsx');
            } else {
                # view
                return view('report.survey_report_export', $data);
            }
        }


        # Cache Area

        $areas = Area::all();
        $markets = Market::all();
        $headings = Answer::where('question_id',1)->get();
        $answers = Answer::where('question_id','!=',1)->get();

        $data['areas'] = $areas;
        $data['markets'] = $markets;
        $data['headings'] = $headings;
        $data['answers'] = $answers;
        $data['distance'] = $distance;
 

        return view('report.survey_report', $data);
    }
    public function surveyReportOld(Request $request)
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
                        'user_responses.formatted_address',
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


                    $query->when($request->area_id == 0, function ($query) use ($request) {
                        $query->when($request->search_division != '', function ($q) use ($request) {
                            $q->where('user_responses.response_division', $request->search_division);
                        });
                        $query->when($request->search_district != '', function ($q) use ($request) {
                            $q->where('user_responses.response_district', $request->search_district);
                        });
                        $query->when($request->search_district != '', function ($q) use ($request) {
                            $q->where('user_responses.response_district', $request->search_district);
                        });
                        $query->when($request->address_address != '', function ($q) use ($request) {
                            $q->where('user_responses.formatted_address', $request->address_address);
                        });
                    });

                    if ($request->division != '') {
                        $query->where('areas.division', $request->division);
                    }
                    if ($request->district != '') {
                        $query->where('areas.district', $request->district);
                    }
                    if ($request->thana != '') {
                        $query->where('areas.thana', $request->thana);
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
                    $query->orderBy('user_responses.id');
                    $query->groupBy('user_responses.id');
                    $query->groupBy('user_response_details.question_id');
                    $query->where('user_responses.status', 2);
                    $query->where('user_response_details.sub_question_id', 0);
                    $records = $query->get();

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
                        $fileName = 'surver_report_' . time() . '.pdf';
                        return $pdf->download($fileName);
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
                        'user_responses.formatted_address',
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
                        $query->whereRaw('
                        CASE
                            WHEN user_responses.area_id = 0 THEN user_responses.response_division
                            ELSE areas.division
                        END = ?', [$request->division]);
                    }
                    if ($request->district != '') {
                        // $query->where('areas.district', $request->district);
                        $query->whereRaw('
                        CASE
                            WHEN user_responses.area_id = 0 THEN user_responses.response_district
                            ELSE areas.district
                        END = ?', [$request->district]);
                    }
                    if ($request->thana != '') {
                        $query->where('areas.thana', $request->thana);
                    }
                    if ($request->address_address != '') {
                        $query->where('user_responses.formatted_address', $request->address_address);
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
                    // $sql = $query->toSql();
                    // dd($sql);
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
            $areas = Area::where(['status' => 7])->get();
            $this->webspice->createCache($cacheName, $areas);
        } else {
            $areas = $this->webspice->getCache($cacheName);
        }

        # Cache Market
        $cacheName = 'active-markets';
        if (!$this->webspice->getCache($cacheName)) {
            $markets = Market::where(['status' => 7])->get();
            $this->webspice->createCache($cacheName, $markets);
        } else {
            $markets = $this->webspice->getCache($cacheName);
        }

        # Cache Category
        $cacheName = 'active-categories';
        // $this->webspice->forgetCache($cacheName);
        if (!$this->webspice->getCache($cacheName)) {
            $categories = Option::where(['option_group_name' => 'category', 'status' => 7])->get();
            $this->webspice->createCache($cacheName, $categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }

        # Cache Questions
        $cacheName = 'active-questions';
        if (!$this->webspice->getCache($cacheName)) {
            $questions = Question::where(['status' => 7])->get();
            $this->webspice->createCache($cacheName, $questions);
        } else {
            $questions = $this->webspice->getCache($cacheName);
        }

        # Cache Sub Questions
        $cacheName = 'active-sub_questions';
        if (!$this->webspice->getCache($cacheName)) {
            $sub_questions = SubQuestion::where(['status' => 7])->get();
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
            'user_responses.formatted_address',
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
        if ($request->address_address != '') {
            $query->where('user_responses.formatted_address', $request->address_address);
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
        $selectedCategory = 'Poultry';
        if ($request->category) {
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
        return view('report.district_wise_warnings_report', compact('regionWiseColorMapRecords', 'categories', 'selectedCategory', 'webspice'));
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
        return view('report.division_wise_counting_report', compact('googleMapResult', 'webspice'));
    }
}
