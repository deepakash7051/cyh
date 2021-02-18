<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsVerification extends Model
{
    protected $fillable = [  
        'phone',
        'code',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];
}
