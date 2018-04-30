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

require_once(__DIR__ . '/../../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(__DIR__ . '/../../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {

        ?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2018
-->
        <html lang="en">
            <title>ADL | Add Vitality Income Benefit</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
            <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
            <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
            <link  rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
            <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
            
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
            <script src="/resources/lib/js-webshim/minified/polyfiller.js"></script>
           
                        <script>
                webshims.setOptions('forms-ext', {
                    replaceUI: 'auto',
                    types: 'number'
                });
                webshims.polyfill('forms forms-ext');
            </script>
            <style>
                .form-row input {
                    padding: 3px 1px;
                    width: 100%;
                }
                input.currency {
                    text-align: right;
                    padding-right: 15px;
                }
                .input-group .form-control {
                    float: none;
                }
                .input-group .input-buttons {
                    position: relative;
                    z-index: 3;
                }
            </style>
        </head>
        <body>

            <?php require_once(__DIR__ . '/../../../../includes/navbar.php'); ?>

            <br>

            <div class="container">
        <div class="row">

            <form action="/addon/Life/php/add_income_benefit.php?EXECUTE=1&INSURER=Vitality&CID=<?php echo $CID; ?>" id="formentry" class="form-horizontal" role="form" method="POST">
                <div class="container-fluid shadow">
                    <div class="row">
                        
                        <div id="panel161" class="panel panel-default" data-role="panel" style="display: block;">
        <div class="panel-heading">Add Vitality Income Benefit</div>
        <div class="panel-body">
            
        <div class="row">
            <div class="col-md-4">

 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="REF">Policy Reference<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="REF" class="form-control"  selected="selected" name="REF" required>
                            <option value=""></option>
                            
                            <?php
                            
                            $query = $pdo->prepare("SELECT adl_policy_ref FROM adl_policy WHERE adl_policy_insurer ='Vitality' AND adl_policy_client_id_fk=:CID");
                            $query->bindParam(':CID', $CID, PDO::PARAM_STR);
                            $query->execute();
                                                    if ($query->rowCount() > 0) {
                                                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                                                            
                                                            $POLICY_REF = $row['adl_policy_ref'];
                                                            
                                                            ?>
                            <option value='<?php if(isset($POLICY_REF)) { echo $POLICY_REF; } ?>'><?php if(isset($POLICY_REF)) { echo $POLICY_REF; } ?></option>
                                                   <?php     }
                                                    }  ?>
                            
                            
                        </select>
                    </div>
                </div>             
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3">Type<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="TYPE_1">
                            <input type="radio" value="Primary" id="TYPE_1" name="TYPE" required>Primary</label>
                            <label class="radio-inline" for="TYPE_2">
                                <input type="radio" value="Comprehensive" id="TYPE_2" name="TYPE" >Comprehensive</label>
                             <label class="radio-inline" for="TYPE_2">
                                <input type="radio" value="Short term" id="TYPE_2" name="TYPE" >Short term</label>    
                    </div>
                </div>            
   
                <div class="form-group" style="display: block">
                    <label class="control-label control-label-left col-sm-3">Indexation Before Claim</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="INDEXATION_SELECTED_3">
                            <input type="radio" value="Yes" id="INDEXATION_SELECTED_3" name="INDEXATION" required>Yes</label>
                            <label class="radio-inline" for="INDEXATION_SELECTED_1">
                                <input type="radio" value="No" id="INDEXATION_SELECTED_1" name="INDEXATION">No</label>
                    </div>
                </div>  

                <div class="form-group" style="display: block">
                    <label class="control-label control-label-left col-sm-3">Escalation During Claim</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="ESCALATION_SELECTED_3">
                            <input type="radio" value="Indexed" id="ESCALATION_SELECTED_3" name="ESCALATION" required>Indexed</label>
                            <label class="radio-inline" for="ESCALATION_SELECTED_1">
                                <input type="radio" value="Level" id="ESCALATION_SELECTED_1" name="ESCALATION">Level</label>
                    </div>
                </div>
                
                <div class="form-group" style="display: block">
                    <label class="control-label control-label-left col-sm-3">Premium Type</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="PREMIUM_TYPE_SELECTED_3">
                            <input type="radio" value="Guaranteed" id="PREMIUM_TYPE_SELECTED_3" name="PREMIUM_TYPE" required>Guaranteed</label>
                            <label class="radio-inline" for="PREMIUM_TYPE_SELECTED_1">
                                <input type="radio" value="Reviewable" id="PREMIUM_TYPE_SELECTED_1" name="PREMIUM_TYPE">Reviewable</label>
                    </div>
                </div>    
                
            </div>
            
            <div class="col-md-4">
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="PREMIUM">Premium<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <input id="PREMIUM" name="PREMIUM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div>  
                  
                
 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="PERIOD">Deferred Period<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="PERIOD" class="form-control"  selected="selected" name="PERIOD" required>
                            <option value=""></option>
                                                        <option value="None">None</option>
                                                        <option value="1 month">1 month</option>
                                                        <option value="3 month">3 month</option>
                                                        <option value="6 month">6 month</option>
                                                        <option value="12 month">12 month</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="BENEFIT_AMOUNT">Benefit Amount<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <input id="BENEFIT_AMOUNT" name="BENEFIT_AMOUNT" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div> 
                
            <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="DEFERRED_PERIOD">Additional Deferred Period</label>
                    <div class="controls col-sm-5">
                        <select id="DEFERRED_PERIOD" class="form-control"  selected="selected" name="DEFERRED_PERIOD">
                            <option value=""></option>
                                                        <option value="None">None</option>
                                                        <option value="1 month">1 month</option>
                                                        <option value="3 month">3 month</option>
                                                        <option value="6 month">6 month</option>
                                                        <option value="12 month">12 month</option>
                        </select>
                    </div>
                </div> 
               
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="TERM">Fixed Term</label>
                    <div class="controls col-sm-6">
                        <input id="TERM" name="TERM" autocomplete="off" type="text" class="form-control">
                    </div>
                </div>                
                
            
            <div class="col-md-4">
                
                
            
            </div>   
            
        </div>
        </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-success">Save</button>
            </form>
        </div>
    </div>

</body>
</html>
<?php } ?>