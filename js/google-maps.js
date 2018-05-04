function googleMaps(deplat,deplng,destlat,destlng) {		
	
	if(jQuery('#map-route').length) {			
		
		var mapOptions = {
			zoom: 10,
			scrollwheel: false,
			center: new google.maps.LatLng(39.405494,-75.675546), //TOWNSEND
		};
		var mapElement = document.getElementById('map-route');
		var map = new google.maps.Map(mapElement, mapOptions);
		var directionsService = new google.maps.DirectionsService();
		var directionsDisplay = new google.maps.DirectionsRenderer();
		directionsDisplay.setMap(map);
		
		calcRoute();
		function calcRoute() {
			var start = new google.maps.LatLng(deplat,deplng);
			var end = new google.maps.LatLng(destlat,destlng);
			var request = {
				origin: start,
				destination: end,
				travelMode: 'DRIVING'
			};
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				} else {
					alert("Directions Request from failed: " + status);
				}
			});
		}
	}
	
}