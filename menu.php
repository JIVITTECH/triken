        <header class="header">
            <div class="mlogo">
                        <a href="index.php" class="logo">
                            <img src="assets/images/logo.png" alt="logo">
                        </a>
                    </div>
            <section class="sticky-content fix-top sticky-header border-no">
                <div class="header-middle">
                    <div class="container">
                        <div class="header-left mr-md-4">
                            <a href="#" class="mobile-menu-toggle  w-icon-hamburger"></a>
                            <a href="index.php" class="logo hidden-sm">
                                <img src="assets/images/logo.png" alt="logo">
                            </a>
                            <form method="get" action="#"
                                class="input-wrapper header-search hs-expanded hs-round d-md-flex">
                                <div class="select-box">
                                    <a class="button" href="#popup1"><i class="fa fa-map-marker" aria-hidden="true"></i>
     VOC Colony, Peelamedu</a>
                                </div>
                                <button class="btn btn-search productsearch hidden-sm" type="submit">
                                    <i class="w-icon-search"></i>
                                    <input type="text" class="form-control pt-0 pb-0" name="search" id="search" onblur="this.placeholder = 'Search your delicious product'"
                                    placeholder="Search your delicious product" onfocus="this.placeholder = ''" required />
                                </button>
                            </form>
                        </div>
                        <div class="header-right">
                            <div class="header-call d-xs-show d-lg-flex align-items-center">
                                        <a href="about.php">About</a>
                            </div>
                            <a href="login.php" id="login" class="login sign-in"> <i class="fa fa-user-circle" aria-hidden="true"></i>
     <span class="htext">Log In/Sign Up</span></a>
                            <!--<a href="otp.php" class="login sign-in hidden-sm">OTP</a>-->
                            <div class="dropdown cart-dropdown mr-0 mr-lg-2">
                                <div class="cart-overlay"></div>
                                <a href="#" class="cart-toggle label-down link">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span class="cart-count" id="cart_count"></span>
                                    </i>
                                    <span class="cart-label">Cart</span>
                                </a>
                                <div class="dropdown-box">
                                    <div class="products" id="cart_items_container" style="height: 100% !important;">
									  No Items Added
                                    </div>
    
                                    <div class="cart-total">
                                        <label>Subtotal:</label>
                                        <span id="subtotal_cart_container" class="subtotal_cart_container">0.00</span>
                                    </div>
    
                                    <div class="cart-action">
                                        <a onclick ="checkUserSession()" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                        <a onclick ="checkUserSession()" class="btn btn-primary  btn-rounded">Checkout</a>
                                    </div>
                                </div>
                                <!-- End of Dropdown Box -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submenu">
                    <div class="container">
                <div class="category-wrapper row cols-12" id="top_container">
                </div> 
            </div>
                </div>
            </section>
            <!-- End of Header Middle -->
        </header>
        <!-- End of Header -->

<main class="main">
</main>
<div id="popup1" class="overlay">
    <div class="popup">
         <a class="close" href="#">&times;</a>
             <?php include('location.php'); ?>
    </div>
</div>

<script>
		    
			$(document).ready(function () {
				var sel_elemt = document.getElementById("button_grp");
				if(customer_id !== -1){
					loadCartData();
				}else{
					loadCartDataFromCookie();
				}
				if(sel_elemt){
					loadItemsDescription();
					document.getElementById("qty_in_cart").value = 0;
				}else{
					loadCookieData();
				}
			});

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
				var sel_elemt = document.getElementById("button_grp");
							
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
						if(sel_elemt){
							document.getElementById("button_grp").style.display = "none";
							document.getElementById("add_button").style.display = "block";
							document.getElementById("remove_button").style.display = "none";
						}
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
			
			function saveCookieData() {
                var arr1 = getAllUrlParams((window.location).toString());
                var branch_id = 1;
				var customer_id= 1;
                var xmlhttp = new XMLHttpRequest();
                var url = "controller/saveCookieData.php?customer_id=" + customer_id + "&branch_id=" + branch_id;
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        $.removeCookie("item_list");
                    }
                };
            }
		</script>
