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

        # Category Wise Report
        $categoryWiseReport = array();
        foreach ($categories as $category) :
            $categoryId = $category->id;
            $categoryWiseReport[$categoryId]['category_name'] = $category->option_value;
            $query = UserResponseDetail::leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
            $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
            $query->where('questions.category_id', $categoryId);
            $query->whereRaw('user_responses.response_date = CURDATE()');
            if ($category->option_value == 'LBM Worker') {
                $resData = $query->count('user_response_details.response');
            } else {
                $resData = $query->sum('user_response_details.response');
            }
            $categoryWiseReport[$categoryId]['response_data'] =   $resData;
        endforeach;

        # Division Wise Report
        $divisionWiseReport = array();
        foreach ($divisions as $division) :
            $divisionId = $division->id;
            $divisionWiseReport[$divisionId]['division_name'] = $division->division_name;
            foreach ($categories as $category) :
                $query = UserResponseDetail::leftJoin('questions', 'questions.id', '=', 'user_response_details.question_id');
                $query->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id');
                $query->leftJoin('registered_users', 'registered_users.id', '=', 'user_responses.registered_user_id');
                $query->where('questions.category_id', $categoryId);
                $query->where('registered_users.division', $division->division_name);
                $query->whereBetween('user_responses.response_date',[Carbon::today()->subDays(7)->toDateString(),Carbon::today()->toDateString()]);
                if ($category->option_value == 'LBM Worker') {
                    $resData = $query->count('user_response_details.response');
                } else {
                    $resData = $query->sum('user_response_details.response');
                }
                $divisionWiseReport[$divisionId][$category->id] = $resData;
            endforeach;
        endforeach;
        // dd($categoryWiseReport);
        return view('livewire.frontend.home', [
            'categories' => $categoryWiseReport,
            'divisions' => $divisionWiseReport
        ])->extends('livewire.frontend.master');
    }
}
