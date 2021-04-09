<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\AdminProposal;
use App\ProposalAccept;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proposal;
use App\MilestonePayment;
class ProposalAcceptController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->payload(['StatusCode' => '200', 'message' => 'Proposal Accepted', 'result' => array('proposal_accept' => ProposalAccept::all())],200);
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
        try{
            $validator = Validator::make($request->all(), [
	            'admin_proposal_id' => 'required|integer',
	        ]);
	        if ($validator->fails()) {
	            $errors = $validator->errors()->toArray();
	            $message = "";
	            foreach($errors as $key  => $values){
	                foreach($values as $value){
	                    $message .= $value . "\n";
	                }
	            }
	            return $this->payload(['StatusCode' => '422', 'message' => $message, 'result' => new \stdClass],200);
	        }

            $user = auth()->user();
            
            $adminProposal = AdminProposal::where( 'id',$request->input('admin_proposal_id') );
            $checkUser = ProposalAccept::where(['user_id'=>auth()->user()->id]);
            
            if( $adminProposal && $adminProposal->exists() ){
                
                $proposal_id = $adminProposal->first('proposal_id');
                $disableProposal = AdminProposal::where(['proposal_id'=>$proposal_id->proposal_id])->where('id', '<>', $request->input('admin_proposal_id'));
                $checkProposalId =  ProposalAccept::where(['user_id'=>auth()->user()->id,'admin_proposal_id'=>$request->input('admin_proposal_id')]);
                if( $checkProposalId && !$checkProposalId->exists()){ // && $checkUser && !$checkUser->exists()
                    $checkProposalId->create(['user_id'=>$user->id,'admin_proposal_id'=>$request->input('admin_proposal_id')]);
                    $adminProposal->update(['accept'=>true]);
                    $disableProposal->update(['accept'=>false]);

                    $this->milestonePayment($proposal_id,$request->all());

                    $message = "Proposal accepted";
                    
                }else{
                    $message = 'Proposal already accepted.';
                }

            }else{
                $message = 'Proposal does not exist.';
            }

            return $this->payload(['StatusCode' => '200', 'message' => $message, 'result' => array('proposal' => [])],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acceptedProposal = ProposalAccept::find($id);
        $acceptedProposal->delete();
        return $this->payload(['StatusCode' => '200', 'message' => 'Proosal deleted', 'result' => array('proposal' => [])],200);
    }

    public function milestonePayment($proposal_id,$request){
        $adminProposal = AdminProposal::where('id',$request['admin_proposal_id'])->first();
        $proposal = Proposal::where('id',$proposal_id->proposal_id)->first();
        $amount = $adminProposal->price;
        $proposalAmount = $proposal->amount;
        if( !empty($amount) && !empty($proposalAmount) ){
            $balance = (int)$amount - (int)$proposalAmount;

            $downPayment = $this->fourtyPercent($balance);
            $materialsFabricationDone = $this->fourtyPercent($balance);
            $uponInstallation = $this->tenPercent($balance);
            $uponCompletetion = $this->tenPercent($balance);

            $data = [
                'downPayment'=>$downPayment,
                'materialsFabricationDone'=>$materialsFabricationDone,
                'uponInstallation'=>$uponInstallation,
                'uponCompletetion'=>$uponCompletetion
            ];

            MilestonePayment::where(['user_id'=>auth()->user()->id, 'proposal_id'=>$proposal_id->proposal_id,'milestone_id'=>1])->update(['admin_proposal_id'=>$request['admin_proposal_id']]);

            MilestonePayment::where(['user_id'=>auth()->user()->id, 'proposal_id'=>$proposal_id->proposal_id,'milestone_id'=>2])->update(['amount'=>$downPayment,'admin_proposal_id'=>$request['admin_proposal_id']]);

            MilestonePayment::where(['user_id'=>auth()->user()->id, 'proposal_id'=>$proposal_id->proposal_id,'milestone_id'=>3])->update(['amount'=>$materialsFabricationDone,'admin_proposal_id'=>$request['admin_proposal_id']]);

            MilestonePayment::where(['user_id'=>auth()->user()->id, 'proposal_id'=>$proposal_id->proposal_id,'milestone_id'=>4])->update(['amount'=>$uponInstallation,'admin_proposal_id'=>$request['admin_proposal_id']]);

            MilestonePayment::where(['user_id'=>auth()->user()->id, 'proposal_id'=>$proposal_id->proposal_id,'milestone_id'=>5])->update(['amount'=>$uponCompletetion,'admin_proposal_id'=>$request['admin_proposal_id']]);

            return $data;
        }
        
        return $proposal;
    }

    public function fourtyPercent($proposalAmount){
        $fourtyPercent = ((int)$proposalAmount * 40) / 100;
        return $fourtyPercent;
    }

    public function tenPercent($proposalAmount){
        $tenPercent = ((int)$proposalAmount * 10) / 100;
        return $tenPercent;
    }
}
