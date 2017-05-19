<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');


if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_8_Access, true)) {

    header('Location: /../../CRMmain.php');
    die;
}

if ($ffsms == '0') {
    header('Location: /../../CRMmain.php?FEATURE=SMS');
}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Bulk SMS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />

    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

    <div class="container">
        
        <form method="POST" action="EWS.php?EXECUTE=1">
            <fieldset>
                <legend>Bulk SMS EWS Clients</legend>
                
            <div class="col-md-12">
            
                <div class="col-md-4">
            <select class="form-control" name="COLOUR" required="">
                <option value="">Select EWS Colour</option>
                <option value="Black">Black</option>
            </select>
                </div>
            
                <div class="col-md-2">
            <input class="form-control" type="text" name="DATE" id="DATE" placeholder="Clawback Date" required>
                </div>
                
                <div class="col-md-4">
            <select class="form-control" name="MESSAGE" required="">
                <option value="">Select message to send</option>
                <option value="1">[CLIENT_NAME] it very important that we speak to you regarding your life insurance policy. Please contact [COMPANY_NAME] on [COMPANY_TEL].</option>
            </select>
                </div>                
            
                <div class="col-md-2">
            <button type="submit" class="btn btn-warning btn-md"><i class="fa fa-save"></i></button>
                </div>
                
            </div>
            </fieldset>
        </form>      
        
        
    </div>
    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script>
        $(function () {
            $("#DATE").datepicker({
                dateFormat: 'M-y',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>
