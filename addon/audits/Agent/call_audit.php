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
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | L&G Lead Audit</title>
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
    
        <form class="form-horizontal" method="POST" action="/addon/audits/Agent/php/add_call_audit.php?EXECUTE=1">
<fieldset>

<legend>Audit questions (Lead Gen)</legend>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Opening Section 1</h3>
</div>

<div class="panel-body">
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="REFERENCE">Reference ID</label>  
        <div class="col-md-4">
            <input id="REFERENCE" name="REFERENCE" class="form-control input-md" type="text">
        </div>
    </div>
    
    <div class="form-group">
  <label class="col-md-4 control-label" for="AGENT">Lead Gen</label>  
  <div class="col-md-4">
      <input id="AGENT" name='AGENT' class='form-control' placeholder="AGENT" class="form-control input-md" type="text" required>
  </div>
</div>

    <script>var options = {
	url: "/../../app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
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
      <input name="SQ1" id="Q1RADIO" value="Yes" type="radio" onclick="javascript:q1JAVA();" required>
      Yes
    </label> 
    <label class="radio-inline" for="SQ1">
      <input name="SQ1" id="name-Yes" value="No" type="radio" onclick="javascript:q1JAVA();" >
      No
    </label>
  </div>
</div>

<div id="Q1DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c1"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q1TEXT" name="Q1TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea>
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
<script type="text/javascript">

function q1JAVA() {
    if (document.getElementById('Q1RADIO').checked) {
        document.getElementById('Q1DIV').style.display = 'none';
    }
    else document.getElementById('Q1DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="calling">Q2. Said where they were calling from</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ2">
      <input name="SQ2" id="Q2RADIO" value="Yes" type="radio" onclick="javascript:q2JAVA();"required>
      Yes
    </label> 
    <label class="radio-inline" for="SQ2">
      <input name="SQ2" id="SQ2" value="No" type="radio" onclick="javascript:q2JAVA();">
      No
    </label>
  </div>
</div>

<div id="Q2DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q2TEXT" name="Q2TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea>
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
<script type="text/javascript">

function q2JAVA() {
    if (document.getElementById('Q2RADIO').checked) {
        document.getElementById('Q2DIV').style.display = 'none';
    }
    else document.getElementById('Q2DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="reason">Q3. Said the reason for the call</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ3">
      <input name="SQ3" id="Q3RADIO" value="Yes" type="radio" onclick="javascript:q3JAVA();"  required>
      Yes
    </label> 
    <label class="radio-inline" for="SQ3">
      <input name="SQ3" id="SQ3" value="No" onclick="javascript:q3JAVA();" type="radio">
      No
    </label>
  </div>
</div>

<div id="Q3DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q3TEXT" name="Q3TEXT" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea>
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
<script type="text/javascript">

function q3JAVA() {
    if (document.getElementById('Q3RADIO').checked) {
        document.getElementById('Q3DIV').style.display = 'none';
    }
    else document.getElementById('Q3DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="SQ4">Q4. Agent followed the script</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="SQ4">
      <input name="SQ4" id="Q4RADIO" value="Yes" type="radio" onclick="javascript:q4JAVA();" required>
      Yes
    </label> 
    <label class="radio-inline" for="SQ4">
      <input name="SQ4" id="SQ4" value="No" type="radio" onclick="javascript:q4JAVA();" >
      No
    </label>
  </div>
</div>

<div id="Q4DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q4TEXT" name="Q4TEXT" rows="1" cols="74" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea>
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
<script type="text/javascript">

function q4JAVA() {
    if (document.getElementById('Q4RADIO').checked) {
        document.getElementById('Q4DIV').style.display = 'none';
    }
    else document.getElementById('Q4DIV').style.display = 'block';

}
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
      <input name="S2AQ1" id="S2AQ1yes" value="Yes" type="radio" onclick="javascript:yesnoqual();" required>
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ1">
      <input name="S2AQ1" id="S2AQ1no" value="No" type="radio" onclick="javascript:yesnoqual();">
      No
    </label> 
  </div>
</div>

<div id="Qualifyyes" style="display:none">


<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ2">Q2. What was the main reason you took the policy out?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ2" id="Q6RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q6JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ2" id="radios-Yes" value="No"  type="radio" onclick="javascript:q6JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ2">Q3. Repayment or interest only?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ3" id="Q7RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q7JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ2">
      <input name="S2AQ3" id="S2AQ2" value="No"  type="radio" onclick="javascript:q7JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ4">Q4. When was your last review on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ4">
      <input name="S2AQ4" id="Q8RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q8JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ4">
      <input name="S2AQ4" id="S2AQ4" value="No" type="radio" onclick="javascript:q8JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ5">Q5. How did you take out the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ5">
      <input name="S2AQ5" id="Q9RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q9JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ5">
      <input name="S2AQ5" id="S2AQ5" value="No" type="radio" onclick="javascript:q9JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ6">Q6. How much are you paying on a monthly basis?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ6">
      <input name="S2AQ6" id="Q10RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q10JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="S2AQ6" id="S2AQ6" value="No" type="radio" onclick="javascript:q10JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ7">Q7. How much are you covered for?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ7">
      <input name="S2AQ7" id="Q11RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q11JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="S2AQ7" id="S2AQ7" value="No" type="radio" onclick="javascript:q11JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ8">Q8. How long do you have left on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input name="S2AQ8" id="Q12RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q12JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ8">
      <input name="S2AQ8" id="S2AQ8" value="No" type="radio" onclick="javascript:q12JAVA();">
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ9">Q9. Is your policy single, joint or separate?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ9">
      <input name="S2AQ9" id="Q13RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q13JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ9">
      <input name="S2AQ9" id="S2AQ9" value="No" type="radio" onclick="javascript:q13JAVA();">
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ10">Q10. Have you or your partner smoked in the last 12 months?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ10">
      <input name="S2AQ10" id="Q14RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q14JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ10">
      <input name="S2AQ10" id="S2AQ10" value="No" type="radio" onclick="javascript:q14JAVA();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="S2AQ11">Q11. Have you or your partner got or has had any health issues?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="S2AQ11">
      <input name="S2AQ11" id="Q15RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q15JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="S2AQ11">
      <input name="S2AQ11" id="S2AQ11" value="No" type="radio" onclick="javascript:q15JAVA();">
      No
    </label> 
  </div>
</div>

</div>
<script type="text/javascript">

function yesnoqual() {
    if (document.getElementById('S2AQ1yes').checked) {
        document.getElementById('Qualifyyes').style.display = 'none';
    }
    else document.getElementById('Qualifyyes').style.display = 'block';

}
</script>
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
      <input name="S2BQ1" value="Yes" type="radio" id="S2BQ1yescheck" onclick="javascript:yesnoCheckc1();" required>
      Yes
    </label> 
    <label class="radio-inline" for="S2BQ1">
      <input name="S2BQ1" value="No" type="radio" id="S2BQ1nocheck" onclick="javascript:yesnoCheckc1();" >
      No
    </label> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="Q2S2BQ2">Q2. Were all questions recorded correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Q2S2BQ2">
      <input name="Q2S2BQ2" id="Q2S2BQ2yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc2();" required>
      Yes
    </label> 
    <label class="radio-inline" for="Q2S2BQ2">
      <input name="Q2S2BQ2" id="Q2S2BQ2no" value="No" type="radio" onclick="javascript:yesnoCheckc2();">
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
      <input name="Q1S4Q1n" id="Q1S4Q1nyes" value="Yes" type="radio" onclick="javascript:yesnoCheckc4();" required>
      Yes
    </label> 
    <label class="radio-inline" for="Q1S4Q1n">
      <input name="Q1S4Q1n" id="Q1S4Q1nno" value="No" type="radio" onclick="javascript:yesnoCheckc4();">
      No
    </label> 
  </div>
</div>
        
<div id="ifYesc4" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Q1S4C1n" name="Q1S4C1n" maxlength="1000" ></textarea>
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
<script type="text/javascript">
function yesnoCheckc4() {
    if (document.getElementById('Q1S4Q1nyes').checked) {
        document.getElementById('ifYesc4').style.display = 'none';
    }
    else document.getElementById('ifYesc4').style.display = 'block';

}
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
      <input name="Q1S3Q1" id="Q1S3Q1yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc3();" required>
      Yes
    </label> 
    <label class="radio-inline" for="Q1S3Q1">
      <input name="Q1S3Q1" id="Q1S3Q1no" value="No" type="radio" onclick="javascript:yesnoCheckc3();">
      No
    </label> 
  </div>
</div>

</div>
</div>

<!-- Button -->
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