<?php
$timecheck = date("H:i");
$start = "10:00";
$end = "21:00";
        
if($timecheck >= $start  && $timecheck <= $end ) {
            
        }
        
        else {
        
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dialler | Timecheck</title>

<META HTTP-EQUIV="refresh" CONTENT="5"; >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <style>
        .vertical-center {
  min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
  min-height: 100vh; /* These two lines are counted as one :-)       */

  display: flex;
  align-items: center;
}
.backcolour {
    background-color:#05668d !important;
}
</style>
    </head>
    <body class="backcolour">
        <div class="jumbotron vertical-center backcolour">
        <div class="container">
        
        
        
        <div class="alert alert-info">
        <center>
        <i class="fa  fa-clock-o fa-5x"></i>
        <br>
  <strong>Dialler <?php echo "Login at 10:00, the time is now $timecheck";?></strong></center></div>
  </div>
  </div>
</body>
</html>

<?php


        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Real Time Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="../styles/realtimereport.css" type="text/css" />
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="icon" type="../image/x-icon" href="/img/favicon.ico"  />
<style>
.status_piltrans {color: white; background: #551A8B; }
</style>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script>
    function refresh_div() {
        jQuery.ajax({
            url:' ',
            type:'POST',
            success:function(results) {
                jQuery(".container").html(results);
            }
        });
    }

    t = setInterval(refresh_div,9000);
</script>
</head>
<body>
<?php 

include($_SERVER['DOCUMENT_ROOT']."/includes/DIALLER_PDO_CON.php");

?>

  <div class="container">


<?php

$query = $TRB_DB_PDO->prepare("select 
vicidial_users.full_name
, vicidial_live_agents.uniqueid
, vicidial_live_agents.status
, vicidial_live_agents.lead_id
, vicidial_live_agents.pause_code
, vicidial_auto_calls.phone_number
, vicidial_users.full_name
, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
from vicidial_agent_log
JOIN vicidial_users ON vicidial_users.user = vicidial_agent_log.user
JOIN vicidial_live_inbound_agents on vicidial_users.full_name = vicidial_live_inbound_agents.group_id
JOIN vicidial_live_agents ON vicidial_agent_log.user = vicidial_live_agents.user
LEFT JOIN vicidial_list on vicidial_live_agents.lead_id =vicidial_list.lead_id
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
LEFT JOIN vicidial_lists on vicidial_list.list_id = vicidial_lists.list_id
WHERE vicidial_agent_log.event_time >= CURRENT_DATE()
AND vicidial_agent_log.campaign_id ='15'
GROUP by vicidial_agent_log.user
order by vicidial_live_agents.campaign_id ASC, vicidial_live_agents.status ASC,
last_state_change
 limit 10
;");

echo "<table id='main2' border='1' align=\"center\">";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status = $result['status'];
$uniqueid = $result['uniqueid'];
$phone_number = $result['phone_number']; 
$campaign_id = $result['campaign_id'];
$lead_id = $result['lead_id'];
$full_name =$result['full_name'];

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


}
} //else {
   // echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No stats found for conversion rate</div>";
//}
echo "</table>";


$qlead = $TRB_DB_PDO->prepare("select vicidial_users.full_name, vicidial_auto_calls.status, vicidial_auto_calls.campaign_id from vicidial_auto_calls
JOIN vicidial_list on vicidial_auto_calls.lead_id = vicidial_list.lead_id
JOIN vicidial_users on vicidial_users.user = vicidial_list.user
where vicidial_auto_calls.status = 'live' AND vicidial_auto_calls.call_type = 'IN'");

echo "<table id='main2' border='1' align=\"center\" cellspacing=\"5\">";

$qlead->execute();
if ($qlead->rowCount()>0) {
while ($result=$qlead->fetch(PDO::FETCH_ASSOC)){

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

$PAUSEquery = $TRB_DB_PDO->prepare("SELECT count(live_agent_id) AS LIVE_AGENT_ID FROM vicidial_live_agents 
WHERE campaign_id IN ('10','STAV')
AND status ='PAUSED' or status = 'DISPO'");
$PAUSEquery->execute();
$PAUSEresult=$PAUSEquery->fetch(PDO::FETCH_ASSOC);

$PAUSEDCOUNT=$PAUSEresult['LIVE_AGENT_ID'];

$PAUSED_AGENTS_query = $TRB_DB_PDO->prepare("SELECT DISTINCT vicidial_live_agents.comments, vicidial_live_agents.lead_id, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id IN ('10','STAV')
AND vicidial_live_agents.status ='PAUSED' or vicidial_live_agents.status = 'DISPO'
order by vicidial_live_agents.status, last_state_change");


$PAUSE_TABLE = '<table cellspacing="0"  cellpadding="10" id="boo">';

$PAUSED_AGENTS_query->execute();
if ($PAUSED_AGENTS_query->rowCount()>0) {
    
    ?>
      
            <div class="row">
                <div class="col-sm-12">
                    <strong><center><h2 style="color:white;">[ <i class="fa fa-pause"></i> <?php echo $PAUSEDCOUNT; ?> PAUSED AGENT<?php if($PAUSEDCOUNT>='2') { echo "S"; } ?> ]</h2></center></strong>
                </div>
      </div>  
      
      <?php
    
    $ii = 0;
while ($result=$PAUSED_AGENTS_query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];

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
        elseif ($result['pause_code']=='1hr' && $Time >'00:59:99') {$result['status'] = 'LATE'; $class = 'status_LATE';}
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
 
 switch($result['pause_code']) {
     
     case"Toilet";
         $PAUSE_CODE_I_CLASS="fa-briefcase ";
         break;
          case"Train";
         $PAUSE_CODE_I_CLASS="fa-book ";
         break;
     case"1hr";
     case"50min";
         case"40min";
             case"15min";
                 case"10min";
         $PAUSE_CODE_I_CLASS="fa-coffee";
         break;
     case"LOGIN";
         case"Login";
         $PAUSE_CODE_I_CLASS="fa-user";         
         break;
     case"Callba";
         $PAUSE_CODE_I_CLASS="fa-calendar-check-o"; 
         break;
     default;
         $PAUSE_CODE_I_CLASS="fa-pause";
         break;
     
     
 }
	   if ($ii % 5 == 0) { 
        $PAUSE_TABLE .= '<tr><td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    } else {
        $PAUSE_TABLE .= '<td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].' </strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    }
    $ii++;
}
$PAUSE_TABLE .= '</tr></table>';
} 
echo $PAUSE_TABLE;
?>
<!--

$DATE_SUB_1=date('Y-m-d') .' ' . "0:00:01";
$DATE_SUB_2=date('Y-m-d').' ' . "23:59:59";



$SUB_STATUS_query = $TRB_DB_PDO->prepare("SELECT 
vicidial_users.full_name,
count(vicidial_agent_log.sub_status) AS TOILET_COUNT,
sum(vicidial_agent_log.pause_sec) AS TOILET_TIME
from vicidial_agent_log
JOIN vicidial_users on vicidial_agent_log.user = vicidial_users.user
where vicidial_agent_log.sub_status='Toilet' 
and vicidial_agent_log.event_time >= :DATE_SUB_1  
and vicidial_agent_log.event_time <= :DATE_SUB_2
GROUP BY vicidial_agent_log.user
ORDER BY TOILET_COUNT DESC
LIMIT 5");
$SUB_STATUS_query->bindParam(':DATE_SUB_1', $DATE_SUB_1, PDO::PARAM_STR);   
$SUB_STATUS_query->bindParam(':DATE_SUB_2', $DATE_SUB_2, PDO::PARAM_STR);   

$SUB_STATUS_table = '<table cellspacing="0"  cellpadding="10" id="boo">';

$SUB_STATUS_query->execute();
if ($SUB_STATUS_query->rowCount()>0) {
    
    ?>
                  <div class="row">
                <div class="col-sm-12">
                    <strong><center><h2 style="color:white;">[ <i class="fa fa-pause"></i> Toilet Breaks ]</h2></center></strong>
                </div>
      </div>
      
      
    
    $ii = 0;
while ($result=$SUB_STATUS_query->fetch(PDO::FETCH_ASSOC)){

$TOILET_SEC_TIME=$result['TOILET_TIME'];    
$TOILET_TIME=gmdate("H:i:s", $TOILET_SEC_TIME);


	   if ($ii % 5 == 0) { 
        $SUB_STATUS_table .= '<tr><td class="status_PAUSED5"><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br>'.$result['TOILET_COUNT'].' ('.$TOILET_TIME.')</td>';
    } else {
        $SUB_STATUS_table .= '<td class="status_PAUSED5"><strong style="font-size: 30px;">'.$result['full_name'].' </strong><br>'.$result['TOILET_COUNT'].' ('.$TOILET_TIME.')</td>';
    }
    $ii++;
}
$SUB_STATUS_table .= '</tr></table>';
} 
echo $SUB_STATUS_table;


$DATE_SUB_1=date('Y-m-d') .' ' . "0:00:01";
$DATE_SUB_2=date('Y-m-d').' ' . "23:59:59";



$PAUSE_STATUS_query = $TRB_DB_PDO->prepare("SELECT 
vicidial_users.full_name,
sum(vicidial_agent_log.pause_sec)+SUM(vicidial_agent_log.dispo_sec)+SUM(vicidial_agent_log.dead_sec) AS Pause_Sec_TIME
from vicidial_agent_log
JOIN vicidial_users on vicidial_agent_log.user = vicidial_users.user
where campaign_id IN ('REVIEW')
and vicidial_agent_log.event_time >= :DATE_SUB_1  
and vicidial_agent_log.event_time <= :DATE_SUB_2
GROUP BY vicidial_agent_log.user
ORDER BY Pause_Sec_TIME DESC
LIMIT 5");
$PAUSE_STATUS_query->bindParam(':DATE_SUB_1', $DATE_SUB_1, PDO::PARAM_STR);   
$PAUSE_STATUS_query->bindParam(':DATE_SUB_2', $DATE_SUB_2, PDO::PARAM_STR);   

$PAUSE_STATUS_table = '<table cellspacing="0"  cellpadding="10" id="boo">';

$PAUSE_STATUS_query->execute();
if ($PAUSE_STATUS_query->rowCount()>0) {
    
    ?>
                  <div class="row">
                <div class="col-sm-12">
                    <strong><center><h2 style="color:white;">[ <i class="fa fa-pause"></i> Top 5 Pause Times 10 Camp ]</h2></center></strong>
                </div>
      </div>
      
     
    
    
    $ii = 0;
while ($result=$PAUSE_STATUS_query->fetch(PDO::FETCH_ASSOC)){

    
$Pause_Sec_TIME=$result['Pause_Sec_TIME'];  
$Pause_Sec_TIME=gmdate("H:i:s", $Pause_Sec_TIME);


	   if ($ii % 5 == 0) { 
        $PAUSE_STATUS_table .= '<tr><td class="status_PAUSED5"><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br><i class="fa fa-clock-o"></i> '.$Pause_Sec_TIME.'</td>';
    } else {
        $PAUSE_STATUS_table .= '<td class="status_PAUSED5"><strong style="font-size: 30px;"> '.$result['full_name'].' </strong><br><i class="fa fa-clock-o"></i> '.$Pause_Sec_TIME.'</td>';
    }
    $ii++;
}
$PAUSE_STATUS_table .= '</tr></table>';
} 
echo $PAUSE_STATUS_table;
?>

      
      

-->


</div>
</body>
</html>
