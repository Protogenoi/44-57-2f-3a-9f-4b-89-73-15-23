<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adlfunctions.php'); 

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }

include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

include('../includes/ADL_PDO_CON.php');

$auditid = '0';
if(isset($_GET["auditid"])) $auditid = $_GET["auditid"];
 
  
$auditid=$_GET['auditid'];
?>

<!DOCTYPE html>
<html lang="en">
<title>View Closer Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="..//bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
<link rel="stylesheet" href="../styles/viewlayout.css" type="text/css" />
<script src="../js/jquery-1.4.min.js"></script>
<script src="../js/jquery.pjScrollUp.min.js"></script>
<script>
$(function() {
    $(document).pjScrollUp({
        offset: 210,
        duration: 850,
        aTitle: "Scroll Up",
        imgAlt: "Back to top",
        imgSrc: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAVPSURBVHic7Z3dbxRVFMB/ZylRaipYsQo8FEkIGx76ggHfFGliGx98kDZqMOJ/ZpRoAuGBmFiQLSVV0lB5sSakpgapAYm1qR+NYDT0+HBv93vne+7MLPNL9qHdmTvn/nJ3Z+6ZO2dFVckKEdkFjABDHi+ATY/Xmqo+cht5A3EtUER2A0eAKnAQqMRscgu4CywDP6jqnzHbC4UTgSLyIkZYFdiX8uF+wchcVtW1lI+VnkAREeAocBLYm8pB/FkH5oDbmlJHUxEoIi8D48CBxBuPxn2gpqo/Jd1wogLtR3UcOJxYo8myghH5a1INJiJQRJ4FTgFjgMRuMF0UWAJmVfWvuI3FFigiB4FpYDBuMI55CJxX1btxGoklUEReASaBHXGCyJDHwIyq3oraQCSBIlIBJoDjUQ+cMxaBy6q6FXbH0ALt7GEKOBT2YDnnDnAh7KwmlEARGQbOAMPhYisMG8A5Vd0IukPgaZQdef0sD0zfzti+BiKQQPudN0V/y9tmGJiyffYl6AicoP++87w4hOmzL74C7aVKv5xtw3Dc9t0TT4H2InkyoYCKyKR10JOeAu30bJriXiQnwQ5g2rroitcIPEXxpmdpMIhx0ZWuAm1WZSytiArImHXSQa8ROE7+syouEYyTDjoE2mRoXvN5WXLYummhRaBNw3c1XQLAuHVUp30EHiU/afg8cgDjqE67wJPuYiksLY7qAu1ZJqu7Z0Vib/MZuXkEVjMIpqjUXZUCo9Eq0C63SHvFQD+xzzqrj8By9IWnCjDQ/EfO+A2zLONnTHxvkK+5eRW4OWDT16NZR9PG98AXqvqv/fuWiPwIvAu8lF1YLYyKyK4KZn1e3CVmSbKgqheb5AGgqn8AH2PWueSBCjBSobGIMQ/Mq+qVXm+q6j/Ap5glbHlgKE8Ca6p6zW+jJokP0g/Jl9wIvKKq3wTd2N78/gRzosmSXAi8qqoLYXeyEj8D/k4+pMBkLvCaqt6IurOq/g58DvyXXEihyFTgdVWd99tIRJ7yel9V7wEXMYvNXZOZwHlVve63kYi8BnwoIju9tlPVZeASZvGkS4ayuP67EeRsKyLHMLm3/cDp9kxwO6r6HfBlMiEGp4J5WMUVC6p61W8jEakCbzX96wgBllqo6rfAbPTwQrPpUuA94Cu/jURkFDhN5+zohIi86re/qn6NWevnAqcC5/ye1bCZ3vdoJDnaedOOTj98T04J4VSg5/RLRPZg1h8+7bUZ8I6I+N34cjVLcSrQax3OIPABwa4IdgLvi8hzPtu4wKnArksjrIizwPMh2noGOGuXHHdjf7jQIrM5gDuBEyKyAKxhnmHbg8lDvk60ROlu4CMRuQmsYvrxgn2dSCLgAGwOYDq0Rfo5wRHg7YTbHCK7lRRbwFrFTspXMwqiyKyq6qPtUbecaSjFZBkaH9tSYHgaAu1j8nnI8BaFB9ulBZpPHOUoDE7dVSkwGp0C7VPc65mEUyzWm594b7/2m3McTBFpcdQu8Db5uXGdR+5jHNVpEWjTTTWXERWMWntKrmP6ZkuDrDgLqTisdCub0mv+W8P9DZo80/OT2VWgPcsspRlRwVjqVWvGKwMziykN8qTzEI8bVT0F2qI05zGlQZ5UHmNqy/Qs0OOZA7RFaWYSDqpIzPgV5vFNotqiNItJRVQgFoMU5Amahb6Mu3uteeAOps++BBJoK/pcwNRV6Xc2MAV4Ai1WCnwfxKb+z9HfErcL7wSuXlSWfmqQfumn+k5l8bE6Zfm7LMrftTRQFmAsS4DGoSxCG5OyDHJMykLcMSlLwcek/DGCmDgX2HLwPvg5jP8BZQUTNqeQ8kYAAAAASUVORK5CYII=",
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
    <script>
        function toggle(id) {
            if (document.getElementById(id).style.display == 'none') {
                document.getElementById(id).style.display = 'block';
            } else {
                document.getElementById(id).style.display = 'none';
            }
        }
    </script>
<script type="text/javascript">

function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';

}

</script>
</head>
<body>
<?php include('../includes/PDOcon.php');
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>
  <div class="container">

           
<?php

$search=$_POST['search'];

$query = $pdo->prepare("SELECT * FROM closer_audits WHERE id = :searchplaceholder OR id = :auditidplaceholder");

$query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
$query->bindParam(':auditidplaceholder', $auditid, PDO::PARAM_STR, 12);
  
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC)  
  
  
?>


<!--<h1><b>Call Audit ID: <?php echo $search?></b> - Being viewed by <?php echo $hello_name ?> </h1>-->

<div class="wrapper col4">

<table id='users'>


<thead>

<tr>
<td colspan=2><b>Call Audit ID: <?php echo $search?><?php echo $auditid?></b></td>
</tr>

<tr>

<?php  if($result['grade']=='Amber') // [val1] can be 'approved'
         echo "<td style='background-color: #FF9900;' colspan=2><b>".$result['grade']."</b></td>"; 
  else if($result['grade']=='Green')// [val2]can be 'rejected'
         echo "<td style='background-color: #109618;' colspan=2><b>".$result['grade']."</b></td>"; 
  else if($result['grade']=='Red') //[val3] can be 'on hold'
         echo "<td style='background-color: #DC3912;' colspan=2><b>".$result['grade']."</b></td>"; ?>
</tr>

<tr>
<td colspan=2><?php echo $result[total]?>/ 54 answered correctly</td>
</tr>

<tr>
<td>Auditor</td>
<td><?php echo $result[auditor]?></td>
</tr>

<tr>
<td>Closer(s)</td>
<td><?php echo $result[closer]?> - <?php echo $result[closer2]?><br></td>
</tr>

<tr>
<td>Date Submitted</td>
<td><?php echo $result[date_submitted]?></td>
</tr>

<tr>
<td>Policy/AN Number</td>
<td><?php echo $result[policy_number]?> / <?php echo $result[an_number]?></td>
</tr>




</thead>
</table>


<!--Compliance: <?php echo $result[score]?>%<br>-->
<!--Calculated Grade: <?php 

$red = "Red";
$green = "Green";

if ($result[cal_grade] >= "1") {
	echo "$red";
} elseif ($totalincorrect < "1") {
	echo "$green";
	}
?>
-->

<!--<p>
<button onClick="window.print()">Print Audit</button>
</p>-->

<fieldset>

<form name="form" method="POST" action="php/closer_edit_submit.php">

<input type="hidden" name="keyfield" value="<?php echo $search?>">
<input type="hidden" name="edited" value="<?php echo $hello_name ?>">  
<!--
<label for="policy_id">Policy Number:</label><br>

<b></b> 


 
<p>
<label for="grade">Overall compliance grade:</label><br>

<b><?php echo $result[grade]?></b> 

</p>
-->
<!--
<p>
<label for="lead_id">Lead ID</label><br>
<input type="text" name="field2" value="<?php echo $result[lead_id]?>" readonly>
<label for="lead_id2">Lead ID</label><br>
<input type="text" name="field2" value="<?php echo $result[lead_id2]?>" readonly>
<label for="lead_id3">Lead ID</label><br>
<input type="text" name="field2" value="<?php echo $result[lead_id3]?>" readonly> 
</p>
-->
<h1><b>Opening Declaration</b></h1>

<p>
<label for="q1">Q1. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q1]?>" readonly> 
-->
<input type="radio" name="q1" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q1']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q1" value="No" onclick="return false"onclick="return false"<?php if ($result['q1']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q1contest" value="Contested" onclick="return false"<?php if ($result['q1contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q1outcome" value="Outcome" onclick="return false"onclick="return false" <?php if ($result['q1outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c1]?>
</div>
</p>

<p>
<label for="q2">Q2. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q2]?>" readonly> 
-->
<input type="radio" name="q2" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q2']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q2" value="No" onclick="return false"onclick="return false"<?php if ($result['q2']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q2contest" value="Contested" onclick="return false"<?php if ($result['q2contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q2outcome" value="Outcome" onclick="return false"<?php if ($result['q2outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c2]?>
</div>
</p>

<p>
<label for="q3">Q3. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q3]?>" readonly> 
-->
<input type="radio" name="q3" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q3']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q3" value="No" onclick="return false"onclick="return false"<?php if ($result['q3']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q3contest" value="Contested" onclick="return false"<?php if ($result['q3contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q3outcome" value="Outcome" onclick="return false"<?php if ($result['q3outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c3]?>
</div>
</p>

<p>
<label for="q4">Q4. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q4]?>" readonly>
-->

<input type="radio" name="q4" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q4']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q4" value="No" onclick="return false"onclick="return false"<?php if ($result['q4']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q4contest" value="Contested" onclick="return false"<?php if ($result['q4contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q4outcome" value="Outcome" onclick="return false"<?php if ($result['q4outcome']) echo 'checked="checked"'?>> Outcome<br>--> 

<div class="phpcomments">
<?php echo $result[c4]?>
</div>
</p>

<p>
<label for="q5">Q5. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q5]?>" readonly> 
-->
<input type="radio" name="q5" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q5']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q5" value="No" onclick="return false"onclick="return false"<?php if ($result['q5']=="No") echo "checked"?>><label for="No">No</label>
<!--<input type="radio" name="q5" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q5']=="No") echo "checked"?>>N/A-->

<!--<input type="checkbox" name="q<input type="checkbox" name="q5contest" value="Contested" onclick="return false"<?php if ($result['q5contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q5outcome" value="Outcome" onclick="return false"<?php if ($result['q5outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c5]?>
</div>
</p>


<h1><b>Customer Information</b></h1>

<p>
<label for="q6">Q6. Were All Clients Titles And Names Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q6]?>" readonly>
-->
<input type="radio" name="q6" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q6']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q6" value="No" onclick="return false"onclick="return false"<?php if ($result['q6']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q6contest" value="Contested" onclick="return false"<?php if ($result['q6contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q6outcome" value="Outcome" onclick="return false"<?php if ($result['q6outcome']) echo 'checked="checked"'?>> Outcome<br>--> 

<div class="phpcomments">
<?php echo $result[c6]?>
</div>
</p>

<label for="q7">Q7. Was The Clients Gender Accurately Recorded?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q7]?>" readonly> 
-->
<input type="radio" name="q7" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q7']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q7" value="No" onclick="return false"onclick="return false"<?php if ($result['q7']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q7contest" value="Contested" onclick="return false"<?php if ($result['q7contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q7outcome" value="Outcome" onclick="return false"<?php if ($result['q7outcome']) echo 'checked="checked"'?>> Outcome<br>-->


<div class="phpcomments">
<?php echo $result[c7]?>
</div>
</p>
<p>
<label for="q8">Q8. Was The Clients Date Of Birth Accurately Recorded?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q8]?>" readonly>
-->
<input type="radio" name="q8" value="Yes"<?php if ($result['q8']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q8" value="No"<?php if ($result['q8']=="No") echo "checked"?>><label for="No">No</label>


<!--<input type="checkbox" name="q<input type="checkbox" name="q8contest" value="Contested" onclick="return false"<?php if ($result['q8contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q8outcome" value="Outcome" onclick="return false"<?php if ($result['q8outcome']) echo 'checked="checked"'?>> Outcome<br>--> 

<div class="phpcomments">
<?php echo $result[c8]?>
</div>
</p>
</p>

<p>
<label for="q9">Q9. Was The Clients Smoker Status Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q9]?>" readonly>
-->
<input type="radio" name="q9" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q9']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q9" value="No" onclick="return false"onclick="return false"<?php if ($result['q9']=="No") echo "checked"?>><label for="No">No</label>

 
<!--<input type="checkbox" name="q<input type="checkbox" name="q9contest" value="Contested" onclick="return false"<?php if ($result['q9contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q9outcome" value="Outcome" onclick="return false"<?php if ($result['q9outcome']) echo 'checked="checked"'?>> Outcome<br>-->


<div class="phpcomments">
<?php echo $result[c9]?>
</div>
</p>

<p>
<label for="q10">Q10. Was The Clients Employment Status Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q10]?>" readonly>
-->
<input type="radio" name="q10" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q10']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q10" value="No" onclick="return false"onclick="return false"<?php if ($result['q10']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q10contest" value="Contested" onclick="return false"<?php if ($result['q10contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q10outcome" value="Outcome" onclick="return false"<?php if ($result['q10outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c10]?>
</div>
</p>
</p>

<p>
<label for="q11">Q11. Did The Sales Agent Confirm The Policy Was A Single Or Joint Application?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q11]?>" readonly> 
-->
<input type="radio" name="q11" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q11']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q11" value="No" onclick="return false"onclick="return false"<?php if ($result['q11']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q11contest" value="Contested" onclick="return false"<?php if ($result['q11contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q11outcome" value="Outcome" onclick="return false"<?php if ($result['q11outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c11]?>
</div>


<h1><b>Identifying Clients Needs</b></h1>

<p>
<label for="q12">Q12. Did The Agent Check All Details Of What The Client Has With Their Existing Life Insurance Policy?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q12]?>" readonly>
-->
<input type="radio" name="q12" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q12']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q12" value="No" onclick="return false"onclick="return false"<?php if ($result['q12']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q12contest" value="Contested" onclick="return false"<?php if ($result['q12contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q12outcome" value="Outcome" onclick="return false"<?php if ($result['q12outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c12]?>
</div>
</p>

<p>
<label for="q53">Q13. Did the agent mention waiver, indexation, or TPD?</label><br>

<input type="radio" name="q53" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q53']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q53" value="No" onclick="return false"onclick="return false"<?php if ($result['q53']=="No") echo "checked"?>><label for="No">No</label>
<input type="radio" name="q53" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q53']=="N/A") echo "checked"?>><label for="N/A">N/A</label>


<div class="phpcomments">
<?php echo $result[c53]?>
</div>
</p>

<p>
<label for="q13">Q14. Did The Agent Ensure That The Client Was Provided With A Policy That Meet Their Needs? More Cover,Cheaper Premium Etc?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q13]?>" readonly>
-->
<input type="radio" name="q13" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q13']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q13" value="No" onclick="return false"onclick="return false"<?php if ($result['q13']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q13contest" value="Contested" onclick="return false"<?php if ($result['q13contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q13outcome" value="Outcome" onclick="return false"<?php if ($result['q13outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c13]?>
</div>
</p>

<p>
<label for="q14">Q15. Did The Sales Agent Provide The Customer With A Sufficient Amount Of Features And Benefits For The Policy?</label><br>

<b><?php echo $result[q14]?></b> 

<!--<input type="checkbox" name="q<input type="checkbox" name="q14contest" value="Contested" onclick="return false"<?php if ($result['q14contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q14outcome" value="Outcome" onclick="return false"<?php if ($result['q14outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c14]?>
</div>
</p>

<p>
<label for="q15">Q16. Agent confirmed This Policy Will Be Set Up With Legal And General?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q15]?>" readonly>
-->
<input type="radio" name="q15" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q15']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q15" value="No" onclick="return false"onclick="return false"<?php if ($result['q15']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q15contest" value="Contested" onclick="return false"<?php if ($result['q15contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q15outcome" value="Outcome" onclick="return false"<?php if ($result['q15outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c15]?>
</div>
</p>

<h1><b>Eligibility</b></h1>

<p>
<label for="q55">Q17. Important customer information declaration?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q55]?>" readonly> 
-->
<input type="radio" name="q55" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q55']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q55" value="No" onclick="return false"onclick="return false"<?php if ($result['q55']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q55contest" value="Contested" onclick="return false"<?php if ($result['q55contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q55outcome" value="Outcome" onclick="return false"<?php if ($result['q55outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c55]?>
</div>
</p>

<p>
<label for="q17">Q18. Were All Clients Contact Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q17]?>" readonly> 
-->
<input type="radio" name="q17" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q17']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q17" value="No" onclick="return false"onclick="return false"<?php if ($result['q17']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q17contest" value="Contested" onclick="return false"<?php if ($result['q17contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q17outcome" value="Outcome" onclick="return false"<?php if ($result['q17outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c17]?>
</div>
</p>



<p>
<label for="q16">Q19. Were All Clients Address Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q16]?>" readonly> 
-->
<input type="radio" name="q16" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q16']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q16" value="No" onclick="return false"onclick="return false"<?php if ($result['q16']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q16contest" value="Contested" onclick="return false"<?php if ($result['q16contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q16outcome" value="Outcome" onclick="return false"<?php if ($result['q16outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c16]?>
</div>
</p>

<p>
<label for="q31">Q20. Were All Doctors Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q31]?>" readonly> 
-->
<input type="radio" name="q31" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q31']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q31" value="No" onclick="return false"onclick="return false"<?php if ($result['q31']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q31contest" value="Contested" onclick="return false"<?php if ($result['q31contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q31outcome" value="Outcome" onclick="return false"<?php if ($result['q31outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c31]?>
</div>
</p>

<p>
<label for="q18">Q21. Did The Agent Ask And Accurately Record The Work And Travel Questions And Record The Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q18]?>" readonly>
-->
<input type="radio" name="q18" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q18']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q18" value="No" onclick="return false"onclick="return false"<?php if ($result['q18']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q18contest" value="Contested" onclick="return false"<?php if ($result['q18contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q18outcome" value="Outcome" onclick="return false"<?php if ($result['q18outcome']) echo 'checked="checked"'?>> Outcome<br>--> 

<div class="phpcomments">
<?php echo $result[c18]?>
</div>
</p>

<p>
<label for="q19">Q22. Did The Agent Ask And Accurately Record The Hazardous Activities Questions?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q19]?>" readonly> 
-->
<input type="radio" name="q19" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q19']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q19" value="No" onclick="return false"onclick="return false"<?php if ($result['q19']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q19contest" value="Contested" onclick="return false"<?php if ($result['q19contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q19outcome" value="Outcome" onclick="return false"<?php if ($result['q19outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c19]?>
</div>
</p>

<p>
<label for="q20">Q23. Did The Agent Ask And Accurately Record The Height And Weight Details And Record The Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q20]?>" readonly> 
-->
<input type="radio" name="q20" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q20']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q20" value="No" onclick="return false"onclick="return false"<?php if ($result['q20']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q20contest" value="Contested" onclick="return false"<?php if ($result['q20contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q20outcome" value="Outcome" onclick="return false"<?php if ($result['q20outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c20]?>
</div>
</p>

<p>
<label for="q21">Q24. Did The Agent Ask And Accurately Record The Smoking Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q21]?>" readonly> 
-->
<input type="radio" name="q21" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q21']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q21" value="No" onclick="return false"onclick="return false"<?php if ($result['q21']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q21contest" value="Contested" onclick="return false"<?php if ($result['q21contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q21outcome" value="Outcome" onclick="return false"<?php if ($result['q21outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c21]?>
</div>
</p>

<p>
<label for="q22">Q25. Did The Agent Ask And Accurately Record The Drug Use Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q22]?>" readonly>
-->
<input type="radio" name="q22" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q22']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q22" value="No" onclick="return false"onclick="return false"<?php if ($result['q22']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q22contest" value="Contested" onclick="return false"<?php if ($result['q22contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q22outcome" value="Outcome" onclick="return false"<?php if ($result['q22outcome']) echo 'checked="checked"'?>> Outcome<br>--> 
 
<div class="phpcomments">
<?php echo $result[c22]?>
</div>
</p>

<p>
<label for="q23">Q26. Did The Agent Ask And Accurately Record The Alcohol Consumption Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q23]?>" readonly> 
-->
<input type="radio" name="q23" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q23']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q23" value="No" onclick="return false"onclick="return false"<?php if ($result['q23']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q23contest" value="Contested" onclick="return false"<?php if ($result['q23contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q23outcome" value="Outcome" onclick="return false"<?php if ($result['q23outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c23]?>
</div>
</p>

<p>
<label for="q24">Q27. Were All Health Ever Questions Asked And Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q24]?>" readonly>
-->
<input type="radio" name="q24" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q24']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q24" value="No" onclick="return false"onclick="return false"<?php if ($result['q24']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q24contest" value="Contested" onclick="return false"<?php if ($result['q24contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q24outcome" value="Outcome" onclick="return false"<?php if ($result['q24outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c24]?>
</div>
</p>

<p>
<label for="q25">Q28. Were All Health Last 5 Years Questions Asked And Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q25]?>" readonly>
-->
<input type="radio" name="q25" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q25']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q25" value="No" onclick="return false"onclick="return false"<?php if ($result['q25']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q25contest" value="Contested" onclick="return false"<?php if ($result['q25contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q25outcome" value="Outcome" onclick="return false"<?php if ($result['q25outcome']) echo 'checked="checked"'?>> Outcome<br>-->
 
<div class="phpcomments">
<?php echo $result[c25]?>
</div>
</p>

<p>
<label for="q26">Q29. Were All Health Last 2 Years Questions Asked And Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q26]?>" readonly>
-->
<input type="radio" name="q26" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q26']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q26" value="No" onclick="return false"onclick="return false"<?php if ($result['q26']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q26contest" value="Contested" onclick="return false"<?php if ($result['q26contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q26outcome" value="Outcome" onclick="return false"<?php if ($result['q26outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c26]?>
</div>
</p>

<p>
<label for="q27">Q30. Were All Health Continued Questions Asked And Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q27]?>" readonly>
-->
<input type="radio" name="q27" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q27']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q27" value="No" onclick="return false"onclick="return false"<?php if ($result['q27']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q27contest" value="Contested" onclick="return false"<?php if ($result['q27contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q27outcome" value="Outcome" onclick="return false"<?php if ($result['q27outcome']) echo 'checked="checked"'?>> Outcome<br>-->
 
<div class="phpcomments">
<?php echo $result[c27]?>
</div>
</p>

<p>
<label for="q28">Q31. Were All Family History Questions Asked And Details Recorded Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q28]?>" readonly>
-->
<input type="radio" name="q28" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q28']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q28" value="No" onclick="return false"onclick="return false"<?php if ($result['q28']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q28contest" value="Contested" onclick="return false"<?php if ($result['q28contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q28outcome" value="Outcome" onclick="return false"<?php if ($result['q28outcome']) echo 'checked="checked"'?>> Outcome<br>-->
 
<div class="phpcomments">
<?php echo $result[c28]?>
</div>
</p>

<p>
<label for="q29">Q32. Were Term For Term Details Recorded Correctly?</label><br>

<b><?php echo $result[q29]?></b>

<!--<input type="checkbox" name="q<input type="checkbox" name="q29contest" value="Contested" onclick="return false"<?php if ($result['q29contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q29outcome" value="Outcome" onclick="return false"<?php if ($result['q29outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c29]?>
</div>
</p>

<h1><b>Declarations of Insurance</b></h1>

<p>
<label for="q30">Q33. Customer declaration read out?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q30]?>" readonly> 
-->
<input type="radio" name="q30" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q30']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q30" value="No" onclick="return false"onclick="return false"<?php if ($result['q30']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q30contest" value="Contested" onclick="return false"<?php if ($result['q30contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q30outcome" value="Outcome" onclick="return false"<?php if ($result['q30outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c30]?>
</div>
</p>


<p>
<label for="q54">Q34. If appropirate did the agent confirm the exclusions on the policy</label><br>

<input type="radio" name="q54" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q54']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q54" value="No" onclick="return false"onclick="return false"<?php if ($result['q54']=="No") echo "checked"?>><label for="No">No</label>
<input type="radio" name="q54" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q54']=="N/A") echo "checked"?>><label for="N/A">N/A</label>


<div class="phpcomments">
<?php echo $result[c54]?>
</div>
</p>



<h1><b>Payment Information</b></h1>

<p>
<label for="q32">Q35. Was The Clients Policy Start Date Accurately Recorded?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q32]?>" readonly> 
-->
<input type="radio" name="q32" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q32']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q32" value="No" onclick="return false"onclick="return false"<?php if ($result['q32']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q32contest" value="Contested" onclick="return false"<?php if ($result['q32contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q32outcome" value="Outcome" onclick="return false"<?php if ($result['q32outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c32]?>
</div>
</p>
<p>
<label for="q33">Q36. Did The Agent Offer To Read The Direct Debit Guarantee?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q33]?>" readonly> 
-->
<input type="radio" name="q33" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q33']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q33" value="No" onclick="return false"onclick="return false"<?php if ($result['q33']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q33contest" value="Contested" onclick="return false"<?php if ($result['q33contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q33outcome" value="Outcome" onclick="return false"<?php if ($result['q33outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c33]?>
</div>
</p>

<p>
<label for="q34">Q37. Did The Agent Offer A Preferred Premium Collection Date?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q34]?>" readonly> 
-->
<input type="radio" name="q34" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q34']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q34" value="No" onclick="return false"onclick="return false"<?php if ($result['q34']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q34contest" value="Contested" onclick="return false"<?php if ($result['q34contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q34outcome" value="Outcome" onclick="return false"<?php if ($result['q34outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c34]?>
</div>
</p>

<p>
<label for="q35">Q38. Did The Agent Take Bank Details Correctly?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q35]?>" readonly> 
-->
<input type="radio" name="q35" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q35']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q35" value="No" onclick="return false"onclick="return false"<?php if ($result['q35']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q35contest" value="Contested" onclick="return false"<?php if ($result['q35contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q35outcome" value="Outcome" onclick="return false"<?php if ($result['q35outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c35]?>
</div>
</p>

<p>
<label for="q36">Q39. Did They Have Consent Off The Premium Payer?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q36]?>" readonly> 
-->
<input type="radio" name="q36" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q36']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q36" value="No" onclick="return false"onclick="return false"<?php if ($result['q36']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q36contest" value="Contested" onclick="return false"<?php if ($result['q36contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q36outcome" value="Outcome" onclick="return false"<?php if ($result['q36outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c36]?>
</div>
</p>
</p>


<!--
<p>
<label for="q37">Q37. Did The Sales Agent Confirm Who The Policy Is With And The Length Of The Policy?</label><br>

<input type="text" name="field2" value="<?php echo $result[q37]?>" readonly> 

<input type="radio" name="q37" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q37']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q37" value="No" onclick="return false"onclick="return false"<?php if ($result['q37']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q37contest" value="Contested" onclick="return false"<?php if ($result['q37contest']) echo 'checked="checked"'?>> Contested
<!--<input type="checkbox" name="q<input type="checkbox" name="q37outcome" value="Outcome" onclick="return false"<?php if ($result['q37outcome']) echo 'checked="checked"'?>> Outcome<br>

</p>
-->
<!--
<div class="phpcomments">
<?php echo $result[c37]?>
</div>
</p>
-->

<h1><b>Consolidation Declaration</b></h1>

<p>
<label for="q38">Q40. Agent confirmed The Customers Rights To Cancel The Policy At Any Anytime And If The Customer Changes Their Mind Within The First 30 Days Of Starting There Will Be A Refund Of Premiums?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q38]?>" readonly>
-->
<input type="radio" name="q38" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q38']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q38" value="No" onclick="return false"onclick="return false"<?php if ($result['q38']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q38contest" value="Contested" onclick="return false"<?php if ($result['q38contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q38outcome" value="Outcome" onclick="return false"<?php if ($result['q38outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c38]?>
</div>
</p>

<p>
<label for="q39">Q41. Agent confirmed If The Policy Is Cancelled At Any Other Time The Cover Will End And No Refund Will Be Made And That The Policy Has No Cash In Value?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q39]?>" readonly> 
-->
<input type="radio" name="q39" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q39']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q39" value="No" onclick="return false"onclick="return false"<?php if ($result['q39']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q39contest" value="Contested" onclick="return false"<?php if ($result['q39contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q39outcome" value="Outcome" onclick="return false"<?php if ($result['q39outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c39]?>
</div>
</p>

<p>
<label for="q40">Q42. Like Mentioned Earlier Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q40]?>" readonly>
-->
<input type="radio" name="q40" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q40']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q40" value="No" onclick="return false"onclick="return false"<?php if ($result['q40']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q40contest" value="Contested" onclick="return false"<?php if ($result['q40contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q40outcome" value="Outcome" onclick="return false"<?php if ($result['q40outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c40]?>
</div>
</p>

<p>
<label for="q41">Q43. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q41]?>" readonly> 
-->
<input type="radio" name="q41" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q41']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q41" value="No" onclick="return false"onclick="return false"<?php if ($result['q41']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q41contest" value="Contested" onclick="return false"<?php if ($result['q41contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q41outcome" value="Outcome" onclick="return false"<?php if ($result['q41outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c41]?>
</div>
</p>

<p>
<label for="q42">Q44. Did the closer confirm that the customer will be getting a 'my account' email from Legal and General?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q42]?>" readonly>
-->
<input type="radio" name="q42" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q42']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q42" value="No" onclick="return false"onclick="return false"<?php if ($result['q42']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q42contest" value="Contested" onclick="return false"<?php if ($result['q42contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q42outcome" value="Outcome" onclick="return false"<?php if ($result['q42outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c42]?>
</div>
</p>

<p>
<label for="q43">Q45. Agent confirmed The Check Your Details Procedure?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q43]?>" readonly>
-->
<input type="radio" name="q43" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q43']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q43" value="No" onclick="return false"onclick="return false"<?php if ($result['q43']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q43contest" value="Contested" onclick="return false"<?php if ($result['q43contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q43outcome" value="Outcome" onclick="return false"<?php if ($result['q43outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c43]?>
</div>
</p>

<p>
<label for="q44">Q46. Agent Confirmed an approximate Direct Debit date and informed the customer it is not an exact date, but legal and general will write to them with a more specific date?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q44]?>" readonly> 
-->
<input type="radio" name="q44" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q44']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q44" value="No" onclick="return false"onclick="return false"<?php if ($result['q44']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q44contest" value="Contested" onclick="return false"<?php if ($result['q44contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q44outcome" value="Outcome" onclick="return false"<?php if ($result['q44outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c44]?>
</div>
</p>

<p>
<label for="q45">Q47. Did the closer confirm to the customer to cancel their existing direct debit</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q45]?>" readonly> 
-->
<input type="radio" name="q45" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q45']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q45" value="No" onclick="return false"onclick="return false"<?php if ($result['q45']=="No") echo "checked"?>><label for="No">No</label>
<input type="radio" name="q45" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q45']=="N/A") echo "checked"?>><label for="N/A">N/A</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q45contest" value="Contested" onclick="return false"<?php if ($result['q45contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q45outcome" value="Outcome" onclick="return false"<?php if ($result['q45outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c45]?>
</div>
</p>

<h1><b>Quality Control</b></h1>

<p>
<label for="q46">Q48. Agent confirmed That They Have Set The Client Up On A Level/Decreasing/CIC Term Policy With Legal And General With Client Confirmation?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q46]?>" readonly> 
-->
<input type="radio" name="q46" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q46']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q46" value="No" onclick="return false"onclick="return false"<?php if ($result['q46']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q46contest" value="Contested" onclick="return false"<?php if ($result['q46contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q46outcome" value="Outcome" onclick="return false"<?php if ($result['q46outcome']) echo 'checked="checked"'?>> Outcome<br>-->


<div class="phpcomments">
<?php echo $result[c46]?>
</div>
</p>

<p>
<label for="q47">Q49. Agent confirmed The Length Of The Policy In Years With Client Confirmation?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q47]?>" readonly>
-->
<input type="radio" name="q47" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q47']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q47" value="No" onclick="return false"onclick="return false"<?php if ($result['q47']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q47contest" value="Contested" onclick="return false"<?php if ($result['q47contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q47outcome" value="Outcome" onclick="return false"<?php if ($result['q47outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c47]?>
</div>
</p>
<p>
<label for="q48">Q50. Agent confirmed The Amount Of Cover On The Policy With Client Confirmation?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q48]?>" readonly> 

-->
<input type="radio" name="q48" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q48']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q48" value="No" onclick="return false"onclick="return false"<?php if ($result['q48']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q48contest" value="Contested" onclick="return false"<?php if ($result['q48contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q48outcome" value="Outcome" onclick="return false"<?php if ($result['q48outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c48]?>
</div>
</p>

<p>
<label for="q49">Q51. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q49]?>" readonly>
-->
<input type="radio" name="q49" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q49']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q49" value="No" onclick="return false"onclick="return false"<?php if ($result['q49']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q49contest" value="Contested" onclick="return false"<?php if ($result['q49contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q49outcome" value="Outcome" onclick="return false"<?php if ($result['q49outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c49]?>
</div>
</p>

<p>
<label for="q50">Q52. Did The Customer Give Their Explicit Consent For The Policy To Be Set Up?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q50]?>" readonly>
-->
<input type="radio" name="q50" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q50']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q50" value="No" onclick="return false"onclick="return false"<?php if ($result['q50']=="No") echo "checked"?>><label for="No">No</label>
 
<!--<input type="checkbox" name="q<input type="checkbox" name="q50contest" value="Contested" onclick="return false"<?php if ($result['q50contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q50outcome" value="Outcome" onclick="return false"<?php if ($result['q50outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c50]?>
</div>
</p>

<p>
<label for="q51">Q53. Did The Agent Provide Contact Details For The Review Bureau?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q51]?>" readonly> 
-->
<input type="radio" name="q51" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q51']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q51" value="No" onclick="return false"onclick="return false"<?php if ($result['q51']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q51contest" value="Contested" onclick="return false"<?php if ($result['q51contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q51outcome" value="Outcome" onclick="return false"<?php if ($result['q51outcome']) echo 'checked="checked"'?>> Outcome<br>--> 

<div class="phpcomments">
<?php echo $result[c51]?>
</div>
</p>

<p>
<label for="q52">Q54. Did The Sales Agent Keep To The Requirements Of A Non-Advised Sale, Providing An Information Based Service And Not Offering Advice Or Personal Opinion?</label><br>
<!--
<input type="text" name="field2" value="<?php echo $result[q52]?>" readonly> 
-->
<input type="radio" name="q52" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q52']=="Yes") echo "checked"?>>Yes
<input type="radio" name="q52" value="No" onclick="return false"onclick="return false"<?php if ($result['q52']=="No") echo "checked"?>><label for="No">No</label>

<!--<input type="checkbox" name="q<input type="checkbox" name="q52contest" value="Contested" onclick="return false"<?php if ($result['q52contest']) echo 'checked="checked"'?>> Contested-->
<!--<input type="checkbox" name="q<input type="checkbox" name="q52outcome" value="Outcome" onclick="return false"<?php if ($result['q52outcome']) echo 'checked="checked"'?>> Outcome<br>-->

<div class="phpcomments">
<?php echo $result[c52]?>
</div>
</p>

</form>
</fieldset>


 </div>
  </div>
</div>
</p>
</body>
</html>
