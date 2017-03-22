<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');


if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_8_Access, true)) {

    header('Location: ../CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Life Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">

                    <li>
                        <a href="/CRMmain.php">
                            <span class="ca-icon"><i class="fa fa-arrow-left"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Back<br/></h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>

                    <?php
                    if ($fflife == '1') {
                        if (in_array($hello_name, $Level_10_Access, true)) {
                            ?>

                            <li>
                                <a href="Financials.php">
                                    <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">New<br/> Financial Report</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                            <?php
                            if (isset($hello_name)) {
                                if ($hello_name == 'Michael') {
                                    ?>
                                    <li>
                                        <a href="/Financial_Reports.php">
                                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Financial<br/>Report</h2>
                                                <h3 class="ca-sub"></h3>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
                                }
                            }
                        }
                        if (in_array($hello_name, $Level_8_Access, true)) {
                            ?>

                            <li>
                                <a href="Reports/EWSMaster.php">
                                    <span class="ca-icon"><i class="fa fa-archive"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Archive<br/> EWS</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="Reports/EWS.php">
                                    <span class="ca-icon"><i class="fa fa-warning"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Early Warning<br/> System</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="Reports/EWSWhite.php">
                                    <span class="ca-icon"><i class="fa fa-warning"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">EWS<br/> White</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>                    

                            <li>
                                <a href="Reports/EWSModify.php">
                                    <span class="ca-icon"><i class="fa fa-edit"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Correct<br/> EWS Record</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="Reports/EWSOverview.php">
                                    <span class="ca-icon"><i class="fa fa-pie-chart"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">EWS<br/>Overview</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="Reports/EWSAgentPerformance.php">
                                    <span class="ca-icon"><i class="fa fa-line-chart"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">EWS<br/>Agent Performance</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                        <?php
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
