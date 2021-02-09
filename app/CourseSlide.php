<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSlide extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
	use \Czim\Paperclip\Model\PaperclipTrait;

	protected $fillable = [  
        'course_id',
        'en_title',
        'bn_title',
        'zh_title',
        'ta_title',
        'place',
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

    public static function laratablesCustomAction($slide)
    {
        return view('admin.slides.action', compact('slide'))->render();
    }

    public static function laratablesStatus($slide)
    {
        return $slide->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
