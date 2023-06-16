<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'id',
        'option_group_name',
        'option_value',
        'option_value2',
        'option_value3',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id', 'id')->withTrashed();
    }
}
