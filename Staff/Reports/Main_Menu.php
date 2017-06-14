<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

 include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /index.php?AccessDenied'); die;

}

include('../includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Main Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    
<div class="container">
    <div class="col-xs-12 .col-md-8">
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    <?php if (in_array($hello_name,$Level_3_Access, true)) { ?>
                    <li>
			<a href="/AddClient.php">
			<span class="ca-icon"><i class="fa fa-user-plus"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Add New<br/> Employee</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                    <?php } ?>
			<li>
                            <a href="/SearchClients.php">
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
                            <a href="Reports_Menu.php">
			<span class="ca-icon"><i class="fa fa-plane"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Holidays<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                        <li>
                            <a href="Reports_Menu.php">
			<span class="ca-icon"><i class="fa fa-area-chart"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">RAG Report<br/></h2>
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
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
