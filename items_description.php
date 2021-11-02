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
		                    <h1 class="product-title"> <?php echo "$page"; ?> </h1>
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
							                            <div class="input-group">
							                                    <input class="quantity form-control" type="number" min="1" max="10000000">
							                                    <button class="quantity-plus w-icon-plus"></button>
							                                    <button class="quantity-minus w-icon-minus"></button>
							                            </div>
							                        </div>
						                        </div>
				                            </div>
				                        </div>
				                        <div class="col-lg-3 col-sm-12">
				                            <button class="btn btn-primary btn-cart"> <span>Add to Cart</span> </button>
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


<script type='text/javascript'>

$(document).ready(function () {
	loadItemsDescription();
});

var branch_id = 1;

function getAllUrlParams(url) {
	// get query string from url (optional) or window
	var queryString = url ? url.split('?')[1] : window.location.search.slice(1); // we'll store the parameters here
	var obj = {}; // if query string exists
	if (queryString) {

		// stuff after # is not part of query string, so get rid of it                                                 queryString = queryString.split('#')[0];

		// split our query string into its component parts
		var arr = queryString.split('&');
		for (var i = 0; i < arr.length; i++) {
			// separate the keys and the values
			var a = arr[i].split('=');
			// in case params look like: list[]=thing1&list[]=thing2
			var paramNum = undefined;
			var paramName = a[0].replace(/\[\d*\]/, function (v) {
				paramNum = v.slice(1, -1);
				return '';
			});
			// set parameter value (use 'true' if empty)
			var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
			// (optional) keep case consistent
			paramName = paramName.toLowerCase();
			paramValue = paramValue.toLowerCase();
			// if parameter name already exists
			if (obj[paramName]) {                                 // convert value to array (if still string)
				if (typeof obj[paramName] === 'string') {
					obj[paramName] = [obj[paramName]];
				}
				// if no array index number specified...
				if (typeof paramNum === 'undefined') {
					// put the value on the end of the array                                                             obj[paramName].push(paramValue);
				}
				// if array index number specified...
				else {
					// put the value at that index number                                     obj[paramName][paramNum] = paramValue;
				}
			}
			// if param name doesn't exist yet, set it
			else {
				obj[paramName] = paramValue;
			}
		}
	}

	return obj;
}	
</script>
