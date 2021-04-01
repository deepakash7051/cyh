<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
