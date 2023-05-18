<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'question_id',
        'sub_question_id',
        'response'
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
        return $this->belongsTo(UserResponse::class)->withTrashed();
    }
    public function question(){
        return $this->belongsTo(Question::class)->withTrashed();
    }
    public function subQuestion(){
        return $this->belongsTo(SubQuestion::class)->withTrashed();
    }
}

