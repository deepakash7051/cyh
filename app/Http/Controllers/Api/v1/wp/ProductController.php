<?php

namespace App\Http\Controllers\Api\v1\wp;

use Response;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Codexshaper\WooCommerce\Facades\Product;
use App\Http\Controllers\Api\v1\ApiController;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            
            $product = Product::all();
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Products List', 'result' => array('product' => $product)],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
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
	            'name' => 'required',
                'type' => '',
	            'regular_price' => 'required|integer',
                'description' => '',
                'short_description' => '',
                'categories' => '',
                'images.*' => 'image:jpeg,png,jpg,gif,svg|max:2048'
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

            $images = [];
            if($request->hasFile('images')){
                foreach( $request->file('images') as $imgs ){
                    $imgPath = $imgs;
                    $imgName = time() . '.' . $imgPath->getClientOriginalName();
                    $path = $imgs->storeAs('temp', $imgName, 'public');
                    $images[] = ['src' => url('storage/'.$path)];
                    
                }
            }
            
            $exploded = explode(',', $request->input('categories'));
            $cat = array();
            foreach ($exploded as $elem) {
                $cat[] = array('id' => $elem);
            }

            $data = [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'description' => $request->input('description'),
                'short_description' => $request->input('short_description'),
                'categories' => $cat,
                'images' => $images,
                'regular_price' => $request->input('regular_price')
            ];
            
            $product = Product::create($data);
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Product Created', 'result' => array('product' => $product)],200);
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
        try{
            
            $product =Product::find($id);;
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Product Detail', 'result' => array('product' => $product)],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
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
        
        try{

            $validator = Validator::make($request->all(), [
	            'name' => 'required',
                'type' => '',
	            'regular_price' => 'required|integer',
                'description' => '',
                'short_description' => '',
                'categories' => '',
                'images.*' => 'image:jpeg,png,jpg,gif,svg|max:2048'
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

            $images = [];
            if($request->hasFile('images')){
                foreach( $request->file('images') as $imgs ){
                    $imgPath = $imgs;
                    $imgName = time() . '.' . $imgPath->getClientOriginalName();
                    $path = $imgs->storeAs('temp', $imgName, 'public');
                    $images[] = ['src' => url('storage/'.$path)];
                    
                }
            }
            
            $exploded = explode(',', $request->input('categories'));
            $cat = array();
            foreach ($exploded as $elem) {
                $cat[] = array('id' => $elem);
            }

            $data = [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'regular_price' => $request->input('regular_price'),
                'description' => $request->input('description'),
                'short_description' => $request->input('short_description'),
                'categories' => $cat,
                'images' => $images,
                
            ];

            $product = Product::update($id, $data);
            return $this->payload(['StatusCode' => '200', 'message' => 'Product Updated', 'result' => array('product' => $product)],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $options = ['force' => true]; // Set force option true for delete permanently. Default value false
            $product = Product::delete($id, $options);
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Product Deleted', 'result' => array('product' => [])],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
    }
}
