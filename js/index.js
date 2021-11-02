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
											"<a href='recipe-detail.php?recipe_id='" + myObj[i].recipe_id + ">" +
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