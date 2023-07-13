<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Market extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'value',
        'value_bangla',
        'market_address',
        'area_id',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];



    public function area() : BelongsTo
    {
        return $this->belongsTo(Area::class,'area_id','id')->withTrashed();
    }


    public function toSearchableArray()
{
    return [
        'value' => '',
        'value_bangla' => '',
        'latitude' => '',
        'latitude' => '',
        'markets.value' => '',
        'markets.value_bangla' => '',
    ];
}

}
