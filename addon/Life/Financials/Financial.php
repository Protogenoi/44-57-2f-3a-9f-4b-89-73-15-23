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

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

require_once(BASE_URL.'/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(BASE_URL.'/includes/user_tracking.php'); 

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');
require_once(BASE_URL.'/includes/ADL_PDO_CON.php');
require_once(BASE_URL.'/classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
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

$DATE_FROM=date("Y-m-d");

$DATETO = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$DATEFROM = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

$RL_DATE_FROM = filter_input(INPUT_GET, 'RL_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$RL_DATE_TO = filter_input(INPUT_GET, 'RL_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$RL_COMM_DATE = filter_input(INPUT_GET, 'RL_commdate', FILTER_SANITIZE_SPECIAL_CHARS);


$WOL_DATE_FROM = filter_input(INPUT_GET, 'WOL_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$WOL_DATE_TO = filter_input(INPUT_GET, 'WOL_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$WOL_COMM_DATE = filter_input(INPUT_GET, 'WOL_commdate', FILTER_SANITIZE_SPECIAL_CHARS);

$AVI_DATE_FROM = filter_input(INPUT_GET, 'AVI_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$AVI_DATE_TO = filter_input(INPUT_GET, 'AVI_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$AVI_COMM_DATE = filter_input(INPUT_GET, 'AVI_commdate', FILTER_SANITIZE_SPECIAL_CHARS);

$LV_DATE_FROM = filter_input(INPUT_GET, 'LV_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$LV_DATE_TO = filter_input(INPUT_GET, 'LV_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$LV_COMM_DATE = filter_input(INPUT_GET, 'LV_commdate', FILTER_SANITIZE_SPECIAL_CHARS);

$ZURICH_DATE_FROM = filter_input(INPUT_GET, 'Zurich_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$ZURICH_DATE_TO = filter_input(INPUT_GET, 'Zurich_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$ZURICH_COMM_DATE = filter_input(INPUT_GET, 'Zurich_commdate', FILTER_SANITIZE_SPECIAL_CHARS);

$SCOTTISH_WIDOWS_DATE_FROM = filter_input(INPUT_GET, 'Scottish_Widows_datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$SCOTTISH_WIDOWS_DATE_TO = filter_input(INPUT_GET, 'Scottish_Widows_dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$SCOTTISH_WIDOWS_COMM_DATE = filter_input(INPUT_GET, 'Scottish_Widows_commdate', FILTER_SANITIZE_SPECIAL_CHARS);

$COMM_DATE = filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);

                    $simply_biz = "5.0";

        $ADL_PAGE_TITLE = "Financials";
        require_once(BASE_URL.'/app/core/head.php'); 
        
        ?> 
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">  
</head>
<body>

    <?php require_once(BASE_URL.'/includes/navbar.php'); ?>

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

                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle\"></i> Success:</strong> Policy found on recheck!</div>");
            }

            if ($RECHECK == 'n') {

                print("<div class=\"notice notice-danger\" role=\"alert\" ><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy not found on recheck!</div>");
            }
        } echo "<br>";
        ?>
         
         <div class="panel panel-primary">
             <div class="panel-heading">
                 <h3 class="panel-title"><a data-toggle="collapse" href="#DATEScollapse1">Dates</a></h3>
             </div>
             <div id="DATEScollapse1" class="panel-collapse collapse">
                 <div class="panel-body">
                     
                     <form action=" " method="GET" class="">
                         <fieldset>
                             
                         <div class="col-xs-12">
                             
                             <div class="form-group">
                                 <label>Vitality</label>
                             </div>
                             
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($DATEFROM)) {
                                        echo $DATEFROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($DATETO)) {
                                        echo $DATETO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="commdate">
                                        <?php
                                        $VIT_COM_DATE = $pdo->prepare("SELECT 
                                                        DATE(vitality_financial_uploaded_date) AS vitality_financial_uploaded_date
                                                    FROM 
                                                        vitality_financial 
                                                    group by 
                                                        DATE(vitality_financial_uploaded_date) 
                                                    ORDER BY 
                                                        vitality_financial_uploaded_date DESC");
                                        $VIT_COM_DATE->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($VIT_COM_DATE->rowCount() > 0) {
                                            while ($row = $VIT_COM_DATE->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['vitality_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['vitality_financial_uploaded_date']; ?>" <?php if($COMM_DATE == $row['vitality_financial_uploaded_date'] ) { echo "selected"; } ?> ><?php echo $row['vitality_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>
                         </div>
                             
                 <div class="col-xs-12">
                     
                      <div class="form-group">
                          <label>Royal London</label>
                             </div>
                     
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="RL_datefrom" name="RL_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($RL_DATE_FROM)) {
                                        echo $RL_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="RL_dateto" name="RL_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($RL_DATE_TO)) {
                                        echo $RL_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="RL_commdate">
                                        <?php
                                        $RL_COM_DATE_query = $pdo->prepare("SELECT 
                                                        DATE(royal_london_financial_uploaded_date) AS royal_london_financial_uploaded_date
                                                    FROM 
                                                        royal_london_financial 
                                                    group by 
                                                        DATE(royal_london_financial_uploaded_date) 
                                                    ORDER BY 
                                                        royal_london_financial_uploaded_date DESC");
                                        $RL_COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($RL_COM_DATE_query->rowCount() > 0) {
                                            while ($row = $RL_COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['royal_london_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['royal_london_financial_uploaded_date']; ?>" <?php if($RL_COMM_DATE == $row['royal_london_financial_uploaded_date']) { echo "selected"; } ?> ><?php echo $row['royal_london_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div>
                             
 <div class="col-xs-12">
     
      <div class="form-group">
          <label>One Family</label>
                             </div>
     
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="WOL_datefrom" name="WOL_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($WOL_DATE_FROM)) {
                                        echo $WOL_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="WOL_dateto" name="WOL_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($WOL_DATE_TO)) {
                                        echo $WOL_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="WOL_commdate">
                                        <?php
                                        $COM_DATE_query = $pdo->prepare("SELECT 
                                                        DATE(one_family_financial_uploaded_date) AS one_family_financial_uploaded_date
                                                    FROM 
                                                        one_family_financial 
                                                    group by 
                                                        DATE(one_family_financial_uploaded_date) 
                                                    ORDER BY 
                                                        one_family_financial_uploaded_date DESC");
                                        $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($COM_DATE_query->rowCount() > 0) {
                                            while ($row = $COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['one_family_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['one_family_financial_uploaded_date']; ?>"><?php echo $row['one_family_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div>  
                             
 <div class="col-xs-12">
     
      <div class="form-group">
          <label>Aviva</label>
                             </div>
     
     
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="AVI_datefrom" name="AVI_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($AVI_DATE_FROM)) {
                                        echo $AVI_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="AVI_dateto" name="AVI_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($AVI_DATE_TO)) {
                                        echo $AVI_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="AVI_commdate">
                                        <?php
                                        $COM_DATE_query = $pdo->prepare("SELECT 
                                                        DATE(aviva_financial_uploaded_date) AS aviva_financial_uploaded_date
                                                    FROM 
                                                        aviva_financial 
                                                    group by 
                                                        DATE(aviva_financial_uploaded_date) 
                                                    ORDER BY 
                                                        aviva_financial_uploaded_date DESC");
                                        $COM_DATE_query->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($COM_DATE_query->rowCount() > 0) {
                                            while ($row = $COM_DATE_query->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['aviva_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['aviva_financial_uploaded_date']; ?>"><?php echo $row['aviva_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div> 
                             
                             <div class="col-xs-12">
                                 
                                 
                                  <div class="form-group">
                                      <label>LV</label>
                             </div>
                                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="LV_datefrom" name="LV_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($LV_DATE_FROM)) {
                                        echo $LV_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="LV_dateto" name="LV_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($LV_DATE_TO)) {
                                        echo $LV_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="LV_commdate">
                                        <?php
                                        $LV_COM_DATE = $pdo->prepare("SELECT 
                                                        DATE(lv_financial_uploaded_date) AS lv_financial_uploaded_date
                                                    FROM 
                                                        lv_financial 
                                                    group by 
                                                        DATE(lv_financial_uploaded_date) 
                                                    ORDER BY 
                                                        lv_financial_uploaded_date DESC");
                                        $LV_COM_DATE->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($LV_COM_DATE->rowCount() > 0) {
                                            while ($row = $LV_COM_DATE->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['lv_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['lv_financial_uploaded_date']; ?>"><?php echo $row['lv_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div>   
                             
<div class="col-xs-12">
                                 
                                 
                                  <div class="form-group">
                                      <label>Zurich</label>
                             </div>
                                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="Zurich_datefrom" name="Zurich_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($ZURICH_DATE_FROM)) {
                                        echo $ZURICH_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="Zurich_dateto" name="Zurich_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($ZURICH_DATE_TO)) {
                                        echo $ZURICH_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="Zurich_commdate">
                                        <?php
                                        $Zurich_COM_DATE = $pdo->prepare("SELECT 
                                                        DATE(lv_financial_uploaded_date) AS lv_financial_uploaded_date
                                                    FROM 
                                                        lv_financial 
                                                    group by 
                                                        DATE(lv_financial_uploaded_date) 
                                                    ORDER BY 
                                                        lv_financial_uploaded_date DESC");
                                        $Zurich_COM_DATE->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($Zurich_COM_DATE->rowCount() > 0) {
                                            while ($row = $Zurich_COM_DATE->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['lv_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['lv_financial_uploaded_date']; ?>"><?php echo $row['lv_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div> 
                             
<div class="col-xs-12">
                                 
                                 
                                  <div class="form-group">
                                      <label>Scottish_Widows</label>
                             </div>
                                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="Scottish_Widows_datefrom" name="Scottish_Widows_datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($SCOTTISH_WIDOWS_DATE_FROM)) {
                                        echo $SCOTTISH_WIDOWS_DATE_FROM;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-4">
                                    <input type="text" id="Scottish_Widows_dateto" name="Scottish_Widows_dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($SCOTTISH_WIDOWS_DATE_TO)) {
                                        echo $SCOTTISH_WIDOWS_DATE_TO;
                                    } else { echo $DATE_FROM; }
                                    ?>" required>
                                </div>
                            </div>                 
                 
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <select class="form-control" name="Scottish_Widows_commdate">
                                        <?php
                                        $Scottish_Widows_COM_DATE = $pdo->prepare("SELECT 
                                                        DATE(lv_financial_uploaded_date) AS lv_financial_uploaded_date
                                                    FROM 
                                                        lv_financial 
                                                    group by 
                                                        DATE(lv_financial_uploaded_date) 
                                                    ORDER BY 
                                                        lv_financial_uploaded_date DESC");
                                        $Scottish_Widows_COM_DATE->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($Scottish_Widows_COM_DATE->rowCount() > 0) {
                                            while ($row = $Scottish_Widows_COM_DATE->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['lv_financial_uploaded_date'])) {
                                                    ?>
                                                    <option value="<?php echo $row['lv_financial_uploaded_date']; ?>"><?php echo $row['lv_financial_uploaded_date']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>                    
                 </div>                              
                         
                         <div class="col-xs-12">
                             
                             <br><br>
                             
                            <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-block"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                         </div>

                            </fieldset>
                        </form>  
             </div>
             </div>
                  </div>
                      <br><br>
         
        <?php if(isset($DATEFROM)) { ?> 
         
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
                                                     
//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/VITALITY/TotalMissingWithDates.php');
    $TotalMissingWithDates = new TotalMissingWithDatesModal($pdo);
    $TotalMissingWithDatesList = $TotalMissingWithDates->getTotalMissingWithDates($DATEFROM, $DATETO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/VITALITY/Total-Missing-With-Dates.php');
//END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/VITALITY/TotalAwaitingWithDates.php');
    $TotalAwaitingWithDates = new TotalAwaitingWithDatesModal($pdo);
    $TotalAwaitingWithDatesList = $TotalAwaitingWithDates->getTotalAwaitingWithDates($DATEFROM, $DATETO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/VITALITY/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/VITALITY/TotalExpectedWithDates.php');
    $TotalExpectedWithDates = new TotalExpectedWithDatesModal($pdo);
    $TotalExpectedWithDatesList = $TotalExpectedWithDates->getTotalExpectedWithDates($DATEFROM, $DATETO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/VITALITY/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$VIT_TOTAL_NEW_GROSS = $VIT_ADL_EXPECTED_SUM - $VIT_ADL_AWAITING_SUM; 
$VIT_TOTAL_NEW_GROSS_DISPLAY = number_format($VIT_TOTAL_NEW_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(vitality_policy_comms) AS commission
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sale_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'Cancelled''DECLINED',
        'On hold');
        ");
                           $EXPECTED_SUM_QRY->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $VIT_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $VIT_simply_EXPECTED_SUM;
    //END OF CALCULATION          

                            $POL_ON_TM_QRY = $pdo->prepare("SELECT 
    SUM(CASE
        WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount
        ELSE 0
    END) AS PAID_TOTAL_PLUS,
    SUM(CASE
        WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount
        ELSE 0
    END) AS PAID_TOTAL_LOSS
FROM
    vitality_financial
        LEFT JOIN
    adl_policy ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(vitality_financial_uploaded_date) = :COMMDATE
        AND adl_policy_ref IN (SELECT 
            adl_policy_ref
        FROM
            adl_policy
        WHERE
            DATE(adl_policy_sale_date) BETWEEN :DATEFROM AND :DATETO
                AND adl_policy_insurer = 'Vitality')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("SELECT 
    SUM(CASE
        WHEN vitality_financial.vitality_financial_amount >= 0 THEN vitality_financial.vitality_financial_amount
        ELSE 0
    END) AS NOT_PAID_TOTAL_PLUS,
    SUM(CASE
        WHEN vitality_financial.vitality_financial_amount < 0 THEN vitality_financial.vitality_financial_amount
        ELSE 0
    END) AS NOT_PAID_TOTAL_LOSS
FROM
    vitality_financial
        LEFT JOIN
    adl_policy ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(vitality_financial_uploaded_date) = :COMMDATE
        AND adl_policy_ref IN (SELECT 
            adl_policy_ref
        FROM
            adl_policy
        WHERE
            DATE(adl_policy_sale_date) NOT BETWEEN :DATEFROM AND :DATETO
                AND adl_policy_insurer = 'Vitality');");
                            $POL_NOT_TM_QRY->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->execute()or die(print_r($POL_NOT_TM_QRY->errorInfo(), true));
                            $POL_NOT_TM_SUM_QRY_RS = $POL_NOT_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_NOT_TM_SUM = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_PLUS'];
                            $POL_NOT_TM_SUM_LS = $POL_NOT_TM_SUM_QRY_RS['NOT_PAID_TOTAL_LOSS'];

                            $MISSING_SUM_DISPLAY_QRY = $pdo->prepare("SELECT 
    SUM(vitality_policy_comms) AS commission
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sub_date) BETWEEN '2018-01-01' AND :DATETO
        AND adl_policy_ref NOT IN (SELECT 
            vitality_financial_policy_number
        FROM
            vitality_financial)
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status NOT IN ('Awaiting' , 'Clawback',
        'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On Hold');");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_VIT_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $VIT_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_VIT_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($VIT_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$DATEFROM - $DATETO"; ?>.
                                                   
ADL <?php echo $VIT_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $VIT_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $VIT_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$DATEFROM - $DATETO  $VIT_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($DATEFROM)) { echo "within 2017-01-01 - $DATETO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($DATEFROM)) { echo "within $DATEFROM - $DATETO"; } ?>.

ADL <?php echo $VIT_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $VIT_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN vitality_financial_amount < 0 THEN vitality_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN vitality_financial_amount >= 0 THEN vitality_financial_amount ELSE 0 END) as totalgross
    FROM vitality_financial 
    WHERE 
        DATE(vitality_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);                            
                            
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
                                        echo "<td>£$VIT_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$VIT_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$VIT_ADL_AWAITING_SUM_FORMAT</td>";
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
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$COMM_DATE"; ?>.

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
                        vitality_financial.vitality_financial_life_assured_name, 
                        vitality_financial.vitality_financial_policy_number, 
                        vitality_financial.vitality_financial_amount, 
                        DATE(vitality_financial_uploaded_date) AS COMM_DATE
                    FROM
                        vitality_financial
                    WHERE 
                        DATE(vitality_financial_uploaded_date) = :commdate
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
                                echo "<td>".$row['vitality_financial_policy_number']."</td>";
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
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    vitality_policy_comms,
    DATE(adl_policy_sub_date) AS SALE_DATE
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status = 'Live'");
                    $EXPECTED_QUERY->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED (Live Policies) for <?php echo "$DATEFROM - $DATETO ($EXPECTEDcount records) | ADL £$VIT_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$VIT_ADL_EXPECTED_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            </tr>
                            </thead>

                            <?php
                            while ($row = $EXPECTED_QUERY->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['vitality_policy_comms'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION;
                                
                                ?>

                                <tr>
                                <td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=<?php echo $row['PID']; ?>&CID=<?php echo$row['CID'];?>' target='_blank'><?php echo $row['adl_policy_ref']; ?></a></td>
                                <td><?php echo $row['adl_policy_policy_holder']; ?></td>
                                <td><span class="label label-success"><?php echo $EXP_COMMISSION; ?></span></td>
                                </tr>
                                
                           <?php } ?>
                        </table>

                        <?php
                    } else {
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    }
                ?>
        </div>

        <div id="VIT_PENDING" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    vitality_policy_comms,
    adl_policy_status,
    DATE(adl_policy_sub_date) AS SUB_DATE
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sub_date) BETWEEN '2018-01-01' AND :DATETO
        AND adl_policy_ref NOT IN (SELECT 
            vitality_financial_policy_number
        FROM
            vitality_financial)
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status NOT IN ('Awaiting' , 'Clawback'
        'DECLINED',
        'On hold')
ORDER BY vitality_policy_comms DESC");
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $DATETO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                                
                            <th>Sub Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['vitality_policy_comms'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION; ?>

                                <tr>
                                    <td><?php echo $row['SUB_DATE']; ?></td>
                                    <td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=<?php echo $row['PID']; ?>&CID=<?php echo$row['CID'];?>' target='_blank'><?php echo $row['adl_policy_ref']; ?></a></td>
                                    <td><?php echo $row['adl_policy_policy_holder']; ?></td>
                                    <td><span class="label label-success"><?php echo $EXP_COMMISSION; ?></span></td>
                                    <td><span class="label label-default"><?php echo $row['adl_policy_status']; ?></span></td>
                                </tr>
                                
                          <?php  }
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
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    adl_policy_status,
    vitality_policy_comms,
    adl_policy_status,
    DATE(adl_policy_sub_date) AS SUB_DATE
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_ref NOT IN (SELECT 
            vitality_financial.vitality_financial_policy_number
        FROM
            vitality_financial)
        AND adl_policy_ref NOT IN (SELECT 
            vitality_financial.vitality_financial_policy_number
        FROM
            vitality_financial)
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status NOT IN ('Awaiting' , 'Clawback', 'DECLINED', 'On Hold')");
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sub Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['vitality_policy_comms'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION; ?>

                                <tr>
                                    <td><?php echo $row['SUB_DATE']; ?></td>
                                    <td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=<?php echo $row['PID']; ?>&CID=<?php echo $row['CID']; ?>' target='_blank'><?php echo $row['adl_policy_ref']; ?></a></td>
                                    <td><?php echo $row['adl_policy_policy_holder']; ?></td>
                                    <td><span class="label label-success"><?php echo $EXP_COMMISSION; ?></span></td>
                                    <td><span class="label label-default"><?php echo $row['adl_policy_status']; ?></span></td>
                                </tr>
                                
                          <?php } ?>
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
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    adl_policy_status,
    vitality_policy_comms,
    DATE(adl_policy_sub_date) AS SUB_DATE
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status = 'Awaiting'
ORDER BY DATE(adl_policy_sub_date)");
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$COMM_DATE ($count records) | ADL £$VIT_ADL_AWAITING_SUM_DATES_FORMAT | Total £$VIT_ADL_AWAITING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sub Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $ORIG_EXP_COMMISSION = $row['vitality_policy_comms'];
                                $AWAITING_SUB_DATE = $row['SUB_DATE'];

                                $simply_EXP_COMMISSION = ($simply_biz / 100) * $ORIG_EXP_COMMISSION;
                                $EXP_COMMISSION = $ORIG_EXP_COMMISSION - $simply_EXP_COMMISSION; ?>

                                <tr>
                                    <td><?php echo $row['SUB_DATE']; ?></td>
                                    <td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=<?php echo $row['PID']; ?>&CID=<?php echo $row['CID']; ?>' target='_blank'><?php echo $row['adl_policy_ref']; ?></a></td>
                                    <td><?php echo $row['adl_policy_policy_holder']; ?></td>
                                    <td><span class="label label-success"><?php echo $EXP_COMMISSION; ?></span></td>
                                    <td><span class="label label-default"><?php echo $row['adl_policy_status']; ?></span></td>
                                </tr>
                                
                          <?php } ?>
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
    SUM(vitality_financial.vitality_financial_amount) AS vitality_financial_amount
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(vitality_financial_uploaded_date) = :COMMDATE
        AND adl_policy_ref IN (SELECT 
            adl_policy_ref
        FROM
            adl_policy
        WHERE
            DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
                AND adl_policy_insurer = 'Vitality')");
                    $POLIN_SUM_QRY->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['vitality_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    vitality_policy_comms,
    vitality_financial.vitality_financial_policy_number,
    vitality_financial.vitality_financial_amount
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(vitality_financial_uploaded_date) = :COMMDATE
        AND adl_policy_ref IN (SELECT 
            adl_policy_ref
        FROM
            adl_policy
        WHERE
            DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
                AND adl_policy_insurer = 'Vitality')");
                    $query->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$DATETO - $DATEFROM with COMM date of $COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=" . $row['PID'] . "&CID=" . $row['CID'] . "' target='_blank'>" . $row['adl_policy_ref'] . "</a></td>";
                                echo "<td>" . $row['adl_policy_policy_holder'] . "</td>";
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
    vitality_policy_id AS PID,
    adl_policy_client_id_fk AS CID,
    adl_policy_policy_holder,
    adl_policy_ref,
    vitality_policy_comms,
    adl_policy_status,
    vitality_financial.vitality_financial_policy_number,
    vitality_financial.vitality_financial_amount,
    DATE(vitality_financial_uploaded_date) AS COMM_DATE
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(vitality_financial_uploaded_date) = :COMMDATE
        AND adl_policy_ref IN (SELECT 
            adl_policy_ref
        FROM
            adl_policy
        WHERE
            DATE(adl_policy_sub_date) NOT BETWEEN :DATEFROM AND :DATETO
                AND adl_policy_insurer = 'Vitality');");
                    $query->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$DATETO - $DATEFROM with COMM date of $COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=" . $row['PID'] . "&CID=" . $row['CID'] . "' target='_blank'>" . $row['adl_policy_ref'] . "</a></td>";
                                echo "<td>" . $row['adl_policy_policy_holder'] . "</td>";
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
                            WHERE 
                                DATE(vitality_financial_uploaded_date) =:commdate ");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            vitality_financial.vitality_financial_amount, 
                            vitality_financial.vitality_financial_policy_number,
                            vitality_financial_life_assured_name
                        FROM 
                            vitality_financial 

                        WHERE 
                            vitality_financial.vitality_financial_amount >= 0 
                        AND 
                            DATE(vitality_financial_uploaded_date) =:commdate");
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
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                echo "<td>$policy</td>";
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
                                sum(vitality_financial_amount) AS vitality_financial_amount 
                            FROM 
                                vitality_financial 
                            WHERE 
                                vitality_financial_amount < 0
                            AND 
                                DATE(vitality_financial_uploaded_date) =:commdate");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['vitality_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
    vitality_financial_amount,
    vitality_financial_policy_number,
    vitality_financial_life_assured_name
FROM
    vitality_financial
WHERE
    vitality_financial_amount < 0
        AND DATE(vitality_financial_uploaded_date) = :COMMDATE");
                    $query->bindParam(':COMMDATE', $COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
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
                                echo "<td>" . $row['vitality_financial_life_assured_name'] . "</td>";
                                echo "<td>$policy</td>";
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
                            if (intval($row['vitality_financial_nomatch_amount']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else if (intval($row["vitality_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['vitality_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['vitality_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Recheck.php?EXECUTE=1&INSURER=Vitality&BRID=$iddd&AMOUNT=$paytype&POLICY=$policy' class='btn btn-success btn-sm'><i class='fa fa-check-circle'></i></a></td>";
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Vitality' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
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
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$DATEFROM&dateto=$DATETO&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$DATEFROM&dateto=$DATETO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$DATEFROM&dateto=$DATETO&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$DATEFROM&dateto=$DATETO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$DATEFROM&dateto=$DATETO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                        $RL_nomatchbadge = $pdo->query("SELECT COUNT(royal_london_financial_nomatch_id) AS badge from royal_london_financial_nomatch");
                        $RL_row = $RL_nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($RL_row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="RL_home" class="tab-pane fade in active">

                
                        <?php

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ROYAL/TotalMissingWithDates.php');
    $RL_TotalMissingWithDates = new RL_TotalMissingWithDatesModal($pdo);
    $RL_TotalMissingWithDatesList = $RL_TotalMissingWithDates->RL_getTotalMissingWithDates($RL_DATE_FROM, $RL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ROYAL/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ROYAL/TotalAwaitingWithDates.php');
    $RL_TotalAwaitingWithDates = new RL_TotalAwaitingWithDatesModal($pdo);
    $RL_TotalAwaitingWithDatesList = $RL_TotalAwaitingWithDates->RL_getTotalAwaitingWithDates($RL_DATE_FROM, $RL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ROYAL/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ROYAL/TotalExpectedWithDates.php');
    $RL_TotalExpectedWithDates = new RL_TotalExpectedWithDatesModal($pdo);
    $RL_TotalExpectedWithDatesList = $RL_TotalExpectedWithDates->RL_getTotalExpectedWithDates($RL_DATE_FROM, $RL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ROYAL/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$RL_TOTAL_NEW_GROSS = $RL_ADL_EXPECTED_SUM - $RL_ADL_AWAITING_SUM; 
$RL_TOTAL_NEW_GROSS_DISPLAY = number_format($RL_TOTAL_NEW_GROSS, 2);                                       
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
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $RL_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $RL_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(royal_london_financial_commission_debits_amount) as totalloss,
    SUM(royal_london_financial_commission_credit_amount) as totalgross
    FROM 
        royal_london_financial 
    WHERE 
        DATE(royal_london_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("SELECT 
    SUM(royal_london_financial_commission_credit_amount) as PAID_TOTAL_PLUS,
    SUM(royal_london_financial_commission_debits_amount) as PAID_TOTAL_LOSS 
    FROM 
        royal_london_financial 
    LEFT JOIN 
        client_policy 
    ON 
        royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number 
    WHERE 
        DATE(royal_london_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='Royal London')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(royal_london_financial_commission_credit_amount) as NOT_PAID_TOTAL_PLUS,
                                    SUM(royal_london_financial_commission_debits_amount) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    royal_london_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                                WHERE 
                                    DATE(royal_london_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number 
                                IN
                                    (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Royal London')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select royal_london_financial_plan_number FROM royal_london_financial)
                                    AND 
                                        insurer='Royal London'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_RL_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $RL_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_RL_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($RL_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $RL_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$RL_DATE_FROM - $RL_DATE_TO"; ?>.
                                                   
ADL <?php echo $RL_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $RL_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $RL_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $RL_DATE_FROM; ?>&dateto=<?php echo $RL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$RL_DATE_FROM - $RL_DATE_TO  $RL_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $RL_DATE_FROM; ?>&dateto=<?php echo $RL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($RL_DATE_FROM)) { echo "within 2017-01-01 - $RL_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $RL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($RL_DATE_FROM)) { echo "within $RL_DATE_FROM - $RL_DATE_TO"; } ?>.

ADL <?php echo $RL_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $RL_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $RL_DATE_FROM; ?>&dateto=<?php echo $RL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

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
                                        echo "<td>£$RL_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$RL_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$RL_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $RL_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$RL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$RL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$RL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$RL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$RL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$RL_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $RL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $RL_COMM_DATE"; ?></th>
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
                        royal_london_financial.royal_london_financial_plan_owner, 
                        royal_london_financial.royal_london_financial_plan_number, 
                        royal_london_financial.royal_london_financial_commission_credit_amount,
                        royal_london_financial.royal_london_financial_commission_debits_amount,
                        DATE(royal_london_financial_uploaded_date) AS COMM_DATE
                    FROM
                        royal_london_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                    WHERE 
                        DATE(royal_london_financial.royal_london_financial_uploaded_date) = :COMM_DATE
                    AND
                        client_policy.insurer='Royal London'
                    ORDER BY 
                        royal_london_financial.royal_london_financial_commission_credit_amount DESC");
                    $query->bindParam(':COMM_DATE', $RL_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$RL_COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['royal_london_financial_plan_owner'] . "</td>";
                                if (intval($row['royal_london_financial_commission_credit_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_credit_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                }
                                if (intval($row['royal_london_financial_commission_debits_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_debits_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
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
        AND insurer = 'Royal London'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Royal London'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $RL_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $RL_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$RL_COMM_DATE ($EXPECTEDcount records) | ADL £$RL_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$RL_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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

                    $RL_PENDING = $pdo->prepare("
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
                                policy_number NOT IN(select royal_london_financial_plan_number FROM royal_london_financial) 
                            AND
                                insurer='Royal London'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $RL_PENDING->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                    $RL_PENDING->execute()or die(print_r($RL_PENDING->errorInfo(), true));
                    if ($RL_PENDING->rowCount() > 0) {
                        $count = $RL_PENDING->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $RL_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $RL_PENDING->fetch(PDO::FETCH_ASSOC)) {

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
                
                    $RL_MISSING = $pdo->prepare("
                        SELECT
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            royal_london_financial.royal_london_financial_plan_number,
                            royal_london_financial.royal_london_financial_commission_credit_amount,
                            royal_london_financial.royal_london_financial_commission_debits_amount,
                            DATE(royal_london_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            royal_london_financial
                        ON 
                            royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(SELECT royal_london_financial.royal_london_financial_plan_number FROM royal_london_financial) 
                        AND 
                            client_policy.insurer='Royal London'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $RL_MISSING->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
                    $RL_MISSING->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                    $RL_MISSING->execute()or die(print_r($RL_MISSING->errorInfo(), true));
                    if ($RL_MISSING->rowCount() > 0) {
                        $count = $RL_MISSING->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$RL_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
                                </tr>
                            <th>Sale Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ADL Amount</th>
                            <th>ADL Status</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $RL_MISSING->fetch(PDO::FETCH_ASSOC)) {

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

                    $RL_AWAITING = $pdo->prepare("
                        SELECT
                            client_policy.application_number,
                            DATE(client_policy.submitted_date) AS submitted_date,
                            client_policy.policystatus,
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            royal_london_financial.royal_london_financial_plan_number,
                            royal_london_financial.royal_london_financial_commission_credit_amount,
                            royal_london_financial.royal_london_financial_commission_debits_amount,
                            DATE(royal_london_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            royal_london_financial
                        ON 
                            royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Royal London'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $RL_AWAITING->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
                    $RL_AWAITING->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                    $RL_AWAITING->execute()or die(print_r($RL_AWAITING->errorInfo(), true));
                    if ($RL_AWAITING->rowCount() > 0) {
                        $count = $RL_AWAITING->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$RL_COMM_DATE ($count records) | ADL £$RL_ADL_AWAITING_SUM_DATES_FORMAT | Total £$RL_ADL_AWAITING_SUM_FORMAT"; ?></th>
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
                            while ($row = $RL_AWAITING->fetch(PDO::FETCH_ASSOC)) {

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
                
                    $RL_POLIN_SUM = $pdo->prepare("
                        SELECT 
                            sum(royal_london_financial.royal_london_financial_commission_credit_amount) AS PLUS_AMOUNT 
                        FROM 
                            royal_london_financial
                        LEFT JOIN 
                            client_policy ON royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                        WHERE 
                            DATE(royal_london_financial.royal_london_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Royal London')");
                    $RL_POLIN_SUM->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $RL_POLIN_SUM->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                    $RL_POLIN_SUM->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
                    $RL_POLIN_SUM->execute()or die(print_r($RL_POLIN_SUM->errorInfo(), true));
                    $RL_POLIN_SUM_RS = $RL_POLIN_SUM->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $RL_POLIN_SUM_RS['PLUS_AMOUNT'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            royal_london_financial.royal_london_financial_plan_number,
                            royal_london_financial.royal_london_financial_commission_credit_amount,
                            royal_london_financial.royal_london_financial_commission_debits_amount,
                            DATE(royal_london_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            royal_london_financial
                        LEFT JOIN 
                            client_policy ON royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                        WHERE 
                            DATE(royal_london_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (SELECT client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto AND insurer='Royal London')");
                    $query->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$RL_DATE_TO - $RL_DATE_FROM with COMM date of $RL_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>Credits</th>
                            <th>Debits</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['royal_london_financial_commission_credit_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_credit_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                }
            
                                if (intval($row['royal_london_financial_commission_debits_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_debits_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
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
                            royal_london_financial.royal_london_financial_commission_credit_amount,
                            royal_london_financial.royal_london_financial_commission_debits_amount,
                            royal_london_financial.royal_london_financial_plan_number, 
                            DATE(royal_london_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            royal_london_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                        WHERE 
                            DATE(royal_london_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (SELECT client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Royal London')");
                    $query->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$RL_DATE_TO - $RL_DATE_FROM with COMM date of $RL_COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>Credit</th>
                            <th>Debits</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($row['royal_london_financial_commission_credit_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_credit_amount"]) < 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-default\">" . $row['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                }
                                
                                if (intval($row['royal_london_financial_commission_debits_amount']) > 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else if (intval($row["royal_london_financial_commission_debits_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-default\">" . $row['royal_london_financial_commission_debits_amount'] . "</span></td>";
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
                                sum(royal_london_financial_commission_credit_amount) AS PAID
                            FROM 
                                royal_london_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                            WHERE 
                                DATE(royal_london_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Royal London'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['PAID'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            royal_london_financial_commission_credit_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            royal_london_financial.royal_london_financial_plan_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            royal_london_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number 
                        WHERE 
                            royal_london_financial.royal_london_financial_commission_credit_amount > 0 
                        AND 
                            DATE(royal_london_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Royal London'");
                    $query->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $RL_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>Credits</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['royal_london_financial_plan_number'];
                                $PAY_AMOUNT = number_format($row['royal_london_financial_commission_credit_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-success\">$PAY_AMOUNT</span></td>";
                                } else if (intval($PAY_AMOUNT) <= 0) {
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
                                sum(royal_london_financial_commission_debits_amount) AS DEBITS 
                            FROM 
                                royal_london_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number
                            WHERE 
                                DATE(royal_london_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Royal London'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['DEBITS'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $RL_CLAWBACKS = $pdo->prepare("
                            SELECT 
                                royal_london_financial_commission_debits_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                royal_london_financial_plan_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                royal_london_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                royal_london_financial.royal_london_financial_plan_number=client_policy.policy_number 
                            WHERE 
                                royal_london_financial_commission_debits_amount > 0 
                            AND 
                                DATE(royal_london_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Royal London'");
                    $RL_CLAWBACKS->bindParam(':commdate', $RL_COMM_DATE, PDO::PARAM_STR, 100);
                    $RL_CLAWBACKS->execute()or die(print_r($RL_CLAWBACKS->errorInfo(), true));
                    if ($RL_CLAWBACKS->rowCount() > 0) {
                        $count = $RL_CLAWBACKS->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $RL_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>Debits</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $RL_CLAWBACKS->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['royal_london_financial_plan_number'];
                                $PAY_AMOUNT = number_format($row['royal_london_financial_commission_debits_amount'], 2);

                                echo '<tr>';
                                echo "<td>" . $row['sale_date'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td><a href='/app/Client.php?search=" . $row['client_id'] . "' target='_blank'>$policy</a></td>";
                                if (intval($PAY_AMOUNT) > 0) {
                                    echo "<td><span class=\"label label-danger\">$PAY_AMOUNT</span></td>";
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
                        echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Clawbacks</div>";
                    }
                ?>
            </div>                                

        <div id="RL_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            royal_london_financial_nomatch_id, 
                            royal_london_financial_nomatch_commission_debits_amount,
                            royal_london_financial_nomatch_commission_credit_amount,
                            royal_london_financial_nomatch_uploaded_date, 
                            royal_london_financial_nomatch_plan_number
                        FROM
                            royal_london_financial_nomatch");
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Unmatched Policies (Not on ADL)</th>
                        </tr>
                    <th>Row</th>
                    <th>Entry Date</th>
                    <th>Policy</th>
                    <th>Credits</th>
                    <th>Debits</th>
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['royal_london_financial_nomatch_plan_number'];
                            $RL_CREDITS = $row['royal_london_financial_nomatch_commission_credit_amount'];
                            $RL_DEBITS = $row['royal_london_financial_nomatch_commission_debits_amount'];
                            $iddd = $row['royal_london_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['royal_london_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if ($RL_CREDITS) {
                                echo "<td><span class=\"label label-success\">$RL_CREDITS</span></td>";
                            } else {
                                echo "<td>$RL_CREDITS</td>";
                            }
                           if ($RL_DEBITS) {
                                echo "<td><span class=\"label label-danger\">$RL_DEBITS</span></td>";
                            } else {
                                echo "<td>$RL_DEBITS</td>";
                            }                          
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Royal London' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
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
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$RL_DATE_FROM&dateto=$RL_DATE_TO&commdate=$RL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$RL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$RL_DATE_FROM&dateto=$RL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$RL_DATE_FROM&dateto=$RL_DATE_TO&commdate=$RL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$RL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$RL_DATE_FROM&dateto=$RL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$RL_DATE_FROM&dateto=$RL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                        $nomatchbadge = $pdo->query("SELECT COUNT(one_family_financial_nomatch_id) AS badge FROM one_family_financial_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="WOL_home" class="tab-pane fade in active">

                
                        <?php


//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/WOL/TotalMissingWithDates.php');
    $WOL_TotalMissingWithDates = new WOL_TotalMissingWithDatesModal($pdo);
    $WOL_TotalMissingWithDatesList = $WOL_TotalMissingWithDates->WOL_getTotalMissingWithDates($WOL_DATE_FROM, $WOL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/WOL/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/WOL/TotalAwaitingWithDates.php');
    $WOL_TotalAwaitingWithDates = new WOL_TotalAwaitingWithDatesModal($pdo);
    $WOL_TotalAwaitingWithDatesList = $WOL_TotalAwaitingWithDates->WOL_getTotalAwaitingWithDates($WOL_DATE_FROM, $WOL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/WOL/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/WOL/TotalExpectedWithDates.php');
    $WOL_TotalExpectedWithDates = new WOL_TotalExpectedWithDatesModal($pdo);
    $WOL_TotalExpectedWithDatesList = $WOL_TotalExpectedWithDates->WOL_getTotalExpectedWithDates($WOL_DATE_FROM, $WOL_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/WOL/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$WOL_TOTAL_NEW_GROSS = $WOL_ADL_EXPECTED_SUM - $WOL_ADL_AWAITING_SUM; 
$WOL_TOTAL_NEW_GROSS_DISPLAY = number_format($WOL_TOTAL_NEW_GROSS, 2);                                       
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
        ");
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $WOL_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $WOL_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='INTCOMCB' THEN one_family_financial_commission_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='BACS_OUT' THEN one_family_financial_commission_amount ELSE 0 END) as totalgross
    FROM one_family_financial
    WHERE 
        DATE(one_family_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='BACS_OUT' THEN one_family_financial_commission_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='INTCOMCB' THEN one_family_financial_commission_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        one_family_financial 
    LEFT JOIN 
        client_policy 
    ON 
        one_family_financial.one_family_financial_policy_id=client_policy.policy_number 
    WHERE 
        DATE(one_family_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='One Family')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='BACS_OUT' THEN one_family_financial_commission_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='INTCOMCB' THEN one_family_financial_commission_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    one_family_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                                WHERE 
                                    DATE(one_family_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='One Family')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select one_family_financial_policy_id from one_family_financial)
                                    AND 
                                        insurer='One Family'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_WOL_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $WOL_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_WOL_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($WOL_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $WOL_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$WOL_DATE_FROM - $WOL_DATE_TO"; ?>.
                                                   
ADL <?php echo $WOL_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $WOL_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $WOL_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $WOL_DATE_FROM; ?>&dateto=<?php echo $WOL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$WOL_DATE_FROM - $WOL_DATE_TO  $WOL_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $WOL_DATE_FROM; ?>&dateto=<?php echo $WOL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($WOL_DATE_FROM)) { echo "within 2017-01-01 - $WOL_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $WOL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($WOL_DATE_FROM)) { echo "within $WOL_DATE_FROM - $WOL_DATE_TO"; } ?>.

ADL <?php echo $WOL_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $WOL_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $WOL_DATE_FROM; ?>&dateto=<?php echo $WOL_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

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
                                    $TOTAL_NET_POS=abs($totalgross);
                                    $totalnet = $TOTAL_NET_POS - $totalloss;

                                    $hwifsd = ($totalrate / 100) * $totalnet;
                                    $netcom = $totalnet - $hwifsd;

                                   
                                        $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                        
                                        echo '<tr>';
                                        echo "<td>£$WOL_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$WOL_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$WOL_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $WOL_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$WOL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$WOL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$WOL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$WOL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$WOL_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$WOL_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $WOL_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    </tr>
                                    </thead>
                                    
                                    <?php
                                    
                                    $TOTAL_GROSS_RAW_TO_POSITIVE=abs($totalgross);
                                    $TOTAL_GROSS_RAW = number_format($TOTAL_GROSS_RAW_TO_POSITIVE, 2);
                                    
                                    $TOTAL_LOSS_RAW = number_format($totalloss, 2);
                                    $TOTAL_NET_RAW = number_format($totalnet, 2);
                                    $HWIFS_RAW = number_format($hwifsd, 2);
                                    $NET_COMM_RAW = number_format($netcom, 2); 
                                    $ADL_vs_RAW_RAW = number_format($totaldifference, 2);
                                    
                                    ?>

                                    <tr>
                                        <td><?php echo "£$TOTAL_GROSS_RAW_TO_POSITIVE"; ?></td>
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $WOL_COMM_DATE"; ?></th>
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
                        one_family_financial.one_family_financial_policy_holder_name, 
                        one_family_financial.one_family_financial_policy_id, 
                        one_family_financial.one_family_financial_commission_amount, 
                        DATE(one_family_financial_uploaded_date) AS COMM_DATE
                    FROM
                        one_family_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                    WHERE 
                        DATE(one_family_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='One Family'
                    ORDER BY 
                        one_family_financial.one_family_financial_commission_amount DESC");
                    $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$WOL_COMM_DATE ($count records)"; ?></th>
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
                                echo "<td>" . $row['one_family_financial_policy_holder_name'] . "</td>";
                                if (intval($row['one_family_financial_commission_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
                                } else if (intval($row["one_family_financial_commission_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
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
        AND insurer = 'One Family'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'One Family'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $WOL_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $WOL_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$WOL_COMM_DATE ($EXPECTEDcount records) | ADL £$WOL_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$WOL_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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
                                policy_number NOT IN(select one_family_financial_policy_id FROM one_family_financial) 
                            AND
                                insurer='One Family'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $WOL_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
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
                            one_family_financial.one_family_financial_policy_id,
                            one_family_financial.one_family_financial_commission_amount,
                            DATE(one_family_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            one_family_financial
                        ON 
                            one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select one_family_financial.one_family_financial_policy_id from one_family_financial) 
                        AND
                            client_policy.policy_number NOT IN(select one_family_financial.one_family_financial_policy_id from one_family_financial)
                        AND 
                            client_policy.insurer='One Family'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$WOL_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
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
                            one_family_financial.one_family_financial_policy_id,
                            one_family_financial.one_family_financial_commission_amount,
                            DATE(one_family_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            one_family_financial
                        ON 
                            one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='One Family'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$WOL_COMM_DATE ($count records) | ADL £$WOL_ADL_AWAITING_SUM_DATES_FORMAT | Total £$WOL_ADL_AWAITING_SUM_FORMAT"; ?></th>
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
                            SUM(one_family_financial.one_family_financial_commission_amount) AS one_family_financial_commission_amount 
                        FROM 
                            one_family_financial
                        LEFT JOIN 
                            client_policy ON one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                        WHERE 
                            DATE(one_family_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='One Family')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['one_family_financial_commission_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            one_family_financial.one_family_financial_policy_id,
                            one_family_financial.one_family_financial_commission_amount,
                            DATE(one_family_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            one_family_financial
                        LEFT JOIN 
                            client_policy ON one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                        WHERE 
                            DATE(one_family_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='One Family')");
                    $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$WOL_DATE_TO - $WOL_DATE_FROM with COMM date of $WOL_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
                                if (intval($row['one_family_financial_commission_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
                                } else if (intval($row["one_family_financial_commission_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['one_family_financial_commission_amount'] . "</span></td>";
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
                            one_family_financial.one_family_financial_policy_id, 
                            one_family_financial.one_family_financial_commission_amount, 
                            one_family_financial.one_family_financial_transaction_type,
                            DATE(one_family_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            one_family_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                        WHERE 
                            DATE(one_family_financial_uploaded_date) = :commdate
                        AND 
                        one_family_financial_transaction_type IN ('BACS_OUT','INTCOMCB')
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='One Family')");
                    $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $WOL_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $WOL_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$WOL_DATE_TO - $WOL_DATE_FROM with COMM date of $WOL_COMM_DATE ($count records)"; ?></th>
                                </tr>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                
                                if($row['one_family_financial_transaction_type'] == 'BACS_OUT') {
                                    $LATE_PAYMENTS=abs($row['one_family_financial_commission_amount']);
                                } elseif($row['one_family_financial_transaction_type'] == 'INTCOMCB') {
                                    $LATE_PAYMENTS=$row['one_family_financial_commission_amount'];
                                }

                                echo '<tr>';
                                echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=" . $row['PID'] . "&search=" . $row['CID'] . "' target='_blank'>" . $row['policy_number'] . "</a></td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                if (intval($LATE_PAYMENTS) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $LATE_PAYMENTS . "</span></td>";
                                } else if (intval($LATE_PAYMENTS) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $LATE_PAYMENTS . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $LATE_PAYMENTS . "</span></td>";
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
                                sum(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='BACS_OUT' THEN one_family_financial_commission_amount ELSE 0 END) AS one_family_financial_commission_amount
                            FROM 
                                one_family_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                            WHERE 
                                one_family_financial.one_family_financial_commission_amount < 0 
                            AND 
                                one_family_financial_transaction_type='BACS_OUT'    
                            AND 
                                DATE(one_family_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='One Family'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['one_family_financial_commission_amount'];
                    
                    $NEG_TO_POS=abs($ORIG_COMMIN_SUM);
                    
                    $COMMIN_SUM_FORMATTED = number_format($NEG_TO_POS, 2);

                    $query = $pdo->prepare("
                        SELECT
                            one_family_financial.one_family_financial_commission_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            one_family_financial.one_family_financial_policy_id, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            one_family_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            one_family_financial.one_family_financial_policy_id=client_policy.policy_number 
                        WHERE 
                            one_family_financial.one_family_financial_commission_amount < 0 
                        AND 
                           one_family_financial_transaction_type='BACS_OUT'    
                        AND 
                            DATE(one_family_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='One Family'");
                    $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $WOL_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['one_family_financial_policy_id'];
                                
                                $TOTAL_PAY_POSITIVE=abs($row['one_family_financial_commission_amount']);
                                $PAY_AMOUNT = number_format($TOTAL_PAY_POSITIVE, 2);

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
                                sum(CASE WHEN one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='INTCOMCB' THEN one_family_financial_commission_amount ELSE 0 END) AS one_family_financial_commission_amount 
                            FROM 
                                one_family_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                one_family_financial.one_family_financial_policy_id=client_policy.policy_number
                            WHERE 
                                one_family_financial.one_family_financial_commission_amount < 0 
                            AND 
                                one_family_financial_transaction_type='INTCOMCB'
                            AND 
                                DATE(one_family_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='One Family'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['one_family_financial_commission_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                one_family_financial.one_family_financial_commission_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                one_family_financial.one_family_financial_policy_id, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                one_family_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                one_family_financial.one_family_financial_policy_id=client_policy.policy_number 
                            WHERE 
                                one_family_financial.one_family_financial_commission_amount < 0 AND one_family_financial_transaction_type='INTCOMCB' AND DATE(one_family_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='One Family'");
                    $query->bindParam(':commdate', $WOL_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $WOL_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['one_family_financial_policy_id'];
                                $PAY_AMOUNT = number_format($row['one_family_financial_commission_amount'], 2);

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
                            one_family_financial_nomatch_id, 
                            one_family_financial_nomatch_commission_amount, 
                            one_family_financial_nomatch_uploaded_date, 
                            one_family_financial_nomatch_policy_id
                        FROM
                            one_family_financial_nomatch");
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
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['one_family_financial_nomatch_policy_id'];
                            $paytype = $row['one_family_financial_nomatch_commission_amount'];
                            $iddd = $row['one_family_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['one_family_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['one_family_financial_nomatch_commission_amount']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['one_family_financial_nomatch_commission_amount'] . "</span></td>";
                            } else if (intval($row["one_family_financial_nomatch_commission_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['one_family_financial_nomatch_commission_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['one_family_financial_nomatch_commission_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=One Family' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
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
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$WOL_DATE_FROM&dateto=$WOL_DATE_TO&commdate=$WOL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$WOL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$WOL_DATE_FROM&dateto=$WOL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$WOL_DATE_FROM&dateto=$WOL_DATE_TO&commdate=$WOL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$WOL_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$WOL_DATE_FROM&dateto=$WOL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$WOL_DATE_FROM&dateto=$WOL_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                        $nomatchbadge = $pdo->query("SELECT COUNT(aviva_financial_nomatch_id) AS badge from aviva_financial_nomatch");
                        $row = $nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="AVI_home" class="tab-pane fade in active">

                
                        <?php

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/AVIVA/TotalMissingWithDates.php');
    $AVI_TotalMissingWithDates = new AVI_TotalMissingWithDatesModal($pdo);
    $AVI_TotalMissingWithDatesList = $AVI_TotalMissingWithDates->AVI_getTotalMissingWithDates($AVI_DATE_FROM, $AVI_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/AVIVA/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/AVIVA/TotalAwaitingWithDates.php');
    $AVI_TotalAwaitingWithDates = new AVI_TotalAwaitingWithDatesModal($pdo);
    $AVI_TotalAwaitingWithDatesList = $AVI_TotalAwaitingWithDates->AVI_getTotalAwaitingWithDates($AVI_DATE_FROM, $AVI_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/AVIVA/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/AVIVA/TotalExpectedWithDates.php');
    $AVI_TotalExpectedWithDates = new AVI_TotalExpectedWithDatesModal($pdo);
    $AVI_TotalExpectedWithDatesList = $AVI_TotalExpectedWithDates->AVI_getTotalExpectedWithDates($AVI_DATE_FROM, $AVI_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/AVIVA/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$AVI_TOTAL_NEW_GROSS = $AVI_ADL_EXPECTED_SUM - $AVI_ADL_AWAITING_SUM; 
$AVI_TOTAL_NEW_GROSS_DISPLAY = number_format($AVI_TOTAL_NEW_GROSS, 2);                                       
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
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $AVI_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $AVI_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                            

                            $query = $pdo->prepare("SELECT 
    SUM(CASE WHEN aviva_financial_amount < 0 THEN aviva_financial_amount ELSE 0 END) as totalloss,
    SUM(CASE WHEN aviva_financial_amount >= 0 THEN aviva_financial_amount ELSE 0 END) as totalgross
    FROM aviva_financial 
    WHERE 
        DATE(aviva_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);


                            $POL_ON_TM_QRY = $pdo->prepare("select 
    SUM(CASE WHEN aviva_financial.aviva_financial_amount >= 0 THEN aviva_financial.aviva_financial_amount ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN aviva_financial.aviva_financial_amount < 0 THEN aviva_financial.aviva_financial_amount ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        aviva_financial 
    LEFT JOIN 
        client_policy 
    ON 
        aviva_financial.aviva_financial_policy=client_policy.policy_number 
    WHERE 
        DATE(aviva_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='Aviva')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN aviva_financial.aviva_financial_amount >= 0 THEN aviva_financial.aviva_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN aviva_financial.aviva_financial_amount < 0 THEN aviva_financial.aviva_financial_amount ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    aviva_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    aviva_financial.aviva_financial_policy=client_policy.policy_number
                                WHERE 
                                    DATE(aviva_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Aviva')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select aviva_financial_policy from aviva_financial)
                                    AND 
                                        insurer='Aviva'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                                    AND policy_number NOT like '%DU%'");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_AVI_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $AVI_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_AVI_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($AVI_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $AVI_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$AVI_DATE_FROM - $AVI_DATE_TO"; ?>.
                                                   
ADL <?php echo $AVI_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $AVI_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $AVI_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $AVI_DATE_FROM; ?>&dateto=<?php echo $AVI_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$AVI_DATE_FROM - $AVI_DATE_TO  $AVI_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $AVI_DATE_FROM; ?>&dateto=<?php echo $AVI_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($AVI_DATE_FROM)) { echo "within 2017-01-01 - $AVI_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $AVI_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($AVI_DATE_FROM)) { echo "within $AVI_DATE_FROM - $AVI_DATE_TO"; } ?>.

ADL <?php echo $AVI_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $AVI_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $AVI_DATE_FROM; ?>&dateto=<?php echo $AVI_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

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
                                        echo "<td>£$AVI_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$AVI_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$AVI_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $AVI_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$AVI_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$AVI_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$AVI_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$AVI_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$AVI_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$AVI_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $AVI_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $AVI_COMM_DATE"; ?></th>
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
                        aviva_financial.aviva_financial_client_name, 
                        aviva_financial.aviva_financial_policy, 
                        aviva_financial.aviva_financial_amount, 
                        DATE(aviva_financial_uploaded_date) AS COMM_DATE
                    FROM
                        aviva_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        aviva_financial.aviva_financial_policy=client_policy.policy_number
                    WHERE 
                        DATE(aviva_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Aviva'
                    ORDER BY 
                        aviva_financial.aviva_financial_amount DESC");
                    $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$AVI_COMM_DATE ($count records)"; ?></th>
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
                                echo "<td>" . $row['aviva_financial_client_name'] . "</td>";
                                if (intval($row['aviva_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else if (intval($row["aviva_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
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
        AND insurer = 'Aviva'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Aviva'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $AVI_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $AVI_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$AVI_COMM_DATE ($EXPECTEDcount records) | ADL £$AVI_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$AVI_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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
                                policy_number NOT IN(select aviva_financial_policy FROM aviva_financial) 
                            AND
                                insurer='Aviva'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            AND
                                policy_number NOT like '%DU%' 
                            ORDER BY commission DESC");
                    $query->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $AVI_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
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
                            aviva_financial.aviva_financial_policy,
                            aviva_financial.aviva_financial_amount,
                            DATE(aviva_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            aviva_financial
                        ON 
                            aviva_financial.aviva_financial_policy=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select aviva_financial.aviva_financial_policy from aviva_financial) 
                        AND
                            client_policy.policy_number NOT IN(select aviva_financial.aviva_financial_policy from aviva_financial)
                        AND 
                            client_policy.insurer='Aviva'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')
                        AND 
                            client_policy.policy_number NOT like '%DU%'");
                    $query->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$AVI_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
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
                            aviva_financial.aviva_financial_policy,
                            aviva_financial.aviva_financial_amount,
                            DATE(aviva_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            aviva_financial
                        ON 
                            aviva_financial.aviva_financial_policy=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Aviva'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$AVI_COMM_DATE ($count records) | ADL £$AVI_ADL_AWAITING_SUM_DATES_FORMAT | Total £$AVI_ADL_AWAITING_SUM_FORMAT"; ?></th>
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
                            sum(aviva_financial.aviva_financial_amount) AS aviva_financial_amount 
                        FROM 
                            aviva_financial
                        LEFT JOIN 
                            client_policy ON aviva_financial.aviva_financial_policy=client_policy.policy_number
                        WHERE 
                            DATE(aviva_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Aviva')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['aviva_financial_amount'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            aviva_financial.aviva_financial_policy,
                            aviva_financial.aviva_financial_amount,
                            DATE(aviva_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            aviva_financial
                        LEFT JOIN 
                            client_policy ON aviva_financial.aviva_financial_policy=client_policy.policy_number
                        WHERE 
                            DATE(aviva_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Aviva')");
                    $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$AVI_DATE_TO - $AVI_DATE_FROM with COMM date of $AVI_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
                                if (intval($row['aviva_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else if (intval($row["aviva_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
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
                            aviva_financial.aviva_financial_policy, 
                            aviva_financial.aviva_financial_amount, 
                            DATE(aviva_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            aviva_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            aviva_financial.aviva_financial_policy=client_policy.policy_number
                        WHERE 
                            DATE(aviva_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Aviva')");
                    $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $AVI_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $AVI_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$AVI_DATE_TO - $AVI_DATE_FROM with COMM date of $AVI_COMM_DATE ($count records)"; ?></th>
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
                                if (intval($row['aviva_financial_amount']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else if (intval($row["aviva_financial_amount"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['aviva_financial_amount'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['aviva_financial_amount'] . "</span></td>";
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
                                sum(aviva_financial.aviva_financial_amount) AS aviva_financial_amount
                            FROM 
                                aviva_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                aviva_financial.aviva_financial_policy=client_policy.policy_number
                            WHERE 
                                aviva_financial.aviva_financial_amount >= 0 
                            AND 
                                DATE(aviva_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='Aviva'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['aviva_financial_amount'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            aviva_financial.aviva_financial_amount, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            aviva_financial.aviva_financial_policy, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            aviva_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            aviva_financial.aviva_financial_policy=client_policy.policy_number 
                        WHERE 
                            aviva_financial.aviva_financial_amount >= 0 
                        AND 
                            DATE(aviva_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Aviva'");
                    $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $AVI_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['aviva_financial_policy'];
                                $PAY_AMOUNT = number_format($row['aviva_financial_amount'], 2);

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
                                SUM(aviva_financial.aviva_financial_amount) AS aviva_financial_amount 
                            FROM 
                                aviva_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                aviva_financial.aviva_financial_policy=client_policy.policy_number
                            WHERE 
                                aviva_financial.aviva_financial_amount < 0
                            AND 
                                DATE(aviva_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Aviva'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['aviva_financial_amount'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                aviva_financial.aviva_financial_amount, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                aviva_financial.aviva_financial_policy, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                aviva_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                aviva_financial.aviva_financial_policy=client_policy.policy_number 
                            WHERE 
                                aviva_financial.aviva_financial_amount < 0 AND DATE(aviva_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Aviva'");
                    $query->bindParam(':commdate', $AVI_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $AVI_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['aviva_financial_policy'];
                                $PAY_AMOUNT = number_format($row['aviva_financial_amount'], 2);

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
                            aviva_financial_nomatch_id, 
                            aviva_financial_nomatch_amount, 
                            aviva_financial_nomatch_uploaded_date, 
                            aviva_financial_nomatch_policy
                        FROM
                            aviva_financial_nomatch");
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
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['aviva_financial_nomatch_policy'];
                            $paytype = $row['aviva_financial_nomatch_amount'];
                            $iddd = $row['aviva_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['aviva_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($row['aviva_financial_nomatch_amount']) > 0) {
                                echo "<td><span class=\"label label-success\">" . $row['aviva_financial_nomatch_amount'] . "</span></td>";
                            } else if (intval($row["aviva_financial_nomatch_amount"]) < 0) {
                                echo "<td><span class=\"label label-danger\">" . $row['aviva_financial_nomatch_amount'] . "</span></td>";
                            } else {
                                echo "<td>" . $row['aviva_financial_nomatch_amount'] . "</td>";
                            }
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=Aviva' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
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
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$AVI_DATE_FROM&dateto=$AVI_DATE_TO&commdate=$AVI_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$AVI_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$AVI_DATE_FROM&dateto=$AVI_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$AVI_DATE_FROM&dateto=$AVI_DATE_TO&commdate=$AVI_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$AVI_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$AVI_DATE_FROM&dateto=$AVI_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$AVI_DATE_FROM&dateto=$AVI_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                        $LV_nomatchbadge = $pdo->query("SELECT 
                                                        COUNT(lv_financial_nomatch_id) AS badge
                                                        FROM 
                                                            lv_financial_nomatch");
                        $LV_NO_MATCH_row = $LV_nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($LV_NO_MATCH_row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="LV_home" class="tab-pane fade in active">

                
                        <?php

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/LV/TotalMissingWithDates.php');
    $LV_TotalMissingWithDates = new LV_TotalMissingWithDatesModal($pdo);
    $LV_TotalMissingWithDatesList = $LV_TotalMissingWithDates->LV_getTotalMissingWithDates($LV_DATE_FROM, $LV_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/LV/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/LV/TotalAwaitingWithDates.php');
    $LV_TotalAwaitingWithDates = new LV_TotalAwaitingWithDatesModal($pdo);
    $LV_TotalAwaitingWithDatesList = $LV_TotalAwaitingWithDates->LV_getTotalAwaitingWithDates($LV_DATE_FROM, $LV_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/LV/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/LV/TotalExpectedWithDates.php');
    $LV_TotalExpectedWithDates = new LV_TotalExpectedWithDatesModal($pdo);
    $LV_TotalExpectedWithDatesList = $LV_TotalExpectedWithDates->LV_getTotalExpectedWithDates($LV_DATE_FROM, $LV_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/LV/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$LV_TOTAL_NEW_GROSS = $LV_ADL_EXPECTED_SUM - $LV_ADL_AWAITING_SUM; 
$LV_TOTAL_NEW_GROSS_DISPLAY = number_format($LV_TOTAL_NEW_GROSS, 2);                                       
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
                           $EXPECTED_SUM_QRY->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $LV_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $LV_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                           

                            $POL_ON_TM_QRY = $pdo->prepare("SELECT 
    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        lv_financial 
    LEFT JOIN 
        client_policy 
    ON 
        lv_financial.lv_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(lv_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='LV')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    lv_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    lv_financial.lv_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(lv_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='LV')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                                    AND 
                                        insurer='LV'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_LV_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $LV_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_LV_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($LV_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $LV_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$LV_DATE_FROM - $LV_DATE_TO"; ?>.
                                                   
ADL <?php echo $LV_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $AVI_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $LV_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $LV_DATE_FROM; ?>&dateto=<?php echo $LV_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$LV_DATE_FROM - $LV_DATE_TO  $LV_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $LV_DATE_FROM; ?>&dateto=<?php echo $LV_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($LV_DATE_FROM)) { echo "within 2017-01-01 - $LV_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $LV_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($LV_DATE_FROM)) { echo "within $LV_DATE_FROM - $LV_DATE_TO"; } ?>.

ADL <?php echo $LV_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $LV_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $LV_DATE_FROM; ?>&dateto=<?php echo $LV_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                             $query = $pdo->prepare("SELECT 
                                                    SUM(CASE WHEN lv_financial_indemnity < 0 THEN lv_financial_indemnity ELSE 0 END) AS totalloss,
                                                    SUM(CASE WHEN lv_financial_indemnity >= 0 THEN lv_financial_indemnity ELSE 0 END) as totalgross
                                                    FROM 
                                                        lv_financial
                                                    WHERE
                                                        DATE(lv_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                           
                            
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
                                        echo "<td>£$LV_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$LV_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$LV_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $LV_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$LV_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$LV_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$LV_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$LV_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$LV_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$LV_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $LV_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $LV_COMM_DATE"; ?></th>
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
                        lv_financial.lv_financial_name, 
                        lv_financial.lv_financial_policy_number, 
                        lv_financial.lv_financial_indemnity, 
                        DATE(lv_financial_uploaded_date) AS COMM_DATE
                    FROM
                        lv_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        lv_financial.lv_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(lv_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='LV'
                    ORDER BY 
                        lv_financial.lv_financial_indemnity DESC");
                    $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$LV_COMM_DATE ($count records)"; ?></th>
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
                                echo "<td>" . $row['vitality_financial_name'] . "</td>";
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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
        AND insurer = 'LV'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'LV'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $LV_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $LV_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$LV_COMM_DATE ($EXPECTEDcount records) | ADL £$LV_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$LV_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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
                                insurer='LV'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            ORDER BY 
                                commission DESC");
                    $query->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $LV_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial) 
                        AND
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                        AND 
                            client_policy.insurer='LV'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                    $query->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$LV_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='LV'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$LV_COMM_DATE ($count records) | ADL £$LV_ADL_AWAITING_SUM_DATES_FORMAT | Total £$LV_ADL_AWAITING_SUM_FORMAT"; ?></th>
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
                            sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='LV')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['lv_financial_indemnity'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='LV')");
                    $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$LV_DATE_TO - $LV_DATE_FROM with COMM date of $LV_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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
                            lv_financial.lv_financial_policy_number, 
                            lv_financial.lv_financial_indemnity, 
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (SELECT client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='LV')");
                    $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $LV_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $LV_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$LV_DATE_TO - $LV_DATE_FROM with COMM date of $LV_COMM_DATE ($count records)"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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
                                SUM(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity >= 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='LV'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            lv_financial.lv_financial_indemnity, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            lv_financial.lv_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            lv_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            lv_financial.lv_financial_indemnity >= 0 
                        AND 
                            DATE(lv_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='LV'");
                    $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $LV_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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
                                sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='LV'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                lv_financial.lv_financial_indemnity, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                lv_financial.lv_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                lv_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='LV'");
                    $query->bindParam(':commdate', $LV_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $LV_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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
                            lv_financial_nomatch_id, 
                            lv_financial_nomatch_indemnity, 
                            lv_financial_nomatch_uploaded_date, 
                            lv_financial_nomatch_policy_number
                        FROM
                            lv_financial_nomatch");
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
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['lv_financial_nomatch_policy_number'];
                            $paytype = $row['lv_financial_nomatch_indemnity'];
                            $iddd = $row['lv_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['lv_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($paytype) > 0) {
                                echo "<td><span class=\"label label-success\">$paytype</span></td>";
                            } else if (intval($paytype) < 0) {
                                echo "<td><span class=\"label label-danger\">$paytype</span></td>";
                            } else {
                                echo "<td>$paytype</td>";
                            }
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=LV' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
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
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$LV_DATE_FROM&dateto=$LV_DATE_TO&commdate=$LV_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$LV_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$LV_DATE_FROM&dateto=$LV_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$LV_DATE_FROM&dateto=$LV_DATE_TO&commdate=$LV_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$LV_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$LV_DATE_FROM&dateto=$LV_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$LV_DATE_FROM&dateto=$LV_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                 <h3 class="panel-title"><a data-toggle="collapse" href="#ZURICHcollapse1">Zurich Financial Statistics</a></h3>
             </div>
             <div id="ZURICHcollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#ZURICH_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#ZURICH_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $ZURICH_nomatchbadge = $pdo->query("SELECT 
                                                        COUNT(lv_financial_nomatch_id) AS badge
                                                        FROM 
                                                            lv_financial_nomatch");
                        $ZURICH_NO_MATCH_row = $ZURICH_nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($ZURICH_NO_MATCH_row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="ZURICH_home" class="tab-pane fade in active">

                
                        <?php

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ZURICH/TotalMissingWithDates.php');
    $ZURICH_TotalMissingWithDates = new ZURICH_TotalMissingWithDatesModal($pdo);
    $ZURICH_TotalMissingWithDatesList = $ZURICH_TotalMissingWithDates->ZURICH_getTotalMissingWithDates($ZURICH_DATE_FROM, $ZURICH_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ZURICH/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ZURICH/TotalAwaitingWithDates.php');
    $ZURICH_TotalAwaitingWithDates = new ZURICH_TotalAwaitingWithDatesModal($pdo);
    $ZURICH_TotalAwaitingWithDatesList = $ZURICH_TotalAwaitingWithDates->ZURICH_getTotalAwaitingWithDates($ZURICH_DATE_FROM, $ZURICH_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ZURICH/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/ZURICH/TotalExpectedWithDates.php');
    $ZURICH_TotalExpectedWithDates = new ZURICH_TotalExpectedWithDatesModal($pdo);
    $ZURICH_TotalExpectedWithDatesList = $ZURICH_TotalExpectedWithDates->ZURICH_getTotalExpectedWithDates($ZURICH_DATE_FROM, $ZURICH_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/ZURICH/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$ZURICH_TOTAL_NEW_GROSS = $ZURICH_ADL_EXPECTED_SUM - $ZURICH_ADL_AWAITING_SUM; 
$ZURICH_TOTAL_NEW_GROSS_DISPLAY = number_format($ZURICH_TOTAL_NEW_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Zurich'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        ");
                            $EXPECTED_SUM_QRY->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $ZURICH_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $ZURICH_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                           

                            $POL_ON_TM_QRY = $pdo->prepare("SELECT 
    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        lv_financial 
    LEFT JOIN 
        client_policy 
    ON 
        lv_financial.lv_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(lv_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='Zurich')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    lv_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    lv_financial.lv_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(lv_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Zurich')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                                    AND 
                                        insurer='Zurich'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_ZURICH_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $ZURICH_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_ZURICH_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($ZURICH_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $ZURICH_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$ZURICH_DATE_FROM - $ZURICH_DATE_TO"; ?>.
                                                   
ADL <?php echo $ZURICH_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $ZURICH_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $ZURICH_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $ZURICH_DATE_FROM; ?>&dateto=<?php echo $ZURICH_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$ZURICH_DATE_FROM - $ZURICH_DATE_TO  $ZURICH_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $ZURICH_DATE_FROM; ?>&dateto=<?php echo $ZURICH_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($ZURICH_DATE_FROM)) { echo "within 2017-01-01 - $ZURICH_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $ZURICH_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($ZURICH_DATE_FROM)) { echo "within $ZURICH_DATE_FROM - $ZURICH_DATE_TO"; } ?>.

ADL <?php echo $ZURICH_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $ZURICH_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $ZURICH_DATE_FROM; ?>&dateto=<?php echo $ZURICH_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                             $query = $pdo->prepare("SELECT 
                                                    SUM(CASE WHEN lv_financial_indemnity < 0 THEN lv_financial_indemnity ELSE 0 END) AS totalloss,
                                                    SUM(CASE WHEN lv_financial_indemnity >= 0 THEN lv_financial_indemnity ELSE 0 END) as totalgross
                                                    FROM 
                                                        lv_financial
                                                    WHERE
                                                        DATE(lv_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                           
                            
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
                                        echo "<td>£$ZURICH_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$ZURICH_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$ZURICH_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $ZURICH_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$ZURICH_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$ZURICH_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$ZURICH_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$ZURICH_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$ZURICH_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$ZURICH_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $ZURICH_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $ZURICH_COMM_DATE"; ?></th>
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
        
        <div id="ZURICH_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        lv_financial.lv_financial_name, 
                        lv_financial.lv_financial_policy_number, 
                        lv_financial.lv_financial_indemnity, 
                        DATE(lv_financial_uploaded_date) AS COMM_DATE
                    FROM
                        lv_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        lv_financial.lv_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(lv_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Zurich'
                    ORDER BY 
                        lv_financial.lv_financial_indemnity DESC");
                    $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$ZURICH_COMM_DATE ($count records)"; ?></th>
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
                                echo "<td>" . $row['vitality_financial_name'] . "</td>";
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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


        <div id="ZURICH_EXPECTED" class="tab-pane fade">
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
        AND insurer = 'ZURICH'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'ZURICH'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $ZURICH_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $ZURICH_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$ZURICH_COMM_DATE ($EXPECTEDcount records) | ADL £$ZURICH_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$ZURICH_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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

        <div id="ZURICH_PENDING" class="tab-pane fade">

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
                                insurer='Zurich'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            ORDER BY 
                                commission DESC");
                    $query->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $ZURICH_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
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


        <div id="ZURICH_MISSING" class="tab-pane fade">
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial) 
                        AND
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                        AND 
                            client_policy.insurer='Zurich'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                    $query->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$ZURICH_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
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


        <div id="ZURICH_AWAITING" class="tab-pane fade">
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Zurich'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$ZURICH_COMM_DATE ($count records) | ADL £$ZURICH_ADL_AWAITING_SUM_DATES_FORMAT | Total £$ZURICH_ADL_AWAITING_SUM_FORMAT"; ?></th>
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

        <div id="ZURICH_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Zurich')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['lv_financial_indemnity'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Zurich')");
                    $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$ZURICH_DATE_TO - $ZURICH_DATE_FROM with COMM date of $ZURICH_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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

        <div id="ZURICH_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            lv_financial.lv_financial_policy_number, 
                            lv_financial.lv_financial_indemnity, 
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (SELECT client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Zurich')");
                    $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $ZURICH_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $ZURICH_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$ZURICH_DATE_TO - $ZURICH_DATE_FROM with COMM date of $ZURICH_COMM_DATE ($count records)"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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

        <div id="ZURICH_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                SUM(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity >= 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='ZURICH'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            lv_financial.lv_financial_indemnity, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            lv_financial.lv_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            lv_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            lv_financial.lv_financial_indemnity >= 0 
                        AND 
                            DATE(lv_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Zurich'");
                    $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $ZURICH_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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


        <div id="ZURICH_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Zurich'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                lv_financial.lv_financial_indemnity, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                lv_financial.lv_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                lv_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Zurich'");
                    $query->bindParam(':commdate', $ZURICH_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $ZURICH_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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

        <div id="ZURICH_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            lv_financial_nomatch_id, 
                            lv_financial_nomatch_indemnity, 
                            lv_financial_nomatch_uploaded_date, 
                            lv_financial_nomatch_policy_number
                        FROM
                            lv_financial_nomatch");
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
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['lv_financial_nomatch_policy_number'];
                            $paytype = $row['lv_financial_nomatch_indemnity'];
                            $iddd = $row['lv_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['lv_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($paytype) > 0) {
                                echo "<td><span class=\"label label-success\">$paytype</span></td>";
                            } else if (intval($paytype) < 0) {
                                echo "<td><span class=\"label label-danger\">$paytype</span></td>";
                            } else {
                                echo "<td>$paytype</td>";
                            }
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=ZURICH' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="ZURICH_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$ZURICH_DATE_FROM&dateto=$ZURICH_DATE_TO&commdate=$ZURICH_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$ZURICH_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$ZURICH_DATE_FROM&dateto=$ZURICH_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$ZURICH_DATE_FROM&dateto=$ZURICH_DATE_TO&commdate=$ZURICH_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$ZURICH_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$ZURICH_DATE_FROM&dateto=$ZURICH_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$ZURICH_DATE_FROM&dateto=$ZURICH_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                 <h3 class="panel-title"><a data-toggle="collapse" href="#SCOTTISH_WIDOWScollapse1">Scottish Widows Financial Statistics</a></h3>
             </div>
             <div id="SCOTTISH_WIDOWScollapse1" class="panel-collapse collapse">
             <div class="panel-body">
                 
                 <ul class="nav nav-pills">
                     <li class="active"><a data-toggle="pill" href="#SCOTTISH_WIDOWS_home">Financials</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_PENDING">Unpaid</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_MISSING">Total Missing</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_AWAITING">Awaiting</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_EXPECTED">Expected</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_POLINDATE">Policies on Time</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_POLOUTDATE">Late Policies</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_COMMIN">Total Gross</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_COMMOUT">Total Loss</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_RAW">RAW</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_EXPORT">Export</a></li>
                     <li><a data-toggle="pill" href="#SCOTTISH_WIDOWS_NOMATCH">Unmatched Policies <span class="badge alert-warning">
                        <?php
                        $SCOTTISH_WIDOWS_nomatchbadge = $pdo->query("SELECT 
                                                        COUNT(lv_financial_nomatch_id) AS badge
                                                        FROM 
                                                            lv_financial_nomatch");
                        $SCOTTISH_WIDOWS_NO_MATCH_row = $SCOTTISH_WIDOWS_nomatchbadge->fetch(PDO::FETCH_ASSOC);
                        echo htmlentities($SCOTTISH_WIDOWS_NO_MATCH_row['badge']);
                        ?>
                    </span></a></li>
                 </ul>



    <div class="tab-content">

        <div id="SCOTTISH_WIDOWS_home" class="tab-pane fade in active">

                
                        <?php

//CALCULATE MISSING AMOUNT WITH DATES. Polices on SALE DATE RANGE BUT NOT ON RAW COMMS
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/SCOTTISH_WIDOWS/TotalMissingWithDates.php');
    $SCOTTISH_WIDOWS_TotalMissingWithDates = new SCOTTISH_WIDOWS_TotalMissingWithDatesModal($pdo);
    $SCOTTISH_WIDOWS_TotalMissingWithDatesList = $SCOTTISH_WIDOWS_TotalMissingWithDates->SCOTTISH_WIDOWS_getTotalMissingWithDates($SCOTTISH_WIDOWS_DATE_FROM, $SCOTTISH_WIDOWS_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/SCOTTISH_WIDOWS/Total-Missing-With-Dates.php');
                       //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/SCOTTISH_WIDOWS/TotalAwaitingWithDates.php');
    $SCOTTISH_WIDOWS_TotalAwaitingWithDates = new SCOTTISH_WIDOWS_TotalAwaitingWithDatesModal($pdo);
    $SCOTTISH_WIDOWS_TotalAwaitingWithDatesList = $SCOTTISH_WIDOWS_TotalAwaitingWithDates->SCOTTISH_WIDOWS_getTotalAwaitingWithDates($SCOTTISH_WIDOWS_DATE_FROM, $SCOTTISH_WIDOWS_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/SCOTTISH_WIDOWS/Total-Awaiting-With-Dates.php');                            
    //END OF CALCULATION
    
//CALCULATE EXPECTED AMOUNT WITH DATES
    require_once(BASE_URL.'/addon/Life/Financials/models/financials/SCOTTISH_WIDOWS/TotalExpectedWithDates.php');
    $SCOTTISH_WIDOWS_TotalExpectedWithDates = new SCOTTISH_WIDOWS_TotalExpectedWithDatesModal($pdo);
    $SCOTTISH_WIDOWS_TotalExpectedWithDatesList = $SCOTTISH_WIDOWS_TotalExpectedWithDates->SCOTTISH_WIDOWS_getTotalExpectedWithDates($SCOTTISH_WIDOWS_DATE_FROM, $SCOTTISH_WIDOWS_DATE_TO);
    require_once(BASE_URL.'/addon/Life/Financials/views/financials/SCOTTISH_WIDOWS/Total-Expected-With-Dates.php');  
    

//CALCULATE NET| GROSS
$SW_TOTAL_NEW_GROSS = $SW_ADL_EXPECTED_SUM - $SW_ADL_AWAITING_SUM; 
$SW_TOTAL_NEW_GROSS_DISPLAY = number_format($SW_TOTAL_NEW_GROSS, 2);                                       
//END OF CALCULATION    
                                $EXPECTED_SUM_QRY = $pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Scottish Widows'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        ");
                            $EXPECTED_SUM_QRY->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR);
                            $EXPECTED_SUM_QRY->execute()or die(print_r($EXPECTED_SUM_QRY->errorInfo(), true));
                            $EXPECTED_SUM_QRY_RS = $EXPECTED_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                            $ORIG_EXPECTED_SUM = $EXPECTED_SUM_QRY_RS['commission'];

                            $SW_simply_EXPECTED_SUM = ($simply_biz / 100) * $ORIG_EXPECTED_SUM;
                            $EXPECTED_SUM = $ORIG_EXPECTED_SUM - $SW_simply_EXPECTED_SUM;
    //END OF CALCULATION          
                           

                            $POL_ON_TM_QRY = $pdo->prepare("SELECT 
    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_PLUS,
    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as PAID_TOTAL_LOSS 
    FROM 
        lv_financial 
    LEFT JOIN 
        client_policy 
    ON 
        lv_financial.lv_financial_policy_number=client_policy.policy_number 
    WHERE 
        DATE(lv_financial_uploaded_date) = :commdate
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
                                            client_policy.insurer='Scottish Widows')
                                            ");
                            $POL_ON_TM_QRY->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
                            $POL_ON_TM_QRY->execute()or die(print_r($POL_ON_TM_QRY->errorInfo(), true));
                            $POL_ON_TM_SUM_QRY_RS = $POL_ON_TM_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $POL_ON_TM_SUM = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_PLUS'];
                            $POL_ON_TM_SUM_LS = $POL_ON_TM_SUM_QRY_RS['PAID_TOTAL_LOSS'];

                            $POL_NOT_TM_QRY = $pdo->prepare("
                                SELECT
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity >= 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_PLUS,
                                    SUM(CASE WHEN lv_financial.lv_financial_indemnity < 0 THEN lv_financial.lv_financial_indemnity ELSE 0 END) as NOT_PAID_TOTAL_LOSS   
                                FROM 
                                    lv_financial
                                LEFT JOIN 
                                    client_policy 
                                ON 
                                    lv_financial.lv_financial_policy_number=client_policy.policy_number
                                WHERE 
                                    DATE(lv_financial_uploaded_date) = :commdate 
                                AND 
                                    client_policy.policy_number IN(select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Scottish Widows')");
                            $POL_NOT_TM_QRY->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                            $POL_NOT_TM_QRY->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
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
                                        policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                                    AND 
                                        insurer='Scottish Widows'
                                    AND 
                                        policystatus NOT like '%CANCELLED%'
                                    AND 
                                        policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                            $MISSING_SUM_DISPLAY_QRY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR); 
                            $MISSING_SUM_DISPLAY_QRY->execute()or die(print_r($MISSING_SUM_DISPLAY_QRY->errorInfo(), true));
                            $MISSING_SUM_DISPLAY_QRY_RS = $MISSING_SUM_DISPLAY_QRY->fetch(PDO::FETCH_ASSOC);
                            
                            $ORIG_MISSING_SUM = $MISSING_SUM_DISPLAY_QRY_RS['commission'];

                            $simply_EXP_SCOTTISH_WIDOWS_PENDING = ($simply_biz / 100) * $ORIG_MISSING_SUM;
                            $SW_MISSING_SUM_DISPLAY_UNFORMATTED = $ORIG_MISSING_SUM - $simply_EXP_SCOTTISH_WIDOWS_PENDING;
                            $MISSING_SUM_DISPLAY = number_format($SW_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
                            $ORIG_MISSING_SUM_FOR = number_format($ORIG_MISSING_SUM, 2);
                       
                        ?>       

                        <table  class="table table-hover">

                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections for $SCOTTISH_WIDOWS_COMM_DATE";?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$SCOTTISH_WIDOWS_DATE_FROM - $SCOTTISH_WIDOWS_DATE_TO"; ?>.
                                                   
ADL <?php echo $SW_ADL_EXPECTED_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $SW_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $SW_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $SCOTTISH_WIDOWS_DATE_FROM; ?>&dateto=<?php echo $SCOTTISH_WIDOWS_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$SCOTTISH_WIDOWS_DATE_FROM - $SCOTTISH_WIDOWS_DATE_TO  $SW_TOTAL_NEW_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $SCOTTISH_WIDOWS_DATE_FROM; ?>&dateto=<?php echo $SCOTTISH_WIDOWS_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($SCOTTISH_WIDOWS_DATE_FROM)) { echo "within 2017-01-01 - $SCOTTISH_WIDOWS_DATE_TO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $SCOTTISH_WIDOWS_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($SCOTTISH_WIDOWS_DATE_FROM)) { echo "within $SCOTTISH_WIDOWS_DATE_FROM - $SCOTTISH_WIDOWS_DATE_TO"; } ?>.

ADL <?php echo $SW_ADL_AWAITING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_AWAITING_SUM_FORMAT; ?>

Total: <?php echo $SW_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $SCOTTISH_WIDOWS_DATE_FROM; ?>&dateto=<?php echo $SCOTTISH_WIDOWS_DATE_TO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>

                            <?php
                             $query = $pdo->prepare("SELECT 
                                                    SUM(CASE WHEN lv_financial_indemnity < 0 THEN lv_financial_indemnity ELSE 0 END) AS totalloss,
                                                    SUM(CASE WHEN lv_financial_indemnity >= 0 THEN lv_financial_indemnity ELSE 0 END) as totalgross
                                                    FROM 
                                                        lv_financial
                                                    WHERE
                                                        DATE(lv_financial_uploaded_date)=:commdate");
                            $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                           
                            
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
                                        echo "<td>£$SW_ADL_EXPECTED_SUM_FORMAT</td>";
                                        echo "<td>£$SW_TOTAL_NEW_GROSS_DISPLAY</td>";
                                        echo "<td>£$MISSING_SUM_DISPLAY</td>";    
                                        echo "<td>£$SW_ADL_AWAITING_SUM_FORMAT</td>";
                                        echo "</tr>";
                                        echo "\n";
                                }
                                ?>
                        </table>
                        
                        <!-- RAW COMM TABLE  -->
                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><?php echo "RAW COMMS statistics for $SCOTTISH_WIDOWS_COMM_DATE";?></th>
                                        </tr>
                                    <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="Total Paid for COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>Total Loss <i class="fa fa-question-circle" style="color:skyblue" title="Total Clawbacks for COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Total Net <i class="fa fa-question-circle" style="color:skyblue" title="Total Gross - Total Loss for COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>   
                                    <th>INSURER % <i class="fa fa-question-circle" style="color:skyblue" title="Percentage deduction <?php echo "$totalrate%"; ?>."></i></th> 
                                    <th>Net COMM <i class="fa fa-question-circle" style="color:skyblue" title="Total Net - INSURER % for COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                    <th>ADL vs RAW DIFF <i class="fa fa-question-circle" style="color:skyblue" title="Difference between ADL Projected Gross - RAW Total Gross COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>."></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                    <th>Missing <i class="fa fa-question-circle" style="color:skyblue" title="Polciies that were not paid for COMM date <?php echo "$SCOTTISH_WIDOWS_COMM_DATE"; ?>.

ADL <?php echo $ADL_MISSING_SUM_DATES_FORMAT; ?>

Insurer Percentage: <?php echo $simply_MISSING_SUM_FORMAT; ?>

Total: <?php echo $ADL_MISSING_SUM_FORMAT; ?>"
></i> <a href="?commdate=<?php echo $SCOTTISH_WIDOWS_COMM_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
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
                                    <th colspan="8"><?php echo "RAW COMMS breakdown $SCOTTISH_WIDOWS_COMM_DATE"; ?></th>
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
        
        <div id="SCOTTISH_WIDOWS_RAW" class="tab-pane fade">

                <?php

                    $query = $pdo->prepare("SELECT 
                        client_policy.id AS PID, 
                        client_policy.client_id AS CID, 
                        client_policy.policy_number, 
                        client_policy.commission, 
                        DATE(client_policy.sale_date) AS SALE_DATE, 
                        lv_financial.lv_financial_name, 
                        lv_financial.lv_financial_policy_number, 
                        lv_financial.lv_financial_indemnity, 
                        DATE(lv_financial_uploaded_date) AS COMM_DATE
                    FROM
                        lv_financial
                    LEFT JOIN 
                        client_policy
                    ON 
                        lv_financial.lv_financial_policy_number=client_policy.policy_number
                    WHERE 
                        DATE(lv_financial_uploaded_date) = :commdate
                    AND
                        client_policy.insurer='Scottish Widows'
                    ORDER BY 
                        lv_financial.lv_financial_indemnity DESC");
                    $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>RAW COMMS for <?php echo "$SCOTTISH_WIDOWS_COMM_DATE ($count records)"; ?></th>
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
                                echo "<td>" . $row['vitality_financial_name'] . "</td>";
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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


        <div id="SCOTTISH_WIDOWS_EXPECTED" class="tab-pane fade">
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
        AND insurer = 'SCOTTISH_WIDOWS'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'SCOTTISH_WIDOWS'
        AND policystatus = 'Awaiting'");
                    $EXPECTED_QUERY->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':datefrom2', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR);
                    $EXPECTED_QUERY->bindParam(':dateto2', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR);
                    $EXPECTED_QUERY->execute()or die(print_r($EXPECTED_QUERY->errorInfo(), true));
                    if ($EXPECTED_QUERY->rowCount() > 0) {
                        $EXPECTEDcount = $EXPECTED_QUERY->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>
                                <tr>
                                    <th colspan='3'>EXPECTED for <?php echo "$SCOTTISH_WIDOWS_COMM_DATE ($EXPECTEDcount records) | ADL £$SW_ADL_EXPECTED_SUM_DATES_FORMAT | Total £$SW_ADL_EXPECTED_SUM_FORMAT"; ?></th>
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

        <div id="SCOTTISH_WIDOWS_PENDING" class="tab-pane fade">

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
                                insurer='Scottish Widows'
                            AND
                                policystatus NOT like '%CANCELLED%' 
                            AND
                                policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED','On hold') 
                            ORDER BY 
                                commission DESC");
                    $query->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Unpaid for <?php echo "2017-01-01 to $SCOTTISH_WIDOWS_DATE_TO ($count records) | Total £$MISSING_SUM_DISPLAY | ADL £$ORIG_MISSING_SUM_FOR"; ?></th>
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


        <div id="SCOTTISH_WIDOWS_MISSING" class="tab-pane fade">
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
                        AND 
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial) 
                        AND
                            client_policy.policy_number NOT IN(select lv_financial.lv_financial_policy_number FROM lv_financial)
                        AND 
                            client_policy.insurer='Scottish Widows'
                        AND 
                            client_policy.policystatus NOT like '%CANCELLED%'
                        AND
                            client_policy.policystatus NOT IN ('Awaiting','Clawback','SUBMITTED-NOT-LIVE','DECLINED')");
                    $query->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Missing for <?php echo "$SCOTTISH_WIDOWS_COMM_DATE ($count records) | ADL £$ADL_MISSING_SUM_DATES_FORMAT | Total £$ADL_MISSING_SUM_FORMAT"; ?></th>
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


        <div id="SCOTTISH_WIDOWS_AWAITING" class="tab-pane fade">
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
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM
                            client_policy
                        LEFT JOIN 
                            lv_financial
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(client_policy.submitted_date) between :datefrom AND :dateto 
                        AND 
                            client_policy.insurer='Scottish Widows'
                        AND 
                            client_policy.policystatus ='Awaiting' 
                        ORDER BY 
                            DATE(client_policy.sale_date)");
                    $query->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Awaiting for <?php echo "$SCOTTISH_WIDOWS_COMM_DATE ($count records) | ADL £$SW_ADL_AWAITING_SUM_DATES_FORMAT | Total £$SW_ADL_AWAITING_SUM_FORMAT"; ?></th>
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

        <div id="SCOTTISH_WIDOWS_POLINDATE" class="tab-pane fade">

                <?php
                
                    $POLIN_SUM_QRY = $pdo->prepare("
                        SELECT 
                            sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND 
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Scottish Widows')");
                    $POLIN_SUM_QRY->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
                    $POLIN_SUM_QRY->execute()or die(print_r($POLIN_SUM_QRY->errorInfo(), true));
                    $POLIN_SUM_QRY_RS = $POLIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_POLIN_SUM = $POLIN_SUM_QRY_RS['lv_financial_indemnity'];

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID,
                            client_policy.client_id AS CID,
                            client_policy.policy_number,
                            client_policy.commission,
                            DATE(client_policy.sale_date) AS SALE_DATE,
                            lv_financial.lv_financial_policy_number,
                            lv_financial.lv_financial_indemnity,
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy ON lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (select client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND insurer='Scottish Widows')");
                    $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR);
                    $query->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Policies in date range <?php echo "$SCOTTISH_WIDOWS_DATE_TO - $SCOTTISH_WIDOWS_DATE_FROM with COMM date of $SCOTTISH_WIDOWS_COMM_DATE ($count records) | Total £$ORIG_POLIN_SUM"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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

        <div id="SCOTTISH_WIDOWS_POLOUTDATE" class="tab-pane fade">

               <?php

                    $query = $pdo->prepare("
                        SELECT 
                            client_policy.client_name,
                            client_policy.id AS PID, 
                            client_policy.client_id AS CID, 
                            client_policy.policy_number, 
                            client_policy.commission, 
                            DATE(client_policy.sale_date) AS SALE_DATE, 
                            lv_financial.lv_financial_policy_number, 
                            lv_financial.lv_financial_indemnity, 
                            DATE(lv_financial_uploaded_date) AS COMM_DATE
                        FROM 
                            lv_financial
                        LEFT JOIN 
                            client_policy
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number
                        WHERE 
                            DATE(lv_financial_uploaded_date) = :commdate
                        AND
                            client_policy.policy_number 
                        IN
                            (SELECT client_policy.policy_number FROM client_policy WHERE DATE(client_policy.sale_date) NOT BETWEEN :datefrom AND :dateto AND insurer='Scottish Widows')");
                    $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->bindParam(':dateto', $SCOTTISH_WIDOWS_DATE_TO, PDO::PARAM_STR, 100);
                    $query->bindParam(':datefrom', $SCOTTISH_WIDOWS_DATE_FROM, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>Back Dated Policies <?php echo "$SCOTTISH_WIDOWS_DATE_TO - $SCOTTISH_WIDOWS_DATE_FROM with COMM date of $SCOTTISH_WIDOWS_COMM_DATE ($count records)"; ?></th>
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
                                if (intval($row['lv_financial_indemnity']) > 0) {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else if (intval($row["lv_financial_indemnity"]) < 0) {
                                    echo "<td><span class=\"label label-danger\">" . $row['lv_financial_indemnity'] . "</span></td>";
                                } else {
                                    echo "<td><span class=\"label label-success\">" . $row['lv_financial_indemnity'] . "</span></td>";
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

        <div id="SCOTTISH_WIDOWS_COMMIN" class="tab-pane fade">

                <?php

                    $COMMIN_SUM_QRY = $pdo->prepare("
                            SELECT 
                                SUM(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity >= 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate 
                            AND 
                                client_policy.insurer ='SCOTTISH_WIDOWS'");
                    $COMMIN_SUM_QRY->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMIN_SUM_QRY->execute()or die(print_r($COMMIN_SUM_QRY->errorInfo(), true));
                    $COMMIN_SUM_QRY_RS = $COMMIN_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    
                    $ORIG_COMMIN_SUM = $COMMIN_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMIN_SUM_FORMATTED = number_format($ORIG_COMMIN_SUM, 2);

                    $query = $pdo->prepare("
                        SELECT
                            lv_financial.lv_financial_indemnity, 
                            client_policy.CommissionType, 
                            DATE(client_policy.sale_date) AS sale_date, 
                            client_policy.policy_number, 
                            lv_financial.lv_financial_policy_number, 
                            client_policy.client_name, 
                            client_policy.client_id 
                        FROM 
                            lv_financial 
                        LEFT JOIN
                            client_policy 
                        ON 
                            lv_financial.lv_financial_policy_number=client_policy.policy_number 
                        WHERE 
                            lv_financial.lv_financial_indemnity >= 0 
                        AND 
                            DATE(lv_financial_uploaded_date) =:commdate
                        AND 
                            client_policy.insurer='Scottish Widows'");
                    $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM IN <?php echo "with COMM date of $SCOTTISH_WIDOWS_COMM_DATE ($count records) | Total £$COMMIN_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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


        <div id="SCOTTISH_WIDOWS_COMMOUT" class="tab-pane fade">

                <?php
                
                    $COMMOUT_SUM_QRY = $pdo->prepare("
                            SELECT 
                                sum(lv_financial.lv_financial_indemnity) AS lv_financial_indemnity 
                            FROM 
                                lv_financial 
                            LEFT JOIN 
                                client_policy 
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Scottish Widows'");
                    $COMMOUT_SUM_QRY->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $COMMOUT_SUM_QRY->execute()or die(print_r($COMMOUT_SUM_QRY->errorInfo(), true));
                    $COMMOUT_SUM_QRY_RS = $COMMOUT_SUM_QRY->fetch(PDO::FETCH_ASSOC);
                    $ORIG_COMMOUT_SUM = $COMMOUT_SUM_QRY_RS['lv_financial_indemnity'];
                    $COMMOUT_SUM_FORMATTED = number_format($ORIG_COMMOUT_SUM, 2);

                    $query = $pdo->prepare("
                            SELECT 
                                lv_financial.lv_financial_indemnity, 
                                client_policy.CommissionType, 
                                DATE(client_policy.sale_date) AS sale_date, 
                                client_policy.policy_number, 
                                lv_financial.lv_financial_policy_number, 
                                client_policy.client_name, 
                                client_policy.client_id 
                            FROM 
                                lv_financial
                            LEFT JOIN 
                                client_policy
                            ON 
                                lv_financial.lv_financial_policy_number=client_policy.policy_number 
                            WHERE 
                                lv_financial.lv_financial_indemnity < 0 
                            AND 
                                DATE(lv_financial_uploaded_date) =:commdate
                            AND 
                                client_policy.insurer='Scottish Widows'");
                    $query->bindParam(':commdate', $SCOTTISH_WIDOWS_COMM_DATE, PDO::PARAM_STR, 100);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $count = $query->rowCount();
                        ?>

                        <table  class="table table-hover table-condensed">

                            <thead>

                                <tr>
                                    <th colspan='3'>COMM OUT  <?php echo "with COMM date of $SCOTTISH_WIDOWS_COMM_DATE ($count records) | Total £$COMMOUT_SUM_FORMATTED"; ?></th>
                                </tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>COMM Amount</th>
                            </tr>
                            </thead>
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                $policy = $row['lv_financial_policy_number'];
                                $PAY_AMOUNT = number_format($row['lv_financial_indemnity'], 2);

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

        <div id="SCOTTISH_WIDOWS_NOMATCH" class="tab-pane fade">   

                <?php
                $query = $pdo->prepare("
                        SELECT
                            lv_financial_nomatch_id, 
                            lv_financial_nomatch_indemnity, 
                            lv_financial_nomatch_uploaded_date, 
                            lv_financial_nomatch_policy_number
                        FROM
                            lv_financial_nomatch");
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
                    <th>Re-check all</th>
                    </thead>
                    <?php
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    if ($query->rowCount() > 0) {
                        $i=0;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            
                            $i++;

                            $policy = $row['lv_financial_nomatch_policy_number'];
                            $paytype = $row['lv_financial_nomatch_indemnity'];
                            $iddd = $row['lv_financial_nomatch_id'];
                            echo "<tr>
                            <td>$i</td>
                            ";
                            
                            echo"<td>" . $row['lv_financial_nomatch_uploaded_date'] . "</td>";
                            echo "<td>$policy</td>";
                            if (intval($paytype) > 0) {
                                echo "<td><span class=\"label label-success\">$paytype</span></td>";
                            } else if (intval($paytype) < 0) {
                                echo "<td><span class=\"label label-danger\">$paytype</span></td>";
                            } else {
                                echo "<td>$paytype</td>";
                            }
                            echo "<td><a href='php/Financial_Recheck.php?EXECUTE=10&INSURER=SCOTTISH_WIDOWS' class='btn btn-default btn-sm'><i class='fa fa-check-circle'></i> Check all non matching policies</a></td>";
                            echo "</tr>";
                            echo "\n";
                        }
                    } else {
                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong>Info!</strong> No unmatched policies!</div>";
                    }
                    ?>   
                </table>
            </div>

        <div id="SCOTTISH_WIDOWS_EXPORT" class="tab-pane fade">
                        
                            <center>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=1<?php echo "&datefrom=$SCOTTISH_WIDOWS_DATE_FROM&dateto=$SCOTTISH_WIDOWS_DATE_TO&commdate=$SCOTTISH_WIDOWS_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM & SALE (Policies on Time)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=2<?php echo "&commdate=$SCOTTISH_WIDOWS_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> COMM Date (JUST COMMS)</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=3<?php echo "&datefrom=$SCOTTISH_WIDOWS_DATE_FROM&dateto=$SCOTTISH_WIDOWS_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Sale Date (Missing and Policies on Time)</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=4<?php echo "&datefrom=$SCOTTISH_WIDOWS_DATE_FROM&dateto=$SCOTTISH_WIDOWS_DATE_TO&commdate=$SCOTTISH_WIDOWS_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> GROSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=5<?php echo "&commdate=$SCOTTISH_WIDOWS_COMM_DATE"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> LOSS</a>
                                        </div>


                                        <div class="col-xs-4">
                                            <a href='/addon/Life/Financials/export/Export.php?EXECUTE=6<?php echo "&datefrom=$SCOTTISH_WIDOWS_DATE_FROM&dateto=$SCOTTISH_WIDOWS_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> Awaiting</a>

                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-xs-12"><br>
                                    <div class="col-xs-4">
                                        <a href='/addon/Life/Financials/export/Export.php?EXECUTE=7<?php echo "&datefrom=$SCOTTISH_WIDOWS_DATE_FROM&dateto=$SCOTTISH_WIDOWS_DATE_TO"; ?>' class="btn btn-default"><i class="fa fa-cloud-download"></i> MISSING</a>

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
                 <h3 class="panel-title"><a data-toggle="collapse" href="#OVERVIEWcollapse1">Financial Statistics Overview</a></h3>
             </div>
             <div id="OVERVIEWcollapse1" class="panel-collapse collapse">
             <div class="panel-body">

                 <div class="tab-content">
                     <div id="OVERVIEW_home" class="tab-pane fade in active">  
            
            <?php           
            
            $OVER_ADL_EXPECTED_SUM = $VIT_ADL_EXPECTED_SUM + $RL_ADL_EXPECTED_SUM + $WOL_ADL_EXPECTED_SUM + $AVI_ADL_EXPECTED_SUM + $LV_ADL_EXPECTED_SUM + $ZURICH_ADL_EXPECTED_SUM + $SW_ADL_EXPECTED_SUM;
            $OVER_ADL_EXPECTED_SUM_FORMAT = number_format($OVER_ADL_EXPECTED_SUM, 2);
            
            $OVER_simply_EXPECTED_SUM = $SW_simply_EXPECTED_SUM + $VIT_simply_EXPECTED_SUM + $WOL_simply_EXPECTED_SUM  + $ZURICH_simply_EXPECTED_SUM + $RL_simply_EXPECTED_SUM + $LV_simply_EXPECTED_SUM + $AVI_simply_EXPECTED_SUM;
            $OVER_simply_EXPECTED_SUM_FORMAT = number_format($OVER_simply_EXPECTED_SUM, 2);
            
            $OVER_TOTAL_NEW_GROSS = $SW_TOTAL_NEW_GROSS + $VIT_TOTAL_NEW_GROSS + $WOL_TOTAL_NEW_GROSS + $ZURICH_TOTAL_NEW_GROSS  + $RL_TOTAL_NEW_GROSS + $LV_TOTAL_NEW_GROSS + $AVI_TOTAL_NEW_GROSS;
            $OVER_TOTAL_NET_GROSS_DISPLAY = number_format($OVER_TOTAL_NEW_GROSS, 2);
            
            $OVER_MISSING_SUM_DISPLAY_UNFORMATTED = $SW_MISSING_SUM_DISPLAY_UNFORMATTED + $VIT_MISSING_SUM_DISPLAY_UNFORMATTED + $WOL_MISSING_SUM_DISPLAY_UNFORMATTED + $ZURICH_MISSING_SUM_DISPLAY_UNFORMATTED  + $RL_MISSING_SUM_DISPLAY_UNFORMATTED + $LV_MISSING_SUM_DISPLAY_UNFORMATTED + $AVI_MISSING_SUM_DISPLAY_UNFORMATTED;
            $OVER_MISSING_SUM_DISPLAY = number_format($OVER_MISSING_SUM_DISPLAY_UNFORMATTED, 2);
            
            $OVER_ADL_AWAITING_SUM_DATES_FORMAT = $SW_ADL_AWAITING_SUM + $VIT_ADL_AWAITING_SUM + $WOL_ADL_AWAITING_SUM + $ZURICH_ADL_AWAITING_SUM  + $RL_ADL_AWAITING_SUM + $LV_ADL_AWAITING_SUM + $AVI_ADL_AWAITING_SUM;
            $OVER_ADL_AWAITING_SUM_FORMAT = number_format($OVER_ADL_AWAITING_SUM_DATES_FORMAT, 2);
            
            ?>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "ADL Projections"; ?></th>
                                </tr>
                                <th>Total Gross <i class="fa fa-question-circle" style="color:skyblue" title="ADL COMM Amount for policies that should be paid within <?php echo "$DATEFROM - $DATETO"; ?>.
                                                   
ADL <?php echo $OVER_ADL_EXPECTED_SUM_FORMAT; ?>

Insurer Percentage: <?php echo $OVER_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $OVER_ADL_EXPECTED_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_TOTALGROSS&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                
        <th>Insurer <?php echo "($simply_biz%)"; ?></th>
        <th>Net Gross <i class="fa fa-question-circle" style="color:skyblue" title="Projected Total Gross - Awaiting Policies within <?php echo "$DATEFROM - $DATETO  $OVER_TOTAL_NET_GROSS_DISPLAY"; ?>." ></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_NETGROSS&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
        <th>Unpaid <i class="fa fa-question-circle" style="color:skyblue" title="Policies that have not been paid <?php if (isset($DATEFROM)) { echo "within 2017-01-01 - $DATETO"; } ?>."></i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_UNPAID&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
        <th>Awaiting <i class="fa fa-question-circle" style="color:skyblue" title="Policies awaiting to be submitted <?php if (isset($DATEFROM)) { echo "within $DATEFROM - $DATETO"; } ?>.

ADL <?php echo $OVER_ADL_AWAITING_SUM_FORMAT; ?>

Insurer Percentage: <?php echo $OVER_simply_EXPECTED_SUM_FORMAT; ?>

Total: <?php echo $OVER_ADL_AWAITING_SUM_FORMAT; ?>"</i> <a href="/addon/Life/Financials/export/Export.php?EXECUTE=ADL_AWAITING&datefrom=<?php echo $DATEFROM; ?>&dateto=<?php echo $DATETO; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>

                            </tr>
                            </thead>
                                        
                                        <tr>
                                        <td><?php echo "£$OVER_ADL_EXPECTED_SUM_FORMAT"; ?></td>
                                        <td><?php echo "£$OVER_simply_EXPECTED_SUM_FORMAT"; ?></td>
                                        <td><?php echo "£$OVER_TOTAL_NET_GROSS_DISPLAY"; ?></td>
                                        <td><?php echo "£$OVER_MISSING_SUM_DISPLAY"; ?></td>  
                                        <td><?php echo "£$OVER_ADL_AWAITING_SUM_FORMAT"; ?></td>
                                        </tr>
                        </table>
                         
                         <?php                        
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/VITALITY/total_policies_sold-model.php');
                            $VIT_Total_Policies_Sold = new VIT_Total_Policies_SoldModal($pdo);
                            $VIT_Total_Policies_Sold_VARS = $VIT_Total_Policies_Sold->VIT_getTotal_Policies_Sold($DATEFROM, $DATETO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/VITALITY/total_policies_sold-view.php');                          
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/ROYAL/total_policies_sold-model.php');
                            $RL_Total_Policies_Sold = new RL_Total_Policies_SoldModal($pdo);
                            $RL_Total_Policies_Sold_VARS = $RL_Total_Policies_Sold->RL_getTotal_Policies_Sold($RL_DATE_FROM, $RL_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/ROYAL/total_policies_sold-view.php'); 
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/WOL/total_policies_sold-model.php');
                            $WOL_Total_Policies_Sold = new WOL_Total_Policies_SoldModal($pdo);
                            $WOL_Total_Policies_Sold_VARS = $WOL_Total_Policies_Sold->WOL_getTotal_Policies_Sold($WOL_DATE_FROM, $WOL_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/WOL/total_policies_sold-view.php');                             
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/AVIVA/total_policies_sold-model.php');
                            $AVI_Total_Policies_Sold = new AVI_Total_Policies_SoldModal($pdo);
                            $AVI_Total_Policies_Sold_VARS = $AVI_Total_Policies_Sold->AVI_getTotal_Policies_Sold($AVI_DATE_FROM, $AVI_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/AVIVA/total_policies_sold-view.php');       
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/LV/total_policies_sold-model.php');
                            $LV_Total_Policies_Sold = new LV_Total_Policies_SoldModal($pdo);
                            $LV_Total_Policies_Sold_VARS = $LV_Total_Policies_Sold->LV_getTotal_Policies_Sold($LV_DATE_FROM, $LV_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/LV/total_policies_sold-view.php');               
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/ZURICH/total_policies_sold-model.php');
                            $ZURICH_Total_Policies_Sold = new ZURICH_Total_Policies_SoldModal($pdo);
                            $ZURICH_Total_Policies_Sold_VARS = $ZURICH_Total_Policies_Sold->ZURICH_getTotal_Policies_Sold($ZURICH_DATE_FROM, $ZURICH_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/ZURICH/total_policies_sold-view.php');    
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/SCOTTISH_WIDOWS/total_policies_sold-model.php');
                            $SW_Total_Policies_Sold = new SW_Total_Policies_SoldModal($pdo);
                            $SW_Total_Policies_Sold_VARS = $SW_Total_Policies_Sold->SW_getTotal_Policies_Sold($SCOTTISH_WIDOWS_DATE_FROM, $SCOTTISH_WIDOWS_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/SCOTTISH_WIDOWS/total_policies_sold-view.php');                                
                         
                         ?>
                         
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "Indemnity Policies";?></th>
                                </tr>
                                <th>Vitality</th> 
                                <th>Royal London</th> 
                                <th>One Family</th> 
                                <th>Aviva</th> 
                                <th>LV</th> 
                                <th>Zurich</th>
                                <th>Scottish Widows</th>
                            </thead>
                                        
                                        <tr>
                                        <td><?php if(isset($VIT_POLICIES_SOLD)) { echo "$VIT_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($RL_POLICIES_SOLD)) { echo "$RL_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($WOL_POLICIES_SOLD)) { echo "$WOL_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($AVI_POLICIES_SOLD)) { echo "$AVI_POLICIES_SOLD"; } ?></td>  
                                        <td><?php if(isset($LV_POLICIES_SOLD)) { echo "$LV_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($ZURICH_POLICIES_SOLD)) { echo "$ZURICH_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($SW_POLICIES_SOLD)) { echo "$SW_POLICIES_SOLD"; } ?></td>
                                        </tr>
                        </table>         
                         
 <?php
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/VITALITY/total_ni_policies_sold-model.php');
                            $VIT_Total_NI_Policies_Sold = new VIT_Total_NI_Policies_SoldModal($pdo);
                            $VIT_Total_NI_Policies_Sold_VARS = $VIT_Total_NI_Policies_Sold->VIT_getTotal_NI_Policies_Sold($DATEFROM, $DATETO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/VITALITY/total_ni_policies_sold-view.php');                          
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/ROYAL/total_ni_policies_sold-model.php');
                            $RL_Total_NI_Policies_Sold = new RL_Total_NI_Policies_SoldModal($pdo);
                            $RL_Total_NI_Policies_Sold_VARS = $RL_Total_NI_Policies_Sold->RL_getTotal_NI_Policies_Sold($RL_DATE_FROM, $RL_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/ROYAL/total_ni_policies_sold-view.php'); 
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/WOL/total_ni_policies_sold-model.php');
                            $WOL_Total_NI_Policies_Sold = new WOL_Total_NI_Policies_SoldModal($pdo);
                            $WOL_Total_NI_Policies_Sold_VARS = $WOL_Total_NI_Policies_Sold->WOL_getTotal_NI_Policies_Sold($WOL_DATE_FROM, $WOL_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/WOL/total_ni_policies_sold-view.php');                             
                         
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/AVIVA/total_ni_policies_sold-model.php');
                            $AVI_Total_NI_Policies_Sold = new AVI_Total_NI_Policies_SoldModal($pdo);
                            $AVI_Total_NI_Policies_Sold_VARS = $AVI_Total_NI_Policies_Sold->AVI_getTotal_NI_Policies_Sold($AVI_DATE_FROM, $AVI_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/AVIVA/total_ni_policies_sold-view.php');       
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/LV/total_ni_policies_sold-model.php');
                            $LV_Total_NI_Policies_Sold = new LV_Total_NI_Policies_SoldModal($pdo);
                            $LV_Total_NI_Policies_Sold_VARS = $LV_Total_NI_Policies_Sold->LV_getTotal_NI_Policies_Sold($LV_DATE_FROM, $LV_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/LV/total_ni_policies_sold-view.php');               
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/ZURICH/total_ni_policies_sold-model.php');
                            $ZURICH_Total_NI_Policies_Sold = new ZURICH_Total_NI_Policies_SoldModal($pdo);
                            $ZURICH_Total_NI_Policies_Sold_VARS = $ZURICH_Total_NI_Policies_Sold->ZURICH_getTotal_NI_Policies_Sold($ZURICH_DATE_FROM, $ZURICH_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/ZURICH/total_ni_policies_sold-view.php');    
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/SCOTTISH_WIDOWS/total_ni_policies_sold-model.php');
                            $SW_Total_NI_Policies_Sold = new SW_Total_NI_Policies_SoldModal($pdo);
                            $SW_Total_NI_Policies_Sold_VARS = $SW_Total_NI_Policies_Sold->SW_getTotal_NI_Policies_Sold($SCOTTISH_WIDOWS_DATE_FROM, $SCOTTISH_WIDOWS_DATE_TO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/SCOTTISH_WIDOWS/total_ni_policies_sold-view.php');                                
                         
                         ?>
                         
                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8"><?php echo "Non-Indemnity Policies";?></th>
                                </tr>
                                <th>Vitality</th> 
                                <th>Royal London</th> 
                                <th>One Family</th> 
                                <th>Aviva</th> 
                                <th>LV</th> 
                                <th>Zurich</th>
                                <th>Scottish Widows</th>
                            </thead>
                                        
                                        <tr>
                                        <td><?php if(isset($VIT_NI_POLICIES_SOLD)) { echo "$VIT_NI_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($RL_NI_POLICIES_SOLD)) { echo "$RL_NI_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($WOL_NI_POLICIES_SOLD)) { echo "$WOL_NI_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($AVI_NI_POLICIES_SOLD)) { echo "$AVI_NI_POLICIES_SOLD"; } ?></td>  
                                        <td><?php if(isset($LV_NI_POLICIES_SOLD)) { echo "$LV_NI_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($ZURICH_NI_POLICIES_SOLD)) { echo "$ZURICH_NI_POLICIES_SOLD"; } ?></td>
                                        <td><?php if(isset($SW_NI_POLICIES_SOLD)) { echo "$SW_NI_POLICIES_SOLD"; } ?></td>
                                        </tr>
                        </table>  
                         
<?php

                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/STATS/avg_commission_premium-model.php');
                            $COMM_PREM_STATS = new Comm_Prem_Stats_Model($pdo);
                            $COMM_PREM_STATS_VARS = $COMM_PREM_STATS->VIT_Comm_Prem_Stats($DATEFROM, $DATETO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/STATS/avg_commission_premium-view.php');  
                            
                            require_once(BASE_URL.'/addon/Life/Financials/models/financials/STATS/most_cancels-model.php');
                            $CANCELS_STATS = new Cancels_Stats_Model($pdo);
                            $CANCELS_STATS_VARS = $CANCELS_STATS->VIT_Cancels_Stats($DATEFROM, $DATETO);
                            require_once(BASE_URL.'/addon/Life/Financials/views/financials/STATS/most_cancels-view.php');                              

?>
  
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
        $(function () {
            $("#RL_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#RL_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        }); 
        $(function () {
            $("#LV_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#LV_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });   
        $(function () {
            $("#AVI_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#AVI_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });    
        $(function () {
            $("#WOL_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#WOL_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        }); 
        $(function () {
            $("#Zurich_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#Zurich_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });        
        $(function () {
            $("#Scottish_Widows_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#Scottish_Widows_dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });         
    </script>  
</body>
</html>