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
    public function surveyReport(Request $request){

        if($exportType = $request->submit_btn){
            $records = [];
            $data = array(
                'report_format' => $exportType,
                'date_from' => $request->date_from,
                'date_from' => $request->date_from,
                'records' => $records,
            );
            if($exportType=='pdf'){
                # Generate PDF                
                $pdf = PDF::loadView('report.survey_report_export', $data);
                $pdf->set_paper('letter', 'landscape');
                return $pdf->download('salary_statement_' . time() . '.pdf');

            }else if($exportType=='export'){
                 # Generate Excel
               
                 return Excel::download(new SurveyReportExport($data), 'salary_statement_' . time() . '.xlsx');

            }else{
                # view

            }
          
        }
        # Cache Area
        $cacheName = 'active-areas';
        if (!$this->webspice->getCache($cacheName)) {
            $areas = Area::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$areas);
        } else {
            $areas = $this->webspice->getCache($cacheName);
        }

        # Cache Market
        $cacheName = 'active-markets';
        if (!$this->webspice->getCache($cacheName)) {
            $markets = Market::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$markets);
        } else {
            $markets = $this->webspice->getCache($cacheName);
        }

        # Cache Category
        $cacheName = 'active-categories';
        if (!$this->webspice->getCache($cacheName)) {
            $categories = Option::where(['option_group_name'=>'category','status' => 1])->get();
            $this->webspice->createCache($cacheName,$categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }

        # Cache Questions
        $cacheName = 'active-questions';
        if (!$this->webspice->getCache($cacheName)) {
            $questions = Question::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$questions);
        } else {
            $questions = $this->webspice->getCache($cacheName);
        }

        # Cache Sub Questions
        $cacheName = 'active-sub_questions';
        if (!$this->webspice->getCache($cacheName)) {
            $sub_questions = SubQuestion::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$sub_questions);
        } else {
            $sub_questions = $this->webspice->getCache($cacheName);
        }
        
        return view('report.survey_report',compact('areas','markets','categories','questions','sub_questions'));
    }
}
