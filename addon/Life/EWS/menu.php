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

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');
require_once(BASE_URL.'/includes/ADL_PDO_CON.php');

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

if($ffews=='0') {
    header('Location: /../../../../CRMmain.php?FEATURE=EWS');
}

        $ADL_PAGE_TITLE = "EWS Menu";
        require_once(BASE_URL.'/app/core/head.php'); 
        
        ?>  
</head>
<body>

    <?php require_once(BASE_URL.'/includes/navbar.php'); ?>
    
    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    
                    <li>
                        <a href="/addon/Life/EWS/adl_ews.php">
                            <span class="ca-icon"><i class="fas fa-exclamation-triangle"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Early<br/>Warning System</h2>
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