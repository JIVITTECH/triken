<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");
if ($_GET["action"] == "get_top_categories") {
    $branch_id = $_GET["branch_id"];
    $res = "";

    $events = array();

    $sql = 'SELECT * 
            FROM predefined_menu_categories 
	        WHERE withdraw ="N" 
              AND branch_id="'.$branch_id.'"
              AND lower(name) NOT LIKE "%all%"
	        ORDER BY ordering ASC, pre_menu_id ASC';
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    while ($rows = mysqli_fetch_array($result)) {

        $events = array(
            "id" => "$rows[pre_menu_id]",
            "name" => "$rows[name]",
            "image_path" => "$rows[image_path]",
            "icon" => "$rows[icon]"
        );

        $output[] = $events;

        $res = json_encode($output);
    }
    if ($res == "") {
        $res = json_encode([]);
    }

    echo $res;
}
