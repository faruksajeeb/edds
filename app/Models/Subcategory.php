<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable=[
        'id',
        'category_id',
        'sub_category_name',
        'status',
        'created_by',
        'updated_by',
        'status'
    ];
        
    protected $dates = ['deleted_at'];

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withTrashed();
    }
}
