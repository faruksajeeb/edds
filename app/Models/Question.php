<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $fillable=[        
        'value',
        'value_bangla',
        'created_by',
        'updated_by',
        'status'
    ];
}
