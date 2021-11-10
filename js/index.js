var branch_id = 1;
    
function loadAllRecipes() { 
	var information = "";
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
						image_path = '../ecaterweb/Catering/' + cover_photo;
					} else
					{
						image_path = 'images/default.jpg';
					}
							
					information = information + "<div class='swiper-slide post text-center overlay-zoom'>" +
										"<figure class='post-media'>" +
											"<a href='recipe-detail.php?recipe_id=" + myObj[i].recipe_id + "'>" +
												"<img src='" + image_path + "' alt='Recipes' />" +
											"</a>" +
										"</figure>" +
										"<div class='post-details'>" +
											"<h4 class='post-title'><a href='#'>" + myObj[i].recipe_name + "</a></h4>" +
											"<a href='recipe-detail.php?recipe_id='" + myObj[i].recipe_id + " class='btn btn-link btn-dark btn-underline'> View Recipe  <i class='w-icon-long-arrow-right'></i> </a>" +
										"</div>" +
									"</div>";
				}
				$('#recipe_container').empty();
				$('#recipe_container').append(information);
            } else {
				$('#recipe_container').append("<center>No recipe found<\center>");
            }
		}
	};
}

function loadAllCategories() { 
    var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/load_home_page.php?action=get_list_of_categories";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			    information = "<div class='row cols-2'>";
				for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image_path;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = '../ecaterweb/Catering/' + cover_photo;
					} else
					{
						image_path = 'images/default.jpg';
					}
							
					information = information + "<div class='col-lg-3 col-sm-6'>" +
											         "<a href='products.php?category_id=" + myObj[i].id + "'>" +
												          "<div class='swiper-slide slide-animate' data-animation-options='{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.4s'}' >" +  
													           "<figure class='category-media'>" +
													                "<img src='" + image_path + "' alt='Categroy' />" +
														       "</figure>" +
															   "<div class='category-content'>" +
																   "<h4 class='category-name'> <a href='products.php?category_id=" + myObj[i].id + "'>" + myObj[i].name + "</a> </h4>" +
															   "</div>" + 
														  "</div>" +
													 "</a>" +
									            "</div>";
									            
				}
				information = information + "</div>";
				$('#categories_container').empty();
				$('#categories_container').append(information);
            } else {
				$('#categories_container').append("<center>No Categories found<\center>");
            }
		}
	};
}

function loadTopCategories(branch_id) {
    var name = "";
    var image_path ="";
    var icon ="";
    var information = "";
    var xmlhttp = new XMLHttpRequest();
    var url = "api/getTopCategories.php?action=get_top_categories&branch_id="+branch_id;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            if (myObj.length !== 0) {
                for (var i = 0; i < myObj.length; i++) {
                    icon = myObj[i].icon;
                    name = myObj[i].name;
                    if (icon !== "")
                    {
                        image_path = icon;
                    } else
                    {
                        image_path = 'images/default.jpg';
                    }
                    information = information + "<div class='category'><figure class='category-media'><a href='#'><img src="+image_path+" alt="+name+"><h4 class='category-name'>"+name+"</h4></a></figure></div>";
                }
                $('#top_container').empty();
                $('#top_container').append(information);
            } else {
                $('#top_container').append("<center>No Categories found<\center>");
            }
        }
    };
}

function loadLtdDealsOfTheDay() {
	var information = "";
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
					if (cover_photo !== "")
					{
						image_path = '../ecaterweb/Catering/' + cover_photo;
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
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>";
						act_price = reduced_price.toFixed(2);
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
						act_price = +myObj[i].price;
					}
					
					information = information + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='#'><img src=" + image_path + " alt='Product'/> </a>" +
															"<div class='product-label-group'>" +
                                								discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='#'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#ltd_deals_of_the_day_container').empty();
				$('#ltd_deals_of_the_day_container').append(information);
            } else {
				$('#ltd_deals_of_the_day_container').append("<center>No Items found</center>");
            }
		}
	};
}

function loadAllDealsOfTheDay() {
	var information = "";
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
						image_path = '../ecaterweb/Catering/' + cover_photo;
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
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>";
						act_price = reduced_price.toFixed(2);
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
						act_price = +myObj[i].price;
					}
					
					information = information + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
														"<figure class='product-media'>" +
															"<a href='#'><img src=" + image_path + " alt='Product'/> </a>" +
															"<div class='product-label-group'>" +
                                								discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='#'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#all_deals_of_the_day_container').empty();
				$('#all_deals_of_the_day_container').append(information);
            } else {
				$('#all_deals_of_the_day_container').append("<center>No Items found</center>");
            }
		}
	};
}

function loadLtdBestSellingProducts() {
	var information = "";
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
						image_path = '../ecaterweb/Catering/' + cover_photo;
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
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>";
						act_price = reduced_price.toFixed(2);
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
						act_price = +myObj[i].price;
					}
					
					information = information + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='#'><img src=" + image_path + " alt='Product'/> </a>" +
															"<div class='product-label-group'>" +
		                                						discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='#'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#ltd_best_selling_products_container').empty();
				$('#ltd_best_selling_products_container').append(information);
            } else {
				$('#ltd_best_selling_products_container').append("<center>No Items found</center>");
            }
		}
	};
}

function loadAllBestSellingProducts() {
	var information = "";
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
						image_path = '../ecaterweb/Catering/' + cover_photo;
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
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>";
						act_price = reduced_price.toFixed(2);
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
						act_price = +myObj[i].price;
					}
					
					information = information + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
                   										"<figure class='product-media'>" +
															"<a href='#'><img src=" + image_path + " alt='Product'/> </a>" +
															"<div class='product-label-group'>" +
		                                						discount_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='#'>" + myObj[i].name  + "</a> </h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + "</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	discount_price +
																"</div>" +
																"<div class='col-md-4'><a href='#' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>";
				}
				$('#all_best_selling_products_container').empty();
				$('#all_best_selling_products_container').append(information);
            } else {
				$('#all_best_selling_products_container').append("<center>No Items found</center>");
            }
		}
	};
}