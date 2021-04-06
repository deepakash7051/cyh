<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Comment;
use App\Proposal;
use App\Portfolio;
use App\FirstProposal;
use App\PaymentStatus;
use App\ThirdProposal;
use App\SecondProposal;
use App\AdminProposalFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use App\Http\Requests\DesignEditRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProposalEditRequest;
use App\Http\Requests\ProposalUpdateRequest;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proposals.index');
    }

    public function list(){
        //return Proposal::with(['portfolio'])->get();
        return Laratables::recordsOf(Proposal::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = Proposal::with(['user','portfolio','proposal_images'])->where('id',$id)->first();
        return view('admin.proposals.show')->with('proposals',$proposal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = Proposal::with(['user','portfolio','proposal_images','first_proposal','second_proposal','third_proposal','admin_propsal_files','single_manual_payment','payment_status'])->where('id',$id)->first();
        //return $proposal;
        $first_proposal = FirstProposal::with(['admin_propsal_files'])->where('proposal_id',$id)->get();
        $second_proposal = SecondProposal::with(['admin_propsal_files'])->where('proposal_id',$id)->get();
        $third_proposal = ThirdProposal::with(['admin_propsal_files'])->where('proposal_id',$id)->get();
        return view('admin.proposals.edit')->with(
            [
                'proposals'=>$proposal,
                'first_proposals'=>$first_proposal,
                'second_proposals'=>$second_proposal,
                'third_proposals'=>$third_proposal
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(ProposalUpdateRequest $request, $id)
    {
        $user = auth()->user();
        $porposal = Proposal::find($id);
        $plan_id = [];
        if( $request->exists('first_propsal') ){
            $data = request()->merge(['user_id'=>$user->id])->except(['_token','_method','first_propsal']);
            $model = $porposal->first_proposal()->updateOrCreate(['proposal_id'=>$id],$data);
            $plan_id = ['first_p_id'=>$model->id];
        }
        if( $request->exists('second_propsal') ){
            $data = request()->merge(['user_id'=>$user->id])->except(['_token','_method','second_propsal']);
            $model = $porposal->second_proposal()->updateOrCreate(['proposal_id'=>$id],$data);
            $plan_id = ['second_p_id'=>$model->id];
        }
        if( $request->exists('third_propsal') ){
            $data = request()->merge(['user_id'=>$user->id])->except(['_token','_method','third_propsal']);
            $model = $porposal->third_proposal()->updateOrCreate(['proposal_id'=>$id],$data);
            $plan_id = ['third_p_id'=>$model->id];
        }
        
        if( $request->has('attachment') ){
            foreach($request->attachment as $attachment){
                if(!empty($plan_id)){
                    $data = array_merge(['user_id'=>$user->id,'attachment' => $attachment],$plan_id);

                }else{
                    $data = ['user_id'=>$user->id,'attachment' => $attachment];
                }
                $porposal->admin_propsal_files()->create( $data );
            }
        }
        return redirect()->back();
        //return redirect()->route('admin.proposals.index')->with('sussces', 'Proposal created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proposal = Proposal::with(['portfolio','proposal_images'])->where('id',$id);
        $proposal->delete();
        
        return back();
    }

    public function deleteFile($id){
        $file = AdminProposalFile::find($id);
        $file->delete();
        
        return back();
    }

    public function updatePaymentStatus(Request $request,$id){
        $paymentStatus = PaymentStatus::find($id);
        $paymentStatus->update(['status'=>$request->route('paymentStatus')]);
        return $request->route('paymentStatus');
    }
}
