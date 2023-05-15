<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Area;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function surveyReport(){

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
            $categories = Category::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }
        
        # Cache Sub Category
        $cacheName = 'active-sub_categories';
        //$this->webspice->forgetCache($cacheName);
        if (!$this->webspice->getCache($cacheName)) {
            $sub_categories = SubCategory::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName,$sub_categories);
        } else {
            $sub_categories = $this->webspice->getCache($cacheName);
           
            
        }
        
        return view('report.survey_report',compact('areas','markets','categories','sub_categories'));
    }
}
