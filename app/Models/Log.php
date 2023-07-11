<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'loggable_id ',
        'loggable_type',
        'old_value',
        'new_value'
    ];

    /**
     * Get all of the owning loggable models.
     */
    public function loggable()
    {
        return $this->morphTo();
    }
}
