function saveNewDeliveryAddress(flag) {
    var street = document.getElementById("Street").value;
    var area = document.getElementById("area").value;
    var city = document.getElementById("city").value;
    var pincode = document.getElementById("pincode").value;
    var landmark = document.getElementById("landmark").value;
	var flatNo = document.getElementById("building-name").value;

    if (street.trim().length == 0 || area.trim().length == 0 || city.trim().length == 0 || pincode.trim().length == 0 || landmark.trim().length == 0 || flatNo.trim().length == 0) {
        alert('Please enter all address fields');
		var elem = document.getElementById("filled-in-box");
		if(elem){
			document.getElementById("filled-in-box").checked = false;
			return;
		}
    } 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
			var myObj = this.responseText;
            document.getElementById("building-name").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("area").value = "";
            document.getElementById("city").value = "";
            document.getElementById("pincode").value = "";
            document.getElementById("landmark").value = "";
			if(flag === 1){
				document.getElementById("filled-in-box").checked = false;
				loadAllDeliveryAddress();
			}else{
				document.getElementById("close_btn").click();
				load_address_details();
			}
        }
    };
    xhttp.open("GET", "api/saveDeliveryAddress.php?" + "addr_flat_no_build_name=" + encodeURIComponent(flatNo) + "&addr_street_area=" + encodeURIComponent(street) +
               "&addr_area=" + encodeURIComponent(area) + "&addr_city=" + encodeURIComponent(city) + "&addr_pincode=" + pincode + "&addr_landmark=" + landmark +
               "&action=save_new_delivery_address", true);
    xhttp.send();
}

function updateCurrentDeliveryAddress(del_address_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getCurrentDeliveryAddress();
        }
    };
    xhttp.open("GET", "api/saveDeliveryAddress.php?" + "del_address_id=" + del_address_id + 
               "&action=update_current_delivery_address", true);
    xhttp.send();
}

function removeDeliveryAddress(del_address_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            loadAllDeliveryAddress();
        }
    };
    xhttp.open("GET", "api/saveDeliveryAddress.php?" + "del_address_id=" + del_address_id + 
               "&action=remove_delivery_address", true);
    xhttp.send();
}