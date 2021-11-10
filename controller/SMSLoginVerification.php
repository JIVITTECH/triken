<?php

//Bypass the Login Verfication process
//Set 1 for Developmer Mode & Set 0 for Normal Mode

$dev_mode = 1;

/* Login Verification */
include("../database.php");
include("./SMSSend.php");

if ($_GET["action"] == "loginValid1") {
    loginVerifyOTP1($conn);
} else if ($_GET["action"] == "loginValid2") {
    loginVerifyOTP2($conn);
}

function loginVerifyOTP1($conn) {
    global $dev_mode;
    global $current_zone_time;
    $loginNumber = $_GET['loginNumber'];
    $sender_id = "ECAPIN";
    $branch_id = "";
    $customer_id = "";
    $section = 'OBO';
    $code = "OBOOTP";
    $orderId = 0;
    $rows = [];
    $events = [];
    //Verify the user already exists or not
    $sql1 = "SELECT id as cus_id FROM kot_customer_details WHERE contact_no='$loginNumber'";
    $qry_result1 = mysqli_query($conn, $sql1);
    while ($rows = mysqli_fetch_array($qry_result1)) {
        $events = array("cus_id" => "$rows[cus_id]");
    }
    $customer_id = $events["cus_id"];

    $getBranchid = "SELECT branchId FROM kot_customer_details WHERE contact_no='$loginNumber'";
    $resBranch = mysqli_query($conn, $getBranchid);
    while ($rows_qry = mysqli_fetch_array($resBranch)) {
        $branch_id = $rows_qry['branchId'];
    }

    if ($customer_id !== null) {
        if ($dev_mode == 0) {
            $otp = getOtp($conn, $code, $loginNumber, $sender_id, $branch_id, $customer_id, $section, $orderId);
        } else {
            $otp = "123456";
        }
        //kot_otp_log_validation
        $sql2 = "INSERT INTO kot_otp_log_validation (user_id, otp, status, datetime) VALUES 
                                                    ('$customer_id', '$otp', '0', '$current_zone_time')";
        mysqli_query($conn, $sql2);
        error_log($sql2);
        loginVerifyOTP2($conn , $loginNumber);
        mysqli_close($conn);
        echo "success";
    } else {
        echo "failed";
    }
}

function loginVerifyOTP2($conn, $loginNumber) {
    global $dev_mode;
    global $current_zone_time;
//    $otpcharr = $_GET['otpchar'];
//    $mobile = $_GET['mobile'];
    $otpcharr = '123456';
    $mobile = $loginNumber;
    $success = 0;

    $res = "";
    $events = array();


    if ($dev_mode == 0) {
        $sqlexp = "SELECT * FROM kot_otp_log_validation 
                   WHERE otp='$otpcharr'
                   AND status!=1
                   AND '$current_zone_time' <= DATE_ADD(datetime, INTERVAL 60 second)";
    } else {
        $sqlexp = "SELECT * FROM kot_otp_log_validation 
                   WHERE otp='$otpcharr'
                   AND status!=1";
    }

    $result = mysqli_query($conn, $sqlexp);
    $count = mysqli_num_rows($result);
    if (!empty($count)) {
        mysqli_query($conn, "UPDATE kot_otp_log_validation SET status = 1 WHERE otp = '$otpcharr'");
        $success = 2;
    } else {
        $success = 1;
    }
    if ($success == 2) {
        $sql1 = "SELECT kcd.id as user_id,
			kcd.customer_name,
                        kcd.branchId as branch_id,
                        kcd.contact_no,
			kcd.email_addr
                FROM kot_customer_details kcd
                LEFT JOIN kot_otp_log_validation kolv
                       ON kolv.user_id = kcd.id 
                WHERE kolv.otp = '$otpcharr' AND kcd.contact_no='$mobile' AND '$current_zone_time' <= DATE_ADD(kolv.datetime, INTERVAL 60 second)";
        $res_sql = mysqli_query($conn, $sql1);
        $rowscount_res_sql = mysqli_num_rows($res_sql);        

        if ($rowscount_res_sql > 0) {
            if ($rows = mysqli_fetch_array($res_sql)) {
//              Login process session value sets
                $_SESSION['user_id'] = $rows['user_id'];
                $_SESSION['branch_id'] = $rows['branch_id'];
                $_SESSION['contact_no'] = $rows['contact_no'];
                $_SESSION['user_name'] = $rows['customer_name'];
                $_SESSION['email_addr'] = $rows['email_addr'];
                
//              Login success Response returns to index.php file loginValid()
                $events = array(
                    "status" => "OTPSuccess",
                    "user_id" => $_SESSION['user_id'],
                    "branch_id" => $_SESSION['branch_id'],
                    "email_id" => $_SESSION['email_addr'],
                    "mobile_no" => $_SESSION['contact_no'],
                    "user_name" => $_SESSION['user_name']
                );

                $output[] = $events;

                $res = json_encode($output);
                echo $res;
            }
        }
    } else if ($success == 1) {
        $events = array(
            "status" => "OTPExpired"
        );

        $output[] = $events;

        $res = json_encode($output);
        if ($res == "") {
            $res = json_encode([]);
        }
        echo $res;
    }
}

?>