<?php
    $title = 'Thank you- Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'noindex,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    include('header.php');
    include('main.php');
	$page ="Order Summary";
?> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<section class="thankyou">
    <div class="container">
        <div class="order-success ttext">
            <ul>
                <li><img src="assets/images/tick.svg">  </li>
                <li><h3> Thank you for your order! :)</h3>
            <p>We’ve received your order.</p></li>
            </ul>
            <table class="orderlist">
                <tr>
                    <td><p>Order Number:</p> <h6> #<span id ="generated_cart_id"> </span></h6></td>
                    <td><p>Total:</p> <h6> ₹<span id ="grand_total"></span> </h6></td>
                </tr>
                <tr>
                    <td><p>Date:</p> <h6><span id ="order_date"> </span> </h6></td>
                    <td><p>Payment Method:</p> <h6> <span id ="payment_mode"></span></h6></td>
                </tr>
            </table>
        </div>
                    <div class="order-details-wrapper mb-5">
                        <h4>Order Details</h4>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="item_tag">
                              
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td>₹<span id="sub_total"></span></td>
                                </tr>
                                <tr>
                                    <td>Delivery:</td>
                                    <td>₹<span id="del_charge"></span></td>
                                </tr>
                                <tr>
                                    <td>Payment method:</td>
                                    <td><span id="mode"></span></td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td>₹<span id="discount"></span></td>
                                </tr>
                                <tr class="total">
                                    <td class="border-no">Total:</th>
                                    <td class="border-no">₹<span id="g_total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End of Order Details -->

                    <div id="account-addresses">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="ecommerce-address shipping-address">
                                    <h4>Shipping Address</h4>
                                        <table class="address-table">
                                            <tbody>
                                                <tr>
                                                    <td>
													<address id="del_address"></address></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="dslot">Delivery Slot </span>
                                                    <span class="slotdt"id="del_slot"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Account Address -->

                    <a href="#" class="btn btn-dark "><i class="w-icon-long-arrow-left"></i>Back to Home</a>
        </div>
    </div>
</section>
<script>
 $(document).ready(function () {
	loadOrderDetails();
});

	function loadOrderDetails() {
		var arr1 = getAllUrlParams((window.location).toString());
        var cus_cart_id = arr1.cart_id;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			var myObj = JSON.parse(this.responseText);
				if (myObj.length > 0) {
					var temp_cart_id = [];   
					var temp_cart_id1 = [];
					for (var i = 0; i < myObj.length; i++) {

					var cart_arr = myObj[i];
					var cart_details = cart_arr[0].cart_details;
					var cart_items_count = cart_arr[1].cart_items_count;
					var cart_items = cart_arr[2].cart_items;
					var cart_sub_total = cart_arr[3].cart_sub_total;
					var cart_taxes = cart_arr[4].cart_taxes;
					var cart_disc = cart_arr[5].cart_disc;
					var order_type = cart_details.delivery;
					var cart_payment_mode = "";
					
					if(cart_details.payment_type !== "" ){
						cart_payment_mode = "Bank Transfer";
					}else{
						cart_payment_mode = "Cash on Delivery";
					}
					
					var del_slot = cart_details.del_day + " | " + cart_details.del_day + " slot";
					document.getElementById("generated_cart_id").innerHTML =  cart_details.cart_id;
					document.getElementById("order_date").innerHTML =  cart_details.ordered_date_time;
					document.getElementById("grand_total").innerHTML =  cart_details.total_price;
					document.getElementById("payment_mode").innerHTML =  cart_payment_mode;
					document.getElementById("del_address").innerHTML =  cart_details.delivery_address;
					document.getElementById("sub_total").innerHTML = cart_sub_total.toFixed(2) ;
					document.getElementById("g_total").innerHTML =  cart_details.total_price;
					document.getElementById("mode").innerHTML =  cart_payment_mode;
					document.getElementById("del_slot").innerHTML =   del_slot;
					document.getElementById("del_charge").innerHTML =  cart_details.del_charge;
					if (cart_disc.length > 0) {
						for (var l = 0; l < cart_disc.length; l++) {
							document.getElementById("discount").innerHTML =  cart_disc[l].disc_cost;
						}
					}
					
					if (cart_items.length > 0) {

						for (var k = 0; k < cart_items.length; k++) {
							  
							$('#item_tag').append('<tr>' +
														'<td>' +
															'<a href="#">' + cart_items[k].name + '</a>&nbsp;<strong>x ' + cart_items[k].quantity + '</strong>' +
														'</td>'+
														'<td> ₹ ' + cart_items[k].price.toFixed(2) + ' </td>' +
													'</tr>');
								}
							}
						}
					}
				}
			};
	var url = "api/order_summary.php?cus_cart_id="+cus_cart_id;
	xhttp.open("GET", url, true);
	xhttp.send();
	}
	
    function getAllUrlParams(url) {
		// get query string from url (optional) or window
		var queryString = url ? url.split('?')[1] : window.location.search.slice(1); // we'll store the parameters here
		var obj = {}; // if query string exists
		if (queryString) {

			// stuff after # is not part of query string, so get rid of it                                                 queryString = queryString.split('#')[0];

			// split our query string into its component parts
			var arr = queryString.split('&');
			for (var i = 0; i < arr.length; i++) {
				// separate the keys and the values
				var a = arr[i].split('=');
				// in case params look like: list[]=thing1&list[]=thing2
				var paramNum = undefined;
				var paramName = a[0].replace(/\[\d*\]/, function (v) {
					paramNum = v.slice(1, -1);
					return '';
				});
				// set parameter value (use 'true' if empty)
				var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
				// (optional) keep case consistent
				paramName = paramName.toLowerCase();
				paramValue = paramValue.toLowerCase();
				// if parameter name already exists
				if (obj[paramName]) {                                 // convert value to array (if still string)
					if (typeof obj[paramName] === 'string') {
						obj[paramName] = [obj[paramName]];
					}
					// if no array index number specified...
					if (typeof paramNum === 'undefined') {
						// put the value on the end of the array                                                             obj[paramName].push(paramValue);
					}
					// if array index number specified...
					else {
						// put the value at that index number                                     obj[paramName][paramNum] = paramValue;
					}
				}
				// if param name doesn't exist yet, set it
				else {
					obj[paramName] = paramValue;
				}
			}
		}

		return obj;
	}

</script>

<?php include('footer.php'); ?>