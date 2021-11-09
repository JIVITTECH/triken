<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' ';
$pageCanonical = '';
$url = ' ';
include('header.php');
include ('main.php');
$page ="Recipes & Tips";
?>

<?php include('breadcrumb.php'); ?>
			
			<div class="page-content">
                <div class="container">
					<section class="recipe_banner" id="recipe_banner">
					</section>
                    <section class="recipe_cont">
						<div class="row">
								<h2 class="title title-center" id="recipe_name"></h2>
								<p class="mx-auto text-center" id="recipe_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat sed bibendum in proin enim. At etiam vitae morbi viverra nisl faucibus aliquet. Sed velit hendrerit pellentesque nunc. A cras amet, ultricies volutpat et ultrices. Ornare lectus eleifend consectetur ipsum aliquam nibh vitae dui. Nisl in nunc platea nec lectus lacus ultricies.</p>
						</div>
                    </section>
					<section class="ingredients">
						<div class="row">
								<h4 class="ingredient_title">Ingredients of <span id="name_rec"></span><span class="serving">Serving 2</span></h4>
								<hr>
								<div id="ingredients_div">
								</div>
						</div>
                    </section>
					
					<section class="making">
						<div class="row">
								<h4 class="ingredient_title">How to make <span id="name_rec2"></span></h4>
								<hr>
								<div id="procedure">
								</div>
						</div>
                    </section>
					
					<div class="recipe">
						<h1 class="title text-center appear-animate mb-6"> Related Recipes </h1>
					<div class="swiper-container swiper-theme post-wrapper appear-animate" data-swiper-options="{
                    'slidesPerView': 1.1,
                    'spaceBetween': 20,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 1
                        },
                        '768': {
                            'slidesPerView': 3
                        },
                        '992': {
                            'slidesPerView': 3,
                            'dots': false
                        }
                    }
                }">
							<div class="swiper-wrapper row " id="recipe_container">
							</div>
						</div>
						
						</div>
					
				</div>
				
			</div>

<?php include('footer.php'); ?>

<script type='text/javascript'>

$(document).ready(function () {
	loadAllRecipesDetail();
});

var branch_id = 1;
var recipe_name = "";

function loadAllRecipes() {
	var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_list_of_related_recipes.php?branch=" + branch_id + "&recipe_name=" + recipe_name + "&show_limited_recipes=Y";
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

function loadAllRecipesDetail() {
	var information = "";
	var image_path = "";
	var arr1 = getAllUrlParams((window.location).toString());
	var recipe_id = arr1.recipe_id;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_detail_recipe_details.php?branch=" + branch_id + "&recipe_id=" + recipe_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			loadAllRecipes();
			if (myObj.length !== 0) {
				for (var i = 0; i < myObj.length; i++) {
					var cover_photo = myObj[i].image;
					var procedure = myObj[i].procedure;
					if (cover_photo !== "")
					{
						image_path = '../ecaterweb/Catering/' + cover_photo;
					} else
					{
						image_path = 'images/default.jpg';
					}
					$('#recipe_banner').empty();
				    $('#recipe_banner').append('<img src=' + image_path + '>');
					recipe_name = myObj[i].recipe_name; 
					document.getElementById("recipe_name").innerHTML = myObj[i].recipe_name; 
					document.getElementById("recipe_desc").innerHTML = myObj[i].description;
					document.getElementById("name_rec2").innerHTML = myObj[i].recipe_name; 
					document.getElementById("name_rec").innerHTML = myObj[i].recipe_name; 
					
					var ing_div = "";
					var inv_list = "";
					var ing_list = myObj[i].ingredient_list;
					var ing_length = ing_list.length/2;
					var start_index = 0;
					var end_index = ing_length;
					var k = 0;
					for ( k = 0; k < 2; k++){
						inv_list = "";
						for (var l = start_index; l < end_index; l++) {
						      ing_div = ing_div + "<li>" + ing_list[l].ingredient_name + "</li>";
						}     
                         inv_list = inv_list + "<div class='col-md-6'>" +
								   "<ul>" + ing_div +
                                   "</ul>" +
								   "</div>" ;		
						start_index = end_index;
						end_index = end_index + ing_length;
				    }
					$('#ingredients_div').empty();
					$('#ingredients_div').append(inv_list);
					
					var procedure_div = "";
				    for (var j = 0; j < procedure.length; j++) {
						procedure_div = procedure_div + "<h3><b>Step " + procedure[j].instruction_id + ":</b> " + procedure[j].recipe_notes + " </h3>" +
                                        "<p>" + procedure[j].detail_steps + "</p>";
				    }
					$('#procedure').empty();
					$('#procedure').append(procedure_div);
				}
	        }
		}
	};
}


</script>