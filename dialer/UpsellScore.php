<?php
$test= filter_input(INPUT_GET, 'test', FILTER_SANITIZE_SPECIAL_CHARS);
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

    .container{
        width: 95%;
    }
.backcolour {
    background-color:#05668d !important;
}
table {
    border: none !important;
}
.i_color_red {
  color: red;
}
.i_color_green {
  color: #00FF00;
}
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0; }
}
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

    t = setInterval(refresh_div,7000);
</script>
</head>
<body class="backcolour">
<?php
if(isset($test)){
    include("../includes/DATA_DIALLER_PDO_CON.php"); 
} else {
    include("../includes/DIALLER_PDO_CON.php");                        
}
?>
    
    <div class="container">

<?php

$CLOSER_query = $TRB_DB_PDO->prepare("select 
vicidial_users.full_name
, vicidial_live_agents.uniqueid
, vicidial_live_agents.lead_id
, vicidial_live_agents.status
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

echo "<table id='main2' cellspacing='0' cellpadding='10'>";

$CLOSER_query->execute();
if ($CLOSER_query->rowCount()>0) {
while ($result=$CLOSER_query->fetch(PDO::FETCH_ASSOC)){

$status = $result['status'];
$uniqueid = $result['uniqueid'];
$phone_number = $result['phone_number']; 
$campaign_id = $result['campaign_id'];
$lead_id = $result['lead_id'];
$full_name =$result['full_name'];
$Time=$result['Time'];

switch( $status )
    {
      case("READY"):
         $class2 = 'status_READY12';
          break;
        case("INCALL"):
          $class2 = 'status_INCALL12';
	if ($uniqueid=='0') {$status = 'MANUAL'; $class2 = 'status_MANUAL2';}
	if ($phone_number<='0') {$status = 'DEAD'; $class2 = 'status_DEAD2';}
if ($campaign_id =='REVIEW' && $lead_id>'1') {$status = 'TRANSFER'; $class2 = 'status_piltrans';}
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
	echo "<td class='$class2'><strong style='font-size: 35px;'>$full_name</strong><br>".$result['Time']."</td>";

}
} 
echo "</table>";

$LEAD_query = $TRB_DB_PDO->prepare("select vicidial_users.full_name, vicidial_auto_calls.status, vicidial_auto_calls.campaign_id from vicidial_auto_calls
JOIN vicidial_list on vicidial_auto_calls.lead_id = vicidial_list.lead_id
JOIN vicidial_users on vicidial_users.user = vicidial_list.user
where vicidial_auto_calls.status = 'live' AND vicidial_auto_calls.call_type = 'IN'");

$LEAD_query->execute();
if ($LEAD_query->rowCount()>0) {
while ($result=$LEAD_query->fetch(PDO::FETCH_ASSOC)){

?>
      
                      <div class="row">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:white;"><i class="fa fa-arrow-circle-o-right"></i> <?php echo $result['full_name']; ?> LEAD FOR <?php echo $result['campaign_id']; ?></h1></center></strong>
                </div>
      </div>
      
      
      <?php

}
}

include('../includes/ADL_PDO_CON.php');
$NEWLEAD = $pdo->prepare("select agent from dealsheet_call ");
$NEWLEAD->execute();
if ($NEWLEAD->rowCount()>0) {
while ($result=$NEWLEAD->fetch(PDO::FETCH_ASSOC)){

?>
      
                      <div class="row blink_me">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:red;"><i class="fa fa-exclamation"></i> NEW LEAD <?php echo $result['agent']; ?></h1></center></strong>
                </div>
      </div>
      
      
      <?php

}
}



$PAUSECODE_query = $TRB_DB_PDO->prepare("SELECT pause_code, count(pause_code) AS PAUSE_CODE_COUNT FROM vicidial_live_agents WHERE pause_code !='' GROUP BY pause_code ORDER BY PAUSE_CODE_COUNT DESC LIMIT 1");
$PAUSECODE_query->execute();
$PAUSECODEresult=$PAUSECODE_query->fetch(PDO::FETCH_ASSOC);

$PAUSEDCODECOUNT=$PAUSECODEresult['PAUSE_CODE_COUNT'];
$PAUSECODE_CODE=$PAUSECODEresult['pause_code'];


if($PAUSECODE_CODE=='40min' && $PAUSEDCODECOUNT>='10') {
    
$time40=date("H:i:s");
$date40=date("Y-m-d");
$file_timeTXT40="Time.txt";
$file_dateTXT40="Date.txt";

$file_date40 = file_get_contents($file_dateTXT40);


if($date40!=$file_date40) { //clear files on next day

unlink("/home/var/www/dev.adlcrm.com/public/dialer/Time.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Time.txt");
unlink("/home/var/www/dev.adlcrm.com/public/dialer/Date.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Date.txt");    

file_put_contents($file_dateTXT40, $date40, FILE_APPEND | LOCK_EX); //Put new date and time
file_put_contents($file_timeTXT40, $time40, FILE_APPEND | LOCK_EX);

$file_time40 = file_get_contents($file_timeTXT40); // Get time

$BREAK_END40 = date("H:i:s", strtotime("+40 minutes", strtotime($file_time40))); //Get break end time

}

else {
    $file_time40 = file_get_contents($file_timeTXT40); // Get time

$BREAK_END40 = date("H:i:s", strtotime("+40 minutes", strtotime($file_time40))); //Get break end time
}

}

if($PAUSECODE_CODE=='10min' && $PAUSEDCODECOUNT>='10') {
    
$time=date("H:i:s");
$date=date("Y-m-d");
$file_timeTXT="Time10.txt";
$file_dateTXT="Date10.txt";

$file_date = file_get_contents($file_dateTXT);


if($date!=$file_date) { //clear files on next day

unlink("/home/var/www/dev.adlcrm.com/public/dialer/Time10.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Time10.txt");
unlink("/home/var/www/dev.adlcrm.com/public/dialer/Date10.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Date10.txt");    

file_put_contents($file_dateTXT, $date, FILE_APPEND | LOCK_EX); //Put new date and time
file_put_contents($file_timeTXT, $time, FILE_APPEND | LOCK_EX);

$file_time = file_get_contents($file_timeTXT); // Get time

$BREAK_END = date("H:i:s", strtotime("+10 minutes", strtotime($file_time))); //Get break end time

}

else {
    $file_time = file_get_contents($file_timeTXT); // Get time

$BREAK_END10 = date("H:i:s", strtotime("+10 minutes", strtotime($file_time))); //Get break end time
}

}

if($PAUSECODE_CODE=='15min' && $PAUSEDCODECOUNT>='10') {
    
$time=date("H:i:s");
$date=date("Y-m-d");
$file_timeTXT="Time15.txt";
$file_dateTXT="Date15.txt";

$file_date15 = file_get_contents($file_dateTXT);


if($date!=$file_date15) { //clear files on next day

unlink("/home/var/www/dev.adlcrm.com/public/dialer/Time15.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Time15.txt");
unlink("/home/var/www/dev.adlcrm.com/public/dialer/Date15.txt");
touch("/home/var/www/dev.adlcrm.com/public/dialer/Date15.txt");    

file_put_contents($file_dateTXT, $date, FILE_APPEND | LOCK_EX); //Put new date and time
file_put_contents($file_timeTXT, $time, FILE_APPEND | LOCK_EX);

$file_time15 = file_get_contents($file_timeTXT); // Get time

$BREAK_END15 = date("H:i:s", strtotime("+15 minutes", strtotime($file_time15))); //Get break end time

}

else {
    $file_time15 = file_get_contents($file_timeTXT); // Get time

$BREAK_END15 = date("H:i:s", strtotime("+15 minutes", strtotime($file_time15))); //Get break end time
}

}
    if($PAUSECODE_CODE=='40min' && $PAUSEDCODECOUNT>='10') {
?>

                      <div class="row">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:white;">[ <i class="fa fa-coffee "></i> 40min Break Ends at <?php echo $BREAK_END40;?> ]</h1></center></strong>
                </div>
      </div>
      
      <?php
}


if($PAUSECODE_CODE=='15min' && $PAUSEDCODECOUNT>='10') {
    
?>

                      <div class="row">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:white;">[ <i class="fa fa-coffee "></i> 15min Break Ends at <?php echo "$BREAK_END15";?> ]</h1></center></strong>
                </div>
      </div>
      
      <?php
} 

if($PAUSECODE_CODE=='10min' && $PAUSEDCODECOUNT>='10') {
    
?>

                      <div class="row">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:white;">[ <i class="fa fa-coffee"></i> 10min Break Ends at <?php echo $BREAK_END10;?> ]</h1></center></strong>
                </div>
      </div>
      
      <?php
} 



$query = $TRB_DB_PDO->prepare("SELECT DISTINCT vicidial_live_agents.lead_id,vicidial_live_agents.comments, vicidial_live_agents.calls_today, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id = '36'
AND vicidial_live_agents.status NOT IN('PAUSED','DISPO')
order by vicidial_live_agents.status ASC, last_state_change LIMIT 40");

$dyn_table = '<table cellspacing="0"  cellpadding="10" id="boo">';

$query->execute();
if ($query->rowCount()>0) {
    $i = 0;
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$status=$result['status'];
$Time=$result['Time'];
$lead_id=$result['lead_id'];
$calls_today=$result['calls_today'];

switch( $result['status'] ) {
      case("READY"):
         $class = 'status_READY';
	if ($Time <'00:00:98' ) {$result['status'] = 'READY'; $class = 'status_READY10';}
	elseif ($Time >='00:00:99') {$result['status'] = 'READY'; $class = 'status_READY1';}
	elseif ($Time >='00:01:99') {$result['status'] = 'READY'; $class = 'status_READY5';}
        $PAUSE_CODE_I_CLASS="fa-clock-o";
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
        $PAUSE_CODE_I_CLASS="fa-phone";
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
	   if ($i % 5 == 0) { 
        $dyn_table .= '<tr><td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br><strong style="font-size: 25px;">Calls today:  '.$calls_today.'</strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    } else {
        $dyn_table .= '<td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].' </strong><br><strong style="font-size: 25px;">Calls today:  '.$calls_today.'</strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    }
    $i++;
}
$dyn_table .= '</tr></table>';
} 
echo $dyn_table;

$PAUSEquery = $TRB_DB_PDO->prepare("SELECT count(live_agent_id) AS LIVE_AGENT_ID FROM vicidial_live_agents 
WHERE campaign_id ='36'
AND status ='PAUSED' or status = 'DISPO'");
$PAUSEquery->execute();
$PAUSEresult=$PAUSEquery->fetch(PDO::FETCH_ASSOC);

$PAUSEDCOUNT=$PAUSEresult['LIVE_AGENT_ID'];

$PAUSED_AGENTS_query = $TRB_DB_PDO->prepare("SELECT DISTINCT vicidial_live_agents.comments, vicidial_live_agents.calls_today, vicidial_live_agents.lead_id, vicidial_auto_calls.phone_number, vicidial_live_agents.status, vicidial_users.full_name, vicidial_live_agents.pause_code, vicidial_live_agents.uniqueid, TIMEDIFF(current_TIMESTAMP, vicidial_live_agents.last_state_change) as Time
FROM vicidial_live_agents 
JOIN vicidial_users on vicidial_live_agents.user = vicidial_users.user
LEFT JOIN vicidial_auto_calls on vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
WHERE vicidial_live_agents.campaign_id ='36'
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
$calls_today=$result['calls_today'];

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
        $PAUSE_TABLE .= '<tr><td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br><strong style="font-size: 25px;">Calls today:  '.$calls_today.'</strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    } else {
        $PAUSE_TABLE .= '<td class='.$class.'><strong style="font-size: 30px;">'.$result['full_name'].' </strong><br><strong style="font-size: 25px;">Calls today:  '.$calls_today.'</strong><br><i class="fa '.$PAUSE_CODE_I_CLASS.'"></i> '.$result['Time'].'</td>';
    }
    $ii++;
}
$PAUSE_TABLE .= '</tr></table>';
} 
echo $PAUSE_TABLE;

if(isset($CHECK_TOP_PAUSES)) {

$DATE_SUB_1=date('Y-m-d') .' ' . "0:00:01";
$DATE_SUB_2=date('Y-m-d').' ' . "23:59:59";


$PAUSE_STATUS_query = $TRB_DB_PDO->prepare("SELECT 
vicidial_users.full_name,
sum(vicidial_agent_log.pause_sec)+SUM(vicidial_agent_log.dispo_sec)+SUM(vicidial_agent_log.dead_sec) AS Pause_Sec_TIME
from vicidial_agent_log
JOIN vicidial_users on vicidial_agent_log.user = vicidial_users.user
where campaign_id IN ('10')
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
                    <strong><center><h2 style="color:white;">[ <i class="fa fa-pause"></i> Top 5 Pause Times ]</h2></center></strong>
                </div>
      </div>
      
      <?php
    
    $ii = 0;
while ($result=$PAUSE_STATUS_query->fetch(PDO::FETCH_ASSOC)){

    
$Pause_Sec_TIME=$result['Pause_Sec_TIME'];  
$Paused_Sec_TIME=gmdate("H:i:s", $Pause_Sec_TIME);


	   if ($ii % 5 == 0) { 
        $PAUSE_STATUS_table .= '<tr><td class="status_PAUSED5"><strong style="font-size: 30px;">'.$result['full_name'].'</strong><br><i class="fa fa-clock-o"></i> '.$Paused_Sec_TIME.'</td>';
    } else {
        $PAUSE_STATUS_table .= '<td class="status_PAUSED5"><strong style="font-size: 30px;"> '.$result['full_name'].' </strong><br><i class="fa fa-clock-o"></i> '.$Paused_Sec_TIME.'</td>';
    }
    $ii++;
}
$PAUSE_STATUS_table .= '</tr></table>';
} 
echo $PAUSE_STATUS_table;

}
?>

</div>
</body>
</html>
