<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5BYHi0FBli9RCmOmL60gwUddobPVX6qk&callback=initMap&libraries=places&v=weekly" defer></script>
<script>
    "use strict";
    var latitude = "";
    var longitude = "";
    
    var area;
    var city;
    var state;
    var pinCode;
    
    var addressCompObj = null;
    
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 13
        });
        const input = document.getElementById("location");
        const inputMob = document.getElementById("mobLocation");
        const autocomplete = new google.maps.places.Autocomplete(input);
        const autocompleteMob = new google.maps.places.Autocomplete(inputMob);
        autocomplete.bindTo("bounds", map); // Specify just the place data fields that you need.
        autocompleteMob.bindTo("bounds", map);

        autocomplete.setFields([
            "place_id",
            "geometry",
            "name",
            "formatted_address",
            "address_components"
        ]);
        
        autocompleteMob.setFields([
            "place_id",
            "geometry",
            "name",
            "formatted_address"
        ]);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputMob);
        const infowindow = new google.maps.InfoWindow();
        const infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        const geocoder = new google.maps.Geocoder();
        const marker = new google.maps.Marker({
            map: map
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });
        autocomplete.addListener("place_changed", () => {
            infowindow.close();
            const place = autocomplete.getPlace();
            latitude= place.geometry.location.lat();
            longitude = place.geometry.location.lng();
            
            addressCompObj = place['address_components'];
            area = "";
            city = "";
            state = "";
            pinCode = "";
            
            for (var i = 0; i < addressCompObj.length; i++) {
            
               var addressType = addressCompObj[i].types[0];
               
               if (addressType === 'colloquial_area' || addressType === 'sublocality_level_2' || addressType === 'sublocality_level_1' || addressType === 'locality') {
                   if (area.trim().length !== '0') {
                      area = area + ", ";
                   }  
                   area += addressCompObj[i] ['long_name'];
               } else if (addressType === "administrative_area_level_2") {
                   city = addressCompObj[i] ['long_name'];
               } else if (addressType === "administrative_area_level_1") {
                   state = addressCompObj[i] ['long_name'];
               } else if (addressType === "postal_code") {
                   pinCode = addressCompObj[i] ['short_name'];
               }
            }
            
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            document.getElementById('delArea').value = area;
            document.getElementById('delCity').value = city;
            document.getElementById('delState').value = state;
            document.getElementById('delPinCode').value = pinCode;

            console.log("tripazo --- latitude --- " + latitude);
            console.log("tripazo --- longitude --- " + longitude);
//            getLatAndLong();
            if (!place.place_id) {
                return;
            }

            geocoder.geocode(
                    {
                        placeId: place.place_id
                    },
                    (results, status) => {
                if (status !== "OK") {
                    modal_alert_msg("Geocoder failed due to: " + status,0,0);
                    return;
                }

                map.setZoom(11);
                map.setCenter(results[0].geometry.location); // Set the position of the marker using the place ID and location.
                // @ts-ignore TODO(jpoehnelt) This should be in @typings/googlemaps.

                marker.setPlace({
                    placeId: place.place_id,
                    location: results[0].geometry.location
                });
                
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place.name;
                infowindowContent.children["place-id"].textContent =
                        place.place_id;
                infowindowContent.children["place-address"].textContent =
                        results[0].formatted_address;
                infowindow.open(map, marker);
            }
            );
        });
        
        autocompleteMob.addListener("place_changed", () => {
            infowindow.close();
            const place = autocompleteMob.getPlace();
                latitude= place.geometry.location.lat();
            longitude = place.geometry.location.lng();
            console.log("tripazo --- latitude --- " + latitude);
            console.log("tripazo --- longitude --- " + longitude);
//            getLatAndLong();
            if (!place.place_id) {
                return;
            }

            geocoder.geocode(
                    {
                        placeId: place.place_id
                    },
                    (results, status) => {
                if (status !== "OK") {
                    modal_alert_msg("Geocoder failed due to: " + status,0,0);
                    return;
                }

                map.setZoom(11);
                map.setCenter(results[0].geometry.location); // Set the position of the marker using the place ID and location.
                // @ts-ignore TODO(jpoehnelt) This should be in @typings/googlemaps.

                marker.setPlace({
                    placeId: place.place_id,
                    location: results[0].geometry.location
                });
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place.name;
                infowindowContent.children["place-id"].textContent =
                        place.place_id;
                infowindowContent.children["place-address"].textContent =
                        results[0].formatted_address;
                infowindow.open(map, marker);
            }
            );
        });
    }
</script>
<style>
    .pac-container:after{
        content:none !important;
        z-index: 99999;
    }
</style>


<!-- geo location map (do not delete) -->
<div id="map" hidden></div>
<div id="infowindow-content" hidden>
    <span id="place-name" class="title"></span><br />
    <strong>Place ID</strong>: <span id="place-id"></span><br />
    <span id="place-address"></span>
</div>
<!-- geo location map (do not delete) -->