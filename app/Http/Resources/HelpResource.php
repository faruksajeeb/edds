<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HelpResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'help_english'  => $this->help_english,
            'help_bangla'      => $this->help_bangla,
            'created_at' => optional($this->created_at)->format('Y-m-d h:i:s a'),
            'updated_at' => optional($this->updated_at)->format('Y-m-d h:i:s a')
        ];
    }
}
