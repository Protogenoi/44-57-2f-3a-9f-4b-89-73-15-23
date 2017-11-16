<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php'); 

if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}


include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>EWS Agent Performance</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
      <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
      <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <style>
        .label-purple {
  background-color: #8e44ad;
}
#tableEditor {
    position: absolute;
    left: 50px; top: 250px;
    padding: 5px;
    border: 1px solid #000;
    background: #fff;
}
        div.smallcontainer {
          
            font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
        }
    </style>
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
   
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $agent= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);
    $type= filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);


$newdatefrom="$datefrom 01:00:00";
$newdateto="$dateto 23:00:00";
    ?>
    
    <div class="container">
  <div class="row">
  <form class="form-vertical">
<fieldset>

<legend>Select Agent/Closer and a date range</legend>

  <div class="col-xs-2">
    <select id="type" name="type" class="form-control" required>
        <?php if(isset($type)) { ?>
        <option value="<?php echo"$type";?>"><?php echo"$type";?></option>
        <?php } ?>
       <option value="">Select...</option> 
      <option value="Closer">Closer</option>
      <option value="AnyUser">All</option>
      <option value="LeadGen">LeadGen</option>
    </select>
  </div>

<div class="col-xs-2">
<input type='text' id='agent' name='agent' style="width: 140px" value="<?php if(isset($agent)) { echo "$agent";}?>">      
</div>
<script>var options = {
	url: "../../JSON/<?php if($companynamere=='Bluestone Protect') { echo "AllNames" ; } else { echo "CUS_AllNames"; } ?>.json",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#agent").easyAutocomplete(options);</script>

<div class="col-xs-2">
  <input id="datefrom" name="datefrom" placeholder="Date From" <?php if(isset($datefrom)) { echo "value='$datefrom'"; }?>class="form-control input-md" type="text">
</div>

<div class="col-xs-2">
  <input id="dateto" name="dateto" placeholder="Date To" <?php if(isset($dateto)) { echo "value='$dateto'"; }?> class="form-control input-md" type="text"> 
</div>

<div class="col-xs-2">
    <button name="submit" class="btn btn-success">Submit</button>
    <a href="EWSAgentPerformance.php" class="btn btn-danger "><span class="glyphicon glyphicon-repeat"></span> Reset</a>
  </div>


</fieldset>
</form>
  </div>
         <?php         

         if(isset($type)) {
             if($type=='Closer') {

         $query = $pdo->prepare("
select COUNT(ews_data.ews_status_status) AS Lists FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer3 AND ews_data.ews_status_status='CFO' AND ews_data.date_added between :datefrom3 AND :dateto3  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer4 AND ews_data.ews_status_status='LAPSED' AND ews_data.date_added between :datefrom4 AND :dateto4   UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer5 AND ews_data.ews_status_status='RE-INSTATED'AND ews_data.date_added between  :datefrom5 AND :dateto5  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer6 AND ews_data.ews_status_status='WILL CANCEL' AND ews_data.date_added between :datefrom6 AND :dateto6  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer7 AND ews_data.ews_status_status='CANCELLED' AND ews_data.date_added between  :datefrom7 AND :dateto7  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer8 AND ews_data.ews_status_status='WILL REDRAW' AND ews_data.date_added between :datefrom8 AND :dateto8  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.closer=:closer9 AND ews_data.ews_status_status='REDRAWN' AND ews_data.date_added between :datefrom9 AND :dateto9
");

$query->bindParam(':closer3', $agent, PDO::PARAM_STR);
$query->bindParam(':closer4', $agent, PDO::PARAM_STR);
$query->bindParam(':closer5', $agent, PDO::PARAM_STR);
$query->bindParam(':closer6', $agent, PDO::PARAM_STR);
$query->bindParam(':closer7', $agent, PDO::PARAM_STR);
$query->bindParam(':closer8', $agent, PDO::PARAM_STR);
$query->bindParam(':closer9', $agent, PDO::PARAM_STR);

$query->bindParam(':datefrom3', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto3', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom4', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto4', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom5', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto5', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom6', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto6', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom7', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto7', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom8', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto8', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom9', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto9', $newdateto, PDO::PARAM_STR, 12);

         }
         
         if($type=='LeadGen') {
             
                          $query = $pdo->prepare("
select COUNT(ews_data.ews_status_status) AS Lists FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead3 AND ews_data.ews_status_status='CFO' AND ews_data.date_added between :datefrom3 AND :dateto3  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead4 AND ews_data.ews_status_status='LAPSED' AND ews_data.date_added between :datefrom4 AND :dateto4   UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead5 AND ews_data.ews_status_status='RE-INSTATED'AND ews_data.date_added between  :datefrom5 AND :dateto5  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead6 AND ews_data.ews_status_status='WILL CANCEL' AND ews_data.date_added between :datefrom6 AND :dateto6  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead7 AND ews_data.ews_status_status='CANCELLED' AND ews_data.date_added between  :datefrom7 AND :dateto7  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead8 AND ews_data.ews_status_status='WILL REDRAW' AND ews_data.date_added between :datefrom8 AND :dateto8  UNION ALL
select COUNT(ews_data.ews_status_status) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:lead9 AND ews_data.ews_status_status='REDRAWN' AND ews_data.date_added between :datefrom9 AND :dateto9
");

$query->bindParam(':lead3', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead4', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead5', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead6', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead7', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead8', $agent, PDO::PARAM_STR, 12);
$query->bindParam(':lead9', $agent, PDO::PARAM_STR, 12);

$query->bindParam(':datefrom3', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto3', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom4', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto4', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom5', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto5', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom6', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto6', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom7', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto7', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom8', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto8', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom9', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto9', $newdateto, PDO::PARAM_STR, 12);   
             
             
         }
         
  
                      if($type=='AnyUser') {

         $query = $pdo->prepare("
select COUNT(ews_data.warning) AS Lists FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='CFO' AND ews_data.date_added between :datefrom3 AND :dateto3  UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='LAPSED' AND ews_data.date_added between :datefrom4 AND :dateto4   UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='RE-INSTATED'AND ews_data.date_added between  :datefrom5 AND :dateto5  UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='WILL CANCEL' AND ews_data.date_added between :datefrom6 AND :dateto6  UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='CANCELLED' AND ews_data.date_added between  :datefrom7 AND :dateto7  UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='WILL REDRAW' AND ews_data.date_added between :datefrom8 AND :dateto8  UNION ALL
select COUNT(ews_data.warning) FROM client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.warning='REDRAWN' AND ews_data.date_added between :datefrom9 AND :dateto9
");

$query->bindParam(':datefrom3', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto3', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom4', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto4', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom5', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto5', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom6', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto6', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom7', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto7', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom8', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto8', $newdateto, PDO::PARAM_STR, 12);
$query->bindParam(':datefrom9', $newdatefrom, PDO::PARAM_STR, 12);
$query->bindParam(':dateto9', $newdateto, PDO::PARAM_STR, 12);

         }
         }

?>
<div class="row">
<table class="table table-condensed table-striped" id="stats">

<thead>
	<tr>
	<th colspan='9'></th>
	</tr>
	<tr>
	<td>CFO</td>
	<td>LAPSED</td>
	<td>RE-INSTATED</td>
	<td>WILL CANCEL</td>
	<td>CANCELLED</td>
	<td>WILL REDRAW</td>
	<td>REDRAWN</td>
	</tr>
	</thead>
        
        <?php

        if(isset($type)) {
        
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	echo "<th>".$result["Lists"]."</th>";
    }
} 
        
else {
	echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
        }
?>
    
    </table>
</div> 
    </div> <?php 
         
         if(isset($type)) {
             if($type=='Closer') {
         
         
         $query = $pdo->prepare("select ews_data.off_risk_date, ews_data.premium_os, ews_data.net_premium, ews_data.last_full_premium_paid, ews_data.policy_type, ews_data.post_code, CONCAT(ews_data.address1,' ',ews_data.address2,' ',ews_data.address3,' ',ews_data.address4) AS ADDRESS, ews_data.client_name, ews_data.clawback_due, ews_data.policy_start_date, ews_data.date_added, ews_data.policy_number, client_policy.client_id, client_policy.id,  ews_data.ews_status_status, ews_data.warning, client_policy.closer, client_policy.lead from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.date_added between :datefrom AND :dateto AND client_policy.closer=:closer");
         $query->bindParam(':closer', $agent, PDO::PARAM_STR, 12);
         $query->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $query->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         
         $clawq = $pdo->prepare("select sum(ews_data.clawback_due) AS clawback_due from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.date_added between :datefrom AND :dateto AND client_policy.closer=:closer");
         $clawq->bindParam(':closer', $agent, PDO::PARAM_STR, 12);
         $clawq->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $clawq->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         $clawq->execute();
         $result=$clawq->fetch(PDO::FETCH_ASSOC);
         
         $clawtotal=$result['clawback_due'];
         }
         
                      if($type=='AnyUser') {
         
         
         $query = $pdo->prepare("select ews_data.off_risk_date, ews_data.premium_os, ews_data.net_premium, ews_data.last_full_premium_paid, ews_data.policy_type, ews_data.post_code, CONCAT(ews_data.address1,' ',ews_data.address2,' ',ews_data.address3,' ',ews_data.address4) AS ADDRESS, ews_data.client_name, ews_data.clawback_due, ews_data.policy_start_date, ews_data.date_added, ews_data.policy_number, client_policy.client_id, client_policy.id, ews_data.ews_status_status, ews_data.warning, client_policy.closer, client_policy.lead from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.date_added between :datefrom AND :dateto");
         $query->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $query->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         
         $clawq = $pdo->prepare("select sum(ews_data.clawback_due) AS clawback_due from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.date_added between :datefrom AND :dateto");
         $clawq->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $clawq->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         $clawq->execute();
         $result=$clawq->fetch(PDO::FETCH_ASSOC);
         
         $clawtotal=$result['clawback_due'];
         
         }
         
         if($type=='LeadGen') {
             
         $query = $pdo->prepare("select ews_data.off_risk_date, ews_data.premium_os, ews_data.net_premium, ews_data.last_full_premium_paid, ews_data.policy_type, ews_data.post_code, CONCAT(ews_data.address1,' ',ews_data.address2,' ',ews_data.address3,' ',ews_data.address4) AS ADDRESS, ews_data.client_name, ews_data.policy_number, ews_data.clawback_due, ews_data.policy_start_date, ews_data.date_added, client_policy.client_id, client_policy.id, ews_data.ews_status_status, ews_data.warning, client_policy.closer, client_policy.lead from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE client_policy.lead=:closer AND ews_data.date_added between :datefrom AND :dateto");
         $query->bindParam(':closer', $agent, PDO::PARAM_STR, 12);
         $query->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $query->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         
         $clawq = $pdo->prepare("select sum(ews_data.clawback_due) AS clawback_due from client_policy JOIN ews_data on client_policy.policy_number = ews_data.policy_number WHERE ews_data.date_added between :datefrom AND :dateto AND client_policy.lead=:closer");
         $clawq->bindParam(':closer', $agent, PDO::PARAM_STR, 12);
         $clawq->bindParam(':datefrom', $newdatefrom, PDO::PARAM_STR, 12);
         $clawq->bindParam(':dateto', $newdateto, PDO::PARAM_STR, 12);
         $clawq->execute();
         $result=$clawq->fetch(PDO::FETCH_ASSOC);
         
         $clawtotal=$result['clawback_due'];
             
         }

         ?>
    <div class="smallcontainer">
                    

                       <a href="edit" id=edit><i class="fa fa-eye-slash"></i> Hide/Show columns</a> 
                    <table id="table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Policy</th>
                                <th>Client</th>
                                <th>Address</th>
                                <th>Post Code</th>
                                <th>Type</th>
                                <th>Last Full Premium Paid</th>
                                <th>Net Premium</th>
                                <th>Premium O/S</th>
                                <th>Clawback <?php if(isset($clawtotal)){ echo "(£$clawtotal)";} ?></th>
                                <th>Policy Start</th>
                                <th>Off Risk Date</th>
                                <th>Warning</th>
                                <th>Orig Warning</th>
                                <th>Closer</th>
                                <th>Lead</th>
                            </tr>
                        </thead>
                            
                            <?php
                            
                            if(isset($type)) {
                            
                            $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $search=$result['client_id'];
                                    $polid=$result['id'];
                                    $ADLSTATUS=$result['ews_status_status'];
                                    $EWSSTATUS=$result['warning'];
                                    $shortdate=date("Y-m-d", strtotime($result['date_added']));
                                       
                                    echo '<tr>';
                                    echo "<td>$shortdate</td>";
                                    echo "<td><a href='../ViewPolicy.php?policyID=$polid' target='_blank'>".$result['policy_number']."</a></td>";
                                    echo "<td><a href='../ViewClient.php?search=$search' target='_blank'><i class='fa fa-search'></i> ".$result['client_name']."</a></td>";
                                    echo "<td>".$result['ADDRESS']."</td>";
                                    echo "<td>".$result['post_code']."</td>";
                                    echo "<td>".$result['policy_type']."</td>";
                                    echo "<td>".$result['last_full_premium_paid']."</td>";
                                    echo "<td>£".$result['net_premium']."</td>";
                                    echo "<td>£".$result['premium_os']."</td>";
                                    echo "<td>£".$result['clawback_due']."</td>";
                                    echo "<td>".$result['policy_start_date']."</td>";
                                    echo "<td>".$result['off_risk_date']."</td>";
                                    
                                    
                                    if($ADLSTATUS != $EWSSTATUS) {
                                        switch ($EWSSTATUS) {
                                            case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$EWSSTATUS</span></td>";
                                                break;
                                                case "WILL CANCEL":
                                                echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                                                break;
                                            case "REDRAWN":
                                                case "WILL REDRAW":
                                                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                                                    break;
                                                case "CANCELLED":
                                                    case "CFO":
                                                        case "LAPSED":
                                                            case "CANCELLED DD":
                                                                case "BOUNCED DD":
                                                                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                                                                    break;
                                                                default:
                                                                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
                                                                    
                                        }
                                        
                                        }
                                        
                                        else {
                                            
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$ADLSTATUS</span></td>";
                                                break;
                                                    case "WILL CANCEL":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "CANCELLED":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                            
                                            }
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$ADLSTATUS</span></td>";
                                                break;
                                                    case "WILL CANCEL":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "CANCELLED":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                    echo "<td>".$result['closer']."</td>";
                                    echo "<td>".$result['lead']."</td>";
                                    echo "</tr>";
                                    
                                }
                                
                                }
                                
                                else {
                                    
                                    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Agent/Closer)</div>";
                                    
                                }
                            }
         }
                                ?>
                    </table>      
        
                    </div>
   
    

    <script>
$('#edit').click(function() {
    var headers = $('#table th').map(function() {
        var th =  $(this);
        return {
            text: th.text(),
            shown: th.css('display') != 'none'
        };
    });
    
    var h = ['<div id=tableEditor><a href="#" class="btn btn-primary btn-block" id="done"><i class="fa fa-check"></i> Set Columns</a><table><thead><tr>'];
    $.each(headers, function() {
        h.push('<th><input type=checkbox',
               (this.shown ? ' checked ' : ' '),
               '/> ',
               this.text,
               '</th>');
    });
    h.push('</tr></thead></table></div>');
    $('body').append(h.join(''));
    
    $('#done').click(function() {
        var showHeaders = $('#tableEditor input').map(function() { return this.checked; });
        $.each(showHeaders, function(i, show) {
            var cssIndex = i + 1;
            var tags = $('#table th:nth-child(' + cssIndex + '), #table td:nth-child(' + cssIndex + ')');
            if (show)
                tags.show();
            else
                tags.hide();
        });
        
        $('#tableEditor').remove();
        return false;
    });
    
    return false;
});

    
    
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
