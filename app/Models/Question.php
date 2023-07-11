<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function category(): HasOne
    {
        return $this->hasOne(Option::class, 'id', 'category_id')->withTrashed()->withDefault(['option_value' => '']);
    }

    function subQuestions(): HasMany
    {
        return $this->hasMany(SubQuestion::class);
    }

    function activeSubQuestions()
    {
        return $this->hasMany(SubQuestion::class)->where('status', 1);
    }

    public function latestSubQuestion(): HasOne
    {
        return $this->hasOne(SubQuestion::class)->latestOfMany();
    }

    public function oldestSubQuestion(): HasOne
    {
        return $this->hasOne(SubQuestion::class)->oldestOfMany();
    }

    public function largestSubQuestion(): HasOne
    {
        return $this->hasOne(SubQuestion::class)->ofMany('id', 'max');
    }

    public function currentSubQuestion(): HasOne
    {
        return $this->hasOne(SubQuestion::class)->ofMany([
            'created_at' => 'max',
            'id' => 'max',
        ], function (Builder $query) {
            $query->where('published_at', '<', now());
        });
    }

    /**
     * Get all of the post's logs.
     */
    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'loggable');
    }
}
