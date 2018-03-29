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
$INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    if ($EXECUTE == '1') {
    
        if (isset($CID)) {

    $tracking_search= "%search=$CID%";
}

    $query = $pdo->prepare("SELECT 
    adl_policy_policy_holder,
    adl_policy_closer,
    adl_policy_agent,
    adl_policy_sale_date,
    adl_policy_sub_date,
    adl_policy_status,
    adl_policy_ref,
    adl_policy_added_by,
    adl_policy_updated_by,
    adl_policy_added_date,
    adl_policy_updated_date,
    vitality_policy_plan,
    vitality_policy_type,
    vitality_policy_cover,
    vitality_policy_cover_type,
    vitality_policy_sic_opt,
    vitality_policy_term_prem,
    vitality_policy_wellness,
    vitality_policy_premium,
    vitality_policy_comms,
    vitality_policy_non_indem_comms,
    vitality_policy_cover_amount,
    vitality_policy_policy_term,
    vitality_policy_cb_term,
    vitality_policy_drip,
    vitality_policy_comms_type,
    vitality_policy_kids_sic_name,
    vitality_policy_kids_sic_dob,
    vitality_policy_kids_sic_amount,
    vitality_policy_kids_sic_opt,
         vitality_policy_sic_policy_term,
    vitality_policy_sic_cover_amount
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        JOIN
    vitality_policy_kids_sic ON vitality_policy.vitality_policy_id = vitality_policy_kids_sic_id_fk
WHERE    
    adl_policy_client_id_fk = :CID
    AND vitality_policy_id = :PID");
    $query->bindParam(':PID', $PID, PDO::PARAM_INT);
    $query->bindParam(':CID', $CID, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);
    
    if(empty($data2['covera'])) {
        $data2['covera']=0;
    } elseif(!is_numeric ( $data2['covera'] )) {
        $data2['covera']=0;
    }
    $COVER_AMOUNT = number_format($data2['covera'],2);

    $query2 = $pdo->prepare("SELECT email, email2 FROM client_details WHERE client_id=:CID");
    $query2->bindParam(':CID', $CID, PDO::PARAM_INT);
    $query2->execute();
    $data3 = $query2->fetch(PDO::FETCH_ASSOC);
        ?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2018
-->
        <html lang="en">
            <title>ADL | View Vitality Policy</title>
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

            <form action="" class="form-horizontal" role="form">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div id="panel161" class="panel panel-primary" data-role="panel" style="display: block;">
        <div class="panel-heading"><?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?> Vitality Policy</div>
        <div class="panel-body">
            
        <div class="row">
            <div class="col-md-4">
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="CLIENT_NAME">Client</label>
                    <div class="controls col-sm-9">
                        <select id="CLIENT_NAME" class="form-control"  name="CLIENT_NAME" readonly>
                            <option value="<?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?>"><?php if(isset($data2['adl_policy_policy_holder'])) { echo $data2['adl_policy_policy_holder'];  } ?> </option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_REF">Policy</label>
                    <div class="controls col-sm-9">
                        <input readonly id="POLICY_REF" name="POLICY_REF" value="<?php if(isset($data2['adl_policy_ref'])) { echo $data2['adl_policy_ref'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Plan">Plan</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_plan'])) { echo $data2['vitality_policy_plan'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>      
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Type">Type</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_type'])) { echo $data2['vitality_policy_type'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                  
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Type">Cover</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_cover'])) { echo $data2['vitality_policy_cover'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>        
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="COVER_TYPE_1">Cover type</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_cover_type'])) { echo $data2['vitality_policy_cover_type'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SIC_OPT_1">SIC Opt</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_sic_opt'])) { echo $data2['vitality_policy_sic_opt'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                  
                                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="WELLNESS_OPT">Term Prem</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_term_prem'])) { echo $data2['vitality_policy_term_prem'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="WELLNESS">Wellness</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_term_prem'])) { echo $data2['vitality_policy_wellness'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                   
                             
                
            </div>
            
            <div class="col-md-4">
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Premium">Premium</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_premium'])) { echo $data2['vitality_policy_premium'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                  
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="COMMS_TYPE">Comm Type</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_comms_type'])) { echo $data2['vitality_policy_comms_type'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                               
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Comms">Comms</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_comms'])) { echo $data2['vitality_policy_comms'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>  
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="NON_INDEM_COMM">Non-Idem Comm</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_non_indem_comms'])) { echo $data2['vitality_policy_non_indem_comms'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="COVER_AMOUNT">Cover</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_cover_amount'])) { echo $data2['vitality_policy_cover_amount'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div> 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="TERM">Policy Term</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_policy_term'])) { echo $data2['vitality_policy_policy_term'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div> 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SIC_COVER_AMOUNT">SIC Cover</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_cover_amount'])) { echo $data2['vitality_policy_sic_cover_amount'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div> 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SIC_TERM">SIC Policy Term</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_policy_term'])) { echo $data2['vitality_policy_sic_policy_term'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="CB_TERM">Clawback Term</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_cb_term'])) { echo $data2['vitality_policy_cb_term'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Drip">Drip</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['vitality_policy_drip'])) { echo $data2['vitality_policy_drip'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Closer">Closer</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_closer'])) { echo $data2['adl_policy_closer'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="Agent">Agent</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_agent'])) { echo $data2['adl_policy_agent'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>  

        
            </div>
            
            <div class="col-md-4">             
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SALE_DATE">Sale Date</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_sale_date'])) { echo $data2['adl_policy_sale_date'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>  

                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="SUB_DATE">Submitted Date</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_sub_date'])) { echo $data2['adl_policy_sub_date'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>     
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="POLICY_STATUS">Status</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_status'])) { echo $data2['adl_policy_status'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div> 
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="ADDED_BY">Added by</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_added_by'])) { echo $data2['adl_policy_added_by'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                  
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="ADDED_DATE">Date added</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_added_date'])) { echo $data2['adl_policy_added_date'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>   
                
                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="EDIT_BY">Last edited by</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_updated_by'])) { echo $data2['adl_policy_updated_by'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div> 

                 <div class="form-group" style="display: block;">
                    <label class="control-label control-label-left col-sm-3" for="EDIT_BY">Updated date</label>
                    <div class="controls col-sm-9">
                        <input readonly value="<?php if(isset($data2['adl_policy_updated_date'])) { echo $data2['adl_policy_updated_date'];  } ?>" type="text" class="form-control k-textbox" data-role="text"  >
                    </div>
                </div>                 

 <div class="form-group">
     <div class="col-md-10">
         <center>
         <a href="/app/Client.php?search=<?php echo $CID; ?>" class="btn btn-warning "><i class="fa fa-arrow-circle-o-left"></i> Back</a>
         <a href="edit_policy.php?EXECUTE=1&PID=<?php echo $PID; ?>&CID=<?php echo $CID; ?>" class="btn btn-warning "><i class="fa fa-edit"></i> Edit Policy</a>
         </center>
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
                            <input readonly value="<?php if(isset($data2['vitality_policy_kids_sic_name'])) { echo $data2['vitality_policy_kids_sic_name'];  } ?>" id="KID_NAME_1" name="KID_NAME_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label control-label-left col-sm-3" for="KID_DOB_1">DOB</label>
                        <div class="controls col-sm-9">
                            <input readonly value="<?php if(isset($data2['vitality_policy_kids_sic_dob'])) { echo $data2['vitality_policy_kids_sic_dob'];  } ?>" id="KID_DOB_1" name="KID_DOB_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_AMOUNT_1">Amount</label>
                        <div class="controls col-sm-9">
                            <input readonly value="<?php if(isset($data2['vitality_policy_kids_sic_amount'])) { echo $data2['vitality_policy_kids_sic_amount'];  } ?>" id="KID_AMOUNT_1" name="KID_AMOUNT_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" style="display: block;">
                        <label class="control-label control-label-left col-sm-3" for="KID_OPT_1"></label>
                        <div class="controls col-sm-9">
                            <input readonly value="<?php if(isset($data2['vitality_policy_kids_sic_opt'])) { echo $data2['vitality_policy_kids_sic_opt'];  } ?>" id="KID_AMOUNT_1" name="KID_AMOUNT_1" type="text" class="form-control k-textbox" data-role="text">
                        </div>
                    </div>
                </div>                

            </div>
        </div>
        </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

</body>
</html>
<?php } } ?>