<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['user_id']);
unset($_SESSION['branch_id']);
unset($_SESSION['contact_no']);
unset($_SESSION['cart_id']);
/*unset($_SESSION['user_loc_longitude']);
unset($_SESSION['user_loc_latitude']);*/

if (isset($_COOKIE['item_list'])) {
    unset($_COOKIE['item_list']);
    setcookie('item_list', '', time()+(3600*24*30), '/'); // empty value and old timestamp
}

if (isset($_COOKIE['user_id'])) {
    setcookie("user_id", "", time()+(3600*24*30));
}
if (isset($_COOKIE['mobile_no'])) {
    setcookie("mobile_no", "", time()+(3600*24*30));
}
/*if (isset($_COOKIE['branch_id'])) {
    setcookie("branch_id", "-1", time()+(3600*24*30));
}*/
if (isset($_COOKIE['cart_id'])) {
    setcookie("cart_id", "", time()+(3600*24*30));
}
/*if (isset($_COOKIE['locName'])) {
    setcookie("locName", "", time()+(3600*24*30));
}*/
header("location:index.php");
?>