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

require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/includes/user_tracking.php');

require_once(__DIR__ . '/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

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

        require_once(__DIR__ . '/classes/database_class.php');
        require_once(__DIR__ . '/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 8) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
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
                        if ($ACCESS_LEVEL >= 8) {
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

                        if ($ACCESS_LEVEL == 10) {
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

?>

                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
