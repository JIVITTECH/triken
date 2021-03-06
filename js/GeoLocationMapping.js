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
				     if ($.cookie("branch_id") !== undefined) {
					      if ($.cookie("branch_id") !== myObj[i].branch_id) {
							   var cart_count = document.getElementById('cart_count').innerHTML;
							   if(+cart_count !== 0){
									document.getElementById('clear_cart').style.display = 'block';
									document.getElementById('branch_dialog').style.display = 'none';
									document.getElementById('hidden_branch').value = myObj[i].branch_id;
							   } else {
									branch_id = +myObj[i].branch_id;
									$.cookie("branch_id", JSON.stringify(branch_id));
									$('.lpopup').hide();
									var location = document.getElementById("location").value;
									location =  location.substr(0, location.indexOf(',')); 
									if(location.length > 24){
										location = location.substring(0,24) + "...";
									} 
									document.cookie = "locName=" + location + "; expires=Thu, 31 Dec 2099 23:59:59 GMT";
									document.getElementById("loc_name").innerHTML = location;
									window.location.href = window.location.href;
									loadAllCategories();
									loadTopCategories();
									loadAllRecipes();
									if (myObj[i].message != "") {
									   document.getElementById("myModal").style.display = "block";
									   document.getElementById("msg").innerHTML = myObj[i].message;
									}
								}
					      } else {
								branch_id = +myObj[i].branch_id;
								$.cookie("branch_id", JSON.stringify(branch_id));
								$('.lpopup').hide();
								var location = document.getElementById("location").value;
								location =  location.substr(0, location.indexOf(',')); 
								if(location.length > 24){
									location = location.substring(0,24) + "...";
								} 
								document.cookie = "locName=" + location + "; expires=Thu, 31 Dec 2099 23:59:59 GMT";
								document.getElementById("loc_name").innerHTML = location;
								window.location.href = window.location.href;
								loadAllCategories();
								loadTopCategories();
								loadAllRecipes();
								if (myObj[i].message != "") {
							 	    document.getElementById("myModal").style.display = "block";
								    document.getElementById("msg").innerHTML = myObj[i].message;
								}
						  }
					 } else {
						  branch_id = +myObj[i].branch_id;
						  $.cookie("branch_id", JSON.stringify(branch_id));
						  $('.lpopup').hide();
					      var location = document.getElementById("location").value;
						  location =  location.substr(0, location.indexOf(',')); 
						  if(location.length > 24){
							  location = location.substring(0,24) + "...";
						  } 
						  document.cookie = "locName=" + location + "; expires=Thu, 31 Dec 2099 23:59:59 GMT";
						  document.getElementById("loc_name").innerHTML = location;
						  window.location.href = window.location.href;
						  loadAllCategories();
						  loadTopCategories();
						  loadAllRecipes();
						  if (myObj[i].message != "" && myObj[i].message != null) {
							  document.getElementById("myModal").style.display = "block";
							  document.getElementById("msg").innerHTML = myObj[i].message;
						  }
					 }
				}
			} else {
				document.getElementById("no_branch").style.display = "block";
			} 
		}
    };
    xhttp.open("GET", "api/find_nearest_branch.php?" + "latitude=" + latitude + 
               "&longitude=" + longitude, true);
    xhttp.send();
}
