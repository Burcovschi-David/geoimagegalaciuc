<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class APIModel extends Model {
	static function getCorrectPicturesByLocation($latitude, $longitude) {
		$res_correct_pictures_average_zone = DB::select ( "SELECT *, 
												( 3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) ) 
												* cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians(latitude)) ) ) AS distance 
												FROM d_zones
												ORDER by distance 
												", array () );
		
		$average_red = 0;
		$average_blue = 0;
		$average_green = 0;
		$o = 0;
		foreach ( $res_correct_pictures_average_zone as $corect_average_zone ) {
			if ($corect_average_zone->distance <= 1) {
				// Select values for every colour and make average for them
				$res_correct_red = DB::select ( "SELECT *FROM d_values_zones_pictures WHERE id_zone=? AND id_value=?", array (
						$corect_average_zone->id 
				,1) );
				$res_correct_green = DB::select ( "SELECT *FROM d_values_zones_pictures WHERE id_zone=? AND id_value=?", array (
						$corect_average_zone->id 
				,2) );
				$res_correct_blue = DB::select ( "SELECT *FROM d_values_zones_pictures WHERE id_zone=? AND id_value=?", array (
						$corect_average_zone->id 
				,4) );
				
				$SUMRed = 0;
				$SUMGreen = 0;
				$SUMBlue = 0;
				for($i = 0; $i < count ( $res_correct_red ); $i ++) {
					$SUMRed = $SUMRed + $res_correct_red [$i]->value;
				}
				
				for($j = 0; $j < count ( $res_correct_green ); $j ++) {
					$SUMGreen = $SUMGreen + $res_correct_green [$j]->value;
				}
				
				for($k = 0; $k < count ( $res_correct_blue ); $k ++) {
					$SUMBlue = $SUMBlue + $res_correct_blue [$k]->value;
				}
				
				$average_red = $average_red + $SUMRed / $i;
				$average_green = $average_green + $SUMGreen / $j;
				$average_blue = $average_blue + $SUMBlue / $k;
				
				$o ++;
			}
		}
		
		$average_red = $average_red / $o;
		$average_green = $average_green / $o;
		$average_blue = $average_blue / $o;
		
		return [ 
				$average_red,
				$average_green,
				$average_blue 
		];
	}
}
