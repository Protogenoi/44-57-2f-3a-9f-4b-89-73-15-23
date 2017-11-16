<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

$test= filter_input(INPUT_GET, 'test', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Real Time Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/styles/realtimereport.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="icon" type="/image/x-icon" href="/img/favicon.ico"  />
<style>
    @import url('http://getbootstrap.com/dist/css/bootstrap.css');
 html, body, .container-table {
    height: 100%;
}
.container-table {
    display: table;
    
}
    .container{
        width: 95% !important;
    }
.vertical-center-row {
    display: table-cell;
    vertical-align: middle;
}
.backcolour {
    background-color:#05668d !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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

    t = setInterval(refresh_div,10000);
</script>
</head>
<body class="backcolour">
<div class="container container-table">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
<?php 
if(isset($test)){
    include("../includes/DATA_DIALLER_PDO_CON.php"); 
} else {
    include("../includes/DIALLER_PDO_CON.php");                        
}

$query = $TRB_DB_PDO->prepare("SELECT 
    vicidial_live_agents.uniqueid,
    vicidial_live_agents.status,
    vicidial_live_agents.pause_code,
    vicidial_auto_calls.phone_number,
    vicidial_users.full_name,
    TIMEDIFF(CURRENT_TIMESTAMP,
            vicidial_live_agents.last_state_change) AS Time,
    COUNT(IF(vicidial_agent_log.status = 'SALE',
        1,
        NULL)) AS Sales,
    vicidial_live_inbound_agents.calls_today AS Leads
FROM
    vicidial_agent_log
        JOIN
    vicidial_users ON vicidial_users.user = vicidial_agent_log.user
        JOIN
    vicidial_live_inbound_agents ON vicidial_users.full_name = vicidial_live_inbound_agents.group_id
        LEFT JOIN
    vicidial_live_agents ON vicidial_agent_log.user = vicidial_live_agents.user
        LEFT JOIN
    vicidial_list ON vicidial_live_agents.lead_id = vicidial_list.lead_id
        LEFT JOIN
    vicidial_auto_calls ON vicidial_live_agents.lead_id = vicidial_auto_calls.lead_id
        LEFT JOIN
    vicidial_lists ON vicidial_list.list_id = vicidial_lists.list_id
WHERE
    DATE(vicidial_agent_log.event_time) = CURDATE()
        AND vicidial_agent_log.campaign_id IN ('15' , '36') AND vicidial_users.full_name !='Michael'
GROUP BY vicidial_agent_log.user
ORDER BY vicidial_live_agents.status ASC , last_state_change LIMIT 10");

echo "<table id='main2' cellspacing='0' cellpadding='10'>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$Sales = $result['Sales'];
$Leads = $result['Leads'];
$CLOSER_NAME=$result['full_name'];

switch ($CLOSER_NAME) {
    case("Matt"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;
        break;
    case("Richard"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;        
        break;
    case("Kyle"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;
        break;
    case("Sarah"):
        $LEADS = $Leads - 0;
        $SALES = $Sales - 0;
        break; 
    case("Gavin"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;    
        break; 
    case("James"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;    
        break; 
    case("Ricky"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;       
        break; 
        case("Stavros"):
        $LEADS = $Leads - 0;
        $SALES = $Sales - 0;       
        break; 
    case("Hayley"):
        $LEADS = $Leads - 0;
        $SALES = $Sales - 0;       
        break; 
    default:
        $LEADS = $Leads;
        $SALES = $Sales;
        break;
    
}
   
if($SALES=='0') {
   $Formattedrate= "0.0";
} else {
    $Conversionrate = $LEADS /$SALES;
    $Formattedrate = number_format($Conversionrate,1);
}


 switch( $result['status'] )
    {
      case("READY"):
         $class2 = 'status_READY12';
          break;
        case("INCALL"):
          $class2 = 'status_INCALL12';
	if ($result['uniqueid']=='0') {$result['status'] = 'MANUAL'; $class2 = 'status_MANUAL2';}
	if ($result['phone_number']<='0') {$result['status'] = 'DEAD'; $class2 = 'status_DEAD2';}
elseif ($result['campaign_id'] =='10' && $result['lead_id']>'1') {$result['status'] = 'TRANSFER'; $class2 = 'status_piltrans';}
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
	echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$CLOSER_NAME.' <br>'.$LEADS.'/'.$SALES.'<br>'.$Formattedrate.'</strong></td>';

}
} 
echo "</table>";

$STAT_QRY = $TRB_DB_PDO->prepare("SELECT 
    vicidial_users.full_name,
    COUNT(IF(vicidial_agent_log.status = 'QML',
        1,
        NULL)) AS QML,
    COUNT(IF(vicidial_agent_log.status = 'QQQ',
        1,
        NULL)) AS QQQ,
    COUNT(IF(vicidial_agent_log.status = 'QCBK',
        1,
        NULL)) AS QCBK,
    COUNT(IF(vicidial_agent_log.status = 'DIDNO',
        1,
        NULL)) AS DIDNO,
    COUNT(IF(vicidial_agent_log.status = 'QNQ',
        1,
        NULL)) AS QNQ,
    COUNT(IF(vicidial_agent_log.status = 'QUN',
        1,
        NULL)) AS QUN,
    COUNT(IF(vicidial_agent_log.status = 'QDE'
            OR vicidial_agent_log.status = 'DEC',
        1,
        NULL)) AS QDE,
    COUNT(IF(vicidial_agent_log.status = 'NoCard',
        1,
        NULL)) AS NoCard,
    COUNT(IF(vicidial_agent_log.status = 'SALE',
        1,
        NULL)) AS Sales,
    COUNT(IF(vicidial_agent_log.status NOT IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'QNQ',
            'DIDNO',
            'QCBK',
            'QQQ',
            'QML'),
        1,
        NULL)) AS Other
FROM
    vicidial_agent_log
        JOIN
    vicidial_users ON vicidial_agent_log.user = vicidial_users.user
WHERE
    vicidial_agent_log.user_group IN ('LifeCloser' , 'TRBUpSells')
        AND vicidial_agent_log.event_time > DATE(NOW())
GROUP BY vicidial_agent_log.user
ORDER BY vicidial_users.full_name;");

echo "<table id='main2' cellspacing='0' cellpadding='10'>
<th class='status_PAUSED'>Closer</th>
<th class='status_PAUSED'>Sales</th>
<th class='status_PAUSED'>Quote Mortgage Lead</th>
<th class='status_PAUSED'>Quoted</th>
<th class='status_PAUSED'>Quote Callback</th>
<th class='status_PAUSED'>Didn't Beat</th>
<th class='status_PAUSED'>No Quote</th>
<th class='status_PAUSED'>Underwritten</th>
<th class='status_PAUSED'>Decline</th>
<th class='status_PAUSED'>No Card</th>
<th class='status_PAUSED'>Other</th>";
    
$STAT_QRY->execute();
if ($STAT_QRY->rowCount()>0) {
while ($STAT_result=$STAT_QRY->fetch(PDO::FETCH_ASSOC)){

    $QML = $STAT_result['QML'];
    $QQQ = $STAT_result['QQQ'];
    $QCBK = $STAT_result['QCBK'];
    $DIDNO = $STAT_result['DIDNO'];
    $QNQ = $STAT_result['QNQ'];
    $QUN = $STAT_result['QUN'];
    $QDE = $STAT_result['QDE'];
    $NoCard = $STAT_result['NoCard'];
    $OTHER = $STAT_result['Other'];

$Sales = $STAT_result['Sales'];
$Leads = $STAT_result['Leads'];
$CLOSER_NAME=$STAT_result['full_name'];

switch ($CLOSER_NAME) {
    case("Matt"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;
        break;
    case("Richard"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;        
        break;
    case("Kyle"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;
        break;
    case("Sarah"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;
        break; 
    case("Gavin"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;    
        break; 
    case("James"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;         
        break; 
    case("Ricky"):
        $LEADS = $Leads - 0;
        $SALES = $Sales + 0;       
        break; 
    default:
        $LEADS = $Leads;
        $SALES = $Sales;
        break;
    
}

	echo '<tr><td class="status_PAUSED12"><strong style="font-size: 50px;">'.$CLOSER_NAME.' </strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$SALES.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QML.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QQQ.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QCBK.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$DIDNO.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QNQ.'</strong></td><';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QUN.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$QDE.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$NoCard.'</strong></td>';
        echo '<td class='.$class2.'><strong style="font-size: 50px;">'.$OTHER.'</strong></td>';

}
} 
echo "</table>";
 
?>
        </div>
    </div>
</div>
</body>
</html>
