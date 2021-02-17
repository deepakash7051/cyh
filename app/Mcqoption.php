<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcqoption extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [  
        'question_id',
        'type',
        'language',
        'option',
        'value',
        'attachment',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $appends = ['attachment_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function optionvalue($language, $option)
    {
        return $this->where('language', $language)->where('option', $option)->first();
    }
}
