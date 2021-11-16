<div class="login-popup" id="login_dialog">
        <h1> Sign In / Sign Up </h1>
        <p> To order your item </p>
            <div id="sign-in">
                <!--<form action="" method="post">-->
                    <div class="form-group">
                        <input type="tel" maxlength="10" class="form-control" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" onkeyup ="ValidateNumber()" Placeholder="Enter Mobile Number" required>
                        <p class="text-left">An OTP will be sent on this mobile number</p>
                    </div>
                   <!---->
                    <button  id="send_otp" class="btn btn-primary disabled" style="pointer-events:none" onclick="loginValid();"> <span> Send OTP </span> </button>
                 <!--</form>-->
            </div>
</div>

  
