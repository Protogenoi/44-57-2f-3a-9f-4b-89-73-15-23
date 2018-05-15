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
            if ($data[0] != 'Agency Number') {
            
$AGENCY_NUMBER=$data[0];
$AGENCY_NAME=$data[1];
$FCA_NUMBER=$data[2];
$TYPE=$data[3];
$RI_NAME=$data[4];
$BENEFIT_NAME=$data[5];
$COMMISSION_TYPE=$data[6];
$TRANSACTION_TYPE=$data[7];
$POLICY_NUMBER=filter_var($data[8], FILTER_SANITIZE_NUMBER_INT);
$LICENSE_INDICATOR=$data[9];
$POLICY_DOC = $data[11];
$POLICY_DOC_NEW= Datetime::createFromFormat('d/m/Y', $POLICY_DOC)->format('Y-m-d');

$LIFE_ASSURED_NAME=$data[12];
$AMOUNT=$data[13];
$BENEFIT_PREMIUM=$data[14];

$SETTLEMENT_DATE = $data[15];
$SETTLEMENT_DATE_NEW= Datetime::createFromFormat('d/m/Y', $SETTLEMENT_DATE)->format('Y-m-d');

$SETTLEMENT_REFERENCE_NUMBER=$data[16];

$POLICY_NUMBER_NEW = "%$POLICY_NUMBER%";

if ($AMOUNT > 0) {
    $POLICY_STATUS="Live";
    
} elseif ($AMOUNT < 0) {
    $POLICY_STATUS="Clawback";
    }
     
    $query = $pdo->prepare("SELECT
            adl_policy_id, 
            adl_policy_client_id_fk, 
            adl_policy_ref, 
            adl_policy_status 
        FROM 
            adl_policy 
        WHERE 
            adl_policy_ref like :POL");
    $query->bindParam(':POL', $POLICY_NUMBER_NEW, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    
    if ($query->rowCount() >= 1) { //IF THERES A MATCH ELSE GO TO NO MATCH
    
    $clientid=$result['adl_policy_client_id_fk'];
    $polid=$result['adl_policy_id'];
    $policynumber=$result['adl_policy_ref'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['adl_policy_status'];
     
    $note="Vitality Financial Uploaded";
    $message="COMM (Status changed from $polstat to $POLICY_STATUS)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE adl_policy set adl_policy_status=:STATUS, edited=:sent WHERE adl_policy_id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':STATUS', $POLICY_STATUS, PDO::PARAM_STR);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
                 
        
}

if ($query->rowCount() <= 0) { // NO MATCH
    
    $query = $pdo->prepare("SELECT id FROM client_policy where policy_number like :POL");
    $query->bindParam(':POL', $POLICY_NUMBER_NEW, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    
    if ($query->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO
            vitality_financial_nomatch 
        SET 
            vitality_financial_nomatch_amount=:pay, 
            vitality_financial_nomatch_policy_number=:pol, 
            vitality_financial_nomatch_uploader=:hello");
    $insert->bindParam(':pay', $AMOUNT, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $POLICY_NUMBER, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
    
}

    }

        $VIT_INSERT = $pdo->prepare("INSERT INTO
                                        vitality_financial
                                    SET 
                                        vitality_financial_agency_number=:AGENCY_NUMBER,  
                                        vitality_financial_agency_name=:AGENCY_NAME,  
                                        vitality_financial_fca_number=:FCA_NUMBER,  
                                        vitality_financial_type=:TYPE,  
                                        vitality_financial_ri_name=:RI_NAME,  
                                        vitality_financial_benefit_name=:BENEFIT_NAME,  
                                        vitality_financial_commission_type=:COMMISSON_TYPE,  
                                        vitality_financial_transaction_type=:TRANSACTION_TYPE,  
                                        vitality_financial_policy_number=:POLICY_NUMBER,  
                                        vitality_financial_license_indicator=:LICENSE_INDICATOR,  
                                        vitality_financial_policy_doc=:POLICY_DOC,  
                                        vitality_financial_life_assured_name=:LIFE_ASSURED_NAME,  
                                        vitality_financial_amount=:AMOUNT,  
                                        vitality_financial_benefit_premium=:BENEFIT_PREMIUM,  
                                        vitality_financial_settlement_date=:SETTLEMENT_DATE,  
                                        vitality_financial_settlement_reference_number=:SETTLEMENT_REFERENCE_NUMBER, 
                                        vitality_financial_uploader=:UPLOADER");
        $VIT_INSERT->bindParam(':AGENCY_NUMBER', $AGENCY_NUMBER , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':AGENCY_NAME', $AGENCY_NAME , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':FCA_NUMBER', $FCA_NUMBER , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':TYPE', $TYPE , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':RI_NAME', $RI_NAME , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':BENEFIT_NAME', $BENEFIT_NAME , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':COMMISSON_TYPE', $COMMISSION_TYPE , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':TRANSACTION_TYPE', $TRANSACTION_TYPE , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':POLICY_NUMBER', $POLICY_NUMBER , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':LICENSE_INDICATOR', $LICENSE_INDICATOR , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':POLICY_DOC', $POLICY_DOC_NEW , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':LIFE_ASSURED_NAME', $LIFE_ASSURED_NAME , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':AMOUNT', $AMOUNT , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':BENEFIT_PREMIUM', $BENEFIT_PREMIUM , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':SETTLEMENT_DATE', $SETTLEMENT_DATE_NEW , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':SETTLEMENT_REFERENCE_NUMBER', $SETTLEMENT_REFERENCE_NUMBER , PDO::PARAM_STR);
        $VIT_INSERT->bindParam(':UPLOADER', $hello_name , PDO::PARAM_STR, 50);
        $VIT_INSERT->execute();
      
        }
    }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../../../../addon/Life/Financials/FinancialUploads.php?success=1&FiancialType=Vitality'); die;
}    
    
    
}

}
?>