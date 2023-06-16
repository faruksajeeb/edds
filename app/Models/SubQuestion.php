<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubQuestion extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'value',
        'value_bangla',
        'question_id',
        // 'input_method',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];

    
    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class)->withTrashed()->withDefault(['value'=>'']);
    }
}
