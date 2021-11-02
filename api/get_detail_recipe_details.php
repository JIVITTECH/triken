<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
include("../database.php");

$branch = $_GET['branch'];
$recipe_id = $_GET['recipe_id'];

$query = 'SELECT * FROM
          obo_recipe rcp
          WHERE rcp.branch_id = "'.$branch.'"
	      AND rcp.id = "'.$recipe_id.'" ';

$result = mysqli_query($conn, $query);

$res = '';

while ($rows = mysqli_fetch_array($result)) {

    $recipe_id = $rows['id'];
	$recipe_name = $rows['recipe_name'];
	$image = $rows['image'];
	$description = $rows['description'];
	
	$query_ing = 'SELECT * FROM
          obo_recipe_ingredients rci
          WHERE rci.branch_id = "'.$branch.'" 
	      AND rci.recipe_id = "'.$recipe_id.'" 
		  ORDER BY id ';

	$res_ing = mysqli_query($conn, $query_ing);
	
	$rec_ing_arr = [];	

	while ($rows1 = mysqli_fetch_array($res_ing)) { 
		$events_arr = array(
            "ingredient_id" => "$rows1[id]",
            "ingredient_name" => "$rows1[ingredient_name]",
        );
	
		$rec_ing_arr[] = $events_arr;
	}
	
	$query_steps = 'SELECT * FROM
          obo_recipe_procedure orp
          WHERE orp.branch_id = "'.$branch.'" 
	      AND orp.recipe_id = "'.$recipe_id.'" 
		  ORDER BY instruction_id asc';

	$res_steps = mysqli_query($conn, $query_steps);
	
	$rec_proc_arr = [];	

	while ($rows2 = mysqli_fetch_array($res_steps)) {
		$events_proc = array(
            "instruction_id" => "$rows2[instruction_id]",
            "recipe_notes" => "$rows2[recipe_notes]",
			"detail_steps" => "$rows2[detail_steps]"
        );
	
		$rec_proc_arr[] = $events_proc;
	}
	
    
    if ($recipe_id != null) {

        $events = array(
            "recipe_id" => "$rows[id]",
            "recipe_name" => $recipe_name,
            "image" => $image,
            "description" => $description,
			"ingredient_list" => $rec_ing_arr,
			"procedure" => $rec_proc_arr
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