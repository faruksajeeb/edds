<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Api\OtpGenerationService;
use App\Services\Api\OtpVerificationService;
use App\Services\Api\LoginTokenService;
use App\Services\Api\RegisterService;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UserVerifyRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    // use HasApiTokens;
    use OtpGenerationService,OtpVerificationService, RegisterService, LoginTokenService;

    public function userRegister(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = $this->createUser($data);
        $response['message'] = 'Successfully Registered! Now, Login!';
        $response['data']['user'] = $user;
        return new SuccessResource($response);
    }

    public function userLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        return $this->generateOtp($credentials);

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
