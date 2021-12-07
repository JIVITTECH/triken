<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$branch = $_GET['branch'];
$category_id = $_GET['category_id'];
$item_id = $_GET['item_id'];

$number = "";

/*if($limit == "Y"){
	$number = "limit 4";
}else{
	$number = "";
}*/

$query = 'SELECT crh.id,
				 crd.customer_name,
				 crd.ratings,
				 crd.feedback,
				 crd.image
		    FROM obo_customer_reviews_hdr crh
			JOIN obo_cust_reviews_hdr_data crd
			  ON crh.id = crd.review_id            
		   WHERE crh.branch_id = "'.$branch.'"';
		   
if ($category_id != '') {
	$query = $query . ' AND crh.category_id ="'.$category_id.'"';
}

if($item_id) {
	$query = $query . ' AND crh.predef_menu_id ="'.$item_id.'"';
}

error_log('T2: ' . $query);
		   


$result = mysqli_query($conn, $query);

$res = '';

while ($rows = mysqli_fetch_array($result)) {

    $events = array(
            "review_id" => "$rows[id]",
		    "customer_name" => "$rows[customer_name]",
		    "ratings" => "$rows[ratings]",
		    "feedback" => "$rows[feedback]",
		    "image" => "$rows[image]"
           );
		   
    $output[] = $events;

    $res = json_encode($output);

}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>