<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{

    protected $fillable = [
        'portfolio_id'
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function proposal_images(){
        return $this->hasMany('App\ProposalImage');
    }

}
