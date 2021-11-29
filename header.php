<?php
   include_once './session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <script src="js/basics.js"></script>
	<title>
		<?php echo $title; 
		$keywords = "";
		$category = "";
		$page = "";
		?>
	</title>

		<meta name="description" content="<?php echo $description; ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta property="og:title" content="<?php echo $title; ?>">
		<meta property="og:description" content="<?php echo $description; ?>">
		<meta property="og:image" content="<?php echo $image; ?>">
		<meta property="og:url" content="<?php echo $url; ?>">

		<?php
			if($pageCanonical)
			{
			echo '<link rel="canonical" href="' . $pageCanonical . '">';
			}
			if($pageRobots)
			{
			echo '<meta name="robots" content="' . $pageRobots . '">';
			}
		?>
		

		<link rel="icon" type="image/png" href="assets/images/fav.png">

	    <!-- Vendor CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">
		<script src="js/header.js"></script>

	    <!-- Plugins CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/vendor/magnific-popup/magnific-popup.min.css">

	    <!-- Default CSS -->
   		<link rel="stylesheet" type="text/css" href="assets/css/demo12.min.css">
   		<link rel="stylesheet" type="text/css" href="assets/css/todaysstyle.css">
   		<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

   		<link rel="stylesheet" type="text/css" href="assets/font/font-awesome/css/font-awesome.min">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/common.js"></script>

		<script>
		    
			var sel_obo_order_type = 3;
	        var customer_id = "<?php echo $_SESSION['user_id']; ?>";
			customer_id = +customer_id;
            var branch_id = "<?php echo $_SESSION['branch_id']; ?>";
			branch_id = branch_id;
            var cus_cart_id = "<?php echo $_SESSION['cart_id']; ?>";
            cus_cart_id= +cus_cart_id;
			
			function imgError(image) {
				image.onerror = "";
				image.src = "images/default.jpg";
				return true;
			}

		    function loadCookieData(){
				item_list_array = [];
				var arr1 = getAllUrlParams((window.location).toString());
				var menu_id = arr1.item_id;
				if ($.cookie("item_list") !== undefined) {
					var item_list = $.parseJSON($.cookie("item_list"));
					$.cookie("item_list", JSON.stringify(item_list));
					for (var i = 0; i < item_list.length; i++) {
					var items = "";
					var menu_id = item_list[i].menu_id;
					var sel_qty = item_list[i].quantity;
					var price = item_list[i].price;
					var rep_name = item_list[i].item_name;
					var pkg_charge = item_list[i].pkg_charge;
					items = {
						'menu_id': menu_id,
						'price': price,
						'quantity': sel_qty,
						'item_name': rep_name,
						'pkg_charge' : pkg_charge
					};
					item_list_array.push(items);
					}
					if(item_list.length > 0){
						setOption();
					}else{
						var sel_elemt = document.getElementById("button_grp");
						if(sel_elemt){
							document.getElementById("button_grp").style.display = "none";
							document.getElementById("add_button").style.display = "block";
							document.getElementById("remove_button").style.display = "none";
						}
					}
				}else{
					var sel_elemt = document.getElementById("button_grp");
						if(sel_elemt){
							document.getElementById("button_grp").style.display = "none";
							document.getElementById("add_button").style.display = "block";
							document.getElementById("remove_button").style.display = "none";
						}
				}
			}
			
			function setOption(){
				var arr1 = getAllUrlParams((window.location).toString());
				var flag = false;
				for (var k = 0; k < item_list_array.length; k++) {
					if (item_list_array[k].menu_id === +arr1.item_id) {// check if both id is same
					    total_qty = item_list_array[k].quantity;
						flag = true;
						break;
					}
				}
				for (var i = 0; i < item_list_array.length; i++) {
					if(flag === true){
						if (item_list_array[i].menu_id === +arr1.item_id) {// check if both id is same
							var sel_elemt = document.getElementById("button_grp");
							if(sel_elemt){
								if(item_list_array[i].menu_id === +arr1.item_id){
										document.getElementById("button_grp").style.display = "block";
										document.getElementById("add_button").style.display = "none";
										document.getElementById("remove_button").style.display = "block";
										document.getElementById("qty_in_cart").value = +item_list_array[i].quantity ;
								}
							}
						}
				}else{
						document.getElementById("button_grp").style.display = "none";
						document.getElementById("add_button").style.display = "block";
						document.getElementById("remove_button").style.display = "none";
					}
				}
			}
			
						
						
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
			
			function saveCookieData(customer_id,branch_id) {
                var arr1 = getAllUrlParams((window.location).toString());
                var xmlhttp = new XMLHttpRequest();
                var url = "api/saveCookieData.php?customer_id=" + customer_id + "&branch_id=" + branch_id;
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
						var myOnj = this.responseText;
                        var name = "item_list";
						document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
						window.location.href = "cart.php?branch_id=" + branch_id;
                    }
                };
            }
			
	</script>
		
</head>
<div class='lpopup popup'>
	<?php include('location.php'); ?>
</div>  

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


	
