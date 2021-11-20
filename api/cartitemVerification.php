<?php

include "../database.php";

$cart_id = $_GET['cart_id'];

$sql = "SELECT *  FROM 
obo_cart_item_details 
WHERE cart_id = $cart_id
  AND quantity > 0";
//echo $sql;
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

echo $count;
?>
