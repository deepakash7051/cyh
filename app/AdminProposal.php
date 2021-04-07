<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProposal extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'desc',
        'proposal_type'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function admin_first_proposal_files(){
        return $this->hasMany('App\AdminProposalFile','first_p_id');
    }

    public function admin_second_proposal_files(){
        return $this->hasMany('App\AdminProposalFile','second_p_id');
    }

    public function admin_third_proposal_files(){
        return $this->hasMany('App\AdminProposalFile','third_p_id');
    }
}
