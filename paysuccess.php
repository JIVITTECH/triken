<?php
ob_start();

session_start();
$title = 'Country Chicken - Triken ';
$description = 'The only thing we stock is the packages we use to deliver the meat.';
$pageRobots = 'index,nofollow';
$image = ' '; 
$pageCanonical = '';
$url = ' '; 
$page ="Personal Details";
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

include_once 'configure.php';

include("database.php");

date_default_timezone_set("Asia/Kolkata");

$current_zone_time = date("Y-m-d H:i:s");

$category_load_flag = 0;
$item_load_flag = 0;
$cart_page_flag = 0;
$razorpay_payment_id = "";
$completed_cart_id = 0;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_POST || $_GET) {

    $pm = paymentMethod($_GET['pm']); // payment method //
    $razorpay_payment_id = "";
    $rows_cnt_sel_pay = 0;
    $is_cod = "COD";
    if($_POST) {
        $razorpay_payment_id = $_POST['easepayid'];
        $is_cod = "";
        $sel_pay = "select * from invoice_details where razor_pay_id = '$razorpay_payment_id'";
        $res_sel_pay = mysqli_query($conn, $sel_pay);
        $rows_cnt_sel_pay = mysqli_num_rows($res_sel_pay);
    }
    $branch_id = $_GET['branch_id'];
    $cart_id = $_GET['cart_id'];
	$completed_cart_id = $cart_id;
    $delivery = $_GET['delivery'];
    $package_chg = $_GET['package_chg'];
    $user_id = $_GET['user_id'];
    $branch_name = "";
    $total_price = "";
    $customer_id = "";
    $merchant_id = "";
    $sub_total = "";
    $item_array = [];
    $mod_array = [];
    $tax = "";
    $order_type = "";
	/*$_COOKIE['locName'] = $_GET['locName'];*/
    $latitude = $_GET['latitude'];
	$longitude = $_GET['longitude'];
	$_COOKIE['user_id'] = $user_id;
	$_COOKIE['branch_id'] = $branch_id;
	
   
    $sql1 = "SELECT kcd.id as user_id,
            kcd.customer_name,
            kcd.branchId as branch_id,
            kcd.contact_no,
            kcd.email_addr
            FROM kot_customer_details kcd
            WHERE id = $user_id";

    $res_sql = mysqli_query($conn, $sql1);
    $rowscount_res_sql = mysqli_num_rows($res_sql);

    if ($rowscount_res_sql > 0) {
        if ($rows = mysqli_fetch_array($res_sql)) {
            $_SESSION['user_id'] = $rows['user_id'];
            $_SESSION['branch_id'] = $rows['branch_id'];
            $_SESSION['contact_no'] = $rows['contact_no'];
			setcookie("mobile_no",$rows['contact_no'] , time()+(3600*24*30));
        }
    }
        
    $sql_component_color = "SELECT * FROM obo_customization_details";
    $qry_component_color = mysqli_query($conn, $sql_component_color);
    $rowscount1 = mysqli_num_rows($qry_component_color);
    if ($rowscount1 > 0) {
        while($rows2 = mysqli_fetch_array($qry_component_color)){
            if($rows2['component'] === "button"){
                if($rows2['color']!== ""){
                    $_SESSION["obo_button_color"] = $rows2['color'];
                }else{
                    $_SESSION["obo_button_color"] = $rows2['default_color'];
                }
            }
            if($rows2['component'] === "header_bg"){
                if($rows2['color']!== ""){
                    $_SESSION["obo_header_color"] = $rows2['color'];
                }else{
                    $_SESSION["obo_header_color"] = $rows2['default_color'];
                }
            }
        }
    }          

    $branch_address = "";
    $branch_ad = "SELECT *     
                      FROM kot_branch_details
                      WHERE branch_id = $branch_id ";
    $branch_res = mysqli_query($conn, $branch_ad);
    $count = mysqli_num_rows($branch_res);
    if ($count !== 0) {
        while ($qry1 = mysqli_fetch_array($branch_res)) {
            $branch_address = $qry1['name'] . ', ' . $qry1['description']; //This line to be uploaded on live
        }
    }
    
	    $invoice_insert = "INSERT INTO invoice_details (invoice_date, razor_pay_id, others) values ('$current_zone_time', '" . $razorpay_payment_id . "', '" . $is_cod . "')";
        $res_invoice_insert = mysqli_query($conn, $invoice_insert);
        $invoice_id = mysqli_insert_id($conn);
        $order_id = $invoice_id;
        $upd_cus_pkgs = "update obo_cart_details set
                    invoice_no = '$invoice_id' , del_charge = '$delivery',order_placed = 'Y',ordered_date_time = '$current_zone_time',temp_order_id = '$order_id',branch_address ='$branch_address',packing_charge = '$package_chg',del_lat = '$latitude',del_long = '$longitude'  
                    where cart_id = $cart_id";
        if ($upd_cus_pkgs) {

        }
        $update_cart = mysqli_query($conn, $upd_cus_pkgs);
		
        $address = "";
        $sql_brnch = "select * from obo_cart_details  where cart_id  = $cart_id";
        $res_brnch = mysqli_query($conn, $sql_brnch);
        while ($rows = mysqli_fetch_array($res_brnch)) {
            $total_price = $rows['total_price'];
            $sub_total = $rows['sub_total'];
            $customer_id = round($rows['customer_id'], 0);
            $tax = $rows['tax'];
            $order_type = $rows['delivery'];
			$address = $rows['delivery_address'];
        }

        $sql_tax = "select * from tax_name where find_in_set($order_type,zone) and branchId = $branch_id and tax_flag = 1 group by id order by tax_name";
        $result_tax = mysqli_query($conn, $sql_tax);

        $del_tax = "delete from obo_order_tax where cart_id = $cart_id";
        $result_del = mysqli_query($conn, $del_tax);

        while ($rows = mysqli_fetch_array($result_tax)) {
            $tax_name = $rows['tax_name'];
            $tax_percentage = $rows['tax_percentage'];
            $tax_amount = ($sub_total / 100) * $tax_percentage;

            $sql = "insert into obo_order_tax(cart_id,tax_name,tax_per, tax_cost)values($cart_id,'$tax_name','$tax_percentage' , '$tax_amount')";
            $result = mysqli_query($conn, $sql);
        }

        $rest_id = "";
        $db_name_qry = "select * from masterdb";
        $db_name_res = mysqli_query($conn, $db_name_qry);
        while ($row_db = mysqli_fetch_array($db_name_res)) {
            $rest_id = $row_db['restaurant_key'];
        }

        $pos_merchant_id = "";

        $brnch_name = "select * from kot_branch_details  where branch_id  = $branch_id";
        $res_brnch_name = mysqli_query($conn, $brnch_name);
        while ($row = mysqli_fetch_array($res_brnch_name)) {
            $branch_name = $row['name'];
            $pos_merchant_id = $row['pos_merchant_id'];
        }

        $customer_name = "";
        $contact_no = "";
        $email_addr = "";
        $discount_amount = 0;


        $cus_details = "select * from kot_customer_details where id = $customer_id";
        $res_cus_details = mysqli_query($conn, $cus_details);
        while ($rows_cus = mysqli_fetch_array($res_cus_details)) {
            $customer_name = $rows_cus['customer_name'];
            $contact_no = $rows_cus['contact_no'];
            $email_addr = $rows['email_addr'];
        }

        $del = "select * from obo_cart_coupon where cart_id = $cart_id";
        $result_off = mysqli_query($conn, $del);
        while ($rows_dis = mysqli_fetch_array($result_off)) {
            $discount_amount = $rows_dis['amount'];
        }
        
        $order_id = $invoice_id;
        $ord_time = time();
        
        $cart_item_id = "";
        $predef_menu_id = "";
        $packaging_gst = 0;
        $sgst_percent = 0;
        $sgst = 0;
        $cgst_percent = 0;
        $cgst = 0;
        $discount = 0;
        $instructions = "";
        $packaging = 0;
        $gst_percent = 0;
        $item_quantity = 0;
        $price = 0;
        $item_unit_price = 0;
        $id = 0;
        $item_id = 0;
        $item_name = "";
        $items_list = "";
        $mod_list = "";

        $del_res = "delete from obo_cart_item_details where cart_id = $cart_id and quantity = 0";
        $del_list = mysqli_query($conn, $del_res);

        $items_res = "select DISTINCT oboi.cart_item_id AS cart_item_id_1, oboi.*, 
                        pm.name, pm.image,pm.tax, COALESCE(GROUP_CONCAT(sm.name), '') AS sub_mod_name,
                        COALESCE(GROUP_CONCAT(oboim.mod_sub_id), '') AS addon_id,
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

        $res_items = mysqli_query($conn, $items_res);

        $count = mysqli_num_rows($res_items);
        while ($rows_items = mysqli_fetch_array($res_items)) {
            $item_quantity = $rows_items['quantity'];
            $price = $rows_items['price'] + ($item_quantity * $rows_items['mod_price']) + ($rows_items['price'] / 100 * $rows_items['tax']);
            $item_unit_price = $price / $item_quantity;
            $id = $rows_items['cart_item_id'];
            $item_id = $rows_items['predef_menu_id'];
            $sub_mod_name = $rows_items['sub_mod_name'];
            $mod_price = $rows_items['mod_price'];
            $mod_cart_id = $rows_items['addon_id'];


            $item_details = "select * from predefined_menu  where predef_menu_id = $item_id and branch = $branch_id ";
            $res_details = mysqli_query($conn, $item_details);
            while ($rows_details = mysqli_fetch_array($res_details)) {
                $item_name = $rows_details['name'];
            }

            $gst = 0;
            $mod_gst_percent = 0;
            $mod_discount = 0;
            $mod_gst = 0;
            $mod_sub_id = 0;
            $mod_names = "";
            $mod_array = [];

            $mod_list = array("addon_id" => $mod_cart_id,
                "name" => $sub_mod_name,
                "price" => $mod_price,
                "gst" => $mod_gst,
                "gst_percent" => $mod_gst_percent,
                "discount" => $mod_discount
            );

            array_push($mod_array, $mod_list);

            $item_unit_price_round = $item_unit_price;
            $price_round = $price;
            $items_list = array("wera_item_id" => $id,
                "item_id" => $item_id,
                "item_name" => $item_name,
                "item_unit_price" => $item_unit_price_round,
                "subtotal" => $price_round,
                "item_quantity" => $item_quantity,
                "gst" => $gst,
                "gst_percent" => $gst_percent,
                "packaging" => $package_chg,
                "dish" => [1],
                "instructions" => $instructions,
                "discount" => $discount,
                "cgst" => $cgst,
                "cgst_percent" => $cgst_percent,
                "sgst" => $sgst,
                "sgst_percent" => $sgst_percent,
                "packaging_gst" => $packaging_gst,
                "variants" => [],
                "addons" => $mod_array);

            array_push($item_array, $items_list);
        }
        $item_array_list = json_encode($item_array);
        $order_type_temp ="";
        if ($order_type === "3") {
            $order_type_temp = "DELIVERY";
        } else if ($order_type === "2") {
            $order_type_temp = "TAKE AWAY";
        }
        $response = '{"code":1,"msg":"","error":"",
"details":{"count":"1","orders":[{"order_id":"' . $order_id . '","restaurant_id":"' . $pos_merchant_id . '","restaurant_address":"' . $branch_name . '","restaurant_number":"","external_order_id":"' . $order_id . '","status":"Pending","order_from":"'.$order_type_temp.'","restaurant_name":"' . $branch_name . '","order_date_time":"' . $ord_time . '","enable_delivery":0,"is_pop_order":false,"order_otp":"","net_amount":"' . $sub_total . '","gross_amount":"' . $total_price . '","payment_mode":"Ease Buzz","order_type":"DELIVERY","order_instructions":"","discount_reason":"","is_edit":false,"is_kot_printed":false,"is_bill_printed":false,"foodready":0,"expected_delivery_time":"1970-01-01 05:30:00","taxes":[],"packaging":"' . $package_chg. '","order_packaging":0,"packaging_cgst_percent":0,"packaging_sgst_percent":0,"packaging_cgst":0,"packaging_sgst":0,"gst":"' . $tax . '","cgst":0,"sgst":0,"delivery_charge":"' . $delivery . '","discount":"' . $discount_amount . '",
"customer_details":{"name":"' . $customer_name . '","phone_number":"' . $contact_no . '","email":"' . $email_addr . '","address":"' . $address . '","delivery_area":"' . $address . '","address_instructions":"' . $address . '"},
"rider":{"is_rider_available":false,"arrival_time":"rider status should be confirm"},
"order_items":' . $item_array_list . '}]}}';
        $js = json_decode($response);
        $details = $js->details;
        $ord = $details->orders;
        // echo $response;

        $sql_cart_id = "select * from obo_cart_details where customer_id = $user_id and order_placed= 'N' order by cart_id desc limit 1";
        $res_cart_id = mysqli_query($conn, $sql_cart_id);
        $cart_count = mysqli_num_rows($res_cart_id);

        if ($cart_count > 0) {
            if ($rows_cart_id = mysqli_fetch_array($res_cart_id)) {
                $cus_last_cart_id = $rows_cart_id['cart_id'];
            }
        } else {
            $sql = "insert into obo_cart_details(customer_id,delivery)values($user_id,$order_type)";
            $result = mysqli_query($conn, $sql);
            $cart_id = mysqli_insert_id($conn);
			$cus_last_cart_id = $cart_id;
        }
		setcookie("cart_id",$cus_last_cart_id , time()+(3600*24*30));
        $_SESSION['cart_id'] = $cus_last_cart_id;         
        sendPlaceOrderRequestToClient($ord, $_SERVER['HTTP_HOST'], $config_url_pos); /* - *** ENABLE THIS IF THEY PURCHASE POS**** */
    }


function sendPlaceOrderRequestToClient($js, $hostname,$config_url_pos) {

    global $branch_id;
    global $username;
    global $password;
    global $dbname;
	global $completed_cart_id;
    $request_headers = array();
    $request_headers[] = "Content-Type:" . "application/json";
    $request_headers[] = "Accept:" . "application/json";

    if ($hostname != "" && $hostname != null) {

        //Prepare you post parameters
        $postData = json_encode($js);

        //API URL
        $url = $config_url_pos . "pending_order_update.php?branch_id=" . $branch_id . "&db_name=" . $dbname . "&db_uname=" . $username . "&db_pass=" . $password;

        // echo $url;
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $request_headers
                //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $response = curl_exec($ch);
        $err = curl_errno($ch);

        curl_close($ch);

        //Print error if any
        if ($err) {
            //echo 'error:' . curl_error($ch);
        } else {
            echo $response;
        }
    }

    header("location:order_summary.php?cart_id=".$completed_cart_id);
}
ob_end_flush();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Cart</title>

        <!-- bootstrap css & js -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        <style>
            body {
                background: #f2f2f2;
            }
        </style>

        <script>

            function getAllUrlParams(url) {
                // get query string from url (optional) or window
                var queryString = url ? url.split('?')[1] : window.location.search.slice(1); // we'll store the parameters here
                var obj = {}; // if query string exists
                if (queryString) {

                    // stuff after # is not part of query string, so get rid of it                                                 queryString = queryString.split('#')[0];

                    // split our query string into its component parts
                    var arr = queryString.split('&');
                    for (var i = 0; i < arr.length; i++) {
                        // separate the keys and the values
                        var a = arr[i].split('=');
                        // in case params look like: list[]=thing1&list[]=thing2
                        var paramNum = undefined;
                        var paramName = a[0].replace(/\[\d*\]/, function (v) {
                            paramNum = v.slice(1, -1);
                            return '';
                        });
                        // set parameter value (use 'true' if empty)
                        var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
                        // (optional) keep case consistent
                        paramName = paramName.toLowerCase();
                        paramValue = paramValue.toLowerCase();
                        // if parameter name already exists
                        if (obj[paramName]) {                                 // convert value to array (if still string)
                            if (typeof obj[paramName] === 'string') {
                                obj[paramName] = [obj[paramName]];
                            }
                            // if no array index number specified...
                            if (typeof paramNum === 'undefined') {
                                // put the value on the end of the array                                                             obj[paramName].push(paramValue);
                            }
                            // if array index number specified...
                            else {
                                // put the value at that index number                                     obj[paramName][paramNum] = paramValue;
                            }
                        }
                        // if param name doesn't exist yet, set it
                        else {
                            obj[paramName] = paramValue;
                        }
                    }
                }

                return obj;
            }

            function imgError(image) {
                image.onerror = "";
                image.src = "images/default.png";
                return true;
            }

        </script>

        <script>

            $(document).ready(function () {

                var arr1 = getAllUrlParams((window.location).toString());
                var customer_id = "<?php echo $customer_id; ?>">;
                loadCustomerSelectedItems();

            });
            function loadCustomerSelectedItems() {

            }

        </script>

    </head>

    <body>

        <header>
            <?php include_once 'header.php'; ?>
        </header>
        <div class="container" style="margin-top:220px;margin-bottom :250px;">
            <h3 style="text-align:center;">Please wait..Do not refresh the page</h3>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary"  style="width: 5rem; height: 5rem;"  role="status">
                    <!--<span class="sr-only">Loading...</span>-->
                </div>
            </div>
        </div>

        <footer>
            <!-- footer section - start -->
            <?php include_once 'footer.php'; ?>
            <!-- footer section - end -->
        </footer>

    </body>

</html>