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

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

require_once(BASE_URL.'/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(BASE_URL.'/includes/user_tracking.php');

require_once(BASE_URL.'/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(BASE_URL.'/classes/database_class.php');
        require_once(BASE_URL.'/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 8) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        $ADL_PAGE_TITLE = "Reports";
        require_once(BASE_URL.'/app/core/head.php'); 
        
        ?>
</head>
<body>

    <?php require_once(BASE_URL.'/includes/navbar.php'); ?>

    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">                   

                    <?php
                    if ($fflife == '1') {
                        if ($ACCESS_LEVEL >= 10) {
                            if($fffinancials=='1') { ?>
                            
                            <li>
                                <a href="/addon/Life/Financials/Financial.php">
                                    <span class="ca-icon"><i class="fa fa-pound-sign"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">All Financial<br/> Reports</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>                                  
                                
                        <?php   
                        
                        
                            }
                            }
                            
                            
                        if ($ACCESS_LEVEL >= 8) {
                            if($ffews=='1') {
                                
                            ?>
                            
                            <li>
                                <a href="/addon/Life/EWS/adl_ews.php">
                                    <span class="ca-icon"><i class="fa fa-exclamation"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Early Warning<br/> System</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                        <?php
                        } if ($ffcalendar == 1 ) {
                            ?>
                            <li>
                                <a href="/app/calendar/All_Callbacks.php">
                                    <span class="ca-icon"><i class="fa fa-phone"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">All Active<br/>Callbacks</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                            <li>
                                <a href="/addon/Life/Reports/policy_statuses.php">
                                    <span class="ca-icon"><i class="fa fa-list-alt"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Policy<br/>Statuses</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                            <?php
                        }

                        if ($ACCESS_LEVEL == 10) {
                                ?>

                                <li>
                                    <a href="/app/admin/Export.php">
                                        <span class="ca-icon"><i class="fas fa-cloud-download-alt"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Export<br/>Data</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                
                                <?php
                        }
                    }

?>

                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>