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
            $categories = Option::where(['option_group_name'=>'category','status' => 1])->get();
            $this->webspice->createCache($cacheName, $categories);
        } else {
            $categories = $this->webspice->getCache($cacheName);
        }
        # Category Wise Report
        $query = Option::where(['option_group_name'=>'category','status' => 1])->select(
            'options.option_value',
             DB::raw("(SELECT COUNT(user_response_details.response) FROM user_response_details LEFT JOIN user_responses ON
             user_responses.id=user_response_details.response_id
             LEFT JOIN registered_users ON  registered_users.id=user_responses.registered_user_id
             WHERE registered_users.respondent_type = options.option_value GROUP BY registered_users.respondent_type) as totalResponse")
        );
        dd($query->get());
        return view('livewire.frontend.home', ['categories'=>$categories])->extends('livewire.frontend.master');
    }
}
