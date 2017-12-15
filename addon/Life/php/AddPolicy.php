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

if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 

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

            echo "duepde $dupepol";

            $insert = $pdo->prepare("INSERT INTO client_policy set 
client_id=:cid,
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
 polterm=:polterm");
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

        $insert = $pdo->prepare("INSERT INTO client_policy set client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
        $insert->bindParam(':cid', $CID, PDO::PARAM_STR);
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
    }
}


if (isset($fferror)) {
    if ($fferror == '0') {

        header('Location: /../../../../../app/Client.php?CLIENT_POLICY=1&search=' . $CID . '&CLIENT_POLICY_POL_NUM=' . $policy_number);
        die;
    }
}

} else {
     header('Location: /../../../../../CRMmain.php?AccessDenied');
    die;
}
?>