<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
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
        
        header('Location: /../../../../../../app/Client.php?search='.$client_id.'&CLIENT_EWS=1&CLIENT_POLICY_POL_NUM='.$policy_number); die;
    }
    
}

header('Location: /../../../../../../CRMmain.php'); die;
?>
