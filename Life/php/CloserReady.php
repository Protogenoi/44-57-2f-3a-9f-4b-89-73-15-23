<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($ffdealsheets) && $ffdealsheets=='0') {
    header('Location: ../../CRMmain.php?Feature=NotEnabled'); die;
}

        $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
        $SEND_LEAD= filter_input(INPUT_POST, 'SEND_LEAD', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        
            include('../../includes/Access_Levels.php');
    include('../../classes/database_class.php');
    
    $database = new Database(); 
        $database->beginTransaction();
        
            $database->query("SELECT closer FROM dealsheet_call WHERE closer=:CLOSER");
            $database->bind(':CLOSER',$hello_name);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
            $database->query("DELETE FROM dealsheet_call WHERE closer=:CLOSER");
            $database->bind(':CLOSER',$hello_name);
            $database->execute();                     
                
            }
  
            else {
                
            $database->query("INSERT INTO dealsheet_call set agent=:agent, closer=:CLOSER");
            $database->bind(':CLOSER',$hello_name);
            $database->bind(':agent',$SEND_LEAD);
            $database->execute(); 
            
            }
            
  $database->endTransaction();
    }

    
        }

header('Location: ../LifeDealSheet.php?query=CloserTrackers'); die;
?>
