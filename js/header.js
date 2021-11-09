    var grand_sub_total = 0;
	var pkg_price = 0;

//To be replaced by dynamic values from session
    var cus_cart_id = 404;
	var sel_obo_order_type = 3;
	var branch_id = 1;
    var customer_id = 1;
    
	function loadCartData() {
		$('#cart_items_container').empty();
		var information = "";
		var arr1 = getAllUrlParams((window.location).toString());
		var branch_id = 1;
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
																"<input class='quantity form-control' value =  " + myObj[i].quantity + " type='number' min='1' max='10000000'>" +
																"<button onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ")'  class='quantity-plus w-icon-plus'></button>" +
																"<button onclick='redQtyFromCart(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",0," + myObj[i].quantity + ")'  class='quantity-minus w-icon-minus'></button>" +
															"</div>" +
															"<div class='price-box'>" +
																"<span class='product-price'><ins class='new-price'>" + total_price + "</ins></span>" +
															"</div>" +
														"</div>" +
													"</div>" +
													"<button class='btn btn-link btn-close' aria-label='button'>" +
														"<i class='fas fa-times'></i>" +
													"</button>" +
												"</div><hr class='product-divider'>";
							$('#cart_items_container').empty();
							$('#cart_items_container').append(information);
							document.getElementById("subtotal_cart_container").innerHTML = "";
							document.getElementById("subtotal_cart_container").innerHTML = (+grand_sub_total).toFixed(2);
							}
					} else
					{
						document.getElementById("cart_items_container").style.display = "none";
					}
				}
			};
			var url = "api/loadCustomerSelectedItems.php?cart_id=" + cus_cart_id + "&branch=" + branch_id + "&order_type=" + sel_obo_order_type;
			xhttp.open("GET", url, true);
			xhttp.send();
		}

