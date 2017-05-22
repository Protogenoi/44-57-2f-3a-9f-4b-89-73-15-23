<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

$agent= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);

include('../../includes/ADL_PDO_CON.php');

if(isset($agent)) {

$query = $pdo->prepare("select Task, COUNT(Complete) As Completed FROM Client_Tasks WHERE complete='0' and assigned=:agent GROUP BY Task");
$query->bindParam(':agent', $agent, PDO::PARAM_STR, 12);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json=json_encode($results);

}

else {

$query = $pdo->prepare("select Task, COUNT(Complete) As Completed FROM Client_Tasks WHERE complete='0' GROUP BY Task");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json=json_encode($results);    
    
}
