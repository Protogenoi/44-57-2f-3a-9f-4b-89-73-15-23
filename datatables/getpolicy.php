<?php

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');
 
    if ($EXECUTE == 'Life') {

        $query = $pdo->prepare("SELECT client_id, client_name, sale_date, application_number, policy_number, type, insurer, submitted_by, commission, CommissionType, PolicyStatus, submitted_date FROM client_policy");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData'] = $query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
    }
    if ($EXECUTE == 'Home') {
        $query = $pdo->prepare("SELECT client_id, client_name, added_date, insurer, policy_number, status FROM home_policy");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData'] = $query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
    }
}

if (empty($EXECUTE)) {
    header('Location: ../CRMmain.php?AccessDenied');
    die;
}
?>

