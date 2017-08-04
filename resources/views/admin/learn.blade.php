<style>
#map_canvas {
	width: 100%;
	height: 400px;
}
</style>
<script src="{{URL::asset('design/admin/js/jquery.js')}}"></script>
<script>
		
		function getMobileOperatingSystem() {
  			var userAgent = navigator.userAgent || navigator.vendor || window.opera;

      		// Windows Phone must come first because its UA also contains "Android"
    		if (/windows phone/i.test(userAgent)) {
        		return "Windows Phone";
    		}

    		if (/android/i.test(userAgent)) {
        		return "Android";
    		}

    		// iOS detection from: http://stackoverflow.com/a/9039885/177710
    		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        		return "iOS";
    		}

    		return "unknown";
		}
		
		$(function($) {

			
		
    	// Asynchronously Load the map API
    	var script = document.createElement('script');
    		script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyBTsn5gxb-HtKUyo-zEaE_Z1esQN5NF2eY&sensor=false&callback=initialize";
    		document.body.appendChild(script);
		});

		function initialize() {
    		var map;
    		var bounds = new google.maps.LatLngBounds();
    		var mapOptions = {
        		mapTypeId: 'roadmap',
        		disableDoubleClickZoom: true,
        		center: new google.maps.LatLng({lat:45.9241697,lng:26.6481328}),
        		zoom: 17,
        		minZoom: 1,
        		
    		};

    		// Display a map on the page
    		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    		//map.setTilt(0);
			var myLatLng = {lat:45.9241697,lng:26.6481328};
			var markers = [];
			var marker = new google.maps.Marker({
  	          position: myLatLng,
  	          map: map,
  	          animation: google.maps.Animation.DROP
  	        });
	        markers.push(marker);

	        $('#latitude').val(45.9241697);
       		$('#longitude').val(26.6481328);
    		//Double click trigger
    		google.maps.event.addListener(map, "dblclick", function (e) { 
        		var myLatLng = {lat: e.latLng.lat(), lng: e.latLng.lng()};
        		removeMarkers();
        		var marker = new google.maps.Marker({
        	          position: myLatLng,
        	          map: map,
        	          animation: google.maps.Animation.DROP
        	        });
    	        markers.push(marker);
           		//console.log(e.latLng.lat()); 
           		//alert("Ai selectat punctul: Latitudine: "+e.latLng.lat()+" / Longitudine: "+e.latLng.lng());
           		$('#latitude').val(e.latLng.lat());
           		$('#longitude').val(e.latLng.lng());
           		

           		//alert("Ai selectat punctul: Latitudine: "+$('#lat').val()+" / Longitudine: "+$('#long').val());
        	});

			function removeMarkers(){
				for(i=0; i<markers.length; i++){
			        markers[i].setMap(null);
			    }
			}
    		
    		// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    		var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        		this.setZoom(17);
        		google.maps.event.removeListener(boundsListener);
    		});

    		

		}

		
		</script>

@include("admin.head")
<div class="row">
	<div class="col-md-7 align-div-center" >
		<h1 class="center-text">Input please pictures and choose location where they were made:</h1>
		<form action="/admin/learn" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}"> 
			<input class="form-control" type="text" value="0" id="latitude" name="latitude"><br> 
			<input class="form-control" type="text" value="0" id="longitude" name="longitude"> <br>
			<input class="form-control" type="number" placeholder="Enter please acurracy in meters..." class="form-control" min="1" max="20000" step="0.5" required name="acurracy" class="form-control"><br> 
			<input class="form-control" type="file" multiple placeholder="Choose correct pictures for this location...." class="form-control" required name="pictures[]"> <br><br>
			@include("admin.map")<br><br><br>
			<input  type="submit" value="Send data set!" class="btn btn-danger form-control" style="margin-top: 20px; position: relative;">
		</form>
	</div>
</div>
@include("admin.footer")