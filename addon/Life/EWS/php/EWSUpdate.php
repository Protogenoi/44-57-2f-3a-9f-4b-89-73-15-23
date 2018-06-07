<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../../CRMmain.php?AccessDenied'); die;
}

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/ADL_PDO_CON.php');

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);


    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
 
        $client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
        $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);        
        $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $newcolour= filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_SPECIAL_CHARS);        
        $warning= filter_input(INPUT_POST, 'warning', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $notetypedata="EWS Status update";
        $status_update="$warning changed to $status ($newcolour) - $notes";
        
        $qnotes = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
  
        $qnotes->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
        $qnotes->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $qnotes->bindParam(':recipientholder',$policy_number, PDO::PARAM_STR, 500);
        $qnotes->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $qnotes->bindParam(':messageholder',$status_update, PDO::PARAM_STR, 2500);
        $qnotes->execute()or die(print_r($qnotes->errorInfo(), true));

        $qews = $pdo->prepare("UPDATE ews_data set warning=:status, ournotes=:notes, color_status=:color WHERE policy_number=:policy");
        $qews->bindParam(':status',$status, PDO::PARAM_STR);
        $qews->bindParam(':notes',$notes, PDO::PARAM_STR);
        $qews->bindParam(':color',$newcolour, PDO::PARAM_STR);
        $qews->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $qews->execute()or die(print_r($qews->errorInfo(), true));

        $qmaster = $pdo->prepare("INSERT INTO ews_data_history (master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,processor,ournotes,color_status) (select master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,:hello,ournotes,color_status from ews_data WHERE policy_number =:policy limit 1)");
        $qmaster->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $qmaster->bindParam(':hello',$hello_name, PDO::PARAM_STR);
        $qmaster->execute()or die(print_r($qmaster->errorInfo(), true)); 
        
        header('Location: /Life/ViewClient.php?search='.$client_id.'&Updated=EWS&policy_number='.$policy_number); die;
    }
    
}

header('Location: ../CRMmain.php?AccessDenied'); die;
?>
