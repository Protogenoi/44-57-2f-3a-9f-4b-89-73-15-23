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

    header('Location: /../../Life/Financial_Menu.php');
    die;
}

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);
$companynamere = $companydetailsq['company_name'];
?>
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
          <a class="nav-link" href="/app/SearchClients.php"><i class="fa fa-user-plus">  Add Client</i></a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="/Staff/Search.php"><i class="fa fa-user-plus">  Employee's</i></a>
      </li>
      <?php if($ffaudits=='1') { ?>      
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="/addon/audits/main_menu.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Audits
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="/addon/audits/lead_gen_reports.php?step=New">Legal and General Lead Audits</a>
              <a class="dropdown-item" href="/addon/audits/CloserAudit.php">Legal and General Audits</a>
              <a class="dropdown-item" href="/addon/audits/RoyalLondon/Menu.php">Royal London Audits</a>
              <a class="dropdown-item" href="/addon/audits/Aviva/Menu.php">Aviva Audits</a>
              <a class="dropdown-item" href="/addon/audits/WOL/Menu.php">One Family Audits</a>
          </div>
      </li>
      
      <?php } ?>
            <li class="nav-item">
        <a class="nav-link" href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
  </div>
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
                url: '/app/NavbarLiveResults.php',
                type: 'POST',
                success: function (results) {
                    jQuery(".LIVERESULTS").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 1000);
    </script>
<?php } ?>