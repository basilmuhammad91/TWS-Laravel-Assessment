<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductSale;
use PDF;

class SaleController extends Controller
{

	public function __construct()
	{
		return $this->middleware('auth');
	}

    public function index()
    {
    	$sales =  Sale::orderBy('sale_id', 'DESC')->get();
    	$customers = Customer::orderBy('customer_id', 'DESC')->get();
    	$products = Product::orderBy('product_id', 'DESC')->get();
    	return view('sale.index')
    	->with('sales', $sales)
    	->with('customers', $customers)
    	->with('products', $products)
    	;
    }

    public function submit(Request $req)
    {
    	$req->validate([
    		"reference" => "required|unique:sales",
    		"customer_id" => "required",
    		"grand_total" => "required"
    	]);
    	$sale = new Sale();
    	$sale->reference = $req->reference;
    	$sale->customer_id = $req->customer_id;
    	$sale->grand_total = $req->grand_total;
    	if($sale->save())
    	{
			foreach ($req->product_id as $key => $value) {
				$product_sale = new ProductSale();
				$product_sale->sale_id = $sale->id;
				$product_sale->product_id = $req->product_id[$key];
				$product_sale->quantity = $req->quantity[$key];
				$product_sale->total = $req->total[$key];
				$product_sale->save();
			}

			$req->session()->flash('success', 'Sales has been added successfully');
			return response()->json(["response"=>"true"]);

    	}
    }

    public function update(Request $req)
    {
    	$sale = Sale::where(['sale_id'=>$req->sale_id])->update([
    		"reference" => $req->reference,
    		"customer_id" => $req->customer_id,
    		"grand_total" => $req->grand_total,
    	]);

    	if($sale)
    	{
    		foreach ($req->product_sale_id as $key => $value) {
				$product_sale = ProductSale::where(['product_sale_id'=>$value])->update([
					"product_id" => $req->product_id[$key],
					"quantity" => $req->quantity[$key],
					"total" => $req->total[$key],
				]);
			}

			$req->session()->flash('success', 'Sales has been updated successfully');
    		return response()->json(["response"=>"true"]);
    	}

    	
    }

    public function get_quantity_by_product_id(Request $req)
    {
    	$products = Product::where(["product_id"=>$req->id])->first();
    	return response()->json(["response"=>$products]);
    }

    public function print_report($id)
    {
		$sales = Sale::where('sale_id', $id)->first();
        
        // return view('sale.report')
        // ->with('sales', $sales)
        // ; 

		 view()
        ->share('sales', $sales)
        ;
        $pdf = PDF::loadView('sale.report');
    
        return $pdf->download('report.pdf');

    }

    public function delete($id)
    {
    	$sale = Sale::where(['sale_id'=>$id])->delete();
    	if($sale)
    	{
    		session()->flash('success', 'Sale has been deleted successfully');
    		return redirect()->route('sales');
    	}
    }

}
