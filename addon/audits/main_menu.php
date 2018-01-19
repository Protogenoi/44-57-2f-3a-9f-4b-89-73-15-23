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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if ($ffaudits=='0') {
        
        header('Location: /../../../CRMmain.php'); die;
    }

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
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
<title>ADL | Audits</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php require_once(__DIR__ . '/../../includes/navbar.php');
    
    ?> 


  <div class="container">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">
			<li>
			<a href="lead_gen_reports.php">
                            <span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Lead Gen<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

			<li>
			<a href="auditor_menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Legal and General<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

			<li>
                            <a href="/addon/audits/RoyalLondon/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Royal London<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>     
                        
			<li>
                            <a href="/addon/audits/WOL/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">One Family<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>  
                        
			<li>
                            <a href="/addon/audits/Aviva/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Aviva<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>                        

<li>
                            <a href="/addon/audits/Vitality/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Vitality<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>                        
                        
			<li>
			<a href="reports_main.php">
			<span class="ca-icon"><i class="fa fa-bar-chart"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Call Audit<br/> Reports </h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>



		</ul>
	</div>
</div>
    </div>


    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

</body>
</html>
