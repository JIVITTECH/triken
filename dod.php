<?php
    $title = 'Deal of the Day- Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    include('header.php');
    include('main.php');
    $page ="Deal of the Day";
?> 

<?php include('breadcrumb.php'); ?>
<script src="js/index.js"></script>

<section class="productcat">
	<div class="container">
		<div class="row cols-xl-4 cols-md-3 cols-sm-3">
            <div id="all_deals_of_the_day_container">
            </div>            
        </div>
	</div>
</section>

<?php include('footer.php'); ?>
<script type='text/javascript'>
    $(document).ready(function () {
        loadAllDealsOfTheDay();
    });
</script>