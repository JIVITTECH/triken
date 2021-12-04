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
        var url_attribute = getAllUrlParams((window.location).toString());
        var cat_id = url_attribute.category_id;
        if (branch_id !== '-1' && branch_id !== "") {
            loadAllCustomerReviews(branch_id, cat_id, '');
        }
    });
    
    function loadAllCustomerReviews(branch_id, category_id, item_id) {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
	
	$('#all_customer_review_container').empty();
	//document.getElementById("load_heading_of_breadcrumb").innerHTML = 'Customer Review';
	var xmlhttp = new XMLHttpRequest();
	var url = "api/get_customer_reviews.php?branch=" + branch_id + "&category_id=" + category_id + "&item_id=" + item_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
				var final_div = '';
				for (var i = 0; i < myObj.length; i++) {
					var img = myObj[i].image;
					var image_path = "";
					if (img !== "")
					{
						image_path = '<img src="' + img + '" class="img-responsive" alt="reviews">';
					}

					var rev_div = '<div class="col-lg-3 col-sm-6"> <div class="doorstep">' +
					image_path +
					'<div class="review">' +
					'<h4>' + myObj[i].customer_name + '</h4>' + 
					'<span class="star">';
					
					for (var j=0; j<myObj[i].ratings; j++) {
						rev_div = rev_div + '<i class="fa fa-star active" aria-hidden="true"></i>';
					}
					
					rev_div = rev_div + '</span>' +
					'<p>' + myObj[i].feedback + '</p>' +
					'</div></div>' +
					'<div class="space"></div>';
					
					final_div = final_div + rev_div + '</div>';
					
				}
				
				/* if((i+1)%3 !== 0) {
					final_div = final_div + '</div>' ;
				} */	
				
				$('#all_customer_review_container').append(final_div);
            } else {
				$('#all_customer_review_container').append("<center>No reviews yet</center>");
            }
		}
	};
}
</script>