<?php
    $title = 'Best seller- Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    include('header.php');
    include('main.php');
    $page ="Best Seller";
?> 

<?php include('breadcrumb.php'); ?>
<script src="js/index.js"></script>

<section class="productcat">
	<div class="container">
		<div id="all_best_selling_products_container" class="row cols-xl-4 cols-md-3 cols-sm-3">
        </div>
	</div>
</section>

<?php include('footer.php'); ?>
<script type='text/javascript'>
    $(document).ready(function () {
        loadAllBestSellingProducts();
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
