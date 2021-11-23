function loadOrders() {   
		var orders_div = "";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {   
			if (this.readyState === 4 && this.status === 200){
				var myObj = JSON.parse(this.responseText);
				if (myObj.length > 0) {   
					for (var i = 0; i < myObj.length; i++) {
						var cart_arr = myObj[i]; 
						var cart_details = cart_arr[0].cart_details;
						var cart_items_count = cart_arr[1].cart_items_count;
						var cart_items = cart_arr[2].cart_items; 
						var cart_sub_total = cart_arr[3].cart_sub_total;
						var cart_taxes = cart_arr[4].cart_taxes;
						var order_type = cart_details.delivery;
						var cart_payment_mode = "Paid via Credit/Debit card";
						
						var items_div = "";
						
						if(cart_items !== undefined){
							if(cart_items.length > 0) {

								for (var k = 0; k < cart_items.length; k++) {
									
									items_div = items_div + cart_items[k].name + "&nbsp;&nbsp;x" + cart_items[k].quantity + "";
									
									if(k == cart_items.length - 1){
										items_div = items_div + "&nbsp;&nbsp";
									}else{
										items_div = items_div + "," + "&nbsp;&nbsp";
									}
								}
							}
						}
						
						orders_div =  "<div class='row order_row'>" +
														"<div class='order_sec'>" +
															"<div class='col-md-10 col-xs-9' onclick='goToOrderSummary(" + cart_details.cart_id + ")'>" +
																"<div class='order-detail'>Order # " + cart_details.invoice_no + "<br>" + cart_details.ordered_date_time  + "</div>" +
															"</div>" +
															"<div class='col-md-2 col-xs-12'>" +
																"<button onclick='isCartFilled(" + cart_details.cart_id + ")' class='btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded'>Reorder</button>" +
															"</div>" +
														"</div>" +
														"<p>" + items_div + "</p>" +
													"</div>";
						$('#my-orders').append(orders_div);
				}
			}
		};
	}
	var url = "api/myOrdersController.php?obo_cus_id="+customer_id;
	xhttp.open("GET", url, true);
	xhttp.send();
}


function isCartFilled(cartId) {

	var arr1 = getAllUrlParams((window.location).toString());
	var xmlhttp = new XMLHttpRequest();
	var url = "api/cartitemVerification.php?cart_id=" + curr_cart_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = xmlhttp.responseText;
			cart_counts = +myObj;
			document.getElementById('reorder_cart_id').value = cartId;
			if (cart_counts === 0) {     
				sel = 2;
				removingOrderItems();
			} else {   
			    document.getElementById('reOrder').click();
			}
		}
	};
}

var sel = 0;

function removingOrderItems() {
	var cart_id = document.getElementById('reorder_cart_id').value;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/reorderStockCheck.php?cart_id=" + cart_id + '&type=3' + "&cur_cart_id=" +  curr_cart_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = xmlhttp.responseText;
			if(sel === 0){
				document.getElementById('close_btn1').click();
				stockCheck(cart_id);
			}else{
				document.getElementById('close_btn2').click();
				stockCheck(cart_id);
			}
		}
	};                   
}


function stockCheck(cartId) {                
	var xmlhttp = new XMLHttpRequest();
	var name = [];
	var url = "api/reorderStockCheck.php?cart_id=" + cartId + '&type=1' + "&cur_cart_id=" +  curr_cart_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length > 0) {
				for (var i= 0; i < myObj.length; i++) {
					name.push(myObj[i].name);
				}
				var itmName = name.toString();        
				document.getElementById('out_stock').click();
				document.getElementById('infoMsg').innerHTML = "";
				document.getElementById('infoMsg').innerHTML = itmName + " is/are not in stock. Do you want to continue?";
			} else {
				navCartItem(cartId);
			}
		}
	};
}

function navCartItem() {
	var cartId = document.getElementById('reorder_cart_id').value;
    var arr1 = getAllUrlParams((window.location).toString());
	var xmlhttp = new XMLHttpRequest();
	var url = "api/reorderStockCheck.php?cart_id=" + cartId + '&type=2' + "&cur_cart_id=" +  curr_cart_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = xmlhttp.responseText;
			window.location.href = "cart.php?branch_id=" + branch_id ;
		}
	};                
}

function goToOrderSummary(card_id) {
    window.location.href = 'order_summary.php?cart_id=' + card_id +"&view_order_history=Y";  
	document.getElementById('summary_title').innerHTML = "";
}
