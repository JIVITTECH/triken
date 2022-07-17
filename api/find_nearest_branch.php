<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}	

$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

$_SESSION['user_loc_latitude'] = $latitude;
$_SESSION['user_loc_longitude'] = $longitude;

$res = "";

$sql_dis = "SELECT db.* 
            FROM 
			    (SELECT kbd.branch_id,
				        kbd.name,
						kbd.description,
					   (
							(
								(
									acos(
										sin(( $latitude * pi() / 180))
										*
										sin(( `latitude` * pi() / 180)) + cos(($latitude * pi() /180 ))
										*
										cos(( `latitude` * pi() / 180)) * cos((($longitude - `longitude`) * pi()/180)))
								) * 180/pi()
							) * 60 * 1.1515 * 1.609344
						)
					   as distance,
					   oss.message,
					   CASE 
					     WHEN trim(oss.message) IS NOT NULL AND ASCII(oss.message) != '0' THEN 
						    '1'       
						 ELSE
						    '0' 
                       END AS msg_ind 
			    FROM kot_branch_details kbd
				LEFT JOIN 
				     ( SELECT message,
					          branch
				   	   FROM obo_store_settings 
					   WHERE NOW() BETWEEN (TIMESTAMP(closed_from, TIME(start_time))) 
					     AND (TIMESTAMP(closed_till, TIME(end_time)))  ) oss
				  ON oss.branch = kbd.branch_id
				WHERE kbd.withdraw_branch = '0' ) db
			ORDER BY db.msg_ind ASC, db.distance ASC";

error_log($sql_dis);

$result_dis = mysqli_query($conn, $sql_dis);

$cnt = 0;
   
while ($rows_dis = mysqli_fetch_array($result_dis)) {
	    
	 $distance = $rows_dis['distance'];
	
	 if($cnt == 0){
		
		  if($distance <= $radius){

			  $_SESSION['branch_id'] = $rows_dis['branch_id'];
			  
			  $events = array(
					"branch_id" => "$rows_dis[branch_id]",
					"name" => "$rows_dis[name]",
					"message" => "$rows_dis[message]",
			  );
				
			  $output[] = $events;

			  $res = json_encode($output);
			
			  $cnt = $cnt + 1;
		 }
	}
}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>

