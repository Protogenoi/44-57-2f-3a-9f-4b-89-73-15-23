<?php

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {

include('../../../../includes/ADL_PDO_CON.php');

$query = $pdo->prepare("select hol_id, title, start, end FROM employee_holidays");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json;

    }

}


?>