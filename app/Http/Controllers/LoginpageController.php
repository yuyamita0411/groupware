<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginpageRequest;

use Validator;

use Illuminate\Support\Facades\DB;

class LoginpageController extends Controller
{
    //
    public function __construct(){
    }

    public function index(Request $request){
    	$setdata = $request->session()->get('msg');
    	return view('mypage.login', ['session_data' => $setdata]);
    }

    public function formmethod(LoginpageRequest $request){
        $msg = $request->input;
        $request->session()->put('msg', $msg);

        if(!$request){
    		return redirect('/login')
    		->withErrors($request)
    		->withInput();        	
        }else{
            if(empty($_COOKIE['username'])){
                setcookie('username', $_POST['username'], time()+60*60*24*14);
                return redirect('/mypage?username='.$_POST['username']);
            }
        }
        return view('mypage.login');
    }
}