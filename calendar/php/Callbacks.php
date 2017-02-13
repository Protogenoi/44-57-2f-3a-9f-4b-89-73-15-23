<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='4') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
include('../../classes/database_class.php');

if(isset($fflife)) {
    if($fflife=='1') {
        
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
        $cb= filter_input(INPUT_GET, 'cb', FILTER_SANITIZE_SPECIAL_CHARS);
        $CBK_ID= filter_input(INPUT_GET, 'callbackid', FILTER_SANITIZE_NUMBER_INT);
        
        if(isset($cb)){
            if($cb=='c'){

        $database = new Database(); 
        $database->beginTransaction();

       $CBK_DATE= filter_input(INPUT_POST, 'callbackdate', FILTER_SANITIZE_SPECIAL_CHARS);
       $CBK_TIME= filter_input(INPUT_POST, 'callbacktime', FILTER_SANITIZE_SPECIAL_CHARS);
       $CBK_NAME= filter_input(INPUT_POST, 'callbackclient', FILTER_SANITIZE_SPECIAL_CHARS);
       $CBK_NOTES= filter_input(INPUT_POST, 'callbacknotes', FILTER_SANITIZE_SPECIAL_CHARS);
       $CBK_ASSIGN= filter_input(INPUT_POST, 'assign', FILTER_SANITIZE_SPECIAL_CHARS);
       $CBK_REM= filter_input(INPUT_POST, 'callreminder', FILTER_SANITIZE_SPECIAL_CHARS);
       $callremindeed =  date("H:i:s",  strtotime($CBK_REM, strtotime($CBK_TIME)));
       
       $database->query("UPDATE scheduled_callbacks set reminder=:reminder, assign=:assign, callback_time=:time, callback_date=:date, client_name =:client, edited_by =:submtter, notes =:note WHERE id=:id");
       $database->bind(':id', $CBK_ID);
       $database->bind(':reminder', $callremindeed);
       $database->bind(':client', $CBK_NAME);
       $database->bind(':assign', $CBK_ASSIGN);
       $database->bind(':time', $CBK_TIME);
       $database->bind(':date', $CBK_DATE);
       $database->bind(':submtter', $CBK_ASSIGN);
       $database->bind(':note', $CBK_NOTES);
       $database->execute();
       
       if(isset($ffcalendar)) { 
           if($ffcalendar=='1') {
               
               $calendar_start= "$CBK_DATE $CBK_TIME";
               $calendar_name=" $CBK_TIME - $CBK_NAME ($search) - $CBK_NOTES";
               
               $database->query("INSERT INTO evenement set start=:start, end=:end, title=:title, assigned_to=:assign");
               $database->bind(':assign', $CBK_ASSIGN);
               $database->bind(':start', $calendar_start);
               $database->bind(':end', $calendar_start);
               $database->bind(':title', $calendar_name);
               $database->execute();
               
           }
           
           }
           
           $notetypedata= "Callback"; 
           $messagetime= "Time $CBK_DATE $CBK_TIME | Notes: $CBK_NOTES (Assigned to $CBK_ASSIGN)";
           
           $database->query("INSERT INTO client_note set client_id=:id, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message");
           $database->bind(':id',$search);
           $database->bind(':sent',$hello_name);
           $database->bind(':recipient',$CBK_NAME);
           $database->bind(':note',$notetypedata);
           $database->bind(':message',$messagetime);
           $database->execute();

           $database->endTransaction();
           
           if ($database->rowCount()>0) {
               
              header('Location: /calendar/calendar.php?callback=complete&callbackid='.$CBK_ID); die;
                              
           }
           
           else {
               
               header('Location: /calendar/calendar.php?callback=complete&callbackid='.$CBK_ID); die;
               
              
               }
               
           } 
           }
        
    }
    }
          
          header('Location: ../../CRMmain.php'); die;