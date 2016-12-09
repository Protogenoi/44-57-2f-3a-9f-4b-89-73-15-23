<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;
include('../../classes/database_class.php');
include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
                                                $cb= filter_input(INPUT_GET, 'cb', FILTER_SANITIZE_SPECIAL_CHARS);
                                            if(isset($cb)){
                                                $callbackcompletedyn= filter_input(INPUT_GET, 'cb', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $callbackcompletedid= filter_input(INPUT_GET, 'callbackid', FILTER_SANITIZE_NUMBER_INT);
                                                if ($callbackcompletedyn =='y') {
                                                    $query = $pdo->prepare("UPDATE scheduled_pension_callbacks set complete='y', edited_by=:hello where id = :callbackidyes");
                                                    $query->bindParam(':callbackidyes', $callbackcompletedid, PDO::PARAM_INT);
                                                    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR);
                                                    $query->execute();
                                                  
                                                    header('Location: ../../calendar/calendar.php?callback=complete&callbackid'.$callbackcompletedid); die;
                                                    
                                                }
                                                
                                                if ($callbackcompletedyn =='n') {
                                                    $query = $pdo->prepare("UPDATE scheduled_pension_callbacks set complete='n' , edited_by=:hello where id = :callbackidno");
                                                    $query->bindParam(':callbackidno', $callbackcompletedid, PDO::PARAM_INT);
                                                    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR);
                                                    $query->execute();
                                                
                                                    header('Location: ../../calendar/calendar.php?callback=incomplete'); die;
                                                    
                                                } 
                                                
                                                     if ($callbackcompletedyn =='yV') {
                                                         
                                                         $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
                                                         
                                                    $query = $pdo->prepare("UPDATE scheduled_pension_callbacks set complete='y' , edited_by=:hello where id = :callbackidyes");
                                                    $query->bindParam(':callbackidyes', $callbackcompletedid, PDO::PARAM_INT);
                                                    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR);
                                                    $query->execute();
                                                  
                                                    header('Location: ../ViewClient.php?Addcallback=complete&callbackid'.$callbackcompletedid.'&search='.$search); die;
                                                    
                                                }
                                                
                                                if ($callbackcompletedyn =='nV') {
                                                    
                                                    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
                                                    
                                                    $query = $pdo->prepare("UPDATE scheduled_pension_callbacks set complete='n' , edited_by=:hello where id = :callbackidno");
                                                    $query->bindParam(':callbackidno', $callbackcompletedid, PDO::PARAM_INT);
                                                    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR);
                                                    $query->execute();
                                                
                                                    header('Location: ../ViewClient.php?Addcallback=incomplete&search='.$search); die;
                                                    
                                                } 
                                                
                                                }


   $callsub = filter_input(INPUT_POST, 'callsub', FILTER_SANITIZE_NUMBER_INT);
   if(isset($callsub)){

        $database = new Database(); 
        $database->beginTransaction();
        
       $getcallback_date= filter_input(INPUT_POST, 'callbackdate', FILTER_SANITIZE_SPECIAL_CHARS);
       $getcallback_time= filter_input(INPUT_POST, 'callbacktime', FILTER_SANITIZE_SPECIAL_CHARS);
       $getcallback_client= filter_input(INPUT_POST, 'callbackclient', FILTER_SANITIZE_SPECIAL_CHARS);
       $getcallback_notes= filter_input(INPUT_POST, 'callbacknotes', FILTER_SANITIZE_SPECIAL_CHARS);
       $assign= filter_input(INPUT_POST, 'assign', FILTER_SANITIZE_SPECIAL_CHARS);
       $callreminder= filter_input(INPUT_POST, 'callreminder', FILTER_SANITIZE_SPECIAL_CHARS);
       $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
       $calltype= filter_input(INPUT_POST, 'calltype', FILTER_SANITIZE_SPECIAL_CHARS);
       $callremindeed =  date("H:i:s",  strtotime($callreminder, strtotime($getcallback_time)));
       
       if(isset($calltype)) {
           if($calltype=='Quickdox Appointment') {
        $getcallback_notes="$calltype: $getcallback_notes";       
           }
       }
       
       
       $database->query("INSERT INTO scheduled_pension_callbacks set reminder=:reminder, assign=:assign, callback_time=:callback_time, callback_date=:callback_date, client_id = :searchplaceholder, client_name =:clientnameplaceholder, submitted_by =:submtterplaceholder, notes =:callbacknotesvar");
       $database->bind(':searchplaceholder', $search);
       $database->bind(':reminder', $callremindeed);
       $database->bind(':clientnameplaceholder', $getcallback_client);
       $database->bind(':assign', $assign);
       $database->bind(':callback_time', $getcallback_time);
       $database->bind(':callback_date', $getcallback_date);
       $database->bind(':submtterplaceholder', $hello_name);
       $database->bind(':callbacknotesvar', $getcallback_notes);
       $database->execute();
  if($calltype=='Quickdox Appointment') {
$calldate = strtotime ( '-1 day' , strtotime ( $getcallback_date ) ) ;
$calldate=date("Y-m-d",$calldate);

  $getcallback_notes_reminder="Quickdox Appointment Reminder: $getcallback_notes";     
       $database->query("INSERT INTO scheduled_pension_callbacks set reminder=:reminder, assign=:assign, callback_time=:callback_time, callback_date=:callback_date, client_id = :searchplaceholder, client_name =:clientnameplaceholder, submitted_by =:submtterplaceholder, notes =:callbacknotesvar");
       $database->bind(':searchplaceholder', $search);
       $database->bind(':reminder', $callremindeed);
       $database->bind(':clientnameplaceholder', $getcallback_client);
       $database->bind(':assign', $assign);
       $database->bind(':callback_time', $getcallback_time);
       $database->bind(':callback_date', $calldate);
       $database->bind(':submtterplaceholder', $hello_name);
       $database->bind(':callbacknotesvar', $getcallback_notes_reminder);
       $database->execute();
  }
       if(isset($ffcalendar)) { 
           if($ffcalendar=='1') {
               
               $calendar_start= "$getcallback_date $getcallback_time";
               $calendar_name=" $getcallback_time - $getcallback_client ($search) - $getcallback_notes";
               
               $database->query("INSERT INTO evenement set start=:start, end=:end, title=:title, assigned_to=:assign");
               $database->bind(':assign', $assign);
               $database->bind(':start', $calendar_start);
               $database->bind(':end', $calendar_start);
               $database->bind(':title', $calendar_name);
               $database->execute();
    if($calltype=='Quickdox Appointment') {
        
                $calendar_start= "$calldate $getcallback_time";
               $calendar_name=" $getcallback_time - $getcallback_client ($search) - $getcallback_notes_reminder";
               
               $database->query("INSERT INTO evenement set start=:start, end=:end, title=:title, assigned_to=:assign");
               $database->bind(':assign', $assign);
               $database->bind(':start', $calendar_start);
               $database->bind(':end', $calendar_start);
               $database->bind(':title', $calendar_name);
               $database->execute();   
        
        
    }            
               
           }
           
           }
           
           if($calltype=='Quickdox Appointment') {
            
           $notetypedata= "Callback $calldate $getcallback_time"; 
           $messagetime= "Assigned to $assign | Notes: $getcallback_notes_reminder";
           
           $database->query("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
           $database->bind(':clientidholder',$search);
           $database->bind(':sentbyholder',$hello_name);
           $database->bind(':recipientholder',$getcallback_client);
           $database->bind(':noteholder',$notetypedata);
           $database->bind(':messageholder',$messagetime);
           $database->execute();    
               
               
           }
           
           $notetypedata= "Callback $getcallback_date $getcallback_time"; 
           $messagetime= "Assigned to $assign | Notes: $getcallback_notes";
           
           $database->query("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
           $database->bind(':clientidholder',$search);
           $database->bind(':sentbyholder',$hello_name);
           $database->bind(':recipientholder',$getcallback_client);
           $database->bind(':noteholder',$notetypedata);
           $database->bind(':messageholder',$messagetime);
           $database->execute();
           
           $database->endTransaction();
           
           if ($database->rowCount()>0) {
               
               header('Location: ../ViewClient.php?CallbackSet=1&search='.$search.'&CallbackTime='.$getcallback_time.'&CallbackDate='.$getcallback_date); die;
                              
           }
           
           else {
               
               header('Location: ../ViewClient.php?CallbackSet=0&search='.$search); die;
               
              
               }
               
           }


          
          header('Location: ../../CRMmain.php'); die;