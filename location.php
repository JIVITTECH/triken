
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
    <h2>Select your city</h2>
    <form class="findlocation">
        <div>
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
        </div>
        </form>
            <div id="detect" style="display: none">
                <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                    <input type="text" class="form-control" name="text" id="text"
                        placeholder="Enter your area" required="">
                    <button class="btn btn-dark" type="submit"> <img src="assets/images/detect.svg"> Detect my location</button>
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