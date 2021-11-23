function loadFooterCategories() { 
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/load_home_page.php?action=get_list_of_categories&branch_id=" + branch_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var myObj = JSON.parse(this.responseText);
			if (myObj.length !== 0) {
			    information = information + "<div class='widget'>" +
									   		  "<h4 class='widget-title'>Categories</h4>" +
											  "<ul class='widget-body'>";
			    for (var i = 0; i < myObj.length; i++) {
					information = information + "<li><a href='products.php?category_id=" + myObj[i].id + "'>" + myObj[i].name + "</a></li>";
									            
				}
				information = information +   "</ul>" +
                                            "</div>";
				$('#load_footer_cats_container').empty();
				$('#load_footer_cats_container').append(information);
		    } else {
			    $('#load_footer_cats_container').empty();
				$('#load_footer_cats_container').append("<center>No Categories found<\center>");
            }
		}
	};
}

function loadFooterItemsForCategories() {
    if(typeof branch_id ==="undefined") {
        branch_id = '-1';
    }
    var information = "";
	var xmlhttp = new XMLHttpRequest();
	var url = "api/load_footer_page.php?action=get_list_of_all_items_for_cats&branch_id=" + branch_id;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			information = this.responseText;
			$('#load_footer_items_for_cats_container').empty();
			$('#load_footer_items_for_cats_container').append(information);
		}
	};
}