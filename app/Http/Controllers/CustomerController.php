<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
    	$customers = Customer::orderBy('customer_id', 'DESC')->get();
    	return view('customer.index')
    	->with('customers', $customers)
    	;
    }

    // Save record to customer table
    public function submit(Request $req)
    {
    	$req->validate([
    		"name" => "required",
    		"email" => "required|unique:customers",
    		"phone" =>"required|integer",
    	]);

    	$customer = new Customer();
    	$customer->name = $req->name;
    	$customer->email = $req->email;
    	$customer->phone = $req->phone;
    	
    	if($customer->save())
    	{
    		$req->session()->flash('success', 'Customers has been added successfully');
    		return response()->json(['response'=>'true']);
    	}
    }

    // Update Customers
    public function update(Request $req)
    {
    	$req->validate([
    		"name" => "required",
    		"email" => "required",
    		"phone" =>"required|integer",
    	]);

    	$customer = Customer::where(["customer_id"=>$req->customer_id])->update([
    		"name" => $req->name,
    		"email" =>$req->email,
    		"phone" =>$req->phone,
    	]);

    	if($customer)
    	{
    		$req->session()->flash('success', 'Customers has been updated successfully');
    		return response()->json(['response'=>'true']);
    	}
    }

    public function delete($id)
    {
    	$customer = Customer::where(['customer_id'=>$id])->delete();
    	if($customer)
    	{
    		session()->flash('success', 'Customers has been deleted successfully');
    		return redirect()->route('customers');
    	}
    }

}