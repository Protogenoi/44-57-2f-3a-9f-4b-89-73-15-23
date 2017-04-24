<?php

    if($WHICH_COMPANY=='ADL_CUS') {
        if (in_array($hello_name,$Level_8_Access, true)) {
        $database->query("select count(id) AS id from ews_data where policy_number IN(select policy_number from client_policy WHERE client_id=:CID) AND color_status='Black'");
        $database->bind(':CID', $search);
        $database->execute(); 
        $EWS_COUNT_RESULT=$database->single(); 
        if ($database->rowCount()>=1) {
            $EWS_COUNT=$EWS_COUNT_RESULT['id'];
            if(isset($EWS_COUNT)) { if($EWS_COUNT>=1) {
                ?>
<div class="notice notice-danger" role="alert" id='HIDELGKEY'><strong><i class="fa fa-exclamation-circle fa-lg"></i> EWS:</strong> This client has <?php if(isset($EWS_COUNT)) { if($EWS_COUNT>=2) { echo "$EWS_COUNT policies on EWS White"; } else { echo "1 policy on EWS White"; } } ?> <i>(action required).</i>  </div>              
    <?php
    
}

            }

}

}

$TSK_QRY = $pdo->prepare("select task from Client_Tasks WHERE client_id=:CID and complete ='0' AND task !='24 48' and deadline <= CURDATE()");
$TSK_QRY->bindParam(':CID', $search, PDO::PARAM_INT);
                            $TSK_QRY->execute();
                            if ($TSK_QRY->rowCount()>0) { 
                            while ($result=$TSK_QRY->fetch(PDO::FETCH_ASSOC)){    ?>

         
    <div class="notice notice-default" role="alert" id='HIDELGKEY'><strong><i class="fa fa-tasks fa-lg"></i> Tasks To Do:</strong> <?php 
foreach ($result as $value) {
    echo "$value ";
}
?> deadline expired<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>   
         
                          <?php  }   } 

 if(empty($closeraudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }
    

            $database->query("select uploadtype from tbl_uploads where uploadtype='LGkeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='LGpolicy' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }

     if($ffkeyfactsemail=='1') {
            
         $database->query("select keyfactsemail_email from keyfactsemail where keyfactsemail_email=:email");
         $database->bind(':email', $clientonemail);
         $database->execute();
         $database->single();
         if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDECLOSERKF'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Alert:</strong> Keyfacts Email not sent <i>(Send from Files & Uploads tab)</i>!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>";    
             
     
     }    
     
}     
     
}
//END CUS 
//ASSURA
if($companynamere=='Assura') {
    
 if(!empty($closeraudit)) {
     
     switch ($CGRADE) {
         case "Red":
             echo "<div class='notice notice-danger' role='alert' id='HIDEGCLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Closer Audit Grade Red!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGCLOSER'>&times;</a></div>";
             break;
         case "Amber":
             echo "<div class='notice notice-warning' role='alert' id='HIDEGCLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Closer Audit Grade Amber!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGCLOSER'>&times;</a></div>";
             break;
         case "Green":
             echo "<div class='notice notice-success' role='alert' id='HIDEGCLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Closer Audit Grade Green!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGCLOSER'>&times;</a></div>";
             break;
         default:
             echo "<div class='notice notice-info' role='alert' id='HIDEGCLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Info:</strong> Closer Audit Grade not found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGCLOSER'>&times;</a></div>";
             
     }     
 }
 
  if(!empty($leadaudit)) {
     
     switch ($LGRADE) {
         case "Red":
             echo "<div class='notice notice-danger' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-headphones fa-lg'></i> Lead Gen Audit Grade Red!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGLEAD'>&times;</a></div>";
             break;
         case "Amber":
             echo "<div class='notice notice-warning' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-headphones fa-lg'></i> Lead Gen Audit Grade Amber!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGLEAD'>&times;</a></div>";
             break;
         case "Green":
             echo "<div class='notice notice-success' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-headphones fa-lg'></i> Lead Gen Audit Grade Green!</strong> <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGLEAD'>&times;</a></div>";
             break;
         default:
             echo "<div class='notice notice-info' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-headphones fa-lg'></i> Info:</strong> Lead Gen Audit Grade not found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEGLEAD'>&times;</a></div>";
             
     }     
 }


}
//END ASSURA

if(isset($WHICH_COMPANY)){     


if($WHICH_COMPANY=='TRB WOL') {

 if(empty($WOL_CLOSER_AUDIT)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No WOL Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }

  if(empty($WOL_LEAD_AUDIT)) {
     echo "<div class='notice notice-info' role='alert' id='HIDELEAD'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No WOL Lead Gen audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEAD'>&times;</a></div>";   
     
 }        
        
    }

//TRB    
    if($WHICH_COMPANY=='The Review Bureau') {
        if (in_array($hello_name,$Level_8_Access, true)) {
        $database->query("select count(id) AS id from ews_data where policy_number IN(select policy_number from client_policy WHERE client_id=:CID) AND color_status='Black'");
        $database->bind(':CID', $search);
        $database->execute(); 
        $EWS_COUNT_RESULT=$database->single(); 
        if ($database->rowCount()>=1) {
            $EWS_COUNT=$EWS_COUNT_RESULT['id'];
            if(isset($EWS_COUNT)) { if($EWS_COUNT>=1) {
                ?>
<div class="notice notice-danger" role="alert" id='HIDELGKEY'><strong><i class="fa fa-exclamation-circle fa-lg"></i> EWS:</strong> This client has <?php if(isset($EWS_COUNT)) { if($EWS_COUNT>=2) { echo "$EWS_COUNT policies on EWS White"; } else { echo "1 policy on EWS White"; } } ?> <i>(action required).</i>  </div>              
    <?php
    
}

            }

}

}

$TSK_QRY = $pdo->prepare("select task from Client_Tasks WHERE client_id=:CID and complete ='0' and deadline <= CURDATE()");
$TSK_QRY->bindParam(':CID', $search, PDO::PARAM_INT);
                            $TSK_QRY->execute();
                            if ($TSK_QRY->rowCount()>0) { 
                            while ($result=$TSK_QRY->fetch(PDO::FETCH_ASSOC)){    ?>

         
    <div class="notice notice-default" role="alert" id='HIDELGKEY'><strong><i class="fa fa-tasks fa-lg"></i> Tasks To Do:</strong> <?php 
foreach ($result as $value) {
    echo "$value ";
}
?> deadline expired<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>   
         
                          <?php  }   } 

 if(empty($closeraudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }

 if(empty($leadaudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDELEAD'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Lead Gen audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEAD'>&times;</a></div>";   
     
 }
    

            $database->query("select uploadtype from tbl_uploads where uploadtype='LGkeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='LGpolicy' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }

     if($ffkeyfactsemail=='1') {
     if($client_date_added >= "2016-06-17 16:00:00" && $client_date_added <= "2017-04-24 11:54:00") {
         
         $database->query("select email_address from KeyFactsEmails where email_address=:email");
         $database->bind(':email', $clientonemail);
         $database->execute();
         $database->single();
         if ($database->rowCount()<=0) {  
         
    echo "<div class='notice notice-danger' role='alert' id='HIDECLOSERKF'><strong><i class='fa fa-envelope-o  fa-lg'></i> Alert:</strong> Keyfacts Email not sent <i>(Send from Files & Uploads tab)</i>!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>";     
         
     }      
     
     }  
     
          if($client_date_added >= "2017-04-24 11:55:00") {
         
         $database->query("select keyfactsemail_email from keyfactsemail where keyfactsemail_email=:email");
         $database->bind(':email', $clientonemail);
         $database->execute();
         $database->single();
         if ($database->rowCount()<=0) {  
         
    echo "<div class='notice notice-danger' role='alert' id='HIDECLOSERKF'><strong><i class='fa fa-envelope-o  fa-lg'></i> Alert:</strong> Keyfacts Email not sent <i>(Send from Files & Uploads tab)</i>!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>";    
         
     }      
     
     }    
     
}
    }
//END TRB


if($WHICH_COMPANY=='Assura') {
    
 if(empty($closeraudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }

 if(empty($leadaudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDELEAD'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Lead Gen audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEAD'>&times;</a></div>";   
     
 }   

            $database->query("select uploadtype from tbl_uploads where uploadtype='AssuraPol' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Assura Policy not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
}

}
if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='Assura' || $WHICH_COMPANY=='TRB Aviva' || $WHICH_COMPANY == 'TRB Home Insurance' || $WHICH_COMPANY=='TRB Royal London' || $WHICH_COMPANY=='TRB WOL' || $WHICH_COMPANY=='TRB Vitality') {

    
     if($client_date_added <= "2017-03-07 16:25:00") {
        if(empty($leadid1)) {
        echo "<div class='notice notice-danger' role='alert' id='HIDELEADID'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Alert:</strong> No Recording ID added!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEADID'>&times;</a></div>";
        
     } } else {

    if(!isset($leadid1)) {
    $database->query("select uploadtype from tbl_uploads where uploadtype='Closer Call Recording' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-danger\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Alert:</strong> No closer call recording not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }
    $database->query("select uploadtype from tbl_uploads where uploadtype='Agent Call Recording' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-danger\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Alert:</strong> No agent call recording not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }
}
     
     }
     
     
    if(!isset($dealsheet_id)) {
    $database->query("select uploadtype from tbl_uploads where uploadtype='Dealsheet' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Dealsheet not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }
}
}
     $dupepolicy= filter_input(INPUT_GET, 'dupepolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($dupepolicy)) {
         if(!empty($dupepolicy)) {
   $origpolicy= filter_input(INPUT_GET, 'origpolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
    echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Warning:</strong> Duplicate $origpolicy number found! Policy number changed to $dupepolicy<br><br><strong><i class='fa fa-exclamation-triangle fa-lg'></i> $hello_name:</strong> If you are replacing an old policy change old policy to $origpolicy OLD and remove DUPE from the newer updated policy.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  

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
                                        $clienteditedy= filter_input(INPUT_GET, 'clientedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                        if ($clienteditedy =='y') {
                                            print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client details updated!</div>");
                                            
                                        }
                                        if ($clienteditedy =='n') {
                                            print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Client details not updated!</div>");
                                            
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
                                                        if($EmailMAD='1') {
                                                            
                                                        }
                                                        
                                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> My Account Details email sent to <b>$emailaddress</b> !</div>");
                                                        if($EmailMAD='0') {
                                                            
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