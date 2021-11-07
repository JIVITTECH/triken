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
					                                   "<input type='radio' id='address" + i + "'" + "name='address' value='address" + i + "'" + " checked>" +
												       "<label for='address" + i + "'>" + myObj[i].delivery_address + "</label>" +
													   "<br>"+
												   "</div>";
					} else {
					   information = information + "<div class='radio-item address'>" +
					                                   "<input type='radio' id='address" + i + "'" + "name='address' value='address" + i + "'>" +
												       "<label for='address" + i + "'>" + myObj[i].delivery_address + "</label>" +
													   "<br>" +
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
		}
	};

	return information;
}