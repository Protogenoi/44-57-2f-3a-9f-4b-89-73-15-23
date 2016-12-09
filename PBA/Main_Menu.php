<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

    $Level_2_Access = array("Jade");

if (in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: /Life/Financial_Menu.php'); die;

}

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out(); 
}
include('../includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>PBA Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
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
    
    if($ffpba=='0') {
        
        header('Location: /CRMmain.php'); die;
        
    }
    
?> 
    
<div class="container">

    <div class="col-xs-12 .col-md-8">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">	
      
                    <?php if($ffpba=='1') { ?>
                    
			<li>
			<a href="AddNewClient.php">
			<span class="ca-icon"><i class="fa fa-user-plus"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Add New<br/> Client</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

			<li>
			<a href="SearchClients.php?client=PBA">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/>Clients</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                        <?php }  ?>

                        
		</ul>
	</div>
</div>
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>   
</body>
</html>
