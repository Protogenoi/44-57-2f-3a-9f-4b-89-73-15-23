<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

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

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /index.php?AccessDenied');
    die;
}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Compliance Menu</title>
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
        <div class="col-xs-12 .col-md-8">
            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">
                        <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                            <li>
                                <a href="/AddClient.php">
                                    <span class="ca-icon"><i class="fa fa-user-plus"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Add New<br/> Client</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="/SearchClients.php">
                                <span class="ca-icon"><i class="fa fa-search"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Search<br/>Clients/Policies</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>

                        <?php if (in_array($hello_name, $Level_8_Access, true)) { 
                            if($fffinancials=='1' || $ffews=='1') { ?> 

                            <li>
                                <a href="Reports_Menu.php">
                                    <span class="ca-icon"><i class="fa fa-bar-chart"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Reports<br/></h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                        <?php
                        } }

                        if (in_array($hello_name, $Level_3_Access, true)) {
                            ?>
                            <li>
                                <a href="<?php
                                if ($fflife == '1') {
                                    echo "Reports/AllTasks.php";
                                } else {
                                    echo "#";
                                }
                                ?>">
                                    <span class="ca-icon"><i class="fa fa-tasks"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Tasks<br/></h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
    <?php if ($ffcalendar == '1' && $ffcallbacks == '1') { ?>

                                <li>
                                    <a href="/calendar/calendar.php">
                                        <span class="ca-icon"><i class="fa  fa-calendar-check-o"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Call backs<br/></h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                                <?php
                            }

                            if ($ffdealsheets == '1') {
                                ?>
                                <li>
                                    <a href="LifeDealSheet.php">
                                        <span class="ca-icon"><i class="fa fa-file-text-o"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Dealsheets<br/> </h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
    <?php } ?>
                            <li>
                                <a href="/Emails.php">
                                    <span class="ca-icon"><i class="fa fa-envelope"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Emails<br/></h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

<?php } ?>

                    </ul>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
