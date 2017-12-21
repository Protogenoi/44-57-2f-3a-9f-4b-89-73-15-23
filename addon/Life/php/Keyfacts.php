<?php
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

if(isset($ffkeyfactsemail) && $ffkeyfactsemail=='0') {
    header('Location: /../../../../CRMmain.php?Feature=NotEnabled'); die;
}

        $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
        $EMAIL= filter_input(INPUT_GET, 'EMAIL', FILTER_SANITIZE_EMAIL);
        
if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
    
    $database = new Database(); 
    $database->beginTransaction();
                
            $database->query("INSERT INTO keyfactsemail set keyfactsemail_email=:EMAIL, keyfactsemail_added_by=:NAME");
            $database->bind(':NAME',$hello_name);
            $database->bind(':EMAIL',$EMAIL);
            $database->execute(); 
            
            $database->endTransaction();
    }

    
        }

header('Location: ../Reports/Keyfacts.php?SEARCH=NotSent&RETURN=IGNORE'); die;
?>