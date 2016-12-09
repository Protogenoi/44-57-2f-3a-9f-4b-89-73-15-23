<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    $stageid= filter_input(INPUT_GET, 'stageid', FILTER_SANITIZE_NUMBER_INT);
    $stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_SPECIAL_CHARS);
    $complete= filter_input(INPUT_GET, 'complete', FILTER_SANITIZE_SPECIAL_CHARS);
    $task= filter_input(INPUT_GET, 'Task', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($stage)) {
        if($stage=='1') {
            include('../../classes/database_class.php');
            include('../../includes/adlfunctions.php');  
            
            $database = new Database(); 
           
            if($complete=='1') {
            
            $database->query("UPDATE pension_stages set updated_by=:hello, complete='Yes' where stage_id=:stageid");
            $database->bind(':stageid',$stageid);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
                   
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1";
            $messagedata="$task marked as complete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute(); 
            
            $database->query("SELECT complete from pension_stages where client_id=:client and stage='1' and complete='Yes'");
            $database->bind(':client',$search);
            $database->execute();
            
            if ($database->rowCount()>=5) {
                
                $database->query("UPDATE pension_stages set stage_complete='Y', complete='Yes', updated_by=:hello where client_id=:client and stage='1'");
                $database->bind(':client',$search);
                $database->bind(':hello',$hello_name);
                $database->execute();   

            $notedata= "Task Updated";
            $clientnamedata= "Stage 1";
            $messagedata="Stage 1 completed";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute();    
            
              header('Location: ../ViewClient.php?StageOne=StageComplete&Task='.$task.'&search='.$search); die;  
            }

            header('Location: ../ViewClient.php?StageOne=TaskComplete&Task='.$task.'&search='.$search); die;
            
            }
            
            if($complete=='0') {
                
            $database->query("UPDATE pension_stages set updated_by=:hello, complete='No' where stage_id=:stageid");
            $database->bind(':stageid',$stageid);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
                       
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1";
            $messagedata="$task marked as incomplete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute(); 
            
            $database->query("SELECT complete from pension_stages where client_id=:client and stage='1' and complete='Yes'");
            $database->bind(':client',$search);
            $database->execute(); 
            
            if ($database->rowCount()>=4) {
                
                $database->query("UPDATE pension_stages set stage_complete='N', updated_by=:hello where client_id=:client and stage='1'");
                $database->bind(':client',$search);
                $database->bind(':hello',$hello_name);
                $database->execute();   
                
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1";
            $messagedata="Stage 1 incomplete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute();  
                
                header('Location: ../ViewClient.php?StageOne=StageInComplete&Task='.$task.'&search='.$search); die;
                
                
            }

            header('Location: ../ViewClient.php?StageOne=TaskInComplete&Task='.$task.'&search='.$search); die;    
                
                
            }
        
        
    }
    
    
         if($stage=='1.1') {
             
             
             
            include('../../classes/database_class.php');
            include('../../includes/adlfunctions.php');  
            
            $database = new Database(); 
           
            if($complete=='1') {
            
            $database->query("UPDATE pension_stages set updated_by=:hello, complete='Yes' where stage_id=:stageid");
            $database->bind(':stageid',$stageid);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
                   
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1.1";
            $messagedata="$task marked as complete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute(); 
            
            $database->query("SELECT complete from pension_stages where client_id=:client and stage='1.1' and complete='Yes'");
            $database->bind(':client',$search);
            $database->execute();
            
            if ($database->rowCount()>=8) {
                
                $database->query("UPDATE pension_stages set stage_complete='Y', complete='Yes', updated_by=:hello where client_id=:client and stage='1.1'");
                $database->bind(':client',$search);
                $database->bind(':hello',$hello_name);
                $database->execute();   

            $notedata= "Task Updated";
            $clientnamedata= "Stage 1.1";
            $messagedata="Stage 1.1 completed";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute();    
            
              header('Location: ../ViewClient.php?StageOneb=StageComplete&Task='.$task.'&search='.$search); die;  
            }

            header('Location: ../ViewClient.php?StageOneb=TaskComplete&Task='.$task.'&search='.$search); die;
            
            }
            
            if($complete=='0') {
                
            $database->query("UPDATE pension_stages set updated_by=:hello, complete='No' where stage_id=:stageid");
            $database->bind(':stageid',$stageid);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
                       
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1.1";
            $messagedata="$task marked as incomplete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute(); 
            
            $database->query("SELECT complete from pension_stages where client_id=:client and stage='1.1' and complete='Yes'");
            $database->bind(':client',$search);
            $database->execute(); 
            
            if ($database->rowCount()>=7) {
                
                $database->query("UPDATE pension_stages set stage_complete='N', updated_by=:hello where client_id=:client and stage='1.1'");
                $database->bind(':client',$search);
                $database->bind(':hello',$hello_name);
                $database->execute();   
                
            $notedata= "Task Updated";
            $clientnamedata= "Stage 1.1";
            $messagedata="Stage 1.1 incomplete";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute();  
                
                header('Location: ../ViewClient.php?StageOneb=StageInComplete&Task='.$task.'&search='.$search); die;
                
                
            }

            header('Location: ../ViewClient.php?StageOneb=TaskInComplete&Task='.$task.'&search='.$search); die;    
                
                
            }
        
        
    }
    
    
    
    }

?>