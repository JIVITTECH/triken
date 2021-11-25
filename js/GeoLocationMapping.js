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
        findNearestBranch(latitude, longitude);
    } else {
        document.getElementById('latitude').value = "";
        document.getElementById('longitude').value = "";
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
  var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  getCurrentAddress(myLatlng, position.coords.latitude, position.coords.longitude);
}

function getCurrentAddress(location, lat, long) {
   currgeocoder = new google.maps.Geocoder();
    currgeocoder.geocode({
        'location': location
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results[0]);
            document.getElementById("location").value=results[0].formatted_address;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = long;
            findNearestBranch(lat, long);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function findNearestBranch (latitude, longitude) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
						branch_id = myObj[i].branch_id;
						var location = document.getElementById("location").value;
						location =  location.substr(0, location.indexOf(',')); 
						if(location.length > 24){
							location = location.substring(0,24) + "...";
						} 
						document.cookie = "locName=" + location + "; expires=Thu, 31 Dec 2099 23:59:59 GMT";
						document.getElementById("loc_name").innerHTML = location;
					}
				$('.lpopup').hide();
				window.location.href = window.location.href;
				loadAllCategories();
				loadTopCategories();
				loadLtdDealsOfTheDay();
				loadLtdBestSellingProducts();
				loadAllRecipes();
			}else{
				document.getElementById("no_branch").style.display = "block";
			} 
		}
    };
    xhttp.open("GET", "api/find_nearest_branch.php?" + "latitude=" + latitude + 
               "&longitude=" + longitude, true);
    xhttp.send();
}
