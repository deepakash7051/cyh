<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [
        'portfolio_id',
        'description'
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

    public function first_proposal(){
        return $this->hasMany('App\FirstProposal','proposal_id');
    }

    public function second_proposal(){
        return $this->hasMany('App\SecondProposal','proposal_id');
    }

    public function third_proposal(){
        return $this->hasMany('App\ThirdProposal','proposal_id');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile');
    }
    
}
