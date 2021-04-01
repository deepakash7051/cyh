<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    
}
