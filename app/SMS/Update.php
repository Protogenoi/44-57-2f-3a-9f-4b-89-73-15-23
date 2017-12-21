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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
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

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../../../CRMmain.php');
    die;
}

if(isset($ffsms) && $ffsms == 0) {
    
     header('Location: /../../../CRMmain.php');
    die;   
}
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
    $NID= filter_input(INPUT_GET, 'NID', FILTER_SANITIZE_SPECIAL_CHARS);
    $PHONE= filter_input(INPUT_GET, 'PHONE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
    $TYPE= filter_input(INPUT_GET, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
            if(isset($NID)) {
                
                $MESSAGE="Viewed $TYPE for $PHONE";
                    
                            $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:PHONE, sent_by=:hello, note_type='SMS Update', message=:MSG");
                            $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $INSERT->bindParam(':hello',$hello_name, PDO::PARAM_STR);
                            $INSERT->bindParam(':MSG',$MESSAGE, PDO::PARAM_STR);
                            $INSERT->bindParam(':PHONE',$PHONE, PDO::PARAM_STR);
                            $INSERT->execute();

                          $SMS_DELETE = $pdo->prepare("DELETE FROM sms_inbound WHERE sms_inbound_id=:NID LIMIT 1");
                          $SMS_DELETE->bindParam(':NID',$NID, PDO::PARAM_INT);
                          $SMS_DELETE->execute();                            
                           
                          header('Location: ../Client.php?search='.$CID); die;
                          
                        }
    }

    }         
        
?>