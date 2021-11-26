var grand_sub_total = 0;
var pkg_price = 0;
var mobile = "";

function loadTopCategories() {
    var name = "";
    var image_path ="";
    var icon ="";
    var information = "";
	$('#top_container').empty();
    var xmlhttp = new XMLHttpRequest();
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    var url = "api/getTopCategories.php?action=get_top_categories&branch_id=" + branch_id;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            if (myObj.length !== 0) {
                for (var i = 0; i < 7; i++) {
                    icon = myObj[i].icon;
                    name = myObj[i].name;
                    if (icon !== "")
                    {
                        image_path = dirname +  icon.replace("../", "");
                    } else
                    {
                        image_path = 'images/default.jpg';
                    }
                    information = information + "<div class='category'>" +
					                                "<figure class='category-media'>" +
													      "<a href='products.php?category_id=" + myObj[i].id + "'>" +
														       "<img onerror='onImgError(this)' src=" + image_path + " alt=" + name + ">" +
														       "<h4 class='category-name'>" + name + "</h4>" +
														  "</a>" +
												    "</figure>" + 
												"</div>";
                }
                $('#top_container').append(information);
            } else {
                $('#top_container').append("<center>No Categories found<\center>");
            }
        }
    };
}

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
					grand_sub_total = 0;
					if (myObj.length > 0 && +myObj !== -1) {
							pkg_price = 0;
							var cart_count = myObj.length;
							document.getElementById("cart_count").innerHTML = cart_count;
			
							for (var i = 0; i < myObj.length; i++) {
								var cover_photo = myObj[i].image;
								var image_path = "";
								var stock_chk = "";
								if (cover_photo !== "")
								{
									image_path = dirname + cover_photo.replace("../", "");
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
									var reduced_price = +myObj[i].price - (+myObj[i].disc_per / 100) * (+myObj[i].price); 
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
																"<button onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")'  class='quantity-plus w-icon-plus'></button>" +
																"<button onclick='redQtyFromCart(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",0," + myObj[i].quantity + ")'  class='quantity-minus w-icon-minus'></button>" +
															"</div>" +
															"<div class='price-box'>" +
																"<span class='product-price'><ins class='new-price'>" + total_price + "</ins></span>" +
															"</div>" +
														"</div>" +
													"</div>" +
													"<button class='btn btn-link btn-close' aria-label='button'>" +
															"<i class='fas fa-times' onclick='redQtyFromCart(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",1," + myObj[i].quantity + ")'   ></i>" +
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
						document.getElementById("subtotal_cart_container").innerHTML = "";
						document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
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

			if (item_list.length > 0) {
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
														"<button onclick='saveItemDetails(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + encodeURIComponent(item_name) + "\", "  + pkg_charge +  ",\"" + encodeURIComponent(image_path) + "\")'  class='quantity-plus w-icon-plus'></button>" +
														"<button onclick='redQtyFromCart(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + encodeURIComponent(item_name) + "\", "  + pkg_charge +  ",0," + sel_qty + ")'  class='quantity-minus w-icon-minus'></button>" +
													"</div>" +
													"<div class='price-box'>" +
														"<span class='product-price'><ins class='new-price'>" + total_price + "</ins></span>" +
													"</div>" +
												"</div>" +
											"</div>" +
											"<button class='btn btn-link btn-close' aria-label='button'>" +
												"<i class='fas fa-times' onclick='redQtyFromCart(" + menu_id + ", "  + customer_id +  "," + price +  ",\"" + encodeURIComponent(item_name) + "\", "  + pkg_charge +  ",1," + sel_qty + ")' ></i>" +
											"</button>" +
										"</div><hr class='product-divider'>";
					$('#cart_items_container').empty();
					$('#cart_items_container').append(information);
					document.getElementById("subtotal_cart_container").innerHTML = "";
					document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
				}
			} else {
			    $('#cart_items_container').empty();
				$('#cart_items_container').append("No Items Added");
				document.getElementById("subtotal_cart_container").innerHTML = "";
				document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
			}
		}else {
			$('#cart_items_container').empty();
			$('#cart_items_container').append("No Items Added");
			document.getElementById("subtotal_cart_container").innerHTML = "";
			document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
		}
}

var timeLeft = 0;
var elem = "";
var timerId = 0;
var mobile = "";
			
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
			
			if (+this.responseText === 1) {
				document.getElementById('login_popup').style.display = 'none';
				document.getElementById('otp_popup').style.display = 'block';
				document.getElementById('timer').style.display = 'block';
				timeLeft = 60;
				elem = document.getElementById('timer');
				timerId = setInterval(countdown, 1000);
			} else {
				document.getElementById('login_dialog').style.display = 'none';
			}
		}
	};

	var url = "api/SMSLoginVerification.php?action=loginValid1&loginNumber=" + loginNumber;
	xhttp.open("GET", url, true);
	xhttp.send();
}

function countdown() {
	if (timeLeft === 0) {
		clearTimeout(timerId);
		doSomething();
	} else {
		elem.innerHTML = timeLeft + ' seconds remaining';
		timeLeft--;
	}
}

function doSomething() {
	elem.innerHTML = "";
	elem.innerHTML = 'OTP Expired';
	document.getElementById('resendOTP').style.display = 'block';
	document.getElementById('invalid_otp').style.display = 'none';
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
				if (status === "OTPSuccess") {
					document.cookie = "user_id=" +  myObj[0].user_id + "; expires=Wed, 01 Jan 2100 12:00:00 UTC";
					document.cookie = "mobile_no=" +  myObj[0].mobile_no + "; expires=Wed, 01 Jan 2100 12:00:00 UTC";
					document.cookie = "email_id=" +  myObj[0].email_id + "; expires=Wed, 01 Jan 2100 12:00:00 UTC";
					document.cookie = "user_name=" +  myObj[0].user_name + "; expires=Wed, 01 Jan 2100 12:00:00 UTC";
					document.cookie = "cart_id=" +  myObj[0].cart_id + "; expires=Wed, 01 Jan 2100 12:00:00 UTC";
					document.getElementById('login_dialog').style.display = 'none';
					if ($.cookie("item_list") !== undefined) {
						saveCookieData(customer_id,branch_id);
					}else{
						window.location.href = "cart.php?branch_id=" + branch_id;
					}
				}else{
					document.getElementById('invalid_otp').style.display = 'block';
				} 
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
	document.getElementById('invalid_otp').style.display = 'none';
	var mobile = document.getElementById('contact_no').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			if (+this.responseText === 1) {
				timeLeft = 60;
				document.getElementById('resendOTP').style.display = 'none';
				document.getElementById('timer').style.display = 'block';
				elem = document.getElementById('timer');
				timerId = setInterval(countdown, 1000);
			}
		}
	};

	var url = "api/SMSLoginVerification.php?action=loginValid1&loginNumber=" + mobile;
	xhttp.open("GET", url, true);
	xhttp.send();
}