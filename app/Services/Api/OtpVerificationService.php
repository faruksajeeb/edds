<?php
namespace App\Services\Api;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\RegisteredUser;
use App\Services\Api\LoginTokenService;

trait OtpVerificationService
{
    use LoginTokenService;

    public function verifyOtp(array $credentials)
    {
        $user = RegisteredUser::where([
            'mobile_no'=> $credentials['mobile_no'],
            'otp'=> $credentials['otp'],
            ])->first();
        if ($user) {
            # Generate Token
            $token = $this->loginToken($user);
            # Remove OTP
            $user->otp = NULL;
            $user->otp_generated_at = NULL;
            $user->token = $token;
            $user->save();

            #send token to user
            $response = [
                'message' => 'Valid OTP',
                'data' => [                    
                    'token'=> $token
                ]
            ];

            return new SuccessResource($response);
        }

        $errors['mobile_no'][] = __('auth.failed');
        return (new ErrorResource($errors))->response()->setStatusCode(422);
    }
}