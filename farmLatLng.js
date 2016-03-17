'use strict';

var key = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCg-HUqHhznjp_zNNOgERRwm_ONHtJvCD4"
var fs = require('fs');
var allOregonFarms;

fs.readFile('./farms/allFarms.json', 'utf8', function (err, data) {
	if (err) throw err;
	allOregonFarms = JSON.parse(data);
	var latlng = allOregonFarms[0].address + ", " + allOregonFarms[0].city
	console.log(allOregonFarms[0]);
	console.log(latlng);
});

/*
function codeAddress(farmData) {
	var address;
	var geocoder = new google.maps.Geocoder();
	for (i = 0; i < farmData.length; i++) {
		var latlng = geocoder.geocode(farmData[i].address + ", " + farmData[i].city);
		
		farmData[i].coordinates = latlng.location.geometry;
		console.log(farmData[i].coordinates);
		
	}
}

codeAddress(allOregonFarms);

*/



