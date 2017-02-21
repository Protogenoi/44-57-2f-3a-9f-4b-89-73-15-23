<?php

$QRY= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($QRY)) {
    include('../../../includes/ADL_PDO_CON.php');
    if($QRY=='1') { 
        

        $query = $pdo->prepare("SELECT grade, closer, plan_number, added_by, added_date, audit_id FROM RoyalLondon_Audit");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);    

    }
}

if(!isset($QRY)) {
header('Location: /CRMmain.php'); die;
}