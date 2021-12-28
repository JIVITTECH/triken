<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' '; 
$pageCanonical = '';
$url = ' '; 
include('header.php');
include('main.php');
$page ="View Cart";

include("database.php");

$cart_page_flag = 1;
$disc_amount = 0;
$delivery_address = "";
$cus_lat = 0;
$cus_long = 0;
$latitude = 0;
$longitude = 0;
$discount_name = "";
$branch = $_GET['branch_id'];
$min_price = 0;
$additional_price = 0;
$min_distance = 0;
$user_id = $_SESSION['user_id'];
$cart_id = $_SESSION['cart_id'];
$branch_add = "SELECT * from kot_branch_details where branch_id = $branch ";
$bran_res = mysqli_query($conn, $branch_add);
$count_branch = mysqli_num_rows($bran_res);
if ($count_branch !== 0) {
    while ($qry3 = mysqli_fetch_array($bran_res)) {
        $latitude = $qry3['latitude'];
        $longitude = $qry3['longitude'];
    }
}

/* $del_address = "SELECT delivery_address,latitude,longitude   
                      FROM obo_customer_addresses
                      WHERE customer_id = '$user_id' AND current_address = 'Y'";

$res_del = mysqli_query($conn, $del_address);
$count = mysqli_num_rows($res_del);
if ($count !== 0) {
    while ($qry1 = mysqli_fetch_array($res_del)) {
        $delivery_address = $qry1['delivery_address'];
        $cus_lat = $qry1['latitude'];
        $cus_long = $qry1['longitude'];
    }
} else {
    $cus_address = "SELECT address  ,latitude,longitude    
                      FROM kot_customer_details
                      WHERE id = '$user_id'";

    $cus_res = mysqli_query($conn, $cus_address);
    $count_res = mysqli_num_rows($cus_res);
    if ($cus_res !== 0) {
        while ($qry2 = mysqli_fetch_array($cus_res)) {
            $delivery_address = $qry2['address'];
            $cus_lat = $qry2['latitude'];
            $cus_long = $qry2['longitude'];
        }
    }
}
*/

$delivery_address = $_COOKIE['locName'];
$cus_lat = $_SESSION['user_loc_latitude'];
$cus_long = $_SESSION['user_loc_longitude'];

$del = "SELECT * FROM obo_cart_coupon occ 
        LEFT JOIN discount_types dis 
        ON dis.id = occ.discount_id where cart_id = $cart_id AND EXPIRY_DATE >= CURDATE()";
$result_del = mysqli_query($conn, $del);
$count_dis = mysqli_num_rows($result_del);

if ($count_dis !== "0") {
    while ($qry3 = mysqli_fetch_array($result_del)) {
        $disc_amount = $qry3['discount_cost'];
        $discount_name = $qry3['discount_name'];
    }
}

$distance = 0;


if ($cus_lat === null || $cus_lat === "") {
    $cus_lat = 0;
}
if ($cus_long === null || $cus_long === "") {
    $cus_long = 0;
}

$sql = "SELECT db.* FROM (SELECT branch_id,name,description,
           (
                (
                    (
                        acos(
                            sin(( $cus_lat * pi() / 180))
                            *
                            sin(( `latitude` * pi() / 180)) + cos(( $cus_lat * pi() /180 ))
                            *
                            cos(( `latitude` * pi() / 180)) * cos((( $cus_long - `longitude`) * pi()/180)))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            )
           as distance FROM kot_branch_details ORDER BY branch_id ASC )db WHERE branch_id = $branch";

$result = mysqli_query($conn, $sql);
$count_distance = mysqli_num_rows($result);

if ($count_distance !== 0) {
    while ($rows = mysqli_fetch_array($result)) {
        $distance = round($rows['distance']);
    }
}

$del_qry = "SELECT * from delivery_charge where branch_id =$branch ";

$del_res = mysqli_query($conn, $del_qry);
while ($qry4 = mysqli_fetch_array($del_res)) {
    $min_price = $qry4['min_price'];
    $additional_price = $qry4['additional_price'];
    $min_distance = $qry4['min_distance'];
}

$delivery_charge = getDeliveryCharge($distance, $min_price, $additional_price, $min_distance);

function getDeliveryCharge($distance, $min_price, $additional_price, $min_distance) {
    $distance_calc = 0;

    $dis_diff = $distance - $min_distance;
    if ($distance <= $min_distance) {
        $distance_calc = $min_price;
    } else {
        $distance_calc = $min_price + ($dis_diff * $additional_price);
    }

    return $distance_calc;
}

?> 


<style type="text/css"> 
.submenu{padding: 10px 0; border-bottom: 1px solid #eee;}
</style>

<link rel="stylesheet" href="assets/css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/cart.js"></script>
<script src="js/loadDeliveryAddress.js"></script>
<script src="js/saveDeliveryAddress.js"></script>
<div class="cartpage">
    <div class="container" id="cart_container">
			
	<div class="multisteps-form">
        <!--progress bar-->
        <div class="row">
          <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
            <div class="multisteps-form__progress">
              <button class="multisteps-form__progress-btn js-active" type="button" title="Cart"><span>Cart</span></button>
              <button id="proceed_to_personal_details" class="multisteps-form__progress-btn" type="button" title="Personal Details"><span>Personal Details</span></button>
              <button id = "proceed_to_payment" class="multisteps-form__progress-btn" type="button" title="Payment Details" onclick="loadFinalizedCart()"><span>Payment Details</span></button>
            </div>
          </div>
        </div>
        <!--form panels-->
        <div class="row">
          <div class="col-12 col-lg-12 m-auto">
            <form class="multisteps-form__form">
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="scaleIn">
                
                <div class="multisteps-form__content">
                  
				  <div class="cartpage">
    <div class="container">
        <div class="row gutter-lg">
            <div class="col-lg-8 pr-lg-4 mb-6">
                <table style="table-layout: fixed;" class="shop-table cart-table">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Products</span></th> </tr> </thead>
                    <tbody id = "selected_items">
                    </tbody>
                </table>
                <div class="btn-continue">
                    <a href="#" onclick='gotoHome()' class="btn btn-block "> <i class="w-icon-long-arrow-left"></i> Continue Shipping </a>
                </div>
            </div>
            <div class="col-lg-4 delivery">
                 <table class="shop-table cart-table cart_delivery order-summary">
                    <thead> <tr> <th colspan="1" class="product-name"><span>Delivery</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                            <td>
                                  <div class="payment-methods" id="payment_method">
                                            <div class="accordion payment-accordion">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#payment" id="default" onclick ="setCookie('del_slot',365,1)" class="">Deliver Now (120 mins)</a>
                                                    </div>
                                                    <div id="payment" class="card-body expanded">
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" id="date_time" class="">Deliver Date & Time</a>
                                                    </div>
                                                    <div id="cash-on-delivery" class="card-body collapsed">
                                                        <form>
                                                    <input placeholder="Select your delivery date" value="" onchange ="setCookie('del_slot',365,2)" class="form-control" type="date"  id="date" min="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+2 days')); ?>" >
                                
                                
                                <div class="form-group">
                                                <div id = "sel_date_time" class="select-box">
                                                    <select id="delivery_time" onchange ="setCookie('del_slot',365,2)" class="form-control form-control-md">
                                                        <option value="default" selected="selected">Select your delivery time
                                                        </option>
                                                        <option value="1">7-9 AM</option>
                                                        <option value="2">9-11 AM</option>
                                                        <option value="3">11-01 PM</option>
                                                        <option value="4">1-3 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                </form>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="cart-subtotal align-items-center justify-content-between">
                                    <div class="csubtotal">
                                        <label class="ls-25">Subtotal  </label>
                                        <ins class="subtotal" id="sub_total">0</ins>
                                    </div>
                                        <p> Delivery, taxes, and discount codes
                                        calculated at checkout </p>
                                </div>

                                <button  onclick ='$("#proceed_to_personal_details").trigger("click");' type="button" class="btn btn-block btn-checkout"> Checkout </button> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
				  
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Next</button>
                  </div>
				  
                </div>
              </div>
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                
                <div class="multisteps-form__content">
                  
				  <div class="row cartpage gutter-lg">
		
			<div class="col-lg-4 delivery pr-0">
                 <table class="shop-table cart-table saved-address">
                    <thead> <tr> <th colspan="1" class="product-name"><span>Selected Saved Address</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                           <td> 
                                <div class="ecommerce-address billing-address saved-address" id="loadalldeliveryaddress">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
			<div class="col-lg-1 or_col">OR</div>
            <div class="col-lg-7 pl-0 mb-6 new_address">
                <table class="shop-table cart-table">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Enter New Address</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                             <td class="product-thumbnail">
                                <form class="form account-details-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="building-name" name="building-name" placeholder="Flat no / Building Name" class="form-control form-control-md" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="Street" name="street" placeholder="Street / Area"
                                                    class="form-control form-control-md" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="area" name="area" placeholder="Area" class="form-control form-control-md" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="city" name="city" placeholder="City"
                                                    class="form-control form-control-md" >
                                            </div>
                                        </div>
                                    </div>
									
									<div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control form-control-md" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="landmark" name="landmark" placeholder="Landmark"
                                                    class="form-control form-control-md" >
                                            </div>
                                        </div>
                                    </div>
                                  <input type="checkbox" class="filled-in" id="filled-in-box" name="" onclick="saveNewDeliveryAddress(1)">
								<label for="filled-in-box">Save Address</label>
                                </form>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
				
				<button  onclick ='proceedToPayment()' class="submit_btn btn btn-dark btn-rounded btn-sm mb-4 orange_btn" type="button">Proceed to Payment</button>
				
            </div>
            
        </div>
				  
				  
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Prev</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Next</button>
                  </div>
				  
				  
                </div>
              </div>
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                
                <div class="multisteps-form__content">
                  
				  <div class="cartpage">
    <div class="container">
	
        <div class="row gutter-lg">
            <div class="col-lg-8 pr-lg-4 mb-6">
                <table style="table-layout: fixed;" class="shop-table cart-table">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Your Order</span></th> </tr> </thead>
                    <tbody id = "final_cart">
                      
                    </tbody>
                </table>
				
				<div class="row delivery_at">
					<div class="col-lg-6">
					<h4>Delivery at</h4>
					<p id="load_current_del_address">
					</p>
					</div>
					<div class="col-lg-6">
					<h4>Delivery Slot</h4>
					<p id="expected_date"></p>
					</div>
				</div>
				
            </div>
            <div class="col-lg-4 delivery payment_col">
                 <table class="shop-table cart-table">
                    <thead> <tr> <th colspan="1" class="product-name"><span>Payments</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                           <td class="border_all"> 
								<div class="coupon-content">
								<div class="input-wrapper-inline">
									<input type="text" name="coupon_code" id = "coupon_code" class="coupon_code form-control form-control-md mb-2" placeholder="Gift card or discount code" id="coupon_code">
									<button id="cancel_coupon" class="apply_coupon button btn-rounded btn-coupon mb-2" type="button" name="cancel_coupon" value="X" onclick="removeOffers()">X</button>
									<button class="apply_coupon btn button btn-rounded btn-coupon mb-2" type="button" name="apply_coupon" value="Apply" onclick="saveOffers()">Apply</button>
								</div>
								</div>	
								<hr class="mt-2 mb-2">
								<div class="order-summary">
									<table class="order-table">
										<tbody>
											<tr class="bb-no">
												<td class="product-name">Subtotal</td>
												<td class="product-total text-right">₹<span id="final_sub_total">0.00</span></td>
											</tr>
											<tr class="bb-no">
												<td class="product-name">Discount</td>
												<td class="product-total text-right discount_amt" id="">₹<span id="discount-id">0.00</span></td>
											</tr>
											<tr class="bb-no">
												<td class="product-name">Parcel Charge</td>
												<td class="product-total text-right">₹<span id="package-id">0.00</span></td>
											</tr>
											<tr class="bb-no">
												<td class="product-name">Delivery</td>
												<td class="product-total text-right">₹<span id="delivery_cost">0.00</span></td>
											</tr>
										</tbody>
									</table>
									<hr class="mt-2">
									<table>
										<tbody>
											<tr class="cart-subtotal bb-no">
												<td class="product-name">Total</td>
												<td class="cart-price text-right">₹<span id="grand_total">0.00</span></td>
											</tr>
										</tbody>
									</table>
									<hr class="mt-2">
									<div class="payment-methods" id="">
                                        <div class="radio-item">
											<input type="radio" id="payment1" name="payment" value="payment1" checked onclick="paymentMode('1')">
											<label for="payment1">CC Avenue</label>
											<img src="assets/images/ccavenue.png" alt="">
										</div> 
										<div class="radio-item">	
											<input type="radio" id="payment2" name="payment" value="payment2" onclick="paymentMode('2')">
											<label for="payment2">Cash on Delivery</label>
										</div> 
                                        
										<button  id="ebz-checkout-btn"  class="btn btn-dark btn-rounded mb-4 orange_btn" type="button">Place Order</button>
										<script>

											document.getElementById('ebz-checkout-btn').onclick = function (e) {
												if (stock_chk_array.length === 0) {
													if (current_address_flag.trim().length == 0) { 
														document.getElementById('out_stock').click();
													}else{
														if (payementMethod !== "") {
															document.getElementById('id02').style.display = 'block';
																saveDetails();
														}
													}
												}else{
													document.getElementById('no_stock').click();
												}
											};
											
											function saveDeliveryDetails() {
                    
												var tmp_gt = document.getElementById("grand_total").innerHTML;
												var tot_Amt = (+tmp_gt) * 100;
												var amount = Math.round(tot_Amt);
												document.getElementById("gt_hidden").value = amount;
												var pm = document.getElementById("payment_method").value;
												var delivery = document.getElementById("delivery_cost").innerHTML;
												var package_chg = document.getElementById("package-id").innerHTML;
												var del_cost = document.getElementById("delivery_cost").innerHTML;
												var gt = document.getElementById("gt_hidden").value;
												var latitude  = "<?php echo $cus_lat; ?>";
												var longitude = "<?php echo $cus_long; ?>";
												var xmlhttp = new XMLHttpRequest();
												var url = "paysuccess.php?pm=" + pm + "&cart_id=" + cus_cart_id + "&branch_id="
														+ branch_id + "&user_id=" + customer_id + "&delivery=" + delivery + "&mode=" + 2 + "&package_chg=" + package_chg + "&latitude=" + latitude 
														+ "&longitude=" + longitude;
												xmlhttp.open("GET", url, true);
												xmlhttp.send();
												xmlhttp.onreadystatechange = function () {
													if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
														var myObj = xmlhttp.responseText;
														if (myObj !== "") {
															location.href = 'order_summary.php?cart_id=' + cus_cart_id;
														}
													}
												};
											}

										</script>
                                    </div>
								</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
				
			  <div class="button-row d-flex mt-4">
				<button class="btn btn-primary js-btn-prev" type="button" title="Prev">Prev</button>
				<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>
			  </div>  
			   <div id="id02" class="model_myaddress" style="display:none;">

					<form class="modal-content_123 animate" id="form_id1">
						<div>
							<img src="images/loader.gif" style="width: 50px;height: 50px;">
						</div>
					</form>
				</div>    
				<style>
					.modal-content_123 {
						/*/background-color: #fefefe;*/
						margin: 20% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
						border: 1px solid #888;
						width: 50px;
						height: 50px;
						border:0px solid;
					}
				</style>
				<input type="hidden" id="gt_hidden" name="gt_hidden" value="000">
				<input type="hidden" id="gt_total" name="gt_total" value="">
			    <input type="hidden" id="payment_method" name="payment_method" value="1" checked>
                                                          
				  
                </div>
              </div>
              <!--single form panel-->
               
            </form>
          </div>
        </div>
      </div>
    </div>
<div id="no_data">
</div>
</div> 

<div class="cspace"></div>

<script>
    function getCookie(key) {
		  let value = '';
		  document.cookie.split(';').forEach((e)=>{
			 if(e.includes(key)) {
				value = e.split('=')[1]
			 }
		  })
		return value
	}

	$(document).ready(function () {
	    var arr1 = getAllUrlParams((window.location).toString());
        var discount_amt = "<?php echo $disc_amount; ?>";
	    payementMethod = 1;
        loadCustomerSelectedItems();
		loadAllDeliveryAddress();
		getCurrentDeliveryAddress();
        loadCartCount(cus_cart_id);
		let date = new Date();
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; 
		var yyyy = today.getFullYear();
		if(dd<10) 
		{
			dd='0'+dd;
		} 

		if(mm<10) 
		{
			mm='0'+mm;
		} 
		
		var del_type = getCookie("selected_date");
		
		var selected_date = yyyy + '-' + mm + '-'+ dd;
		var cookie_name = "selected_date";
		var del_slot =  getCookie("del_slot");
		var sel_text = getCookie("del_type");
		if(del_slot === "-1" || del_slot === "" || del_slot === "undefined"){
			date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000)); 
			const expires = "expires=" + date.toUTCString();
			document.cookie = cookie_name + "=" + selected_date + "; " + expires + "; path=/";
			document.cookie = "del_slot" + "=" + -1 + "; " + expires + "; path=/";
			document.getElementById("expected_date").innerHTML = "Deliver Now";
			$("#date_time").removeClass("expand");
			$("#default").addClass("collapse");
		}else{
			$("#default").removeClass("expand");
			$("#date_time").addClass("collapse");
			document.getElementById("date").value = getCookie("selected_date");
			if(document.getElementById("date").value === ""){
				selected_date = "Today";
			}
			document.getElementById("delivery_time").value = getCookie("del_slot");
			document.getElementById("expected_date").innerHTML = getCookie("selected_date") + "<br>" + sel_text + " slot";
		}
    });
       
	var stock_chk_array = [];
	
    function loadFinalizedCart() {
		stock_chk_array = [];
		grand_sub_total = 0;
		$('#final_cart').empty();
		var information = "";
		var arr1 = getAllUrlParams((window.location).toString());
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200)
			{
				var myObj = JSON.parse(this.responseText);
				if (myObj.length > 0) {
					if (+myObj !== -1) {
						grand_sub_total = 0;
						pkg_price = 0;
						var cart_count = myObj.length;
						for (var i = 0; i < myObj.length; i++) {
							var cover_photo = myObj[i].image;
							var image_path = "";
							var stock_chk = "";
							if (myObj[i].stock_chk === "0") {
								stock_chk = "";
							} else {
								stock_chk = "<p style='color:red;'>(Not Available)</p>";
								stock_chk_array.push(myObj[i].menu_id);
							}
							if (cover_photo !== "")
							{
								image_path = dirname + cover_photo.replace("../", "");
							} else
							{
								image_path = 'images/default.jpg';
							}
							var total_price = "";
							var tax_tag = "";
							if (+myObj[i].tax !== 0) {
								tax_tag = "(Inclusive Item Tax)";
								total_price = (+myObj[i].quantity * +myObj[i].mod_price) + +myObj[i].tot_price + (+myObj[i].tot_price / 100 * +myObj[i].tax);
								grand_sub_total = +grand_sub_total + +total_price;
							} else {
								tax_tag = "";
								total_price = (+myObj[i].quantity * +myObj[i].mod_price) + +myObj[i].tot_price;
								grand_sub_total = +grand_sub_total + +total_price;
							}
							var modifiers = "";
							var mod_title = "";
							var mod_items = "";
							var replace_name = "";
							var replace_title = "";
							var replace_display = "";
							if (myObj[i].selectedMods === "")
							{
								mod_title = "none";
								mod_items = "none";
								modifiers = " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
							} else {
								modifiers = myObj[i].selectedMods;
								mod_title = "inline-block";
								mod_items = "block";
							}


							if (myObj[i].name !== myObj[i].replace_name) {
								replace_name = " (" + myObj[i].replace_name + ")";
							} else {
								replace_name = "";
							}
							var tot_pkg_price = "";
							if (myObj[i].packing_charge !== "" || myObj[i].packing_charge !== null) {
								tot_pkg_price = parseFloat(myObj[i].packing_charge) * parseInt(myObj[i].quantity);
								pkg_price = +pkg_price + +tot_pkg_price;
							}
		                    
							var indString = myObj[i].net_weight;
							var substring = "-";
							var net_weight = "";

							if(indString.includes(substring)){ // true
								var index = indString.indexOf("-");  // Gets the first index where a space occours
								var first_part = indString.substr(0, index); // Gets the first part
								var sec_part = indString.substr(index + 1);  
								net_weight = (+first_part * +myObj[i].quantity) + "-" + (+sec_part * +myObj[i].quantity);
                            }else{
								net_weight = +myObj[i].net_weight * +myObj[i].quantity;
							}
							
							var stock_chk = "";
							if(myObj[i].stock_chk !== "0"){
								stock_chk = "<span style='color:#E0522D;'>&nbsp;&nbsp;&nbsp;(Out of Stock)</span>";
							}else{
								stock_chk = "";
							}
							information = information + "<tr id = 'div_id_" + myObj[i].cart_item_id  + "'>" +
											"<td class='product-thumbnail  col-xs-2>" +
											"<div class='p-relative'>" +
											"<a>" +
											"<figure>" +
											"<img src='" + image_path + "' onerror='imgError(this);' alt='product'>" +
											"</figure>" +
											"</a>" +
											"</div>" +
											"</td>" +
											"<td class='product-name' style='white-space: normal !important;'>" +
								  			"<a>" + myObj[i].name + "</a>" +
											"<span class='cross'>x" + myObj[i].quantity +  stock_chk  + "</span>" +
											"<div  class='product-price'>" +
	                                        "<ins class='new-price'>" + total_price.toFixed(2) + "</ins>" +
											"<span class='gms'>" + (+net_weight).toFixed(1) + " " + myObj[i].measure + "</span>" +
											"</div>" +
                                            "</td>" +
                                            "</tr>";


						}
						$('#final_cart').empty();
						$('#final_cart').append(information);
                        document.getElementById("final_sub_total").innerHTML = "";
						document.getElementById("final_sub_total").innerHTML = (+grand_sub_total).toFixed(2);
						document.getElementById('package-id').innerHTML = (+pkg_price).toFixed(2);
                        discount_amt = "<?php echo $disc_amount;?>";
						var disc_name = "<?php echo $discount_name;?>";
						if (disc_name !== "") {
							document.getElementById("coupon_code").value = disc_name;
							document.getElementById("coupon_code").setAttribute("disabled", true);
							document.getElementById("cancel_coupon").style.display = "block";
						} else {
							document.getElementById("coupon_code").removeAttribute("disabled", false);
							document.getElementById("cancel_coupon").style.display = "none";
						}
                        delivery_cost = "<?php echo $delivery_charge; ?>";
                        document.getElementById("delivery_cost").innerHTML = (+delivery_cost).toFixed(2);
						document.getElementById("discount-id").innerHTML = (+discount_amt).toFixed(2);
                        document.getElementById("grand_total").innerHTML = (+grand_sub_total - +discount_amt + +delivery_cost + +pkg_price).toFixed(2);
                     	} else {
					}
				} else
				{
				    document.getElementById("cart_container").style.display = "none";
					$('#no_data').append("<div class='row' style='height: 100%; text-align: left; border: 1px solid #e6e6e6; padding-left: 0px; padding-right: 0px; border-radius: 10px; margin-bottom: 10px;'><div class='col-lg-12'><p style='padding: 20px; text-align: center;'>Your cart is empty. Add products from the <a onclick='gotoHome()' style='text-decoration: underline;'> Menu</a></p></div></div>");
                }
			}
		};
        var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
		xhttp.open("GET", url, true);
		xhttp.send();
	}


	function setCookie(cName, expDays,flag) {
			let date = new Date();
			var today = new Date();
			today.setHours(today.getHours() + 4);
			var selected_slot = "";
			var selected_date = "";
			var cookie_name = "";
			var sel_text = "Deliver Now";
			if(flag === 1){
				selected_slot = -1;
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; 
				var yyyy = today.getFullYear();
				if(dd<10) 
				{
					dd='0'+dd;
				} 

				if(mm<10) 
				{
					mm='0'+mm;
				} 
				selected_date = yyyy + '-' + mm + '-'+ dd;
				document.getElementById("expected_date").innerHTML = sel_text;
			}else{
			    selected_slot = document.getElementById("delivery_time").value;
				selected_date = document.getElementById("date").value;
				sel_text = $("#delivery_time option:selected").text();
				if(selected_date === ""){
					selected_date = "Today";
				}
				document.getElementById("expected_date").innerHTML = selected_date + "<br>" + sel_text + " slot";
			}
			cookie_name = "selected_date";
			date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
			const expires = "expires=" + date.toUTCString();
			document.cookie = cName + "=" + selected_slot + "; " + expires + "; path=/";
			document.cookie = cookie_name + "=" + selected_date + "; " + expires + "; path=/";
			document.cookie = "del_type" + "=" + sel_text + "; " + expires + "; path=/";
			
	}

    var current_address_flag = "";
		
	function proceedToPayment() {
		var xmlhttp = new XMLHttpRequest();
		var url = "api/loadDeliveryAddress.php?action=get_current_delivery_address";
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = JSON.parse(this.responseText);
				if (myObj.length !== 0) {
			 		for (var i = 0; i < myObj.length; i++) {
						current_address_flag = myObj[i].delivery_address; 	
					}
				}
				if (current_address_flag.trim().length == 0) { 
				    document.getElementById('out_stock').click();
				} else { 
				    $("#proceed_to_payment").trigger("click");
				}
			}
		};
	}
	
	function checkAddress() {
		var curr_Address = "";
		var xmlhttp = new XMLHttpRequest();
		var url = "api/loadDeliveryAddress.php?action=get_current_delivery_address";
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = JSON.parse(this.responseText);
				if (myObj.length !== 0) {
			 		for (var i = 0; i < myObj.length; i++) {
						curr_Address = myObj[i].delivery_address; 	
					}
				}
				if (curr_Address.trim().length == 0) { 
				    document.getElementById('out_stock').click();
				} 
			}
		};
	}

</script>
<script  src="assets/js/script.js"></script>
<a href="#myModal1" id="out_stock" style="visibility:hidden;" class="button btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded ml-3 mt-2"></a>								
<div id="myModal1" class="overlay">
    <div class="popup">
         <a id ="close_btn2" style="display:none;" class="close" href="#">&times;</a>
        <div class="content">
            <form class="form account-details-form" action="" method="post">
				<div class="row" style="text-align:center;"><h3>Please select delivery address</h3></div>
					<div class="row">
					<div class="form-group" style="margin-top:40px;text-align:center;">
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="document.getElementById('close_btn2').click();">OK</button>
					</div>			
				</div>
			</form>
        </div>
    </div>
</div>

<a href="#myModal2" id="no_stock" style="visibility:hidden;" class="button btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded ml-3 mt-2"></a>								
<div id="myModal2" class="overlay">
    <div class="popup">
         <a id ="close_btn3" style="display:none;" class="close" href="#">&times;</a>
        <div class="content">
            <form class="form account-details-form" action="" method="post">
				<div class="row" style="text-align:center;"><h3>Sorry !! Few items are out of stock Please remove them from the cart .</h3></div>
					<div class="row">
					<div class="form-group" style="margin-top:40px;text-align:center;">
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="document.getElementById('close_btn3').click();">OK</button>
					</div>			
				</div>
			</form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
