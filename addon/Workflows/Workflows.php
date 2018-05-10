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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Workflows</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>
    
      <div class="container">
          
          <?php
          
          if(isset($EXECUTE) && $EXECUTE == 1 ) { ?>
          
    <div  class="text-center">
       <label class="label label-success">Incomplete Workflows</label>
      <div id="bar-chart" ></div>
    </div>
  
          <br>
          
    <table id="task" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Reminder</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Reminder</th>
                <th>Deadline</th>
            </tr>
        </tfoot>
    </table>          
          
              
 <?php  } ?>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>

<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
<script type="text/javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

<?php if(isset($EXECUTE) && $EXECUTE == 1 ) { ?>
    
<script>
    
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': '/addon/Workflows/JSON/workflow_charts.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=1&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=1"; } ?>>',
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
      xkey: 'task',
      ykeys: ['Completed'],
      labels: ['Incompleted Tasks'],
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
<script type="text/javascript" language="javascript" >
$(document).ready(function() {
    var table = $('#task').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    if ( aData["deadline"] <= aData["today"] )  {
          $('td', nRow).eq(7).addClass( 'red' );
    }
   else if ( aData["deadline"] >= aData["today"] )  {
          $('td', nRow).eq(7).addClass( 'green' );

    }
    if ( aData["reminder"] < aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'red' );
    }
   else if ( aData["reminder"] === aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'amber' );

    } 
       else if ( aData["reminder"] > aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'green' );

    } 
},
"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/addon/Workflows/JSON/workflows.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=1&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=1"; } ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_added" },
            { "data": "adl_workflows_client_id_fk",
            "render": function(data, type, full, meta) {
                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
            } },
            { "data": "name" },
            { "data": "adl_workflows_assigned" },
            { "data": "adl_workflows_name" },
            { "data": "reminder" },
            { "data": "deadline" }
         ],
        "order": [[7, 'asc']]
    } ); $('#min, #max').keyup( function() {
        table.draw();
    } );
     
    $('#task tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } ); 
} );
</script>    
      
<?php } ?>
</body>
</html>