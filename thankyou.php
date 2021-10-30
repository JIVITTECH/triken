<?php
    $title = 'Thank you- Triken ';
    $description = 'The only thing we stock is the packages we use to deliver the meat.';
    $pageRobots = 'noindex,nofollow';
    $image = ' '; 
    $pageCanonical = '';
    $url = ' '; 
    $page ="Deal of the Day";
    include('header.php');
    include('main.php');
?> 

<section class="thankyou">
    <div class="container">
        <div class="order-success ttext">
            <ul>
                <li><img src="assets/images/tick.svg">  </li>
                <li><h3> Thank you for your order! :)</h3>
            <p>We’ve received your order.</p></li>
            </ul>
            <table class="orderlist">
                <tr>
                    <td><p>Order Number:</p> <h6> #118471143479 </h6></td>
                    <td><p>Total:</p> <h6> ₹2100 </h6></td>
                </tr>
                <tr>
                    <td><p>Date:</p> <h6> Thu, Oct 28, 2021 </h6></td>
                    <td><p>Payment Method:</p> <h6> Bank Transfer </h6></td>
                </tr>
            </table>
        </div>
                    <div class="order-details-wrapper mb-5">
                        <h4>Order Details</h4>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#">Country Chicken Curry cuts Small (varuval) with skin</a>&nbsp;<strong>x 1</strong>
                                    </td>
                                    <td>$40.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Baasa Fish Curry cuts Small whole cleaned</a>&nbsp;<strong>x 1</strong>
                                    </td>
                                    <td>$60.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td>$100.00</td>
                                </tr>
                                <tr>
                                    <td>Delivery:</td>
                                    <td>Flat rate</td>
                                </tr>
                                <tr>
                                    <td>Payment method:</td>
                                    <td>Direct bank transfor</td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td>₹300</td>
                                </tr>
                                <tr class="total">
                                    <td class="border-no">Total:</th>
                                    <td class="border-no">$100.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End of Order Details -->

                    <div id="account-addresses">
                        <div class="row">
                            <!--<div class="col-sm-6 mb-8">
                                <div class="ecommerce-address billing-address">
                                    <h4 class="title title-underline ls-25 font-weight-bold">Billing Address</h4>
                                    <address class="mb-4">
                                        <table class="address-table">
                                            <tbody>
                                                <tr>
                                                    <td>John Doe</td>
                                                </tr>
                                                <tr>
                                                    <td>Conia</td>
                                                </tr>
                                                <tr>
                                                    <td>Wall Street</td>
                                                </tr>
                                                <tr>
                                                    <td>California</td>
                                                </tr>
                                                <tr>
                                                    <td>United States (US)</td>
                                                </tr>
                                                <tr>
                                                    <td>92020</td>
                                                </tr>
                                                <tr>
                                                    <td>1112223334</td>
                                                </tr>
                                                <tr class="email">
                                                    <td>nicework125@gmail.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </address>
                                </div>
                            </div> -->
                            <div class="col-sm-6">
                                <div class="ecommerce-address shipping-address">
                                    <h4>Shipping Address</h4>
                                        <table class="address-table">
                                            <tbody>
                                                <tr>
                                                    <td>
<address>41/2,SRC Sunrise,2nd Floor, Post,
Vivekanandha Nagar, Singanallur,
Tamil Nadu 641005</address></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="dslot">Delivery Slot </span>
                                                    <span class="slotdt">01/10/2021 |  7-9 AM slot</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Account Address -->

                    <a href="#" class="btn btn-dark "><i class="w-icon-long-arrow-left"></i>Back to Home</a>
        </div>
    </div>
</section>


<?php include('footer.php'); ?>