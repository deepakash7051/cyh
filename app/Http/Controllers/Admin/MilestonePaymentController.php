<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MilestonePayment;

class MilestonePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $m_p_id = $request->input('m_p_id');
        $status = $request->input('m_p_status');
        $milestoenPayment = MilestonePayment::find($m_p_id);
        //$milestoenPayment->update(['status'=>$status]);
        dd($request->all());exit;
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function milestonesTaskStatus(Request $request,$id){
        $milestonePayment = MilestonePayment::find($id);
        return $milestonePayment->update(['task'=>$request->route('task')]);
    }

    public function milestonesPaymentStatus(Request $request,$id){
        $milestonePayment = MilestonePayment::find($id);
        return $milestonePayment->update(['status'=>$request->route('status')]);
    }
}
