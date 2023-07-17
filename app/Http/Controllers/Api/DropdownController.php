<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Market;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
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
}
