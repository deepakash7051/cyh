<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
	use \Czim\Paperclip\Model\PaperclipTrait;

	protected $fillable = [  
        'category_id',
        'ref_code',
        'en_title',
        'en_description',
        'bn_title',
        'bn_description',
        'zh_title',
        'zh_description',
        'ta_title',
        'ta_description',
        'price',
        'duration',
        'seats',
        'image',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = ['course_image_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('image');
        parent::__construct($attributes);
    }

    public function getCourseImageUrlAttribute() {
        return $this->image->url();
    }

    public static function laratablesCustomAction($course)
    {
        return view('admin.courses.action', compact('course'))->render();
    }

    public static function laratablesStatus($course)
    {
        return $course->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function shop_videos()
    {
        return $this->hasMany('App\CourseVideo');
    }
}
