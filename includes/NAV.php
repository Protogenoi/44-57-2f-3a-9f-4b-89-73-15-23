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
  <a class="navbar-brand" href="#">ADL</a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
          <a class="nav-link" href="/CRMmain.php"><i class="fa fa-home">  Home</i> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="/AddClient.php"><i class="fa fa-user-plus">  Add Client</i></a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="/SearchClients.php"><i class="fa fa-search">  Search Clients</i></a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="/Staff/Search.php"><i class="fa fa-user-plus">  Employee's</i></a>
      </li>
      <?php if($ffaudits=='1') { ?>
            <li class="nav-item">
                <a class="nav-link" href="/audits/main_menu.php"><i class="fa fa-folder">  Audits</i></a>
      </li>
      <?php } ?>
            <li class="nav-item">
        <a class="nav-link" href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>