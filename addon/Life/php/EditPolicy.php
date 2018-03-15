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

$search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$callbackcompletedid = filter_input(INPUT_POST, 'callbackid', FILTER_SANITIZE_NUMBER_INT);

$policyunid = filter_input(INPUT_POST, 'policyunid', FILTER_SANITIZE_SPECIAL_CHARS);
$NAME = filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$SALE_DATE = filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
$APP_NUM = filter_input(INPUT_POST, 'application_number', FILTER_SANITIZE_SPECIAL_CHARS);
$policy_number = filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
$premium = filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$INSURER = filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
$commission = filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
$CommissionType = filter_input(INPUT_POST, 'CommissionType', FILTER_SANITIZE_SPECIAL_CHARS);
$POLICY_STATUS = filter_input(INPUT_POST, 'PolicyStatus', FILTER_SANITIZE_SPECIAL_CHARS);
$edited = filter_input(INPUT_POST, 'edited', FILTER_SANITIZE_SPECIAL_CHARS);
$CID = filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_SPECIAL_CHARS);
$policyID = filter_input(INPUT_POST, 'policyID', FILTER_SANITIZE_SPECIAL_CHARS);
$comm_term = filter_input(INPUT_POST, 'comm_term', FILTER_SANITIZE_SPECIAL_CHARS);
$drip = filter_input(INPUT_POST, 'drip', FILTER_SANITIZE_SPECIAL_CHARS);
$soj = filter_input(INPUT_POST, 'soj', FILTER_SANITIZE_SPECIAL_CHARS);
$CLOSER = filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$LEAD = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$covera = filter_input(INPUT_POST, 'covera', FILTER_SANITIZE_SPECIAL_CHARS);
$polterm = filter_input(INPUT_POST, 'polterm', FILTER_SANITIZE_SPECIAL_CHARS);

$EXTRA_CHARGE = filter_input(INPUT_POST, 'EXTRA_CHARGE', FILTER_SANITIZE_SPECIAL_CHARS);
$NonIdem = filter_input(INPUT_POST, 'NonIdem', FILTER_SANITIZE_SPECIAL_CHARS);

$submitted_date = filter_input(INPUT_POST, 'submitted_date', FILTER_SANITIZE_SPECIAL_CHARS);

if(strpos($NAME, ' and ') !== false) {
    $soj="Joint";
} else {
    $soj="Single";
}

if ($POLICY_STATUS == "Awaiting") {
    $SALE_DATE = "TBC";
    $policy_number = "TBC $policyunid";
}

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol AND client_id !=:id");
$dupeck->bindParam(':pol', $policy_number, PDO::PARAM_STR);
$dupeck->bindParam(':id', $search, PDO::PARAM_STR);
$dupeck->execute();
$row = $dupeck->fetch(PDO::FETCH_ASSOC);

if ($count = $dupeck->rowCount() >= 1) {
    $dupepol = "$row[policy_number] DUPE";

    $query = $pdo->prepare("SELECT policy_number AS orig_policy, policystatus FROM client_policy WHERE id=:OCID");
    $query->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
    $query->execute();
    $origdetails = $query->fetch(PDO::FETCH_ASSOC);

    $oname = $origdetails['orig_policy'];
    
    $ORIG_POLICY_STATUS = $origdetails['policystatus'];

    $update = $pdo->prepare("UPDATE client_policy SET non_indem_com=:NONIDEM, extra_charge=:CHARGE, submitted_date=:sub, covera=:covera, soj=:soj, client_name=:client_name, sale_date=:sale_date, application_number=:application_number, policy_number=:policy_number, premium=:premium, type=:type, insurer=:insurer, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, edited=:edited, comm_term=:comm_term, drip=:drip, closer=:closer, lead=:lead, polterm=:polterm WHERE id=:OCID");
    $update->bindParam(':NONIDEM', $NonIdem, PDO::PARAM_INT);
    $update->bindParam(':CHARGE', $EXTRA_CHARGE, PDO::PARAM_INT);
    $update->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
    $update->bindParam(':covera', $covera, PDO::PARAM_INT);
    $update->bindParam(':sub', $submitted_date, PDO::PARAM_STR);
    $update->bindParam(':soj', $soj, PDO::PARAM_STR);
    $update->bindParam(':client_name', $NAME, PDO::PARAM_STR);
    $update->bindParam(':sale_date', $SALE_DATE, PDO::PARAM_STR);
    $update->bindParam(':application_number', $APP_NUM, PDO::PARAM_STR);
    $update->bindParam(':policy_number', $dupepol, PDO::PARAM_STR);
    $update->bindParam(':premium', $premium, PDO::PARAM_INT);
    $update->bindParam(':type', $type, PDO::PARAM_STR);
    $update->bindParam(':insurer', $INSURER, PDO::PARAM_STR);
    $update->bindParam(':commission', $commission, PDO::PARAM_INT);
    $update->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
    $update->bindParam(':PolicyStatus', $POLICY_STATUS, PDO::PARAM_STR);
    $update->bindParam(':edited', $hello_name, PDO::PARAM_STR);
    $update->bindParam(':comm_term', $comm_term, PDO::PARAM_INT);
    $update->bindParam(':drip', $drip, PDO::PARAM_INT);
    $update->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
    $update->bindParam(':lead', $LEAD, PDO::PARAM_STR);
    $update->bindParam(':polterm', $polterm, PDO::PARAM_STR);
    $update->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
    $update->execute();
    
if($ORIG_POLICY_STATUS == 'On Hold' && $POLICY_STATUS != $ORIG_POLICY_STATUS) {
    
    
        $database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount() <=0 ) {
            
        if(isset($INSURER) && $INSURER == 'Vitality') {
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_vitality_workflows.php');     
            
        }   else {            
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_workflows.php'); 
        
        }
                            
        } 
        
        $database->endTransaction();     
    
} if($POLICY_STATUS == 'On Hold' && $ORIG_POLICY_STATUS != $POLICY_STATUS) {
    
        $database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount() >= 1 ) {

        $database->query("DELETE FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        $notedata= "All Workflows and Tasks have been deleted (Policy $POLICY_STATUS)!";
        $REF= "CRM Alert";
        $messagedata="All workflows and tasks have been removed from this client";
                
        $database->query("INSERT INTO client_note SET client_id=:CID, client_name=:recipientholder, sent_by='ADL', note_type=:NOTE, message=:MSG ");
        $database->bind(':CID',$CID);
        $database->bind(':recipientholder',$REF);
        $database->bind(':NOTE',$notedata);
        $database->bind(':MSG',$messagedata);
        $database->execute();          
                            
        } 
        
        $database->endTransaction();      
    
}    

    $clientnamedata2 = $NAME;

    $queryTRKn = $pdo->prepare("INSERT INTO policy_number_tracking set new_policy_number=:newpolicyholder, policy_id =:origpolicyid, oldpolicy=:oldpolicyholder ");
    $queryTRKn->bindParam(':newpolicyholder', $policy_number, PDO::PARAM_STR, 500);
    $queryTRKn->bindParam(':oldpolicyholder', $oname, PDO::PARAM_STR, 500);
    $queryTRKn->bindParam(':origpolicyid', $policyunid, PDO::PARAM_STR, 500);
    $queryTRKn->execute();

    $notedata = "Policy Number Updated";
    $messagedata = "Policy number updated $dupepol duplicate of $policy_number";

    $queryNote = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type=:NOTE, message=:MSG ");
    $queryNote->bindParam(':CID', $CID, PDO::PARAM_INT);
    $queryNote->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
    $queryNote->bindParam(':HOLDER', $NAME, PDO::PARAM_STR, 500);
    $queryNote->bindParam(':NOTE', $notedata, PDO::PARAM_STR, 255);
    $queryNote->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
    $queryNote->execute();

            header('Location: /../../../../../../app/Client.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $policy_number);
            die;
            
}

$query = $pdo->prepare("SELECT policy_number AS orig_policy, policystatus FROM client_policy WHERE id=:OCID");
$query->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
$query->execute();
$origdetails = $query->fetch(PDO::FETCH_ASSOC);

$oname = $origdetails['orig_policy'];

$ORIG_POLICY_STATUS = $origdetails['policystatus'];

$update = $pdo->prepare("UPDATE client_policy SET non_indem_com=:NONIDEM, extra_charge=:CHARGE, submitted_date=:sub, covera=:covera, soj=:soj, client_name=:client_name, sale_date=:sale_date, application_number=:application_number, policy_number=:policy_number, premium=:premium, type=:type, insurer=:insurer, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, edited=:edited, comm_term=:comm_term, drip=:drip, closer=:closer, lead=:lead, polterm=:polterm WHERE id=:OCID");
$update->bindParam(':NONIDEM', $NonIdem, PDO::PARAM_INT);
$update->bindParam(':CHARGE', $EXTRA_CHARGE, PDO::PARAM_INT);
$update->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
$update->bindParam(':covera', $covera, PDO::PARAM_INT);
$update->bindParam(':soj', $soj, PDO::PARAM_STR);
$update->bindParam(':sub', $submitted_date, PDO::PARAM_STR);
$update->bindParam(':client_name', $NAME, PDO::PARAM_STR);
$update->bindParam(':sale_date', $SALE_DATE, PDO::PARAM_STR);
$update->bindParam(':application_number', $APP_NUM, PDO::PARAM_STR);
$update->bindParam(':policy_number', $policy_number, PDO::PARAM_STR);
$update->bindParam(':premium', $premium, PDO::PARAM_INT);
$update->bindParam(':type', $type, PDO::PARAM_STR);
$update->bindParam(':insurer', $INSURER, PDO::PARAM_STR);
$update->bindParam(':commission', $commission, PDO::PARAM_INT);
$update->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
$update->bindParam(':PolicyStatus', $POLICY_STATUS, PDO::PARAM_STR);
$update->bindParam(':edited', $hello_name, PDO::PARAM_STR);
$update->bindParam(':comm_term', $comm_term, PDO::PARAM_INT);
$update->bindParam(':drip', $drip, PDO::PARAM_INT);
$update->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
$update->bindParam(':lead', $LEAD, PDO::PARAM_STR);
$update->bindParam(':polterm', $polterm, PDO::PARAM_STR);
$update->bindParam(':OCID', $policyunid, PDO::PARAM_INT);
$update->execute();

$clientnamedata2 = $NAME;

if($ORIG_POLICY_STATUS == 'On Hold' && $POLICY_STATUS != $ORIG_POLICY_STATUS) {
    
    
        $database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount() <=0 ) {
            
        if(isset($INSURER) && $INSURER == 'Vitality') {
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_vitality_workflows.php');     
            
        }   else {            
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_workflows.php'); 
        
        }
                            
        } 
        
        $database->endTransaction();     
    
} elseif($POLICY_STATUS == 'On Hold' && $ORIG_POLICY_STATUS != $POLICY_STATUS) {
    
        $database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount() >= 1 ) {

        $database->query("DELETE FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
         $notedata= "All Workflows and Tasks have been deleted (Policy $POLICY_STATUS)!";
        $REF= "CRM Alert";
        $messagedata="All workflows and tasks have been removed from this client";
                
        $database->query("INSERT INTO client_note SET client_id=:CID, client_name=:recipientholder, sent_by='ADL', note_type=:NOTE, message=:MSG ");
        $database->bind(':CID',$CID);
        $database->bind(':recipientholder',$REF);
        $database->bind(':NOTE',$notedata);
        $database->bind(':MSG',$messagedata);
        $database->execute();               
                           
        } 
        
        $database->endTransaction();      
    
}

$changereason = filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($changereason)) {

    if ($changereason == 'Incorrect Policy Number') {

        $POL_TRK_QRY = $pdo->prepare("INSERT INTO policy_number_tracking set new_policy_number=:newpolicyholder, policy_id =:origpolicyid, oldpolicy=:oldpolicyholder ");
        $POL_TRK_QRY->bindParam(':newpolicyholder', $policy_number, PDO::PARAM_STR, 500);
        $POL_TRK_QRY->bindParam(':oldpolicyholder', $oname, PDO::PARAM_STR, 500);
        $POL_TRK_QRY->bindParam(':origpolicyid', $policyunid, PDO::PARAM_STR, 500);
        $POL_TRK_QRY->execute();

        $notedata = "Policy Number Updated";
        $clientnamedata = $policyunid . " - " . $policy_number;
        $messagedata = $oname . " changed to " . $policy_number;

        $INSERT_NOTE = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type=:NOTE, message=:MSG ");
        $INSERT_NOTE->bindParam(':CID', $CID, PDO::PARAM_INT);
        $INSERT_NOTE->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $INSERT_NOTE->bindParam(':HOLDER', $clientnamedata, PDO::PARAM_STR, 500);
        $INSERT_NOTE->bindParam(':NOTE', $notedata, PDO::PARAM_STR, 255);
        $INSERT_NOTE->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $INSERT_NOTE->execute();

    }

    $clientnamedata = $policyunid . " - " . $policy_number;
    $notedata = "Policy Details Updated";

    $INSERT_NOTE = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type=:NOTE, message=:MSG ");
    $INSERT_NOTE->bindParam(':CID', $CID, PDO::PARAM_INT);
    $INSERT_NOTE->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
    $INSERT_NOTE->bindParam(':HOLDER', $clientnamedata, PDO::PARAM_STR, 500);
    $INSERT_NOTE->bindParam(':NOTE', $notedata, PDO::PARAM_STR, 255);
    $INSERT_NOTE->bindParam(':MSG', $changereason, PDO::PARAM_STR, 2500);
    $INSERT_NOTE->execute();
}

        header('Location: /../../../../../../app/Client.php?CLIENT_POLICY=2&search=' . $CID .'&CLIENT_POLICY_POL_NUM='.$policy_number);
        die;
?>