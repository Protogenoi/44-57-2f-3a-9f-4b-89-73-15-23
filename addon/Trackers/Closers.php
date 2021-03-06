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

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

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

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 1) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }


if ($fftrackers == '0') {
    header('Location: /../../../CRMmain.php?Feature=NotEnabled');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_POST, 'DATES', FILTER_SANITIZE_SPECIAL_CHARS);
$CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Closer Trackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/ADL/Notices.css">
    <link rel="stylesheet" type="text/css" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />  
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <body>

        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

        <?php
        if (isset($EXECUTE)) {
        if($EXECUTE=='1') { ?>
                   
  <div class="container">
<?php if(in_array($hello_name, $Level_3_Access, true)) { ?> 
                    <div class="col-md-12">

                        <div class="col-md-4">
                                 <div class="btn-group">
                                     <a class="btn btn-default btn-sm" href="Agent.php?EXECUTE=1"><i class="fa fa-check-circle"></i> Agent Trackers</a>
                                 </div>   
                            
                        </div>
                        <div class="col-md-4"></div>

                        <div class="col-md-4">

                            <?php echo "<h3>$Today_DATES</h3>"; ?>
                            <?php echo "<h4>$Today_TIME</h4>"; ?>

                        </div>

                    </div>

                    <div class="list-group">
                        <span class="label label-primary">Closer Trackers</span>
                        <br><br>
                        <form action="?EXECUTE=1" method="post">

                            <div class="col-md-12">
                                <div class="col-md-4">
                             <select class="form-control" name="CLOSER" id="CLOSER">
                                 <option value="All" <?php if($CLOSER=='All') { echo "selected"; } ?>>All</option>
                                 <?php
                                    $CLO_QRY = $pdo->prepare("SELECT 
    firstname
FROM
    employee_details
WHERE
    position = 'Closer' AND employed = '1'
        AND company = :COMPANY");
                                    $CLO_QRY->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
                                    $CLO_QRY->execute();
if ($CLO_QRY->rowCount() > 0) {
                                    while ($result = $CLO_QRY->fetch(PDO::FETCH_ASSOC)) {   
                                        
                                        if(isset($result['firstname'])) {
                                        $CLOSER_NAME=$result['firstname'];
                                        
                                        if($CLOSER_NAME=='Michael') {
                                            $CLOSER_NAME='Mike';
                                        } elseif($CLOSER_NAME == 'Ryan') {
                                            $CLOSER_NAME="Ryan Tidball";
                                        } elseif($CLOSER_NAME == 'Jade BLANK') {
                                            $CLOSER_NAME="Jade";
                                        } elseif($CLOSER_NAME == 'Aron') {
                                            $CLOSER_NAME="Aron Davies";
                                        }
                                        
                                        }
                                        
                                        
                                 
                                 ?>
                                 <option value='<?php if(isset($CLOSER_NAME)) { echo $CLOSER_NAME; } ?>' <?php if($CLOSER_NAME==$CLOSER) { echo "selected"; } ?> ><?php if(isset($CLOSER_NAME)) { echo $CLOSER_NAME; } ?></option>
<?php } } ?>       
                             </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="text" id="DATES" name="DATES" value="<?php if(isset($datefrom)) { echo "$datefrom"; } else { echo date("Y-m-d"); } ?>" class="form-control">
                          </div>
                                
                             <div class="col-md-4">
                                 <div class="btn-group">
                                 <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-calendar-alt"></i> Set Dates</button> 
                                 </form>
                                 <a class="btn btn-default btn-sm" href="Export/Closers.php?EXECUTE=1&DATE=<?php if(isset($datefrom)) { echo "$datefrom"; } else { echo date("Y-m-d"); } ?>"><i class="fa fa-file-excel"></i> Export</a>
                                 <a class="btn btn-danger btn-sm" href="?EXECUTE=1"><i class="fa fa-recycle"></i> RESET</a>
                                 </div>
                          </div>

                              
                            </div>

                       
                    </div>
                        
                        <?php } ?>
      <div class="STATREFRESH"></div>
      
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: 'AJAX/Stats.php?EXECUTE=1',
                type: 'POST',
                success: function (results) {
                    jQuery(".STATREFRESH").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 1000);
    </script>
    
      
  </div>

<div class="container-fluid">
                        <?php
if (isset($datefrom)) {
    if(isset($CLOSER)) {
        if($CLOSER!='All') {
    $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE DATE(date_updated)=:date AND closer=:closer");
    $CLO_CHK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $CLO_CHK->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {
        
        require_once(__DIR__ . '/models/trackers/CLOSER/StatsPAD.php');
        $StatsPad = new STATSPadModal($pdo);
        $StatsPadList = $StatsPad->getSTATSPad($datefrom,$CLOSER);
        require_once(__DIR__ . '/views/trackers/CLOSER/Stats-PAD.php');

        require_once(__DIR__ . '/models/trackers/CLOSER/CloserPAD.php');
        $CloserPad = new CLOSERPadModal($pdo);
        $CloserPadList = $CloserPad->getCLOSERPad($datefrom,$CLOSER);
        require_once(__DIR__ . '/views/trackers/CLOSER/Closer-PAD.php');
    }
} 

if($CLOSER=='All') {
        $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE DATE(date_updated)=:date");
    $CLO_CHK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {
        
       require_once(__DIR__ . '/models/trackers/CLOSER/AllStatsPAD.php');
        $AllStatsPad = new AllSTATSPadModal($pdo);
        $AllStatsPadList = $AllStatsPad->AllgetSTATSPad($datefrom);
        require_once(__DIR__ . '/views/trackers/CLOSER/AllStats-PAD.php');
       
        require_once(__DIR__ . '/models/trackers/CLOSER/AllCloserPAD.php');
        $CloserPad = new AllCLOSERPadModal($pdo);
        $CloserPadList = $CloserPad->AllgetCLOSERPad($datefrom);
        require_once(__DIR__ . '/views/trackers/CLOSER/AllCloser-PAD.php');
        
    }
}
    }
} 

if (!isset($datefrom)) {
    $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE date_updated >=CURDATE()");
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {
        
        require_once(__DIR__ . '/models/trackers/CLOSER/StatsALLPAD.php');
        $StatsPad = new STATSALLPadModal($pdo);
        $StatsPadList = $StatsPad->getSTATSALLPad();
        require_once(__DIR__ . '/views/trackers/CLOSER/Stats-PAD.php');

        require_once(__DIR__ . '/models/trackers/CLOSER/CloserALLPAD.php');
        $CloserPad = new CLOSERAllPadModal($pdo);
        $CloserPadList = $CloserPad->getCLOSERALLPad();
        require_once(__DIR__ . '/views/trackers/CLOSER/Closer-PAD.php');
    }
}
?>  

                    </div>

     <?php   }
}
?>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <script>
        $(function () {
            $("#DATES").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>          
</body>
</html>