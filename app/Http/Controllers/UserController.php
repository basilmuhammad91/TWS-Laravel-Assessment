<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
    	$users = User::orderBy('id', 'DESC')->get();
    	return view('user.index')
    	->with('users', $users)
    	;
    }

    // Save record to product table
    public function submit(Request $req)
    {
    	$req->validate([
    		"name" => "required",
    		"email" => "required",
    		"username" =>"required",
    		"password" =>"required",
    		"avatar" => "required",
    	]);

    	$user = new User();
    	$user->name = $req->name;
		$user->email = $req->email;
		$user->username = $req->username;
		$user->password = Hash::make($req->password);

		if($req->avatar)
		{
			$user->avatar = $req->avatar->store('Images/Users','public');
		}
    	
    	if($user->save())
    	{
    		$req->session()->flash('success', 'User has been added successfully');
    		return response()->json(['response'=>'true']);
    	}
    }

    // Update Products
    public function update(Request $req)
    {
    	// $req->validate([
    	// 	"name" => "required",
    	// 	"email" => "required",
    	// 	"username" =>"required",
    	// 	"password" =>"required",
    	// ]);

    	if($req->avatar)
    	{
    		$user = User::where(["id"=>$req->user_id])->update([
	    		"name" => $req->name,
				"email" => $req->email,
				"username" => $req->username,
				"password" => Hash::make($req->password),
				"avatar" => $req->avatar->store('Images/Users','public')
	    	]);
    	}

    	$user = User::where(["id"=>$req->user_id])->update([
    		"name" => $req->name,
			"email" => $req->email,
			"username" => $req->username,
			"password" => $req->password,
    	]);

    	$req->session()->flash('success', 'User has been updated successfully');
    		return response()->json(['response'=>'true']);
    }

    public function delete($id)
    {
    	$user = User::where(['id'=>$id])->delete();
    	if($user)
    	{
    		session()->flash('success', 'User has been deleted successfully');
    		return redirect()->route('users');
    	}
    }
}
