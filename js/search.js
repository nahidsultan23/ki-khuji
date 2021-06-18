// Places library is required. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initMap(){
	
	var preLat = document.getElementById('preLat').value;
	var preLong = document.getElementById('preLong').value;
	
	var map = new google.maps.Map(document.getElementById('map'),{
		center: new google.maps.LatLng(preLat,preLong),
		zoom: 13,
		gestureHandling: 'greedy'
	});
	
	var input = document.getElementById('pac-input');
	var autocomplete = new google.maps.places.Autocomplete(input);

// Set the data fields to return when the user selects a place.
	autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

	var infowindow = new google.maps.InfoWindow();
	var infowindowContent = document.getElementById('infowindow-content');
	infowindow.setContent(infowindowContent);
	var marker = new google.maps.Marker({
		map: map,
		draggable: true,
		animation: google.maps.Animation.DROP,
		position: new google.maps.LatLng(preLat,preLong)
	});
		
	marker.addListener('click', toggleBounce);
			
	google.maps.event.addListener(marker, 'dragend', function (event) {
		var latitude = event.latLng.lat();
		var longitude = event.latLng.lng();
				  
		document.getElementById('latitude').value = latitude;
		document.getElementById('longitude').value = longitude;
				  
		GetAddress(latitude, longitude);
	});

	autocomplete.addListener('place_changed',function(){
		infowindow.close();
		marker.setVisible(false);
		var place = autocomplete.getPlace();
		if(!place.geometry){
			return;
		}
		  
		var lati = place.geometry.location.lat();
		var longi = place.geometry.location.lng();
		  
		document.getElementById('latitude').value = lati;
		document.getElementById('longitude').value = longi;
		  
		GetAddress(lati, longi);

// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		}
		else {
			map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
		}
		marker.setPosition(place.geometry.location);
		marker.setVisible(true);
	});
	
	addYourLocationButton(map, marker);
}
	  
function toggleBounce() {
	if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	}
	else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}
		  
function GetAddress(lat, lng) {
			  
	var latlng = new google.maps.LatLng(lat, lng);
	var geocoder = geocoder = new google.maps.Geocoder();
			  
	geocoder.geocode({ 'latLng': latlng }, function (results, status) {
				
		if (status == google.maps.GeocoderStatus.OK) {
						
			if (results[1]) {
				document.getElementById('current-place').value = results[1].formatted_address;
			}
			else{
				document.getElementById('current-place').value = 'No address found';
			}
						
		}
		else{
			
			document.getElementById('current-place').value = 'No address found';
			
		}
				
	});
			  
}

function addYourLocationButton(map,marker){
	
	var controlDiv = document.createElement('div');
	
	var firstChild = document.createElement('button');
	firstChild.style.backgroundColor = '#fff';
	firstChild.style.border = 'none';
	firstChild.style.outline = 'none';
	firstChild.style.width = '28px';
	firstChild.style.height = '28px';
	firstChild.style.borderRadius = '2px';
	firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
	firstChild.style.cursor = 'pointer';
	firstChild.style.marginRight = '10px';
	firstChild.style.padding = '0px';
	firstChild.title = 'Your Location';
	controlDiv.appendChild(firstChild);
	
	var secondChild = document.createElement('div');
	secondChild.style.margin = '5px';
	secondChild.style.width = '18px';
	secondChild.style.height = '18px';
	secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
	secondChild.style.backgroundSize = '180px 18px';
	secondChild.style.backgroundPosition = '0px 0px';
	secondChild.style.backgroundRepeat = 'no-repeat';
	secondChild.id = 'you_location_img';
	firstChild.appendChild(secondChild);
	
	google.maps.event.addListener(map, 'dragend', function() {
		$('#you_location_img').css('background-position', '0px 0px');
	});
	
	firstChild.addEventListener('click', function() {
		var imgX = '0';
		var animationInterval = setInterval(function(){
			if(imgX == '-18') imgX = '0';
			else imgX = '-18';
			$('#you_location_img').css('background-position', imgX+'px 0px');
		}, 500);
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				marker.setPosition(latlng);
				map.setCenter(latlng);
				clearInterval(animationInterval);
				$('#you_location_img').css('background-position', '-144px 0px');
				
				var currentLat = latlng.lat();
				var currentLong = latlng.lng();
				
				document.getElementById('latitude').value = currentLat;
				document.getElementById('longitude').value = currentLong;
						  
				GetAddress(currentLat, currentLong);
			});
		}
		else{
			clearInterval(animationInterval);
			$('#you_location_img').css('background-position', '0px 0px');
		}
	});
	
	controlDiv.index = 1;
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
	
}