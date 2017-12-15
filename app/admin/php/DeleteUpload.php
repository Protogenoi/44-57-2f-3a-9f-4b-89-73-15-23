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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

if (!in_array($hello_name, $Level_10_Access, true)) {

    header('Location: /../../../../CRMmain.php');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'deletefile', FILTER_SANITIZE_NUMBER_INT);
if (isset($EXECUTE)) {

    if ($EXECUTE == '1') {

        $FILE_NAME = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_SPECIAL_CHARS);
        $UPID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $CID = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);

        $query = $pdo->prepare("DELETE FROM tbl_uploads where id = :id");
        $query->bindParam(':id', $UPID, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {

            if (file_exists("../uploads/$FILE_NAME")) {
                unlink("../uploads/$FILE_NAME");
            } 
            
            if (file_exists("../uploads/life/$FILE_NAME")) {
                unlink("../uploads/life/$FILE_NAME");
            }
            
            if (file_exists("../uploads/life/$CID/$FILE_NAME")) {
                unlink("../uploads/life/$CID/$FILE_NAME");
            }            
            
            $count=1;
            
$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='ADL Alert', sent_by=:SENT, note_type='Deleted File Upload', message=:MSG ");
$query->bindParam(':CID',$CID, PDO::PARAM_INT);
$query->bindParam(':SENT',$hello_name, PDO::PARAM_STR);
$query->bindParam(':MSG',$FILE_NAME, PDO::PARAM_STR);
$query->execute();            

                    header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=3&search=' . $CID . '&CLIENT_FILE_COUNT=' . $count . 'CLIENT_FILE=' . $FILE_NAME . '#menu2');
                    die;
        } else {
                    header('Location: /../../../../app/Client.php?CLIENT_UPLOAD=4&search=' . $CID . 'CLIENT_FILE=' . $FILE_NAME . '#menu2');
                    die;
        }
    }
}

        header('Location: /../../../../CRMmain.php');
        die;
?>