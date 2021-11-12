<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$dev_mode = 0;

if ($_GET["action"] == "sign_in") {
	
	$loginNumber = $_GET['loginNumber'];
	
	$events = [];
	
	$sql = "SELECT id as cus_id FROM kot_customer_details WHERE contact_no= '$loginNumber'";
    $qry_result = mysqli_query($conn, $sql);
    
	while ($rows = mysqli_fetch_array($qry_result)) {
        $events = array("cus_id" => "$rows[cus_id]");
    }
	
	$customer_id = $events["cus_id"];

    if ($customer_id !== null) {
		
        if ($dev_mode == 0) {
            $otp = getOtp($conn, $code, $loginNumber, $sender_id, $branch_id, $customer_id, $section, $orderId);
        } else {
            $otp = "123456";
        }
		
        $sql2 = "INSERT INTO kot_otp_log_validation (user_id, otp, status, datetime) VALUES 
                                                    ('$customer_id', '$otp', '0', '$current_zone_time')";
        mysqli_query($conn, $sql2);
       
	    echo "OTP Send";
		
    } else {
        echo "Mobile Number Does Not Exist";
    }
}

if ($_GET["action"] == "get_cart_id") {
	
	$sql1 = "SELECT kcd.id as user_id,
				kcd.customer_name,
				kcd.branchId as branch_id,
				kcd.contact_no,
			    kcd.email_addr
                FROM kot_customer_details kcd
                WHERE  kcd.contact_no='$mobile'";
				
	$res_sql = mysqli_query($conn, $sql1);
	$rowscount_res_sql = mysqli_num_rows($res_sql);        

	if ($rowscount_res_sql > 0) {
		if ($rows = mysqli_fetch_array($res_sql)) {
			$_SESSION['customer_id'] = $rows['user_id'];
			$_SESSION['customer_branch_id'] = $rows['branch_id'];
			$_SESSION['customer_contact_no'] = $rows['contact_no'];
			$_SESSION['customer_name'] = $rows['customer_name'];
			$_SESSION['customer_addr'] = $rows['email_addr'];
			
			getUserCartDetails($conn, $_SESSION['customer_id']);
		}
	}
}

function getUserCartDetails($conn, $userid) {
    $cus_cart_id = 0;
    $sql_cart_id = "SELECT * FROM obo_cart_details "
            . "WHERE customer_id = $userid "
            . "AND order_placed= 'N' ORDER BY cart_id DESC LIMIT 1";
    $res_cart_id = mysqli_query($conn, $sql_cart_id);

    $cart_count = mysqli_num_rows($res_cart_id);

    if ($cart_count > 0) {
        if ($rows_cart_id = mysqli_fetch_array($res_cart_id)) {
            $cus_cart_id = $rows_cart_id['cart_id'];
        }
    } else {
        $sqlfs = "INSERT into obo_cart_details(customer_id) VALUES($userid)";
        $result = mysqli_query($conn, $sqlfs);
        $cart_id = mysqli_insert_id($conn);
        $cus_cart_id = $cart_id;
    }
    $_SESSION['obo_cart_id'] = $cus_cart_id;
}

?>

