<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
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
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
            
            if(isset($_FILES['file'])) {
            
            $RECORDING_DATE= filter_input(INPUT_POST, 'RECORDING_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
            $AGENT_NAME= filter_input(INPUT_POST, 'AGENT_NAME', FILTER_SANITIZE_SPECIAL_CHARS);
  
            if($_FILES['file']['size'] > 40000000) {
                header('Location: /Recordings.php?RETURN=UPMAX'); die;
            }
         
  if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='TRB';
    $COMPANY_NAME='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='PFP';
    $COMPANY_NAME='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='PLL';
    $COMPANY_NAME='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='WI';
    $COMPANY_NAME='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='TFAC';
    $COMPANY_NAME='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='APM';
    $COMPANY_NAME='Assured Protect and Mortgages';
    }   
          if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    $COMPANY='TRB';
    $COMPANY_NAME='The Review Bureau';
    }    

$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            
 

if(isset($btnupload)) {    
     
 $file = $COMPANY."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/compliance/recordings/$COMPANY")) {
    mkdir("uploads/compliance/recordings/$COMPANY", 0777, true);
}

 $folder="uploads/compliance/recordings/$COMPANY/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);

 $final_file=str_replace("'","",$new_file_name);
 $LOCATION="uploads/compliance/recordings/$COMPANY/$final_file";
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {
     
         $query = $pdo->prepare("SELECT compliance_agents_id FROM compliance_agents WHERE compliance_agents_company=:COMPANY AND compliance_agents_name=:NAME");
    $query->bindParam(':NAME', $AGENT_NAME, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_NAME, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['compliance_agents_id'];
     
$UPLOAD = $pdo->prepare("INSERT INTO compliance_recordings set compliance_recordings_id_fk=:FK, compliance_recordings_company=:COMPANY, compliance_recordings_advisor=:ADVISOR, compliance_recordings_location=:LOCATION, compliance_recordings_recording_date=:DATE");
$UPLOAD->bindParam(':FK',$ID_FK, PDO::PARAM_STR);
$UPLOAD->bindParam(':LOCATION',$LOCATION, PDO::PARAM_STR);
$UPLOAD->bindParam(':ADVISOR',$AGENT_NAME, PDO::PARAM_STR);
$UPLOAD->bindParam(':DATE',$RECORDING_DATE, PDO::PARAM_STR);
$UPLOAD->bindParam(':COMPANY',$COMPANY_NAME, PDO::PARAM_STR);
$UPLOAD->execute();  

 header('Location: /compliance/Recordings.php?RETURN=UPLOAD'); die;
 }

}

header('Location: /compliance/Recordings.php?RETURN=UPFAIL'); die;
            }
            
            else {
              header('Location: /compliance/Recordings.php?RETURN=UPNO'); die;  
            }
            
        }
        
        if($EXECUTE=='2') {
            
            if(isset($_FILES['file'])) {
            
            $DOC_TITLE= filter_input(INPUT_POST, 'DOC_TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
            $DOC_COMPANY= filter_input(INPUT_POST, 'DOC_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
            $DOC_CAT= filter_input(INPUT_POST, 'DOC_CAT', FILTER_SANITIZE_SPECIAL_CHARS);
  
            if($_FILES['file']['size'] > 40000000) {
                header('Location: /Compliance.php?RETURN=UPMAX'); die;
            }
         
  if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='TRB';
    $COMPANY_NAME='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='PFP';
    $COMPANY_NAME='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='PLL';
    $COMPANY_NAME='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='WI';
    $COMPANY_NAME='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='TFAC';
    $COMPANY_NAME='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='APM';
    $COMPANY_NAME='Assured Protect and Mortgages';
    }   
          if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    $COMPANY='TRB';
    $COMPANY_NAME=$DOC_COMPANY;
    }    

$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            
 

if(isset($btnupload)) {    
     
 $file = $COMPANY."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/compliance/docs/$COMPANY")) {
    mkdir("uploads/compliance/docs/$COMPANY", 0777, true);
}

 $folder="uploads/compliance/docs/$COMPANY/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);

 $final_file=str_replace("'","",$new_file_name);
 $LOCATION="uploads/compliance/docs/$COMPANY/$final_file";
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {
     
$UPLOAD = $pdo->prepare("INSERT INTO compliance_uploads set compliance_uploads_category=:CAT, compliance_uploads_title=:TITLE, compliance_uploads_company=:COMPANY, compliance_uploads_uploaded_by=:HELLO, compliance_uploads_location=:LOCATION");
$UPLOAD->bindParam(':LOCATION',$LOCATION, PDO::PARAM_STR);
$UPLOAD->bindParam(':HELLO',$hello_name, PDO::PARAM_STR);
$UPLOAD->bindParam(':TITLE',$DOC_TITLE, PDO::PARAM_STR);
$UPLOAD->bindParam(':CAT',$DOC_CAT, PDO::PARAM_STR);
$UPLOAD->bindParam(':COMPANY',$COMPANY_NAME, PDO::PARAM_STR);
$UPLOAD->execute();  

 header('Location: /compliance/Compliance.php?RETURN=DOCUPLOAD'); die;
 }

}

header('Location: /compliance/Compliance.php?RETURN=UPFAIL'); die;
            }
            
            else {
              header('Location: /compliance/Compliance.php?RETURN=UPNO'); die;  
            }
            
        }        
                if($EXECUTE=='10') {
            
            
$REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            

   if($_FILES['file']['size'] > 40000000) {
               header('Location: /Staff/ViewEmployee.php?RETURN=FILEUPLOAD&fileuploadedfail=y&?fail&REF='.$REF.'#menu3'); die;
            }

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

$Home= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($Home)) {
        if($Home=='y') {
            
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);

   if($_FILES['file']['size'] > 40000000) {
                header('Location: /Home/ViewClient.php?UPLOAD=MAX&CID='.$CID.'#menu2'); die;
            }

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
?>