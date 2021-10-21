<?php

include("../database.php");

if ($_GET["action"] == "add_item_to_cart") {
	
	$item_id = $_GET['menu_id'];
	$customer_id = $_GET['customer_id'];
	$quantity = $_GET['quantity'];
	$price = $_GET['price'];
	$cus_cart_id = $_GET['cus_cart_id'];
	$cart_id = 0;
	$cal_price = $quantity * $price;
	$cat_id = $_GET['cat_id'];
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
		$sql = "insert into obo_cart_item_details(cart_id,predef_menu_id,quantity,price,cat_id,replace_name,packing_charge)values($cus_cart_id,$item_id,$quantity,$cal_price,$cat_id,'$name',$packing_charge)";
		$result = mysqli_query($conn, $sql);
	} else {
		$sql = "update obo_cart_item_details set quantity = quantity + $quantity ,price = price + $cal_price,packing_charge = $packing_charge  WHERE cart_id = $cus_cart_id AND  predef_menu_id = $item_id AND cart_item_id = $cart_item_id";
		$result = mysqli_query($conn, $sql);
	}
}
if ($_GET["action"] == "remove_item_from_cart") {
	
	$item_id = $_GET['menu_id'];
	$customer_id = $_GET['customer_id'];
	$quantity = $_GET['quantity'];
	$price = $_GET['price'];
	$cus_cart_id = $_GET['cus_cart_id'];
	$cal_price = $quantity * $price;
	$cart_item_id = $_GET['cart_item_id'];
	$qty_in_cart = 0;

	$sql = "UPDATE obo_cart_item_details
				   SET quantity = $quantity ,
				   price = $cal_price 
				   WHERE cart_id = $cus_cart_id  AND cart_item_id = $cart_item_id AND  predef_menu_id = $item_id";
				   
	$result = mysqli_query($conn, $sql);

	$sql_sel = "SELECT * FROM
			obo_cart_item_details
			WHERE (TRIM('$item_id') = '' OR predef_menu_id = '$item_id') AND cart_id = $cus_cart_id";

	$result_qry = mysqli_query($conn, $sql_sel);

	while ($rows = mysqli_fetch_array($result_qry)) {
			$qty_in_cart = $rows['quantity'];
	}
	
	if ($qty_in_cart == 0) {
		$sql1 = "DELETE FROM obo_cart_item_details WHERE cart_item_id = $cart_item_id";
		$result1 = mysqli_query($conn, $sql1);
	}
}
if ($_GET["action"] == "get_items_from_cart") {
	
	$cart_id = $_GET['cart_id'];
	
	$sql = "SELECT db.* ,
			  (SELECT COUNT(*) FROM  kot_item_stock_details isd
			   WHERE isd.predef_menu_id = db.menu_id)as stock_chk
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
			   ocid.packing_charge
			   FROM 
			   obo_cart_details ocd
			   LEFT JOIN obo_cart_item_details ocid
			   ON ocd.cart_id = ocid.cart_id 
			   LEFT JOIN predefined_menu pm
			   ON pm.predef_menu_id = ocid.predef_menu_id 
			   where ocd.cart_id = $cart_id and ocid.quantity <> 0 
			   group by ocid.cart_item_id)db";

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
            "image" => "$rows[image]",
            "menu_id" => "$rows[menu_id]",
            "per_unit_price" => "$rows[per_unit_price]",
            "cart_item_id" => "$rows[cart_item_id]",
            "tax" => "$rows[tax]",
            "category_id" => "$rows[category_id]",
            "stock_chk" => "$rows[stock_chk]",
            "replace_name" => "$rows[replace_name]",
            "packing_charge" => "$rows[packing_charge]"
        );
        $output[] = $events;

        $res = json_encode($output);
		
    }
}
?>

