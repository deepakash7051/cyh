<?php

namespace App;

use App\FirstProposal;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\PortfolioResource;
use Illuminate\Database\Eloquent\Relations\Relation;

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

    public function admin_proposals(){
        return $this->hasMany('App\AdminProposal','proposal_id');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile','proposal_id');
    }
    
    public function payment_status(){
        return $this->hasOne('App\PaymentStatus','proposal_id')->withDefault([
            'status' => 'pending'
        ])->latest();
    }

    public function single_manual_payment(){
        return $this->hasOne('App\ManualPayment','proposal_id')->latest();
    }

    public function manual_payment(){
        return $this->hasMany('App\ManualPayment','proposal_id');
    }

    public function stripe_payment(){
        return $this->hasOne('App\StripePayment','proposal_id')->latest();
    }

    public function proposal_accept(){
        return $this->hasMany('App\ProposalAccept','admin_proposal_id');
    }
}
