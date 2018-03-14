<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/ 

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
    
    if(isset($EXECUTE)) {
        if($EXECUTE == 1 ) {
    
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $TASK_NAME= filter_input(INPUT_POST, 'TASK_NAME', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $WORKFLOW_HAPPY= filter_input(INPUT_POST, 'Happywithpolicy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_EMAIL= filter_input(INPUT_POST, 'Hademailfromus', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_POST= filter_input(INPUT_POST, 'Hadpostfrominsurer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_DD= filter_input(INPUT_POST, 'CancelledoldDD', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_TPS= filter_input(INPUT_POST, 'TPS', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_TRUST= filter_input(INPUT_POST, 'Trust', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $WORKFLOW_ZONE= filter_input(INPUT_POST, 'Loggedintomemberzone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $WORKFLOW_HEALTH_CHECK= filter_input(INPUT_POST, 'Bookedhealthcheck', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $SELECT_HAPPY = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_workflows_id, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Happy with policy'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_HAPPY->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_HAPPY->execute();
    $HAPPYresult=$SELECT_HAPPY->fetch(PDO::FETCH_ASSOC);
    
    $SELECT_EMAIL = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Had email from us'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_EMAIL->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_EMAIL->execute();
    $EMAILresult=$SELECT_EMAIL->fetch(PDO::FETCH_ASSOC);    
    
    $SELECT_INS = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Had post from insurer'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_INS->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_INS->execute();
    $POSTresult=$SELECT_INS->fetch(PDO::FETCH_ASSOC);   

    $SELECT_CAN = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Cancelled old DD'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_CAN->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_CAN->execute();
    $CANresult=$SELECT_CAN->fetch(PDO::FETCH_ASSOC);       
    
    $SELECT_TPS = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'TPS'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_TPS->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_TPS->execute();
    $TPSresult=$SELECT_TPS->fetch(PDO::FETCH_ASSOC); 
    
    $SELECT_TRUST = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Trust'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_TRUST->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_TRUST->execute();
    $TRUSTresult=$SELECT_TRUST->fetch(PDO::FETCH_ASSOC); 
    
    $SELECT_ZONE = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Logged into memberzone'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_ZONE->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_ZONE->execute();
    $ZONEresult=$SELECT_ZONE->fetch(PDO::FETCH_ASSOC); 
    
    $SELECT_HEALTH = $pdo->prepare("SELECT 
    adl_tasks_outcome, adl_tasks_id
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
        AND adl_tasks_title = 'Booked health check'
ORDER BY adl_workflows_updated_date DESC");
    $SELECT_HEALTH->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECT_HEALTH->execute();
    $HEALTHresult=$SELECT_HEALTH->fetch(PDO::FETCH_ASSOC);     
    
    $VAR_SEVEN=$ZONEresult['adl_tasks_outcome'];
    $TID_SEVEN=$ZONEresult['adl_tasks_id'];
    
    $VAR_EIGHT=$HEALTHresult['adl_tasks_outcome'];
    $TID_EIGHT=$HEALTHresult['adl_tasks_id'];    
    
    $ORIGVAR_SEVEN=$ZONEresult['adl_tasks_outcome'];
    $ORIGVAR_EIGHT=$HEALTHresult['adl_tasks_outcome'];   
    
    $WFID=$HAPPYresult['adl_workflows_id'];
    
    $VAR_ONE=$HAPPYresult['adl_tasks_outcome'];
    $TID_ONE=$HAPPYresult['adl_tasks_id'];
    
    $VAR_TWO=$EMAILresult['adl_tasks_outcome'];
    $TID_TWO=$EMAILresult['adl_tasks_id'];
    
    $VAR_THREE=$POSTresult['adl_tasks_outcome'];
    $TID_THREE=$POSTresult['adl_tasks_id'];
    
    $VAR_FOUR=$CANresult['adl_tasks_outcome'];
    $TID_FOUR=$CANresult['adl_tasks_id'];
    
    $VAR_FIVE=$TPSresult['adl_tasks_outcome'];
    $TID_FIVE=$TPSresult['adl_tasks_id'];
    
    $VAR_SIX=$TRUSTresult['adl_tasks_outcome'];
    $TID_SIX=$TRUSTresult['adl_tasks_id'];
    
    $ORIGVAR_ONE=$HAPPYresult['adl_tasks_outcome'];
    $ORIGVAR_TWO=$EMAILresult['adl_tasks_outcome'];
    $ORIGVAR_THREE=$POSTresult['adl_tasks_outcome'];
    $ORIGVAR_FOUR=$CANresult['adl_tasks_outcome'];
    $ORIGVAR_FIVE=$TPSresult['adl_tasks_outcome'];
    $ORIGVAR_SIX=$TRUSTresult['adl_tasks_outcome'];
    
    if($VAR_ONE != $WORKFLOW_HAPPY) {
        
        $VAR_ONE="| Happy with Policy - $WORKFLOW_HAPPY |";
        
    }
    
    else {
        
        unset($VAR_ONE);
        
    }
    
        if($VAR_TWO != $WORKFLOW_EMAIL) {
            
            $VAR_TWO="| Had email from us - $WORKFLOW_EMAIL |";
        
    }
    
    else {
        
        unset($VAR_TWO);
        
    }
    
        if($VAR_THREE != $WORKFLOW_POST) {
            
            $VAR_THREE="| Cancelled DDs - $WORKFLOW_POST |";
        
    }
    
        else {
        
        unset($VAR_THREE);
        
    }
    
        if($VAR_FOUR != $WORKFLOW_DD) {
            
            $VAR_FOUR="| Confirm old DD - $WORKFLOW_DD |";
        
    }
    
        else {
        
        unset($VAR_FOUR);
        
    }
    
        if($VAR_FIVE != $WORKFLOW_TPS) {
            
            $VAR_FIVE="| TPS - $WORKFLOW_TPS |";
        
    }
    
        else {
        
        unset($VAR_FIVE);
        
    }
    
        if($VAR_SIX != $WORKFLOW_TRUST) {
            
            $VAR_SIX= "| Trust - $WORKFLOW_TRUST |";
        
    }
    
        else {
        
        unset($VAR_SIX);
        
    }

    
        if($VAR_SEVEN != $WORKFLOW_ZONE) {
            
            $VAR_SEVEN= "| Logged into member zone - $WORKFLOW_ZONE |";
        
    }
    
        else {
        
        unset($VAR_SEVEN);
        
    }   
    
        if($VAR_EIGHT != $WORKFLOW_HEALTH_CHECK) {
            
            $VAR_EIGHT= "| Booked health check - $WORKFLOW_HEALTH_CHECK |";
        
    }
    
        else {
        
        unset($VAR_EIGHT);
        
    }   


        $query = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Happy with policy'");
        $query->bindParam(':OUTCOME', $WORKFLOW_HAPPY, PDO::PARAM_STR);
        $query->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $query->execute();
        
        $QRY_TWO = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Had email from us'");
        $QRY_TWO->bindParam(':OUTCOME', $WORKFLOW_EMAIL, PDO::PARAM_STR);
        $QRY_TWO->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_TWO->execute();

        $QRY_THREE = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Had post from insurer'");
        $QRY_THREE->bindParam(':OUTCOME', $WORKFLOW_POST, PDO::PARAM_STR);
        $QRY_THREE->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_THREE->execute();

        $QRY_FOUR = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID        
        AND
            adl_tasks_title='Cancelled old DD'");
        $QRY_FOUR->bindParam(':OUTCOME', $WORKFLOW_DD, PDO::PARAM_STR);
        $QRY_FOUR->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_FOUR->execute();

        $QRY_FIVE = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='TPS'");
        $QRY_FIVE->bindParam(':OUTCOME', $WORKFLOW_TPS, PDO::PARAM_STR);
        $QRY_FIVE->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_FIVE->execute();

        $QRY_SIX = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Trust'");
        $QRY_SIX->bindParam(':OUTCOME', $WORKFLOW_TRUST, PDO::PARAM_STR);
        $QRY_SIX->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_SIX->execute();   
         
        $QRY_SEVEN = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Logged into memberzone'");
        $QRY_SEVEN->bindParam(':OUTCOME', $WORKFLOW_ZONE, PDO::PARAM_STR);
        $QRY_SEVEN->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_SEVEN->execute();

        $QRY_EIGHT = $pdo->prepare("UPDATE 
            adl_tasks 
        SET     
            adl_tasks_outcome=:OUTCOME 
        WHERE 
            adl_tasks_id_fk=:TID
        AND
            adl_tasks_title='Booked health check'");
        $QRY_EIGHT->bindParam(':OUTCOME', $WORKFLOW_HEALTH_CHECK, PDO::PARAM_STR);
        $QRY_EIGHT->bindParam(':TID', $WFID, PDO::PARAM_INT); 
        $QRY_EIGHT->execute();       
       
    if($TASK_NAME=='48 hour') {
    
        $complete = $pdo->prepare("UPDATE adl_workflows SET adl_workflows_complete='1' WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name IN('7 day','48 hour')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();  
        
    }    
    
        elseif($TASK_NAME =='7 day') {
    
        $complete = $pdo->prepare("UPDATE adl_workflows SET adl_workflows_complete='1' WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name IN('7 day','48 hour')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();    
        
    } 
        
   else { 
        
        $complete = $pdo->prepare("UPDATE adl_workflows SET adl_workflows_complete='1' WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name=:OPTION");        
        $complete->bindParam(':OPTION', $TASK_NAME, PDO::PARAM_STR);
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();
        
   }
   
        $notetypedata= "Task $TASK_NAME";
        $recept="Workflows and Tasks Updated";
        
            if($ORIGVAR_ONE == $WORKFLOW_HAPPY 
                    && $ORIGVAR_TWO == $WORKFLOW_EMAIL 
                    && $ORIGVAR_THREE == $WORKFLOW_POST 
                    && $ORIGVAR_FOUR == $WORKFLOW_DD 
                    && $ORIGVAR_FIVE == $WORKFLOW_TPS 
                    && $ORIGVAR_SIX == $WORKFLOW_TRUST
                    && $ORIGVAR_SEVEN == $WORKFLOW_ZONE
                    && $ORIGVAR_EIGHT == $WORKFLOW_HEALTH_CHECK) {
        
        $notes="No changes";
    }
    
    else {
        
        if(empty($VAR_ONE)) {
            
            $VAR_ONE="";
            
        }
        
        if(empty($VAR_TWO)) {
            
            $VAR_TWO="";
            
        }
        
        if(empty($VAR_THREE)) {
            
            $VAR_THREE="";
            
        }       
        
        if(empty($VAR_FOUR)) {
            
            $VAR_FOUR="";
            
        }       
        
        if(empty($VAR_FIVE)) {
            
            $VAR_FIVE="";
            
        }         
        
        if(empty($VAR_SIX)) {
            
            $VAR_SIX="";
            
        } 
        
        if(empty($VAR_SEVEN)) {
            
            $VAR_SEVEN="";
            
        } 

        if(empty($VAR_EIGHT)) {
            
            $VAR_EIGHT="";
            
        }         
        
        $notes="$VAR_ONE $VAR_TWO $VAR_THREE $VAR_FOUR $VAR_FIVE $VAR_SIX $VAR_SEVEN $VAR_EIGHT";
        
    }
    
$noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:HELLO, note_type=:NOTE, message=:MSG ");
$noteinsert->bindParam(':CID',$CID, PDO::PARAM_INT);
$noteinsert->bindParam('HELLO',$hello_name, PDO::PARAM_STR, 100);
$noteinsert->bindParam(':recipient',$recept, PDO::PARAM_STR, 500);
$noteinsert->bindParam(':NOTE',$notetypedata, PDO::PARAM_STR, 255);
$noteinsert->bindParam(':MSG',$notes, PDO::PARAM_STR, 2500);
$noteinsert->execute();


      header('Location: /../../../../../app/Client.php?search='.$CID.'&CLIENT_TASK='.$TASK_NAME.'#menu4'); die; 

    }       
                        
                        }

                        header('Location: /../../../../CRMmain.php'); die;
?>