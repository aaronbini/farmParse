<html lang="en">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link href="./styles.css" rel="stylesheet">
</head>
	<body>
		<div id="map-canvas"></div>
		<div>
			
			<input type="button" value="Encode" onclick="geocodeFarms(farmAddresses, function (results) {
            return results;
        });">
			<input type="button" value="Push LatLngs" onclick="pushLatLng(allOregonFarms, farmLatLngs);">
		</div>
		<div class="footer">
			<p>&copy;<?php echo date('Y'); ?> Aaron Bini</p>
			<a href="#top">Back to top &raquo;</a>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg-HUqHhznjp_zNNOgERRwm_ONHtJvCD4"></script>
		<script type="text/javascript">
			//onclick calls 
			/* getLatLng(allAddresses, function (results) {
            return results);
        });
		
		<input type="button" value="Encode" onclick="geocodeFarms(function(latlng) {
				return latlng;
			});"> */
			
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
			
			var farmAddresses = [];
			
			function pullAddresses(farmsArray) {
				for (var i = 10; i < 20; i++) {
					var farmAddress = {};
					//farmAddress['name'] = farmsArray[i].name;
					farmAddress = farmsArray[i].address + ', ' + farmsArray[i].city;
					farmAddresses.push(farmAddress);
				}
			}
			
			pullAddresses(allOregonFarms);
			
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
			var farmLatLngs = [];
			
			function geocodeFarms(addresses, callback) {
				addresses.forEach(function(address) {
				
				geocoder = new google.maps.Geocoder();
				//for (var i = 0; i < 10; i++) {
					//var date = Date.now()
						//console.log("waiting...");
						//while(Date.now()-date<500) {
							//do nothing
						//};
						//'address': '"' + allOregonFarms[i].address + ', ' + allOregonFarms[i].city + '"'
					geocoder.geocode({'address': address}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								var farmInfo = {};
								farmInfo['lat'] = results[0].geometry.location.lat();
								farmInfo['lng'] = results[0].geometry.location.lng();
								farmLatLngs.push(farmInfo);
								
								//all addresses have been processed
								//if (farmLatLngs.length === addresses.length)
								
								//map.setCenter(results[0].geometry.location);
								//var marker = new google.maps.Marker({
								//	map: map,
								//	position: results[0].geometry.location
								//});
								callback(farmLatLngs);
								//console.log("farmlatlngs: " + farmLatLngs);
								//return farmLatLngs;
								var date = Date.now();
								console.log("waiting...");
								while(Date.now()-date<500) {
									//do nothing
								};
							} else {
								//may need to push undefined lat lngs for bad addresses
								console.log("Geocode was not successful for the following reason: " + status);
							}
						});
					//};
				});
			}
			
			
			function pushLatLng(farmArray, arrayLatLng) {
				for(var i = 10; i < 20; i++) {
					farmArray[i]['lat'] = arrayLatLng[i]['lat'];
					farmArray[i]['lng'] = arrayLatLng[i]['lng'];
					console.log(farmArray[i]);
				}
			}
			
			google.maps.event.addDomListener(window, 'load', load);
			
		</script>
		
	</body>
	
</html>

