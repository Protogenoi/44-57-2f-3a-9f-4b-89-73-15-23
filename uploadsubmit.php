<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 4);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$Home= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($Home)) {
        if($Home=='y') {
            
            include('includes/ADL_PDO_CON.php'); 
            
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($btnupload)) {    
     
 $file = $CID."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/home/$CID")) {
    mkdir("uploads/home/$CID", 0777, true);
}
 
 $folder="uploads/home/$CID/";

 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);

 $final_file=str_replace("'","",$new_file_name);
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
$TBL_query->execute();  

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':CID',$CID, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

  header('Location: Home/ViewClient.php?fileuploaded=y&?success&fileupname='.$uploadtype.'&CID='.$CID.'#menu2'); die;
 }

}

header('Location: Home/ViewClient.php?fileuploadedfail=y&?fail&CID='.$CID.'#menu2'); die;
          
            
        }
    } 
    
$life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($life)) {
        if($life=='y') {
            include('includes/ADL_PDO_CON.php');
            
$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            
 

if(isset($btnupload)) {    
     
 $file = $search."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/life/$search")) {
    mkdir("uploads/life/$search", 0777, true);
}

 $folder="uploads/life/$search/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);

 $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
$TBL_query->execute();  

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

 header('Location: /Life/ViewClient.php?fileuploaded=y&?success&fileupname='.$uploadtype.'&search='.$search.'#menu2'); die;
 }

}

header('Location: /Life/ViewClient.php?fileuploadedfail=y&?fail&search='.$search.'#menu2'); die;
          
            
        }
    }    
    

include_once 'includes/uploaddb.php';

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$stageid= filter_input(INPUT_POST, 'stageid', FILTER_SANITIZE_NUMBER_INT);
$task= filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);
   
if(isset($task)) {
   include('includes/ADL_PDO_CON.php'); 
    if($task=='Stage 1 Receipt of Client Agreement') {

        $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
        
    $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="uploads/";
    
    $uploadtype="Stage 1 Receipt of Client Agreement";
    $new_size = $file_size/1024;  
    $new_file_name = strtolower($file);
    $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
$TBL_query->execute();  

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

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

 }

   ?>
  <script>
  
        window.location.href='ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
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


   ?>
  <script>
  
        window.location.href='ViewPensionClient.php?LOASent=y&LOAMethod=<?php echo $MethodLOA?>&search=<?php echo $search?>&?success';
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

   ?>
  <script>
  
        window.location.href='ViewPensionClient.php?CRSent=y&CRMethod=<?php echo $MethodCR?>&search=<?php echo $search?>&?success';
        </script>
  <?php
    

 }


    if($task=='Stage 2 Risk Profile') {
        
        $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
        
     $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="uploads/";
    
    $uploadtype="Stage 2 Risk Profile";
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

$stage1 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE stage_id=:stageid AND task='Risk Profile' OR task='Fact Find'");
$stage1->bindParam(':stageid',$stageid, PDO::PARAM_INT);
$stage1->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

 }
 
   ?>
  <script>
  
        window.location.href='ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php
 
    }
    
        if($task=='Stage 4 Ceeding Plan Illustration') {
        
        $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
        
    $file = $search."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="uploads/";
    
    $uploadtype="Stage 4 Ceeding Plan Illustration";
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

$stage4 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE stage_id=:stageid AND task='Research and prep'");
$stage4->bindParam(':stageid',$stageid, PDO::PARAM_INT);
$stage4->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$stage4->execute()or die(print_r($stage4->errorInfo(), true));  

 }
 
   ?>
  <script>
  
        window.location.href='ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php


    }
    
            if($task=='Stage 4 Selecta Pension Part 1') {
                $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
                $policyid= filter_input(INPUT_POST, 'policyid', FILTER_SANITIZE_SPECIAL_CHARS);
                $file = $search."-".$_FILES['file']['name'];
                $file_loc = $_FILES['file']['tmp_name'];
                $file_size = $_FILES['file']['size'];
                $file_type = $_FILES['file']['type'];
                $folder="uploads/";
                
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
  
        window.location.href='ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $uploadtype?>&search=<?php echo $search?>&?success';
        </script>
  <?php


    }


 }
    

    
$pension= filter_input(INPUT_GET, 'pension', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($pension)) {
        if($pension=='y') {
            
            
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
  


$clientidata= filter_input(INPUT_POST, 'uploadclientid', FILTER_SANITIZE_NUMBER_INT);
$uploadtypedata= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO pension_client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$clientidata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
  header('Location: /Pensions/ViewClient.php?fileuploaded=y&?success&fileupname='.$uploadtype.'&search='.$search.'#menu2'); die;
 }

}

header('Location: /Pensions/ViewClient.php?fileuploadedfail=y&?fail&search='.$search.'#menu2'); die;
          
            
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
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace("'","",$new_file_name);
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
  $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
  mysqli_query($GLOBALS["___mysqli_ston"], $sql);
  ?>
  <script>
  
        window.location.href='ViewPensionClient.php?fileuploaded=y&fileupname=<?php echo $_POST[uploadtype]?>&search=<?php echo $_POST[search]?>&?success';
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
        window.location.href='ViewPensionClient.php?$fileuploadedfail=y&search=<?php echo $search?>&?fail';
        </script>
<?php   