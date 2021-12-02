<!-- Start of Mobile Menu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay"></div>
        <!-- End of .mobile-menu-overlay -->

        <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
        <!-- End of .mobile-menu-close -->

        <div class="mobile-menu-container scrollable">
            <form onsubmit="event.preventDefault();" class="input-wrapper">
                <input type="text" id="search_mobile" class="form-control" name="search" autocomplete="off" placeholder="Search your delicious product"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search" onclick = "search_products_by_text_mobile()"></i>
                </button>
            </form>
            <!-- End of Search Form -->
            <div class="tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#main-menu" class="nav-link active">Main Menu</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="main-menu">
                    <ul class="mobile-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Todays’ Cut</a></li>
                        <li><a href="recipes.php">Recipes & Tips</a></li>
                        <li><a href="my-account.php">My Account</a></li>
                        <li><a href="#">Privacy Policy</a></li
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Mobile Menu -->

<script>
function search_products_by_text_mobile() {
	var search_text = document.getElementById("search_mobile").value;
	if (search_text.trim().length != '0') {
	   window.location.href = "products.php?search_text=" + search_text;
	}
}

$("#search_mobile").keyup(function(event) {
	var search_text = document.getElementById("search_mobile").value;
	if (event.keyCode === 13) {
        if (search_text.trim().length != '0') {
		   window.location.href = "products.php?search_text=" + search_text;
		}
    }
});
</script>
 
