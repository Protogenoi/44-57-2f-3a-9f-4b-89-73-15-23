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
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
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

$deleteimage= filter_input(INPUT_GET, 'deleteimage', FILTER_SANITIZE_SPECIAL_CHARS);

        if($deleteimage=='y') {
            
$uploadid= filter_input(INPUT_POST, 'uploadid', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadfile= filter_input(INPUT_POST, 'uploadfile', FILTER_SANITIZE_SPECIAL_CHARS);

  
     
$query = $pdo->prepare("DELETE FROM tbl_uploads WHERE id=:idholder ");
unlink("../uploads/$uploadfile");
$query->bindParam(':idholder',$uploadid, PDO::PARAM_INT);
$query->execute()or die(print_r($query->errorInfo(), true));

            if(isset($fferror)) {
    if($fferror=='0') {
        

header('Location: ../admin/Admindash.php?companylogo=deleted&company=y'); die;
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

      

?>

