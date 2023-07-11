<?php

namespace App\Http\Livewire\Frontend;

use App\Lib\Webspice;
use App\Models\Division;
use App\Models\Option;
use App\Models\UserResponseDetail;
use Livewire\Component;
use DB;
use \Carbon\Carbon;

class Home extends Component
{
    protected $webspice;
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];
    public function render(Webspice $webspice)
    {
        $this->webspice = $webspice;
        # Cache Area
        $cacheName = 'active-category-options';
        if (!$this->webspice->getCache($cacheName)) {
            $categories = Option::where(['option_group_name' => 'category', 'status' => 1])->get();
            $this->webspice->createCache($cacheName, $categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }

        $cacheName = 'active-divisions';
        $this->webspice->forgetCache($cacheName);
        if (!$this->webspice->getCache($cacheName)) {
            $divisions = Division::where(['status' => 1])->get();
            $this->webspice->createCache($cacheName, $divisions);
        } else {
            $divisions = $this->webspice->getCache($cacheName);
        }

        # Category Wise Report
        $categoryWiseReport = array();
        foreach ($categories as $category) :
            $categoryId = $category->id;
            $categoryWiseReport[$categoryId]['category_id'] = $categoryId;
            $categoryWiseReport[$categoryId]['category_name'] = $category->option_value;
            $categoryWiseReport[$categoryId]['category_name_bangla'] = $category->option_value2;
            $query = UserResponseDetail::leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
            $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
            $query->where('questions.category_id', $categoryId);
            $query->where('user_responses.status', 2);
            $query->whereRaw('user_responses.response_date = CURDATE()');
            if ($category->option_value == 'LBM Worker') {
                $resData = $query->count(DB::raw("DISTINCT(user_response_details.response_id)"));
            } else {
                $resData = $query->sum('user_response_details.response');
            }
            $categoryWiseReport[$categoryId]['response_data'] =   $resData;

            $responseLocations = UserResponseDetail::select('user_responses.response_location')
            ->leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id')
            ->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id')
            ->where('questions.category_id', $categoryId)
            ->whereBetween('user_responses.response_date',[Carbon::today()->subDays(7)->toDateString(),Carbon::today()->toDateString()])
            ->where('user_responses.status', 2)->get();
            $categoryWiseReport[$categoryId]['response_locations'] =   $responseLocations;
        endforeach;
        // dd($categoryWiseReport[5]['response_locations']->toArray());
        # Division Wise Report
        $divisionWiseReport = array();
        foreach ($divisions as $division) :
            $divisionId = $division->id;
            $divisionWiseReport[$divisionId]['division_name'] = $division->division_name;
           // dd($categories);
            foreach ($categories as $category) :
                $query = UserResponseDetail::leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
                $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
                // $query->leftJoin('registered_users', 'registered_users.id', '=', 'user_responses.registered_user_id');
                $query->where('questions.category_id', $category->id);
                // $query->where('registered_users.division', $division->division_name);
                $query->where('user_responses.response_division', $division->division_name);
                $query->where('user_responses.status', 2);
                $query->whereBetween('user_responses.response_date',[Carbon::today()->subDays(7)->toDateString(),Carbon::today()->toDateString()]);
                if ($category->option_value == 'LBM Worker') {
                    $resData = $query->count(DB::raw("DISTINCT(user_response_details.response_id)"));
                } else {
                    $resData = $query->sum('user_response_details.response');
                }
                // $query->groupBy('questions.category_id');
                // $query->groupBy('registered_users.division');
               // $query->get();
                $divisionWiseReport[$divisionId][$category->id] = $resData;
            endforeach;
        endforeach;
        //  dd($divisionWiseReport);

        $selectedCategory ='Poultry';
        // if($request->category){
        //     $selectedCategory = $request->category;
        // }
        $regionWiseColorMapRecords = DB::select("SELECT district, 
        SUM(CASE WHEN category='Poultry' THEN response ELSE 0 END) TOTAL_POULTRY,
        SUM(CASE WHEN category='Wild Bird' THEN response ELSE 0 END) TOTAL_WILD_BIRD,
        COUNT(DISTINCT(CASE WHEN category='LBM Worker' THEN response_id END)) TOTAL_LBM_WORKER
        FROM(
        SELECT user_response_details.*,
        user_responses.status,user_responses.registered_user_id, user_responses.response_date,
        questions.category_id,
        options.option_value AS category,
        user_responses.response_division as division, user_responses.response_district as district
        FROM user_response_details
        LEFT JOIN user_responses ON user_responses.id = user_response_details.response_id
        LEFT JOIN questions ON questions.id = user_response_details.question_id
        LEFT JOIN `options` ON options.id = questions.category_id
        -- LEFT JOIN registered_users ON registered_users.id = user_responses.registered_user_id
        ) TBL_RES
        WHERE status=2 AND response_date >= DATE(NOW() - INTERVAL 7 DAY)
        GROUP BY district");
      
        return view('livewire.frontend.home', [
            'selectedCategory' => $selectedCategory,
            'categories' => $categoryWiseReport,
            'divisions' => $divisionWiseReport,
            'webspice' => $this->webspice,
            'regionWiseColorMapRecords'=>$regionWiseColorMapRecords
        ])->extends('livewire.frontend.master');
    }
}
