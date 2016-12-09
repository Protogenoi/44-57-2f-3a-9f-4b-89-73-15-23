<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if($fflife=='0') {
    
    header('Location: /CRMmain.php'); die;
    
}

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/ADL_PDO_CON.php');
include('../includes/ADL_MYSQLI_CON.php');

?>

<!DOCTYPE html>
<html>
<title>ADL | My Account</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<style>#area-chart,
#line-chart,
#bar-chart,
#stacked,
#pie-chart{
  min-height: 250px;
}</style>
<link rel="stylesheet" type="text/css" href="//cdn.oesmith.co.uk/morris-0.5.1.css">
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>

<?php include('../includes/navbar.php'); ?>
<div class="container">
    
    <?php if($fflife=='1') { ?>
    
    <div  class="text-center">
       <label class="label label-success">Tasks in-complete</label>
      <div id="bar-chart" ></div>
    </div>



<?php

$query = $pdo->prepare("SELECT Client_Tasks.client_id, Client_Tasks.Task, Client_Tasks.deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where Client_Tasks.Assigned =:hello AND complete='0' ORDER BY Client_Tasks.deadline ASC");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table\">";

echo "  <thead>
	<tr>
	<th colspan= 12>Your Tasks</th>
	</tr>
    	<tr>
                <th>Client Name</th>
                <th>Subject</th>
                <th>Deadline</th>
	</tr>
	</thead>";

 $query->execute();
 if ($query->rowCount()>0) {
     while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
  $deadline=$row['deadline'];
  $today=$row['today'];
    
        switch( $row['deadline'] )
    {
      case($deadline <= $today):
         $class2 = 'red';
          break;
        case($deadline >= $today):
          $class2 = 'green';
           break; 
        default:
 }
	echo '<tr>';
	echo "<td><a href='/Life/ViewClient.php?search=".$row['client_id']."'>".$row['name']."</a></td>";
	echo "<td>".$row['Task']."</td>";
	echo "<td class='$class2'>".$row['deadline']."</td>";

	echo "</tr>";
	echo "\n";
	}
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No tasks have been Assigned to you.</div>";
}
echo "</table>";

    }
?>


</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>
<?php if($fflife=='0') { ?>
<script>
    
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': 'Client_Task_Data.php',
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
      xkey: 'Task',
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
<?php } ?>
</body>

</html>
