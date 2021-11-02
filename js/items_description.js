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
					if(myObj[i].best_seller !== "1"){
						document.getElementById("best_seller_tag").style.display = 'none';
					}
					
					var related_images = myObj[i].related_images;
					var related_images_tag = "";
					for (var j = 0; j < related_images.length; j++) {
						var full_path = "../ecaterweb/Catering/" + related_images[j].image_path;
						related_images_tag = related_images_tag + "<div class='swiper-slide'>" +
		                                "<figure class='product-image'>" +
		                                    "<img src='" + full_path + "' data-zoom-image='" + full_path + "' alt=''>" +
		                                "</figure>" +
		                            "</div>";
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
					
					document.getElementById("specifications_div_2").innerHTML = specifications_div_2;
					document.getElementById("specifications_div_1").innerHTML = specifications_div_1;
					document.getElementById("images_tag").innerHTML = related_images_tag;
					document.getElementById("item_name").innerHTML = myObj[i].name;
					document.getElementById("gross_weight").innerHTML = myObj[i].gross_weight + " " + myObj[i].measure;
					document.getElementById("net_weight").innerHTML = myObj[i].net_weight + " " +  myObj[i].measure ;
					document.getElementById("product_des").innerHTML = myObj[i].description;
					document.getElementById("delivery_time").innerHTML = myObj[i].delivery_time;
                    $('#video_link').append("<img src=" + myObj[i].video_path + ">");	
					
					var discount_price = "";
					if(myObj[i].disc_per !== ""){
						var reduced_price = +myObj[i].price - (+myObj[i].disc_per / +myObj[i].price) * 100; 
						discount_price = "<ins class='new-price'>" + reduced_price.toFixed(2) + "</ins><del class='old-price'>" + myObj[i].price + "</del>" + "<ins class='offer'>" + myObj[i].disc_per + " % OFF</ins>";
					}else{
						discount_price = "<ins class='new-price'>" + myObj[i].price + "</ins>";
					}
					
					document.getElementById("product_price").innerHTML = discount_price;
				}
			} else {
				$('#item_container').append("<center>No Items found</center>");
            }
		}
	};
}
