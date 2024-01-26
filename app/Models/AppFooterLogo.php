<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppFooterLogo extends Model
{   
    use HasFactory,SoftDeletes;
    protected $table = 'tbl_logos';

    public $fillable = [
        'logo_base64',
        'status'
    ];

}
