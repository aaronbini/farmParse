(function(module){
  var mapInit = {};

  mapInit.allOregonFarms = (function () {
    var jsonFarms = null;
    $.ajax({
      'async': false,
      'global': false,
      'url': 'allFarms.json',
      'dataType': 'json',
      'success': function (data) {
        jsonFarms = data;
      }
    });
    return jsonFarms;
  })();

  var map;
  mapInit.load = function () {
    map = new google.maps.Map(document.getElementById('map-canvas'), {
      // center: new google.maps.LatLng(45.5424, -122.6544),
      center: new google.maps.LatLng(44.810579, -117.97523699999999),
      zoom: 9,
      mapTypeId: 'roadmap',
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });
  };

  mapInit.geocodeFarms = function (farms) {
    var geocoder = new google.maps.Geocoder();
    var geocodePromises = farms.map(function(farm, index) {
      if (index < 10) {
        //add if check here for address, and if no address
        //geocode county if possible, or city
        var address = farm.address + ', ' + farm.city;
        return new Promise(function(resolve, reject) {
          window.setTimeout(function() {
            geocoder.geocode({'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                console.log(results[0]);
                resolve(results[0]);
              } else {
                farm.geometry = {};
                farm.geometry.location = {lat: 45.5424, lng: -122.6544};
                console.log(status);
                resolve(farm);
              }
            });
          }, 1100 + (1050 * index));
        });
      }
    });
    return Promise.all(geocodePromises);
  };

  //to seed database, run above code after GET request to database
  //if GET all farms request length is 0, run the geocoding and POST all the farms
  //to the database, else do nothing

  google.maps.event.addDomListener(window, 'mapInit.load', mapInit.load);
  mapInit.load();

  // $('#geocode').on('click', function (e) {
  //   e.preventDefault();
  mapInit.geocodeFarms(mapInit.allOregonFarms)
    .then(function(geocoded) {
      for (var i = 0; i < 10; i++) {
        new google.maps.Marker({
          map: map,
          position: geocoded[i].geometry.location
        });
      }
    })
    .catch(function(err){
      console.log(err);
    });
  // });

  module.mapInit = mapInit;
})(window);
