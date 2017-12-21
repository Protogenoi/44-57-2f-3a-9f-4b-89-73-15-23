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

    $life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($life)) {
        if($life=='y') {

$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone_number= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$alt_number= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
$dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
$email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL);
$address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
$address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
$address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
$town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
$post_code= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid1= filter_input(INPUT_POST, 'leadid1', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid2= filter_input(INPUT_POST, 'leadid2', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid3= filter_input(INPUT_POST, 'leadid3', FILTER_SANITIZE_SPECIAL_CHARS);
$callauditid= filter_input(INPUT_POST, 'callauditid', FILTER_SANITIZE_SPECIAL_CHARS);
$leadauditid= filter_input(INPUT_POST, 'leadauditid', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid12= filter_input(INPUT_POST, 'leadid12', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid22= filter_input(INPUT_POST, 'leadid22', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid32= filter_input(INPUT_POST, 'leadid32', FILTER_SANITIZE_SPECIAL_CHARS);
$title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$callauditid2= filter_input(INPUT_POST, 'callauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
$leadauditid2= filter_input(INPUT_POST, 'leadauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
$company= filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
$CID= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_SPECIAL_CHARS);
$lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
$dealsheet_id= filter_input(INPUT_POST, 'dealsheet_id', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("SELECT CONCAT(title, ' ', first_name, ' ',last_name) AS orig_name, CONCAT(title2, ' ', first_name2, ' ',last_name2) AS orig_name2 FROM client_details WHERE client_id=:origidholder");
$query->bindParam(':origidholder',$CID, PDO::PARAM_INT);
$query->execute(); 
$origdetails=$query->fetch(PDO::FETCH_ASSOC);

$oname=$origdetails['orig_name'];
$oname2=$origdetails['orig_name2'];

$UPDATE_CLIENT = $pdo->prepare("UPDATE client_details
SET
dealsheet_id=:DEAL_ID,
title=:TITLE,
first_name=:FIRST,
last_name=:LAST,
dob=:DOB,
email=:EMAIL,
phone_number=:PHONE,
alt_number=:ALT,
title2=:TITLE2,
first_name2=:FIRST2,
last_name2=:LAST2,
dob2=:DOB2,
email2=:EMAIL2,
address1=:ADD1,
address2=:ADD2,
address3=:ADD3,
town=:TOWN,
post_code=:POST,
leadid1=:LEADID,
leadid2=:LEADID2,
leadid3=:LEADID3,
callauditid=:AUDITID,
leadauditid=:LEADAUDITID,
leadid12=:LEAD_ID,
leadid22=:LEAD_ID_2,
leadid32=:LEAD_ID_3,
callauditid2=:CALL_AUDIT_ID,
leadauditid2=:LEAD_AUDIT_ID,
date_edited=CURRENT_TIMESTAMP,
recent_edit=:HELLO,
company=:COMPANY
WHERE client_id=:CID");
$UPDATE_CLIENT->bindParam(':DEAL_ID',$dealsheet_id, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':TITLE',$title, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':FIRST',$first_name, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':LAST',$last_name, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':DOB',$dob, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':EMAIL',$email, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':PHONE',$phone_number, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':ALT',$alt_number, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':TITLE2',$title2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':FIRST2',$first_name2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':LAST2',$last_name2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':DOB2',$dob2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':EMAIL2',$email2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':ADD1',$address1, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':ADD2',$address2, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':ADD3',$address3, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':TOWN',$town, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':POST',$post_code, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':LEADID',$leadid1, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEADID2',$leadid2, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEADID3',$leadid3, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':AUDITID',$callauditid, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEADAUDITID',$leadauditid, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEAD_ID',$leadid12, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEAD_ID_2',$leadid22, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEAD_ID_3',$leadid32, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':CALL_AUDIT_ID',$callauditid2, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':LEAD_AUDIT_ID',$leadauditid2, PDO::PARAM_INT);
$UPDATE_CLIENT->bindParam(':HELLO',$hello_name, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':COMPANY',$company, PDO::PARAM_STR);
$UPDATE_CLIENT->bindParam(':CID',$CID, PDO::PARAM_INT);
$UPDATE_CLIENT->execute(); 

if ($UPDATE_CLIENT->rowCount()>=1) {  

$clientnamedata= "CRM Alert";   
$notedata= "Client Details Updated";


$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
$query->execute(); 

    $clientnamedatas=$title ." ". $first_name ." ". $last_name;
    $clientnamedatas2=$title2 ." ". $first_name2 ." ". $last_name2;
    
   $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($changereason)){
    
      $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($changereason =='Incorrect Client Name') {
        
        $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholder WHERE client_name =:orignameholder");
        $query->bindParam(':recipientholder',$clientnamedatas, PDO::PARAM_STR, 500);
        $query->bindParam(':orignameholder',$oname, PDO::PARAM_STR, 500);
        $query->execute(); 

    }
    
        if ($changereason =='Incorrect Client Name 2') {

            $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholders WHERE client_name =:orignameholders");
            $query->bindParam(':recipientholders',$clientnamedatas2, PDO::PARAM_STR, 500);
            $query->bindParam(':orignameholders',$oname2, PDO::PARAM_STR, 500);
            $query->execute(); 
            
    }
}
    if(isset($fferror)) {
    if($fferror=='0') {
   header('Location: /../../../../../app/Client.php?CLIENT_EDIT=1&search='.$CID); die;
    }
    }
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    
    if(isset($fferror)) {
    if($fferror=='0') {
    
    header('Location: /../../../../../app/Client.php?CLIENT_EDIT=0&search='.$CID); die;
    }
    }
}

        }
    }

header('Location: /../../../../../CRMmain.php'); die;

?>