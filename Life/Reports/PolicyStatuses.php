<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php'); 

if ($fflife=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }

include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

?>
<!DOCTYPE html>
<html lang="en">
<title>Policy Statuses</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
      <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $type= filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

$newdatefrom="$datefrom 06:00:00";
$newdateto="$dateto 23:00:00";
    ?>
    
    <div class="container">
  <div class="row">
  <form class="form-vertical">
<fieldset>

<legend>Select a Policy Status and a date range</legend>

  <div class="col-xs-2">
    <select id="type" name="type" class="form-control" required>
        
        
        <?php
        
        if(isset($type)) {
            
                ?>
                <option value="<?php echo "$type"; ?>"><?php echo "$type"; ?></option>
                <?php
        }
                $query = $pdo->prepare("SELECT policystatus from client_policy GROUP BY policystatus");
                $query->execute();
                if ($query->rowCount()>0) {
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
              
                
                ?>
                
                <option value="<?php echo "$result[policystatus]"; ?>"><?php echo "$result[policystatus]"; ?></option>
                    
                    <?php
                    }
                    }
                    
                    ?>
    </select>
  </div>

<div class="col-xs-2">
  <input id="datefrom" name="datefrom" placeholder="Date From" <?php if(isset($datefrom)) { echo "value='$datefrom'"; }?>class="form-control input-md" type="text">
</div>

<div class="col-xs-2">
  <input id="dateto" name="dateto" placeholder="Date To" <?php if(isset($dateto)) { echo "value='$dateto'"; }?> class="form-control input-md" type="text"> 
</div>

<div class="col-xs-2">
    <button name="submit" class="btn btn-success">Submit</button>
    <a href="PolicyStatuses.php" class="btn btn-danger "><span class="glyphicon glyphicon-repeat"></span> Reset</a>
  </div>


</fieldset>
</form>
  </div>

<div class="row">
<table class="table table-hover table-condensed">

<thead>
	<tr>
	<th colspan='9'></th>
	</tr>
	<tr>
	<td>Client</td>
        <td>Policy Number</td>
	<td>Policy Status</td>
	<td>Insurer</td>
	<td>Added</td>
	<td>Updated</td>
        <td>View</td>
	</tr>
	</thead>
        
        <?php

        if(isset($type)) {
            
         $query = $pdo->prepare("select policy_number, client_name, client_id, policystatus, insurer, submitted_date, date_edited from client_policy WHERE policystatus=:status and submitted_date between :datefrom AND :dateto");
         $query->bindParam(':status', $type, PDO::PARAM_STR, 12);
         $query->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $query->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
        
$query->execute();
$count = $query->rowCount();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	                                    $search=$result['client_id'];
                                       
                                    echo '<tr>';
                                    echo "<td>".$result['client_name']."</td>";
                                    echo "<td>".$result['policy_number']."</td>";
                                    echo "<td>".$result['policystatus']."</td>";
                                    echo "<td>".$result['insurer']."</td>";
                                    echo "<td>".$result['submitted_date']."</td>";
                                    echo "<td>".$result['date_edited']."</td>";
                                    echo "<td><a href='../ViewClient.php?search=$search' target='_blank' class='btn btn-info btn-sm'><i class='fa fa-search'></i> </a></td>";
                                    echo "</tr>";
    }
    
    echo "<br><div class=\"notice notice-info\" role=\"alert\"><strong>Info!</strong> <strong>$count</strong> records found for <strong>$type</strong></div>";
} 
        
else {
	echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available (Policy Status)</div>";
}
        }
        
?>
    
    </table>
</div> 
         
        
                    </div>
    </div>
    
<script src="../../js/jquery.min.js"></script>
<script src="../../resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
