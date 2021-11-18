$( document ).ready(function() {
    load_profile_details();
    load_address_details();
	loadOrders();

});


function load_profile_details() {
    var xmlhttp = new XMLHttpRequest();
    var url = "api/get_profile_details.php";
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            if (myObj.length !== 0) {
                
                for (var i = 0; i < myObj.length; i++) {
                    document.getElementById("firstname").value = myObj[i].customer_name;
                    document.getElementById("lastname").value = myObj[i].last_name;
                    document.getElementById("phone").value = myObj[i].contact_no;
                    document.getElementById("email_1").value = myObj[i].email_addr;
                }

            }
        }
    };
}

function load_address_details() {
    var xmlhttp = new XMLHttpRequest();
    var url = "api/loadDeliveryAddress.php?action=get_all_delivery_address";
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            $('#address-book-row').empty();
            if (myObj.length !== 0) {
                
                for (var i = 0; i < myObj.length; i++) {
                    $('#address-book-row').append('<div class="ecommerce-address billing-address pr-lg-8">' +
                    '<div class="address">' +
                    myObj[i].delivery_address +
                    '</div>' +
                    '<a href="#" onclick="editAddress(' + myObj[i].delivery_add_id + ',\'' + myObj[i].flatNo + '\',\'' + myObj[i].street + '\',\'' + myObj[i].area + '\',\'' + myObj[i].pincode + '\',\'' + myObj[i].landmark + '\',\'' + myObj[i].city + '\')" class="btn btn-link btn-underline btn-icon-right" style="color: #E0522D;text-transform: inherit;">Edit</a>' +
                    '<a href="#" onclick="deleteAddress(' + myObj[i].delivery_add_id + ')" class="btn btn-link btn-underline btn-icon-right pl-5" style="color: #E0522D;text-transform: inherit;">Delete</a>' +
                    '</div>');
                }

            }
        }
    };
}

function editAddress(id,flatNo,street,area,pincode,landmark,city) {
    document.getElementById("saveButton").style.display = 'none';
	document.getElementById("updateButton").style.display = 'none';
	document.getElementById("Street").value = street;
    document.getElementById("area").value = area;
    document.getElementById("city").value = city;
    document.getElementById("pincode").value = pincode;
    document.getElementById("landmark").value = landmark;
	document.getElementById("building-name").value = flatNo;
	document.getElementById("hidden_address").value = id;
    $('#add-new-addr-btn').click();
}

function deleteAddress(val) {
    var xmlhttp = new XMLHttpRequest();
    var url = "api/loadDeliveryAddress.php?action=delete_delivery_address&delivery_add_id=" + val;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            load_address_details();
        }
    };
}