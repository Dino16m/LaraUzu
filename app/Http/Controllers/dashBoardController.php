<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use DB;

class dashBoardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	 $user = null;
	 $user= $this::getdetails($request);
	 if ($user){
	 return view('dashboardView')->with(['user'=>$user]);
	 }
	}
		
	
		
  private function getDetails($request){
    if($request->session()->has('email')){
     $email= $request->session()->get('email');
     $user= \App\User::where('email',$email)->first();
     $name = $user->username;
     $number = $user->Number;
     $bio = $user->bio;
     $image =$user->image;
    
    return ['name'=>$name, 'number'=>$number, 'bio'=>$bio, 'image'=>$image];
      
    }
  }

	

}
