<?php

ob_start();

$config_url = "http://localhost/triken/";
//$config_url = "https://www.ecater.in/app/triken/";//live

$config_url_pos = "http://localhost/ecaterweb/Catering/POS/";
//$config_url_pos = "https://www.ecater.in/app/Catering/POS-develop/";//live

$easebuzz_pay_callback_url = "http://localhost/"; // test
//$razor_pay_callback_url = "https://www.ecater.in/app/"; // live

function paymentMethod($val) {
    switch ($val) {
        case 1: return 'Razor Pay';
        default: return 'Razor Pay';
    }
}


ob_end_flush();
