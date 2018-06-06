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

require_once(__DIR__ . '/../../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php'); 

require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
if($EXECUTE=='1') {

    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if (isset($data[0])) {
            
$POLICY= filter_var($data[0], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$CLIENT=filter_var($data[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$PRODUCT_TYPE=filter_var($data[2], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$DUE_LASPED_DATE = $data[3];
$DUE_DATE_NEW= Datetime::createFromFormat('d/m/y', $DUE_LASPED_DATE)->format('Y-m-d');
$PREMIUM= filter_var($data[4], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$FREQ=filter_var($data[5], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TYPE=filter_var($data[6], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$AMOUNT=filter_var($data[7], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$COMMENT=filter_var($data[8], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($AMOUNT > 0) {
    $POLICY_STATUS="Live";
    
} if ($AMOUNT <= 0) {
    $POLICY_STATUS="Clawback";
    }
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :POL");
    $query->bindParam(':POL', $POLICY, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    
    if ($query->rowCount() >= 1) { //IF THERES A MATCH ELSE GO TO NO MATCH
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Aviva Financial Uploaded";
    $message="COMM (Status changed from $polstat to $POLICY_STATUS)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus=:STATUS, edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':STATUS', $POLICY_STATUS, PDO::PARAM_STR);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
                 
        
}

if ($query->rowCount() <= 0) { // NO MATCH

   $insert = $pdo->prepare("
        INSERT INTO 
            aviva_financial_nomatch
        SET 
            aviva_financial_nomatch_amount=:AMOUNT,
            aviva_financial_nomatch_policy=:pol, 
            aviva_financial_nomatch_uploader=:hello
            ");
    $insert->bindParam(':AMOUNT', $AMOUNT, PDO::PARAM_INT);
    $insert->bindParam(':pol', $POLICY, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
    
}

        $VIT_INSERT = $pdo->prepare("INSERT INTO
                                        aviva_financial
                                    SET 
aviva_financial_policy=:POLICY, 
aviva_financial_client_name=:NAME, 
aviva_financial_product_type=:PRODCUT_TYPE, 
aviva_financial_due_lapsed_date=:DATE, 
aviva_financial_premium=:PREMIUM, 
aviva_financial_freq=:FREQ, 
aviva_financial_type=:TYPE, 
aviva_financial_amount=:AMOUNT, 
aviva_financial_comment=:COMMENT, 
aviva_financial_uploader=:UPLOADER");
        $VIT_INSERT->bindParam(':POLICY', $POLICY , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':NAME', $CLIENT , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':PRODCUT_TYPE', $PRODUCT_TYPE , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':DATE', $DUE_LASPED_DATE , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':PREMIUM', $PREMIUM , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':FREQ', $FREQ , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':TYPE', $TYPE , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':AMOUNT', $AMOUNT , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':COMMENT', $COMMENT , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':UPLOADER', $hello_name , PDO::PARAM_STR);
        $VIT_INSERT->execute();
      
    }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../../../../addon/Life/Financials/upload_raw.php?success=1&FiancialType=Aviva'); die;
}    
      
}

}
?>