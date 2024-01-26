<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tbl_a';
    public $fillable = [
        'respondent_type',
        'answare',
        'answare_bangla',
        'question_id',
        // 'created_by',
        // 'updated_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $dates = ['deleted_at'];


    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class,'question_id','id')->withTrashed();
    }
}
