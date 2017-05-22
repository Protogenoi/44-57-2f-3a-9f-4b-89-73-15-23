<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');


if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_8_Access, true)) {

    header('Location: /../../CRMmain.php');
    die;
}

if ($ffsms == '0') {
    header('Location: /../../CRMmain.php?FEATURE=SMS');
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
    <title>ADL | SMS Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

    <div class="container">
        
 <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    
                    <li>
                        <a href="Report.php">
                                    <span class="ca-icon"><i class="fa fa-info"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">SMS<br/> Traffic Responses</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                        
                                    <li>
                                        <a href="Bulk.php">
                                            <span class="ca-icon"><i class="fa fa-send-o"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Send<br/>Bulk SMS</h2>
                                                <h3 class="ca-sub"></h3>
                                            </div>
                                        </a>
                                    </li>
              
                </ul>
            </div>
        </div>        
        
        
    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

</body>
</html>
