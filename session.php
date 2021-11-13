<?php

$restaurant_id = "";
$customer_id = "";
$branch_id = "";
$contact_no = "";
$cart_id = "";
$cus_last_cart_id = "";
$category_load_flag = "";
$item_load_flag = "";
$cart_page_flag = "";
$delivery_charge = 0;
$redirect_id = "";

//master cookies -unset cookies handle in index.php file
if (isset($_COOKIE['cookie_res_name']) != NULL) {
    $restaurant_id = $_COOKIE['cookie_res_name'];
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id']) != NULL || isset($_SESSION['contact_no']) != NULL) {
    if (isset($_SESSION['user_id']) != NULL) {
        $customer_id = $_SESSION['user_id'];
    }

    if (isset($_SESSION['contact_no']) != NULL) {
        $contact_no = $_SESSION['contact_no'];
    }

    if (isset($_SESSION['branch_id']) != NULL) {
        $branch_id = $_SESSION['branch_id'];
    }

    if (isset($_SESSION['cart_id']) != NULL) {
        $cus_cart_id = $_SESSION['cart_id'];
    }
} else if (isset($_SESSION['user_id']) == NULL || isset($_SESSION['contact_no']) == NULL) {
    $_SESSION['user_id'] = '-1';
    if ($_SESSION['branch_id'] == "" || $_SESSION['branch_id'] == NULL) {
        $_SESSION['branch_id'] = '-1';
    }
    $_SESSION['contact_no'] = '-1';
    $_SESSION['cart_id'] = '-1';
    $customer_id = $_SESSION['user_id'];
    $contact_no = $_SESSION['contact_no'];
    $branch_id = $_SESSION['branch_id'];
    $cus_cart_id = $_SESSION['cart_id'];
}
