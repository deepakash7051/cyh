<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAttempt extends Model
{
    use SoftDeletes;

    protected $fillable = [  
        'user_id',
        'course_id',
        'attempts',
        'resume_module',
        'completed_at',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
