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

require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
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
<title>ADL | 500 Internal Server Error</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php include('../includes/navbar.php'); ?>

<div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">500
                    <small>Internal Server Error</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../CRMmain.php">Home</a>
                    </li>
                    <li class="active">500</li>
                </ol>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="jumbotron">
<h1><span class="glyphicon glyphicon-fire red"></span> 500</h1>

<p>Report this immediately to Michael.


            <center>
                <p>Info Logged<br><?php echo $_SERVER['REMOTE_ADDR'] ?><br>
<?php loggedhostnameip();?> 
<br>
<?php
date_default_timezone_set("Europe/London");
echo date('m/d/y h:i a', time());
?> 
</p>
</center>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
