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

require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);

$companynamere = $companydetailsq['company_name'];

$TIMELOCK_ACCESS=array("Michael","Matt","Archiver");

$ANYTIME_ACCESS=array("Archiver","Michael","Matt");
$COM_MANAGER_ACCESS = array("Michmael");
$COM_LVL_10_ACCESS = array("Bob Jones");
$TRB_ACCESS= array("Michael","Matt");
    
    $COMPANY_ENTITY_ID="1";
    $COMPANY_ENTITY = 'Bluestone Protect';
    $COMPANY_ENTITY_LEAD_GENS="The Review Bureau";
    
    $Level_10_Access = array("Michael", "Matt");
    $Level_9_Access = array("Michael", "Matt");
    $Level_8_Access = array("Michael", "Matt","Tina","carys");
    $Level_3_Access = array("Archiver","Michael", "Matt","Tina","carys");
    $Level_1_Access = array("Archiver","Michael", "Matt","Tina","carys");
    
    $Task_Access = array("Bob Jones");
    
    $SECRET = array("Michael");
    
    $Agent_Access = array("Bob Jones");
    $Closer_Access = array("Bob Jones");
    $Manager_Access = array("Michael","Matt");

    $EWS_SEARCH_ACCESS=array("Bob Jones");
    $ADMIN_EWS_SEARCH_ACCESS=array("Michael","Matt");
    $OLD_CLIENT_SEARCH=array("Bob Jones");
    
    ///Advanced Admin Search
    $GOOD_SEARH_ACCESS=array("Michael","Matt","Tina","Archiver","carys");
    //Basic Admin Search
    $ADMIN_SEARCH_ACCESS=array("Michael","Tina","Matt");
    //View Dealsheets awaiting QA
    $QA_Access = array("Michael","Tina");
    
    $AUDIT_SEARCH_ACCESS=array("Bob Jones");
?>