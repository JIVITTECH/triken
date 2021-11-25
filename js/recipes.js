function loadSelectedCategory() {
	$('#category_container').empty();
    var name = "";
    var information = "";
    var xmlhttp = new XMLHttpRequest();
    var url = "api/getTopCategories.php?action=get_top_categories&branch_id=" + branch_id;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            if (myObj.length !== 0) {
                for (var i = 0; i < myObj.length; i++) {
                    name = myObj[i].name;
					
					if(i === 0){
						selected_category = myObj[i].id;
						information = information + " <li><a href='#' onclick='setCategory(" + myObj[i].id + ")' class='nav-filter active' data-filter=" + name + ">" + name + "</a></li>";
					}else{
						information = information + " <li><a href='#' onclick='setCategory(" + myObj[i].id + ")' class='nav-filter' data-filter=" + name + ">" + name + "</a></li>";
					}
				}
                $('#category_container').empty();
                $('#category_container').append(information);
				loadAllRecipes();
            } else {
                $('#category_container').append("<center>No Categories found</center>");
            }
        }
    };
}

var selected_category = "";

function setCategory(cat_id){
	selected_category = cat_id;
	loadAllRecipes();
}

function loadAllRecipes() { 
    $('#recipe_container').empty();
	var information = "";
	var recipe_name = document.getElementById("recipe_name").value;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_recipe_details.php?branch=" + branch_id +  "&recipe_name=" + recipe_name + "&selected_category=" + selected_category + "&show_limited_recipes=N";
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
					
					information = information + "<article class='post post-grid-type grid-item overlay-zoom mutton chicken'>" +
													"<div class='recipe_box'>" +
														"<figure class='post-media br-sm'>" +
															"<a href='recipe-detail.php?recipe_id=" + myObj[i].recipe_id + "'>" +
																"<img src='" + image_path + "' alt='Recipes' />" +
																"</a>" +
																"</figure>" +
																"<div class='post-details'>" +
																	"<h4 class='post-title'><a href='#'>" + myObj[i].recipe_name + "</a></h4>" +
																	"<a href='recipe-detail.php?recipe_id=" + myObj[i].recipe_id + "' class='btn btn-link btn-dark btn-underline'> View Recipe  <i class='w-icon-long-arrow-right'></i> </a>" +
																"</div>" +
															"</div>" +
												"</article>";
				}
				$('#recipe_container').empty();
				$('#recipe_container').append(information);
            } else {
				$('#recipe_container').append("<center>No recipe found</center>");
            }
		}
	};
}
