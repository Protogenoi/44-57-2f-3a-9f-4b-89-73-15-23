<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /../../../../CRMmain.php'); die;
    }

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
$AUDITID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);     

if(isset($AUDITID)) {

    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT 
                            DATE(adl_audits_date_added) AS adl_audits_date_added, 
                            adl_audits_auditor, 
                            adl_audits_grade, 
                            adl_audits_agent,
                            adl_audits_ref
                        FROM 
                            adl_audits 
                        WHERE 
                            adl_audits_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_AUDIT=$database->single();   
    
    if(isset($VIT_AUDIT['adl_audits_date_added'])) {
        
        $VIT_DATE=$VIT_AUDIT['adl_audits_date_added'];
        
    }
    
    if(isset($VIT_AUDIT['adl_audits_auditor'])) {
        
        $VIT_AUDITOR=$VIT_AUDIT['adl_audits_auditor'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_grade'])) {
        
        $VIT_GRADE=$VIT_AUDIT['adl_audits_grade'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_agent'])) {
        
        $VIT_AGENT=$VIT_AUDIT['adl_audits_agent'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_ref'])) {
        
        $VIT_REF=$VIT_AUDIT['adl_audits_ref'];
        
    }  
    
    $database->query("SELECT 
        adl_audit_lead_id,
        adl_audit_lead_sec_1,
        adl_audit_lead_sec_2,
        adl_audit_lead_sec_3,
        adl_audit_lead_sec_4,
        adl_audit_lead_sec_c1,
        adl_audit_lead_sec_c2,
        adl_audit_lead_sec_c3,
        adl_audit_lead_sec_c4,
        adl_audit_lead_qua_a_1,
        adl_audit_lead_qua_a_2,
        adl_audit_lead_qua_a_3,
        adl_audit_lead_qua_a_4,
        adl_audit_lead_qua_a_5,
        adl_audit_lead_qua_a_6,
        adl_audit_lead_qua_a_7,
        adl_audit_lead_qua_a_8,
        adl_audit_lead_qua_a_9,
        adl_audit_lead_qua_a_10,
        adl_audit_lead_qua_a_11,
        adl_audit_lead_qua_b_1,
        adl_audit_lead_qua_b_2,
        adl_audit_lead_qua_sec3_1,
        adl_audit_lead_qua_sec3_c_1,
        adl_audit_lead_qua_sec4_1
  FROM
    adl_audit_lead
  WHERE
    adl_audit_lead_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_Q_AUDIT=$database->single();   
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_id'])) {
        $AID_FK=$VIT_Q_AUDIT['adl_audit_lead_id'];
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_1'])) {
        $SEC1=$VIT_Q_AUDIT['adl_audit_lead_sec_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_2'])) {
        $SEC2=$VIT_Q_AUDIT['adl_audit_lead_sec_2'];
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_3'])) {
        $SEC3=$VIT_Q_AUDIT['adl_audit_lead_sec_3'];
    }        
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_4'])) {
        $SEC4=$VIT_Q_AUDIT['adl_audit_lead_sec_4'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c1'])) {
        $SEC_C1=$VIT_Q_AUDIT['adl_audit_lead_sec_c1'];
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c2'])) {
        $SEC_C2=$VIT_Q_AUDIT['adl_audit_lead_sec_c2'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c3'])) {
        $SEC_C3=$VIT_Q_AUDIT['adl_audit_lead_sec_c3'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c4'])) {
        $SEC_C4=$VIT_Q_AUDIT['adl_audit_lead_sec_c4'];
    }  

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_1'])) {
        $SEC2_A_1=$VIT_Q_AUDIT['adl_audit_lead_qua_a_1'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_2'])) {
        $SEC2_A_2=$VIT_Q_AUDIT['adl_audit_lead_qua_a_2'];
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_3'])) {
        $SEC2_A_3=$VIT_Q_AUDIT['adl_audit_lead_qua_a_3'];
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_4'])) {
        $SEC2_A_4=$VIT_Q_AUDIT['adl_audit_lead_qua_a_4'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_5'])) {
        $SEC2_A_5=$VIT_Q_AUDIT['adl_audit_lead_qua_a_5'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_6'])) {
        $SEC2_A_6=$VIT_Q_AUDIT['adl_audit_lead_qua_a_6'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_7'])) {
        $SEC2_A_7=$VIT_Q_AUDIT['adl_audit_lead_qua_a_7'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_8'])) {
        $SEC2_A_8=$VIT_Q_AUDIT['adl_audit_lead_qua_a_8'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_9'])) {
        $SEC2_A_9=$VIT_Q_AUDIT['adl_audit_lead_qua_a_9'];
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_10'])) {
        $SEC2_A_10=$VIT_Q_AUDIT['adl_audit_lead_qua_a_10'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_11'])) {
        $SEC2_A_11=$VIT_Q_AUDIT['adl_audit_lead_qua_a_11'];
    }        
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_b_1'])) {
        $SEC2_B_1=$VIT_Q_AUDIT['adl_audit_lead_qua_b_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_b_2'])) {
        $SEC2_B_2=$VIT_Q_AUDIT['adl_audit_lead_qua_b_2'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec3_1'])) {
        $SEC3_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec3_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec3_c_1'])) {
        $SEC3_C_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec3_c_1'];
    } 

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec4_1'])) {
        $SEC4_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec4_1'];
    }   
    
    $database->endTransaction();  
    
}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Agent Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
</head>
<body>
    
    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">
    
        <form class="form-horizontal" method="POST" action="/addon/audits/Agent/php/edit_call_audit.php?EXECUTE=1&AID=<?php echo $AUDITID; ?>">
<fieldset>

<legend>Edit Agent Call Audit</legend>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Opening Section 1</h3>
</div>

<div class="panel-body">
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="REFERENCE">Reference ID</label>  
        <div class="col-md-4">
            <input id="REFERENCE" name="REFERENCE" class="form-control input-md" type="text" value="<?php if(isset($VIT_REF)) { echo $VIT_REF; } ?>" >
        </div>
    </div>
    
    <div class="form-group">
  <label class="col-md-4 control-label" for="AGENT">Lead Gen</label>  
  <div class="col-md-4">
      <input id="agents" name='AGENT' class='form-control' placeholder="AGENT" class="form-control input-md" type="text" required value="<?php if(isset($VIT_AGENT)) { echo $VIT_AGENT; } ?>">
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

<div class="form-group">
  <label class="col-md-4 control-label" for="name">Q1. Agent said their name</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ1">
      <input name="SQ1" id="Q1RADIO" value="Yes" type="radio" <?php if(isset($SEC1) && $SEC1 == 'Yes') { echo "checked"; } ?> required>
      Yes
    </label> 
    <label class="radio-inline" for="SQ1">
      <input name="SQ1" id="name-Yes" value="No" type="radio" <?php if(isset($SEC1) && $SEC1 == 'No') { echo "checked"; } ?>>
      No
    </label>
  </div>
</div>

<div id="Q1DIV" style="display:block">
<div class="form-group">
  <label class="col-md-4 control-label" for="c1"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q1TEXT" name="Q1TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($SEC_C1)) { echo $SEC_C1; } ?></textarea>
    <span class="help-block"><p id="Q1LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#Q1LEFT').text('1000 characters left');
    $('#Q1TEXT').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#Q1LEFT').text('You have reached the limit');
            $('#Q1LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#Q1LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#Q1LEFT').removeClass('red');            
        }
    });    
});
</script>

  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="calling">Q2. Said where they were calling from</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ2">
      <input name="SQ2" id="Q2RADIO" value="Yes" type="radio" required <?php if(isset($SEC2) && $SEC2 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="SQ2">
      <input name="SQ2" id="SQ2" value="No" type="radio" <?php if(isset($SEC2) && $SEC2 == 'No') { echo "checked"; } ?>>
      No
    </label>
  </div>
</div>

<div id="Q2DIV" style="display:block">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q2TEXT" name="Q2TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($SEC_C2)) { echo $SEC_C2; } ?></textarea>
    <span class="help-block"><p id="Q2LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#Q2LEFT').text('1000 characters left');
    $('#Q2TEXT').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#Q2LEFT').text('You have reached the limit');
            $('#Q2LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#Q2LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#Q2LEFT').removeClass('red');            
        }
    });    
});
</script>

  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="reason">Q3. Said the reason for the call</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ3">
      <input name="SQ3" id="Q3RADIO" value="Yes" type="radio" required <?php if(isset($SEC3) && $SEC3 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="SQ3">
      <input name="SQ3" id="SQ3" value="No" type="radio" <?php if(isset($SEC3) && $SEC3 == 'No') { echo "checked"; } ?>>
      No
    </label>
  </div>
</div>

<div id="Q3DIV" style="display:block">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q3TEXT" name="Q3TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($SEC_C3)) { echo $SEC_C3; } ?></textarea>
    <span class="help-block"><p id="Q3LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#Q3LEFT').text('1000 characters left');
    $('#Q3TEXT').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#Q3LEFT').text('You have reached the limit');
            $('#Q3LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#Q3LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#Q3LEFT').removeClass('red');            
        }
    });    
});
</script>

  </div>
</div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="SQ4">Q4. Agent followed the script</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ4">
      <input name="SQ4" id="Q4RADIO" value="Yes" type="radio" required <?php if(isset($SEC4) && $SEC4 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="SQ4">
      <input name="SQ4" id="SQ4" value="No" type="radio" <?php if(isset($SEC4) && $SEC4 == 'No') { echo "checked"; } ?>>
      No
    </label>
  </div>
</div>

<div id="Q4DIV" style="display:block">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q4TEXT" name="Q4TEXT" rows="1" cols="74" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($SEC_C4)) { echo $SEC_C4; } ?></textarea>
    <span class="help-block"><p id="Q4LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#Q4LEFT').text('1000 characters left');
    $('#Q4TEXT').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#Q4LEFT').text('You have reached the limit');
            $('#Q4LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#Q4LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#Q4LEFT').removeClass('red');            
        }
    });    
});
</script>

  </div>
</div>
</div>

</div>
</div>

<div class="panel panel-info">

    <div class="panel-heading">
<h3 class="panel-title">Qualifying Section 2a</h3>
</div>
<div class="panel-body">


<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ1">Q1. Were all the questions asked?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ1">
      <input name="S2AQ1" id="S2AQ1yes" value="Yes" type="radio" required <?php if(isset($SEC2_A_1) && $SEC2_A_1 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ1">
      <input name="S2AQ1" id="S2AQ1no" value="No" type="radio" <?php if(isset($SEC2_A_1) && $SEC2_A_1 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>

<div id="Qualifyyes" style="display:block">


<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ2">Q2. What was the main reason you took the policy out?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ2" id="Q6RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_2) && $SEC2_A_2 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ2" id="radios-Yes" value="No"  type="radio" <?php if(isset($SEC2_A_2) && $SEC2_A_2 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ2">Q3. Repayment or interest only?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ3" id="Q7RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_3) && $SEC2_A_3 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ3" id="S2AQ2" value="No"  type="radio" <?php if(isset($SEC2_A_3) && $SEC2_A_3 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ4">Q4. When was your last review on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ4">
      <input name="S2AQ4" id="Q8RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_4) && $SEC2_A_4 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ4">
      <input name="S2AQ4" id="S2AQ4" value="No" type="radio" <?php if(isset($SEC2_A_4) && $SEC2_A_4 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ5">Q5. How did you take out the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ5">
      <input name="S2AQ5" id="Q9RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_5) && $SEC2_A_5 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ5">
      <input name="S2AQ5" id="S2AQ5" value="No" type="radio" <?php if(isset($SEC2_A_5) && $SEC2_A_5 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ6">Q6. How much are you paying on a monthly basis?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ6">
      <input name="S2AQ6" id="Q10RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_6) && $SEC2_A_6 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="S2AQ6" id="S2AQ6" value="No" type="radio" <?php if(isset($SEC2_A_6) && $SEC2_A_6 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ7">Q7. How much are you covered for?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ7">
      <input name="S2AQ7" id="Q11RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_7) && $SEC2_A_7 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="S2AQ7" id="S2AQ7" value="No" type="radio" <?php if(isset($SEC2_A_7) && $SEC2_A_7 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ8">Q8. How long do you have left on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input name="S2AQ8" id="Q12RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_8) && $SEC2_A_8 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ8">
      <input name="S2AQ8" id="S2AQ8" value="No" type="radio" <?php if(isset($SEC2_A_8) && $SEC2_A_8 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ9">Q9. Is your policy single, joint or separate?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ9">
      <input name="S2AQ9" id="Q13RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_9) && $SEC2_A_9 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ9">
      <input name="S2AQ9" id="S2AQ9" value="No" type="radio" <?php if(isset($SEC2_A_9) && $SEC2_A_9 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ10">Q10. Have you or your partner smoked in the last 12 months?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ10">
      <input name="S2AQ10" id="Q14RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_10) && $SEC2_A_10 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ10">
      <input name="S2AQ10" id="S2AQ10" value="No" type="radio" <?php if(isset($SEC2_A_10) && $SEC2_A_10 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ11">Q11. Have you or your partner got or has had any health issues?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ11">
      <input name="S2AQ11" id="Q15RADIO" value="Yes" checked="checked" type="radio" <?php if(isset($SEC2_A_11) && $SEC2_A_11 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ11">
      <input name="S2AQ11" id="S2AQ11" value="No" type="radio" <?php if(isset($SEC2_A_11) && $SEC2_A_11 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

</div>

</div>
    
</div>

<div class="panel panel-info">

    <div class="panel-heading">
<h3 class="panel-title">Section 2b</h3>
</div>
<div class="panel-body">


<div class="form-group">
  <label class="col-md-4 control-label" for="S2BQ1">Q1. Were all questions asked correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2BQ1">
      <input name="S2BQ1" value="Yes" type="radio" id="S2BQ1yescheck" required <?php if(isset($SEC2_B_1) && $SEC2_B_1 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="S2BQ1">
      <input name="S2BQ1" value="No" type="radio" id="S2BQ1nocheck" <?php if(isset($SEC2_B_1) && $SEC2_B_1 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="Q2S2BQ2">Q2. Were all questions recorded correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Q2S2BQ2">
      <input name="Q2S2BQ2" id="Q2S2BQ2yes" value="Yes" type="radio" required <?php if(isset($SEC2_B_2) && $SEC2_B_2 == 'Yes') { echo "checked"; } ?>>
      Yes
    </label> 
    <label class="radio-inline" for="Q2S2BQ2">
      <input name="Q2S2BQ2" id="Q2S2BQ2no" value="No" type="radio" <?php if(isset($SEC2_B_2) && $SEC2_B_2 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>
    
</div>
</div>

<div class="panel panel-info">

    <div class="panel-heading">
<h3 class="panel-title">Section 3</h3>
</div>
    <div class="panel-body">
        
   <div class="form-group">
  <label class="col-md-4 control-label" for="Q1S4Q1n">Q1. Did the agent stick to branding compliance?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Q1S4Q1n">
      <input name="Q1S4Q1n" id="Q1S4Q1nyes" value="Yes" type="radio" required <?php if(isset($SEC3_1) && $SEC3_1 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="Q1S4Q1n">
      <input name="Q1S4Q1n" id="Q1S4Q1nno" value="No" type="radio" <?php if(isset($SEC3_1) && $SEC3_1 == 'No') { echo "checked"; } ?>>
      No
    </label> 
  </div>
</div>
        
<div id="ifYesc4" style="display:block">
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q1S4C1n" name="Q1S4C1n" maxlength="1000" ><?php if(isset($SEC3_C_1)) { echo $SEC3_C_1; } ?></textarea>
    <span class="help-block"><p id="characterLeftc4" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#characterLeftc4').text('1000 characters left');
    $('#Q1S4C1n').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeftc4').text('You have reached the limit');
            $('#characterLeftc4').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeftc4').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeftc4').removeClass('red');            
        }
    });    
});
</script>

  </div>
</div>
</div>
        
        
    </div>
</div>

<div class="panel panel-info">

    <div class="panel-heading">
<h3 class="panel-title">Section 4</h3>
</div>
<div class="panel-body">


<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Q1. Were all personal details recorded correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Q1S3Q1">
      <input name="Q1S3Q1" id="Q1S3Q1yes" value="Yes" type="radio" required <?php if(isset($SEC4_1) && $SEC4_1 == 'Yes') { echo "checked"; } ?> >
      Yes
    </label> 
    <label class="radio-inline" for="Q1S3Q1">
      <input name="Q1S3Q1" id="Q1S3Q1no" value="No" type="radio" <?php if(isset($SEC4_1) && $SEC4_1 == 'No') { echo "checked"; } ?> >
      No
    </label> 
  </div>
</div>

</div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
      <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-click"></i>Submit Audit</button>
  </div>
</div>



</fieldset>
</form>

    </div>
    <?php
    require_once(__DIR__ . '/../../../app/Holidays.php');

    if (isset($hello_name)) {

            if ($XMAS == 'December') {
                $SANTA_TIME = date("H");
                
                ?>
                <audio autoplay>
                    <source src="/app/sounds/<?php echo $XMAS_ARRAY[$RAND_XMAS_ARRAY[0]]; ?>" type="audio/mpeg">
                </audio>  
                <?php
          
            }
            
            if($HALLOWEEN=='31st of October') {  ?>

                <audio autoplay>
                    <source src="/app/sounds/halloween/<?php echo $RAND_HALLOWEEN_ARRAY; ?>" type="audio/mpeg">
                </audio>    
            <?php } }

    ?>  
    </body>
</html>
