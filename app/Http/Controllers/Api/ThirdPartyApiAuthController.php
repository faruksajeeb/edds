<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Api\ThirdPartyApiLoginTokenService;
use App\Services\Api\RegisterService;

use App\Http\Requests\Api\ThirdPartyApiLoginRequest;
use App\Http\Requests\Api\UserVerifyRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;

class ThirdPartyApiAuthController extends Controller
{
    // use HasApiTokens;
    use RegisterService, ThirdPartyApiLoginTokenService;


    public function userLogin(ThirdPartyApiLoginRequest $request)
    {
        $credentials = $request->validated();
        return $this->loginToken($credentials);
    }

    public function userVerify(UserVerifyRequest $request)
    {
        $credentials = $request->validated();
       return $this->verifyOtp($credentials);

    }

    public function user(Request $request)
    {
        // dd($request->user());
        $response['data'] = new UserResource($request->user());
        return new SuccessResource($response);
    }

    public function userLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response['message'] = 'Successfully Logout!';
        return new SuccessResource($response);
    }

}
