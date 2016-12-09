<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2);
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

//$query2 = $pdo->prepare("select subject, count(subject) As Incomplete from client_notes where complete NOT IN ('Y') AND subject IN ('12 Day Call','18 Day Call','24 - 48hr Call','CYD Chase','5 Day Call') group by subject");

//$query2->execute();
//$results2=$query2->fetchAll(PDO::FETCH_ASSOC);
//$json2=json_encode($results2);

//header("content-type:application/json");
//echo $json2=json_encode($results2);

}

else {

$query = $pdo->prepare("select Task, COUNT(Complete) As Completed FROM Client_Tasks WHERE complete='0' GROUP BY Task");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json=json_encode($results);    
    
}
