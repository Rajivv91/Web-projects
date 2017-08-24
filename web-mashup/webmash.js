// Put your zillow.com API key here

var username = "rajivv91";
var request = new XMLHttpRequest();
var map;
var marker;
var latitude;
var longitude;
var address;
var geocoder;
var Outputarray = []; // this array contains all the information about latitude, longitiude, address etc
var infowindow;
var counter = 0;

//initMap() which initiates map to a location
function initMap() {

	//initialize map
	var myLatLng = {lat: 32.75, lng: -97.13};
	map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 32.75, lng: -97.13},
          zoom: 17
        });
		
		
		// adding a marker
	marker = new google.maps.Marker({
      position: myLatLng,
      map: map
    });
	
	//Initialize a mouse click event on map which then calls reversegeocode function
  geocoder = new google.maps.Geocoder;
  infowindow = new google.maps.InfoWindow;
  google.maps.event.addListener(map, 'click', function(event) {
    addMarker(event.latLng, map);
	geocodeLatLng(geocoder, map);
	sendRequest();
	
  });
  
	
	
	
}


function addMarker(location, map) {
  
    marker.setPosition(location);
  
  //getting latitude and longitude
  latitude = location.lat();
  longitude = location.lng();
  Outputarray.push("lattitude:");
  Outputarray.push(latitude);
  Outputarray.push("longitude:");
  Outputarray.push(longitude);
  
  // for debugging, displaying values for lattitude and longitude
  console.log(latitude);
  console.log(longitude);
}




// Reserse Geocoding 
function geocodeLatLng(geocoder, map) {
  //get the latitude and longitude from the mouse click and get the address.
  
  geocoder.geocode({'location': marker.getPosition()}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        
        address = (results[1].formatted_address);
		console.log(address);
		
		//getting address
		Outputarray.push("address:");
		Outputarray.push(address);
      
      } else {
        window.alert('No results found');
      }
    } else {
      window.alert('Geocoder failed due to: ' + status);
    }
  });
  
  
}// end of geocodeLatLng()



function displayResult () {
    if (request.readyState == 4) {
        var xml = request.responseXML.documentElement;
		console.log(xml);
		
		// getting temperature
        var t = xml.getElementsByTagName("temperature")[0];
		var temperature = t.childNodes[0].nodeValue;
		Outputarray.push("temperature:");
		Outputarray.push(temperature);
		
		//getting clouds
		var c = xml.getElementsByTagName("clouds")[0];
		var clouds = c.childNodes[0].nodeValue;
		Outputarray.push("clouds:");
		Outputarray.push(clouds);
		
		//getting windSpeed
		var w = xml.getElementsByTagName("windSpeed")[0];
		var windSpeed = w.childNodes[0].nodeValue;
		Outputarray.push("windSpeed:");
		Outputarray.push(windSpeed);
		counter = counter+1; 
		//inserting a line to differentiate
		Outputarray.push("--------------"+counter+"-----------------");
		
		
		// this prints the details on top of the marker
		infowindow.setContent("address: "+address+"</br>"+"temperature:"+temperature+"</br>"+"clouds:"+clouds+"</br>"+"windSpeed:"+windSpeed+"</br>");
		infowindow.open(map,marker);
    
	
	document.getElementById("output").innerHTML = Outputarray.join("</br>"); 
	
	//console.log(temperature);
	//console.log(y);
	
    }
}

function sendRequest () {
    request.onreadystatechange = displayResult;
    /*
	var lat = "";
    var lng = "";*/
	
  var uri = "http://api.geonames.org/findNearByWeatherXML?lat="+latitude+"&lng="+longitude+"&username="+username;
  var encoded = encodeURI(uri);
  request.open("GET",encoded);
  

  //request.withCredentials = "true";
    request.send();
}

// this fuction is called when the "clear" button is clicked
function clearscreen () {
	counter=0;
	Outputarray = []; 
	document.getElementById("output").innerHTML = Outputarray;
}


