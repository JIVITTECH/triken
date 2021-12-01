<?php
    $title = 'Products - Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    include('header.php');
    include('main.php');
	$page ='<span id="load_heading_of_product_page"></span>';
?> 

<?php include('breadcrumb.php'); ?>

<section class="productcat">
	<div class="container">
		<div class="row cols-xl-4 cols-md-3 cols-sm-3" id="item_container">
           
		</div>
	</div>
</section>

<?php include('footer.php'); ?>

<script type='text/javascript'>

$(document).ready(function () {
	loadAllItemDetails();
});

function loadAllItemDetails() {
	var information = "";
	var arr1 = getAllUrlParams((window.location).toString());

	if(typeof arr1.category_id === "undefined") {
        category_id = '';
    } else {
		category_id = arr1.category_id;
	}
	if(typeof arr1.search_text === "undefined") {
        search_text = '';
    } else { 
	    search_text = arr1.search_text;
	}

	$('#item_container').empty();

 	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_list_of_products.php?branch=" + branch_id + "&search_by_category=" + category_id + "&search_by_product=" + search_text;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
				    if (category_id != '') {
						document.getElementById("load_heading_of_product_page").innerHTML = myObj[i].category_name;
						document.getElementById("load_heading_of_breadcrumb").innerHTML = camelCase(myObj[i].category_name);
					} else {
					    document.getElementById("load_heading_of_product_page").innerHTML = 'Products';
						document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Products';
					}
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
					if(myObj[i].best_seller === "1"){
						bseller_tag = "<label class='product-label label-discount best'>Best Seller</label>";
					}else{
						bseller_tag = "";
					}
					
					var narrival_tag = "";
					if(myObj[i].new_arrival === "1"){
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
					
					information = information + "<div class='product-wrap'>" +
													"<div class='product text-center'>" +
														"<figure class='product-media'>" +
															"<a href='items_description.php?item_id=" + myObj[i].menu_id + "'><img onerror='onImgError(this)' src=" + image_path + " alt='Product'/> </a>" +
															    "<div class='product-label-group'>" +
																		narrival_tag +
																		bseller_tag +
																		discount_tag +
																"</div>" +
															"</figure>" +
															"<div class='product-details'>" +
																"<h3 class='product-name'> <a href='#'>" + myObj[i].name + "</a> </h3>" +
																"<div class='row prod_quant'>" +
																	"<div class='product-cat col-md-6'>Net wt: " + myObj[i].net_weight + "  " + myObj[i].measure + "</div>" +
																	"<div class='product-cat col-md-6'>Delivery: " + myObj[i].delivery_time + " mins</div>" +
																"</div>" +
																"<div class='row'>" +
																	"<div class='col-md-8 product-price'>" +
																		discount_price +  
																	"</div>" + 
																	"<div class='col-md-4'><a onclick='saveItemDetails(" + myObj[i].menu_id + ", "  + customer_id +  "," + act_price +  ",\"" + encodeURIComponent(myObj[i].name) + "\", "  + myObj[i].packing_charge +  ",\"" + encodeURIComponent(image_path) + "\")' class='add_cart btn-cart' title='Add to Cart'><i class='w-icon-plus'></i> Add</a></div>" +
																"</div>" +
															"</div>" +
														"</div>" +
													"</div>";
				}
				$('#item_container').append(information);
            } else {
			    document.getElementById("load_heading_of_product_page").innerHTML = 'Products';
			    document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Products';
				$('#item_container').append("<center>No Items found</center>");
            }
		}
	};
}
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>