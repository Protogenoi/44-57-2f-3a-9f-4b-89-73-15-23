<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL| Lead Gen Submit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
</head>
<body>

<?php include('../../includes/navbar.php'); ?>
<?php include('../../includes/ADL_PDO_CON.php'); ?>
<div class="container">
		
<?php

$answer1 = $_POST['call_opening'];  
$answer2 = $_POST['full_info']; 
$answer3 = $_POST['obj_handled'];  
$answer4 = $_POST['rapport']; 
$answer5 = $_POST['dealsheet_questions'];  
$answer6 = $_POST['brad_compl']; 
 
$totalCorrect = 0;

if ($answer1 =="Excellent") { $totalCorrect++; }
if ($answer1 =="Good") { $totalCorrect++; }
if ($answer1 =="Acceptable") { $totalCorrect++; }
if ($answer2 =="Excellent") { $totalCorrect++; }
if ($answer2 =="Good") { $totalCorrect++; }
if ($answer2 =="Acceptable") { $totalCorrect++; }
if ($answer3 =="Excellent") { $totalCorrect++; }
if ($answer3 =="Good") { $totalCorrect++; }
if ($answer3 =="Acceptable") { $totalCorrect++; }
if ($answer4 =="Excellent") { $totalCorrect++; }
if ($answer4 =="Good") { $totalCorrect++; }
if ($answer4 =="Acceptable") { $totalCorrect++; }
if ($answer5 =="Yes") { $totalCorrect++; }
if ($answer6 =="Yes") { $totalCorrect++; }

$total = 6;
$percentage = $totalCorrect/$total * 100;

$totalincorrect = 0;

if ($answer1 =="Unacceptable") { $totalincorrect++; }
if ($answer2 =="Unacceptable") { $totalincorrect++; }
if ($answer3 =="Unacceptable") { $totalincorrect++; }
if ($answer4 =="Unacceptable") { $totalincorrect++; }
if ($answer5 =="Unacceptable") { $totalincorrect++; }
if ($answer6 =="Unacceptable") { $totalincorrect++; }

$red = "Status Red";
$amber = "Status Amber";
$green = "Status Green";
$total2 = 6;
$percentage2 = $totalincorrect/$total2 * 100;
$totalincorrect;

echo "<h2>Audit Results:</h2>";
$gradeswitch = "$_POST[grade]";

switch ($gradeswitch) {
    case "Red":
        echo "<div class=\"warningalert\">
    <div class=\"notice notice-danger fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade</strong> Status Red ($percentage2%).
    </div>";
        break;
    case "Amber":
        echo "<div class=\"editpolicy\">
    <div class=\"notice notice-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> Status Amber ($percentage2%).
    </div>";
        break;
    case "Green":
        echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> Status Green ($percentage2%).
    </div>";
        break;
    default:
        echo "<div class=\"editpolicy\">
    <div class=\"notice notice-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> No Grade - Audit Saved.
    </div>";
}

echo "<div class=\"editpolicy\">
    <div class=\"notice notice-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Audit Score:</strong> $totalCorrect / 6 answered correctly ($percentage%).
    </div>";


$lead_gen_name=$_POST['full_name'];
$lead_gen_name2=$_POST['full_name2'];
$auditor=$_POST['auditor'];
$grade=$_POST['grade'];
$c1=$_POST['c1'];
$call_opening=$_POST['call_opening'];
$c2=$_POST['c2'];
$full_info=$_POST['full_info'];
$c3=$_POST['c3'];
$obj_handled=$_POST['obj_handled'];
$c4=$_POST['c4'];
$rapport=$_POST['rapport'];
$c5=$_POST['c5'];
$dealsheet_questions=$_POST['dealsheet_questions'];
$c6=$_POST['c6'];
$brad_compl=$_POST['brad_compl'];
$c7=$_POST['c7'];
$agree=$_POST['agree'];

$query = $pdo->prepare("INSERT INTO lead_gen_audit 
(edited
, date_edited
, total
, cal_grade
, score
, date_submitted
, lead_gen_name
, lead_gen_name2
, auditor
, grade
, c1
, call_opening
, c2
, full_info
, c3
, obj_handled
, c4
, rapport
, c5
, dealsheet_questions
, c6
, brad_compl
, c7
, agree)
VALUES 
(' '
, CURRENT_TIMESTAMP
, :totalholder
, :calgradeholder
, :scoreholder
, CURRENT_TIMESTAMP
, :leadgenholder
, :leadgen2holder
, :auditorholder
, :gradeholder
, :c1holder
, :callopeningholder
, :c2holder
, :full_infoholder
, :c3holder
, :obj_handledholder
, :c4holder
, :rapportholder
, :c5holder
, :dealsheet_questionsholder
, :c6holder
, :brad_complholder
, :c7holder
, :agreeholder) ");

$query->bindParam(':totalholder',$totalCorrect, PDO::PARAM_INT);
$query->bindParam(':calgradeholder',$percentage2, PDO::PARAM_INT);
$query->bindParam(':scoreholder', $percentage, PDO::PARAM_INT);

$query->bindParam(':leadgenholder',$lead_gen_name, PDO::PARAM_STR, 12);
$query->bindParam(':leadgen2holder',$lead_gen_name2, PDO::PARAM_STR, 12);
$query->bindParam(':auditorholder',$auditor, PDO::PARAM_STR, 12);
$query->bindParam(':gradeholder',$grade, PDO::PARAM_STR, 12);

$query->bindParam(':c1holder',$c1, PDO::PARAM_STR, 2500);
$query->bindParam(':callopeningholder', $call_opening, PDO::PARAM_STR, 12);
$query->bindParam(':c2holder',$c2, PDO::PARAM_STR, 2500);
$query->bindParam(':full_infoholder', $full_info, PDO::PARAM_STR, 12);
$query->bindParam(':c3holder',$c3, PDO::PARAM_STR, 2500);
$query->bindParam(':obj_handledholder', $obj_handled, PDO::PARAM_STR, 12);
$query->bindParam(':c4holder',$c4, PDO::PARAM_STR, 2500);
$query->bindParam(':rapportholder', $rapport, PDO::PARAM_STR, 12);
$query->bindParam(':c5holder',$c5, PDO::PARAM_STR, 2500);
$query->bindParam(':dealsheet_questionsholder', $dealsheet_questions, PDO::PARAM_STR, 12);
$query->bindParam(':c6holder',$c6, PDO::PARAM_STR, 2500);
$query->bindParam(':brad_complholder', $brad_compl, PDO::PARAM_STR, 12);
$query->bindParam(':c7holder',$c7, PDO::PARAM_STR, 2500);
$query->bindParam(':agreeholder',$agree, PDO::PARAM_INT);

$query->execute();

echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Lead Gen Audit Successfully Added.
    </div>";

?>
<br>
<br>  
<center>
    <div class="btn-group">
<a href="/audits/lead_gen_reports.php" class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Audit Menu</a>
<a href="/audits/LeadGen.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</a>
<a href="/audits/lead_search.php" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</a>
<a href="#Foo" type="button" data-toggle="collapse" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Show form</a>
    </div>
</center>
<br>
<br>
<br>  

   <div id="Foo" class="collapse"> 
<form class="form-horizontal" action="lead_gen_submit.php" method="POST" autocomplete="off">
<fieldset disabled>

<legend>Submitted Audit</legend>

<input type="hidden" name="auditor" value="<?php echo $hello_name ?>" readonly>

<div class="panel panel-primary">

    <div class="panel-heading">
<h3 class="panel-title">Agent performance</span></h3>
</div>

<div class="panel-body">

    
     <div class="form-group">
  <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
  <div class="col-md-4">
      <input id="provider-json" name='full_name' class='form-control' value='<?php $_POST['full_name'];?>'required placeholder="Lead Gen" class="form-control input-md" type="text">
  </div>
</div>
    
        <div class="form-group">
  <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
  <div class="col-md-4">
  <input id="provider-json" name='full_name2' class='form-control' value='<?php $_POST['full_name2'];?>' placeholder="Lead Gen" class="form-control input-md" type="text">
  </div>
</div>
   
<
    <div class="form-group">
  <label class="col-md-4 control-label" for="grade">Grade:</label>
  <div class="col-md-4">
    <select id="grade" name="grade" class="form-control" required>
      <option value="">Select...</option>
      <option value="Green" <?php if ($_POST['grade']=="Green") echo "selected"?>>Green</option>
      <option value="Amber" <?php if ($_POST['grade']=="Amber") echo "selected"?>>Amber</option>
      <option value="Red" <?php if ($_POST['grade']=="Red") echo "selected"?>Red>Red</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c1">Overall comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c1" name="c1" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c1'] ?></textarea>
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
      <option value="">Select...</option>
      <option value="Excellent" <?php if ($_POST['call_opening']=="Excellent") echo "selected"?>>Excellent</option>
      <option value="Good" <?php if ($_POST['call_opening']=="Good") echo "Good"?>>Good</option>
      <option value="Acceptable" <?php if ($_POST['call_opening']=="Acceptable") echo "selected"?>>Acceptable</option>
      <option value="Unacceptable" <?php if ($_POST['call_opening']=="Unacceptable") echo "selected"?>>Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c2">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c2" name="c2" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c2']?></textarea>
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
      <option value="">Select...</option>
      <option value="Excellent" <?php if ($_POST['full_info']=="Excellent") echo "selected"?>>Excellent</option>
      <option value="Good" <?php if ($_POST['full_info']=="Good") echo "selected"?>>Good</option>
      <option value="Acceptable" <?php if ($_POST['full_info']=="Acceptable") echo "selected"?>>Acceptable</option>
      <option value="Unacceptable" <?php if ($_POST['full_info']=="Unacceptable") echo "selected"?>>Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c3">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c3" name="c3" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c3'] ?></textarea>
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
      <option value="">Select....</option>
      <option value="Excellent" <?php if ($_POST['obj_handled']=="Excellent") echo "selected"?>>Excellent</option>
      <option value="Good" <?php if ($_POST['obj_handled']=="Good") echo "selected"?>>Good</option>
      <option value="Acceptable" <?php if ($_POST['obj_handled']=="Acceptable") echo "selected"?>>Acceptable</option>
      <option value="Unacceptable" <?php if ($_POST['obj_handled']=="Unacceptable") echo "selected"?>>Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c4">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c4" name="c4"  rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c4'] ?></textarea>
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
      <option value="">Select...</option>
      <option value="Excellent" <?php if ($_POST['rapport']=="Excellent") echo "selected"?>>Excellent</option>
      <option value="Good" <?php if ($_POST['rapport']=="Good") echo "selected"?>>Good</option>
      <option value="Acceptable" <?php if ($_POST['rapport']=="Acceptable") echo "selected"?>>Acceptable</option>
      <option value="Unacceptable" <?php if ($_POST['rapport']=="Unacceptable") echo "selected"?>>Unacceptable</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c5">Comments:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c5" name="c5" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c5']?></textarea>
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
      <input name="dealsheet_questions" id="dealsheet_questions-0" value="Yes" <?php if ($_POST['dealsheet_questions']=="Yes") echo "checked"?>  type="radio">
      Yes
    </label> 
    <label class="radio-inline" for="dealsheet_questions-1">
      <input name="dealsheet_questions" id="dealsheet_questions-1" value="No" <?php if ($_POST['dealsheet_questions']=="No") echo "checked"?> type="radio">
      No
    </label>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c6">Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c6" name="c6" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c6']?></textarea>
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
      <input name="brad_compl" id="brad_compl-0" value="Yes" <?php if ($_POST['brad_compl']=="Yes") echo "checked"?> type="radio">
      Yes
    </label> 
    <label class="radio-inline" for="brad_compl-1">
      <input name="brad_compl" id="brad_compl-1" value="No" <?php if ($_POST['brad_compl']=="No") echo "checked"?> type="radio">
      No
    </label>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="c7">Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="c7" name="c7" rows="1" cols="75" maxlength="2500" onkeyup="textAreaAdjust(this)"><?php echo $_POST['c7'] ?></textarea>
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

</div>
</div>
</form>
</div>
 </div>
  

</body>
</html>
