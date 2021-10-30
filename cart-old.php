<?php
    $title = 'Country Chicken - Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'index,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    $page ="Cart";
    include('header.php');
    include('main.php');
?> 

<style type="text/css"> 
.submenu{padding: 10px 0; border-bottom: 1px solid #eee;}
</style>
<hr>

<section class="cartpage">
    <div class="container">
        <h1 class="title text-center appear-animate"> Your Cart </h1>  
        <div class="row gutter-lg">
            <div class="col-lg-8 pr-lg-4 mb-6">
                <table class="shop-table cart-table cart_delivery">
                    <thead> <tr> <th colspan="3" class="product-name"><span>Products</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                             <td class="product-thumbnail">
                                <div class="p-relative">
                                    <a href="#">
                                        <figure>
                                            <img src="assets/images/products/currycut.jpg" alt="product">
                                        </figure>
                                    </a>
                                </div>
                            </td>
                            <td class="product-name">
                                <a href="#"> Country Chicken Curry cuts Small (varuval) with skin </a>
                                <div  class="product-price">
	                               <ins class="new-price">650</ins>
								   <span class="gms"> 500 gms </span>
								</div>
                            </td>
                            <td class="product-quantity">
                                <div class="input-group">
                                    <input class="quantity form-control" type="number" min="1" max="100000">
                                                <button class="quantity-plus w-icon-plus"></button>
                                                <button class="quantity-minus w-icon-minus"></button>
                                </div>
                                <span class="remove"> <a href=""> Remove </a> </span>
                            </td>
                        </tr>
                        <tr>
                             <td class="product-thumbnail">
                                <div class="p-relative">
                                    <a href="#">
                                        <figure>
                                            <img src="assets/images/products/currycut.jpg" alt="product">
                                        </figure>
                                    </a>
                                </div>
                            </td>
                            <td class="product-name">
                                <a href="#"> Baasa Fish </a>
                                <div  class="product-price">
                                   <ins class="new-price">1750</ins>
                                   <span class="gms"> 1100 gms</span>
                                </div>
                            </td>
                            <td class="product-quantity">
                                <div class="input-group">
                                    <input class="quantity form-control" type="number" min="1" max="100000">
                                                <button class="quantity-plus w-icon-plus"></button>
                                                <button class="quantity-minus w-icon-minus"></button>
                                </div>
                                <span class="remove"> <a href=""> Remove </a> </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-continue">
                    <a href="#" class="btn btn-block "> <i class="w-icon-long-arrow-left"></i> Continue Shipping </a>
                </div>
            </div>
            <div class="col-lg-4 delivery">
                 <table class="shop-table cart-table order-summary">
                    <thead> <tr> <th colspan="1" class="product-name"><span>Delivery</span></th> </tr> </thead>
                    <tbody>
                        <tr>
                            <td>
                                  <div class="payment-methods" id="payment_method">
                                            <div class="accordion payment-accordion">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#payment" class="expand">Deliver Now (120 mins)</a>
                                                    </div>
                                                    <div id="payment" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" class="collapse">Pickup Date & Time</a>
                                                    </div>
                                                    <div id="cash-on-delivery" class="card-body expanded">
                                                        <form>
                                 <input placeholder="Select your delivery date" class="form-control" type="date"  id="date" required="required">
                                
                                
                                <div class="form-group">
                                                <div class="select-box">
                                                    <select name="state" class="form-control form-control-md">
                                                        <option value="default" selected="selected">Select your delivery time
                                                        </option>
                                                        <option value="slot1">7-9 AM</option>
                                                        <option value="slot2">9-11 AM</option>
                                                        <option value="slot3">11-01 PM</option>
                                                        <option value="slot4">1-3 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                </form>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="cart-subtotal align-items-center justify-content-between">
                                    <div class="csubtotal">
                                        <label class="ls-25">Subtotal  </label>
                                        <ins class="subtotal">2400</ins>
                                    </div>
                                        <p> Delivery, taxes, and discount codes
                                        calculated at checkout </p>
                                </div>

                                <button type="submit" class="btn btn-block btn-checkout"> Checkout </button> 
                            </td>
                        </tr>
                       <!-- <tr>
                            <td>
                                <ul class="shipping-methods mb-2">
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="free-shipping" class="custom-control-input"
                                                    name="shipping">
                                                <label for="free-shipping"
                                                    class="custom-control-label color-dark">Deliver Now (120 mins)</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="local-pickup" class="custom-control-input"
                                                    name="shipping">
                                                <label for="local-pickup"
                                                    class="custom-control-label color-dark">Pickup Date & Time</label>
                                            </div>
                                        </li>
                                    </ul>
                            </td>
                        </tr> -->
                       <!-- <tr>
                           <td> 
                                <form>
                                <label> Pickup Date & Time </label>
                                <input placeholder="Select your delivery date" class="form-control" type="text" onfocus="(this.type='date')" id="date" required="required">
                                <input placeholder="Select your delivery time" class="form-control" type="text" onfocus="(this.type='time')" id="time" required="required"> 

                                <div class="cart-subtotal align-items-center justify-content-between">
                                    <div class="csubtotal">
                                        <label class="ls-25">Subtotal  </label>
                                        <ins class="subtotal">2400</ins>
                                    </div>
                                        <p> Delivery, taxes, and discount codes
                                        calculated at checkout </p>
                                </div>

                                <button type="submit" class="btn btn-block btn-checkout"> Checkout </button> 
                                </form>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section> 

<?php include('footer.php'); ?>