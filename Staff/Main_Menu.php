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
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

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
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Staff Database</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/cosmo/bootstrap.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link rel="stylesheet" href="/resources/templates/ADL/LargeIcons.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php require_once(__DIR__ . '/../includes/navbar.php'); ?> 
    
<div class="container">
    <div class="col-xs-12 .col-md-8">
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">

			<li>
                            <a href="Search.php">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/>Employee Database</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                        <?php 
                        if (in_array($hello_name,$Level_8_Access, true)) { ?>

			<li>
                            <a href="Holidays/Calendar.php">
			<span class="ca-icon"><i class="fa fa-plane"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Holidays<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                        <li>
                            <a href="Reports/RAG.php">
			<span class="ca-icon"><i class="fa fa-area-chart"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Manager Reports<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                                                <li>
                                                    <a href="Assets/Assets.php">
			<span class="ca-icon"><i class="fa fa-list-ul"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Inventory<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                                                <li>
                            <a href="#">
			<span class="ca-icon"><i class="fa fa-gbp"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Wages<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                         <?php  } ?>

                        
		</ul>
        
        </div>
</div>
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>