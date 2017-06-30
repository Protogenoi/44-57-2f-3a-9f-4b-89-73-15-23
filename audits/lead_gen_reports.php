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

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }


if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

$step= filter_input(INPUT_GET, 'step', FILTER_SANITIZE_SPECIAL_CHARS);

if ($step =='Search') {
    
    $result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY)group by grade");

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


$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen WHERE submitted_date between DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) AND LAST_DAY(NOW()) group by grade");

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


$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date between DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH) AND DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY) group by grade");

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

$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date > DATE_SUB(NOW(), INTERVAL 1 DAY) group by grade");

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

$jsonTable5 = json_encode($table);
    
}

else { 
    

$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND auditor='$hello_name' group by grade");

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


$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen WHERE submitted_date between DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) AND LAST_DAY(NOW()) AND auditor='$hello_name' group by grade");

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


$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date between DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH) AND DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY) AND auditor='$hello_name' group by grade");

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

$result = $conn->query("select grade, count(grade) As Alert from Audit_LeadGen where submitted_date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND auditor='$hello_name' group by grade");

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

$jsonTable5 = json_encode($table);
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
<title>ADL | Lead Gen Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../styles/sweet-alert.min.css" />
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
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
<!--<div class="col-md-3">
    <div id="today_chart">
        
    </div>
        
</div>
<div class="col-md-3">
    <div id="donutchart2">
        
    </div>
        
</div>
<div class="col-md-3">
    <div id="donutchart">
        
    </div>
        
</div>
<div class="col-md-3">
    <div id="previous_month_chart">
        
    </div>
        
</div>
</div>
    
    <div class="container"> -->

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

$audit= filter_input(INPUT_GET, 'audit', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($audit)){

    if ($audit =='y') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Audit submitted!</div>");
    }
    
}

$grade= filter_input(INPUT_GET, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($grade)){

    if ($grade =='Green') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Audit grade: Green!</strong></div>");
    }
    
        if ($grade =='Red') {

print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Audit grade: Red!</strong></div>");
    }
    
           if ($grade =='Amber') {

print("<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Audit grade: Amber!</strong></div>");
    }
    
}

?>

<br>

<center>
    <div class="btn-group">
        <a href="Audit_LeadGen.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</a>
        <a href="auditor_menu.php" class="btn btn-info"><i class="fa fa-folder-open"></i> Closer Audits</a>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cats"><span class="glyphicon glyphicon-question-sign"></span></button>
    </div>
</center>
<br>

 <?php
 
$deleteauditid = filter_input(INPUT_GET, 'deletedaudit', FILTER_SANITIZE_NUMBER_INT);
$deletenewauditid = filter_input(INPUT_GET, 'deletednewaudit', FILTER_SANITIZE_NUMBER_INT);

if(isset($deleteauditid)){

$idvarplaceholder = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("DELETE FROM lead_gen_audit where id = :idnameplaceholder LIMIT 1");

$query->bindParam(':idnameplaceholder', $idvarplaceholder, PDO::PARAM_INT);
$query->execute();

if ($count = $query->rowCount()>0) {
echo("<div class=\"notice notice-danger fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Audit deleted</strong></div>.");
}
else {
    echo "<div class=\"notice notice-warning fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error Audit NOT deleted</strong></div>";
    }
}



if(isset($deletenewauditid)){

$deletenewauditid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("DELETE FROM Audit_LeadGen where id = :idholder LIMIT 1");

$query->bindParam(':idholder', $deletenewauditid, PDO::PARAM_INT);
$query->execute();

if ($count = $query->rowCount()>0) {
echo("<div class=\"notice notice-danger fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Audit $deletenewauditid deleted</strong></div>.");
}
else {
    echo "<div class=\"notice notice-warning fade in\" role=\"alert\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error Audit NOT deleted</strong></div>";
    }
}
?>
<br>

          <form class="form-inline" method="GET">
              <fieldset>
                  <legend>Audit Search</legend>

<div class="form-group">
    <select id="step" name="step" class="form-control">
        <?php if(isset($step)) { echo "<option value='$step'>$step</option>";} ?>
        <option value=" ">Select..</option>
      <option value="New">New</option>
      <option value="Search">Search New Audits</option>
      <option value="Old">Old</option>
      <option value="Searchold">Search Old Audits</option>
    </select>
</div>

<div class="form-group">

    <button id="" name="" class="btn btn-primary">Submit</button>
    <a href="lead_gen_reports.php" class="btn btn-danger"> Reset</a>

</div>
              </fieldset>
          </form>
<br>

<?php



if ($step =='New') {
    
    $step= filter_input(INPUT_GET, 'step', FILTER_SANITIZE_SPECIAL_CHARS);
    
    
    

$query = $pdo->prepare("SELECT id, an_number, submitted_date, agent, auditor, grade, edited, submitted_edit from Audit_LeadGen where auditor = :hellonameplaceholder and submitted_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or submitted_edit between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND edited =:hellonameplaceholder ORDER BY submitted_date DESC");
$query->bindParam(':hellonameplaceholder', $hello_name, PDO::PARAM_STR, 12);

echo "<table class=\"table\">";

echo 
"<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
	<tr>
	<th>ID</th>
	<th>Date Submitted</th>
        <th>AN Number</th>
	<th>Lead Gen</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";
$i=0;
$query->execute();
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
	echo "<td>".$result['submitted_date']."</td>";
        echo "<td>".$result['an_number']."</td>";
	echo "<td>".$result['agent']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	echo "<td>".$result['edited']."</td>";
	echo "<td>".$result['submitted_edit']."</td>";
	echo "<td>
      <form action='lead_gen_form_edit.php?new=y'  method='POST' name='form'>
	<input type='hidden' name='editid' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
	echo "<td> 
      <form action='LandG/View.php?EXECUTE=1&AID=".$result['id']."' method='POST'>
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
	echo "<td>
      <form action='LeadPDFReport.php?new=y' method='POST' name='pdfformview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button>
      </form>
   </td>";
	echo "<td>
      <form action='agent_reports.php' method='get' name='leadgen'>
	<input type='hidden' name='leadgen' value='".$result['agent']."' >
<button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button>
      </form>
   </td>";
if($hello_name == 'Michael'){
echo "<td>
      <form id='deletenewauditconfirm$i' action='lead_gen_reports.php?deletenewaudit' method='GET' name='deleteaudit'>
	<input type='hidden' name='id' value='".$result['id']."' >
            <input type='hidden' name='step' value='New' >
	<input type='hidden' name='deletednewaudit'>
<button type=\"submit\" name='deletednewaudit' class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span> </button>
      </form>
   </td>";
}    
   
	echo "</tr>";
	echo "\n"; ?>
<script>
        document.querySelector('#deletenewauditconfirm<?php echo $i?>').addEventListener('submit', function(e) {
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
      
} }
    echo "</table>";
    
}



if ($step =='Search') {
    
    ?>
    <table id="clients" width="auto" cellspacing="0" class="table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>AN Number</th>
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
                <th>AN Number</th>
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
<?php

}

if ($step =='Searchold') {
    
    ?>
    <table id="oldclients" width="auto" cellspacing="0" class="table-condensed">
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
<?php

}

if ($step =='Old') {


$query = $pdo->prepare("SELECT id, date_submitted, lead_gen_name, auditor, grade, edited, date_edited from lead_gen_audit where auditor = :hellonameplaceholder and date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or date_edited between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND edited =:hellonameplaceholder ORDER BY date_submitted DESC");
$query->bindParam(':hellonameplaceholder', $hello_name, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
	<tr>
	<th>ID</th>
	<th>Date Submitted</th>
	<th>Lead Gen</th>
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
	echo "<td>".$result['date_submitted']."</td>";
	echo "<td>".$result['lead_gen_name']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	echo "<td>".$result['edited']."</td>";
	echo "<td>".$result['date_edited']."</td>";
	echo "<td>
      <form action='lead_gen_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
	echo "<td>
     <form action='LandG/View.php?EXECUTE=1&AID=".$result['id']."' method='POST'>
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
	echo "<td>
      <form action='LeadPDFReport.php' method='POST' name='pdfformview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button>
      </form>
   </td>";
	echo "<td>
      <form action='agent_reports.php' method='get' name='leadgen'>
	<input type='hidden' name='leadgen' value='".$result['lead_gen_name']."' >
<button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button>
      </form>
   </td>";
if($hello_name == 'Michael'){
echo "<td>
      <form id='deleteauditconfirm$i' action='lead_gen_reports.php?deleteaudit' method='GET' name='deleteaudit'>
	<input type='hidden' name='id' value='".$result['id']."' >
	<input type='hidden' name='deletedaudit'>
<button type=\"submit\" name='deletedaudit' class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span> </button>
      </form>
   </td>";
}    
   
	echo "</tr>";?>
<script>
        document.querySelector('#deleteauditconfirm<?php echo $i?>').addEventListener('submit', function(e) {
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
   <?php }
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Old Data/Information Available</div>";
}
echo "</table>";
}
?>
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
         <img class="img-responsive" src="../img/aww/<?php $random = rand(1,12); echo $random; ?>.jpg" alt="Image not found"> 
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
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="../js/sweet-alert.min.js"></script>
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
			colors: ['#109618', '#FF9900','#DC3912', '#990099'],
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
			colors: ['#109618', '#FF9900','#DC3912', '#990099'],
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
			colors: ['#109618', '#FF9900','#DC3912', '#990099'],
backgroundColor: '#FFFFFF'
        };
      var chart = new google.visualization.PieChart(document.getElementById('previous_month_chart'));
      chart.draw(data, options);
    }
    </script>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable5?>);
      var options = {
           title: 'Todays Grades',
			pieHole: 0.4,
			colors: ['#109618', '#FF9900','#DC3912', '#990099'],
backgroundColor: '#FFFFFF'
        };
      var chart = new google.visualization.PieChart(document.getElementById('today_chart'));
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
<script type="text/javascript" language="javascript" >
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Changes:</td>'+
            '<td>'+d.submitted_edit+' </td>'+
	   '<td>'+d.edited+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Grade:</td>'+
            '<td>'+d.grade+' </td>'+
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
        "ajax": "datatables/AuditSearch.php?AuditType=NewLeadGen",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "submitted_date" },
            { "data": "id"},
            { "data": "an_number"},
            { "data": "agent" },
            { "data": "auditor" },
            { "data": "grade" },
  { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="lead_gen_form_edit.php?new=y&auditid=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LandG/View.php?EXECUTE=1&AID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a>';
            } },
 
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LeadPDFReport.php?new=y&auditid=' + data + '"><button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button></a>';
            } },
  { "data": "agent",
            "render": function(data, type, full, meta) {
                return '<a href="agent_reports.php?new=y&leadgen=' + data + '"><button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button></a>';
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
    var table = $('#oldclients').DataTable( {
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
        "ajax": "datatables/AuditSearch.php?AuditType=OldLeadGen",
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
                return '<a href="LandG/View.php?EXECUTE=1&AID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a>';
            } },
 
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LeadPDFReport.php?new=y&auditid=' + data + '"><button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button></a>';
            } },
  { "data": "lead_gen_name",
            "render": function(data, type, full, meta) {
                return '<a href="agent_reports.php?leadgen=' + data + '"><button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button></a>';
            } },
        ],
        "order": [[1, 'desc']]
    } );

    $('#oldclients tbody').on('click', 'td.details-control', function () {
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
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
</body>
</html>