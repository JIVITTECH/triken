<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include "../database.php";

$cartId = $_GET['cart_id'];
$offerSTR = $_GET['offertxt'];
$grandTotal = $_GET['grand_total'];
$branch_id = $_GET['branch_id'];
$discount_amount = "";
$row = null;
$sql_offer = "select 
                        *
                         from 
                         discount_types
                         where LOWER(discount_name) = LOWER('" . $offerSTR . "')
                         AND EXPIRY_DATE >= CURDATE() AND branchId = $branch_id AND
                         discount_coupon_amount <=" . $grandTotal;
//echo $sql_offer;
$result_offer = mysqli_query($conn, $sql_offer);
$count = mysqli_num_rows($result_offer);
while ($rows = mysqli_fetch_array($result_offer)) {
    $disc_type = $rows['discount_type'];
    $discount_amt = $rows['discount_amount'];
    $dis_per = $rows['discount_per'];
    $discount_id = $rows['id'];
    $discount_name = $rows['discount_name'];
}
if ($count > 0) {

    if ($disc_type == 1) {
        $discount_amount = $discount_amt;
    } elseif ($disc_type == 2) {
        $discount_amount = ($dis_per / 100) * $grandTotal;
    }
    $rem_amount = $grandTotal - $discount_amount;

    $del = "select * from obo_cart_coupon where cart_id = $cartId";
    $result_del = mysqli_query($conn, $del);
    $count_res = mysqli_num_rows($result_del);
    if ($count_res === 0) {
        $ins_dis = "INSERT INTO obo_cart_coupon(cart_id, type, discount_cost, discount_name, discount_id) VALUES($cartId, $disc_type, '$discount_amount', '$discount_name', '$discount_id')";
        $result = mysqli_query($conn, $ins_dis);
        echo $discount_amount;

        $dis = "update obo_cart_coupon set amount = '$rem_amount'  where cart_id = $cartId";
        $dis_res = mysqli_query($conn, $dis);
    } else {
        echo "-2";
    }
} else {
    echo "-1";
}
?>
