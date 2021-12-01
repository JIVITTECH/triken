<div id="branch_dialog" class="content">      
    <h2>Select your city</h2>
    <form class="findlocation" id='cities'>
    </form>    

            <div id="detect" style="display: none">
			    <h4 id="no_branch" style="display:none;color:red;">Sorry, we currently don’t deliver to your location. Please select a different location</h4>
                <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
             
                <input type="text" name="location" id="location" onclick="getLatAndLong();" class="form-control" placeholder="Enter your area" required="">
                <input type="hidden" id="latitude" name="latitude"  style="width:100%;height: 25px;" value="">
                <script src="js/GeoLocationMapping.js"></script>
                      <?php include "./geo-location-map.php"; ?> 
                <input type="hidden" id="longitude" name="longitude"  style="width:100%;height: 25px;" value=""> 
                    <button class="btn btn-dark" onclick="getLocation();" type="submit"> <img src="assets/images/detect.svg"> Detect my location</button>
                </form>  
                <p> Expansion of our delivery service into a wider
    geography is underway.</p>
            </div>
</div>
<div id="clear_cart" class="content" style="display:none;">
	<input type="hidden" id="hidden_branch">
	<form class="form account-details-form" action="" method="post">
		<div class="row" style="text-align:center;"><h3>The items added to cart will be removed.Please confirm</h3></div>
			<div class="row">
				<div class="form-group" style="margin-top:40px;text-align:center;">
					<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723;width:95px;" onclick="clearCart();">OK</button>
					<button type="button"  id="" class="submit_btn btn btn-dark btn-rounded btn-sm mb-4" style="background-color:#EF6723;border-color: #EF6723;width:95px;" onclick="$('.lpopup').hide();">CANCEL</button>
				</div>			
			</div>
	</form>
</div>

<script type="text/javascript">
    function ShowHideDiv() {
        var chkYes = document.getElementById("chkYes");
        var dvPassport = document.getElementById("detect");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
    }
</script>