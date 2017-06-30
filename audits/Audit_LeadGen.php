<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }
    
if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | L&G Lead Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
</head>
<body>
    
    <?php 
   require_once(__DIR__ . '/../includes/navbar.php');

    ?>

    <div class="container">
    
        <form class="form-horizontal" method="POST" action="php/AuditsLeadGenSubmit.php">
<fieldset>

<!-- Form Name -->
<legend>Audit questions (Lead Gen)</legend>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Opening Section 1</h3>
</div>

<div class="panel-body">
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="annumber">AN Number</label>  
        <div class="col-md-4">
            <input id="annumber" name="annumber" placeholder="AN Number" class="form-control input-md" type="text">
        </div>
    </div>
    
    <div class="form-group">
  <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
  <div class="col-md-4">
      <input id="provider-json" name='agent' class='form-control' required placeholder="Lead Gen" class="form-control input-md" type="text" required="">
  </div>
</div>

    <script>var options = {
	url: "../JSON/<?php if($companynamere=='Bluestone Protect') { echo "LeadGenNames" ; } else { echo "CUS_LEAD"; } ?>.json",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#provider-json").easyAutocomplete(options);</script>


<div class="form-group">
  <label class="col-md-4 control-label" for="name">Q1. Agent said their name</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="sq1">
      <input name="sq1" id="q1RADIO" value="Yes" type="radio" onclick="javascript:q1JAVA();" required>
      Yes
    </label> 
    <label class="radio-inline" for="sq1">
      <input name="sq1" id="name-Yes" value="No" type="radio" onclick="javascript:q1JAVA();" >
      No
    </label>
  </div>
</div>

<div id="q1DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c1"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q1TEXT" name="q1TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q1LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q1LEFT').text('400 characters left');
    $('#q1TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q1LEFT').text('You have reached the limit');
            $('#q1LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q1LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q1LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q1JAVA() {
    if (document.getElementById('q1RADIO').checked) {
        document.getElementById('q1DIV').style.display = 'none';
    }
    else document.getElementById('q1DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="calling">Q2. Said where they were calling from</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="sq2">
      <input name="sq2" id="q2RADIO" value="Yes" type="radio" onclick="javascript:q2JAVA();"required>
      Yes
    </label> 
    <label class="radio-inline" for="sq2">
      <input name="sq2" id="sq2" value="No" type="radio" onclick="javascript:q2JAVA();">
      No
    </label>
  </div>
</div>

<div id="q2DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q2TEXT" name="q2TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q2LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q2LEFT').text('400 characters left');
    $('#q2TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q2LEFT').text('You have reached the limit');
            $('#q2LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q2LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q2LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q2JAVA() {
    if (document.getElementById('q2RADIO').checked) {
        document.getElementById('q2DIV').style.display = 'none';
    }
    else document.getElementById('q2DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="reason">Q3. Said the reason for the call</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="sq3">
      <input name="sq3" id="q3RADIO" value="Yes" type="radio" onclick="javascript:q3JAVA();"  required>
      Yes
    </label> 
    <label class="radio-inline" for="sq3">
      <input name="sq3" id="sq3" value="No" onclick="javascript:q3JAVA();" type="radio">
      No
    </label>
  </div>
</div>

<div id="q3DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q3TEXT" name="q3TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q3LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q3LEFT').text('400 characters left');
    $('#q3TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q3LEFT').text('You have reached the limit');
            $('#q3LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q3LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q3LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q3JAVA() {
    if (document.getElementById('q3RADIO').checked) {
        document.getElementById('q3DIV').style.display = 'none';
    }
    else document.getElementById('q3DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="sq4">Q4. Used EU gender directive correctly</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="sq4">
      <input name="sq4" id="q4RADIO" value="Yes" type="radio" onclick="javascript:q4JAVA();" required>
      Yes
    </label> 
    <label class="radio-inline" for="sq4">
      <input name="sq4" id="directive-Yes" value="No" onclick="javascript:q4JAVA();" type="radio">
      No
    </label>
  </div>
</div>

<div id="q4DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q4TEXT" name="q4TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q4LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q4LEFT').text('400 characters left');
    $('#q4TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q4LEFT').text('You have reached the limit');
            $('#q4LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q4LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q4LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q4JAVA() {
    if (document.getElementById('q4RADIO').checked) {
        document.getElementById('q4DIV').style.display = 'none';
    }
    else document.getElementById('q4DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="sq5">Q5. Agent followed the script</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="sq5">
      <input name="sq5" id="q5RADIO" value="Yes" type="radio" onclick="javascript:q5JAVA();" required>
      Yes
    </label> 
    <label class="radio-inline" for="sq5">
      <input name="sq5" id="sq5" value="No" type="radio" onclick="javascript:q5JAVA();" >
      No
    </label>
  </div>
</div>

<div id="q5DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q5TEXT" name="q5TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q5LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q5LEFT').text('400 characters left');
    $('#q5TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q5LEFT').text('You have reached the limit');
            $('#q5LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q5LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q5LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q5JAVA() {
    if (document.getElementById('q5RADIO').checked) {
        document.getElementById('q5DIV').style.display = 'none';
    }
    else document.getElementById('q5DIV').style.display = 'block';

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
  <label class="col-md-4 control-label" for="s2aq1">Q1. Were all the questions asked?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq1">
      <input name="s2aq1" id="s2aq1yes" value="Yes" type="radio" onclick="javascript:yesnoqual();" required>
      Yes
    </label> 
    <label class="radio-inline" for="s2aq1">
      <input name="s2aq1" id="s2aq1no" value="No" type="radio" onclick="javascript:yesnoqual();">
      No
    </label> 
  </div>
</div>

<div id="qualifyyes" style="display:none">


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq2">Q2. What was the main reason you took the policy out?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq2">
      <input name="s2aq2" id="q6RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q6JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="s2aq2">
      <input name="s2aq2" id="radios-Yes" value="No"  type="radio" onclick="javascript:q6JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q6DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q6TEXT" name="q6TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q6LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q6LEFT').text('400 characters left');
    $('#q6TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q6LEFT').text('You have reached the limit');
            $('#q6LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q6LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q6LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q6JAVA() {
    if (document.getElementById('q6RADIO').checked) {
        document.getElementById('q6DIV').style.display = 'none';
    }
    else document.getElementById('q6DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq2">Q3. Repayment or interest only?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq2">
      <input name="s2aq3" id="q7RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q7JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="s2aq2">
      <input name="s2aq3" id="s2aq2" value="No"  type="radio" onclick="javascript:q7JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q7DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q7TEXT" name="q7TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q7LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q7LEFT').text('400 characters left');
    $('#q7TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q7LEFT').text('You have reached the limit');
            $('#q7LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q7LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q7LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q7JAVA() {
    if (document.getElementById('q7RADIO').checked) {
        document.getElementById('q7DIV').style.display = 'none';
    }
    else document.getElementById('q7DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq4">Q4. When was your last review on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq4">
      <input name="s2aq4" id="q8RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q8JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="s2aq4">
      <input name="s2aq4" id="s2aq4" value="No" type="radio" onclick="javascript:q8JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q8DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q8TEXT" name="q8TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q8LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q8LEFT').text('400 characters left');
    $('#q8TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q8LEFT').text('You have reached the limit');
            $('#q8LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q8LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q8LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q8JAVA() {
    if (document.getElementById('q8RADIO').checked) {
        document.getElementById('q8DIV').style.display = 'none';
    }
    else document.getElementById('q8DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq5">Q5. How did you take out the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq5">
      <input name="s2aq5" id="q9RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q9JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="s2aq5">
      <input name="s2aq5" id="s2aq5" value="No" type="radio" onclick="javascript:q9JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q9DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q9TEXT" name="q9TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q9LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q9LEFT').text('400 characters left');
    $('#q9TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q9LEFT').text('You have reached the limit');
            $('#q9LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q9LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q9LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q9JAVA() {
    if (document.getElementById('q9RADIO').checked) {
        document.getElementById('q9DIV').style.display = 'none';
    }
    else document.getElementById('q9DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq6">Q6. How much are you paying on a monthly basis?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq6">
      <input name="s2aq6" id="q10RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q10JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="s2aq6" id="s2aq6" value="No" type="radio" onclick="javascript:q10JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q10DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q10TEXT" name="q10TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q10LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q10LEFT').text('400 characters left');
    $('#q10TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q10LEFT').text('You have reached the limit');
            $('#q10LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q10LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q10LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q10JAVA() {
    if (document.getElementById('q10RADIO').checked) {
        document.getElementById('q10DIV').style.display = 'none';
    }
    else document.getElementById('q10DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq7">Q7. How much are you covered for?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq7">
      <input name="s2aq7" id="q11RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q11JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="radios-Yes">
      <input name="s2aq7" id="s2aq7" value="No" type="radio" onclick="javascript:q11JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q11DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q11TEXT" name="q11TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q11LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q11LEFT').text('400 characters left');
    $('#q11TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q11LEFT').text('You have reached the limit');
            $('#q11LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q11LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q11LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q11JAVA() {
    if (document.getElementById('q11RADIO').checked) {
        document.getElementById('q11DIV').style.display = 'none';
    }
    else document.getElementById('q11DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq8">Q8. How long do you have left on the policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input name="s2aq8" id="q12RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q12JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="s2aq8">
      <input name="s2aq8" id="s2aq8" value="No" type="radio" onclick="javascript:q12JAVA();">
      No
    </label> 
  </div>
</div>

<div id="q12DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q12TEXT" name="q12TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q12LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q12LEFT').text('400 characters left');
    $('#q12TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q12LEFT').text('You have reached the limit');
            $('#q12LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q12LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q12LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q12JAVA() {
    if (document.getElementById('q12RADIO').checked) {
        document.getElementById('q12DIV').style.display = 'none';
    }
    else document.getElementById('q12DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq9">Q9. Is your policy single, joint or separate?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq9">
      <input name="s2aq9" id="q13RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q13JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="s2aq9">
      <input name="s2aq9" id="s2aq9" value="No" type="radio" onclick="javascript:q13JAVA();">
      No
    </label> 
  </div>
</div>

<div id="q13DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q13TEXT" name="q13TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q13LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q13LEFT').text('400 characters left');
    $('#q13TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q13LEFT').text('You have reached the limit');
            $('#q13LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q13LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q13LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q13JAVA() {
    if (document.getElementById('q13RADIO').checked) {
        document.getElementById('q13DIV').style.display = 'none';
    }
    else document.getElementById('q13DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq10">Q10. Have you or your partner smoked in the last 12 months?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq10">
      <input name="s2aq10" id="q14RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q14JAVA();" >
      Yes
    </label> 
    <label class="radio-inline" for="s2aq10">
      <input name="s2aq10" id="s2aq10" value="No" type="radio" onclick="javascript:q14JAVA();" >
      No
    </label> 
  </div>
</div>

<div id="q14DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q14TEXT" name="q14TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q14LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q14LEFT').text('400 characters left');
    $('#q14TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q14LEFT').text('You have reached the limit');
            $('#q14LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q14LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q14LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q14JAVA() {
    if (document.getElementById('q14RADIO').checked) {
        document.getElementById('q14DIV').style.display = 'none';
    }
    else document.getElementById('q14DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="s2aq11">Q11. Have you or your partner got or has had any health issues?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2aq11">
      <input name="s2aq11" id="q15RADIO" value="Yes" checked="checked" type="radio" onclick="javascript:q15JAVA();">
      Yes
    </label> 
    <label class="radio-inline" for="s2aq11">
      <input name="s2aq11" id="s2aq11" value="No" type="radio" onclick="javascript:q15JAVA();">
      No
    </label> 
  </div>
</div>

<div id="q15DIV" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q15TEXT" name="q15TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="q15LEFT" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#q15LEFT').text('400 characters left');
    $('#q15TEXT').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#q15LEFT').text('You have reached the limit');
            $('#q15LEFT').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#q15LEFT').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#q15LEFT').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function q15JAVA() {
    if (document.getElementById('q15RADIO').checked) {
        document.getElementById('q15DIV').style.display = 'none';
    }
    else document.getElementById('q15DIV').style.display = 'block';

}
</script>
  </div>
</div>
</div>

</div>
<script type="text/javascript">

function yesnoqual() {
    if (document.getElementById('s2aq1yes').checked) {
        document.getElementById('qualifyyes').style.display = 'none';
    }
    else document.getElementById('qualifyyes').style.display = 'block';

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
  <label class="col-md-4 control-label" for="s2bq1">Q1. Were all questions asked correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="s2bq1">
      <input name="s2bq1" value="Yes" type="radio" id="s2bq1yescheck" onclick="javascript:yesnoCheckc1();" required>
      Yes
    </label> 
    <label class="radio-inline" for="s2bq1">
      <input name="s2bq1" value="No" type="radio" id="s2bq1nocheck" onclick="javascript:yesnoCheckc1();" >
      No
    </label> 
  </div>
</div>

<!-- Textarea -->
<div id="ifYesc1" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c1"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q1s2bc1" name="q1s2bc1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea>
    <span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#characterLeft1').text('1000 characters left');
    $('#q1s2bc1').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft1').text('You have reached the limit');
            $('#characterLeft1').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft1').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft1').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckc1() {
    if (document.getElementById('s2bq1yescheck').checked) {
        document.getElementById('ifYesc1').style.display = 'none';
    }
    else document.getElementById('ifYesc1').style.display = 'block';

}
</script>
  </div>
</div>
</div>




<div class="form-group">
  <label class="col-md-4 control-label" for="q2s2bq2">Q2. Were all questions recorded correctly?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="q2s2bq2">
      <input name="q2s2bq2" id="q2s2bq2yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc2();" required>
      Yes
    </label> 
    <label class="radio-inline" for="q2s2bq2">
      <input name="q2s2bq2" id="q2s2bq2no" value="No" type="radio" onclick="javascript:yesnoCheckc2();">
      No
    </label> 
  </div>
</div>

<!-- Textarea -->
<div id="ifYesc2" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="c2"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q2s2bc2" name="q2s2bc2" maxlength="1000" ></textarea>
    <span class="help-block"><p id="characterLeftc2" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#characterLeftc2').text('1000 characters left');
    $('#q2s2bc2').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeftc2').text('You have reached the limit');
            $('#characterLeftc2').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeftc2').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeftc2').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">
function yesnoCheckc2() {
    if (document.getElementById('q2s2bq2yes').checked) {
        document.getElementById('ifYesc2').style.display = 'none';
    }
    else document.getElementById('ifYesc2').style.display = 'block';

}
</script>
  </div>
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
  <label class="col-md-4 control-label" for="q1s4q1n">Q1. Did the agent stick to branding compliance?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="q1s4q1n">
      <input name="q1s4q1n" id="q1s4q1nyes" value="Yes" type="radio" onclick="javascript:yesnoCheckc4();" required>
      Yes
    </label> 
    <label class="radio-inline" for="q1s4q1n">
      <input name="q1s4q1n" id="q1s4q1nno" value="No" type="radio" onclick="javascript:yesnoCheckc4();">
      No
    </label> 
  </div>
</div>
        
<!-- Textarea -->
<div id="ifYesc4" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q1s4c1n" name="q1s4c1n" maxlength="1000" ></textarea>
    <span class="help-block"><p id="characterLeftc4" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#characterLeftc4').text('1000 characters left');
    $('#q1s4c1n').keydown(function () {
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
    if (document.getElementById('q1s4q1nyes').checked) {
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
    <label class="radio-inline" for="q1s3q1">
      <input name="q1s3q1" id="q1s3q1yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc3();" required>
      Yes
    </label> 
    <label class="radio-inline" for="q1s3q1">
      <input name="q1s3q1" id="q1s3q1no" value="No" type="radio" onclick="javascript:yesnoCheckc3();">
      No
    </label> 
  </div>
</div>

<!-- Textarea -->
<div id="ifYesc3" style="display:none">
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="q1s3c1" name="q1s3c1" maxlength="1000"></textarea>
    <span class="help-block"><p id="characterLeftc3" class="help-block ">You have reached the limit</p></span>
    <script>
$(document).ready(function(){ 
    $('#characterLeftc3').text('1000 characters left');
    $('#q1s3c1').keydown(function () {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeftc3').text('You have reached the limit');
            $('#characterLeftc3').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeftc3').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeftc3').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">
function yesnoCheckc3() {
    if (document.getElementById('q1s3q1yes').checked) {
        document.getElementById('ifYesc3').style.display = 'none';
    }
    else document.getElementById('ifYesc3').style.display = 'block';

}
</script>
  </div>
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
    </body>
</html>
