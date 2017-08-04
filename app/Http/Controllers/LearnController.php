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
    				
    				
    				// Load
    				list($width, $height) = getimagesize(public_path()."/pictures/".$filename);
    				$thumb = imagecreatetruecolor(64, 64);
    				$image = imagecreatefromjpeg(public_path()."/pictures/".$filename);
    				// Resize
    				imagecopyresized($thumb, $image, 0, 0, 0, 0, 16, 16, $width, $height);
    				
    				if($thumb && imagefilter($thumb, IMG_FILTER_GRAYSCALE) && imagefilter($thumb, IMG_FILTER_CONTRAST, -1000))
    				{
    					
    					
    					imagejpeg($thumb, public_path()."/pictures/".$filename);
    				}
    				else
    				{
    					echo 'Conversion to grayscale failed.';
    				}
    				
    				$hash=CustomHelpers::hashOfPicture(public_path()."/pictures/".$filename);
    				
									
    				
    				LearnModel::insertLearn($request->input("latitude"),$request->input("longitude"),$filename,$hash,5,$request->input("acurracy"));
    				if(!unlink(public_path()."/pictures/".$filename)){
    					echo "Nu am putut sterge imaginea!";
    				}
    			}
    		}
    	}
    	
    }
}
