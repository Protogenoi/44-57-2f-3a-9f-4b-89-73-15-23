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
    
$selectopt= filter_input(INPUT_POST, 'selectopt', FILTER_SANITIZE_SPECIAL_CHARS);
$WHICH_COMPANY= filter_input(INPUT_POST, 'SMS_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$CID= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);

$num= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$CLIENT_NAME= filter_input(INPUT_POST, 'FullName', FILTER_SANITIZE_SPECIAL_CHARS);
$SMS_MESSAGE= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$SMS_INSURER= filter_input(INPUT_POST, 'SMS_INSURER', FILTER_SANITIZE_SPECIAL_CHARS);
$MESSAGE_OPTION= filter_input(INPUT_POST, 'selectopt', FILTER_SANITIZE_SPECIAL_CHARS);

$INSURER_ARRAY=array("Legal and General","Aviva","One Family","Vitality","Royal London","Zurich","Scottish Widows");
$COMPANY_ARRAY=array("The Review Bureau","Bluestone Protect");

if(!in_array($WHICH_COMPANY, $COMPANY_ARRAY)) {
    header('Location: /../../../app/Client.php?search='.$CID); die;

}

if(!in_array($SMS_INSURER, $INSURER_ARRAY)) {
    header('Location: /../../../app/Client.php?search='.$CID); die;

}

if(!isset($MESSAGE_OPTION)) {
    $MESSAGE_OPTION=$SMS_MESSAGE;
}


if(isset($WHICH_COMPANY)) {
    
if($WHICH_COMPANY=="The Review Bureau" && $SMS_INSURER=='Legal and General') {
    $WHICH_COMPANY="The Review Bureau";
    
}
    
if($WHICH_COMPANY=="The Review Bureau" && $SMS_INSURER=='One Family') {
    $WHICH_COMPANY="TRB WOL";
    
}

if($WHICH_COMPANY=="The Review Bureau" && $SMS_INSURER=='Royal London') {
    $WHICH_COMPANY="TRB Royal London";
    
}

if($WHICH_COMPANY=="The Review Bureau" && $SMS_INSURER=='Vitality') {
    $WHICH_COMPANY="TRB Vitality";
    
}

if($WHICH_COMPANY=="The Review Bureau" && $SMS_INSURER=='Aviva') {
    $WHICH_COMPANY="TRB Aviva";
    
}    
    

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Legal and General') {
    $WHICH_COMPANY="Bluestone Protect";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='One Family') {
    $WHICH_COMPANY="One Family";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Royal London') {
    $WHICH_COMPANY="Royal London";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Vitality') {
    $WHICH_COMPANY="Vitality";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Zurich') {
    $WHICH_COMPANY="Zurich";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Scottish Widows') {
    $WHICH_COMPANY="Scottish Widows";
    
}

if($WHICH_COMPANY=="Bluestone Protect" && $SMS_INSURER=='Aviva') {
    $WHICH_COMPANY="Aviva";
    
}

}

if(isset($selectopt)) {

    $SMS_QRY = $pdo->prepare("SELECT twilio_account_sid, AES_DECRYPT(twilio_account_token, UNHEX(:key)) AS twilio_account_token FROM twilio_account");
    $SMS_QRY->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500); 
    $SMS_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $SMS_RESULT=$SMS_QRY->fetch(PDO::FETCH_ASSOC);
    
    $SID=$SMS_RESULT['twilio_account_sid'];
    $TOKEN=$SMS_RESULT['twilio_account_token'];

    $MES_QRY = $pdo->prepare("SELECT message FROM sms_templates WHERE title=:title and insurer=:SMS_INSURER AND company=:COMPANY");
    $MES_QRY->bindParam(':title', $selectopt, PDO::PARAM_STR, 100);
    $MES_QRY->bindParam(':SMS_INSURER', $SMS_INSURER, PDO::PARAM_STR, 100);
    $MES_QRY->bindParam(':COMPANY', $WHICH_COMPANY, PDO::PARAM_STR, 100);
    $MES_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $result=$MES_QRY->fetch(PDO::FETCH_ASSOC);    

    
    $SMS_MESSAGE=$result['message'];
    $countryCode = "+44";
    
 #   $NO_ZERO_CHK =strlen($num);
    
   # if($NO_ZERO_CHK < 11) {
  #      $num="0$num";
    #}
    
    $newNumber = preg_replace('/^0?/', ''.$countryCode, $num);
    
}

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {

    $SMS_QRY = $pdo->prepare("SELECT twilio_account_sid, AES_DECRYPT(twilio_account_token, UNHEX(:key)) AS twilio_account_token FROM twilio_account");
    $SMS_QRY->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500); 
    $SMS_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $SMS_RESULT=$SMS_QRY->fetch(PDO::FETCH_ASSOC);
    
    $SID=$SMS_RESULT['twilio_account_sid'];
    $TOKEN=$SMS_RESULT['twilio_account_token'];

    $countryCode = "+44";

    $newNumber = preg_replace('/^0?/', ''.$countryCode, $num);
    
}
}

require_once(__DIR__ . '/../../../resources/lib/twilio-php-master/Twilio/autoload.php');
use Twilio\Rest\Client;

$client = new Client($SID, $TOKEN);

$client->messages->create(
    "$newNumber",
    array(
        'from' => '+441792720471',
        'body' => "$SMS_MESSAGE",
        'statusCallback' => "https://review.adlcrm.com/app/SMS/Status.php?EXECUTE=1"
    )
);

if(isset($CID)) {
    
    $NOTE_OPTION="Sent SMS: $MESSAGE_OPTION";

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type=:REF, message=:MESSAGE ");
$INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
$INSERT->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':HOLDER',$CLIENT_NAME, PDO::PARAM_STR, 500);
$INSERT->bindParam(':REF',$NOTE_OPTION, PDO::PARAM_STR, 2500);
$INSERT->bindParam(':MESSAGE',$SMS_MESSAGE, PDO::PARAM_STR, 2500);
$INSERT->execute();

header('Location: /../../../../../app/Client.php?CLIENT_SMS=1&search='.$CID); die;

}
 header('Location: /../../../../../CRMmain.php'); die;    
    ?>