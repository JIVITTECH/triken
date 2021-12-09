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
                            <div class="input-wrapper header-search hs-expanded hs-round d-md-flex">
                                <div class="select-box">
                                    <a class="button" onclick="$('.lpopup').show();"><i class="fa fa-map-marker" aria-hidden="true"></i>
									<span id="loc_name"></span></a>
                                </div>
                                <button class="btn btn-search productsearch hidden-sm" type="submit">
                                    <i class="w-icon-search" onclick="search_products_by_text()"></i>
                                    <input type="text" class="form-control pt-0 pb-0" name="search" id="search" onblur="this.placeholder = 'Search your delicious product'"
                                    placeholder="Search your delicious product" onfocus="this.placeholder = ''" required />
                                </button>
                            </div>
                        </div>
                        <div class="header-right">
                            <div class="header-call d-xs-show d-lg-flex align-items-center">
                                        <a href="about.php">About</a>
                            </div>
							<?php if ($customer_id  === '-1') { ?>    
								<a href="login.php" id="login" class="login sign-in"> <i class="fa fa-user-circle" aria-hidden="true"></i>
								<span class="htext">Log In/Sign Up</span></a>
							<?php } ?>
                            <?php if ($customer_id  !== '-1') { ?>    
                            <a  onclick="logout()" id="logout" class="login sign-in"> <i class="fa fa-user-circle" aria-hidden="true"></i>
								<span class="htext">Logout</span></a>
							<?php } ?>
							<div class="dropdown cart-dropdown mr-0 mr-lg-2">
                                <div class="cart-overlay"></div>
                                <a class="cart-toggle label-down link">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span class="cart-count" id="cart_count"></span>
                                    </i>
                                    <span class="cart-label">Cart&nbsp;&nbsp;&nbsp;</span>
                                </a>
								<div class="dropdown-box" style="max-height:600px;overflow-y: scroll;">
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
								<input type="hidden" id="contact_no">
                                <!-- End of Dropdown Box -->
                            </div>
							<?php if ($customer_id  !== '-1') { ?>
								<a class="cart-toggle label-down link">
									<i id="my_account"  onclick="window.location.href='my-account.php?view=1'" class="fa fa-user-circle" style="font-size:24px" aria-hidden="true">
										<span class="" id=""></span>
									</i>
									<span class="cart-label"></span>
								</a>
							<?php } ?>
						 <a href="otp.php" id="otp_btn" class="login sign-in hidden-sm"></a>
						 </div>
                    </div>
                </div>
				<div class="msearch hidden-md">
                    <form  onsubmit="return false"
                                class="input-wrapper header-search hs-expanded hs-round d-md-flex">
                    <button class="btn btn-search productsearch ">
						<i class="w-icon-search" onclick="search_products_by_text_mobile()"></i>
						<input type="text" class="form-control pt-0 pb-0" name="search" id="search_mobile" onblur="this.placeholder = 'Search your delicious product'"
						placeholder="Search your delicious product" onfocus="this.placeholder = ''" required />
					</button>
                    </form>
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
        <?php include('location.php'); ?>
    </div>
</div>
<script>
			function search_products_by_text_mobile() {
				var search_text = document.getElementById("search_mobile").value;
				if (search_text.trim().length != '0') {
				   window.location.href = "search.php?search_text=" + search_text;
				}
			}

			$("#search_mobile").keyup(function(event) {
				var search_text = document.getElementById("search_mobile").value;
				if (event.keyCode === 13) {
					if (search_text.trim().length != '0') {
					   window.location.href = "search.php?search_text=" + search_text;
					}
				}
			});
		    
			$(document).ready(function () {
				var loadDynamicData = "";
				var no_of_active_branches = 0;
				$.get("api/load_home_page.php?action=get_list_of_cities", function (data, status) {
					var jsonStr = JSON.parse(data);
					for (var i = 0; i < jsonStr.length; i++) {
						if (jsonStr[i].branch_exists === 'Y') {
						    no_of_active_branches = no_of_active_branches + 1;
							loadDynamicData = loadDynamicData+ "<div><label for='chkYes' class='location'><input type='radio' id='chkYes' class='loc' name='chkPassPort' onclick='ShowHideDiv()'/>" + jsonStr[i].city_name + "</label> <br><span class='soon hide'> Coming Soon!</span></div>";
						} else {
							loadDynamicData = loadDynamicData+"<div><label for='chkNo' class='no location'><input type='radio' id='chkNo' class='loc' name='chkPassPort' onclick='ShowHideDiv()'/> " + jsonStr[i].city_name + "</label> <br><span class='soon'> Coming Soon!</span></div>";
						}
					}
					$('#cities').append(loadDynamicData);
					if (no_of_active_branches == 1) {
					    $('#chkYes').click();
					}
				});
				
				var sel_elemt = document.getElementById("button_grp");
				var user_location = readCookie('locName');
				if(user_location !== undefined && user_location !== "" && user_location !== null){
					document.getElementById("loc_name").innerHTML = user_location;
				} else {
				    document.getElementById("loc_name").innerHTML = "Please select a location";
				}
				if (branch_id != '-1' && branch_id != "") {
				    loadTopCategories();
				}
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

            function loadTopCategories() {
				var name = "";
				var image_path ="";
				var icon ="";
				var information = "";
				var no_of_cats_to_load = 7;
				$('#top_container').empty();
				var xmlhttp = new XMLHttpRequest();
				if(typeof branch_id ==="undefined") {
					branch_id = '-1';
				}
				var url = "api/getTopCategories.php?action=get_top_categories&branch_id=" + branch_id;
				xmlhttp.open("GET", url, true);
				xmlhttp.send();
				xmlhttp.onreadystatechange = function () {
					if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
						var myObj = JSON.parse(this.responseText);
						if (myObj.length < 7) {
						   no_of_cats_to_load = myObj.length;
						}
						if (myObj.length !== 0) {
							for (var i = 0; i < no_of_cats_to_load; i++) {
								icon = myObj[i].icon;
								name = myObj[i].name;
								if (icon !== "")
								{
									image_path = dirname +  icon.replace("../", "");
								} else
								{
									image_path = 'images/default.jpg';
								}
								information = information + "<div class='category'>" +
																"<figure class='category-media'>" +
																	  "<a href='products.php?category_id=" + myObj[i].id + "'>" +
																		   "<img onerror='onImgError(this)' src=" + image_path + " alt=" + name + ">" +
																		   "<h4 class='category-name'>" + name + "</h4>" +
																	  "</a>" +
																"</figure>" + 
															"</div>";
							}
							$('#top_container').append(information);
						} else {
							$('#top_container').append("<center>No Categories found<\center>");
						}
					}
				};
			}

			function readCookie(name) {
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for(var i=0;i < ca.length;i++) {
					var c = ca[i];
					while (c.charAt(0)==' ') c = c.substring(1,c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
				return null;
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
			
		
			function logout() {
                var arr1 = getAllUrlParams((window.location).toString());
                var xmlhttp = new XMLHttpRequest();
                var url = "logout.php";
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        window.location.href = "index.php";
                    }
                };
            }

			function search_products_by_text() {
			    var search_text = document.getElementById("search").value;
				if (search_text.trim().length != '0') {
				   window.location.href = "search.php?search_text=" + search_text;
				}
			}
			
			$("#search").keyup(function(event) {
				var search_text = document.getElementById("search").value;
				if (event.keyCode === 13) {
					if (search_text.trim().length != '0') {
						window.location.href = "search.php?search_text=" + search_text;
					}
				}
			});

			function gotoHome() {
	            window.location.href = "index.php";
	        }
		
       		//var dirname = "app/Catering/"; 
			var dirname = "../ecaterweb/Catering/";
			
			function ValidateNumber(){
				var mobileNo = document.getElementById("phone").value;
				var mbLength = mobileNo.length;
				if(mbLength === 10){
					document.getElementById("send_otp").style.pointerEvents  = 'auto';
				}
			}

			function camelCase(str) {
				var string = str.split(' ');
				var stringCamelCase = '';
				for (i=0 ; i< string.length ; i++) {
				   stringCamelCase = stringCamelCase +  string[i].charAt(0).toUpperCase() + string[i].slice(1).toLowerCase() + ' ';
				}
				return stringCamelCase;
			}
		</script>
