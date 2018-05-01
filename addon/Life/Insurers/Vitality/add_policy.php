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
    if ($EXECUTE == '1') {

        $query = $pdo->prepare("SELECT 
            CONCAT(title, ' ', first_name, ' ', last_name) AS Name,
            CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 
        FROM 
            client_details
        WHERE 
            client_id = :CID");
        $query->bindParam(':CID', $CID, PDO::PARAM_STR);
        $query->execute();
        $data2 = $query->fetch(PDO::FETCH_ASSOC);

        if(isset($data2['Name2'])) {
            $NAME2=$data2['Name2'];
        }
        ?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2018
-->
        <html lang="en">
            <title>ADL | Add Vitality Policy</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
            <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
            <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
            <link  rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
            <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
            <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
            
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
            <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
            <script src="/resources/lib/js-webshim/minified/polyfiller.js"></script>
            <script>
                $(function () {
                    $("#SALE_DATE").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
                $(function () {
                    $("#SUB_DATE").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
                $(function () {
                    $("#KID_DOB_1").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });    
                $(function () {
                    $("#KID_DOB_2").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });        
                $(function () {
                    $("#KID_DOB_3").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });   
                $(function () {
                    $("#KID_DOB_4").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });    
                 $(function () {
                    $("#KID_DOB_5").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });       
                 $(function () {
                    $("#KID_DOB_6").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });                  
            </script>
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

            <form action="/addon/Life/php/add_policy.php?EXECUTE=1&INSURER=Vitality&CID=<?php echo $CID; ?>" id="formentry" class="form-horizontal" role="form" method="POST">
                <div class="container-fluid shadow">
                    <div class="row">
                        
                        <div id="panel161" class="panel panel-default" data-role="panel" style="display: block;">
        <div class="panel-heading">Add new Vitality Policy</div>
        <div class="panel-body">
            
        <div class="row">
            <div class="col-md-4">
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="CLIENT_NAME">Client<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <select id="CLIENT_NAME" class="form-control"  name="CLIENT_NAME" required>
                                            <option value="<?php echo $data2['Name']; ?>"><?php echo $data2['Name']; ?></option>
                                            <?php if (isset($NAME2)) { ?>
                                            <option value="<?php echo $data2['Name2']; ?>"><?php echo $data2['Name2']; ?></option>
                                            <option value="<?php echo "$data2[Name] and  $data2[Name2]"; ?>"><?php echo "$data2[Name] and  $data2[Name2]"; ?></option>
                                            <?php } ?>  
                        </select>
                    </div>
                </div>
                
                <div class="form-group alert alert-info" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_REF">Policy Reference<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <input id="POLICY_REF" name="POLICY_REF" type="text" class="form-control k-textbox" data-role="text"  placeholder="TBC">
                        <span class="help-block"><strong>For Awaiting/TBC polices leave as TBC. A unique ID will be generated.</strong></span>
                    </div>
                </div>                
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3">Plan<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="PLAN_1">
                            <input type="radio" value="Essential" id="PLAN_1" name="PLAN" required>Essential</label>
                            <label class="radio-inline" for="PLAN_2">
                                <input type="radio" value="Vitality Life" id="PLAN_2" name="PLAN" >Vitality Life</label>
                    </div>
                </div>            
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3">Type<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="TYPE_1">
                            <input type="radio" value="Index" id="TYPE_1" name="TYPE" required>Index</label>
                            <label class="radio-inline" for="TYPE_2">
                                <input type="radio" value="DTA" id="TYPE_2" name="TYPE" >DTA</label>
                                <label class="radio-inline" for="TYPE_3">
                                    <input type="radio" value="LTA" id="TYPE_3" name="TYPE" >LTA</label>
                                    <label class="radio-inline" for="TYPE_4">
                                    <input type="radio" value="WOL" id="TYPE_4" name="TYPE" >WOL</label></div>
                </div>        
                
                <div class="form-group" style="display: block">
                    <label class="control-label control-label-left col-sm-3">Cover</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="SIC_SELECTED_3">
                            <input type="radio" value="Life" id="SIC_SELECTED_3" name="COVER" required>Life</label>
                            <label class="radio-inline" for="SIC_SELECTED_1">
                                <input type="radio" value="Life or SIC" id="SIC_SELECTED_1" name="COVER">Life or SIC</label>
                        <label class="radio-inline" for="SIC_SELECTED_2">
                                <input type="radio" value="Life and SIC" id="SIC_SELECTED_2" name="COVER">Life and SIC</label>
                    </div>
                </div>  

        <script>$(function () {
        $("#SIC_SELECTED_1").click(function () {
            if ($(this).is(":checked")) {
                $("#sic_type_div").show();
                $("#sic_opt_div").show();
                 $("#SIC_COVER_AMOUNT").show();
                $("#SIC_TERM").show();                 
            } else {
                $("#sic_type_div").hide();
                $("#sic_opt_div").hide();
                $("#SIC_COVER_AMOUNT").hide();
                $("#SIC_TERM").hide();                
            }
        });
        $("#SIC_SELECTED_2").click(function () {
            if ($(this).is(":checked")) {
                $("#sic_type_div").show();
                $("#sic_opt_div").show();
                 $("#SIC_COVER_AMOUNT").show();
                $("#SIC_TERM").show();               
            } else {
                $("#sic_type_div").hide();
                $("#sic_opt_div").hide();
                 $("#SIC_COVER_AMOUNT").hide();
                $("#SIC_TERM").hide();                 
            }
        });        
    });</script>                  
                
                <div class="form-group" style="display: none" id="sic_type_div">
                    <label class="control-label control-label-left col-sm-3">Cover type</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="COVER_TYPE_1">
                            <input type="radio" value="Protected SIC" id="COVER_TYPE_1" name="COVER_TYPE">Protected SIC</label>
                        <label class="radio-inline" for="COVER_TYPE_2">
                            <input type="radio" value="Protected Life" id="COVER_TYPE_2" name="COVER_TYPE">Protected Life</label>                            
                            <label class="radio-inline" for="COVER_TYPE_3">
                                <input type="radio" value="Not protected" id="COVER_TYPE_3" name="COVER_TYPE">Not protected</label>
                                <span class="help-block radio-inline">(If cover == SIC)</span>
                    </div>
                </div>                   
                
                <div class="form-group" style="display: none;" id="sic_opt_div">
                    <label class="control-label control-label-left col-sm-3">SIC Opt</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="SIC_OPT_1">
                            <input type="radio" value="Primary" id="SIC_OPT_1" name="SIC_OPT">Primary</label>
                            <label class="radio-inline" for="SIC_OPT_2">
                                <input type="radio" value="Comprehensive" id="SIC_OPT_2" name="SIC_OPT">Comprehensive</label>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3">Term Prem<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="TERM_PREM_1">
                            <input type="radio" value="No opt" id="TERM_PREM_1" name="WELLNESS_OPT" required>No opt</label>
                            <label class="radio-inline" for="TERM_PREM_2">
                                <input type="radio" value="Wellness opt" name="WELLNESS_OPT" id="TERM_PREM_2" >Wellness opt</label>
                    </div>
                </div>

        <script>$(function () {
        $("#TERM_PREM_2").click(function () {
            if ($(this).is(":checked")) {
                $("#wellness_div").show();
            } else {
                $("#wellness_div").hide();
            }
        });
    });</script>                
                
                <div class="form-group" style="display: none" id="wellness_div">
                    <label class="control-label control-label-left col-sm-3">Wellness</label>
                    <div class="controls col-sm-9">
                        <label class="radio-inline" for="WELLNESS_1">
                            <input type="radio" value="Vital Lite" id="WELLNESS_1" name="VITAL">Vital Lite</label>
                            <label class="radio-inline" for="WELLNESS_2">
                                <input type="radio" value="Vital Plus" id="WELLNESS_2" name="VITAL">Vital Plus</label>
                                <span class="help-block radio-inline">(If wellness opt selected)</span>
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
                    <label class="control-label control-label-left col-sm-4" for="COMMS_TYPE">Comm Type<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="COMMS_TYPE" name="COMMS_TYPE" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                            <option value=""></option>
                            <option value="Indemnity">Indemnity</option>
                            <option value="Non Indemnity">Non-Indem</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="COMM">Comms</label>
                    <div class="controls col-sm-5">
                        <input id="COMM" name="COMM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div>                
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="NON_INDEM_COMM">Non-Idem Comm</label>
                    <div class="controls col-sm-5">
                        <input id="NON_INDEM_COMM" name="NON_INDEM_COMM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="COVER">Cover Amount</label>
                    <div class="controls col-sm-5">
                        <input id="COVER_AMOUNT" name="COVER_AMOUNT" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="TERM">Policy Term</label>
                    <div class="controls col-sm-5">
                        <input id="TERM" name="TERM" value="" type="text" class="form-control k-input" data-role="numeric" data-format="integer" role="spinbutton" aria-valuenow="" aria-disabled="false" aria-readonly="false" required>
                    </div>
                </div>
                
                <div class="form-group" style="display: none;" id="SIC_COVER_AMOUNT">
                    <label class="control-label control-label-left col-sm-4" for="SIC_COVER_AMOUNT">SIC Cover Amount</label>
                    <div class="controls col-sm-5">
                        <input id="SIC_COVER_AMOUNT" name="SIC_COVER_AMOUNT" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>
                
                <div class="form-group" style="display: none;" id="SIC_TERM">
                    <label class="control-label control-label-left col-sm-4" for="SIC_TERM">SIC Policy Term</label>
                    <div class="controls col-sm-5">
                        <input id="SIC_TERM" name="SIC_TERM" value="" type="text" class="form-control k-input" data-role="numeric" data-format="integer" role="spinbutton" aria-valuenow="" aria-disabled="false" aria-readonly="false">
                    </div>
                </div>                
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="CB_TERM">Clawback Term<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="CB_TERM" class="form-control"  selected="selected" name="CB_TERM" required>
                            <option value=""></option>
                                                    <?php for ($CB_TERM = 52; $CB_TERM > 11; $CB_TERM = $CB_TERM - 1) {
                                                            if($CB_TERM< 12) {
                                                               break; 
                                                    } 
                                                            ?>
                                                        <option value="<?php echo $CB_TERM;?>"><?php echo $CB_TERM; ?></option>
                                                        <?php } ?>
                                                        <option value="1 year">1 year</option>
                                                        <option value="2 year">2 year</option>
                                                        <option value="3 year">3 year</option>
                                                        <option value="4 year">4 year</option>
                                                        <option value="5 year">5 year</option>
                                                        <option value="0">0</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="DRIP">Drip<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <input id="DRIP" name="DRIP" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="CLOSER">Closer<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <input id="CLOSER" name="CLOSER" type="text" class="form-control k-textbox" data-role="text" required>
                    </div>
                </div>
                
<script>
    var options = {
        url: "/../../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
        getValue: "full_name",
        list: {
            match: {
                enabled: true
    }
    }
    };
    $("#CLOSER").easyAutocomplete(options);
</script>                
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="AGENT">Agent<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <input id="AGENT" name="AGENT" type="text" class="form-control k-textbox" data-role="text" required>
                    </div>
                </div>
            
                                                    <script>var options = {
                                                            url: "/../../../app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };
                                                        $("#AGENT").easyAutocomplete(options);</script>               
            </div>
            
            <div class="col-md-4">
                
                <div class="form-group alert alert-info" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SALE_DATE">Sale Date<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                                <input id="SALE_DATE" name="SALE_DATE" value="<?php echo date('Y-m-d H:i:s'); ?>" type="text" class="form-control k-input" data-role="date" role="textbox" aria-haspopup="true" aria-expanded="false" aria-owns="field29_dateview" style="width: 100%;" aria-disabled="false" aria-readonly="false" required>
                                <span class="help-block"><strong>This is the sale date on the deal sheet.</strong></span>
                    </div>
                </div>
                
                <div class="form-group alert alert-info" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SUB_DATE">Submitted Date<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                            <span class="k-picker-wrap k-state-default">
                                <input id="SUB_DATE" name="SUB_DATE" value="<?php echo date('Y-m-d H:i:s'); ?>" type="text" class="form-control k-input" data-role="date" role="textbox" aria-haspopup="true" aria-expanded="false" aria-owns="field30_dateview" style="width: 100%;" aria-disabled="false" aria-readonly="false" required>
                                    <span class="help-block"><strong>This is the policy live date on the insurers portal.</strong></span>
                    </div>
                </div>
                
                <div class="form-group alert alert-info" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_STATUS">Policy Status<span class="req"> *</span></label>
                    <div class="controls col-sm-9">
                        <select id="POLICY_STATUS" class="form-control"  selected="selected" name="POLICY_STATUS" required>
                            <option value=""></option>
                            <option value="Live">Live</option>
                            <option value="Awaiting">Awaiting</option>
                            <option value="Not Live">Not Live</option>
                            <option value="NTU">NTU</option>
                            <option value="Declined">Declined</option>
                            <option value="Redrawn">Redrawn</option>
                            <option value="On Hold">On Hold</option>
                        </select>
                        <span class="help-block"><strong>For any policy where the submitted date is unknown. The policy status should be awaiting.</strong></span>
                    </div>
                </div>
            
            </div>
                                                    
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group brdbot">
			    <h4>Bolted on kids SIC</h4>
                
		</div>
                </div>
            </div>
            
            <div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_1">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_1" name="KID_NAME_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_1">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_1" name="KID_DOB_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_1">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_1" name="KID_AMOUNT_1" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_1">
                                <input type="radio" value="Primary" id="KID_OPT_1" name="KID_OPT_1">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_1" name="KID_OPT_1" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_1" name="KID_OPT_1" type="radio" value="Index">Index</label>
                                        <label class="radio-inline">
                                        <input id="KID_OPT_1" name="KID_OPT_1" type="radio" value="Comp and Index">Comp and Index</label> 
                                        <label class="radio-inline">
                                        <input id="KID_OPT_1" name="KID_OPT_1" type="radio" value="Pri and Index">Pri and Index</label>                                         
                        </div>
                    </div>
                </div>
            </div>
            
<div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_2">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_2" name="KID_NAME_2" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_2">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_2" name="KID_DOB_2" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_2">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_2" name="KID_AMOUNT_2" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_2">
                                <input type="radio" value="Primary" id="KID_OPT_2" name="KID_OPT_2">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_2" name="KID_OPT_2" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_2" name="KID_OPT_2" type="radio" value="Index">Index</label>
                                        <label class="radio-inline">
                                        <input id="KID_OPT_2" name="KID_OPT_2" type="radio" value="Comp and Index">Comp and Index</label> 
                                        <label class="radio-inline">
                                        <input id="KID_OPT_2" name="KID_OPT_2" type="radio" value="Pri and Index">Pri and Index</label> 
                        </div>
                    </div>
                </div>
            </div>   
            
<div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_3">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_3" name="KID_NAME_3" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_3">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_3" name="KID_DOB_3" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_3">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_3" name="KID_AMOUNT_3" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_3">
                                <input type="radio" value="Primary" id="KID_OPT_3" name="KID_OPT_3">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_3" name="KID_OPT_3" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_3" name="KID_OPT_3" type="radio" value="Index">Index</label>
                                        <label class="radio-inline">
                                        <input id="KID_OPT_3" name="KID_OPT_3" type="radio" value="Comp and Index">Comp and Index</label> 
                                        <label class="radio-inline">
                                        <input id="KID_OPT_3" name="KID_OPT_3" type="radio" value="Pri and Index">Pri and Index</label> 
                        </div>
                    </div>
                </div>
            </div>     
            
<div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_4">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_4" name="KID_NAME_4" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_4">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_4" name="KID_DOB_4" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_4">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_4" name="KID_AMOUNT_4" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_4">
                                <input type="radio" value="Primary" id="KID_OPT_4" name="KID_OPT_4">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_4" name="KID_OPT_4" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_4" name="KID_OPT_4" type="radio" value="Index">Index</label>
                                        <label class="radio-inline">
                                        <input id="KID_OPT_4" name="KID_OPT_4" type="radio" value="Comp and Index">Comp and Index</label> 
                                  <label class="radio-inline">
                                        <input id="KID_OPT_4" name="KID_OPT_4" type="radio" value="Pri and Index">Pri and Index</label>       
                        </div>
                    </div>
                </div>
            </div>    
            
<div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_5">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_5" name="KID_NAME_5" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_5">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_5" name="KID_DOB_5" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_5">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_5" name="KID_AMOUNT_5" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_5">
                                <input type="radio" value="Primary" id="KID_OPT_5" name="KID_OPT_5">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_5" name="KID_OPT_5" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_5" name="KID_OPT_5" type="radio" value="Index">Index</label>
                                        <label class="radio-inline">
                                        <input id="KID_OPT_5" name="KID_OPT_5" type="radio" value="Comp and Index">Comp and Index</label> 
                                        <label class="radio-inline">
                                        <input id="KID_OPT_5" name="KID_OPT_5" type="radio" value="Pri and Index">Pri and Index</label> 
                        </div>
                    </div>
                </div>
            </div>           
            
  <div class="row" style="display: block;">
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_NAME_6">Name</label>
                        <div class="controls col-sm-9">
                            <input id="KID_NAME_6" name="KID_NAME_6" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_6">DOB</label>
                        <div class="controls col-sm-9">
                            <input id="KID_DOB_6" name="KID_DOB_6" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_6">Amount</label>
                        <div class="controls col-sm-9">
                            <input id="KID_AMOUNT_6" name="KID_AMOUNT_6" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3 sr-only"></label>
                        <div class="controls col-sm-9">
                            <label class="radio-inline" for="KID_OPT_6">
                                <input type="radio" value="Primary" id="KID_OPT_6" name="KID_OPT_6">Pri</label>
                                <label class="radio-inline">
                                    <input id="KID_OPT_6" name="KID_OPT_6" type="radio" value="Comp">Comp</label>
                                    <label class="radio-inline">
                                        <input id="KID_OPT_6" name="KID_OPT_6" type="radio" value="Index">Index</label>
                                   <label class="radio-inline">
                                        <input id="KID_OPT_6" name="KID_OPT_6" type="radio" value="Comp and Index">Comp and Index</label>  
                                        <label class="radio-inline">
                                        <input id="KID_OPT_6" name="KID_OPT_6" type="radio" value="Pri and Index">Pri and Index</label> 
                        </div>
                    </div>
                </div>
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
<?php } } ?>