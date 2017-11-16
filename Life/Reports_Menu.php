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

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
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

        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 6) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

if($fffinancials=='0' || $ffews=='0') {
    header('Location: ../CRMmain.php?FEATURE=FINANCIALS');
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
    <title>ADL | Life Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
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
                        if (isset($hello_name)) {
                        if (in_array($hello_name, $Level_10_Access, true)) {
                            if($fffinancials=='1') {
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
                            
                                    ?>
                                    <li>
                                        <a href="/Financial_Reports.php">
                                            <span class="ca-icon"><i class="fa fa-upload"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Upload<br/>RAW COMMS</h2>
                                                <h3 class="ca-sub"></h3>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
                             
                        } }
                        }
                        if (in_array($hello_name, $Level_8_Access, true)) {
                            if($ffews=='1') {
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
                        } }
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
