	var grand_sub_total = 0;
	var delivery_cost = 0;
	var stock_chk_array = [];
	var pkg_price = 0;
    var cus_cart_id = 404;
	var sel_obo_order_type = 3;
	var branch_id = 1;
    var customer_id = 1;
    var discount_amt = 0;


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

	function loadCustomerSelectedItems() {
		grand_sub_total = 0;
		$('#selected_items').empty();
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
											"<td class='product-thumbnail'>" +
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
                                            "<div  class='product-price'>" +
	                                        "<ins id = 'price_" + myObj[i].cart_item_id  + "' class='new-price'>" + total_price.toFixed(2) + "</ins>" +
								            "<span class='gms'>" + myObj[i].net_weight + " " + myObj[i].measure + "</span>" +
								            "</div>" +
                                            "</td>" +
                                            "<td class='product-quantity'>" +
                                            "<div class='input-group'>" +
                                            "<input id = 'qty_" + myObj[i].menu_id  + "' class='quantity form-control' type='number'  value = '" + myObj[i].quantity + "' readonly>"  +
                                            "<button class='quantity-plus w-icon-plus' href='#' onclick='IncreaseItemQuantity(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "<button class='quantity-minus w-icon-minus' href='#' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + "," + myObj[i].quantity + "," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")' ></button>" +
                                            "</div>" +
                                            "<span class='remove' onclick='redQty(" + myObj[i].menu_id + "," + myObj[i].per_unit_price + ",1," + myObj[i].cart_item_id + "," + myObj[i].packing_charge + ")'> <a href=''> Remove </a> </span>" +
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
					$('#no_data').append("<div class='row' style='height: 100%; text-align: left; border: 1px solid #e6e6e6; padding-left: 0px; padding-right: 0px; border-radius: 10px; margin-bottom: 10px;'><div class='col-lg-12'><p style='padding: 20px; text-align: center;'>Your cart is empty. Add something from the <a onclick='exploreMenu()' style='text-decoration: underline;'> Menu</a></p></div></div>");
                }
			}
		};
        var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
		xhttp.open("GET", url, true);
		xhttp.send();
	}


	function imgError(image) {
		image.onerror = "";
		image.src = "images/default.jpg";
		return true;
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
						if (cover_photo !== "")
						{
							image_path = '../' + cover_photo;
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
						var tot_pkg_price = 0;
						if (myObj[i].packing_charge !== "" || myObj[i].packing_charge !== null) {
							tot_pkg_price = parseFloat(myObj[i].packing_charge) * parseInt(myObj[i].quantity);
							pkg_price = +pkg_price + +tot_pkg_price;
						}


						if (+myObj[i].cart_item_id === cart_item_id) {
							document.getElementById("qty_" + myObj[i].menu_id + "").value = +myObj[i].quantity;
			                document.getElementById("price_" + cart_item_id + "").value = +total_price.toFixed(2);
						}
					}
					document.getElementById("sub_total").innerHTML = "";
					document.getElementById("sub_total").innerHTML = (+grand_sub_total).toFixed(2);
				} 
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
					document.getElementById("grand_total").innerHTML = (+grand_sub_total - +discount_amount + +delivery_cost).toFixed(2);
					alert("Coupon Applied");
					document.getElementById("coupon_code").setAttribute("disabled", true);
				}
			}
		};

	}

	function removeOffers() {
		var arr1 = getAllUrlParams((window.location).toString());
		var xmlhttp = new XMLHttpRequest();
		var url = "controller/delete_offer.php?cart_id=" + cus_cart_id;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = xmlhttp.responseText;
				document.getElementById("discount-id").innerHTML = "0.00";
				document.getElementById("grand_total").innerHTML = (+grand_sub_total + +delivery_cost).toFixed(2);
				discount_amount = 0;
				document.getElementById("coupon_code").value = "";
				document.getElementById("coupon_code").removeAttribute("disabled", true);
			}
		};

	}

