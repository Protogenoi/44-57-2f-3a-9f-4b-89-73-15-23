<?php
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
    $Level_3_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Mike", "Keith", "Renee", "Victoria", "Christian", "Audits", "Tiaba");
    $Level_1_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Mike", "Keith", "Renee", "Victoria", "Christian", "Audits", "Tiaba");
    $SECRET = array("Michael", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Amy', "Victoria", "Christian");
    $Task_Access = array("Michael", "Abbiek", "Victoria", "Keith");
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
<nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-primary">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">ADL CRM</a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#"><i class="fa fa-home">  Home</i> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-user-plus">  Add</i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-search">  Search</i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-flash">  Quick Search</i></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          CRM
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/AddClient.php">Add Client</a>
          <a class="dropdown-item" href="/SearchClients.php">Search Clients</a>
          <a class="dropdown-item" href="/SearchPolicies.php?query=Life">Search Policies</a>
          <?php if ($fflife == '1') { 
          if (in_array($hello_name, $Level_8_Access, true)) { ?>
              ?>
          <a class="dropdown-item" href="/CRMReports.php">Reports</a>
          <?php } } 
          if ($ffdialler == '1') { ?>
          <a class="dropdown-item" href="/dialer/Recordings.php">Recordings</a>
          <?php } ?>
          <a class="dropdown-item" href="/Emails.php">Emails</a>
          <?php if($ffsms=='1') { ?>
          <a class="dropdown-item"href="/Life/SMS/Report.php">SMS Report</a>
          <?php  } 
          if ($ffcalendar == '1') {
          ?>          
          <a class="dropdown-item" href="/calendar/calendar.php">Calendar</a>
          <?php }
          if ($hello_name == 'Michael') {
          ?>
          <a class="dropdown-item" href="/email/emailinbox.php">Email Inbox</a>
          <?php } ?>
        </div>
      </li>
      <?php if($ffaudits=='1') { ?>
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Audits
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/audits/main_menu.php">Main Menu</a>
          <a class="dropdown-item" href="/audits/lead_gen_reports.php?step=New">Lead Audits</a>
          <a class="dropdown-item" href="/audits/auditor_menu.php">Closer Audits</a>
          <a class="dropdown-item" href="/audits/RoyalLondon/Menu.php">Royal London Audits</a>
          <a class="dropdown-item" href="/audits/WOL/Menu.php">WOL Audits</a>
          <a class="dropdown-item" href="/audits/reports_main.php">Reports</a>   
        </div>
      </li>
      <?php } 
      if (in_array($hello_name, $Level_9_Access, true)) {
      ?>
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php if ($ffemployee == '1') { ?>
          <a class="dropdown-item" href="/Staff/Main_Menu.php">Staff Database</a>
          <a class="dropdown-item" href="/Staff/Search.php">Search Database</a>
          <a class="dropdown-item" href="/Staff/Holidays/Calendar.php">Holidays</a>
          <a class="dropdown-item" href="/Staff/Reports/RAG.php">RAG</a>
            <?php } 
            if (in_array($hello_name, $Level_10_Access, true)) {
            ?>
          <a class="dropdown-item" href="/admin/Admindash.php?admindash=y">Control Panel</a>
            <?php } 
            if($hello_name=="Michael") {
            ?>
          <a class="dropdown-item" href="/admin/users.php">User Accounts</a>            
            <?php } ?>
        </div>
      </li>
      <?php } ?>
            <li class="nav-item">
        <a class="nav-link" href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>