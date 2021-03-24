<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Design;
use App\Portfolio;
use App\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesignRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Http\Requests\DesignEditRequest;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = Portfolio::all();
        return view('admin.designs.index');
    }

    public function list()
    {
       return Laratables::recordsOf(Portfolio::class);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.designs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignRequest $request)
    {
        $user = auth()->user();
        $portfolio = new Portfolio();
        $portfolio->user_id = auth()->user()->id;
        $portfolio->title = $request->input('title');
        $portfolio->save();
        if( $request->has('attachments') ){
            foreach($request->attachments as $attachment){
                $user->designs()->create(['portfolio_id'=>$portfolio->id,'attachment' => $attachment]);
            }
        }

        return redirect('/admin/designs')->with('sussces', 'Portfolio created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Design::where('portfolio_id',$id)->get();
        return view('admin.designs.show')->with('designs',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Portfolio::where('id',$id)->first();   
        return view('admin.designs.edit')->with('design',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DesignEditRequest $request, $id)
    {
        $user = auth()->user();
        $portfolio = Portfolio::find($id);

        if( $request->input('title') ){
            $portfolio->update(['title' => $request->input('title')]);
        }
        
        if( $request->has('attachments') ){
            foreach($request->attachments as $attachment){
                $user->designs()->create(['portfolio_id'=>$portfolio->id,'attachment' => $attachment]);
            }
        }
        

        return redirect('/admin/designs')->with('sussces', 'Design has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);
        $portfolio->delete();

        $design = Design::where('portfolio_id',$id);
        $design->delete();

        return back();
    }

    public function deleteDesign($id){
        if(!empty($id)){
            $design = Design::find($id);
            $design->delete();
        }
        return back();
    }
}
