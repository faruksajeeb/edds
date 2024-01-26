<?php

namespace App\Http\Requests\Api;

use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "userName" => 'required',
            "userMobile" => ['required','unique:registered_users,mobile_no'],
            "userLoginPIN" => 'required',
            "userEmail" => '',
            "userGender" => 'required',
            "userBirthYear" => '',
            "userDivision" => 'required',
            "userDistrict" => 'required',
            "userUpzilla" => 'required',
            "userTypeOfRespondent" => 'required'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = (new ErrorResource($validator->errors()))->response()->setStatusCode(422);
        throw new ValidationException($validator, $response);
    }
}
