<?php

include "../database.php";

$cus_cart_id = $_GET['cart_id'];
$grand_sub_total = $_GET['grand_sub_total'];
$grand_total = $_GET['grand_total'];
$branch_id = $_GET['branch_id'];
$user_id = $_GET['user_id'];
$discount = $_GET['discount'];
$sub_total = $_GET['sub_total'];
$delivery_address = "";
$lat = "";
$long = "";
$rem_Amount = $grand_sub_total - $discount;
$del_address = "SELECT delivery_address,latitude,longitude   
                      FROM obo_customer_addresses
                      WHERE customer_id = '$user_id' AND current_address = 'Y'";

$res_del = mysqli_query($conn, $del_address);
$count = mysqli_num_rows($res_del);
if ($count !== 0) {
    while ($qry1 = mysqli_fetch_array($res_del)) {
        $delivery_address = $qry1['delivery_address'];
        $lat = $qry1['latitude'];
        $long = $qry1['longitude'];
    }
} else {
    $cus_address = "SELECT address  ,latitude,longitude    
                      FROM kot_customer_details
                      WHERE id = '$user_id'";
//echo $cus_address;
    $cus_res = mysqli_query($conn, $cus_address);
    $count_res = mysqli_num_rows($cus_res);
    if ($cus_res !== 0) {
        while ($qry2 = mysqli_fetch_array($cus_res)) {
            $delivery_address = $qry2['address'];
            $lat = $qry2['latitude'];
            $long = $qry2['longitude'];
        }
    }
}

$sql = "update obo_cart_details set sub_total ='$sub_total',total_price = $grand_total,del_long='$long',del_lat='$lat',delivery_address = '$delivery_address' where cart_id = $cus_cart_id";
$result = mysqli_query($conn, $sql);

$dis = "update obo_cart_coupon set amount = '$rem_Amount', discount_cost = '$discount'  where cart_id = $cus_cart_id";
$dis_res = mysqli_query($conn, $dis);


?>

