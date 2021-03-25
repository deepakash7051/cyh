<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [  
        'title',
        'description',
    ];

    protected $hidden = [  
        'portfolio_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function designs(){
        return $this->hasMany('App\Design','portfolio_id');
    }

    public function proposal(){
        return $this->belongsTo('App\Proposal','portfolio_id');
    }

    public static function laratablesCustomAction($design)
    {
        return view('admin.designs.action', compact('design'))->render();
    }
}
