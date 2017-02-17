<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php'); 

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }

include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Royal London Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../styles/layout.css" type="text/css" />
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />

<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>

<?php include('../../php/Holidays.php'); ?>
</head>
<body>

<?php include('../../includes/navbar.php'); 
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>


<div class="container">
 <form action="#" method="POST" autocomplete="off">
<fieldset>   
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Royal London Audit</h3>
        </div>
        <div class="panel-body">
<p>


    
<div class='form-group'>
<label for='closer'>Closer:</label>
<select class='form-control' name='full_name' id='full_name' required> 
    <option value="">Select...</option>
<option value="Carys">Carys</option>
<option value="Hayley">Hayley</option>
<option value="James">James</option>
<option value="Kyle">Kyle</option>  
<option value="Mike">Mike</option> 
<option value="Richard">Richard</option> 
<option value="Sarah">Sarah</option>
<option value="Stavros">Stavros</option>
<option value="Nicola">Nicola</option>  
<option value="Gavin">Gavin</option>
</select>
</div>

<div class='form-group'>
<label for='closer2'>Closer (optional):</label>
<select class='form-control' name='full_name2' id='full_name2' >    
<option value="None">None</option>    
<option value="Carys">Carys</option>
<option value="Hayley">Hayley</option>
<option value="James">James</option>
<option value="Kyle">Kyle</option>  
<option value="Mike">Mike</option> 
<option value="Richard">Richard</option>
<option value="Sarah">Sarah</option> 
<option value="Stavros">Stavros</option>
<option value="Nicola">Nicola</option> 
<option value="Gavin">Gavin</option> 
</select>
</div>

<label for="plan_number">Plan Number</label>
<input type="text" class="form-control" name="plan_number" style="width: 520px">
</p>

<p>
<div class="form-group">
<label for='grade'>Grade:</label>
<select class="form-control" name="formgrade" required>
  <option value="">Select...</option>
  <option value="SAVED">Incomplete Audit (SAVE)</option>
  <option value="Green">Green</option>
  <option value="Amber">Amber</option>
  <option value="Red">Red</option>
</select>
</div>
</p>
</div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
<h3 class="panel-title">Opening Declaration</h3>
</div>
<div class="panel-body">
<p>
<label for="OD1">Q<?php $i=0; $i++; echo $i; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
<input type="radio" name="OD1" 
<?php if (isset($OD1) && $OD1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckODT1();"
value="Yes" id="yesCheckODT1">Yes
<input type="radio" name="OD1"
<?php if (isset($OD1) && $OD1=="No") echo "checked";?> onclick="javascript:yesnoCheckODT1();"
value="No" id="noCheckODT1">No
</p>

<div id="ifYesODT1" style="display:none">
<textarea class="form-control"id="ODT1" name="ODT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft1').text('500 characters left');
    $('#ODT1').keydown(function () {
        var max = 500;
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

function yesnoCheckODT1() {
    if (document.getElementById('yesCheckODT1').checked) {
        document.getElementById('ifYesODT1').style.display = 'none';
    }
    else document.getElementById('ifYesODT1').style.display = 'block';

}
</script>

<p>
<label for="OD2">Q<?php $i++; echo $i; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
<input type="radio" name="OD2" 
<?php if (isset($OD2) && $OD2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckODT2();"
value="Yes" id="yesCheckODT2">Yes
<input type="radio" name="OD2"
<?php if (isset($OD2) && $OD2=="No") echo "checked";?> onclick="javascript:yesnoCheckODT2();"
value="No" id="noCheckODT2">No
</p>

<div id="ifYesODT2" style="display:none">
<textarea class="form-control"id="ODT2" name="ODT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft2').text('500 characters left');
    $('#ODT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft2').text('You have reached the limit');
            $('#characterLeft2').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft2').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft2').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT2() {
    if (document.getElementById('yesCheckODT2').checked) {
        document.getElementById('ifYesODT2').style.display = 'none';
    }
    else document.getElementById('ifYesODT2').style.display = 'block';

}

</script>

<p>
<label for="OD3">Q<?php $i++; echo $i; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
<input type="radio" name="OD3" 
<?php if (isset($OD3) && $OD3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckODT3();"
value="Yes" id="yesCheckODT3">Yes
<input type="radio" name="OD3"
<?php if (isset($OD3) && $OD3=="No") echo "checked";?> onclick="javascript:yesnoCheckODT3();"
value="No" id="noCheckODT3">No
</p>

<div id="ifYesODT3" style="display:none">
<textarea class="form-control"id="ODT3" name="ODT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft3').text('500 characters left');
    $('#ODT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft3').text('You have reached the limit');
            $('#characterLeft3').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft3').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft3').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT3() {
    if (document.getElementById('yesCheckODT3').checked) {
        document.getElementById('ifYesODT3').style.display = 'none';
    }
    else document.getElementById('ifYesODT3').style.display = 'block';

}

</script>

<p>
<label for="OD4">Q<?php $i++; echo $i; ?>. Did the closer provide the name and details of the firm who is regulated by the FCA?</label>
<input type="radio" name="OD4" 
<?php if (isset($OD4) && $OD4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckODT4();"
value="Yes" id="yesCheckODT4">Yes
<input type="radio" name="OD4"
<?php if (isset($OD4) && $OD4=="No") echo "checked";?> onclick="javascript:yesnoCheckODT4();"
value="No" id="noCheckODT4">No
</p>

<div id="ifYesODT4" style="display:none">
<textarea class="form-control"id="ODT4" name="ODT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft4').text('500 characters left');
    $('#ODT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft4').text('You have reached the limit');
            $('#characterLeft4').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft4').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft4').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT4() {
    if (document.getElementById('yesCheckODT4').checked) {
        document.getElementById('ifYesODT4').style.display = 'none';
    }
    else document.getElementById('ifYesODT4').style.display = 'block';

}

</script>

<p>
<label for="OD5">Q<?php $i++; echo $i; ?>. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
<input type="radio" name="OD5" 
<?php if (isset($OD5) && $OD5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckODT5();"
value="Yes" id="yesCheckODT5">Yes
<input type="radio" name="OD5"
<?php if (isset($OD5) && $OD5=="No") echo "checked";?> onclick="javascript:yesnoCheckODT5();"
value="No" id="noCheckODT5">No
</p>

<div id="ifYesODT5" style="display:none">
<textarea class="form-control"id="ODT5" name="ODT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft5').text('500 characters left');
    $('#ODT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft5').text('You have reached the limit');
            $('#characterLeft5').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft5').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft5').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT5() {
    if (document.getElementById('yesCheckODT5').checked) {
        document.getElementById('ifYesODT5').style.display = 'none';
    }
    else document.getElementById('ifYesODT5').style.display = 'block';

}

</script>
</div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
    </div>
    <div class="panel-body">

<p>
<label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients gender accurately recorded?</label>
<input type="radio" name="CI1" 
<?php if (isset($CI1) && $CI1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT1();"
value="Yes" id="yesCheckCIT1">Yes
<input type="radio" name="CI1"
<?php if (isset($CI1) && $CI1=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT1();"
value="No" id="noCheckCIT1">No
</p>

<div id="ifYesCIT1" style="display:none">
<textarea class="form-control"id="CIT1" name="CIT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft7').text('500 characters left');
    $('#CIT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft7').text('You have reached the limit');
            $('#characterLeft7').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft7').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft7').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT1() {
    if (document.getElementById('yesCheckCIT1').checked) {
        document.getElementById('ifYesCIT1').style.display = 'none';
    }
    else document.getElementById('ifYesCIT1').style.display = 'block';

}

</script>

<p>
<label for="CI2">Q<?php $i++; echo $i; ?>. Was the clients date of birth accurately recorded?</label>
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();"
<?php if (isset($CI2) && $CI2=="Yes") echo "checked";?>
value="Yes" id="yesCheck">Yes
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();"
<?php if (isset($CI2) && $CI2=="No") echo "checked";?>
value="No" id="noCheck">No
</p>
<div id="ifYes" style="display:none">
<textarea class="form-control"id="CIT2" name="CIT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft8').text('500 characters left');
    $('#CIT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft8').text('You have reached the limit');
            $('#characterLeft8').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft8').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft8').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';

}

</script>

<p>
<label for="CI3">Q<?php $i++; echo $i; ?>. Was the clients smoking status recorded correctly?</label>
<input type="radio" name="CI3" 
<?php if (isset($CI3) && $CI3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT3();"
value="Yes" id="yesCheckCIT3">Yes
<input type="radio" name="CI3"
<?php if (isset($CI3) && $CI3=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT3();"
value="No" id="noCheckCIT3">No
</p>

<div id="ifYesCIT3" style="display:none">
<textarea class="form-control"id="CIT3" name="CIT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft9').text('500 characters left');
    $('#CIT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft9').text('You have reached the limit');
            $('#characterLeft9').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft9').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft9').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT3() {
    if (document.getElementById('yesCheckCIT3').checked) {
        document.getElementById('ifYesCIT3').style.display = 'none';
    }
    else document.getElementById('ifYesCIT3').style.display = 'block';

}

</script>

<p>
<label for="CI4">Q<?php $i++; echo $i; ?>. Was the clients employment status recorded correctly?</label>
<input type="radio" name="CI4" 
<?php if (isset($CI4) && $CI4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT4();"
value="Yes" id="yesCheckCIT4">Yes
<input type="radio" name="CI4"
<?php if (isset($CI4) && $CI4=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT4();"
value="No" id="noCheckCIT4">No
</p>

<div id="ifYesCIT4" style="display:none">
<textarea class="form-control"id="CIT4" name="CIT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft10" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft10').text('500 characters left');
    $('#CIT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft10').text('You have reached the limit');
            $('#characterLeft10').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft10').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft10').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT4() {
    if (document.getElementById('yesCheckCIT4').checked) {
        document.getElementById('ifYesCIT4').style.display = 'none';
    }
    else document.getElementById('ifYesCIT4').style.display = 'block';

}

</script>

<p>
<label for="CI5">Q<?php $i++; echo $i; ?>. Did the closer confirm the policy was a single or a joint application?</label>
<input type="radio" name="CI5" 
<?php if (isset($CI5) && $CI5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT5();"
value="Yes" id="yesCheckCIT5">Yes
<input type="radio" name="CI5"
<?php if (isset($CI5) && $CI5=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT5();"
value="No" id="noCheckCIT5">No
</p>

<div id="ifYesCIT5" style="display:none">
<textarea class="form-control"id="CIT5" name="CIT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft11').text('500 characters left');
    $('#CIT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft11').text('You have reached the limit');
            $('#characterLeft11').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft11').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft11').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT5() {
    if (document.getElementById('yesCheckCIT5').checked) {
        document.getElementById('ifYesCIT5').style.display = 'none';
    }
    else document.getElementById('ifYesCIT5').style.display = 'block';

}

</script>

<p>
<label for="CI6">Q<?php $i++; echo $i; ?>. Was the clients country of residence recorded correctly?</label>
<input type="radio" name="CI6" 
<?php if (isset($CI6) && $CI6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT6();"
value="Yes" id="yesCheckCIT6">Yes
<input type="radio" name="CI6"
<?php if (isset($CI6) && $CI6=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT6();"
value="No" id="noCheckCIT6">No
</p>

<div id="ifYesCIT6" style="display:none">
<textarea class="form-control"id="CIT6" name="CIT6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft112" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft112').text('500 characters left');
    $('#CIT6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft112').text('You have reached the limit');
            $('#characterLeft112').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft112').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft112').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT6() {
    if (document.getElementById('yesCheckCIT6').checked) {
        document.getElementById('ifYesCIT6').style.display = 'none';
    }
    else document.getElementById('ifYesCIT6').style.display = 'block';

}

</script>

<p>
<label for="CI7">Q<?php $i++; echo $i; ?>. Was the clients occupation recorded correctly?</label>
<input type="radio" name="CI7" 
<?php if (isset($CI7) && $CI7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT7();"
value="Yes" id="yesCheckCIT7">Yes
<input type="radio" name="CI7"
<?php if (isset($CI7) && $CI7=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT7();"
value="No" id="noCheckCIT7">No
</p>

<div id="ifYesCIT7" style="display:none">
<textarea class="form-control"id="CIT7" name="CIT7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft113" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft113').text('500 characters left');
    $('#CIT7').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft113').text('You have reached the limit');
            $('#characterLeft113').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft113').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft113').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT7() {
    if (document.getElementById('yesCheckCIT7').checked) {
        document.getElementById('ifYesCIT7').style.display = 'none';
    }
    else document.getElementById('ifYesCIT7').style.display = 'block';

}

</script>

<p>
<label for="CI8">Q<?php $i++; echo $i; ?>. Was the clients salary recorded correctly?</label>
<input type="radio" name="CI8" 
<?php if (isset($CI8) && $CI8=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCIT8();"
value="Yes" id="yesCheckCIT8">Yes
<input type="radio" name="CI8"
<?php if (isset($CI8) && $CI8=="No") echo "checked";?> onclick="javascript:yesnoCheckCIT8();"
value="No" id="noCheckCIT8">No
</p>

<div id="ifYesCIT8" style="display:none">
<textarea class="form-control"id="CIT8" name="CIT8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft114" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft114').text('500 characters left');
    $('#CIT8').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft114').text('You have reached the limit');
            $('#characterLeft114').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft114').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft114').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT8() {
    if (document.getElementById('yesCheckCIT8').checked) {
        document.getElementById('ifYesCIT8').style.display = 'none';
    }
    else document.getElementById('ifYesCIT8').style.display = 'block';

}

</script>

</div>
</div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Identifying Clients Needs</h3>
    </div>
    <div class="panel-body">
<p>
<label for="IC1">Q<?php $i++; echo $i; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label>
<input type="radio" name="IC1" 
<?php if (isset($IC1) && $IC1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckICT1();"
value="Yes" id="yesCheckICT1">Yes
<input type="radio" name="IC1"
<?php if (isset($IC1vvv) && $IC1=="No") echo "checked";?> onclick="javascript:yesnoCheckICT1();"
value="No" id="noCheckICT1">No
</p>

<div id="ifYesICT1" style="display:none">
<textarea class="form-control"id="ICT1" name="ICT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft12').text('500 characters left');
    $('#ICT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft12').text('You have reached the limit');
            $('#characterLeft12').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft12').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft12').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT1() {
    if (document.getElementById('yesCheckICT1').checked) {
        document.getElementById('ifYesICT1').style.display = 'none';
    }
    else document.getElementById('ifYesICT1').style.display = 'block';

}

</script>

<p>
<label for="IC2">Q<?php $i++; echo $i; ?>. Did the closer mention waiver, indexation, or TPD?</label>
<input type="radio" name="IC2" 
<?php if (isset($IC2) && $IC2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckICT2();"
value="Yes" id="yesCheckICT2">Yes
<input type="radio" name="IC2"
<?php if (isset($IC2) && $IC2=="No") echo "checked";?> onclick="javascript:yesnoCheckICT2();"
value="No" id="noCheckICT2">No
<input type="radio" name="IC2" 
<?php if (isset($IC2) && $IC2=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesICT2" style="display:none">
<textarea class="form-control"id="ICT2" name="ICT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft13').text('500 characters left');
    $('#ICT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft13').text('You have reached the limit');
            $('#characterLeft13').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft13').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft13').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT2() {
    if (document.getElementById('yesCheckICT2').checked) {
        document.getElementById('ifYesICT2').style.display = 'none';
    }
    else document.getElementById('ifYesICT2').style.display = 'block';

}

</script>

<p>
<label for="IC3">Q<?php $i++; echo $i; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
<input type="radio" name="IC3" 
<?php if (isset($IC3) && $IC3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckICT3();"
value="Yes" id="yesCheckICT3">Yes
<input type="radio" name="IC3"
<?php if (isset($IC3) && $IC3=="No") echo "checked";?> onclick="javascript:yesnoCheckICT3();"
value="No" id="noCheckICT3">No
</p>

<div id="ifYesICT3" style="display:none">
<textarea class="form-control"id="ICT3" name="ICT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft14').text('500 characters left');
    $('#ICT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft14').text('You have reached the limit');
            $('#characterLeft14').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft14').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft14').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT3() {
    if (document.getElementById('yesCheckICT3').checked) {
        document.getElementById('ifYesICT3').style.display = 'none';
    }
    else document.getElementById('ifYesICT3').style.display = 'block';

}

</script>

<p>
<label for="IC4">Q<?php $i++; echo $i; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label>
<select class="form-control" name="IC4" onclick="javascript:yesnoCheckICT4();">
  <option value="NA">Select...</option>
  <option value="More than sufficient">More than sufficient</option>
  <option value="Sufficient">Sufficient</option>
  <option value="Adaquate">Adequate</option>
  <option value="Poor" onclick="javascript:yesnoCheckICT4a();" id="yesCheckICT4">Poor</option>
</select>
</p>
<div id="ifYesICT4" style="display:none">
<textarea class="form-control"id="ICT4" name="ICT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft15').text('500 characters left');
    $('#ICT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft15').text('You have reached the limit');
            $('#characterLeft15').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft15').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft15').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT4() {
    if (document.getElementById('yesCheckICT4').checked) {
        document.getElementById('ifYesICT4').style.display = 'none';
    }
    else document.getElementById('ifYesICT4').style.display = 'block';

}

</script>
<script type="text/javascript">

function yesnoCheckICT4a() {
    if (document.getElementById('yesCheckICT4').checked) {
        document.getElementById('ifYesICT4').style.display = 'none';
    }
    else document.getElementById('ifYesICT4').style.display = 'block';

}

</script>

<p>
<label for="IC5">Q<?php $i++; echo $i; ?>. Closer confirmed this policy will be set up with Royal London?</label>
<input type="radio" name="IC5" 
<?php if (isset($IC5) && $IC5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckICT5();"
value="Yes" id="yesCheckICT5">Yes
<input type="radio" name="IC5"
<?php if (isset($IC5) && $IC5=="No") echo "checked";?> onclick="javascript:yesnoCheckICT5();"
value="No" id="noCheckICT5">No
</p>

<div id="ifYesICT5" style="display:none">
<textarea class="form-control"id="ICT5" name="ICT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft16').text('500 characters left');
    $('#ICT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft16').text('You have reached the limit');
            $('#characterLeft16').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft16').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft16').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">
function yesnoCheckICT5() {
    if (document.getElementById('yesCheckICT5').checked) {
        document.getElementById('ifYesICT5').style.display = 'none';
    }
    else document.getElementById('ifYesICT5').style.display = 'block';

}
</script>
</div>
</div>    
    
 <div class="panel panel-info">
     <div class="panel-heading">
         <h3 class="panel-title">Contact Details</h3>
     </div>
     <div class="panel-body">

<p>
<label for="CD1">Q<?php $i++; echo $i; ?>. Were all clients titles and names recorded correctly?</label>
<input type="radio" name="CD1" 
<?php if (isset($CD1) && $CD1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDT1();"
value="Yes" id="yesCheckCDT1">Yes
<input type="radio" name="CD1"
<?php if (isset($CD1) && $CD1=="No") echo "checked";?> onclick="javascript:yesnoCheckCDT1();"
value="No" id="noCheckCDT1">No
</p>

<div id="ifYesCDT1" style="display:none">
<textarea class="form-control"id="CDT1" name="CDT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#CDT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT1() {
    if (document.getElementById('yesCheckCDT1').checked) {
        document.getElementById('ifYesCDT1').style.display = 'none';
    }
    else document.getElementById('ifYesCDT1').style.display = 'block';

}

</script>

<p>
<label for="CD2">Q<?php $i++; echo $i; ?>. Was the clients marital status recorded correctly?</label>
<input type="radio" name="CD2" 
<?php if (isset($CD2) && $CD2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDT2();"
value="Yes" id="yesCheckCDT2">Yes
<input type="radio" name="CD2"
<?php if (isset($CD2) && $CD2=="No") echo "checked";?> onclick="javascript:yesnoCheckCDT2();"
value="No" id="noCheckCDT2">No
</p>

<div id="ifYesCDT2" style="display:none">
<textarea class="form-control"id="CDT2" name="CDT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#CDT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT2() {
    if (document.getElementById('yesCheckCDT2').checked) {
        document.getElementById('ifYesCDT2').style.display = 'none';
    }
    else document.getElementById('ifYesCDT2').style.display = 'block';

}
</script>  

<p>
<label for="CD3">Q<?php $i++; echo $i; ?>. Was the clients address recored correctly?</label>
<input type="radio" name="CD3" 
<?php if (isset($CD3) && $CD3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDT3();"
value="Yes" id="yesCheckCDT3">Yes
<input type="radio" name="CD3"
<?php if (isset($CD3) && $CD3=="No") echo "checked";?> onclick="javascript:yesnoCheckCDT3();"
value="No" id="noCheckCDT3">No
</p>

<div id="ifYesCDT3" style="display:none">
<textarea class="form-control"id="CDT3" name="CDT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#CDT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT3() {
    if (document.getElementById('yesCheckCDT3').checked) {
        document.getElementById('ifYesCDT3').style.display = 'none';
    }
    else document.getElementById('ifYesCDT3').style.display = 'block';

}
</script>  

<p>
<label for="CD4">Q<?php $i++; echo $i; ?>. Was clients phone number(s) recorded correctly?</label>
<input type="radio" name="CD4" 
<?php if (isset($CD4) && $CD4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDT4();"
value="Yes" id="yesCheckCDT4">Yes
<input type="radio" name="CD4"
<?php if (isset($CD4) && $CD4=="No") echo "checked";?> onclick="javascript:yesnoCheckCDT4();"
value="No" id="noCheckCDT4">No
</p>

<div id="ifYesCDT4" style="display:none">
<textarea class="form-control"id="CDT4" name="CDT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#CDT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT4() {
    if (document.getElementById('yesCheckCDT4').checked) {
        document.getElementById('ifYesCDT4').style.display = 'none';
    }
    else document.getElementById('ifYesCDT4').style.display = 'block';

}
</script>

<p>
<label for="CD5">Q<?php $i++; echo $i; ?>. Was the clients email address recorded correctly?</label>
<input type="radio" name="CD5" 
<?php if (isset($CD5) && $CD5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDT5();"
value="Yes" id="yesCheckCDT5">Yes
<input type="radio" name="CD5"
<?php if (isset($CD5) && $CD5=="No") echo "checked";?> onclick="javascript:yesnoCheckCDT5();"
value="No" id="noCheckCDT5">No
</p>

<div id="ifYesCDT5" style="display:none">
<textarea class="form-control"id="CDT5" name="CDT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#CDT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT5() {
    if (document.getElementById('yesCheckCDT5').checked) {
        document.getElementById('ifYesCDT5').style.display = 'none';
    }
    else document.getElementById('ifYesCDT5').style.display = 'block';

}
</script>
         
     </div>
 </div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Declarations of Insurance</h3>
    </div>
    <div class="panel-body">

<p>
<label for="DO1">Q<?php $i++; echo $i; ?>. Confirmed that we comply with the Data Protection Act, and are happy for their personal to be passed over the phone?</label>
<input type="radio" name="DO1" 
<?php if (isset($DO1) && $DO1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT1();"
value="Yes" id="yesCheckDOT1">Yes
<input type="radio" name="DO1"
<?php if (isset($DO1) && $DO1=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT1();"
value="No" id="noCheckDOT1">No
</p>
<div id="ifYesDOT1" style="display:none">
<textarea class="form-control"id="DOT1" name="DOT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#DOT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft34').text('You have reached the limit');
            $('#characterLeft34').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft34').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft34').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT1() {
    if (document.getElementById('yesCheckDOT1').checked) {
        document.getElementById('ifYesDOT1').style.display = 'none';
    }
    else document.getElementById('ifYesDOT1').style.display = 'block';

}

</script>        
           
<p>
<label for="DO2">Q<?php $i++; echo $i; ?>. The impact of misrepresentation declaration read out?</label>
<input type="radio" name="DO2" 
<?php if (isset($DO2) && $DO2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT2();"
value="Yes" id="yesCheckDOT2">Yes
<input type="radio" name="DO2"
<?php if (isset($DO2) && $DO2=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT2();"
value="No" id="noCheckDOT2">No
</p>

<div id="ifYesDOT2" style="display:none">
<textarea class="form-control"id="DOT2" name="DOT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#DOT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft34').text('You have reached the limit');
            $('#characterLeft34').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft34').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft34').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT2() {
    if (document.getElementById('yesCheckDOT2').checked) {
        document.getElementById('ifYesDOT2').style.display = 'none';
    }
    else document.getElementById('ifYesDOT2').style.display = 'block';

}

</script>

<p>
<label for="DO3">Q<?php $i++; echo $i; ?>. If appropriate did the closer confirm the exclusions on the policy?</label>
<input type="radio" name="DO3" 
<?php if (isset($DO3) && $DO3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT3();"
value="Yes" id="yesCheckDOT3">Yes
<input type="radio" name="DO3"
<?php if (isset($DO3) && $DO3=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT3();"
value="No" id="noCheckDOT3">No
<input type="radio" name="DO3" 
<?php if (isset($DO3) && $DO3=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesDOT3" style="display:none">
<textarea class="form-control"id="DOT3" name="DOT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT3() {
    if (document.getElementById('yesCheckDOT3').checked) {
        document.getElementById('ifYesDOT3').style.display = 'none';
    }
    else document.getElementById('ifYesDOT3').style.display = 'block';

}

</script>

<p>
<label for="DO4">Q<?php $i++; echo $i; ?>. Client informed that Royal London may request a copy of their medical reports up to six months after the cover has started?</label>
<input type="radio" name="DO4" 
<?php if (isset($DO4) && $DO4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT4();"
value="Yes" id="yesCheckDOT4">Yes
<input type="radio" name="DO4"
<?php if (isset($DO4) && $DO4=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT4();"
value="No" id="noCheckDOT4">No
<input type="radio" name="DO4" 
<?php if (isset($DO4) && $DO4=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesDOT4" style="display:none">
<textarea class="form-control"id="DOT4" name="DOT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT4() {
    if (document.getElementById('yesCheckDOT4').checked) {
        document.getElementById('ifYesDOT4').style.display = 'none';
    }
    else document.getElementById('ifYesDOT4').style.display = 'block';

}
</script>

<p>
<label for="DO5">Q<?php $i++; echo $i; ?>. Did the closer ask the client to read out the Access to Medical Reports Act 1988 (or to send a copy)?</label>
<input type="radio" name="DO5" <?php if (isset($DO5) && $DO5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT5();" value="Yes" id="yesCheckDOT5">Yes
<input type="radio" name="DO5" <?php if (isset($DO5) && $DO5=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT5();" value="No" id="noCheckDOT5">No
</p>

<div id="ifYesDOT5" style="display:none">
<textarea class="form-control"id="DOT5" name="DOT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT5() {
    if (document.getElementById('yesCheckDOT5').checked) {
        document.getElementById('ifYesDOT5').style.display = 'none';
    }
    else document.getElementById('ifYesDOT5').style.display = 'block';

}
</script>

<p>
<label for="DO6">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had any existing plans or an application with Royal London?</label>
<input type="radio" name="DO6" <?php if (isset($DO6) && $DO6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT6();" value="Yes" id="yesCheckDOT6">Yes
<input type="radio" name="DO6" <?php if (isset($DO6) && $DO6=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT6();" value="No" id="noCheckDOT6">No
</p>

<div id="ifYesDOT6" style="display:none">
<textarea class="form-control"id="DOT6" name="DOT6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT6() {
    if (document.getElementById('yesCheckDOT6').checked) {
        document.getElementById('ifYesDOT6').style.display = 'none';
    }
    else document.getElementById('ifYesDOT6').style.display = 'block';

}
</script>

<p>
<label for="DO7">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had an application on your life deferred or declined?</label>
<input type="radio" name="DO7" <?php if (isset($DO7) && $DO7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT7();" value="Yes" id="yesCheckDOT7">Yes
<input type="radio" name="DO7" <?php if (isset($DO7) && $DO7=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT7();" value="No" id="noCheckDOT7">No
</p>

<div id="ifYesDOT7" style="display:none">
<textarea class="form-control"id="DOT7" name="DOT7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT7').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT7() {
    if (document.getElementById('yesCheckDOT7').checked) {
        document.getElementById('ifYesDOT7').style.display = 'none';
    }
    else document.getElementById('ifYesDOT7').style.display = 'block';

}
</script>

<p>
<label for="DO8">Q<?php $i++; echo $i; ?>. Did the closer ask the client if the total amount of cover that they have applied for, added to the amount that they already have, across all insurance companies exceed £1,000,000 life cover or £500,000 CIC?</label>
<input type="radio" name="DO8" <?php if (isset($DO8) && $DO8=="Yes") echo "checked";?> onclick="javascript:yesnoCheckDOT8();" value="Yes" id="yesCheckDOT8">Yes
<input type="radio" name="DO8" <?php if (isset($DO8) && $DO8=="No") echo "checked";?> onclick="javascript:yesnoCheckDOT8();" value="No" id="noCheckDOT8">No
</p>

<div id="ifYesDOT8" style="display:none">
<textarea class="form-control"id="DOT8" name="DOT8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#DOT8').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT8() {
    if (document.getElementById('yesCheckDOT8').checked) {
        document.getElementById('ifYesDOT8').style.display = 'none';
    }
    else document.getElementById('ifYesDOT8').style.display = 'block';

}
</script>

</div>
</div>    
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Life Style</h3>
    </div>
    <div class="panel-body">
        
<p>
<label for="LS1">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the height and weight details correctly?</label>
<input type="radio" name="LS1" 
<?php if (isset($LS1) && $LS1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST1();"
value="Yes" id="yesCheckLST1">Yes
<input type="radio" name="LS1"
<?php if (isset($LS1) && $LS1=="No") echo "checked";?> onclick="javascript:yesnoCheckLST1();"
value="No" id="noCheckLST1">No
</p>

<div id="ifYesLST1" style="display:none">
<textarea class="form-control"id="LST1" name="LST1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft23" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft23').text('500 characters left');
    $('#LST1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft23').text('You have reached the limit');
            $('#characterLeft23').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft23').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft23').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST1() {
    if (document.getElementById('yesCheckLST1').checked) {
        document.getElementById('ifYesLST1').style.display = 'none';
    }
    else document.getElementById('ifYesLST1').style.display = 'block';

}

</script>

<p>
<label for="LS2">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the clients clothe measurements?</label>
<input type="radio" name="LS2" 
<?php if (isset($LS2) && $LS2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST2();"
value="Yes" id="yesCheckLST2">Yes
<input type="radio" name="LS2"
<?php if (isset($LS2) && $LS2=="No") echo "checked";?> onclick="javascript:yesnoCheckLST2();"
value="No" id="noCheckLST2">No
</p>

<div id="ifYesLST2" style="display:none">
<textarea class="form-control"id="LST2" name="LST2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft23" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft23').text('500 characters left');
    $('#LST2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft23').text('You have reached the limit');
            $('#characterLeft23').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft23').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft23').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST2() {
    if (document.getElementById('yesCheckLST2').checked) {
        document.getElementById('ifYesLST2').style.display = 'none';
    }
    else document.getElementById('ifYesLST2').style.display = 'block';

}

</script>

<p>
<label for="LS3">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the smoking details correctly?</label>
<input type="radio" name="LS3" 
<?php if (isset($LS3) && $LS3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST3();"
value="Yes" id="yesCheckLST3">Yes
<input type="radio" name="LS3"
<?php if (isset($LS3) && $LS3=="No") echo "checked";?> onclick="javascript:yesnoCheckLST3();"
value="No" id="noCheckLST3">No
</p>

<div id="ifYesLST3" style="display:none">
<textarea class="form-control"id="LST3" name="LST3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft24" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft24').text('500 characters left');
    $('#LST3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft24').text('You have reached the limit');
            $('#characterLeft24').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft24').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft24').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST3() {
    if (document.getElementById('yesCheckLST3').checked) {
        document.getElementById('ifYesLST3').style.display = 'none';
    }
    else document.getElementById('ifYesLST3').style.display = 'block';

}

</script>

<p>
<label for="LS4">Q<?php $i++; echo $i; ?>. Was the client asked how many units of alcohol they drink in a week?</label>
<input type="radio" name="LS4" 
<?php if (isset($LS4) && $LS4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST4();"
value="Yes" id="yesCheckLST4">Yes
<input type="radio" name="LS4"
<?php if (isset($LS4) && $LS4=="No") echo "checked";?> onclick="javascript:yesnoCheckLST4();"
value="No" id="noCheckLST4">No
</p>

<div id="ifYesLST4" style="display:none">
<textarea class="form-control"id="LST4" name="LST4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#LST4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST4() {
    if (document.getElementById('yesCheckLST4').checked) {
        document.getElementById('ifYesLST4').style.display = 'none';
    }
    else document.getElementById('ifYesLST4').style.display = 'block';

}

</script>

<p>
<label for="LS5">Q<?php $i++; echo $i; ?>. Did the closer ask if they have been disqualified from driving in the last 5 years?</label>
<input type="radio" name="LS5" 
<?php if (isset($LS5) && $LS5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST5();"
value="Yes" id="yesCheckLST5">Yes
<input type="radio" name="LS5"
<?php if (isset($LS5) && $LS5=="No") echo "checked";?> onclick="javascript:yesnoCheckLST5();"
value="No" id="noCheckLST5">No
</p>

<div id="ifYesLST5" style="display:none">
<textarea class="form-control"id="LST5" name="LST5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#LST5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST5() {
    if (document.getElementById('yesCheckLST5').checked) {
        document.getElementById('ifYesLST5').style.display = 'none';
    }
    else document.getElementById('ifYesLST5').style.display = 'block';

}

</script>

<p>
<label for="LS6">Q<?php $i++; echo $i; ?>. Did the closer ask if the client has used recreational drugs in the last 10 years?</label>
<input type="radio" name="LS6" 
<?php if (isset($LS6) && $LS6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST6();"
value="Yes" id="yesCheckLST6">Yes
<input type="radio" name="LS6"
<?php if (isset($LS6) && $LS6=="No") echo "checked";?> onclick="javascript:yesnoCheckLST6();"
value="No" id="noCheckLST6">No
</p>

<div id="ifYesLST6" style="display:none">
<textarea class="form-control"id="LST6" name="LST6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#LST6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST6() {
    if (document.getElementById('yesCheckLST6').checked) {
        document.getElementById('ifYesLST6').style.display = 'none';
    }
    else document.getElementById('ifYesLST6').style.display = 'block';

}

</script>

<p>
<label for="LS7">Q<?php $i++; echo $i; ?>. Did the closer check if the client had undertaken any of the listed activities?</label>
<input type="radio" name="LS7" 
<?php if (isset($LS7) && $LS7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckLST7();"
value="Yes" id="yesCheckLST7">Yes
<input type="radio" name="LS7"
<?php if (isset($LS7) && $LS7=="No") echo "checked";?> onclick="javascript:yesnoCheckLST7();"
value="No" id="noCheckLST7">No
</p>

<div id="ifYesLST7" style="display:none">
<textarea class="form-control"id="LST7" name="LST7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#LST7').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST7() {
    if (document.getElementById('yesCheckLST7').checked) {
        document.getElementById('ifYesLST7').style.display = 'none';
    }
    else document.getElementById('ifYesLST7').style.display = 'block';

}

</script>

    </div>    
</div> 
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Occupation and Travel</h3>
    </div>
    <div class="panel-body">

<p>
<label for="OT1">Q<?php $i++; echo $i; ?>. Was the client asked if their job involves manual work or driving?</label>
<input type="radio" name="OT1" 
<?php if (isset($OT1) && $OT1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckOTT1();"
value="Yes" id="yesCheckOTT1">Yes
<input type="radio" name="OT1"
<?php if (isset($OT1) && $OT1=="No") echo "checked";?> onclick="javascript:yesnoCheckOTT1();"
value="No" id="noCheckOTT1">No
</p>

<div id="ifYesOTT1" style="display:none">
<textarea class="form-control"id="OTT1" name="OTT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#OTT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft34').text('You have reached the limit');
            $('#characterLeft34').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft34').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft34').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT1() {
    if (document.getElementById('yesCheckOTT1').checked) {
        document.getElementById('ifYesOTT1').style.display = 'none';
    }
    else document.getElementById('ifYesOTT1').style.display = 'block';

}

</script>  

<p>
<label for="OT2">Q<?php $i++; echo $i; ?>. Was the client asked if they undertake in any of the listed hazardous activities?</label>
<input type="radio" name="OT2" 
<?php if (isset($OT2) && $OT2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckOTT2();"
value="Yes" id="yesCheckOTT2">Yes
<input type="radio" name="OT2"
<?php if (isset($OT2) && $OT2=="No") echo "checked";?> onclick="javascript:yesnoCheckOTT2();"
value="No" id="noCheckOTT2">No
</p>

<div id="ifYesOTT2" style="display:none">
<textarea class="form-control"id="OTT2" name="OTT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#OTT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT2() {
    if (document.getElementById('yesCheckOTT2').checked) {
        document.getElementById('ifYesOTT2').style.display = 'none';
    }
    else document.getElementById('ifYesOTT2').style.display = 'block';

}

</script>

<p>
<label for="OT3">Q<?php $i++; echo $i; ?>. Was the client asked if they have worked/travelled out the listed countries (in the last 2 years, or do they intend to)?</label>
<input type="radio" name="OT3" 
<?php if (isset($OT3) && $OT3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckOTT3();"
value="Yes" id="yesCheckOTT3">Yes
<input type="radio" name="OT3"
<?php if (isset($OT3) && $OT3=="No") echo "checked";?> onclick="javascript:yesnoCheckOTT3();"
value="No" id="noCheckOTT3">No
</p>

<div id="ifYesOTT3" style="display:none">
<textarea class="form-control"id="OTT3" name="OTT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#OTT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft26').text('You have reached the limit');
            $('#characterLeft26').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft26').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft26').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT3() {
    if (document.getElementById('yesCheckOTT3').checked) {
        document.getElementById('ifYesOTT3').style.display = 'none';
    }
    else document.getElementById('ifYesOTT3').style.display = 'block';

}

</script>
        
    </div>
</div>        
   
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Health Questions</h3>
        </div>
        <div class="panel-body">
           
<p>
<label for="HQ1">Q<?php $i++; echo $i; ?>. Was the client asked if they have ever had any health problems?</label>
<input type="radio" name="HQ1" 
<?php if (isset($HQ1) && $HQ1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT1();"
value="Yes" id="yesCheckHQT1">Yes
<input type="radio" name="HQ1"
<?php if (isset($HQ1) && $HQ1=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT1();"
value="No" id="noCheckHQT1">No
</p>

<div id="ifYesHQT1" style="display:none">
<textarea class="form-control"id="HQT1" name="HQT1" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft27" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft27').text('2500 characters left');
    $('#HQT1').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft27').text('You have reached the limit');
            $('#characterLeft27').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft27').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft27').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT1() {
    if (document.getElementById('yesCheckHQT1').checked) {
        document.getElementById('ifYesHQT1').style.display = 'none';
    }
    else document.getElementById('ifYesHQT1').style.display = 'block';

}

</script>

<p>
<label for="HQ2">Q<?php $i++; echo $i; ?>. Were all health in the last 5 years questions asked and recorded correctly?</label>
<input type="radio" name="HQ2" 
<?php if (isset($HQ2) && $HQ2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT2();"
value="Yes" id="yesCheckHQT2">Yes
<input type="radio" name="HQ2"
<?php if (isset($HQ2) && $HQ2=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT2();"
value="No" id="noCheckHQT2">No
</p>

<div id="ifYesHQT2" style="display:none">
<textarea class="form-control"id="HQT2" name="HQT2" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft28" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft28').text('2500 characters left');
    $('#HQT2').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft28').text('You have reached the limit');
            $('#characterLeft28').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft28').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft28').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT2() {
    if (document.getElementById('yesCheckHQT2').checked) {
        document.getElementById('ifYesHQT2').style.display = 'none';
    }
    else document.getElementById('ifYesHQT2').style.display = 'block';

}

</script>

<p>
<label for="HQ3">Q<?php $i++; echo $i; ?>. Were all health in the last 3 years questions asked and recorded correctly?</label>
<input type="radio" name="HQ3" 
<?php if (isset($HQ3) && $HQ3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT3();"
value="Yes" id="yesCheckHQT3">Yes
<input type="radio" name="HQ3"
<?php if (isset($HQ3) && $HQ3=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT3();"
value="No" id="noCheckHQT3">No
</p>

<div id="ifYesHQT3" style="display:none">
<textarea class="form-control"id="HQT3" name="HQT3" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft29" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft29').text('2500 characters left');
    $('#HQT3').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft29').text('You have reached the limit');
            $('#characterLeft29').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft29').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft29').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT3() {
    if (document.getElementById('yesCheckHQT3').checked) {
        document.getElementById('ifYesHQT3').style.display = 'none';
    }
    else document.getElementById('ifYesHQT3').style.display = 'block';

}

</script>

<p>
<label for="HQ4">Q<?php $i++; echo $i; ?>. Was the client asked if their family have any medical history?</label>
<input type="radio" name="HQ4" 
<?php if (isset($HQ4) && $HQ4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT4();"
value="Yes" id="yesCheckHQT4">Yes
<input type="radio" name="HQ4"
<?php if (isset($HQ4) && $HQ4=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT4();"
value="No" id="noCheckHQT4">No
</p>

<div id="ifYesHQT4" style="display:none">
<textarea class="form-control"id="HQT4" name="HQT4" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#HQT4').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft30').text('You have reached the limit');
            $('#characterLeft30').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft30').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft30').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT4() {
    if (document.getElementById('yesCheckHQT4').checked) {
        document.getElementById('ifYesHQT4').style.display = 'none';
    }
    else document.getElementById('ifYesHQT4').style.display = 'block';

}

</script>    

<p>
<label for="HQ5">Q<?php $i++; echo $i; ?>. If appropriate, did the closer confirm any exclusions on the policy?</label>
<input type="radio" name="HQ5" 
<?php if (isset($HQ5) && $HQ5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT5();"
value="Yes" id="yesCheckHQT5">Yes
<input type="radio" name="HQ5"
<?php if (isset($HQ5) && $HQ5=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT5();"
value="No" id="noCheckHQT5">No
</p>

<div id="ifYesHQT5" style="display:none">
<textarea class="form-control"id="HQT5" name="HQT5" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#HQT5').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft30').text('You have reached the limit');
            $('#characterLeft30').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft30').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft30').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT5() {
    if (document.getElementById('yesCheckHQT5').checked) {
        document.getElementById('ifYesHQT5').style.display = 'none';
    }
    else document.getElementById('ifYesHQT5').style.display = 'block';

}

</script>  

<p>
<label for="HQ6">Q<?php $i++; echo $i; ?>. Were all of the health questions recorded correctly?</label>
<input type="radio" name="HQ6" 
<?php if (isset($HQ6) && $HQ6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckHQT6();"
value="Yes" id="yesCheckHQT6">Yes
<input type="radio" name="HQ6"
<?php if (isset($HQ6) && $HQ6=="No") echo "checked";?> onclick="javascript:yesnoCheckHQT6();"
value="No" id="noCheckHQT6">No
</p>

<div id="ifYesHQT6" style="display:none">
<textarea class="form-control"id="HQT6" name="HQT6" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#HQT6').keydown(function () {
        var max = 2500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft30').text('You have reached the limit');
            $('#characterLeft30').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft30').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft30').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT6() {
    if (document.getElementById('yesCheckHQT6').checked) {
        document.getElementById('ifYesHQT6').style.display = 'none';
    }
    else document.getElementById('ifYesHQT6').style.display = 'block';

}

</script>  
            
        </div>
    </div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Eligibility</h3>
    </div>
    <div class="panel-body">
<p>
<label for="E1">Q<?php $i++; echo $i; ?>. Important customer information declaration?</label>
<input type="radio" name="E1" 
<?php if (isset($E1) && $E1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckET1();"
value="Yes" id="yesCheckET1">Yes
<input type="radio" name="E1"
<?php if (isset($E1) && $E1=="No") echo "checked";?> onclick="javascript:yesnoCheckET1();"
value="No" id="noCheckET1">No
</p>

<div id="ifYesET1" style="display:none">
<textarea class="form-control"id="ET1" name="ET1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft19" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft19').text('500 characters left');
    $('#ET1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft19').text('You have reached the limit');
            $('#characterLeft19').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft19').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft19').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET1() {
    if (document.getElementById('yesCheckET1').checked) {
        document.getElementById('ifYesET1').style.display = 'none';
    }
    else document.getElementById('ifYesET1').style.display = 'block';

}

</script>

<p>
<label for="E2">Q<?php $i++; echo $i; ?>. Were all clients contact details recorded correctly?</label>
<input type="radio" name="E2" 
<?php if (isset($E2) && $E2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckET2();"
value="Yes" id="yesCheckET2">Yes
<input type="radio" name="E2"
<?php if (isset($E2) && $E2=="No") echo "checked";?> onclick="javascript:yesnoCheckET2();"
value="No" id="noCheckET2">No
</p>

<div id="ifYesET2" style="display:none">
<textarea class="form-control"id="ET2" name="ET2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft18" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft18').text('500 characters left');
    $('#ET2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft18').text('You have reached the limit');
            $('#characterLeft18').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft18').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft18').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET2() {
    if (document.getElementById('yesCheckET2').checked) {
        document.getElementById('ifYesET2').style.display = 'none';
    }
    else document.getElementById('ifYesET2').style.display = 'block';

}

</script>

<p>
<label for="E3">Q<?php $i++; echo $i; ?>. Were all clients address details recorded correctly?</label>
<input type="radio" name="E3" 
<?php if (isset($E3) && $q15=="Yes") echo "checked";?> onclick="javascript:yesnoCheckET3();"
value="Yes" id="yesCheckET3">Yes
<input type="radio" name="E3"
<?php if (isset($E3) && $E3=="No") echo "checked";?> onclick="javascript:yesnoCheckET3();"
value="No" id="noCheckET3">No
</p>

<div id="ifYesET3" style="display:none">
<textarea class="form-control"id="ET3" name="ET3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft17" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft17').text('500 characters left');
    $('#ET3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft17').text('You have reached the limit');
            $('#characterLeft17').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft17').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft17').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET3() {
    if (document.getElementById('yesCheckET3').checked) {
        document.getElementById('ifYesET3').style.display = 'none';
    }
    else document.getElementById('ifYesET3').style.display = 'block';

}

</script>

<p>
<label for="E4">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label>
<input type="radio" name="E4" 
<?php if (isset($E4) && $E4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckET4();"
value="Yes" id="yesCheckET4">Yes
<input type="radio" name="E4"
<?php if (isset($E4) && $E4=="No") echo "checked";?> onclick="javascript:yesnoCheckET4();"
value="No" id="noCheckET4">No
</p>

<div id="ifYesET4" style="display:none">
<textarea class="form-control"id="ET4" name="ET4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft21" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft21').text('500 characters left');
    $('#ET4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft21').text('You have reached the limit');
            $('#characterLeft21').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft21').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft21').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET4() {
    if (document.getElementById('yesCheckET4').checked) {
        document.getElementById('ifYesET4').style.display = 'none';
    }
    else document.getElementById('ifYesET4').style.display = 'block';

}

</script>

<p>
<label for="E5">Q<?php $i++; echo $i; ?>. Were all family history questions asked and recorded correctly?</label>
<input type="radio" name="E5" 
<?php if (isset($E5) && $E5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckET5();"
value="Yes" id="yesCheckET5">Yes
<input type="radio" name="E5"
<?php if (isset($E5) && $E5=="No") echo "checked";?> onclick="javascript:yesnoCheckET5();"
value="No" id="noCheckET5">No
</p>

<div id="ifYesET5" style="display:none">
<textarea class="form-control"id="ET5" name="ET5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft31" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft31').text('500 characters left');
    $('#ET5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft31').text('You have reached the limit');
            $('#characterLeft31').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft31').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft31').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET5() {
    if (document.getElementById('yesCheckET5').checked) {
        document.getElementById('ifYesET5').style.display = 'none';
    }
    else document.getElementById('ifYesET5').style.display = 'block';

}

</script>

<p>
<label for="E6">Q<?php $i++; echo $i; ?>. Were term for term details recorded correctly?</label>
<select class="form-control" name="E6" >
  <option value="0">Select...</option>
  <option value="1">Client Provided Details</option>
  <option value="2">Client failed to provide details</option>
  <option value="3">Not existing Royal London customer</option>
  <option value="4">Obtained from Term4Term service</option>
  <option value="5">Existing Royal London Policy, no attempt to get policy number</option>
</select>
</p>

<textarea class="form-control"id="ET6" name="ET6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft32" class="help-block ">You have reached the limit</p></span>
<script>
$(document).ready(function(){ 
    $('#characterLeft32').text('500 characters left');
    $('#ET6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft32').text('You have reached the limit');
            $('#characterLeft32').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft32').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft32').removeClass('red');            
        }
    });    
});
</script>

</div>
</div>    

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Payment Information</h3>
    </div>
    <div class="panel-body">
<p>
<label for="PI1">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label>
<input type="radio" name="PI1" 
<?php if (isset($PI1) && $PI1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckPIT1();"
value="Yes" id="yesCheckPIT1">Yes
<input type="radio" name="PI1"
<?php if (isset($PI1) && $PI1=="No") echo "checked";?> onclick="javascript:yesnoCheckPIT1();"
value="No" id="noCheckPIT1">No
</p>

<div id="ifYesPIT1" style="display:none">
<textarea class="form-control"id="PIT1" name="PIT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft36').text('500 characters left');
    $('#PIT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft36').text('You have reached the limit');
            $('#characterLeft36').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft36').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft36').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT1() {
    if (document.getElementById('yesCheckPIT1').checked) {
        document.getElementById('ifYesPIT1').style.display = 'none';
    }
    else document.getElementById('ifYesPIT1').style.display = 'block';

}

</script>

<p>
<label for="PI2">Q<?php $i++; echo $i; ?>. Did the closer offer to read the direct debit guarantee?</label>
<input type="radio" name="PI2" 
<?php if (isset($PI2) && $PI2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckPIT2();"
value="Yes" id="yesCheckPIT2">Yes
<input type="radio" name="PI2"
<?php if (isset($PI2) && $PI2=="No") echo "checked";?> onclick="javascript:yesnoCheckPIT2();"
value="No" id="noCheckPIT2">No
</p>

<div id="ifYesPIT2" style="display:none">
<textarea class="form-control"id="PIT2" name="PIT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft37').text('500 characters left');
    $('#PIT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft37').text('You have reached the limit');
            $('#characterLeft37').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft37').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft37').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT2() {
    if (document.getElementById('yesCheckPIT2').checked) {
        document.getElementById('ifYesPIT2').style.display = 'none';
    }
    else document.getElementById('ifYesPIT2').style.display = 'block';

}

</script>

<p>
<label for="PI3">Q<?php $i++; echo $i; ?>. Did the closer offer a preferred premium collection date?</label>
<input type="radio" name="PI3" 
<?php if (isset($PI3) && $PI3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckPIT3();"
value="Yes" id="yesCheckPIT3">Yes
<input type="radio" name="PI3"
<?php if (isset($PI3) && $PI3=="No") echo "checked";?> onclick="javascript:yesnoCheckPIT3();"
value="No" id="noCheckPIT3">No
</p>

<div id="ifYesPIT3" style="display:none">
<textarea class="form-control"id="PIT3" name="PIT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft38').text('500 characters left');
    $('#PIT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft38').text('You have reached the limit');
            $('#characterLeft38').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft38').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft38').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT3() {
    if (document.getElementById('yesCheckPIT3').checked) {
        document.getElementById('ifYesPIT3').style.display = 'none';
    }
    else document.getElementById('ifYesPIT3').style.display = 'block';

}

</script>

<p>
<label for="PI4">Q<?php $i++; echo $i; ?>. Did the closer record the bank details correctly?</label>
<input type="radio" name="PI4" 
<?php if (isset($PI4) && $PI4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckPIT4();"
value="Yes" id="yesCheckPIT4">Yes
<input type="radio" name="PI4"
<?php if (isset($PI4) && $PI4=="No") echo "checked";?> onclick="javascript:yesnoCheckPIT4();"
value="No" id="noCheckPIT4">No
</p>

<div id="ifYesPIT4" style="display:none">
<textarea class="form-control"id="PIT4" name="PIT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft39').text('500 characters left');
    $('#PIT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft39').text('You have reached the limit');
            $('#characterLeft39').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft39').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft39').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT4() {
    if (document.getElementById('yesCheckPIT4').checked) {
        document.getElementById('ifYesPIT4').style.display = 'none';
    }
    else document.getElementById('ifYesPIT4').style.display = 'block';

}

</script>

<p>
<label for="PI5">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label>
<input type="radio" name="PI5" 
<?php if (isset($PI5) && $PI5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckPIT5();"
value="Yes" id="yesCheckPIT5">Yes
<input type="radio" name="PI5"
<?php if (isset($PI5) && $PI5=="No") echo "checked";?> onclick="javascript:yesnoCheckPIT5();"
value="No" id="noCheckPIT5">No
</p>

<div id="ifYesPIT5" style="display:none">
<textarea class="form-control"id="PIT5" name="PIT5" rows="1" cols="75" maxlength="1500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft40').text('500 characters left');
    $('#PIT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft40').text('You have reached the limit');
            $('#characterLeft40').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft40').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft40').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT5() {
    if (document.getElementById('yesCheckPIT5').checked) {
        document.getElementById('ifYesPIT5').style.display = 'none';
    }
    else document.getElementById('ifYesPIT5').style.display = 'block';

}

</script>

</div>
</div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Consolidation Declaration</h3>
        </div>
        <div class="panel-body">
            
<p>
<label for="CDE1">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
<input type="radio" name="CDE1" 
<?php if (isset($CDE1) && $CDE1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET1();"
value="Yes" id="yesCheckCDET1">Yes
<input type="radio" name="CDE1"
<?php if (isset($CDE1) && $CDE1=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET1();"
value="No" id="noCheckCDET1">No
</p>

<div id="ifYesCDET1" style="display:none">
<textarea class="form-control"id="CDET1" name="CDET1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft41').text('500 characters left');
    $('#CDET1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft41').text('You have reached the limit');
            $('#characterLeft41').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft41').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft41').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET1() {
    if (document.getElementById('yesCheckCDET1').checked) {
        document.getElementById('ifYesCDET1').style.display = 'none';
    }
    else document.getElementById('ifYesCDET1').style.display = 'block';

}

</script>


<p>
<label for="CDE2">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
<input type="radio" name="CDE2" 
<?php if (isset($CDE2) && $CDE2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET2();"
value="Yes" id="yesCheckCDET2">Yes
<input type="radio" name="CDE2"
<?php if (isset($CDE2) && $CDE2=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET2();"
value="No" id="noCheckCDET2">No
</p>

<div id="ifYesCDET2" style="display:none">
<textarea class="form-control"id="CDET2" name="CDET2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft42').text('500 characters left');
    $('#CDET2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft42').text('You have reached the limit');
            $('#characterLeft42').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft42').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft42').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET2() {
    if (document.getElementById('yesCheckCDET2').checked) {
        document.getElementById('ifYesCDET2').style.display = 'none';
    }
    else document.getElementById('ifYesCDET2').style.display = 'block';

}

</script>

<p>
<label for="CDE3">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
<input type="radio" name="CDE3" 
<?php if (isset($CDE3) && $CDE3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET3();"
value="Yes" id="yesCheckCDET3">Yes
<input type="radio" name="CDE3"
<?php if (isset($CDE3) && $CDE3=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET3();"
value="No" id="noCheckCDET3">No
</p>

<div id="ifYesCDET3" style="display:none">
<textarea class="form-control"id="CDET3" name="CDET3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft43" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft43').text('500 characters left');
    $('#CDET3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft43').text('You have reached the limit');
            $('#characterLeft43').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft43').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft43').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET3() {
    if (document.getElementById('yesCheckCDET3').checked) {
        document.getElementById('ifYesCDET3').style.display = 'none';
    }
    else document.getElementById('ifYesCDET3').style.display = 'block';

}

</script>

<p>
<label for="CDE4">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
<input type="radio" name="CDE4" 
<?php if (isset($CDE4) && $CDE4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET4();"
value="Yes" id="yesCheckCDET4">Yes
<input type="radio" name="CDE4"
<?php if (isset($CDE4) && $CDE4=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET4();"
value="No" id="noCheckCDET4">No
</p>

<div id="ifYesCDET4" style="display:none">
<textarea class="form-control"id="CDET4" name="CDET4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft44" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft44').text('500 characters left');
    $('#CDET4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft44').text('You have reached the limit');
            $('#characterLeft44').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft44').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft44').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET4() {
    if (document.getElementById('yesCheckCDET4').checked) {
        document.getElementById('ifYesCDET4').style.display = 'none';
    }
    else document.getElementById('ifYesCDET4').style.display = 'block';

}

</script>

<p>
<label for="CDE5">Q<?php $i++; echo $i; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Royal London?</label>
<input type="radio" name="CDE5" 
<?php if (isset($CDE5) && $CDE5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET5();"
value="Yes" id="yesCheckCDET5">Yes
<input type="radio" name="CDE5"
<?php if (isset($CDE5) && $CDE5=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET5();"
value="No" id="noCheckCDET5">No
</p>

<div id="ifYesCDET5" style="display:none">
<textarea class="form-control"id="CDET5" name="CDET5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft45" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft45').text('500 characters left');
    $('#CDET5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft45').text('You have reached the limit');
            $('#characterLeft45').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft45').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft45').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET5() {
    if (document.getElementById('yesCheckCDET5').checked) {
        document.getElementById('ifYesCDET5').style.display = 'none';
    }
    else document.getElementById('ifYesCDET5').style.display = 'block';

}

</script>

<p>
<label for="CDE6">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label>
<input type="radio" name="CDE6" 
<?php if (isset($CDE6) && $CDE6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET6();"
value="Yes" id="yesCheckCDET6">Yes
<input type="radio" name="CDE6"
<?php if (isset($CDE6) && $CDE6=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET6();"
value="No" id="noCheckCDET6">No
</p>

<div id="ifYesCDET6" style="display:none">
<textarea class="form-control"id="CDET6" name="CDET6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft46" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft46').text('500 characters left');
    $('#CDET6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft46').text('You have reached the limit');
            $('#characterLeft46').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft46').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft46').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET6() {
    if (document.getElementById('yesCheckCDET6').checked) {
        document.getElementById('ifYesCDET6').style.display = 'none';
    }
    else document.getElementById('ifYesCDET6').style.display = 'block';

}

</script>

<p>
<label for="CDE7">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Royal London will write to them with a more specific date?</label>
<input type="radio" name="CDE7" 
<?php if (isset($CDE7) && $CDE7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET7();"
value="Yes" id="yesCheckCDET7">Yes
<input type="radio" name="CDE7"
<?php if (isset($CDE7) && $CDE7=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET7();"
value="No" id="noCheckCDET7">No

</p>

<div id="ifYesCDET7" style="display:none">
<textarea class="form-control"id="CDET7" name="CDET7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft47" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft47').text('500 characters left');
    $('#CDET7').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft47').text('You have reached the limit');
            $('#characterLeft47').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft47').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft47').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET7() {
    if (document.getElementById('yesCheckCDET7').checked) {
        document.getElementById('ifYesCDET7').style.display = 'none';
    }
    else document.getElementById('ifYesCDET7').style.display = 'block';

}

</script>

<p>
<label for="CDE8">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label>
<input type="radio" name="CDE8" 
<?php if (isset($CDE8) && $CDE8=="Yes") echo "checked";?> onclick="javascript:yesnoCheckCDET8();"
value="Yes" id="yesCheckCDET8">Yes
<input type="radio" name="CDE8"
<?php if (isset($CDE8) && $CDE8=="No") echo "checked";?> onclick="javascript:yesnoCheckCDET8();"
value="No" id="noCheckCDET8">No
<input type="radio" name="CDE8" 
<?php if (isset($CDE8) && $CDE8=="N/A") echo "checked";?> onclick="javascript:yesnoCheckCDET8();"
value="N/A" id="yesCheckCDET8">N/A
</p>

<div id="ifYesCDET8" style="display:none">
<textarea class="form-control"id="CDET8" name="CDET8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft48" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft48').text('500 characters left');
    $('#CDET8').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft48').text('You have reached the limit');
            $('#characterLeft48').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft48').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft48').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET8() {
    if (document.getElementById('yesCheckCDET8').checked) {
        document.getElementById('ifYesCDET8').style.display = 'none';
    }
    else document.getElementById('ifYesCDET8').style.display = 'block';

}

</script>

</div>
</div>
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Quality Control</h3>
        </div>
        <div class="panel-body">
            
<p>
<label for="QC1">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Royal London with client information?</label>
<input type="radio" name="QC1" 
<?php if (isset($QC1) && $QC1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT1();"
value="Yes" id="yesCheckQCT1">Yes
<input type="radio" name="QC1"
<?php if (isset($QC1) && $QC1=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT1();"
value="No" id="noCheckQCT1">No
</p>

<div id="ifYesQCT1" style="display:none">
<textarea class="form-control"id="QCT1" name="QCT1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft49" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft49').text('500 characters left');
    $('#QCT1').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft49').text('You have reached the limit');
            $('#characterLeft49').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft49').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft49').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT1() {
    if (document.getElementById('yesCheckQCT1').checked) {
        document.getElementById('ifYesQCT1').style.display = 'none';
    }
    else document.getElementById('ifYesQCT1').style.display = 'block';

}

</script>

<p>
<label for="QC2">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label>
<input type="radio" name="QC2" 
<?php if (isset($QC2) && $QC2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT2();"
value="Yes" id="yesCheckQCT2">Yes
<input type="radio" name="QC2"
<?php if (isset($QC2) && $QC2=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT2();"
value="No" id="noCheckQCT2">No
</p>

<div id="ifYesQCT2" style="display:none">
<textarea class="form-control"id="QCT2" name="QCT2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft50" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft50').text('500 characters left');
    $('#QCT2').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft50').text('You have reached the limit');
            $('#characterLeft50').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft50').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft50').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT2() {
    if (document.getElementById('yesCheckQCT2').checked) {
        document.getElementById('ifYesQCT2').style.display = 'none';
    }
    else document.getElementById('ifYesQCT2').style.display = 'block';

}

</script>

<p>
<label for="QC3">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
<input type="radio" name="QC3" 
<?php if (isset($QC3) && $QC3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT3();"
value="Yes" id="yesCheckQCT3">Yes
<input type="radio" name="QC3"
<?php if (isset($QC3) && $QC3=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT3();"
value="No" id="noCheckQCT3">No
</p>

<div id="ifYesQCT3" style="display:none">
<textarea class="form-control"id="QCT3" name="QCT3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft51" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft51').text('500 characters left');
    $('#QCT3').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft51').text('You have reached the limit');
            $('#characterLeft51').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft51').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft51').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT3() {
    if (document.getElementById('yesCheckQCT3').checked) {
        document.getElementById('ifYesQCT3').style.display = 'none';
    }
    else document.getElementById('ifYesQCT3').style.display = 'block';

}

</script>

<p>
<label for="QC4">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
<input type="radio" name="QC4" 
<?php if (isset($QC4) && $QC4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT4();"
value="Yes" id="yesCheckQCT4">Yes
<input type="radio" name="QC4"
<?php if (isset($QC4) && $QC4=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT4();"
value="No" id="noCheckQCT4">No
</p>

<div id="ifYesQCT4" style="display:none">
<textarea class="form-control"id="QCT4" name="QCT4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft52" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft52').text('500 characters left');
    $('#QCT4').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft52').text('You have reached the limit');
            $('#characterLeft52').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft52').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft52').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT4() {
    if (document.getElementById('yesCheckQCT4').checked) {
        document.getElementById('ifYesQCT4').style.display = 'none';
    }
    else document.getElementById('ifYesQCT4').style.display = 'block';

}

</script>

<p>
<label for="QC5">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
<input type="radio" name="QC5" 
<?php if (isset($QC5) && $QC5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT5();"
value="Yes" id="yesCheckQCT5">Yes
<input type="radio" name="QC5"
<?php if (isset($QC5) && $QC5=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT5();"
value="No" id="noCheckQCT5">No
</p>

<div id="ifYesQCT5" style="display:none">
<textarea class="form-control"id="QCT5" name="QCT5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft53" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft53').text('500 characters left');
    $('#QCT5').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft53').text('You have reached the limit');
            $('#characterLeft53').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft53').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft53').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT5() {
    if (document.getElementById('yesCheckQCT5').checked) {
        document.getElementById('ifYesQCT5').style.display = 'none';
    }
    else document.getElementById('ifYesQCT5').style.display = 'block';

}

</script>

<p>
<label for="QC6">Q<?php $i++; echo $i; ?>. Closer provided contact details for The Review Bureau?</label>
<input type="radio" name="QC6" 
<?php if (isset($QC6) && $QC6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT6();"
value="Yes" id="yesCheckQCT6">Yes
<input type="radio" name="QC6"
<?php if (isset($QC6) && $QC6=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT6();"
value="No" id="noCheckQCT6">No
</p>

<div id="ifYesQCT6" style="display:none">
<textarea class="form-control"id="QCT6" name="QCT6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft54" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft54').text('500 characters left');
    $('#QCT6').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft54').text('You have reached the limit');
            $('#characterLeft54').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft54').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft54').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT6() {
    if (document.getElementById('yesCheckQCT6').checked) {
        document.getElementById('ifYesQCT6').style.display = 'none';
    }
    else document.getElementById('ifYesQCT6').style.display = 'block';

}

</script>

<p>
<label for="QC7">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
<input type="radio" name="QC7" 
<?php if (isset($QC7) && $QC7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckQCT7();"
value="Yes" id="yesCheckQCT7">Yes
<input type="radio" name="QC7"
<?php if (isset($QC7) && $QC7=="No") echo "checked";?> onclick="javascript:yesnoCheckQCT7();"
value="No" id="noCheckQCT7">No
</p>

<div id="ifYesQCT7" style="display:none">
<textarea class="form-control"id="QCT7" name="QCT7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft55" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft55').text('500 characters left');
    $('#QCT7').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft55').text('You have reached the limit');
            $('#characterLeft55').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft55').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft55').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT7() {
    if (document.getElementById('yesCheckQCT7').checked) {
        document.getElementById('ifYesQCT7').style.display = 'none';
    }
    else document.getElementById('ifYesQCT7').style.display = 'block';

}

</script>

</div>
</div>

<br>

<center>
    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Submit Audit</button>
</center>
</form>


    </div>
  </div>

</div>

<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>