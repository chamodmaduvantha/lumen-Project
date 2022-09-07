<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get - all data from database
        $product = Product::all();
        return response()->json($product);
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
        //POST data to database from user

        //validate
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'
        ]);
        $product = new Product();


        //image data

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention=['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention,$allowedfileExtention);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }
        }


        //text data
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // give 1 item for products table
        $product = Product::find($id);
        return response()->json($product);
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
        //update - ID

        //validate
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'
        ]);

        $product = Product::find($id);


        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention=['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention,$allowedfileExtention);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete - ID
        $product = Product::find($id);
        $product->delete();
        return response()->json("Product deleted successfully!");
    }
}
