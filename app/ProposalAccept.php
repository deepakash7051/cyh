<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalAccept extends Model
{
    protected $guarded = [];

    protected $table = 'proposal_accepts';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal');
    }

}
