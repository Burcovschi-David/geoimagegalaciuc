<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class APIModel extends Model {
	static function getCorrectPicturesByLocation($latitude, $longitude,$hash) {
		$res_correct_pictures_average_zone = DB::select ( "SELECT *, 
												( 3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) ) 
												* cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians(latitude)) ) ) AS distance 
												FROM d_zones
												ORDER by distance 
												", array () );
		
		
		$o = 0;
		$average=0;
		foreach ( $res_correct_pictures_average_zone as $corect_average_zone ) {
			if ($corect_average_zone->distance <= 1) {
				
				$res_value=DB::select("SELECT *FROM d_values_zones_pictures WHERE id_zone=? AND id_value=5",array($corect_average_zone->id));
				
				for($i=0;$i<count($res_value);$i++){
					similar_text ( $hash ,$res_value[$i]->value ,$percent );
					if($percent>$average){
						$average=$percent;
					}
					$o ++;
				}
				
			}
		}
		
		
		
		return $average;
	}
}
