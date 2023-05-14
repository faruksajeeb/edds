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
        'respondent_id',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];

    
    public function respondent() : BelongsTo
    {
        return $this->belongsTo(Option::class,'respondent_id','id')->withTrashed();
    }
}
