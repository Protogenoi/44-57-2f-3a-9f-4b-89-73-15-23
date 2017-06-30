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
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
<script src="../js/jquery-1.4.min.js"></script>
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
   
</head>
<body>
    
    <?php 
require_once(__DIR__ . '/../includes/navbar.php');
    ?>

<div class="container">

<form class="form-horizontal" action="php/lead_gen_submit.php" method="POST" autocomplete="off">
<fieldset>

<legend>Lead Gen Call Audit</legend>

<input type="hidden" name="auditor" value="<?php echo $hello_name ?>" readonly>

<div class="panel panel-primary">

    <div class="panel-heading">
<h3 class="panel-title">Agent performance</span></h3>
</div>

<div class="panel-body">

    <div class="form-group">
  <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
  <div class="col-md-4">
  <input id="provider-json" name='full_name' class='form-control' required placeholder="Lead Gen" class="form-control input-md" type="text">
  </div>
</div>
    
        <div class="form-group">
  <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
  <div class="col-md-4">
  <input id="provider-json" name='full_name2' class='form-control' placeholder="Lead Gen" class="form-control input-md" type="text">
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="grade">Grade:</label>
  <div class="col-md-4">
    <select id="grade" name="grade" class="form-control" required>
      <option value="">Select...</option>
      <option value="Green">Green</option>
      <option value="Amber">Amber</option>
      <option value="Red">Red</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c1">Overall comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c1" name="c1" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc1"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc1').html(text_max + ' characters remaining');

    $('#c1').keyup(function() {
        var text_length = $('#c1').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc1').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


</div>
</div>

<div class="panel panel-info">

    <div class="panel-heading">
<h3 class="panel-title">Audit Questions</h3>
</div>
<div class="panel-body">

<div class="form-group">
  <label class="col-md-4 control-label" for="call_opening">Call opening?</label>
  <div class="col-md-4">
    <select id="call_opening" name="call_opening" class="form-control">
      <option value="NA">Select...</option>
      <option value="Excellent">Excellent</option>
      <option value="Good">Good</option>
      <option value="Acceptable">Acceptable</option>
      <option value="Unacceptable">Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c2">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c2" name="c2" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc2"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc2').html(text_max + ' characters remaining');

    $('#c2').keyup(function() {
        var text_length = $('#c2').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc2').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="full_info">Did the agent provide full information?</label>
  <div class="col-md-4">
    <select id="full_info" name="full_info" class="form-control">
      <option value="NA">Select...</option>
      <option value="Excellent">Excellent</option>
      <option value="Good">Good</option>
      <option value="Acceptable">Acceptable</option>
      <option value="Unacceptable">Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c3">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c3" name="c3" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc3"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc3').html(text_max + ' characters remaining');

    $('#c3').keyup(function() {
        var text_length = $('#c3').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc3').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="obj_handled">Objections handled</label>
  <div class="col-md-4">
    <select id="obj_handled" name="obj_handled" class="form-control">
      <option value="NA">Select...</option>
      <option value="Excellent">Excellent</option>
      <option value="Good">Good</option>
      <option value="Acceptable">Acceptable</option>
      <option value="Unacceptable">Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c4">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c4" name="c4"  rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc4"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc4').html(text_max + ' characters remaining');

    $('#c4').keyup(function() {
        var text_length = $('#c4').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc4').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="rapport">Rapport</label>
  <div class="col-md-4">
    <select id="rapport" name="rapport" class="form-control">
      <option value="NA">Select...</option>
      <option value="Excellent">Excellent</option>
      <option value="Good">Good</option>
      <option value="Acceptable">Acceptable</option>
      <option value="Unacceptable">Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c5">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c5" name="c5" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc5"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc5').html(text_max + ' characters remaining');

    $('#c5').keyup(function() {
        var text_length = $('#c5').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc5').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="dealsheet_questions">Did the agent ask all the questions on the dealsheet</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="dealsheet_questions-0">
      <input name="dealsheet_questions" id="dealsheet_questions-0" value="Yes"  type="radio">
      Yes
    </label> 
    <label class="radio-inline" for="dealsheet_questions-1">
      <input name="dealsheet_questions" id="dealsheet_questions-1" value="No" type="radio">
      No
    </label>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c6">Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c6" name="c6" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc6"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc6').html(text_max + ' characters remaining');

    $('#c6').keyup(function() {
        var text_length = $('#c6').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc6').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="brad_compl">Did the agent stick to branding compliance?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="brad_compl-0">
      <input name="brad_compl" id="brad_compl-0" value="Yes"  type="radio">
      Yes
    </label> 
    <label class="radio-inline" for="brad_compl-1">
      <input name="brad_compl" id="brad_compl-1" value="No" type="radio">
      No
    </label>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c7">Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c7" name="c7" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"></textarea>
    <div id="textarea_feedbackc7"></div>
<script>
$(document).ready(function() {
    var text_max = 2500;
    $('#textarea_feedbackc7').html(text_max + ' characters remaining');

    $('#c7').keyup(function() {
        var text_length = $('#c7').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedbackc7').html(text_remaining + ' characters remaining');
    });
});
</script>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="agree">Confirm audit submission</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="agree-0">
      <input name="agree" id="agree-0" value="Yes" type="radio" required>
      Yes
    </label>
  </div>
</div>

<center>

<button type="submit" value="submit"  class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Submit Audit</button>
</center>

</div>
</div>



</fieldset>
</form>

</body>
</html>
