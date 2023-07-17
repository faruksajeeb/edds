<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id')->withTrashed();
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
    // public function setUpdatedAtAttribute($value)
    // {
    //     $this->attributes['updated_at']=Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('Y-m-d H:i:s');
    // }
    public function getUpdatedAtAttribute($value)
    {
        if (isset($this->attributes['updated_at'])) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('F j, Y h:i:s A');
        }
    }
    // public function setCreatedAtAttribute($value)
    // {
    //     $this->attributes['created_at']=Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('Y-m-d H:i:s');
    // }
    public function getCreatedAtAttribute()
    {
        if (isset($this->attributes['created_at'])) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('F j, Y h:i:s A');
        }
    }

}
