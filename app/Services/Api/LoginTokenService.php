<?php
namespace App\Services\Api;

use Laravel\Sanctum\Sanctum;

trait LoginTokenService
{

    // public function loginToken(array $credentials)
    public function loginToken($user)
    {
        // $user = RegisteredUser::where('mobile_no', $credentials['mobile_no'])->first();

        // if ($user && Hash::check($credentials['password'], $user->password)) {
        if ($user) {

            Sanctum::actingAs($user);
            $token = $user->createToken('api');
            // $response = [
            //     'message' => 'Login Token Generated Successfully!',
            //     'data' => [
            //         'token' => $token->plainTextToken
            //     ]
            // ];

            // return new SuccessResource($response);
            return $token->plainTextToken;
        }

        // $errors['mobile_no'][] = __('auth.failed');
        // return (new ErrorResource($errors))->response()->setStatusCode(422);
    }
}