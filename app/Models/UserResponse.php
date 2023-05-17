<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->hasMany(UserResponseDetail::class,'response_id','id')->orderBy('question_id');
    }
}
