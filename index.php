<html lang="en">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link href="./styles.css" rel="stylesheet">
</head>
	<body>
		<div id="map-canvas"></div>
		<div>
			
			<input type="button" value="Encode" onclick="geocodeFarms(function(latlng) {
				return latlng;
			});">
		</div>
		<div class="footer">
			<p>&copy;<?php echo date('Y'); ?> Aaron Bini</p>
			<a href="#top">Back to top &raquo;</a>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg-HUqHhznjp_zNNOgERRwm_ONHtJvCD4"></script>
		<script type="text/javascript">
			
			var allOregonFarms = (function () {
				var allOregonFarms = null;
				$.ajax({
					'async': false,
					'global': false,
					'url': 'allFarms.json',
					'dataType': "json",
					'success': function (data) {
						allOregonFarms = data;
					}
				});
				return allOregonFarms;
			})();
			
			var map;
			
			function load() {
				map = new google.maps.Map(document.getElementById('map-canvas'), {
					center: new google.maps.LatLng(45.5424, -122.6544),
					zoom: 9,
					mapTypeId: 'roadmap',
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
				});
			};
			
			var geocoder;
			/* function initialize () {
				geocoder = new google.maps.Geocoder();
				//var address = '"' + allOregonFarms[i].address + ', ' + allOregonFarms[i].city + '"';
				geocodeFarms(function(latlng) {
					console.log(latlng);
				});
			}; */
			
			var farmLatLngs = [];
			function geocodeFarms(callback) {
				geocoder = new google.maps.Geocoder();
				//var address = '"' + allOregonFarms[i].address + ', ' + allOregonFarms[i].city + '"';
				for (var i = 0; i <= 10; i++) {
					geocoder.geocode({'address': '"' + allOregonFarms[i].address + ', ' + allOregonFarms[i].city + '"'}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							//farmLatLngs[i] = results[0].geometry.location;
							//console.log(farmLatLngs);
							var newElement = {};
							newElement['name'] = allOregonFarms[i]['name'];
							newElement['lat'] = results[0].geometry.location.lat();
							newElement['lng'] = results[0].geometry.location.lng();
							allOregonFarms[i].lat = results[0].geometry.location.lat();
							allOregonFarms[i].lng = results[0].geometry.location.lng();
							farmLatLngs.push(newElement);
							console.log("farmLatLngs: " + farmLatLngs);
							//map.setCenter(results[0].geometry.location);
							//var marker = new google.maps.Marker({
							//	map: map,
							//	position: results[0].geometry.location
							//});
							callback(farmLatLngs);
							return farmLatLngs;
							
						} else {
							console.log("Geocode was not successful for the following reason: " + status);
						}
					});
					//console.log(farmLatLngs);
					//return farmLatLngs;
				};
				//console.log(farmLatLngs);
				//return farmLatLngs;
			}
			
			google.maps.event.addDomListener(window, 'load', load);
			
		</script>
		
	</body>
	
</html>

