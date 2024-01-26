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
use App\Http\Resources\HelpResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Models\Help;

class HelpController extends Controller
{
    // use HasApiTokens;

    public function index(Request $request)
    {
        // dd($request->user());
        // $helps = new HelpResource($request);
        $helps = Help::all();
        return new SuccessResource([
            'message' => 'All Help Message',
            'data' => $helps
        ]);
    }


}
