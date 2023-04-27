<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'option_group_name',
        'option_value',
        'option_value2',
        'option_value3',
        'created_by',
        'updated_by',
        'status'
    ];
}
