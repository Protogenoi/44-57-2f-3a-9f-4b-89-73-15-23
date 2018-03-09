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

require_once(__DIR__ . '/../../../includes/user_tracking.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$option= filter_input(INPUT_POST, 'Taskoption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($option)) {

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

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
      header('Location: ../Reports/Tasks.php?REF='.$CID.'&CLIENT_TASK='.$option); die;  
    }
} else {
 header('Location: /../../../../../app/Client.php?search='.$CID.'&CLIENT_TASK='.$option.'#menu4'); die;   
}
 
    }

         header('Location: /../../../../../CRMmain.php'); die; 
?>