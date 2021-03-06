<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/includes/user_tracking.php');

require_once(__DIR__ . '/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

$life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS); 
$search= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT); 

            if(isset($_FILES['file'])) {
            if($_FILES['file']['size'] > 40000000) {
                header('Location: /Life/ViewClient.php?UPLOAD=MAX&search='.$search.'#menu2'); die;
            }
            }

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');
require_once(__DIR__ . '/includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(__DIR__ . '/classes/database_class.php');
        require_once(__DIR__ . '/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

    if(isset($life)) {
        if($life=='y') {
            if(isset($_FILES['file'])) {

$uploadtype= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$btnupload= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);            
 

if(isset($btnupload)) {    
    $DATE = date("his"); 
 $file = $search."-".$DATE."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists("uploads/life/$search")) {
    mkdir("uploads/life/$search", 0777, true);
}

 $folder="uploads/life/$search/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);
 
 if($uploadtype=="LGPolicy Summary") {
     $final_file=$search."-".$uploadtype."-".$DATE;
     
 } else {

 $final_file=str_replace("'","",$new_file_name);
 
 }
 
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$uploadtype, PDO::PARAM_STR, 255);
$TBL_query->execute();  

$clientnamedata= "Upload";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by=:SENT, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':CID',$search, PDO::PARAM_INT);
$query->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

 header('Location: /Life/ViewClient.php?fileuploaded=y&?success&fileupname='.$uploadtype.'&search='.$search.'#menu2'); die;
 }

}

header('Location: /Life/ViewClient.php?fileuploadedfail=y&?fail&search='.$search.'#menu2'); die;
          
            }
            header('Location: /Life/ViewClient.php?UPLOAD=MAX&search='.$search.'#menu2'); die;
        }
    }
    
 ?>
