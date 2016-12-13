<?php

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 4);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/PDOcon.php'); 
include_once '../includes/uploaddb.php';

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$stageid= filter_input(INPUT_POST, 'stageid', FILTER_SANITIZE_NUMBER_INT);
$task= filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);
  $Task= filter_input(INPUT_GET, 'Task', FILTER_SANITIZE_SPECIAL_CHARS); 
  
if(isset($task)) {
    
    if($task=='Stage 1 Receipt of Client Agreement') {

        $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
        
    $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="../uploads/";
    
    $uploadtype="Stage 1 Receipt of Client Agreement";
    $new_size = $file_size/1024;  
    $new_file_name = strtolower($file);
    $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {
  $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
  mysqli_query($GLOBALS["___mysqli_ston"], $sql);

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO pension_client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

$stage1 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Receipt of Client Agreement'");
$stage1->bindParam(':stageid',$policyid, PDO::PARAM_INT);
$stage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

    $stage1complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='1' and client_id=:client");
    $stage1complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage1complete->execute();
    $stage1completeresults=$stage1complete->fetch(PDO::FETCH_ASSOC);

    $stage1check=$stage1completeresults['complete'];
    
    if($stage1check >=3) {
        
        $updatestage1 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='1'");
        $updatestage1->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage1->execute()or die(print_r($updatestage1->errorInfo(), true));   
        
    }

 }

   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php
 
    }
    
    $SentLOA= filter_input(INPUT_POST, 'SentLOA', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($task=='Stage 1 Send Pension LOA') {

        $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
        
        
        $MethodLOA= filter_input(INPUT_POST, 'MethodLOA', FILTER_SANITIZE_SPECIAL_CHARS);
        $name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);


$note = "Stage 1 Sent Pension LOA";
$message ="Sent via $MethodLOA";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$note, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$message, PDO::PARAM_STR, 2500);
$query->execute();

$stage1 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Send Pension LOA'");
$stage1->bindParam(':stageid',$policyid, PDO::PARAM_INT);
$stage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

    $stage1complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='1' and client_id=:client");
    $stage1complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage1complete->execute();
    $stage1completeresults=$stage1complete->fetch(PDO::FETCH_ASSOC);

    $stage1check=$stage1completeresults['complete'];
    
    if($stage1check >=3) {
        
        $updatestage1 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='1'");
        $updatestage1->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage1->execute()or die(print_r($updatestage1->errorInfo(), true));   
        
    }

   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?LOASent=y&LOAMethod=<?php echo $MethodLOA?>&search=<?php echo $search?>&?success';
        </script>
  <?php

 }
 

 
      $SentCR= filter_input(INPUT_POST, 'SentCR', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($task=='Stage 1 Send Client Receipt') {

        $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
        
        
        $MethodCR= filter_input(INPUT_POST, 'MethodCR', FILTER_SANITIZE_SPECIAL_CHARS);
        $name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);


$note = "Stage 1 Sent Client Receipt";
$message ="Sent via $MethodCR";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$note, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$message, PDO::PARAM_STR, 2500);
$query->execute();

$stage1 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Send Client Receipt'");
$stage1->bindParam(':stageid',$policyid, PDO::PARAM_INT);
$stage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

    $stage1complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='1' and client_id=:client");
    $stage1complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage1complete->execute();
    $stage1completeresults=$stage1complete->fetch(PDO::FETCH_ASSOC);

    $stage1check=$stage1completeresults['complete'];
    
    if($stage1check >=3) {
        
        $updatestage1 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='1'");
        $updatestage1->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage1->execute()or die(print_r($updatestage1->errorInfo(), true));   
        
    }

   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?CRSent=y&CRMethod=<?php echo $MethodCR?>&search=<?php echo $search?>&?success';
        </script>
  <?php
    

 }


    if($task=='Stage 2 Download attitude to risk to CRM') {
        
        $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
        
     $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="../uploads/";
    
    $uploadtype="Download attitude to risk to CRM";
    $new_size = $file_size/1024;  
    $new_file_name = strtolower($file);
    $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
  $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
  mysqli_query($GLOBALS["___mysqli_ston"], $sql);

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO pension_client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

$stage1 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE client_id=:stageid AND task='Download attitude to risk to CRM'");
$stage1->bindParam(':stageid',$search, PDO::PARAM_INT);
$stage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  



    $stage2complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='2' and client_id=:client");
    $stage2complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage2complete->execute();
    $stage2completeresults=$stage2complete->fetch(PDO::FETCH_ASSOC);

    $stage2check=$stage2completeresults['complete'];
    
    if($stage2check >=5) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='2'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }


 }
 
   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php
 
    }
    
        if($task=='Stage 4 Ceeding Plan Illustration') {
        
        $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
        
    $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="../uploads/";
    
    $uploadtype="Stage 4 Ceeding Plan Illustration";
    $new_size = $file_size/1024;  
    $new_file_name = strtolower($file);
    $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
  $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
  mysqli_query($GLOBALS["___mysqli_ston"], $sql);


$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

$stage4 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE stage_id=:stageid AND task='Ceeding Report'");
$stage4->bindParam(':stageid',$stageid, PDO::PARAM_INT);
$stage4->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage4->execute()or die(print_r($stage4->errorInfo(), true));  

 }
 
   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php
  
     $stage4complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='4' and client_id=:client");
   $stage4complete->bindParam(':client',$search, PDO::PARAM_INT);
   $stage4complete->execute();
   $stage4completeresults=$stage4complete->fetch(PDO::FETCH_ASSOC);

    $stage4check=$stage4completeresults['complete'];
    
    if($stage4check >=2) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='4'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }



    }
    
            if($task=='Stage 4 Selecta Pension Part 1') {
                $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
                $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
                $file = $search."-".$_FILES['file']['name'];
                $file_loc = $_FILES['file']['tmp_name'];
                $file_size = $_FILES['file']['size'];
                $file_type = $_FILES['file']['type'];
                $folder="../uploads/";
                
                $uploadtype="Stage 4 Selecta Pension Part 1";
                $new_size = $file_size/1024;  
                $new_file_name = strtolower($file);
                $final_file=str_replace("'","",$new_file_name);
                
                if(move_uploaded_file($file_loc,$folder.$final_file)) {
                    $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
                    mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                    
                    $clientnamedata= "Upload";
                    $query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                    $query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
                    $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                    $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
                    $query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
                    $query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
                    $query->execute();
                    
                    $stage4 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Selecta Pension'");
                    $stage4->bindParam(':stageid',$policyid, PDO::PARAM_INT);
                    $stage4->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
                    $stage4->execute()or die(print_r($stage4->errorInfo(), true));  

 }
 
   ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php

   $stage4complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='4' and client_id=:client");
   $stage4complete->bindParam(':client',$search, PDO::PARAM_INT);
   $stage4complete->execute();
   $stage4completeresults=$stage4complete->fetch(PDO::FETCH_ASSOC);

    $stage4check=$stage4completeresults['complete'];
    
    if($stage4check >=2) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='4'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }
  

    }


 }

 
 if(isset($Task)) {   
     
     $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if($Task=='Synaptics') {
         
         $MethodLOA= filter_input(INPUT_POST, 'MethodLOA', FILTER_SANITIZE_SPECIAL_CHARS);
         
         if(isset($MethodLOA)) {
             
             $note = "Stage 5 Sent Synaptics";
             $message ="Sent via $MethodLOA";
             $ref="Stage 5";
             
             $Synaptics = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
             $Synaptics->bindParam(':clientidholder',$search, PDO::PARAM_INT);
             $Synaptics->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
             $Synaptics->bindParam(':recipientholder',$ref, PDO::PARAM_STR, 500);
             $Synaptics->bindParam(':noteholder',$note, PDO::PARAM_STR, 255);
             $Synaptics->bindParam(':messageholder',$message, PDO::PARAM_STR, 2500);
             $Synaptics->execute();
             
             $stage5 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Send Synaptics to Client'");
             $stage5->bindParam(':stageid',$policyid, PDO::PARAM_INT);
             $stage5->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
             $stage5->execute()or die(print_r($stage5->errorInfo(), true));
             
             $stage5complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='5' and client_id=:client");
             $stage5complete->bindParam(':client',$search, PDO::PARAM_INT);
             $stage5complete->execute();
             $stage5completeresults=$stage5complete->fetch(PDO::FETCH_ASSOC);
             
             $stage5check=$stage5completeresults['complete'];
             
             if($stage5check >=5) {
                 
                 $updatestage5 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='5'");
                 $updatestage5->bindParam(':id',$search, PDO::PARAM_INT);
                 $updatestage5->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
                 $updatestage5->execute()or die(print_r($updatestage5->errorInfo(), true));
                 
        }
        ?>
        <script> 
        window.location.href='/Pensions/ViewPensionClient.php?SynapticsSent=y&LOAMethod=<?php echo $MethodLOA?>&search=<?php echo $search?>&?success';
        </script>
            <?php
                
            }
            
            
        
    $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="../uploads/";
    
    $uploadtype="Stage 5 Synaptics";
    $new_size = $file_size/1024;  
    $new_file_name = strtolower($file);
    $final_file=str_replace("'","",$new_file_name);
    
    if(move_uploaded_file($file_loc,$folder.$final_file)) {
        
        $upload = $pdo->prepare("INSERT INTO tbl_uploads set file=:final, type=:type, size=:size, uploadtype=:uploadtype");
        $upload->bindParam(':final',$final_file, PDO::PARAM_STR, 255);
        $upload->bindParam(':type',$file_type, PDO::PARAM_STR, 255);
        $upload->bindParam(':size',$new_size, PDO::PARAM_STR, 255);
        $upload->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
        $upload->execute(); 
        
        $clientnamedata= "Upload";
        
        $insert = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $insert->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $insert->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $insert->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
        $insert->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
        $insert->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
        $insert->execute();
        
        $stage5 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE policy_id=:stageid AND task='Create Synaptics'");
        $stage5->bindParam(':stageid',$policyid, PDO::PARAM_INT);
        $stage5->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $stage5->execute()or die(print_r($stage5->errorInfo(), true));
        
        $stage5complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='5' and client_id=:client");
        $stage5complete->bindParam(':client',$search, PDO::PARAM_INT);
        $stage5complete->execute();
        $stage5completeresults=$stage5complete->fetch(PDO::FETCH_ASSOC);
        
        $stage5check=$stage5completeresults['complete'];
        
        if($stage5check >=5) {
            
            $updatestage5 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='5'");
            $updatestage5->bindParam(':id',$search, PDO::PARAM_INT);
            $updatestage5->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
            $updatestage5->execute()or die(print_r($updatestage5->errorInfo(), true));
            
        }
        
        }
        
        ?>
        <script>
            window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
            <?php
            
        }
        
        }



if(isset($_POST['btn-upload']))
$search=$_POST['search'];
$uploadtype=$_POST['uploadtype'];

{    
     
 $file = $search."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);

 
 $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
  $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
  mysqli_query($GLOBALS["___mysqli_ston"], $sql);
  ?>
  <script>
  
        window.location.href='/Pensions/ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $_POST[uploadtype]?>&search=<?php echo $_POST[search]?>&?success';
        </script>
  <?php

$clientidata= filter_input(INPUT_POST, 'uploadclientid', FILTER_SANITIZE_NUMBER_INT);
$uploadtypedata= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$clientidata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

 }

}


?>
  <script>
        window.location.href='/Pensions/ViewPensionClient.php?$fileuploadedfail=y&search=<?php echo $search?>&?fail';
        </script>
<?php   