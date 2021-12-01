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
			information_3 = information_3 + '<div class="container mb-4">' +
			                                '<div class="widget-body br-sm h-100">' +
											     '<div class="row">' + 
												      '<div class="col-lg-8 col-sm-12"> <h1 class="title text-left appear-animate"> <img src="assets/images/certificate.svg"> Deal of the Day  </h1> </div>' +
													  '<div class="col-lg-4 col-sm-12">' +
													      '<div class="viewall">' +
														       '<a href="dod.php" class="btn btn-dark"> View All </a>' +
														  '</div>' +
													  '</div>' +
												 '</div>' +
											'<div class="swiper slider_sec">';
			if (myObj.length !== 0) {
			    information_3 = information_3 + "<div class=" + '"swiper-container  swiper-theme nav-top"' + ' data-swiper-options="{' +
				                                            "'slidesPerView': 1.1," + 
															"'spaceBetween': 10," +
															"'breakpoints': {" +
															    "'576': {" + 
																   "'slidesPerView': 2" + 
																"}," + 
																"'768': {" + 
																   "'slidesPerView': 3" + 
                                                                "}," +
																"'992': {" +
																   "'slidesPerView': 4" + 
                                                                "}" +
															"}" +
														'}">' +
											"<div class='swiper-wrapper row cols-lg-1 cols-md-3'>";
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
					
					information_3 = information_3 + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product' />" +
															 "</a>" +
															"<div class='product-label-group'>" +
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
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				information_3 = information_3 + "</div>" + 
				                            "<button class='swiper-button-next'></button>" +
											"<button class='swiper-button-prev'></button>" +
											"</div>";
            } else {
			    information_3 = information_3 + "<center>No Items found</center>";
	        }
			information_3 = information_3 + '</div>' + '</div>' + '</div>';
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
					
					information_4 = information_4 + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" +
															"</a>" +
															"<div class='product-label-group'>" +
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
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
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
			information_5 = information_5 + '<div class="container mb-4">' +
			                                '<div class="widget-body br-sm h-100">' +
											     '<div class="row">' + 
												      '<div class="col-lg-8 col-sm-12"> <h1 class="title text-left appear-animate"> <img src="assets/images/certificate.svg"> Best Selling Products  </h1> </div>' +
													  '<div class="col-lg-4 col-sm-12">' +
													      '<div class="viewall">' +
														       '<a href="bestselling.php" class="btn btn-dark"> View All </a>' +
														  '</div>' +
													  '</div>' +
												 '</div>' +
											'<div class="swiper slider_sec">';
			if (myObj.length !== 0) {
			    information_5 = information_5 + "<div class=" + '"swiper-container  swiper-theme nav-top"' + ' data-swiper-options="{' +
				                                            "'slidesPerView': 1.1," + 
															"'spaceBetween': 10," +
															"'breakpoints': {" +
															    "'576': {" + 
																   "'slidesPerView': 2" + 
																"}," + 
																"'768': {" + 
																   "'slidesPerView': 3" + 
                                                                "}," +
																"'992': {" +
																   "'slidesPerView': 4" + 
                                                                "}" +
															"}" +
														'}">' +
											"<div class='swiper-wrapper row cols-lg-1 cols-md-3'>";
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
					discount_tag = discount_tag + "<label class='product-label label-discount bestseller best'>Best Seller </label>";
					
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
					
					information_5 = information_5 + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" + 
															"</a>" +
															"<div class='product-label-group'>" +
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
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
                information_5 = information_5 + "</div>" + 
				                            "<button class='swiper-button-next'></button>" +
											"<button class='swiper-button-prev'></button>" +
											"</div>";
            } else {
				information_5 = information_5 + "<center>No Items found</center>";
	        }
			information_5 = information_5 + '</div>' + '</div>' + '</div>';
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
					discount_tag = discount_tag + "<label class='product-label label-discount bestseller best'>Best Seller </label>";
					
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
					
					information_6 = information_6 + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
                   										"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'>" +
															    "<img onerror='onImgError(this)' src=" + image_path + " alt='Product'/>" + 
															"</a>" +
															"<div class='product-label-group'>" +
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
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
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