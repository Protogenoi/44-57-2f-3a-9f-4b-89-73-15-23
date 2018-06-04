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

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

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

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();

if(!in_array($hello_name, $ANYTIME_ACCESS,true)) {

if($TRACKED_IP!='81.145.167.66') {
    $page_protect->log_out();
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
    header('Location: /../../../CRMmain.php');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$DATES = filter_input(INPUT_POST, 'DATES', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Survey Trackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/ADL/Notices.css">
    <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
    <link rel="stylesheet" type="text/css" href="/resources/templates/ADL/control_panel.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <body>

<?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>
        
        <div class="container">
                    <div class="col-md-12">

                        <div class="col-md-8">
            
                <div class='notice notice-info' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-exclamation fa-lg'></i> Info:</strong> <b>You are logged in as <font color="red"><?php echo $hello_name; ?></font>. All trackers will be saved to this user, ensure that you are logged into your own account!</b></div>
            
                            
                        </div>
                   

                        <div class="col-md-4">

                            <?php echo "<h3>$Today_DATES</h3>"; ?>
                            <?php echo "<h4>$Today_TIME</h4>"; ?>

                        </div>

                    </div>
         
   

                            <div class="col-md-12">
                                <form action="?EXECUTE=1" method="post"> 
                                
                                <div class="col-md-4">
                                    <input type="text" id="DATES" name="DATES" value="<?php if(isset($DATES)) { echo "$DATES"; } else { echo date("Y-m-d"); } ?>" class="form-control">
                          </div>
                                
                             <div class="col-md-4">
                                 <div class="btn-group">
                                 <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-calendar-alt"></i> Search old data</button> 
                                 </div>
                                 </form>  
                            </div>
            
                                <div class="col-md-4">

                                </div>
                    
        </div> 
        <?php
        
        if(isset($DATES)) {
            
            $QRY_CHK = $pdo->prepare("SELECT 
                survey_tracker_id 
            FROM 
                survey_tracker 
            WHERE 
                survey_tracker_agent = :HELLO
            AND 
                DATE(survey_tracker_updated_date) = :DATE
            OR  
                DATE(survey_tracker_added_date) = :DATES");
            $QRY_CHK->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
            $QRY_CHK->bindParam(':DATE', $DATES, PDO::PARAM_STR);
            $QRY_CHK->bindParam(':DATES', $DATES, PDO::PARAM_STR);
    $QRY_CHK->execute();
    if ($QRY_CHK->rowCount() > 0) {
        
        require_once(__DIR__ . '/models/trackers/SURVEY/Survey-Dated-model.php');
        $SURVEY_DATA_LIST = new SURVEY_MODAL($pdo);
        $SURVEY_DATA_LIST_R = $SURVEY_DATA_LIST->getSurveyData($hello_name,$DATES);
        require_once(__DIR__ . '/views/trackers/SURVEY/Survey-view.php'); 
        
    }            
            
        } else {
        
            $QRY_CHK = $pdo->prepare("SELECT 
                survey_tracker_id 
            FROM 
                survey_tracker 
            WHERE 
                survey_tracker_agent = :HELLO
            AND 
                DATE(survey_tracker_updated_date) >= CURDATE()");
            $QRY_CHK->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
    $QRY_CHK->execute();
    if ($QRY_CHK->rowCount() > 0) {
        
        require_once(__DIR__ . '/models/trackers/SURVEY/Survey-model.php');
        $SURVEY_DATA_LIST = new SURVEY_MODAL($pdo);
        $SURVEY_DATA_LIST_R = $SURVEY_DATA_LIST->getSurveyData($hello_name);
        require_once(__DIR__ . '/views/trackers/SURVEY/Survey-view.php'); 
        
    }
    
        }
        
        ?>

</div>

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

<?php require_once(__DIR__ . '/../../app/Holidays.php'); ?>
</body>
</html>