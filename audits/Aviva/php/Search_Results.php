<?php

$QRY= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($QRY)) {
    include('../../../includes/ADL_PDO_CON.php');
    if($QRY=='1') { 
        

        $query = $pdo->prepare("SELECT aviva_audit_grade, aviva_audit_closer, aviva_audit_policy, aviva_audit_added_by, aviva_audit_added_date, aviva_audit_id FROM aviva_audit");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);    

    }
}

if(!isset($QRY)) {
header('Location: ../../../CRMmain.php'); die;
}