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
    if($EXECUTE=='10') {

    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if (isset($data[0])) {
            if ($data[0] != 'IFA ID' && !empty($data[0])) {
            
$IFA_ID= filter_var($data[0], FILTER_SANITIZE_NUMBER_INT);
$IFA_NAME=filter_var($data[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$ASSIGNED_REP_ID=filter_var($data[2], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$ASSIGNED_REP_NAME=filter_var($data[3], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$PLAN_NUMBER= filter_var($data[4], FILTER_SANITIZE_NUMBER_INT);
$PLAN_OWNER=filter_var($data[5], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$REFERENCE=filter_var($data[6], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$PREMIUM=str_replace("£","",$data[7]);
$FREQUENCY=filter_var($data[8], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$DUE_DATE = $data[9];

echo "3) $data[3]<br>";
echo "8) $data[8]<br>";
echo "9) $data[9]";

$DUE_DATE_NEW= Datetime::createFromFormat('d/m/Y', $DUE_DATE)->format('Y-m-d');

$CREDIT=str_replace("£","",$data[10]);

$TYPE=filter_var($data[11], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$DEBIT=str_replace("£","",$data[12]);
$REASON=filter_var($data[13], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$PAID_DATE = $data[14];

$PAID_DATE_NEW= Datetime::createFromFormat('d/m/Y', $PAID_DATE)->format('Y-m-d');

$PLAN_NUMBER_NEW = "%$PLAN_NUMBER%";

if ($CREDIT > 0) {
    $POLICY_STATUS="Live";
    
} if ($DEBIT > 0) {
    $POLICY_STATUS="Clawback";
    }
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :POL");
    $query->bindParam(':POL', $PLAN_NUMBER_NEW, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    
    if ($query->rowCount() >= 1) { //IF THERES A MATCH ELSE GO TO NO MATCH
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Royal London Financial Uploaded";
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
            royal_london_financial_nomatch
        SET 
            royal_london_financial_nomatch_commission_credit_amount=:CREDIT,
            royal_london_financial_nomatch_commission_DEBITS_amount=:DEBIT,
            royal_london_financial_nomatch_plan_number=:pol, 
            royal_london_financial_nomatch_uploader=:hello
            ");
    $insert->bindParam(':CREDIT', $CREDIT, PDO::PARAM_INT);
    $insert->bindParam(':DEBIT', $DEBIT, PDO::PARAM_INT);
    $insert->bindParam(':pol', $PLAN_NUMBER, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
    
}

        $VIT_INSERT = $pdo->prepare("INSERT INTO
                                        royal_london_financial
                                    SET 
                                        royal_london_financial_ifa_id=:IFA_ID,  
                                        royal_london_financial_ifa_name=:IFA_NAME,  
                                        royal_london_financial_assigned_rep_id=:REP_ID,  
                                        royal_london_financial_assigned_rep_name=:REP_NAME,  
                                        royal_london_financial_plan_number=:PLAN,  
                                        royal_london_financial_plan_owner=:OWNER,  
                                        royal_london_financial_reference=:REF,  
                                        royal_london_financial_premium_amount=:PREM,  
                                        royal_london_financial_frequency=:FREQ,  
                                        royal_london_financial_due_date=:DUE_DATE,  
                                        royal_london_financial_commission_credit_amount=:CREDIT,  
                                        royal_london_financial_commission_type=:TYPE,  
                                        royal_london_financial_commission_debits_amount=:DEBITS,  
                                        royal_london_financial_commission_debits_reason=:REASON,  
                                        royal_london_financial_paid_date=:PAID_DATE,  
                                        royal_london_financial_uploaded_by=:UPLOADER
                                        ");
        $VIT_INSERT->bindParam(':IFA_ID', $IFA_ID , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':IFA_NAME', $IFA_NAME , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':REP_ID', $ASSIGNED_REP_ID , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':REP_NAME', $ASSIGNED_REP_NAME , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':PLAN', $PLAN_NUMBER , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':OWNER', $PLAN_OWNER , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':REF', $REFERENCE , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':PREM', $PREMIUM , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':FREQ', $FREQUENCY , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':DUE_DATE', $DUE_DATE_NEW , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':CREDIT', $CREDIT , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':TYPE', $TYPE , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':DEBITS', $DEBIT , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':REASON', $REASON , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':PAID_DATE', $PAID_DATE_NEW , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':UPLOADER', $hello_name , PDO::PARAM_STR);
        $VIT_INSERT->execute();
      
        }
    }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../../../../addon/Life/Financials/upload_raw.php?success=1&FiancialType=Royal London'); die;
}    
      
}

}
?>