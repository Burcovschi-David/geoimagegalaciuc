<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CustomHelpers;
use DB;
use Illuminate\Http\Request;

use App\APIModel;


class ApiController extends Controller {
	function checkPictures(Request $request) {
		if ($request->file ( 'pictures' )) {
			
			$pictures_list=array();
			
			
			foreach ( $request->file ( 'pictures' ) as $picture ) {
				
				
				if (! empty ( $picture )) {
					$destinationPath = 'pictures/';
					$filename = rand(1000,9999999999)."-".$picture->getClientOriginalName();
					$picture->move($destinationPath, $filename);
					
					
					$image = imagecreatefromjpeg(public_path()."/pictures/".$filename);
					
					if($image && imagefilter($image, IMG_FILTER_GRAYSCALE) && imagefilter($image, IMG_FILTER_CONTRAST, -1000))
					{
						
						
						imagejpeg($image, public_path()."/pictures/".$filename);
					}
					else
					{
						echo 'Conversion to grayscale failed.';
					}
					
					$score=0;
					
					$score=APIModel::getCorrectPicturesByLocation(45.9248,26.648,md5_file(public_path () . "/pictures/" . $filename));
					
					//Adaug date despre poza
					array_push($pictures_list,array("image_name"=>public_path () . "/pictures/" . $filename,"score"=>$score));
					
					
					
				}
				
				
			
				
				
			}
		}
		
		return var_dump($pictures_list);
	}
	
	
	
	static function specificColors(){
		return [
				[
						230,
						178,
						129,
						'count_appear' => 0
				],
				[
						192,
						139,
						97,
						'count_appear' => 0
				],
				[
						82,
						44,
						29,
						'count_appear' => 0
				],
				[
						119,
						118,
						99,
						'count_appear' => 0
				],
				[
						237,
						216,
						179,
						'count_appear' => 0
				],
				[
						245,
						240,
						223,
						'count_appear' => 0
				],
				[
						179,
						195,
						205,
						'count_appear' => 0
				],
				[
						55,
						53,
						54,
						'count_appear' => 0
				],
				[
						182,
						154,
						122,
						'count_appear' => 0
				],
				[
						163,
						110,
						70,
						'count_appear' => 0
				],
				[
						237,
						140,
						94,
						'count_appear' => 0
				],
				[
						164,
						179,
						129,
						'count_appear' => 0
				],
				[
						253,
						177,
						201,
						'count_appear' => 0
				],
				[
						74,
						52,
						35,
						'count_appear' => 0
				],
				[
						147,
						137,
						123,
						'count_appear' => 0
				],
				[
						254,
						78,
						48,
						'count_appear' => 0
				],
				[
						74,
						83,
						64,
						'count_appear' => 0
				],
				[
						52,
						82,
						106,
						'count_appear' => 0
				],
				[
						70,
						43,
						28,
						'count_appear' => 0
				],
				[
						215,
						207,
						182,
						'count_appear' => 0
				],
				[
						96,
						99,
						86,
						'count_appear' => 0
				],
				[
						55,
						29,
						18,
						'count_appear' => 0
				],
				[
						168,
						159,
						136,
						'count_appear' => 0
				],
				[
						165,
						182,
						108,
						'count_appear' => 0
				],
				[
						35,
						63,
						92,
						'count_appear' => 0
				],
				[
						104,
						92,
						81,
						'count_appear' => 0
				],
				[
						206,
						107,
						97,
						'count_appear' => 0
				],
				[
						191,
						99,
						138,
						'count_appear' => 0
				],
				[
						254,
						220,
						171,
						'count_appear' => 0
				],
				[
						186,
						70,
						71,
						'count_appear' => 0
				],
				[
						38,
						67,
						55,
						'count_appear' => 0
				],
				[
						189,
						144,
						105,
						'count_appear' => 0
				],
				[
						216,
						188,
						157,
						'count_appear' => 0
				],
				[
						134,
						60,
						57,
						'count_appear' => 0
				],
				[
						80,
						39,
						40,
						'count_appear' => 0
				],
				[
						136,
						114,
						86,
						'count_appear' => 0
				],
				[
						226,
						157,
						45,
						'count_appear' => 0
				],
				[
						153,
						141,
						132,
						'count_appear' => 0
				],
				[
						252,
						183,
						247,
						'count_appear' => 0
				],
				[
						103,
						105,
						99,
						'count_appear' => 0
				],
				[
						135,
						12,
						22,
						'count_appear' => 0
				],
				[
						59,
						65,
						65,
						'count_appear' => 0
				],
				[
						87,
						192,
						248,
						'count_appear' => 0
				],
				[
						206,
						148,
						135,
						'count_appear' => 0
				],
				[
						235,
						222,
						203,
						'count_appear' => 0
				],
				[
						95,
						131,
						145,
						'count_appear' => 0
				],
				[
						26,
						47,
						89,
						'count_appear' => 0
				],
				[
						102,
						108,
						95,
						'count_appear' => 0
				],
				[
						93,
						105,
						129,
						'count_appear' => 0
				],
				[
						141,
						155,
						144,
						'count_appear' => 0
				],
				[
						211,
						201,
						134,
						'count_appear' => 0
				],
				[
						208,
						175,
						135,
						'count_appear' => 0
				]
		];
	}
}
