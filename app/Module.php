<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cohensive\Embed\Facades\Embed;

class Module extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
	use \Czim\Paperclip\Model\PaperclipTrait;

	protected $fillable = [  
        'en_title',
        'bn_title',
        'zh_title',
        'ta_title',
        'course_id',
        'en_video',
        'bn_video',
        'zh_video',
        'ta_video',
        'place',
        'en_slide',
        'bn_slide',
        'zh_slide',
        'ta_slide',
        'status',
        'link_attachment',
        'en_video_link',
        'bn_video_link',
        'zh_video_link',
        'ta_video_link',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = [
    	'en_video_url', 
    	'bn_video_url', 
    	'zh_video_url', 
    	'ta_video_url',
    	'en_slide_url', 
    	'bn_slide_url', 
    	'zh_slide_url', 
    	'ta_slide_url',
        'en_video_html',
        'bn_video_html',
        'zh_video_html',
        'ta_video_html',
    ];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('en_video');
        $this->hasAttachedFile('bn_video');
        $this->hasAttachedFile('zh_video');
        $this->hasAttachedFile('ta_video');
        $this->hasAttachedFile('en_slide');
        $this->hasAttachedFile('bn_slide');
        $this->hasAttachedFile('zh_slide');
        $this->hasAttachedFile('ta_slide');
        parent::__construct($attributes);
    }

    public function getEnVideoUrlAttribute() {
        return $this->en_video->url();
    }

    public function getBnVideoUrlAttribute() {
        return $this->bn_video->url();
    }

    public function getZhVideoUrlAttribute() {
        return $this->zh_video->url();
    }

    public function getTaVideoUrlAttribute() {
        return $this->ta_video->url();
    }

    public function getEnSlideUrlAttribute() {
        return $this->en_slide->url();
    }

    public function getbnSlideUrlAttribute() {
        return $this->bn_slide->url();
    }

    public function getZhSlideUrlAttribute() {
        return $this->zh_slide->url();
    }

    public function getTaSlideUrlAttribute() {
        return $this->ta_slide->url();
    }

    public function getEnVideoHtmlAttribute()
    {
        if(!empty($this->en_video_link)){
            //return $this->en_video_link;
            $embed = Embed::make($this->en_video_link)->parseUrl();
            if (!$embed) return '';
            $embed->setAttribute(['width' => '', 'height' => '']);
            return $embed->getHtml();
        } else {
            return '';
        }
        
    }

    public function getBnVideoHtmlAttribute()
    {
        if(!empty($this->bn_video_link)){
            $embed = Embed::make($this->bn_video_link)->parseUrl();
            if (!$embed) return '';
            $embed->setAttribute(['width' => '', 'height' => '']);
            return $embed->getHtml();
        } else {
            return '';
        }
    }

    public function getZhVideoHtmlAttribute()
    {
        if(!empty($this->zh_video_link)){
            $embed = Embed::make($this->zh_video_link)->parseUrl();
            if (!$embed) return '';
            $embed->setAttribute(['width' => '', 'height' => '']);
            return $embed->getHtml();
        } else {
            return '';
        }
    }

    public function getTaVideoHtmlAttribute()
    {
        if(!empty($this->ta_video_link)){

            $embed = Embed::make($this->ta_video_link)->parseUrl();
            if (!$embed) return '';

            $embed->setAttribute(['width' => '', 'height' => '']);
            return $embed->getHtml();
        } else {
            return '';
        }
    }

    public static function laratablesStatus($module)
    {
        return $module->status == 1 ? trans('global.active') : trans('global.inactive');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public static function laratablesRowClass($module)
    {
        return $module->status=='1' ? 'text-dark' : 'text-danger';
    }
}
