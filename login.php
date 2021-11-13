
<div class="modal3" id="login_dialog" style="display:none;">
    <div class="form2 search_filter modal3-content animate">
        <h1> Sign In / Sign Up </h1>
        <p> To order your item </p>
            <div id="sign-in">
                <!--<form action="" method="post">-->
                    <div class="form-group">
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" Placeholder="Enter Mobile Number" required>
                        <p class="text-left">An OTP will be sent on this mobile number</p>
                    </div>
                   <!---->
                    <button class="btn btn-primary" onclick="loginValid();"> <span> Send OTP </span> </button>
                 <!--</form>-->
            </div>
    </div>    
</div>
  
<!--  
 Start Modal Section
<div id="idConfigDialog_otp" class="modal3" style="display:none;">

    <div class="form2 search_filter modal3-content animate">
        <h2 style="color:#000000">OTP Verification</h2>          
        <br>
            <input type="text" hidden name="user_id" id="user_id" placeholder="" autocomplete="off" />
        <input type="tel" name="otp" id="otp" placeholder="OTP" maxlength="6" autocomplete="off" onkeypress="return isNumber(event)" style="font-size: 16px !important"/>
        <center>
            <button id = "otpid" style="color: white;border-radius: 10px; border: 0px solid white;;" onclick="verifiedOTP()">VERIFY</button>
        </center>
    </div>
</div>
 End Modal Section-->
