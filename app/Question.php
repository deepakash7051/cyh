<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
	use \Czim\Paperclip\Model\PaperclipTrait;

	protected $fillable = [  
        'course_id',
        'quiz_id',
        'type',
        'en_title',
        'bn_title',
        'zh_title',
        'ta_title',
        'place',
        'visible',
        'option_label',
        'en_correct_answer',
        'bn_correct_answer',
        'zh_correct_answer',
        'ta_correct_answer',
        'en_attachment',
        'bn_attachment',
        'zh_attachment',
        'ta_attachment',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = ['en_attachment_url', 'bn_attachment_url', 'zh_attachment_url'. 'ta_attachment_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('en_attachment');
        $this->hasAttachedFile('bn_attachment');
        $this->hasAttachedFile('zh_attachment');
        $this->hasAttachedFile('ta_attachment');
        parent::__construct($attributes);
    }

    public function getEnAttachmentUrlAttribute() {
        return $this->en_attachment->url();
    }

    public function getBnAttachmentUrlAttribute() {
        return $this->bn_attachment->url();
    }

    public function getZhAttachmentUrlAttribute() {
        return $this->zh_attachment->url();
    }

    public function getTaAttachmentUrlAttribute() {
        return $this->ta_attachment->url();
    }

    public static function laratablesCustomAction($question)
    {
        return view('admin.questions.action', compact('question'))->render();
    }

    public static function laratablesStatus($question)
    {
        return $question->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function mcqoptions()
    {
        return $this->hasMany('App\Mcqoption');
    }

    public static function laratablesRowClass($question)
    {
        return $question->status=='1' ? 'text-dark' : 'text-danger';
    }

    
}
