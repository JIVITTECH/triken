/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var currgeocoder;
function getLatAndLong() {
    var geoLocation = document.getElementById("location").value;
    if (geoLocation.trim().length != 0) {
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
        document.getElementById('delArea').value = area;
        document.getElementById('delCity').value = city;
        document.getElementById('delState').value = state;
        document.getElementById('delPinCode').value = pinCode;
        $.cookie("user_loc_latitude", latitude);
        $.cookie("user_loc_longitude", longitude);
        findNearestBranch(latitude, longitude);
    } else {
        document.getElementById('latitude').value = "";
        document.getElementById('longitude').value = "";
        document.getElementById('delArea').value = "";
        document.getElementById('delCity').value = "";
        document.getElementById('delState').value = "";
        document.getElementById('delPinCode').value = "";
    }
}

var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
//  x.innerHTML = "Latitude: " + position.coords.latitude + 
//  "<br>Longitude: " + position.coords.longitude;
  var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  getCurrentAddress(myLatlng);
}
//Get current address
function getCurrentAddress(location) {
   currgeocoder = new google.maps.Geocoder();
    currgeocoder.geocode({
        'location': location
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results[0]);
            document.getElementById("location").value=results[0].formatted_address;
//            $("#address").html();
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function findNearestBranch (latitude, longitude) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //no action
        }
    };
    xhttp.open("GET", "api/find_nearest_branch.php?" + "latitude=" + latitude + 
               "&longitude=" + longitude, true);
    xhttp.send();
}
