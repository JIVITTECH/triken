<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$branch = $_GET['branch'];
$recipe_name = $_GET['recipe_name'];
$limit = $_GET['show_limited_recipes'];

if($limit == "Y"){
	$number = "limit 3";
}else{
	$number = "";
}

$item_arr = explode(" ", $recipe_name);
$qry = "";
if(sizeof($item_arr) > 0) {
    for($i = 0; $i < sizeof($item_arr); $i++) {
        if($i == 0) {
            $qry = $qry . " AND (";
        }
        $qry = $qry . "rcp.recipe_name  LIKE '%$item_arr[$i]%'";
        if($i != sizeof($item_arr)-1) {
            $qry = $qry . " OR ";
        }
        if($i == sizeof($item_arr)-1) {
            $qry = $qry . ")";
        }
    }
}

$query = 'SELECT * FROM
          obo_recipe rcp
          WHERE rcp.branch_id = "'.$branch.'"
		  ' . $qry . '
          group by rcp.id ORDER BY rcp.id DESC '. $number .'';

$result = mysqli_query($conn, $query);

$res = '';

while ($rows = mysqli_fetch_array($result)) {

    $recipe_id = $rows['id'];
    
    if ($recipe_id != null) {

        $events = array(
            "recipe_id" => "$rows[id]",
            "recipe_name" => "$rows[recipe_name]",
            "image" => "$rows[image]",
            "description" => "$rows[description]",
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