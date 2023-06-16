<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisteredUser extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'full_name',
        'email',
        'mobile_no',
        'gender',
        'division',
        'department',
        'district',
        'respondent_type',
        'status'
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
}
