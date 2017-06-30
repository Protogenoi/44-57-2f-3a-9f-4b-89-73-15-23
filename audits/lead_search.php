<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_MYSQLI_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}


$result = $mysqli->query('select grade, count(grade) As Alert from lead_gen_audit where date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) group by grade');

  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable = json_encode($table);

?>

<?php

$result = $mysqli->query('select grade, count(grade) As Alert from lead_gen_audit WHERE date_submitted between DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) AND LAST_DAY(NOW()) group by grade');

  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable2 = json_encode($table);

?>

<?php


$result = $mysqli->query("select grade, count(grade) As Alert from lead_gen_audit where date_submitted between DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH) AND DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY) group by grade");

  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable4 = json_encode($table);

?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Lead Audit Search</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../datatables/css/dataTables.customLoader.walker.css">
<link rel="stylesheet" type="text/css" href="../datatables/css/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php');

?>

<div class="container">

<br>

			<div class="column-left">
   <div id="donutchart2"></div>
			</div>
			<div class="column-center">
   <div id="donutchart"></div>
			</div>
			<div class="column-right">
<div id="previous_month_chart"></div>   
			</div>

<br>
    <table id="clients" width="auto" cellspacing="0" class="table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>Lead Gen</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
                <th>PDF</th>
                <th>Profile</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>Lead Gen</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
                <th>PDF</th>
                <th>Profile</th>
            </tr>
        </tfoot>
    </table>
</div>


<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/tab.js"></script>		
<script type="text/javascript" language="javascript" src="../datatables/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" >
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Changes:</td>'+
            '<td>'+d.date_edited+' </td>'+
	   '<td>'+d.edited+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Grade:</td>'+
            '<td>'+d.grade+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Answered Correctly:</td>'+
            '<td>'+d.total+'/6 </td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#clients').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["grade"] == "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["grade"] == "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["grade"] == "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["grade"] == "SAVED" )  {
          $(nRow).addClass( 'Purple' );
    }
},

"response":true,
					"processing": true,
"iDisplayLength": 50,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "datatables/getleadaudits.php",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_submitted" },
            { "data": "id"},
            { "data": "lead_gen_name" },
            { "data": "auditor" },
            { "data": "grade" },
  { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="lead_gen_form_edit.php?auditid=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="lead_gen_form_view.php?auditid=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a>';
            } },
 
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LeadPDFReport.php?auditid=' + data + '"><button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button></a>';
            } },
  { "data": "lead_gen_name",
            "render": function(data, type, full, meta) {
                return '<a href="agent_reports.php?leadgen=' + data + '"><button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button></a>';
            } },
        ],
        "order": [[1, 'desc']]
    } );

    $('#clients tbody').on('click', 'td.details-control', function () {
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

 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 <script type="text/javascript">


    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
           title: 'This Weeks Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
      chart.draw(data, options);
    }
    </script>
	<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable2?>);
      var options = {
           title: 'This Months Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
    </script>

<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable4?>);
      var options = {
           title: 'Last Months Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };

      var chart = new google.visualization.PieChart(document.getElementById('previous_month_chart'));
      chart.draw(data, options);
    }
    </script>
</body>
</html>
