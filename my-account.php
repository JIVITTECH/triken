<?php
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' ';
$pageCanonical = '';
$url = ' ';
include('header.php');
include('main.php');
$page ="My Account";
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
#myModal .popup {    background-color: #fff;    padding: 3% 3% 3%;    border-radius: 0;	}
</style>
<script src="js/GeoLocationMapping.js"></script>
<div class="page-content account_sec">
                <div class="container">
					<h2 class="title title-center">My Account</h2>
					<input type="hidden" id="reorder_cart_id" name="reorder_cart_id" value="" placeholder="" style="font-size: 18px; width: 100%; height: 40px;">
                    <input type="hidden" id="reorder_branch_id" name="reorder_branch_id" value="" placeholder="" style="font-size: 18px; width: 100%; height: 40px;">
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
        <div class="content">
            <a id = "close_btn" class="close" href="#">&times;</a>
            <form class="form account-details-form" action="" method="post">
             <div class="row"><h1>Add or Edit Address</h1></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					     <input type="text" id="building-name" name="building-name" placeholder="Flat no / Building Name" class="form-control form-control-md" >
               </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					 <input type="text" id="Street" name="street" placeholder="Street / Area" class="form-control form-control-md" >
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" id="area" name="area" placeholder="Area" class="form-control form-control-md" >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					 <input type="text" id="city" name="city" placeholder="City"  class="form-control form-control-md" >
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					    <input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control form-control-md" >
             	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" id="landmark" name="landmark" placeholder="Landmark" class="form-control form-control-md" >
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
				    <input type="hidden" id="hidden_address">
					<button type="button"  id="saveButton" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" onclick="saveNewDeliveryAddress(2);">Save Address</button>
					<button type="button"  id="updateButton" style="display:none;" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" onclick="updateDelivery(2);">Update Address</button>
				</div>
			</div>
		</div>
	</form>
        </div>
    </div>
</div>            

<a href="#myModal" id="reOrder" style="visibility:hidden;" class="button btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded ml-3 mt-2"></a>								
<div id="myModal" class="overlay">
    <div class="popup">
         <a id = "close_btn1" class="close" href="#">&times;</a>
        <div class="content">
            <form class="form account-details-form" action="" method="post">
				<div class="row" style="text-align:center;"><h1>Information</h1></div>
					<p> Do you really want to remove the items from the cart and proceed with REORDER? </p>
					<div class="row">
					<div class="form-group" id="makeDecision" style="margin-top:40px;text-align:center;">
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="removingOrderItems()">YES</button>
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="document.getElementById('close_btn1').click();">NO</button>
					</div>			
				</div>
			</form>
        </div>
    </div>
</div>

<a href="#myModal1" id="out_stock" style="visibility:hidden;" class="button btn acc_btn btn-outline btn-default btn-block btn-sm btn-rounded ml-3 mt-2"></a>								
<div id="myModal1" class="overlay">
    <div class="popup">
         <a id ="close_btn2" class="close" href="#">&times;</a>
        <div class="content">
            <form class="form account-details-form" action="" method="post">
				<div class="row" style="text-align:center;"><h1>Information</h1></div>
					<div id="infoMsg" style="font-size:16px;line-height: 2.6;"></div>
					<div class="row">
					<div class="form-group" style="margin-top:40px;text-align:center;">
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="navCartItem()">YES</button>
						<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723" onclick="document.getElementById('close_btn2').click();">NO</button>
					</div>			
				</div>
			</form>
        </div>
    </div>
</div>
            
<?php include('footer.php'); ?>
<script>
	var curr_cart_id = "<?php echo $_SESSION['cart_id']; ?>";
	curr_cart_id = +curr_cart_id;
</script>
<script src="js/loadProfileDetails.js"></script>
<script src="js/myOrders.js"></script>
<script src="js/saveDeliveryAddress.js"></script>
