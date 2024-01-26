<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Division;
use App\Models\Option;
use App\Models\UserResponseDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    protected $webspice;

    function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $chart_type = 'bar';
        $date_from = Carbon::today()->subDays(7)->toDateString();
        $date_to = Carbon::today()->toDateString();
        // dd($request->submit_btn);
        if ($request->submit_btn) {
            $chart_type = $request->chart_type;
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }

        # Cache Area
        // $cacheName = 'active-categories';
        // if (!$this->webspice->getCache($cacheName)) {
        $categories = Option::where(['option_group_name' => 'category', 'status' => 7])->get();
        //     $this->webspice->createCache($cacheName, $categories);
        // } else {
        //     $categories = $this->webspice->getCache($cacheName);
        // }

        $cacheName = 'active-divisions';
        if (!$this->webspice->getCache($cacheName)) {
            $divisions = Division::where(['status' => 7])->get();
            $this->webspice->createCache($cacheName, $divisions);
        } else {
            $divisions = $this->webspice->getCache($cacheName);
        }
        $labels = [];
        foreach ($divisions as $key => $division) {
            $labels[] = $division->division_name;
        }

        // $labels = ['jan', 'feb', 'april', 'may', 'jun', 'july'];
        // dd($labels);
        // dd($divisions);
        $data = [];
        foreach ($categories as $category) {
            $categoryWiseDivisionResponse = [];
            foreach ($divisions as $key => $division) {
                DB::enableQueryLog();
                $query = UserResponseDetail::leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id')
                    ->leftJoin('tbl_q as questions', 'questions.id', '=', 'user_response_details.question_id')
                    ->leftJoin('areas', 'areas.id', '=', 'user_responses.area_id')
                    ->where('questions.category_id', $category->id)
                    ->whereRaw('
                    CASE
                    WHEN (user_responses.market_id != 0 OR user_responses.market_id!=-100) THEN areas.division
                    ELSE user_responses.response_division
                END = ?', [$division->division_name]);
                $query->where('user_responses.status', 2);
                $query->where('user_response_details.sub_question_id', 0);
                // $query->whereBetween('user_responses.response_date',[Carbon::today()->subDays(7)->toDateString(),Carbon::today()->toDateString()]);                
                $query->whereBetween('user_responses.response_date', [$date_from, $date_to]);
                if ($category->option_value == 'LBM Worker') {
                    $categoryWiseDivisionResponse[] = $query->count(DB::raw("DISTINCT(user_response_details.response_id)"));
                } else {
                    $categoryWiseDivisionResponse[] = $query->sum('user_response_details.response');
                }
                // $query = DB::getQueryLog();
                // $lastQuery = end($query)['query'];
                // $bindings = end($query)['bindings'];
                // $sqlWithBindings = vsprintf(str_replace('?', "'%s'", $lastQuery), $bindings);
                // dd($sqlWithBindings);
            }


            $data[$category->id] = $categoryWiseDivisionResponse;
        }


        // dd($data);



        // $data = [65, 59, 80, 81, 56, 55, 40,80];
        // dd($data);
        $webspice = $this->webspice;
        return view('dashboard', compact('categories', 'labels', 'chart_type', 'date_from', 'date_to', 'data', 'webspice'));
    }
}
