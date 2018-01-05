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

    if ($_FILES[csv][size] > 0) {

    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {
/////////////////Transmission_Date
if ($data[0] != 'Transmission Date' && $data[0] != 'Transmission_Date' ) {
$CSV_Transmission_Date=$data[0];
$CSV_Transmission_Time=$data[1];
$CSV_Payment_Date=$data[2];
$CSV_Master_Agency_No=$data[3];
$CSV_FRN_Number=$data[4];
$CSV_Sub_Agency_No=$data[5];
$CSV_Policy_Type=$data[6];
$CSV_Policy=$data[7];
$CSV_Broker_Ref=$data[8];
$CSV_Reason_Code=$data[9];
$CSV_Party=$data[10];
$CSV_Policy_Name=$data[11];
$CSV_Initial=$data[12];
$CSV_Product_Description=$data[13];
$CSV_Payment_Type=$data[14];
$CSV_Payment_Amount=$data[15];
$CSV_Payment_Currency=$data[16];
$CSV_Payment_Basis=$data[17];
$CSV_Payment_Code=$data[18];
$CSV_Payment_Due_Date=$data[19];
$CSV_Premium_Type=$data[20];
$CSV_Premium_Amount=$data[21];
$CSV_Premium_Currency=$data[22];
$CSV_Premium_Frequency=$data[23];
$CSV_Payment_Reason=$data[24];
$CSV_Scheme_Number=$data[25];
$CSV_Scheme_Name=$data[26];

$regpol1= filter_var($data[7], FILTER_SANITIZE_NUMBER_INT);
$regpol="$regpol1";
$reggy = "%$regpol%";

if ($CSV_Payment_Amount >= 0) {
   
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Financial Uploaded";
    $message="COMM (Status changed from $polstat to Live)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
        
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() == 0) {
    
 $CHK_POLICY_HAS_ZERO = substr($CSV_Policy, 0, 1);

if($CHK_POLICY_HAS_ZERO != 0) {
    $CSV_Policy="0$CSV_Policy";
}       
    
   $insert = $pdo->prepare("INSERT INTO financial_statistics_nomatch set payment_amount=:pay, policy_number=:pol, entry_by=:hello, payment_type=:type");

    $insert->bindParam(':pay', $CSV_Premium_Amount, PDO::PARAM_STR, 250);
    $insert->bindParam(':type', $CSV_Payment_Type, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $CSV_Policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
}
}

if ($CSV_Payment_Amount < 0) {
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Financial Uploaded";
    $message="CLAWBACK (Status changed from $polstat to Clawback)";    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
        
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() == 0) {
    
 $CHK_POLICY_HAS_ZERO = substr($CSV_Policy, 0, 1);

if($CHK_POLICY_HAS_ZERO != 0) {
    $CSV_Policy="0$CSV_Policy";
}   
    
   $insert = $pdo->prepare("INSERT INTO financial_statistics_nomatch set payment_amount=:pay, policy_number=:pol, entry_by=:hello, payment_type=:type");

    $insert->bindParam(':pay', $CSV_Premium_Amount, PDO::PARAM_STR, 250);
    $insert->bindParam(':type', $CSV_Payment_Type, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $CSV_Policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
}

}

$CHK_POLICY_HAS_ZERO = substr($CSV_Policy, 0, 1);

if($CHK_POLICY_HAS_ZERO != 0) {
    $CSV_Policy="0$CSV_Policy";
}

 $query = $pdo->prepare("INSERT INTO financial_statistics_history "
. "set Transmission_Date=:Transmission_Date ,"
. " Transmission_Time=:Transmission_Time ,"
. " Payment_Date=:Payment_Date ,"
. " Master_Agency_No=:Master_Agency_No ,"
. " FRN_Number=:FRN_Number ,"
. " Sub_Agency_No=:Sub_Agency_No ,"
. " Policy_Type=:Policy_Type ,"
. " Policy=:Policy ,"
. " Broker_Ref=:Broker_Ref ,"
. " Reason_Code=:Reason_Code ,"
. " Party=:Party ,"
. " Policy_Name=:Policy_Name ,"
. " Initial=:Initial ,"
. " Product_Description=:Product_Description ,"
. " Payment_Type=:Payment_Type ,"
. " Payment_Amount=:Payment_Amount ,"
. " Payment_Currency=:Payment_Currency ,"
. " Payment_Basis=:Payment_Basis ,"
. " Payment_Code=:Payment_Code ,"
. " Payment_Due_Date=:Payment_Due_Date ,"
. " Premium_Type=:Premium_Type ,"
. " Premium_Amount=:Premium_Amount ,"
. " Premium_Currency=:Premium_Currency ,"
. " Premium_Frequency=:Premium_Frequency ,"
. " Payment_Reason=:Payment_Reason ,"
. " Scheme_Number=:Scheme_Number ,"
. " Scheme_Name=:Scheme_Name ,"
. " uploader=:uploader");



    $query->bindParam(':Transmission_Date', $CSV_Transmission_Date , PDO::PARAM_STR, 200);
    $query->bindParam(':Transmission_Time', $CSV_Transmission_Time , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Date', $CSV_Payment_Date , PDO::PARAM_STR, 200);
    $query->bindParam(':Master_Agency_No', $CSV_Master_Agency_No , PDO::PARAM_STR, 200);
    $query->bindParam(':FRN_Number', $CSV_FRN_Number , PDO::PARAM_STR, 200);
    $query->bindParam(':Sub_Agency_No', $CSV_Sub_Agency_No , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy_Type', $CSV_Policy_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy', $CSV_Policy , PDO::PARAM_STR, 200);
    $query->bindParam(':Broker_Ref', $CSV_Broker_Ref , PDO::PARAM_STR, 200);
    $query->bindParam(':Reason_Code', $CSV_Reason_Code , PDO::PARAM_STR, 200);
    $query->bindParam(':Party', $CSV_Party , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy_Name', $CSV_Policy_Name , PDO::PARAM_STR, 200);
    $query->bindParam(':Initial', $CSV_Initial , PDO::PARAM_STR, 200);
    $query->bindParam(':Product_Description', $CSV_Product_Description , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Type', $CSV_Payment_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Amount', $CSV_Payment_Amount , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Currency', $CSV_Payment_Currency , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Basis', $CSV_Payment_Basis , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Code', $CSV_Payment_Code , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Due_Date', $CSV_Payment_Due_Date , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Type', $CSV_Premium_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Amount', $CSV_Premium_Amount , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Currency', $CSV_Premium_Currency , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Frequency', $CSV_Premium_Frequency , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Reason', $CSV_Payment_Reason , PDO::PARAM_STR, 200);
    $query->bindParam(':Scheme_Number', $CSV_Scheme_Number , PDO::PARAM_STR, 200);
    $query->bindParam(':Scheme_Name', $CSV_Scheme_Name , PDO::PARAM_STR, 200);
    $query->bindParam(':uploader', $hello_name , PDO::PARAM_STR, 200);

  $query->execute();

}

        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../FinancialUploads.php?success=1'); die;
}

}

if($EXECUTE=='2') {
    
    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {
$wol_type=$data[0];
$wol_payment_date = DateTime::createFromFormat('j-M-y', $data[1]);
$wol_payment_date=$wol_payment_date->format('Y-m-d');
$wol_comm_type=$data[2];
$wol_agent=$data[3];
$wol_agency_id=$data[4];
$wol_agency=$data[5];
$wol_client=$data[6];
$wol_policy=$data[7];
$wol_sale_date = DateTime::createFromFormat('j-M-y', $data[8]);
$wol_sale_date=$wol_sale_date->format('Y-m-d');
$wol_fig_1 = number_format($data[9], 2, '.', '');
$wol_fig_2 = number_format($data[10], 2, '.', '');
$wol_blank=$data[11];
$wol_comm = number_format($data[12], 2, '.', '');

$regpol1= filter_var($data[7], FILTER_SANITIZE_NUMBER_INT);
$regpol="$regpol1";
$reggy = "%$regpol%";

if ($wol_comm > 0) {
   
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="WOL Financial Uploaded";
    $message="COMM (Status changed from $polstat to Live)";
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() <= 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select wol_nomatch_id from wol_nomatch WHERE wol_nomatch_comm=:pay AND wol_nomatch_policy=:pol");
     $DUPE_NOMTC_CHK->bindParam(':pay', $wol_comm, PDO::PARAM_STR, 250);
     $DUPE_NOMTC_CHK->bindParam(':pol', $wol_policy, PDO::PARAM_STR, 250);
     $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO wol_nomatch set wol_nomatch_comm=:pay, wol_nomatch_policy=:pol, wol_nomatch_uploader=:hello");
    $insert->bindParam(':pay', $wol_comm, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $wol_policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}
}

if ($wol_comm < 0) {
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="WOL Financial Upload";
    $message="CLAWBACK (Status changed from $polstat to Clawback)";    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() == 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select wol_nomatch_id from wol_nomatch WHERE wol_nomatch_comm=:pay AND wol_nomatch_policy=:pol");
    $DUPE_NOMTC_CHK->bindParam(':pay', $wol_comm, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':pol', $wol_policy, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO wol_nomatch set wol_nomatch_comm=:pay, wol_nomatch_policy=:pol, wol_nomatch_uploader=:hello");
   $insert->bindParam(':pay', $wol_comm, PDO::PARAM_STR, 250);
   $insert->bindParam(':pol', $wol_policy, PDO::PARAM_STR, 250);
   $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
   $insert->execute();        
        
    }
    

    
}

}

$DUPECHK = $pdo->prepare("SELECT wol_id from wol_financials WHERE wol_type=:wol_type AND wol_payment_date=:wol_payment_date AND wol_comm_type=:wol_comm_type AND wol_agent=:wol_agent AND wol_agency_id=:wol_agency_id AND wol_agency=:wol_agency AND wol_client=:wol_client AND wol_policy=:wol_policy AND wol_sale_date=:wol_sale_date AND wol_fig_1=:wol_fig_1 AND wol_fig_2=:wol_fig_2 AND wol_comm=:wol_comm");
$DUPECHK->bindParam(':wol_type', $wol_type , PDO::PARAM_STR, 200);
 $DUPECHK->bindParam(':wol_payment_date', $wol_payment_date , PDO::PARAM_STR, 200);
 $DUPECHK->bindParam(':wol_comm_type', $wol_comm_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_agent', $wol_agent , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_agency_id', $wol_agency_id , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_agency', $wol_agency , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_client', $wol_client , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_policy', $wol_policy , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_sale_date', $wol_sale_date , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_fig_1', $wol_fig_1 , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_fig_2', $wol_fig_2 , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':wol_comm', $wol_comm , PDO::PARAM_STR, 200);  
    $DUPECHK->execute();  
    if ($DUPECHK->rowCount() <= 0) {
        
        $WOL_INSERT = $pdo->prepare("INSERT INTO wol_financials set wol_type=:wol_type, wol_payment_date=:wol_payment_date, wol_comm_type=:wol_comm_type, wol_agent=:wol_agent, wol_agency_id=:wol_agency_id, wol_agency=:wol_agency , wol_client=:wol_client, wol_policy=:wol_policy, wol_sale_date=:wol_sale_date, wol_fig_1=:wol_fig_1, wol_fig_2=:wol_fig_2, wol_comm=:wol_comm, wol_uploader=:wol_uploader");
        $WOL_INSERT->bindParam(':wol_type', $wol_type , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_payment_date', $wol_payment_date , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_comm_type', $wol_comm_type , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_agent', $wol_agent , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_agency_id', $wol_agency_id , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_agency', $wol_agency , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_client', $wol_client , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_policy', $wol_policy , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_sale_date', $wol_sale_date , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_fig_1', $wol_fig_1 , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_fig_2', $wol_fig_2 , PDO::PARAM_STR, 200);
        $WOL_INSERT->bindParam(':wol_comm', $wol_comm , PDO::PARAM_STR, 200);    
        $WOL_INSERT->bindParam(':wol_uploader', $hello_name , PDO::PARAM_STR, 200);
        $WOL_INSERT->execute();        
        
    }
   


        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../FinancialUploads.php?success=1&FiancialType=WOL'); die;
}    
    
    
}

if($EXECUTE=='3') {
    
    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {

$royal_london_payment_date = DateTime::createFromFormat('d/m/Y', $data[0]);
$royal_london_payment_date=$royal_london_payment_date->format('Y-m-d');
$royal_london_type=$data[1];
$royal_london_status=$data[2];
$royal_london_agent=$data[3];
$royal_london_agency=$data[4];
$royal_london_ifa=$data[5];
$royal_london_client=$data[6];
$royal_london_policy=$data[7];
$royal_london_sale_date = DateTime::createFromFormat('d/m/Y', $data[8]);
$royal_london_sale_date=$royal_london_sale_date->format('Y-m-d');

$royal_london_premium=str_replace("£","",$data[9]);
$royal_london_comm=str_replace("£","",$data[10]);

$regpol1= filter_var($data[7], FILTER_SANITIZE_NUMBER_INT);
$regpol="$regpol1";
$reggy = "%$regpol%";

if ($royal_london_comm > 0) {
   
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Royal London Financial Uploaded";
    $message="COMM (Status changed from $polstat to Live)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() <= 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select royal_london_nomatch_id from royal_london_nomatch WHERE royal_london_nomatch_comm=:pay AND royal_london_nomatch_policy=:pol AND royal_london_nomatch_status=:type");
    $DUPE_NOMTC_CHK->bindParam(':pay', $royal_london_comm, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':type', $royal_london_status, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':pol', $royal_london_policy, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO royal_london_nomatch set royal_london_nomatch_comm=:pay, royal_london_nomatch_policy=:pol, royal_london_nomatch_uploader=:hello, royal_london_nomatch_status=:type");
    $insert->bindParam(':pay', $royal_london_comm, PDO::PARAM_STR, 250);
    $insert->bindParam(':type', $royal_london_status, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $royal_london_policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}
}

if ($royal_london_comm < 0) {
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Royal London Financial Upload";
    $message="CLAWBACK (Status changed from $polstat to Clawback)";    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() == 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select royal_london_nomatch_id from royal_london_nomatch WHERE royal_london_nomatch_comm=:pay AND royal_london_nomatch_policy=:pol AND royal_london_nomatch_status=:type");
    $DUPE_NOMTC_CHK->bindParam(':pay', $royal_london_comm, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':type', $royal_london_status, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':pol', $royal_london_policy, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO royal_london_nomatch set royal_london_nomatch_comm=:pay, royal_london_nomatch_policy=:pol, royal_london_nomatch_uploader=:hello, royal_london_nomatch_status=:type");
    $insert->bindParam(':pay', $royal_london_comm, PDO::PARAM_STR, 250);
    $insert->bindParam(':type', $royal_london_status, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $royal_london_policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    

    
}

}

 $DUPECHK = $pdo->prepare("Select royal_london_id from royal_london_financials WHERE royal_london_payment_date=:royal_london_payment_date AND royal_london_type=:royal_london_type AND royal_london_status=:royal_london_status AND royal_london_agent=:royal_london_agent AND royal_london_agency=:royal_london_agency AND royal_london_ifa=:royal_london_ifa AND royal_london_client=:royal_london_client AND royal_london_policy=:royal_london_policy AND royal_london_sale_date=:royal_london_sale_date AND royal_london_premium=:royal_london_premium AND royal_london_comm=:royal_london_comm");
    $DUPECHK->bindParam(':royal_london_payment_date', $royal_london_payment_date , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_type', $royal_london_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_status', $royal_london_status , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_agent', $royal_london_agent , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_agency', $royal_london_agency , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_ifa', $royal_london_ifa , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_client', $royal_london_client , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_policy', $royal_london_policy , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_sale_date', $royal_london_sale_date , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_premium', $royal_london_premium , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':royal_london_comm', $royal_london_comm , PDO::PARAM_STR, 200);
    $DUPECHK->execute();
    
    if ($DUPECHK->rowCount() <= 0) {
        
 $WOL_INSERT = $pdo->prepare("INSERT INTO royal_london_financials set royal_london_payment_date=:royal_london_payment_date, royal_london_type=:royal_london_type, royal_london_status=:royal_london_status, royal_london_agent=:royal_london_agent, royal_london_agency=:royal_london_agency, royal_london_ifa=:royal_london_ifa, royal_london_client=:royal_london_client, royal_london_policy=:royal_london_policy, royal_london_sale_date=:royal_london_sale_date, royal_london_premium=:royal_london_premium, royal_london_comm=:royal_london_comm, royal_london_uploader=:royal_london_uploader");
    $WOL_INSERT->bindParam(':royal_london_payment_date', $royal_london_payment_date , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_type', $royal_london_type , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_status', $royal_london_status , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_agent', $royal_london_agent , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_agency', $royal_london_agency , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_ifa', $royal_london_ifa , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_client', $royal_london_client , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_policy', $royal_london_policy , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_sale_date', $royal_london_sale_date , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_premium', $royal_london_premium , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_comm', $royal_london_comm , PDO::PARAM_STR, 200);
    $WOL_INSERT->bindParam(':royal_london_uploader', $hello_name , PDO::PARAM_STR, 200);
    $WOL_INSERT->execute();        
        
    }
   


        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../FinancialUploads.php?success=1&FiancialType=RoyalLondon'); die;
}    
    
    
}

if($EXECUTE=='4') {
            ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {
$vitality_ref_id=$data[0];
$vitality_agency=$data[1];
$vitality_agency_id=$data[2];
$vitality_comm_type=$data[3];
$vitality_agent=$data[4];
$vitality_cover_type=$data[5];
$vitality_comm_status=$data[6];
$vitality_pay_type=$data[7];
$vitality_policy=$data[8];
$vitality_type=$data[9];

$vitality_sale_date = DateTime::createFromFormat("d/m/Y", $data[10]);
$vitality_sale_date=$vitality_sale_date->format('Y-m-d');

$vitality_client=$data[11];
$vitality_comm=str_replace("£","",$data[12]);
$vitality_premium=str_replace("£","",$data[13]);
$vitality_payment_date = DateTime::createFromFormat("d/m/Y", $data[14]);
$vitality_payment_date=$vitality_payment_date->format('Y-m-d');
$vitality_ref=$data[15];
$regpol1= filter_var($data[8], FILTER_SANITIZE_NUMBER_INT);
$regpol="$regpol1";
$reggy = "%$regpol%";

if ($vitality_comm > 0) {
   
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Vitality Financial Uploaded";
    $message="COMM (Status changed from $polstat to Live)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() <= 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select vitality_nomatch_id from vitality_nomatch WHERE vitality_nomatch_comm=:pay AND vitality_nomatch_policy=:pol");
    $DUPE_NOMTC_CHK->bindParam(':pay', $vitality_comm, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':pol', $vitality_policy, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO vitality_nomatch set vitality_nomatch_comm=:pay, vitality_nomatch_policy=:pol, vitality_nomatch_uploader=:hello");
    $insert->bindParam(':pay', $vitality_comm, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $vitality_policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}
}

if ($vitality_comm < 0) {
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Vitality Financial Upload";
    $message="CLAWBACK (Status changed from $polstat to Clawback)";    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() == 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select vitality_nomatch_id from vitality_nomatch WHERE vitality_nomatch_comm=:pay AND vitality_nomatch_policy=:pol");
    $DUPE_NOMTC_CHK->bindParam(':pay', $vitality_comm, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->bindParam(':pol', $vitality_policy, PDO::PARAM_STR, 250);
    $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO vitality_nomatch set vitality_nomatch_comm=:pay, vitality_nomatch_policy=:pol, vitality_nomatch_uploader=:hello");
    $insert->bindParam(':pay', $vitality_comm, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $vitality_policy, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}

}

$DUPECHK = $pdo->prepare("SELECT vitality_id from vitality_financials WHERE vitality_ref_id=:vitality_ref_id AND vitality_agency=:vitality_agency AND vitality_agency_id=:vitality_agency_id AND vitality_comm_type=:vitality_comm_type AND vitality_agent=:vitality_agent AND vitality_cover_type=:vitality_cover_type AND vitality_comm_status=:vitality_comm_status AND vitality_pay_type=:vitality_pay_type AND vitality_policy=:vitality_policy AND vitality_type=:vitality_type AND vitality_sale_date=:vitality_sale_date AND vitality_client=:vitality_client AND vitality_comm=:vitality_comm AND vitality_premium=:vitality_premium AND vitality_payment_date=:vitality_payment_date AND vitality_ref=:vitality_ref");
    $DUPECHK->bindParam(':vitality_ref_id', $vitality_ref_id , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_agency', $vitality_agency , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_agency_id', $vitality_agency_id , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_comm_type', $vitality_comm_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_agent', $vitality_agent , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_cover_type', $vitality_cover_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_comm_status', $vitality_comm_status , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_pay_type', $vitality_pay_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_policy', $vitality_policy , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_type', $vitality_type , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_sale_date', $vitality_sale_date , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_client', $vitality_client , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_comm', $vitality_comm , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_premium', $vitality_premium , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_payment_date', $vitality_payment_date , PDO::PARAM_STR, 200);
    $DUPECHK->bindParam(':vitality_ref', $vitality_ref , PDO::PARAM_STR, 200);
    $DUPECHK->execute();
    
    if ($DUPECHK->rowCount() <= 0) {
        
        $VIT_INSERT = $pdo->prepare("INSERT INTO vitality_financials set vitality_ref_id=:vitality_ref_id,  vitality_agency=:vitality_agency,  vitality_agency_id=:vitality_agency_id,  vitality_comm_type=:vitality_comm_type,  vitality_agent=:vitality_agent,  vitality_cover_type=:vitality_cover_type,  vitality_comm_status=:vitality_comm_status,  vitality_pay_type=:vitality_pay_type,  vitality_policy=:vitality_policy,  vitality_type=:vitality_type,  vitality_sale_date=:vitality_sale_date,  vitality_client=:vitality_client,  vitality_comm=:vitality_comm,  vitality_premium=:vitality_premium,  vitality_payment_date=:vitality_payment_date,  vitality_ref=:vitality_ref, vitality_uploader=:vitality_uploader");
        $VIT_INSERT->bindParam(':vitality_ref_id', $vitality_ref_id , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_agency', $vitality_agency , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_agency_id', $vitality_agency_id , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':vitality_comm_type', $vitality_comm_type , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_agent', $vitality_agent , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_cover_type', $vitality_cover_type , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_comm_status', $vitality_comm_status , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_pay_type', $vitality_pay_type , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_policy', $vitality_policy , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_type', $vitality_type , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_sale_date', $vitality_sale_date , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_client', $vitality_client , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_comm', $vitality_comm , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_premium', $vitality_premium , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_payment_date', $vitality_payment_date , PDO::PARAM_STR, 200);
        $VIT_INSERT->bindParam(':vitality_ref', $vitality_ref , PDO::PARAM_INT);
        $VIT_INSERT->bindParam(':vitality_uploader', $hello_name , PDO::PARAM_STR, 200);
        $VIT_INSERT->execute();        
        
    }

        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../FinancialUploads.php?success=1&FiancialType=RoyalLondon'); die;
}    
    
    
}

 if($EXECUTE=='8') {

    if ($_FILES['csv']['size'] > 0) {

    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {

if ($data[0] != 'Policy ref' && $data[0] != 'Policy ref' ) {
$CSV_POLICY=$data[0];
$CSV_PAYMENT=$data[1];
$CSV_PAY_DATE=$data[2];
$CSV_PROVIDER=$data[3];
$CSV_CLIENT=$data[5];
$CSV_BRID=$data[10];

$reggy = "%$CSV_POLICY%";

    $DUPE_CHK = $pdo->prepare("SELECT financials_policy from financials WHERE bedrock_id =:BRID");
    $DUPE_CHK->bindParam(':BRID', $CSV_BRID, PDO::PARAM_STR);
    $DUPE_CHK->execute();
    $result=$DUPE_CHK->fetch(PDO::FETCH_ASSOC);
    
    if ($DUPE_CHK->rowCount() <= 0) {
        


if ($CSV_PAYMENT >= 0) {
   
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold AND insurer=:INSURER");
    $query->bindParam(':INSURER', $CSV_PROVIDER, PDO::PARAM_STR);
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Financial Uploaded";
    $message="COMM (Status changed from $polstat to Live)";
    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
        
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() <= 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select financials_nomatch_id from financials_nomatch WHERE bedrock_id=:BRID");
     $DUPE_NOMTC_CHK->bindParam(':BRID', $CSV_BRID, PDO::PARAM_INT);
     $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO financials_nomatch set bedrock_id=:BRID, financials_nomatch_payment=:pay, financials_nomatch_policy=:pol, financials_nomatch_insert_by=:hello");
   $insert->bindParam(':BRID', $CSV_BRID, PDO::PARAM_STR, 250); 
   $insert->bindParam(':pay', $CSV_PAYMENT, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $CSV_POLICY, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}

}

if ($CSV_PAYMENT < 0) {
     
    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold AND insurer=:INSURER");
    $query->bindParam(':INSURER', $CSV_PROVIDER, PDO::PARAM_STR);
    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
   
if ($query->rowCount() >= 1) {
    
    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    $ref= "$policynumber ($polid)";
    $polstat=$result['policystatus'];
     
    $note="Financial Uploaded";
    $message="CLAWBACK (Status changed from $polstat to Clawback)";    
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");

    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
    
        $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
        $update->execute();
        
}

if ($query->rowCount() <= 0) {
    
     $DUPE_NOMTC_CHK = $pdo->prepare("Select financials_nomatch_id from financials_nomatch WHERE bedrock_id=:BRID");
     $DUPE_NOMTC_CHK->bindParam(':BRID', $CSV_BRID, PDO::PARAM_INT);
     $DUPE_NOMTC_CHK->execute();
    
    if ($DUPE_NOMTC_CHK->rowCount() <= 0) {

   $insert = $pdo->prepare("INSERT INTO financials_nomatch set bedrock_id=:BRID, financials_nomatch_payment=:pay, financials_nomatch_policy=:pol, financials_nomatch_insert_by=:hello");
   $insert->bindParam(':BRID', $CSV_BRID, PDO::PARAM_STR, 250); 
   $insert->bindParam(':pay', $CSV_PAYMENT, PDO::PARAM_STR, 250);
    $insert->bindParam(':pol', $CSV_POLICY, PDO::PARAM_STR, 250);
    $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();        
        
    }
    
}

}

 $query = $pdo->prepare("INSERT INTO financials set bedrock_id=:BRID, financials_pay_date=:DATE, financials_policy=:POLICY, financials_payment=:PAYMENT, financials_provider=:PROVIDER, financials_client=:CLIENT, financials_insert_by=:HELLO");
 $query->bindParam(':BRID', $CSV_BRID , PDO::PARAM_STR);
 $query->bindParam(':POLICY', $CSV_POLICY , PDO::PARAM_STR);
 $query->bindParam(':DATE', $CSV_PAY_DATE , PDO::PARAM_STR);
    $query->bindParam(':PAYMENT', $CSV_PAYMENT , PDO::PARAM_STR);
    $query->bindParam(':PROVIDER', $CSV_PROVIDER , PDO::PARAM_STR);
    $query->bindParam(':CLIENT', $CSV_CLIENT , PDO::PARAM_STR);
    $query->bindParam(':HELLO', $hello_name , PDO::PARAM_STR);
    $query->execute();

}

        }
    } 
    
    } 
    
    while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /../FinancialUploads.php?success=1'); die;
}

}

}
?>