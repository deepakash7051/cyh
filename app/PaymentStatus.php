<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $guarded = [];

    protected $hidden = [
        
    ];

    public function manual_payment(){
        return $this->belongsTo('App\ManualPayment');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }
}
