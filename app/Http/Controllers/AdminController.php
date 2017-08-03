<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request;
use App\Models\LearnModel;

class AdminController extends Controller
{
    function login(Request $request){
    	if(!LearnModel::loginUser($username,$password)){
    		return redirect("/login");
    	}else{
    		return redirect("/learn");
    	}
    }
    
    static function isLogged(){
    	if(session_id()==""){
    		session_start();
    	}
    	
    	if(!isset($_SESSION['ok'])){
    		redirect("/login");
    	}
    	
    	if($_SESSION['ok']!=1 || !isset($_SESSION['username'])){
    		redirect("/login");
    	}
    }
}
