<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SmsResponse extends Model
{
    use HasFactory;
    protected $table = 'user_response_sms_info';
    protected $fillable = [
        'contact_no',
        'respondent_type',
        'address',
        'item',
        'quantity'
    ];


    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'address', 'sms_code');
    }

    public function respondent()
    {
        return $this->belongsTo(RespondentType::class, 'respondent_type', 'sms_code');
    }
    
    public function category()
    {
        return $this->belongsTo(Option::class, 'item', 'option_value3');
    }
}
