<?php 
include('../includes/adlfunctions.php'); 

if ($fflife=='0') {
        
        header('Location: ../CRMmain.php?AccessDenied'); die;
    }

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

$Level_2_Access = array("Michael", "Matt", "leighton", "Jade");

if($companynamere=='The Review Bureau') {
if (!in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: ../CRMmain.php?AccessDenied'); die;
}
}

?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Financial Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
<?php     if ($hello_name!='Jade') {
    include('../includes/navbar.php');
    }

if($companynamere=='The Review Bureau') {

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;
}
}

    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    
?>
    
    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
			
                    
                    <li>
                        <a href="Reports/Financial_Reports.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Report</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="Reports/FinancialUpload.php">
                            <span class="ca-icon"><i class="fa fa-upload"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Uploads</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>

                    


                    
                </ul>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
