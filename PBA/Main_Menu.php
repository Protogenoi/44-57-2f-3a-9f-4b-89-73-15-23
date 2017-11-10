<?php 
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');
require_once(__DIR__ . '../../includes/adlfunctions.php');

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
