<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
include("../database.php");

$limit = $_GET['show_limited_recipes'];
$branch = $_GET['branch'];

$number = "";

if($limit == "Y"){
	$number = "limit 3";
}else{
	$number = "";
}

$query = 'SELECT * FROM
          obo_recipe rcp
          WHERE rcp.branch_id = "'.$branch.'"
	      GROUP BY id ORDER BY id DESC '. $number .'';

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