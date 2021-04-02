<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProposalFile extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $guarded = [];

    protected $appends = ['attachment_url'];
    
    public function __construct( array $attributes = [] ){
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function first_proposal(){
        return $this->belongsTo('App\FirstProposal');
    }

    public function second_proposal(){
        return $this->belongsTo('App\SecondProposal');
    }

    public function third_proposal(){
        return $this->belongsTo('App\ThirdProposal');
    }
}
