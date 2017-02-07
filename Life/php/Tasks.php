<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 7); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain'); die;

}
    
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    $REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);

    include('../../classes/database_class.php');
    
    if($EXECUTE=='1') {
          
            $database = new Database();
            $database->beginTransaction();

            $database->query("SELECT client_id, task from Client_Tasks WHERE id=:REF");
            $database->bind(':REF',$REF);
            $database->execute();     
            $result=$database->single();
            
            $SEARCH=$result['client_id'];
            $TASK=$result['task'];
                        
            if ($database->rowCount()>=1) {
                
            $database->query("UPDATE Client_Tasks set complete='1' WHERE id=:REF");
            $database->bind(':REF',$REF);
            $database->execute(); 

        $RECIPIENT="Task Updated";
        $MESSAGE="Updated from task menu";
        $TASKS="Task $TASK";
            
            $database->query("INSERT INTO client_note set client_id=:client, client_name=:recipient, sent_by=:hello, note_type=:note, message=:message");
            $database->bind(':client',$SEARCH);
            $database->bind(':hello',$hello_name);    
            $database->bind(':recipient',$RECIPIENT);
            $database->bind(':note',$TASKS); 
            $database->bind(':message',$MESSAGE); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Reports/Tasks.php?RETURN=TASKUPDATED'); die;
            }

            $database->endTransaction();
            
            header('Location: ../Reports/Tasks.php?RETURN=error'); die;

    } 
    
}
            
?>