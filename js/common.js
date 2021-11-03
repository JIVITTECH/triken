var branch_id = 1;
var customer_id = 45;
var cus_cart_id = 404;
         
var item_list_array = []; // Global item list array
var quantity = 0; // Total item quanity selected by the user
var replace_name = "";// selected replace name
            

function saveItemDetails(menu_id, customer_id, amount, item_name, pkg_charge) {
    if (customer_id !== "-1") {
		addToCart(menu_id, customer_id, amount, item_name, pkg_charge);
	} else {
		if (item_list_array.length > 0) {
			for (var i = 0; i < item_list_array.length; i++) {

				if (item_list_array[i].menu_id === +menu_id) {
					item_list_array[i].quantity = +item_list_array[i].quantity + 1;
					break;
				}
			}
			$.cookie("item_list", JSON.stringify(item_list_array));		
		} else {
			var items_list = {
				'menu_id': +menu_id,
				'price': price,
				'quantity': 1,
				'item_name': replace_name,
				'pkg_charge': pkg_charge
			};
			item_list_array.push(items_list);
			$.cookie("item_list", JSON.stringify(item_list_array));
			var item_array_length = item_list_array.length;
			//document.getElementById("cart_count").innerHTML = "(0)";
			//document.getElementById("cart_count").innerHTML = "(" + item_array_length + ")";
		}
	}
}


function addToCart(menu_id, customer_id, price, name, pkg_charge) {
	var qty = 1;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/add_or_remove_item_in_cart.php?menu_id=" + menu_id + "&customer_id=" + customer_id + "&quantity=" + qty + "&branch=" + branch_id + "&price=" + price + "&cus_cart_id=" + cus_cart_id + "&name=" + encodeURIComponent(name) + "&pkg_charge=" + pkg_charge + "&action=add_item_to_cart";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = xmlhttp.responseText;
			if (myObj !== "") {
				var arr1 = getAllUrlParams((window.location).toString());
	            var menu_id = arr1.item_id;
				if(+menu_id === +arr1.item_id){
					loadItemsFromCart();
				}
				//loadCartCount(cart_id);
			}
		}
	};
}

var total_qty = 0;

function loadItemsFromCart() {
	var arr1 = getAllUrlParams((window.location).toString());
	var menu_id = arr1.item_id;
	if (customer_id !== "-1") {
		var xmlhttp = new XMLHttpRequest();
		var url = "api/add_or_remove_item_in_cart.php?menu_id=" + menu_id + "&branch=" + branch_id + "&cus_cart_id=" + cus_cart_id + "&action=load_item_from_cart";
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var myObj = JSON.parse(this.responseText);
				if (myObj.length > 0) {
					total_qty = +myObj[0].quantity;
					if(+myObj[0].quantity > 0){
						document.getElementById("button_grp").style.display = "block";
						document.getElementById("add_button").style.display = "none";
						document.getElementById("remove_button").style.display = "block";
						document.getElementById("qty_in_cart").value = myObj[0].quantity;
					}else{
						document.getElementById("button_grp").style.display = "none";
						document.getElementById("add_button").style.display = "block";
						document.getElementById("remove_button").style.display = "none";
						document.getElementById("qty_in_cart").value = myObj[0].quantity;
					}
				}else{
					document.getElementById("button_grp").style.display = "none";
					document.getElementById("add_button").style.display = "block";
					document.getElementById("remove_button").style.display = "none";
				}
			}
		};
	}else{
		if ($.cookie("item_list") !== undefined) {
			var item_list = $.parseJSON($.cookie("item_list"));
			$.cookie("item_list", JSON.stringify(item_list));
			for (var i = 0; i < item_list.length; i++) {
			var items = "";
			var menu_id = item_list[i].menu_id;
			var sel_qty = item_list[i].quantity;
			var price = item_list[i].price;
			var rep_name = item_list[i].rep_name;
			var pkg_charge = item_list[i].pkg_charge;
			items = {
				'menu_id': menu_id,
				'price': price,
				'quantity': sel_qty,
				'rep_name': rep_name,
				'pkg_charge' : pkg_charge
			};
			item_list_array.push(items);
			
			if(+menu_id === +arr1.item_id){
					document.getElementById("button_grp").style.display = "block";
					document.getElementById("qty_in_cart").value = sel_qty;
					break;
				}else{
					document.getElementById("button_grp").style.display = "none";
				}
			}
		}
	}
}

function redQty(menu_id, price, name, pkg_charge) {
	if (customer_id !== "-1") {
		removeFromCart(menu_id, customer_id, price, name, pkg_charge);// remove the items from cart directly 
	} else {
		for (var i = 0; i < item_list_array.length; i++) {

			if (item_list_array[i].menu_id === menu_id) {
				item_list_array[i].quantity = +total_qty - 1;
				break;
			}
		}
		$.cookie("item_list", JSON.stringify(item_list_array));
	}
}
	
function removeFromCart(menu_id, customer_id, price, name, pkg_charge) {
	var qty = total_qty - 1;
	var xmlhttp = new XMLHttpRequest();
	var url = "api/add_or_remove_item_in_cart.php?menu_id=" + menu_id + "&customer_id=" + customer_id + "&quantity=" + qty + "&branch=" + branch_id + "&price=" + price + "&cus_cart_id=" + cus_cart_id + "&name=" + encodeURIComponent(name) + "&pkg_charge=" + pkg_charge + "&action=remove_item_from_cart";
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = xmlhttp.responseText;
			if (myObj !== "") {
				var arr1 = getAllUrlParams((window.location).toString());
	            var menu_id = arr1.item_id;
				if(+menu_id === +arr1.item_id){
					loadItemsFromCart();
				}
				//loadCartCount(cart_id);
			}
		}
	};
}