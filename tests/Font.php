<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php');

$LOGOUT_ACTION = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$FEATURE = filter_input(INPUT_GET, 'FEATURE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($LOGOUT_ACTION) && $LOGOUT_ACTION == "log_out") {
	$page_protect->log_out();
}

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();

if(!in_array($hello_name, $ANYTIME_ACCESS,true)) {

if($TRACKED_IP!='81.145.167.66') {
    header('Location: /index.php?TIME=1');
}
}

        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->UpdateToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL <=0) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }  

if (in_array($hello_name, $Agent_Access, true)) {

    header('Location: /Life/Dealsheet.php');
    die;
}

if (in_array($hello_name, $Closer_Access, true)) {

    header('Location: /addon/Trackers/Tracker.php?query=CloserTrackers');
    die;
}    
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2018
-->
<html lang="en">
    <title>ADL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once(__DIR__ . '/../includes/navbar.php');
           
    ?> 
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
    </div>

    <div class="container">


        <?php
        $clientdeleted = filter_input(INPUT_GET, 'clientdeleted', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($clientdeleted)) {
            if ($clientdeleted == 'y') {

                print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Client deleted from database</strong></div><br>");
            }
            if ($clientdeleted == 'failed') {

                print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error: Client not deleted</strong></div><br>");
            }
        }
        ?>
        <div class="col-xs-12 .col-md-8">

            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">

                        <?php 
                        
                        if (isset($ACCESS_LEVEL)) {
                            if ($ACCESS_LEVEL >= 3) { ?>
                            <li>
                                <a href="/app/AddClient.php">
                                    <span class="ca-icon"><i class="fas fa-user-plus"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Add New<br/> Client</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                        <li>
                            <a href="/app/SearchClients.php">
                                <span class="ca-icon"><i class="fas fa-search"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Search<br/>All Clients</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>

                       <?php if($fflife == '1') {
                                ?>
                                <li>
                                    <a href="Life/Main_Menu.php">
                                        <span class="ca-icon"><i class="fa fa-medkit"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Life<br/> Insurance</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                                <?php
                            }
                            if($ACCESS_LEVEL == 10) {  ?>
                            <li>
                                <a href="https://164.39.13.58/ConnexReports/dashboard.php" target="_blank">
                                    <span class="ca-icon"><i class="fa fa-headphones"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Connex<br/>Call Recordings</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                            
                         
                        <?php if(isset($ffaudits) && $ffaudits == 1 ) { ?>    
                            
                                <li>
                                    <a href="/addon/audits/search_audits.php">
                                        <span class="ca-icon"><i class="fa fa-folder"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Call Audits<br/></h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>                            
                            
                        
                            <?php }  }                           
                      
                       }
                        
                            if ($ffemployee == '1') {
                                if ($ACCESS_LEVEL == 10) { 
                                ?>
                                <li>
                                    <a href="/addon/Staff/Main_Menu.php">
                                        <span class="ca-icon"><i class="fa fa-database"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Employee<br/> Database</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                            if ($ffcompliance == '1') {
                                if (in_array($hello_name, $Level_10_Access, true)) {
                            
                                ?>
                                <li>
                                    <a href="/addon/compliance/dash.php?EXECUTE=1">
                                        <span class="ca-icon"><i class="fa fa-folder-open"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Compliance</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                            }
                        ?>
                                
 <?php
 
 if ($fftrackers == '1') {
                        if (in_array($hello_name, $Manager_Access, true)) {
                            
                                ?>
                                <li>
                                    <a href="/addon/Trackers/View.php">
                                        <span class="ca-icon"><i class="fa fa-bullseye"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Trackers<br/></h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        } 
                        
                           }
                        ?>    
                                
                    </ul>
                </div>
            </div>
        </div>
    </div>

   
</body>
</html>