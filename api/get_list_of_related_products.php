<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$branch = $_GET['branch'];
$item_id = $_GET['item_id'];

$category_id = ''; 

$cat_query = 'select menu_id
              from predefined_menu
              where predef_menu_id =' . $item_id . '
                 and branch =' . $branch;

$cat_result = mysqli_query($conn, $cat_query);

while ($rows = mysqli_fetch_array($cat_result)) {
    $category_id = $rows['menu_id'];
}

$query = 'select db.* , (SELECT COUNT(*) FROM  kot_item_stock_details isd
WHERE isd.predef_menu_id = db.predef_menu_id  AND branch_id = ' . $branch . ' AND isd.zone_id = ' . $sel_obo_order_type . ')as stock_chk
from (
select pm.predef_menu_id, pm.name as item_name
,pm.preqty, IFNULL(kmz.price, pm.price) AS price, pm.tax, pm.image,
pm.veg_non,
IF(pk_chg.price IS NULL,0,pk_chg.price) AS packing_charge,
pm.item_notes,
pm.deals_of_the_day,
FLOOR(pm.disc_per) AS disc_per,
pma.net_weight,
pma.gross_weight,
pma.delivery_time,
pm.best_seller,
pm.measure,
pm.new_arrival
from predefined_menu pm
join predefined_menu_categories pmc 
on find_in_set(pmc.pre_menu_id, pm.menu_id)
join kot_branch_details kbd
on kbd.branch_id = pmc.branch_id
join zone_details zt
on zt.branch_id = pmc.branch_id
left join kot_menu_zone kmz
on find_in_set(kmz.item_id, pm.predef_menu_id)
and kmz.branch_id = zt.branch_id
and kmz.zone = zt.zone_id 
left join packing_charges pk_chg
on pk_chg.predef_menu_id = pm.predef_menu_id AND pk_chg.branch_id = pm.branch
and pmc.branch_id = pk_chg.branch_id 
left join predefined_menu_additional pma
on pma.predef_menu_id = pm.id
WHERE zt.zone_id = "' . $sel_obo_order_type . '" AND pm.branch = ' . $branch . '
   and pmc.pre_menu_id = "' . $category_id . '"
group by pm.predef_menu_id)db';

$result = mysqli_query($conn, $query);

$res = '';

while ($rows = mysqli_fetch_array($result)) {

    $pre_menu_id = $rows['predef_menu_id'];
    
    if ($pre_menu_id != null) {

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
			"new_arrival" => "$rows[new_arrival]",
			"disc_per" => "$rows[disc_per]",
		   );
    }
    $output[] = $events;

    $res = json_encode($output);
}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>