<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if($fflife=='0') {
    
    header('Location: ../../CRMmain.php'); die;
    
}
$INSURER= filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);  

    if(isset($INSURER)) {
        if($INSURER=='Aviva') {
            header('Location: Aviva.php?INSURER='.$INSURER); die;
            }
            if($INSURER=='LegalandGeneral') {
                header('Location: ../Financials.php'); die;
                }
                if($INSURER=='WOL') {
                    header('Location: OneFamily.php?INSURER='.$INSURER); die;
                    }
                    if($INSURER=='Vitality') {
                        header('Location: Vitality.php?INSURER='.$INSURER); die;
                        }
                        
                    }
                    
                    include ("../../includes/ADL_PDO_CON.php");

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
$companynamere=$companydetailsq['company_name'];

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/adlfunctions.php');
include('../../includes/Access_Levels.php');

if($companynamere=='The Review Bureau') {
    $Level_2_Access = array("Michael", "Matt", "leighton", "Jade");
if (!in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: ../../CRMmain.php?AccessDenied'); die;
}
}

if($companynamere=='ADL_CUS') {
    $Level_2_Access = array("Michael", "Dean", "Andrew", "Helen", "David");
if (!in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: ../../CRMmain.php?AccessDenied'); die;
}
}

$FILTER= filter_input(INPUT_POST, 'FILTER', FILTER_SANITIZE_SPECIAL_CHARS);
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
    <link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
    <script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</head>
<body>
    
    <?php     if ($hello_name!='Jade') {
    include('../../includes/navbar.php');
    }
    
    if($ffanalytics=='1') {  
        include_once('../../php/analyticstracking.php'); 
        
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
    
    }   echo "<br>";    
         
    ?>
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Financials</a></li>
            <li><a data-toggle="pill" href="#PENDING">Pending</a></li>
              <li><a data-toggle="pill" href="#MISSING">Missing</a></li>
            <li><a data-toggle="pill" href="#TBC">TBC</a></li>
            <?php if(isset($datefrom)) { ?>
            <li><a data-toggle="pill" href="#EXPECTED">Expected</a></li>
            <li><a data-toggle="pill" href="#POLINDATE">Policies on Time</a></li>
            <li><a data-toggle="pill" href="#POLOUTDATE">Late Policies</a></li>
            <li><a data-toggle="pill" href="#COMMIN">Total Gross</a></li>
            <li><a data-toggle="pill" href="#COMMOUT">Total Loss</a></li>
            <li><a data-toggle="pill" href="#RAW">RAW</a></li>
            <li><a data-toggle="pill" href="#EXPORT">Export</a></li>
            <?php } ?>
            
            <li><a data-toggle="pill" href="#NOMATCH">Unmatched Policies <span class="badge alert-warning">
                <?php $nomatchbadge = $pdo->query("select count(royal_london_nomatch_id) AS badge from royal_london_nomatch");
            $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC); echo htmlentities($row['badge']);?>
                    </span></a>
            </li>
                         <form action="" method="GET">
    <div class="form-group col-xs-3">
  <label class="col-md-4 control-label" for="query"></label>
    <select id="INSURER" name="INSURER" class="form-control" onchange="this.form.submit()" required>
        <option <?php if(isset($INSURER)) { if($INSURER=='LegalandGeneral') { echo "selected"; } } ?> value="LegalandGeneral" selected>Legal And General</option>
        <option <?php if(isset($INSURER)) { if($INSURER=='Aviva') { echo "selected"; } } ?> value="Aviva">Aviva</option>
        <option <?php if(isset($INSURER)) { if($INSURER=='RoyalLondon') { echo "selected"; } } ?> value="RoyalLondon">Royal London</option>
        <option <?php if(isset($INSURER)) { if($INSURER=='WOL') { echo "selected"; } } ?> value="WOL">One Family</option>
        <option <?php if(isset($INSURER)) { if($INSURER=='Vitality') { echo "selected"; } } ?> value="Vitality">Vitality</option>
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
                            <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php if(isset($datefrom)) { echo $datefrom; } ?>" required>
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
                    
                    $COM_DATE_query = $pdo->prepare("SELECT DATE(royal_london_insert_date) AS royal_london_insert_date FROM royal_london_financials group by DATE(royal_london_insert_date) ORDER BY royal_london_insert_date DESC");
                    $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                    if ($COM_DATE_query->rowCount()>0) {
                        while ($row=$COM_DATE_query->fetch(PDO::FETCH_ASSOC)){ 
                                if(isset($row['royal_london_insert_date'])) {  ?>
                                <option value="<?php echo $row['royal_london_insert_date']; ?>"><?php echo $row['royal_london_insert_date']; ?></option>
        
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
                $simply_biz = "18.75";
                
                $PIPE_query = $pdo->prepare("select sum(client_policy.commission) AS pipe from client_policy LEFT JOIN royal_london_financials ON client_policy.policy_number = royal_london_financials.royal_london_policy WHERE royal_london_financials.royal_london_policy IS NULL AND client_policy.insurer ='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%'");
                $PIPE_query->execute()or die(print_r($PIPE_query->errorInfo(), true));
                $row_rsmyQuery=$PIPE_query->fetch(PDO::FETCH_ASSOC);
                $ORIG_pipe = $row_rsmyQuery['pipe']; 
                
                $simply_ORIG_pipe = ($simply_biz/100) * $ORIG_pipe;
                $pipe=$ORIG_pipe-$simply_ORIG_pipe;    
                
                if(isset($datefrom)) {
                    
                    $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN royal_london_financials.royal_london_comm < 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as totalloss,
    SUM(CASE WHEN royal_london_financials.royal_london_comm >= 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as totalgross
    FROM royal_london_financials WHERE DATE(royal_london_insert_date)=:commdate");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);

    $MISSING_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission FROM client_policy LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' AND client_policy.policy_number NOT like '%tbc%'");
        $MISSING_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $MISSING_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $MISSING_SUM_QRY->execute()or die(print_r($MISSING_SUM_QRY->errorInfo(), true));
        $MISSING_SUM_QRY_RS=$MISSING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_MISSING_SUM = $MISSING_SUM_QRY_RS['commission'];
        
        $simply_MISSING_SUM = ($simply_biz/100) * $ORIG_MISSING_SUM;
        $MISSING_SUM=$ORIG_MISSING_SUM-$simply_MISSING_SUM;        
        
        $EXPECTED_SUM_QRY = $pdo->prepare("select SUM(commission) AS commission FROM client_policy WHERE DATE(sale_date) between :datefrom AND :dateto AND insurer='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') AND client_policy.policy_number NOT like '%DU%'");
        $EXPECTED_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $EXPECTED_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
        $EXPECTED_SUM_QRY_RS=$EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission']; 
        
        $simply_EXPECTED_SUM = ($simply_biz/100) * $ORIG_EXPECTED_SUM;
        $EXPECTED_SUM=$ORIG_EXPECTED_SUM-$simply_EXPECTED_SUM;
        
$POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN royal_london_financials.royal_london_comm >= 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN royal_london_financials.royal_london_comm < 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
    $POL_ON_TM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true)); 
    $POL_ON_TM_SUM_QRY_RS=$POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
    $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS']; 
    $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS']; 
    
    $POL_NOT_TM_QRY = $pdo->prepare("select
    SUM(CASE WHEN royal_london_financials.royal_london_comm >= 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
    SUM(CASE WHEN royal_london_financials.royal_london_comm < 0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as NOT_PAID_TOTAL_LOSS        
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
    $POL_NOT_TM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true)); 
    $POL_NOT_TM_SUM_QRY_RS=$POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
    $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS']; 
    $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS']; 
    
        $TBC_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.insurer='Royal London' AND client_policy.policystatus IN ('Awaiting Policy Number','Live Awaiting Policy Number')");
        $TBC_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $TBC_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $TBC_SUM_QRY->execute()or die(print_r($TBC_SUM_QRY->errorInfo(), true));
        $TBC_SUM_QRY_RS=$TBC_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_TBC_SUM = $TBC_SUM_QRY_RS['commission'];                    

        $simply_EXP_TBC = ($simply_biz/100) * $ORIG_TBC_SUM;
        $TBC_SUM_UNFORMATTED=$ORIG_TBC_SUM-$simply_EXP_TBC;    
        $TBC_SUM = number_format($TBC_SUM_UNFORMATTED, 2);  
        
        $PENDING_SUM_QRY = $pdo->prepare("select SUM(commission) AS commission FROM client_policy WHERE DATE(sale_date) BETWEEN '2017-01-01' AND :dateto AND policy_number NOT IN(select royal_london_policy from royal_london_financials) AND insurer='Royal London' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND policy_number NOT like '%DU%'");
        $PENDING_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);  
        $PENDING_SUM_QRY->execute()or die(print_r($PENDING_SUM_QRY->errorInfo(), true));
        $PENDING_SUM_QRY_RS=$PENDING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_PENDING_SUM = $PENDING_SUM_QRY_RS['commission'];                    

        $simply_EXP_PENDING = ($simply_biz/100) * $ORIG_PENDING_SUM;
        $PENDING_SUM_UNFORMATTED=$ORIG_PENDING_SUM-$simply_EXP_PENDING;    
        $PENDING_SUM = number_format($PENDING_SUM_UNFORMATTED, 2);          
        $ORIG_PENDING_SUM_FOR = number_format($ORIG_PENDING_SUM, 2); 


    
                } else {
                    
                    $query = $pdo->prepare("SELECT SUM(CASE WHEN royal_london_financials.royal_london_comm<0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as totalloss,
     SUM(CASE WHEN royal_london_financials.royal_london_comm>=0 THEN royal_london_financials.royal_london_comm ELSE 0 END) as totalgross
    FROM royal_london_financials ");
                    
        $MISSING_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission FROM client_policy LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number WHERE client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' AND client_policy.policy_number NOT like '%tbc%'");
        $MISSING_SUM_QRY->execute()or die(print_r($MISSING_SUM_QRY->errorInfo(), true));
        $MISSING_SUM_QRY_RS=$MISSING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_MISSING_SUM = $MISSING_SUM_QRY_RS['commission'];
        
        $simply_MISSING_SUM = ($simply_biz/100) * $ORIG_MISSING_SUM;
        $MISSING_SUM=$ORIG_MISSING_SUM-$simply_MISSING_SUM;     
        
            $TBC_SUM_QRY = $pdo->prepare("select sum(client_policy.commission) AS commission
FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus IN ('Awaiting Policy Number','Live Awaiting Policy Number')");
 
        $TBC_SUM_QRY->execute()or die(print_r($TBC_SUM_QRY->errorInfo(), true));
        $TBC_SUM_QRY_RS=$TBC_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_TBC_SUM = $TBC_SUM_QRY_RS['commission'];                    

        $simply_EXP_TBC = ($simply_biz/100) * $ORIG_TBC_SUM;
        $TBC_SUM_UNFORMATTED=$ORIG_TBC_SUM-$simply_EXP_TBC;    
        $TBC_SUM = number_format($TBC_SUM_UNFORMATTED, 2);
        
         $PENDING_SUM_QRY = $pdo->prepare("select SUM(commission) AS commission FROM client_policy WHERE DATE(sale_date) BETWEEN '2017-01-01' AND CURDATE() AND policy_number NOT IN(select royal_london_policy from royal_london_financials) AND insurer='Royal London' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND policy_number NOT like '%DU%'"); 
        $PENDING_SUM_QRY->execute()or die(print_r($PENDING_SUM_QRY->errorInfo(), true));
        $PENDING_SUM_QRY_RS=$PENDING_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_PENDING_SUM = $PENDING_SUM_QRY_RS['commission'];                    

        $simply_EXP_PENDING = ($simply_biz/100) * $ORIG_PENDING_SUM;
        $PENDING_SUM_UNFORMATTED=$ORIG_PENDING_SUM-$simply_EXP_PENDING;    
        $PENDING_SUM = number_format($PENDING_SUM_UNFORMATTED, 2);          
        $ORIG_PENDING_SUM_FOR = number_format($ORIG_PENDING_SUM, 2);        
                }
                
                ?>       
                    
<table  class="table table-hover">

<thead>

    <tr>
    <th colspan="8"><?php if(isset($datefrom)) { echo "ADL Projections for $commdate"; } ?></th>
    </tr>
    <?php if(isset($datefrom)) { ?>
    <th>EST Total Gross</th>
    <th>Projected Gross</th>
        <?php } ?>
    <th>Pending</th>
    <th>TBC</th>
    <?php if(isset($datefrom)) { ?>
    
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

$TBC_MIN_GROSS=$ORIG_EXPECTED_SUM-$ORIG_TBC_SUM;
$TBC_MIN = number_format($TBC_MIN_GROSS, 2);

     $simply_EXPECTED_SUM = ($simply_biz/100) * $TBC_MIN_GROSS;
        $GROSS_MIN_TBC=$TBC_MIN_GROSS-$simply_EXPECTED_SUM;
$FORMATTED_TBC_MIN = number_format($GROSS_MIN_TBC, 2);
}
$formattedmissing = number_format($MISSING_SUM, 2);



    echo '<tr>';
    if(isset($datefrom)) {
    echo "<td>£$formattedexpected</td>";
    echo "<td>£$FORMATTED_TBC_MIN</td>";
    echo "<td>£$PENDING_SUM</td>";   
    }
    else {
     echo "<td>£$PENDING_SUM</td>";    
    }
    echo "<td>£$TBC_SUM</td>"; 
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
    <th>ADL vs RAW DIFF</th>
    <th>EST Missing</th> 
    </tr>
    </thead>
    
    <tr>
        <td><?php echo "£$formattedtotalgross"; ?></td>
        <td><?php echo "£$formattedtotalloss"; ?></td>
        <td><?php echo "£$formattedtotalnet"; ?></td>
        <td><?php echo "£$formattedhwifsd"; ?></td>
        <td><?php echo "£$formattednetcom"; ?></td>
        <td><?php echo "£$formattedtotmis"; ?></td>
        <td><?php echo "£$formattedmissing"; ?></td>
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
                </div>
                </div>
        <div id="RAW" class="tab-pane fade">
                <div class="container">
                    
<?php
if(isset($datefrom)){

$query = $pdo->prepare("select client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_client, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate ORDER by royal_london_financials.royal_london_comm DESC");
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
    echo "<td>".$row['royal_london_client']."</td>";
      if (intval($row['royal_london_comm'])>0) {
       echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }
       else if (intval($row["royal_london_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['royal_london_comm']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }


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
                <?php
                if(isset($datefrom)){
                    
                    

$query = $pdo->prepare("select id AS PID, client_id AS CID, client_name, policy_number, policystatus, commission, DATE(sale_date) AS SALE_DATE
FROM client_policy
WHERE insurer='Royal London' AND DATE(sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT like '%tbc%' AND client_policy.policy_number NOT like '%DU%'");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>
    <tr>
    <th colspan='3'>EXPECTED for <?php echo "$commdate ($count records) | Total £$formattedexpected"; ?></th>
    </tr>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
    </tr>
    </thead>
    
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
    $ORIG_EXP_COMMISSION=$row['commission'];
    
        $simply_EXP_COMMISSION = ($simply_biz/100) * $ORIG_EXP_COMMISSION;
        $EXP_COMMISSION=$ORIG_EXP_COMMISSION-$simply_EXP_COMMISSION;      

    echo '<tr>';
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($EXP_COMMISSION)>0) {
       echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
       else if (intval($EXP_COMMISSION)<0) {
           echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

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
        
            <div id="PENDING" class="tab-pane fade">
                <div class="container">

                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select DATE(sale_date) AS SALE_DATE, policystatus, client_name, id AS PID, client_id AS CID, policy_number, commission 
FROM client_policy
WHERE DATE(sale_date) BETWEEN '2017-01-01' AND :dateto AND policy_number NOT IN(select royal_london_policy from royal_london_financials) AND insurer='Royal London' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') AND policy_number NOT like '%DU%' ORDER BY commission DESC");
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Pending for <?php echo "2017-01-01 to $dateto ($count records) | Total £$PENDING_SUM | ADL £$ORIG_PENDING_SUM_FOR"; ?></th>
    </tr>
<th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
    $ORIG_EXP_COMMISSION=$row['commission'];
    
        $simply_EXP_COMMISSION = ($simply_biz/100) * $ORIG_EXP_COMMISSION;
        $EXP_COMMISSION=$ORIG_EXP_COMMISSION-$simply_EXP_COMMISSION;      

    echo '<tr>';
    echo "<td>".$row['SALE_DATE']."</td>";
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($EXP_COMMISSION)>0) {
       echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
       else if (intval($EXP_COMMISSION)<0) {
           echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Pending Policies Found!</div>";
}


} else {

$query = $pdo->prepare("select DATE(sale_date) AS SALE_DATE, policystatus, client_name, id AS PID, client_id AS CID, policy_number, commission 
FROM client_policy
WHERE DATE(sale_date) BETWEEN '2017-01-01' AND CURDATE() AND policy_number NOT IN(select royal_london_policy from royal_london_financials) AND insurer='Royal London' AND policystatus NOT like '%CANCELLED%' AND policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') AND policy_number NOT like '%DU%' ORDER BY commission DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Pending for <?php echo "2017-01-01 to" ;?> <?php echo date('Y-m-d'); ?> <?php echo " ($count records) | Total £$PENDING_SUM | ADL £$ORIG_PENDING_SUM_FOR"; ?></th>
    </tr>
<th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
    $ORIG_EXP_COMMISSION=$row['commission'];
    
        $simply_EXP_COMMISSION = ($simply_biz/100) * $ORIG_EXP_COMMISSION;
        $EXP_COMMISSION=$ORIG_EXP_COMMISSION-$simply_EXP_COMMISSION;      

    echo '<tr>';
    echo "<td>".$row['SALE_DATE']."</td>";
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($EXP_COMMISSION)>0) {
       echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
       else if (intval($EXP_COMMISSION)<0) {
           echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

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
        
            
            <div id="MISSING" class="tab-pane fade">
                <div class="container">

                <?php
                if(isset($datefrom)){

$query = $pdo->prepare("select DATE(client_policy.sale_date) AS SALE_DATE, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' AND client_policy.policy_number NOT like '%tbc%' ");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Missing for <?php echo "$commdate ($count records) | Total £$formattedmissing | ADL £$ORIG_MISSING_SUM"; ?></th>
    </tr>
<th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
    $ORIG_EXP_COMMISSION=$row['commission'];
    
        $simply_EXP_COMMISSION = ($simply_biz/100) * $ORIG_EXP_COMMISSION;
        $EXP_COMMISSION=$ORIG_EXP_COMMISSION-$simply_EXP_COMMISSION;      

    echo '<tr>';
    echo "<td>".$row['SALE_DATE']."</td>";
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($EXP_COMMISSION)>0) {
       echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
       else if (intval($EXP_COMMISSION)<0) {
           echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}


}                 else{

$query = $pdo->prepare("select client_policy.policystatus, DATE(client_policy.sale_date) AS SALE_DATE, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE client_policy.policy_number NOT like '%tbc%' AND client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' ORDER BY client_policy.commission DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>Missing for <?php echo "$commdate ($count records) | Total £$formattedmissing | ADL £$ORIG_MISSING_SUM"; ?></th>
    </tr>
    <th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
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
       else if (intval($row["royal_london_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['commission']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

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
        
        
            <div id="TBC" class="tab-pane fade">
                <div class="container">

                <?php
                if(isset($datefrom)){  
                    
$query = $pdo->prepare("select DATE(client_policy.sale_date) AS sale_date, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.insurer='Royal London' AND client_policy.policystatus IN ('Awaiting Policy Number','Live Awaiting Policy Number') ORDER BY DATE(client_policy.sale_date)");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>TBC for <?php echo "$commdate ($count records)| Total £$TBC_SUM | ADL £$ORIG_TBC_SUM"; ?></th>
    </tr>
    <th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){
    
    $ORIG_EXP_COMMISSION=$row['commission'];
    
        $simply_EXP_COMMISSION = ($simply_biz/100) * $ORIG_EXP_COMMISSION;
        $EXP_COMMISSION=$ORIG_EXP_COMMISSION-$simply_EXP_COMMISSION;      

    echo '<tr>';
    echo "<td>".$row['sale_date']."</td>";
    echo "<td><a href='/Life/ViewPolicy.php?policyID=".$row['PID']."&search=".$row['CID']."' target='_blank'>".$row['policy_number']."</a></td>";
    echo "<td>".$row['client_name']."</td>";
      if (intval($EXP_COMMISSION)>0) {
       echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
       else if (intval($EXP_COMMISSION)<0) {
           echo "<td><span class=\"label label-danger\">$EXP_COMMISSION</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">$EXP_COMMISSION</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No TBC Policies found</div>";
}


}                 else{

$query = $pdo->prepare("select client_policy.policystatus, DATE(client_policy.sale_date) AS SALE_DATE, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE 
FROM client_policy
LEFT JOIN royal_london_financials ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE client_policy.policy_number NOT IN(select royal_london_financials.royal_london_policy from royal_london_financials) AND client_policy.insurer='Royal London' AND client_policy.policystatus IN ('Awaiting Policy Number','Live Awaiting Policy Number') OR client_policy.policy_number like '%tbc%' AND client_policy.insurer='Royal London' ORDER BY client_policy.commission DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>TBC <?php echo "($count records) | Total £$TBC_SUM | ADL £$ORIG_TBC_SUM"; ?></th>
    </tr>
    <th>Sale Date</th>
    <th>Policy</th>
    <th>Client</th>
    <th>ADL Amount</th>
    <th>ADL Status</th>
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
       else if (intval($row["commission"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['commission']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['commission']."</span></td>"; }
echo "<td><span class=\"label label-default\">".$row['policystatus']."</span></td>";

    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No TBC policies found!</div>";
}


} 


?>
            </div>                
                
            </div>        
            
            <div id="POLINDATE" class="tab-pane fade">
                <div class="container">
                <?php
                if(isset($datefrom)){
                    
    $POLIN_SUM_QRY = $pdo->prepare("select sum(royal_london_financials.royal_london_comm) AS royal_london_comm FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
    $POLIN_SUM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
    $POLIN_SUM_QRY->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
    $POLIN_SUM_QRY->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
        $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
        $POLIN_SUM_QRY_RS=$POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['royal_london_comm'];                                         
    
$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
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
    <th colspan='3'>Policies in date range <?php echo "$dateto - $datefrom with COMM date of $commdate ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
      if (intval($row['royal_london_comm'])>0) {
       echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }
       else if (intval($row["royal_london_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['royal_london_comm']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }


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
    <?php if(isset($datefrom)) {   ?>
    <form action="?datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto;?>&commdate=<?php echo $commdate; ?>#POLOUTDATE" method="POST">
    <div class="form-group col-xs-3">
  <label class="col-md-4 control-label" for="query"></label>
    <select id="FILTER" name="FILTER" class="form-control" onchange="this.form.submit()" required>
        <option>Select to filter by paid or deductions</option>
        <option <?php if(isset($FILTER)) { if($FILTER=='1') { echo "selected"; } } ?> value="1">Late Paid</option>
        <option <?php if(isset($FILTER)) { if($FILTER=='2') { echo "selected"; } } ?> value="2">Late Deductions</option>

    </select>
</div>
    </form>    
    
    <?php } 
    
    if(isset($datefrom) && isset($FILTER)) { 
        if($FILTER=='1') {
        
$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto) AND royal_london_financials.Payment_Amount >='0'");
    
        }

     if($FILTER=='2') {
         $query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto) AND royal_london_financials.Payment_Amount <'0'");
    
     }   
        
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
      if (intval($row['royal_london_comm'])>0) {
       echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }
       else if (intval($row["royal_london_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['royal_london_comm']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }


    echo "</tr>";
    echo "\n";
    } ?>
    </table>
                
                <?php
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}        
        
    }
    
    if(isset($datefrom) && !isset($FILTER)) {         

$query = $pdo->prepare("select client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, royal_london_financials.royal_london_policy, royal_london_financials.royal_london_comm, DATE(royal_london_financials.royal_london_insert_date) AS COMM_DATE 
FROM royal_london_financials 
LEFT JOIN client_policy ON royal_london_financials.royal_london_policy=client_policy.policy_number 
WHERE DATE(royal_london_financials.royal_london_insert_date) = :commdate AND client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto)");
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
      if (intval($row['royal_london_comm'])>0) {
       echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }
       else if (intval($row["royal_london_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['royal_london_comm']."</span></td>"; }
           else {
               echo "<td><span class=\"label label-success\">".$row['royal_london_comm']."</span></td>"; }


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
                <?php
                if(isset($datefrom)){
               
    $COMMIN_SUM_QRY = $pdo->prepare("select sum(royal_london_financials.royal_london_comm) AS royal_london_comm from royal_london_financials LEFT JOIN client_policy on royal_london_financials.royal_london_policy=client_policy.policy_number where royal_london_financials.royal_london_comm >= 0 AND DATE(royal_london_financials.royal_london_insert_date) =:commdate AND client_policy.insurer ='Royal London'");
    $COMMIN_SUM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
        $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
        $COMMIN_SUM_QRY_RS=$COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['royal_london_comm'];                            
$COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

$query = $pdo->prepare("select royal_london_financials.royal_london_comm, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, royal_london_financials.royal_london_policy, client_policy.client_name, client_policy.client_id from royal_london_financials LEFT JOIN client_policy on royal_london_financials.royal_london_policy=client_policy.policy_number where royal_london_financials.royal_london_comm >= 0 AND DATE(royal_london_financials.royal_london_insert_date) =:commdate AND client_policy.insurer ='Royal London'");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>COMM IN <?php echo "with COMM date of $commdate ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
    </tr>
    <th>Date</th>
    <th>Client</th>
    <th>Policy</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['royal_london_policy'];
$PAY_AMOUNT = number_format($row['royal_london_comm'], 2);

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
                <?php
                if(isset($datefrom)){
                    
                       $COMMOUT_SUM_QRY = $pdo->prepare("select sum(royal_london_financials.royal_london_comm) AS royal_london_comm from royal_london_financials LEFT JOIN client_policy on royal_london_financials.royal_london_policy=client_policy.policy_number where royal_london_financials.royal_london_comm < 0 AND DATE(royal_london_financials.royal_london_insert_date) =:commdate AND client_policy.insurer ='Royal London'");
    $COMMOUT_SUM_QRY->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
        $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
        $COMMOUT_SUM_QRY_RS=$COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
        $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['royal_london_comm'];                            
$COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2); 

$query = $pdo->prepare("select royal_london_financials.royal_london_comm, client_policy.CommissionType, DATE(client_policy.sale_date) AS sale_date, client_policy.policy_number, royal_london_financials.royal_london_policy, client_policy.client_name, client_policy.client_id from royal_london_financials LEFT JOIN client_policy on royal_london_financials.royal_london_policy=client_policy.policy_number where royal_london_financials.royal_london_comm < 0 AND DATE(royal_london_financials.royal_london_insert_date) =:commdate AND client_policy.insurer ='Royal London'");
    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
    $count = $query->rowCount();
    ?>

<table  class="table table-hover table-condensed">

<thead>

    <tr>
    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $commdate ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
    </tr>
    <th>Date</th>
    <th>Client</th>
    <th>Policy</th>
    <th>COMM Amount</th>
    </tr>
    </thead>
<?php

while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['royal_london_policy'];
$PAY_AMOUNT = number_format($row['royal_london_comm'], 2);

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
        
                 <div id="NOMATCH" class="tab-pane fade">   
            <div class="container">
<?php

$query = $pdo->prepare("select royal_london_nomatch_insert_date , royal_london_nomatch_id, royal_london_nomatch_policy, royal_london_nomatch_comm from royal_london_nomatch");
?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Premium</th>
                    <th>Re-check ADL</th>
                </thead>
<?php 
$query->execute()or die(print_r($query->errorInfo(), true));
if ($query->rowCount()>0) {
while ($row=$query->fetch(PDO::FETCH_ASSOC)){

$policy = $row['royal_london_nomatch_policy'];
$AMOUNT = $row['royal_london_nomatch_comm'];
$iddd = $row['royal_london_nomatch_id'];

    echo '<tr>'; 
    echo"<td>".$row['royal_london_nomatch_insert_date']."</td>";
    echo "<td>$policy</td>"; 
       if (intval($row['royal_london_nomatch_comm'])>0) {
       echo "<td><span class=\"label label-success\">".$row['royal_london_nomatch_comm']."</span></td>"; }
       else if (intval($row["royal_london_nomatch_comm"])<0) {
           echo "<td><span class=\"label label-danger\">".$row['royal_london_nomatch_comm']."</span></td>"; }
           else {
               echo "<td>".$row['royal_london_nomatch_comm']."</td>"; }
               
               if(isset($datefrom)) {
                                  echo "<td><a href='../php/Financial_Recheck.php?EXECUTE=1&INSURER=RoyalLondon&RECHECK=y&finpolicynumber=$policy&AMOUNT=$AMOUNT&iddd=$iddd&datefrom=$datefrom&dateto=$dateto&commdate=$commdate' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";

               }
               
               else {
                                  echo "<td><a href='../php/Financial_Recheck.php?EXECUTE=1&INSURER=RoyalLondon&RECHECK=y&finpolicynumber=$policy&AMOUNT=$AMOUNT&iddd=$iddd' class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i></a></td>";

               }
               ?> 
                   <?php
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
                    
             <?php if(isset($datefrom)) { ?>  
                    <center>
                    <div class="col-md-12">
                        <br>
                                    <div class="form-group">
                        <div class="col-xs-4">
                            <a href='../export/Export.php?EXECUTE=1<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$commdate";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                        </div>
                  
                                   
                        <div class="col-xs-4">
                            <a href='../export/Export.php?EXECUTE=2<?php echo "&commdate=$commdate";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                        </div>
                  
                      
                        <div class="col-xs-4">
                            <a href='../export/Export.php?EXECUTE=3<?php echo "&datefrom=$datefrom&dateto=$dateto";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                        </div>
                    </div>
                        <br>
                    </div>
                                            <div class="col-md-12">
                        <br>
                                    <div class="form-group">
                        <div class="col-xs-4">
                            <a href='../export/Export.php?EXECUTE=4<?php echo "&datefrom=$datefrom&dateto=$dateto&commdate=$commdate";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                        </div>
                  
                                   
                        <div class="col-xs-4">
                            <a href='../export/Export.php?EXECUTE=5<?php echo "&commdate=$commdate";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                        </div>
                  
                      
                        <div class="col-xs-4">
                        <a href='../export/Export.php?EXECUTE=6<?php echo "&datefrom=$datefrom&dateto=$dateto";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> TBC</a>

                        </div>
                    </div>
                        <br>
                    </div>
                        
                        <div class="col-md-12"><br>
                                                    <div class="col-xs-4">
                        <a href='../export/Export.php?EXECUTE=7<?php echo "&datefrom=$datefrom&dateto=$dateto";?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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