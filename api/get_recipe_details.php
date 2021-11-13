<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$limit = $_GET['show_limited_recipes'];
$branch = $_GET['branch'];
$number = "";

if($limit == "Y"){
	$number = "limit 3";
}else{
	$number = "";
}

$condition_1 = "";
$condition_2 = "";

if(isset($_GET['recipe_name'])){
	$recipe_name = $_GET['recipe_name'];
	if($recipe_name !== ""){
		$condition_1 = 'AND (rcp.recipe_name IS NOT NULL AND  rcp.recipe_name LIKE "%'. $recipe_name . '%")';
	}
}else{
	$condition_1 = "";
}

if(isset($_GET['selected_category'])){
	$selected_category = $_GET['selected_category'];
	if($selected_category !== ""){
		$condition_2 = 'AND rcp.category_id = ' . $selected_category . '';
	}
}else{
	$condition_2 = "";
}

$query = 'SELECT * FROM
          obo_recipe rcp
          WHERE rcp.branch_id = "' . $branch . '"  ' . $condition_1 . ' ' . $condition_2 . '
	      GROUP BY id ORDER BY id DESC '. $number .'';

//echo $query;
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