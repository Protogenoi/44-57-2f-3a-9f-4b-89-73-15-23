<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /../../../index.php?AccessDenied');
    die;
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENCY = filter_input(INPUT_GET, 'AGENCY', FILTER_SANITIZE_SPECIAL_CHARS);

    $YEAR=date('Y');
    $MONTH=date('M');
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Compliance Dash</title>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.css">
        <link href="/resources/templates/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../../includes/NAV.php'); ?> 
        <br>
        <div class="container-fluid">

            <div class="row">
               <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
               
<div class="col-6">
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <center><strong><?php if(isset($AGENCY)) { echo $AGENCY; } else { echo "$COMPANY_ENTITY Main Dashboard"; }  ?><br>
                        <?php if(isset($hello_name)) { echo $hello_name; } ?> </strong></center></div>	
<?php if (isset($EXECUTE)) {

     if($EXECUTE=='3') { ?>
    
    
                        <div class="row">
                            <article class="col-12">
                                <h2>Agents Stat Overview</h2>
                                
<?php
      $QUERY = $pdo->prepare("SELECT 
    closer,
    COUNT(IF(policystatus = 'Live', 1, NULL)) AS Live,
    COUNT(IF(type = 'DTA', 1, NULL)) AS DTA,
    COUNT(IF(type = 'LTA', 1, NULL)) AS LTA,
    COUNT(IF(type = 'DTA CIC', 1, NULL)) AS DTA_CIC,
    COUNT(IF(type = 'LTA CIC', 1, NULL)) AS LTA_CIC,
    COUNT(IF(ews_status_status = 'CFO', 1, NULL)) AS CFO,
    COUNT(IF(ews_status_status = 'Lapsed',
        1,
        NULL)) AS Lapsed,
    employee_id
FROM
    client_policy
        LEFT JOIN
    ews_data ON client_policy.policy_number = ews_data.policy_number
        JOIN
    employee_details ON client_policy.closer = CONCAT(employee_details.firstname,
            ' ',
            employee_details.lastname)
WHERE
    MONTH(sale_date) = MONTH(CURDATE())
        AND YEAR(sale_date) = YEAR(CURDATE())
        AND client_policy.insurer = 'Legal and General'
GROUP BY closer");
     $QUERY->execute();
    
                                if ($QUERY->rowCount() > 0) {

?>

       <table id="ClientListTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Sales</th>
                                        <th>Standard</th>
                                        <th>CIC</th>
                                        <th>CFO</th>
                                        <th>Lapsed</th>
                                        <th>CR</th>
                                        <th>View Profile</th>
                                    </tr>
                                </thead>
                                <?php 
                                
                                while ($result = $QUERY->fetch(PDO::FETCH_ASSOC)) {
                                    
                                    if(isset($result['closer'] )) {
                                    $STAT_ADVISOR=$result['closer'] ;
                                    }
                                    if(isset($result['Live'])) {
                                    $STAT_SALES=$result['Live'];
                                    }
                                    if(isset($result['LTA'])) {
                                    $STAT_LTA=$result['LTA'];
                                    }  
                                    if(isset($result['LTA_CIC'])) {
                                    $STAT_LTA_CIC=$result['LTA_CIC'];
                                    } 
                                    if(isset($result['DTA'])) {
                                    $STAT_DTA=$result['DTA'];
                                    }  
                                    if(isset($result['DTA_CIC'])) {
                                    $STAT_DTA_CIC=$result['DTA_CIC'];
                                    }                                        
                                    if(isset($result['CFO'])) {
                                    $STAT_CFO=$result['CFO'];
                                    }
                                    if(isset($result['Lapsed'])) {
                                    $STAT_LAPSED=$result['Lapsed'];
                                    }
                                    if(isset($result['employee_id'])) {
                                    $STAT_FK=$result['employee_id'];
                                    }
                                    
                                    $CR_STAT=($STAT_CFO/$STAT_SALES)*100;
                                    $CR_PER=number_format($CR_STAT, 2);
                                    $STAT_STAN=$STAT_LTA+$STAT_DTA;
                                    $STAT_CIC=$STAT_LTA_CIC+$STAT_DTA_CIC;
                                    
                                    echo "<tr><td>$STAT_ADVISOR</td>
                                    <td>$STAT_SALES</td>
                                    <td>$STAT_STAN</td>
                                    <td>$STAT_CIC</td>    
                                    <td>$STAT_CFO</td>
                                    <td>$STAT_LAPSED</td>
                                    <td>$CR_PER%</td>    
                                    <td><a href='/addon/Staff/ViewEmployee.php?REF=$STAT_FK' target='_blank'><i class='fa fa-search'></i></a> </td>    
                                    ";
                                }
                                
                                
                                
                              ?> </table> <?php } 
                                ?>

                            </article>
                        </div>    
    
    
        
 <?php   }
     
    if($EXECUTE=='1') { ?>

                        <div class="row">
                            <article class="col-12">
                                <h2>Life Insurance</h2>
                                <p>Put your knowledge to the test with this Life insurance test!</p>
                                
                                    <p><a href="tests/Life.php?AGENCY=<?php echo $COMPANY_ENTITY; ?>" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Insurance Test</a>
                                    <a href="tests/Protection.php?AGENCY=<?php echo $COMPANY_ENTITY; ?>" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Protection Test</a>

                            </article>
                        </div>
                        <hr>
                        <div class="row">
                            <article class="col-12">
                                <h2>Documents</h2>
                                <p>Upload or read through Compliance guidelines and documents.</p>
 <?php                               
                                      $UP_CAT = $pdo->prepare("
                                            SELECT
                                                compliance_uploads_category
                                            FROM
                                                compliance_uploads
                                            GROUP BY 
                                                compliance_uploads_Category");
                                      $UP_CAT->execute();
    
                                if ($UP_CAT->rowCount() > 0) { ?>
                                <p>   
                                    <?php
                                    
                                while ($result = $UP_CAT->fetch(PDO::FETCH_ASSOC)) {
                                    
                                    $UPLOAD_CAT=$result['compliance_uploads_category'];
                                    
                                    ?>                                

                                <a href="Compliance.php?SCID=<?php echo $UPLOAD_CAT;?>" class="btn btn-outline-primary"><?php echo $UPLOAD_CAT;?></a>
                                
                                <?php } ?>
                                <a href="Compliance.php?SCID=1" class="btn btn-outline-primary">Read More</a>   
                                </p> 
                                <?php }  ?>
                                
                            </article>
                        </div>                        

                        <hr>      
                        <div class="row">
                            <article class="col-12">
                                <h2>Complaints</h2>
                                <p>Log complaints to a client profile.</p>
                                <a href="/app/SearchClients.php" class="btn btn-outline-danger"><i class="fa fa-search"></i> Search Clients</a> 
                                <a href="/app/SearchComplaints.php" class="btn btn-outline-danger"><i class="fa fa-search"></i> Search Complaints</a> 
                            </article>
                        </div>
                     
                   
                
    <?php } ?>
                 </div>
                
                    <div class="col-3">

                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-tachometer" aria-hidden="true"></i> 
                                    Statistics for this month
                                </h5>
                            </div>
                            <div class="card-block">
                                
                                 <?php 
                             
                         if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
                             if(isset($AGENCY)) {
                                   $database = new Database();
                                   
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' AND type IN ('LTA','LTA CIC','DTA','DTA CIC')");
                        $SALE_COUNT = $database->single();
                        $STAT_SALES= htmlentities($SALE_COUNT['badge']);                         
     
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA','DTA')");
                        $STAN_COUNT = $database->single();
                        $STAT_STAN= htmlentities($STAN_COUNT['badge']);
                                               
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA CIC','DTA CIC')");
                        $CIC_COUNT = $database->single();
                        $STAT_CIC= htmlentities($CIC_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='CFO' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $CFO_COUNT = $database->single();
                        $STAT_CFO= htmlentities($CFO_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='Lapsed' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $LAP_COUNT = $database->single();
                        $STAT_LAPSED= htmlentities($LAP_COUNT['badge']);  
                        
                        $database->query("SELECT SUM(compliance_sale_stats_cancel_rate) AS badge FROM compliance_sale_stats where compliance_sale_stats_company=:COMPANY AND
    compliance_sale_stats_year=:YEAR
    AND
    compliance_sale_stats_month=:MONTH");
                        $database->bind(':YEAR', $YEAR);
                        $database->bind(':MONTH', $MONTH);                        
                        $database->bind(':COMPANY', $AGENCY);
                        $RATE_COUNT = $database->single();
                        $STAT_CANCEL_RATE= htmlentities($RATE_COUNT['badge']);   
                        
                        if($STAT_SALES >0) {
                        
                                $STAT_STAN_PERCENT=($STAT_STAN/$STAT_SALES)*100;
                                $STAT_CIC_PERCENT=($STAT_CIC/$STAT_SALES)*100;
                                $STAT_CFO_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                $STAT_LAPSED_PERCENT=($STAT_LAPSED/$STAT_SALES)*100;
                                $STAT_CANCEL_RATE_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                
                        }
                             }
                             
                             if(!isset($AGENCY)) {
                                 
                             
                             $database = new Database();
                             
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' AND type IN ('LTA','LTA CIC','DTA','DTA CIC')");
                        $SALE_COUNT = $database->single();
                        $STAT_SALES= htmlentities($SALE_COUNT['badge']);                         
     
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA','DTA')");
                        $STAN_COUNT = $database->single();
                        $STAT_STAN= htmlentities($STAN_COUNT['badge']);
                                               
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA CIC','DTA CIC')");
                        $CIC_COUNT = $database->single();
                        $STAT_CIC= htmlentities($CIC_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='CFO' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $CFO_COUNT = $database->single();
                        $STAT_CFO= htmlentities($CFO_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='Lapsed' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $LAP_COUNT = $database->single();
                        $STAT_LAPSED= htmlentities($LAP_COUNT['badge']);  
                        
                        $database->query("SELECT SUM(compliance_sale_stats_cancel_rate) AS badge FROM compliance_sale_stats WHERE
    compliance_sale_stats_year=:YEAR
    AND
    compliance_sale_stats_month=:MONTH");
                        $database->bind(':YEAR', $YEAR);
                        $database->bind(':MONTH', $MONTH);                        
                        $RATE_COUNT = $database->single();
                        $STAT_CANCEL_RATE= htmlentities($RATE_COUNT['badge']);   
                        
                        if($STAT_SALES >0) {
                                $STAT_STAN_PERCENT=($STAT_STAN/$STAT_SALES)*100;
                                $STAT_CIC_PERCENT=($STAT_CIC/$STAT_SALES)*100;
                                $STAT_CFO_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                $STAT_LAPSED_PERCENT=($STAT_LAPSED/$STAT_SALES)*100;
                                $STAT_CANCEL_RATE_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                
                        }
                             }
                         }
                         
                         else {
                             
                         $database = new Database();  
                         
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' AND type IN ('LTA','LTA CIC','DTA','DTA CIC')");
                        $SALE_COUNT = $database->single();
                        $STAT_SALES= htmlentities($SALE_COUNT['badge']);                         
     
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA','DTA')");
                        $STAN_COUNT = $database->single();
                        $STAT_STAN= htmlentities($STAN_COUNT['badge']);
                                               
                        $database->query("SELECT COUNT(id) AS badge FROM client_policy where insurer='Legal and General' AND MONTH(submitted_date) = MONTH(CURDATE()) AND YEAR(submitted_date) = YEAR(CURDATE()) AND policystatus='Live' and type IN ('LTA CIC','DTA CIC')");
                        $CIC_COUNT = $database->single();
                        $STAT_CIC= htmlentities($CIC_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='CFO' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $CFO_COUNT = $database->single();
                        $STAT_CFO= htmlentities($CFO_COUNT['badge']);
                        
                        $database->query("SELECT COUNT(id) AS badge FROM ews_data where ews_Status_status='Lapsed' AND MONTH(policy_start_date) = MONTH(CURDATE()) AND YEAR(policy_start_date) = YEAR(CURDATE())");
                        $LAP_COUNT = $database->single();
                        $STAT_LAPSED= htmlentities($LAP_COUNT['badge']);    
                        
                        $database->query("SELECT SUM(compliance_sale_stats_cancel_rate) AS badge FROM compliance_sale_stats where compliance_sale_stats_company=:COMPANY   AND
    compliance_sale_stats_year=:YEAR
    AND
    compliance_sale_stats_month=:MONTH");
                        $database->bind(':YEAR', $YEAR);
                        $database->bind(':MONTH', $MONTH);                        
                        $database->bind(':COMPANY', $COMPANY_ENTITY);
                        $RATE_COUNT = $database->single();
                        $STAT_CANCEL_RATE= htmlentities($RATE_COUNT['badge']);   
                        
                        if($STAT_SALES >0) {
                        
                                $STAT_STAN_PERCENT=($STAT_STAN/$STAT_SALES)*100;
                                $STAT_CIC_PERCENT=($STAT_CIC/$STAT_SALES)*100;
                                $STAT_CFO_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                $STAT_LAPSED_PERCENT=($STAT_LAPSED/$STAT_SALES)*100;
                                
                                 $STAT_CANCEL_RATE_PERCENT=($STAT_CFO/$STAT_SALES)*100;
                                
                        }
                        
                         }
                                   
                        ?>

                                <div class="text-center" id="progress-caption-1">Sales <?php if(isset($STAT_SALES)) { echo $STAT_SALES; } else { echo 0; } ?></div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php if(isset($STAT_SALES)) { echo $STAT_SALES; } else { echo 0; } ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">Standard Policies &hellip; <?php if(isset($STAT_STAN_PERCENT)) { echo number_format($STAT_STAN_PERCENT, 2); } else { echo 0; } ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php if(isset($STAT_STAN_PERCENT)) { echo number_format($STAT_STAN_PERCENT, 2); } else { echo 0; } ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">CIC Policies &hellip; <?php if(isset($STAT_CIC_PERCENT)) { echo number_format($STAT_CIC_PERCENT, 2); } else { echo 0; } ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php if(isset($STAT_CIC_PERCENT)) { echo number_format($STAT_CIC_PERCENT, 2); } else { echo 0; } ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                 <div class="text-center" id="progress-caption-1">CFO &hellip; <?php if(isset($STAT_CFO_PERCENT)) { echo number_format($STAT_CFO_PERCENT, 2); } else { echo 0; } ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php if(isset($STAT_CFO_PERCENT)) { echo number_format($STAT_CFO_PERCENT, 2); } else { echo 0; } ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">Lapsed &hellip; <?php if(isset($STAT_LAPSED_PERCENT)) { echo number_format($STAT_LAPSED_PERCENT, 2); } else { echo 0; } ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php if(isset($STAT_LAPSED_PERCENT)) { echo number_format($STAT_LAPSED_PERCENT, 2); } else { echo 0; } ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                                                <div class="text-center" id="progress-caption-1">Cancel Rate &hellip; <?php if(isset($STAT_CANCEL_RATE_PERCENT)) { echo number_format($STAT_CANCEL_RATE_PERCENT, 2); } else { echo 0; } ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php if(isset($STAT_CANCEL_RATE_PERCENT)) { echo number_format($STAT_CANCEL_RATE_PERCENT, 2); } else { echo 0; } ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>                       
                        <!-- Text Panel -->
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    Legal and General Call Audits
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php 
                             
                         if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
                             if(isset($AGENCY)) {
                                   $database = new Database();                      
     
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Green' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $GREEN_COUNT = $database->single();
                        $GREEN_VAR= htmlentities($GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Amber' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AMBER_COUNT = $database->single();
                        $AMBER_VAR= htmlentities($AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Red' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RED_COUNT = $database->single();
                        $RED_VAR= htmlentities($RED_COUNT['badge']); 
                             }
                             
                             if(!isset($AGENCY)) {
                                 
                             
                             $database = new Database();                
     
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Green' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $GREEN_COUNT = $database->single();
                        $GREEN_VAR= htmlentities($GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Amber' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AMBER_COUNT = $database->single();
                        $AMBER_VAR= htmlentities($AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Red' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RED_COUNT = $database->single();
                        $RED_VAR= htmlentities($RED_COUNT['badge']);                             
                             }
                         }
                         
                         else {
                             
                         $database = new Database();                        
     
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Green' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $GREEN_COUNT = $database->single();
                        $GREEN_VAR= htmlentities($GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Amber' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AMBER_COUNT = $database->single();
                        $AMBER_VAR= htmlentities($AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(id) AS badge FROM closer_audits where grade='Red' AND YEARWEEK(`date_submitted`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RED_COUNT = $database->single();
                        $RED_VAR= htmlentities($RED_COUNT['badge']);
                        
                         }
                                   
                        ?><center>
                            <p><button type="button" class="btn btn-secondary bg-success">Green (<?php if(isset($GREEN_VAR) && $GREEN_VAR>=1) { echo $GREEN_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-warning">Amber (<?php if(isset($AMBER_VAR) && $AMBER_VAR>=1) { echo $AMBER_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-danger">Red (<?php if(isset($RED_VAR) && $RED_VAR>=1) { echo $RED_VAR; }  else { echo "0"; } ?>)</button></p>
                        </center>

                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    Royal London Call Audits
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php 
                             
                             $database = new Database();                
     
                        $database->query("SELECT count(audit_id) AS badge FROM RoyalLondon_Audit where grade='Green' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RL_GREEN_COUNT = $database->single();
                        $RL_GREEN_VAR= htmlentities($RL_GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(audit_id) AS badge FROM RoyalLondon_Audit where grade='Amber' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RL_AMBER_COUNT = $database->single();
                        $RL_AMBER_VAR= htmlentities($RL_AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(audit_id) AS badge FROM RoyalLondon_Audit where grade='Red' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $RL_RED_COUNT = $database->single();
                        $RL_RED_VAR= htmlentities($RL_RED_COUNT['badge']);  

                        ?>
                                <center>
                            <p><button type="button" class="btn btn-secondary bg-success">Green (<?php if(isset($RL_GREEN_VAR) && $RL_GREEN_VAR>=1) { echo $RL_GREEN_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-warning">Amber (<?php if(isset($RL_AMBER_VAR) && $RL_AMBER_VAR>=1) { echo $RL_AMBER_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-danger">Red (<?php if(isset($RL_RED_VAR) && $RL_RED_VAR>=1) { echo $RL_RED_VAR; }  else { echo "0"; } ?>)</button></p>
                                </center>

                            </div>
                        </div>  
                              
                        
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    One Family Call Audits
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php 
                             
                        $database->query("SELECT count(wol_id) AS badge FROM audit_wol where grade='Green' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $OF_GREEN_COUNT = $database->single();
                        $OF_GREEN_VAR= htmlentities($OF_GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(wol_id) AS badge FROM audit_wol where grade='Amber' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $OF_AMBER_COUNT = $database->single();
                        $OF_AMBER_VAR= htmlentities($OF_AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(wol_id) AS badge FROM audit_wol where grade='Red' AND YEARWEEK(`added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $OF_RED_COUNT = $database->single();
                        $OF_RED_VAR= htmlentities($OF_RED_COUNT['badge']);  

                        ?>
                                <center>
                            <p><button type="button" class="btn btn-secondary bg-success">Green (<?php if(isset($OF_GREEN_VAR) && $OF_GREEN_VAR>=1) { echo $OF_GREEN_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-warning">Amber (<?php if(isset($OF_AMBER_VAR) && $OF_AMBER_VAR>=1) { echo $OF_AMBER_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-danger">Red (<?php if(isset($OF_RED_VAR) && $OF_RED_VAR>=1) { echo $OF_RED_VAR; }  else { echo "0"; } ?>)</button></p>
                                </center>

                            </div>
                        </div>                           
                        
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    Aviva Call Audits
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php 
                             
                        $database->query("SELECT count(aviva_audit_id) AS badge FROM aviva_audit where aviva_audit_grade='Green' AND YEARWEEK(`aviva_audit_added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AV_GREEN_COUNT = $database->single();
                        $AV_GREEN_VAR= htmlentities($AV_GREEN_COUNT['badge']);
                                               
                        $database->query("SELECT count(aviva_audit_id) AS badge FROM aviva_audit where aviva_audit_grade='Amber' AND YEARWEEK(`aviva_audit_added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AV_AMBER_COUNT = $database->single();
                        $AV_AMBER_VAR= htmlentities($AV_AMBER_COUNT['badge']);
                        
                        $database->query("SELECT count(aviva_audit_id) AS badge FROM aviva_audit where aviva_audit_grade='Red' AND YEARWEEK(`aviva_audit_added_date`, 1) = YEARWEEK(CURDATE(), 1)");
                        $AV_RED_COUNT = $database->single();
                        $AV_RED_VAR= htmlentities($AV_RED_COUNT['badge']);  

                        ?>
                                <center>
                            <p><button type="button" class="btn btn-secondary bg-success">Green (<?php if(isset($AV_GREEN_VAR) && $AV_GREEN_VAR>=1) { echo $AV_GREEN_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-warning">Amber (<?php if(isset($AV_AMBER_VAR) && $AV_AMBER_VAR>=1) { echo $AV_AMBER_VAR; }  else { echo "0"; } ?>)</button>
                        <button type="button" class="btn btn-secondary bg-danger">Red (<?php if(isset($AV_RED_VAR) && $AV_RED_VAR>=1) { echo $AV_RED_VAR; }  else { echo "0"; } ?>)</button></p>
                                </center>

                            </div>
                        </div>                           
                        
                    </div>
<?php } ?>
            </div>
        </div>


        <script src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/resources/templates/bootstrap/js/bootstrap.min.js"></script>

        <script>
            // Initialize tooltip component
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            // Initialize popover component
            $(function () {
                $('[data-toggle="popover"]').popover()
            })
        </script> 


    </body>

</html>
