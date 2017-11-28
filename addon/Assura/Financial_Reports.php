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

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if($fflife=='0') {
    
    header('Location: ../../CRMmain.php'); die;
    
}

include('../../includes/ADL_PDO_CON.php');
include('../../includes/adlfunctions.php');
include('../../includes/Access_Levels.php');
include('../../includes/adl_features.php');

      if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;
} 

if(isset($_GET["datefrom"])) $datefrom = $_GET["datefrom"];
if(isset($_GET["dateto"])) $dateto = $_GET["dateto"];


?>

<!DOCTYPE html>
<html>
    <title>Assura Financial Database</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
</head>
<body>
    
    <?php include('../../includes/navbar.php');
    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/analyticstracking.php'); 
    
    }
        ?>
    
    <div class="container">
        
        <?php
        
        $RECHECK= filter_input(INPUT_GET, 'RECHECK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($RECHECK)) {
        
        if($RECHECK=='y') {
            
            print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Policy found on recheck!</div>");
            
        }
        
        if($RECHECK=='n') {
        
            print("<div class=\"notice notice-danger\" role=\"alert\" ><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy not found on recheck!</div>");
            
    }
    
    }
               
                    $SearchByPol= filter_input(INPUT_GET, 'SearchByPol', FILTER_SANITIZE_NUMBER_INT);
                    $FINpolicy_number= filter_input(INPUT_POST, 'FINpolicy_number', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($SearchByPol)) {        
        if($SearchByPol=='1') {
            
                $FinSearchRowCount = $pdo->prepare("select policy from assura_financial_statistics where policy=:id");
    $FinSearchRowCount->bindParam(':id', $FINpolicy_number, PDO::PARAM_STR);
    $FinSearchRowCount->execute();
    $FinSearchRowCountdata=$FinSearchRowCount->fetch(PDO::FETCH_ASSOC);
     if ($count = $FinSearchRowCount->rowCount()>0) {  
            
            echo "<div class=\"notice notice-success\" role=\"alert\" id='HIDEFINFOUND'><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Policy found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEFINFOUND'>&times;</a></div>";
            
        }
       
        if ($count = $FinSearchRowCount->rowCount()<=0) {
            
          echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDEFINNOTFOUND'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Warning:</strong> Policy not found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEFINNOTFOUND'>&times;</a></div>";  
            
        
        }
        }
    }


    
    if(isset($datefrom)) {
        
        $datefromnew ="$datefrom 01:00:00";
        $datetonew= "$dateto 23:00:00"; 
        
            $unpaidamount = $pdo->prepare("select sum(assura_financial_statistics.payment_amount) AS paidtotal from assura_financial_statistics where assura_financial_statistics.payment_amount < 0 AND insert_date between :datefromholder AND :datetoholder;");
    $unpaidamount->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $unpaidamount->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);
    $unpaidamount->execute()or die(print_r($query->errorInfo(), true));
    $unpaidamounts=$unpaidamount->fetch(PDO::FETCH_ASSOC);

$unpdamount = number_format($unpaidamounts['paidtotal'], 2);

$paidamount = $pdo->prepare("select sum(assura_financial_statistics.payment_amount) AS paidtotal from assura_financial_statistics where assura_financial_statistics.payment_amount >= 0 AND insert_date between :datefromholder AND :datetoholder;");
    $paidamount->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $paidamount->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);
    $paidamount->execute()or die(print_r($query->errorInfo(), true));
    $paidamounts=$paidamount->fetch(PDO::FETCH_ASSOC);
    
    #$pdamount=$paidamounts['paidtotal'];
$pdamount = number_format($paidamounts['paidtotal'], 2);
    }
        
        ?>

        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Financial Report</a>
            </li>
            <li><a data-toggle="pill" href="#menu7">Paid Policies <span class="badge alert-warning">
                <?php $paidbadge = $pdo->query("select distinct count(policy) As badge from assura_financial_statistics where payment_amount >= 0");
            $row = $paidbadge->fetch(PDO::FETCH_ASSOC); echo htmlentities($row['badge']);?>
                    </span></a>
            </li>
            <li><a data-toggle="pill" href="#menu1">Clawback Policies <span class="badge alert-warning">
                <?php $clawbadge = $pdo->query("select distinct count(policy) As badge from assura_financial_statistics where payment_amount < 0");
            $row = $clawbadge->fetch(PDO::FETCH_ASSOC); echo htmlentities($row['badge']);?>
                    </span></a>
            </li>
            <li><a data-toggle="pill" href="#menu4">Unmatched Policies <span class="badge alert-warning">
                <?php $nomatchbadge = $pdo->query("select count(id) AS badge from assura_financial_statistics_nomatch");
            $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC); echo htmlentities($row['badge']);?>
                    </span></a>
            </li>
            </li>
            <li><a data-toggle="pill" href="#menu5">Double Clawbacks</a>
            </li>
            <li><a data-toggle="pill" href="#menu6">Unpaid Policies <span class="badge alert-warning">
                <?php $statement = $pdo->query("select count(*) AS badge FROM client_policy LEFT JOIN assura_financial_statistics on assura_financial_statistics.policy=client_policy.policy_number  WHERE  assura_financial_statistics.id IS NULL AND client_policy.insurer='Assura'");
            $row = $statement->fetch(PDO::FETCH_ASSOC); echo htmlentities($row['badge']);?>
                    </span></a>
            </li>  

            <li><a data-toggle="pill" href="#finsearch">Policy Search</a>
            <li><a data-toggle="pill" href="#menu3">Upload</a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        
        <div id="home" class="tab-pane fade in active">
            <div class="container">
<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } ?>
                
                
                <br>
                
                <form action=" " method="get">
                    
                    <div class="form-group">
                        <div class="col-xs-2">
                            <input type="text" id="datefrom" name="datefrom" placeholder="Date from:" class="form-control" value="<?php echo $datefrom ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-2">
                            <input type="text" id="dateto" name="dateto" class="form-control" placeholder="Date to" value="<?php echo $dateto ?>" required>
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
if(isset($datefrom)) { ?>
                <div class="btn-group">
                    <a href="export/ExportData.php?financialExport=paid&dateto=<?php echo $datetonew;?>&datefrom=<?php echo $datefromnew;?>" class="btn btn-success"><i class="fa fa-download"></i> Export Paid</a>
                    <a href="export/ExportData.php?financialExport=unpaid&dateto=<?php echo $datetonew;?>&datefrom=<?php echo $datefromnew;?>" class="btn btn-danger"><i class="fa fa-download"></i> Export Unpaid</a>
                </div>
<?php }

    $query = $pdo->prepare("select sum(client_policy.commission) AS pipe from client_policy LEFT JOIN assura_financial_statistics ON client_policy.policy_number = assura_financial_statistics.policy WHERE assura_financial_statistics.policy IS NULL AND client_policy.insurer='Assura'");
    $query->execute()or die(print_r($query->errorInfo(), true));
    $row_rsmyQuery=$query->fetch(PDO::FETCH_ASSOC);


$pipe = $row_rsmyQuery['pipe'];



if(isset($datefrom)) {


$query = $pdo->prepare("SELECT 
    SUM(CASE WHEN assura_financial_statistics.payment_amount < 0 THEN assura_financial_statistics.payment_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN assura_financial_statistics.payment_amount >= 0 THEN assura_financial_statistics.payment_amount ELSE 0 END) as totalgross
    FROM assura_financial_statistics WHERE insert_date between :datefromholder AND :datetoholder");
    $query->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);
    
}

else {
    
    $query = $pdo->prepare("SELECT SUM(CASE WHEN assura_financial_statistics.payment_amount<0 THEN assura_financial_statistics.payment_amount ELSE 0 END) as totalloss,
     SUM(CASE WHEN assura_financial_statistics.payment_amount>=0 THEN assura_financial_statistics.payment_amount ELSE 0 END) as totalgross
    FROM assura_financial_statistics ");
    
}


echo "<table  class=\"table table-hover\">";

echo "  <thead>

    <tr>
    <th colspan= 15>Statistics for $datefrom - $dateto</th>
    </tr>
    <th>Ret Rate</th>
    <th>HW Rate</th>
    <th>Total Gross</th>
    <th>Total Loss</th>
    <th>Total Net</th>
    <th>HWIFS Deduction</th>
    <th>Net Comm</th>
    <th>Pipeline</th>
    </tr>
    </thead>";

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$totalgross = $result['totalgross'];
$totalloss = abs($result['totalloss']); 
$totalrate = "25.00";

$totalnet = $totalgross - $totalloss;

$hwifsd = ($totalrate/100) * $totalnet ;
$netcom = $totalnet - $hwifsd;

$formattedpipe = number_format($pipe, 2);
$formattedtotalgross = number_format($totalgross, 2);
$formattedtotalloss = number_format($totalloss, 2);
$formattedtotalnet = number_format($totalnet, 2);
$formattedhwifsd = number_format($hwifsd, 2);
$formattednetcom = number_format($netcom, 2);

    echo '<tr class='.$class.'>';
    echo "<td>15%</td>";
    echo "<td>10%</td>";
    echo "<td>£$formattedtotalgross</td>";
    echo "<td>£$formattedtotalloss</td>";
    echo "<td>£$formattedtotalnet</td>";
    echo "<td>£$formattedhwifsd</td>";
    echo "<td>£$formattednetcom</td>";
    echo "<td>£$formattedpipe</td>";
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";

if(isset($datefrom)) {
    
    ?>
                
                <form class="form-vertical">
                                <div class="form-group"> 
  <div class="col-xs-2 col-lg-3">
  <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo "Total Paid £$pdamount";?>" disabled>
  </div>
</div>
               
                                <div class="form-group">
    
  <div class="col-xs-2 col-lg-3">
  <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo "Total Clawback £$unpdamount";?>" disabled>
  </div>
</div>
    </form> 
                
                <?php


$query = $pdo->prepare("SELECT assura_financial_statistics.*, client_policy.policy_number, client_policy.id AS POLID FROM assura_financial_statistics left join client_policy on assura_financial_statistics.Policy = client_policy.policy_number WHERE insert_date between :datefromholder2 and :datetoholder2 GROUP BY assura_financial_statistics.id ORDER by payment_amount DESC");
    $query->bindParam(':datefromholder2', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder2', $datetonew, PDO::PARAM_STR, 100);


echo "<table  class=\"table table-hover table-condensed\">";

echo "  <thead>

    <tr>
    <th colspan='3'>Transactions for $datefrom - $dateto</th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>Amount</th>
    </tr>
    </thead>";

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$formattedpayment = number_format($row['payment'], 2);
$formatteddeduction = number_format($row['deduction'], 2);
$clientid = $row['policy_number'];

    echo '<tr class='.$class.'>';
    echo "<td><a href='/Life/ViewPolicy.php?&policyID=".$row['POLID']."' target='_blank'>".$row['Policy']."</a></td>";
    echo "<td>".$row['Policy_Name']."</td>";
      if (intval($row['Payment_Amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['Payment_Amount']."</span></td>"; }
       else if (intval($row["Payment_Amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['Payment_Amount']."</span></td>"; }
           else {
               echo "<td>".$row['Payment_Amount']."</td>"; }


    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";

}
?>   
                
            </div>
        </div>
        
                <div id="menu7" class="tab-pane fade">   
            <div class="container">           
                
<?php

if(isset($datefrom)) {


    ?>
 
                <form class="form-vertical">
                                <div class="form-group"> 
  <div class="col-xs-2 col-lg-3">
  <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo "Total Paid £$pdamount";?>" disabled>
  </div>
</div>
    </form> 
                
                <?php
    
$query = $pdo->prepare("select assura_financial_statistics.payment_amount, client_policy.CommissionType, client_policy.sale_date, client_policy.policy_number, assura_financial_statistics.policy, assura_financial_statistics.payment_due_date , client_policy.client_name, client_policy.client_id from assura_financial_statistics LEFT JOIN client_policy on assura_financial_statistics.policy=client_policy.policy_number where assura_financial_statistics.payment_amount >= 0 AND insert_date between :datefromholder AND :datetoholder;");
    $query->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);

}

else {

$query = $pdo->prepare("select assura_financial_statistics.payment_amount, client_policy.CommissionType, client_policy.sale_date, client_policy.policy_number, assura_financial_statistics.policy, client_policy.client_name, client_policy.client_id from assura_financial_statistics LEFT JOIN client_policy on assura_financial_statistics.policy=client_policy.policy_number where assura_financial_statistics.payment_amount >= 0 group by assura_financial_statistics.policy;");
}

echo "<table class=\"table table-hover\"  >";

echo "  <thead>

    <tr>
    <th colspan= 15>PAID Policies</th>
    </tr>
    <th>Sale Date</th>
    <th>Client Name</th>
    <th>Policy</th>
    <th>Type</th>
    <th>Payment Amount</th>
    </tr>
    </thead>";

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['policy'];
$PAY_AMOUNT = number_format($row['payment_amount'], 2);

    echo '<tr class='.$class.'>';
    echo "<td>".$row['sale_date']."</td>";
    echo "<td>".$row['client_name']."</td>";
   echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>"; 
   echo "<td>".$row['CommissionType']."</td>";
       if (intval($PAY_AMOUNT)>0) {
       echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>"; }
       else if (intval($PAY_AMOUNT)<0) {
           echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>"; }
           else {
               echo "<td>$PAY_AMOUNT</td>"; }
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available (PAID Policies)</div>";
}
echo "</table>";

?>   
            </div>
        </div>
        
        <div id="menu1" class="tab-pane fade">   
            <div class="container">
<?php

if(isset($datefrom)) {
    

    ?>
 
                <form class="form-vertical">
               
                                <div class="form-group">
    
  <div class="col-xs-2 col-lg-3">
  <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo "Total Clawback £$unpdamount";?>" disabled>
  </div>
</div>
    </form> 
                <?php
 

$query = $pdo->prepare("select assura_financial_statistics.payment_amount, client_policy.CommissionType, client_policy.sale_date, client_policy.policy_number, assura_financial_statistics.policy, assura_financial_statistics.payment_due_date , client_policy.client_name, client_policy.client_id from assura_financial_statistics LEFT JOIN client_policy on assura_financial_statistics.policy=client_policy.policy_number where assura_financial_statistics.payment_amount < 0 AND insert_date between :datefromholder AND :datetoholder;");
    $query->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);

}

else {

$query = $pdo->prepare("select assura_financial_statistics.payment_amount, client_policy.CommissionType, client_policy.sale_date, client_policy.policy_number, assura_financial_statistics.policy, assura_financial_statistics.payment_due_date , client_policy.client_name, client_policy.client_id from assura_financial_statistics LEFT JOIN client_policy on assura_financial_statistics.policy=client_policy.policy_number where assura_financial_statistics.payment_amount < 0 group by assura_financial_statistics.policy;");
}

echo "<table class=\"table table-hover\"  >";

echo "  <thead>

    <tr>
    <th colspan= 15>CLAWBACK Policies</th>
    </tr>
    <th>Sale Date</th>
    <th>Client Name</th>
    <th>Policy</th>
    <th>Type</th>
    <th>Payment Due</th>
    <th>Payment Amount</th>
    </tr>
    </thead>";

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['policy'];

    echo '<tr class='.$class.'>';
    echo "<td>".$row['sale_date']."</td>";
    echo "<td>".$row['client_name']."</td>";
   echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>"; 
   echo "<td>".$row['CommissionType']."</td>";
   echo "<td>".$row['payment_due_date']."</td>";
       if (intval($row['payment_amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['payment_amount']."</span></td>"; }
           else {
               echo "<td>".$row['payment_amount']."</td>"; }
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available (Clawback Policies)</div>";
}
echo "</table>";

?>   
            </div>
        </div>
        
                <div id="menu4" class="tab-pane fade">   
            <div class="container">
<?php

$query = $pdo->prepare("select entry_date, id, policy_number, payment_type, payment_amount from financial_statistics_nomatch");
?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="15">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Payment Amount</th>
                    <th>Re-check</th>
                </thead>
<?php 
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['policy_number'];
$paytype = $row['payment_type'];
$iddd = $row['id'];

    echo '<tr class='.$class.'>'; 
    echo"<td>".$row['entry_date']."</td>";
    echo "<td>$policy</td>"; 
       if (intval($row['payment_amount'])>0) {
       echo "<td><span class=\"label label-success\">".$row['payment_amount']."</span></td>"; }
       else if (intval($row["payment_amount"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['payment_amount']."</span></td>"; }
           else {
               echo "<td>".$row['payment_amount']."</td>"; }
               echo "<td><a href='php/Financial_Recheck.php?RECHECK=y&finpolicynumber=$policy&paytype=$paytype&iddd=$iddd' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
}


?>   
                </table>
            </div>
        </div>

        
        <div id="menu5" class="tab-pane fade">
            <div class="container">
        <?php


$query = $pdo->prepare("select client_name,policy_number from client_policy where policy_number in (SELECT assura_financial_statistics.policy as policy FROM assura_financial_statistics WHERE assura_financial_statistics.Payment_Type ='X' group by assura_financial_statistics.policy having count(*) > 1)");
        
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){
        $doubbleclawbackarray[$row['policy_number']]['CLIENTINFO']['Name']=$row['client_name'];
}
}
        
        
$query = $pdo->prepare("SELECT policy,Payment_Date,Payment_Type,Payment_Due_Date,Premium_Type,Premium_Amount,Premium_Frequency,insert_date,uploader from (SELECT assura_financial_statistics.policy as policy FROM assura_financial_statistics WHERE assura_financial_statistics.Payment_Type ='X' group by assura_financial_statistics.policy having count(*) > 1) tbl1 join assura_financial_statistics using(policy)");

$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){


$doubbleclawbackarray[$row['policy']][]=$row;
}

} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}

?>
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Policy Number</th>
                            <th>Client Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($doubbleclawbackarray as $ZoVoS_polnum => $ZoVoS_data)
                        {
echo<<<ZOVOS
                         <tr onclick='$(".{$ZoVoS_polnum}").toggle();'>
                            <th>
                                {$ZoVoS_polnum}
                            </th>
                            <td>
                                {$ZoVoS_data['CLIENTINFO']['Name']}
                            </td>
                        </tr>
ZOVOS;

                                
                        foreach($ZoVoS_data as $key => $value)
                        {
                            if ($key !== 'CLIENTINFO')
                            {
                                echo '<tr class="'.$ZoVoS_polnum.' SubRow" style="display: none;">';
                                echo "<td colspan='2'>";
                                foreach ($value as $Z_type => $Z_dat)
                                {

                                    echo "<div>";
                                    if ($Z_type != 'policy')
                                    {
                                        echo "$Z_dat<br>";
                                    }
                                    echo "</div>";
                                }
                                echo "</td>";
                                echo '</tr>';
                            }
                        }
                        }
?>
                    </tbody>
                </table>
<?php
echo '<pre>';
print_r($doubbleclawbackarray);
echo '</pre>';

?>           
                
            </div>   
        </div>

                    
        <div id="menu6" class="tab-pane fade">
            <div class="container">
                
                
        <?php
        
        $unpaid = $pdo->prepare("SELECT client_policy.client_name, client_policy.client_id, client_policy.id, client_policy.policy_number
FROM client_policy
LEFT JOIN assura_financial_statistics  on assura_financial_statistics.policy=client_policy.policy_number 
WHERE  assura_financial_statistics.id IS NULL AND client_policy.insurer='Assura' "); ?>
                
                <table class="table table-hover">
                    <thead>
                       <tr>
                       <th colspan="2">Unpaid Policies</th>
                       </tr>
                       <th>Client Name</th>
                       <th>Policy Number</th>
                </thead>
<?php
$unpaid->execute()or die(print_r($unpaid->errorInfo(), true));
if ($unpaid->rowCount()>0) {
while ($row=$unpaid->fetch(PDO::FETCH_ASSOC)){



    echo '<tr class='.$class.'>';
   echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>".$row['client_name']."</a></td>";
   echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['id'] . "' target='_blank'>".$row['policy_number']."</a></td>"; 
    echo "</tr>";
    echo "\n";
    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


?>         
                </table>     
                
            </div>
                        
        </div>
        
        
        <div id="menu3" class="tab-pane fade">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <span class="glyphicon glyphicon-hdd"></span> Upload data</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload financial data</h3>
                                        
<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } ?>
                                        
                                        
                                        <form action="../../upload/Assura_Fin_Up.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" />
                                            <input type="hidden" name="Processor" value="<?php echo $hello_name?>">
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><img src="img/loading.gif" class="icon" /></center>
                    <h4>Uploading... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                </div>
            </div>
        </div>
    </div>
</div>  
            </div>
        </div>
        
        <div id="finsearch" class="tab-pane fade">            
            <div class="container">
            
                <form class="form-inline" method="POST" action="Financial_Reports.php?SearchByPol=1#finsearch">
<fieldset>

<legend>Search Financials by Policy Number</legend>

<div class="form-group">
   
  <div class="col-xs-2 col-lg-3">
  <input id="policy_number" name="FINpolicy_number" <?php if(isset($FINpolicy_number)) { echo "value=$FINpolicy_number";}?> class="form-control input-md" required type="text">
    
  </div>
</div>

<div class="btn-group">
    <button id="button1id" name="button1id" class="btn btn-success"<i class="fa fa-search"></i> Search</button>
    <a href="#" class="btn btn-danger "><i class="fa fa-refresh"></i> Reset</a>
  </div>



</fieldset>
</form>
                
                <?php 
                
                       if(isset($SearchByPol)) {
                    if($SearchByPol=='1') {
                                       
                        
                        $financial = $pdo->prepare("SELECT assura_financial_statistics.*, client_policy.policy_number, client_policy.CommissionType, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM assura_financial_statistics join client_policy on assura_financial_statistics.Policy = client_policy.policy_number WHERE policy=:id AND client_policy.insurer='Assura' GROUP BY assura_financial_statistics.id");
                        $financial->bindParam(':id', $FINpolicy_number, PDO::PARAM_STR);
                    
                        ?>
                    
                    <table  class='table table-hover table-condensed'>
                        <thead>
                            <tr>
                                <th colspan='7'>Financial Report</th>
                            </tr>
                        <th>Comm Date</th>
                        <th>Policy</th>
                        <th>Commission Type</th>
                        <th>Policy Status</th>
                        <th>Closer</th>
                        <th>Lead</th>
                        <th>Amount</th>
                    </thead>
                    
                    <?php
                    
                    $financial->execute()or die(print_r($financial->errorInfo(), true));
                    if ($financial->rowCount()>0) {
                        while ($row=$financial->fetch(PDO::FETCH_ASSOC)){
                            
                            $formattedpayment = number_format($row['payment'], 2);
                            $formatteddeduction = number_format($row['deduction'], 2);
                            $clientid = $row['policy_number'];
                            
                            echo '<tr class='.$class.'>';
                            echo "<td>".$row['insert_date']."</td>";
                            echo "<td><a target='_blank' href='/ViewPolicy.php?&policyID=".$row['POLID']."'>".$row['Policy']."</a></td>";
                            echo "<td>".$row['CommissionType']."</td>";
                            echo "<td>".$row['policystatus']."</td>";
                            echo "<td>".$row['closer']."</td>";
                            echo "<td>".$row['lead']."</td>";
                            if (intval($row['Payment_Amount'])>0) {
                                echo "<td><span class=\"label label-success\">".$row['Payment_Amount']."</span></td>"; }
                                else if (intval($row["Payment_Amount"])<0) {
                                    echo "<td><span class=\"label label-danger\">".$row['Payment_Amount']."</span></td>"; }
                                    else {
                                        echo "<td>".$row['Payment_Amount']."</td>"; }
                                        echo "</tr>";
                                        echo "\n";
                                        
                                    }
                                    
                                    } 
                                    
                                    else {
                                        echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                                        
                                    }
                                    
                                    ?>
                    
                    </table>
                        
                <?php        
                
                    }
                }
            
                ?>
                
        </div>
        </div>
    </div>

<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
<script type="text/javascript" language="javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script>
            $( "#CLICKTOHIDEFINFOUND" ).click(function() {
  $( "#HIDEFINFOUND" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDEFINNOTFOUND" ).click(function() {
  $( "#HIDEFINNOTFOUND" ).fadeOut( "slow", function() {

  });
});
            </script>
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
    </script>
    <script>
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
