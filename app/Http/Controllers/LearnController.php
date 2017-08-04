<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  CustomHelperss;
use App\LearnModel;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use Jenssegers\ImageHash\ImageHash;

class LearnController extends Controller
{
    function learnInsert(Request $request){
    	
    	if($request->file('pictures')){
    		foreach($request->file('pictures') as $picture){
    			if(!empty($picture)){
    				$destinationPath = 'pictures/input/';
    				$filename = rand(1000,9999999999)."-".$picture->getClientOriginalName();
    				$picture->move($destinationPath, $filename);
    				
    				$implementation = new DifferenceHash;
    				$hasher = new ImageHash($implementation);
    				$hash = $hasher->hash(public_path()."/pictures/input/".$filename);
    				
    				
    				LearnModel::insertLearn($request->input("latitude"),$request->input("longitude"),$filename,$hash,5,$request->input("acurracy"));
    				
    			}
    		}
    	}
    	
    }
}
