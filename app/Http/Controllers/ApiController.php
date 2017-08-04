<?php

namespace App\Http\Controllers;


use DB;
use App\Http\Controllers\CustomHelpers;
use Illuminate\Http\Request;
use App\APIModel;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use Jenssegers\ImageHash\ImageHash;

class ApiController extends Controller {
	function checkPictures(Request $request) {
		if ($request->file ( 'pictures' )) {
			
			$pictures_list = array ();
			
			$suma_scor = 0;
			foreach ( $request->file ( 'pictures' ) as $picture ) {
				
				if (! empty ( $picture )) {
					$destinationPath = 'pictures/client/';
					$filename = rand ( 1000, 9999999999 ) . "-" . $picture->getClientOriginalName ();
					$picture->move ( $destinationPath, $filename );
					
					$score = 0;
					$locatie_meta=CustomHelpers::getImageLocationByMeta(public_path () . "/pictures/client/" . $filename);
					
					
					if ($locatie_meta === false) {
						$implementation = new DifferenceHash ();
						$hasher = new ImageHash ( $implementation );
						$hash = $hasher->hash ( public_path () . "/pictures/client/" . $filename );
						
						$res = DB::select ( "SELECT *FROM d_values_zones_pictures" );
						foreach ( $res as $row ) {
							similar_text ( $hash, $row->value, $score2 );
							if ($score2 > $score) {
								$score = $score2;
							}
						}
						
						// Adaug date despre poza
						array_push ( $pictures_list, array (
								"image_name" => public_path () . "/pictures/input/" . $filename,
								"score" => $score 
						) );
						if ($score <= 50) {
							$score = $score - $score / 1.5;
						} else if ($score < 65 && $score > 50) {
							$score = $score + 30;
						}
						$suma_scor = $suma_scor + $score;
						echo public_path () . "/pictures/input/" . $filename.": ".($score) . "<br>";
					} else {
						
						$score = $locatie_meta;
						$suma_scor = $suma_scor + $score;
						echo public_path () . "/pictures/input/" . $filename.": ".($score) . "<br>";
					}
				}
			}
		}
		
		echo"<br><br>Scor general: $suma_scor";
	}
}
