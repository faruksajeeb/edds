<?php

namespace App\Http\Livewire\Frontend;

use App\Lib\Webspice;
use App\Models\Option;
use App\Models\UserResponseDetail;
use Livewire\Component;
use DB;

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
        // dd($categoryWiseReport);
        return view('livewire.frontend.home', ['categories' => $categoryWiseReport])->extends('livewire.frontend.master');
    }
}
