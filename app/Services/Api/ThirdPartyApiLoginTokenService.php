<?php

namespace App\Services\Api;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait ThirdPartyApiLoginTokenService
{

    public function loginToken(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            
            // Sanctum::actingAs($user);

            // Set the expiration time 
            // $expirationTime = now()->addDay();
            // $expirationTime = now()->addHour();
            // $expirationTime = now()->addMinutes(1);

            $token = $user->createToken('api')->plainTextToken;

            $response = [
                'message' => 'Login Token Generated Successfully!',
                'data' => [
                    'token' => $token,
                    'user' => $user
                ]
            ];

            return new SuccessResource($response);
            return $token->plainTextToken;
        }

        $errors['email'][] = __('auth.failed');
        return (new ErrorResource($errors))->response()->setStatusCode(422);
    }
}
