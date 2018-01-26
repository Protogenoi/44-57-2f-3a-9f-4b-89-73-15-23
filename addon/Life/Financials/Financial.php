<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($fffinancials == '0') {

    header('Location: /../../../../CRMmain.php');
    die;
}

$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$COMM_DATE = filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | Financials</title>
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

    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">
                <?php 
        $database = new Database();
            $database->query("SELECT
                                    vitality_financial_uploader, 
                                    vitality_financial_uploaded_date 
                                FROM 
                                    vitality_financial 
                                ORDER BY 
                                    vitality_financial_uploaded_date DESC 
                                LIMIT 1");
            $database->execute(); 
            $FIN_ALERT = $database->single();  
            
            
            if ($database->rowCount()>=1) { ?>
        <div class='notice notice-info' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's have been uploaded by <?php echo "".$FIN_ALERT['vitality_financial_uploader']." (".$FIN_ALERT['vitality_financial_uploaded_date'].")"; ?>.</center></strong> </div>  
        <?php    }
        
        if ($database->rowCount()<1) { ?>
        
         <div class='notice notice-info' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's have not yet been uploaded for this week.</center></strong> </div>  
      
        
        <?php
        }
        
        $RECHECK = filter_input(INPUT_GET, 'RECHECK', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($RECHECK)) {

            if ($RECHECK == 'y') {

                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Policy found on recheck!</div>");
            }

            if ($RECHECK == 'n') {

                print("<div class=\"notice notice-danger\" role=\"alert\" ><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy not found on recheck!</div>");
            }
        } echo "<br>";
        ?>
         
             <form action=" " method="GET">                    

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($datefrom)) {
                                        echo $datefrom;
                                    }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($dateto)) {
                                        echo $dateto;
                                    }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <select class="form-control" name="commdate">
                                        <?php
                                        $COM_DATE_query = $pdo->prepare("SELECT 
                                                        DATE(vitality_financial_uploaded_date) AS vitality_financial_uploaded_date
                                                    FROM 
                                                        vitality_financial 
                                                    group by 
                                                        DATE(vitality_financial_uploaded_date) 
                                                    ORDER BY 
                                                        vitality_financial_uploaded_date DESC");
                                        $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($COM_DATE_query->rowCount() > 0) {
                                            while ($row = $COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['vitality_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['vitality_financial_uploaded_date']; ?>"><?php echo $row['vitality_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
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

         <br><br>
         
        <?php if(isset($datefrom)) { ?> 
         
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#VITALITYcollapse1">Vitality Financial Statistics</a></h3>
             </div>
             <div id="VITALITYcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#home">Financials</a></li>
                     <li><a data-toggle="pill" href="#VIT_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#VIT_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#VIT_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#VIT_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#VIT_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#VIT_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#VIT_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#VIT_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#VIT_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#VIT_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#VIT_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("SELECT COUNT(vitality_financial_nomatch_id) AS badge
                                                    FROM
                                                    vitality_financial_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="home" class="tab-pane fade in active">

                
                        <?php
                        $simply_biz = "5.00";

                                                     
//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/VITALITY/TotalMissingWithDates.php');
    $TotalMissingWithDates = new TotalMissingWithDatesModal($pdo);
    $TotalMissingWithDatesList = $TotalMissingWithDates->getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/VITALITY/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/VITALITY/TotalAwaitingWithDates.php');
    $TotalAwaitingWithDates = new TotalAwaitingWithDatesModal($pdo);
    $TotalAwaitingWithDatesList = $TotalAwaitingWithDates->getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/VITALITY/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/VITALITY/TotalExpectedWithDates.php');
    $TotalExpectedWithDates = new TotalExpectedWithDatesModal($pdo);
    $TotalExpectedWithDatesList = $TotalExpectedWithDates->getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/VITALITY/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$TOTAL_NET_GROSS = $ADL_EXPECTED_SUM - $ADL_AWAITING_SUM; 
$TOTAL_NET_GROSS_DISPLAY = number_format($TOTAL_NET_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        vitality_financial 
    LEFT JOIN 
        client_policy 
    ON 
        vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(vitality_financial_uploaded_date) = :commdate
    AND 
        client_policy.policy_number IN(SELECT 
                                            client_policy.policy_number 
                                        FROM 
                                            client_policy 
                                        WHERE 
                                            DATE(client_policy.sale_date) 
                                        BETWEEN 
                                            :datefrom
                                        AND 
                                            :dateto 
                                        AND 
                                            client_policy.insurer='Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    vitality_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(vitality_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT
                                        SUM(commission) AS commission 
                                    FROM 
                                        client_policy 
                                    WHERE 
                                        DATE(sale_date) BETWEEN '2017-01-01' AND :dateto
                                    AND 
                                        policy_number NOT IN(select vitality_financial_policy_number from vitality_financial)
                                    AND 
                                        insurer='Vitality'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_VIT_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_VIT_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$datefrom - $dateto"; ?>.
                                                   
ADL <?php echo $ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            if ($query->rowCount() > 0) {
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                    $totalgross = $result['totalgross'];
                                    $totalloss = abs($result['totalloss']);

                                           $totalrate = "5.00"; 

                                        $totaldifference = $EXPECTED_SUM - $totalgross;
                                    }

                                    $totalnet = $totalgross - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$TOTAL_NET_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>HWIFS <i class="fa fa-question-circle-o" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Net - HWIFS for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle-o" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle-o" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW = number_format($totalgross, 2);
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_LOSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_NET_RAW"; ?></td>
                                        <td><?php echo "£$HWIFS_RAW"; ?></td>
                                        <td><?php echo "£$NET_COMM_RAW"; ?></td>
                                        <td><?php echo "£$ADL_vs_RAW_RAW"; ?></td>
                                        <td><?php echo "£$ADL_MISSING_SUM_FORMAT"; ?></td>
                                    </tr>

                                </table> 
                        
                        <!-- END RAW COMM TABLE -->
                        
<?php 

$PAY_ON_TIME = number_format($POL_ON_TM_SUM, 2);
$PAY_LATE = number_format($POL_NOT_TM_SUM, 2);
$PAY_ON_TIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$PAY_LATE_LS = number_format($POL_NOT_TM_SUM_LS, 2);

?>
                        <!-- COMPARISON TABLE -->
                        
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $COMM_DATE"; ?></th>
                                </tr>
                                <tr>
                                    <th>Payments on Time</th> 
                                    <th>Deductions on Time</th>
                                    <th>Late Payments</th>   
                                    <th>Late Deductions</th> 
                                </tr>
                            </thead>
                            
                            <tr>
                                <td><?php echo "£$PAY_ON_TIME"; ?></td>
                                <td><?php echo "£$PAY_ON_TIME_LS"; ?></td>
                                <td><?php echo "£$PAY_LATE"; ?></td>
                                <td><?php echo "£$PAY_LATE_LS"; ?></td>
                            </tr>
                        </table>
                        
                        <!-- END OF COMPARISON TABLE -->
  
            </div>
        
        <div id="VIT_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Vitality'
                    ORDER BY 
                        vitality_financial.vitality_financial_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>                                       
        </div>


        <div id="VIT_EXPECTED" class="tab-pane fade">
                <?php

                    $EXPECTED_QUERY = $pdo->prepare("
SELECT 
    id AS PID,
    client_id AS CID,
    client_name,
    policy_number,
    policystatus,
    commission,
    DATE(sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Vitality'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$COMM_DATE ($EXPECTEDcount records) | ADL £$ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="VIT_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("
                        SELECT 
                            DATE(sale_date) AS SALE_DATE, 
                            policystatus, client_name, 
                            id AS PID, client_id AS CID, 
                            policy_number, 
                            commission
                            FROM
                                client_policy
                            WHERE 
                                DATE(sale_date) BETWEEN '2017-01-01' AND :dateto 
                            AND
                                policy_number NOT IN(select vitality_financial_policy_number FROM vitality_financial) 
                            AND
                                insurer='Vitality'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $dateto ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Unpaid Policies Found!</div>";
                    }
                    
?>
        </div>        


        <div id="VIT_MISSING" class="tab-pane fade">
                <?php
                
                    $query = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial) 
                        AND
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial)
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>


        <div id="VIT_AWAITING" class="tab-pane fade">
                <?php

                    $query = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_AWAITING_SUM_DATES_FORMAT | Total £$ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>App</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];
                                $AWAITING_SUB_DATE = $row['submitted_date'];
                                $AWAITING_APP = $row['application_number'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>$AWAITING_SUB_DATE</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>$AWAITING_APP</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Awaiting Policies found</div>";
                    }
                ?>
        </div>        

        <div id="VIT_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div> 

        <div id="VIT_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            vitality_financial.vitality_financial_policy_number, 
                            vitality_financial.vitality_financial_amount, 
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>   

        <div id="VIT_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount >= 0 
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            vitality_financial.vitality_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            vitality_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                


        <div id="VIT_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                vitality_financial.vitality_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                vitality_financial.vitality_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                vitality_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0 AND DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                                

        <div id="VIT_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            vitality_financial_nomatch_id, 
                            vitality_financial_nomatch_amount, 
                            vitality_financial_nomatch_uploaded_date, 
                            vitality_financial_nomatch_policy_number
                        FROM
                            vitality_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['vitality_financial_nomatch_policy_number'];
                            $paytype = $row['vitality_financial_nomatch_amount'];
                            $iddd = $row['vitality_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['vitality_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['vitality_financial_nomatch_policy_number']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_policy_number'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="VIT_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>

                            </center> 
        </div>                   

                </div>
            </div>
             </div>
        </div>
         
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#RLcollapse1">Royal London Financial Statistics</a></h3>
             </div>
             <div id="RLcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#RL_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#RL_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#RL_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#RL_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#RL_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#RL_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#RL_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#RL_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#RL_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#RL_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#RL_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#RL_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("SELECT COUNT(financials_nomatch_id) AS badge from financials_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="RL_home" class="tab-pane fade in active">

                
                        <?php
                        $simply_biz = "5.00";

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/ROYAL/TotalMissingWithDates.php');
    $RL_TotalMissingWithDates = new RL_TotalMissingWithDatesModal($pdo);
    $RL_TotalMissingWithDatesList = $RL_TotalMissingWithDates->RL_getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/ROYAL/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/ROYAL/TotalAwaitingWithDates.php');
    $RL_TotalAwaitingWithDates = new RL_TotalAwaitingWithDatesModal($pdo);
    $RL_TotalAwaitingWithDatesList = $RL_TotalAwaitingWithDates->RL_getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/ROYAL/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/ROYAL/TotalExpectedWithDates.php');
    $RL_TotalExpectedWithDates = new RL_TotalExpectedWithDatesModal($pdo);
    $RL_TotalExpectedWithDatesList = $RL_TotalExpectedWithDates->RL_getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/ROYAL/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$TOTAL_NET_GROSS = $ADL_EXPECTED_SUM - $ADL_AWAITING_SUM; 
$TOTAL_NET_GROSS_DISPLAY = number_format($TOTAL_NET_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Royal London'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        vitality_financial 
    LEFT JOIN 
        client_policy 
    ON 
        vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(vitality_financial_uploaded_date) = :commdate
    AND 
        client_policy.policy_number IN(SELECT 
                                            client_policy.policy_number 
                                        FROM 
                                            client_policy 
                                        WHERE 
                                            DATE(client_policy.sale_date) 
                                        BETWEEN 
                                            :datefrom
                                        AND 
                                            :dateto 
                                        AND 
                                            client_policy.insurer='Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    vitality_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(vitality_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT
                                        SUM(commission) AS commission 
                                    FROM 
                                        client_policy 
                                    WHERE 
                                        DATE(sale_date) BETWEEN '2017-01-01' AND :dateto
                                    AND 
                                        policy_number NOT IN(select vitality_financial_policy_number from vitality_financial)
                                    AND 
                                        insurer='Vitality'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_RL_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_RL_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$datefrom - $dateto"; ?>.
                                                   
ADL <?php echo $ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            if ($query->rowCount() > 0) {
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                    $totalgross = $result['totalgross'];
                                    $totalloss = abs($result['totalloss']);

                                           $totalrate = "5.00"; 

                                        $totaldifference = $EXPECTED_SUM - $totalgross;
                                    }

                                    $totalnet = $totalgross - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$TOTAL_NET_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>HWIFS <i class="fa fa-question-circle-o" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Net - HWIFS for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle-o" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle-o" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW = number_format($totalgross, 2);
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_LOSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_NET_RAW"; ?></td>
                                        <td><?php echo "£$HWIFS_RAW"; ?></td>
                                        <td><?php echo "£$NET_COMM_RAW"; ?></td>
                                        <td><?php echo "£$ADL_vs_RAW_RAW"; ?></td>
                                        <td><?php echo "£$ADL_MISSING_SUM_FORMAT"; ?></td>
                                    </tr>

                                </table> 
                        
                        <!-- END RAW COMM TABLE -->
                        
<?php 

$PAY_ON_TIME = number_format($POL_ON_TM_SUM, 2);
$PAY_LATE = number_format($POL_NOT_TM_SUM, 2);
$PAY_ON_TIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$PAY_LATE_LS = number_format($POL_NOT_TM_SUM_LS, 2);

?>
                        <!-- COMPARISON TABLE -->
                        
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $COMM_DATE"; ?></th>
                                </tr>
                                <tr>
                                    <th>Payments on Time</th> 
                                    <th>Deductions on Time</th>
                                    <th>Late Payments</th>   
                                    <th>Late Deductions</th> 
                                </tr>
                            </thead>
                            
                            <tr>
                                <td><?php echo "£$PAY_ON_TIME"; ?></td>
                                <td><?php echo "£$PAY_ON_TIME_LS"; ?></td>
                                <td><?php echo "£$PAY_LATE"; ?></td>
                                <td><?php echo "£$PAY_LATE_LS"; ?></td>
                            </tr>
                        </table>
                        
                        <!-- END OF COMPARISON TABLE -->
  
            </div>
        
        <div id="RL_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Vitality'
                    ORDER BY 
                        vitality_financial.vitality_financial_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>                                       
        </div>


        <div id="RL_EXPECTED" class="tab-pane fade">
                <?php

                    $EXPECTED_QUERY = $pdo->prepare("
SELECT 
    id AS PID,
    client_id AS CID,
    client_name,
    policy_number,
    policystatus,
    commission,
    DATE(sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Vitality'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$COMM_DATE ($EXPECTEDcount records) | ADL £$ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="RL_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("
                        SELECT 
                            DATE(sale_date) AS SALE_DATE, 
                            policystatus, client_name, 
                            id AS PID, client_id AS CID, 
                            policy_number, 
                            commission
                            FROM
                                client_policy
                            WHERE 
                                DATE(sale_date) BETWEEN '2017-01-01' AND :dateto 
                            AND
                                policy_number NOT IN(select vitality_financial_policy_number FROM vitality_financial) 
                            AND
                                insurer='Vitality'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $dateto ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Unpaid Policies Found!</div>";
                    }
                    
?>
        </div>        


        <div id="RL_MISSING" class="tab-pane fade">
                <?php
                
                    $query = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial) 
                        AND
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial)
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>


        <div id="RL_AWAITING" class="tab-pane fade">
                <?php

                    $query = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_AWAITING_SUM_DATES_FORMAT | Total £$ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>App</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];
                                $AWAITING_SUB_DATE = $row['submitted_date'];
                                $AWAITING_APP = $row['application_number'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>$AWAITING_SUB_DATE</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>$AWAITING_APP</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Awaiting Policies found</div>";
                    }
                ?>
        </div>        

        <div id="RL_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div> 

        <div id="RL_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            vitality_financial.vitality_financial_policy_number, 
                            vitality_financial.vitality_financial_amount, 
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>   

        <div id="RL_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount >= 0 
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            vitality_financial.vitality_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            vitality_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                


        <div id="RL_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                vitality_financial.vitality_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                vitality_financial.vitality_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                vitality_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0 AND DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                                

        <div id="RL_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            vitality_financial_nomatch_id, 
                            vitality_financial_nomatch_amount, 
                            vitality_financial_nomatch_uploaded_date, 
                            vitality_financial_nomatch_policy_number
                        FROM
                            vitality_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['vitality_financial_nomatch_policy_number'];
                            $paytype = $row['vitality_financial_nomatch_amount'];
                            $iddd = $row['vitality_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['vitality_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['vitality_financial_nomatch_policy_number']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_policy_number'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="RL_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>

                            </center> 
        </div>                   

                </div>
            </div>
             </div>
        </div>
         
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#WOLcollapse1">One Family Financial Statistics</a></h3>
             </div>
             <div id="WOLcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#WOL_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#WOL_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#WOL_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#WOL_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#WOL_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#WOL_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#WOL_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#WOL_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#WOL_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#WOL_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#WOL_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#WOL_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("SELECT COUNT(financials_nomatch_id) AS badge from financials_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="WOL_home" class="tab-pane fade in active">

                
                        <?php
                        $simply_biz = "5.00";

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/WOL/TotalMissingWithDates.php');
    $WOL_TotalMissingWithDates = new WOL_TotalMissingWithDatesModal($pdo);
    $WOL_TotalMissingWithDatesList = $WOL_TotalMissingWithDates->WOL_getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/WOL/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/WOL/TotalAwaitingWithDates.php');
    $WOL_TotalAwaitingWithDates = new WOL_TotalAwaitingWithDatesModal($pdo);
    $WOL_TotalAwaitingWithDatesList = $WOL_TotalAwaitingWithDates->WOL_getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/WOL/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/WOL/TotalExpectedWithDates.php');
    $WOL_TotalExpectedWithDates = new WOL_TotalExpectedWithDatesModal($pdo);
    $WOL_TotalExpectedWithDatesList = $WOL_TotalExpectedWithDates->WOL_getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/WOL/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$TOTAL_NET_GROSS = $ADL_EXPECTED_SUM - $ADL_AWAITING_SUM; 
$TOTAL_NET_GROSS_DISPLAY = number_format($TOTAL_NET_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'One Family'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        vitality_financial 
    LEFT JOIN 
        client_policy 
    ON 
        vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(vitality_financial_uploaded_date) = :commdate
    AND 
        client_policy.policy_number IN(SELECT 
                                            client_policy.policy_number 
                                        FROM 
                                            client_policy 
                                        WHERE 
                                            DATE(client_policy.sale_date) 
                                        BETWEEN 
                                            :datefrom
                                        AND 
                                            :dateto 
                                        AND 
                                            client_policy.insurer='Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    vitality_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(vitality_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT
                                        SUM(commission) AS commission 
                                    FROM 
                                        client_policy 
                                    WHERE 
                                        DATE(sale_date) BETWEEN '2017-01-01' AND :dateto
                                    AND 
                                        policy_number NOT IN(select vitality_financial_policy_number from vitality_financial)
                                    AND 
                                        insurer='Vitality'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_WOL_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_WOL_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$datefrom - $dateto"; ?>.
                                                   
ADL <?php echo $ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            if ($query->rowCount() > 0) {
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                    $totalgross = $result['totalgross'];
                                    $totalloss = abs($result['totalloss']);

                                           $totalrate = "5.00"; 

                                        $totaldifference = $EXPECTED_SUM - $totalgross;
                                    }

                                    $totalnet = $totalgross - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$TOTAL_NET_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>HWIFS <i class="fa fa-question-circle-o" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Net - HWIFS for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle-o" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle-o" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW = number_format($totalgross, 2);
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_LOSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_NET_RAW"; ?></td>
                                        <td><?php echo "£$HWIFS_RAW"; ?></td>
                                        <td><?php echo "£$NET_COMM_RAW"; ?></td>
                                        <td><?php echo "£$ADL_vs_RAW_RAW"; ?></td>
                                        <td><?php echo "£$ADL_MISSING_SUM_FORMAT"; ?></td>
                                    </tr>

                                </table> 
                        
                        <!-- END RAW COMM TABLE -->
                        
<?php 

$PAY_ON_TIME = number_format($POL_ON_TM_SUM, 2);
$PAY_LATE = number_format($POL_NOT_TM_SUM, 2);
$PAY_ON_TIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$PAY_LATE_LS = number_format($POL_NOT_TM_SUM_LS, 2);

?>
                        <!-- COMPARISON TABLE -->
                        
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $COMM_DATE"; ?></th>
                                </tr>
                                <tr>
                                    <th>Payments on Time</th> 
                                    <th>Deductions on Time</th>
                                    <th>Late Payments</th>   
                                    <th>Late Deductions</th> 
                                </tr>
                            </thead>
                            
                            <tr>
                                <td><?php echo "£$PAY_ON_TIME"; ?></td>
                                <td><?php echo "£$PAY_ON_TIME_LS"; ?></td>
                                <td><?php echo "£$PAY_LATE"; ?></td>
                                <td><?php echo "£$PAY_LATE_LS"; ?></td>
                            </tr>
                        </table>
                        
                        <!-- END OF COMPARISON TABLE -->
  
            </div>
        
        <div id="WOL_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Vitality'
                    ORDER BY 
                        vitality_financial.vitality_financial_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>                                       
        </div>


        <div id="WOL_EXPECTED" class="tab-pane fade">
                <?php

                    $EXPECTED_QUERY = $pdo->prepare("
SELECT 
    id AS PID,
    client_id AS CID,
    client_name,
    policy_number,
    policystatus,
    commission,
    DATE(sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Vitality'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$COMM_DATE ($EXPECTEDcount records) | ADL £$ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="WOL_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("
                        SELECT 
                            DATE(sale_date) AS SALE_DATE, 
                            policystatus, client_name, 
                            id AS PID, client_id AS CID, 
                            policy_number, 
                            commission
                            FROM
                                client_policy
                            WHERE 
                                DATE(sale_date) BETWEEN '2017-01-01' AND :dateto 
                            AND
                                policy_number NOT IN(select vitality_financial_policy_number FROM vitality_financial) 
                            AND
                                insurer='Vitality'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $dateto ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Unpaid Policies Found!</div>";
                    }
                    
?>
        </div>        


        <div id="WOL_MISSING" class="tab-pane fade">
                <?php
                
                    $query = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial) 
                        AND
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial)
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>


        <div id="WOL_AWAITING" class="tab-pane fade">
                <?php

                    $query = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_AWAITING_SUM_DATES_FORMAT | Total £$ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>App</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];
                                $AWAITING_SUB_DATE = $row['submitted_date'];
                                $AWAITING_APP = $row['application_number'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>$AWAITING_SUB_DATE</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>$AWAITING_APP</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Awaiting Policies found</div>";
                    }
                ?>
        </div>        

        <div id="WOL_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div> 

        <div id="WOL_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            vitality_financial.vitality_financial_policy_number, 
                            vitality_financial.vitality_financial_amount, 
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>   

        <div id="WOL_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount >= 0 
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            vitality_financial.vitality_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            vitality_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                


        <div id="WOL_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                vitality_financial.vitality_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                vitality_financial.vitality_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                vitality_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0 AND DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                                

        <div id="WOL_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            vitality_financial_nomatch_id, 
                            vitality_financial_nomatch_amount, 
                            vitality_financial_nomatch_uploaded_date, 
                            vitality_financial_nomatch_policy_number
                        FROM
                            vitality_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['vitality_financial_nomatch_policy_number'];
                            $paytype = $row['vitality_financial_nomatch_amount'];
                            $iddd = $row['vitality_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['vitality_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['vitality_financial_nomatch_policy_number']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_policy_number'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="WOL_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>

                            </center> 
        </div>                   

                </div>
            </div>
             </div>
        </div>
         
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#AVIcollapse1">Aviva Financial Statistics</a></h3>
             </div>
             <div id="AVIcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#AVI_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#AVI_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#AVI_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#AVI_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#AVI_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#AVI_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#AVI_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#AVI_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#AVI_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#AVI_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#AVI_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#AVI_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("SELECT COUNT(financials_nomatch_id) AS badge from financials_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="AVI_home" class="tab-pane fade in active">

                
                        <?php
                        $simply_biz = "5.00";

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/AVIVA/TotalMissingWithDates.php');
    $AVI_TotalMissingWithDates = new AVI_TotalMissingWithDatesModal($pdo);
    $AVI_TotalMissingWithDatesList = $AVI_TotalMissingWithDates->AVI_getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/AVIVA/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/AVIVA/TotalAwaitingWithDates.php');
    $AVI_TotalAwaitingWithDates = new AVI_TotalAwaitingWithDatesModal($pdo);
    $AVI_TotalAwaitingWithDatesList = $AVI_TotalAwaitingWithDates->AVI_getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/AVIVA/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/AVIVA/TotalExpectedWithDates.php');
    $AVI_TotalExpectedWithDates = new AVI_TotalExpectedWithDatesModal($pdo);
    $AVI_TotalExpectedWithDatesList = $AVI_TotalExpectedWithDates->AVI_getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/AVIVA/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$TOTAL_NET_GROSS = $ADL_EXPECTED_SUM - $ADL_AWAITING_SUM; 
$TOTAL_NET_GROSS_DISPLAY = number_format($TOTAL_NET_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Aviva'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        vitality_financial 
    LEFT JOIN 
        client_policy 
    ON 
        vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(vitality_financial_uploaded_date) = :commdate
    AND 
        client_policy.policy_number IN(SELECT 
                                            client_policy.policy_number 
                                        FROM 
                                            client_policy 
                                        WHERE 
                                            DATE(client_policy.sale_date) 
                                        BETWEEN 
                                            :datefrom
                                        AND 
                                            :dateto 
                                        AND 
                                            client_policy.insurer='Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    vitality_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(vitality_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT
                                        SUM(commission) AS commission 
                                    FROM 
                                        client_policy 
                                    WHERE 
                                        DATE(sale_date) BETWEEN '2017-01-01' AND :dateto
                                    AND 
                                        policy_number NOT IN(select vitality_financial_policy_number from vitality_financial)
                                    AND 
                                        insurer='Vitality'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_AVI_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_AVI_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$datefrom - $dateto"; ?>.
                                                   
ADL <?php echo $ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            if ($query->rowCount() > 0) {
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                    $totalgross = $result['totalgross'];
                                    $totalloss = abs($result['totalloss']);

                                           $totalrate = "5.00"; 

                                        $totaldifference = $EXPECTED_SUM - $totalgross;
                                    }

                                    $totalnet = $totalgross - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$TOTAL_NET_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>HWIFS <i class="fa fa-question-circle-o" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Net - HWIFS for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle-o" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle-o" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW = number_format($totalgross, 2);
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_LOSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_NET_RAW"; ?></td>
                                        <td><?php echo "£$HWIFS_RAW"; ?></td>
                                        <td><?php echo "£$NET_COMM_RAW"; ?></td>
                                        <td><?php echo "£$ADL_vs_RAW_RAW"; ?></td>
                                        <td><?php echo "£$ADL_MISSING_SUM_FORMAT"; ?></td>
                                    </tr>

                                </table> 
                        
                        <!-- END RAW COMM TABLE -->
                        
<?php 

$PAY_ON_TIME = number_format($POL_ON_TM_SUM, 2);
$PAY_LATE = number_format($POL_NOT_TM_SUM, 2);
$PAY_ON_TIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$PAY_LATE_LS = number_format($POL_NOT_TM_SUM_LS, 2);

?>
                        <!-- COMPARISON TABLE -->
                        
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $COMM_DATE"; ?></th>
                                </tr>
                                <tr>
                                    <th>Payments on Time</th> 
                                    <th>Deductions on Time</th>
                                    <th>Late Payments</th>   
                                    <th>Late Deductions</th> 
                                </tr>
                            </thead>
                            
                            <tr>
                                <td><?php echo "£$PAY_ON_TIME"; ?></td>
                                <td><?php echo "£$PAY_ON_TIME_LS"; ?></td>
                                <td><?php echo "£$PAY_LATE"; ?></td>
                                <td><?php echo "£$PAY_LATE_LS"; ?></td>
                            </tr>
                        </table>
                        
                        <!-- END OF COMPARISON TABLE -->
  
            </div>
        
        <div id="AVI_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Vitality'
                    ORDER BY 
                        vitality_financial.vitality_financial_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>                                       
        </div>


        <div id="AVI_EXPECTED" class="tab-pane fade">
                <?php

                    $EXPECTED_QUERY = $pdo->prepare("
SELECT 
    id AS PID,
    client_id AS CID,
    client_name,
    policy_number,
    policystatus,
    commission,
    DATE(sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Vitality'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$COMM_DATE ($EXPECTEDcount records) | ADL £$ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="AVI_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("
                        SELECT 
                            DATE(sale_date) AS SALE_DATE, 
                            policystatus, client_name, 
                            id AS PID, client_id AS CID, 
                            policy_number, 
                            commission
                            FROM
                                client_policy
                            WHERE 
                                DATE(sale_date) BETWEEN '2017-01-01' AND :dateto 
                            AND
                                policy_number NOT IN(select vitality_financial_policy_number FROM vitality_financial) 
                            AND
                                insurer='Vitality'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $dateto ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Unpaid Policies Found!</div>";
                    }
                    
?>
        </div>        


        <div id="AVI_MISSING" class="tab-pane fade">
                <?php
                
                    $query = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial) 
                        AND
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial)
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>


        <div id="AVI_AWAITING" class="tab-pane fade">
                <?php

                    $query = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_AWAITING_SUM_DATES_FORMAT | Total £$ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>App</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];
                                $AWAITING_SUB_DATE = $row['submitted_date'];
                                $AWAITING_APP = $row['application_number'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>$AWAITING_SUB_DATE</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>$AWAITING_APP</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Awaiting Policies found</div>";
                    }
                ?>
        </div>        

        <div id="AVI_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div> 

        <div id="AVI_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            vitality_financial.vitality_financial_policy_number, 
                            vitality_financial.vitality_financial_amount, 
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>   

        <div id="AVI_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount >= 0 
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            vitality_financial.vitality_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            vitality_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                


        <div id="AVI_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                vitality_financial.vitality_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                vitality_financial.vitality_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                vitality_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0 AND DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                                

        <div id="AVI_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            vitality_financial_nomatch_id, 
                            vitality_financial_nomatch_amount, 
                            vitality_financial_nomatch_uploaded_date, 
                            vitality_financial_nomatch_policy_number
                        FROM
                            vitality_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['vitality_financial_nomatch_policy_number'];
                            $paytype = $row['vitality_financial_nomatch_amount'];
                            $iddd = $row['vitality_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['vitality_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['vitality_financial_nomatch_policy_number']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_policy_number'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="AVI_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>

                            </center> 
        </div>                   

                </div>
            </div>
             </div>
        </div>
         
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#LVcollapse1">LV Financial Statistics</a></h3>
             </div>
             <div id="LVcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#LV_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#LV_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#LV_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#LV_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#LV_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#LV_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#LV_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#LV_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#LV_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#LV_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#LV_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#LV_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("SELECT COUNT(financials_nomatch_id) AS badge from financials_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="LV_home" class="tab-pane fade in active">

                
                        <?php
                        $simply_biz = "5.00";

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/LV/TotalMissingWithDates.php');
    $LV_TotalMissingWithDates = new LV_TotalMissingWithDatesModal($pdo);
    $LV_TotalMissingWithDatesList = $LV_TotalMissingWithDates->LV_getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LV/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/LV/TotalAwaitingWithDates.php');
    $LV_TotalAwaitingWithDates = new LV_TotalAwaitingWithDatesModal($pdo);
    $LV_TotalAwaitingWithDatesList = $LV_TotalAwaitingWithDates->LV_getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LV/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/LV/TotalExpectedWithDates.php');
    $LV_TotalExpectedWithDates = new LV_TotalExpectedWithDatesModal($pdo);
    $LV_TotalExpectedWithDatesList = $LV_TotalExpectedWithDates->LV_getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LV/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$TOTAL_NET_GROSS = $ADL_EXPECTED_SUM - $ADL_AWAITING_SUM; 
$TOTAL_NET_GROSS_DISPLAY = number_format($TOTAL_NET_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'LV'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        vitality_financial 
    LEFT JOIN 
        client_policy 
    ON 
        vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(vitality_financial_uploaded_date) = :commdate
    AND 
        client_policy.policy_number IN(SELECT 
                                            client_policy.policy_number 
                                        FROM 
                                            client_policy 
                                        WHERE 
                                            DATE(client_policy.sale_date) 
                                        BETWEEN 
                                            :datefrom
                                        AND 
                                            :dateto 
                                        AND 
                                            client_policy.insurer='Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    vitality_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(vitality_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT
                                        SUM(commission) AS commission 
                                    FROM 
                                        client_policy 
                                    WHERE 
                                        DATE(sale_date) BETWEEN '2017-01-01' AND :dateto
                                    AND 
                                        policy_number NOT IN(select vitality_financial_policy_number from vitality_financial)
                                    AND 
                                        insurer='Vitality'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_LV_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_LV_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$datefrom - $dateto"; ?>.
                                                   
ADL <?php echo $ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            if ($query->rowCount() > 0) {
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                    $totalgross = $result['totalgross'];
                                    $totalloss = abs($result['totalloss']);

                                           $totalrate = "5.00"; 

                                        $totaldifference = $EXPECTED_SUM - $totalgross;
                                    }

                                    $totalnet = $totalgross - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$TOTAL_NET_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>HWIFS <i class="fa fa-question-circle-o" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle-o" style="color:skyblue" title="Total Net - HWIFS for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle-o" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle-o" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW = number_format($totalgross, 2);
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_LOSS_RAW"; ?></td>
                                        <td><?php echo "£$TOTAL_NET_RAW"; ?></td>
                                        <td><?php echo "£$HWIFS_RAW"; ?></td>
                                        <td><?php echo "£$NET_COMM_RAW"; ?></td>
                                        <td><?php echo "£$ADL_vs_RAW_RAW"; ?></td>
                                        <td><?php echo "£$ADL_MISSING_SUM_FORMAT"; ?></td>
                                    </tr>

                                </table> 
                        
                        <!-- END RAW COMM TABLE -->
                        
<?php 

$PAY_ON_TIME = number_format($POL_ON_TM_SUM, 2);
$PAY_LATE = number_format($POL_NOT_TM_SUM, 2);
$PAY_ON_TIME_LS = number_format($POL_ON_TM_SUM_LS, 2);
$PAY_LATE_LS = number_format($POL_NOT_TM_SUM_LS, 2);

?>
                        <!-- COMPARISON TABLE -->
                        
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $COMM_DATE"; ?></th>
                                </tr>
                                <tr>
                                    <th>Payments on Time</th> 
                                    <th>Deductions on Time</th>
                                    <th>Late Payments</th>   
                                    <th>Late Deductions</th> 
                                </tr>
                            </thead>
                            
                            <tr>
                                <td><?php echo "£$PAY_ON_TIME"; ?></td>
                                <td><?php echo "£$PAY_ON_TIME_LS"; ?></td>
                                <td><?php echo "£$PAY_LATE"; ?></td>
                                <td><?php echo "£$PAY_LATE_LS"; ?></td>
                            </tr>
                        </table>
                        
                        <!-- END OF COMPARISON TABLE -->
  
            </div>
        
        <div id="LV_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Vitality'
                    ORDER BY 
                        vitality_financial.vitality_financial_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>                                       
        </div>


        <div id="LV_EXPECTED" class="tab-pane fade">
                <?php

                    $EXPECTED_QUERY = $pdo->prepare("
SELECT 
    id AS PID,
    client_id AS CID,
    client_name,
    policy_number,
    policystatus,
    commission,
    DATE(sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Vitality'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Vitality'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$COMM_DATE ($EXPECTEDcount records) | ADL £$ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="LV_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("
                        SELECT 
                            DATE(sale_date) AS SALE_DATE, 
                            policystatus, client_name, 
                            id AS PID, client_id AS CID, 
                            policy_number, 
                            commission
                            FROM
                                client_policy
                            WHERE 
                                DATE(sale_date) BETWEEN '2017-01-01' AND :dateto 
                            AND
                                policy_number NOT IN(select vitality_financial_policy_number FROM vitality_financial) 
                            AND
                                insurer='Vitality'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $dateto ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Unpaid Policies Found!</div>";
                    }
                    
?>
        </div>        


        <div id="LV_MISSING" class="tab-pane fade">
                <?php
                
                    $query = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial) 
                        AND
                            client_policy.policy_number NOT IN(select vitality_financial.vitality_financial_policy_number from vitality_financial)
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>" . $row['SALE_DATE'] . "</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>


        <div id="LV_AWAITING" class="tab-pane fade">
                <?php

                    $query = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            vitality_financial
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Vitality'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_AWAITING_SUM_DATES_FORMAT | Total £$ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>App</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['commission'];
                                $AWAITING_SUB_DATE = $row['submitted_date'];
                                $AWAITING_APP = $row['application_number'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;

                                echo '<tr>';
                                echo "<td>$AWAITING_SUB_DATE</td>";
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>$AWAITING_APP</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($EXP_COMMISSION) > 0) {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                } else if (intval($EXP_COMMISSION) < 0) {
                                    echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>";
                                }
                                echo "<td><span class=\"label label-default\">" . $row['policystatus'] . "</span></td>";

                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Awaiting Policies found</div>";
                    }
                ?>
        </div>        

        <div id="LV_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial.vitality_financial_amount,
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy ON vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div> 

        <div id="LV_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            vitality_financial.vitality_financial_policy_number, 
                            vitality_financial.vitality_financial_amount, 
                            DATE(vitality_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            vitality_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(vitality_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Vitality')");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$dateto - $datefrom with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['vitality_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else if (intval($row["vitality_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['vitality_financial_amount'] . "</span></td>";
                                }


                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>   

        <div id="LV_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount >= 0 
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            vitality_financial.vitality_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            vitality_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                


        <div id="LV_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(vitality_financial.vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                vitality_financial.vitality_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                vitality_financial.vitality_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                vitality_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                vitality_financial.vitality_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                vitality_financial.vitality_financial_amount < 0 AND DATE(vitality_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Vitality'");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['vitality_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['vitality_financial_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) < 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                }
                                echo "</tr>";
                                echo "\n";
                            }
                            ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
            </div>                                

        <div id="LV_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            vitality_financial_nomatch_id, 
                            vitality_financial_nomatch_amount, 
                            vitality_financial_nomatch_uploaded_date, 
                            vitality_financial_nomatch_policy_number
                        FROM
                            vitality_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['vitality_financial_nomatch_policy_number'];
                            $paytype = $row['vitality_financial_nomatch_amount'];
                            $iddd = $row['vitality_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['vitality_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['vitality_financial_nomatch_policy_number']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_policy_number'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="LV_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>

                            </center> 
        </div>                   

                </div>
            </div>
             </div>
        </div>
         
        <?php } ?>

    </div>

    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
    <script type="text/javascript" language="javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script>

                            $(document).ready(function () {
                                if (window.location.href.split('#').length > 1)
                                {
                                    $tab_to_nav_to = window.location.href.split('#')[1];
                                    if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
                                    {
                                        $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
                                    }
                                }
                            });

    </script>
    <script>
        $(function () {
            $("#datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>  
</body>
</html>