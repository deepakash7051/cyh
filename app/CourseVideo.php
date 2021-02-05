<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseVideo extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
	use \Czim\Paperclip\Model\PaperclipTrait;

	protected $fillable = [  
        'course_id',
        'place',
        'attachment',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = ['attachment_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }

    public static function laratablesCustomAction($video)
    {
        return view('admin.videos.action', compact('video'))->render();
    }

    public static function laratablesStatus($video)
    {
        return $video->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
