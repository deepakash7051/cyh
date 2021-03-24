<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Design extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;
    
    protected $guarded = [];

    protected $appends = ['attachment_url'];

    public function __construct( array $attributes = [] ){
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function portfolio(){
        return $this->belongsTo('App\Portfolio','portfolio_id');
    }
    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }
}
