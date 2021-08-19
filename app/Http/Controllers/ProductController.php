<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
    	$products = Product::orderBy('product_id', 'DESC')->get();
    	return view('product.index')
    	->with('products', $products)
    	;
    }

    // Save record to product table
    public function submit(Request $req)
    {
    	$req->validate([
    		"name" => "required",
    		"description" => "required",
    		"retail_price" =>"required",
    		"wholesale_price" =>"required",
    	]);

    	$product = new Product();
    	$product->name = $req->name;
		$product->description = $req->description;
		$product->retail_price = $req->retail_price;
		$product->wholesale_price = $req->wholesale_price;
    	
    	if($product->save())
    	{
    		$req->session()->flash('success', 'Product has been added successfully');
    		return response()->json(['response'=>'true']);
    	}
    }

    // Update Products
    public function update(Request $req)
    {
    	$req->validate([
    		"name" => "required",
    		"description" => "required",
    		"retail_price" =>"required",
    		"wholesale_price" =>"required",
    	]);

    	$product = Product::where(["product_id"=>$req->product_id])->update([
    		"name" => $req->name,
			"description" => $req->description,
			"retail_price" => $req->retail_price,
			"wholesale_price" => $req->wholesale_price,
    	]);

    	if($product)
    	{
    		$req->session()->flash('success', 'Products has been updated successfully');
    		return response()->json(['response'=>'true']);
    	}
    }

    public function delete($id)
    {
    	$product = Product::where(['product_id'=>$id])->delete();
    	if($product)
    	{
    		session()->flash('success', 'Products has been deleted successfully');
    		return redirect()->route('products');
    	}
    }

}
