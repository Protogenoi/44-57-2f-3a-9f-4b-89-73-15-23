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
<link href="../..//img/favicon.ico" rel="icon" type="image/x-icon" />

<script>
$(function() {
    $(document).pjScrollUp({
        offset: 210,
        duration: 850,
        aTitle: "Scroll Up",
        imgAlt: "Back to top",
        imgSrc: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAVPSURBVHic7Z3dbxRVFMB/ZylRaipYsQo8FEkIGx76ggHfFGliGx98kDZqMOJ/ZpRoAuGBmFiQLSVV0lB5sSakpgapAYm1qR+NYDT0+HBv93vne+7MLPNL9qHdmTvn/nJ3Z+6ZO2dFVckKEdkFjABDHi+ATY/Xmqo+cht5A3EtUER2A0eAKnAQqMRscgu4CywDP6jqnzHbC4UTgSLyIkZYFdiX8uF+wchcVtW1lI+VnkAREeAocBLYm8pB/FkH5oDbmlJHUxEoIi8D48CBxBuPxn2gpqo/Jd1wogLtR3UcOJxYo8myghH5a1INJiJQRJ4FTgFjgMRuMF0UWAJmVfWvuI3FFigiB4FpYDBuMI55CJxX1btxGoklUEReASaBHXGCyJDHwIyq3oraQCSBIlIBJoDjUQ+cMxaBy6q6FXbH0ALt7GEKOBT2YDnnDnAh7KwmlEARGQbOAMPhYisMG8A5Vd0IukPgaZQdef0sD0zfzti+BiKQQPudN0V/y9tmGJiyffYl6AicoP++87w4hOmzL74C7aVKv5xtw3Dc9t0TT4H2InkyoYCKyKR10JOeAu30bJriXiQnwQ<?php $i++; echo $i; ?>g2rroitcIPEXxpmdpMIhx0ZWuAm1WZSytiArImHXSQa8ROE7+syouEYyTDjoE2mRoXvN5WXLYummhRaBNw3c1XQLAuHVUp30EHiU/afg8cgDjqE67wJPuYiksLY7qAu1ZJqu7Z0Vib/MZuXkEVjMIpqjUXZUCo9Eq0C63SHvFQD+xzzqrj8By9IWnCjDQ/EfO+A2zLONnTHxvkK+5eRW4OWDT16NZR9PG98AXqvqv/fuWiPwIvAu8lF1YLYyKyK4KZn1e3CVmSbKgqheb5AGgqn8AH2PWueSBCjBSobGIMQ/Mq+qVXm+q6j/Ap5glbHlgKE8Ca6p6zW+jJokP0g/Jl9wIvKKq3wTd2N78/gRzosmSXAi8qqoLYXeyEj8D/k4+pMBkLvCaqt6IurOq/g58DvyXXEihyFTgdVWd99tIRJ7yel9V7wEXMYvNXZOZwHlVve63kYi8BnwoIju9tlPVZeASZvGkS4ayuP67EeRsKyLHMLm3/cDp9kxwO6r6HfBlMiEGp4J5WMUVC6p61W8jEakCbzX96wgBllqo6rfAbPTwQrPpUuA94Cu/jURkFDhN5+zohIi86re/qn6NWevnAqcC5/ye1bCZ3vdoJDnaedOOTj98T04J4VSg5/RLRPZg1h8+7bUZ8I6I+N34cjVLcSrQax3OIPABwa4IdgLvi8hzPtu4wKnArksjrIizwPMh2noGOGuXHHdjf7jQIrM5gDuBEyKyAKxhnmHbg8lDvk60ROlu4CMRuQmsYvrxgn2dSCLgAGwOYDq0Rfo5wRHg7YTbHCK7lRRbwFrFTspXMwqiyKyq6qPtUbecaSjFZBkaH9tSYHgaAu1j8nnI8BaFB9ulBZpPHOUoDE7dVSkwGp0C7VPc65mEUyzWm594b7/2m3McTBFpcdQu8Db5uXGdR+5jHNVpEWjTTTWXERWMWntKrmP6ZkuDrDgLqTisdCub0mv+W8P9DZo80/OT2VWgPcsspRlRwVjqVWvGKwMziykN8qTzEI8bVT0F2qI05zGlQZ5UHmNqy/Qs0OOZA7RFaWYSDqpIzPgV5vFNotqiNItJRVQgFoMU5Amahb6Mu3uteeAOps++BBJoK/pcwNRV6Xc2MAV4Ai1WCnwfxKb+z9HfErcL7wSuXlSWfmqQfumn+k5l8bE6Zfm7LMrftTRQFmAsS4DGoSxCG5OyDHJMykLcMSlLwcek/DGCmDgX2HLwPvg5jP8BZQUTNqeQ<?php $i++; echo $i; ?>kYAAAAASUVORK5CYII=",
        selector: "my-id",
        easing: "linear",
        complete: function () {
            if (window.console && window.console.log) {
                console.log("complete!");
            }
        }
    });
});
</script>
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
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
<label for='full_name'>Closer:</label>
<select class='form-control' name='full_name' id='full_name' required> 
    <option value="">Select...</option>
<option value="Carys">Carys</option>
<option value="Hayley">Hayley</option>
<option value="James">James</option>
<option value="Kyle">Kyle</option>  
<option value="Mike">Mike</option> 
<option value="Nathan">Nathan</option> 
<option value="Richard">Richard</option>
<option value="Ricky">Ricky</option> 
<option value="Sarah">Sarah</option>
<option value="Stavros">Stavros</option>
<option value="Nicola">Nicola</option>  
<option value="Gavin">Gavin</option>
<option value="Rhys">Rhys</option> 
</select>
</div>



<div class='form-group'>
<label for='full_name2'>Closer (optional):</label>
<select class='form-control' name='full_name2' id='full_name2' >    
<option value="None">None</option>    
<option value="Carys">Carys</option>
<option value="Hayley">Hayley</option>
<option value="James">James</option>
<option value="Kyle">Kyle</option>  
<option value="Mike">Mike</option> 
<option value="Nathan">Nathan</option> 
<option value="Richard">Richard</option>
<option value="Ricky">Ricky</option> 
<option value="Sarah">Sarah</option> 
<option value="Stavros">Stavros</option>
<option value="Nicola">Nicola</option> 
<option value="Gavin">Gavin</option> 
<option value="Rhys">Rhys</option> 
</select>
</div>


<label for="policy_id">Policy Number</label>
<input type="text" class="form-control" name="policy_id" style="width: 520px">

<label for="annumber">AN Number</label>
<input type="text" class="form-control" name="annumber" style="width: 520px" required>

</p>

<p>
<div class="form-group">
<label for='formgrade'>Grade:</label>
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
<label for="q1">Q<?php $i=0; $i++; echo $i; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
<input type="radio" name="q1" 
<?php if (isset($q1) && $q1=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc1();"
value="Yes" id="yesCheckc1">Yes
<input type="radio" name="q1"
<?php if (isset($q1) && $q1=="No") echo "checked";?> onclick="javascript:yesnoCheckc1();"
value="No" id="noCheckc1">No
</p>

<div id="ifYesc1" style="display:none">
<textarea class="form-control"id="c1" name="c1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft1').text('500 characters left');
    $('#c1').keydown(function () {
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

function yesnoCheckc1() {
    if (document.getElementById('yesCheckc1').checked) {
        document.getElementById('ifYesc1').style.display = 'none';
    }
    else document.getElementById('ifYesc1').style.display = 'block';

}
</script>

<p>
<label for="q2">Q<?php $i++; echo $i; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
<input type="radio" name="q2" 
<?php if (isset($q2) && $q2=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc2();"
value="Yes" id="yesCheckc2">Yes
<input type="radio" name="q2"
<?php if (isset($q2) && $q2=="No") echo "checked";?> onclick="javascript:yesnoCheckc2();"
value="No" id="noCheckc2">No
</p>

<div id="ifYesc2" style="display:none">
<textarea class="form-control"id="c2" name="c2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft2').text('500 characters left');
    $('#c2').keydown(function () {
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

function yesnoCheckc2() {
    if (document.getElementById('yesCheckc2').checked) {
        document.getElementById('ifYesc2').style.display = 'none';
    }
    else document.getElementById('ifYesc2').style.display = 'block';

}

</script>

<p>
<label for="q3">Q<?php $i++; echo $i; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
<input type="radio" name="q3" 
<?php if (isset($q3) && $q3=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc3();"
value="Yes" id="yesCheckc3">Yes
<input type="radio" name="q3"
<?php if (isset($q3) && $q3=="No") echo "checked";?> onclick="javascript:yesnoCheckc3();"
value="No" id="noCheckc3">No
</p>

<div id="ifYesc3" style="display:none">
<textarea class="form-control"id="c3" name="c3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft3').text('500 characters left');
    $('#c3').keydown(function () {
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

function yesnoCheckc3() {
    if (document.getElementById('yesCheckc3').checked) {
        document.getElementById('ifYesc3').style.display = 'none';
    }
    else document.getElementById('ifYesc3').style.display = 'block';

}

</script>

<p>
<label for="q4">Q<?php $i++; echo $i; ?>. Did the closer provide the name and details of the firm who is regulated by the FCA?</label>
<input type="radio" name="q4" 
<?php if (isset($q4) && $q4=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc4();"
value="Yes" id="yesCheckc4">Yes
<input type="radio" name="q4"
<?php if (isset($q4) && $q4=="No") echo "checked";?> onclick="javascript:yesnoCheckc4();"
value="No" id="noCheckc4">No
</p>

<div id="ifYesc4" style="display:none">
<textarea class="form-control"id="c4" name="c4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft4').text('500 characters left');
    $('#c4').keydown(function () {
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

function yesnoCheckc4() {
    if (document.getElementById('yesCheckc4').checked) {
        document.getElementById('ifYesc4').style.display = 'none';
    }
    else document.getElementById('ifYesc4').style.display = 'block';

}

</script>

<p>
<label for="q5">Q<?php $i++; echo $i; ?>. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
<input type="radio" name="q5" 
<?php if (isset($q5) && $q5=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc5();"
value="Yes" id="yesCheckc5">Yes
<input type="radio" name="q5"
<?php if (isset($q5) && $q5=="No") echo "checked";?> onclick="javascript:yesnoCheckc5();"
value="No" id="noCheckc5">No
</p>

<div id="ifYesc5" style="display:none">
<textarea class="form-control"id="c5" name="c5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft5').text('500 characters left');
    $('#c5').keydown(function () {
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

function yesnoCheckc5() {
    if (document.getElementById('yesCheckc5').checked) {
        document.getElementById('ifYesc5').style.display = 'none';
    }
    else document.getElementById('ifYesc5').style.display = 'block';

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
<label for="q7">Q<?php $i++; echo $i; ?>. Was the clients gender accurately recorded?</label>
<input type="radio" name="q7" 
<?php if (isset($q7) && $q7=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc7();"
value="Yes" id="yesCheckc7">Yes
<input type="radio" name="q7"
<?php if (isset($q7) && $q7=="No") echo "checked";?> onclick="javascript:yesnoCheckc7();"
value="No" id="noCheckc7">No
</p>

<div id="ifYesc7" style="display:none">
<textarea class="form-control"id="c7" name="c7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft7').text('500 characters left');
    $('#c7').keydown(function () {
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

function yesnoCheckc7() {
    if (document.getElementById('yesCheckc7').checked) {
        document.getElementById('ifYesc7').style.display = 'none';
    }
    else document.getElementById('ifYesc7').style.display = 'block';

}

</script>


<p>
<label for="q8">Q<?php $i++; echo $i; ?>. Was the clients date of birth accurately recorded?</label>
<input type="radio" name="q8" onclick="javascript:yesnoCheck();"
<?php if (isset($q8) && $q8=="Yes") echo "checked";?>
value="Yes" id="yesCheck">Yes
<input type="radio" name="q8" onclick="javascript:yesnoCheck();"
<?php if (isset($q8) && $q8=="No") echo "checked";?>
value="No" id="noCheck">No
</p>
<div id="ifYes" style="display:none">
<textarea class="form-control"id="c8" name="c8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft8').text('500 characters left');
    $('#c8').keydown(function () {
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
<label for="q9">Q<?php $i++; echo $i; ?>. Was the clients smoking status recorded correctly?</label>
<input type="radio" name="q9" 
<?php if (isset($q9) && $q9=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc9();"
value="Yes" id="yesCheckc9">Yes
<input type="radio" name="q9"
<?php if (isset($q9) && $q9=="No") echo "checked";?> onclick="javascript:yesnoCheckc9();"
value="No" id="noCheckc9">No
</p>

<div id="ifYesc9" style="display:none">
<textarea class="form-control"id="c9" name="c9" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft9').text('500 characters left');
    $('#c9').keydown(function () {
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

function yesnoCheckc9() {
    if (document.getElementById('yesCheckc9').checked) {
        document.getElementById('ifYesc9').style.display = 'none';
    }
    else document.getElementById('ifYesc9').style.display = 'block';

}

</script>


<p>
<label for="q10">Q<?php $i++; echo $i; ?>. Was the clients employment status recorded correctly?</label>
<input type="radio" name="q10" 
<?php if (isset($q10) && $q10=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc10();"
value="Yes" id="yesCheckc10">Yes
<input type="radio" name="q10"
<?php if (isset($q10) && $q10=="No") echo "checked";?> onclick="javascript:yesnoCheckc10();"
value="No" id="noCheckc10">No
</p>

<div id="ifYesc10" style="display:none">
<textarea class="form-control"id="c10" name="c10" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft10" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft10').text('500 characters left');
    $('#c10').keydown(function () {
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

function yesnoCheckc10() {
    if (document.getElementById('yesCheckc10').checked) {
        document.getElementById('ifYesc10').style.display = 'none';
    }
    else document.getElementById('ifYesc10').style.display = 'block';

}

</script>

<p>
<label for="q11">Q<?php $i++; echo $i; ?>. Did the closer confirm the policy was a single or a joint application?</label>
<input type="radio" name="q11" 
<?php if (isset($q11) && $q11=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc11();"
value="Yes" id="yesCheckc11">Yes
<input type="radio" name="q11"
<?php if (isset($q11) && $q11=="No") echo "checked";?> onclick="javascript:yesnoCheckc11();"
value="No" id="noCheckc11">No
</p>

<div id="ifYesc11" style="display:none">
<textarea class="form-control"id="c11" name="c11" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft11').text('500 characters left');
    $('#c11').keydown(function () {
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

function yesnoCheckc11() {
    if (document.getElementById('yesCheckc11').checked) {
        document.getElementById('ifYesc11').style.display = 'none';
    }
    else document.getElementById('ifYesc11').style.display = 'block';

}

</script>

<p>
<label for="q112">Q<?php $i++; echo $i; ?>. Was the clients country of residence recorded correctly?</label>
<input type="radio" name="q112" 
<?php if (isset($q112) && $q112=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc112();"
value="Yes" id="yesCheckc112">Yes
<input type="radio" name="q112"
<?php if (isset($q112) && $q112=="No") echo "checked";?> onclick="javascript:yesnoCheckc112();"
value="No" id="noCheckc112">No
</p>

<div id="ifYesc112" style="display:none">
<textarea class="form-control"id="c112" name="c112" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft112" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft112').text('500 characters left');
    $('#c112').keydown(function () {
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

function yesnoCheckc112() {
    if (document.getElementById('yesCheckc112').checked) {
        document.getElementById('ifYesc112').style.display = 'none';
    }
    else document.getElementById('ifYesc112').style.display = 'block';

}

</script>

<p>
<label for="q113">Q<?php $i++; echo $i; ?>. Was the clients occupation recorded correctly?</label>
<input type="radio" name="q113" 
<?php if (isset($q113) && $q113=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc113();"
value="Yes" id="yesCheckc113">Yes
<input type="radio" name="q113"
<?php if (isset($q113) && $q113=="No") echo "checked";?> onclick="javascript:yesnoCheckc113();"
value="No" id="noCheckc113">No
</p>

<div id="ifYesc113" style="display:none">
<textarea class="form-control"id="c113" name="c113" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft113" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft113').text('500 characters left');
    $('#c113').keydown(function () {
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

function yesnoCheckc113() {
    if (document.getElementById('yesCheckc113').checked) {
        document.getElementById('ifYesc113').style.display = 'none';
    }
    else document.getElementById('ifYesc113').style.display = 'block';

}

</script>

<p>
<label for="q114">Q<?php $i++; echo $i; ?>. Was the clients salary recorded correctly?</label>
<input type="radio" name="q114" 
<?php if (isset($q114) && $q114=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc114();"
value="Yes" id="yesCheckc114">Yes
<input type="radio" name="q114"
<?php if (isset($q114) && $q114=="No") echo "checked";?> onclick="javascript:yesnoCheckc114();"
value="No" id="noCheckc114">No
</p>

<div id="ifYesc114" style="display:none">
<textarea class="form-control"id="c114" name="c114" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft114" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft114').text('500 characters left');
    $('#c114').keydown(function () {
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

function yesnoCheckc114() {
    if (document.getElementById('yesCheckc114').checked) {
        document.getElementById('ifYesc114').style.display = 'none';
    }
    else document.getElementById('ifYesc114').style.display = 'block';

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
<label for="q12">Q<?php $i++; echo $i; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label>
<input type="radio" name="q12" 
<?php if (isset($q12) && $q12=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc12();"
value="Yes" id="yesCheckc12">Yes
<input type="radio" name="q12"
<?php if (isset($q12vvv) && $q12=="No") echo "checked";?> onclick="javascript:yesnoCheckc12();"
value="No" id="noCheckc12">No
</p>

<div id="ifYesc12" style="display:none">
<textarea class="form-control"id="c12" name="c12" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft12').text('500 characters left');
    $('#c12').keydown(function () {
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

function yesnoCheckc12() {
    if (document.getElementById('yesCheckc12').checked) {
        document.getElementById('ifYesc12').style.display = 'none';
    }
    else document.getElementById('ifYesc12').style.display = 'block';

}

</script>


<p>
<label for="q53">Q<?php $i++; echo $i; ?>. Did the closer mention waiver, indexation, or TPD?</label>
<input type="radio" name="q53" 
<?php if (isset($q53) && $q53=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc53();"
value="Yes" id="yesCheckc53">Yes
<input type="radio" name="q53"
<?php if (isset($q53) && $q53=="No") echo "checked";?> onclick="javascript:yesnoCheckc53();"
value="No" id="noCheckc53">No
<input type="radio" name="q53" 
<?php if (isset($q53) && $q53=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesc53" style="display:none">
<textarea class="form-control"id="c53" name="c53" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft13').text('500 characters left');
    $('#c53').keydown(function () {
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

function yesnoCheckc53() {
    if (document.getElementById('yesCheckc53').checked) {
        document.getElementById('ifYesc53').style.display = 'none';
    }
    else document.getElementById('ifYesc53').style.display = 'block';

}

</script>


<p>
<label for="q13">Q<?php $i++; echo $i; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
<input type="radio" name="q13" 
<?php if (isset($q13) && $q13=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc13();"
value="Yes" id="yesCheckc13">Yes
<input type="radio" name="q13"
<?php if (isset($q13) && $q13=="No") echo "checked";?> onclick="javascript:yesnoCheckc13();"
value="No" id="noCheckc13">No
</p>

<div id="ifYesc13" style="display:none">
<textarea class="form-control"id="c13" name="c13" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft14').text('500 characters left');
    $('#c13').keydown(function () {
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

function yesnoCheckc13() {
    if (document.getElementById('yesCheckc13').checked) {
        document.getElementById('ifYesc13').style.display = 'none';
    }
    else document.getElementById('ifYesc13').style.display = 'block';

}

</script>

<p>
<label for="q14">Q<?php $i++; echo $i; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label>
<select class="form-control" name="q14" onclick="javascript:yesnoCheckc14();">
  <option value="NA">Select...</option>
  <option value="More than sufficient">More than sufficient</option>
  <option value="Sufficient">Sufficient</option>
  <option value="Adaquate">Adequate</option>
  <option value="Poor" onclick="javascript:yesnoCheckc14a();" id="yesCheckc14">Poor</option>
</select>
</p>


<div id="ifYesc14" style="display:none">
<textarea class="form-control"id="c14" name="c14" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft15').text('500 characters left');
    $('#c14').keydown(function () {
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

function yesnoCheckc14() {
    if (document.getElementById('yesCheckc14').checked) {
        document.getElementById('ifYesc14').style.display = 'none';
    }
    else document.getElementById('ifYesc14').style.display = 'block';

}

</script>
<script type="text/javascript">

function yesnoCheckc14a() {
    if (document.getElementById('yesCheckc14').checked) {
        document.getElementById('ifYesc14').style.display = 'none';
    }
    else document.getElementById('ifYesc14').style.display = 'block';

}

</script>

<p>
<label for="q15">Q<?php $i++; echo $i; ?>. Closer confirmed this policy will be set up with Royal London?</label>
<input type="radio" name="q15" 
<?php if (isset($q15) && $q15=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc15();"
value="Yes" id="yesCheckc15">Yes
<input type="radio" name="q15"
<?php if (isset($q15) && $q15=="No") echo "checked";?> onclick="javascript:yesnoCheckc15();"
value="No" id="noCheckc15">No
</p>

<div id="ifYesc15" style="display:none">
<textarea class="form-control"id="c15" name="c15" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft16').text('500 characters left');
    $('#c15').keydown(function () {
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

function yesnoCheckc15() {
    if (document.getElementById('yesCheckc15').checked) {
        document.getElementById('ifYesc15').style.display = 'none';
    }
    else document.getElementById('ifYesc15').style.display = 'block';

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
<label for="q6">Q<?php $i++; echo $i; ?>. Were all clients titles and names recorded correctly?</label>
<input type="radio" name="q6" 
<?php if (isset($q6) && $q6=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc6();"
value="Yes" id="yesCheckc6">Yes
<input type="radio" name="q6"
<?php if (isset($q6) && $q6=="No") echo "checked";?> onclick="javascript:yesnoCheckc6();"
value="No" id="noCheckc6">No
</p>

<div id="ifYesc6" style="display:none">
<textarea class="form-control"id="c6" name="c6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#c6').keydown(function () {
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

function yesnoCheckc6() {
    if (document.getElementById('yesCheckc6').checked) {
        document.getElementById('ifYesc6').style.display = 'none';
    }
    else document.getElementById('ifYesc6').style.display = 'block';

}

</script>

<p>
<label for="q125">Q<?php $i++; echo $i; ?>. Was the clients marital status recorded correctly?</label>
<input type="radio" name="q125" 
<?php if (isset($q125) && $q125=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc125();"
value="Yes" id="yesCheckc125">Yes
<input type="radio" name="q125"
<?php if (isset($q125) && $q125=="No") echo "checked";?> onclick="javascript:yesnoCheckc125();"
value="No" id="noCheckc125">No
</p>

<div id="ifYesc125" style="display:none">
<textarea class="form-control"id="c125" name="c125" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#c125').keydown(function () {
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

function yesnoCheckc125() {
    if (document.getElementById('yesCheckc125').checked) {
        document.getElementById('ifYesc125').style.display = 'none';
    }
    else document.getElementById('ifYesc125').style.display = 'block';

}
</script>  

<p>
<label for="q126">Q<?php $i++; echo $i; ?>. Was the clients address recored correctly?</label>
<input type="radio" name="q126" 
<?php if (isset($q126) && $q126=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc126();"
value="Yes" id="yesCheckc126">Yes
<input type="radio" name="q126"
<?php if (isset($q126) && $q126=="No") echo "checked";?> onclick="javascript:yesnoCheckc126();"
value="No" id="noCheckc126">No
</p>

<div id="ifYesc126" style="display:none">
<textarea class="form-control"id="c126" name="c126" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#c126').keydown(function () {
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

function yesnoCheckc126() {
    if (document.getElementById('yesCheckc126').checked) {
        document.getElementById('ifYesc126').style.display = 'none';
    }
    else document.getElementById('ifYesc126').style.display = 'block';

}
</script>  

<p>
<label for="q127">Q<?php $i++; echo $i; ?>. Was clients phone number(s) recorded correctly?</label>
<input type="radio" name="q127" 
<?php if (isset($q127) && $q127=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc127();"
value="Yes" id="yesCheckc127">Yes
<input type="radio" name="q127"
<?php if (isset($q127) && $q127=="No") echo "checked";?> onclick="javascript:yesnoCheckc127();"
value="No" id="noCheckc127">No
</p>

<div id="ifYesc127" style="display:none">
<textarea class="form-control"id="c127" name="c127" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#c127').keydown(function () {
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

function yesnoCheckc127() {
    if (document.getElementById('yesCheckc127').checked) {
        document.getElementById('ifYesc127').style.display = 'none';
    }
    else document.getElementById('ifYesc127').style.display = 'block';

}
</script>

<p>
<label for="q128">Q<?php $i++; echo $i; ?>. Was the clients email address recorded correctly?</label>
<input type="radio" name="q128" 
<?php if (isset($q128) && $q128=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc128();"
value="Yes" id="yesCheckc128">Yes
<input type="radio" name="q128"
<?php if (isset($q128) && $q128=="No") echo "checked";?> onclick="javascript:yesnoCheckc128();"
value="No" id="noCheckc128">No
</p>

<div id="ifYesc128" style="display:none">
<textarea class="form-control"id="c128" name="c128" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('500 characters left');
    $('#c128').keydown(function () {
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

function yesnoCheckc128() {
    if (document.getElementById('yesCheckc128').checked) {
        document.getElementById('ifYesc128').style.display = 'none';
    }
    else document.getElementById('ifYesc128').style.display = 'block';

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
<label for="q115">Q<?php $i++; echo $i; ?>. Confirmed that we comply with the Data Protection Act, and are happy for their personal to be passed over the phone?</label>
<input type="radio" name="q115" 
<?php if (isset($q115) && $q115=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc115();"
value="Yes" id="yesCheckc115">Yes
<input type="radio" name="q115"
<?php if (isset($q115) && $q115=="No") echo "checked";?> onclick="javascript:yesnoCheckc115();"
value="No" id="noCheckc115">No
</p>

<div id="ifYesc115" style="display:none">
<textarea class="form-control"id="c115" name="c115" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#c115').keydown(function () {
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

function yesnoCheckc115() {
    if (document.getElementById('yesCheckc115').checked) {
        document.getElementById('ifYesc115').style.display = 'none';
    }
    else document.getElementById('ifYesc115').style.display = 'block';

}

</script>        
           
<p>
<label for="q30">Q<?php $i++; echo $i; ?>. The impact of misrepresentation declaration read out?</label>
<input type="radio" name="q30" 
<?php if (isset($q30) && $q30=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc30();"
value="Yes" id="yesCheckc30">Yes
<input type="radio" name="q30"
<?php if (isset($q30) && $q30=="No") echo "checked";?> onclick="javascript:yesnoCheckc30();"
value="No" id="noCheckc30">No
</p>

<div id="ifYesc30" style="display:none">
<textarea class="form-control"id="c30" name="c30" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#c30').keydown(function () {
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

function yesnoCheckc30() {
    if (document.getElementById('yesCheckc30').checked) {
        document.getElementById('ifYesc30').style.display = 'none';
    }
    else document.getElementById('ifYesc30').style.display = 'block';

}

</script>

<p>
<label for="q54">Q<?php $i++; echo $i; ?>. If appropriate did the closer confirm the exclusions on the policy?</label>
<input type="radio" name="q54" 
<?php if (isset($q54) && $q54=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc54();"
value="Yes" id="yesCheckc54">Yes
<input type="radio" name="q54"
<?php if (isset($q54) && $q54=="No") echo "checked";?> onclick="javascript:yesnoCheckc54();"
value="No" id="noCheckc54">No
<input type="radio" name="q54" 
<?php if (isset($q54) && $q54=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesc54" style="display:none">
<textarea class="form-control"id="c54" name="c54" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c54').keydown(function () {
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

function yesnoCheckc54() {
    if (document.getElementById('yesCheckc54').checked) {
        document.getElementById('ifYesc54').style.display = 'none';
    }
    else document.getElementById('ifYesc54').style.display = 'block';

}

</script>

<p>
<label for="q129">Q<?php $i++; echo $i; ?>. Client informed that Royal London may request a copy of their medical reports up to six months after the cover has started?</label>
<input type="radio" name="q129" 
<?php if (isset($q129) && $q129=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc129();"
value="Yes" id="yesCheckc129">Yes
<input type="radio" name="q129"
<?php if (isset($q129) && $q129=="No") echo "checked";?> onclick="javascript:yesnoCheckc129();"
value="No" id="noCheckc129">No
<input type="radio" name="q129" 
<?php if (isset($q129) && $q129=="N/A") echo "checked";?>
value="N/A" >N/A
</p>

<div id="ifYesc129" style="display:none">
<textarea class="form-control"id="c129" name="c129" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c129').keydown(function () {
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

function yesnoCheckc129() {
    if (document.getElementById('yesCheckc129').checked) {
        document.getElementById('ifYesc129').style.display = 'none';
    }
    else document.getElementById('ifYesc129').style.display = 'block';

}
</script>

<p>
<label for="q130">Q<?php $i++; echo $i; ?>. Did the closer ask the client to read out the Access to Medical Reports Act 1988 (or to send a copy)?</label>
<input type="radio" name="q130" <?php if (isset($q130) && $q130=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc130();" value="Yes" id="yesCheckc130">Yes
<input type="radio" name="q130" <?php if (isset($q130) && $q130=="No") echo "checked";?> onclick="javascript:yesnoCheckc130();" value="No" id="noCheckc130">No
</p>

<div id="ifYesc130" style="display:none">
<textarea class="form-control"id="c130" name="c130" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c130').keydown(function () {
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

function yesnoCheckc130() {
    if (document.getElementById('yesCheckc130').checked) {
        document.getElementById('ifYesc130').style.display = 'none';
    }
    else document.getElementById('ifYesc130').style.display = 'block';

}
</script>

<p>
<label for="q131">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had any existing plans or an application with Royal London?</label>
<input type="radio" name="q131" <?php if (isset($q131) && $q131=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc131();" value="Yes" id="yesCheckc131">Yes
<input type="radio" name="q131" <?php if (isset($q131) && $q131=="No") echo "checked";?> onclick="javascript:yesnoCheckc131();" value="No" id="noCheckc131">No
</p>

<div id="ifYesc131" style="display:none">
<textarea class="form-control"id="c131" name="c131" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c131').keydown(function () {
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

function yesnoCheckc131() {
    if (document.getElementById('yesCheckc131').checked) {
        document.getElementById('ifYesc131').style.display = 'none';
    }
    else document.getElementById('ifYesc131').style.display = 'block';

}
</script>

<p>
<label for="q132">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had an application on your life deferred or declined?</label>
<input type="radio" name="q132" <?php if (isset($q132) && $q132=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc132();" value="Yes" id="yesCheckc132">Yes
<input type="radio" name="q132" <?php if (isset($q132) && $q132=="No") echo "checked";?> onclick="javascript:yesnoCheckc132();" value="No" id="noCheckc132">No
</p>

<div id="ifYesc132" style="display:none">
<textarea class="form-control"id="c132" name="c132" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c132').keydown(function () {
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

function yesnoCheckc132() {
    if (document.getElementById('yesCheckc132').checked) {
        document.getElementById('ifYesc132').style.display = 'none';
    }
    else document.getElementById('ifYesc132').style.display = 'block';

}
</script>

<p>
<label for="q133">Q<?php $i++; echo $i; ?>. Did the closer ask the client if the total amount of cover that they have applied for, added to the amount that they already have, across all insurance companies exceed £1,000,000 life cover or £500,000 CIC?</label>
<input type="radio" name="q133" <?php if (isset($q133) && $q133=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc133();" value="Yes" id="yesCheckc133">Yes
<input type="radio" name="q133" <?php if (isset($q133) && $q133=="No") echo "checked";?> onclick="javascript:yesnoCheckc133();" value="No" id="noCheckc133">No
</p>

<div id="ifYesc133" style="display:none">
<textarea class="form-control"id="c133" name="c133" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft35').text('500 characters left');
    $('#c133').keydown(function () {
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

function yesnoCheckc133() {
    if (document.getElementById('yesCheckc133').checked) {
        document.getElementById('ifYesc133').style.display = 'none';
    }
    else document.getElementById('ifYesc133').style.display = 'block';

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
<label for="q20">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the height and weight details correctly?</label>
<input type="radio" name="q20" 
<?php if (isset($q20) && $q20=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc20();"
value="Yes" id="yesCheckc20">Yes
<input type="radio" name="q20"
<?php if (isset($q20) && $q20=="No") echo "checked";?> onclick="javascript:yesnoCheckc20();"
value="No" id="noCheckc20">No
</p>

<div id="ifYesc20" style="display:none">
<textarea class="form-control"id="c20" name="c20" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft23" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft23').text('500 characters left');
    $('#c20').keydown(function () {
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

function yesnoCheckc20() {
    if (document.getElementById('yesCheckc20').checked) {
        document.getElementById('ifYesc20').style.display = 'none';
    }
    else document.getElementById('ifYesc20').style.display = 'block';

}

</script>


<p>
<label for="q116">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the clients clothe measurements?</label>
<input type="radio" name="q116" 
<?php if (isset($q116) && $q116=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc20();"
value="Yes" id="yesCheckc20">Yes
<input type="radio" name="q116"
<?php if (isset($q116) && $q116=="No") echo "checked";?> onclick="javascript:yesnoCheckc20();"
value="No" id="noCheckc20">No
</p>

<div id="ifYesc20" style="display:none">
<textarea class="form-control"id="c20" name="c20" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft23" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft23').text('500 characters left');
    $('#c20').keydown(function () {
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

function yesnoCheckc20() {
    if (document.getElementById('yesCheckc20').checked) {
        document.getElementById('ifYesc20').style.display = 'none';
    }
    else document.getElementById('ifYesc20').style.display = 'block';

}

</script>

<p>
<label for="q21">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the smoking details correctly?</label>
<input type="radio" name="q21" 
<?php if (isset($q21) && $q21=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc21();"
value="Yes" id="yesCheckc21">Yes
<input type="radio" name="q21"
<?php if (isset($q21) && $q21=="No") echo "checked";?> onclick="javascript:yesnoCheckc21();"
value="No" id="noCheckc21">No
</p>

<div id="ifYesc21" style="display:none">
<textarea class="form-control"id="c21" name="c21" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft24" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft24').text('500 characters left');
    $('#c21').keydown(function () {
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

function yesnoCheckc21() {
    if (document.getElementById('yesCheckc21').checked) {
        document.getElementById('ifYesc21').style.display = 'none';
    }
    else document.getElementById('ifYesc21').style.display = 'block';

}

</script>

<p>
<label for="q23">Q<?php $i++; echo $i; ?>. Was the client asked how many units of alcohol they drink in a week?</label>
<input type="radio" name="q23" 
<?php if (isset($q23) && $q23=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc23();"
value="Yes" id="yesCheckc23">Yes
<input type="radio" name="q23"
<?php if (isset($q23) && $q23=="No") echo "checked";?> onclick="javascript:yesnoCheckc23();"
value="No" id="noCheckc23">No
</p>

<div id="ifYesc23" style="display:none">
<textarea class="form-control"id="c23" name="c23" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c23').keydown(function () {
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

function yesnoCheckc23() {
    if (document.getElementById('yesCheckc23').checked) {
        document.getElementById('ifYesc23').style.display = 'none';
    }
    else document.getElementById('ifYesc23').style.display = 'block';

}

</script>

<p>
<label for="q117">Q<?php $i++; echo $i; ?>. Did the closer ask if they have been disqualified from driving in the last 5 years?</label>
<input type="radio" name="q117" 
<?php if (isset($q117) && $q117=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc117();"
value="Yes" id="yesCheckc117">Yes
<input type="radio" name="q117"
<?php if (isset($q117) && $q117=="No") echo "checked";?> onclick="javascript:yesnoCheckc117();"
value="No" id="noCheckc117">No
</p>

<div id="ifYesc117" style="display:none">
<textarea class="form-control"id="c117" name="c117" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c117').keydown(function () {
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

function yesnoCheckc117() {
    if (document.getElementById('yesCheckc117').checked) {
        document.getElementById('ifYesc117').style.display = 'none';
    }
    else document.getElementById('ifYesc117').style.display = 'block';

}

</script>

<p>
<label for="q118">Q<?php $i++; echo $i; ?>. Did the closer ask if the client has used recreational drugs in the last 10 years?</label>
<input type="radio" name="q118" 
<?php if (isset($q118) && $q118=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc118();"
value="Yes" id="yesCheckc118">Yes
<input type="radio" name="q118"
<?php if (isset($q118) && $q118=="No") echo "checked";?> onclick="javascript:yesnoCheckc118();"
value="No" id="noCheckc118">No
</p>

<div id="ifYesc118" style="display:none">
<textarea class="form-control"id="c118" name="c118" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c118').keydown(function () {
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

function yesnoCheckc118() {
    if (document.getElementById('yesCheckc118').checked) {
        document.getElementById('ifYesc118').style.display = 'none';
    }
    else document.getElementById('ifYesc118').style.display = 'block';

}

</script>

<p>
<label for="q119">Q<?php $i++; echo $i; ?>. Did the closer check if the client had undertaken any of the listed activities?</label>
<input type="radio" name="q119" 
<?php if (isset($q119) && $q119=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc119();"
value="Yes" id="yesCheckc119">Yes
<input type="radio" name="q119"
<?php if (isset($q119) && $q119=="No") echo "checked";?> onclick="javascript:yesnoCheckc119();"
value="No" id="noCheckc119">No
</p>

<div id="ifYesc119" style="display:none">
<textarea class="form-control"id="c119" name="c119" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c119').keydown(function () {
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

function yesnoCheckc119() {
    if (document.getElementById('yesCheckc119').checked) {
        document.getElementById('ifYesc119').style.display = 'none';
    }
    else document.getElementById('ifYesc119').style.display = 'block';

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
<label for="q120">Q<?php $i++; echo $i; ?>. Was the client asked if their job involves manual work or driving?</label>
<input type="radio" name="q120" 
<?php if (isset($q120) && $q120=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc120();"
value="Yes" id="yesCheckc120">Yes
<input type="radio" name="q120"
<?php if (isset($q120) && $q120=="No") echo "checked";?> onclick="javascript:yesnoCheckc120();"
value="No" id="noCheckc120">No
</p>

<div id="ifYesc120" style="display:none">
<textarea class="form-control"id="c120" name="c120" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft34').text('500 characters left');
    $('#c120').keydown(function () {
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

function yesnoCheckc120() {
    if (document.getElementById('yesCheckc120').checked) {
        document.getElementById('ifYesc120').style.display = 'none';
    }
    else document.getElementById('ifYesc120').style.display = 'block';

}

</script>  

<p>
<label for="q121">Q<?php $i++; echo $i; ?>. Was the client asked if they undertake in any of the listed hazardous activities?</label>
<input type="radio" name="q121" 
<?php if (isset($q121) && $q121=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc121();"
value="Yes" id="yesCheckc121">Yes
<input type="radio" name="q121"
<?php if (isset($q121) && $q121=="No") echo "checked";?> onclick="javascript:yesnoCheckc121();"
value="No" id="noCheckc121">No
</p>

<div id="ifYesc121" style="display:none">
<textarea class="form-control"id="c121" name="c121" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c121').keydown(function () {
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

function yesnoCheckc121() {
    if (document.getElementById('yesCheckc121').checked) {
        document.getElementById('ifYesc121').style.display = 'none';
    }
    else document.getElementById('ifYesc121').style.display = 'block';

}

</script>

<p>
<label for="q122">Q<?php $i++; echo $i; ?>. Was the client asked if they have worked/travelled out the listed countries (in the last 2 years, or do they intend to)?</label>
<input type="radio" name="q122" 
<?php if (isset($q122) && $q122=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc122();"
value="Yes" id="yesCheckc122">Yes
<input type="radio" name="q122"
<?php if (isset($q122) && $q122=="No") echo "checked";?> onclick="javascript:yesnoCheckc122();"
value="No" id="noCheckc122">No
</p>

<div id="ifYesc122" style="display:none">
<textarea class="form-control"id="c122" name="c122" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft26" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft26').text('500 characters left');
    $('#c122').keydown(function () {
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

function yesnoCheckc122() {
    if (document.getElementById('yesCheckc122').checked) {
        document.getElementById('ifYesc122').style.display = 'none';
    }
    else document.getElementById('ifYesc122').style.display = 'block';

}

</script>
        
    </div>
</div>        
   
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Health Questions</h3>
        </div>
        <div class="panel-body">
           
<p>
<label for="q24">Q<?php $i++; echo $i; ?>. Was the client asked if they have ever had any health problems?</label>
<input type="radio" name="q24" 
<?php if (isset($q24) && $q24=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc24();"
value="Yes" id="yesCheckc24">Yes
<input type="radio" name="q24"
<?php if (isset($q24) && $q24=="No") echo "checked";?> onclick="javascript:yesnoCheckc24();"
value="No" id="noCheckc24">No
</p>

<div id="ifYesc24" style="display:none">
<textarea class="form-control"id="c24" name="c24" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft27" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft27').text('2500 characters left');
    $('#c24').keydown(function () {
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

function yesnoCheckc24() {
    if (document.getElementById('yesCheckc24').checked) {
        document.getElementById('ifYesc24').style.display = 'none';
    }
    else document.getElementById('ifYesc24').style.display = 'block';

}

</script>

<p>
<label for="q25">Q<?php $i++; echo $i; ?>. Were all health in the last 5 years questions asked and recorded correctly?</label>
<input type="radio" name="q25" 
<?php if (isset($q25) && $q25=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc25();"
value="Yes" id="yesCheckc25">Yes
<input type="radio" name="q25"
<?php if (isset($q25) && $q25=="No") echo "checked";?> onclick="javascript:yesnoCheckc25();"
value="No" id="noCheckc25">No
</p>

<div id="ifYesc25" style="display:none">
<textarea class="form-control"id="c25" name="c25" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft28" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft28').text('2500 characters left');
    $('#c25').keydown(function () {
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

function yesnoCheckc25() {
    if (document.getElementById('yesCheckc25').checked) {
        document.getElementById('ifYesc25').style.display = 'none';
    }
    else document.getElementById('ifYesc25').style.display = 'block';

}

</script>

<p>
<label for="q26">Q<?php $i++; echo $i; ?>. Were all health in the last 3 years questions asked and recorded correctly?</label>
<input type="radio" name="q26" 
<?php if (isset($q26) && $q26=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc26();"
value="Yes" id="yesCheckc26">Yes
<input type="radio" name="q26"
<?php if (isset($q26) && $q26=="No") echo "checked";?> onclick="javascript:yesnoCheckc26();"
value="No" id="noCheckc26">No
</p>

<div id="ifYesc26" style="display:none">
<textarea class="form-control"id="c26" name="c26" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft29" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft29').text('2500 characters left');
    $('#c26').keydown(function () {
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

function yesnoCheckc26() {
    if (document.getElementById('yesCheckc26').checked) {
        document.getElementById('ifYesc26').style.display = 'none';
    }
    else document.getElementById('ifYesc26').style.display = 'block';

}

</script>

<p>
<label for="q27">Q<?php $i++; echo $i; ?>. Was the client asked if their family have any medical history?</label>
<input type="radio" name="q27" 
<?php if (isset($q27) && $q27=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc27();"
value="Yes" id="yesCheckc27">Yes
<input type="radio" name="q27"
<?php if (isset($q27) && $q27=="No") echo "checked";?> onclick="javascript:yesnoCheckc27();"
value="No" id="noCheckc27">No
</p>

<div id="ifYesc27" style="display:none">
<textarea class="form-control"id="c27" name="c27" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#c27').keydown(function () {
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

function yesnoCheckc27() {
    if (document.getElementById('yesCheckc27').checked) {
        document.getElementById('ifYesc27').style.display = 'none';
    }
    else document.getElementById('ifYesc27').style.display = 'block';

}

</script>    

<p>
<label for="q124">Q<?php $i++; echo $i; ?>. If appropriate, did the closer confirm any exclusions on the policy?</label>
<input type="radio" name="q124" 
<?php if (isset($q124) && $q124=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc124();"
value="Yes" id="yesCheckc124">Yes
<input type="radio" name="q124"
<?php if (isset($q124) && $q124=="No") echo "checked";?> onclick="javascript:yesnoCheckc124();"
value="No" id="noCheckc124">No
</p>

<div id="ifYesc124" style="display:none">
<textarea class="form-control"id="c124" name="c124" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#c124').keydown(function () {
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

function yesnoCheckc124() {
    if (document.getElementById('yesCheckc124').checked) {
        document.getElementById('ifYesc124').style.display = 'none';
    }
    else document.getElementById('ifYesc124').style.display = 'block';

}

</script>  

<p>
<label for="q123">Q<?php $i++; echo $i; ?>. Were all of the health questions recorded correctly?</label>
<input type="radio" name="q123" 
<?php if (isset($q123) && $q123=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc123();"
value="Yes" id="yesCheckc123">Yes
<input type="radio" name="q123"
<?php if (isset($q123) && $q123=="No") echo "checked";?> onclick="javascript:yesnoCheckc123();"
value="No" id="noCheckc123">No
</p>

<div id="ifYesc123" style="display:none">
<textarea class="form-control"id="c123" name="c123" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft30').text('2500 characters left');
    $('#c123').keydown(function () {
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

function yesnoCheckc123() {
    if (document.getElementById('yesCheckc123').checked) {
        document.getElementById('ifYesc123').style.display = 'none';
    }
    else document.getElementById('ifYesc123').style.display = 'block';

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
<label for="q55">Q<?php $i++; echo $i; ?>. Important customer information declaration?</label>
<input type="radio" name="q55" 
<?php if (isset($q55) && $q55=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc55();"
value="Yes" id="yesCheckc55">Yes
<input type="radio" name="q55"
<?php if (isset($q55) && $q55=="No") echo "checked";?> onclick="javascript:yesnoCheckc55();"
value="No" id="noCheckc55">No
</p>

<div id="ifYesc55" style="display:none">
<textarea class="form-control"id="c55" name="c55" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft19" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft19').text('500 characters left');
    $('#c55').keydown(function () {
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

function yesnoCheckc55() {
    if (document.getElementById('yesCheckc55').checked) {
        document.getElementById('ifYesc55').style.display = 'none';
    }
    else document.getElementById('ifYesc55').style.display = 'block';

}

</script>

<p>
<label for="q17">Q<?php $i++; echo $i; ?>. Were all clients contact details recorded correctly?</label>
<input type="radio" name="q17" 
<?php if (isset($q17) && $q17=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc17();"
value="Yes" id="yesCheckc17">Yes
<input type="radio" name="q17"
<?php if (isset($q17) && $q17=="No") echo "checked";?> onclick="javascript:yesnoCheckc17();"
value="No" id="noCheckc17">No
</p>

<div id="ifYesc17" style="display:none">
<textarea class="form-control"id="c17" name="c17" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft18" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft18').text('500 characters left');
    $('#c17').keydown(function () {
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

function yesnoCheckc17() {
    if (document.getElementById('yesCheckc17').checked) {
        document.getElementById('ifYesc17').style.display = 'none';
    }
    else document.getElementById('ifYesc17').style.display = 'block';

}

</script>

<p>
<label for="q16">Q<?php $i++; echo $i; ?>. Were all clients address details recorded correctly?</label>
<input type="radio" name="q16" 
<?php if (isset($q16) && $q15=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc16();"
value="Yes" id="yesCheckc16">Yes
<input type="radio" name="q16"
<?php if (isset($q16) && $q16=="No") echo "checked";?> onclick="javascript:yesnoCheckc16();"
value="No" id="noCheckc16">No
</p>

<div id="ifYesc16" style="display:none">
<textarea class="form-control"id="c16" name="c16" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft17" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft17').text('500 characters left');
    $('#c16').keydown(function () {
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

function yesnoCheckc16() {
    if (document.getElementById('yesCheckc16').checked) {
        document.getElementById('ifYesc16').style.display = 'none';
    }
    else document.getElementById('ifYesc16').style.display = 'block';

}

</script>

<p>
<label for="q18">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label>
<input type="radio" name="q18" 
<?php if (isset($q18) && $q18=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc18();"
value="Yes" id="yesCheckc18">Yes
<input type="radio" name="q18"
<?php if (isset($q18) && $q18=="No") echo "checked";?> onclick="javascript:yesnoCheckc18();"
value="No" id="noCheckc18">No
</p>

<div id="ifYesc18" style="display:none">
<textarea class="form-control"id="c18" name="c18" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft21" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft21').text('500 characters left');
    $('#c18').keydown(function () {
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

function yesnoCheckc18() {
    if (document.getElementById('yesCheckc18').checked) {
        document.getElementById('ifYesc18').style.display = 'none';
    }
    else document.getElementById('ifYesc18').style.display = 'block';

}

</script>

<p>
<label for="q28">Q<?php $i++; echo $i; ?>. Were all family history questions asked and recorded correctly?</label>
<input type="radio" name="q28" 
<?php if (isset($q28) && $q28=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc28();"
value="Yes" id="yesCheckc28">Yes
<input type="radio" name="q28"
<?php if (isset($q28) && $q28=="No") echo "checked";?> onclick="javascript:yesnoCheckc28();"
value="No" id="noCheckc28">No
</p>

<div id="ifYesc28" style="display:none">
<textarea class="form-control"id="c28" name="c28" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft31" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft31').text('500 characters left');
    $('#c28').keydown(function () {
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

function yesnoCheckc28() {
    if (document.getElementById('yesCheckc28').checked) {
        document.getElementById('ifYesc28').style.display = 'none';
    }
    else document.getElementById('ifYesc28').style.display = 'block';

}

</script>

<p>
<label for="q29">Q<?php $i++; echo $i; ?>. Were term for term details recorded correctly?</label>
<select class="form-control" name="q29" >
  <option value="NA">Select...</option>
  <option value="Client provided details">Client Provided Details</option>
  <option value="Client failed to provide details">Client failed to provide details</option>
  <option value="Not existing Royal London customer">Not existing Royal London customer</option>
  <option value="Obtained from Term4Term service">Obtained from Term4Term service</option>
  <option value="Existing Royal London Policy, no attempt to get policy number">Existing Royal London Policy, no attempt to get policy number</option>
</select>
</p>

<textarea class="form-control"id="c29" name="c29" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft32" class="help-block ">You have reached the limit</p></span>
<script>
$(document).ready(function(){ 
    $('#characterLeft32').text('500 characters left');
    $('#c29').keydown(function () {
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
<label for="q32">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label>
<input type="radio" name="q32" 
<?php if (isset($q32) && $q32=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc32();"
value="Yes" id="yesCheckc32">Yes
<input type="radio" name="q32"
<?php if (isset($q32) && $q32=="No") echo "checked";?> onclick="javascript:yesnoCheckc32();"
value="No" id="noCheckc32">No
</p>

<div id="ifYesc32" style="display:none">
<textarea class="form-control"id="c32" name="c32" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft36').text('500 characters left');
    $('#c32').keydown(function () {
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

function yesnoCheckc32() {
    if (document.getElementById('yesCheckc32').checked) {
        document.getElementById('ifYesc32').style.display = 'none';
    }
    else document.getElementById('ifYesc32').style.display = 'block';

}

</script>

<p>
<label for="q33">Q<?php $i++; echo $i; ?>. Did the closer offer to read the direct debit guarantee?</label>
<input type="radio" name="q33" 
<?php if (isset($q33) && $q33=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc33();"
value="Yes" id="yesCheckc33">Yes
<input type="radio" name="q33"
<?php if (isset($q33) && $q33=="No") echo "checked";?> onclick="javascript:yesnoCheckc33();"
value="No" id="noCheckc33">No
</p>

<div id="ifYesc33" style="display:none">
<textarea class="form-control"id="c33" name="c33" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft37').text('500 characters left');
    $('#c33').keydown(function () {
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

function yesnoCheckc33() {
    if (document.getElementById('yesCheckc33').checked) {
        document.getElementById('ifYesc33').style.display = 'none';
    }
    else document.getElementById('ifYesc33').style.display = 'block';

}

</script>

<p>
<label for="q34">Q<?php $i++; echo $i; ?>. Did the closer offer a preferred premium collection date?</label>
<input type="radio" name="q34" 
<?php if (isset($q34) && $q34=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc34();"
value="Yes" id="yesCheckc34">Yes
<input type="radio" name="q34"
<?php if (isset($q34) && $q34=="No") echo "checked";?> onclick="javascript:yesnoCheckc34();"
value="No" id="noCheckc34">No
</p>

<div id="ifYesc34" style="display:none">
<textarea class="form-control"id="c34" name="c34" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft38').text('500 characters left');
    $('#c34').keydown(function () {
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

function yesnoCheckc34() {
    if (document.getElementById('yesCheckc34').checked) {
        document.getElementById('ifYesc34').style.display = 'none';
    }
    else document.getElementById('ifYesc34').style.display = 'block';

}

</script>

<p>
<label for="q35">Q<?php $i++; echo $i; ?>. Did the closer record the bank details correctly?</label>
<input type="radio" name="q35" 
<?php if (isset($q35) && $q35=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc35();"
value="Yes" id="yesCheckc35">Yes
<input type="radio" name="q35"
<?php if (isset($q35) && $q35=="No") echo "checked";?> onclick="javascript:yesnoCheckc35();"
value="No" id="noCheckc35">No
</p>

<div id="ifYesc35" style="display:none">
<textarea class="form-control"id="c35" name="c35" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft39').text('500 characters left');
    $('#c35').keydown(function () {
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

function yesnoCheckc35() {
    if (document.getElementById('yesCheckc35').checked) {
        document.getElementById('ifYesc35').style.display = 'none';
    }
    else document.getElementById('ifYesc35').style.display = 'block';

}

</script>

<p>
<label for="q36">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label>
<input type="radio" name="q36" 
<?php if (isset($q36) && $q36=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc36();"
value="Yes" id="yesCheckc36">Yes
<input type="radio" name="q36"
<?php if (isset($q36) && $q36=="No") echo "checked";?> onclick="javascript:yesnoCheckc36();"
value="No" id="noCheckc36">No
</p>

<div id="ifYesc36" style="display:none">
<textarea class="form-control"id="c36" name="c36" rows="1" cols="75" maxlength="1500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft40').text('500 characters left');
    $('#c36').keydown(function () {
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

function yesnoCheckc36() {
    if (document.getElementById('yesCheckc36').checked) {
        document.getElementById('ifYesc36').style.display = 'none';
    }
    else document.getElementById('ifYesc36').style.display = 'block';

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
<label for="q38">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
<input type="radio" name="q38" 
<?php if (isset($q38) && $q38=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc38();"
value="Yes" id="yesCheckc38">Yes
<input type="radio" name="q38"
<?php if (isset($q38) && $q38=="No") echo "checked";?> onclick="javascript:yesnoCheckc38();"
value="No" id="noCheckc38">No
</p>

<div id="ifYesc38" style="display:none">
<textarea class="form-control"id="c38" name="c38" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft41').text('500 characters left');
    $('#c38').keydown(function () {
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

function yesnoCheckc38() {
    if (document.getElementById('yesCheckc38').checked) {
        document.getElementById('ifYesc38').style.display = 'none';
    }
    else document.getElementById('ifYesc38').style.display = 'block';

}

</script>


<p>
<label for="q39">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
<input type="radio" name="q39" 
<?php if (isset($q39) && $q39=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc39();"
value="Yes" id="yesCheckc39">Yes
<input type="radio" name="q39"
<?php if (isset($q39) && $q39=="No") echo "checked";?> onclick="javascript:yesnoCheckc39();"
value="No" id="noCheckc39">No
</p>

<div id="ifYesc39" style="display:none">
<textarea class="form-control"id="c39" name="c39" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft42').text('500 characters left');
    $('#c39').keydown(function () {
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

function yesnoCheckc39() {
    if (document.getElementById('yesCheckc39').checked) {
        document.getElementById('ifYesc39').style.display = 'none';
    }
    else document.getElementById('ifYesc39').style.display = 'block';

}

</script>



<p>
<label for="q40">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
<input type="radio" name="q40" 
<?php if (isset($q40) && $q40=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc40();"
value="Yes" id="yesCheckc40">Yes
<input type="radio" name="q40"
<?php if (isset($q40) && $q40=="No") echo "checked";?> onclick="javascript:yesnoCheckc40();"
value="No" id="noCheckc40">No
</p>

<div id="ifYesc40" style="display:none">
<textarea class="form-control"id="c40" name="c40" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft43" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft43').text('500 characters left');
    $('#c40').keydown(function () {
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

function yesnoCheckc40() {
    if (document.getElementById('yesCheckc40').checked) {
        document.getElementById('ifYesc40').style.display = 'none';
    }
    else document.getElementById('ifYesc40').style.display = 'block';

}

</script>

<p>
<label for="q41">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
<input type="radio" name="q41" 
<?php if (isset($q41) && $q41=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc41();"
value="Yes" id="yesCheckc41">Yes
<input type="radio" name="q41"
<?php if (isset($q41) && $q41=="No") echo "checked";?> onclick="javascript:yesnoCheckc41();"
value="No" id="noCheckc41">No
</p>

<div id="ifYesc41" style="display:none">
<textarea class="form-control"id="c41" name="c41" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft44" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft44').text('500 characters left');
    $('#c41').keydown(function () {
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

function yesnoCheckc41() {
    if (document.getElementById('yesCheckc41').checked) {
        document.getElementById('ifYesc41').style.display = 'none';
    }
    else document.getElementById('ifYesc41').style.display = 'block';

}

</script>

<p>
<label for="q42">Q<?php $i++; echo $i; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Royal London?</label>
<input type="radio" name="q42" 
<?php if (isset($q42) && $q42=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc42();"
value="Yes" id="yesCheckc42">Yes
<input type="radio" name="q42"
<?php if (isset($q42) && $q42=="No") echo "checked";?> onclick="javascript:yesnoCheckc42();"
value="No" id="noCheckc42">No
</p>

<div id="ifYesc42" style="display:none">
<textarea class="form-control"id="c42" name="c42" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft45" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft45').text('500 characters left');
    $('#c42').keydown(function () {
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

function yesnoCheckc42() {
    if (document.getElementById('yesCheckc42').checked) {
        document.getElementById('ifYesc42').style.display = 'none';
    }
    else document.getElementById('ifYesc42').style.display = 'block';

}

</script>

<p>
<label for="q43">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label>
<input type="radio" name="q43" 
<?php if (isset($q43) && $q43=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc43();"
value="Yes" id="yesCheckc43">Yes
<input type="radio" name="q43"
<?php if (isset($q43) && $q43=="No") echo "checked";?> onclick="javascript:yesnoCheckc43();"
value="No" id="noCheckc43">No
</p>

<div id="ifYesc43" style="display:none">
<textarea class="form-control"id="c43" name="c43" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft46" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft46').text('500 characters left');
    $('#c43').keydown(function () {
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

function yesnoCheckc43() {
    if (document.getElementById('yesCheckc43').checked) {
        document.getElementById('ifYesc43').style.display = 'none';
    }
    else document.getElementById('ifYesc43').style.display = 'block';

}

</script>

<p>
<label for="q44">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Royal London will write to them with a more specific date?</label>
<input type="radio" name="q44" 
<?php if (isset($q44) && $q44=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc44();"
value="Yes" id="yesCheckc44">Yes
<input type="radio" name="q44"
<?php if (isset($q44) && $q44=="No") echo "checked";?> onclick="javascript:yesnoCheckc44();"
value="No" id="noCheckc44">No

</p>

<div id="ifYesc44" style="display:none">
<textarea class="form-control"id="c44" name="c44" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft47" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft47').text('500 characters left');
    $('#c44').keydown(function () {
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

function yesnoCheckc44() {
    if (document.getElementById('yesCheckc44').checked) {
        document.getElementById('ifYesc44').style.display = 'none';
    }
    else document.getElementById('ifYesc44').style.display = 'block';

}

</script>

<p>
<label for="q45">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label>
<input type="radio" name="q45" 
<?php if (isset($q45) && $q45=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc45();"
value="Yes" id="yesCheckc45">Yes
<input type="radio" name="q45"
<?php if (isset($q45) && $q45=="No") echo "checked";?> onclick="javascript:yesnoCheckc45();"
value="No" id="noCheckc45">No
<input type="radio" name="q45" 
<?php if (isset($q45) && $q45=="N/A") echo "checked";?> onclick="javascript:yesnoCheckc45();"
value="N/A" id="yesCheckc45">N/A
</p>

<div id="ifYesc45" style="display:none">
<textarea class="form-control"id="c45" name="c45" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft48" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft48').text('500 characters left');
    $('#c45').keydown(function () {
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

function yesnoCheckc45() {
    if (document.getElementById('yesCheckc45').checked) {
        document.getElementById('ifYesc45').style.display = 'none';
    }
    else document.getElementById('ifYesc45').style.display = 'block';

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
<label for="q46">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Royal London with client information?</label>
<input type="radio" name="q46" 
<?php if (isset($q46) && $q46=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc46();"
value="Yes" id="yesCheckc46">Yes
<input type="radio" name="q46"
<?php if (isset($q46) && $q46=="No") echo "checked";?> onclick="javascript:yesnoCheckc46();"
value="No" id="noCheckc46">No
</p>

<div id="ifYesc46" style="display:none">
<textarea class="form-control"id="c46" name="c46" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft49" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft49').text('500 characters left');
    $('#c46').keydown(function () {
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

function yesnoCheckc46() {
    if (document.getElementById('yesCheckc46').checked) {
        document.getElementById('ifYesc46').style.display = 'none';
    }
    else document.getElementById('ifYesc46').style.display = 'block';

}

</script>

<p>
<label for="q47">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label>
<input type="radio" name="q47" 
<?php if (isset($q47) && $q47=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc47();"
value="Yes" id="yesCheckc47">Yes
<input type="radio" name="q47"
<?php if (isset($q47) && $q47=="No") echo "checked";?> onclick="javascript:yesnoCheckc47();"
value="No" id="noCheckc47">No
</p>

<div id="ifYesc47" style="display:none">
<textarea class="form-control"id="c47" name="c47" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft50" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft50').text('500 characters left');
    $('#c47').keydown(function () {
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

function yesnoCheckc47() {
    if (document.getElementById('yesCheckc47').checked) {
        document.getElementById('ifYesc47').style.display = 'none';
    }
    else document.getElementById('ifYesc47').style.display = 'block';

}

</script>

<p>
<label for="q48">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
<input type="radio" name="q48" 
<?php if (isset($q48) && $q48=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc48();"
value="Yes" id="yesCheckc48">Yes
<input type="radio" name="q48"
<?php if (isset($q48) && $q48=="No") echo "checked";?> onclick="javascript:yesnoCheckc48();"
value="No" id="noCheckc48">No
</p>

<div id="ifYesc48" style="display:none">
<textarea class="form-control"id="c48" name="c48" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft51" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft51').text('500 characters left');
    $('#c48').keydown(function () {
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

function yesnoCheckc48() {
    if (document.getElementById('yesCheckc48').checked) {
        document.getElementById('ifYesc48').style.display = 'none';
    }
    else document.getElementById('ifYesc48').style.display = 'block';

}

</script>

<p>
<label for="q49">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
<input type="radio" name="q49" 
<?php if (isset($q49) && $q49=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc49();"
value="Yes" id="yesCheckc49">Yes
<input type="radio" name="q49"
<?php if (isset($q49) && $q49=="No") echo "checked";?> onclick="javascript:yesnoCheckc49();"
value="No" id="noCheckc49">No
</p>

<div id="ifYesc49" style="display:none">
<textarea class="form-control"id="c49" name="c49" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft52" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft52').text('500 characters left');
    $('#c49').keydown(function () {
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

function yesnoCheckc49() {
    if (document.getElementById('yesCheckc49').checked) {
        document.getElementById('ifYesc49').style.display = 'none';
    }
    else document.getElementById('ifYesc49').style.display = 'block';

}

</script>

<p>
<label for="q50">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
<input type="radio" name="q50" 
<?php if (isset($q50) && $q50=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc50();"
value="Yes" id="yesCheckc50">Yes
<input type="radio" name="q50"
<?php if (isset($q50) && $q50=="No") echo "checked";?> onclick="javascript:yesnoCheckc50();"
value="No" id="noCheckc50">No
</p>

<div id="ifYesc50" style="display:none">
<textarea class="form-control"id="c50" name="c50" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft53" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft53').text('500 characters left');
    $('#c50').keydown(function () {
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

function yesnoCheckc50() {
    if (document.getElementById('yesCheckc50').checked) {
        document.getElementById('ifYesc50').style.display = 'none';
    }
    else document.getElementById('ifYesc50').style.display = 'block';

}

</script>

<p>
<label for="q51">Q<?php $i++; echo $i; ?>. Closer provided contact details for The Review Bureau?</label>
<input type="radio" name="q51" 
<?php if (isset($q51) && $q51=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc51();"
value="Yes" id="yesCheckc51">Yes
<input type="radio" name="q51"
<?php if (isset($q51) && $q51=="No") echo "checked";?> onclick="javascript:yesnoCheckc51();"
value="No" id="noCheckc51">No
</p>

<div id="ifYesc51" style="display:none">
<textarea class="form-control"id="c51" name="c51" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft54" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft54').text('500 characters left');
    $('#c51').keydown(function () {
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

function yesnoCheckc51() {
    if (document.getElementById('yesCheckc51').checked) {
        document.getElementById('ifYesc51').style.display = 'none';
    }
    else document.getElementById('ifYesc51').style.display = 'block';

}

</script>

<p>
<label for="q52">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
<input type="radio" name="q52" 
<?php if (isset($q52) && $q52=="Yes") echo "checked";?> onclick="javascript:yesnoCheckc52();"
value="Yes" id="yesCheckc52">Yes
<input type="radio" name="q52"
<?php if (isset($q52) && $q52=="No") echo "checked";?> onclick="javascript:yesnoCheckc52();"
value="No" id="noCheckc52">No
</p>

<div id="ifYesc52" style="display:none">
<textarea class="form-control"id="c52" name="c52" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php echo $comment;?></textarea><span class="help-block"><p id="characterLeft55" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft55').text('500 characters left');
    $('#c52').keydown(function () {
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

function yesnoCheckc52() {
    if (document.getElementById('yesCheckc52').checked) {
        document.getElementById('ifYesc52').style.display = 'none';
    }
    else document.getElementById('ifYesc52').style.display = 'block';

}

</script>

</div>
</div>

<br>

<center>
<button type="submit" value="submit"  class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Submit Audit</button>
</center>
</form>


    </div>
  </div>

</div>

<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
