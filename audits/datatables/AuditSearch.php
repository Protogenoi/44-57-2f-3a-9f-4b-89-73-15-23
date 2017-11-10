<?php
$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {

$hello_name=$USER;
require_once(__DIR__ . '/../../includes/Access_Levels.php');

    include('../../includes/ADL_PDO_CON.php');

    $AuditType= filter_input(INPUT_GET, 'AuditType', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($AuditType)) {
    
    if($AuditType=='NewLeadGen') { 
        
        $query = $pdo->prepare("SELECT submitted_date, id, agent, auditor, grade, an_number from Audit_LeadGen");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        
        echo json_encode($results);

    }
    
    if($AuditType=='OldLeadGen') {  
        
        $query = $pdo->prepare("SELECT id, date_submitted, lead_gen_name, total, score, auditor, grade, edited, date_edited from lead_gen_audit");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        
        echo json_encode($results);        

    }
    
    if($AuditType=='Closer') { 
        
        $query = $pdo->prepare("SELECT an_number, policy_number, id, date_submitted, closer, total, score, auditor, grade, edited, date_edited from closer_audits");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        
        echo json_encode($results);          

    }
    
    }
    
        }
    
 } else {

    header('Location: /../../CRMmain.php');
    die;
    
}   
?>



