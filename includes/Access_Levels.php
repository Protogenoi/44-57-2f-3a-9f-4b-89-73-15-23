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
$COM_LVL_10_ACCESS = array("Michamel");
$TRB_ACCESS= array("Michael","Matt","leighton","Nick");
    
    $COMPANY_ENTITY_ID="1";
    $COMPANY_ENTITY = 'Bluestone Protect';
    $COMPANY_ENTITY_LEAD_GENS="The Review Bureau";
    
    $Level_10_Access = array("Michael", "Matt", "leighton", "Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton", "Nick", "carys");
    $Level_8_Access = array("Nathan Thomas","Molly Grove","Michael", "Matt", "leighton", "Nick", "carys", "Tina", "Nicola","David Bebee","Ryan Tidbal","Lois Taylor");
    $Level_3_Access = array("Molly Grove","Nathan Thomas","Archiver","Michael", "Matt", "leighton", "Nick", "carys", "Jakob", "Nicola", "Tina","Ryan","Christopher Griffiths","David Bebee","Ryan Tidbal","Lois Taylor");
    $Level_1_Access = array("Molly Grove","Nathan Thomas","Archiver","Michael", "Matt", "leighton", "Nick", "carys", "Jakob", "Nicola", "Tina","Ryan","Christopher Griffiths","David Bebee","Ryan Tidbal","Lois Taylor");
    
    $Task_Access = array("Jakob","David Bebee");
    
    $SECRET = array("Michael", "carys", "Jakob", "Nicola", "Tina");
    
    $Agent_Access = array("Bob Jones");
    $Closer_Access = array("Bob Jones");
    $Manager_Access = array("Michael", "Matt", "leighton", "Nick", "carys", "Nicola","Ryan","Jakob","Christopher Griffiths");

    $EWS_SEARCH_ACCESS=array("Bob Jones");
    $ADMIN_EWS_SEARCH_ACCESS=array("carys","Nicola","Michael","Matt");
    $OLD_CLIENT_SEARCH=array("Bob Jones");
    
    ///Advanced Admin Search
    $GOOD_SEARH_ACCESS=array("Michael","Matt","leighton","Nick","Tina","Archiver","Nicola","Jakob","carys","Molly Grove","David Bebee");
    //Basic Admin Search
    $ADMIN_SEARCH_ACCESS=array("carys","Jakob","Nicola","Michael","Nick","Tina","Matt","leighton","Molly Grove","David Bebee","Ryan Tidbal","Lois Taylor");
    //View Dealsheets awaiting QA
    $QA_Access = array("Michael","Nathan Thomas","carys", "Jakob", "Nicola", "Tina","Ryan","Molly Grove","Christopher Griffiths","David Bebee","Ryan Tidbal","Lois Taylor");
    
    $AUDIT_SEARCH_ACCESS=array("Molly Grove","Nathan Thomas","Ryan","Christopher Griffiths","Ryan Tidbal","Lois Taylor");
?>