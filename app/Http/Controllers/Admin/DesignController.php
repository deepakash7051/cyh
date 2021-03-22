<?php

namespace App\Http\Controllers\Admin;

use App\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use Validator;

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
        return view('admin.designs.imageupload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/designs/create')->with('error', 'All fields are required');
        }

        $images = $request->file('file');
        
        foreach( $images as $image ){
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'),$imageName);

            $imageUpload = new ImageUpload();
            $imageUpload->title = $request->input('title');
            $imageUpload->user_id = auth()->user()->id;
            $imageUpload->filename = $imageName;
            $imageUpload->save();
        }
        
        return redirect('/admin/designs/create')->with('sussces', 'Image has been uploaded');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Laratables::recordsOf(ImageUpload::class);
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
        //
    }
}
