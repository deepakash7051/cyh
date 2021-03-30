<?php

namespace App\Http\Controllers\Admin;

use App\Proposal;
use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use App\Http\Requests\ProposalEditRequest;
use App\Http\Requests\ProposalUpdateRequest;
use App\Http\Requests\DesignEditRequest;
use App\Comment;

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
        $proposal = Proposal::with(['user','portfolio','proposal_images'])->where('id',$id)->first();
        $comments = auth()->user()->comments()->latest()->first();
        return view('admin.proposals.edit')->with(['proposals'=>$proposal,'comments'=>$comments]);
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
//         $comment = new Comment();
//         $comment->user_id = auth()->user()->id;
//         $comment->comment = $request->input('comment');
//         $comment->proposal_id = $id;
//         $comment->save();
        $comment =  Comment::updateOrCreate(['user_id'=>$user->id,'comment'=>$request->input('comment'),'proposal_id'=>$id]);
        if( $request->has('attachment') ){
            foreach($request->attachment as $attachment){
                $comment->comments_attachments()->create(['user_id'=>$user->id,'comment_id'=>$comment->id,'attachment' => $attachment]);
            }
        }
        
        return redirect()->route('admin.proposals.index')->with('sussces', 'Proposal created successfully');
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
}
