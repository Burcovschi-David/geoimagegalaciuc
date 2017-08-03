<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AdminController;
use DB;

class LearnModel extends Model {
	static function insertLearn($latitude, $longitude, $picture, $value, $id_value, $precision) {
		$locatie = json_decode ( file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=AIzaSyBTsn5gxb-HtKUyo-zEaE_Z1esQN5NF2eY" ), true ) ["results"] [0] ["formatted_address"];
		if (count ( DB::select ( "SELECT *FROM d_zones WHERE latitude=? AND longitude=?", array (
				$latitude,
				$longitude 
		) ) ) == 0) {
			DB::insert ( "INSERT INTO d_zones(latitude,longitude,name)VALUES(?,?,?)", array (
					$latitude,
					$longitude,
					$locatie 
			
			) );
			$last_location_id_inserted = DB::select ( "SELECT *FROM d_zones ORDER BY id DESC LIMIT 1" ) [0]->id;
		} else {
			$last_location_id_inserted = DB::select ( "SELECT *FROM d_zones WHERE latitude=? AND longitude=?", array (
					$latitude,
					$longitude 
			) ) [0]->id;
		}
		
		if (count ( DB::select ( "SELECT *FROM d_pictures WHERE path=?", array (
				$picture 
		) ) ) == 0) {
			DB::insert ( "INSERT INTO d_pictures(path)VALUES(?)", array (
					$picture 
			) );
			$last_picture_id_inserted = DB::select ( "SELECT *FROM d_pictures ORDER BY id DESC LIMIT 1" ) [0]->id;
		} else {
			$last_picture_id_inserted = DB::select ( "SELECT *FROM d_pictures WHERE path=?", array (
					$picture 
			) ) [0]->id;
		}
		
		DB::insert ( "INSERT INTO d_values_zones_pictures(id_zone,id_value,id_picture,value,aprox)VALUES(?,?,?,?,?)", array (
				$last_location_id_inserted,
				$id_value,
				$last_picture_id_inserted,
				$value,
				$precision 
		) );
	}
}
