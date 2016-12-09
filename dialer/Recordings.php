<?php 

include('../includes/adlfunctions.php'); 

if ($ffdialler=='0') {
        
        header('Location: ../CRMmain.php'); die;
    }

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;


include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>Call Recordings</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<style>
  .modal-static { 
    position: fixed;
    top: 50% !important; 
    left: 50% !important; 
    margin-top: -100px;  
    margin-left: -100px; 
    overflow: visible !important;
}
.modal-static,
.modal-static .modal-dialog,
.modal-static .modal-content {
    width: 180px; 
    height: 200px; 
}
.modal-static .modal-dialog,
.modal-static .modal-content {
    padding: 0 !important; 
    margin: 0 !important;
}
.modal-static .modal-content .icon {
}
  </style>
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
    include('../includes/dialler_functions.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
            include($_SERVER['DOCUMENT_ROOT']."/includes/DIALLER_PDO_CON.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $SERVER= filter_input(INPUT_POST, 'SERVER', FILTER_SANITIZE_SPECIAL_CHARS);
    ?>


  <div class="container">
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-headphones"></i> Call Recordings <a href='Recordings.php'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-history"></i> New Search...</button></a></div>
  <div class="panel-body">

<h4>Search by number </h4>

<form action="Recordings.php?go" method="post" id="searchform" autocomplete="off"> 
    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" name="location" placeholder="7446301726" value="<?php echo $_POST['location'] ?>">
</div>
</div>
    
            <div class="form-group">
      <div class="col-xs-2">
          <select name="SERVER" class="form-control">
              <?php if(isset($SERVER)) {
                  if($SERVER=='OLD') { ?>
                    <option value="OLD" selected>OLD SERVER</option>
              <option value="NEW">NEW SERVER</option>  
                <?php }
                  if($SERVER=='NEW') { ?>
               <option value="OLD" DISABLED>OLD SERVER</option>
              <option value="NEW" selected>NEW SERVER</option>      
                <?php  }
              } else {
?>
              <option value="NEW">NEW SERVER</option>
              <option value="OLD" DISABLED>OLD SERVER</option>
              
              
              <?php } ?>
          </select>
</div>
</div>
    <div class="form-group">
      <div class="col-xs-2">
      </div>
      </div>


    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
          <button type="submit" name="submit" value="Search" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form>
<br>

<?php


$go = filter_input(INPUT_GET, 'go', FILTER_SANITIZE_NUMBER_INT);

if(isset($go)){
if(isset($SERVER)) {
    


$name= filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
$locationvar = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT);    
    


$RM_ZERO = ltrim($locationvar, '0');
$newlocationvar = "$RM_ZERO";
$four_phone = "44$RM_ZERO";

if($SERVER=='OLD') {

$query = $bureaupdo->prepare("SELECT lead_id,call_date,status from vicidial_log where phone_number IN (:nozero,:four,:zero) group by lead_id ORDER BY call_date DESC");
$query->bindParam(':nozero', $newlocationvar, PDO::PARAM_INT);
$query->bindParam(':four', $four_phone, PDO::PARAM_INT);
$query->bindParam(':zero', $locationvar, PDO::PARAM_INT);

}


if($SERVER=='NEW') {
    include('../includes/DIALLER_PDO_CON.php');
$query = $TRB_DB_PDO->prepare("SELECT lead_id,call_date,status from vicidial_log where phone_number IN (:nozero,:four,:zero) group by lead_id ORDER BY call_date DESC");
$query->bindParam(':nozero', $newlocationvar, PDO::PARAM_INT);
$query->bindParam(':four', $four_phone, PDO::PARAM_INT);
$query->bindParam(':zero', $locationvar, PDO::PARAM_INT);
    
}

echo "<table align=\"center\" class=\"table\">";

echo   
    "<thead>
    <tr>
    <th colspan= 11>Searched for $locationvar</th>
    </tr>
    <tr>
    <th>Lead ID</td>
    <th>Call Date</th>
    <th>Status</th>
    </tr>
    </thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$call_date=$result['call_date'];
$status=$result['status'];

if($SERVER=='OLD') {
recordings_table($lead_id, $call_date, $status);
}
if($SERVER=='NEW') {
new_recordings_table($lead_id, $call_date, $status);
}

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for  $locationvar/$RM_ZERO</div>";
}
echo "</table>";
}
}

?>

<br>



<h4>Search by lead ID </h4>

<form action="Recordings.php?leadid" method="POST" autocomplete="off">

    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="lead_ids" name="lead_ids" placeholder="Lead ID" value="<?php echo $lead_ids ?>" required>
</div>
</div>
    
    

            <div class="form-group">
      <div class="col-xs-2">
          <select name="SERVER" class="form-control">
              <?php if(isset($SERVER)) {
                  if($SERVER=='OLD') { ?>
                    <option value="OLD" selected>OLD SERVER</option>
              <option value="NEW">NEW SERVER</option>  
                <?php }
                  if($SERVER=='NEW') { ?>
               <option value="OLD" DISABLED>OLD SERVER</option>
              <option value="NEW" selected>NEW SERVER</option>      
                <?php  }
              } else {
?>
              <option value="NEW">NEW SERVER</option>
              <option value="OLD" DISABLED>OLD SERVER</option>
              
              <?php } ?>
          </select>
</div>
</div>
    
        <div class="form-group">
      <div class="col-xs-2">
      </div>
      </div>

    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
<button type="submit" name="submitleadid" value="submitleadid" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form>
<br>

<?php

$submitleadid= filter_input(INPUT_POST, 'submitleadid', FILTER_SANITIZE_NUMBER_INT);
$leadid = filter_input(INPUT_GET, 'leadid', FILTER_SANITIZE_NUMBER_INT);

if(isset($submitleadid)){
if(isset($leadid)){

$lead_ids = filter_input(INPUT_POST, 'lead_ids', FILTER_SANITIZE_NUMBER_INT); 
if($SERVER=='OLD') {
$query = $bureaupdo->prepare("SELECT lead_id,call_date,status from vicidial_log where lead_id = :leadidplaceholder group by lead_id ORDER BY call_date DESC");
$query->bindParam(':leadidplaceholder', $lead_ids, PDO::PARAM_INT);
}

if($SERVER=='NEW') {
    include('../includes/DIALLER_PDO_CON.php');
$query = $TRB_DB_PDO->prepare("SELECT lead_id,call_date,status from vicidial_log where lead_id = :leadidplaceholder group by lead_id ORDER BY call_date DESC");
$query->bindParam(':leadidplaceholder', $lead_ids, PDO::PARAM_INT);

}


echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo "  <thead>
    <tr>
    <th colspan= 11>Searched for $lead_ids</th>
    </tr>
        <tr>
    <th>Lead ID</td>
    <th>Call Date</th>
    <th>Length in Seconds</th>
    </tr>
    </thead>";

 
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$call_date=$result['call_date'];
$status=$result['status'];

if($SERVER=='OLD') {
recordings_table($lead_id, $call_date, $status);
}

if($SERVER=='NEW') {
new_recordings_table($lead_id, $call_date, $status);

}

}
} else {
echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for $lead_ids</div>";
}
echo "</table>";
}
}

if($SERVER=='OLD') {
?>


<br>
<h4>Search by agent and date</h4>

<form action="Recordings.php?agentdate" method="POST" autocomplete="off">
    <div class="form-group">
      <div class="col-xs-2">
<?php

$query = $bureaupdo->prepare("SELECT user, full_name FROM vicidial_users where active ='Y' ORDER BY full_name ASC");
	echo "<select class='form-control' style=\"width: 180px\" name='usersearchvar' required>";
	echo "<option value=''>Select...</option>";
$query->execute();
	if ($query->rowCount()>0) {
	while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	echo "<option value='" . $result['user'] . "'>" . $result['full_name'] . "</option>";
	}
	}
	echo "</select>";
?>

</div>
</div>
    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="datefromvar" name="datefromvar" placeholder="Date From:" value="<?php echo $datefromvar ?>" required>
</div>
</div>
    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
<button type="submit" name="agentdatesearch" value="agentdatesearch" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>

</form>
<br>

<?php

$agentdatesearch= filter_input(INPUT_POST, 'agentdatesearch', FILTER_SANITIZE_NUMBER_INT);
$agentdate = filter_input(INPUT_GET, 'agentdate', FILTER_SANITIZE_NUMBER_INT);

if(isset($agentdatesearch)){
if(isset($agentdate)){

$datefromvar = filter_input(INPUT_POST, 'datefromvar', FILTER_SANITIZE_NUMBER_INT);
$usersearchvar = filter_input(INPUT_POST, 'usersearchvar', FILTER_SANITIZE_SPECIAL_CHARS); 

$newdate = "$datefromvar%";

$query = $bureaupdo->prepare("SELECT vicidial_list.status, recording_log.lead_id, recording_log.user, recording_log.start_time, recording_log.end_time, recording_log.length_in_min, recording_log.location 
FROM recording_log 
LEFT JOIN vicidial_list
ON vicidial_list.lead_id = recording_log.lead_id 
WHERE recording_log.user = :userplaceholder
AND recording_log.start_time like :datefromplaceholder
 GROUP by vicidial_list.lead_id ORDER BY start_time DESC");

$query->bindParam(':userplaceholder', $usersearchvar, PDO::PARAM_STR, 12);
$query->bindParam(':datefromplaceholder', $newdate, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table\">";

echo   
    "<thead>
    <tr>
    <th colspan= 11>Searched for $usersearchvar ($datefromvar)</th>
    </tr>
    <tr>
    <th>Lead ID</td>
    <th>User</th>
    <th>Status</th>
    <th id='STIME'>Start Time</th>
    <th id='ETIME'>End Time</th>
    <th>Call Time</th>
    <th></th>
    </tr>
    </thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];
$user=$result['user'];
$start_time=$result['start_time'];
$end_time=$result['end_time'];
$length_in_min=$result['length_in_min'];
$location=$result['location'];
$status=$result['status'];

recordings_table($lead_id, $user, $status, $start_time,$end_time,$length_in_min,$location);
}
} else {
echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for $usersearchvar ($datefromvar)</div>";
}
echo "</table>";
}
}

?>
<br>
<h4>Search by agent and number</h4>

<form action="Recordings.php?agentnumber" method="post" id="searchform" autocomplete="off"> 

    <div class="form-group">
      <div class="col-xs-2">

<?php
$query = $bureaupdo->prepare("SELECT user, full_name FROM vicidial_users where active ='Y' ORDER BY full_name ASC");
	echo "<select class='form-control' style=\"width: 180px\" name='usersearchvarb' required>";
	echo "<option value=''>Select...</option>";
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	echo "<option value='" . $result['user'] . "'>" . $result['full_name'] . "</option>";
}
}
	echo "</select>";
?>
</div>
</div>
    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" name="locationvarb" placeholder="7446301726">
</div>
</div>
    <div class="form-group">
      <div class="col-xs-2">
           <div class="btn-group">
<button type="submit" name="agentnumbersearch" value="agentnumbersearch" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>

</form>
<br>

<?php

$agentnumbersearch= filter_input(INPUT_POST, 'agentnumbersearch', FILTER_SANITIZE_NUMBER_INT);
$agentnumber = filter_input(INPUT_GET, 'agentnumber', FILTER_SANITIZE_NUMBER_INT);

if(isset($agentnumbersearch)){
if(isset($agentnumber)){

$locationvarb = filter_input(INPUT_POST, 'locationvarb', FILTER_SANITIZE_NUMBER_INT);
$usersearchvarb = filter_input(INPUT_POST, 'usersearchvarb', FILTER_SANITIZE_SPECIAL_CHARS); 

$newlocationvar = "%$locationvarb%";

$query = $bureaupdo->prepare("SELECT vicidial_list.status, recording_log.lead_id, recording_log.user, recording_log.start_time, recording_log.end_time, recording_log.length_in_min, recording_log.location 
FROM recording_log 
LEFT JOIN vicidial_list
ON vicidial_list.lead_id = recording_log.lead_id 
WHERE recording_log.location LIKE :locationplaceholder AND recording_log.user = :userplaceholder
GROUP by vicidial_list.lead_id ORDER BY start_time DESC");

$query->bindParam(':locationplaceholder', $newlocationvar, PDO::PARAM_STR, 12);
$query->bindParam(':userplaceholder', $usersearchvarb, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo 
	"<thead>
	<tr>
	<th>Lead ID</td>
	<th>User</th>
	<th>Status</th>
	<th id='STIME'>Start Time</th>
	<th id='ETIME'>End Time</th>
	<th>Call Time</th>
	<th></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$user=$result['user'];
$start_time=$result['start_time'];
$end_time=$result['end_time'];
$length_in_min=$result['length_in_min'];
$location=$result['location'];
$status=$result['status'];

recordings_table($lead_id, $user, $status, $start_time,$end_time,$length_in_min,$location);

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for $usersearchvarb - $locationvarb</div>";
}
echo "</table>";
}
}
?>
<br>
<h4>Search by mainline and date</h4>

<form action="Recordings.php?searchmain" method="POST" autocomplete="off">

    <div class="form-group">
      <div class="col-xs-2">
      
<select class='form-control' name='usersearch' style='width: 180px' required>
<option value=''>Select...</option>
<?php if(isset($companynamere)) {
    if($companynamere=='The Review Bureau') {
?>
<option value='08450950041'>Life Mainline</option>
<option value='950041'>Carys Life Mainline</option>
<option value='01792905366'>Financial 366 Mainline</option>
<option value='03300882906'>Financial 906 Mainline</option>
<option value='01792905364'>Recruitment Mainline</option>
<?php } } ?>
<?php if(isset($companynamere)) {
    if($companynamere=='Assura') {
?>
<option value='03334432484'>Assura Mainline</option>
<?php } } ?>
</select>
</div>
</div>

    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="datefrommain" name="datefrom" placeholder="Date From:" value="<?php echo $datefrom ?>" required>
</div>
</div>

    <div class="form-group">
      <div class="col-xs-2">
           <div class="btn-group">
<button type="submit" name="mainlinesearch" value="mainlinesearch" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form><br>

<?php

$mainlinesearch= filter_input(INPUT_POST, 'mainlinesearch', FILTER_SANITIZE_NUMBER_INT);
$searchmain = filter_input(INPUT_GET, 'searchmain', FILTER_SANITIZE_NUMBER_INT);

if(isset($mainlinesearch)){
if(isset($searchmain)){
    
$usersearch = filter_input(INPUT_POST, 'usersearch', FILTER_SANITIZE_NUMBER_INT);
$datefrom = filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_NUMBER_INT);

$newdatefrom = "$datefrom%";

$query = $bureaupdo->prepare("SELECT vicidial_list.status, recording_log.lead_id, recording_log.user, recording_log.start_time, recording_log.end_time, recording_log.length_in_min, recording_log.location 
FROM recording_log 
LEFT JOIN vicidial_list
ON vicidial_list.lead_id = recording_log.lead_id 
WHERE recording_log.user = :usersearchplaceholder
AND recording_log.start_time like :datefromplaceholder
 GROUP by vicidial_list.lead_id ORDER BY start_time DESC");

$query->bindParam(':usersearchplaceholder', $usersearch, PDO::PARAM_STR, 12);
$query->bindParam(':datefromplaceholder', $newdatefrom, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo 
	"<thead>
	<tr>
	<th colspan= 15>User ID: $usersearch Date: $datefrom</th>
	</tr>
	<tr>
	<th>Lead ID</td>
	<th>User</th>
	<th>Status</th>
	<th id='STIME'>Start Time</th>
	<th id='ETIME'>End Time</th>
	<th>Call Time</th>
	<th></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];
$user=$result['user'];
$start_time=$result['start_time'];
$end_time=$result['end_time'];
$length_in_min=$result['length_in_min'];
$location=$result['location'];
$status=$result['status'];

recordings_table($lead_id, $user, $status, $start_time,$end_time,$length_in_min,$location);

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for  $usersearch ($datefrom)</div>";
}
echo "</table>";
}
}
?>

<br>
<h4>Search by client name</h4>
<form action="Recordings.php?searchname" method="POST" autocomplete="off">

     <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Bob" value="<?php echo $firstname ?>" required>
</div>
</div>


    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Jones" value="<?php echo $lastname ?>" required>
</div>
</div>

    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
<button type="submit" name="namesubmit" data-toggle="modal" data-target="#processing-modal" value="Search" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form><br>

<?php

$namesubmit= filter_input(INPUT_POST, 'namesubmit', FILTER_SANITIZE_NUMBER_INT);
$searchname = filter_input(INPUT_GET, 'searchname', FILTER_SANITIZE_NUMBER_INT);

if(isset($namesubmit)){
if(isset($searchname)){
    
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $bureaupdo->prepare("SELECT vicidial_list.status, recording_log.lead_id, recording_log.user, recording_log.start_time, recording_log.end_time, recording_log.length_in_min 
FROM vicidial_list 
LEFT JOIN recording_log
ON vicidial_list.lead_id = recording_log.lead_id 
WHERE vicidial_list.first_name = :firstnameplaceholder
AND vicidial_list.last_name = :lastnameplaceholder
 GROUP by vicidial_list.lead_id ORDER BY start_time DESC");

$query->bindParam(':firstnameplaceholder', $firstname, PDO::PARAM_STR, 12);
$query->bindParam(':lastnameplaceholder', $lastname, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo "  <thead>
    <tr>
    <th colspan= 15>Searched for $firstname $lastname</th>
    </tr>
        <tr>
    <th>Lead ID</td>
    <th>User</th>
    <th>Status</th>
    <th id='STIME'>Start Time</th>
    <th id='ETIME'>End Time</th>
    <th>Call Time</th>
    </tr>
    </thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$user=$result['user'];
$start_time=$result['start_time'];
$end_time=$result['end_time'];
$length_in_min=$result['length_in_min'];
$status=$result['status'];

recordings_table($lead_id, $user, $status, $start_time,$end_time,$length_in_min);

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for  $firstnamevar $lastnamevar</div>";
}
echo "</table>";
}
}
}
?>

</div>
</div>
</div>

<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="../img/loading.gif" class="icon" />
                    <h4>Searching... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
    $("readonly").keydown(function(e){
        e.preventDefault();
    });
</script>
 <script>
  $(function() {
    $( "#datefrommain" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#datefromvar" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
</body>
</html>
