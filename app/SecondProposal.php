<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SecondProposal extends Model
{
    protected $fillable = [
        '_token',
        'proposal_id',
        'second_price',
        'second_desc',
        'user_id'
    ];

    protected $table = 'second_proposals';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile','second_p_id');
    }

}
