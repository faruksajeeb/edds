<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;


class UserController extends Controller
{
    
    public function user(Request $request)
    {
       
        $response['data'] = new UserResource($request->user());
        return new SuccessResource($response);
    }

}
