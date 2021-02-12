<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcqoption extends Model
{
    protected $fillable = [  
        'question_id',
        'en_option_a',
        'en_option_b',
        'en_option_c',
        'en_option_d',
        'bn_option_a',
        'bn_option_b',
        'bn_option_c',
        'bn_option_d',
        'zh_option_a',
        'zh_option_b',
        'zh_option_c',
        'zh_option_d',
        'ta_option_a',
        'ta_option_b',
        'ta_option_c',
        'ta_option_d',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
