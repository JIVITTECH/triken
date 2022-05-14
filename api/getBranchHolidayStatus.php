<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if ($_GET["action"] == "getStatus") {
   $branch_id = $_GET["branch_id"];	
		$res = "";

		$events = array();
		 
		$sql = "SELECT message 
                        FROM obo_store_settings 
                        WHERE (TIMESTAMP(CLOSED_FROM,TIME(START_TIME))<=NOW()) AND (TIMESTAMP(CLOSED_TILL, TIME(END_TIME))>=NOW()) AND branch='$branch_id';";
                error_log($sql);
		$result = mysqli_query($conn, $sql);
		
		$count = mysqli_num_rows($result);
        
		while ($rows = mysqli_fetch_array($result)) {
			
		$events = array(
				"message" => "$rows[message]"
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

