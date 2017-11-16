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

require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../../classes/database_class.php');
    require_once(__DIR__ . '../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($USER,$TOKEN);
        $CHECK_USER_LOGIN->CheckToken();
        $OUT=$CHECK_USER_LOGIN->CheckToken();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }        
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) { 
    if($EXECUTE=='1') {

    $COMPANY='Bluestone Protect';
       

    if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
                $query = $pdo->prepare("SELECT employee_details.employed, employee_details.company, employee_details.employee_id, CONCAT(employee_details.firstname,' ', employee_details.lastname) AS NAME, employee_contact.mob, employee_contact.tel, employee_details.position FROM employee_details JOIN employee_contact ON employee_details.employee_id = employee_contact.employee_id ORDER BY employee_details.added_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    } else {
                $query = $pdo->prepare("SELECT employee_details.employed, employee_details.company, employee_details.employee_id, CONCAT(employee_details.firstname,' ', employee_details.lastname) AS NAME, employee_contact.mob, employee_contact.tel, employee_details.position FROM employee_details JOIN employee_contact ON employee_details.employee_id = employee_contact.employee_id WHERE employee_details.company=:COMPANY ORDER BY employee_details.added_date DESC");
       $query->bindParam(':COMPANY', $COMPANY, PDO::PARAM_STR);
                $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
    


        
    }
    
} } }
    
    ?>