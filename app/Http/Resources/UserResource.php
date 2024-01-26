<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user' => [
                // 'id'         => $this->id,
                'mobile_no'  => $this->mobile_no,
                'email'      => $this->email,
                'respondent_type'       => $this->respondent_type,
                'full_name'       => $this->full_name,
                'gender'       => $this->gender,                
                'birth_year'       => $this->birth_year,                
                'division'       => $this->division,                
                'district'       => $this->district,                
                'thana'       => $this->thana,                
                'created_at' => $this->created_at->format('Y-m-d h:i:s a'),
                'updated_at' => $this->updated_at->format('Y-m-d h:i:s a'),
            ]
        ];
    }
}