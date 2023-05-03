<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function surveyReport(){
        return view('report.survey_report',[
            
        ]);
    }
}
