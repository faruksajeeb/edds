<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserResponse extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'registered_user_id',
        'area_id',
        'market_id',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
   

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];

    public function setResponseDateAttribute($value)
    {
        $this->attributes['response_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    public function getResponseDateAttribute()
    {
        if ($this->attributes['response_date']!=null) {
            return Carbon::createFromFormat('Y-m-d',$this->attributes['response_date'])->format('F j, Y');
        }
    }

    public function registered_user() : BelongsTo
    {
        return $this->belongsTo(RegisteredUser::class,'registered_user_id','id')->withTrashed();
    }
    public function area() : BelongsTo
    {
        return $this->belongsTo(Area::class,'area_id','id')->withTrashed();
    }
    public function market() : BelongsTo
    {
        return $this->belongsTo(Market::class,'market_id','id')->withTrashed();
    }

    public function userResponseDetails(){
        return $this->hasMany(UserResponseDetail::class,'response_id','id')->orderBy('id');
    }

    function responses() {
        return $this->hasMany(UserResponseDetail::class);
    }

    function verifiedResponses() {
        return $this->hasMany(UserResponseDetail::class)->where('status', 2);
    }
    
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
