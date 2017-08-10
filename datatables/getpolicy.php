<?php

$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         header('Location: ../../CRMmain.php?AccessDenied');  
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {

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
} }
else {
    header('Location: ../CRMmain.php?AccessDenied');
    die;
}
?>

