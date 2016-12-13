<?php 
require($_SERVER['DOCUMENT_ROOT']."/classes/access_user/db_config.php"); 

include('includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('includes/adlfunctions.php');
$action= filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL CRM | Logout</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<link href="img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php 
    include('includes/navbar.php');
     
    if($ffanalytics=='1') {
        include('php/analyticstracking.php');
        
    }
    
?> 
    
<div class="container">
    
    <?php 
    if(isset($action)) {
        if($action=='log_out') { 
            echo "<div class=\"notice notice-success\" role=\"alert\"><strong><center><i class=\"fa fa-exclamation-triangle fa-lg\"></i> You are now logged out.</center></strong></div><br> ";   
            
        }
        
        }
        ?>
    <div class="col-xs-12 .col-md-8">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">
                    
                    
                    <li>
			<a href="index.php">
			<span class="ca-icon"><i class="fa fa-sign-in"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Login<br/> </h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                  
                      

                        
		</ul>
	</div>
</div>
    </div>



</div>
    
    <div class="footer navbar-fixed-bottom"><center><?php adl_version();?> <?php 

    $time_start = microtime(true);
    sleep(1);
    $time_end = microtime(true);
    $time = $time_end - $time_start;

echo "<i>Page execution {$time}.</i>"; ?>
        </center></div>
    
<script type="text/javascript" language="javascript" src="js/jquery/jquery-3.0.0.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
