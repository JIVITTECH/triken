<?php
    $title = 'Best seller- Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    $page ="Best Seller";
    include('header.php');
    include('main.php');
?> 

<?php include('breadcrumb.php'); ?>
<script src="js/index.js"></script>

<section class="productcat">
	<div class="container">
		<div class="row cols-xl-4 cols-md-3 cols-sm-3" id="all_best_selling_products_container">
            
        </div>
	</div>
</section>

<?php include('footer.php'); ?>
<script type='text/javascript'>
    $(document).ready(function () {
        loadAllBestSellingProducts();
    });
</script>