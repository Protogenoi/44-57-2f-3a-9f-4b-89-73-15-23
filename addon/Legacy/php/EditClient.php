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
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/adl_features.php');

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

    $legacy= filter_input(INPUT_GET, 'legacy', FILTER_SANITIZE_SPECIAL_CHARS);
    
        if(isset($legacy)) {
            if($legacy=='y') {
            
            $clientid= filter_input(INPUT_POST, 'clientid', FILTER_SANITIZE_NUMBER_INT);
            
                $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
                $firstname= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
                $middlename= filter_input(INPUT_POST, 'middlename', FILTER_SANITIZE_SPECIAL_CHARS);
                $surname= filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_SPECIAL_CHARS);
                $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
                $smoker= filter_input(INPUT_POST, 'smoker', FILTER_SANITIZE_SPECIAL_CHARS);
                $home_email= filter_input(INPUT_POST, 'home_email', FILTER_SANITIZE_SPECIAL_CHARS);
                $work_email= filter_input(INPUT_POST, 'office_email', FILTER_SANITIZE_SPECIAL_CHARS);
                $DaytimeTel= filter_input(INPUT_POST, 'DaytimeTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $EveningTel= filter_input(INPUT_POST, 'EveningTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $MobileTel= filter_input(INPUT_POST, 'MobileTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $Client_telephone= filter_input(INPUT_POST, 'Client_telephone', FILTER_SANITIZE_SPECIAL_CHARS);
                $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
                $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
                $address4= filter_input(INPUT_POST, 'address4', FILTER_SANITIZE_SPECIAL_CHARS);
                $postcode= filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
                
                $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
                                
                $clientone = $pdo->prepare("UPDATE assura_client_details set title=:title, firstname=:firstname, middlename=:middlename, surname=:surname, DaytimeTel=:DaytimeTel, EveningTel=:EveningTel, MobileTel=:MobileTel, Client_telephone=:Client_telephone, home_email=:home_email, office_email=:office_email, address1=:address1, address2=:address2, address3=:address3, address4=:address4, postcode=:postcode, dob=:dob, smoker=:smoker WHERE client_id = :id");
                $clientone->bindParam(':id', $clientid, PDO::PARAM_STR, 12);

                $clientone->bindParam(':title', $title, PDO::PARAM_STR, 200);
                $clientone->bindParam(':firstname', $firstname, PDO::PARAM_STR, 200);
                $clientone->bindParam(':middlename', $middlename, PDO::PARAM_STR, 200);
                $clientone->bindParam(':surname', $surname, PDO::PARAM_STR, 200);
                $clientone->bindParam(':dob', $dob, PDO::PARAM_STR, 200);
                $clientone->bindParam(':smoker', $smoker, PDO::PARAM_STR, 200);
                $clientone->bindParam(':home_email', $home_email, PDO::PARAM_STR, 200);
                $clientone->bindParam(':office_email', $work_email, PDO::PARAM_STR, 200);
                $clientone->bindParam(':DaytimeTel', $DaytimeTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':EveningTel', $EveningTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':MobileTel', $MobileTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':Client_telephone', $Client_telephone, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address1', $address1, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address2', $address2, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address3', $address3, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address4', $address4, PDO::PARAM_STR, 200);
                $clientone->bindParam(':postcode', $postcode, PDO::PARAM_STR, 200);
                $clientone->execute();

                $clientnamedata= "CRM Alert";   
                $notedata= "Client Details Updated";
                
                $query = $pdo->prepare("INSERT INTO legacy_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $query->bindParam(':clientidholder',$clientid, PDO::PARAM_INT);
                $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
                $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                $query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
                $query->execute(); 
            
                $clientid2= filter_input(INPUT_POST, 'clientid2', FILTER_SANITIZE_NUMBER_INT);
            
            if (isset($clientid2)) {
                
                $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
                $firstname2= filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_SPECIAL_CHARS);
                $middlename2= filter_input(INPUT_POST, 'middlename2', FILTER_SANITIZE_SPECIAL_CHARS);
                $surname2= filter_input(INPUT_POST, 'surname2', FILTER_SANITIZE_SPECIAL_CHARS);
                $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
                $smoker2= filter_input(INPUT_POST, 'smoker2', FILTER_SANITIZE_SPECIAL_CHARS);
                $home_email2= filter_input(INPUT_POST, 'home_email2', FILTER_SANITIZE_SPECIAL_CHARS);
                $work_email2= filter_input(INPUT_POST, 'office_email2', FILTER_SANITIZE_SPECIAL_CHARS);
                $DaytimeTel2= filter_input(INPUT_POST, 'DaytimeTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $EveningTel2= filter_input(INPUT_POST, 'EveningTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $MobileTel2= filter_input(INPUT_POST, 'MobileTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $Client_telephone2= filter_input(INPUT_POST, 'Client_telephone2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
                $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
                $address4= filter_input(INPUT_POST, 'address4', FILTER_SANITIZE_SPECIAL_CHARS);
                $postcode= filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
                
                $clienttwo = $pdo->prepare("UPDATE assura_client_details set title=:title, firstname=:firstname, middlename=:middlename, surname=:surname, DaytimeTel=:DaytimeTel, EveningTel=:EveningTel, MobileTel=:MobileTel, Client_telephone=:Client_telephone, home_email=:home_email, office_email=:office_email, address1=:address1, address2=:address2, address3=:address3, address4=:address4, postcode=:postcode, dob=:dob, smoker=:smoker WHERE client_id = :id");

                $clienttwo->bindParam(':id', $clientid2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':title', $title2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':firstname', $firstname2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':middlename', $middlename2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':surname', $surname2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':dob', $dob2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':smoker', $smoker2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':home_email', $home_email2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':office_email', $work_email2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':DaytimeTel', $DaytimeTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':EveningTel', $EveningTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':MobileTel', $MobileTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':Client_telephone', $Client_telephone2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address1', $address1, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address2', $address2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address3', $address3, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address4', $address4, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':postcode', $postcode, PDO::PARAM_STR, 200);               
                $clienttwo->execute();
            
            }
            
           header('Location: ../ViewLegacyClient.php?clientedited=y&search='.$clientid); die; 
           
        }
        }

header('Location: ../../../CRMmain.php?Clientadded=failed'); die;

?>