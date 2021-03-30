<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentAttachment extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;
    
    protected $guarded = [];
    
    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }
    
    public function comment(){
        return $this->belongsTo('App\Comment');
    }
    
    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }
}
