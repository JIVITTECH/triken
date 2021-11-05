<?php

include("../database.php");

if ($_GET["action"] == "add_item_to_cart") {
	
	$item_id = $_GET['menu_id'];
	$branch = $_GET['branch'];
	$customer_id = $_GET['customer_id'];
	$quantity = $_GET['quantity'];
	$price = $_GET['price'];
	$cus_cart_id = $_GET['cus_cart_id'];
	$cart_id = 0;
	$cal_price = $quantity * $price;
	$obo_order_type = $sel_obo_order_type;
	$pkg_charge = $_GET['pkg_charge'];
	$packing_charge = (double)$pkg_charge;
	$name = mysqli_real_escape_string($conn,$_GET['name']);
	
	$sql_sel = "SELECT * from
			obo_cart_item_details
			WHERE (TRIM('$item_id') = '' OR predef_menu_id = '$item_id') AND cart_id = $cus_cart_id";

	$result_qry = mysqli_query($conn, $sql_sel);
	$count = mysqli_num_rows($result_qry);
    
	$cart_item_id = "";
	
	while ($rows = mysqli_fetch_array($result_qry)) {
			$cart_item_id = $rows['cart_item_id'];
	}
	
	if ($count == 0) {
		$sql = "insert into obo_cart_item_details(cart_id,predef_menu_id,quantity,price,replace_name,packing_charge,branch_id)values($cus_cart_id,$item_id,$quantity,$cal_price,'$name',$packing_charge,$branch)";
		$result = mysqli_query($conn, $sql);
	} else {
		$sql = "update obo_cart_item_details set quantity = quantity + $quantity ,price = price + $cal_price,packing_charge = $packing_charge  WHERE cart_id = $cus_cart_id AND  predef_menu_id = $item_id AND cart_item_id = $cart_item_id";
		$result = mysqli_query($conn, $sql);		
	}
	echo $sql ;
}

if ($_GET["action"] == "remove_item_from_cart") {
	
	$item_id = $_GET['menu_id'];
	$customer_id = $_GET['customer_id'];
	$quantity = $_GET['quantity'];
	$price = $_GET['price'];
	$cus_cart_id = $_GET['cus_cart_id'];
	$cal_price = $quantity * $price;
	$qty_in_cart = 0;
	$branch = $_GET['branch'];
	
	$sql_sel = "SELECT * from
			obo_cart_item_details
			WHERE (TRIM('$item_id') = '' OR predef_menu_id = '$item_id') AND cart_id = $cus_cart_id";

	$result_qry = mysqli_query($conn, $sql_sel);
	$count = mysqli_num_rows($result_qry);
    
	$cart_item_id = "";
	
	while ($rows = mysqli_fetch_array($result_qry)) {
			$cart_item_id = $rows['cart_item_id'];
	}
  
	$sql = "UPDATE obo_cart_item_details
				   SET quantity = $quantity ,
				   price = $cal_price 
				   WHERE cart_id = $cus_cart_id  AND cart_item_id = $cart_item_id AND  predef_menu_id = $item_id";
				   
	$result = mysqli_query($conn, $sql);

	if ($quantity == 0) {
		$sql1 = "DELETE FROM obo_cart_item_details WHERE cart_item_id = $cart_item_id";
		$result1 = mysqli_query($conn, $sql1);
	}
}

if ($_GET["action"] == "load_item_from_cart") {
	$item_id = $_GET['menu_id'];
	$cus_cart_id = $_GET['cus_cart_id'];
	$branch = $_GET['branch'];
	
	
	$query = "SELECT * from
			obo_cart_item_details
		    WHERE (TRIM('$item_id') = '' OR predef_menu_id = '$item_id')
 		    AND cart_id = $cus_cart_id AND branch_id = $branch";

			$result = mysqli_query($conn, $query);

			$res = '';

			while ($rows = mysqli_fetch_array($result)) {

				$events = array(
					"quantity" => "$rows[quantity]",
			    );

			$output[] = $events;

			$res = json_encode($output);

			}
	if ($res == "") {
		$res = json_encode([]);
	}
	echo $res;	
}

?>

