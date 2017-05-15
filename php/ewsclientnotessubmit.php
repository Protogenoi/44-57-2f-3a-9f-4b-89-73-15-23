<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$Legacy= filter_input(INPUT_GET, 'Legacy', FILTER_SANITIZE_NUMBER_INT);
$EWS= filter_input(INPUT_GET, 'EWS', FILTER_SANITIZE_NUMBER_INT);
$REDIRECT= filter_input(INPUT_GET, 'REDIRECT', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($Legacy)) {    
    if($Legacy=='1') {
        
        $clientidnote= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
        $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $notetypedata="EWS Status update";
        $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        $status_update=$status.' - '.$notes;
        
        
        $newcolour= filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_SPECIAL_CHARS);

        $query = $pdo->prepare("INSERT INTO legacy_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        
        $status_update=$status.' - '.$notes;
        
        $query->bindParam(':clientidholder',$clientidnote, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$policy_number, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 500);
        $query->bindParam(':messageholder',$status_update, PDO::PARAM_STR, 2500);
        $query->execute();
     
        echo "<p>$status $newcolour $policy_number</p>";
        
        $sql2 = "UPDATE assura_ews_data SET ews_status = '$status', color_status='$newcolour' WHERE policy_number ='$policy_number'";
        
        if (mysqli_query($conn, $sql2)) {
    echo "<p>True</p>";
    echo "<br>";
} else {
    echo "<p>False</p>" . mysqli_error($conn);
}
        
     header('Location: ../Legacy/EWSLegfiles.php?notesupdated=y'); die;
        
    }
    
    
}

if(isset($EWS)) {    
    if($EWS=='1') {
        
        $client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
        $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        $edited= filter_input(INPUT_POST, 'edited', FILTER_SANITIZE_SPECIAL_CHARS);        
        $submitted_date= filter_input(INPUT_POST, 'submitted_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $deadline= filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_SPECIAL_CHARS);        
        $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $newcolour= filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_SPECIAL_CHARS);        
        $warning= filter_input(INPUT_POST, 'warning', FILTER_SANITIZE_SPECIAL_CHARS);        

        $notetypedata="EWS Status update";
        
        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $status_update="$warning changed to $status - $notes";
        
        $query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$policy_number, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$status_update, PDO::PARAM_STR, 2500);
        $query->execute();

        $UPDATE = $pdo->prepare("UPDATE ews_data SET ews_status_status =:warning, warning=:status, ournotes=:notes, color_status=:colour WHERE policy_number =:policy");
        $UPDATE->bindParam(':warning',$warning, PDO::PARAM_STR);
        $UPDATE->bindParam(':status',$status, PDO::PARAM_STR);
        $UPDATE->bindParam(':notes',$notes, PDO::PARAM_STR);
        $UPDATE->bindParam(':colour',$newcolour, PDO::PARAM_STR);
        $UPDATE->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $UPDATE->execute();

        $sqlx = "INSERT INTO ews_data_history (master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,processor,ournotes,color_status) (select master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,'$hello_name',ournotes,color_status from ews_data WHERE policy_number ='$policy_number' limit 1)";
if (mysqli_query($conn, $sqlx)) {
    echo "<p>TRUE</p>";
    echo "<br>";
} else {
    echo "<p>FALSE Error: " . $sqlx . "</p>" . mysqli_error($conn);
}

if(isset($MASTERMASTER)) {
        
        $UPDATE_MASTER = $pdo->prepare("INSERT INTO ews_data_history (master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,processor,ournotes,color_status) (select master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,:hello,ournotes,color_status from ews_data WHERE policy_number=:policy LIMIT 1");
        $UPDATE_MASTER->bindParam(':hello',$hello_name, PDO::PARAM_STR);
        $UPDATE_MASTER->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $UPDATE_MASTER->execute();
}

if(isset($REDIRECT)) {
    if($REDIRECT=='EWSWhite') {
 header('Location: ../Life/Reports/EWSWhite.php?RETURN=EWSNotesUpdated'); die;   
}
}

else {
header('Location: ../EWSfiles.php?RETURN=EWSNotesUpdated'); die;
}
    }
    
    
        if($EWS=='2') {
 
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

        $qews = $pdo->prepare("UPDATE ews_data set ews_status_status=:warning, warning=:status, ournotes=:notes, color_status=:color WHERE policy_number=:policy");
        $qews->bindParam(':warning',$warning, PDO::PARAM_STR);
        $qews->bindParam(':status',$status, PDO::PARAM_STR);
        $qews->bindParam(':notes',$notes, PDO::PARAM_STR);
        $qews->bindParam(':color',$newcolour, PDO::PARAM_STR);
        $qews->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $qews->execute()or die(print_r($qews->errorInfo(), true));

        $qmaster = $pdo->prepare("INSERT INTO ews_data_history (master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,processor,ournotes,color_status) (select master_agent_no,agent_no,policy_number,client_name,dob,address1,address2,address3,address4,post_code,policy_type,warning,last_full_premium_paid,net_premium,premium_os,clawback_due,clawback_date,policy_start_date,off_risk_date,seller_name,frn,reqs,ews_status_status,:hello,ournotes,color_status from ews_data WHERE policy_number =:policy limit 1)");
        $qmaster->bindParam(':policy',$policy_number, PDO::PARAM_STR);
        $qmaster->bindParam(':hello',$hello_name, PDO::PARAM_STR);
        $qmaster->execute()or die(print_r($qmaster->errorInfo(), true)); 
        
        header('Location: ../Life/ViewClient.php?search='.$client_id.'&Updated=EWS&policy_number='.$policy_number); die;
    }
    
}

header('Location: ../CRMmain.php?AccessDenied'); die;
?>
