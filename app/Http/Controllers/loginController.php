<?php namespace App\Http\Controllers;

use App\Http\Requests;
use \App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;



use Illuminate\Http\Request;

class loginController extends Controller {

	public function index(){
	  if(auth::check()){
	    echo auth::user()->email;
	    return redirect()->route('dashboard');
	  }
	  else{	return view('login');}
	  
	}
	
	public function login(Request $request) {
	  $credentials= $request->only('email','password');
	  if (auth::attempt($credentials)){
	   $request->session()->put('email',$request->input('email'));
	   return redirect()->route('dashboard');
	    }
	  else{
	    return view('login')->with(['errormsg'=>'one or more of the details you input are wrong']);
	      }
	}
	
	public function logout(Request $request){
	 if(auth::check()){
	  auth::logout();
	  \Session::flush();
	 }
	  return redirect()->action('loginController@index');
	}

}
