<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');

if(isset($ffkeyfactsemail) && $ffkeyfactsemail=='0') {
    header('Location: ../../CRMmain.php?Feature=NotEnabled'); die;
}

        $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
        $EMAIL= filter_input(INPUT_GET, 'EMAIL', FILTER_SANITIZE_EMAIL);
        
if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        
    include('../../classes/database_class.php');
    
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
