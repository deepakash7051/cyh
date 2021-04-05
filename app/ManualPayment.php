<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $guarded = [];

    protected $appends = ['attachment_url'];

    public function __construct( array $attributes = [] ) {
        $this->hasAttachedFile('attachment');
        parent::__construct($attributes);
    }

    public function user(){
        return $this->belongsTo('App\User')->withDefault([
            'status' => 'pending'
        ]);;
    }

    public function payment_status(){
        return $this->hasMany('App\PaymentStatus');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function getAttachmentUrlAttribute() {
        return $this->attachment->url();
    }
}
