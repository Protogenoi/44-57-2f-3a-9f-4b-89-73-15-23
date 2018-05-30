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
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/  

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$AUDITID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($AUDITID)) {

    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT
                            adl_audits_insurer
                        FROM 
                            adl_audits 
                        WHERE 
                            adl_audits_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_AUDIT=$database->single();  
    
        if(isset($VIT_AUDIT['adl_audits_insurer'])) {
        
        $INSUER=$VIT_AUDIT['adl_audits_insurer'];
        
    }
    
    if(isset($EXECUTE) && $EXECUTE == 'EDIT') {
    
    if(isset($INSUER)) {
        if($INSUER == 'Vitality') {
         header('Location: Vitality/edit_call_audit.php?AUDITID='.$AUDITID);
        die;           
        } elseif($INSUER == 'Royal London') {
         header('Location: RoyalLondon/edit_call_audit.php?AUDITID='.$AUDITID);
        die;           
        }
        elseif($INSUER == 'LV') {
         header('Location: LV/edit_call_audit.php?AUDITID='.$AUDITID);
        die;           
        } 
        elseif($INSUER == 'Zurich') {
         header('Location: Zurich/edit_call_audit.php?AUDITID='.$AUDITID);
        die;           
        }         
        elseif($INSUER == 'Lead') {
         header('Location: Agent/edit_call_audit.php?AUDITID='.$AUDITID);
        die;                
        }
    }
    
} elseif(isset($EXECUTE) && $EXECUTE == 'VIEW') {
    
    if(isset($INSUER)) {
        if($INSUER == 'Vitality') {
         header('Location: Vitality/view_call_audit.php?AUDITID='.$AUDITID);
        die;           
        } 
        elseif($INSUER == 'Royal London') {
         header('Location: RoyalLondon/view_call_audit.php?AUDITID='.$AUDITID);
        die;           
        }
        elseif($INSUER == 'LV') {
         header('Location: LV/view_call_audit.php?AUDITID='.$AUDITID);
        die;           
        }  
        elseif($INSUER == 'Zurich') {
         header('Location: Zurich/view_call_audit.php?AUDITID='.$AUDITID);
        die;           
        }          
        elseif($INSUER == 'Lead') {
         header('Location: Agent/view_call_audit.php?EXECUTE=1&AUDITID='.$AUDITID);
        die;                
        }
    }    
    
}
    
    
}

?>