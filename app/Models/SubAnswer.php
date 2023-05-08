<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubAnswer extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'value',
        'value_bangla',
        'answer_id',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];

    
    public function answer() : BelongsTo
    {
        return $this->belongsTo(Answer::class,'answer_id','id');
    }
}
