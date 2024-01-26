<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RespondentType extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'tbl_respopndent';

    public $fillable = [
        'option',
        'label',
        'label_bangla',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    protected $dates = ['deleted_at'];
}
