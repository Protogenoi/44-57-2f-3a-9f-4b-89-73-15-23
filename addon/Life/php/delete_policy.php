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
    $PID = filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_SPECIAL_CHARS);
    $HOLDER = filter_input(INPUT_GET, 'HOLDER', FILTER_SANITIZE_SPECIAL_CHARS);
    $REF = filter_input(INPUT_GET, 'POL', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($EXECUTE == 1) {             
            
        $database->query("DELETE FROM adl_policy WHERE adl_policy_id=:PID AND adl_policy_client_id_fk =:CID LIMIT 1");
        $database->bind(':PID', $PID);
        $database->bind(':CID', $CID);
        $database->execute();  
        
        $notes= "Policy $REF ($PID)";
        $notetypedata= "Policy Deleted";
        
        $query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type=:NOTE, message=:MSG");
        $query->bindParam(':CID',$CID, PDO::PARAM_INT);
        $query->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER',$HOLDER, PDO::PARAM_STR, 500);
        $query->bindParam(':NOTE',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':MSG',$notes, PDO::PARAM_STR, 2500);
        $query->execute();        
        
        $database->endTransaction(); 
        
        header('Location: /../../../../../app/Client.php?deletedpolicy=y&search='.$CID); die;
                
            }
            
}
       
?>