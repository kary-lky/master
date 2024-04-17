//Variables that can be reused in this page
var map;
var directionsService = new google.maps.DirectionsService();
var directionsDisplay;
var currentLocation;

$(function() {
    //currentLocation = 
	init();
    loadMap("Hong Kong","Hong Kong airport");
});
//Initialize Map information
function init(){
  var mapOptions = {
  zoom: 0,
  };
  
  directionsDisplay = new google.maps.DirectionsRenderer();
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}


//AJAX call to load the specific map
function loadMap(start,place){
	var url = "/searchMap"; // the url action to handle the form input.
    
	$.ajax({
            type : 'get',
            url : url,
            data:{'query':place,'startPoint':start},
            success:function(data)
            {
                var geoLocationStart = data['hongKongGeocode'];
                var geoLocationDest = data['geocode'];
                console.log(data);
                console.log(geoLocationDest + " " + geoLocationStart)
                // Rest of your code
                var infowindow = new google.maps.InfoWindow({
                    content: "This is a place",
                    maxWidth: 150
                });

                var start_lat_lng = new google.maps.LatLng(geoLocationStart[0], geoLocationStart[1]);
                var dest_lat_lng = new google.maps.LatLng(geoLocationDest[0], geoLocationDest[1]);
                // To add the marker to the map, use the 'map' property
                var startMarker = new google.maps.Marker({
                                                            position: start_lat_lng,
                                                            map: map,
                                                            title: start,
                                                            //icon: "images/bookstore.png"
                                                            });
                
                var dest_marker = new google.maps.Marker({
                    position: dest_lat_lng,
                    map: map,
                    title: place,
                    //icon: 'images/man.png'
                });
                // To add the marker to the map, call setMap();
                startMarker.setMap(map);
                dest_marker.setMap(map);
                //Get the route of walking
                //var selectedMode = "DRIVING";
                var request = {
                    origin: start_lat_lng,
                    destination: dest_lat_lng,
                    // Note that Javascript allows us to access the constant
                    // using square brackets and a string value as its
                    // "property."
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.IMPERIAL
                };
                directionsService.route(request, function(response, status) {
                                        if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(response);
                                        }
                                        });
                
        }
    });
}

function getCurrentLocation(){
    var pos = {};
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
    
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);
        }, function() {});
    } 
    return pos;
}

function getWeather() {
    var destination = $("#destination").val();
    $.ajax({
      type: "POST",
      url: "https://api.openweathermap.org/data/2.5/weather?q=" + destination +
        "&appid=47094a0b172ed978ff86a5b68525ead4&units=metric",
      dataType: "json",
      success: function(result, status, xhr) {
        console.log(result);
        $("#weatherBody").html("City: " + result.name + "<br/>" + "Temperature:" + result.main.temp);
      },
      error: function(xhr, status, error) {
        console.log("Error: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
      }
    });
}


function getAirport() {
  var destination = $("#destination").val();
  if (destination == "") {
      return;
  } else {
      $.ajax({
          url: "https://raw.githubusercontent.com/algolia/datasets/master/airports/airports.json",
          dataType: "json",
          success: function(airports) {
              let fits = airports.filter(function(airport) {
                  const regex = new RegExp('^' + destination, 'gi');
                  return (
                      airport.country.match(regex) ||
                      airport.name.match(regex) ||
                      airport.city.match(regex) ||
                      airport.iata_code.match(regex)
                  );
              });

              if (fits.length > 0) {
                  var iataCode = fits[0].iata_code;
                  getFlightInfo(iataCode)
              }
              // Manipulate the DOM with the filtered data (fits)
              // Example: $('#airportList').html(...);
          }
      });
  }
}

function getFlightInfo(code) {
  // var form = $("#travelIdea");
  // var formData = form.serialize();
  var date = $("#start_date").val();
  var url = "/api/search";
  var requestData = {
      from: "HKG",
      to: code,
      date: date,
      passengers: 1
  };
  $.post(url, requestData, function(response) {
      var flights = response.data;
      $("#orginDest").html("HKG -> " + code);
      $.each(flights.data, function(index, flight) {
          //console.log(flight)
          var row = '<tr>' +
              '<th scope="row">' + flight.id + '</th>' +
              '<td>' + flight.itineraries[0].duration.substring(2) + '</td>' +
              '<td>' + flight.price.total + '</td>' +
              '</tr>';

          $('#flightResult tbody').append(row);
      });

  }).fail(function(xhr, status, error) {
      console.error(error); // Handle the error case
  });
}