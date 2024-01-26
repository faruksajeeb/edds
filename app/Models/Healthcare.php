<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Healthcare extends Model
{   
    use HasFactory, SoftDeletes;
    protected $table = 'tbl_healthcare';

    public $fillable = [
        'center_type_id',
        'hospital_name_english',
        'hospital_name_bangla',
        'latitude',
        'longitude',
        'type',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function center_type(): HasOne
    {
        return $this->hasOne(Option::class, 'id', 'center_type_id')->withTrashed()->withDefault(['option_value' => '']);
    }
    
}
