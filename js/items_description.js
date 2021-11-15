function loadItemsDescription() {
	var information = "";
	var arr1 = getAllUrlParams((window.location).toString());
    var item_id = arr1.item_id;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_items_description.php?branch=" + branch_id + "&item_id=" + item_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
					
					var bseller_tag = "";
					selected_item_name =  myObj[i].name;
					if(myObj[i].best_seller !== "1"){
						document.getElementById("best_seller_tag").style.display = 'none';
					}
				    loadAllRelatedItems();

					
					var related_images = myObj[i].related_images;
					var related_images_tag = "";
					for (var j = 0; j < related_images.length; j++) {
						var full_path = dirname + related_images[j].image_path;
						related_images_tag = related_images_tag + "<div class='swiper-slide'>" +
		                                "<figure class='product-image'>" +
		                                    "<img src='" + full_path + "' data-zoom-image='" + full_path + "' alt=''>" +
		                                "</figure>" +
		                            "</div>";
					}
					var cover_photo = myObj[i].image;
					var image_path = "";
					if (cover_photo !== "")
					{
						image_path = '../ecaterweb/Catering/' + cover_photo;
					} else
					{
						image_path = 'images/default.jpg';
					}
					var specifications = myObj[i].specification;
					var specifications_length = specifications.length/2;
					var specifications_div_1 = "";
					var specifications_tag_1 = "";
					var start_index_1 = 0;
					var end_index_1 = specifications_length;
					var specifications_div_2 = "";
					var specifications_tag_2 = "";
					var start_index_2 = end_index_1;
					var end_index_2 = specifications.length;
					
					for (var l = start_index_1; l < end_index_1; l++) {
						  specifications_tag_1 = specifications_tag_1 + "<li>" + specifications[l].specification + "</li>";
					} 
					specifications_div_1 = specifications_div_1 + "<ul  class='list-type-check'>" + specifications_tag_1 +
										"</ul>";
										
					for (var m = start_index_2; m < end_index_2; m++) {
						  specifications_tag_2 = specifications_tag_2 + "<li>" + specifications[m].specification + "</li>";
					} 
					specifications_div_2 = specifications_div_2 + "<ul  class='list-type-check'>" + specifications_tag_2 +
										"</ul>";
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
					document.getElementById("specifications_div_2").innerHTML = specifications_div_2;
					document.getElementById("specifications_div_1").innerHTML = specifications_div_1;
					document.getElementById("images_tag").innerHTML = related_images_tag;
					//document.getElementById("item_name").innerHTML = myObj[i].name;
					document.getElementById("sel_name").innerHTML = myObj[i].name;
					document.getElementById("gross_weight").innerHTML = myObj[i].gross_weight + " " + myObj[i].measure;
					document.getElementById("net_weight").innerHTML = myObj[i].net_weight + " " +  myObj[i].measure ;
					document.getElementById("product_des").innerHTML = myObj[i].description;
					document.getElementById("delivery_time").innerHTML = myObj[i].delivery_time;
                    $('#video_link').append("<img src=" + myObj[i].video_path + ">");	
					$('#add_sub').append("<button onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='quantity-plus w-icon-plus'></button>");
					$('#add_sub').append("<button onclick='redQty(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",0)' class='quantity-minus w-icon-minus'></button>"); 
					$('#add_to_cart').append("<button id='add_button' onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' class='btn btn-primary btn-cart'> <span>Add to Cart</span> </button>");
					$('#add_to_cart').append("<button id='remove_button' onclick='redQty(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",1)' class='btn btn-primary btn-cart'> <span>Remove</span> </button>");
					var discount_price = "";
					if(myObj[i].disc_per !== ""){
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>" + "<ins class='offer'>" + myObj[i].disc_per + " % OFF</ins>";
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
					}
					
					document.getElementById("product_price").innerHTML = discount_price;
				}
				loadItemsFromCart();
				if (customer_id !== -1) {
				   loadCartData();
				} else {
				   loadCartDataFromCookie();
				}
			} else {
				$('#item_container').append("<center>No Items found</center>");
            }
		}
	};
}

var selected_item_name = "";

function loadAllRelatedItems() {
	var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_list_of_related_products.php?branch=" + branch_id + "&item_name="+ selected_item_name;
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
						image_path = dirname + cover_photo;
					} else
					{
						image_path = 'images/default.jpg';
					}
					
					var bseller_tag = "";
					if(myObj[i].best_seller === "1"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var discount_price = 0;
					var act_price = 0;
					if(myObj[i].disc_per !== ""){
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = reduced_price;
						act_price = reduced_price.toFixed(2);
					}else{
						discount_price = myObj[i].price;
						act_price = +myObj[i].price;
					}
					information = information + "<div class='swiper-slide product-widget-wrap'>" +
													"<div class='product'>" +
														"<figure class='product-media'>" +
															"<a href='#'><img src=" + image_path + " alt='Product'/> </a>" +
																"<div class='product-label-group'>" +
																	bseller_tag +
															"</div>" +
														"</figure>" +
														"<div class='product-details'>" +
															"<h3 class='product-name'> <a href='#'>" + myObj[i].name + "</h3>" +
															"<div class='row prod_quant'>" +
																"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + " " + myObj[i].measure + " </div>" +
																"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + " mins</div>" +
															"</div>" +
															"<div class='row'>" +
																"<div class='col-md-8 product-price'>" +
																	"<ins class='new-price'>" + discount_price + "</ins>" +
																"</div>" +
																"<div class='col-md-4'><a onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + myObj[i].name + "\", "  + myObj[i].packing_charge +  ",\"" + image_path + "\")' href='#' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
															"</div>" +
														"</div>" +
													"</div>" +
												"</div>"  ;
												
				}
				$('#related_products').empty();
				$('#related_products').append(information);
            } else {
				$('#related_products').append("<center>No Related Items found</center>");
            }
		}
	};
}
