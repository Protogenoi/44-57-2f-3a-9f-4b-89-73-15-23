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

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($fffinancials == '0') {

    header('Location: ../CRMmain.php');
    die;
}
$INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($INSURER)) {
    if ($INSURER == 'RoyalLondon') {
        header('Location: Financials/RoyalLondon.php?INSURER=' . $INSURER);
        die;
    }
    if ($INSURER == 'Aviva') {
        header('Location: Financials/Aviva.php?INSURER=' . $INSURER);
        die;
    }
    if ($INSURER == 'WOL') {
        header('Location: Financials/OneFamily.php?INSURER=' . $INSURER);
        die;
    }
    if ($INSURER == 'Vitality') {
        header('Location: Financials/Vitality.php?INSURER=' . $INSURER);
        die;
    }
}

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);
$companynamere = $companydetailsq['company_name'];


        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$FILTER = filter_input(INPUT_POST, 'FILTER', FILTER_SANITIZE_SPECIAL_CHARS);
$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$COMM_DATE = filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <title>ADL | Financials</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php
    if ($hello_name != 'Jade') {
        require_once(__DIR__ . '/../includes/navbar.php');
    }
    ?>

    <div class="container">
                <?php 
        $database = new Database();
            $database->query("SELECT uploader, insert_date from financial_statistics_history ORDER BY insert_date DESC LIMIT 1");
            $database->execute(); 
            $FIN_ALERT = $database->single();  
            
            
            if ($database->rowCount()>=1) { ?>
        <div class='notice notice-info' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's for Legal and General have been uploaded by <?php echo "".$FIN_ALERT['uploader']." (".$FIN_ALERT['insert_date'].")"; ?>.</center></strong> </div>  
        <?php    }
        
        if ($database->rowCount()<1) { ?>
        
         <div class='notice notice-info' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's for Legal and General have not yet been uploaded for this week.</center></strong> </div>  
      
        
        <?php
        }
        
        if(isset($dateto)) {
            if($dateto>='2017-04-20' && $datefrom<'2017-04-20') { ?>
            <div class="notice notice-warning" role="alert"><strong><i class="fa fa-check-circle-o"></i> Info:</strong> HWIFS percentage has changed from 2017-05-03 onwards. These figures will be incorrect. Change the end date to less than 2017-04-20</div>
 
      <?php      }
        }
        
        $RECHECK = filter_input(INPUT_GET, 'RECHECK', FILTER_SANITIZE_SPECIAL_CHARS);
        $UPDATED = filter_input(INPUT_GET, 'UPDATED', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($RECHECK)) {

            if ($RECHECK == 'y') {

                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Policy found on recheck!</div>");
            }

            if ($RECHECK == 'n') {

                print("<div class=\"notice notice-danger\" role=\"alert\" ><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy not found on recheck!</div>");
            }         
            
        }
        
            if(isset($UPDATED)) {
                
                if($UPDATED == 1 ) {
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> $UPDATED Policy found on recheck!</div>";
                
                }
                
                elseif($UPDATED >=2 ) {
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> $UPDATED Policies found on recheck!</div>";
                    
                }
                
                else {
                    echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Success:</strong> No Policies found on recheck!</div>";
                }
   
    }          
        
        echo "<br>";
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
                        $nomatchbadge = $pdo->query("select count(id) AS badge from financial_statistics_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a>
            </li>
            <form action="" method="GET">
                <div class="form-group col-xs-3">
                    <label class="col-md-4 control-label" for="query"></label>
                    <select id="INSURER" name="INSURER" class="form-control" onchange="this.form.submit()" required>
                        <option <?php
                        if (isset($INSURER)) {
                            if ($INSURER == 'LegalandGeneral') {
                                echo "selected";
                            }
                        }
                        ?> value="LegalandGeneral" selected>Legal And General</option>
                        <option <?php
                        if (isset($INSURER)) {
                            if ($INSURER == 'Aviva') {
                                echo "selected";
                            }
                        }
                        ?> value="Aviva">Aviva</option>
                        <option <?php
                        if (isset($INSURER)) {
                            if ($INSURER == 'RoyalLondon') {
                                echo "selected";
                            }
                        }
                        ?> value="RoyalLondon">Royal London</option>
                        <option <?php
                        if (isset($INSURER)) {
                            if ($INSURER == 'WOL') {
                                echo "selected";
                            }
                        }
                        ?> value="WOL">One Family</option>
                        <option <?php
                        if (isset($INSURER)) {
                            if ($INSURER == 'Vitality') {
                                echo "selected";
                            }
                        }
                        ?> value="Vitality">Vitality</option>
                    </select>
                </div>
            </form>
        </ul>

    </div>

    <div class="tab-content">

        <div id="home" class="tab-pane fade in active">
            <div class="container"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Financial Statistics</h3>
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
                                        $COM_DATE_query = $pdo->prepare("SELECT DATE(insert_date) AS insert_date FROM financial_statistics_history group by DATE(insert_date) ORDER BY insert_date DESC");
                                        $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($COM_DATE_query->rowCount() > 0) {
                                            while ($row = $COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['insert_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['insert_date']; ?>"><?php echo $row['insert_date']; ?></option>

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
                        $simply_biz = "2.5";
                        
                        if (isset($datefrom)) {
                                                     
//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(__DIR__ . '/models/financials/LG/TotalMissingWithDates.php');
    $TotalMissingWithDates = new TotalMissingWithDatesModal($pdo);
    $TotalMissingWithDatesList = $TotalMissingWithDates->getTotalMissingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LG/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/LG/TotalAwaitingWithDates.php');
    $TotalAwaitingWithDates = new TotalAwaitingWithDatesModal($pdo);
    $TotalAwaitingWithDatesList = $TotalAwaitingWithDates->getTotalAwaitingWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LG/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(__DIR__ . '/models/financials/LG/TotalExpectedWithDates.php');
    $TotalExpectedWithDates = new TotalExpectedWithDatesModal($pdo);
    $TotalExpectedWithDatesList = $TotalExpectedWithDates->getTotalExpectedWithDates($datefrom, $dateto);
    require_once(__DIR__ . '/views/financials/LG/Total-Expected-With-Dates.php');  
    

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
        AND insurer = 'Legal and General'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        ");
                            $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as totalgross
    FROM financial_statistics_history WHERE DATE(insert_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);



                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
                            $POL_ON_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("select
    SUM(CASE WHEN financial_statistics_history.payment_amount >= 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
    SUM(CASE WHEN financial_statistics_history.payment_amount < 0 THEN financial_statistics_history.payment_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS        
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("select SUM(commission) AS commission FROM client_policy WHERE DATE(sale_date) BETWEEN '2017-01-01' AND :dateto AND policy_number NOT IN(select policy from financial_statistics_history) AND insurer='Legal and General' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
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

Total: <?php echo $ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="../export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle-o" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$datefrom - $dateto  $TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="../export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies that have not been paid <?php if (isset($datefrom)) { echo "within 2017-01-01 - $dateto"; } ?>."></i> <a href="../export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle-o" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($datefrom)) { echo "within $datefrom - $dateto"; } ?>.

ADL <?php echo $ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="../export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

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

                    $query = $pdo->prepare("select client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.Policy_Name, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate ORDER by financial_statistics_history.payment_amount DESC");
                    $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['Policy_Name'] . "</td>";
                                if (intval($row['payment_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
                                } else if (intval($row["payment_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['payment_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
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
        AND insurer = 'Legal and General'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Legal and General'
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
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

                    $query = $pdo->prepare("select DATE(sale_date) AS SALE_DATE, policystatus, client_name, id AS PID, client_id AS CID, policy_number, commission 
FROM client_policy
WHERE DATE(sale_date) BETWEEN '2017-01-01' AND :dateto AND policy_number NOT IN(select policy from financial_statistics_history) AND insurer='Legal and General' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') AND policy_number NOT like '%DU%' ORDER BY commission DESC");
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
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

                    $query = $pdo->prepare("select DATE(client_policy.sale_date) AS SALE_DATE, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
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

                    $query = $pdo->prepare("select client_policy.application_number, DATE(client_policy.submitted_date) AS submitted_date, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.submitted_date) between :datefrom AND :dateto AND client_policy.insurer='Legal and General' AND client_policy.policystatus ='Awaiting' ORDER BY DATE(client_policy.sale_date)");
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
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

                    $POLIN_SUM_QRY = $pdo->prepare("select sum(financial_statistics_history.payment_amount) AS payment_amount FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
                    $POLIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['payment_amount'];

                    $query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['payment_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
                                } else if (intval($row["payment_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['payment_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
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
                <?php if (isset($datefrom)) { ?>
                    <form action="?datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>&commdate=<?php echo $COMM_DATE; ?>#POLOUTDATE" method="POST">
                        <div class="form-group col-xs-3">
                            <label class="col-md-4 control-label" for="query"></label>
                            <select id="FILTER" name="FILTER" class="form-control" onchange="this.form.submit()" required>
                                <option>Select to filter by paid or deductions</option>
                                <option <?php
                                if (isset($FILTER)) {
                                    if ($FILTER == '1') {
                                        echo "selected";
                                    }
                                }
                                ?> value="1">Late Paid</option>
                                <option <?php
                                if (isset($FILTER)) {
                                    if ($FILTER == '2') {
                                        echo "selected";
                                    }
                                }
                                ?> value="2">Late Deductions</option>

                            </select>
                        </div>
                    </form>    

                    <?php
                }

                if (isset($datefrom) && isset($FILTER)) {
                    if ($FILTER == '1') {

                        $query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto) AND financial_statistics_history.Payment_Amount >='0'");
                    }

                    if ($FILTER == '2') {
                        $query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto) AND financial_statistics_history.Payment_Amount <'0'");
                    }

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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['payment_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
                                } else if (intval($row["payment_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['payment_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
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

                if (isset($datefrom) && !isset($FILTER)) {

                    $query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(financial_statistics_history.insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
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
                                echo "<td><a href='/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['payment_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
                                } else if (intval($row["payment_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['payment_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
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

                    $COMMIN_SUM_QRY = $pdo->prepare("select sum(financial_statistics_history.payment_amount) AS payment_amount from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount >= 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['payment_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, financial_statistics_history.policy, financial_statistics_history.payment_due_date , client_policy.client_name, client_policy.client_id from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount >= 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
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

                                $policy = $row['policy'];
                                $PAY_AMOUNT = number_format($row['payment_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
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

                    $COMMOUT_SUM_QRY = $pdo->prepare("select sum(financial_statistics_history.payment_amount) AS payment_amount from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount < 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['payment_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, financial_statistics_history.policy, financial_statistics_history.payment_due_date , client_policy.client_name, client_policy.client_id from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount < 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
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

                                $policy = $row['policy'];
                                $PAY_AMOUNT = number_format($row['payment_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/Life/ViewClient.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
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
                $query = $pdo->prepare("select entry_date, id, policy_number, payment_type, payment_amount from financial_statistics_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="7">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                    <th>L&G Summary Sheet</th>
                    <th>Recheck all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                            $i++;
                            $policy = $row['policy_number'];
                            $AMOUNT = $row['payment_amount'];
                            $paytype = $row['payment_type'];
                            $iddd = $row['id'];

                            echo "<tr>
                            <td>$i</td>";
                            echo"<td>" . $row['entry_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['payment_amount']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['payment_amount'] . "</span></td>";
                            } else if (intval($row["payment_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['payment_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['payment_amount'] . "</td>";
                            }

                            if (isset($datefrom)) {
                                echo "<td><a href='../php/Financial_Recheck.php?EXECUTE=1&INSURER=LG&RECHECK=y&finpolicynumber=$policy&paytype=$paytype&iddd=$iddd&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";
                            } else {
                                echo "<td><a href='../php/Financial_Recheck.php?EXECUTE=1&INSURER=LG&RECHECK=y&finpolicynumber=$policy&paytype=$paytype&iddd=$iddd' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i> Check single non matching policy</a></td>";
                            }
                            ?> <td><form target="_blank" action='//www20.landg.com/PolicyEnquiriesIFACentre/requests.do' method='post'><input type='hidden' name='policyNumber' value='<?php echo substr_replace($policy, "", -1); ?>'><input type='hidden' name='routeSelected' value='convLifeSummary'><button type='submit' class='btn btn-warning btn-sm'><i class='fa fa-check-circle-o'></i> Check L&G Summary Statement</button></form></td>

                            <?php
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=LG' class='btn btn-default btn-sm'><i class='fa fa-check-circle-o'></i> Check all non matching policies</a></td>";

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
                                            <a href='../export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='../export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='../export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='../export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='../export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='../export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-12"><br>
                                    <div class="col-xs-4">
                                        <a href='../export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
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