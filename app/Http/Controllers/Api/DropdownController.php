<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Area;
use App\Models\District;
use App\Models\Market;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function fetchDistrict(Request $request)
    {
       
        $data['districts'] = District::where("division_id", $request->division_id)
                                ->get(["id","district_name", "district_name_bangla"]);
  
        return response()->json($data);
    }
    public function fetchArea(Request $request)
    {
       
        $data['areas'] = Area::where("thana", $request->upazilla)
                                ->get(["value", "id"]);
  
        return response()->json($data);
    }
    public function fetchMarket($id)
    {
       
        $data['markets'] = Market::where("area_id", $id)
                                ->get(["value", "id"]);
  
        return response()->json($data);
    }
    public function fetchItems($itemName)
    {
       
        $item = Answer::where('answare',$itemName)->first();
       
        // $data['items'] = Answer::where("id",$item->id)->get(["answare","id"]);
        // $data['items'] = Answer::where("id",$item->id)->select("answare","id")->get();

        $data['items'] = Answer::leftJoin('tbl_q', 'tbl_q.relation_id',  '=', 'tbl_a.id')
        ->leftJoin('tbl_a as answer', 'answer.question_id',  '=', 'tbl_q.id')         
        ->select("answer.answare","answer.id")
        ->where('tbl_q.related_to','=','answare')
        ->where("tbl_q.relation_id",$item->id)
        ->get();
       
        // dd($data['items']->toArray());
        return response()->json($data);
    }
}
