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
          <a class="nav-link" href="/SearchClients.php"><i class="fa fa-user-plus">  Add Complaint</i></a>
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

        t = setInterval(refresh_div, 1000);
    </script>
<?php } ?>