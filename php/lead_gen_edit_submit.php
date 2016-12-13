<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Lead Gen Edit Submit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
</head>
<body >


<?php include('../includes/navbar.php');
include('../includes/PDOcon.php');

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
    <div class=\"alert alert-danger fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade</strong> Status Red ($percentage2%).
    </div>";
        break;
    case "Amber":
        echo "<div class=\"editpolicy\">
    <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> Status Amber ($percentage2%).
    </div>";
        break;
    case "Green":
        echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> Status Green ($percentage2%).
    </div>";
        break;
    default:
        echo "<div class=\"editpolicy\">
    <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Grade:</strong> No Grade - Audit Saved.
    </div>";
}

echo "<div class=\"editpolicy\">
    <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Audit Score:</strong> $totalCorrect / 6 answered correctly ($percentage%).
    </div>";


$_POST['c1'] = mysqli_real_escape_string($conn, $_POST['c1']);
$_POST['c2'] = mysqli_real_escape_string($conn, $_POST['c2']);
$_POST['c3'] = mysqli_real_escape_string($conn, $_POST['c3']);
$_POST['c4'] = mysqli_real_escape_string($conn, $_POST['c4']);
$_POST['c5'] = mysqli_real_escape_string($conn, $_POST['c5']);
$_POST['c6'] = mysqli_real_escape_string($conn, $_POST['c6']);
$_POST['c7'] = mysqli_real_escape_string($conn, $_POST['c7']);

 
$auditid=$_POST['auditid'];
$keyfield=$_POST['keyfield'];
$edited_by=$_POST['edited']; 
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
$lead_gen_name=$_POST['lead_gen_name'];
$lead_gen_name2=$_POST['lead_gen_name2'];

$sql = "UPDATE `lead_gen_audit` 
SET
total='$totalCorrect',
lead_gen_name='$lead_gen_name',
lead_gen_name2='$lead_gen_name2',
cal_grade='$percentage2',
score='$percentage', 
edited='$edited_by', 
grade='$grade', 
c1='$c1', 
call_opening='$call_opening', 
c2='$c2', 
full_info='$full_info', 
c3='$c3', 
obj_handled='$obj_handled', 
c4='$c4', 
rapport='$rapport', 
c5='$c5', 
dealsheet_questions='$dealsheet_questions', 
c6='$c6', 
brad_compl='$brad_compl', 
c7='$c7',
date_edited=CURRENT_TIMESTAMP
WHERE ID= '$keyfield' OR ID= '$auditid' ";
 
if (mysqli_query($conn, $sql)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Lead Gen Audit Edited Successfully.
    </div>";
} else {
    echo "<div class=\"warningalert\">
    <div class=\"alert alert-danger fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Error!</strong> Error: " . $sql . "<br>.
    </div>" . mysqli_error($conn);
}
  
mysqli_close($conn);

?>

<center>
<a href="/lead_gen_reports.php">
<button type="button" class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Audit Menu</button>
</a>
<a href="/LeadGen.php">
<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</button>
</a>
<a href="#">
<button type="button" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Create Notes</button>
</a>
<a href="/lead_search.php">
<button type="button" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</button>
</a>
<a href="#">
<button type="button" class="btn btn-danger "><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Audit</button>
</a>
</center>


   </div>
  </div>
</div>

</body>
</html>
