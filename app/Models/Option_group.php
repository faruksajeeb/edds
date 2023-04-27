<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option_group extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'option_group_name',
        'created_by',
        'updated_by',
        'status'
    ];
}
