<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' '; 
$pageCanonical = '';
$url = ' '; 
$page ="Personal Details";
include('header.php');
include('main.php');

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

$branch_add = "SELECT * from kot_branch_details where branch_id = $branch ";
$bran_res = mysqli_query($conn, $branch_add);
$count_branch = mysqli_num_rows($bran_res);
if ($count_branch !== 0) {
    while ($qry3 = mysqli_fetch_array($bran_res)) {
        $latitude = $qry3['latitude'];
        $longitude = $qry3['longitude'];
    }
}

$del_address = "SELECT delivery_address,latitude,longitude   
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
       
<div class="cartpage">
    <div class="container" id="cart_container">
			
	<div class="multisteps-form">
        <!--progress bar-->
        <div class="row">
          <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
            <div class="multisteps-form__progress">
              <button class="multisteps-form__progress-btn js-active" type="button" title="Cart"><span>Cart</span></button>
              <button class="multisteps-form__progress-btn" type="button" title="Personal Details"><span>Personal Details</span></button>
              <button class="multisteps-form__progress-btn" type="button" title="Payment Details" onclick="loadFinalizedCart()"><span>Payment Details</span></button>
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
                <table class="shop-table cart-table">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Products</span></th> </tr> </thead>
                    <tbody id = "selected_items">
                    </tbody>
                </table>
                <div class="btn-continue">
                    <a href="#" class="btn btn-block "> <i class="w-icon-long-arrow-left"></i> Continue Shipping </a>
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
                                                        <a href="#payment" class="collapse">Deliver Now (120 mins)</a>
                                                    </div>
                                                    <div id="payment" class="card-body expanded">
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" class="expand">Pickup Date & Time</a>
                                                    </div>
                                                    <div id="cash-on-delivery" class="card-body collapsed">
                                                        <form>
                                 <input placeholder="Select your delivery date" class="form-control" type="date"  id="date" >
                                
                                
                                <div class="form-group">
                                                <div class="select-box">
                                                    <select name="state" class="form-control form-control-md">
                                                        <option value="default" selected="selected">Select your delivery time
                                                        </option>
                                                        <option value="slot1">7-9 AM</option>
                                                        <option value="slot2">9-11 AM</option>
                                                        <option value="slot3">11-01 PM</option>
                                                        <option value="slot4">1-3 PM</option>
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

                                <button  class="btn btn-block btn-checkout"> Checkout </button> 
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
                                <div class="ecommerce-address billing-address saved-address">
									<div class="radio-item address">
										<input type="radio" id="address1" name="address" value="address1" checked>
										<label for="address1">41/2,SRC Sunrise,2nd Floor, Post, Vivekanandha Nagar, Singanallur, Tamil Nadu 641005</label>
										<br>
										<a href="#" class="btn btn-link btn-underline btn-icon-right" style="color: #E0522D;text-transform: inherit;">Edit</a>
									</div>
										<hr>
									<div class="radio-item address">
										<input type="radio" id="address2" name="address" value="address2">
										<label for="address2">358 Pudur Coimbatore Coimbatore Tamil Nadu 641015 India</label>
										<br>
									</div>
									<div class="radio-item address">
										<input type="radio" id="address3" name="address" value="address3">
										<label for="address3">358 Pudur Coimbatore Coimbatore Tamil Nadu 641015 India</label>
										<br>
									</div>
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
                                  <input type="checkbox" class="filled-in" id="filled-in-box" name="" checked>
								<label for="filled-in-box">Save Address</label>
                                </form>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
				
				<button  class="submit_btn btn btn-dark btn-rounded btn-sm mb-4 orange_btn">Proceed to Payment</button>
				
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
                <table class="shop-table cart-table">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Your Order</span></th> </tr> </thead>
                    <tbody id = "final_cart">
                      
                    </tbody>
                </table>
				
				<div class="row delivery_at">
					<div class="col-lg-6">
					<h4>Delivery at</h4>
					<p>41/2,SRC Sunrise,2nd Floor, Post, 
					Vivekanandha Nagar, Singanallur, 
					Tamil Nadu 641005</p>
					</div>
					<div class="col-lg-6">
					<h4>Delivery Slot</h4>
					<p>01/10/2021	<br>7-9 AM slot</p>
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
									<button  class="apply_coupon btn button btn-rounded btn-coupon mb-2" name="apply_coupon" value="Apply" onclick="saveOffers()">Apply</button>
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
									<div class="payment-methods" id="payment_method">
                                        <div class="radio-item">
											<input type="radio" id="payment1" name="payment" value="payment1" checked>
											<label for="payment1">CC Avenue</label>
											<img src="assets/images/ccavenue.png" alt="">
										</div> 
										<div class="radio-item">	
											<input type="radio" id="payment2" name="payment" value="payment2">
											<label for="payment2">Cash on Delivery</label>
										</div> 
                                        
										<button class="submit_btn btn btn-dark btn-rounded mb-4 orange_btn">Place Order</button>
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
	$(document).ready(function () {
	    var arr1 = getAllUrlParams((window.location).toString());
        var discount_amt = "<?php echo $disc_amount; ?>";
		loadCustomerSelectedItems();
        loadCartCount(cus_cart_id);
    });

    function loadFinalizedCart() {
		grand_sub_total = 0;
		$('#final_cart').empty();
		var information = "";
		var arr1 = getAllUrlParams((window.location).toString());
		var branch_id = 1;
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
								image_path = '../ecaterweb/Catering/' + cover_photo;
								;
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
		
                            information = information + "<tr id = 'div_id_" + myObj[i].cart_item_id  + "'>" +
											"<td class='product-thumbnail  col-xs-2 text-right'>" +
											"<div class='p-relative'>" +
											"<a href='#'>" +
											"<figure>" +
											"<img src='" + image_path + "' onerror='imgError(this);' alt='product'>" +
											"</figure>" +
											"</a>" +
											"</div>" +
											"</td>" +
											"<td class='product-name'>" +
								  			"<a href='#'>" + myObj[i].name + "</a>" +
											"<span class='cross'>x" + myObj[i].quantity + "</span>" +
											"<div  class='product-price'>" +
	                                        "<ins class='new-price'>" + total_price.toFixed(2) + "</ins>" +
											"<span class='gms'>" + myObj[i].net_weight + " " + myObj[i].measure + "</span>" +
											"</div>" +
                                            "</td>" +
                                            "</tr>";


						}
						$('#final_cart').empty();
						$('#final_cart').append(information);
                        document.getElementById("final_sub_total").innerHTML = "";
						document.getElementById("final_sub_total").innerHTML = (+grand_sub_total).toFixed(2);
                        discount_amt = "<?php echo $disc_amount;?>";
						var disc_name = "<?php echo $discount_name;?>";
						if (disc_name !== "") {
							document.getElementById("coupon_code").value = disc_name;
						}
                        delivery_cost = "<?php echo $delivery_charge; ?>";
                        document.getElementById("delivery_cost").innerHTML = (+delivery_cost).toFixed(2);
						document.getElementById("discount-id").innerHTML = (+discount_amt).toFixed(2);
                        document.getElementById("grand_total").innerHTML = (+grand_sub_total - +discount_amt + +delivery_cost).toFixed(2);
                     	} else {
					}
				} else
				{
				    document.getElementById("cart_container").style.display = "none";
					$('#no_data').append("<div class='row' style='height: 100%; text-align: left; border: 1px solid #e6e6e6; padding-left: 0px; padding-right: 0px; border-radius: 10px; margin-bottom: 10px;'><div class='col-lg-12'><p style='padding: 20px; text-align: center;'>Your cart is empty. Add something from the <a onclick='exploreMenu()' style='text-decoration: underline;'> Menu</a></p></div></div>");
                }
			}
		};
        var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
		xhttp.open("GET", url, true);
		xhttp.send();
	}


</script>
<script  src="assets/js/script.js"></script>

<?php include('footer.php'); ?>