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