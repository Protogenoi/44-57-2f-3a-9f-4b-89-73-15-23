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

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

require_once(BASE_URL.'/classes/access_user/access_user_class.php');$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(BASE_URL.'/includes/user_tracking.php');

require_once(BASE_URL.'/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS); 
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT); 

$UPLOAD_TYPE= filter_input(INPUT_POST, 'uploadtype', FILTER_SANITIZE_SPECIAL_CHARS);
$UPLOAD_CHECK= filter_input(INPUT_POST, 'btn-upload', FILTER_SANITIZE_SPECIAL_CHARS);     

            if(isset($_FILES['file'])) {
            if($_FILES['file']['size'] > 40000000) {
                header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=2&search='.$CID.'&CLIENT_FILE='.$UPLOAD_TYPE.''); die;
            }
            }

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');
require_once(BASE_URL.'/includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(BASE_URL.'/classes/database_class.php');
        require_once(BASE_URL.'/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
            if(isset($_FILES['file'])) {
                if(isset($UPLOAD_CHECK)) {   
                    
 $DATE = date("his"); 
 $file = $CID."-".$DATE."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 
 if (!file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/life/$CID")) {
    mkdir(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/life/$CID", 0777, true);
}

 $folder=filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/life/$CID/";
 
 $new_size = $file_size/1024;  
 $new_file_name = strtolower($file);
 
 if($UPLOAD_TYPE=="LGPolicy Summary") {
     $final_file=$CID."-".$UPLOAD_TYPE."-".$DATE;
     
 } else {

 $final_file=str_replace("'","",$new_file_name);
 
 }
 
 if(move_uploaded_file($file_loc,$folder.$final_file)) {

$TBL_query = $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype=:uploadtype");
$TBL_query->bindParam(':file',$final_file, PDO::PARAM_STR,500);
$TBL_query->bindParam(':type',$file_type, PDO::PARAM_STR, 100);
$TBL_query->bindParam(':size',$new_size, PDO::PARAM_STR, 500);
$TBL_query->bindParam(':uploadtype',$UPLOAD_TYPE, PDO::PARAM_STR, 255);
$TBL_query->execute();  

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='Upload', sent_by=:SENT, note_type=:NOTE, message=:MSG ");
$INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
$INSERT->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':NOTE',$UPLOAD_TYPE, PDO::PARAM_STR, 255);
$INSERT->bindParam(':MSG',$final_file, PDO::PARAM_STR, 2500);
$INSERT->execute();

 header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=1&?success&CLIENT_FILE='.$UPLOAD_TYPE.'&search='.$CID.'#menu2'); die;
 }

}

header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=0&&search='.$CID.''); die;
          
            }
            
            header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=2&search='.$CID.'&CLIENT_FILE='.$UPLOAD_TYPE); die;
        }
    }
    
 ?>