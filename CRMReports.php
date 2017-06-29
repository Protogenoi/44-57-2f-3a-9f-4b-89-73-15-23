<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_8_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href="img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/includes/navbar.php'); ?>

    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">

                    <li>
                        <a href="CRMmain.php">
                            <span class="ca-icon"><i class="fa fa-arrow-left"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Back<br/></h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>

                    <?php
                    if ($fflife == '1') {
                        if (in_array($hello_name, $Level_8_Access, true)) {
                            if($fffinancials=='1' || $ffews=='1') {
                            ?>
                            <li>
                                <a href="Life/Reports_Menu.php">
                                    <span class="ca-icon"><i class="fa fa-warning"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Bluestone Protect<br/>EWS/Financials</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="calendar/All_Callbacks.php">
                                    <span class="ca-icon"><i class="fa fa-phone"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">All Active<br/>Callbacks</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="Life/Reports/PolicyStatuses.php">
                                    <span class="ca-icon"><i class="fa fa-list-alt"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Policy<br/>Statuses</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <?php
                        }

                        if (in_array($hello_name, $Level_10_Access, true)) {
                            if ($fffinancials == '1') {
                                ?>

                                <li>
                                    <a href="/Life/Reports/FinancialUpload.php">
                                        <span class="ca-icon"><i class="fa fa-upload"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Financial<br/>Uploads</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="/Life/Financial_Menu.php">
                                        <span class="ca-icon"><i class="fa  fa-database"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Jade Financial<br/>Menu</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                            <?php } if($companynamere == 'Bluestone Protect') { ?>

                                <li>
                                    <a href="Export.php">
                                        <span class="ca-icon"><i class="fa fa-cloud-download"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Export<br/>Data</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="Upload.php">
                                        <span class="ca-icon"><i class="fa fa-cloud-upload"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Upload<br/>Data</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    }

?>

                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
