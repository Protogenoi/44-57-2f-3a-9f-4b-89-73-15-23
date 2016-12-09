<?php
include('includes/ADL_PDO_CON.php');

$query = $pdo->prepare("select client_details.client_id, count(client_details.client_id) AS Completed from client_details LEFT JOIN taskcheck on taskcheck.client_id = client_details.client_id WHERE client_details.client_id NOT IN (SELECT client_id from taskcheck)");

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
