<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FirstProposal extends Model
{
    protected $fillable = [
        '_token',
        'user_id',
        'proposal_id',
        'first_price',
        'first_desc'
    ];

    protected $table = 'first_proposals';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile','first_p_id');
    }
    
}
