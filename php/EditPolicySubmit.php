<?php

include($_SERVER['DOCUMENT_ROOT'] . "/classes/access_user/access_user_class.php");
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if (isset($fferror)) {
    if ($fferror == '1') {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

include('../includes/ADL_PDO_CON.php');

$search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$callbackcompletedid = filter_input(INPUT_POST, 'callbackid', FILTER_SANITIZE_NUMBER_INT);

$policyunid = filter_input(INPUT_POST, 'policyunid', FILTER_SANITIZE_SPECIAL_CHARS);
$client_name = filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$sale_date = filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
$application_number = filter_input(INPUT_POST, 'application_number', FILTER_SANITIZE_SPECIAL_CHARS);
$policy_number = filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
$premium = filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$insurer = filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
$commission = filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
$CommissionType = filter_input(INPUT_POST, 'CommissionType', FILTER_SANITIZE_SPECIAL_CHARS);
$PolicyStatus = filter_input(INPUT_POST, 'PolicyStatus', FILTER_SANITIZE_SPECIAL_CHARS);
$edited = filter_input(INPUT_POST, 'edited', FILTER_SANITIZE_SPECIAL_CHARS);
$keyfield = filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_SPECIAL_CHARS);
$policyID = filter_input(INPUT_POST, 'policyID', FILTER_SANITIZE_SPECIAL_CHARS);
$comm_term = filter_input(INPUT_POST, 'comm_term', FILTER_SANITIZE_SPECIAL_CHARS);
$drip = filter_input(INPUT_POST, 'drip', FILTER_SANITIZE_SPECIAL_CHARS);
$soj = filter_input(INPUT_POST, 'soj', FILTER_SANITIZE_SPECIAL_CHARS);
$closer = filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$covera = filter_input(INPUT_POST, 'covera', FILTER_SANITIZE_SPECIAL_CHARS);
$polterm = filter_input(INPUT_POST, 'polterm', FILTER_SANITIZE_SPECIAL_CHARS);

$submitted_date = filter_input(INPUT_POST, 'submitted_date', FILTER_SANITIZE_SPECIAL_CHARS);

if(strpos($client_name, ' and ') !== false) {
    $soj="Joint";
} else {
    $soj="Single";
}

if ($PolicyStatus == "Awaiting") {
    $sale_date = "TBC";
    $policy_number = "TBC $policyunid";
}

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol AND client_id !=:id");
$dupeck->bindParam(':pol', $policy_number, PDO::PARAM_STR);
$dupeck->bindParam(':id', $search, PDO::PARAM_STR);
$dupeck->execute();
$row = $dupeck->fetch(PDO::FETCH_ASSOC);
if ($count = $dupeck->rowCount() >= 1) {
    $dupepol = "$row[policy_number] DUPE";

    $query = $pdo->prepare("SELECT policy_number AS orig_policy FROM client_policy WHERE id=:origpolholder");
    $query->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
    $query->execute();
    $origdetails = $query->fetch(PDO::FETCH_ASSOC);

    $oname = $origdetails['orig_policy'];

    $update = $pdo->prepare("UPDATE client_policy SET submitted_date=:sub, covera=:covera, soj=:soj, client_name=:client_name, sale_date=:sale_date, application_number=:application_number, policy_number=:policy_number, premium=:premium, type=:type, insurer=:insurer, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, edited=:edited, comm_term=:comm_term, drip=:drip, closer=:closer, lead=:lead, polterm=:polterm WHERE id=:origpolholder");
    $update->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
    $update->bindParam(':covera', $covera, PDO::PARAM_INT);
    $update->bindParam(':sub', $submitted_date, PDO::PARAM_STR);
    $update->bindParam(':soj', $soj, PDO::PARAM_STR);
    $update->bindParam(':client_name', $client_name, PDO::PARAM_STR);
    $update->bindParam(':sale_date', $sale_date, PDO::PARAM_STR);
    $update->bindParam(':application_number', $application_number, PDO::PARAM_STR);
    $update->bindParam(':policy_number', $dupepol, PDO::PARAM_STR);
    $update->bindParam(':premium', $premium, PDO::PARAM_INT);
    $update->bindParam(':type', $type, PDO::PARAM_STR);
    $update->bindParam(':insurer', $insurer, PDO::PARAM_STR);
    $update->bindParam(':commission', $commission, PDO::PARAM_INT);
    $update->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
    $update->bindParam(':PolicyStatus', $PolicyStatus, PDO::PARAM_STR);
    $update->bindParam(':edited', $hello_name, PDO::PARAM_STR);
    $update->bindParam(':comm_term', $comm_term, PDO::PARAM_INT);
    $update->bindParam(':drip', $drip, PDO::PARAM_INT);
    $update->bindParam(':closer', $closer, PDO::PARAM_STR);
    $update->bindParam(':lead', $lead, PDO::PARAM_STR);
    $update->bindParam(':polterm', $polterm, PDO::PARAM_STR);
    $update->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
    $update->execute();

    $clientnamedata2 = $client_name;



    $queryTRKn = $pdo->prepare("INSERT INTO policy_number_tracking set new_policy_number=:newpolicyholder, policy_id =:origpolicyid, oldpolicy=:oldpolicyholder ");
    $queryTRKn->bindParam(':newpolicyholder', $policy_number, PDO::PARAM_STR, 500);
    $queryTRKn->bindParam(':oldpolicyholder', $oname, PDO::PARAM_STR, 500);
    $queryTRKn->bindParam(':origpolicyid', $policyunid, PDO::PARAM_STR, 500);
    $queryTRKn->execute();

    $notedata = "Policy Number Updated";
    $messagedata = "Policy number updated $dupepol duplicate of $policy_number";

    $queryNote = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
    $queryNote->bindParam(':clientidholder', $keyfield, PDO::PARAM_INT);
    $queryNote->bindParam(':sentbyholder', $hello_name, PDO::PARAM_STR, 100);
    $queryNote->bindParam(':recipientholder', $client_name, PDO::PARAM_STR, 500);
    $queryNote->bindParam(':noteholder', $notedata, PDO::PARAM_STR, 255);
    $queryNote->bindParam(':messageholder', $messagedata, PDO::PARAM_STR, 2500);
    $queryNote->execute();


    if (isset($fferror)) {
        if ($fferror == '0') {

            header('Location: ../Life/ViewClient.php?policyadded=y&search=' . $keyfield . '&dupepolicy=' . $dupepol . '&origpolicy=' . $policy_number);
            die;
        }
    }
}



$query = $pdo->prepare("SELECT policy_number AS orig_policy FROM client_policy WHERE id=:origpolholder");
$query->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
$query->execute();
$origdetails = $query->fetch(PDO::FETCH_ASSOC);

$oname = $origdetails['orig_policy'];

$update = $pdo->prepare("UPDATE client_policy SET submitted_date=:sub, covera=:covera, soj=:soj, client_name=:client_name, sale_date=:sale_date, application_number=:application_number, policy_number=:policy_number, premium=:premium, type=:type, insurer=:insurer, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, edited=:edited, comm_term=:comm_term, drip=:drip, closer=:closer, lead=:lead, polterm=:polterm WHERE id=:origpolholder");
$update->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
$update->bindParam(':covera', $covera, PDO::PARAM_INT);
$update->bindParam(':soj', $soj, PDO::PARAM_STR);
$update->bindParam(':sub', $submitted_date, PDO::PARAM_STR);
$update->bindParam(':client_name', $client_name, PDO::PARAM_STR);
$update->bindParam(':sale_date', $sale_date, PDO::PARAM_STR);
$update->bindParam(':application_number', $application_number, PDO::PARAM_STR);
$update->bindParam(':policy_number', $policy_number, PDO::PARAM_STR);
$update->bindParam(':premium', $premium, PDO::PARAM_INT);
$update->bindParam(':type', $type, PDO::PARAM_STR);
$update->bindParam(':insurer', $insurer, PDO::PARAM_STR);
$update->bindParam(':commission', $commission, PDO::PARAM_INT);
$update->bindParam(':CommissionType', $CommissionType, PDO::PARAM_STR);
$update->bindParam(':PolicyStatus', $PolicyStatus, PDO::PARAM_STR);
$update->bindParam(':edited', $hello_name, PDO::PARAM_STR);
$update->bindParam(':comm_term', $comm_term, PDO::PARAM_INT);
$update->bindParam(':drip', $drip, PDO::PARAM_INT);
$update->bindParam(':closer', $closer, PDO::PARAM_STR);
$update->bindParam(':lead', $lead, PDO::PARAM_STR);
$update->bindParam(':polterm', $polterm, PDO::PARAM_STR);
$update->bindParam(':origpolholder', $policyunid, PDO::PARAM_INT);
$update->execute();

$clientnamedata2 = $client_name;



$changereason = filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($changereason)) {

    if ($changereason == 'Incorrect Policy Number') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);



        $query = $pdo->prepare("INSERT INTO policy_number_tracking set new_policy_number=:newpolicyholder, policy_id =:origpolicyid, oldpolicy=:oldpolicyholder ");
        $query->bindParam(':newpolicyholder', $policy_number, PDO::PARAM_STR, 500);
        $query->bindParam(':oldpolicyholder', $oname, PDO::PARAM_STR, 500);
        $query->bindParam(':origpolicyid', $policyunid, PDO::PARAM_STR, 500);
        $query->execute();

        $notedata = "Policy Number Updated";
        $clientnamedata = $policyunid . " - " . $policy_number;
        $messagedata = $oname . " changed to " . $policy_number;

        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

        $query->bindParam(':clientidholder', $keyfield, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder', $clientnamedata, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder', $notedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();

    }



    $clientnamedata = $policyunid . " - " . $policy_number;
    $notedata = "Policy Details Updated";

    $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

    $query->bindParam(':clientidholder', $keyfield, PDO::PARAM_INT);
    $query->bindParam(':sentbyholder', $hello_name, PDO::PARAM_STR, 100);
    $query->bindParam(':recipientholder', $clientnamedata, PDO::PARAM_STR, 500);
    $query->bindParam(':noteholder', $notedata, PDO::PARAM_STR, 255);
    $query->bindParam(':messageholder', $changereason, PDO::PARAM_STR, 2500);
    $query->execute();
}

if (isset($fferror)) {
    if ($fferror == '0') {

        header('Location: ../Life/ViewClient.php?policyedited=y&search=' . $keyfield);
        die;
    }
}
?>