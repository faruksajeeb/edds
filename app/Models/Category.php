<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable=[
        'id',
        'name',
        'slug',
        'image',
        'is_popular',
        'status',
        'created_by',
        'updated_by',
        'status'
    ];

        
    protected $dates = ['deleted_at'];

    public function images(){
        return $this->morphMany(Image::class,'imageable');
    }

    
}
