<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class RegisteredUser extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $table = 'registered_users';

    public $fillable = [
        'full_name',
        'email',
        'mobile_no',
        'gender',
        'division',
        'department',
        'district',
        'respondent_type',
        'status',
        'otp',
        'otp_generated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];

    
    // public function respondent() : BelongsTo
    // {
    //     return $this->belongsTo(Option::class,'respondent_id','id')->withTrashed();
    // }

    function responses()
    {
        return $this->hasMany(UserResponse::class)->orderBy('created_at','DESC');;
    }

    function pendingResponses()
    {
        return $this->hasMany(UserResponse::class)->where('status', 1);
    }
    function verifiedResponses()
    {
        return $this->hasMany(UserResponse::class)->where('status', 2);
    }

    /**
     * Get all of the post's logs.
     */
    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'loggable');
    }
}
