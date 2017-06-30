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
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

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
        
        header('Location: ../CRMmain.php'); die;
    }

if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 


$result = $conn->query("select grade, count(grade) As Alert from closer_audits where date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND auditor='$hello_name' group by grade");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable = json_encode($table);

?>

<?php

$result = $conn->query("select grade, count(grade) As Alert from closer_audits WHERE date_submitted between DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) AND LAST_DAY(NOW()) AND auditor='$hello_name' group by grade");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable2 = json_encode($table);

?>

<?php

$result = $conn->query("select grade, count(grade) As Alert from closer_audits where date_submitted between DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH) AND DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY) AND auditor='$hello_name' group by grade");


  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable4 = json_encode($table);

?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
<title>ADL | Legal and General Audits</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<style type="text/css">
	.loginnote{
		margin: 20px;
	}

.uploaderror {
	font-weight: bold !important;
	color: #C00 !important;
}
.btn-file {
  position: relative !important;
  overflow: hidden !important;
}
.btn-file input[type=file] {
  position: absolute !important;
  top: 0 !important;
  right: 0 !important;
  min-width: 100% !important;
  min-height: 100% !important;
  font-size: 100px !important;
  text-align: right !important;
  filter: alpha(opacity=0) !important;
  opacity: 0 !important;
  background: red !important;
  cursor: inherit !important;
  display: block !important;
}
input[readonly] {
  background-color: white !important;
  cursor: text !important;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="/js/sweet-alert.min.js"></script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

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
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});
$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
});
</script>
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php');
?>

<div class="container">
    
<?php 

 $catupload= filter_input(INPUT_GET, 'catupload', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($catupload)) {
        
         $catupload= filter_input(INPUT_GET, 'catupload', FILTER_SANITIZE_SPECIAL_CHARS);

if ($catupload=='y') {

cat_upload();

}
    }

    $foodupload= filter_input(INPUT_GET, 'foodupload', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($foodupload)) {
        
         $foodupload= filter_input(INPUT_GET, 'foodupload', FILTER_SANITIZE_SPECIAL_CHARS);

if ($foodupload=='y') {
food_upload();

}
    }?> 

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

<?php
$RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
    
   if(isset($RETURN)) {
       if($RETURN=='ADDED') { 
               $GRADE = filter_input(INPUT_GET, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);
    $TotalCorrect = filter_input(INPUT_GET, 'TotalCorrect', FILTER_SANITIZE_SPECIAL_CHARS);
           
           ?>

       <div class="editpolicy">
    <div class="notice notice-info">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success:</strong> Audit Added!
    </div>

<?php

 switch ($GRADE) {
    case "Red":
        $NOTICE_COLOR="danger";

        break;
    case "Amber":
        $NOTICE_COLOR="warning";
        break;
    case "Green":
        $NOTICE_COLOR="success";
        break;
    default:
        $NOTICE_COLOR="info";
       
}   ?>

       <div class="editpolicy">
    <div class="notice notice-<?php echo $NOTICE_COLOR; ?>">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Grade:</strong> <?php echo $GRADE; ?> | Total answered correctly: <?php echo "$TotalCorrect/54";?>.
    </div>
    
    <?php
           
       }
       if($RETURN=='FAILED') { ?>

<div class="editpolicy">
<div class="notice notice-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> Closer Audit Failed.
    </div>
</div>
        <?php   
       }
   }
   


    ?>


<center>
    <div class="btn-group">
        <a href="main_menu.php" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i> Audit Menu</a>
        <a href="CloserAudit.php" class="btn btn-primary"><i class="fa fa-plus"></i> Legal and General Audit</a>
        <a href="audit_search.php" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</a>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cats"><span class="glyphicon glyphicon-question-sign"></span></button>
    </div>
</center>
<br>

<?php 

$query = $pdo->prepare("select count(id) AS id from closer_audits where grade ='SAVED' and auditor = :hello ");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$savedcount = $result['id'];
if ($savedcount >=1){
	echo "<div class=\"notice notice-danger\" role=\"alert\"><strong>You have <span class=\"label label-warning\">$savedcount</span> incomplete audit(s)</strong><button type=\"button\" class=\"btn btn-danger pull-right\" data-toggle=\"modal\" data-target=\"#savedaudits\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Saved Audits</button></div>";
}
else {

}
}
}
 
$deleteaudit = filter_input(INPUT_GET, 'deletedaudit', FILTER_SANITIZE_NUMBER_INT);
if(isset($deleteaudit)){

$idvarplaceholder = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("DELETE FROM closer_audits where id = :idnameplaceholder LIMIT 1");

$query->bindParam(':idnameplaceholder', $idvarplaceholder, PDO::PARAM_INT);
$query->execute();

if ($count = $query->rowCount()>0) {
	echo("<div class=\"notice notice-danger fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Audit deleted</strong></div>.");
}
else {
	echo "<div class=\"notice notice-warning fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error Audit NOT deleted</strong></div>";
    }
}
?>

<?php
$query = $pdo->prepare("SELECT policy_number, id, date_submitted, closer, auditor, grade, edited, date_edited from closer_audits where auditor = :hello and date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or date_edited between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND edited =:hello ORDER BY date_submitted DESC");

$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Policy Number</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";

$query->execute();
 $i=0;
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
    $i++;

switch( $result['grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("SAVED"):
            $class = 'Purple';
          break;
        default:
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['id']."</td>";
         echo "<td>".$result['policy_number']."</td>";
	echo "<td>".$result['date_submitted']."</td>";
	echo "<td>".$result['closer']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	echo "<td>".$result['edited']."</td>";
	echo "<td>".$result['date_edited']."</td>";
   echo "<td>
      <form action='closer_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_form_view.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='CloserPDFReport.php' method='POST' name='pdfformview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_reports.php' method='POST' name='fname'>
	<input type='hidden' name='closer' value='".$result['closer']."' >
<button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button>
      </form>
   </td>";
if($hello_name == 'Michael'){
echo "<td>
      <form id='deleteauditconfirm$i' action='auditor_menu.php?deleteaudit' method='GET' name='deleteaudit'>
	<input type='hidden' name='id' value='".$result['id']."' >
	<input type='hidden' name='deletedaudit'>
<button type=\"submit\" name='deletedaudit' class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span> </button>
      </form>
   </td>";
} 
	echo "</tr>";
        ?>
<script>
        document.querySelector('#deleteauditconfirm<?php echo $i ?>').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete audit?",
                text: "Audit cannot be recovered if deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Deleted!',
                        text: 'Audit deleted!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "Audit not deleted", "error");
                }
            });
        });

    </script>
    <?php
	}
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";
?>

    
<div id="savedaudits" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Incomplete (saved) audits</h4>
      </div>
      <div class="modal-body">
<?php
$query = $pdo->prepare("SELECT policy_number, id, date_submitted, closer, auditor, grade from closer_audits where auditor = :hello and grade = 'SAVED' ORDER BY date_submitted DESC");

$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th>ID</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th colspan='3'></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("SAVED"):
            $class = 'Purple';
          break;
        default:
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['id']."</td>";
	echo "<td>".$result['date_submitted']."</td>";
	echo "<td>".$result['closer']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	   echo "<td>
      <form action='closer_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_form_view.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
   if($hello_name == 'Michael'){
echo "<td>
      <form id='deleteauditconfirm' action='auditor_menu.php?deleteaudit' method='GET' name='deleteaudit'>
	<input type='hidden' name='id' value='".$result['id']."' >
	<input type='hidden' name='deletedaudit'>
<button type=\"submit\" name='deletedaudit' class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span> </button>
      </form>
   </td>";
}  
	echo "</tr>";
    }
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No incomplete/saved audits</div>";
}
echo "</table>";

?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
  <section class="pfblock pfblock-gray" id="skills">
		
			<div class="container">
			
				<div class="row skills">
					
					<div class="row">

                        <div class="col-sm-6 col-sm-offset-3">

                            <div class="pfblock-header wow fadeInUp">
                                <h2 class="pfblock-title">My Skills</h2>
                                <div class="pfblock-line"></div>
                                <div class="pfblock-subtitle">
                                    BLAH
                                </div>
                            </div>

                        </div>

                    </div>
					
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="80" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">80</span>
                        </span>
						<h3 class="text-center">Green</h3>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="90" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">90</span>
                        </span>
						<h3 class="text-center">Amber</h3>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="95" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">95</span>
                        </span>
						<h3 class="text-center">Red</h3>
					</div>	
				</div>
			
			</div>
		
    </section>
  
</div>

<!-- Modal -->
<div id="cats" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
         <img class="img-responsive" src="../img/aww/<?php $random = rand(1,15); echo $random; ?>.jpg" alt="Image not found"> 
         <br>
         
         <form enctype="multipart/form-data" class="form-horizontal" action="auditor_menu.php?catupload=y" method="POST">

<input type="hidden" name="MAX_FILE_SIZE" value="4122445"/>

<fieldset>
<legend>Upload more!</legend>

<div class="form-group">
<div class="col-md-4">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Browse&hellip; <input name="upload" class="input-file" type="file">
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">
                Allowed JPEG/JPG.
            </span>
        </div>
        </div>
        
<div class="form-group">
  <div class="col-md-4">
<div class="input-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>

    <button id="singlebutton" name="singlebutton" value="submit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-arrow-up"></span>Upload</button>
  </div>
  </div>
  
</div>



</fieldset>
</form>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--CATS END-->
</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>

</body>
</html>
<?php } else { 
    
    header('Location: ../CRMmain.php'); die;

} ?>