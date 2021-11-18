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
															"<div class='col-md-10 col-xs-9'>" +
																"<div class='order-detail'>Order # " + cart_details.invoice_no + "<br>" + cart_details.ordered_date_time  + "</div>" +
															"</div>" +
															"<div class='col-md-2 col-xs-12'>" +
																"<a href=''  class='btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded'>Reorder</a>" +
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