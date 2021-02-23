<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;

    protected $fillable = [  
        'course_id',
        'en_title',
        'bn_title',
        'zh_title',
        'ta_title',
        'place',
        'time_limit',
        'attempts',
        'unlimited_attempts',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public static function laratablesCustomAction($quiz)
    {
        return view('admin.quizzes.action', compact('quiz'))->render();
    }

    public static function laratablesStatus($quiz)
    {
        return $quiz->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public static function laratablesRowClass($quiz)
    {
        return $quiz->status=='1' ? 'text-dark' : 'text-danger';
    }
}
