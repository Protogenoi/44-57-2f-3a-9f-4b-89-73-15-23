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

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/adl_features.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 
    
        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }    
    
    $custype= filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($custype)) {        
        if($custype=='PBA') {
            
        $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel= filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel2= filter_input(INPUT_POST, 'tel2', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel3= filter_input(INPUT_POST, 'tel3', FILTER_SANITIZE_SPECIAL_CHARS);
        $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'lastname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add1= filter_input(INPUT_POST, 'add1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'add2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'add3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        
        $database = new Database(); 
            
            $database->query("INSERT into pba_client_details set title=:title, firstname=:first, lastname=:last, dob=:dob, email=:email, tel=:tel, tel2=:tel2, tel3=:tel3, title2=:title2, firstname2=:first2, lastname2=:last2, dob2=:dob2, email2=:email2, add1=:add1, add2=:add2, add3=:add3, town=:town, post_code=:post, submitted_by=:hello");
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':tel',$tel);
            $database->bind(':tel2',$tel2);
            $database->bind(':tel3',$tel3);
            $database->bind(':title2', $title2);
            $database->bind(':first2',$first2);
            $database->bind(':last2',$last2);
            $database->bind(':dob2',$correct_dob2);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':post',$post);
            $database->bind(':hello',$hello_name);
            $database->execute();  
            $last_id = $database->lastInsertId();
            
            if ($database->rowCount()>=1) {
            
                header('Location: ../AddNewClient.php?Clientadded=1&id='.$last_id); die;
                
            }
            
            else {
             
                header('Location: ../AddNewClient.php?Clientadded=0'); die;
                
            }
            
        }
 }
else {
header('Location: /../../../../../CRMmain.php?Clientadded=failed'); die;
}
?>