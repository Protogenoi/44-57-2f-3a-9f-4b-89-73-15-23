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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($action) && $action == "log_out") {
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
                                $Manager_Access = array ("Richard","Keith");
                                $QA_Access = array ("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys","Jakob","Nicola","Tina","Amy");
}

if ($companynamere == 'ADL_CUS') {
    $Level_10_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_9_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_8_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_3_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_1_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $SECRET = array("Michael");
    $Task_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
}

if ($companynamere == 'Assura') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael", "Tina", "Charles");
    $Level_3_Access = array("Michael", "Tina", "Charles");
    $Level_1_Access = array("Michael", "Tina", "Charles");
}

if ($companynamere == 'HWIFS') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael");
    $Level_1_Access = array("Michael");
}
?>
<style>.dropdown-menu li:hover .sub-menu {
    visibility: visible;
}

.dropdown:hover .dropdown-menu {
    display: block;
}</style>
<div class="bs-example">
    <nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/index.php" class="navbar-brand"> <?php if (isset($companynamere)) {
    if ($companynamere == 'ADL_CUS') {
        echo "ADL";
    } else {
        echo "$companynamere";
    }
} ?></a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                <li class="active"><a href="/CRMmain.php"><i class="fa fa-home">  Home</i></a></li>
                <li><a href="/AddClient.php"><i class="fa fa-user-plus">  Add</i></a></li>
                <li><a href="/SearchClients.php"><i class="fa fa-search">  Search</i></a></li>
                <li><a href="/Life/QuickSearch.php"><i class="fa fa-flash">  Quick Search</i></a></li>


                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CRM <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/CRMmain.php">Main Menu</a></li>
                        <li><a href="/AddClient.php">Add Client</a></li>
                        <li><a href="/SearchClients.php">Search Clients</a></li>
                        <li><a href="/SearchPolicies.php?query=Life">Search Policies</a></li>
                        <li><a href="/CRMReports.php">Reports</a></li>

<?php if ($ffdialler == '1') { ?>

                            <li><a href="/dialer/Recordings.php">Recordings</a></li>

<?php } ?>

                        <li><a href="/Emails.php">Emails</a></li>

<?php if (in_array($hello_name, $Level_8_Access, true)) { ?>

                            <li><a href="<?php if ($fflife == '1') {
        echo "Life/Reports/AllTasks.php";
    } elseif ($ffpensions == '1') {
        echo "/Pensions/Reports/PensionStages.php";
    } else {
        echo "#";
    } ?>">Tasks</a></li>

                        <?php }

                        if($ffsms=='1') { ?>
                            <li><a href="/Life/SMS/Report.php">SMS Report</a></li>
                          <?php  }
                        
                        if ($ffcalendar == '1') {
                            ?>

                            <li><a href="/calendar/calendar.php">Calendar</a></li>

                <?php }

                if ($hello_name == 'Michael') {
                    ?>
                            <li><a href="/email/emailinbox.php">Email Inbox</a></li>

<?php } ?>
                    </ul>
                </li>

<?php if ($ffaudits == '1') { ?>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Audits <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/audits/main_menu.php">Main Menu</a></li>
                            <li><a href="/audits/lead_gen_reports.php?step=New">Lead Audits</a></li>
                            <li><a href="/audits/auditor_menu.php">Closer Audits</a></li>
                            <li><a href="/audits/RoyalLondon/Menu.php">Royal London Audits</a></li>
                            <li><a href="/audits/WOL/Menu.php">WOL Audits</a></li>
                            <li><a href="/audits/reports_main.php">Reports</a></li>
                    <?php if ($ffdialler == '1') { ?>

                                <li><a href="/dialer/Recordings.php">Recordings</a></li>

    <?php } ?>

                            <li><a href="/Emails.php">Emails</a></li>
                        </ul>
                    </li>

                <?php } }

      if($ffdealsheets=='1') { 
          if(in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager_Access, true)  || in_array($hello_name, $Level_9_Access, true)) { ?>
            <li class="dropdown">
        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
          E-Stats
        <b class='caret'></b></a>
        <ul role='menu' class='dropdown-menu'>
            <?php if(in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager_Access, true)) { ?> 
            <li><button class="list-group-item" onclick="CALLMANANGER();"><i class="fa fa-bullhorn fa-fw"></i>&nbsp; Call Manager/Cancel Call</button></li>
            <li><a href="/Life/LifeDealSheet.php"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets</a></li>
            <li><a href="/Life/LifeDealSheet.php?query=ListCallbacks"><?php if(isset($hello_name)) { echo $hello_name; } ?> Dealsheets Callbacks</a></li>
            <?php } 
            if(in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager_Access, true)) { ?>
<li><a href="/Life/LifeDealSheet.php?query=CloserTrackers"><?php if(isset($hello_name)) { echo $hello_name; } ?> Trackers</a></li>
<li><a href="/Life/LifeDealSheet.php?query=CloserDealSheets"><?php if(isset($hello_name)) { echo $hello_name; } ?> Closer Dealsheets</a></li>
<li><a href="/email/KeyFactsEmail.php" target="_blank">Send Keyfacts</a></li>
<?php } ?>
<?php if(in_array($hello_name, $Manager_Access, true) || in_array($hello_name, $Level_9_Access, true)) { ?>
<li><a href="/Life/Trackers.php?EXECUTE=DEFAULT">Search Upsells</a></li>
<li><a href="/Life/Trackers/Closers.php?EXECUTE=1">Search Trackers</a></li>
<li><a href="/Life/LifeDealSheet.php?query=AllCloserDealSheets">Search Dealsheets</a></li>
<?php } ?>
          <?php if (in_array($hello_name, $Level_9_Access, true)) {  ?>
          <li><a href="/Life/Reports/Pad.php">PAD</a></li>
          <?php } if (in_array($hello_name, $QA_Access) || in_array($hello_name, $Level_9_Access, true)) {  ?>
          <li><a href="/Life/LifeDealSheet.php?query=QADealSheets">Dealsheets for QA</a></li>
          <li><a href="Life/LifeDealSheet.php?query=CompletedDeals">Completed Dealsheets</a></li>
          <?php } ?>

      </ul>
             
      <?php
  
      } }
      
      if($ffdealsheets=='1' && in_array($hello_name, $Closer_Access, true)) { ?>
             <li><a href="/email/KeyFactsEmail.php" target="_blank">Send Keyfacts</a></li>      
                
      <?php }

if (in_array($hello_name, $Level_9_Access, true)) {
    ?>

                    <li class='dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Admin <b class='caret'></b></a>
                        <ul role='menu' class='dropdown-menu'>
                    <?php if ($ffemployee == '1') { ?>
                                <li><a href="/Staff/Main_Menu.php">Staff Database</a></li> 
                                <li><a href="/Staff/Search.php">Search Database</a></li> 
                                <li><a href="/Staff/Holidays/Calendar.php">Holidays</a></li> 
                                <li><a href="/Staff/Reports/RAG.php">RAG</a></li> 
    <?php } ?>
                            <li><a href='/admin/Admindash.php?admindash=y'>Control Panel</a></li>
                            <?php if ($hello_name == 'Michael') { ?>
                            <li><a href='/admin/users.php'>User Accounts</a></li>
                            <?php } ?>
                        </ul>  
                    </li>

            <?php } ?>
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
<?php } }?>