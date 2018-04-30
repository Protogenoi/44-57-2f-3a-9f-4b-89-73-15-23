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

if (isSET($fferror)) {
    if ($fferror == '0') {
        ini_SET('display_errors', 1);
        ini_SET('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    
        $database = new Database(); 
        $database->beginTransaction();       

    $CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($EXECUTE == '1') {

        $REF = filter_input(INPUT_POST, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
        $TYPE = filter_input(INPUT_POST, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $INDEXATION = filter_input(INPUT_POST, 'INDEXATION', FILTER_SANITIZE_SPECIAL_CHARS);
        $ESCALATION = filter_input(INPUT_POST, 'ESCALATION', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM_TYPE = filter_input(INPUT_POST, 'PREMIUM_TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM = filter_input(INPUT_POST, 'PREMIUM', FILTER_SANITIZE_SPECIAL_CHARS);
        $PERIOD = filter_input(INPUT_POST, 'PERIOD', FILTER_SANITIZE_SPECIAL_CHARS);
        $BENEFIT_AMOUNT = filter_input(INPUT_POST, 'BENEFIT_AMOUNT', FILTER_SANITIZE_SPECIAL_CHARS);
        $DEFERRED_PERIOD = filter_input(INPUT_POST, 'DEFERRED_PERIOD', FILTER_SANITIZE_SPECIAL_CHARS);
        $TERM = filter_input(INPUT_POST, 'TERM', FILTER_SANITIZE_SPECIAL_CHARS);
        
        
                $database->query("SELECT vitality_policy_id from vitality_policy where vitality_policy_ref=:REF");
        $database->bind(':REF', $REF);
        $database->execute();           
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $ID_FK=$row['vitality_policy_id'];

            $database->query("INSERT INTO vitality_income_benefit SET 
 vitality_income_benefit_id_fk=:ID_FK,
 vitality_income_benefit_type=:TYPE,
 vitality_income_benefit_period=:PERIOD,
 vitality_income_benefit_deferred_period=:DEF_PERIOD,
 vitality_income_benefit_term=:TERM,
 vitality_income_benefit_indexation=:INDEXATION,
 vitality_income_benefit_escalation=:ESCALATION,
 vitality_income_benefit_premium=:PREMIUM,
 vitality_income_benefit_premium_type=:PREMIUM_TYPE");
            $database->bind(':ID_FK', $ID_FK);
            $database->bind(':TYPE', $TYPE);
            $database->bind(':PERIOD',$PERIOD);
            $database->bind(':DEF_PERIOD',$DEFERRED_PERIOD);
            $database->bind(':TERM',$TERM);
            $database->bind(':INDEXATION',$INDEXATION);
            $database->bind(':ESCALATION',$ESCALATION);
            $database->bind(':PREMIUM',$PREMIUM);
            $database->bind(':PREMIUM_TYPE', $PREMIUM_TYPE);
            $database->execute(); 
            $lastid =  $database->lastInsertId(); 

        $messagedata = "Income benefit added for $REF";
        $CLIENT_NAME="ADL Alert";

        $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Option Added', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER', $CLIENT_NAME, PDO::PARAM_STR, 500);
        $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
        $database->endTransaction(); 
        
       header('Location: /../../../../../app/Client.php?CLIENT_POLICY=3&search=' . $CID . '&CLIENT_POLICY_POL_NUM=' . $REF);
       die;                               
                


    }  }

        }
        
?>