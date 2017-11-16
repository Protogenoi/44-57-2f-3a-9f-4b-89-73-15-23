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

    include('../includes/Access_Levels.php');

        if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;

}

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/ADL_PDO_CON.php');

$life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
$home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
$pension= filter_input(INPUT_GET, 'pension', FILTER_SANITIZE_SPECIAL_CHARS);
$clientid= filter_input(INPUT_POST, 'deleteclientid', FILTER_SANITIZE_NUMBER_INT);

if(isset($home)) {
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
    $query = $pdo->prepare("DELETE FROM client_details WHERE client_id=:CID AND company='TRB Home Insurance' LIMIT 1");
    $query->bindParam(':CID',$CID, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                   if(isset($fferror)) {
                       if($fferror=='0') { 
                           header('Location: ../CRMmain.php?clientdeleted=y'); die;
                           
                       }
                       
                       }
                       
                       }


if(isset($life)) {
    
    $query = $pdo->prepare("DELETE FROM client_details WHERE client_id=:idholder LIMIT 1");
    $query->bindParam(':idholder',$clientid, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                   if(isset($fferror)) {
    if($fferror=='0') {
    
    header('Location: ../CRMmain.php?clientdeleted=y'); die;     
    }
                   }
    
}

if(isset($pension)) {
    
    $query = $pdo->prepare("DELETE FROM pension_clients WHERE client_id=:idholder LIMIT 1");
    $query->bindParam(':idholder',$clientid, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
                   if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../CRMmain.php?clientdeleted=y'); die;   
    }
                   }
    
}
               if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../CRMmain.php?clientdeleted=failed'); die;
    }
               }

?>


