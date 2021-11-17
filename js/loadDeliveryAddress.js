function loadAllDeliveryAddress() {
    var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/loadDeliveryAddress.php?action=get_all_delivery_address";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {

			 	for (var i = 0; i < myObj.length; i++) {
					if (myObj[i].current_address == "Y") {
					   information = information + "<div class='radio-item address'>" +
					                                   "<input type='radio' id='address" + i + "'" + "name='address' value='address" + i + "'" + "onclick = updateCurrentDeliveryAddress(" + myObj[i].delivery_add_id + ") checked>" +
												       "<label for='address" + i + "'>" + myObj[i].delivery_address + "</label>" +
													   "<br>"+
													   "<a onclick='removeDeliveryAddress(" + myObj[i].delivery_add_id + ")' class='btn btn-link btn-underline btn-icon-right' style='color: #E0522D;text-transform: inherit;'>Remove</a>" +
												   "</div>";
					} else {
					   information = information + "<div class='radio-item address'>" +
					                                   "<input type='radio' id='address" + i + "'" + "name='address' value='address" + i + "'" + "onclick = updateCurrentDeliveryAddress(" + myObj[i].delivery_add_id + ") >" +
												       "<label for='address" + i + "'>" + myObj[i].delivery_address + "</label>" +
													   "<br>" +
													   "<a onclick='removeDeliveryAddress(" + myObj[i].delivery_add_id + ")' class='btn btn-link btn-underline btn-icon-right' style='color: #E0522D;text-transform: inherit;'>Remove</a>" +
												   "</div>";
					}		
				}
				$('#loadalldeliveryaddress').empty();
				$('#loadalldeliveryaddress').append(information);

            } else {
				$('#loadalldeliveryaddress').append("<center>No address found<\center>");
            }
		}
	};
}

function getCurrentDeliveryAddress() {
    var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/loadDeliveryAddress.php?action=get_current_delivery_address";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			 	for (var i = 0; i < myObj.length; i++) {
					information = myObj[i].delivery_address; 	
				}
	        }
			$('#load_current_del_address').empty();
			$('#load_current_del_address').append(information);
		}
	};
}