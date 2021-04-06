<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripePayment extends Model
{
    protected $guarded = [];
    protected $table = 'stripe_payments';
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }
}
