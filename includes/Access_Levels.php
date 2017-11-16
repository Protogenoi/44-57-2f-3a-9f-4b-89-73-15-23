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

require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);

$companynamere = $companydetailsq['company_name'];

$TIMELOCK_ACCESS=array("Michael","Matt","Archiver");

if(!in_array($hello_name, $TIMELOCK_ACCESS)) {
$TIMELOCK = date('H');

if($TIMELOCK>='20' || $TIMELOCK<'08') {
    
                $USER_TRACKING_QRY = $pdo->prepare("INSERT INTO user_tracking
                    SET
                    user_tracking_id_fk=(SELECT id from users where login=:HELLO), user_tracking_url='Access_Level_Logout', user_tracking_user=:USER
                    ON DUPLICATE KEY UPDATE
                    user_tracking_url='Access_Level_Logout'");
                $USER_TRACKING_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':USER', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->execute();      
   
    header('Location: ../../CRMmain.php?action=log_out');
    die;
    
}
}

$COM_MANAGER_ACCESS = array("Michael");
$COM_LVL_10_ACCESS = array("Michael");
$TRB_ACCESS= array("Michael","Matt","leighton","Nick");
    
    $COMPANY_ENTITY_ID="1";
    $COMPANY_ENTITY = 'Bluestone Protect';
    
    $Level_10_Access = array("Michael", "Matt", "leighton", "Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton", "Nick", "carys");
    $Level_8_Access = array("Molly Grove","Michael", "Matt", "leighton", "Nick", "carys", "Tina", "Nicola");
    $Level_3_Access = array("Molly Grove","Ciara","Nathan Thomas","Corey Divetta","Hayley Hutchinson","Sarah Wallace","Archiver","Michael", "Matt", "leighton", "Nick", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Keith", "Ryan", "David","Richard","James Adams","Katie Guilfoyle");
    $Level_1_Access = array("Molly Grove","Ciara","Nathan Thomas","Corey Divetta","Hayley Hutchinson","Sarah Wallace","Archiver","Michael", "Matt", "leighton", "Nick", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Audits", "Ryan", "Keith","David","Darryl","Gavin","James Adams","Katie Guilfoyle");
    
    $Task_Access = array("Ciara","Jakob");
    
    $SECRET = array("Michael", "carys", "Jakob", "Nicola", "Tina", 'Amy');
    
    $Agent_Access = array("Bob Jones");
    $Closer_Access = array("Martin","James", "Hayley","Mike", "Kyle", "Sarah", "Richard", "Mike","Corey","Gavin");
    $Manager_Access = array("Corey Divetta","Hayley Hutchinson","Sarah Wallace","Richard", "Keith", "Michael", "Matt", "leighton", "Nick", "carys", "Nicola","David","Darryl","Ryan","Amy","Jakob","James Adams","Katie Guilfoyle");
    
    $QA_Access = array("Michael","Nathan Thomas","carys", "Jakob", "Nicola", "Tina", "Amy","Ryan","Ciara","Katie Guilfoyle");
    
    $ANYTIME_ACCESS=array("Archiver","Michael","Matt","Jade");
    
    $GOOD_SEARH_ACCESS=array("Michael","Matt","leighton","Nick","Tina","Archiver","Nicola","carys");
    $EWS_SEARCH_ACCESS=array("");
    $ADMIN_EWS_SEARCH_ACCESS=array("carys","Nicola","Michael","Matt");
    $OLD_CLIENT_SEARCH=array("Hayley Hutchinson","Sarah Wallace","James Adams","Corey Divetta");
    $ADMIN_SEARCH_ACCESS=array("carys","Jakob","Nicola","Michael","Nick","Tina","Matt","leighton");
    
    $AUDIT_SEARCH_ACCESS=array("Molly Grove","Amy","Nathan Thomas","Ryan","Ciara","Katie Guilfoyle");
?>