<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$branch = $_GET['branch'];
$item_id = $_GET['item_id'];

$query = 'select db.* , 
(SELECT COUNT(*) FROM  kot_item_stock_details isd
WHERE isd.predef_menu_id = db.predef_menu_id AND branch_id = $branch)as stock_chk
from (SELECT
pm.predef_menu_id, 
pm.name as item_name,
pm.preqty, 
IFNULL(kmz.price, pm.price) AS price, 
pm.tax, 
pm.image,
pm.veg_non,
IF(pk_chg.price IS NULL,0,pk_chg.price) AS packing_charge,
pm.item_notes,
pm.deals_of_the_day,
FLOOR(pm.disc_per) AS disc_per,
pm.best_seller,
pm.measure,
pma.net_weight,
pma.gross_weight,
pma.delivery_time,
pma.video_path,
pm.description
FROM
predefined_menu pm
join kot_branch_details kbd
on kbd.branch_id = pm.branch
join zone_details zt
on zt.branch_id = pm.branch
left join kot_menu_zone kmz
on find_in_set(kmz.item_id, pm.predef_menu_id)
and kmz.branch_id = zt.branch_id
and kmz.zone = zt.zone_id 
and kmz.branch_id = pm.branch
left join packing_charges pk_chg
on pk_chg.predef_menu_id = pm.predef_menu_id AND pk_chg.branch_id = pm.branch
left join predefined_menu_additional pma
on pma.predef_menu_id = pm.id
WHERE  zt.zone_id = "' . $sel_obo_order_type . '" AND pm.branch = ' . $branch . ' 
AND pm.predef_menu_id = "' . $item_id . '"
group by pm.predef_menu_id)db';

$result = mysqli_query($conn, $query);

$res = ''; 

while ($rows = mysqli_fetch_array($result)) {

   $events_spc_arr = [];
    
	$items_spc = 'SELECT * 
	        FROM obo_item_description
			WHERE branch_id = ' . $branch . ' 
			AND predef_menu_id = "' . $item_id . '"
			group by id order by id desc';

	$result_spc = mysqli_query($conn, $items_spc);

	
	while ($rows_spc = mysqli_fetch_array($result_spc)) {
		$events_spc = array(
				  "specification" => "$rows_spc[specification]"
			);
		$events_spc_arr[] = $events_spc;
	}

    $events_img_arr = [];
	
	$items_img = "SELECT * 
	        FROM item_related_images
			WHERE branch_id = $branch 
			AND item_id = $item_id
			group by id order by id asc";

	$result_img = mysqli_query($conn, $items_img);

	
	while ($rows_img = mysqli_fetch_array($result_img)) {
		$events_img = array(
				  "image_path" => "$rows_img[image_path]"
			);
		$events_img_arr[] = $events_img;
	}
	
	$events = array(
		"menu_id" => "$rows[predef_menu_id]",
		"name" => "$rows[item_name]",
		"price" => "$rows[price]",
		"image" => "$rows[image]",
		"stock_chk" => "$rows[stock_chk]",
		"veg_non" => "$rows[veg_non]",
		"packing_charge" => "$rows[packing_charge]",
		"item_notes" => "$rows[item_notes]",
		"delivery_time" => "$rows[delivery_time]",
		"gross_weight" => "$rows[gross_weight]",
		"net_weight" => "$rows[net_weight]",
		"measure" => "$rows[measure]",
		"best_seller" => "$rows[best_seller]",
		"disc_per" => "$rows[disc_per]",
		"deals_of_the_day" => "$rows[deals_of_the_day]",
		"video_path" => "$rows[video_path]",
		"description" => "$rows[description]",
		"specification" => $events_spc_arr,
		"related_images" => $events_img_arr
	   );
    
    $output[] = $events;

    $res = json_encode($output);
}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>