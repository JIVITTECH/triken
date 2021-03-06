<?php

include "../database.php";
$customer_id = $_GET['obo_cus_id'];
//$customer_id = "1";

if ($customer_id == null && $customer_id == "" && $customer_id == "-1") {
    echo json_encode([]);
    return;
}


$sql = "select
	cd.*,cd.customer_id as cus_id ,DATE_FORMAT(cd.ordered_date_time, '%d %b %Y, %r') AS ordered_date_time_formatted,
	wpo.rider_name as delivery_person, wpo.rider_no as delivery_person_mo, kfl.*, kfqr.*, id.others as payment_type 
	from obo_cart_details cd
	left join wera_placed_orders wpo
	on wpo.external_order_id = cd.temp_order_id
	left join  kot_feedbacks_logs  kfl  
		   on kfl.cart_or_order_id = cd.cart_id
	left join kot_feedback_qn_and_ratings kfqr
		   on kfl.kfd_id = kfqr.kd_id
	left join invoice_details id
		   on id.invoice_id = cd.invoice_no      
	where cd.customer_id = $customer_id
	AND cd.order_placed = 'Y'
	order by cart_id desc";


$res_sql = mysqli_query($conn, $sql);
$res_sql_cnt = mysqli_num_rows($res_sql);

$obo_cart_arr = array();

if ($res_sql_cnt > 0) {

    while ($rw = mysqli_fetch_array($res_sql)) {

        $obo_cart_details = array();
        $wera_order_no = $rw['temp_order_id'];
        $cart_id = $rw['cart_id'];
        $customer_id = $rw['cus_id'];
        $ordered_date_time = $rw['ordered_date_time_formatted'];
        $delivery_address = $rw['delivery_address'];
        $rider_name = $rw['delivery_person'];
        $tax = $rw['tax'];
        $total_price = $rw['total_price'];
        $invoice_no = $rw['invoice_no'];
        $order_placed = $rw['order_placed'];
        $branch_address = $rw['branch_address'];
        $delivery = $rw['delivery'];
        $del_charge = $rw['del_charge'];
        $pkg_charge = $rw['packing_charge'];
        $ord_ratings = $rw['ord_ratings'];
        $ord_comments = $rw['ord_comments'];
        $del_ratings = $rw['del_ratings'];
        $del_comments = $rw['del_comments'];
        $rider_no= $rw['delivery_person_mo'];
        $payment_type = $rw['payment_type'];
        $cart_detail_tmp = array(
            "cart_details" => array(
                "cart_id" => $cart_id,
                "customer_id" => $customer_id,
                "ordered_date_time" => $ordered_date_time,
                "delivery_address" => $delivery_address,
                "delivery_person" => $rider_name,
                "tax" => $tax,
                "total_price" => $total_price,
                "invoice_no" => $invoice_no,
                "order_placed" => $order_placed,
                "branch_address" => $branch_address,
                "delivery" => $delivery,
                "pkg_charge" => $pkg_charge,
                "del_charge" => $del_charge,
                "ord_ratings" => $ord_ratings,
                "ord_comments" => $ord_comments,
                "del_ratings" => $del_ratings,
                "del_comments" => $del_comments,
                "delivery_person_mo" => $rider_no,
                "payment_type" => $payment_type
            )
        );

        array_push($obo_cart_details, $cart_detail_tmp);

        $sql_items = "select DISTINCT oboi.cart_item_id AS cart_item_id_1, oboi.*, 
                        pm.name, pm.image,pm.tax, COALESCE(GROUP_CONCAT(sm.name), '') AS sub_mod_name,
                        if(sum(sm.price)is null,0,sum(sm.price))  AS mod_price
                        from obo_cart_item_details oboi
                        left join predefined_menu pm
                        on pm.predef_menu_id = oboi.predef_menu_id AND pm.branch = oboi.branch_id
                        left join obo_cart_item_modifiers oboim
                        on oboim.cart_item_id = oboi.cart_item_id
                        left join sub_modifiers sm
                        on sm.mod_sub_id = oboim.mod_sub_id
                        where oboi.cart_id = $cart_id
                        group by oboi.cart_item_id
                        order by oboi.cart_item_id";

        $res_sql_items = mysqli_query($conn, $sql_items);
        $res_sql_items_cnt = mysqli_num_rows($res_sql_items);

        $cart_items_cnt = array(
            "cart_items_count" => "$res_sql_items_cnt"
        );

        array_push($obo_cart_details, $cart_items_cnt);

        if ($res_sql_items_cnt > 0) {

            $cart_item_tmp = array();
            $cart_item_tmp2 = array();

            $sub_total = 0.0;

            while ($row = mysqli_fetch_array($res_sql_items)) {

                $cart_item_id = $row['cart_item_id'];
                $predef_menu_id = $row['predef_menu_id'];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $name = $row['name'];
                $image = $row['image'];
                $sub_mod_name = $row['sub_mod_name'];
                $mod_price = $row['mod_price'];
                $tax = $row['tax'];

                $sub_total = $sub_total + $price + ($quantity * $mod_price) + ($price/ 100 * $tax);

                $cart_item_tmp = array(
                    "cart_item_id" => $cart_item_id,
                    "cart_id" => $cart_id,
                    "predef_menu_id" => $predef_menu_id,
                    "price" => $price + ($quantity * $mod_price) + ($price/ 100 * $tax),
                    "quantity" => $quantity,
                    "name" => $name,
                    "image_path" => $image,
                    "sub_mod_name" => $sub_mod_name,
                 );

                $cart_item_tmp2[] = $cart_item_tmp;
            }

            $cart_items = array(
                "cart_items" => $cart_item_tmp2,
            );

            $cart_sub_total = array(
                "cart_sub_total" => $sub_total
            );

            array_push($obo_cart_details, $cart_items);
            array_push($obo_cart_details, $cart_sub_total);
        }

        $sel_tax = "select * from obo_order_tax where cart_id = $cart_id";
        $res_sel_tax = mysqli_query($conn, $sel_tax);
        $res_sel_tax_cnt = mysqli_num_rows($res_sel_tax);

        if ($res_sel_tax_cnt > 0) {

            while ($row1 = mysqli_fetch_array($res_sel_tax)) {

                $cart_id = $row1['cart_id'];
                $tax_name = $row1['tax_name'];
                $tax_per = $row1['tax_per'];
                $tax_cost = $row1['tax_cost'];

                $cart_tax_tmp = array(
                    "cart_id" => $cart_id,
                    "tax_name" => $tax_name,
                    "tax_per" => $tax_per,
                    "tax_cost" => $tax_cost
                );

                $cart_tax_tmp2[] = $cart_tax_tmp;
            }

            $cart_tax = array(
                "cart_taxes" => $cart_tax_tmp2
            );

            array_push($obo_cart_details, $cart_tax);
        } else {
            $cart_tax = array(
                "cart_taxes" => array()
            );

            array_push($obo_cart_details, $cart_tax);
        }

        $sel_disc = "select * from obo_cart_coupon where cart_id = $cart_id";
        $res_sel_disc = mysqli_query($conn, $sel_disc);
        $res_sel_disc_cnt = mysqli_num_rows($res_sel_disc);

        if ($res_sel_disc_cnt > 0) {

            while ($row2 = mysqli_fetch_array($res_sel_disc)) {

                $cart_id = $row2['cart_id'];
                $disc_name = $row2['discount_name'];
                $disc_cost = $row2['discount_cost'];

                $cart_disc_tmp = array(
                    "cart_id" => $cart_id,
                    "disc_name" => $disc_name,
                    "disc_cost" => $disc_cost
                );

                $cart_disc_tmp2[] = $cart_disc_tmp;
            }

            $cart_disc = array(
                "cart_disc" => $cart_disc_tmp2
            );

            array_push($obo_cart_details, $cart_disc);
        } else {
            $cart_disc = array(
                "cart_disc" => array()
            );

            array_push($obo_cart_details, $cart_disc);
        }

        $status = getOrderStatus($conn, $wera_order_no);

        //$cart_order_status[] = $cart_status;
        $order_status = array(
            "order_status" => $status
        );

        array_push($obo_cart_details, $order_status);

        array_push($obo_cart_arr, $obo_cart_details);
    }


    $db = json_encode($obo_cart_arr);
    echo json_encode($obo_cart_arr);

    //print_r($obo_cart_arr);
    //$db_arr = json_decode($db);
    //print_r($db_arr);
}

function getOrderStatus($conn, $order_no) {
	$ready = "select * from wera_placed_orders
            LEFT JOIN obo_cart_details 
            on obo_cart_details.temp_order_id = wera_placed_orders.order_id
            where (TRIM('$order_no') = '' OR order_id LIKE '%$order_no%' OR external_order_id LIKE '%$order_no%') AND 
            approve_status = 'N' AND reject_id IS NOT NULL order by id desc";
    $res_ready = mysqli_query($conn, $ready);
    $count_ready = mysqli_num_rows($res_ready);
    if ($count_ready != 0) {
        $status = 5;
        return $status;
    }else{
		return 0;
	}
}

?>