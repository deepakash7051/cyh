<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;

class ImageUploadController extends Controller
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
        return view('admin.designs.index')->with('designs',$data);
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

    public function fileCreate()
    {
        return view('admin.designs.imageupload');
    }

    public function fileStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/image/upload')->with('error', 'All fields are required');
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
        
        return redirect('/admin/image/upload')->with('sussces', 'Image has been uploaded');
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        ImageUpload::where('filename',$filename)->delete();
        $path=public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }
}
