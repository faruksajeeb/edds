<?php
namespace App\Services\Api;

use App\Models\RegisteredUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

trait RegisterService
{
    /**
     * Create new user
     * @param array $data
     * 
     * @return App\Models\User $user
     */
    public function createUser(array $data) : Model
    {
        
        $data = array(
            'respondent_type'     => $data['userTypeOfRespondent'],
            'full_name'    => $data['userName'],
            'email'    => $data['userEmail'],
            'mobile_no'    => $data['userMobile'],
            'gender'    => $data['userGender'],
            'birth_year'    => $data['userBirthYear'],
            'division'    => $data['userDivision'],
            'district'    => $data['userDistrict'],
            'thana'    =>$data['userUpzilla'],
            'user_pin'    =>$data['userLoginPIN'],
        );       

        $user = RegisteredUser::create($data);
        return $user;
    }
}