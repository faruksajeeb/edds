<?php

namespace App\Traits;

use App\Models\Area;
use App\Models\Market;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Cache;

trait MasterData
{
    # Poperties
    # Methods 
    public static function getActiveCategory(): object
    {
        if (!Cache::has('active-category-options')) {
            $categories = Option::where(['option_group_name' => 'category', 'status' => 1])->get();
            Cache::forever('active-category-options', $categories);
        } else {
            $categories = Cache::get('active-category-options');
        }
        return $categories;
    }

    public static function getCategory(): object
    {
        if (!Cache::has('category-options')) {
            $categories = Option::where(['option_group_name' => 'category'])->get();
            Cache::forever('category-options', $categories);
        } else {
            $categories = Cache::get('category-options');
        }
        return $categories;
    }

    public static function getActiveRespondent(): object
    {
        if (!Cache::has('active-respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent', 'status' => 1])->get();
            Cache::forever('active-respondent-options', $respondents);
        } else {
            $respondents = Cache::get('active-respondent-options');
        }

        return $respondents;
    }

    public static function getRespondent(): object
    {
        if (!Cache::has('respondent-options')) {
            $respondents = Option::where(['option_group_name' => 'respondent'])->get();
            Cache::forever('respondent-options', $respondents);
        } else {
            $respondents = Cache::get('respondent-options');
        }

        return $respondents;
    }
    public static function getArea(): object
    {
        if (!Cache::has('areas')) {
            $records = Area::all();
            Cache::forever('areas', $records);
        } else {
            $records = Cache::get('areas');
        }

        return $records;
    }

    public static function getActiveArea(): object
    {
        if (!Cache::has('active-areas')) {
            $records = Area::where('status', 1)->get();
            Cache::forever('active-areas', $records);
        } else {
            $records = Cache::get('active-areas');
        }

        return $records;
    }

    public static function getMarket(): object
    {
        if (!Cache::has('markets')) {
            $records = Market::all();
            Cache::forever('markets', $records);
        } else {
            $records = Cache::get('markets');
        }

        return $records;
    }

    public static function getActiveMarket(): object
    {
        if (!Cache::has('active-markets')) {
            $records = Market::where('status', 1)->get();
            Cache::forever('active-markets', $records);
        } else {
            $records = Cache::get('active-markets');
        }

        return $records;
    }

    public static function getQuenstion(): object
    {
        if (!Cache::has('questions')) {
            $records = Question::all();
            Cache::forever('questions', $records);
        } else {
            $records = Cache::get('questions');
        }

        return $records;
    }
    public static function getActiveQuenstion(): object
    {
        if (!Cache::has('active-questions')) {
            $records = Question::where('status', 1)->get();
            Cache::forever('active-questions', $records);
        } else {
            $records = Cache::get('active-questions');
        }

        return $records;
    }
}
