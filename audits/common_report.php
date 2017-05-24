<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_MYSQLI_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }


if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}


$name= filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_NUMBER_INT);
$dateto = filter_input(INPUT_POST, 'dateto', FILTER_SANITIZE_NUMBER_INT);

//print_r($_POST); die;
$result = $mysqli->query("select call_opening, count(call_opening) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  call_opening");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Call Opening', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['call_opening']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable = json_encode($table);

?>

<?php


$result = $mysqli->query("select full_info, count(full_info) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  full_info");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Full Information', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['full_info']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable2 = json_encode($table);

?>

<?php


$result = $mysqli->query("select obj_handled, count(obj_handled) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  obj_handled");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Objections Handled', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['obj_handled']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable3 = json_encode($table);

?>

<?php


$result = $mysqli->query("select rapport, count(rapport) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  rapport");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Rapport', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['rapport']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable4 = json_encode($table);

?>

<?php


$result = $mysqli->query("select dealsheet_questions, count(dealsheet_questions) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  dealsheet_questions");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Dealsheet Questions', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['dealsheet_questions']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable5 = json_encode($table);

?>

<?php


$result = $mysqli->query("select brad_compl, count(brad_compl) as Alert from lead_gen_audit where lead_gen_name ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by  brad_compl");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Branding Compliance', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['brad_compl']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable6 = json_encode($table);

?>

<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Audit Profile Questions</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php');
?>

  <div class="container">
			
		
<fieldset>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<label for="agent"><select class="form-control" style="width: 170px" name="fname" onchange="myFunction(this.value)">
	<option value="<?php echo $_POST[fname]?>"><?php echo $_POST['fname']?></option>


<?php
$query = $bureaupdo->prepare("SELECT full_name FROM vicidial_users WHERE user_group = 'Life' OR user_group = 'web' ORDER BY full_name ASC");
$query->execute();
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
echo "<option value='" . $result['full_name'] . "'>" . $result['full_name'] . "</option>";
}
?>
</select>
</label>

	
<label for="datefrom">Start Date<input id="datefrom" type="text" name="datefrom" placeholder="YYYY-MM-DD" value="<?php echo $datefrom;?>"> </label>
<label for="dateto">End Date<input id="dateto" type="text" name="dateto" placeholder="YYYY-MM-DD" value="<?php echo $dateto;?>"> </label>
	<button type="submit" class="btn btn-info" value="Go"><span class="glyphicon glyphicon-search"></span></button>
	</form>
	</fieldset>
<br>

<center>
<a href="audit_profiles.php">
<button type="button" class="btn btn-warning "><span class="glyphicon glyphicon-user"></span> Audit Profiles</button>
</a>
<a href="lead_gen_reports.php">
<button type="button" class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Lead Audits</button>
</a>
<a href="lead_search.php">
<button type="button" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</button>
</a>
<a href="agent_reports.php">
<button type="button" class="btn btn-primary "><span class="glyphicon glyphicon-question-sign"></span> Lead Grades</button>
</a>
</center>

<br>
<br>

<?php if(isset($datefrom)&& ($dateto) && ($name)) {
echo '<div class="column-left">
<div id="columnchart_material"></div>
<div id="rapport_chart"></div>
</div>

<div class="column-center">
<div id="full_info_chart"></div>
<div id="dealsheet_chart"></div>
</div>

<div class="column-right">
<div id="obj_handled_chart"></div>
<div id="brad_compl_chart"></div>
</div>'; }?>



<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
function myFunction(val) {
    alert("The input value has changed. The new value is: " + val);
}
</script>

    </script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: 'Call opening',
            chart: {
         
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable2?>);

        var options = {
          title: 'Did the agents provide full information?',
            chart: {
          
        },
			colors: ['yellow']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('full_info_chart'));

        chart.draw(data, options);
      }
    </script>
	
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable3?>);

        var options = {
          title: 'Objections handled',
            chart: {
          
        },
		
			colors: ['green']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('obj_handled_chart'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable4?>);

        var options = {
          title: 'Rapport',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('rapport_chart'));

        chart.draw(data, options);
      }
    </script>
	
	<script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable5?>);

        var options = {
          title: 'Did the agent ask all the questions on the dealsheet?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('dealsheet_chart'));

        chart.draw(data, options);
      }
    </script>
	
		<script type="text/javascript">
       google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable6?>);

        var options = {
           title: 'Did the agent stick to branding compliance?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('brad_compl_chart'));

        chart.draw(data, options);
      }
    </script>
	<!--SCROLL UP-->
<script src="../js/jquery-1.4.min.js"></script>
<script src="../js/jquery.pjScrollUp.min.js"></script>
<script>
$(function() {
    $(document).pjScrollUp({
        offset: 210,
        duration: 850,
        aTitle: "Scroll Up",
        imgAlt: "Back to top",
        imgSrc: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAVPSURBVHic7Z3dbxRVFMB/ZylRaipYsQo8FEkIGx76ggHfFGliGx98kDZqMOJ/ZpRoAuGBmFiQLSVV0lB5sSakpgapAYm1qR+NYDT0+HBv93vne+7MLPNL9qHdmTvn/nJ3Z+6ZO2dFVckKEdkFjABDHi+ATY/Xmqo+cht5A3EtUER2A0eAKnAQqMRscgu4CywDP6jqnzHbC4UTgSLyIkZYFdiX8uF+wchcVtW1lI+VnkAREeAocBLYm8pB/FkH5oDbmlJHUxEoIi8D48CBxBuPxn2gpqo/Jd1wogLtR3UcOJxYo8myghH5a1INJiJQRJ4FTgFjgMRuMF0UWAJmVfWvuI3FFigiB4FpYDBuMI55CJxX1btxGoklUEReASaBHXGCyJDHwIyq3oraQCSBIlIBJoDjUQ+cMxaBy6q6FXbH0ALt7GEKOBT2YDnnDnAh7KwmlEARGQbOAMPhYisMG8A5Vd0IukPgaZQdef0sD0zfzti+BiKQQPudN0V/y9tmGJiyffYl6AicoP++87w4hOmzL74C7aVKv5xtw3Dc9t0TT4H2InkyoYCKyKR10JOeAu30bJriXiQnwQ5g2rroitcIPEXxpmdpMIhx0ZWuAm1WZSytiArImHXSQa8ROE7+syouEYyTDjoE2mRoXvN5WXLYummhRaBNw3c1XQLAuHVUp30EHiU/afg8cgDjqE67wJPuYiksLY7qAu1ZJqu7Z0Vib/MZuXkEVjMIpqjUXZUCo9Eq0C63SHvFQD+xzzqrj8By9IWnCjDQ/EfO+A2zLONnTHxvkK+5eRW4OWDT16NZR9PG98AXqvqv/fuWiPwIvAu8lF1YLYyKyK4KZn1e3CVmSbKgqheb5AGgqn8AH2PWueSBCjBSobGIMQ/Mq+qVXm+q6j/Ap5glbHlgKE8Ca6p6zW+jJokP0g/Jl9wIvKKq3wTd2N78/gRzosmSXAi8qqoLYXeyEj8D/k4+pMBkLvCaqt6IurOq/g58DvyXXEihyFTgdVWd99tIRJ7yel9V7wEXMYvNXZOZwHlVve63kYi8BnwoIju9tlPVZeASZvGkS4ayuP67EeRsKyLHMLm3/cDp9kxwO6r6HfBlMiEGp4J5WMUVC6p61W8jEakCbzX96wgBllqo6rfAbPTwQrPpUuA94Cu/jURkFDhN5+zohIi86re/qn6NWevnAqcC5/ye1bCZ3vdoJDnaedOOTj98T04J4VSg5/RLRPZg1h8+7bUZ8I6I+N34cjVLcSrQax3OIPABwa4IdgLvi8hzPtu4wKnArksjrIizwPMh2noGOGuXHHdjf7jQIrM5gDuBEyKyAKxhnmHbg8lDvk60ROlu4CMRuQmsYvrxgn2dSCLgAGwOYDq0Rfo5wRHg7YTbHCK7lRRbwFrFTspXMwqiyKyq6qPtUbecaSjFZBkaH9tSYHgaAu1j8nnI8BaFB9ulBZpPHOUoDE7dVSkwGp0C7VPc65mEUyzWm594b7/2m3McTBFpcdQu8Db5uXGdR+5jHNVpEWjTTTWXERWMWntKrmP6ZkuDrDgLqTisdCub0mv+W8P9DZo80/OT2VWgPcsspRlRwVjqVWvGKwMziykN8qTzEI8bVT0F2qI05zGlQZ5UHmNqy/Qs0OOZA7RFaWYSDqpIzPgV5vFNotqiNItJRVQgFoMU5Amahb6Mu3uteeAOps++BBJoK/pcwNRV6Xc2MAV4Ai1WCnwfxKb+z9HfErcL7wSuXlSWfmqQfumn+k5l8bE6Zfm7LMrftTRQFmAsS4DGoSxCG5OyDHJMykLcMSlLwcek/DGCmDgX2HLwPvg5jP8BZQUTNqeQ8kYAAAAASUVORK5CYII=",
        selector: "my-id",
        easing: "linear",
        complete: function () {
            if (window.console && window.console.log) {
                console.log("complete!");
            }
        }
    });
});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datefrom" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script> 
</body>
</html>
