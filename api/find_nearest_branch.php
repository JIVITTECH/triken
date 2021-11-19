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

$sql_dis = "SELECT db.* FROM (SELECT branch_id,name,description,
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
	   as distance FROM kot_branch_details 
	   WHERE withdraw_branch = '0'
	   GROUP BY branch_id
	   ORDER BY distance ASC )db";


$result_dis = mysqli_query($conn, $sql_dis);

while ($rows_dis = mysqli_fetch_array($result_dis)) {
	
 	 $cnt = 0;
       
	 $distance = $rows_dis['distance'];
	
	 if($cnt == 0){
		
	  	  if($distance <= $radius){

			  $_SESSION['branch_id'] = $rows_dis['branch_id'];
			  setcookie("branch_id", $rows_dis['branch_id'], time()+(3600*24*30), "/");
			  
			  $events = array(
					"branch_id" => "$rows_dis[branch_id]",
					"name" => "$rows_dis[name]",
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

