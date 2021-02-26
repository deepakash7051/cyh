<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use SoftDeletes;

    protected $fillable = [  
        'user_id',
        'quiz_id',
        'attempt_result',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }
}
