<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
$selectopt= filter_input(INPUT_POST, 'selectopt', FILTER_SANITIZE_SPECIAL_CHARS);
$WHICH_COMPANY= filter_input(INPUT_GET, 'WHICH_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);

$num= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$CLIENT_NAME= filter_input(INPUT_POST, 'FullName', FILTER_SANITIZE_SPECIAL_CHARS);
$SMS_MESSAGE= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$SMS_INSURER= filter_input(INPUT_POST, 'SMS_INSURER', FILTER_SANITIZE_SPECIAL_CHARS);
$MESSAGE_OPTION= filter_input(INPUT_POST, 'selectopt', FILTER_SANITIZE_SPECIAL_CHARS);

if(!isset($MESSAGE_OPTION)) {
    $MESSAGE_OPTION=$SMS_MESSAGE;
}

if(isset($selectopt)) {

include('../../includes/ADL_PDO_CON.php');

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

include('../../includes/ADL_PDO_CON.php');

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

require('../../twilio-php-master/Twilio/autoload.php');
use Twilio\Rest\Client;

$client = new Client($SID, $TOKEN);

$client->messages->create(
    "$newNumber",
    array(
        'from' => '+441792720471',
        'body' => "$SMS_MESSAGE",
        'statusCallback' => "https://review.adlcrm.com/Life/SMS/Status.php?EXECUTE=1"
    )
);



if(isset($search)) {
    
    $NOTE_OPTION="Sent SMS: $MESSAGE_OPTION";

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:search, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:REF, message=:MESSAGE ");
$INSERT->bindParam(':search',$search, PDO::PARAM_INT);
$INSERT->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':recipientholder',$CLIENT_NAME, PDO::PARAM_STR, 500);
$INSERT->bindParam(':REF',$NOTE_OPTION, PDO::PARAM_STR, 2500);
$INSERT->bindParam(':MESSAGE',$SMS_MESSAGE, PDO::PARAM_STR, 2500);
$INSERT->execute();

header('Location: ../ViewClient.php?smssent=y&search='.$search); die;

}
 header('Location: ../../CRMmain.php?RETURN=ERROR'); die;    
    ?>