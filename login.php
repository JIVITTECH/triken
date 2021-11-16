<div class="login-popup" id="login_dialog">
    <div id="login_popup">
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
	<div id="otp_popup" style="display:none;">
		<h1> Enter OTP </h1>
		<p> Please enter the OTP sent and it will expire in  <span class="timer"  id ="timer">60</span> seconds </p>
		<div id="sign-in">
			<!--<form action="" method="post">-->
				<div class="form-group">
					<input type="text" class="form-control" id="otp" name="otp"   maxlength="4">
					<p class="text-left"><span class="resend"> <a onclick="resendOTP()"> Click here </a> </span> to generate new OTP.</p>
				</div>
				<button class="btn btn-primary" onclick="verifyOTP()"> <span> Confirm </span> </button>
			<!--</form>-->
		</div>
	</div>
</div>



  
