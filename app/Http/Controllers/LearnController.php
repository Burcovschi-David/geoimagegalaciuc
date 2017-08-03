<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  CustomHelperss;
use App\LearnModel;


class LearnController extends Controller
{
    function learnInsert(Request $request){
    	//return var_dump($request->file("pictures"));
    	if($request->file('pictures')){
    		foreach($request->file('pictures') as $picture){
    			if(!empty($picture)){
    				$destinationPath = 'pictures/';
    				$filename = rand(1000,9999999999)."-".$picture->getClientOriginalName();
    				$picture->move($destinationPath, $filename);
    				$colorsImage=CustomHelpers::getRGBImage(public_path()."/pictures/".$filename);
    				
					//echo var_dump($colorsImage);  				
    				
    				LearnModel::insertLearn($request->input("latitude"),$request->input("longitude"),$filename,$colorsImage["red"],1,$request->input("acurracy"));
    				LearnModel::insertLearn($request->input("latitude"),$request->input("longitude"),$filename,$colorsImage["green"],2,$request->input("acurracy"));
    				LearnModel::insertLearn($request->input("latitude"),$request->input("longitude"),$filename,$colorsImage["blue"],4,$request->input("acurracy"));
    			}
    		}
    	}
    	
    }
}
