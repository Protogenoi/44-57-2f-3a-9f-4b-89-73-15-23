<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$page_protect->log_out();
}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Closer Audit Submit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
</head>
<body>

<?php include('../../includes/navbar.php'); ?>
<?php include('../../includes/ADL_MYSQLI_CON.php'); ?>
<div class="container">
		
<?php

$answer1 = $_POST['q1'];
$answer2 = $_POST['q2']; 
$answer3 = $_POST['q3']; 
$answer4 = $_POST['q4']; 
$answer5 = $_POST['q5']; 
$answer6 = $_POST['q6']; 
$answer7 = $_POST['q7']; 
$answer8 = $_POST['q8']; 
$answer9 = $_POST['q9'];
$answer10 = $_POST['q10'];
$answer11 = $_POST['q11']; 
$answer12 = $_POST['q12']; 
$answer13 = $_POST['q13']; 
$answer14 = $_POST['q14']; 
$answer15 = $_POST['q15']; 
$answer16 = $_POST['q16']; 
$answer17 = $_POST['q17']; 
$answer18 = $_POST['q18']; 
$answer19 = $_POST['q19']; 
$answer20 = $_POST['q20']; 
$answer21 = $_POST['q21']; 
$answer22 = $_POST['q22']; 
$answer23 = $_POST['q23']; 
$answer24 = $_POST['q24']; 
$answer25 = $_POST['q25']; 
$answer26 = $_POST['q26'];
$answer27 = $_POST['q27']; 
$answer28 = $_POST['q28'];
$answer29 = $_POST['q29']; 
$answer30 = $_POST['q30']; 
$answer31 = $_POST['q31']; 
$answer32 = $_POST['q32']; 
$answer33 = $_POST['q33']; 
$answer34 = $_POST['q34'];
$answer35 = $_POST['q35']; 
$answer36 = $_POST['q36']; 
//$answer37 = $_POST['q37'];
$answer38 = $_POST['q38']; 
$answer39 = $_POST['q39'];
$answer40 = $_POST['q40']; 
$answer41 = $_POST['q41']; 
$answer42 = $_POST['q42']; 
$answer43 = $_POST['q43']; 
$answer44 = $_POST['q44']; 
$answer45 = $_POST['q45']; 
$answer46 = $_POST['q46']; 
$answer47 = $_POST['q47']; 
$answer48 = $_POST['q48']; 
$answer49 = $_POST['q49']; 
$answer50 = $_POST['q50']; 
$answer51 = $_POST['q51']; 
$answer52 = $_POST['q52']; 
$answer53 = $_POST['q53']; 
$answer54 = $_POST['q54']; 
$answer55 = $_POST['q55']; 

$totalCorrect = 0;

if ($answer1 =="Yes") { $totalCorrect++; }
if ($answer2 =="Yes") { $totalCorrect++; }
if ($answer3 =="Yes") { $totalCorrect++; }
if ($answer4 =="Yes") { $totalCorrect++; }
if ($answer5 =="Yes") { $totalCorrect++; }
if ($answer6 =="Yes") { $totalCorrect++; }
if ($answer7 =="Yes") { $totalCorrect++; }
if ($answer8 =="Yes") { $totalCorrect++; }
if ($answer9 =="Yes") { $totalCorrect++; }
if ($answer10 =="Yes") { $totalCorrect++; }
if ($answer11 =="Yes") { $totalCorrect++; }
if ($answer12 =="Yes") { $totalCorrect++; }
if ($answer13 =="Yes") { $totalCorrect++; }
if ($answer14 =="More than sufficient") { $totalCorrect++; }
if ($answer14 =="Sufficient") { $totalCorrect++; }
if ($answer14 =="Adaquate") { $totalCorrect++; }
if ($answer15 =="Yes") { $totalCorrect++; }
if ($answer16 =="Yes") { $totalCorrect++; }
if ($answer17 =="Yes") { $totalCorrect++; }
if ($answer18 =="Yes") { $totalCorrect++; }
if ($answer55 =="Yes") { $totalCorrect++; }
if ($answer19 =="Yes") { $totalCorrect++; }
if ($answer20 =="Yes") { $totalCorrect++; }
if ($answer21 =="Yes") { $totalCorrect++; }
if ($answer22 =="Yes") { $totalCorrect++; }
if ($answer23 =="Yes") { $totalCorrect++; }
if ($answer24 =="Yes") { $totalCorrect++; }
if ($answer25 =="Yes") { $totalCorrect++; }
if ($answer26 =="Yes") { $totalCorrect++; }
if ($answer27 =="Yes") { $totalCorrect++; }
if ($answer28 =="Yes") { $totalCorrect++; }
if ($answer29 =="Client provided details") { $totalCorrect++; }
if ($answer29 =="Client failed to provided details") { $totalCorrect++; }
if ($answer29 =="Not existing L&G customer") { $totalCorrect++; }
if ($answer29 =="Obtained from Term4Term service") { $totalCorrect++; }
if ($answer29 =="Client failed to provide details") { $totalCorrect++; }
if ($answer30 =="Yes") { $totalCorrect++; }
if ($answer31 =="Yes") { $totalCorrect++; }
if ($answer32 =="Yes") { $totalCorrect++; }
if ($answer33 =="Yes") { $totalCorrect++; }
if ($answer34 =="Yes") { $totalCorrect++; }
if ($answer35 =="Yes") { $totalCorrect++; }
if ($answer36 =="Yes") { $totalCorrect++; }
//if ($answer37 =="Yes") { $totalCorrect++; }
if ($answer38 =="Yes") { $totalCorrect++; }
if ($answer39 =="Yes") { $totalCorrect++; }
if ($answer40 =="Yes") { $totalCorrect++; }
if ($answer41 =="Yes") { $totalCorrect++; }
if ($answer42 =="Yes") { $totalCorrect++; }
if ($answer43 =="Yes") { $totalCorrect++; }
if ($answer44 =="Yes") { $totalCorrect++; }
if ($answer45 =="Yes") { $totalCorrect++; }
if ($answer45 =="N/A") { $totalCorrect++; }
if ($answer46 =="Yes") { $totalCorrect++; }
if ($answer46 =="N/A") { $totalCorrect++; }
if ($answer47 =="Yes") { $totalCorrect++; }
if ($answer48 =="Yes") { $totalCorrect++; }
if ($answer49 =="Yes") { $totalCorrect++; }
if ($answer50 =="Yes") { $totalCorrect++; }
if ($answer51 =="Yes") { $totalCorrect++; }
if ($answer52 =="Yes") { $totalCorrect++; }
if ($answer53 =="Yes") { $totalCorrect++; }
if ($answer53 =="N/A") { $totalCorrect++; }
if ($answer54 =="Yes") { $totalCorrect++; }
if ($answer54 =="N/A") { $totalCorrect++; }

$total = 54;
$percentage = $totalCorrect/$total * 100;

$totalincorrect = 0;

if ($answer1 =="No") { $totalincorrect++; }
if ($answer2 =="No") { $totalincorrect++; }
if ($answer3 =="No") { $totalincorrect++; }
if ($answer4 =="No") { $totalincorrect++; }
if ($answer5 =="No") { $totalincorrect++; }
if ($answer6 =="No") { $totalincorrect++; }
if ($answer7 =="No") { $totalincorrect++; }
if ($answer8 =="No") { $totalincorrect++; }
if ($answer9 =="No") { $totalincorrect++; }
if ($answer10 =="No") { $totalincorrect++; }
if ($answer11 =="No") { $totalincorrect++; }
if ($answer12 =="No") { $totalincorrect++; }
if ($answer13 =="No") { $totalincorrect++; }
if ($answer15 =="No") { $totalincorrect++; }
if ($answer16 =="No") { $totalincorrect++; }
if ($answer17 =="No") { $totalincorrect++; }
if ($answer18 =="No") { $totalincorrect++; }
if ($answer55 =="No") { $totalincorrect++; }
if ($answer19 =="No") { $totalincorrect++; }
if ($answer20 =="No") { $totalincorrect++; }
if ($answer21 =="No") { $totalincorrect++; }
if ($answer22 =="No") { $totalincorrect++; }
if ($answer23 =="No") { $totalincorrect++; }
if ($answer24 =="No") { $totalincorrect++; }
if ($answer25 =="No") { $totalincorrect++; }
if ($answer26 =="No") { $totalincorrect++; }
if ($answer27 =="No") { $totalincorrect++; }
if ($answer28 =="No") { $totalincorrect++; }
if ($answer29 =="Existing L&G Policy, no attempt to get policy number") { $totalincorrect++; }
if ($answer34 =="No") { $totalincorrect++; }

$red = "Status Red";
$amber = "Status Amber";
$green = "Status Green";
$red = "Status Red";
$total2 = 29;
$percentage2 = $totalincorrect/$total2 * 100;
$totalincorrect;

echo "<h2>Audit Results:</h2>";

$gradeswitch = "$_POST[formgrade]";

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
        <strong>Audit Score:</strong> $totalCorrect / 54 answered correctly ($percentage%).
    </div>";

$annumber= filter_input(INPUT_POST, 'annumber', FILTER_SANITIZE_SPECIAL_CHARS);

$annumber=preg_replace('/\s+/', '', $annumber);

$_POST['c1'] = mysqli_real_escape_string($conn, $_POST['c1']);
$_POST['c2'] = mysqli_real_escape_string($conn, $_POST['c2']);
$_POST['c3'] = mysqli_real_escape_string($conn, $_POST['c3']);
$_POST['c4'] = mysqli_real_escape_string($conn, $_POST['c4']);
$_POST['c5'] = mysqli_real_escape_string($conn, $_POST['c5']);
$_POST['c6'] = mysqli_real_escape_string($conn, $_POST['c6']);
$_POST['c7'] = mysqli_real_escape_string($conn, $_POST['c7']);
$_POST['c8'] = mysqli_real_escape_string($conn, $_POST['c8']);
$_POST['c9'] = mysqli_real_escape_string($conn, $_POST['c9']);
$_POST['c10'] = mysqli_real_escape_string($conn, $_POST['c10']);
$_POST['c11'] = mysqli_real_escape_string($conn, $_POST['c11']);
$_POST['c12'] = mysqli_real_escape_string($conn, $_POST['c12']);
$_POST['c13'] = mysqli_real_escape_string($conn, $_POST['c13']);
$_POST['c14'] = mysqli_real_escape_string($conn, $_POST['c14']);
$_POST['c15'] = mysqli_real_escape_string($conn, $_POST['c15']);
$_POST['c16'] = mysqli_real_escape_string($conn, $_POST['c16']);
$_POST['c17'] = mysqli_real_escape_string($conn, $_POST['c17']);
$_POST['c18'] = mysqli_real_escape_string($conn, $_POST['c18']);
$_POST['c19'] = mysqli_real_escape_string($conn, $_POST['c19']);
$_POST['c20'] = mysqli_real_escape_string($conn, $_POST['c20']);
$_POST['c21'] = mysqli_real_escape_string($conn, $_POST['c21']);
$_POST['c22'] = mysqli_real_escape_string($conn, $_POST['c22']);
$_POST['c23'] = mysqli_real_escape_string($conn, $_POST['c23']);
$_POST['c24'] = mysqli_real_escape_string($conn, $_POST['c24']);
$_POST['c25'] = mysqli_real_escape_string($conn, $_POST['c25']);
$_POST['c26'] = mysqli_real_escape_string($conn, $_POST['c26']);
$_POST['c27'] = mysqli_real_escape_string($conn, $_POST['c27']);
$_POST['c28'] = mysqli_real_escape_string($conn, $_POST['c28']);
$_POST['c29'] = mysqli_real_escape_string($conn, $_POST['c29']);
$_POST['c30'] = mysqli_real_escape_string($conn, $_POST['c30']);
$_POST['c31'] = mysqli_real_escape_string($conn, $_POST['c31']);
$_POST['c32'] = mysqli_real_escape_string($conn, $_POST['c32']);
$_POST['c33'] = mysqli_real_escape_string($conn, $_POST['c33']);
$_POST['c34'] = mysqli_real_escape_string($conn, $_POST['c34']);
$_POST['c35'] = mysqli_real_escape_string($conn, $_POST['c35']);
$_POST['c36'] = mysqli_real_escape_string($conn, $_POST['c36']);
$_POST['c37'] = mysqli_real_escape_string($conn, $_POST['c37']);
$_POST['c38'] = mysqli_real_escape_string($conn, $_POST['c38']);
$_POST['c39'] = mysqli_real_escape_string($conn, $_POST['c39']);
$_POST['c40'] = mysqli_real_escape_string($conn, $_POST['c40']);
$_POST['c41'] = mysqli_real_escape_string($conn, $_POST['c41']);
$_POST['c42'] = mysqli_real_escape_string($conn, $_POST['c42']);
$_POST['c43'] = mysqli_real_escape_string($conn, $_POST['c43']);
$_POST['c44'] = mysqli_real_escape_string($conn, $_POST['c44']);
$_POST['c45'] = mysqli_real_escape_string($conn, $_POST['c45']);
$_POST['c46'] = mysqli_real_escape_string($conn, $_POST['c46']);
$_POST['c47'] = mysqli_real_escape_string($conn, $_POST['c47']);
$_POST['c48'] = mysqli_real_escape_string($conn, $_POST['c48']);
$_POST['c49'] = mysqli_real_escape_string($conn, $_POST['c49']);
$_POST['c50'] = mysqli_real_escape_string($conn, $_POST['c50']);
$_POST['c51'] = mysqli_real_escape_string($conn, $_POST['c51']);
$_POST['c52'] = mysqli_real_escape_string($conn, $_POST['c52']);
$_POST['c53'] = mysqli_real_escape_string($conn, $_POST['c53']);
$_POST['c54'] = mysqli_real_escape_string($conn, $_POST['c54']);
$_POST['c55'] = mysqli_real_escape_string($conn, $_POST['c55']);



$sql = "INSERT INTO closer_audits (an_number, edited, date_edited, total, cal_grade, score, date_submitted , closer, closer2, auditor, policy_number, grade, q1, c1, q2, c2, q3, c3, q4, c4, q5, c5, q6, c6, q7, c7, q8, c8, q9, c9, q10, c10, q11, c11, q12, c12, q13, c13, q14, c14, q15, c15, q16, c16, q17, c17, q18, c18, q19, c19, q20, c20, q21, c21, q22, c22, q23, c23, q24, c24, q25, c25, q26, c26, q27, c27, q28, c28, q29, c29, q30, c30, q31, c31, q32, c32, q33, c33, q34, c34, q35, c35, q36, c36, c37, q38, c38, q39, c39, q40, c40, q41, c41, q42, c42, q43, c43, q44, c44, q45, c45, q46, c46, q47, c47, q48, c48, q49, c49, q50, c50, q51, c51, q52, c52, q53, c53, q54, c54, q55, c55, agree) 
VALUES ('$annumber',' ', '0000-00-00 00-00-00', '$totalCorrect', '".$percentage2."','".$percentage."', CURRENT_TIMESTAMP, '$_POST[full_name]', '$_POST[full_name2]', '$_POST[auditor]', '$_POST[policy_id]', '$_POST[formgrade]', '$_POST[q1]', '$_POST[c1]', '$_POST[q2]', '$_POST[c2]', '$_POST[q3]', '$_POST[c3]', '$_POST[q4]', '$_POST[c4]', '$_POST[q5]', '$_POST[c5]', '$_POST[q6]', '$_POST[c6]', '$_POST[q7]', '$_POST[c7]', '$_POST[q8]', '$_POST[c8]','$_POST[q9]', '$_POST[c9]', '$_POST[q10]','$_POST[c10]', '$_POST[q11]', '$_POST[c11]', '$_POST[q12]', '$_POST[c12]', '$_POST[q13]', '$_POST[c13]', '$_POST[q14]', '$_POST[c14]', '$_POST[q15]', '$_POST[c15]', '$_POST[q16]', '$_POST[c16]', '$_POST[q17]', '$_POST[c17]', '$_POST[q18]', '$_POST[c18]', '$_POST[q19]', '$_POST[c19]', '$_POST[q20]', '$_POST[c20]', '$_POST[q21]', '$_POST[c21]', '$_POST[q22]', '$_POST[c22]', '$_POST[q23]', '$_POST[c23]', '$_POST[q24]', '$_POST[c24]', '$_POST[q25]', '$_POST[c25]', '$_POST[q26]', '$_POST[c26]', '$_POST[q27]', '$_POST[c27]', '$_POST[q28]', '$_POST[c28]', '$_POST[q29]', '$_POST[c29]', '$_POST[q30]', '$_POST[c30]', '$_POST[q31]', '$_POST[c31]', '$_POST[q32]', '$_POST[c32]', '$_POST[q33]', '$_POST[c33]', '$_POST[q34]', '$_POST[c34]', '$_POST[q35]', '$_POST[c35]', '$_POST[q36]',  '$_POST[q37]', '$_POST[c36]', '$_POST[q38]', '$_POST[c38]', '$_POST[q39]', '$_POST[c39]', '$_POST[q40]', '$_POST[c40]', '$_POST[q41]', '$_POST[c41]', '$_POST[q42]', '$_POST[c42]', '$_POST[q43]', '$_POST[c43]', '$_POST[q44]', '$_POST[c44]', '$_POST[q45]', '$_POST[c45]', '$_POST[q46]', '$_POST[c46]', '$_POST[q47]', '$_POST[c47]', '$_POST[q48]', '$_POST[c48]', '$_POST[q49]', '$_POST[c49]', '$_POST[q50]', '$_POST[c50]', '$_POST[q51]', '$_POST[c51]', '$_POST[q52]', '$_POST[c52]', '$_POST[q53]', '$_POST[c53]', '$_POST[q54]', '$_POST[c54]', '$_POST[q55]', '$_POST[c55]', '$_POST[agree]' )";

if (mysqli_query($conn, $sql)) {
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Closer Audit Successfully Added.
    </div>";
} else {
    echo "<div class=\"warningalert\">
    <div class=\"notice notice-danger fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Error!</strong> Error: " . $sql . "<br>.
    </div>" . mysqli_error($conn);
}

$test = mysqli_insert_id($conn);



$conn->close();
?>


<center>
    <div class="btn-group">
<a href="/audits/auditor_menu.php" class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Audit Menu</a>
<a href="/audits/CloserAudit.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</a>
<a href="#" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Create Notes</a>
<a href="/audits/audit_search.php" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</a>
<a href="/audits/closer_form_edit.php?auditid=<?php echo $test?>"class="btn btn-warning "><span class="glyphicon glyphicon-edit"></span> Edit Audit</a>
<a href="#" class="btn btn-danger "><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Audit</a>
    </div>
</center>
<br>
<br>
<br>
 </div>


</body>
</html>
