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

if ($companynamere == 'The Review Bureau') {
    $Level_10_Access = array("Michael", "Matt", "leighton","Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton","Nick","carys");
    $Level_8_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Tina", "Heidy", "Nicola", "Mike");
    $Level_3_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Mike", "Victoria", "Christian", "Audits","Keith","Rhiannon","Ryan");
    $Level_1_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Mike", "Victoria", "Christian", "Audits","Keith","Rhiannon","Ryan");
    $SECRET = array("Michael", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Amy', "Victoria", "Christian");
    $Task_Access = array("Michael", "Abbiek", "Victoria");
    
                                $Agent_Access = array ("111111111");
                                $Closer_Access = array ("James","Hayley","David","Mike","Kyle","Sarah","Richard","Mike","Gavin");
                                $Manager_Access = array("Richard", "Keith","Michael", "Matt", "leighton", "Nick", "carys");
                                $QA_Access = array ("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys","Jakob","Nicola","Tina","Amy");
}

if ($companynamere == 'ADL_CUS') {
    $Level_10_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_9_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_8_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_3_Access = array("Michael", "Dean", "Helen", "Andrew", "David","James");
    $Level_1_Access = array("Michael", "Dean", "Helen", "Andrew", "David","James");
    $SECRET = array("Michael");
    $Task_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
}

if ($companynamere == 'Assura') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael", "Tina", "Charles");
    $Level_3_Access = array("Michael", "Tina", "Charles");
    $Level_1_Access = array("Michael", "Tina", "Charles");
}
?>
<style>
    .dropdown-menu li:hover .sub-menu {
    visibility: visible;
    }
    .dropdown:hover .dropdown-menu {
    display: block;
    }
</style>

<div class="bs-example">
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
                <li><a href="/AddClient.php"><i class="fa fa-user-plus">  Add</i></a></li>
                <li><a href="/SearchClients.php"><i class="fa fa-search">  Search</i></a></li>
                <li><a href="/Life/QuickSearch.php"><i class="fa fa-flash">  Quick Search</i></a></li>


                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CRM <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="<?php if(in_array($hello_name, $Level_3_Access, true)) { echo "/AddClient.php"; } else { echo "#"; } ?>">Add Client</a></li>
                        <li><a href="/<?php if(in_array($hello_name, $Level_3_Access, true)) { echo "SearchClients.php"; } else { echo "#"; } ?>">Search Clients</a></li>
                        <li><a href="<?php if(in_array($hello_name, $Level_3_Access, true)) { echo "/SearchPolicies.php?query=Life"; } else { echo "#"; } ?>">Search Policies</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php if(in_array($hello_name, $Level_6_Access, true)) { echo "/CRMReports.php"; } else { echo "#"; } ?>">Reports</a></li>                        
                        <li><a href="<?php if ($fflife == '1' && in_array($hello_name, $Level_8_Access, true)) { echo "Life/Reports/AllTasks.php"; } else { echo "#"; } ?>">Tasks</a></li>
                        <li><a <?php if ($ffsms == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffsms == '1' && in_array($hello_name, $Level_6_Access, true)) { echo '/Life/SMS/Report.php'; } else { echo '#'; } ?>">SMS Report <?php if ($ffsms == '0') { echo '(not enabled)'; }?></a></li>
                        <li><a <?php if ($ffcalendar == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffcalendar == '1' && in_array($hello_name, $Level_3_Access, true)) { echo '/calendar/calendar.php'; } else { echo '#'; } ?>">Callbacks <?php if ($ffcalendar == '0') { echo '(not enabled)'; } ?></a></li>
                        <li class="divider"></li>
                            
                            <li><a href="<?php if(in_array($hello_name, $Level_3_Access, true)) { echo "/Emails.php"; } else { echo "#"; } ?>">Emails</a></li>
                            <li><a <?php if ($ffkeyfactsemail == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffkeyfactsemail == '1' && in_array($hello_name, $Level_3_Access, true)) {  echo '/Life/Reports/Keyfacts.php'; } else { echo '#'; } ?>">KeyFact Email Report <?php if ($ffkeyfactsemail == '0') { echo '(not enabled)'; } ?></a></li>
                            <li><a href="<?php if ($hello_name == 'Michael') { echo '/email/emailinbox.php'; } else { echo '#'; } ?>"><?php if ($hello_name == 'Michael') { echo 'Email Inbox'; } else { echo 'Email Inbox (not enabled)'; } ?></a></li>
                    </ul>
                </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Audits <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/audits/main_menu.php">Main Menu</a></li>
                            <li class="divider"></li>
                            <li><a <?php if ($ffaudits == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffaudits == '1' && in_array($hello_name, $Level_3_Access, true)) { echo '/audits/lead_gen_reports.php?step=New'; } else { echo '#'; } ?>">Lead Audits <?php if ($ffaudits == '0') { echo "(not enabled)"; } ?></a></li>
                            <li><a <?php if ($ffaudits == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffaudits == '1' && in_array($hello_name, $Level_3_Access, true)) {  echo '/audits/auditor_menu.php'; } else { echo '#'; } ?>">Legal and General Audits <?php if ($ffaudits == '0') { echo "(not enabled)"; } ?></a></li>
                            <li><a <?php if ($ffaudits == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffaudits == '1' && in_array($hello_name, $Level_3_Access, true)) {  echo '/audits/RoyalLondon/Menu.php'; } else { echo '#'; } ?>">Royal London Audits <?php if ($ffaudits == '0') { echo "(not enabled)"; } ?></a></li>
                            <li><a <?php if ($ffaudits == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffaudits == '1' && in_array($hello_name, $Level_3_Access, true)) {  echo '/audits/WOL/Menu.php'; } else { echo '#'; } ?>">One Family Audits <?php if ($ffaudits == '0') { echo "(not enabled)"; } ?></a></li>
                            <li class="divider"></li>
                            <li><a <?php if ($ffaudits == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffaudits == '1' && in_array($hello_name, $Level_3_Access, true)) {  echo '/audits/reports_main.php'; } else { echo '#'; } ?>">Reports <?php if ($ffaudits == '0') { echo "(not enabled)"; } ?></a></li>
                        </ul>
                    </li>

            <li class="dropdown">
        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
          Dialler
        <b class='caret'></b></a>
        <ul role='menu' class='dropdown-menu'>
            
            <li><a <?php if ($ffdialler == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdialler == '1') { echo '/dialer/Recordings.php'; } else  { echo '#'; } ?>">Recordings <?php if ($ffdialler == '0') {  echo '(not enabled)'; } ?></a></li>

            <li><button class="list-group-item" onclick="CALLMANANGER();"><i class="fa fa-bullhorn fa-fw"></i>&nbsp; Call Manager/Cancel Call</button></li>
            <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1') { echo "/Life/LifeDealSheet.php"; } else { "#"; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
            <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1') { echo "/Life/LifeDealSheet.php?query=ListCallbacks"; } else { "#"; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets Callbacks <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
             <li class="divider"></li>
            
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Closer_Access, true) || $ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=CloserTrackers'; } else { echo '#'; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Trackers <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Closer_Access, true) || $ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=CloserDealSheets'; } else { echo '#'; } ?>"><?php if(isset($hello_name)) { echo $hello_name; } ?> Closer Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
 <li class="divider"></li>
 
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/dialer/Agents.php'; } else { echo '#'; } ?>">Add Agent/Closer <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>                   
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/Trackers.php?EXECUTE=DEFAULT'; } else { echo '#'; } ?>">Search Upsells <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/Trackers/Closers.php?EXECUTE=1'; } else { echo '#'; } ?>">Search Trackers <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
<li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Manager_Access, true)) { echo '/Life/LifeDealSheet.php?query=AllCloserDealSheets'; } else { echo '#'; } ?>">Search Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
 <li class="divider"></li>
 
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/Reports/Pad.php'; } else { echo '#'; } ?>">PAD <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
           <li class="divider"></li>
           
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $QA_Access) || $ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/LifeDealSheet.php?query=QADealSheets'; } else { echo '#'; } ?>">Dealsheets for QA <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>
          <li><a <?php if ($ffdealsheets == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffdealsheets == '1' && in_array($hello_name, $QA_Access) || $ffdealsheets == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Life/LifeDealSheet.php?query=CompletedDeals'; } else { echo '#'; } ?>">Completed Dealsheets <?php if ($ffdealsheets == '0') { echo "(not enabled)"; } ?></a></li>

      </ul>
             
      <?php

      
      if($ffdealsheets=='1' && in_array($hello_name, $Closer_Access, true)) { ?>
             <li><a href="/email/KeyFactsEmail.php" target="_blank">Send Keyfacts</a></li>      
                
      <?php }

    ?>

                    <li class='dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Admin <b class='caret'></b></a>
                        <ul role='menu' class='dropdown-menu'>
                                <li><a <?php if ($ffemployee == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffemployee == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Staff/Main_Menu.php'; } else { echo '#'; } ?>">Staff Database <?php if ($ffemployee == '0') { echo "(not enabled)"; } ?></a></li> 
                                <li><a <?php if ($ffemployee == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffemployee == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Staff/Holidays/Calendar.php'; } else { echo '#'; } ?>">Holidays <?php if ($ffemployee == '0') { echo "(not enabled)"; } ?></a></li> 
                                <li><a <?php if ($ffemployee == '0') { echo "class='btn-warning'"; } else { } ?> href="<?php if ($ffemployee == '1' && in_array($hello_name, $Level_9_Access, true)) { echo '/Staff/Reports/RAG.php'; } else { echo '#'; } ?>">Register <?php if ($ffemployee == '0') { echo "(not enabled)"; } ?></a></li> 
                                 <li class="divider"></li>
                            
                            <?php if ($hello_name == 'Michael') { ?>
                                
                             <li><a href='/admin/Admindash.php?admindash=y'>Control Panel</a></li>
                            <li><a href='/admin/users.php'>User Accounts</a></li>
                            <?php } ?>
                        </ul>  
                    </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>

<?php if(in_array($hello_name, $Task_Access, true)  || (in_array($hello_name, $Level_3_Access, true))) { ?>
                <div class="LIVERESULTS">

                </div>
<?php } ?>
        </div>
    </nav>
</div>
<?php if(in_array($hello_name, $Task_Access, true)  || (in_array($hello_name, $Level_3_Access, true))) { ?>
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: '/php/NavbarLiveResults.php?name=<?php if(isset($hello_name)) { echo $hello_name; } ?>',
                type: 'POST',
                success: function (results) {
                    jQuery(".LIVERESULTS").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 1000);
    </script>
<?php } } ?>