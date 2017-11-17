<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
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
 * 
*/  

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php'); 

if ($fflife=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }

include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

?>
<!DOCTYPE html>
<html lang="en">
<title>Assura Reports</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
    include('../../includes/adl_features.php');
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    ?>
    
    <div class="container">
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu"> 
                    
                    <?php

                    if($companynamere=='Bluestone Protect') { 
                        if (in_array($hello_name,$Level_8_Access, true)) {
                            if($fflife=='1') {  
                        
                        ?>
                    
                    <li>
                        <a href="../../CRMReports.php">
                            <span class="ca-icon"><i class="fa fa-arrow-left"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Back<br/></h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <?php 
                    
                    if (in_array($hello_name,$Level_10_Access, true)) {
                        
                        ?>
                    
                    <li>
                        <a href="EWSMaster.php">
                            <span class="ca-icon"><i class="fa fa-archive"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Archive<br/> EWS</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <?php } ?>
                    
                    <li>
                        <a href="EWSfiles.php">
                            <span class="ca-icon"><i class="fa fa-warning"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Early Warning<br/> System</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                      <li>
                        <a href="EWSModify.php">
                            <span class="ca-icon"><i class="fa fa-edit"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Correct<br/> EWS Record</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>                    
                    
                    <li>
                        <a href="Financial_Reports.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Report</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="Export.php">
                            <span class="ca-icon"><i class="fa fa-cloud-download"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Export<br/>Data</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="FinancialUpload.php">
                            <span class="ca-icon"><i class="fa fa-cloud-upload"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Uploads</h2>
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
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
