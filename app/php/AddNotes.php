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

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/adl_features.php');

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
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
        
        $CID= filter_input(INPUT_POST, 'CID', FILTER_SANITIZE_NUMBER_INT);
        $RECIPIENT= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $NOTES= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Client Note', message=:MSG");
        $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
        $INSERT->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
        $INSERT->bindParam(':HOLDER',$RECIPIENT, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':MSG',$NOTES, PDO::PARAM_STR, 2500);
        $INSERT->execute();

        header('Location: ../Client.php?CLIENT_NOTE=ADDED&search='.$CID.'#menu4'); die;

    }
    
    }

header('Location: /../../../CRMmain.php?Clientadded=failed'); die;