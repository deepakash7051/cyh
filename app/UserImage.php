<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [  
        'user_id',
        'attachment'
    ];
    
    protected $hidden = [  
        'id',
        'user_id',
        'created_at',
        'updated_at',
        'user_image'
    ];

    //protected $appends = ['attachment_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }
}
