<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if ($_GET["action"] == "get_list_of_all_items_for_cats") {

     $branch_id = $_GET["branch_id"];
	
	 $res = "";

	 $sql = "SELECT * FROM predefined_menu_categories 
	         WHERE withdraw ='N'and (name <> 'ALL' or name <> 'All')
	   		   AND branch_id = $branch_id
			 ORDER BY pre_menu_id";

	 $result = mysqli_query($conn, $sql);
		
	 while ($rows = mysqli_fetch_array($result)) {

	      $res = $res . "<h6 class='category-name'>" . "$rows[name]" . "</h6>" .
		                "<div class='category-box'>";

          $sql2 = 'select db.*
			  	   from (
					select pm.predef_menu_id, 
					pm.name as item_name
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
					WHERE zt.zone_id = "' . $sel_obo_order_type . '" AND pm.branch = ' . $branch_id . 
					 ' AND find_in_set("'. "$rows[pre_menu_id]" . '", pm.menu_id)' . '
					group by pm.predef_menu_id)db'; 

          $result2 = mysqli_query($conn, $sql2);
		
	      while ($rows2 = mysqli_fetch_array($result2)) {  
		       $res = $res . "<a href='items_description.php?item_id=" . "$rows2[predef_menu_id]" . "'>" . "$rows2[item_name]" . "</a>";        
		  }

		   $res = $res . "</div>";
	 }
		
     echo $res;
}

?>