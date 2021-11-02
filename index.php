<?php
    $title = 'Todays Cut - Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    include('header.php');
?> 

<body>
    <div class="page-wrapper">
    	<div class="main">

        <div class='lpopup popup'>
                <?php include('location.php'); ?>
                <a href='' class='close'>Close</a>
        </div>  


<?php include('menu.php'); ?>


<!-- banner section -->
<div class="intro-wrapper homebanner">
    <div class="swiper-container swiper-theme nav-inner swiper-nav-md animation-slider" data-swiper-options="{
                    'spaceBetween': 20,
                    'slidesPerView': 1,
                    'loop':true,
                    'autoplay': {
                            'delay': 8000,
                            'disableOnInteraction': false
                        }
                }">
        <div class="swiper-wrapper row cols-1 gutter-no">
            <div class="swiper-slide banner " style="background: url(assets/images/home_banner.jpg);">
            </div>
            <div class="swiper-slide banner " style="background: url(assets/images/home_banner.jpg);">
            </div>
            <div class="swiper-slide banner " style="background: url(assets/images/home_banner.jpg);">
            </div>
        </div>
        <button class="swiper-button-next"></button>
        <button class="swiper-button-prev"></button>
    </div>
</div>
                <!-- End of Intro Wrapper -->
                <div class="swiper-container swiper-theme intro-banner appear-animate" data-swiper-options="{
                    'spaceBetween': 20,
                    'slidesPerView': 1,
                    'loop':true,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2,
                            'spaceBetween': 15
                        },
                        '992': {
                            'slidesPerView': 3
                        }
                    }
                }">
                    <div class="swiper-pagination"></div>
                </div>
<!-- End of banner -->

<?php include('dealoftheday.php'); ?>
			
<?php include('bestseller.php'); ?>

<?php include('whytodays.php'); ?>


<section class="explore appear-animate">
	<div class="container">
		 <h1 class="title text-center appear-animate"> Explore by Categories </h1>
		 <div class="row cols-2" id="categories_container">
         </div>

<!-- recipes start -->
    <div class="recipe">
	     <h1 class="title text-center appear-animate mb-6">Recipes for dishes</h1>
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
		      <div class="swiper-wrapper row cols-2" id="recipe_container">
			  </div>
		 </div>

         <div class="viewall">
	          <a href="recipes.php" class="btn btn-dark"> View All Recipes </a>
	     </div>

    </div>
</section>

 <?php include('review.php'); ?>

<section class="featured">
	<div class="container">
		<h1 class="title text-center appear-animate"> Featured in </h1>
		<div class="row">
			<div class="col-lg-4 hidden-sm"> </div>
			<div class="col-lg-4 col-sm-12">
				<ul>
					<li> <img src="assets/images/hindu.jpg" class="img-responsive"> </li>
					<li> <img src="assets/images/covai.jpg" class="img-responsive"> </li>
				</ul>
				<p> Google Review: <span class="count"> 4.2 </span> <i class="fa fa-star" aria-hidden="true"></i>  </p>
			</div>
			<div class="col-lg-4 hidden-sm"> </div>
		</div>
	</div>	
</section>


<?php include('footer.php'); ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script src="js/index.js"></script>
<script type='text/javascript'>
$(function(){
	var overlay = $('<div id="overlay"></div>');
	overlay.show();
	overlay.appendTo(document.body);
	$('.lpopup').show();
	$('.close').click(function(){
	$('.lpopup').hide();
	overlay.appendTo(document.body).remove();
	return false;
	});

	$('.x').click(function(){
	$('.lpopup').hide();
	overlay.appendTo(document.body).remove();
	return false;
	});
});

$(document).ready(function () {
    loadAllRecipes();
    loadAllCategories();
    loadTopCategories('1');
});
</script>
</div>