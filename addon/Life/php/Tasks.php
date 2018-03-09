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
        if($EXECUTE=='1') {
            
            $assigned= filter_input(INPUT_POST, 'assigned', FILTER_SANITIZE_SPECIAL_CHARS);
            $taskid= filter_input(INPUT_POST, 'taskid', FILTER_SANITIZE_NUMBER_INT);
            
            $query = $pdo->prepare("UPDATE Client_Tasks set Assigned=:assigned where id =:id");
            $query->bindParam(':assigned', $assigned, PDO::PARAM_STR);
            $query->bindParam(':id', $taskid, PDO::PARAM_INT);
            $query->execute()or die(print_r($query->errorInfo(), true));
            if ($query->rowCount()>=1) { 
                
                        header('Location: ../Tasks/Tasks.php?taskassigned=y&assignto='.$assigned); die;

                        }
                
                if ($query->rowCount()<=0) { 
                    
                    header('Location: ../Tasks/Tasks.php?taskassigned=failed'); die;

                            }
                            
                        }
                        
if($EXECUTE==2) {

    $option= filter_input(INPUT_POST, 'Taskoption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $HappyPol= filter_input(INPUT_POST, 'HappyPol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $DocsArrived= filter_input(INPUT_POST, 'DocsArrived', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $CYDReturned= filter_input(INPUT_POST, 'CYDReturned', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $RemindDD= filter_input(INPUT_POST, 'RemindDD', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $PitchTPS= filter_input(INPUT_POST, 'PitchTPS', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $PitchTrust= filter_input(INPUT_POST, 'PitchTrust', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Upsells= filter_input(INPUT_POST, 'Upsells', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $CID= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $POST_ARRIVED = filter_input(INPUT_POST, 'PostArrived', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $POST_RETURNED = filter_input(INPUT_POST, 'PostReturned', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $SELECTquery = $pdo->prepare("SELECT Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks WHERE client_id=:CID");
    $SELECTquery->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECTquery->execute();
    $result=$SELECTquery->fetch(PDO::FETCH_ASSOC);
    
    $VAR_ONE=$result['Upsells'];
    $VAR_TWO=$result['PitchTrust'];
    $VAR_THREE=$result['PitchTPS'];
    $VAR_FOUR=$result['RemindDD'];
    $VAR_FIVE=$result['CYDReturned'];
    $VAR_SIX=$result['DocsArrived'];
    $VAR_SEVEN=$result['HappyPol'];
    
    $ORIGVAR_ONE=$result['Upsells'];
    $ORIGVAR_TWO=$result['PitchTrust'];
    $ORIGVAR_THREE=$result['PitchTPS'];
    $ORIGVAR_FOUR=$result['RemindDD'];
    $ORIGVAR_FIVE=$result['CYDReturned'];
    $ORIGVAR_SIX=$result['DocsArrived'];
    $ORIGVAR_SEVEN=$result['HappyPol'];
    
    if($VAR_ONE != $Upsells) {
        
        $VAR_ONE="| Upsells - $Upsells |";
        
    }
    
    else {
        
        unset($VAR_ONE);
        
    }
    
        if($VAR_TWO != $PitchTrust) {
            
            $VAR_TWO="|Pitch Trust - $PitchTrust |";
        
    }
    
    else {
        
        unset($VAR_TWO);
        
    }
    
        if($VAR_THREE != $PitchTPS) {
            
            $VAR_THREE="| Pitch TPS - $PitchTPS |";
        
    }
    
        else {
        
        unset($VAR_THREE);
        
    }
    
        if($VAR_FOUR != $RemindDD) {
            
            $VAR_FOUR="| Remind/Cancel Old/New DD - $RemindDD |";
        
    }
    
        else {
        
        unset($VAR_FOUR);
        
    }
    
        if($VAR_FIVE != $CYDReturned) {
            $VAR_FIVE="| CYD Returned? - $CYDReturned |";
            $CYDnotes=$VAR_FIVE;
            
        }
        else {
            unset($VAR_FIVE);            
            $CYDnotes="No changes";
            
        }
    
    
        if($VAR_SIX != $DocsArrived) {
            
            $VAR_SIX="| Docs Emailed? - $DocsArrived |";
        
    }
    
        else {
        
        unset($VAR_SIX);
        
    }
    
        if($VAR_SEVEN != $HappyPol) {
            
            $VAR_SEVEN= "| Happy with Policy - $HappyPol |";
        
    }
    
        else {
        
        unset($VAR_SEVEN);
        
    }

        $query = $pdo->prepare("UPDATE Client_Tasks set post_returned=:RETURN, post_arrived=:ARRIVED, Upsells=:Upsells, PitchTrust=:PitchTrust, PitchTPS=:PitchTPS, RemindDD=:RemindDD, CYDReturned=:CYDReturned, DocsArrived=:DocsArrived, HappyPol=:HappyPol WHERE client_id=:CID");
        $query->bindParam(':ARRIVED', $POST_ARRIVED, PDO::PARAM_STR);
        $query->bindParam(':RETURN', $POST_RETURNED, PDO::PARAM_STR);
        $query->bindParam(':HappyPol', $HappyPol, PDO::PARAM_STR);
        $query->bindParam(':DocsArrived', $DocsArrived, PDO::PARAM_STR);
        $query->bindParam(':CYDReturned', $CYDReturned, PDO::PARAM_STR);
        $query->bindParam(':RemindDD', $RemindDD, PDO::PARAM_STR);
        $query->bindParam(':PitchTPS', $PitchTPS, PDO::PARAM_STR);
        $query->bindParam(':PitchTrust', $PitchTrust, PDO::PARAM_STR);
        $query->bindParam(':Upsells', $Upsells, PDO::PARAM_STR);
        $query->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $query->execute();
        
    if($option=='24 48') {
    
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:CID AND Task IN('5 day','24 48','CYD')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();           
    }    
    
        if($option =='5 day') {
    
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:CID AND Task IN('5 day','24 48','CYD')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();    
        
    } 
        
   if($option !='5 day' || $option !='24 48') { 
        
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:CID AND Task=:Taskoption");        
        $complete->bindParam(':Taskoption', $option, PDO::PARAM_STR);
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();
        
   }
   
   if($CYDReturned=='Yes complete with Legal and General' || $CYDReturned=='Yes Legal and General not received' || $CYDReturned=='No') {
   
       $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:CID AND Task='CYD'");
       $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
       $complete->execute(); 
       
       if($CYDnotes!="No changes") {
       
        $notetypedata= "Task CYD";
        $recept="Task Updated";
                
        $noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:HELLO, note_type=:NOTE, message=:MSG ");
        $noteinsert->bindParam(':CID',$CID, PDO::PARAM_INT);
        $noteinsert->bindParam('HELLO',$hello_name, PDO::PARAM_STR, 100);
        $noteinsert->bindParam(':recipient',$recept, PDO::PARAM_STR, 500);
        $noteinsert->bindParam(':NOTE',$notetypedata, PDO::PARAM_STR, 255);
        $noteinsert->bindParam(':MSG',$CYDnotes, PDO::PARAM_STR, 2500);
        $noteinsert->execute();
        
   }
   
   }
        $notetypedata= "Task $option";
        $recept="Task Updated";
        
            if($ORIGVAR_ONE ==$Upsells && $ORIGVAR_TWO ==$PitchTrust && $ORIGVAR_THREE ==$PitchTPS && $ORIGVAR_FOUR ==$RemindDD && $ORIGVAR_FIVE ==$CYDReturned && $ORIGVAR_SIX ==$DocsArrived && $ORIGVAR_SEVEN ==$HappyPol) {
        
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
        
        $notes="$VAR_ONE $VAR_TWO $VAR_THREE $VAR_FOUR $VAR_FIVE $VAR_SIX $VAR_SEVEN";
        
    }
    
$noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:HELLO, note_type=:NOTE, message=:MSG ");
$noteinsert->bindParam(':CID',$CID, PDO::PARAM_INT);
$noteinsert->bindParam('HELLO',$hello_name, PDO::PARAM_STR, 100);
$noteinsert->bindParam(':recipient',$recept, PDO::PARAM_STR, 500);
$noteinsert->bindParam(':NOTE',$notetypedata, PDO::PARAM_STR, 255);
$noteinsert->bindParam(':MSG',$notes, PDO::PARAM_STR, 2500);
$noteinsert->execute();


      header('Location: ../Tasks/Tasks.php?REF='.$CID.'&TaskSelect='.$option); die;  

    }    
    
if($EXECUTE== 3 ) {
    
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $TASK_NAME= filter_input(INPUT_POST, 'TASK_NAME', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $LIFE_TASK_HAPPY= filter_input(INPUT_POST, 'LIFE_TASK_HAPPY', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $LIFE_TASK_EMAIL= filter_input(INPUT_POST, 'LIFE_TASK_EMAIL', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $LIFE_TASK_CANCEL= filter_input(INPUT_POST, 'LIFE_TASK_CANCEL', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $LIFE_TASK_FIRST= filter_input(INPUT_POST, 'LIFE_TASK_FIRST', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $LIFE_TASK_TPS= filter_input(INPUT_POST, 'LIFE_TASK_TPS', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $LIFE_TASK_TRUST= filter_input(INPUT_POST, 'LIFE_TASK_TRUST', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $SELECTquery = $pdo->prepare("SELECT 
    life_tasks_happy,
    life_tasks_email,
    life_tasks_dd,
    life_tasks_first_dd,
    life_tasks_trust,
    life_tasks_tps
FROM
    life_tasks
WHERE
    life_tasks_client_id=:CID");
    $SELECTquery->bindParam(':CID', $CID, PDO::PARAM_INT); 
    $SELECTquery->execute();
    $result=$SELECTquery->fetch(PDO::FETCH_ASSOC);
    
    $VAR_ONE=$result['life_tasks_happy'];
    $VAR_TWO=$result['life_tasks_email'];
    $VAR_THREE=$result['life_tasks_dd'];
    $VAR_FOUR=$result['life_tasks_first_dd'];
    $VAR_FIVE=$result['life_tasks_trust'];
    $VAR_SIX=$result['life_tasks_tps'];
    
    $ORIGVAR_ONE=$result['life_tasks_happy'];
    $ORIGVAR_TWO=$result['life_tasks_email'];
    $ORIGVAR_THREE=$result['life_tasks_dd'];
    $ORIGVAR_FOUR=$result['life_tasks_first_dd'];
    $ORIGVAR_FIVE=$result['life_tasks_trust'];
    $ORIGVAR_SIX=$result['life_tasks_tps'];
    
    if($VAR_ONE != $LIFE_TASK_HAPPY) {
        
        $VAR_ONE="| Happy with Policy - $LIFE_TASK_HAPPY |";
        
    }
    
    else {
        
        unset($VAR_ONE);
        
    }
    
        if($VAR_TWO != $LIFE_TASK_EMAIL) {
            
            $VAR_TWO="| Docs emailed - $LIFE_TASK_EMAIL |";
        
    }
    
    else {
        
        unset($VAR_TWO);
        
    }
    
        if($VAR_THREE != $LIFE_TASK_CANCEL) {
            
            $VAR_THREE="| Cancelled DDs - $LIFE_TASK_CANCEL |";
        
    }
    
        else {
        
        unset($VAR_THREE);
        
    }
    
        if($VAR_FOUR != $LIFE_TASK_FIRST) {
            
            $VAR_FOUR="| Confirm 1st DD - $LIFE_TASK_FIRST |";
        
    }
    
        else {
        
        unset($VAR_FOUR);
        
    }
    
        if($VAR_FIVE != $LIFE_TASK_TPS) {
            
            $VAR_FIVE="| Trust - $LIFE_TASK_TPS |";
        
    }
    
        else {
        
        unset($VAR_FIVE);
        
    }
    
        if($VAR_SIX != $LIFE_TASK_TRUST) {
            
            $VAR_SIX= "| TPS - $LIFE_TASK_TRUST |";
        
    }
    
        else {
        
        unset($VAR_SIX);
        
    }

        $query = $pdo->prepare("UPDATE 
            life_tasks 
        SET     
            life_tasks_happy=:HAPPY,
            life_tasks_email=:EMAIL,
            life_tasks_dd=:CANCEL,
            life_tasks_first_dd=:FIRST,
            life_tasks_trust=:TRUST,
            life_tasks_tps=:TPS
        WHERE 
            life_tasks_client_id=:CID");
        $query->bindParam(':HAPPY', $LIFE_TASK_HAPPY, PDO::PARAM_STR);
        $query->bindParam(':EMAIL', $LIFE_TASK_EMAIL, PDO::PARAM_STR);
        $query->bindParam(':CANCEL', $LIFE_TASK_CANCEL, PDO::PARAM_STR);
        $query->bindParam(':FIRST', $LIFE_TASK_FIRST, PDO::PARAM_STR);
        $query->bindParam(':TRUST', $LIFE_TASK_TPS, PDO::PARAM_STR);
        $query->bindParam(':TPS', $LIFE_TASK_TRUST, PDO::PARAM_STR);
        $query->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $query->execute();
        
    if($TASK_NAME=='48') {
    
        $complete = $pdo->prepare("UPDATE life_tasks SET life_tasks_complete='1' WHERE life_tasks_client_id=:CID AND life_tasks_task IN('7 day','48')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();           
    }    
    
        elseif($TASK_NAME =='7 day') {
    
        $complete = $pdo->prepare("UPDATE life_tasks set life_tasks_complete='1' WHERE life_tasks_client_id=:CID AND life_tasks_task IN('7 day','48')");
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();    
        
    } 
        
   else { 
        
        $complete = $pdo->prepare("UPDATE life_tasks set life_tasks_complete='1' WHERE life_tasks_client_id=:CID AND life_tasks_task=:Taskoption");        
        $complete->bindParam(':Taskoption', $TASK_NAME, PDO::PARAM_STR);
        $complete->bindParam(':CID', $CID, PDO::PARAM_INT); 
        $complete->execute();
        
   }
   
        $notetypedata= "Task $TASK_NAME";
        $recept="Task Updated";
        
            if($ORIGVAR_ONE == $LIFE_TASK_HAPPY 
                    && $ORIGVAR_TWO == $LIFE_TASK_EMAIL 
                    && $ORIGVAR_THREE == $LIFE_TASK_CANCEL 
                    && $ORIGVAR_FOUR == $LIFE_TASK_FIRST 
                    && $ORIGVAR_FIVE == $LIFE_TASK_TPS 
                    && $ORIGVAR_SIX == $LIFE_TASK_TRUST) {
        
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
        
        $notes="$VAR_ONE $VAR_TWO $VAR_THREE $VAR_FOUR $VAR_FIVE $VAR_SIX";
        
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