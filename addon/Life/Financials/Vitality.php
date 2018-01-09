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
            $database->query("SELECT financials_insert_by, financials_insert from financials ORDER BY financials.financials_insert DESC LIMIT 1");
            $database->execute(); 
            $FIN_ALERT = $database->single();  
            
            
            if ($database->rowCount()>=1) { ?>
        <div class='notice notice-info' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's have been uploaded by <?php echo "".$FIN_ALERT['financials_insert_by']." (".$FIN_ALERT['financials_insert'].")"; ?>.</center></strong> </div>  
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

        <ul class="nav nav-pills">

            <li class="active"><a data-toggle="pill" href="#home">Financials</a></li>
            <li><a data-toggle="pill" href="#PENDING">Unpaid</a></li>
            <?php if (isset($datefrom)) { ?>
                <li><a data-toggle="pill" href="#MISSING">Total Missing</a></li>
            <?php } ?>
            <li><a data-toggle="pill" href="#Awaiting">Awaiting</a></li>
            <?php if (isset($datefrom)) { ?>
                <li><a data-toggle="pill" href="#EXPECTED">Expected</a></li>
                <li><a data-toggle="pill" href="#POLINDATE">Policies on Time</a></li>
                <li><a data-toggle="pill" href="#POLOUTDATE">Late Policies</a></li>
                <li><a data-toggle="pill" href="#COMMIN">Total Gross</a></li>
                <li><a data-toggle="pill" href="#COMMOUT">Total Loss</a></li>
                <li><a data-toggle="pill" href="#RAW">RAW</a></li>
                <li><a data-toggle="pill" href="#EXPORT">Export</a></li>
            <?php } ?>

            <li><a data-toggle="pill" href="#NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $nomatchbadge = $pdo->query("select count(financials_nomatch_id) AS badge from financials_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a>
            </li>
          
        </ul>

    </div>

    <div class="tab-content">

        <div id="home" class="tab-pane fade in active">
            <div class="container"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Vitality Financial Statistics</h3>
                    </div>
                    <div class="panel-body">
                        
                        <form action=" " method="get">                    

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
                                        $COM_DATE_query = $pdo->prepare("SELECT DATE(financials_insert) AS financials_insert
                                                    FROM 
                                                        financials 
                                                    group by 
                                                        DATE(financials_insert) 
                                                    ORDER BY 
                                                        financials.financials_insert DESC");
                                        $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($COM_DATE_query->rowCount() > 0) {
                                            while ($row = $COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['financials_insert'])) {
                                                    ?>
                                                    <option value="<?php echo $row['financials_insert']; ?>"><?php echo $row['financials_insert']; ?></option>

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
                        
                        <?php
                        $simply_biz = "25.00";
                        
                        if (isset($datefrom)) {
                                                     
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
    SUM(CASE WHEN financials_payment < 0 THEN financials_payment ELSE 0 END) as totalloss,
    SUM(CASE WHEN financials_payment >= 0 THEN financials_payment ELSE 0 END) as totalgross
    FROM financials 
    WHERE 
        DATE(financials_insert)=:commdate
    AND
        financials_provider ='Vitality'");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);



                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN financials.financials_payment >= 0 THEN financials.financials_payment ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN financials.financials_payment < 0 THEN financials.financials_payment ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        financials 
    LEFT JOIN 
        client_policy 
    ON 
        financials.financials_policy=client_policy.policy_number 
    WHERE 
        DATE(financials.financials_insert) = :commdate
    AND
        financials_provider='Vitality'
    AND 
        client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto)");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN financials.financials_payment >= 0 THEN financials.financials_payment ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN financials.financials_payment < 0 THEN financials.financials_payment ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    financials
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    financials.financials_policy=client_policy.policy_number
                                WHERE 
                                    DATE(financials.financials_insert) = :commdate 
                                AND
                                    financials.financials_provider='Vitality'
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
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
                                        policy_number NOT IN(select financials_policy from financials)
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

                            $simply_EXP_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_PENDING;
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

                                    if (isset($datefrom)) {
                                        if($datefrom>='2017-04-20') {
                                            $totalrate = "22.5";
                                        }
                                        else {
                                           $totalrate = "25.00"; 
                                        }
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
  
    <?php }  ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="RAW" class="tab-pane fade">
            <div class="container">

                <?php
                if (isset($datefrom)) {

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        financials.financials_client, 
                        financials.financials_policy, 
                        financials.financials_payment, 
                        DATE(financials.financials_insert) AS COMM_DATE
                    FROM
                        financials
                    LEFT JOIN 
                        client_policy
                    ON 
                        financials.financials_policy=client_policy.policy_number
                    WHERE 
                        DATE(financials.financials_insert) = :commdate
                    AND
                        financials.financials_provider='Vitality'
                    ORDER BY 
                        financials.financials_payment DESC");
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
                                echo "<td>" . $row['financials_client'] . "</td>";
                                if (intval($row['financials_payment']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
                                } else if (intval($row["financials_payment"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['financials_payment'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
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
                }
                ?>                                       
            </div>
        </div>


        <div id="EXPECTED" class="tab-pane fade">
            <div class="container">
                <?php
                if (isset($datefrom)) {



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
        </div>

        <div id="PENDING" class="tab-pane fade">
            <div class="container">

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
                                policy_number NOT IN(select financials_policy FROM financials) 
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
                    
                }
?>
            </div>                

        </div>        


        <div id="MISSING" class="tab-pane fade">
            <div class="container">

                <?php
                if (isset($datefrom)) {

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
                            financials.financials_policy,
                            financials.financials_payment,
                            DATE(financials.financials_insert) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            financials
                        ON 
                            financials.financials_policy=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select financials.financials_policy from financials) 
                        AND
                            client_policy.policy_number NOT IN(select financials.financials_policy from financials)
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
                }
                ?>
            </div>                

        </div>


        <div id="Awaiting" class="tab-pane fade">
            <div class="container">

                <?php
                if (isset($datefrom)) {

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
                            financials.financials_policy,
                            financials.financials_payment,
                            DATE(financials.financials_insert) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            financials
                        ON 
                            financials.financials_policy=client_policy.policy_number
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
                } 
                ?>
            </div>                

        </div>        

        <div id="POLINDATE" class="tab-pane fade">
            <div class="container">
                <?php
                if (isset($datefrom)) {

                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(financials.financials_payment) AS financials_payment 
                        FROM 
                            financials
                        LEFT JOIN 
                            client_policy ON financials.financials_policy=client_policy.policy_number
                        WHERE 
                            DATE(financials.financials_insert) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['financials_payment'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            financials.financials_policy,
                            financials.financials_payment,
                            DATE(financials.financials_insert) AS COMM_DATE
                        FROM 
                            financials
                        LEFT JOIN 
                            client_policy ON financials.financials_policy=client_policy.policy_number
                        WHERE 
                            DATE(financials.financials_insert) = :commdate
                        AND
                            financials.financials_provider='Vitality'
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
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
                                if (intval($row['financials_payment']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
                                } else if (intval($row["financials_payment"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['financials_payment'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
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
                }
                ?>
            </div>   

        </div> 

        <div id="POLOUTDATE" class="tab-pane fade">

            <div class="container">
               <?php


                if (isset($datefrom)) {

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            financials.financials_policy, 
                            financials.financials_payment, 
                            DATE(financials.financials_insert) AS COMM_DATE
                        FROM 
                            financials
                        LEFT JOIN 
                            client_policy
                        ON 
                            financials.financials_policy=client_policy.policy_number
                        WHERE 
                            DATE(financials.financials_insert) = :commdate
                        AND
                            financials.financials_provider='Vitality'
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
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
                                if (intval($row['financials_payment']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
                                } else if (intval($row["financials_payment"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['financials_payment'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['financials_payment'] . "</span></td>";
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
                }
                ?>
            </div>                 


        </div>   

        <div id="COMMIN" class="tab-pane fade">

            <div class="container">
                <?php
                if (isset($datefrom)) {

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(financials.financials_payment) AS financials_payment
                            FROM 
                                financials 
                            LEFT JOIN 
                                client_policy
                            ON 
                                financials.financials_policy=client_policy.policy_number
                            WHERE 
                                financials.financials_payment >= 0 
                            AND 
                                DATE(financials.financials_insert) =:commdate 
                            AND 
                                financials.financials_provider ='Vitality'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['financials_payment'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            financials.financials_payment, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            financials.financials_policy, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            financials 
                        LEFT JOIN
                            client_policy 
                        ON 
                            financials.financials_policy=client_policy.policy_number 
                        WHERE 
                            financials.financials_payment >= 0 
                        AND 
                            DATE(financials.financials_insert) =:commdate
                        AND 
                            financials.financials_provider='Vitality'");
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

                                $policy = $row['financials_policy'];
                                $PAY_AMOUNT = number_format($row['financials_payment'], 2);

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
                }
                ?>
            </div>                

        </div>

        <div id="COMMOUT" class="tab-pane fade">

            <div class="container">
                <?php
                if (isset($datefrom)) {

                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(financials.financials_payment) AS financials_payment 
                            FROM 
                                financials 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                financials.financials_policy=client_policy.policy_number
                            WHERE 
                                financials.financials_payment < 0
                            AND 
                                DATE(financials.financials_insert) =:commdate
                            AND 
                                financials.financials_provider='Vitality'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['financials_payment'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                financials.financials_payment, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                financials.financials_policy, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                financials
                            LEFT JOIN 
                                client_policy
                            ON 
                                financials.financials_policy=client_policy.policy_number 
                            WHERE 
                                financials.financials_payment < 0 AND DATE(financials.financials_insert) =:commdate
                            AND 
                                financials.financials_provider='Vitality'");
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

                                $policy = $row['financials_policy'];
                                $PAY_AMOUNT = number_format($row['financials_payment'], 2);

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
                }
                ?>
            </div>                                


        </div>  

        <div id="NOMATCH" class="tab-pane fade">   
            <div class="container">
                <?php
                $query = $pdo->prepare("
                        SELECT
                            financials_nomatch_id, 
                            financials_nomatch_payment, 
                            financials_nomatch_insert, 
                            financials_nomatch_policy,
                            bedrock_id
                        FROM 
                            financials_nomatch");
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
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['financials_nomatch_policy'];
                            $paytype = $row['financials_nomatch_payment'];
                            $iddd = $row['financials_nomatch_id'];
                            $BRID= $row['bedrock_id'];

                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['financials_nomatch_insert'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['financials_nomatch_policy']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['financials_nomatch_policy'] . "</span></td>";
                            } else if (intval($row["financials_nomatch_payment"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['financials_nomatch_payment'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['financials_nomatch_payment'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$BRID&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                 
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

        <div id="EXPORT" class="tab-pane fade">
            <div class="container">



                <div class="panel panel-default">

                    <div class="panel-heading">Export Data</div>

                    <div class="panel-body">     

                        <?php if (isset($datefrom)) { ?>  
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
                        <?php } ?>  
                    </div>

                </div>
            </div>
        </div>



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