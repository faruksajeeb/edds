<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Help extends Model
{   
    use HasFactory, SoftDeletes;
    protected $table = 'tbl_help';

    public $fillable = [
        'help_english',
        'help_bangla',
        'page_name',
        'question_id',
        'status',
        'created_by',
        'updated_by',
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
