<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [
        'portfolio_id'
    ];
    
    protected $hidden = [
        'image_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function portfolio(){
        return $this->belongsTo('App\Portfolio');
    }

    public function proposal_images(){
        return $this->hasMany('App\ProposalImage');
    }

    public static function laratablesCustomAction($proposal)
    {
        return view('admin.proposals.action', compact('proposal'))->render();
    }

    public static function laratablesCustomName($user)
    {
        return $user->first_name. ' ' .$user->last_name;
    }
     
    public static function laratablesAdditionalColumns()
    {
        return ['portfolio'];
    }

    public static function laratablesOrderName()
    {
        return 'portfolio';
    }
}
