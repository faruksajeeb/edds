<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'division',
        'district',
        'thana',
        'value',
        'value_bangla',
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


    // public function setUpdatedAtAttribute($value)
    // {
    //     $this->attributes['response_date']=Carbon::createFromFormat('d/m/Y H:i:s',$value)->format('Y-m-d H:i:s');
    // }
    public function getUpdatedAtAttribute()
    {
        if (isset($this->attributes['updated_at'])) {
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['updated_at'])->format('F j, Y h:i:s A');
        }
    }
    public function getCreatedAtAttribute()
    {
        if (isset($this->attributes['created_at'])) {
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at'])->format('F j, Y h:i:s A');
        }
    }

}
