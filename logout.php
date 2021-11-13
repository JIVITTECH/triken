<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['user_id']);
unset($_SESSION['branch_id']);
unset($_SESSION['contact_no']);
unset($_SESSION['cart_id']);
unset($_SESSION['user_loc_longitude']);
unset($_SESSION['user_loc_latitude']);

if (isset($_COOKIE['item_list'])) {
    unset($_COOKIE['item_list']);
    setcookie('item_list', '', time() - 3600, '/'); // empty value and old timestamp
}
?>