<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");


include("../database.php");

$branch_id = $_GET['branch_id'];
$sel_obo_order_type = $_GET['sel_obo_order_type'];

$sql = "select * from tax_name where find_in_set($sel_obo_order_type,zone) and branchId = $branch_id and tax_flag = 1 group by id order by tax_name";


$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

$res = "";

while ($rows = mysqli_fetch_array($result)) {

    $events = array(
        "tax_percentage" => "$rows[tax_percentage]",
        "tax_name" => "$rows[tax_name]",
    );

    $output[] = $events;

    $res = json_encode($output);
}
if ($res == "") {
    $res = json_encode([]);
}

echo $res;
?>

