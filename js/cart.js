	var grand_sub_total = 0;
	var delivery_cost = 0;
	var stock_chk_array = [];
	var pkg_price = 0;
	var payementMethod = "";
    var discount_amt = 0;

//To be replaced by dynamic values from session
    function loadCustomerSelectedItems() {
		grand_sub_total = 0;
		$('#selected_items').empty();
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
							if (cover_photo !== "")	{
								image_path = dirname + cover_photo.replace("../", "");
							} else {
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
											"<td class='product-thumbnail'>" +
											"<div class='p-relative'>" +
											"<a>" +
											"<figure>" +
											"<img src='" + image_path + "' onerror='imgError(this);' alt='product'>" +
											"</figure>" +
											"</a>" +
											"</div>" +
											"</td>" +
											"<td class='product-name'>" +
								  			"<a>" + myObj[i].name +  stock_chk +"</a>" +
                                            "<div  class='product-price'>" +
	                                        "<ins id = 'price_" + myObj[i].cart_item_id  + "' class='new-price'>" + total_price.toFixed(2) + "</ins>" +
								            "<span class='gms'>" + net_weight + " " + myObj[i].measure + "</span>" +
								            "</div>" +
                                            "</td>" +
                                            "<td class='product-quantity'>" +
                                            "<div class='input-group'>" +
                                            "<input id = 'qty_" + myObj[i].menu_id  + "' class=' form-control' type='number'  value = '" + myObj[i].quantity + "' readonly>"  +
                                            "<button type='button' class='quantity-plus w-icon-plus' href='#' onclick='IncreaseItemQuantity(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "<button type='button' class='quantity-minus w-icon-minus' href='#' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "</div>" +
                                            "<span class='remove' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + ",1," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")'> <a> Remove </a> </span>" +
                                            "</td>" +
                                            "</tr>";
						}
						$('#selected_items').empty();
						$('#selected_items').append(information);
             			document.getElementById("sub_total").innerHTML = "";
						document.getElementById("sub_total").innerHTML = (+grand_sub_total).toFixed(2);
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

	
    function IncreaseItemQuantity(menu_id, price, quantity, cart_item_id, packing_charge) {
		var arr1 = getAllUrlParams((window.location).toString());
		var cart_id = cus_cart_id;
		var qty = +quantity + 1;
		document.getElementById("qty_" + menu_id + "").value = qty;
		var xmlhttp = new XMLHttpRequest();
		var url = "api/IncreaseItemQuantity.php?menu_id=" + menu_id + "&customer_id=" + customer_id + "&quantity=" + qty + "&branch_id=" + branch_id + "&price=" + price + "&cus_cart_id=" + cart_id + "&cart_item_id=" + cart_item_id + "&packing_charge=" + packing_charge;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				loadAlteredItem(cart_item_id);
			}
		};
	}

    function redQty(menu_id, price, quantity, cart_item_id, packing_charge) {
		if (quantity > 1) {
			quantity = quantity - 1;
			document.getElementById("qty_" + menu_id + "").value = quantity;
			RemoveFromCart(menu_id, customer_id, price, quantity, cart_item_id, packing_charge);
		} else if (quantity === 1) {
			quantity = quantity - 1;
			RemoveFromCart(menu_id, customer_id, price, quantity, cart_item_id, packing_charge);
			$('#div_id_' + cart_item_id + '').empty();
		}
	}

    function RemoveFromCart(menu_id, customer_id, price, quantity, cart_item_id, packing_charge) {
		var arr1 = getAllUrlParams((window.location).toString());
		var cart_id = cus_cart_id;
		var qty = quantity;
		var xmlhttp = new XMLHttpRequest();
		var url = "api/RemoveFromCartList.php?menu_id=" + menu_id + "&customer_id=" + customer_id + "&quantity=" + qty + "&branch_id=" + branch_id + "&price=" + price + "&cus_cart_id=" + cart_id + "&cart_item_id=" + cart_item_id + "&packing_charge=" + packing_charge;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				if (myObj !== "") {
					loadCartCount(cus_cart_id);
					loadAlteredItem(cart_item_id);
				}
			}
		};
	}

    function loadAlteredItem(cart_item_id) {
		grand_sub_total = 0;
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
						
						if (cover_photo !== "")	{
						    image_path = dirname + cover_photo.replace("../", "");
						} else {
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
						var tot_pkg_price = 0;
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
		
						if (+myObj[i].cart_item_id === cart_item_id) {
							$('#div_id_' + myObj[i].cart_item_id  + '').empty();
							
							information = information + "<td class='product-thumbnail'>" +
											"<div class='p-relative'>" +
											"<a>" +
											"<figure>" +
											"<img src='" + image_path + "' onerror='imgError(this);' alt='product'>" +
											"</figure>" +
											"</a>" +
											"</div>" +
											"</td>" +
											"<td class='product-name'>" +
								  			"<a>" + myObj[i].name + stock_chk +"</a>" +
                                            "<div  class='product-price'>" +
	                                        "<ins id = 'price_" + myObj[i].cart_item_id  + "' class='new-price'>" + total_price.toFixed(2) + "</ins>" +
								            "<span class='gms'>" + net_weight + " " + myObj[i].measure + "</span>" +
								            "</div>" +
                                            "</td>" +
                                            "<td class='product-quantity'>" +
                                            "<div class='input-group'>" +
                                            "<input id = 'qty_" + myObj[i].menu_id  + "' class=' form-control' type='number'  value = '" + myObj[i].quantity + "' readonly>"  +
                                            "<button type='button' class='quantity-plus w-icon-plus' href='#' onclick='IncreaseItemQuantity(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "<button type='button' class='quantity-minus w-icon-minus' href='#' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "</div>" +
                                            "<span class='remove' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + ",1," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")'> <a> Remove </a> </span>" +
                                            "</td>";
						    
							$('#div_id_' + myObj[i].cart_item_id  + '').append(information);
						}
					}
					document.getElementById("sub_total").innerHTML = "";
					document.getElementById("sub_total").innerHTML = (+grand_sub_total).toFixed(2);
				} 
				loadCartData();
			}
		};
		var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
		xhttp.open("GET", url, true);
		xhttp.send();
	}

	function loadCartCount(cart_id) {
		var arr1 = getAllUrlParams((window.location).toString());
		var cardCount = 0; 
		var card_count_cookie = "";
		var xmlhttp = new XMLHttpRequest();
		var url = "api/loadCartCount.php?cart_id=" + cus_cart_id + "&branch_id=" + branch_id;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = JSON.parse(this.responseText);
				if (myObj.length !== 0) {
					document.getElementById("cart_count").innerHTML =  myObj[0].count ;
				} else {
					document.getElementById("cart_count").innerHTML = 0;
					
				}
			}
		};
	}

    function getZoneTax() {
		total_tax_Amt = 0;
		var arr1 = getAllUrlParams((window.location).toString());
		var xmlhttp = new XMLHttpRequest();
		var url = "api/getZoneTax.php?branch_id=" + branch_id + "&sel_obo_order_type=" + sel_obo_order_type;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = JSON.parse(this.responseText);
				if (myObj !== "") {
					for (var i = 0; i < myObj.length; i++) {
						var tax_amount = ((grand_sub_total - +discount_amt) / 100) * +myObj[i].tax_percentage;
						total_tax_Amt = total_tax_Amt + tax_amount;
					}
					document.getElementById("grand_total").innerHTML = (+grand_sub_total - +discount_amt + +total_tax_Amt + +delivery_cost + +pkg_price).toFixed(2);
				}
			}
		};
	}

    function saveOffers() {
		var arr1 = getAllUrlParams((window.location).toString());
		var xmlhttp = new XMLHttpRequest();
		var grand_total = document.getElementById("final_sub_total").innerHTML;
		var offerTxt = document.getElementById("coupon_code").value;
		var url = "api/offer.php?cart_id=" + cus_cart_id + "&grand_total=" + grand_total + "&offertxt=" + offerTxt + "&branch_id=" + branch_id;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				if (myObj === "-1") {
					alert("Please enter a valid discount coupon");
				} else if (myObj === "-2") {
					alert("Coupon Already Applied");
				} else {
					discount_amount = (+myObj).toFixed(2);
					document.getElementById("discount-id").innerHTML = (+myObj).toFixed(2);
					document.getElementById("grand_total").innerHTML = (+grand_sub_total - +discount_amount + +delivery_cost + +pkg_price).toFixed(2);
					alert("Coupon Applied");
					document.getElementById("coupon_code").setAttribute("disabled", true);
					document.getElementById("cancel_coupon").style.display = "block";
				}
			}
		};

	}

	function removeOffers() {
		var arr1 = getAllUrlParams((window.location).toString());
		var xmlhttp = new XMLHttpRequest();
		var url = "api/delete_offer.php?cart_id=" + cus_cart_id;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				document.getElementById("discount-id").innerHTML = "0.00";
				document.getElementById("grand_total").innerHTML = (+grand_sub_total + +delivery_cost + +pkg_price).toFixed(2);
				discount_amount = 0;
				document.getElementById("coupon_code").value = "";
				document.getElementById("coupon_code").removeAttribute("disabled", true);
				document.getElementById("cancel_coupon").style.display = "none";
			}
		};

	}
	
	function paymentMode(mode) {
		if (mode === "1") {
			payementMethod = 1;
		} else {
			payementMethod = 2;
		}
	}
	
	function saveDetails() {
		var arr1 = getAllUrlParams((window.location).toString());
		var grand_total = document.getElementById("grand_total").innerHTML;
		var sub_total = document.getElementById("final_sub_total").innerHTML;
		var total = (+grand_total).toFixed(2);
		var gstotal = (+grand_sub_total).toFixed(2);
		var discount_id = document.getElementById("discount-id").innerHTML;
		var discount = (+discount_id).toFixed(2);
		var expected_date = document.getElementById("expected_date").innerHTML;
		var xmlhttp = new XMLHttpRequest();
		var url = "api/savePriceDetails.php?cart_id=" + cus_cart_id + "&grand_total=" + total + "&grand_sub_total=" + gstotal + "&branch_id=" + branch_id + "&user_id=" + customer_id + "&discount=" + discount + "&sub_total=" + sub_total + "&expected_date=" + expected_date;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				if (myObj !== "") {
					if (+payementMethod === 1) {
						var tmp_gt = document.getElementById("grand_total").innerHTML;
						var amount = tmp_gt;
						document.getElementById("gt_hidden").value = amount;
						document.getElementById("gt_total").value = amount;
						var pm = document.getElementById("payment_method").value;
						var delivery = document.getElementById("delivery_cost").innerHTML;
						var package_chg = document.getElementById("package-id").innerHTML;
						window.location = "api/ease_buzz_php_controller.php?payment_method=" + pm + "&cart_id=" + cus_cart_id + "&branch=" + branch_id + "&del_cost=" + delivery + "&package_chg=" + package_chg + "&gt_total=" + tmp_gt;
					}
				}
			}
		};
	}
	
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
		var xmlhttp = new XMLHttpRequest();
		var url = "paysuccess.php?pm=" + pm + "&cart_id=" + cus_cart_id + "&branch_id="
				+ branch_id + "&user_id=" + customer_id + "&delivery=" + delivery + "&mode=" + 2 + "&package_chg=" + package_chg;
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