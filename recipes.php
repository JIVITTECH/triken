<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' ';
$pageCanonical = '';
$url = ' ';
include('header.php');
include('main.php');
$page ="Recipes & Tips";
?>
<script src="js/recipes.js"></script>
<?php include('breadcrumb.php'); ?>
			
			<div class="page-content">
                <div class="container">
				
                    <section class="recipe_sec">
						<div class="row">
								<h2 class="title title-center">Our Recipes</h2>
								<div>
								<input type="text" class="form-control recipe-form" onkeyup ="loadAllRecipes()" id="recipe_name" placeholder="Search our recipes...">
								</div>
						</div>
						
						<ul class="nav-filters" id="category_container">
                        
						</ul>
					
					<hr>
					
                    <div class="row grid cols-lg-3 cols-md-2 mb-2"  id="recipe_container" data-grid-options="{
                        'layoutMode': 'fitRows'
                    }" style="position: relative;">
                      
                    </div>
						
                    </section>
					
				</div>

				
			</div>
			
		</main>
<script>
$(document).ready(function () {
	loadSelectedCategory();
});
</script>


<?php include('footer.php'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
