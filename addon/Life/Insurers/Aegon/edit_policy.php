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
$PID = filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$NAME = filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    if ($EXECUTE == '1') {
    
        if (isset($CID)) {

    $tracking_search= "%search=$CID%";
}

    $query = $pdo->prepare("SELECT 
        adl_policy_id,
        aegon_policy_id,
adl_policy_policy_holder,
adl_policy_closer,
adl_policy_agent,
adl_policy_sale_date,
adl_policy_sub_date,
adl_policy_status,
adl_policy_ref,
aegon_policy_type,
aegon_policy_premium,
aegon_policy_comms,
aegon_policy_non_indem_comms,
aegon_policy_cover_amount,
aegon_policy_policy_term,
aegon_policy_cb_term,
aegon_policy_drip,
aegon_policy_comms_type,
    CONCAT(client_details.title, ' ',client_details.first_name,' ',client_details.last_name) AS NAME, 
    CONCAT(client_details.title2, ' ',client_details.first_name2,' ',client_details.last_name2) AS NAME2
FROM
    adl_policy
        JOIN
    aegon_policy ON adl_policy.adl_policy_id = aegon_policy.aegon_policy_id_fk
    JOIN
    client_details on client_details.client_id = adl_policy.adl_policy_client_id_fk
WHERE    
    adl_policy_client_id_fk = :CID
    AND aegon_policy_id = :PID");
    $query->bindParam(':PID', $PID, PDO::PARAM_INT);
    $query->bindParam(':CID', $CID, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);
    
    $APID=$data2['adl_policy_id'];
    $VPID=$data2['aegon_policy_id'];
    
    if(empty($data2['covera'])) {
        $data2['covera']=0;
    } elseif(!is_numeric ( $data2['covera'] )) {
        $data2['covera']=0;
    }
    $COVER_AMOUNT = number_format($data2['covera'],2);
    
    $NAME = $data2['NAME'];
    
    if(isset($data2['NAME2'])) {
    $NAME2 = $data2['NAME2'];
    $NAME3 = $data2['NAME'] ." and ". $data2['NAME2']; 
    
    }

    $query2 = $pdo->prepare("SELECT email, email2 FROM client_details WHERE client_id=:CID");
    $query2->bindParam(':CID', $CID, PDO::PARAM_INT);
    $query2->execute();
    $data3 = $query2->fetch(PDO::FETCH_ASSOC);
        ?>
        <html lang="en">
            <title>ADL | Edit Aegon Policy</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
            <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
            <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
            <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
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
        </head>
        <body>

            <?php require_once(__DIR__ . '/../../../../includes/navbar.php'); ?>

            <br>

            <div class="container">
        <div class="row">

            <form id="EDIT_FORM" name="EDIT_FORM" action="/addon/Life/php/edit_policy.php?EXECUTE=2&VPID=<?php if(isset($VPID)) { echo $VPID; } ?>&CID=<?php if(isset($CID)) { echo $CID; } ?>&INSURER=Aegon&APID=<?php if(isset($APID)) { echo $APID;  } ?>" class="form-horizontal" role="form" method="POST">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div id="panel161" class="panel panel-warning" data-role="panel" style="display: block;">
        <div class="panel-heading"><?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?> Aegon Policy</div>
        <div class="panel-body">
            
        <div class="row">
            <div class="col-md-4">
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="CLIENT_NAME">Client</label>
                    <div class="controls col-sm-9">
                        <select id="CLIENT_NAME" class="form-control"  name="CLIENT_NAME" readonly>
                            <option value="<?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?>"><?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?> </option>
                            <option value="<?php if(isset($NAME)) { echo $NAME;  } ?>"><?php if(isset($NAME)) { echo $NAME;  } ?> </option>
                            <?php if (!empty($NAME2) && $NAME3) { ?>
                            <option value="<?php if(isset($NAME2)) { echo $NAME2;  } ?>"><?php if(isset($NAME2)) { echo $NAME2;  } ?> </option>
                            <option value="<?php if(isset($NAME3)) { echo $NAME3;  } ?>"><?php if(isset($NAME3)) { echo $NAME3;  } ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_REF">Policy</label>
                    <div class="controls col-sm-9">
                        <input id="POLICY_REF" name="POLICY_REF" value="<?php if(isset($data2['adl_policy_ref'])) { echo $data2['adl_policy_ref'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                 
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="TYPE">Cover Type<span class="req"> *</span></label>
                    <div class="controls col-sm-5">
                        <select id="TYPE" name="TYPE" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" required>
                            <option value=""></option>
                            <option value="LTA" <?php if(isset($data2['aegon_policy_type']) && $data2['aegon_policy_type'] == 'LTA') { echo "selected"; } ?> >LTA</option>
                            <option value="LTA CIC" <?php if(isset($data2['aegon_policy_type']) && $data2['aegon_policy_type'] == 'LTA CIC') { echo "selected"; } ?>>LTA + CIC</option>
                            <option value="DTA" <?php if(isset($data2['aegon_policy_type']) && $data2['aegon_policy_type'] == 'DTA') { echo "selected"; } ?>>DTA</option>
                            <option value="DTA CIC" <?php if(isset($data2['aegon_policy_type']) && $data2['aegon_policy_type'] == 'DTA CIC') { echo "selected"; } ?>>DTA + CIC</option>
                            <option value="CIC" <?php if(isset($data2['aegon_policy_type']) && $data2['aegon_policy_type'] == 'CIC') { echo "selected"; } ?>>CIC</option>
                        </select>
                    </div>
                </div>    
            
            
            </div>
            
            <div class="col-md-4">
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="PREMIUM">Premium</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_premium'])) { echo $data2['aegon_policy_premium'];  } ?>" id="PREMIUM" name="PREMIUM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>             
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="COMMS_TYPE">Comm Type</label>
                    <div class="controls col-sm-5">
                        <select id="COMMS_TYPE" name="COMMS_TYPE" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                            <option value="Indemnity" <?php if(isset($data2['aegon_policy_comms_type']) && $data2['aegon_policy_comms_type'] == 'Indemnity') { echo "selected";  } ?>>Indemnity</option>
                            <option value="Non Indemnity" <?php if(isset($data2['aegon_policy_comms_type']) && $data2['aegon_policy_comms_type'] == 'Non Indemnity') { echo "selected";  } ?> >Non Indemnity</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="COMM">Comms</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_comms'])) { echo $data2['aegon_policy_comms'];  } ?>" id="COMM" name="COMM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>                
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="NON_INDEM_COMM">Non-Idem Comm</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_non_indem_comms'])) { echo $data2['aegon_policy_non_indem_comms'];  } ?>" id="NON_INDEM_COMM" name="NON_INDEM_COMM" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="COVER">Cover Amount</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_cover_amount'])) { echo $data2['aegon_policy_cover_amount'];  } ?>" id="COVER_AMOUNT" name="COVER_AMOUNT" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="TERM">Policy Term</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_policy_term'])) { echo $data2['aegon_policy_policy_term'];  } ?>" id="TERM" name="TERM" value="" type="text" class="form-control k-input" data-role="numeric" data-format="integer" role="spinbutton" aria-valuenow="" aria-disabled="false" aria-readonly="false">
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="CB_TERM">Clawback Term</label>
                    <div class="controls col-sm-5">
                        <select id="CB_TERM" class="form-control"  selected="selected" name="CB_TERM">
                            <option value="<?php if(isset($data2['aegon_policy_cb_term'])) { echo "selected";  } ?>"><?php if(isset($data2['aegon_policy_cb_term'])) { echo $data2['aegon_policy_cb_term'];  } ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="DRIP">Drip</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['aegon_policy_drip'])) { echo $data2['aegon_policy_drip'];  } ?>" id="DRIP" name="DRIP" value="0" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1">
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-4" for="CLOSER">Closer</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['adl_policy_closer'])) { echo $data2['adl_policy_closer'];  } ?>" id="CLOSER" name="CLOSER" type="text" class="form-control k-textbox" data-role="text" required>
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
                    <label class="control-label control-label-left col-sm-4" for="AGENT">Agent</label>
                    <div class="controls col-sm-5">
                        <input value="<?php if(isset($data2['adl_policy_agent'])) { echo $data2['adl_policy_agent'];  } ?>" id="AGENT" name="AGENT" type="text" class="form-control k-textbox" data-role="text" required>
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
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SALE_DATE">Sale Date</label>
                    <div class="controls col-sm-9">
                                <input id="SALE_DATE" name="SALE_DATE" value="<?php if(isset($data2['adl_policy_sale_date'])) { echo $data2['adl_policy_sale_date'];  } ?>" type="text" class="form-control k-input" data-role="date" role="textbox" aria-haspopup="true" aria-expanded="false" aria-owns="field29_dateview" style="width: 100%;" aria-disabled="false" aria-readonly="false" >
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SUB_DATE">Submitted Date</label>
                    <div class="controls col-sm-9">
                            <span class="k-picker-wrap k-state-default">
                                <input id="SUB_DATE" name="SUB_DATE" value="<?php if(isset($data2['adl_policy_sub_date'])) { echo $data2['adl_policy_sub_date'];  } ?>" type="text" class="form-control k-input" data-role="date" role="textbox" aria-haspopup="true" aria-expanded="false" aria-owns="field30_dateview" style="width: 100%;" aria-disabled="false" aria-readonly="false" >
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_STATUS">Status</label>
                    <div class="controls col-sm-9">
                        <select id="POLICY_STATUS" class="form-control"  selected="selected" name="POLICY_STATUS" required>
                                        <option value="Live" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Live') { echo "selected";  } ?>>Live</option>
                                        <option value="Awaiting" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Awaiting') { echo "selected";  } ?>>Awaiting</option>
                                        <option value="Not Live" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Not Live') { echo "selected";  } ?>>Not Live</option>
                                        <option value="NTU" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'NTU') { echo "selected";  } ?>>NTU</option>
                                        <option value="Declined" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Declined') { echo "selected";  } ?>>Declined</option>
                                        <option value="Redrawn" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Redrawn') { echo "selected";  } ?>>Redrawn</option>
                                        <option value="On Hold" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'On Hold') { echo "selected";  } ?>>On Hold</option>
                                        <option value="Cancelled" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Cancelled') { echo "selected";  } ?>>Cancelled</option>
                                        <option value="Clawback" <?php if(isset($data2['adl_policy_status']) && $data2['adl_policy_status'] == 'Clawback') { echo "selected";  } ?>>Clawback</option>
                        </select>
                    </div>
                </div>
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="CHANGE_REASON">Change reason</label>
                    <div class="controls col-sm-9">
                        <select id="CHANGE_REASON" class="form-control"  name="CHANGE_REASON" required>
                            <option value="">Select...</option>
                                    <option value="Updated TBC Policy Number">Updated TBC Policy Number</option>
                                    <option value="Incorrect Policy Number">Incorrect Policy Number</option>
                                    <option value="Incorrect Single/Joint">Incorrect Single/Joint</option>
                                    <option value="Incorrect Application Number">Application Number</option>
                                    <option value="Incorrect Policy Holder">Incorrect Policy Holder</option>
                                    <option value="Incorrect Sale Date">Incorrect Sale Date</option>
                                    <option value="Incorrect Submitted Date<">Incorrect Submitted Date</option>
                                    <option value="Incorrect Policy Type">Incorrect Policy Type  (LTA, DTA, etc...)</option>
                                    <option value="Incorrect Insurer">Incorrect Insurer</option>
                                    <option value="Incorrect Premium">Incorrect Premium</option>
<?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                                        <option value="Incorrect Commission">Incorrect Commission</option>
<?php } ?>
                                    <option value="Incorrect Comm Type">Incorrect Comms Type</option>
                                    <option value="Incorrect Clawback Term">Incorrect Clawback Term</option>
                                    <option value="Incorrect Drip">Incorrect Drip</option>
                                    <option value="Incorrect Lead Gen">Incorrect Lead Gen</option>
                                    <option value="Incorrect Closer">Incorrect Closer</option>
                                    <option value="Update Policy Status">Update Policy Status</option>
                                    <option value="Updated Cover Amount">Update Cover Amount</option>
<?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                                        <option value="Admin Change">Admin Change</option>
<?php } ?>
                        </select>
                    </div>
                </div>               
            
            </div>

        </div>
        </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-warning">Update</button>
            </form>
        </div>
    </div>
<script>
    document.querySelector('#EDIT_FORM').addEventListener('submit', function (e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Save changes?",
            text: "You will not be able to recover any overwritten data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: 'Complete!',
                            text: 'Policy details updated!',
                            type: 'success'
                        }, function () {
                            form.submit();
                        });

                    } else {
                        swal("Cancelled", "No Changes have been submitted", "error");
                    }
                });
    });

</script>
<script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
</body>
</html>
<?php } } ?>