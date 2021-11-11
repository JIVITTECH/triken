<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' ';
$pageCanonical = '';
$url = ' ';
$page ="My Account";
include('header.php');
include('main.php');
?>
<style type="text/css"> 
.order-detail	{	font-size: 16px;    color: #333;	}
.account_sec .product.product-cart .product-detail {    max-width: 100%;	}
.order_sec	{	display: flex;    border-bottom: 2px dashed #D8D8D8;    padding-bottom: 10px;    margin: 0 40px;    padding-left: 0;	}
.order_row p {	padding: 10px 40px;	}
.account_sec .tab-vertical .tab-pane {    border: 1px solid #E8E8E8;	}
#my-orders.tab-pane .row {    padding: 20px 0 0;	}
#my-orders.tab-pane .row:last-child	{	border-bottom: 0px solid #E8E8E8;	}
#address-book	{	padding: 20px;	}
#address-book {    border: 0px solid #E8E8E8;    padding: 0px;	}
.billing-address {    padding: 20px 30px 20px 60px;    border: 1px solid #EAEAEA;  width: 46%;    margin: 2%;	}
.address {  position: relative;	}
.address:before	{	content: "";    background: url(assets/images/location_icon.png) no-repeat;    width: 20px;    height: 20px;    position: absolute;    display: inline-block;    left: -30px;	}
#popup2 .popup {    background-color: #fff;    padding: 3% 3% 3%;    border-radius: 0;	}
</style>
<script src="js/loadProfileDetails.js"></script>
<div class="page-content account_sec">
                <div class="container">
					<h2 class="title title-center">My Account</h2>
                    <div class="tab tab-vertical row gutter-lg">
                        <ul class="nav nav-tabs mb-6" role="tablist">
                            <li class="nav-item">
                                <a href="#my-orders" class="nav-link active">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a href="#address-book" class="nav-link">Address Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile" class="nav-link" onclick="load_profile_details();">Profile</a>
                            </li>
                        </ul>

                        <div class="tab-content mb-6">
                            

                            <div class="tab-pane active in mb-4" id="my-orders">

								<div class="row order_row">
									<div class="order_sec">
										<div class="col-md-10 col-xs-9">
										
												<div class="order-detail">
												Order #118471143479<br>
												Thu, Oct 28, 2021
												</div>
											
										</div>
										<div class="col-md-2 col-xs-12">
										<a href="#"  class="btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded">Reorder</a>
										</div>
									</div>
									<p>Country Chicken x1, Catla slice x1</p>
								</div>
								
								<div class="row order_row">
									<div class="order_sec">
										<div class="col-md-10 col-xs-9">
										
												<div class="order-detail">
												Order #118471143479<br>
												Thu, Oct 28, 2021
												</div>
											
										</div>
										<div class="col-md-2 col-xs-12">
										<a href="#"  class="btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded">Reorder</a>
										</div>
									</div>
									<p>Country Chicken x1, Catla slice x1</p>
								</div>
								
								<div class="row order_row">
									<div class="order_sec">
										<div class="col-md-10 col-xs-9">
										
												<div class="order-detail">
												Order #118471143479<br>
												Thu, Oct 28, 2021
												</div>
											
										</div>
										<div class="col-md-2 col-xs-12">
										<a href="#"  class="btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded">Reorder</a>
										</div>
									</div>
									<p>Country Chicken x1, Catla slice x1</p>
								</div>
								
							
                            </div>

                            

                            <div class="tab-pane" id="address-book">
                                <div class="row" id="address-book-row">
								
                                </div>
								<div class="row">
									<a href="#popup2" id="add-new-addr-btn" class="button btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded ml-3 mt-2">Add New Address</a>
									</div>
                            </div>

                            <div class="tab-pane" id="profile">
                                <form class="form account-details-form" action="api/update_profile_details.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="firstname" name="firstname" placeholder="First Name"
                                                    class="form-control form-control-md" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="lastname" name="lastname" placeholder="Last name"
                                                    class="form-control form-control-md" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <input type="text" id="phone" name="phone" placeholder="Phone Number"
                                                    class="form-control form-control-md" required>
                                    </div>

                                    <div class="form-group mb-6">
                                        <input type="email" id="email_1" name="email_1" placeholder="Email"
                                            class="form-control form-control-md" required>
                                    </div>
                                  
                                    <button type="submit" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div id="popup2" class="overlay">
    <div class="popup">
         <a class="close" href="#">&times;</a>
        <div class="content">
            <form class="form account-details-form" action="#" method="post">
             <div class="row"><h1>Add New Address</h1></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<textarea id="message" name="message" cols="30" rows="5" class="form-control" placeholder="Street Address"required></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" id="city" name="city" placeholder="City"
						class="form-control form-control-md" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" id="state" name="state" placeholder="State"
						class="form-control form-control-md" required>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" id="zipcode" name="zipcode" placeholder="Zipcode"
						class="form-control form-control-md" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input type="email" id="country" name="country" placeholder="Country"
					class="form-control form-control-md" required>
				</div>
			</div>
		</div>
	  
		<button type="submit" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4">Save Address</button>
	</form>
        </div>
    </div>
</div>            
            
<?php include('footer.php'); ?>