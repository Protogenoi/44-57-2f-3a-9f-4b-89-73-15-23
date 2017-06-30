<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

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
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php');
    
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
                            <a href="/audits/RoyalLondon/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Royal London<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>     
                        
			<li>
                            <a href="/audits/WOL/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">One Family<br/> Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>  
                        
			<li>
                            <a href="/audits/Aviva/Menu.php">
			<span class="ca-icon"><i class="fa fa-folder"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Aviva<br/> Audits</h2>
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




</body>
</html>
