<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
include('../../includes/ADL_PDO_CON.php');

$addsms= filter_input(INPUT_GET, 'addsms', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($addsms)) {

$provider= filter_input(INPUT_GET, 'provider', FILTER_SANITIZE_SPECIAL_CHARS);
$smsusername= filter_input(INPUT_POST, 'smsusername', FILTER_SANITIZE_SPECIAL_CHARS);
$smspassword= filter_input(INPUT_POST, 'smspassword', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($provider)){

    if($provider=='Twilio') {
       //select original encrpted password see if theres a match. If it is do nothing else encrpted new password 
        $SID= filter_input(INPUT_POST, 'SID', FILTER_SANITIZE_SPECIAL_CHARS);
        $TOKEN= filter_input(INPUT_POST, 'TOKEN', FILTER_SANITIZE_SPECIAL_CHARS);
        
    $query = $pdo->prepare("INSERT INTO twilio_account set twilio_account_updated_by=:hello, twilio_account_sid=:SID, twilio_account_token=AES_ENCRYPT(:TOKEN, UNHEX(:key))");
    $query->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500);
    $query->bindParam(':SID', $SID, PDO::PARAM_STR, 100);
    $query->bindParam(':TOKEN', $TOKEN, PDO::PARAM_STR, 500);
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    if(isset($fferror)) {
        if($fferror=='0') {
            header('Location: ../Admindash.php?smsaccount=y&SMS=y'); die;
            
        }
        
        }     
        
        }
        
        if($provider=='BulkSMS') {
            
            $query = $pdo->prepare("INSERT INTO sms_accounts set submitter=:hello, smsprovider='Bulk SMS', smsusername=:user, smspassword=AES_ENCRYPT(:pass, UNHEX(:key))");
            $query->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500);
            $query->bindParam(':user', $smsusername, PDO::PARAM_STR, 100);
            $query->bindParam(':pass', $smspassword, PDO::PARAM_STR, 500);
            $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);     
            $query->execute()or die(print_r($query->errorInfo(), true));
            
            if(isset($fferror)) {
                if($fferror=='0') {
                    header('Location: ../Admindash.php?smsaccount=y&SMS=y'); die;
                    }
                    
                }
                
                } 
                
                }
                
                }

$newsmsmessagevar= filter_input(INPUT_GET, 'newsmsmessage', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($newsmsmessagevar)) {

$smsmessagevar= filter_input(INPUT_POST, 'smsmessage', FILTER_SANITIZE_SPECIAL_CHARS);
$smstitle= filter_input(INPUT_POST, 'smstitle', FILTER_SANITIZE_SPECIAL_CHARS);
$insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = $pdo->prepare("INSERT INTO sms_templates set title=:title, insurer=:insurer, message=:message");
    $query->bindParam(':insurer', $insurer, PDO::PARAM_STR, 500);
        $query->bindParam(':title', $smstitle, PDO::PARAM_STR, 500);
        $query->bindParam(':message', $smsmessagevar, PDO::PARAM_STR, 500);
        
        $query->execute()or die(print_r($query->errorInfo(), true));
                            if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../Admindash.php?smsaccount=messadded&SMS=y'); die;
    }
                            }
}

else {
    if(isset($fferror)) {
        if($fferror=='0') {
            header('Location: ../Admindash.php?smsaccount=failed&SMS=y'); die;
            
        }
        
        }
        
        }