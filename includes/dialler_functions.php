<?php                            

include($_SERVER['DOCUMENT_ROOT']."/includes/DIALLER_PDO_CON.php");

function recordings_table($lead_id, $call_date, $status) {
    
    include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

                            $GETdiallerURL  = $pdo->prepare("select url from vicidial_accounts where servertype ='Database' limit 1");
                            $GETdiallerURL ->execute()or die(print_r($GETdiallerURL->errorInfo(), true));
                            $DIALLERURL=$GETdiallerURL ->fetch(PDO::FETCH_ASSOC);
                            
                            $diallerurls=$DIALLERURL['url'];
    
echo "<tr>
<td><a href='http://$diallerurls/vicidial/admin_modify_lead.php?lead_id=".$lead_id."' target='_blank'>$lead_id</a></td>
<td>".$call_date."</td>
<td>".$status."</td>";
echo "</tr>";
} //End of function definition

function new_recordings_table($lead_id, $call_date, $status) {
        
echo "<tr>
<td><a href='http://trb.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=".$lead_id."' target='_blank'>$lead_id</a></td>
<td>".$call_date."</td>
<td>".$status."</td>";
echo "</tr>";
} //End of function definition

function realtime_closer_tablesw($status, $uniqueid, $class2, $phone_number, $campaign_id, $lead_id, $full_name, $LASTSTATUS) {
switch( $status )
    {
      case("READY"):
         $class2 = 'status_READY12';
          break;
        case("INCALL"):
          $class2 = 'status_INCALL12';
	if ($uniqueid=='0') {$status = 'MANUAL'; $class2 = 'status_MANUAL2';}
	if ($phone_number<='0') {$status = 'DEAD'; $class2 = 'status_DEAD2';}
elseif ($campaign_id =='REVIEW' && $lead_id>'1') {$status = 'TRANSFER'; $class2 = 'status_piltrans';}
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
	echo "<td class='$class2'>$full_name <br> $LASTSTATUS</td>";

} //End of function definition

function realtime_leadfor_callswaiting() {
include($_SERVER['DOCUMENT_ROOT']."/includes/RealTimeCON.php");
$query = $bureaupdo->prepare("select vicidial_users.full_name, vicidial_auto_calls.status, vicidial_auto_calls.campaign_id from vicidial_auto_calls
JOIN vicidial_list on vicidial_auto_calls.lead_id = vicidial_list.lead_id
JOIN vicidial_users on vicidial_users.user = vicidial_list.user
where vicidial_auto_calls.status = 'live' AND vicidial_auto_calls.call_type = 'IN'");

echo "<table id='main2' border='1' align=\"center\" cellspacing=\"5\">";

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
	echo '<tr class='.$class.'>';
	echo "<td>".$result['full_name']." ".$result['status']." FOR ".$result['campaign_id']."</td>";
	echo "</tr>";

	echo "</table>";
}
}

$query = $bureaupdo->prepare("select status from vicidial_auto_calls where status = 'live' AND call_type = 'OUT'");

echo "<table border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['status'] )
    {
        case("LIVE"):
          $class = 'status_LEAD';
	if ($result['status']='LIVE') {$result['status'] = 'CALL WAITING'; $class = 'status_LEAD';}
           break;    
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['status']."</td>";
	echo "</tr>";
}
}
echo "</table>";
} //End of function definition

function web_agents() {
include($_SERVER['DOCUMENT_ROOT']."/includes/RealTimeCON.php");
$query = $bureaupdo->prepare("SELECT DISTINCT vicidial_live_agents.comments, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id = 'STAV'
AND vicidial_users.user_group = 'Web'
order by vicidial_live_agents.status ASC, last_state_change LIMIT 50");

echo "<table id='users' border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];

switch( $result['status'] )
    {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
          break;
        case("INCALL"):
          $class = 'status_INCALL';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class = 'status_MANUAL';}
	if ($result['uniqueid']=='0' && $Time >='00:00:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL1';}
	if ($result['uniqueid']=='0' && $Time >='00:02:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL5';}
	if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class = 'status_DEAD';}
	if ($result['comments']=='INBOUND') {$result['status'] = 'TRANSFER'; $class = 'status_trans';}
	elseif ($Time <'00:00:98' && $result['uniqueid']>'1' ) {$result['status']= 'INCALL'; $class = 'status_INCALL10';}
	elseif ($Time >='00:00:99' && $Time <'00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL1';}
	elseif ($Time >='00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL5';}
           break;
       case("PAUSED"):
            $class = 'status_PAUSED';
	if ($lead_id=='0') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED';}
	if ($lead_id<>'0') {$result['status'] = 'DISPO'; $class = 'status_DISPO';}
	if ($result['pause_code']=='Toilet' && $Time >'00:03:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
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
	echo '<tr class='.$class.'>';
	echo "<td width=40%>".$result['full_name']."</td>";
	echo "<td width=10%>".$result['status']."</td>";
	echo "<td width=10%>".$result['pause_code']."</td>";
	echo "<td width=10%>".$result['Time']."</td>";
	echo "</tr>";
}
} //else {
  //  echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
//}
echo "</table>";
} //End of function definition

//End of function definition

function Pensions_agents() {
include($_SERVER['DOCUMENT_ROOT']."/includes/PDOcondial132.php");
$query = $pdodial132->prepare("SELECT DISTINCT  vicidial_live_agents.lead_id, vicidial_live_agents.comments, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, vicidial_live_agents.last_state_change, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id = 'PENAID'
order by vicidial_live_agents.status ASC, last_state_change");

echo "<table id='users' border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];

switch( $result['status'] )
    {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
          break;
        case("INCALL"):
          $class = 'status_INCALL';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class = 'status_MANUAL';}
	if ($result['uniqueid']=='0' && $Time >='00:00:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL1';}
	if ($result['uniqueid']=='0' && $Time >='00:02:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL5';}
	if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class = 'status_DEAD';}
	if ($result['comments']=='INBOUND') {$result['status'] = 'TRANSFER'; $class = 'status_trans';}
	elseif ($Time <'00:00:98' && $result['uniqueid']>'1' ) {$result['status']= 'INCALL'; $class = 'status_INCALL10';}
	elseif ($Time >='00:00:99' && $Time <'00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL1';}
	elseif ($Time >='00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL5';}
           break;
       case("PAUSED"):
            $class = 'status_PAUSED';
	if ($lead_id=='0') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED';}
	if ($lead_id<>'0') {$result['status'] = 'DISPO'; $class = 'status_DISPO';}
	if ($result['pause_code']=='Toilet' && $Time >'00:03:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
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
	echo '<tr class='.$class.'>';
	echo "<td width=40%>".$result['full_name']."</td>";
	echo "<td width=10%>".$result['status']."</td>";
	echo "<td width=10%>".$result['pause_code']."</td>";
	echo "<td width=10%>".$result['Time']."</td>";
	echo "</tr>";
}
} //else {
   // echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
//}
echo "</table>";
}

function review_agents() {
include($_SERVER['DOCUMENT_ROOT']."/includes/RealTimeCON.php");
$query = $bureaupdo->prepare("SELECT DISTINCT vicidial_live_agents.comments, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id = 'Review'
order by vicidial_live_agents.status ASC, last_state_change");


echo "<table id='users' border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];


 switch( $result['status'] )
    {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
          break;
        case("INCALL"):
          $class = 'status_INCALL';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class = 'status_MANUAL';}
	if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class = 'status_DEAD';}
	if ($result['comments']=='INBOUND') {$result['status'] = 'TRANSFER'; $class = 'status_trans';}
	elseif ($Time <'00:00:98' && $result['uniqueid']>'1' ) {$result['status']= 'INCALL'; $class = 'status_INCALL10';}
	elseif ($Time >='00:00:99' && $Time <'00:02:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL1';}
	elseif ($Time >='00:02:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL5';}
           break;
       case("PAUSED"):
            $class = 'status_PAUSED';
	if ($lead_id=='0') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED';}
	if ($lead_id<>'0') {$result['status'] = 'DISPO'; $class = 'status_DISPO';}
	if ($result['pause_code']=='Toilet' && $Time >'00:03:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($result['pause_code']=='50min' && $Time >'00:50:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='40min' && $Time >'00:40:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='15min' && $Time >'00:15:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='10min' && $Time >'00:10:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='Other' && $Time >'00:02:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
        elseif ($result['pause_code']=='Login' && $Time >'00:00:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($Time <'00:00:10' ) {$result['status']= 'PAUSED'; $class = 'status_PAUSED10';}
	elseif ($Time >='00:00:10' && $Time <='00:01:99') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED1';}
	elseif ($Time >='00:02:00') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED5';}
          break;
       case("QUEUE"):
            $class = 'status_QUEUE';
          break;
        default:
            $class = 'status_READY';
            break;
 }
	echo '<tr class='.$class.'>';
	echo "<td width=40%>".$result['full_name']."</td>";
	echo "<td width=10%>".$result['status']."</td>";
	echo "<td width=10%>".$result['pause_code']."</td>";
	echo "<td width=10%>".$result['Time']."</td>";
	echo "</tr>";
}
} //else {
   // echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
//}
echo "</table>";
} //End of function definition

function dial132_lead_for_nathan() {
include($_SERVER['DOCUMENT_ROOT']."/includes/PDOcondial132.php");
$query = $pdodial132->prepare("select status from vicidial_auto_calls where status = 'live' AND call_type = 'IN'");

echo "<table border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['status'] )
    {
        case("LIVE"):
          $class2 = 'status_nathan_transfer';
	if ($result['status']='LIVE') {$result['status'] = 'Incoming Transfer <br> Live Transfer Leads <br> Incoming Transfer'; $class2 = 'status_nathan_transfer';}
           break;    
 }
	echo '<tr class='.$class2.'>';
	echo "<td>".$result['status']."</td>";
	echo "</tr>";
}
}
echo "</table>";
} //End of function definition

function phil_agents() {
include($_SERVER['DOCUMENT_ROOT']."/includes/PDOcondial132.php");
$query = $pdodial132->prepare("SELECT DISTINCT vicidial_live_agents.comments, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, vicidial_live_agents.last_state_change, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id = 'PhilPen'
AND vicidial_users.user_group = 'Philippines'
order by vicidial_live_agents.status ASC, last_state_change");

echo "<table id='users' border='1' align=\"center\" cellspacing=\"5\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];

switch( $result['status'] )
    {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
          break;
        case("INCALL"):
          $class = 'status_INCALL';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class = 'status_MANUAL';}
	if ($result['uniqueid']=='0' && $Time >='00:00:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL1';}
	if ($result['uniqueid']=='0' && $Time >='00:02:99') {$result['status'] = 'MANUAL'; $class = 'status_INCALL5';}
	if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class = 'status_DEAD';}
	if ($result['comments']=='INBOUND') {$result['status'] = 'TRANSFER'; $class = 'status_trans';}
	elseif ($Time <'00:00:98' && $result['uniqueid']>'1' ) {$result['status']= 'INCALL'; $class = 'status_INCALL10';}
	elseif ($Time >='00:00:99' && $Time <'00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL1';}
	elseif ($Time >='00:04:99' && $result['uniqueid']>'1') {$result['status'] = 'INCALL'; $class = 'status_INCALL5';}
           break;
       case("PAUSED"):
            $class = 'status_PAUSED';
	if ($lead_id=='0') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED';}
	if ($lead_id<>'0') {$result['status'] = 'DISPO'; $class = 'status_DISPO';}
	if ($result['pause_code']=='Toilet' && $Time >'00:03:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($result['pause_code']=='50min' && $Time >'00:50:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='40min' && $Time >'00:40:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='15min' && $Time >'00:15:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='10min' && $Time >'00:10:01') {$result['status'] = 'LATE'; $class = 'status_LATE';}
	elseif ($result['pause_code']=='Other' && $Time >'00:02:99') {$result['status'] = 'MIA'; $class = 'status_AWOL';}
	elseif ($Time <'00:00:98' ) {$result['status']= 'PAUSED'; $class = 'status_PAUSED10';}
	elseif ($Time >='00:00:99' && $Time <='00:01:99') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED1';}
	elseif ($Time >='00:02:00') {$result['status'] = 'PAUSED'; $class = 'status_PAUSED5';}
          break;
       case("QUEUE"):
            $class = 'status_QUEUE';
          break;
        default:
            $class = 'status_READY';
            break;
 }
	echo '<tr class='.$class.'>';
	echo "<td width=40%>".$result['full_name']."</td>";
	echo "<td width=10%>".$result['status']."</td>";
	echo "<td width=10%>".$result['pause_code']."</td>";
	echo "<td width=10%>".$result['Time']."</td>";
	echo "</tr>";
}
} //else {
   // echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data found</div>";
//}
echo "</table>";
}

function phil_transfers($newdate,$limit_var) {
    
                                $GETdiallerURL  = $pdo->prepare("select url from vicidial_accounts where servertype ='Database' limit 1");
                            $GETdiallerURL ->execute()or die(print_r($GETdiallerURL->errorInfo(), true));
                            $DIALLERURL=$GETdiallerURL ->fetch(PDO::FETCH_ASSOC);
                            
                            $diallerurls=$DIALLERURL['url'];

    
    if(!(in_array($limit_var,array('1','5','10','25','50','100','200'))))
    {
        $limit_var=25;
    }
    
    include($_SERVER['DOCUMENT_ROOT']."/includes/RealTimeCON.php");
    
    $query = $pdodial132->prepare("SELECT recording_log.lead_id, recording_log.user, recording_log.location AS Recording, recording_log.end_time
FROM recording_log 
LEFT JOIN vicidial_list
ON vicidial_list.lead_id = recording_log.lead_id 
LEFT JOIN vicidial_lists
on vicidial_lists.list_id=vicidial_list.list_id
WHERE recording_log.start_time like :date
AND vicidial_lists.campaign_id='PhilPen'
AND vicidial_list.status='SALE'
 GROUP by vicidial_list.lead_id 
ORDER BY start_time DESC
LIMIT $limit_var");
                $query->bindParam(':date', $newdate, PDO::PARAM_STR, 100);

    $query->execute();


echo "<table class=\"table table-hover \" >";

echo "  <thead>
	<tr>
	<th colspan= 7>Transferred Leads</th>
	</tr>
    <tr>
    <th>Time</th>
	<th>Lead ID</th>
	<th>Download</th>
	</tr>
	</thead>";

while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];


    echo '<tr class='.$class.'>';
	echo "<td>".$result['end_time']."</td>";
        echo "<td><a href='http://$diallerurls/vicidial/admin_modify_lead.php?lead_id=" . $result['lead_id'] . "'target='_blank' class='hyperblack'>$lead_id</a></td>";
        echo "<td><a href='" . $result['Recording'] . "'><font color='Black'> Download </font></a></td>";
	echo "</tr>";
	echo "\n";
    
}
echo "</table>";

    
}
//END OF FUNCTION

function transferred_leads($newdate,$limit_var) {
    
                                    $GETdiallerURL  = $pdo->prepare("select url from vicidial_accounts where servertype ='Database' limit 1");
                            $GETdiallerURL ->execute()or die(print_r($GETdiallerURL->errorInfo(), true));
                            $DIALLERURL=$GETdiallerURL ->fetch(PDO::FETCH_ASSOC);
                            
                            $diallerurls=$DIALLERURL['url'];

    
    if(!(in_array($limit_var,array('1','5','10','25','50','100','200'))))
    {
        $limit_var=25;
    }
    
    include($_SERVER['DOCUMENT_ROOT']."/includes/RealTimeCON.php");
    
    
    $query = $pdodial132->prepare("select vicidial_users.full_name, vicidial_users.user, vicidial_agent_log.event_time, vicidial_agent_log.lead_id, vicidial_list.comments AS COMS from vicidial_list 
        JOIN vicidial_users
        ON vicidial_list.user=vicidial_users.user
        JOIN vicidial_agent_log
        on vicidial_agent_log.lead_id=vicidial_list.lead_id
        WHERE vicidial_list.phone_number = '441134199997' 
        AND (vicidial_agent_log.event_time like :date  
        AND vicidial_agent_log.campaign_id = 'PENAID')
        GROUP BY vicidial_list.lead_id
        ORDER BY event_time DESC
        LIMIT $limit_var");
    $query->bindParam(':date', $newdate, PDO::PARAM_STR, 100);
    $query->execute();
    $query->execute();


echo "<table class=\"table table-hover \" >";

echo "  <thead>
	<tr>
	<th colspan= 7>Leads Transferred</th>
	</tr>
    <tr>
	<th>Time</th>
	<th>Lead ID</th>
	<th>User</th>
	<th>Comments</th>
	</tr>
	</thead>";

while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$lead_id=$result['lead_id'];
$list_id=$result['list_id'];
$full_name=$result['full_name'];


    echo '<tr class='.$class.'>';
	echo "<td>".$result['event_time']."</td>";
$TempLocation132=explode( '/', $result['lead_id'] );

	echo "<td><a href='http://$diallerurls/vicidial/admin_modify_lead.php?lead_id=" . $result['lead_id'] . "'target='_blank' class='hyperblack'>".$TempLocation3[2]." $lead_id ".$TempLocation12[5]."</a></td>";
$TempLocation1131=explode( '/', $result['full_name'] );
	echo "<td><a href='http://$diallerurls/vicidial/admin.php?ADD=3&user=" . $result['user'] . "'target='_blank' class='hyperblack'>".$TempLocation1131[2]." $full_name ".$TempLocation1131[5]."</a></td>";
	echo "<td>".$result['COMS']."</td>";
	echo "</tr>";
	echo "\n";
    
}
echo "</table>";

    
}
//END OF FUNCTION