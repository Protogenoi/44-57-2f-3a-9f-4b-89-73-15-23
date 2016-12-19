<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/adlfunctions.php'); 

if ($ffdialler=='0') {
        
        header('Location: ../CRMmain.php'); die;
    }

include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Call Recordings</title>
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
    include('../includes/DIALLER_PDO_CON.php');
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $SERVER= filter_input(INPUT_POST, 'SERVER', FILTER_SANITIZE_SPECIAL_CHARS);
    $QRY = filter_input(INPUT_GET, 'QRY', FILTER_SANITIZE_SPECIAL_CHARS);
    ?>


  <div class="container">
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-headphones"></i> Call Recordings <a href='Recordings.php'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-history"></i> New Search...</button></a></div>
  <div class="panel-body">

<h4>Search by number </h4>

<form action="Recordings.php?go" method="post" id="searchform" autocomplete="off"> 
    <div class="form-group">
      <div class="col-xs-2">
<input type="tel" class="form-control" name="location" required pattern=".{10}|.{10,12}" maxlength="12" placeholder="7446301726" value="<?php echo $_POST['location'] ?>">
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

$query = $TRB_DB_PDO->prepare("SELECT lead_id,call_date,status from vicidial_log where phone_number IN (:nozero,:four,:zero) group by lead_id ORDER BY call_date DESC");
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
$query = $TRB_DB_PDO->prepare("SELECT lead_id,call_date,status from vicidial_log where lead_id = :leadidplaceholder group by lead_id ORDER BY call_date DESC");
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

?>
<br>
<h4>Search by agent and date</h4>

<form action="Recordings.php?QRY=AgentDate" method="POST" autocomplete="off">
    <div class="form-group">
      <div class="col-xs-2">
<?php
$query = $TRB_DB_PDO->prepare("SELECT user, full_name FROM vicidial_users where active ='Y' ORDER BY full_name ASC");
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
    <?php
    
    if(isset($QRY)){
    if($QRY=='AgentDate') {
    $datefromvar = filter_input(INPUT_POST, 'datefromvar', FILTER_SANITIZE_NUMBER_INT);
$usersearchvar = filter_input(INPUT_POST, 'usersearchvar', FILTER_SANITIZE_SPECIAL_CHARS); 
    }
    }
    ?>
    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="datefromvar" name="datefromvar" placeholder="Date From:" value="<?php if(isset($datefromvar)) { echo $datefromvar; } ?>" required>
</div>
</div>
       
        <div class="form-group">
      <div class="col-xs-2">
      </div>
      </div>
    
    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
<button type="submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>

</form>
<br>

<?php

if(isset($QRY)){
    if($QRY=='AgentDate') {
    
$query = $TRB_DB_PDO->prepare("SELECT lead_id,call_date,status from vicidial_log where DATE(call_date) =:date and user=:user group by lead_id ORDER BY call_date DESC");
$query->bindParam(':user', $usersearchvar, PDO::PARAM_INT);
$query->bindParam(':date', $datefromvar, PDO::PARAM_STR, 12);

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
    </tr>
    </thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];
$status=$result['status'];

new_recordings_table($lead_id, $call_date, $status);
}
} else {
echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for $usersearchvar ($datefromvar)</div>";
}
echo "</table>";
}
}

    
    if(isset($QRY)){
if($QRY=='Mainline'){
    
$usersearch = filter_input(INPUT_POST, 'usersearch', FILTER_SANITIZE_NUMBER_INT);
$datefrom = filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_NUMBER_INT);

}
    }
?>

<br>
<h4>Search by mainline and date</h4>

<form action="Recordings.php?QRY=Mainline" method="POST" autocomplete="off">

    <div class="form-group">
        <div class="col-xs-2">
            <select class='form-control' name='usersearch' style='width: 180px' required>
                <option value=''>Select...</option>
                <option value='08450950041' <?php if(isset($usersearch)) { if($usersearch=='08450950041') { echo "selected"; } } ?>>Life Mainline</option>
                <option value='01792905364' <?php if(isset($usersearch)) { if($usersearch=='01792905364') { echo "selected"; } } ?>>Recruitment Mainline</option>
            </select>
        </div>
    </div>

    <div class="form-group">
      <div class="col-xs-2">
<input type="text" class="form-control" id="datefrommain" name="datefrom" placeholder="Date From:" value="<?php if(isset($datefrom)) { echo $datefrom; } ?>" required>
</div>
</div>
    
        <div class="form-group">
      <div class="col-xs-2">
      </div>
</div>

    <div class="form-group">
      <div class="col-xs-2">
           <div class="btn-group">
<button type="submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form><br>

<?php

if(isset($QRY)){
    if($QRY=='Mainline'){

$query = $TRB_DB_PDO->prepare("SELECT location, start_time FROM recording_log WHERE user =:user AND DATE(start_time) =:date ORDER BY start_time DESC");
$query->bindParam(':user', $usersearch, PDO::PARAM_INT);
$query->bindParam(':date', $datefrom, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo 
	"<thead>
	<tr>
	<th colspan='2'>User ID: $usersearch Date: $datefrom</th>
	</tr>
	<tr>
	<th>Date</td>
	<th>URL</th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$location  =$result['location'];
$start_time=$result['start_time'];


echo "<tr>
<td>$start_time</td>
<td><a href='$location' target='_blank'>View</a></td>    
</tr>";

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for  $usersearch ($datefrom)</div>";
}
echo "</table>";
}
}

if(isset($QRY)){
if($QRY=='ClientName'){
    
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);

}
}
?>

<br>
<h4>Search by client name</h4>
<form action="Recordings.php?QRY=ClientName" method="POST" autocomplete="off">

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
      </div>
</div>

    <div class="form-group">
      <div class="col-xs-2">
          <div class="btn-group">
<button type="submit" data-toggle="modal" data-target="#processing-modal" value="Search" class="btn btn-info btn-sm"><i class="fa  fa-search"></i> </button>
          </div>
      </div>
</div>
</form><br>

<?php


if(isset($QRY)){
if($QRY=='ClientName'){

$query = $TRB_DB_PDO->prepare("SELECT lead_id, phone_number, last_local_call_time FROM vicidial_list WHERE first_name=:first AND last_name=:last ORDER BY last_local_call_time DESC LIMIT 100");
$query->bindParam(':first', $firstname, PDO::PARAM_STR, 12);
$query->bindParam(':last', $lastname, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table table-hover table-condensed\">";

echo "  <thead>
    <tr>
    <th colspan= 15>Searched for $firstname $lastname</th>
    </tr>
        <tr>
    <th>Last Called</td>
    <th>Phone</th>
    <th>Lead ID</th>
    </tr>
    </thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$phone_number=$result['phone_number'];
$last_local_call_time=$result['last_local_call_time'];

echo "<tr>
<td>$last_local_call_time</td>
<td>$phone_number</td>
<td><a href='http://trb.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=".$lead_id."' target='_blank'>$lead_id</a></td> 
</tr>";


}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No recordings found for  $firstnamevar $lastnamevar</div>";
}
echo "</table>";
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
