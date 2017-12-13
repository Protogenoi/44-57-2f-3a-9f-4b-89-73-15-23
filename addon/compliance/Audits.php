<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');

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

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /../../../index.php?AccessDenied');
    die;
}

        $COMID = filter_input(INPUT_GET, 'COMID', FILTER_SANITIZE_NUMBER_INT);
        $SCID = filter_input(INPUT_GET, 'SCID', FILTER_SANITIZE_SPECIAL_CHARS);
        
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Audit Overview</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.css">
        <link href="/resources/templates/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/resources/templates/ADL/Notices.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/includes/NAV.php'); ?> 

    <div class="container-fluid"><br>
                <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
<div class="card"">
<h3 class="card-header">
Audit overview for all providers.
</h3>
<div class="card-block">

<p class="card-text">

                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    Legal and General
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php   
                             
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
                                    Royal London
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Audit grades for this week.</p>
                               
                             <?php             
     
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
                                    One Family
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
                                    Aviva
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
    
<h4 class="card-title"></h4>


</p>
</div>
<div class="card-footer">
ADL
</div>
</div>        
        
               
    </div>
                </div>
    </div>
    

            <script src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
            <script src="/resources/templates/bootstrap/js/bootstrap.min.js"></script> 
        
</body>
</html>
