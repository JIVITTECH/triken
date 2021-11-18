<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

if ($_GET["action"] == "save_new_delivery_address") {

   $deliveryAddress = "";

   $flatNo = mysqli_real_escape_string($conn,$_GET['addr_flat_no_build_name']);
   $street = mysqli_real_escape_string($conn,$_GET['addr_street_area']);
   $area = mysqli_real_escape_string($conn,$_GET['addr_area']);
   $city = mysqli_real_escape_string($conn,$_GET['addr_city']);
   $pincode = mysqli_real_escape_string($conn,$_GET['addr_pincode']);
   $landmark = mysqli_real_escape_string($conn,$_GET['addr_landmark']);

   if (strlen(trim($flatNo)) != '0') {
     $deliveryAddress = trim($flatNo);
   }

   if (strlen(trim($street)) != '0') {
     
      if (strlen(trim($deliveryAddress)) != '0') { 
         $deliveryAddress .= ", " . trim($street);
      }  else {
         $deliveryAddress = trim($street);
      }

   }

   if (strlen(trim($area)) != '0') {

      if (strlen(trim($deliveryAddress)) != '0') { 
         $deliveryAddress .= ",<br>" . trim($area);
      }  else {
         $deliveryAddress = trim($area);
      }

   }

   if (strlen(trim($city)) != '0') {

      if (strlen(trim($deliveryAddress)) != '0') { 
         $deliveryAddress .= ",<br>" . trim($city);
      }  else {
         $deliveryAddress = trim($city);
      }

   }

   if (strlen(trim($pincode)) != '0') {

      if (strlen(trim($deliveryAddress)) != '0') { 
         $deliveryAddress .= " - " . trim($pincode);
      }  else {
         $deliveryAddress = trim($pincode);
      }

   }

   if (strlen(trim($landmark)) != '0') {

      if (strlen(trim($deliveryAddress)) != '0') { 
         $deliveryAddress .= ",<br>" . trim($landmark);
      }  else {
         $deliveryAddress = trim($landmark);
      }

   }

   $query = "INSERT INTO obo_customer_addresses (customer_id, delivery_address, current_address,flatNo,street,area,city,pincode,landmark)" .
            " VALUES (" . "'$user_id'" . "," . "'" . $deliveryAddress . "'" . "," . "'Y'" .",'$flatNo','$street','$area','$city','$pincode','$landmark')";  

   if ($conn->query($query) === TRUE) {
      echo "200";
   } else {
      echo "Error Creating record: " . $conn->error;
   }  
}

if ($_GET["action"] == "update_current_delivery_address") {
   
   $delAddressID = $_GET['del_address_id'];

   $query = "UPDATE obo_customer_addresses SET current_address ='Y' " .
            "WHERE customer_id = " . "'" . $user_id . "'" . 
              "AND delivery_add_id = " . $delAddressID . ";";

   if ($conn->query($query) === TRUE) {
      echo "200";
   } else {
      echo "Error Creating record: " . $conn->error;
   }  
}

if ($_GET["action"] == "remove_delivery_address") {
   
   $delAddressID = $_GET['del_address_id'];

   $query = "DELETE FROM obo_customer_addresses " .
            "WHERE customer_id = " . "'" . $user_id . "'" . 
              "AND delivery_add_id = " . $delAddressID . ";";

   if ($conn->query($query) === TRUE) {
      echo "200";
   } else {
      echo "Error Deleting record: " . $conn->error;
   }  
}

?>