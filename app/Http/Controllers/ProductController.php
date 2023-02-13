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
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'price'=>'required',
            'product_image' => 'mimes:jpeg,bmp,png,jpg'
        ]);

        if ($request->has('product_image')) {

            $imageName = time().'.'.$request->product_image->extension();

            $image_path = $request->file('product_image')->store('images', 'public');

            return Product::create([
                "title" => $request->title,
                "description" => $request->description,
                "price" => $request->price,
                "product_image" => $image_path
            ]);

        }else {
            return Product::create([
                "title" => $request->title,
                "description" => $request->description,
                "price" => $request->price,
            ]);
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
        return Product::find($id);
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
        $request->validate([
            'title'=>'required',
            'price'=>'required',
            'product_image' => 'mimes:jpeg,bmp,png,jpg'
        ]);

        $product = Product::find($id);

        if ($request->has('product_image')) {

            $imageName = time().'.'.$request->product_image->extension();

            $image_path = $request->file('product_image')->store('images', 'public');

            $product->update([
                "title" => $request->title,
                "description" => $request->description,
                "price" => $request->price,
                "product_image" => $image_path
            ]);

        }else {
            $product->update([
                "title" => $request->title,
                "description" => $request->description,
                "price" => $request->price,
            ]);
        }     
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * Search for a title.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Product::where('title','like','%'.$title.'%')->get();
    }
}
