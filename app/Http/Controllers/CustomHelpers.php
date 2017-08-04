<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomHelpers extends Controller
{
	/***************Functions for converting from DMS to DEC and reverse***************************/
	/***************Functions getted from here https://www.web-max.ca/PHP/misc_6.php***************/
	/***************Converts DMS ( Degrees / minutes / seconds )***********************************/
	/************** to decimal format longitude / latitude*****************************************/
	static function DMStoDEC($deg,$min,$sec){
		$deg=intval($deg);
		$min=intval($min);
		$sec=intval($sec);
		
		
		
		return $deg+((($min*60)+($sec))/3600);
	}
	
	
	
	/***************Converts decimal longitude / latitude to DMS***********************************/
	/***************( Degrees / minutes / seconds )************************************************/
	static function DECtoDMS($dec){
		
		// This is the piece of code which may appear to
		// be inefficient, but to avoid issues with floating
		// point math we extract the integer part and the float
		// part by using a string function.
		
		$vars = explode(".",$dec);
		$deg = $vars[0];
		$tempma = "0.".$vars[1];
		
		$tempma = $tempma * 3600;
		$min = floor($tempma / 60);
		$sec = $tempma - ($min*60);
		
		return array("deg"=>$deg,"min"=>$min,"sec"=>$sec);
	}
	/**************END converting from DMS to DEC and reverse*************************************/
	
	
	
	
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	/*::                                                                         :*/
	/*::  This routine calculates the distance between two points (given the     :*/
	/*::  latitude/longitude of those points). It is being used to calculate     :*/
	/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
	/*::                                                                         :*/
	/*::  Definitions:                                                           :*/
	/*::    South latitudes are negative, east longitudes are positive           :*/
	/*::                                                                         :*/
	/*::  Passed to function:                                                    :*/
	/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
	/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
	/*::    unit = the unit you desire for results                               :*/
	/*::           where: 'M' is statute miles (default)                         :*/
	/*::                  'K' is kilometers                                      :*/
	/*::                  'N' is nautical miles                                  :*/
	/*::  Worldwide cities and other features databases with latitude longitude  :*/
	/*::  are available at http://www.geodatasource.com                          :*/
	/*::                                                                         :*/
	/*::  For enquiries, please contact sales@geodatasource.com                  :*/
	/*::                                                                         :*/
	/*::  Official Web site: http://www.geodatasource.com                        :*/
	/*::                                                                         :*/
	/*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
	/*::                                                                         :*/
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	static function distance ($lat1, $lng1, $lat2, $lng2) {
		
		$earthRadius = 3958.75;
		
		$dLat = deg2rad($lat2-$lat1);
		$dLng = deg2rad($lng2-$lng1);
		
		
		$a = sin($dLat/2) * sin($dLat/2) +
		cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
		sin($dLng/2) * sin($dLng/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$dist = $earthRadius * $c;
		
		// from miles
		$meterConversion = 1609;
		$geopointDistance = $dist * $meterConversion;
		
		return $geopointDistance;
	}
	/********************END function for calculate distance between 2 points**********************/
	
	
	
	/*******************Functions built by Burcovschi David***************************************/
	/******************Function to get image location byy metas***********************************/
	static function getImageLocationByMeta($folder,$extension,$limit=0,$lat_cerut,$lon_cerut){
		
		$i=0;//Number of current parsed pictures
		
		$array_poze=array();
		
		foreach(glob("{$folder}/*.{$extension}") as $filename){
			
			$name = substr($filename, strrpos($filename, '/') + 1);
			
			// Read metadata of image
			$headers = exif_read_data($filename,"EXIF");
			
			//If there are  headers with location
			
			if(isset($headers["GPSLatitude"]) && isset($headers["GPSLongitude"])){
				
				//Convert GPS degrees to decimal
				$latitude=DMStoDEC(explode("/",$headers["GPSLatitude"][0])[0],explode("/",$headers["GPSLatitude"][1])[0],explode("/",$headers["GPSLatitude"][2])[0]);
				$longitude=DMStoDEC(explode("/",$headers["GPSLongitude"][0])[0],explode("/",$headers["GPSLongitude"][1])[0],explode("/",$headers["GPSLongitude"][2])[0]);
				
				//Get location name
				$locatie=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=AIzaSyBTsn5gxb-HtKUyo-zEaE_Z1esQN5NF2eY"),true)["results"][0]["formatted_address"];
				//This coordinates should be by google for Galaciuc: 45.9241697,26.6481328
				
				//Get distance from current distance to point where picture were taken
				$distanta_curent=distance($lat_cerut, $lon_cerut, $latitude, $longitude);
				
				//Add picture in list with data getted
				array_push($array_poze,array("nume"=>$name,"latitude"=>$latitude,"longitude"=>$longitude,"are_meta"=>1,"locatie"=>$locatie,"distanta_current"=>$distanta_curent));
			}else{
				//Add picture in list with data getted
				array_push($array_poze,array("nume"=>$name,"latitude"=>-1999,"longitude"=>-1999,"are_meta"=>0));
			}
			
			
			$i++;
			
			//If limit==0 so i don't have any limit and limit == with current pictured parsed
			if($i==$limit && $limit!=0){
				break;//Stop
			}
			
			
		}
		//Return list of pictures
		return $array_poze;
	}
	
	/*******************END functions built by Burcovschi David****************************************/
	
	
	
	/*********Function for getting RGB color of a image*****************/
	/************Source: *************************/
	static function getRGBImage($path){
		$image = imagecreatefromjpeg($path); // imagecreatefromjpeg/png/
		
		$width = imagesx($image);
		$height = imagesy($image);
		
		$colors = array("red"=>0,"green"=>0,"blue"=>0);
		
		for ($y = 0; $y < $height-1; $y=$y+3) {
			$y_array = array() ;
			
			for ($x = 0; $x < $width-1; $x=$x+3) {
				$rgb = imagecolorat($image, $x, $y);
				
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				
				
				$x_array = array($r, $g, $b) ;
				
				
				$colors["red"]=$colors["red"]+$r;
				$colors["green"]=$colors["green"]+$g;
				$colors["blue"]=$colors["blue"]+$b;
			}
			
			
		}
		
		$colors["red"]=$colors["red"]/($height/3*$width/3);
		$colors["green"]=$colors["green"]/($height/3*$width/3);
		$colors["blue"]=$colors["blue"]/($height/3*$width/3);
		
		return $colors;
	}
	
	/*********Function for getting RGB color of a image*****************/
	/************Source: *************************/
	static function hashOfPicture($path){
		return md5_file ( $path);
	}
	
	static function similarityOf2Files($path1,$path2){
		$hash1=md5_file($path1);
		$hash2=md5_file($path2);
		similar_text ( $hash1 ,$hash2 ,$percent );
		return $percent;
	}
}
