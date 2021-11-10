<div class="login-popup otp" id="otp_dialog">
    <h1> Enter OTP </h1>
    <p> Please enter the OTP sent and it will expire in 60 seconds </p>
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


