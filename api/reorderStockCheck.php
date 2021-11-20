<?php

include "../database.php";

$cart_id = $_GET['cart_id'];
$type = $_GET['type'];
$cur_cart = $_GET['cur_cart_id'];


if ($type == 1) {
    if ($cart_id != "") {

        $query = "";

        $query = "SELECT pm.branch, pm.predef_menu_id, pm.name
                        FROM predefined_menu pm
                        JOIN obo_cart_item_details ocid
                        ON ocid.predef_menu_id = pm.predef_menu_id
                        AND ocid.branch_id = pm.branch
                        AND ocid.cart_id = $cart_id
                        JOIN kot_item_stock_details kisd
                        ON kisd.branch_id = ocid.branch_id
                        AND kisd.predef_menu_id = ocid.predef_menu_id";
//echo $sql;
        $result = mysqli_query($conn, $query);
    }

    $res = '';

    while ($rows = mysqli_fetch_array($result)) {

        $pre_menu_id = $rows['predef_menu_id'];

        if ($pre_menu_id != null) {

            $events = array(
                "name" => "$rows[name]"
            );
        }
        $output[] = $events;

        $res = json_encode($output);
    }

    if ($res == "") {
        $res = json_encode([]);
    }

    echo $res;
} else if ($type == 2) {

    $predef_id = 0;
    $cart_itm_id = 0;

    $old_cart = "SELECT * FROM obo_cart_item_details where cart_id = $cart_id GROUP BY cart_item_id ORDER BY cart_item_id ";

    $old_cart_result = mysqli_query($conn, $old_cart);

    while ($rows = mysqli_fetch_array($old_cart_result)) {
        $old_cart_itm_id = $rows['cart_item_id'];
        $old_predef_menu_id = $rows['predef_menu_id'];
        $old_price = $rows['price'];
        $old_quantity = $rows['quantity'];
        $old_branch_id = $rows['branch_id'];
        $old_cat_id = $rows['cat_id'];
        $replace_name = $rows['replace_name'];
        $packing_charge = $rows['packing_charge'];
        
        $sql_brnch = "select * from obo_cart_details  where cart_id  = $cart_id";
        $res_brnch = mysqli_query($conn, $sql_brnch);
        while ($rows = mysqli_fetch_array($res_brnch)) {
            $branch_id = $rows['branch_id'];
            $delivery = $rows['delivery'];
            
            $upd_cus_pkgs = "update obo_cart_details set
                branch_id  = '$old_branch_id',delivery = '$delivery'
                where cart_id = $cur_cart";
            $update_cart = mysqli_query($conn, $upd_cus_pkgs);
            
            $_SESSION['branch_id'] = $old_branch_id;
        }
        
        $sql_itm = "INSERT INTO obo_cart_item_details (cart_id, predef_menu_id, price, quantity, branch_id,replace_name,packing_charge)
                    VALUES($cur_cart,$old_predef_menu_id,$old_price,$old_quantity,'$old_branch_id','$replace_name',$packing_charge)";
		echo $sql_itm;
        $item_qry = mysqli_query($conn, $sql_itm);
        $org_cart_itm_id = mysqli_insert_id($conn);
    }
} else if ($type == 3) {

    $sql_del_mods = "DELETE FROM
            obo_cart_item_modifiers
            WHERE cart_id = $cur_cart";

    $result_qry_del = mysqli_query($conn, $sql_del_mods);

    $sql_del = "DELETE FROM
            obo_cart_item_details
            WHERE cart_id = $cur_cart";

    $result_qry = mysqli_query($conn, $sql_del);

    echo $result_qry;
}
