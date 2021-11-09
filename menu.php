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
                            <a href="login.php" class="login sign-in"> <i class="fa fa-user-circle" aria-hidden="true"></i>
     <span class="htext">Log In/Sign Up</span></a>
                            <!--<a href="otp.php" class="login sign-in hidden-sm">OTP</a>-->
                            <div class="dropdown cart-dropdown mr-0 mr-lg-2">
                                <div class="cart-overlay"></div>
                                <a href="#" class="cart-toggle label-down link">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span class="cart-count" id="cart_count">0</span>
                                    </i>
                                    <span class="cart-label">Cart</span>
                                </a>
                                <div class="dropdown-box">
                                    <div class="products">
                                        <div class="product product-cart">
                                            <figure class="product-media">
                                                <a href="#">
                                                     <a href="#"><img src="assets/images/products/currycut.jpg" alt="Product"/> </a>
                                                </a>
                                            </figure>
                                            <div class="product-detail">
                                                <a href="#" class="product-name">Country Chicken Curry cuts Small
    (varuval) with skin 500 gms</a>
                                                <div class="product-qty-form mb-2 mr-2">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" type="number" min="1" max="10000000">
                                                        <button class="quantity-plus w-icon-plus"></button>
                                                        <button class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                    <div class="price-box">
                                                        <span class="product-price"><ins class="new-price">150</ins></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-link btn-close" aria-label="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
    
                                        <hr class="product-divider">
    
                                        <div class="product product-cart">
                                            <figure class="product-media">
                                                <a href="#">
                                                     <a href="#"><img src="assets/images/products/catla.jpg" alt="Product"/> </a>
                                                </a>
                                            </figure>
                                            <div class="product-detail">
                                                <a href="#" class="product-name">Baasa Fish</a>
                                                <div class="product-qty-form mb-2 mr-2">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" type="number" min="1" max="10000000">
                                                        <button class="quantity-plus w-icon-plus"></button>
                                                        <button class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                    <div class="price-box">
                                                        <span class="product-price"><ins class="new-price">150</ins></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-link btn-close" aria-label="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
    
                                    <div class="cart-total">
                                        <label>Subtotal:</label>
                                        <span class="subtotal">58.67</span>
                                    </div>
    
                                    <div class="cart-action">
                                        <a href="cart.php?branch_id=1" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                        <a href="cart.php?branch_id=1" class="btn btn-primary  btn-rounded">Checkout</a>
                                    </div>
                                </div>
                                <!-- End of Dropdown Box -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submenu">
                    <div class="container">
                <div class="category-wrapper row cols-12">
                    <div class="category <?php if ($page=='Country Chicken'|| $category=='Country Chicken') {echo "active";}?>"  >
                            <figure class="category-media">
                                <a href="country_chicken.php">
                                    <img src="assets/images/countrychicken.svg" alt="Country Chicken" >
                                        <h4 class="category-name"> Country Chicken </h4>
                                </a>
                            </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/chicken.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Chicken </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/mutton.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Mutton </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/fish.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Fish/Sea Food </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/egg.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Eggs </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/combos.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Combos </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/party.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Party Packages </h4>
                            </a>
                        </figure>
                    </div>
                </div> 
            </div>
                </div>
            </section>
            <!-- End of Header Middle -->
        </header>
        <!-- End of Header -->

<main class="main">
    <!--<section class="submenu sticky-content fix-top sticky-header border-no">
            <div class="container">
                <div class="category-wrapper row cols-12">
                    <div class="category <?php // if ($page=='Country Chicken'|| $category=='Country Chicken') {echo "active";}?>"  >
                            <figure class="category-media">
                                <a href="country_chicken.php">
                                    <img src="assets/images/countrychicken.svg" alt="Country Chicken" >
                                        <h4 class="category-name"> Country Chicken </h4>
                                </a>
                            </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/chicken.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Chicken </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/mutton.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Mutton </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/fish.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Fish/Sea Food </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/egg.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Eggs </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/combos.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Combos </h4>
                            </a>
                        </figure>
                    </div>
                    <div class="category">
                        <figure class="category-media">
                            <a href="#">
                                <img src="assets/images/party.svg" alt="Country Chicken" >
                                    <h4 class="category-name"> Party Packages </h4>
                            </a>
                        </figure>
                    </div>
                </div> 
            </div>
    </section> -->
</main>
<div id="popup1" class="overlay">
    <div class="popup">
         <a class="close" href="#">&times;</a>
             <?php include('location.php'); ?>
    </div>
</div>
