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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

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

if ($fflife == '0') {

    header('Location: /../../../../CRMmain.php');
    die;
}

$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html>
    <title>ADL | RAW COMM Upload</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
</head>
<body>

    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">

        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#menu3">RAW COMM Upload</a>
            </li>
            </li>
        </ul>
    </div>
    <div class="tab-content">

        <div id="menu3" class="tab-pane fade in active">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <span class="glyphicon glyphicon-hdd"></span> Upload data</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    
                                      <div class="col-xs-6 col-md-6">
                                        <h3>Upload One Family Financials</h3>


                                        <form action="/addon/Life/Financials/upload/finrupload.php?EXECUTE=12" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                    
                                    
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload LV Financials</h3>


                                        <form action="/addon/Life/Financials/upload/finrupload.php?EXECUTE=11" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                      
                                    
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Vitality Financials</h3>


                                        <form action="/addon/Life/Financials/upload/vitality_upload.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                     
                                    
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Aviva Financials</h3>


                                        <form action="/addon/Life/Financials/upload/aviva_upload.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                     
                                    
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Royal London Financials</h3>


                                        <form action="/addon/Life/Financials/upload/royal_london_upload.php?EXECUTE=10" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                     
                                    
                                    
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Legal & General financials</h3>

                                        <form action="/addon/Life/Financials/upload/finrupload.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required>
                                            <input type="hidden" name="Processor" value="<?php echo $hello_name ?>">
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>

                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <center><img src="/img/loading.gif" class="icon" /></center>
                                    <h4>Uploading... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

    </div>

    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
    <script type="text/javascript" language="javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script type="text/javascript" language="javascript" src="/resources/lib/DataTable/datatables.min.js"></script>

    <script>

        $(document).ready(function () {
            if (window.location.href.split('#').length > 1)
            {
                $tab_to_nav_to = window.location.href.split('#')[1];
                if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
                {
                    $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
                }
            }
        });

    </script>
    <script>
        $(function () {
            $("#datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>
    <script>
        $(function () {
            $("#dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>  
</body>
</html>