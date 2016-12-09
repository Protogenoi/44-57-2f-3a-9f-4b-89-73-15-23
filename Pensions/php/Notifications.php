<?php


  if ($penactive =='0') {
      
      echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Cancelled:</strong> Client is marked as cancelled!</div>";
                                            
                                        }

     $dupepolicy= filter_input(INPUT_GET, 'dupepolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($dupepolicy)) {
         if(!empty($dupepolicy)) {
   $origpolicy= filter_input(INPUT_GET, 'origpolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
    echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Warning:</strong> Duplicate $origpolicy number found! Policy number changed to $dupepolicy<br><br><strong><i class='fa fa-exclamation-triangle fa-lg'></i> $hello_name:</strong> If you are replacing an old policy change old policy to $origpolicy OLD and remove DUPE from the newer updated policy.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  

         }
     }
     
     $StageComplete= filter_input(INPUT_GET, 'StageComplete', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($StageComplete)) {
         if($StageComplete=='Stage 1') {
             
                echo "<div class='notice notice-success' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-check fa-lg'></i> Stage Complete:</strong> Stage 1 complete.  Tasks for Stage 1.1 added.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }
     }
     
     $StageOne= filter_input(INPUT_GET, 'StageOne', FILTER_SANITIZE_SPECIAL_CHARS);
     $StageOneb= filter_input(INPUT_GET, 'StageOneb', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($StageOne)) {
         
         $Task= filter_input(INPUT_GET, 'Task', FILTER_SANITIZE_SPECIAL_CHARS);
         
         if($StageOne=='StageInComplete') {
             
        echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Warning:</strong> Stage 1 now marked as incomplete. <br><i class='fa fa-exclamation-triangle fa-lg'></i> <strong>Task:</strong> $Task marked as incomplete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  

             
         }
         
         if($StageOne=='TaskInComplete') {
             
        echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Task:</strong> $Task marked as incomplete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }
         
                  if($StageOne=='TaskComplete') {
             
        echo "<div class='notice notice-success' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-check fa-lg'></i> Task:</strong> $Task marked as complete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }
         
         if($StageOne=='StageComplete') {
             
        echo "<div class='notice notice-success' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-check fa-lg'></i> Task:</strong> Stage 1 complete!<br><strong><i class='fa fa-check fa-lg'></i> Task:</strong> $Task marked as complete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }

     }
     
          if(isset($StageOneb)) {
         
         $Task= filter_input(INPUT_GET, 'Task', FILTER_SANITIZE_SPECIAL_CHARS);
         
         if($StageOneb=='StageInComplete') {
             
        echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Warning:</strong> Stage 1.1 now marked as incomplete. <br><i class='fa fa-exclamation-triangle fa-lg'></i> <strong>Task:</strong> $Task marked as incomplete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  

             
         }
         
         if($StageOneb=='TaskInComplete') {
             
        echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Task:</strong> $Task marked as incomplete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }
         
                  if($StageOneb=='TaskComplete') {
             
        echo "<div class='notice notice-success' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-check fa-lg'></i> Task:</strong> $Task marked as complete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }
         
         if($StageOneb=='StageComplete') {
             
        echo "<div class='notice notice-success' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-check fa-lg'></i> Task:</strong> Stage 1.1 complete!<br><strong><i class='fa fa-check fa-lg'></i> Task:</strong> $Task marked as complete.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
     
             
         }

     }
          
    
         
        $database->query("select active_stage FROM pension_stages where client_id=:cid and stage='1'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                $StageONEactive=$result['active_stage'];
                
         $database->query("select active_stage FROM pension_stages where client_id=:cid and stage='1.1'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                $StageONEbactive=$result['active_stage'];        
                
        if($StageONEactive == "Y") {

            try {
                
                $query = $pdo->prepare("select task FROM pension_stages where client_id=:cid and stage='1' AND complete='No'");
                $query->bindParam(':cid', $search, PDO::PARAM_STR, 12);
                
                $query->execute();
                if ($query->rowCount()>0) {
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                  
                    $StageONEtask=$result['task'];              
            if($StageONEtask=='Confirm Quickdox appointment') {
                
                $quickdox="Quickdox Appointment Reminder%";
                
        $query22 = $pdo->prepare("select callback_date from scheduled_pension_callbacks where notes LIKE :notes and client_id=:search");
        $query22->bindParam(':notes', $quickdox, PDO::PARAM_STR);
        $query22->bindParam(':search', $search, PDO::PARAM_STR);
        $query22->execute()or die(print_r($query->errorInfo(), true));
        $queryr22=$query22->fetch(PDO::FETCH_ASSOC);

        $calldate=$queryr22['callback_date'];
    
        if(!empty($calldate)) {
        
        $newdate=date("l jS \of F",strtotime($calldate));
        
        }
        
        else {
            
            $newdate= "not set";
            
        }
                
            }   
            
           
            
         ?>
         
    <div class="notice notice-danger" role="alert" id='HIDECLOSERKF'><strong><i class="fa fa-exclamation-triangle fa-lg"></i> Stage 1:</strong> <?php 
        
        if($StageONEtask=='Confirm Quickdox appointment') {
        
        echo  "$StageONEtask $newdate";
            
        }
        
        else {
        echo $StageONEtask;    
            
        }
        
        ?>
            <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>   
         <?php
                }    } 
                
                $database->query("select stage_complete FROM pension_stages where client_id=:cid and stage='1' and stage_complete='Y'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                if ($database->rowCount()>=1) {
        
                                    ?>
         
    <div class="notice notice-success" role="alert" id='HIDECLOSERKF'><strong><i class="fa fa-check fa-lg"></i> Success:</strong> Stage 1 is complete!
            <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>   
         <?php
                }     
     } 
                        
                         catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
     
        }
        
        if($StageONEbactive == "Y") {
            
        try {
                
                $query = $pdo->prepare("select task FROM pension_stages where client_id=:cid and stage='1.1' AND complete='No'");
                $query->bindParam(':cid', $search, PDO::PARAM_STR, 12);
                
                $query->execute();
                if ($query->rowCount()>0) {
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                  
                    $StageONEbtask=$result['task'];              
      
         ?>
         
    <div class="notice notice-danger" role="alert" id='HIDECLOSERKF'><strong><i class="fa fa-exclamation-triangle fa-lg"></i> Stage 1.1:</strong> <?php echo $StageONEbtask; ?>
            <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>   
         <?php
                }    } 
                
                $database->query("select stage_complete FROM pension_stages where client_id=:cid and stage='1.1' and stage_complete='Y'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                if ($database->rowCount()>=1) {
        
                                    ?>
         
    <div class="notice notice-success" role="alert" id='HIDECLOSERKF'><strong><i class="fa fa-check fa-lg"></i> Success:</strong> Stage 1.1 is complete!
            <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>   
         <?php
                }     
     } 
                        
                         catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }    
            
            
        }

              
            $TaskSelect= filter_input(INPUT_GET, 'TaskSelect', FILTER_SANITIZE_SPECIAL_CHARS);
                 
                  if(isset($TaskSelect)){                   
                if ($TaskSelect =='CYD') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> CYD Task Updated!</div>";
                    
                }
                
                 if ($TaskSelect =='5 day') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 5 Day Task Updated!</div>";
                    
                }
                
                if ($TaskSelect =='24 48') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 24-48 Day Task Updated!</div>";
                    
                }
                
                  if ($TaskSelect =='18 day') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 18 Day Task Updated!</div>";
                    
                }
                 
                }
                
                $Updated= filter_input(INPUT_GET, 'Updated', FILTER_SANITIZE_SPECIAL_CHARS);
                
                if(isset($Updated)){                  
                if ($Updated =='EWS') {
                    
                    $policy_number= filter_input(INPUT_GET, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> EWS Updated for policy $policy_number!</div>";
                    
                }
                 
                }
            
            $Callback= filter_input(INPUT_GET, 'Callback', FILTER_SANITIZE_SPECIAL_CHARS);
            if(isset($Callback)){   
                $Callback= filter_input(INPUT_GET, 'Callback', FILTER_SANITIZE_SPECIAL_CHARS);
                if ($Callback =='y') {
                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-calendar\"></i> Success:</strong> Callback Set!</div>");
                    
                }
                if ($Callback =='fail') {
                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");
                    
                }
                
                }
                        
                        $policydetailsadded= filter_input(INPUT_GET, 'policydetailsadded', FILTER_SANITIZE_SPECIAL_CHARS);
                        if(isset($policydetailsadded)){
                            $policydetailsadded= filter_input(INPUT_GET, 'policydetailsadded', FILTER_SANITIZE_SPECIAL_CHARS);
                            if ($policydetailsadded =='y') {
                                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client Pension Details Added!</div>");
                                
                            }
                            if ($policydetailsadded =='failed') {
                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");

                                
                            }
                            
                            }
                            
                            $taskedited= filter_input(INPUT_GET, 'taskedited', FILTER_SANITIZE_SPECIAL_CHARS);
                            if(isset($taskedited)){
                                $taskedited= filter_input(INPUT_GET, 'taskedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                if ($taskedited =='y') {
                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Task notes updated!</div>");
                                    
                                }
                                if ($taskedited =='n') {
                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Task notes NOT updated!</div>");
                                    
                                }
                                
                                }
                                
                                $policyedited= filter_input(INPUT_GET, 'policyedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                if(isset($policyedited)){
                                    $policyedited= filter_input(INPUT_GET, 'policyedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                    if ($policyedited =='y') {
                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Policy details updated!</div>");
                                        
                                    }
                                    if ($policyedited =='n') {
                                        print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy details updated!</div>");
                                        
                                    }
                                    
                                    }
                                    
                                    $clientedited= filter_input(INPUT_GET, 'clientedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                    if(isset($clientedited)){
                                        
                                        if ($clientedited =='y') {
                                            print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client details updated!</div>");
                                            
                                        }
                                        if ($clientedited =='n') {
                                            print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Client details not updated!</div>");
                                            
                                        }
                                        
                                         if ($clientedited =='cancelled') {
                                            print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Cancelled:</strong> Client is marked as cancelled!</div>");
                                            
                                        }
                                        
                                        }
                                        
                                        $checklistupdated= filter_input(INPUT_GET, 'checklistupdated', FILTER_SANITIZE_SPECIAL_CHARS);
                                        if(isset($checklistupdated)){
                                            $checklistupdatedd= filter_input(INPUT_GET, 'checklistupdated', FILTER_SANITIZE_SPECIAL_CHARS);
                                            if ($checklistupdatedd =='y') {
                                                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Checklist updated!</div>");
                                                
                                            }
                                            if ($checklistupdatedd =='n') {
                                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Checklist not updated!</div>");
                                                
                                            } 
                                            
                                            }
                                            
                   $Addcallback= filter_input(INPUT_GET, 'Addcallback', FILTER_SANITIZE_SPECIAL_CHARS);
                                                
        
        if(isset($Addcallback)) {
            
            $callbackcompletedid= filter_input(INPUT_GET, 'callbackid', FILTER_SANITIZE_NUMBER_INT);
            
            if($Addcallback=='complete') {
                
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Callback $callbackcompletedid completed!</div>";
                
            }
            
            if($Addcallback=='incomplete') {
                
                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Callback set to incomplete!</div>";
                
            }
            
        }
                                                
                                                $fileuploaded= filter_input(INPUT_GET, 'fileuploaded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploaded)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-upload fa-lg\"></i> Success:</strong> $uploadtypeuploaded uploaded!</div>");
                                                    
                                                }
                                                
                                                $fileuploadedfail= filter_input(INPUT_GET, 'fileuploadedfail', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploadedfail)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> $uploadtypeuploaded <b>upload failed!</b></div>");
                                                    
                                                }
                                                
                                                $smssent= filter_input(INPUT_GET, 'smssent', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($smssent)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> SMS sent!</div>");
                                                    
                                                }
                                                
                                                $taskcompleted= filter_input(INPUT_GET, 'taskcompleted', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($taskcompleted)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Task completed!</div>");
                                                    
                                                }
                                                
                                                $clientnotesadded= filter_input(INPUT_GET, 'clientnotesadded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($clientnotesadded)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client notes added!</div>");
                                                    
                                                }
                                                
                                                    $emailsent= filter_input(INPUT_GET, 'emailsent', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    
                                                    if(isset($emailsent)){
                                                        
                                                        $emailtype= filter_input(INPUT_GET, 'emailtype', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        $emailto= filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        if(isset($emailtype)) {
                                                            if($emailtype="CloserKeyFacts"){
                                                          echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Closer KeyFacts Email sent to <b>$emailto</b> !</div>";
                                                            }
                                                        }
                                                        
                                                        else 
                                                        {
                                                        $emailaddress= filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_EMAIL);
                                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Email sent to <b>$emailaddress</b> !</div>");
                                                        }
                                                    }
                                                    
                                                $EmailMAD= filter_input(INPUT_GET, 'EmailMAD', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    
                                                    if(isset($EmailMAD)){
                                                        
                                                        $emailaddress= filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_EMAIL);
                                                        if($EmailMAD=='1') {
                                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> My Account Details email sent to <b>$emailaddress</b> !</div>");
  
                                                        }
                                                        if($EmailMAD=='2') {
                                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Welcome email sent to <b>$emailaddress</b> !</div>");
                                                        }
                                                        if($EmailMAD=='0') {
                                                            
                                                        print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> My Account Details email failed!</div>");
   
                                                            
                                                        }
                                                    }   
                                                    
                                                
                                                $workflow= filter_input(INPUT_GET, 'workflow', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($workflow)){
                                                    $stepcom= filter_input(INPUT_GET, 'workflow', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Success:</strong>  $stepcom updated</div>");
                                                    
                                                }
                                                
                                                $policyadded= filter_input(INPUT_GET, 'policyadded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($policyadded)){
                                                    $policy_number= filter_input(INPUT_GET, 'policy_number', FILTER_SANITIZE_NUMBER_INT);
                                                    print("<div class=\"notice notice-success\" role=\"alert\" id='HIDENEWPOLICY'><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Success:</strong> Policy $policy_number added<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDENEWPOLICY'>&times;</a></div>");                                                   
                                                    
                                                }
                                                
                                                $deletedpolicy= filter_input(INPUT_GET, 'deletedpolicy', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($deletedpolicy)){
                                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Policy deleted</strong></div>");
                                                    
                                                }
                                                
                                                $DeleteUpload= filter_input(INPUT_GET, 'DeleteUpload', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($DeleteUpload)){
                                                    
                                                    $locationvarplaceholder= filter_input(INPUT_GET, 'file', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $count= filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);
                                                    
                                                    if($DeleteUpload=='1') {
                                                    
                                                        echo("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> File ($count) $locationvarplaceholder deleted</strong></div>\n");
                                                        
                                                    }
                                                    
                                                    if($DeleteUpload=='0') {
                                                        
                                                        echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error file ($count) $locationvarplaceholder NOT deleted</strong></div>";
                                                        
                                                    }
                                                    
                                                    }
                                                    
                                                    $CallbackSet = filter_input(INPUT_GET, 'CallbackSet', FILTER_SANITIZE_NUMBER_INT);
                                                    if(isset($CallbackSet)){
                                                      if($CallbackSet=='1') {
                                                          
                                                        $CallbackTime= filter_input(INPUT_GET, 'CallbackTime', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        $CallbackDate= filter_input(INPUT_GET, 'CallbackDate', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Callback set for $CallbackTime $CallbackDate</strong></div>";

                               
                                                      }
                                                      
                                                      if($CallbackSet=='0') {
                                                          
                                                          echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> No call back changes made</strong></div>";
       
                                                                }
                                                    }
                                                                ?>

