<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');
require_once(__DIR__ . '/includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$Home= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($Home)) {
        if($Home=='y') {
            require_once(__DIR__ . '/includes/ADL_PDO_CON.php');
            
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
            require_once(__DIR__ . '/includes/ADL_PDO_CON.php');
            
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
    
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($EXECUTE)) {
        if($EXECUTE=='10') {
            require_once(__DIR__ . '/includes/ADL_PDO_CON.php');
            
$REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            
 

if(isset($btnupload)) {    
     
 $file = $_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/employee/$REF")) {
    mkdir("uploads/employee/$REF", 0777, true);
}

 $folder="uploads/employee/$REF/";
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);
 $final_file=str_replace("'","",$new_file_name);
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO employee_upload set file=:file, type=:type, size=:size, uploadtype=:uploadtype, employee_id=:REF");
$TBL_query->bindParam(':REF',$REF, PDO::PARAM_INT);
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
$TBL_query->execute();  


$message="$final_file ($uploadtype)";

$query = $pdo->prepare("INSERT INTO employee_timeline set employee_id=:REF, added_by=:sent, note_type='File Upload', message=:message");
$query->bindParam(':REF',$REF, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':message',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

 header('Location: /Staff/ViewEmployee.php?RETURN=FILEUPLOAD&fileuploaded=y&?success&fileupname='.$uploadtype.'&REF='.$REF.'#menu3'); die;
 }

}

header('Location: /Staff/ViewEmployee.php?RETURN=FILEUPLOAD&fileuploadedfail=y&?fail&REF='.$REF.'#menu3'); die;
          
            
        }
    }    
