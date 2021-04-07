<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'proposal_initial_amount',
        'beneficiary_name',
        'account_number',
        'ifsc_code'
    ];

    public function user(){
        return $this->belongsT('App\User');
    }
}
