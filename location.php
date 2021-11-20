<!-- <div class="content">
            <h2>Select your city</h2>

            <div class="city">
                <ul>
                    <li> <div class="location"> <a href="#" class="btn btn-dark active"> Coimbatore </a> </div> </li>
                    <li> <div class="location"> <a href="#" class="btn btn-dark"> Chennai </a> <span class="soon"> Coming Soon! </span> </div> </li>
                    <li> <div class="location"> <a href="#" class="btn btn-dark"> Tiruppur </a> <span class="soon"> Coming Soon! </span> </div> </li>
                </ul>
            </div>
             
            <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                <input type="text" class="form-control" name="text" id="text"
                    placeholder="Enter your area" required="">
                <button class="btn btn-dark" type="submit"> <img src="assets/images/detect.svg"> Detect my location</button>
            </form>
            <p> Expansion of our delivery service into a wider
geography is underway.</p>
           <div class="form-checkbox d-flex align-items-center">
                <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup" name="hide-newsletter-popup"
                    required="">
                <label for="hide-newsletter-popup" class="font-size-sm text-light">Don't show this popup again.</label>
            </div> 
        </div> -->
        
 <div class="content">
    <a href='' class='close'>Close</a>       
    <h2>Select your city</h2>
    <form class="findlocation" id='cities'>
    </form>    
<!--        <div>
            <label for="chkYes" class="location">
                <input type="radio" id="chkYes" class="loc" name="chkPassPort" onclick="ShowHideDiv()" />
                Coimbatore
            </label> <br>
              <span class="soon hide"> Coming Soon! </span> 
        </div>
        <div class="csoon">
            <label for="chkNo" class="no location">
                <input type="radio" id="chkNo" class="loc" name="chkPassPort" onclick="ShowHideDiv()" />
                Chennai
            </label> <br> 
            <span class="soon"> Coming Soon! </span>
        </div>
        <div> 
            <label for="chkNo" class="no location">
                <input type="radio" id="chkYes" class="loc" name="chkPassPort" onclick="ShowHideDiv()" />
                Tiruppur
            </label> <br>
            <span class="soon"> Coming Soon! </span>

        </div>-->

            <div id="detect" style="display: none">
			    <h4 id="no_branch" style="display:none;color:red;">Sorry we currently don’t offer delivery to your location please select a different location</h4>
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

<script type="text/javascript">
    function ShowHideDiv() {
        var chkYes = document.getElementById("chkYes");
        var dvPassport = document.getElementById("detect");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
    }
</script>