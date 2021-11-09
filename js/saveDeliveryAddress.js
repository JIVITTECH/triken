function saveNewDeliveryAddress() {
    var flatNo = document.getElementById("building-name").value;
    var street = document.getElementById("Street").value;
    var area = document.getElementById("area").value;
    var city = document.getElementById("city").value;
    var pincode = document.getElementById("pincode").value;
    var landmark = document.getElementById("landmark").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("building-name").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("area").value = "";
            document.getElementById("city").value = "";
            document.getElementById("pincode").value = "";
            document.getElementById("landmark").value = "";
            document.getElementById("filled-in-box").checked = false;
            loadAllDeliveryAddress();
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
            //no action
        }
    };
    xhttp.open("GET", "api/saveDeliveryAddress.php?" + "del_address_id=" + del_address_id + 
               "&action=update_current_delivery_address", true);
    xhttp.send();
}