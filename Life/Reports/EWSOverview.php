<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php'); 

if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}

    
    include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}



include('../../includes/ADL_MYSQLI_CON.php');

$result = $conn->query("SELECT 
count(ews_status_status) AS Alert,
ews_status_status
FROM ews_data
WHERE ews_data.ournotes = ''
OR color_status='black'
OR color_status='blue'
GROUP BY ews_status_status");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'ews_status_status', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['ews_status_status']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable = json_encode($table); 

$result = $conn->query("SELECT
count(ews_status_status) AS Alert,
ews_status_status
FROM ews_data 
WHERE ews_data.ournotes !=''
AND color_status!='black'
OR color_status!='blue'
GROUP BY ews_status_status");

  $results2 = array();
  $table2 = array();
  $table2['cols'] = array(

    array('label' => 'ews_status_status', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['ews_status_status']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results2[] = array('c' => $temp);
    }

$table2['rows'] = $results2;

$jsonTable1 = json_encode($table2); 

$submit= filter_input(INPUT_GET, 'submit', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($submit)) {
    
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $newdatefrom="$datefrom%";
    $newdateto="$dateto%";
    
    $result = $conn->query("SELECT 
count(ews_status_status) AS Alert,
ews_status_status
FROM ews_data
WHERE ews_data.ournotes = ''
OR color_status='black'
OR color_status='blue'
AND date_added between '$newdatefrom' AND '$newdateto'
GROUP BY ews_status_status");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'ews_status_status', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['ews_status_status']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable3 = json_encode($table); 

}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | EWS Overview</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>
    
    <div class="container">

        
        
            
            <?php if(isset($submit)) {
                
                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-calendar-check-o fa-lg\"></i> Success:</strong> Dates from $datefrom to $dateto</div>");

                
                ?>
            <div class="row">
                <div class="col-sm-4">
      <div id="TOWORK" style="width: 550px; height: 400px;"></div>  
    </div>
    <div class="col-sm-4">
     <div id="CASESWORKED" style="width: 550px; height: 400px;"></div> 
    </div>
            
                <div class="col-sm-4">
     <div id="DATED" style="width: 550px; height: 400px;"></div> 
    </div>
  </div>
        
            <?php } else { ?>
        <div class="row">
            <div class="col-sm-6">
      <div id="TOWORK" style="width: 550px; height: 400px;"></div>  
    </div>
    <div class="col-sm-6">
     <div id="CASESWORKED" style="width: 550px; height: 400px;"></div> 
    </div>
        </div>
            <?php } ?>
  
  
  <form class="form-vertical">
<fieldset>

<!-- Form Name -->
<legend>Select date range</legend>

<div class="col-xs-2">
  <input id="datefrom" name="datefrom" placeholder="Date From" class="form-control input-md" type="text">
</div>

<div class="col-xs-2">
  <input id="dateto" name="dateto" placeholder="Date To" class="form-control input-md" type="text"> 
</div>

<!-- Button (Double) -->
<div class="form-group">
  <div class="col-md-8">
    <button name="submit" class="btn btn-success">Submit</button>
    <a href="EWSOverview.php" class="btn btn-danger "><span class="glyphicon glyphicon-repeat"></span> Reset</a>
  </div>
</div>

</fieldset>
</form>

  
    </div>
    
<script src="../../js/jquery.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

 <script type="text/javascript">
     
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable?>);
        var options = {
            title: 'EWS Cases To Work',
            pieHole: 0.4,
            colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
            backgroundColor: '#FFFFFF'
        };
        
    var chart = new google.visualization.PieChart(document.getElementById('TOWORK'));
    chart.draw(data, options);
    }
     </script>
 <script type="text/javascript">
     
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable1?>);
        var options = {
            title: 'EWS Cases Worked',
            pieHole: 0.4,
            colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
            backgroundColor: '#FFFFFF'
        };
        
    var chart = new google.visualization.PieChart(document.getElementById('CASESWORKED'));
    chart.draw(data, options);
    }
     </script>
      <script type="text/javascript">
     
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable3?>);
        var options = {
            title: 'EWS Date Search',
            pieHole: 0.4,
            colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
            backgroundColor: '#FFFFFF'
        };
        
    var chart = new google.visualization.PieChart(document.getElementById('DATED'));
    chart.draw(data, options);
    }
     </script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
