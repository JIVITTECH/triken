var grand_sub_total = 0;
var pkg_price = 0;
var mobile = "";

//To be replaced by dynamic values from session
function loadCartData() {
		$('#cart_items_container').empty();
		document.getElementById("cart_count").innerHTML = "0";
		var information = "";
		var arr1 = getAllUrlParams((window.location).toString());
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
				if (this.readyState === 4 && this.status === 200)
				{
					var myObj = JSON.parse(this.responseText);
					if (myObj.length > 0) {
							grand_sub_total = 0;
							pkg_price = 0;
							var cart_count = myObj.length;
							document.getElementById("cart_count").innerHTML = cart_count;
			
							for (var i = 0; i < myObj.length; i++) {
								var cover_photo = myObj[i].image;
								var image_path = "";
								var stock_chk = "";
								if (cover_photo !== "")
								{
									image_path = dirname + cover_photo;
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
								
								var tot_pkg_price = "";
								if (myObj[i].packing_charge !== "" || myObj[i].packing_charge !== null) {
									tot_pkg_price = parseFloat(myObj[i].packing_charge) * parseInt(myObj[i].quantity);
									pkg_price = +pkg_price + +tot_pkg_price;
								}
								
								var price = +myObj[i].quantity * +myObj[i].price;
								
								var discount_price = 0;
								var act_price = 0;
								
								if(myObj[i].disc_per !== ""){
									var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
									discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>";
									act_price = reduced_price.toFixed(2);
								}else{
									discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
									act_price = +myObj[i].price;
								}
						
								information = information +  "<div class='product product-cart'>" +
													"<figure class='product-media'>" +
														"<a href='#'>" +
															 "<a href='#'><img src = '" + image_path + "' onerror='imgError(this);' alt='Product'/> </a>" +
														"</a>" +
													"</figure>" +
													"<div class='product-detail'>" +
														"<a href='#' class='product-name'>" + myObj[i].name + "</a>" +
														"<div class='product-qty-form mb-2 mr-2'>" +
															"<div class='input-group'>" +
																"<input class=' form-control' value =  " + myObj[i].quantity + " type='number'>" +
																"<button onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")'  class='quantity-plus w-icon-plus'></button>" +
																"<button onclick='redQtyFromCart(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",0," + myObj[i].quantity + ")'  class='quantity-minus w-icon-minus'></button>" +
															"</div>" +
															"<div class='price-box'>" +
																"<span class='product-price'><ins class='new-price'>" + total_price + "</ins></span>" +
															"</div>" +
														"</div>" +
													"</div>" +
													"<button class='btn btn-link btn-close' aria-label='button'>" +
															"<i class='fas fa-times' onclick='redQtyFromCart(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",1," + myObj[i].quantity + ")'   ></i>" +
													"</button>" +
												"</div><hr class='product-divider'>";
							$('#cart_items_container').empty();
							$('#cart_items_container').append(information);
							document.getElementById("subtotal_cart_container").innerHTML = "";
							document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
							}
					} else
					{
						$('#cart_items_container').empty();
						$('#cart_items_container').append("No Items Added");
					}
				}
			};
			var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
			xhttp.open("GET", url, true);
			xhttp.send();
		}
                
function loadCartDataFromCookie() {
		$('#cart_items_container').empty();
		document.getElementById("cart_count").innerHTML = "0";
		item_list_array = [];
		var information = "";
		var grand_sub_total = 0;
		var arr1 = getAllUrlParams((window.location).toString());
		if ($.cookie("item_list") !== undefined) {
			var item_list = $.parseJSON($.cookie("item_list"));
			$.cookie("item_list", JSON.stringify(item_list));
			document.getElementById("cart_count").innerHTML = item_list.length;
			for (var i = 0; i < item_list.length; i++) {
				var items = "";
				var menu_id = item_list[i].menu_id;
				var sel_qty = item_list[i].quantity;
				var price = item_list[i].price;
				var item_name = item_list[i].item_name;
				var pkg_charge = item_list[i].pkg_charge;
				var image_path = item_list[i].image_path;
				items = {
					'menu_id': menu_id,
					'price': price,
					'quantity': sel_qty,
					'item_name': item_name,
					'pkg_charge' : pkg_charge,
					'image_path' : image_path,
				};
				
				var total_price = +sel_qty * +price;
			    grand_sub_total = grand_sub_total + +total_price;
				item_list_array.push(items);
				information = information +  "<div class='product product-cart'>" +
										"<figure class='product-media'>" +
											"<a href='#'>" +
												 "<a href='#'><img src = '" + image_path + "' onerror='imgError(this);' alt='Product'/> </a>" +
											"</a>" +
										"</figure>" +
										"<div class='product-detail'>" +
											"<a href='#' class='product-name'>" + item_name + "</a>" +
											"<div class='product-qty-form mb-2 mr-2'>" +
												"<div class='input-group'>" +
													"<input class=' form-control' value =  " + sel_qty + " type='number'>" +
													"<button onclick='saveItemDetails(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + item_name + "\", "  + pkg_charge +  ",\"" + image_path + "\")'  class='quantity-plus w-icon-plus'></button>" +
													"<button onclick='redQtyFromCart(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + item_name + "\", "  + pkg_charge +  ",0," + sel_qty + ")'  class='quantity-minus w-icon-minus'></button>" +
												"</div>" +
												"<div class='price-box'>" +
													"<span class='product-price'><ins class='new-price'>" + total_price + "</ins></span>" +
												"</div>" +
											"</div>" +
										"</div>" +
										"<button class='btn btn-link btn-close' aria-label='button'>" +
											"<i class='fas fa-times' onclick='redQtyFromCart(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + item_name + "\", "  + pkg_charge +  ",1," + sel_qty + ")' ></i>" +
										"</button>" +
									"</div><hr class='product-divider'>";
				$('#cart_items_container').empty();
				$('#cart_items_container').append(information);
				document.getElementById("subtotal_cart_container").innerHTML = "";
				document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
		}
	}else
	{
		$('#cart_items_container').empty();
		$('#cart_items_container').append("No Items Added");
	}
}

function loginValid() {
	var loginNumber = "";
	loginNumber = document.getElementById('phone').value;
	if (loginNumber === "") {
		loginNumber = document.getElementById('phone').value;
		mobile = loginNumber;
	}
	document.getElementById('contact_no').value = loginNumber;	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			
			if (this.responseText === "success") {
				document.getElementById('login_dialog').style.display = 'none';
				document.getElementById('otp_btn').click();
			} else {
				document.getElementById('login_dialog').style.display = 'none';
			}
		}
	};

	var url = "api/SMSLoginVerification.php?action=loginValid1&loginNumber=" + loginNumber;
	xhttp.open("GET", url, true);
	xhttp.send();
}

function checkUserSession(){
	if (customer_id !== -1) {
		window.location.href = "cart.php?branch_id=" + branch_id;
	} else { 
		document.getElementById('login').click();	
	}
}

function verifyOTP() {
	if (!OTPVerification()) {
		return;
	}
	var arr1 = getAllUrlParams((window.location).toString());
	var otpchar = document.getElementById('otp').value;
	var mobile = document.getElementById('contact_no').value;
	var bcount = "";
	var status = "";
	var customer_id =  "";
	if (otpchar.trim().length === 0) {
		document.getElementById('otp').style.backgroundColor = '#efefc1';
		document.getElementById('otp').title = 'Enter the Valid OTP';
		return;
	} else {
		document.getElementById('otp').style.backgroundColor = '#f2f2f2';
		document.getElementById('otp').title = '';
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length > 0) {
				bcount = myObj[0].b_count;
				status = myObj[0].status;
				customer_id = myObj[0].user_id;
			}
			if (status === "OTPSuccess") {
				document.getElementById('otp_dialog').style.display = 'none';
				window.location.href = "my-account.php";
			} 
		}
	};

	var url = "api/SMSLoginVerification.php?action=loginValid2&otpchar=" + otpchar + "&mobile=" + mobile;
	xhttp.open("GET", url, true);
	xhttp.send();
}

function OTPVerification() {
	var valid = true;
	var otp = document.getElementById('otp').value;

	if (otp.trim().length === 0) {
		document.getElementById('otp').style.backgroundColor = '#efefc1';
		document.getElementById('otp').title = 'Enter the Valid OTP';
		valid = false;
	} else {
		document.getElementById('otp').style.backgroundColor = '#f2f2f2';
		document.getElementById('otp').title = '';
	}

	return valid;

}
      
function resendOTP() {
	document.getElementById('otp').value = '';
	var mobile = document.getElementById('contact_no').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			if (this.responseText === "success") {
				
			}
		}
	};

	var url = "api/SMSLoginVerification.php?action=loginValid1&loginNumber=" + mobile;
	xhttp.open("GET", url, true);
	xhttp.send();
}
