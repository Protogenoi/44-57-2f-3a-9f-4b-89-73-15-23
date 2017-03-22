<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
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

if(isset($selectopt)) {

include('../../includes/ADL_PDO_CON.php');

    $SMS_QRY = $pdo->prepare("SELECT twilio_account_sid, AES_DECRYPT(twilio_account_token, UNHEX(:key)) AS twilio_account_token FROM twilio_account");
    $SMS_QRY->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500); 
    $SMS_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $SMS_RESULT=$SMS_QRY->fetch(PDO::FETCH_ASSOC);
    
    $SID=$SMS_RESULT['twilio_account_sid'];
    $TOKEN=$SMS_RESULT['twilio_account_token'];
    

$num= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$FullName= filter_input(INPUT_POST, 'FullName', FILTER_SANITIZE_SPECIAL_CHARS);

    $MES_QRY = $pdo->prepare("SELECT message FROM sms_templates WHERE title=:title");
    $MES_QRY->bindParam(':title', $selectopt, PDO::PARAM_STR, 100);
    $MES_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $result=$MES_QRY->fetch(PDO::FETCH_ASSOC);    

    $SMS_MESSAGE=$result['message'];
    $countryCode = "+44";
    $newNumber = preg_replace('/^0?/', ''.$countryCode, $num);
    
}

require('../../twilio-php-master/Twilio/autoload.php');
use Twilio\Rest\Client;

$client = new Client($SID, $TOKEN);

$client->messages->create(
    "$newNumber",
    array(
        'from' => '+441792720471',
        'body' => "$SMS_MESSAGE",
        'statusCallback' => "https://dev.adlcrm.com/Life/SMS/Status.php?EXECUTE=1"
    )
);

$search= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);

if(isset($search)) {

$CLIENT_NAME= filter_input(INPUT_POST, 'FullName', FILTER_SANITIZE_SPECIAL_CHARS);
$MESSAGE_OPTION= filter_input(INPUT_POST, 'selectopt', FILTER_SANITIZE_SPECIAL_CHARS);

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:search, client_name=:recipientholder, sent_by=:sentbyholder, note_type='Sent SMS', message=:messageholder ");
$INSERT->bindParam(':search',$search, PDO::PARAM_INT);
$INSERT->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':recipientholder',$CLIENT_NAME, PDO::PARAM_STR, 500);
$INSERT->bindParam(':messageholder',$MESSAGE_OPTION, PDO::PARAM_STR, 2500);
$INSERT->execute();

header('Location: ../ViewClient.php?smssent=y&search='.$search); die;

}
 header('Location: ../../CRMmain.php?RETURN=ERROR'); die;    
    ?>