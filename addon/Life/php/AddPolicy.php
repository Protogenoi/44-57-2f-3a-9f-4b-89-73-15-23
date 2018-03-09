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

if(isSET($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isSET($fferror)) {
    if ($fferror == '0') {
        ini_SET('display_errors', 1);
        ini_SET('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

if (in_array($hello_name, $Level_3_Access, true)) { 

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isSET($EXECUTE)) {

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

            $insert = $pdo->prepare("INSERT INTO client_policy SET 
 client_id=:CID,
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
            $insert->bindParam(':CID', $CID, PDO::PARAM_STR);
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

            $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
            $query->bindParam(':CID', $CID, PDO::PARAM_INT);
            $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':HOLDER', $client_name, PDO::PARAM_STR, 500);
            $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
            $query->execute();

            $client_type = $pdo->prepare("UPDATE client_details SET client_type='Life' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id', $CID, PDO::PARAM_STR);
            $client_type->execute();

                    header('Location: ../../../app/Client.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $policy_number);
                    die;

        }

        $insert = $pdo->prepare("INSERT INTO client_policy SET non_indem_com=:NONIDEM, client_id=:CID, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
        $insert->bindParam(':CID', $CID, PDO::PARAM_STR);
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

        $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER', $client_name, PDO::PARAM_STR, 500);
        $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
        $database = new Database(); 
        $database->beginTransaction();    
                
        $database->query("SELECT life_tasks_client_id FROM life_tasks WHERE life_tasks_client_id=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            
            
        } else {
    
                $weekarray=array('Mon','Tue','Wed','Thu','Fri');
                $today=date("D"); // check Day Mon - Sun
                $date=date("Y-m-d",strtotime($today)); // Convert day to date
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='48'");
                $database->execute();
                $assign48d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='7 day'");
                $database->execute();
                $assign5d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
                $database->execute();
                $assign18d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='21 day'");
                $database->execute();
                $assign21d=$database->single();                
                
                $assign48=$assign48d['Assigned'];
                $assign5=$assign5d['Assigned'];
                $assign18=$assign18d['Assigned'];
                $assign21=$assign21d['Assigned'];
                
                $task48="48";
                
                $next48 = date("D", strtotime("+2 day")); 
                if($next48 =="Sat") { 
                    $SkipWeekEndDay48 = date("Y-m-d", strtotime("+4 day")); 
                    $deadline48=$SkipWeekEndDay48;
                    
                }
                
                if($next48=="Sun") { 
                    $SkipWeekEndDay48 = date("Y-m-d", strtotime("+3 day")); 
                    $deadline48=$SkipWeekEndDay48;
                    
                }
                
                if (in_array($next48,$weekarray,true)){
                    $WeekDay48 = date("Y-m-d", strtotime("+2 day"));
                    $deadline48=$WeekDay48;
                    
                } 
                
                $task5="7 day";
                $next5 = date("D", strtotime("+7 day")); // Add 2 to Day
               
                if($next5 =="Sat") { //Check if Weekend
                    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+8 day")); //Add extra 2 Days if Sat Weekend
                    $deadline5=$SkipWeekEndDay5;
                    
                }
                
                if($next5=="Sun") { //Check if Weekend
    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+8 day")); //Add extra 1 day if Sunday
    $deadline5=$SkipWeekEndDay5;

}


if (in_array($next5,$weekarray,true)){

$WeekDay5 = date("Y-m-d", strtotime("+7 day"));

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


if (in_array($next18,$weekarray,true)) {

$WeekDay18 = date("Y-m-d", strtotime("+18 day"));
$deadline18=$WeekDay18;

}

$task21="21 day";
$next21 = date("D", strtotime("+21 day")); // Add 2 to Day

if($next21 =="Sat") { //Check if Weekend

    $SkipWeekEndDay21 = date("Y-m-d", strtotime("+23 day")); //Add extra 2 Days if Sat Weekend

    $deadline21=$SkipWeekEndDay21;

}

if($next21=="Sun") { //Check if Weekend

    $SkipWeekEndDay21 = date("Y-m-d", strtotime("+22 day")); //Add extra 1 day if Sunday

    $deadline21=$SkipWeekEndDay21;

}


if (in_array($next21,$weekarray,true)) {

$WeekDay21 = date("Y-m-d", strtotime("+21 day"));
$deadline21=$WeekDay21;

}
        
        $database->query("INSERT INTO life_tasks SET life_tasks_client_id=:CID, life_tasks_assigned=:assign, life_tasks_task=:task, life_tasks_deadline=:deadline");
        $database->bind(':assign', $assign48, PDO::PARAM_STR);
        $database->bind(':task', $task48, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline48, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO life_tasks SET life_tasks_client_id=:CID, life_tasks_assigned=:assign, life_tasks_task=:task, life_tasks_deadline=:deadline");
        $database->bind(':assign', $assign5, PDO::PARAM_STR);
        $database->bind(':task', $task5, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline5, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO life_tasks SET life_tasks_client_id=:CID, life_tasks_assigned=:assign, life_tasks_task=:task, life_tasks_deadline=:deadline");
        $database->bind(':assign', $assign18, PDO::PARAM_STR);
        $database->bind(':task', $task18, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline18, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("INSERT INTO life_tasks SET life_tasks_client_id=:CID, life_tasks_assigned=:assign, life_tasks_task=:task, life_tasks_deadline=:deadline");
        $database->bind(':assign', $assign21, PDO::PARAM_STR);
        $database->bind(':task', $task21, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline21, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();        
        
        $notedata= "Tasks added!";
        $REF= "CRM Alert";
        $messagedata="All tasks have been assigned to this client";
                
                $database->query("INSERT INTO client_note SET client_id=:CID, client_name=:recipientholder, sent_by='ADL', note_type=:NOTE, message=:MSG ");
                $database->bind(':CID',$CID);
                $database->bind(':recipientholder',$REF);
                $database->bind(':NOTE',$notedata);
                $database->bind(':MSG',$messagedata);
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