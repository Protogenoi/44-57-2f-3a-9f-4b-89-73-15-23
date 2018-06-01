<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/  

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php');

$LOGOUT_ACTION = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$FEATURE = filter_input(INPUT_GET, 'FEATURE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($LOGOUT_ACTION) && $LOGOUT_ACTION == "log_out") {
	$page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();

if(!in_array($hello_name, $ANYTIME_ACCESS,true)) {

if($TRACKED_IP!='81.145.167.66') {
    header('Location: /../../../index.php?TIME=1');
}
}

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->UpdateToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL <=0) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        } 

$DATE = filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
$TIME_FROM = filter_input(INPUT_GET, 'TIME_FROM', FILTER_SANITIZE_SPECIAL_CHARS);
$TIME_TO = filter_input(INPUT_GET, 'TIME_TO', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Close Rates</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="stylesheet" href="/resources/templates/ADL/wallboard.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="icon" type="/image/x-icon" href="/img/favicon.ico"  />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <style>
        .vertical-center-row {
            display: table-cell;
            vertical-align: middle;
        }
        .backcolour {
            background-color:#05668d !important;
        }     
h1 {
    font-size: 600%;
}
    </style>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
</head>
<body class="backcolour">
    <div class="contain-to-grid">
        
        
        
        <?php
        
        if(empty($DATE)) { ?>
     <br>
     <br>
     <br>
     <br>
    <div class="col-md-12">    
        
        <form>
         
<form class="form-horizontal" method="GET" action="">
<fieldset>

<div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date' id='datetimepicker1'>
                                                                        <input type='text' class="form-control" id="DATE" name="DATE" placeholder="YYYY-MM-DD" value="<?php
                                                                        if (isset($DATE)) {
                                                                            echo $DATE;
                                                                        }
                                                                        ?>" required />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                       

                                                        <div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date clockpicker'>
                                                                        <input type='text' class="form-control" id="TIME_FROM" name="TIME_FROM" placeholder="24 Hour Format" value="<?php
                                                                        if (isset($TIME_FROM)) {
                                                                            echo $TIME_FROM;
                                                                        }
                                                                        ?>" required  />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-time"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
    <div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date clockpicker'>
                                                                        <input type='text' class="form-control" id="TIME_TO" name="TIME_TO" placeholder="24 Hour Format" value="<?php
                                                                        if (isset($TIME_TO)) {
                                                                            echo $TIME_TO;
                                                                        }
                                                                        ?>" required  />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-time"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
 <div class="btn-group">
                                                        <button class="btn btn-primary"><i class='fa  fa-check-circle-o'></i> Set time and date</button>
                                                    </div>    

</fieldset>
</form>

           
    </div>   
    <?php    }
                        
        elseif(isset($DATE)) {
        
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT 
closer,
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
 COUNT(IF(sale IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'QNQ',
            'DIDNO',
            'QCBK',
            'QQQ',
            'Other',
            'QML'),
        1,
        NULL)) AS Leads
FROM
    closer_trackers

WHERE
TIME(date_added) BETWEEN :TIME_FROM AND :TIME_TO
                                    AND
                                        DATE(date_added) = :DATE 
GROUP BY closer
ORDER BY Sales, Leads");
        ?>

        <table id='main2' cellspacing='0' cellpadding='10'>

            <?php
            $query->bindParam(':DATE', $DATE, PDO::PARAM_STR);
            $query->bindParam(':TIME_FROM', $TIME_FROM, PDO::PARAM_STR);
            $query->bindParam(':TIME_TO', $TIME_TO, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                    $Sales = $result['Sales'];
                    $Leads = $result['Leads'];
                    $CLOSER_NAME = $result['closer'];

                    switch ($CLOSER_NAME) {
                        case("Richard"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Kyle"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Kyle Barnett"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            $CLOSER_NAME = "Kyle";  
                            break;                        
                        case("Sarah"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0;
                            break;
                        case("Sarah Wallace"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            $CLOSER_NAME = "Sarah";  
                            break;                            
                        case("James"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Aron Davies"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $CLOSER_NAME = "Aron";  
                            break;
                        case("Ryan Tidball"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $CLOSER_NAME = "Ryan";  
                            break;                        
                        case("Molly Grove"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $CLOSER_NAME = "Molly";  
                            break;                                      
                        default:
                            $LEADS = $Leads;
                            $SALES = $Sales;
                            break;
                    }

                    if ($SALES == '0') {
                        $Formattedrate = "0.0";
                        $CR_BG_COL = "bgcolor='white'";
                    } else {
                        $Conversionrate = $LEADS / $SALES;
                        $Formattedrate = number_format($Conversionrate, 1);
                    }

                    if ($Formattedrate >4.9 && $Formattedrate<6) {
                        $CR_BG_COL = "bgcolor='orange'";
                    }
                    if ($Formattedrate <=4.9 && $Formattedrate >= 1) {
                        $CR_BG_COL = "bgcolor='green'";
                    }
                    if ($Formattedrate >= 6) {
                        $CR_BG_COL = "bgcolor='red'";
                    }
                    echo '<td ' . $CR_BG_COL . '><strong style="font-size: 50px;">' . $CLOSER_NAME . ' <br>' . $LEADS . '/' . $SALES . '<br>' . $Formattedrate . '</strong></td>';
                }
            }
            ?>
        </table>

<?php    

    require_once(__DIR__ . '/models/CLOSERS/TIME_WARNING.php');
    $TRACKER_WARNING = new TRACKER_WARNINGModal($pdo);
    $TRACKER_WARNINGList = $TRACKER_WARNING->getTRACKER_WARNING($TIME_TO,$TIME_FROM,$DATE);
    require_once(__DIR__ . '/views/CLOSERS/WARNING.php');   
     

        $TRACKER = $pdo->prepare("SELECT
                                        insurer, 
                                        date_updated, 
                                        tracker_id, 
                                        agent, 
                                        closer, 
                                        client, 
                                        current_premium, 
                                        our_premium, 
                                        comments, 
                                        sale, 
                                        date_updated 
                                    FROM 
                                        closer_trackers 
                                    WHERE 
                                        TIME(date_updated) BETWEEN :TIME_FROM AND :TIME_TO
                                    AND
                                        DATE(date_added) = :DATE                                       
                                    ORDER BY 
                                        date_added DESC");
        $TRACKER->bindParam(':DATE', $DATE, PDO::PARAM_STR);
        $TRACKER->bindParam(':TIME_FROM', $TIME_FROM, PDO::PARAM_STR);
        $TRACKER->bindParam(':TIME_TO', $TIME_TO, PDO::PARAM_STR);
        $TRACKER->execute();
        if ($TRACKER->rowCount() > 0) {
            ?>

            <table id="tracker" class="table" id="users">
                <thead>
                    <tr>
                        <th>Closer</th>
                        <th>Agent</th>
                        <th>Client</th>
                        <th>Current Premium</th>
                        <th>Our Premium</th>
                        <th>Notes</th>
                        <th>Insurer</th>
                        <th>DISPO</th>
                    </tr>
                </thead> <?php
                while ($TRACKERresult = $TRACKER->fetch(PDO::FETCH_ASSOC)) {
                    
                    $TRK_tracker_id = $TRACKERresult['tracker_id'];
                    $TRK_agent = $TRACKERresult['agent'];
                    $TRK_closer = $TRACKERresult['closer'];
                    $TRK_client = $TRACKERresult['client'];

                    $TRK_current_premium = $TRACKERresult['current_premium'];
                    $TRK_our_premium = $TRACKERresult['our_premium'];
                    $TRK_comments = $TRACKERresult['comments'];
                    $TRK_sale = $TRACKERresult['sale'];
                    $TRK_INSURER = $TRACKERresult['insurer'];

                    switch ($TRK_sale) {
                        case "QCBK":
                            $TRK_sale = "Quoted Callback";
                            $TRK_BG = "#cc99ff";
                            break;
                        case "SALE":
                            $TRK_sale = "SALE";
                            $TRK_BG = "#00ff00";
                            break;
                        case "QQQ":
                            $TRK_sale = "Quoted";
                            $TRK_BG = "#66ccff";
                            break;
                        case "NoCard":
                            $TRK_sale = "No Card Details";
                            $TRK_BG = "##cc0000";
                            break;
                        case "QUN":
                            $TRK_sale = "Underwritten";
                            $TRK_BG = "#ff0066";
                            break;
                        case "QNQ":
                            $TRK_sale = "No Quote";
                            $TRK_BG = "#ffcc00";
                            break;
                        case "DIDNO":
                            $TRK_sale = "Quote Not Beaten";
                            $TRK_BG = "#ff6600";
                            break;
                        case "QML":
                            $TRK_sale = "Quote Mortgage Lead";
                            $TRK_BG = "#669900";
                            break;
                        case "QDE":
                            $TRK_sale = "Decline";
                            $TRK_BG = "#FF0000";
                            break;
                         case "Thought we were an insurer":
                            $TRK_sale = "Insurer";
                            $TRK_BG = "#ff33cc";
                            break;
                         case "Hangup on XFER":
                            $TRK_sale = "Hang Up";
                            $TRK_BG = "#ff33cc";
                            break;
                        default:
                            $TRK_sale = $TRK_sale;
                            $TRK_BG = "#ffffff";
                    }
                    
                    switch ($TRK_closer) {
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
                        case("James"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Aron Davies"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $TRK_closer = "Aron";  
                            break;
                        case("Ryan Tidball"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $TRK_closer = "Ryan";  
                            break;                        
                        case("Molly Grove"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $TRK_closer = "Molly";  
                            break;               
                        case("David Bebee"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0; 
                            $TRK_closer = "Bebee";                         
                        default:
                            $LEADS = $Leads;
                            $SALES = $Sales;
                            break;
                    }
                    ?>

                    <tr>
                        <td bgcolor="#ffffff"> <strong style="font-size: 40px;"> <?php echo $TRK_closer; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_agent; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_client; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_current_premium; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_our_premium; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_comments; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_INSURER; ?></strong></td>
                        <td bgcolor="<?php echo $TRK_BG; ?>"><strong style="font-size: 40px;"><?php echo $TRK_sale; ?></strong></td>

                    <?php
                    }
                }
                ?>          
        </table> 
  <form>
         
<form class="form-horizontal" method="GET" action="">
<fieldset>

<div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date' id='datetimepicker1'>
                                                                        <input type='text' class="form-control" id="DATE" name="DATE" placeholder="YYYY-MM-DD" value="<?php
                                                                        if (isset($DATE)) {
                                                                            echo $DATE;
                                                                        }
                                                                        ?>" required />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                       

                                                        <div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date clockpicker'>
                                                                        <input type='text' class="form-control" id="TIME_FROM" name="TIME_FROM" placeholder="24 Hour Format" value="<?php
                                                                        if (isset($TIME_FROM)) {
                                                                            echo $TIME_FROM;
                                                                        }
                                                                        ?>" required  />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-time"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
    <div class="row">
                                                            <div class='col-md-4'>
                                                                <div class="form-group">
                                                                    <div class='input-group date clockpicker'>
                                                                        <input type='text' class="form-control" id="TIME_TO" name="TIME_TO" placeholder="24 Hour Format" value="<?php
                                                                        if (isset($TIME_TO)) {
                                                                            echo $TIME_TO;
                                                                        }
                                                                        ?>" required  />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-time"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
 <div class="btn-group">
                                                        <button class="btn btn-warning"><i class='fa  fa-check-circle-o'></i> Update</button>
                                                    </div>    

</fieldset>
</form>

           
    </div>        
 <?php } ?>  
     
 <script>
    $(function () {
        $("#DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>       
    </div>    
</body>
</html>