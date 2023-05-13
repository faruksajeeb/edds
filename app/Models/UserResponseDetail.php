<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserResponseDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'division_id',
        'division_id',
        'district_id',
        'thana_id',
        'area_id',
        'market_id',
        'respondent_id',
        'mobile_no',
        'gender'
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

    public function userResponse(){
        return $this->belongsTo(UserResponse::class);
    }
}
