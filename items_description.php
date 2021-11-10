<?php
    $title = 'Country Chicken - Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    $category ="Country Chicken";
    $page ="Country Chicken Curry Cut Small with Skin";
    include('header.php');
?> 

<?php include('main.php'); ?>

<?php include('product_breadcrumb.php'); ?>
<script src="js/items_description.js"></script>

<div class="page-content">
    <div class="product product-single">
    	<div class="singleproduct">
	    	<div class="container">
		    	<div class="row">
		            <div class="col-md-6 mb-6">
		                <div class="product-gallery product-gallery-sticky product-gallery-vertical">
		                    <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
		                                    'navigation': {
		                                        'nextEl': '.swiper-button-next',
		                                        'prevEl': '.swiper-button-prev'
		                                    }
		                                }">
		                        <div class="swiper-wrapper row cols-1 gutter-no" id="images_tag">
		                            
		                        </div>
		                            <button class="swiper-button-next"></button>
		                            <button class="swiper-button-prev"></button>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6 mb-4 mb-md-6">
		                <div class="product-details">
		                    <label class="product-label label-discount best" id="best_seller_tag" style="margin-right:10px;">Best Seller</label><span class="product-cat" id="item_name"></span>
		                    <h1 class="product-title"><span class="sel_name" id="sel_name"></span> </h1>
		 						<div class="row prod_quant">
									<ul class="product-cat">
										<li> Net wt: <b> <span id="net_weight"></span> </b> </li>
										<li> Gross wt: <b> <span id="gross_weight"></span> </b></li>
									</ul>
								</div>
		                     <hr class="product-divider">
		                    <div class="product-short-desc lh-2">
		                    	<div class="row" id="specs_div">
									<div class='col-md-6 col-sm-12' id="specifications_div_1">
									</div>
									<div class='col-md-6 col-sm-12' id="specifications_div_2">
									</div>
		                    	</div>	
		                    </div> 
		                    <hr class="product-divider">
		                    <div class="fix-bottom product-sticky-content sticky-content">
		                        <div class="product-form container">
		                        	<div class="row">
		                        		<div class="col-lg-9 col-sm-12">
				                            <div class="product-qty-form with-label">
				                            	<div class="row">
				                            		<div class="col-lg-8">
							                            <div class="product-price" id="product_price">
															
														</div> 
													</div>
													<div class="col-lg-4">
							                            <div class="input-group" id="button_grp">
							                                    <input class="quantity form-control" id="qty_in_cart" type="number" disabled min="0" max="10000000">
							                                    <div id="add_sub"></div>
													    </div>
							                        </div>
						                        </div>
				                            </div>
				                        </div>
				                        <div class="col-lg-3 col-sm-12" id="add_to_cart">
				                            
				                        </div>
			                        </div>
		                        </div>
		                    </div> 
		                    <hr class="product-divider" >
		                    <p id="product_des"> Taste the chicken of our nativity that is as meaty as mutton, yet tender enough to make your bites juicy. An excellent source of protein and minerals, our free-range country chickens are raised in farms and grooves. See more </p>
		                    <hr class="product-divider">

		                    <div class="banner-video product-video br-xs">
		                    	<div class="row">
		                    		<div class="col-lg-6 col-sm-6">
		                    			<figure class="media">
		                                	<a class="btn-play-video btn-iframe" href="#"> <span id="video_link"></span>See our hygienic process </a>
		                        		</figure>
		                    		</div>
		                    		<div class="col-lg-6 col-sm-6">
		                    			<figure class="delivered">
		                                	 <img src="assets/images/products/detail/delivery.svg"> Delivered in <b> <span id="delivery_time"></span> </b> mins </b>
		                        		</figure>
		                    		</div>
		                    	</div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		
		<?php include('whytodays.php'); ?>
		
		<section class="best_seller related appear-animate bg-white">
			<div class="container">
		        <div class="widget-body br-sm h-100">
		       		<h1 class="title text-left appear-animate"> Related Products</h1> 
		                <div class="swiper slider_sec">
		                    <div class="swiper-container swiper-theme nav-top" data-swiper-options="{
		                                        'slidesPerView': 1.1,
		                                        'spaceBetween': 10,
		                                        'breakpoints': {
		                                            '576': {
		                                                'slidesPerView': 2
		                                            },
		                                            '768': {
		                                                'slidesPerView': 3
		                                            },
		                                            '992': {
		                                                'slidesPerView': 4
		                                            }
		                                        }
		                                    }">
			                    <div class="swiper-wrapper row cols-lg-1 cols-md-3" id="related_products">
			                                            
			                    </div>
			                    <button class="swiper-button-next"></button>
			                    <button class="swiper-button-prev"></button>
		                    </div>
		                </div>
		        </div>
		    </div>
		</section>

		<?php include('faq.php'); ?>

		<?php include('review.php'); ?>

   </div>
</div>



<?php include('footer.php'); ?>

<script src="js/common.js"></script>
<script type='text/javascript'>


$(document).ready(function () {
	
});

var branch_id = 1;
var customer_id = -1;
var cus_cart_id = 404;

</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

