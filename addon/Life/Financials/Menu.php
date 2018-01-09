<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if($fffinancials=='0') {
    header('Location: /../../../../CRMmain.php?FEATURE=FINANCIALS');
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Financial Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>
    
    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    
                    <li>
                        <a href="Financials.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Legal and General<br/>Financials</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>                    

                    <li>
                        <a href="OneFamily.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">One Family<br/>Financials</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="Aviva.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Aviva<br/>Financials</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="RoyalLondon.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Royal London<br/>Financials</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="Vitality.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Vitality<br/>Financials</h2>
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
