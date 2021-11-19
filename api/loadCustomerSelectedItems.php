<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$cart_id = $_GET['cart_id'];
$branch_id = $_GET['branch'];
$order_type = $sel_obo_order_type;
	
$user_id = 0;
$latitude = 0;
$longitude = 0;
$cus_lat = 0;
$cus_long = 0;
$delivery_address = "";
$cus_name = "";
$cus_no = "";
$brc_name = "";

$sql_brnch = "select * from obo_cart_details  where cart_id  = $cart_id";
$res_brnch = mysqli_query($conn, $sql_brnch);
while ($rows_usr = mysqli_fetch_array($res_brnch)) {
    $user_id = $rows_usr['customer_id'];
}

$cus_name_details = "SELECT *    
                      FROM kot_customer_details
                      WHERE id = '$user_id'";
$cus_details = mysqli_query($conn, $cus_name_details);
$count_details = mysqli_num_rows($cus_details);
while ($qry3 = mysqli_fetch_array($cus_details)) {
    $cus_name = $qry3['customer_name'];
    $cus_no = $qry3['contact_no'];
}

$branch_add = "SELECT * from kot_branch_details where branch_id = $branch_id ";
$bran_res = mysqli_query($conn, $branch_add);
$count_branch = mysqli_num_rows($bran_res);
if ($count_branch !== 0) {
    while ($qry3 = mysqli_fetch_array($bran_res)) {
        $latitude = $qry3['latitude'];
        $longitude = $qry3['longitude'];
        $brc_name = $qry3['name'];
    }
}

/* $del_address = "SELECT delivery_address,latitude,longitude   
                      FROM obo_customer_addresses
                      WHERE customer_id = '$user_id' AND current_address = 'Y'";

$res_del = mysqli_query($conn, $del_address);
$count = mysqli_num_rows($res_del);
if ($count !== 0) {
    while ($qry1 = mysqli_fetch_array($res_del)) {
        $delivery_address = $qry1['delivery_address'];
        $cus_lat = $qry1['latitude'];
        $cus_long = $qry1['longitude'];
    }
} else {
    $cus_address = "SELECT address  ,latitude,longitude    
                      FROM kot_customer_details
                      WHERE id = '$user_id'";
    $cus_res = mysqli_query($conn, $cus_address);
    $count_res = mysqli_num_rows($cus_res);
    if ($cus_res !== 0) {
        while ($qry2 = mysqli_fetch_array($cus_res)) {
            $delivery_address = $qry2['address'];
            $cus_lat = $qry2['latitude'];
            $cus_long = $qry2['longitude'];
        }
    }
}*/

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$delivery_address = $_COOKIE['locName'];
$cus_lat = $_SESSION['user_loc_latitude'];
$cus_long = $_SESSION['user_loc_longitude'];
$delivery_address = convert_br_to_newline($delivery_address);

$distance = 0;


if ($cus_lat === null || $cus_lat === "") {
    $cus_lat = 0;
}
if ($cus_long === null || $cus_long === "") {
    $cus_long = 0;
}

$sql_dis = "SELECT db.* FROM (SELECT branch_id,name,description,
           (
                (
                    (
                        acos(
                            sin(( $cus_lat * pi() / 180))
                            *
                            sin(( `latitude` * pi() / 180)) + cos(( $cus_lat * pi() /180 ))
                            *
                            cos(( `latitude` * pi() / 180)) * cos((( $cus_long - `longitude`) * pi()/180)))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            )
           as distance FROM kot_branch_details ORDER BY branch_id ASC )db WHERE branch_id = $branch_id";

$result_dis = mysqli_query($conn, $sql_dis);
$count_distance = mysqli_num_rows($result_dis);
if ($count_distance !== 0) {
    while ($rows_dis = mysqli_fetch_array($result_dis)) {
        $distance = round($rows_dis['distance']);
    }
}

$radius = 0;

$qry = "select * from obo_store_settings where branch = " . $branch_id;
$results = mysqli_query($conn, $qry);
while ($rows_rad = mysqli_fetch_array($results)) {
    $radius = round($rows_rad['distance_coverage']);
}

if ($distance <= $radius) {
    $sql = "SELECT db.* ,
       (SELECT COUNT(*) FROM  kot_item_stock_details isd
        WHERE isd.branch_id = $branch_id AND isd.predef_menu_id = db.menu_id)as stock_chk,
       (SELECT if(sum(sm.price)is null,0,sum(sm.price)) FROM sub_modifiers sm
       LEFT JOIN obo_cart_item_modifiers  ocm
       ON ocm.mod_sub_id = sm.mod_sub_id 
       LEFT JOIN predefined_menu pm
       ON pm.ID = sm.predef_menu_id and pm.branch = $branch_id
       LEFT JOIN modifiers md
       ON (md.id = sm.modifier_id AND md.branch_id = pm.branch)
       WHERE ocm.cart_id = $cart_id AND sm.predef_menu_id = db.predef_menu_id AND cart_item_id = db.cart_item_id ) as mod_price,
       (SELECT CONCAT('(',GROUP_CONCAT(sm.name),')') FROM sub_modifiers sm
       LEFT JOIN obo_cart_item_modifiers  ocm
       ON ocm.mod_sub_id = sm.mod_sub_id 
       LEFT JOIN obo_cart_item_details ocid 
       ON ocid.cart_id = ocm.cart_id AND  ocid.cart_item_id = ocm.cart_item_id
       LEFT JOIN modifiers md
       ON (md.id = sm.modifier_id AND md.branch_id =$branch_id)
       WHERE ocm.cart_id = $cart_id AND sm.predef_menu_id = db.menu_id and ocid.cart_item_id =db.cart_item_id) AS selectedMods
       FROM
      (SELECT pm.name,ocid.quantity,pm.price,
       ocid.cart_item_id as cart_item_id,
       ocid.cat_id as category_id,
       ocid.price as tot_price,
       ocid.predef_menu_id,
       ocid.replace_name,
       pm.predef_menu_id as menu_id,
       pm.image,
       pm.tax,
      (ocid.price /ocid.quantity) AS per_unit_price,
       ocid.packing_charge,
       pma.net_weight,
       pma.gross_weight,
       pma.delivery_time,
       pm.measure,
       pm.disc_per
       FROM 
       obo_cart_details ocd
       LEFT JOIN obo_cart_item_details ocid
       ON ocd.cart_id = ocid.cart_id AND ocid.branch_id = $branch_id
       LEFT JOIN predefined_menu pm
       ON pm.predef_menu_id = ocid.predef_menu_id AND pm.branch = $branch_id
       LEFT JOIN predefined_menu_additional pma
       ON pma.mapped_id = pm.id AND pma.BRANCH_ID = pm.branch
       LEFT JOIN kot_menu_zone kmz
       ON kmz.branch_id = pm.branch and kmz.item_id = pm.PREDEF_MENU_ID and kmz.zone = '$order_type'
       where ocd.cart_id = $cart_id and pm.branch = $branch_id and ocid.quantity <> 0 
       group by ocid.cart_item_id)db";
//echo $sql;
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    $res = "";

    while ($rows = mysqli_fetch_array($result)) {

        $events = array(
            "name" => "$rows[name]",
            "id" => "$rows[predef_menu_id]",
            "price" => "$rows[price]",
            "tot_price" => "$rows[tot_price]",
            "quantity" => "$rows[quantity]",
            "selectedMods" => "$rows[selectedMods]",
            "mod_price" => "$rows[mod_price]",
            "image" => "$rows[image]",
            "menu_id" => "$rows[menu_id]",
            "per_unit_price" => "$rows[per_unit_price]",
            "cart_item_id" => "$rows[cart_item_id]",
            "tax" => "$rows[tax]",
            "category_id" => "$rows[category_id]",
            "stock_chk" => "$rows[stock_chk]",
            "replace_name" => "$rows[replace_name]",
            "packing_charge" => "$rows[packing_charge]",
            "delivery_time" => "$rows[delivery_time]",
            "gross_weight" => "$rows[gross_weight]",
            "net_weight" => "$rows[net_weight]",
	    "measure" => "$rows[measure]",
            "disc_per" => "$rows[disc_per]"
        );
        $output[] = $events;

        $res = json_encode($output);
    }
} else {
    $msg_cnt = "SELECT * FROM obo_outer_radius_access_details WHERE cart_id = $cart_id";
    $result_cnt = mysqli_query($conn, $msg_cnt);
    $msg_row_cnt = mysqli_num_rows($result_cnt);

    if ($msg_row_cnt == 0) {
        $sql = "INSERT INTO obo_outer_radius_access_details(customer_id,cart_id,accessed_branch,latitude,longitude,customer_address,date)
            VALUES($user_id,$cart_id,$branch_id,'$cus_lat','$cus_long','$delivery_address','$current_zone_time')";
        $result = mysqli_query($conn, $sql);

        $sel = "select ksc.*,
           (SELECT sender_id FROM kot_sms_sender_id WHERE branch_id = $branch_id) AS sender_id
           from kot_sms_config ksc where branch_id = $branch_id and sms_type_code = 'SMSOBO'";

        $res_sel = mysqli_query($conn, $sel);
        $row_cnt = mysqli_num_rows($res_sel);
        if ($row_cnt > 0) {
            if ($rows_num = mysqli_fetch_array($res_sel)) {
                $mobile_number = $rows_num['mobile_number'];
                $sender_id = $rows_num['sender_id'];
                $code = 'SMSOBO';
                $section = 'OBOAPP';
                $orderId = $cart_id;

                $content = "$cus_name($cus_no) from $delivery_address had tried to order food from the restaurant $brc_name , it was not  delivered as it is outside the radius location of the branch";
                //echo $content;
                triggerSMSToCustomer($conn, $content, $mobile_number, $sender_id, $branch_id, $user_id, $code, $section, $orderId);
            }
        }
    }
    $output[] = -1;

    $res = json_encode($output);
}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

function triggerSMSToCustomer($conn, $content, $mobile, $sender_id, $branch_id, $customer_id, $code, $section, $orderId) {
//Your authentication key
    $authKey = "305993AwQ7NF7vgF6S5ddf648d";

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
        //echo 'error:' . curl_error($ch);
    } else {
        logSMSDetails($conn, $branch_id, $customer_id, $sender_id, $code, $section, $mobile, $content, $response, $orderId);
    }
}

function logSMSDetails($conn, $branch_id, $customer_id, $sender_id, $code, $section, $mobile, $content, $response, $orderId) {
    global $current_zone_time;

    $sqlCount = "INSERT INTO kot_sms_log (order_id,branch_id,customer_id,mobile,sent_date,sender_id,type_code,sms_section,sms_content, sms_cost, del_status) "
            . "VALUES ($orderId,$branch_id,$customer_id,'$mobile','$current_zone_time','$sender_id','$code','$section','$content'," . getSmsCreditPoints($content) . ", '$response')";
    $result = mysqli_query($conn, $sqlCount);
}

function getSmsCreditPoints($content) {
    $no_of_credits_utilized = 0;

    $no_of_chars = strlen($content);

    if ($no_of_chars <= 160) {
        $no_of_credits_utilized = 1;
    } else {
        $no_of_credits_utilized = ceil($no_of_chars / 153);
    }

    return $no_of_credits_utilized;
}

function convert_br_to_newline($text) {
    $text = str_ireplace(array("<br>", "<br />", "<br/>"), "\n", $text);
    return $text;
}
?>

