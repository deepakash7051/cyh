<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalImage extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [
        'attachment'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->hasMany('App\Proposal');
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }
}
