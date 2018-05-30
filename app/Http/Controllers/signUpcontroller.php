<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class signUpcontroller extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	if ($request->input('tname') and $request->input('email') !=null){
	  if($request->input('password') and  $request->input('password1')!=null){
	    $name= $this::sanitize($request->input('tname'));
	    $email=$request->input(('email'));
	    
	      if (!filter_var($email, FILTER_VALIDATE_EMAIL )){
	      return view('signUp')->with(['errormsg'=> 'the email entered is invalid']);
	      }
	    
	      if ($request->input('password')==$request->input('password1')){
	         $password= $request->input('password');
	         $password= Hash::make($password);
	         }
	   
	      if ($request->input('number')){
	     
	       $number= $request->input('number');
	       }
	    
	      if($this::numExists($number)){
	       return view('signUp')->with(['errormsg'=> 'the number you gave exists already']);
	         }
	      if($this::mailExists($email)){
	      return view('signUp')->with(['errormsg'=>'the email you gave exists in our system already']);
	        }
	   
	        $insert=$this::dbinsert($name, $email, $number, $password );
	    
	       if (!$insert){
	        $errormsg='your data was not added to our system';
	        return view('signUp', compact('errormsg'));
	       }
	         $credentials =['email'=>$email, 'password'=>$request->input('password')];
          if( $this::login($credentials)){
            $request->session()->put('email', $email);
            	return  redirect()->route('dashboard');
                  	}
	 }
  	else{return view('signUp')->with(['errormsg'=>'one or more of the fields are empty']);}
	}
	else{return view('signUp')->with(['errormsg'=>'one or more of the fields are empty']);}
 
	}
	
	private function login($credentials)
 {
  if (auth::attempt($credentials)){
	   echo auth::user()->email . 'shii';
	   return true; }
	 else return redirect()->action('loginController@index');
 }
  private function sanitize($input){
    $input= trim($input);
    $input = stripslashes($input);
    $input= htmlspecialchars($input);
    return $input;
  }
	private function dbinsert($name, $email, $num, $pass){
	 $result= DB::insert('insert into users (username, email, number,password) values(?,?,?,?)', [$name, $email, $num, $pass] );
	
	  if ($result){
	    return true;
	  }
	}
	 private function numExists($num){
	   $user= DB::select('select * from users WHERE number= ?',[$num]);
	   if($user){
	     return true;
	   }
	   else{return false;}
	 }
	private function mailExists($mail){
	   $user= DB::select('select * from users WHERE email= ?',[$mail]);
	   if($user){
	     return true;
	   }
	   else{return false;}
	}
 
 
 
  
}
