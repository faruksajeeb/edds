<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'value',
        'value_bangla',
        'category_id',
        'respondent',
        'input_method',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function option() : BelongsTo
    {
        return $this->belongsTo(Option::class,'category_id','id')->withTrashed()->withDefault(['option_value'=>'']);
    }

    function subQuestions() {
        return $this->hasMany(SubQuestion::class);
    }


}
