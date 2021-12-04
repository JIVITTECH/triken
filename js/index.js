function loadAllRecipes() { 
	var information_1 = "";
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
	$('#recipe_container').empty();
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_recipe_details.php?branch=" + branch_id + "&show_limited_recipes=Y";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
							
					information_1 = information_1 + "<div class='swiper-slide post text-center overlay-zoom'>" +
										"<figure class='post-media'>" +
											"<a href='recipe-detail.php?recipe_id=" + myObj[i].recipe_id + "'>" +
												"<img onerror='onImgError(this)' src='" + image_path + "' alt='Recipes' />" +
											"</a>" +
										"</figure>" +
										"<div class='post-details'>" +
											"<h4 class='post-title'><a>" + myObj[i].recipe_name + "</a></h4>" +
											"<a href='recipe-detail.php?recipe_id=" + myObj[i].recipe_id + "' class='btn btn-link btn-dark btn-underline'> View Recipe  <i class='w-icon-long-arrow-right'></i> </a>" +
										"</div>" +
									"</div>";
				}
				$('#recipe_container').append(information_1);
            } else {
				$('#recipe_container').append("<center>No recipe found<\center>");
            }
		}
	};
}

function loadAllCategories() { 
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    var information_2 = "";
	$('#categories_container').empty();
	var xmlhttp = new XMLHttpRequest();
	var url = "api/load_home_page.php?action=get_list_of_categories&branch_id=" + branch_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			    for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image_path;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
							
					information_2 = information_2 + "<div class='col-lg-3 col-sm-6'>" +
											         "<a href='products.php?category_id=" + myObj[i].id + "'>" +
												          "<div class='swiper-slide slide-animate' data-animation-options='{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.4s'}' >" +  
													           "<figure class='category-media'>" +
													                "<img onerror='onImgError(this)' src='" + image_path + "' alt='Categroy' />" +
														       "</figure>" +
															   "<div class='category-content'>" +
																   "<h4 class='category-name'> <a href='products.php?category_id=" + myObj[i].id + "'>" + myObj[i].name + "</a> </h4>" +
															   "</div>" + 
														  "</div>" +
													 "</a>" +
									            "</div>";
									            
				}
				$('#categories_container').append(information_2);
            } else {
				$('#categories_container').append("<center>No Categories found<\center>");
            }
		}
	};
}


function loadLtdDealsOfTheDay() {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    $('#ltd_deals_of_the_day_container').empty();
	var information_3 = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_deals_of_the_day.php?branch=" + branch_id + "&show_limited_products=Y";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			    for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "") {
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
					
					var discount_tag = "";
					if(myObj[i].disc_per !== ""){
						discount_tag = "<label class='product-label label-discount'>" + myObj[i].disc_per + " % Off</label>";
					}else{
						discount_tag = "";
					}

					var bseller_tag = "";
					if(myObj[i].best_seller === "Y"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var narrival_tag = "";
					if(myObj[i].new_arrival === "Y"){
						narrival_tag = "<label class='product-label newarrival'>New Arrival</label>";
					}else{
						narrival_tag = "";
					}
					
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
					
					var stock_chk = "";
					if(myObj[i].stock_chk === "0"){
						stock_chk = "<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a>";
					}else{
					    stock_chk = "<div style='color:#E0522D;' class='product-cat col-md-4'>Out of Stock";
					}
					information_3 = information_3 + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product' />" +
															 "</a>" +
															"<div class='product-label-group'>" +
                                								 narrival_tag +
																 bseller_tag +
																 discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																stock_chk + "</div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
			} else {
			    information_3 = information_3 + "<center>No Items found</center>";
	        }
			 $('#ltd_deals_of_the_day_container').append(information_3);
		}
	};
}

function loadAllDealsOfTheDay() {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
	var information_4 = "";
	$('#all_deals_of_the_day_container').empty();
	document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Deal of the Day';
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_deals_of_the_day.php?branch=" + branch_id + "&show_limited_products=N";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
					
					var discount_tag = "";
					if(myObj[i].disc_per !== ""){
						discount_tag = "<label class='product-label label-discount'>" + myObj[i].disc_per + " % Off</label>";
					}else{
						discount_tag = "";
					}

					var bseller_tag = "";
					if(myObj[i].best_seller === "Y"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var narrival_tag = "";
					if(myObj[i].new_arrival === "Y"){
						narrival_tag = "<label class='product-label newarrival'>New Arrival</label>";
					}else{
						narrival_tag = "";
					}
					
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
					
					var stock_chk = "";
					if(myObj[i].stock_chk === "0"){
						stock_chk = "<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a>";
					}else{
					    stock_chk = "<div style='color:#E0522D;' class='product-cat col-md-4'>Out of Stock";
					}
					
					information_4 = information_4 + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" +
															"</a>" +
															"<div class='product-label-group'>" +
                                								 narrival_tag +
																 bseller_tag +
																 discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																stock_chk + "</div>" +
																"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#all_deals_of_the_day_container').append(information_4);
            } else {
				$('#all_deals_of_the_day_container').append("<center>No Items found</center>");
            }
		}
	};
}

function loadLtdBestSellingProducts() {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    $('#ltd_best_selling_products_container').empty();
	var information_5 = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_best_selling_products.php?branch=" + branch_id + "&show_limited_products=Y";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			 	for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
					
					var discount_tag = "";
					if(myObj[i].disc_per !== ""){
						discount_tag = "<label class='product-label label-discount'>" + myObj[i].disc_per + " % Off</label>";
					}else{
						discount_tag = "";
					}

					var bseller_tag = "";
					if(myObj[i].best_seller === "Y"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var narrival_tag = "";
					if(myObj[i].new_arrival === "Y"){
						narrival_tag = "<label class='product-label newarrival'>New Arrival</label>";
					}else{
						narrival_tag = "";
					}
					
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
					
					var stock_chk = "";
					if(myObj[i].stock_chk === "0"){
						stock_chk = "<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a>";
					}else{
					    stock_chk = "<div style='color:#E0522D;' class='product-cat col-md-4'>Out of Stock";
					}
					
					information_5 = information_5 + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" + 
															"</a>" +
															"<div class='product-label-group'>" +
		                                						 narrival_tag +
																 bseller_tag +
																 discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																stock_chk + "</div>" + 
																"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
            } else {
				information_5 = information_5 + "<center>No Items found</center>";
	        }
			$('#ltd_best_selling_products_container').append(information_5);
		}
	};
}

function loadAllBestSellingProducts() {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
	var information_6 = "";
	$('#all_best_selling_products_container').empty();
	document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Best Seller';
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_best_selling_products.php?branch=" + branch_id + "&show_limited_products=N";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = dirname + cover_photo.replace("../", "");
					} else
					{
						image_path = 'images/default.jpg';
					}
					
					var discount_tag = "";
					if(myObj[i].disc_per !== ""){
						discount_tag = "<label class='product-label label-discount'>" + myObj[i].disc_per + " % Off</label>";
					}else{
						discount_tag = "";
					}
					
					var bseller_tag = "";
					if(myObj[i].best_seller === "Y"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var narrival_tag = "";
					if(myObj[i].new_arrival === "Y"){
						narrival_tag = "<label class='product-label newarrival'>New Arrival</label>";
					}else{
						narrival_tag = "";
					}
					
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
					
					var stock_chk = "";
					if(myObj[i].stock_chk === "0"){
						stock_chk = "<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a>";
					}else{
					    stock_chk = "<div style='color:#E0522D;' class='product-cat col-md-4'>Out of Stock";
					}
					information_6 = information_6 + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
                   										"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" + 
															"</a>" +
															"<div class='product-label-group'>" +
		                                					 	 narrival_tag +
																 bseller_tag +
																 discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																stock_chk + "</div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#all_best_selling_products_container').append(information_6);
            } else {
				$('#all_best_selling_products_container').append("<center>No Items found</center>");
            }
		}
	};
}

function loadAllCustomerReviews(branch_id, category_id, item_id) {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
	
	$('#all_customer_review_container').empty();
	//document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Customer Review';
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_customer_reviews.php?branch=" + branch_id + "&category_id=" + category_id + "&item_id=" + item_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				var final_div = '';
				for (var i = 0; i < myObj.length; i++) {
					var img = myObj[i].image;
					var image_path = "";
					if (img !== "")
					{
						image_path = '<img src="' + img + '" class="img-responsive" alt="reviews">';
					}

					var rev_div = '<div class="col-lg-3 col-sm-6"> <div class="doorstep">' +
					image_path +
					'<div class="review">' +
					'<h4>' + myObj[i].customer_name + '</h4>' + 
					'<span class="star">';
					
					for (var j=0; j<myObj[i].ratings; j++) {
						rev_div = rev_div + '<i class="fa fa-star active" aria-hidden="true"></i>';
					}
					
					rev_div = rev_div + '</span>' +
					'<p>' + myObj[i].feedback + '</p>' +
					'</div></div>' +
					'<div class="space"></div>';
					
					final_div = final_div + rev_div + '</div>';
					
				}
				
				/* if((i+1)%3 !== 0) {
					final_div = final_div + '</div>' ;
				} */	
				
				$('#all_customer_review_container').append(final_div);
            } else {
				$('#all_customer_review_container').append("<center>No reviews yet</center>");
            }
		}
	};
}