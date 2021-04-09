<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProposal extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'desc',
        'proposal_type',
        'accept'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function admin_proposal_files(){
        return $this->hasMany('App\AdminProposalFile','admin_proposal_id');
    }

    public function milestone_payment(){
        return $this->hasMany('App\MilestonePayment','proposal_id');
    }
}
