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
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

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

$auditid = filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | View Lead Gen Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../styles/viewlayout.css" type="text/css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="/js/jquery-1.4.min.js"></script>
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
</head>
<body>
    <div class="container">
      
      <?php

    $new= filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);
    $viewauditid= filter_input(INPUT_POST, 'newview', FILTER_SANITIZE_NUMBER_INT);
    
        if(!isset($viewauditid)) 
    {
        
       $viewauditid= filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
        
    }
   

if ($new =='y') {
    
    $new= filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $query = $pdo->prepare("SELECT an_number, q1s4q1n, q1s4c1n, auditor, submitted_date, id, agent, grade, sq1, sq2, sq3, sq4, sq5, s2aq1, s2aq2, s2aq3, s2aq4, s2aq5, s2aq6, s2aq7, s2aq8, s2aq9, s2aq10, s2aq11, s2bq1, q1s2bc1, q2s2bq2, q1s3q1, q2s2bc2, q1s3c1 from Audit_LeadGen where id =:newidholder");
    $query->bindParam(':newidholder', $viewauditid, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    $data3=$query->fetch(PDO::FETCH_ASSOC);
    
    $QUES = $pdo->prepare("SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14 ,q15 FROM Audit_LeadGen_Comments WHERE audit_id=:id");
    $QUES->bindParam(':id', $viewauditid, PDO::PARAM_INT);
    $QUES->execute()or die(print_r($QUES->errorInfo(), true));
    $QUES_RESULTS=$QUES->fetch(PDO::FETCH_ASSOC);
    
    $q1 =$QUES_RESULTS['q1'];
    $q2 =$QUES_RESULTS['q2'];
    $q3 =$QUES_RESULTS['q3'];
    $q4 =$QUES_RESULTS['q4'];
    $q5 =$QUES_RESULTS['q5'];
    $q6 =$QUES_RESULTS['q6'];
    $q7 =$QUES_RESULTS['q7'];
    $q8 =$QUES_RESULTS['q8'];
    $q9 =$QUES_RESULTS['q9'];
    $q10 =$QUES_RESULTS['q10'];
    $q11 =$QUES_RESULTS['q11'];
    $q12 =$QUES_RESULTS['q12'];
    $q13 =$QUES_RESULTS['q13'];
    $q14 =$QUES_RESULTS['q14'];
    $q15 =$QUES_RESULTS['q15'];
   
    ?>
      
      <div class="wrapper col4">

<table id='users'>

<thead>
<tr>
<td colspan="4"><b>Call Audit ID: <?php echo $viewauditid?></b></td>
</tr>
<tr>
<td>Auditor</td>
<td><?php echo $data3['auditor'];?></td>
</tr>

<tr>
<td>Agent(s)</td>
<td><?php echo $data3['agent'];?><br></td>
</tr>

<tr>
<td>AN Number</td>
<td><?php echo $data3['an_number'];?><br></td>
</tr>


<tr>
<td>Date Submitted</td>
<td><?php echo $data3['submitted_date'];?></td>
</tr>

<tr>


<td>Grade</td>
<?php  if($data3['grade']=='Amber')  {
echo "<td style='background-color: #FF9900;'><b>".$data3['grade']."</b></td>"; }
  else if($data3['grade']=='Green') {
  echo "<td style='background-color: #109618;'><b>".$data3['grade']."</b></td>"; }
  else if($data3['grade']=='Red') {
  echo "<td style='background-color: #DC3912;'><b>".$data3['grade']."</b></td>"; } ?>
</tr>

</thead>
</table>
          
<br>
<h4>Opening Section 1</h4>
<br> 

<?php if($data3['sq1']=="Yes") {
    
}

else {
    ?>

<label for="full_info">Q1. Agent said their name?</label>


<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq1']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq1']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q1;?>
</div>
<br>

<?php }

if($data3['sq2']=="Yes") {
    
}

else {
    ?>


<label for="obj_handled">Q2. Said where they were calling from?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq2']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq2']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q2;?>
</div>
<br>

<?php }

if($data3['sq3']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q3. Said the reason for the call?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq3']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq3']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q3;?>
</div>
<br>

<?php }

if($data3['sq4']=="Yes") {
    
}

else {
    ?>

<label for="dealsheet_questions">Q4. Used EU gender directive correctly?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq4']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq4']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q4;?>
</div>
<br>

<?php }

if($data3['sq5']=="Yes") {
    
}

else {
    ?>

<label for="sq5">Q5. Agent followed the script?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq5']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq5']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q5;?>
</div>
<br>

<?php }


if($data3['s2aq1']=="Yes") {
    
}

else {
    ?>

<br>
<h4>Qualifying Section 2a</h4>
<br>      


<label for="full_info">Q1. Were all questions asked?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq1']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq1']=="No") { echo "checked"; } ?>><label for="No">No</label>
<br>

<?php 

if($data3['s2aq2']=="Yes") {
    
}

else {
    ?>

<label for="obj_handled">Q2. What was the main reason you took out the policy?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq2']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq2']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q6;?>
</div>
<br>

<?php }

if($data3['s2aq3']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q3. Repayment or interest only?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq3']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq3']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q7;?>
</div>
<br>

<?php }

if($data3['s2aq4']=="Yes") {
    
}

else {
    ?>

<label for="dealsheet_questions">Q4. When was your last review on the policy?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq4']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq4']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q8;?>
</div>
<br>

<?php }

if($data3['s2aq5']=="Yes") {
    
}

else {
    ?>

<label for="full_info">Q5. How did you take out the policy?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq5']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq5']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q9;?>
</div>
<br>

<?php }

if($data3['s2aq6']=="Yes") {
    
}

else {
    ?>

<label for="obj_handled">Q6. How much are you paying on a monthly basis?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq6']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq6']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q10;?>
</div>
<br>

<?php }

if($data3['s2aq7']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q7. How much are you covered for?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq7']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq7']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q11;?>
</div>
<br>

<?php }

if($data3['s2aq8']=="Yes") {
    
}

else {
    ?>

<label for="dealsheet_questions">Q8. How long do you have left on the policy?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq8']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq8']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q12;?>
</div>
<br>

<?php }

if($data3['s2aq9']=="Yes") {
    
}

else {
    ?>

<label for="full_info">Q9. Is your policy single, joint or separate?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq9']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq9']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q13;?>
</div>
<br>

<?php }

if($data3['s2aq10']=="Yes") {
    
}

else {
    ?>

<label for="obj_handled">Q10. Have you or your partner smoked in the last 12 months?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq10']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq10']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q14;?>
</div>
<br>

<?php }

if($data3['s2aq11']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q11. Have you or your partner got or has had any health issues?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq11']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq11']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $q15;?>
</div>
<br>

<?php } } ?>

<br>
<h4>Section 2b</h4>
<br>   

<?php

if($data3['s2bq1']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q1. Were all questions asked correctly?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2bq1']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2bq1']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $data3['q1s2bc1']?>
</div>
<br>

<?php }

if($data3['q2s2bq2']=="Yes") {
    
}

else {
    ?>

<label for="rapport">Q2. Were all questions recorded correctly?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q2s2bq2']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q2s2bq2']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $data3['q2s2bc2']?>
</div>
<br>

<?php }

if($data3['q1s4q1n']=="Yes") {
    
}

else {
    ?>

<br>
<h4>Section 3</h4>
<br>  

<label for="rapport">Q1. Did the agent stick to branding compliance?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q1s4q1n']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q1s4q1n']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $data3['q1s4c1n']?>
</div>

<?php }

if($data3['q1s3q1']=="Yes") {
    
}

else {
    ?>

<br>
<h4>Section 4</h4>
<br>  

<label for="rapport">Q1. Were all personal details recorded correctly?</label>
<input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q1s3q1']=="Yes") { echo "checked"; } ?>>Yes
<input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q1s3q1']=="No") { echo "checked"; } ?>><label for="No">No</label>
<div class="phpcomments">
<?php echo $data3['q1s3c1']?>
</div>



      <?php
}     
      
}

else {
    ?>


<?php

$search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);

$data = 'SELECT * FROM `lead_gen_audit` WHERE `id` = "'.$search.'" OR id ="'.$auditid.'" ';
  $query = mysql_query($data) or die("Couldn't execute query. ". mysql_error());
  $data2 = mysql_fetch_array($query);
  
  
?>

<div class="wrapper col4">

<table id='users'>

<thead>
<tr>
<td colspan="4"><b>Call Audit ID: <?php echo $search?><?php echo $auditid?></b></td>
</tr>
<tr>
<td>Auditor</td>
<td><?php echo $data2['auditor']; ?></td>
</tr>

<tr>
<td>Agent(s)</td>
<td><?php echo $data2['lead_gen_name']; ?> - <?php echo $data2['lead_gen_name2']; ?><br></td>
</tr>


<tr>
<td>Date Submitted</td>
<td><?php echo $data2['date_submitted']; ?></td>
</tr>

<tr>


<td>Grade</td>
<?php  if($data2['grade']=='Amber') 
         echo "<td style='background-color: #FF9900;'><b>".$data2['grade']."</b></td>"; 
  else if($data2['grade']=='Green')
         echo "<td style='background-color: #109618;'><b>".$data2['grade']."</b></td>"; 
  else if($data2['grade']=='Red') 
         echo "<td style='background-color: #DC3912;'><b>".$data2['grade']."</b></td>"; ?>
</tr>

</thead>
</table>

<!--
<?php
if ($value = Excellent) $color = '#DC3912';
else if ($value = No) $color = '#109618';
?>

<h1><b>Call Audit ID: <?php echo $search?></b> - Being viewed by <?php echo $hello_name ?> </h1>
<p>
Audited by: <?php echo $data2[auditor]?><br>
Lead Gen: <?php echo $data2[lead_gen_name]?><br>
Date Submitted: <?php echo $data2[date_submitted]?><br>
<!--Compliance: <?php echo $data2[score]?>%<br>-->
<!--Calculated Grade: <?php 

$red = "Red";
$amber = "Amber";
$green = "Green";

if ($data2[cal_grade] >= "50") {
	echo "$red";
} elseif ($totalincorrect < "50" && $data2[cal_grade] > "0") {
	echo "$amber";
} elseif ($totalincorrect < "1") {
	echo "$green";
	}



?>-->
</p>

<form name="form" method="POST" action="/php/lead_gen_edit_submit.php">

<input type="hidden" name="keyfield" value="<?php echo $search?>">
<input type="hidden" name="edited" value="<?php echo $hello_name ?>">  


<?php 
$comments1 = str_replace(".", ".<br>", $data2['c1']); ?>
<fieldset>

<div class="phpcomments">
<?php echo $comments1?>
</div>
</p>

<label for="call_opening">Call opening?</label>

<b><?php echo $data2['call_opening']; ?></b>


<div class="phpcomments">
<?php echo $data2[c2]?>
</div>
</p>

<label for="full_info">Did the agents provide full information?</label>

<b><?php echo $data2['full_info']; ?></b>

<div class="phpcomments">
<?php echo $data2['c3'];?>
</div>
</p>

<label for="obj_handled">Objections handled:</label>

<b><?php echo $data2['obj_handled']; ?></b> 


<div class="phpcomments">
<?php echo $data2['c4'];?>
</div>
</p>

<label for="rapport">Rapport:</label>

<b><?php echo $data2['rapport']; ?></b>


<div class="phpcomments">
<?php echo $data2['c5']; ?>
</div>
</p>

<label for="dealsheet_questions">Did the agent ask all the questions on the dealsheet?</label>

<input type="radio" name="dealsheet_questions" value="Yes" onclick="return false"onclick="return false"<?php if ($data2['dealsheet_questions']=="Yes") echo "checked"?>>Yes
<input type="radio" name="dealsheet_questions" value="No" onclick="return false"onclick="return false"<?php if ($data2['dealsheet_questions']=="No") echo "checked"?>><label for="No">No</label>

<div class="phpcomments">
<?php echo $data2[c6]?>
</div>
</p>

<p>
<label for="brad_compl">Did the agent stick to branding compliance?</label>

<input type="radio" name="brad_compl" value="Yes" onclick="return false"onclick="return false"<?php if ($data2['brad_compl']=="Yes") echo "checked"?>>Yes
<input type="radio" name="brad_compl" value="No" onclick="return false"onclick="return false"<?php if ($data2['brad_compl']=="No") echo "checked"?>><label for="No">No</label>
</p>

<div class="phpcomments">
<?php echo $data2['c7'];?>
    
<?php } ?>
</div>
</p>


</form>
</fieldset>

 </div>
  </div>
</div>

</body>
</html>
