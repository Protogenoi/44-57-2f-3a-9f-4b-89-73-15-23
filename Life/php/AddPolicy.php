<?php
include($_SERVER['DOCUMENT_ROOT'] . "/classes/access_user/access_user_class.php");
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');

if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 

if (isset($fferror)) {
    if ($fferror == '1') {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {

    $CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($EXECUTE == '1') {

        include('../../includes/ADL_PDO_CON.php');

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


        if ($PolicyStatus == "Awaiting") {
            $sale_date = "TBC";
            $DATE = date("Y/m/d h:i:s");
            $DATE_FOR_TBC_POL = preg_replace("/[^0-9]/", "", $DATE);

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


            $notedata = "Policy Added";
            $messagedata = "Policy added $dupepol duplicate of $policy_number";

            $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $query->bindParam(':clientidholder', $CID, PDO::PARAM_INT);
            $query->bindParam(':sentbyholder', $hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':recipientholder', $client_name, PDO::PARAM_STR, 500);
            $query->bindParam(':noteholder', $notedata, PDO::PARAM_STR, 255);
            $query->bindParam(':messageholder', $messagedata, PDO::PARAM_STR, 2500);
            $query->execute();

            $client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id', $CID, PDO::PARAM_STR);
            $client_type->execute();

            if (isset($fferror)) {
                if ($fferror == '0') {

                    header('Location: ../../Life/ViewClient.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $policy_number);
                    die;
                }
            }
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


        $notedata = "Policy Added";
        $messagedata = "Policy $policy_number added";

        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':clientidholder', $CID, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder', $client_name, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder', $notedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
    }
}


if (isset($fferror)) {
    if ($fferror == '0') {

        header('Location: ../../Life/ViewClient.php?policyadded=y&search=' . $CID . '&policy_number=' . $policy_number);
        die;
    }
}

} else {
     header('Location: ../../CRMmain.php?AccessDenied');
    die;
}
?>