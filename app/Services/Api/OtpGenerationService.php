<?php
namespace App\Services\Api;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\RegisteredUser;
use App\Services\Api\SendSmsService;

trait OtpGenerationService
{
    use SendSmsService;

    public function generateOtp(array $credentials)
    {
        $user = RegisteredUser::where('mobile_no', $credentials['mobile_no'])->first();

        // if ($user && Hash::check($credentials['password'], $user->password)) {
        if ($user) {

            $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // update OTP
            $user->otp = $otp;
            $user->otp_generated_at = now();
            $user->save();

            # send OTP
            $text = "Please enter the OTP ".$otp." to verify your mobile number";
            $this->sendSms($credentials['mobile_no'],$text);
            
            $response = [
                'message' => '6 Digit OTP has been send Successfully!',
                'data' => [
                    'otp' => $otp
                ]
            ];

            return new SuccessResource($response);
        }

        $errors['mobile_no'][] = __('auth.failed');
        return (new ErrorResource($errors))->response()->setStatusCode(422);
    }
}