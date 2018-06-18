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

require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '../../includes/adl_features.php');

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$LOGOUT_ACTION = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$FEATURE = filter_input(INPUT_GET, 'FEATURE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($LOGOUT_ACTION) && $LOGOUT_ACTION == "log_out") {
	$page_protect->log_out();
}

if(isset($hello_name)) {

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);

$companynamere = $companydetailsq['company_name'];

?>
<style>
    .dropdown-menu li:hover .sub-menu {
    visibility: visible;
    }
    .dropdown:hover .dropdown-menu {
    display: block;
    }
</style>

    <nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/index.php" class="navbar-brand"> ADL</a>
        </div>
        
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/CRMmain.php"><i class="fa fa-home"></i> Home</a></li>
                
                <?php if(in_array($hello_name, $Level_3_Access, true)) { ?>
                
                <li><a href="/app/AddClient.php"><i class="fas fa-user-plus"></i> Add</a></li>
                <li><a href="/app/SearchClients.php"><i class="fas fa-search"></i> Search</a></li>

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CRM <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/app/AddClient.php">Add Client</a></li>
                        <li><a href="/app/SearchClients.php">Search Clients</a></li>
                        <li><a href="/app/SearchPolicies.php?EXECUTE=Life">Search Policies</a></li>
                        <?php if(in_array($hello_name, $Level_8_Access, true) && $fflife == 1) { ?>
                        <li><a href="/addon/Life/SaleSearch.php">Search Sales</a></li>    
                        <?php } ?>
                        <li class="divider"></li>
                        <?php if(in_array($hello_name, $Level_8_Access, true)) { ?>
                        <li><a href="/addon/Life/Reports/menu.php">Reports</a></li>                        
                        <li><a href="/addon/Workflows/Workflows.php?EXECUTE=1">Workflows</a></li>
                        <?php if ($ffsms == '1') { ?>
                        <li><a href="/app/SMS/Report.php?SEARCH_BY=Sent">SMS Report</a></li>
                        <?php }
                        }
                        if ($ffcalendar == '1') { ?>
                        <li><a href="/app/calendar/calendar.php">Callbacks</a></li>
                        <?php } ?>
                        <li class="divider"></li>   
                        <li><a href="/email/Emails.php">Emails</a></li>
                            <li><a href="/addon//Life/Reports/Uploads.php?SEARCH=Insurer Keyfacts">Missing Uploads</a></li>
                        <?php if ($ffkeyfactsemail == '1') { ?>
                            <li><a href="/addon/Life/Reports/Keyfacts.php">KeyFact Email Report</a></li>
                        <?php } ?>    
                           <li class="divider"></li>  
                    <li><a href="/app/messenger/Main.php"> Internal Messages</a></li>
                    <?php if(in_array($hello_name, $Level_10_Access, true)) { ?>
                    <li><a href="/app/docs/DocStore.php"> Doc Store</a></li>
                    <?php } ?>
                    <?php if ($ffews == '1' && in_array($hello_name, $Level_8_Access, true)) { ?>
                    <li class="divider"></li>
                    <li><a href="/Life/Reports/EWS.php"> Early Warning System</a></li>
                    <li><a href="/Life/Reports/EWSModify.php"> Correct a EWS Record</a></li>
                    <li><a href="/Life/Reports/EWSAgentPerformance.php"> EWS Agent Performance</a></li> 
                    <li><a href="/Life/EWS/Search.php"> Search EWS To Work</a></li> 
                    <li><a href="/Life/EWS/CallHistory.php"> Search EWS Timeline Notes</a></li> 
                    <?php } ?>
                    </ul>
                </li>
                
                <?php } 
                if(isset($fftrackers) && $fftrackers == 1 || isset($ffcompliance) && $ffcompliance == 1 || isset($ffaudits) && $ffaudits == 1 ) {
                if(in_array($hello_name, $Level_3_Access, true)) { ?>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Compliance <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                        <?php if (in_array($hello_name, $Level_10_Access, true) && $ffcompliance == '1') { ?>   
                            <li><a href="/addon/compliance/dash.php?EXECUTE=1"> Compliance Hub</a></li>
                            <li><a href="/addon/compliance/dash.php?EXECUTE=3"> Sale Stats</a></li>
                            <li><a href="/addon/compliance/CAR.php"> Compliance Audit and Review</a></li>
                            <li><a href="/addon/compliance/Compliance.php?SCID=1"> Uploaded Docs</a></li>
                            <li class="divider"></li>
                        <?php } if($ffaudits == 1) { ?>  
                            <li><a href="/addon/audits/search_audits.php">Search Audits</a></li>
                            <li><a href="/addon/audits/auditor_menu.php">Legal and General Audits</a></li>
                            <li><a href="/addon/audits/Aviva/Menu.php">Aviva Audits</a></li>
                            <li><a href="/addon/audits/WOL/Menu.php">One Family Audits</a></li>
                            <li><a href="/addon/audits/lead_gen_reports.php?step=New">Search Old Lead Audits</a></li>
                            <li><a href="/addon/audits/LV/Search.php">Search Old LV Audits</a></li>
                            <li><a href="/addon/audits/Vitality/Search.php">Search Old Vitality Audits</a></li>
                            <li><a href="/addon/audits/RoyalLondon/Search.php">Search Old Royal London Audits</a></li>                            
                        <?php } ?>
                        </ul>
                    </li>
                    
                <?php  } }
                if(isset($fftrackers) && $fftrackers == 1 || isset($ffdealsheets) && $ffcompliance == 1) {
                if(in_array($hello_name, $Manager_Access, true) || in_array($hello_name, $Closer_Access, true)) { ?>

            <li class="dropdown">
        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Dialler<b class='caret'></b></a>
        <ul role='menu' class='dropdown-menu'>
            <?php 
            if(isset($fftrackers) && $fftrackers == '1') {
            if (in_array($hello_name, $Agent_Access, true) || in_array($hello_name, $Manager_Access, true)) {  ?>
            <li><a href="/addon/Trackers/Survey.php">Survey Trackers</a></li> 
            <?php } } if ($fftrackers == '1') {  ?>
            <li><a href="/addon/Trackers/Tracker.php?query=CloserTrackers"><?php if(isset($hello_name)) { echo $hello_name; } ?> Trackers</a></li>
            <?php } if ($ffdealsheets == '1') { 
                if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager_Access, true)) { ?>
            <li><a href="/Life/Dealsheet.php?query=CloserDealSheets"><?php if(isset($hello_name)) { echo $hello_name; } ?> Closer Dealsheets</a></li>
            <?php } } ?>
            <li class="divider"></li> 
            <?php if(isset($fftrackers) && $fftrackers == '1') { 
                if(in_array($hello_name, $Manager_Access, true)) { ?>
            <li><a href="/addon/Trackers/Closers.php?EXECUTE=1">Search Closer Trackers</a></li>
            <li><a href="/addon/Trackers/SearchSurvey.php">Search Survey Trackers</a></li>
            <li><a href="/addon/Trackers/Agent.php?EXECUTE=1">Search Agent Trackers</a></li>
            <?php } } 
            if(isset($ffdealsheets) && $ffdealsheets == '1') { 
                if(in_array($hello_name, $Manager_Access, true)) { ?> 
            <li><a href="/Life/Dealsheet.php?query=AllCloserDealSheets">Search Dealsheets</a></li>
            <?php } } 
            if(isset($ffdealsheets) && $ffdealsheets == '1') {  ?>
            <li class="divider"></li>
            <?php if(in_array($hello_name, $QA_Access) || in_array($hello_name, $Level_9_Access, true)) { ?>
            <li><a href="/Life/Dealsheet.php?query=QADealSheets">Dealsheets for QA</a></li>
            <li><a href="/Life/Dealsheet.php?query=CompletedDeals">Completed Dealsheets</a></li>
            <?php } } ?>
            <?php if(in_array($hello_name, $Level_10_Access, true)) { ?>
            <li class="divider"></li>
            <li><a href="/addon/dialer/CloseRates.php" target="_blank">Tracker Wallboard (Full)</a></li>
            <li><a href="/addon/dialer/Admin_Tracker.php" target="_blank">Tracker Wallboard (Admin)</a></li>
            <li><a href="/addon/dialer/Tracker.php" target="_blank">Tracker Wallboard (Limited)</a></li>
            <li><a href="http://192.168.1.184/Wallboards/Life.php" target="_blank">Wallboard</a></li>
            <li><a href="/addon/dialer/time_rates.php?">Time Tracker Wallboard</a></li>            
            <?php } ?>
      </ul>
                <?php } }
      
      if(isset($ffdealsheets) && $ffdealsheets == '1') { 
          if(in_array($hello_name, $Manager_Access, true) || in_array($hello_name, $Agent_Access, true)) { ?>
            
            <li class="dropdown">
                <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Agents<b class='caret'></b></a>
                <ul role='menu' class='dropdown-menu'>
            <li><a href="/addon/Life/Dealsheet/Dealsheet.php"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets</a></li>
            <li><a href="/addon/Life/Dealsheet/Dealsheet.php?query=ListCallbacks"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets Callbacks</a></li>
      </ul>
      <?php } }           
      
      if($ffkeyfactsemail=='1' && in_array($hello_name, $Closer_Access, true)) { ?>
             <li><a href="/email/KeyFactsEmail.php" target="_blank">Send Keyfacts</a></li>      
                
      <?php } ?>
             
             <li class='dropdown'>
                 <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Admin <b class='caret'></b></a>
                 <ul role='menu' class='dropdown-menu'>
                            <?php if(in_array($hello_name, $Level_10_Access, true)) { 
                                if ($fffinancials == '1') { ?>
                     <li><a href="/addon/Life/Financials/Menu.php">Financials</a></li>
                         <?php }
                         if ($ffews == '1') { ?>
                     <li><a href="/Life/Reports/EWS.php">EWS</a></li> 
                            <?php } 
                            if ($ffemployee == '1') { ?>    
                     <li><a href="/addon/Staff/Main_Menu.php">Staff Database</a></li> 
                            <?php } 
                            if ($ffemployee == '1') { ?>    
                     <li><a  href="/addon/Staff/Holidays/Calendar.php">Holidays</a></li> 
                     <li><a  href="/addon/Staff/Reports/RAG.php">Register</a></li> 
                     <li><a  href="/addon/Staff/Assets/Assets.php">Asset Management</a></li> 
                            <?php } ?>
                     <li class="divider"></li> 
                     <li><a href='/app/admin/Admindash.php?admindash=y'>Control Panel</a></li>
                            <?php } ?>
                 </ul>  
             </li>
             
            </ul>
            
<?php if(in_array($hello_name, $Level_3_Access, true)) { ?>
                <div class="LIVERESULTS">

                </div>
<?php } ?>
        </div>
    </nav>

<?php if(in_array($hello_name, $Level_3_Access, true)) { ?>
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: '/app/NavbarLiveResults.php',
                type: 'POST',
                success: function (results) {
                    jQuery(".LIVERESULTS").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 3000);
    </script>
<?php }  } ?>