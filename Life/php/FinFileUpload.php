<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$Level_2_Access = array("Michael", "Matt", "leighton", "Jade");

if (!in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: ../../CRMmain.php?AccessDenied'); die;

}

$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($query)) {
    $csv_mimetypes = array(
                'text/csv', 
                'text/plain',
                'application/csv',
                'text/comma-separated-values',
                'application/excel',
                'application/vnd.ms-excel',
                'application/vnd.msexcel',
                'text/anytext',
                'application/octet-stream',
                'application/txt',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                );

if (!in_array($_FILES['file']['type'], $csv_mimetypes)) {
    
    header('Location: ../Reports/FinancialUpload.php?uploaded=0&Reason=FileType'); die;
  
}              
        include('../../includes/ADL_PDO_CON.php');
        
        if($query=='Home') {            
            $uploadtype="Home Financials";
            $date=date("y-m-d-G:i:s");
            
            $file = $date."-".$hello_name."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder="../FinUploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($file);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {

                try {
                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR); 
                $query->execute(); 
                
                }
                
                                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                header('Location: ../Reports/FinancialUpload.php?uploaded=1&query=Home'); die;
                
            }
            
            header('Location: ../Reports/FinancialUpload.php?uploaded=0&query=Home'); die;
            
            }
            
        if($query=='Vitality') {
            
            $uploadtype="Vitality Financials";
            $date=date("y-m-d-G:i:s");
            
            $file = $date."-".$hello_name."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder="../FinUploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($file);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {

                try {
                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR); 
                $query->execute(); 
                
                }
                
                catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                header('Location: ../Reports/FinancialUpload.php?uploaded=1&query=Vitality'); die;
                
            }
            
            header('Location: ../Reports/FinancialUpload.php?uploaded=0&query=Vitality'); die;
            
            }

        if($query=='Life') {
            
            $uploadtype="Financial Comms";
            $date=date("y-m-d-G:i:s");
            
            $file = $date."-".$hello_name."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder="../FinUploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($file);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {

                try {
                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR); 
                $query->execute(); 
                
                }
                
                catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                header('Location: ../Reports/FinancialUpload.php?uploaded=1&query=Life'); die;
                
            }
            
            header('Location: ../Reports/FinancialUpload.php?uploaded=0&query=Life'); die;
            
            }                 
            
            }            
            
            
            header('Location: ../../CRMmain.php?AccessDenied'); die;
