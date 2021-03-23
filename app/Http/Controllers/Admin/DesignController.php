<?php

namespace App\Http\Controllers\Admin;

use Validator;
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
        $data = ImageUpload::where('user_id',$user_id)->get();
        return view('admin.designs.index');
    }

    public function list()
    {
       return Laratables::recordsOf(ImageUpload::class);
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

        $images = $request->file('image');
        
        foreach( $images as $image ){
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('designs'),$imageName);

            $imageUpload = new ImageUpload();
            $imageUpload->title = $request->input('title');
            $imageUpload->user_id = auth()->user()->id;
            $imageUpload->filename = $imageName;
            $imageUpload->save();
        }
        
        return redirect('/admin/designs/create')->with('sussces', 'Design created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ImageUpload::where('id',$id)->first();
        return view('admin.designs.show')->with('design',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ImageUpload::where('id',$id)->first();   
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

        $design = ImageUpload::find($id);

        if( $request->input('title') ){
            $design->update(['title' => $request->input('title')]);
        }

        $image = $request->file('image');
        
        if( !empty($image) ){

            $imageName = $image->getClientOriginalName();
            $image->move(public_path('designs'),$imageName);

            $design->title = $request->input('title');
            $design->user_id = auth()->user()->id;
            $design->filename = $imageName;
            $design->save();
        }
        

        return redirect('/admin/designs/'.$id.'/edit')->with('sussces', 'Design has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $design = ImageUpload::find($id);
        $design->delete();

        return back();
    }
}
