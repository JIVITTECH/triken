<?php

session_start();

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$branch = $_GET['branch'];

$query = "SELECT ofhd.* 
            FROM OBO_FAQ_HEADER ofh 
            JOIN OBO_FAQS_HEADER_DATA ofhd
              ON ofh.id = ofhd.faq_id";

$result = mysqli_query($conn, $query);

$res = ''; 
while ($rows = mysqli_fetch_array($result)) {	
    $events = array(
        "id" => "$rows[FAQ_ID]",
        "question" => "$rows[QUESTION]",
        "response" => "$rows[RESPONSE]"
    );
    
    $output[] = $events;

    $res = json_encode($output);
}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>