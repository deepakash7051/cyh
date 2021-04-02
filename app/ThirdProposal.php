<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThirdProposal extends Model
{

    protected $fillable = [
        '_token',
        'proposal_id',
        'third_price',
        'third_desc',
        'user_id'
    ];

    protected $table = 'third_proposals';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile','third_p_id');
    }
}
