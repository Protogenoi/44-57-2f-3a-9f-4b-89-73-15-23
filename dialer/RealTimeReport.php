<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $test_access_level->log_out();
}


include('../includes/dialler_functions.php');
include('../includes/DiallerPDOcon.php');

$serverip = filter_input(INPUT_GET, 'serverip', FILTER_SANITIZE_NUMBER_INT);
$serverip = $serverip ?: '37.187.90.141';

$rf = '10';
$rf = filter_input(INPUT_GET, 'rf', FILTER_SANITIZE_NUMBER_INT);
$rf = $rf ?: '10';

$carstats = '5';
$carstats = filter_input(INPUT_GET, 'carstats', FILTER_SANITIZE_NUMBER_INT);
$carstats = $carstats ?: '5';

$camps = 'Review';
$camps = filter_input(INPUT_GET, 'camps', FILTER_SANITIZE_SPECIAL_CHARS);
$camps = $camps ?: 'Review';

$serverip = 'bureau.bluetelecoms.com';
$serverip = filter_input(INPUT_GET, 'serverip', FILTER_SANITIZE_SPECIAL_CHARS);

$chanspy = '8888a';
$chanspy = filter_input(INPUT_GET, 'chanspy', FILTER_SANITIZE_NUMBER_INT);
$chanspy = $chanspy ?: '8888a';

$ug = 'Life';
$ug = filter_input(INPUT_GET, 'ug', FILTER_SANITIZE_SPECIAL_CHARS);
$ug = $ug ?: 'Life';

?>

<?php
//CAUSE

$result = $bureaumysqli->query("SELECT hangup_cause, dialstatus, sip_hangup_cause, sip_hangup_reason, count(hangup_cause) AS Alert from vicidial_carrier_log WHERE call_date >= NOW() - INTERVAL $carstats MINUTE group by hangup_cause");

  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['sip_hangup_cause']); 
      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable2 = json_encode($table);


//DIALSTATUS


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['dialstatus']); 
      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable = json_encode($table);


//SIP HANGUP REASON


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['sip_hangup_reason']); 
      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

$jsonTable1 = json_encode($table);

?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Real Time Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="<?php echo $rf ?>" >
<link rel="stylesheet" href="/styles/realtime.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
.status_piltrans {color: white; background: #551A8B; }
</style>
</head>
<body>

<br>

<div class="container">

  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Main</a></li>
    <li><a data-toggle="pill" href="#menu1">Hopper</a></li>
    <li><a data-toggle="pill" href="#menu2">Lists</a></li>
    <li><a data-toggle="pill" href="#menu3">Hangup Report</a></li>
    <li><button data-toggle="modal" data-target="#optionsmodal" type='submit' name="rf" value="h" class='btn btn-info btn-xs' ><span class='glyphicon glyphicon-cog'></span> </button></li>

<form method="GET">
<input type="hidden" value="<?php echo $serverip ?>" name="serverip">
<input type="hidden" value="<?php echo $camps?>" name="camps">
<input type="hidden" value="<?php echo $ug?>" name="ug">
<input type="hidden" value="<?php echo $carstats?>" name="carstats">
<input type="hidden" value="<?php echo $chanspy?>" name="chanspy">
<input type="hidden" value="PAUSED" name="rf">
<li><button type="submit" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pause"></span> </button></li>
</form>
</ul>
  
  <div class="tab-content">

<!--LISTS-->

   <div id="menu2" class="tab-pane fade">

<?php

$newcampsvar = "%$camps%";

$query = $bureaupdo->prepare("SELECT list_id, list_name 
FROM vicidial_lists 
WHERE campaign_id like :campsplaceholder
AND active = 'Y'");

$query->bindParam(':campsplaceholder', $newcampsvar, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover table-condensed\" >";

echo 
	"<thead>
	<tr>
	<th align=\"center\" colspan=\"6\">Active lists for the $camps Campaign</th>
	</tr>
	<tr>
	<th>List ID</th>
	<th>List Name</th>
	</tr>
	</thead>";
 
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

    $list_id=$result['list_id'];    

    echo "<tr>";
    echo "<td><a href='http://$serverip/vicidial/admin.php?ADD=311&list_id=" . $result['list_id'] . "'target='_blank''>$list_id</a></td>";
    echo "<td>".$result['list_name']."</td>";
    echo "</tr>";
}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No campaign selected $newcampsvar</div>";
}
echo "</table>";


?>

</div>
    <div id="home" class="tab-pane fade in active">


<?php

$query = $bureaupdo->prepare("select 
vicidial_users.full_name
, count(IF(vicidial_agent_log.status='SALE',1,NULL)) AS Sales
, vicidial_live_inbound_agents.calls_today AS Leads 
, (vicidial_live_inbound_agents.calls_today/count(IF(vicidial_agent_log.status='SALE',1,NULL))) As Total
, vicidial_lists.campaign_id
, vicidial_live_agents.uniqueid
, vicidial_live_agents.channel
, vicidial_live_agents.last_call_time
, vicidial_live_agents.status
, vicidial_live_agents.user
, vicidial_live_agents.pause_code
, vicidial_live_agents.last_call_finish
, vicidial_list.lead_id
, vicidial_auto_calls.phone_number
, vicidial_users.full_name
, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
from vicidial_agent_log
JOIN vicidial_users ON vicidial_users.user = vicidial_agent_log.user
JOIN vicidial_live_inbound_agents on vicidial_users.full_name = vicidial_live_inbound_agents.group_id
LEFT JOIN vicidial_live_agents ON vicidial_agent_log.user = vicidial_live_agents.user
LEFT JOIN vicidial_list on vicidial_live_agents.lead_id =vicidial_list.lead_id
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
LEFT JOIN vicidial_lists on vicidial_list.list_id = vicidial_lists.list_id
WHERE vicidial_agent_log.event_time  >= CURRENT_DATE()
AND vicidial_agent_log.campaign_id ='XREVCLO'
GROUP by vicidial_agent_log.user
ORDER BY Total DESC, Sales, Leads
LIMIT 100");

echo "<table class=\"table table-hover table-condensed\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$Sales = $result['Sales'];
$Leads = $result['Leads'];
$Total = $result['Total'];

$FormattedConversionrate = number_format($Total,1);

$Conversionrate = $Leads /$Sales;
$Formattedrate = number_format($Conversionrate,1);

 switch( $result['status'] )
    {
      case("READY"):
         $class2 = 'status_READY12';
          break;
        case("INCALL"):
          $class2 = 'status_INCALL12';
    if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class2 = 'status_MANUAL2';}
    if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class2 = 'status_DEAD2';}
elseif ($result['campaign_id'] =='REVIEW' && $result['lead_id']>'1') {$result['status'] = 'TRANSFER'; $class2 = 'status_piltrans';}

           break;
       case("PAUSED"):
            $class2 = 'status_PAUSED12';
          break;
       case("QUEUE"):
            $class2 = 'status_QUEUE2';
          break;
        default:
            $class2 = 'status_READY12';
            break;
 }
    echo '<td class='.$class2.'><center>'.$result['full_name'].' <br> '.$result['Time'].' <br>'.$Leads.'/'.$Sales.' - '.$FormattedConversionrate.'</center>';
    echo "</td>";

}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No stats found for conversion rate</div>";
}
echo "</table>";

?>

<?php

$query = $bureaupdo->prepare("select  vicidial_users.full_name, vicidial_auto_calls.status, vicidial_auto_calls.campaign_id from vicidial_auto_calls
JOIN vicidial_list on vicidial_auto_calls.lead_id = vicidial_list.lead_id
JOIN vicidial_users on vicidial_users.user = vicidial_list.user
where vicidial_auto_calls.status = 'live' AND vicidial_auto_calls.call_type = 'IN'");

echo "<table class=\"table table-hover table-condensed\" >";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['status'] )
    {

        case("LIVE"):
          $class = 'status_LEAD';
    if ($result['status']='LIVE') {$result['status'] = 'LEAD'; $class = 'status_LEAD';}
           break;
      
 }

    echo "<div class=\"alert alert-warning text-center\" role=\"alert\"><strong> ".$result['full_name']." ".$result['status']." FOR ".$result['campaign_id']."</strong></div>";

}
} else {
    echo "<div class=\"alert alert-warning text-center\" role=\"alert\"><strong>Waiting for leads!</strong></div>";
}
echo "</table>";

?>

<?php

$newclocampvar = "%XREVCLO%";

$query = $bureaupdo->prepare("SELECT COUNT(list_id) AS Lists FROM vicidial_lists  WHERE campaign_id LIKE :campsplaceholder AND active = 'Y' LIMIT 1 UNION ALL
SELECT dialable_leads FROM vicidial_campaign_stats WHERE campaign_id LIKE :campsplaceholder LIMIT 1  UNION ALL
SELECT COUNT(status) AS Hopper from vicidial_hopper where campaign_id LIKE :campsplaceholder LIMIT 1 UNION ALL
SELECT auto_dial_level FROM vicidial_campaigns WHERE active = 'Y' and campaign_id LIKE :campsplaceholder LIMIT 1 UNION ALL
SELECT COUNT(phone_number) AS Numbers from vicidial_auto_calls where status LIKE 'sent' UNION ALL
SELECT drops_answers_today_pct from vicidial_campaign_stats where campaign_id LIKE :campsplaceholder LIMIT 1 UNION ALL
SELECT COUNT(status) AS Incoming from vicidial_auto_calls where status LIKE 'live' AND call_type = 'OUT' UNION ALL
SELECT COUNT(status) from vicidial_live_agents WHERE campaign_id LIKE :campsplaceholder and status ='INCALL' UNION ALL
SELECT COUNT(status) from vicidial_live_agents WHERE campaign_id LIKE :campsplaceholder and status ='READY'  UNION ALL
SELECT COUNT(status) from vicidial_live_agents WHERE campaign_id LIKE :campsplaceholder and status ='PAUSED'  UNION ALL
SELECT LEFT(disk_usage,5) from servers where server_ip = :serveripplaceholder");

$query->bindParam(':campsplaceholder', $camps, PDO::PARAM_STR, 12);
$query->bindParam(':serveripplaceholder', $serverip, PDO::PARAM_STR, 12);
$query->bindParam(':closercampplaceholder', $newclocampvar, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover table-condensed\">";

echo 
	"<thead>
	<tr>
	<th colspan=42><a href='http://$serverip/vicidial/admin.php?ADD=31&campaign_id=$camps' target='_blank'>Campaign Statistics </a></th>
	</tr>
	<tr>
	<td>Active Lists</td>
	<td>Dialable Leads</td>
	<td>Hopper</td>
	<td>Dial Level</td>
	<td>Calls In Progress</td>
	<td>Drop %</td>
	<td>Calls Waiting</td>
	<td>In Call</td>
	<td>Ready</td>
	<td>Paused</td>
	<td>DF</td>
	</tr>
	</thead>";
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	echo "<th>".$result["Lists"]."</th>";
    }
} else {
	echo "<div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";

?>

            <div class="col-md-4">
        <div id="dialstatus"></div>
            </div>
            <div class="col-md-4">
        <div id="sip_hangup_cause"></div>
            </div>
            <div class="col-md-4">
        <div id="reason"></div>
            </div>

<?php

$newugvar = "%$ug%";

$query = $bureaupdo->prepare("SELECT DISTINCT vicidial_live_agents.conf_exten, vicidial_live_agents.comments, vicidial_live_agents.uniqueid, vicidial_users.user, vicidial_auto_calls.phone_number, vicidial_auto_calls.lead_id, vicidial_live_agents.last_call_time, vicidial_live_agents.status, vicidial_live_agents.extension, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.last_call_finish, vicidial_live_agents.last_state_change, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time, CURTIME() AS nowtimes
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id like :campsplaceholder
AND vicidial_users.user_group like :ugplaceholder 
order by vicidial_live_agents.status ASC, last_state_change LIMIT 40");

$dyn_table = '<table border="1" cellpadding="10" id="boo">';

$query->bindParam(':ugplaceholder', $newugvar, PDO::PARAM_STR, 12);
$query->bindParam(':campsplaceholder', $camps, PDO::PARAM_STR, 12);

$query->execute();
if ($query->rowCount()>0) {
    $i = 0;
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];
$status=$result['status'];
$Time=$result['Time'];
$user=$result['user'];
$full_name=$result['full_name'];
$extension=$result['extension'];
$nowtime=$result['nowtimes'];

switch( $result['status'] ) {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
          break;
        case("INCALL"):
          $class = 'status_INCALL';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class = 'status_MANUAL';}
	elseif ($result['uniqueid']=='0' && $Time >='00:00:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL1';}
	elseif ($result['uniqueid']=='0' && $Time >='00:02:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL5';}
	elseif ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class = 'status_DEAD';}
	elseif ($result['comments']=='INBOUND') {$result['status'] = 'TRANSFER'; $class = 'status_trans';}
	elseif ($Time <'00:00:98' && $result['uniqueid']>'1' ) {$result['status']= 'INCALL'; $class = 'status_INCALL10';}
	elseif ($Time >='00:00:99' && $Time <'00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL1';}
	elseif ($Time >='00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL5';}
           break;
       case("PAUSED"):
            $class = 'status_PAUSED';
	if ($lead_id=='0') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED';}
	if ($lead_id<>'0') {$result['status'] = 'DISPO'; $class = 'status_DISPO';}
	elseif ($result['pause_code']=='Toilet' && $Time >'00:03:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($result['pause_code']=='50min' && $Time >'00:50:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='40min' && $Time >'00:40:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='15min' && $Time >'00:15:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='10min' && $Time >'00:10:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='Other' && $Time >'00:02:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($Time <'00:00:10' ) {$result['status']= 'PAUSED'; $class = 'status_PAUSED10';}
	elseif ($Time >='00:00:11' && $Time <='00:01:99') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED1';}
	elseif ($Time >='00:02:00') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED5';}
          break;
       case("QUEUE"):
            $class = 'status_QUEUE';
          break;
        default:
            $class = 'status_READY';
            break;
 }
	   if ($i % 4 == 0) { // if $i is divisible by our target number (in this case "3")
        $dyn_table .= '<tr><td class='.$class.'><strong style="font-size: 15px;">'.$result['full_name'].'</strong><br> '.$result['Time'].'</td>';
    } else {
        $dyn_table .= '<td class='.$class.'><strong style="font-size: 15px;">'.$result['full_name'].' </strong><br>'.$result['Time'].'</td>';
    }
    $i++;
}
$dyn_table .= '</tr></table>';
} //else {
  //  echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
//}
echo $dyn_table;

?>
</div>


<!--HOPPER-->

    <div id="menu1" class="tab-pane fade">

<?php

$query = $bureaupdo->prepare("select vicidial_hopper.lead_id,
phone_number,
vicidial_list.status,
called_count,
vicidial_hopper.list_id,
hopper_id
from vicidial_hopper,
vicidial_list where vicidial_hopper.campaign_id LIKE :campsplaceholder and vicidial_hopper.status='READY' and vicidial_hopper.lead_id=vicidial_list.lead_id order by priority desc,hopper_id limit 5000");

$query->bindParam(':campsplaceholder', $camps, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover table-condensed\" >";

echo 
	"<thead>
	<tr>
	<th align=\"center\" colspan=\"6\">Hopper</th>
	</tr>
	<tr>
	<th>List ID</th>
	<th>Lead ID</th>
	<th>Phone Number</th>
	<th>Status</th>
	<th>Called Count</th>
	<th>Hopper ID</th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id  =$result['lead_id'];
$list_id  =$result['list_id'];

	echo "<td><a href='http://$serverip/vicidial/admin.php?ADD=311&list_id=" . $result['list_id'] . "'target='_blank''>$list_id</a></td>";
	echo "<td><a href='http://$serverip/vicidial/admin_modify_lead.php?lead_id=lead_id'target='_blank''>$lead_id</a></td>";
	echo "<td>".$result['phone_number']."</td>";
	echo "<td>".$result['status']."</td>";
	echo "<td>".$result['called_count']."</td>";
	echo "<td>".$result['hopper_id']."</td>";
	echo "</tr>";
}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
}
echo "</table>";

?>   

</div>

<!--HANGUP-->

    <div id="menu3" class="tab-pane fade">

<?php

$query = $bureaupdo->prepare("SELECT lead_id, hangup_cause, dialstatus, sip_hangup_cause, sip_hangup_reason from vicidial_carrier_log WHERE call_date >= NOW() - INTERVAL :carstatsplaceholder MINUTE ORDER BY dialstatus DESC");

$query->bindParam(':carstatsplaceholder', $carstats, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover table-condensed\" >";

echo 
	"<thead>
	<tr>
	<th colspan=\"5\">$carstats Minute Interval Hangup Causes</th>
	</tr>
	<tr>
	<td>Hangup Cause</td>
	<td>Dial Status</td>
	<td>SIP Hangup Cause</td>
	<td>SIP Hangup Reason</td>
	<td>Lead ID</td>
	</tr>
	</thead>";
 
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

    $hangup_cause=$result['hangup_cause'];    
    $lead_id=$result['lead_id'];

    echo "<tr>";
    echo "<td><a href='https://wiki.freeswitch.org/wiki/Hangup_Causes'>$hangup_cause</a></td>";
    echo "<td>".$result['dialstatus']."</td>";
    echo "<td>".$result['sip_hangup_cause']."</td>";
    echo "<td>".$result['sip_hangup_reason']."</td>";
    echo "<td><a href='http://$serverip/vicidial/admin_modify_lead.php?lead_id=$lead_id'target='_blank'>$lead_id</a></td>";
    echo "</tr>";
}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
}
echo "</table>";

?>  
</div>
</div>
</div>

<div id="optionsmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Real Time Report Settings</h4>
      </div>
      <div class="modal-body">
        <p><?php

$query = $bureaupdo->prepare("SELECT webserver FROM vicidial_webservers ORDER BY webserver ASC");

	echo "<form method='get'>";
	echo "<label for='serverip'>Server</label>";
	echo "<select class='form-control' name='serverip'>";
	echo "<option value='$serverip'>$serverip</option>";
	echo "<option value='Choose'>Server</option>";
	echo "<option value='bureau.bluetelecoms.com'>Bureau</option>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
echo "<option value='" . $result['webserver'] . "'>" . $result['webserver'] . "</option>";
}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
}
echo "</select>";

?>
<br>
<?php

$query = $bureaupdo->prepare("SELECT campaign_id FROM vicidial_campaigns WHERE active = 'Y' ORDER BY campaign_id ASC");

	echo "<label for='Campaign'>Campaign</label>";
	echo "<select class='form-control' name='camps'  >";
	echo "<option value='$camps'>$camps</option>";
	echo "<option value='Choose'>Campaign</option>";
	echo "<option value='%'>All</option>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
echo "<option value='" . $result['campaign_id'] . "'>" . $result['campaign_id'] . "</option>";
}
} else {
    echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
}
echo "</select>";
?>

<br>
<label for='ug'>User Group</label>
 <select class="form-control" name='ug'>
<option value="<?php echo $ug?>"><?php echo $ug?> </option>
  <option value="%">Any</option>
  <option value="Life">Life</option>
  <option value="Web">Web</option>
  <option value="Closer">Closers</option>
  <option value="PBA">PBA</option>
</select> 
<br>
<label for='carstats'>Stats Int(mins)</label>
<select class="form-control" name='carstats'>
<option value="<?php echo $carstats?>"><?php echo $carstats?> </option>
<option value='1'>1</option>
<option value='5'>5</option>
<option value='10'>10</option>
<option value='15'>15</option>
<option value='30'>30</option>
</select>
<br>
<label for='rf'>Refresh Int(secs)</label>
<select class="form-control" name='rf'>
<option value="<?php echo $rf?>"><?php echo $rf?> </option>
<option value='1'>1</option>
<option value='5'>5</option>
<option value='10'>10</option>
<option value='15'>15</option>
<option value='30'>30</option>
<option value='60'>1min</option>
</select>
<br>

<?php

$query = $bureaupdo->prepare("SELECT login FROM phones WHERE status = 'Admin'");

	echo "<label for='login'>Monitor</label>";
	echo "<select class='form-control' name='chanspy' >";
	echo "<option value='$chanspy'>$chanspy </option>";
	echo "<option value='Choose'>SIP</option>";
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	echo "<option value='" . $result['login'] . "'>" . $result['login'] . "</option>";
}
} else {
	echo "<br><br><div class=\"alert alert-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
}
	echo "</select>";
	echo "<br>";
	echo "<br>";
	echo"<button type='submit' value='Submit' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Submit</button>";
	echo "</form>";
?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable2?>);
      var options = {
           title: 'SIP Hangup Cause',
            pieHole: 0.4,
            
        };

      var chart = new google.visualization.PieChart(document.getElementById('reason'));
      chart.draw(data, options);
    }
    </script>
<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
           title: 'Dial Statuses',
            pieHole: 0.4,
            
        };

      var chart = new google.visualization.PieChart(document.getElementById('dialstatus'));
      chart.draw(data, options);
    }
    </script>

<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable1?>);
      var options = {
           title: 'SIP Hangup Reason',
            pieHole: 0.4,
            
        };

      var chart = new google.visualization.PieChart(document.getElementById('sip_hangup_cause'));
      chart.draw(data, options);
    }
    </script>
</body>
</html>
