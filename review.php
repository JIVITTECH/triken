<section class="families appear-animate bg-white">
	<div class="container">
		<h1 class="title text-center appear-animate"> 5000 families have already chosen fresh,
daily-cut meat to be delivered at their doorstep. </h1>
		<div id="all_customer_review_container" class="row">
		</div>
		<div class="viewall">
        	<a href="#" class="btn btn-dark"> View More </a>
        </div>
	</div>	
</section>
<script type='text/javascript'>
    $(document).ready(function () {
		if (branch_id != '-1' && branch_id != "") {
			loadAllCustomerReviews(branch_id, '', '');
		}
    });
</script>