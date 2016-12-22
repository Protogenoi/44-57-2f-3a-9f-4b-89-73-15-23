<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if($fflife=='0') {
    
    header('Location: ../CRMmain.php'); die;
    
}

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/adlfunctions.php');
include('../includes/Access_Levels.php');

      if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../CRMmain.php'); die;
} 

$dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$commdate= filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | Financials</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php include('../includes/navbar.php');
    include('../includes/adl_features.php');   
    
    if($ffanalytics=='1') {  
        include_once('../php/analyticstracking.php'); 
        
    }
    ?>
    
    <div class="container">
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Financials</a></li>
            <li><a data-toggle="pill" href="#RAW">RAW COMMS</a></li>
            <li><a data-toggle="pill" href="#EXPECTED">Expected</a></li>
            <li><a data-toggle="pill" href="#MISSING">Missing/Pending</a></li>
            <li><a data-toggle="pill" href="#POLINDATE">Policies Paid on Time</a></li>
            <li><a data-toggle="pill" href="#POLOUTDATE">Late Policies</a></li>
            <li><a data-toggle="pill" href="#COMMIN">COMMS IN</a></li>
            <li><a data-toggle="pill" href="#COMMOUT">COMMS OUT</a></li>
        </ul>
    </div>
    
    <div class="tab-content">
        
            <div id="home" class="tab-pane fade in active">
                <div class="container"> 
                    
                
                <form action=" " method="get">
                    
                    <div class="form-group">
                        <div class="col-xs-2">
                            <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM::" class="form-control" value="<?php if(isset($datefrom)) { echo $datefrom; } ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-2">
                            <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php if(isset($dateto)) { echo $dateto; } ?>" required>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <div class="col-xs-2">
                            <select class="form-control" name="commdate">
                                                 <?php
                    
                    $COM_DATE_query = $pdo->prepare("SELECT DATE(insert_date) AS insert_date FROM financial_statistics_history group by DATE(insert_date) ORDER BY insert_date DESC");
                    $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                    if ($COM_DATE_query->rowCount()>0) {
                        while ($row=$COM_DATE_query->fetch(PDO::FETCH_ASSOC)){ 
                                if(isset($row['insert_date'])) {  ?>
                                <option value="<?php echo $row['insert_date']; ?>"><?php echo $row['insert_date']; ?></option>
        
                                <?php  } }
    
}                    
                    ?>   
                            </select>
                        </div>
                        </div>       
                    
                    <div class="form-group">
                        <div class="col-xs-2">
                            <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>
                    
                    </fieldset>
                </form>                    
                
                <?php
                
                $PIPE_query = $pdo->prepare("select sum(client_policy.commission) AS pipe from client_policy LEFT JOIN financial_statistics_history ON client_policy.policy_number = financial_statistics_history.policy WHERE financial_statistics_history.policy IS NULL AND client_policy.insurer ='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
                $PIPE_query->execute()or die(print_r($PIPE_query->errorInfo(), true));
                $row_rsmyQuery=$PIPE_query->fetch(PDO::FETCH_ASSOC);
                $pipe = $row_rsmyQuery['pipe'];  
                
                if(isset($datefrom)) {
                    $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalgross
    FROM financial_statistics_history WHERE DATE(insert_date)=:commdate");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    
    
        $MISSING_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission FROM client_policy LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
        $MISSING_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $MISSING_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $MISSING_SUM_QRY->execute()or die(print_r($MISSING_SUM_QRY->errorInfo(), true));
        $MISSING_SUM_QRY_RS=$MISSING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $MISSING_SUM = $MISSING_SUM_QRY_RS['commission'];
        
        $EXPECTED_SUM_QRY = $pdo->prepare("select SUM(commission) AS commission FROM client_policy WHERE DATE(sale_date) between :datefrom AND :dateto AND insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
        $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
        $EXPECTED_SUM_QRY_RS=$EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission']; 
        
        
$POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
    $POL_ON_TM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true)); 
    $POL_ON_TM_SUM_QRY_RS=$POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
    $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS']; 
    $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS']; 
    
    $POL_NOT_TM_QRY = $pdo->prepare("select
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS        
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
    $POL_NOT_TM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true)); 
    $POL_NOT_TM_SUM_QRY_RS=$POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
    $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS']; 
    $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS']; 

    
                } else {
                    
                    $query = $pdo->prepare("SELECT SUM(CASE WHEN financial_statistics_history.payment_amount<0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalloss,
     SUM(CASE WHEN financial_statistics_history.payment_amount>=0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalgross
    FROM financial_statistics_history ");
                    
        $MISSING_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission FROM client_policy LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number WHERE client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
        $MISSING_SUM_QRY->execute()or die(print_r($MISSING_SUM_QRY->errorInfo(), true));
        $MISSING_SUM_QRY_RS=$MISSING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $MISSING_SUM = $MISSING_SUM_QRY_RS['commission'];
                    
                }
                
                ?>


<table  class="table table-hover">

<thead>

    <tr>
    <th colspan="8"><?php if(isset($datefrom)) { echo "ADL Statistics for $commdate"; } ?></th>
    </tr>
    <?php if(isset($datefrom)) { ?>
    <th>EST Expected Gross</th>
    <?php } ?>
    <th>EST Missing</th>
    <?php if(isset($datefrom)) { ?>
    <th>ADL vs RAW GROSS DIFF</th>
    <?php } ?>
    <th>EST Pipeline</th>
    </tr>
    </thead>
    
    <?php

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$totalgross = $result['totalgross'];
$totalloss = abs($result['totalloss']); 
$totalrate = "25.00";

if(isset($datefrom)) {
$totaldifference = $EXPECTED_SUM - $totalgross;
}

$totalnet = $totalgross - $totalloss;

$hwifsd = ($totalrate/100) * $totalnet ;
$netcom = $totalnet - $hwifsd;

if(isset($datefrom)) {
$formattedtotmis = number_format($totaldifference, 2);
$totalONTIME = number_format($POL_ON_TM_SUM, 2);
$totalNOTTIME = number_format($POL_NOT_TM_SUM, 2);
$totalONTIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$totalNOTTIME_LS = number_format($POL_NOT_TM_SUM_LS, 2);

}
$formattedpipe = number_format($pipe, 2);
$formattedtotalgross = number_format($totalgross, 2);
$formattedtotalloss = number_format($totalloss, 2);
$formattedtotalnet = number_format($totalnet, 2);
$formattedhwifsd = number_format($hwifsd, 2);
$formattednetcom = number_format($netcom, 2);
if(isset($datefrom)) {
$formattedexpected = number_format($EXPECTED_SUM, 2);
}
$formattedmissing = number_format($MISSING_SUM, 2);

    echo '<tr>';
    if(isset($datefrom)) {
    echo "<td>£$formattedexpected</td>";
    }
    echo "<td>£$formattedmissing</td>";
    if(isset($datefrom)) {
    echo "<td>£$formattedtotmis</td>";
    }    
    echo "<td>£$formattedpipe</td>";
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
    if(isset($datefrom)) { ?>
    
<table  class="table table-hover">

<thead>

    <tr>
    <th colspan="8"><?php if(isset($datefrom)) { echo "RAW COMMS statistics for $commdate"; } ?></th>
    </tr>
    <th>Total Gross</th> 
    <th>Total Loss</th>
    <th>Total Net</th>   
    <th>HWIFS</th> 
    <th>Net COMM</th> 
    </tr>
    </thead>
    
    <tr>
        <td><?php echo "£$formattedtotalgross"; ?></td>
        <td><?php echo "£$formattedtotalloss"; ?></td>
        <td><?php echo "£$formattedtotalnet"; ?></td>
        <td><?php echo "£$formattedhwifsd"; ?></td>
        <td><?php echo "£$formattednetcom"; ?></td>
    </tr>
    
</table>    
        
<table  class="table table-hover">

<thead>

    <tr>
    <th colspan="8"><?php if(isset($datefrom)) { echo "RAW COMMS breakdown $commdate"; } ?></th>
    </tr>
    <th>Payments on Time</th> 
    <th>Deductions on Time</th>
    <th>Late Payments</th>   
    <th>Late Deductions</th> 
    </tr>
    </thead>
    
    <tr>
        <td><?php echo "£$totalONTIME"; ?></td>
        <td><?php echo "£$totalONTIME_LS"; ?></td>
        <td><?php echo "£$totalNOTTIME"; ?></td>
        <td><?php echo "£$totalNOTTIME_LS"; ?></td>
    </tr>
    
</table>
    
<?php    }
            
                ?>
                
</table>    


                  
            </div>
        </div>
        
        <div id="RAW" class="tab-pane fade">
                <div class="container">
                    
<?php
if(isset($datefrom)){

$query = $pdo->prepare("select client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.Policy_Name, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND financial_statistics_history.policy IN(select client_policy.policy_number from client_policy) ORDER by financial_statistics_history.payment_amount DESC;");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>RAW COMMS for <?php echo "$commdate ($count records)"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['Policy_Name']."</td>";
      if (intval($row['payment_amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['payment_amount']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


}
?>                       
                    
                </div>
        </div>
            
        
            <div id="EXPECTED" class="tab-pane fade">
                <div class="container">
                <p>EXPECTED</p>
                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select id AS PID, client_id AS CID, client_name, policy_number, commission, DATE(sale_date) AS SALE_DATE
FROM client_policy
WHERE insurer='Legal and General' AND DATE(sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT like '%DU%'");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>EXPECTED for <?php echo "$commdate ($count records)"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($row['commission'])>0) {
       echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['commission']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} ?>
            </div>
        </div>
            
            <div id="MISSING" class="tab-pane fade">
                <div class="container">

                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Missing for <?php echo "$commdate ($count records)"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($row['commission'])>0) {
       echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['commission']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


}                 else{

$query = $pdo->prepare("select DATE(client_policy.sale_date) AS SALE_DATE, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' ORDER BY client_policy.commission DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Missing/Pending for <?php echo "$commdate ($count records)"; ?></th>
    </tr>
<th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td>".$row['SALE_DATE']."</td>";
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($row['commission'])>0) {
       echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['commission']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} 


?>
            </div>                
                
            </div>
            
            <div id="POLINDATE" class="tab-pane fade">
               
 <div class="container">
 <p>POLINDATE</p>
                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $commdate ($count records)"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($row['payment_amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['payment_amount']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} ?>
            </div>   

            </div> 
            
            <div id="POLOUTDATE" class="tab-pane fade">
            
<div class="container">
 <p>POLOUTDATE</p>
                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $commdate ($count records)"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($row['payment_amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['payment_amount']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} ?>
            </div>                 
                
                
            </div>   
            
            <div id="COMMIN" class="tab-pane fade">
                
<div class="container">
 <p>COMMIN</p>
                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, financial_statistics_history.policy, financial_statistics_history.payment_due_date , client_policy.client_name, client_policy.client_id from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount >= 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>COMM IN i<?php echo "with COMM date of $commdate ($count records)"; ?></th>
    </tr>
    <th>Date</th>
    <th>Client</th>
    <th>Policy</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['policy'];
$PAY_AMOUNT = number_format($row['payment_amount'], 2);

    echo '<tr>';
    echo "<td>".$row['sale_date']."</td>";
    echo "<td>".$row['client_name']."</td>";
   echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>"; 
       if (intval($PAY_AMOUNT)>0) {
       echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>"; }
       else if (intval($PAY_AMOUNT)<0) {
           echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>"; }
    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} ?>
            </div>                
                
            </div>
            
            <div id="COMMOUT" class="tab-pane fade">
  
<div class="container">
 <p>COMMOUT</p>
                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, financial_statistics_history.policy, financial_statistics_history.payment_due_date , client_policy.client_name, client_policy.client_id from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount < 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $commdate ($count records)"; ?></th>
    </tr>
    <th>Date</th>
    <th>Client</th>
    <th>Policy</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['policy'];
$PAY_AMOUNT = number_format($row['payment_amount'], 2);

    echo '<tr>';
    echo "<td>".$row['sale_date']."</td>";
    echo "<td>".$row['client_name']."</td>";
   echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>"; 
       if (intval($PAY_AMOUNT)>0) {
       echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>"; }
       else if (intval($PAY_AMOUNT)<0) {
           echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>"; }
    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


} ?>
            </div>                                
                
                
            </div>  
            
            
        </div>
        
        
        
    </div>
    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
    <script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script>

$(document).ready(function() {
   if(window.location.href.split('#').length > 1 )
      {
      $tab_to_nav_to=window.location.href.split('#')[1];
      if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
         {
         $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
         }
      }
});

</script>
    <script>
        $(function() {
            $( "#datefrom" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function() {
            $( "#dateto" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>  
</body>
</html>
