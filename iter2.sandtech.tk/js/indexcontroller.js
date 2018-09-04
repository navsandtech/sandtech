//loading symbol
$(window).load(function() {
  $('.loader').fadeOut();
});

//scroll top on loading the page 
$(document).ready(function() {
  $(this).scrollTop(0);
});

//Home view for map with zoom and bounds
var zoom = 13;
var southWest = new L.LatLng(-37.7766849831305, 145.05883631463917),
  northEast = new L.LatLng(-37.83093781796034, 144.9000495409575),
  bounds = new L.LatLngBounds(southWest, northEast);

//creating the initial view for the map
var mymap = L.map('mapid', {
  zoomControl: true
}).setZoom(zoom);
mymap.fitBounds(bounds);

//adding the layer to the map
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoic2FuZHRlY2giLCJhIjoiY2psNHdvd2tkMDNyODNrcDltNGlhZjI1NyJ9.X4iV_TejdQuRBy2w2xNV0A', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  maxZoom: 18,
  id: 'mapbox.streets',
  accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

//Home button for map and reset view
L.easyButton('fa-home', function(btn, mymap) {
  mymap.setZoom(zoom);
  mymap.fitBounds(bounds);
}, 'Home View').addTo(mymap);

//loop to bind the json data to the map
var markers = [];
for (var i = 0; i < objectLocation.length; i++) {
  markers[i] = L.marker([objectLocation[i].lat, objectLocation[i].lon]).addTo(mymap);
  
  var parking,toilet,wheelchairaccess;
  
   for (var j = 0; j < objectParking.length; j++) {
        if (objectLocation[i].name == objectParking[j].name) {
          parking = "No of Disabled Parking : " + objectParking[j].total_disable_park;
        }
      }
      for (var k = 0; k < objectToilet.length; k++) {
        if (objectLocation[i].name == objectToilet[k].name) {
          toilet = "No of Disabled Toilet : " + objectToilet[k].total_no;
          wheelchairaccess = "Wheelchair Access : " + objectToilet[k].wheelchair;
        }
      }
  
  markers[i].bindPopup("<b>" + objectLocation[i].name + '</b><br>' + parking + '<br>' + toilet + '<br>' + wheelchairaccess +'<br><a style="cursor:pointer" onclick="return openPopupEvent(' + objectLocation[i].loc_id + ')" id="detailid' + objectLocation[i].loc_id + '">Details</a>');
  markers[i].bindTooltip(objectLocation[i].name, {
    permanent: false,
    interactive: true
  });
  //.openTooltip();
}

//method for opening the custom popup by passing the id as paramter
function openPopupEvent(markerid) {

  document.getElementById("myNav").style.width = "100%";

  for (var i = 0; i < objectLocation.length; i++) {
    if (objectLocation[i].loc_id == markerid) {

      document.getElementById("popupTitle").innerHTML = objectLocation[i].name;
      
      for (var j = 0; j < objectFeatures.length; j++) {
        if (objectLocation[i].name == objectFeatures[j].name) {
          document.getElementById("popupData").innerHTML = objectFeatures[j].des;
          document.getElementById("popupLink").innerHTML = objectFeatures[j].sub_des;
          document.getElementById("popupLink").href = objectFeatures[j].sub_des;
        }
      }
      
      //document.getElementById("popupTheme").innerHTML = "Theme : " + objectLocation[i].theme;
      //document.getElementById("popupSubTheme").innerHTML = "Sub-Theme : " + objectLocation[i].sub_theme;
     
    }
  }
}
//closing popup method
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
  document.getElementById("popupTitle").innerHTML = "";
  document.getElementById("popupData").innerHTML = "";
  document.getElementById("popupLink").innerHTML = "";
  document.getElementById("popupLink").href = "";
  //document.getElementById("popupToilet").innerHTML = "";
  //document.getElementById("popupWheelchairAccess").innerHTML = "";
}