<?php
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
$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: /Life/Financial_Menu.php');
    die;
}

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
                <li class="active"><a href="/CRMmain.php"><i class="fa fa-home">  Home</i></a></li>
                
                <?php if(in_array($hello_name, $Level_3_Access, true)) { ?>
                
                <li><a href="/AddClient.php"><i class="fa fa-user-plus">  Add</i></a></li>
                <li><a href="/SearchClients.php"><i class="fa fa-search">  Search</i></a></li>

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CRM <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/AddClient.php">Add Client</a></li>
                        <li><a href="SearchClients.php">Search Clients</a></li>
                        <li><a href="/SearchPolicies.php?query=Life">Search Policies</a></li>
                        <li class="divider"></li>
                        <?php if(in_array($hello_name, $Level_8_Access, true)) { ?>
                        <li><a href="/CRMReports.php">Reports</a></li>                        
                        <li><a href="/Life/Reports/AllTasks.php">Tasks</a></li>
                        <?php if ($ffsms == '1') { ?>
                        <li><a href="/Life/SMS/Menu.php">SMS Report</a></li>
                        <?php } if(in_array($hello_name, $Level_8_Access, true)) { ?>
                        <li><a href="/Life/SaleSearch.php">Search Sales (by closer and date range)</a></li>    
                        <?php }
                        }
                        if ($ffcalendar == '1') { ?>
                        <li><a href="/calendar/calendar.php">Callbacks</a></li>
                        <?php } ?>
                        <li class="divider"></li>   
                            <li><a href="/Emails.php">Emails</a></li>
                            <li><a href="/Life/Reports/Uploads.php?SEARCH=Insurer Keyfacts">Missing Uploads</a></li>
                        <?php if ($ffkeyfactsemail == '1') { ?>
                            <li><a href="/Life/Reports/Keyfacts.php">KeyFact Email Report</a></li>
                        <?php } ?>    
                           <li class="divider"></li>
                        <?php if ($ffcompliance == '1') { ?>   
                            <li><a href="/compliance/dash.php?EXECUTE=1"> Compliance</a></li>
                            <li class="divider"></li>
                        <?php } ?>    
                    <li><a href="/messenger/Main.php>"> Internal Messages</a></li>  

                    </ul>
                </li>
                
                <?php } ?>
                
                <?php if(in_array($hello_name, $Level_3_Access, true) && $ffaudits == '1') { ?>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Audits <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/audits/main_menu.php">Main Menu</a></li>
                            <li class="divider"></li>
                            <li><a href="/audits/lead_gen_reports.php?step=New">Lead Audits</a></li>
                            <li><a href="/audits/auditor_menu.php">Legal and General Audits</a></li>
                            <li><a href="/audits/RoyalLondon/Menu.php">Royal London Audits</a></li>
                            <li><a href="/audits/Aviva/Menu.php">Aviva Audits</a></li>
                            <li><a href="/audits/WOL/Menu.php">One Family Audits</a></li>
                            <li class="divider"></li>
                            <li><a href="/audits/reports_main.php">Reports</a></li>
                        </ul>
                    </li>
                    
                <?php } 
                if(in_array($hello_name, $Manager_Access, true) || in_array($hello_name, $Closer_Access, true)) { ?>

            <li class="dropdown">
        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
          Dialler
        <b class='caret'></b></a>
        <ul role='menu' class='dropdown-menu'>
            <?php if ($ffdialler == '1') { ?>
            <li><a  href="/dialer/Recordings.php">Recordings</a></li>
            <?php } 
            if ($ffdealsheets == '1') { ?>
            <li><button class="list-group-item" onclick="CALLMANANGER();"><i class="fa fa-bullhorn fa-fw"></i>&nbsp; Call Manager/Cancel Call</button></li>
            <li><a href="/Life/LifeDealSheet.php"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets</a></li>
            <li><a href="/Life/LifeDealSheet.php?query=ListCallbacks"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets Callbacks</a></li>
            <?php } ?>
            <li class="divider"></li>
<li><a <?php if ($fftrackers == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Closer_Access, true) || $fftrackers == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=CloserTrackers'; } else { echo '/CRMmain.php?FEATURE=TRACKERS'; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Trackers <?php if ($fftrackers == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Closer_Access, true) || $ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=CloserDealSheets'; } else { echo '/CRMmain.php?FEATURE=DEALSHEETS'; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Closer Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
 <li class="divider"></li>
              
<li><a <?php if ($fftrackers == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/Trackers/Upsells.php?EXECUTE=DEFAULT'; } else { echo '/CRMmain.php?FEATURE=TRACKERS'; } ?>">Search Upsells <?php if ($fftrackers == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($fftrackers == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/Trackers/Closers.php?EXECUTE=1'; } else { echo '/CRMmain.php?FEATURE=TRACKERS'; } ?>">Search Trackers <?php if ($fftrackers == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=AllCloserDealSheets'; } else { echo '/CRMmain.php?FEATURE=DEALSHEETS'; } ?>">Search Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
 <li class="divider"></li>
 
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/Reports/Pad.php'; } else { echo '/CRMmain.php?FEATURE=DEALSHEETS'; } ?>">PAD <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
           <li class="divider"></li>
           
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $QA_Access) || $ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/LifeDealSheet.php?query=QADealSheets'; } else { echo '/CRMmain.php?FEATURE=DEALSHEETS'; } ?>">Dealsheets for QA <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $QA_Access) || $ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/LifeDealSheet.php?query=CompletedDeals'; } else { echo '/CRMmain.php?FEATURE=DEALSHEETS'; } ?>">Completed Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>

      </ul>
      <?php

                }
      
      if($ffkeyfactsemail=='1' && in_array($hello_name, $Closer_Access, true)) { ?>
             <li><a href="/email/KeyFactsEmail.php" target="_blank">Send Keyfacts</a></li>      
                
      <?php }

    ?>

                    <li class='dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Admin <b class='caret'></b></a>
                        <ul role='menu' class='dropdown-menu'>
                            <li><a href="https://www20.landg.com/PolicyEnquiriesIFACentre/ENTRY_POINT_RESOURCE?domain=adviser" target="_blank">LG Policy Summary Search</a></li>
                            <?php if(in_array($hello_name, $Level_10_Access, true)) { 
                            if ($fffinancials == '1') {  ?>
                            <li><a href="/Life/Financials/Menu.php">Financials</a></li> 
                            <?php }
                            if ($ffews == '1') { ?>
                                <li><a href="/Life/Reports/EWS.php">EWS</a></li> 
                            <?php } 
                            if ($ffemployee == '1') { ?>    
                                <li><a href="/Staff/Main_Menu.php">Staff Database</a></li> 
                            <?php } 
                            if ($ffemployee == '1') { ?>    
                                <li><a  href="/Staff/Holidays/Calendar.php">Holidays</a></li> 
                                <li><a  href="/Staff/Reports/RAG.php">Register</a></li> 
                                <li><a  href="/Staff/Assets/Assets.php">Asset Management</a></li> 
                            <?php } ?>
                                 <li class="divider"></li> 
                                 <li><a href='/admin/Admindash.php?admindash=y'>Control Panel</a></li>
                            <?php } ?>
                        </ul>  
                    </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
            
            <div class="timelock"></div>           
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: '/AJAX/time.php?EXECUTE=1',
                type: 'POST',
                success: function (results) {
                    jQuery(".timelock").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 3000);
    </script>
<?php if(in_array($hello_name, $Level_1_Access, true)) { ?>
                <div class="LIVERESULTS">

                </div>
<?php } ?>
        </div>
    </nav>

<?php if(in_array($hello_name, $Level_1_Access, true)) { ?>
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: '/php/NavbarLiveResults.php',
                type: 'POST',
                success: function (results) {
                    jQuery(".LIVERESULTS").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 3000);
    </script>
<?php }  } ?>