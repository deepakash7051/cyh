<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MilestonePayment extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Usre');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function milestone(){
        return $this->belongsTo('App\Milestone');
    }

    public function admin_proposal(){
        return $this->belongsTo('App\AdminProposal');
    }

    public function manual_payment(){
        return $this->hasOne('App\ManualPayment','milestone_payment_id');
    }
}
