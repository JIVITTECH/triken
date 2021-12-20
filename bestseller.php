<section class="best_seller appear-animate">
	<div class="container mb-4">
        <div class="widget-body br-sm h-100">
        	<div class="row">
        		<div class="col-lg-8 col-sm-12"> <h1 class="title text-left appear-animate"> <img src="assets/images/certificate.svg"> Best Selling Products </h1> </div>
        		<div class="col-lg-4 col-sm-12">
	        		<div class="viewall">
			        	<a href="bestselling.php" class="btn btn-dark"> View All </a>
			        </div>
        		</div>
        	</div>
                <div class="swiper slider_sec">
                    <div class="swiper-container swiper-theme nav-top" data-swiper-options="{
                                        'slidesPerView': 1.1,
                                        'spaceBetween': 10,
                                        'observer': true,
                                        'observeParents': true,
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
	                    <div class="swiper-wrapper row cols-lg-1 cols-md-3" id="ltd_best_selling_products_container">
	                                            
	                    </div>
	                    <button class="swiper-button-next"></button>
	                    <button class="swiper-button-prev"></button>
                    </div>
                </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function () {
    if (branch_id != '-1' && branch_id != "") {
        loadLtdBestSellingProducts();
    }
});
</script>