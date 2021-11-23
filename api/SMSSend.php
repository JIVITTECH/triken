<?php
include_once '../database.php';

function getOtp($conn, $code, $mobile, $sender_id, $branch_id, $customer_id, $section, $orderId) {
    $n = 6;

    $generator = "1357902468";

// Iterate for n-times and pick a single character 
// FROM " . $_COOKIE['cookie_selectschema'] . ". generator and append it to $result 
// Login for generating a random character FROM " . $_COOKIE['cookie_selectschema'] . ". generator 
//     ---generate a random number 
//     ---take modulus of same with length of generator (say i) 
//     ---append the character at place (i) FROM " . $_COOKIE['cookie_selectschema'] . ". generator to result 

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

// Return result 
    $otp = $result;
    $content = "Your One Time Password is: $otp ";
    triggerSMSToCustomer($conn, $content, $mobile, $sender_id, $branch_id, $customer_id, $code, $section, $orderId, $otp);

    return $otp;
}

function triggerSMSToCustomer($conn, $content, $mobile, $sender_id, $branch_id, $customer_id, $code, $section, $orderId, $otp) {
//Your authentication key
    $authKey = "305993ADfnY0JTD6il6188c1d9P1";

//Multiple mobiles numbers separated by comma
//$mobileNumber = "9629170581";
    $mobileNumber = $mobile;

//Sender ID,While using route4 sender id should be 6 characters long.
//$senderId = "ECAPIN";
    $senderId = $sender_id;

//Your message to send, Add URL encoding here.
//$message = urlencode("Hi, Welcome to eCap");
    $message = $content;

//Define route 
    $route = "4";   // route = 1 for promotional & route = 4 for transactional
//Prepare you post parameters
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );

//API URL
    $url = "http://api.msg91.com/api/sendhttp.php?";

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
//,CURLOPT_FOLLOWLOCATION => true
    ));


//Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
    $response = curl_exec($ch);
    $err = curl_errno($ch);

    curl_close($ch);

//Print error if any
    if ($err) {
        echo 'error:' . curl_error($ch);
    } else {
error_log($response);
        logSMSDetails($conn, $branch_id, $customer_id, $sender_id, $code, $section, $mobile, $content, $response, $orderId, $otp);
    }
}

function logSMSDetails($conn, $branch_id, $customer_id, $sender_id, $code, $section, $mobile, $content, $response, $orderId, $otp) {
    global $current_zone_time;
    $sql1 = "DELETE FROM otp_validaton WHERE order_id = $orderId";
    $results1 = mysqli_query($conn, $sql1);

    $sql = "INSERT INTO otp_validaton(branch_id, order_id, otp) VALUES($branch_id,$orderId,'$otp')";
    $results = mysqli_query($conn, $sql);

    $sqlCount = "INSERT INTO kot_sms_log (order_id,branch_id,customer_id,mobile,sent_date,sender_id,type_code,sms_section,sms_content, sms_cost, del_status) "
            . "VALUES ($orderId,$branch_id,$customer_id,'$mobile','$current_zone_time','$sender_id','$code','$section','$content'," . getSmsCreditPoints($content) . ", '$response')";
    $result = mysqli_query($conn, $sqlCount);
}

function getSmsCreditPoints($content)
{
    $no_of_credits_utilized = 0;
    
    $no_of_chars = strlen($content);

    if ($no_of_chars <= 160) {
        $no_of_credits_utilized = 1;
    } else {
        $no_of_credits_utilized = ceil($no_of_chars / 153);
    }
    
    return  $no_of_credits_utilized;
}

?>
