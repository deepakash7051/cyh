<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $guarded = [];

    public function milestone_payment(){
        return $this->belongs('App\MilestonePayment');
    }

    public static function laratablesCustomAction($proposal)
    {
        return view('admin.proposals.action', compact('proposal'))->render();
    }
}
