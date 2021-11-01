<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' ';
$pageCanonical = '';
$url = ' ';
$page ="Recipes & Tips";
include('header.php');
include ('main.php');
?>

<?php include('breadcrumb.php'); ?>
			
			<div class="page-content">
                <div class="container">
					<section class="recipe_banner">
							<img src="assets/images/recipe-detail-banner.jpg" alt="">
					</section>
                    <section class="recipe_cont">
						<div class="row">
								<h2 class="title title-center">Amritsari Chicken Masala</h2>
								<p class="mx-auto text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat sed bibendum in proin enim. At etiam vitae morbi viverra nisl faucibus aliquet. Sed velit hendrerit pellentesque nunc. A cras amet, ultricies volutpat et ultrices. Ornare lectus eleifend consectetur ipsum aliquam nibh vitae dui. Nisl in nunc platea nec lectus lacus ultricies.</p>
						</div>
                    </section>
					<section class="ingredients">
						<div class="row">
								<h4 class="ingredient_title">Ingredients of Masala Chicken <span class="serving">Serving 2</span></h4>
								<hr>
								<div class="col-md-6">
								<ul>
								<li>750 grams chicken</li>
								<li>2 cup onion</li>
								<li>salt As required</li>
								<li>2 inches cinnamon stick</li>
								<li>2 green cardamom</li>
								<li>1 teaspoon ginger paste</li>
								<li>2 teaspoon coriander powder</li>
								<li>1 cup water</li>
								<li>2 teaspoon cumin powder</li>
								<li>1 tablespoon garam masala powder</li>
								<li>1 tablespoon ghee</li>
								</ul>
								</div>
								<div class="col-md-6">
								<ul>
								<li>4 tablespoon mustard oil</li>
								<li>1/2 cup tomato</li>
								<li>3 teaspoon coriander leaves</li>
								<li>2 bay leaf</li>
								<li>1 black cardamom</li>
								<li>2 teaspoon garlic paste</li>
								<li>1 teaspoon turmeric</li>
								<li>2 teaspoon red chilli powder</li>
								<li>2 green chillies</li>
								<li>2 teaspoon kasoori methi powder</li>
								</ul>
								</div>
						</div>
                    </section>
					
					<section class="making">
						<div class="row">
								<h4 class="ingredient_title">How to make Masala Chicken</h4>
								<hr>
								<h3><b>Step 1:</b>  Wash and clean the chicken</h3>
								<p>To make Masala Chicken, first thoroughly wash the chicken under running water. Now put it in some warm salted water and allow it to rest for 10 minutes and throw the water away and wash again. This helps to remove the smell of the chicken.</p>
								<h3><b>Step 2:</b>  Saute whole spices</h3>
								<p>Add oil and ghee in pan and heat over medium flame. When the oil is hot enough, add bay leaves and both the cardamom and cinnamon. Saute for a minute and then add finely chopped onion into it. Cook till onions turn pink. Then add the ginger-garlic paste. Fry for a minute and then add chicken pieces in it. Cook chicken for 2-3 minutes until it turns white.</p>
								<h3><b>Step 3:</b>  Add spices in frying chicken</h3>
								<p>Add oil and ghee in pan and heat over medium flame. When the oil is hot enough, add bay leaves and both the cardamom and cinnamon. Saute for a minute and then add finely chopped onion into it. Cook till onions turn pink. Then add the ginger-garlic paste. Fry for a minute and then add chicken pieces in it. Cook chicken for 2-3 minutes until it turns white.</p>
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
	loadAllRecipes();
});

var branch_id = 1;
var recipe_name = "PURI";

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
</script>