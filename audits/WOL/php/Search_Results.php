<?php

$QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_NUMBER_INT);

if(isset($QRY)) {
    include('../../../includes/ADL_PDO_CON.php');
    if($QRY=='1') { 
        

        $query = $pdo->prepare("SELECT grade, closer, policy_number, added_by, added_date, wol_id FROM audit_wol");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);    

    }
}

if(!isset($QRY)) {
header('Location: /CRMmain.php'); die;
}