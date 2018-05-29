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
            <title>ADL | Add Aegon Policy</title>
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

            <form action="/addon/Life/php/add_policy.php?EXECUTE=2&INSURER=Aegon&CID=<?php echo $CID; ?>" id="formentry" class="form-horizontal" role="form" method="POST">
                <div class="container-fluid shadow">
                    <div class="row">
                        
                        <div id="panel161" class="panel panel-default" data-role="panel" style="display: block;">
        <div class="panel-heading">Add new Aegon Policy</div>
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
                    <label class="control-label control-label-left col-sm-4" for="TYPE">Cover Type<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="TYPE" name="TYPE" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                            <option value=""></option>
                            <option value="LTA">LTA</option>
                            <option value="LTA CIC">LTA + CIC</option>
                            <option value="DTA">DTA</option>
                            <option value="DTA CIC">DTA + CIC</option>
                            <option value="CIC">CIC</option>
                        </select>
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