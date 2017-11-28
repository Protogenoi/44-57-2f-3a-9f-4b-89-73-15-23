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

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

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
    <title>ADL | Legacy Stats</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.oesmith.co.uk/morris-0.5.1.css">
    <style>.ui-datepicker { 
            z-index:1151 !important;
        }</style>
</head>
<body>
    
    <?php
    include('../includes/navbar.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/analyticstracking.php'); 
    
    }
    
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    ?>
    
    
    
    <div class="container">
        
          <?php
          
           $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($taskassigned)){
    
      $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);
      $assignto= filter_input(INPUT_GET, 'assignto', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($taskassigned =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Task assigned to $assignto!</div><br>");
    }

            if ($taskassigned =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      
          
  ?>         
        <div class="btn-group">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#setdates"><i class="fa fa-calendar-check-o"></i> Set Dates</button>
            <a href="../export/ExportData.php?ExportLegacy=1<?php if(isset($dateto)) { echo "&dateto=$dateto";}?><?php if(isset($datefrom)) { echo "&datefrom=$datefrom";}?>" class="btn btn-default"><i class="fa fa-check-circle-o"></i> Export</a>
                        <a href="../export/ExportData.php?ExportLegacy=2" class="btn btn-default"><i class="fa fa-check-circle-o"></i> Export</a>

        </div>
        
        <div  class="text-center">
            <label class="label label-success">Legacy EWS Stats</label>
            <div id="bar-chart" ></div>
        </div>
        
    </div>
    
    <div id="setdates" class="modal fade" role="dialog">
        <div class="modal-dialog">
            
            
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Set Dates</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="GET">
                        <fieldset>
                            
                            
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="datefrom" name="datefrom" class="form-control" placeholder="Date From" type="text">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="dateto" name="dateto" class="form-control" placeholder="Date To" type="text">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-4">
                                    <button id="singlebutton" name="Submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>
    <script>
    
        var json = (function () {
            var json = null;
            $.ajax({
                'async': false,
                'global': false,
                'url': 'JSON/ChartData.php?Legacy=1<?php if(isset($datefrom)) { echo "&datefrom=$datefrom";}?><?php if(isset($dateto)) { echo "&dateto=$dateto";}?>',
                'dataType': "json",
                'success': function (data) {
                    json = data;
                }
            });
            return json;
        })
        ();
     
        config = {
            data: json,
            xkey: 'status',
            ykeys: ['Total'],
            labels: ['Total'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['gray','red']
        };


        config.element = 'bar-chart';
        Morris.Bar(config);
    </script> 
    
    
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    
    <script>
        $(function() {
            $( "#datefrom" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
        $(function() {
            $( "#dateto" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>
