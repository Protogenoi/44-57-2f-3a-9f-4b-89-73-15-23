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

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_SET('display_errors', 1);
        ini_SET('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    
        $database = new Database(); 
        $database->beginTransaction();       

    if ($EXECUTE == '1') {

     $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS); 
    
        $POLICY_REF= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $CLIENT_NAME= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $SALE_DATE= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM= filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
        $TYPE= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $INSURER= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
        $COMMS= filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
        $POLICY_STATUS= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $CLOSER= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
        $AGENT= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
        $COVER_AMOUNT= filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_SPECIAL_CHARS);    
        
        if(isset($INSURER) && $INSURER == 'Ageas') {

                
        $database->query("SELECT ageas_home_insurance_ref FROM ageas_home_insurance WHERE ageas_home_insurance_ref=:REF");
        $database->bind(':REF', $POLICY_REF);
        $database->execute();           
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupepol="$row[ageas_home_insurance_ref] DUPE";
            $POLICY_STATUS = "On Hold";

$database->query("INSERT INTO adl_policy SET 
 adl_policy_client_id_fk=:CID,
 adl_policy_ref=:REF,
 adl_policy_insurer=:INSURER,
 adl_policy_policy_holder=:HOLDER,
 adl_policy_added_by=:WHO,
 adl_policy_closer=:CLOSER,
 adl_policy_agent=:AGENT,
 adl_policy_sale_date=:SALE_DATE,
 adl_policy_sub_date=:SUB_DATE,
 adl_policy_status=:STATUS");
            $database->bind(':CID', $CID);
            $database->bind(':REF', $dupepol);
            $database->bind(':INSURER', $INSURER);
            $database->bind(':HOLDER',$CLIENT_NAME);
            $database->bind(':WHO',$hello_name);
            $database->bind(':CLOSER',$CLOSER);
            $database->bind(':AGENT',$AGENT);
            $database->bind(':SALE_DATE',$SALE_DATE);
            $database->bind(':SUB_DATE',$SALE_DATE);
            $database->bind(':STATUS', $POLICY_STATUS);
            $database->execute();
            $lastid =  $database->lastInsertId();     
            
     if ($database->rowCount()> 0) {         

            $database->query("INSERT INTO ageas_home_insurance SET 
 ageas_home_insurance_id_fk=:PID,
 ageas_home_insurance_ref=:REF,
 ageas_home_insurance_type=:TYPE,
 ageas_home_insurance_commission=:COMM
 ageas_home_insurance_premium=:PREMIUM,
 ageas_home_insurance_Cover=:COVER_AMOUNT");
            $database->bind(':PID', $lastid);
            $database->bind(':REF', $dupepol);
            $database->bind(':TYPE',$TYPE);
            $database->bind(':PREMIUM', $PREMIUM);
            $database->bind(':COMM', $COMMS);
            $database->bind(':COVER_AMOUNT', $COVER_AMOUNT);
            $database->execute(); 
            $lastid =  $database->lastInsertId(); 

            $database->endTransaction();  

        $messagedata = "Home insurance policy added $dupepol duplicate of $POLICY_REF";

        $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER', $CLIENT_NAME, PDO::PARAM_STR, 500);
        $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();

            $client_type = $pdo->prepare("UPDATE client_details SET client_type='Home' WHERE client_id =:CID");
            $client_type->bindParam(':CID', $CID, PDO::PARAM_STR);
            $client_type->execute();
            
            

                    header('Location: ../../../app/Client.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $POLICY_REF);
                    die;
     }
            
        }
            
$database->query("INSERT INTO adl_policy SET 
 adl_policy_client_id_fk=:CID,
 adl_policy_ref=:REF,
 adl_policy_insurer=:INSURER,
 adl_policy_policy_holder=:HOLDER,
 adl_policy_added_by=:WHO,
 adl_policy_closer=:CLOSER,
 adl_policy_agent=:AGENT,
 adl_policy_sale_date=:SALE_DATE,
 adl_policy_sub_date=:SUB_DATE,
 adl_policy_status=:STATUS");
            $database->bind(':CID', $CID);
            $database->bind(':REF', $POLICY_REF);
            $database->bind(':INSURER', $INSURER);
            $database->bind(':HOLDER',$CLIENT_NAME);
            $database->bind(':WHO',$hello_name);
            $database->bind(':CLOSER',$CLOSER);
            $database->bind(':AGENT',$AGENT);
            $database->bind(':SALE_DATE',$SALE_DATE);
            $database->bind(':SUB_DATE',$SALE_DATE);
            $database->bind(':STATUS', $POLICY_STATUS);
            $database->execute();
            $lastid =  $database->lastInsertId();            
    
            if ($database->rowCount()> 0) { 

                        $database->query("INSERT INTO ageas_home_insurance SET 
 ageas_home_insurance_id_fk=:PID,
 ageas_home_insurance_ref=:REF,
 ageas_home_insurance_type=:TYPE,
 ageas_home_insurance_commission=:COMM,
 ageas_home_insurance_premium=:PREMIUM,
 ageas_home_insurance_Cover=:COVER_AMOUNT");
            $database->bind(':PID', $lastid);
            $database->bind(':REF', $POLICY_REF);
            $database->bind(':TYPE',$TYPE);
            $database->bind(':PREMIUM', $PREMIUM);
            $database->bind(':COMM', $COMMS);
            $database->bind(':COVER_AMOUNT', $COVER_AMOUNT);
            $database->execute(); 
            $lastid =  $database->lastInsertId(); 
            
                $notedata= "Policy Added";
                $messagedata="Home insurance policy $POLICY_REF added";
                
                $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
                $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                $query->bindParam(':recipientholder',$CLIENT_NAME, PDO::PARAM_STR, 500);
                $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
                $query->execute(); 

        
        $database->endTransaction(); 
        
       header('Location: /../../../../../app/Client.php?CLIENT_POLICY=1&search=' . $CID . '&CLIENT_POLICY_POL_NUM=' . $POLICY_REF);
       die;                      
            }           

        }
        
} 

        }
?>

