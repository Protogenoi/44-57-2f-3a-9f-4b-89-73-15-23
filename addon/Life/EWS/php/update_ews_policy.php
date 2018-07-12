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

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

include (BASE_URL."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(BASE_URL.'/includes/adl_features.php');

require_once(BASE_URL.'/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(BASE_URL.'/includes/user_tracking.php'); 
require_once(BASE_URL.'/includes/Access_Levels.php');

require_once(BASE_URL.'/includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
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
        $POLICY= filter_input(INPUT_POST, 'POLICY', FILTER_SANITIZE_SPECIAL_CHARS);
        $NAME= filter_input(INPUT_POST, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);
        $EWS_NOTES= filter_input(INPUT_POST, '$EWS_NOTES', FILTER_SANITIZE_SPECIAL_CHARS);        
        $NEW_STATUS= filter_input(INPUT_POST, 'NEW_STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
        $COLOUR= filter_input(INPUT_POST, 'COLOUR', FILTER_SANITIZE_SPECIAL_CHARS);        
        $ORIG_STATUS= filter_input(INPUT_POST, 'ORIG_STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $AEID= filter_input(INPUT_POST, 'AEID', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $NOTE="EWS Status update";
        $MESSAGE="$warning changed to $NEW_STATUS ($COLOUR) - $EWS_NOTES";
        
        $qnotes = $pdo->prepare("INSERT INTO
                                            client_note
                                        SET 
                                            client_id=:CID, 
                                            client_name=:POLICY, 
                                            sent_by=:SENT, 
                                            note_type=:NOTE, 
                                            message=:MESSAGE");
        $qnotes->bindParam(':CID',$CID, PDO::PARAM_INT);
        $qnotes->bindParam(':SENT',$hello_name, PDO::PARAM_STR);
        $qnotes->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
        $qnotes->bindParam(':NOTE',$NOTE, PDO::PARAM_STR);
        $qnotes->bindParam(':MESSAGE',$MESSAGE, PDO::PARAM_STR);
        $qnotes->execute()or die(print_r($qnotes->errorInfo(), true));

        $qews = $pdo->prepare("UPDATE
                                    adl_ews
                                SET     
                                    adl_ews_status=:STATUS, 
                                    adl_ews_notes=:NOTES, 
                                    adl_ews_colour=:COLOUR,
                                    adl_ews_updated_by=:HELLO,
                                    adl_ews_updated_date = CURRENT_TIMESTAMP
                                WHERE 
                                    adl_policy_id=:AEID");
        $qews->bindParam(':STATUS',$NEW_STATUS, PDO::PARAM_STR);
        $qews->bindParam(':NOTES',$EWS_NOTES, PDO::PARAM_STR);
        $qews->bindParam(':COLOUR',$COLOUR, PDO::PARAM_STR);
        $qews->bindParam(':AEID',$AEID, PDO::PARAM_STR);
        $qews->bindParam(':HELLO',$hello_name, PDO::PARAM_STR);
        $qews->execute()or die(print_r($qews->errorInfo(), true));
        
        header('Location: /../../../../../../app/Client.php?search='.$CID.'&CLIENT_EWS=1&CLIENT_POLICY_POL_NUM='.$POLICY); die;
    }
    
}

header('Location: /../../../../../../CRMmain.php'); die;