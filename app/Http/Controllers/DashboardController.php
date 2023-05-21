<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use App\Models\Division;
use App\Models\Option;
use App\Models\UserResponseDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        if($request->submit_btn){
            $chart_type = $request->chart_type;
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }

        # Cache Area
        $cacheName = 'active-categories';
        if (!$this->webspice->getCache($cacheName)) {
            $categories = Option::where(['option_group_name' => 'category', 'status' => 1])->get();
            $this->webspice->createCache($cacheName, $categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }

        $cacheName = 'active-divisions';
        if (!$this->webspice->getCache($cacheName)) {
            $divisions = Division::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $divisions);
        } else {
            $divisions = $this->webspice->getCache($cacheName);
        }
        $labels = [];
        foreach($divisions as $key=>$division){
            $labels[] = $division->division_name;
        }

        // $labels = ['jan', 'feb', 'april', 'may', 'jun', 'july'];
        // dd($labels);
        $data=[];
        foreach($categories as $category){
            $categoryWiseDivisionResponse = [];
            foreach($divisions as $key=>$division){
                $query = UserResponseDetail::leftJoin('user_responses','user_responses.id','=','user_response_details.response_id')
                ->leftJoin('questions','questions.id','=','user_response_details.question_id')
                ->leftJoin('registered_users','registered_users.id','=','user_responses.registered_user_id')
                ->where('questions.category_id',$category->id)
                ->where('registered_users.division',$division->division_name);
                $query->whereBetween('user_responses.response_date',[$date_from,$date_to]);
                if ($category->option_value == 'LBM Worker') {
                    $categoryWiseDivisionResponse[] = $query->count('user_response_details.response');
                } else {
                    $categoryWiseDivisionResponse[] = $query->sum('user_response_details.response');
                }

            }
            
            $data[$category->id] = $categoryWiseDivisionResponse;
        }
      
        // $data = [65, 59, 80, 81, 56, 55, 40,80];
        // dd($data);
        return view('dashboard', compact('categories', 'labels', 'chart_type','date_from','date_to','data'));
    }

}
