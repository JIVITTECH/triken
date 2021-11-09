<?php

//Bypass the Sign Up Verfication process
//Set 1 for Developmer Mode & Set 0 for Normal Mode
//$dev_mode = 1;

/* User Registraion */
include("../config/database.php");
include("./SMSSend.php");

if ($_GET["action"] == "register") {
    OTPSend($conn); //function to update status
} else if ($_GET["action"] == "verification") {
    verification($conn);
}

function OTPSend($conn) {
//    global $dev_mode;
    global  $current_zone_time;
    $events1 = array();
    $events = array();

    $user_name = $_GET['user_name'];
    $user_mobile = $_GET['user_mobile'];
    $user_email = $_GET['user_email'];
    $location = $_GET['location'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $address = $_GET['address'];

    $sender_id = "";
    $branch_id = "";
    $customer_id = "";

    $section = "";
    $orderId = "";
    //Verify the user already exists or not
    $sql_master = "SELECT count(*) AS count FROM kot_customer_details WHERE contact_no='$user_mobile'";
    $qry_result_master = mysqli_query($conn, $sql_master);
    while ($rows = mysqli_fetch_array($qry_result_master)) {
        $events = array("count" => "$rows[count]");
    }
    $rows = $events["count"];
    if ($rows === "0") {
//        if ($dev_mode == 0) {
//            $otp = getOtp($conn, "", $user_mobile, $sender_id, $branch_id, $customer_id, $section, $orderId);
//        } else {
        $otp = "123456";
//        }
        $branch_sql = "SELECT branch_id, name, count(1) as count1
                     FROM kot_branch_details
                     LIMIT 1";
        $branch_result = mysqli_query($conn, $branch_sql);
        WHILE ($rows1 = mysqli_fetch_array($branch_result)) {
            $events1 = ARRAY("branch_id" => "$rows1[branch_id]",
                "count1" => "$rows1[count1]");
        }
        $branch_id = $events1["branch_id"];
        $location = mysqli_real_escape_string($conn, $location);
        $address = mysqli_real_escape_string($conn, $address);
        $sql1 = "INSERT INTO kot_customer_details (customer_name, contact_no, email_addr, geo_location, branchId, latitude, longitude, address) VALUES 
                                         ('$user_name', '$user_mobile', '$user_email', '$location', '$branch_id', '$latitude', '$longitude', '$address')";
        $qry_result1 = mysqli_query($conn, $sql1);
        $user_id = mysqli_insert_id($conn);
        
        $query = "INSERT INTO obo_customer_addresses (customer_id, delivery_address, current_address, latitude, longitude)" .
                 " VALUES (" . $user_id . "," . "'" . $address . 
                 "'" . "," . "'" . "Y" . "'" . "," . "'" . $latitude . "'" . "," . "'" . $longitude . "'" .");";  

         mysqli_query($conn, $query);

        if ($qry_result1) {
            $sql2 = "INSERT INTO kot_otp_validation (user_id, otp, status, datetime) VALUES 
                                                ('$user_id', '$otp', '1', '$current_zone_time')";
            mysqli_query($conn, $sql2);

            echo "success";
        } else {
            echo "failed";
        }
    } else {
        echo "mob";
    }
}

function verification($conn) {
    $otp = $_GET['otp'];
    $sql4 = "UPDATE kot_otp_validation kov
             SET status = '1'
             WHERE kov.otp = '$otp'";
    $query_rst = mysqli_query($conn, $sql4);
    if ($query_rst) {
        echo 'yes';
    } else {
        echo 'no';
    }
}

function optExpired($user_id, $otp, $conn) {
    global $current_zone_time;
    $sql3 = "UPDATE kot_otp_validation kov
         SET otp = ''
         WHERE kov.datetime < '$current_zone_time' + interval 60 second)";
    mysqli_query($conn, $sql3);
}

?>