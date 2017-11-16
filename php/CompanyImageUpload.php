<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/ADL_PDO_CON.php');
include('../includes/ADL_MYSQLI_CON.php');

$CompImage= filter_input(INPUT_GET, 'CompImage', FILTER_SANITIZE_SPECIAL_CHARS);

        if(isset($CompImage)) {
            
$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);


$file = $_FILES['file']['name'];
 $fileloc = $_FILES['file']['tmp_name'];
 $filesize = $_FILES['file']['size'];
 $filetype = $_FILES['file']['type'];
 $folder="../uploads/";
 
 
 $newsize = $file_size/1024;  
 $finalfile = $uploadtype.".png";
 

 if(move_uploaded_file($fileloc,$folder.$finalfile))
 {
     
     
$query = $pdo->prepare("INSERT INTO tbl_uploads set file =:finalfile ,type =:typeholder , size =:sizeholder , uploadtype =:upholder ");

$query->bindParam(':finalfile',$finalfile, PDO::PARAM_STR, 500);
$query->bindParam(':typeholder',$filetype, PDO::PARAM_STR, 255);
$query->bindParam(':sizeholder',$newsize, PDO::PARAM_INT);
$query->bindParam(':upholder',$uploadtype, PDO::PARAM_STR, 500);
$query->execute()or die(print_r($query->errorInfo(), true));


            if(isset($fferror)) {
    if($fferror=='0') {
        
    
header('Location: ../admin/Admindash.php?companylogo=y&company=y'); die;
    }
            }
  
 }
 

else {
    
                if(isset($fferror)) {
    if($fferror=='0') {
        
    
    header('Location: ../admin/Admindash.php?companylogo=failed&company=y'); die;
    }
                }
}

        }
?>