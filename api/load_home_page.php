<?php

include("../database.php");
//session_start();

if ($_GET["action"] == "get_list_of_cities") {
	
		$res = "";

		$events = array();
		 
		$sql = "SELECT * FROM obo_city_config 
				ORDER BY city_name asc";

		$result = mysqli_query($conn, $sql);
		
		$count = mysqli_num_rows($result);
        
		while ($rows = mysqli_fetch_array($result)) {
			
		$events = array(
				"id" => "$rows[ID]",
				"city_name" => "$rows[city_name]",
				"branch_exists" => "$rows[branch_exists]",
			);
	  
		$output[] = $events;

		$res = json_encode($output);
    
	}
	if ($res == "") {
		$res = json_encode([]);
	}

    echo $res;
}

if ($_GET["action"] == "get_list_of_categories") {
	
		$res = "";

		$events = array();
		 
		$sql = "SELECT * FROM predefined_menu_categories 
		        WHERE withdraw ='N'
				ORDER BY pre_menu_id";

		$result = mysqli_query($conn, $sql);
		
		$count = mysqli_num_rows($result);
        
		while ($rows = mysqli_fetch_array($result)) {
			
		$events = array(
				"id" => "$rows[pre_menu_id]",
				"name" => "$rows[name]",
				"image_path" => "$rows[image_path]",
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

