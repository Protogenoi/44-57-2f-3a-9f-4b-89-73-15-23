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

if (in_array($hello_name, $Level_3_Access, true)) { 

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {

    $CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($EXECUTE == '1') {

        $custtype = filter_input(INPUT_POST, 'custtype', FILTER_SANITIZE_SPECIAL_CHARS);
        $policy_number = filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);

        $client_name = filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $sale_date = filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $application_number = filter_input(INPUT_POST, 'application_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $premium = filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $insurer = filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
        $commission = filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
        $CommissionType = filter_input(INPUT_POST, 'CommissionType', FILTER_SANITIZE_SPECIAL_CHARS);
        $PolicyStatus = filter_input(INPUT_POST, 'PolicyStatus', FILTER_SANITIZE_SPECIAL_CHARS);
        $comm_term = filter_input(INPUT_POST, 'comm_term', FILTER_SANITIZE_SPECIAL_CHARS);
        $drip = filter_input(INPUT_POST, 'drip', FILTER_SANITIZE_SPECIAL_CHARS);
        $soj = filter_input(INPUT_POST, 'soj', FILTER_SANITIZE_SPECIAL_CHARS);
        $closer = filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
        $lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
        $covera = filter_input(INPUT_POST, 'covera', FILTER_SANITIZE_SPECIAL_CHARS);
        $polterm = filter_input(INPUT_POST, 'polterm', FILTER_SANITIZE_SPECIAL_CHARS);
        $submitted_date = filter_input(INPUT_POST, 'submitted_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $NonIndem = filter_input(INPUT_POST, 'NonIndem', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $EXTRA_CHARGE = filter_input(INPUT_POST, 'EXTRA_CHARGE', FILTER_SANITIZE_NUMBER_FLOAT);

        if ($PolicyStatus == "Awaiting" || $policy_number=="TBC") {
            $sale_date = "TBC";
            $DATE = date("Y/m/d h:i:s");
            $DATE_FOR_TBC_POL = preg_replace("/[^0-9]/", "", $DATE);
            $PolicyStatus="Awaiting";

            $policy_number = "TBC $DATE_FOR_TBC_POL";
        }

        if (strpos($client_name, ' and ') !== false) {
            $soj = "Joint";
        } else {
            $soj = "Single";
        }

        $dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
        $dupeck->bindParam(':pol', $policy_number, PDO::PARAM_STR);
        $dupeck->execute();
        $row = $dupeck->fetch(PDO::FETCH_ASSOC);
        if ($count = $dupeck->rowCount() >= 1) {
            $dupepol = "$row[policy_number] DUPE";

            $insert = $pdo->prepare("INSERT INTO client_policy set 
client_id=:cid,
extra_charge=:CHARGE,
 client_name=:name,
 sale_date=:sale,
 application_number=:an_num,
 policy_number=:policy,
 premium=:premium,
 type=:type,
 insurer=:insurer,
 submitted_by=:hello,
 edited=:helloed,
 commission=:commission,
 CommissionType=:CommissionType,
 PolicyStatus=:PolicyStatus,
 comm_term=:comm_term,
 drip=:drip,
 submitted_date=:date,
 soj=:soj,
 closer=:closer,
 lead=:lead,
 covera=:covera,
 polterm=:polterm,
 non_indem_com=:NONIDEM");
            $insert->bindParam(':NONIDEM', $NonIndem, PDO::PARAM_INT);
            $insert->bindParam(':CHARGE', $EXTRA_CHARGE, PDO::PARAM_INT);
            $insert->bindParam(':cid', $CID, PDO::PARAM_STR);
            $insert->bindParam(':name', $client_name, PDO::PARAM_STR);
            $insert->bindParam(':sale', $sale_date, PDO::PARAM_STR);
            $insert->bindParam(':an_num', $application_number, PDO::PARAM_STR);
            $insert->bindParam(':policy', $dupepol, PDO::PARAM_STR);
            $insert->bindParam(':premium', $premium, PDO::PARAM_STR);
            $insert->bindParam(':type', $type, PDO::PARAM_STR);
            $insert->bindParam(':insurer', $insurer, PDO::PARAM_STR);
            $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR);
            $insert->bindParam(':helloed', $hello_name, PDO::PARAM_STR);
            $insert->bindParam(':commission', $commission, PDO::PARAM_STR);
            $insert->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
            $insert->bindParam(':PolicyStatus', $PolicyStatus, PDO::PARAM_STR);
            $insert->bindParam(':comm_term', $comm_term, PDO::PARAM_STR);
            $insert->bindParam(':drip', $drip, PDO::PARAM_STR);
            $insert->bindParam(':date', $submitted_date, PDO::PARAM_STR);
            $insert->bindParam(':soj', $soj, PDO::PARAM_STR);
            $insert->bindParam(':closer', $closer, PDO::PARAM_STR);
            $insert->bindParam(':lead', $lead, PDO::PARAM_STR);
            $insert->bindParam(':covera', $covera, PDO::PARAM_STR);
            $insert->bindParam(':polterm', $polterm, PDO::PARAM_STR);
            $insert->execute();

            $messagedata = "Policy added $dupepol duplicate of $policy_number";

            $query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG ");
            $query->bindParam(':CID', $CID, PDO::PARAM_INT);
            $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':HOLDER', $client_name, PDO::PARAM_STR, 500);
            $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
            $query->execute();

            $client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id', $CID, PDO::PARAM_STR);
            $client_type->execute();

                    header('Location: ../../../app/Client.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $policy_number);
                    die;

        }

        $insert = $pdo->prepare("INSERT INTO client_policy set non_indem_com=:NONIDEM, client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
        $insert->bindParam(':cid', $CID, PDO::PARAM_STR);
        $insert->bindParam(':NONIDEM', $NonIndem, PDO::PARAM_STR);
        $insert->bindParam(':name', $client_name, PDO::PARAM_STR);
        $insert->bindParam(':sale', $sale_date, PDO::PARAM_STR);
        $insert->bindParam(':an_num', $application_number, PDO::PARAM_STR);
        $insert->bindParam(':policy', $policy_number, PDO::PARAM_STR);
        $insert->bindParam(':premium', $premium, PDO::PARAM_STR);
        $insert->bindParam(':type', $type, PDO::PARAM_STR);
        $insert->bindParam(':insurer', $insurer, PDO::PARAM_STR);
        $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR);
        $insert->bindParam(':helloed', $hello_name, PDO::PARAM_STR);
        $insert->bindParam(':commission', $commission, PDO::PARAM_STR);
        $insert->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
        $insert->bindParam(':PolicyStatus', $PolicyStatus, PDO::PARAM_STR);
        $insert->bindParam(':comm_term', $comm_term, PDO::PARAM_STR);
        $insert->bindParam(':drip', $drip, PDO::PARAM_STR);
        $insert->bindParam(':date', $submitted_date, PDO::PARAM_STR);
        $insert->bindParam(':soj', $soj, PDO::PARAM_STR);
        $insert->bindParam(':closer', $closer, PDO::PARAM_STR);
        $insert->bindParam(':lead', $lead, PDO::PARAM_STR);
        $insert->bindParam(':covera', $covera, PDO::PARAM_STR);
        $insert->bindParam(':polterm', $polterm, PDO::PARAM_STR);
        $insert->execute();
        
        $messagedata = "Policy $policy_number added";

        $query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER', $client_name, PDO::PARAM_STR, 500);
        $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
$database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT client_id FROM Client_Tasks WHERE client_id=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            
            
        } else {
    
                $weekarray=array('Mon','Tue','Wed','Thu','Fri');
                $today=date("D"); // check Day Mon - Sun
                $date=date("Y-m-d",strtotime($today)); // Convert day to date
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='CYD'");
                $database->execute();
                $assignCYDd=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='24 48'");
                $database->execute();
                $assign24d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='5 day'");
                $database->execute();
                $assign5d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
                $database->execute();
                $assign18d=$database->single();
                
                $assignCYD=$assignCYDd['Assigned'];
                $assign24=$assign24d['Assigned'];
                $assign5=$assign5d['Assigned'];
                $assign18=$assign18d['Assigned'];
                
                $taskCYD="CYD";
                $next = date("D", strtotime("+91 day")); // Add 2 to Day
                
                if($next =="Sat") { //Check if Weekend
                $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+93 day")); //Add extra 2 Days if Sat Weekend
                $deadlineCYD=$SkipWeekEndDayCYD;
                
                }
                
                if($next=="Sun") {
                    $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+92 day"));
                    $deadlineCYD=$SkipWeekEndDayCYD;
                    
                }
                
                if (in_array($next,$weekarray,true)){
                    $WeekDayCYD = date("Y-m-d", strtotime("+91 day"));
                    $deadlineCYD=$WeekDayCYD;
                    
                } 
                
                $date_added= date("Y-m-d H:i:s");
                $task24="24 48";
                
                $next24 = date("D", strtotime("+2 day")); 
                if($next24 =="Sat") { 
                    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+4 day")); 
                    $deadline24=$SkipWeekEndDay24;
                    
                }

if($next24=="Sun") { 

    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+3 day")); 

    $deadline24=$SkipWeekEndDay24;

}


if (in_array($next24,$weekarray,true)){

$WeekDay24 = date("Y-m-d", strtotime("+2 day"));

    $deadline24=$WeekDay24;

} 

$task5="5 day";
$next5 = date("D", strtotime("+5 day")); // Add 2 to Day

if($next5 =="Sat") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+7 day")); //Add extra 2 Days if Sat Weekend

    $deadline5=$SkipWeekEndDay5;

}

if($next5=="Sun") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+6 day")); //Add extra 1 day if Sunday

    $deadline5=$SkipWeekEndDay5;

}


if (in_array($next5,$weekarray,true)){

$WeekDay5 = date("Y-m-d", strtotime("+5 day"));

    $deadline5=$WeekDay5;

} 


$task18="18 day";
$next18 = date("D", strtotime("+18 day")); // Add 2 to Day

if($next18 =="Sat") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+20 day")); //Add extra 2 Days if Sat Weekend

    $deadline18=$SkipWeekEndDay18;

}

if($next18=="Sun") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+19 day")); //Add extra 1 day if Sunday

    $deadline18=$SkipWeekEndDay18;

}


if (in_array($next18,$weekarray,true)){

$WeekDay18 = date("Y-m-d", strtotime("+18 day"));

    $deadline18=$WeekDay18;

}


        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assignCYD, PDO::PARAM_STR);
        $database->bind(':task', $taskCYD, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadlineCYD, PDO::PARAM_STR); 
        $database->bind(':cid', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign24, PDO::PARAM_STR);
        $database->bind(':task', $task24, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline24, PDO::PARAM_STR); 
        $database->bind(':cid', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign5, PDO::PARAM_STR);
        $database->bind(':task', $task5, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline5, PDO::PARAM_STR); 
        $database->bind(':cid', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign18, PDO::PARAM_STR);
        $database->bind(':task', $task18, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline18, PDO::PARAM_STR); 
        $database->bind(':cid', $CID); 
        $database->execute();
        
        $notedata= "Tasks added!";
        $REF= "CRM Alert";
        $messagedata="All tasks have been assigned to this client";
                
                $database->query("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by='ADL', note_type=:noteholder, message=:messageholder ");
                $database->bind(':CID',$CID);
                $database->bind(':recipientholder',$REF);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();         
        
        $database->endTransaction();        
        
    }        
        
    }
}

        header('Location: /../../../../../app/Client.php?CLIENT_POLICY=1&search=' . $CID . '&CLIENT_POLICY_POL_NUM=' . $policy_number);
        die;

} else {
     header('Location: /../../../../../CRMmain.php?AccessDenied');
    die;
}
?>