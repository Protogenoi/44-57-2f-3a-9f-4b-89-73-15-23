<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out();
}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Closer Edit Submit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<?php include('../../includes/navbar.php'); ?>
<?php include('../../includes/PDOcon.php'); ?>

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
if ($answer55 =="Yes") { $totalCorrect++; }

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
$total2 = 28;
$percentage2 = $totalincorrect/$total2 * 100;
$totalincorrect;
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
        <strong>Audit Score:</strong> $totalCorrect / 54 answered correctly ($percentage%).
    </div>";




$auditid=$_POST['auditid'];
$closer=$_POST['closer'];
$closer2=$_POST['closer2'];
$keyfield=$_POST['keyfield'];
$edited_by=$_POST['edited']; 
$policy_number=$_POST['policy_number']; 
$grade=$_POST['grade']; 
$q1=$_POST['q1'];
$c1=$_POST['c1'];
$q2=$_POST['q2'];
$c2=$_POST['c2'];
$q3=$_POST['q3'];
$c3=$_POST['c3'];
$q4=$_POST['q4'];
$c4=$_POST['c4'];
$q5=$_POST['q5'];
$c5=$_POST['c5'];
$q6=$_POST['q6'];
$c6=$_POST['c6'];
$q7=$_POST['q7'];
$c7=$_POST['c7'];
$q8=$_POST['q8'];
$c8=$_POST['c8'];
$q9=$_POST['q9'];
$c9=$_POST['c9'];
$q10=$_POST['q10'];
$c10=$_POST['c10'];
$q11=$_POST['q11'];
$c11=$_POST['c11'];
$q12=$_POST['q12'];
$c12=$_POST['c12'];
$q13=$_POST['q13'];
$c13=$_POST['c13'];
$q14=$_POST['q14'];
$c14=$_POST['c14'];
$q15=$_POST['q15'];
$c15=$_POST['c15'];
$q16=$_POST['q16'];
$c16=$_POST['c16'];
$q17=$_POST['q17'];
$c17=$_POST['c17'];
$q18=$_POST['q18'];
$c18=$_POST['c18'];
$q19=$_POST['q19'];
$c19=$_POST['c19'];
$q20=$_POST['q20'];
$c20=$_POST['c20'];
$q21=$_POST['q21'];
$c21=$_POST['c21'];
$q22=$_POST['q22'];
$c22=$_POST['c22'];
$q23=$_POST['q23'];
$c23=$_POST['c23'];
$q24=$_POST['q24'];
$c24=$_POST['c24'];
$q25=$_POST['q25'];
$c25=$_POST['c25'];
$q26=$_POST['q26'];
$c26=$_POST['c26'];
$q27=$_POST['q27'];
$c27=$_POST['c27'];
$q28=$_POST['q28'];
$c28=$_POST['c28'];
$q29=$_POST['q29'];
$c29=$_POST['c29'];
$q30=$_POST['q30'];
$c30=$_POST['c30'];
$q31=$_POST['q31'];
$c31=$_POST['c31'];
$q32=$_POST['q32'];
$c32=$_POST['c32'];
$q33=$_POST['q33'];
$c33=$_POST['c33'];
$q34=$_POST['q34'];
$c34=$_POST['c34'];
$q35=$_POST['q35'];
$c35=$_POST['c35'];
$q36=$_POST['q36'];
$c36=$_POST['c36'];
//$q37=$_POST['q37'];
//$c37=$_POST['c37'];
$q38=$_POST['q38'];
$c38=$_POST['c38'];
$q39=$_POST['q39'];
$c39=$_POST['c39'];
$q40=$_POST['q40'];
$c40=$_POST['c40'];
$q41=$_POST['q41'];
$c41=$_POST['c41'];
$q42=$_POST['q42'];
$c42=$_POST['c42'];
$q43=$_POST['q43'];
$c43=$_POST['c43'];
$q44=$_POST['q44'];
$c44=$_POST['c44'];
$q45=$_POST['q45'];
$c45=$_POST['c45'];
$q46=$_POST['q46'];
$c46=$_POST['c46'];
$q47=$_POST['q47'];
$c47=$_POST['c47'];
$q48=$_POST['q48'];
$c48=$_POST['c48'];
$q49=$_POST['q49'];
$c49=$_POST['c49'];
$q50=$_POST['q50'];
$c50=$_POST['c50'];
$q51=$_POST['q51'];
$c51=$_POST['c51'];
$q52=$_POST['q52'];
$c52=$_POST['c52'];
$q53=$_POST['q53'];
$c53=$_POST['c53'];
$q54=$_POST['q54'];
$c54=$_POST['c54'];
$q55=$_POST['q55'];
$c55=$_POST['c55'];
$lead_id=$_POST['lead_id'];
$lead_id2=$_POST['lead_id2'];
$lead_id3=$_POST['lead_id3'];


$query = $pdo->prepare("UPDATE closer_audits SET total= :totalCorrectholder, closer= :closerholder, closer2= :closer2holder, lead_id= :leadholder, lead_id2= :lead2holder, lead_id3= :lead3holder, cal_grade= :percentage2holder, score= :percentageholder, edited= :edited_byholder, policy_number= :policy_numberholder, grade= :gradeholder, q1= :q1holder, c1= :c1holder, q2= :q2holder, c2= :c2holder, q3= :q3holder, c3= :c3holder, q4= :q4holder, c4= :c4holder, q5= :q5holder, c5= :c5holder, q6= :q6holder, c6= :c6holder, q7= :q7holder, c7= :c7holder, q8= :q8holder, c8= :c8holder, q9= :q9holder, c9= :c9holder, q10= :q10holder, c10= :c10holder, q11= :q11holder, c11= :c11holder, q12= :q12holder, c12= :c12holder, q13= :q13holder, c13= :c13holder, q14= :q14holder, c14= :c14holder, q15= :q15holder, c15= :c15holder, q16= :q16holder, c16= :c16holder, q17= :q17holder, c17= :c17holder, q18= :q18holder, c18= :c18holder, q19= :q19holder, c19= :c19holder, q20= :q20holder, c20= :c20holder, q21= :q21holder, c21= :c21holder, q22= :q22holder, c22= :c22holder, q23= :q23holder, c23= :c23holder, q24= :q24holder, c24= :c24holder, q25= :q25holder, c25= :c25holder, q26= :q26holder, c26= :c26holder, q27= :q27holder, c27= :c27holder, q28= :q28holder, c28= :c28holder, q29= :q29holder, c29= :c29holder, q30= :q30holder, c30= :c30holder, q31= :q31holder, c31= :c31holder, q32= :q32holder, c32= :c32holder, q33= :q33holder, c33= :c33holder, q34= :q34holder, c34= :c34holder, q35= :q35holder, c35= :c35holder, q36= :q36holder, c36= :c36holder, q38= :q38holder, q39= :q39holder, q40= :q40holder, q41= :q41holder, q42= :q42holder, q43= :q43holder, q44= :q44holder, q45= :q45holder, q46= :q46holder, q47= :q47holder, q48= :q48holder, q49= :q49holder, q50= :q50holder, q51= :q51holder, q52= :q52holder, c38= :c38holder, c39= :c39holder, c40= :c40holder, c41= :c41holder, c42= :c42holder, c43= :c43holder, c44= :c44holder, c45= :c45holder, c46= :c46holder, c47= :c47holder, c48= :c48holder, c49= :c49holder, c50= :c50holder, c51= :c51holder, c52= :c52holder, q53= :q53holder, c53= :c53holder, q54= :q54holder, c54= :c54holder, q55= :q55holder, c55= :c55holder, date_edited=CURRENT_TIMESTAMP WHERE ID= :keyfieldholder OR ID= :auditidholder"); 

$query->bindParam(':leadgennameplaceholder ',$lead_gen_name, PDO::PARAM_STR, 2500);
$query->bindParam(':leadgennameplaceholder ',$lead_gen_name, PDO::PARAM_STR, 2500);
$query->bindParam(':totalCorrectholder',$total, PDO::PARAM_STR, 2500);
$query->bindParam(':closerholder',$closer, PDO::PARAM_STR, 2500);
$query->bindParam(':closer2holder',$closer2, PDO::PARAM_STR, 2500);
$query->bindParam(':leadholder ',$lead_id, PDO::PARAM_STR, 2500);
$query->bindParam(':lead2holder ',$lead_id2, PDO::PARAM_STR, 2500);
$query->bindParam(':lead3holder',$lead_id3, PDO::PARAM_STR, 2500);
$query->bindParam(':percentage2holder',$cal_grade, PDO::PARAM_STR, 2500);
$query->bindParam(':percentageholder ',$score, PDO::PARAM_STR, 2500);
$query->bindParam(':edited_byholder ',$edited, PDO::PARAM_STR, 2500);
$query->bindParam(':policy_numberholder ',$policy_number, PDO::PARAM_STR, 2500);
$query->bindParam(':gradeholder ',$grade, PDO::PARAM_STR, 2500);
$query->bindParam(':q1holder',$q1, PDO::PARAM_STR, 2500);
$query->bindParam(':c1holder',$c1, PDO::PARAM_STR, 2500);
$query->bindParam(':q2holder',$q2, PDO::PARAM_STR, 2500);
$query->bindParam(':c2holder',$c2, PDO::PARAM_STR, 2500);
$query->bindParam(':q3holder',$q3, PDO::PARAM_STR, 2500);
$query->bindParam(':c3holder',$c3, PDO::PARAM_STR, 2500);
$query->bindParam(':q4holder',$q4, PDO::PARAM_STR, 2500);
$query->bindParam(':c4holder',$c4, PDO::PARAM_STR, 2500);
$query->bindParam(':q5holder',$q5, PDO::PARAM_STR, 2500);
$query->bindParam(':c5holder',$c5, PDO::PARAM_STR, 2500);
$query->bindParam(':q6holder',$q6, PDO::PARAM_STR, 2500);
$query->bindParam(':c6holder',$c6, PDO::PARAM_STR, 2500);
$query->bindParam(':q7holder',$q7, PDO::PARAM_STR, 2500);
$query->bindParam(':c7holder',$c7, PDO::PARAM_STR, 2500);
$query->bindParam(':q8holder',$q8, PDO::PARAM_STR, 2500);
$query->bindParam(':c8holder',$c8, PDO::PARAM_STR, 2500);
$query->bindParam(':q9holder',$q9, PDO::PARAM_STR, 2500);
$query->bindParam(':c9holder',$c9, PDO::PARAM_STR, 2500);
$query->bindParam(':q10holder',$q10, PDO::PARAM_STR, 2500);
$query->bindParam(':c10holder',$c10, PDO::PARAM_STR, 2500);
$query->bindParam(':q11holder',$q11, PDO::PARAM_STR, 2500);
$query->bindParam(':c11holder',$c11, PDO::PARAM_STR, 2500);
$query->bindParam(':q12holder',$q12, PDO::PARAM_STR, 2500);
$query->bindParam(':c12holder',$c12, PDO::PARAM_STR, 2500);
$query->bindParam(':q13holder',$q13, PDO::PARAM_STR, 2500);
$query->bindParam(':c13holder',$c13, PDO::PARAM_STR, 2500);
$query->bindParam(':q14holder',$q14, PDO::PARAM_STR, 2500);
$query->bindParam(':c14holder',$c14, PDO::PARAM_STR, 2500);
$query->bindParam(':q15holder',$q15, PDO::PARAM_STR, 2500);
$query->bindParam(':c15holder',$c15, PDO::PARAM_STR, 2500);
$query->bindParam(':q16holder',$q16, PDO::PARAM_STR, 2500);
$query->bindParam(':c16holder',$c16, PDO::PARAM_STR, 2500);
$query->bindParam(':q17holder',$q17, PDO::PARAM_STR, 2500);
$query->bindParam(':c17holder',$c17, PDO::PARAM_STR, 2500);
$query->bindParam(':q18holder',$q18, PDO::PARAM_STR, 2500);
$query->bindParam(':c18holder',$c18, PDO::PARAM_STR, 2500);
$query->bindParam(':q19holder',$q19, PDO::PARAM_STR, 2500);
$query->bindParam(':c19holder',$c19, PDO::PARAM_STR, 2500);
$query->bindParam(':q20holder',$q20, PDO::PARAM_STR, 2500);
$query->bindParam(':c20holder',$c20, PDO::PARAM_STR, 2500);
$query->bindParam(':q21holder',$q21, PDO::PARAM_STR, 2500);
$query->bindParam(':c21holder',$c21, PDO::PARAM_STR, 2500);
$query->bindParam(':q22holder',$q22, PDO::PARAM_STR, 2500);
$query->bindParam(':c22holder',$c22, PDO::PARAM_STR, 2500);
$query->bindParam(':q23holder',$q23, PDO::PARAM_STR, 2500);
$query->bindParam(':c23holder',$c23, PDO::PARAM_STR, 2500);
$query->bindParam(':q24holder',$q24, PDO::PARAM_STR, 2500);
$query->bindParam(':c24holder',$c24, PDO::PARAM_STR, 2500);
$query->bindParam(':q25holder',$q25, PDO::PARAM_STR, 2500);
$query->bindParam(':c25holder',$c25, PDO::PARAM_STR, 2500);
$query->bindParam(':q26holder',$q26, PDO::PARAM_STR, 2500);
$query->bindParam(':c26holder',$c26, PDO::PARAM_STR, 2500);
$query->bindParam(':q27holder',$q27, PDO::PARAM_STR, 2500);
$query->bindParam(':c27holder',$c27, PDO::PARAM_STR, 2500);
$query->bindParam(':q28holder',$q28, PDO::PARAM_STR, 2500);
$query->bindParam(':c28holder',$c28, PDO::PARAM_STR, 2500);
$query->bindParam(':q29holder',$q29, PDO::PARAM_STR, 2500);
$query->bindParam(':c29holder',$c29, PDO::PARAM_STR, 2500);
$query->bindParam(':q30holder',$q30, PDO::PARAM_STR, 2500);
$query->bindParam(':c30holder',$c30, PDO::PARAM_STR, 2500);
$query->bindParam(':q31holder',$q31, PDO::PARAM_STR, 2500);
$query->bindParam(':c31holder',$c31, PDO::PARAM_STR, 2500);
$query->bindParam(':q32holder',$q32, PDO::PARAM_STR, 2500);
$query->bindParam(':c32holder',$c32, PDO::PARAM_STR, 2500);
$query->bindParam(':q33holder',$q33, PDO::PARAM_STR, 2500);
$query->bindParam(':c33holder',$c33, PDO::PARAM_STR, 2500);
$query->bindParam(':q34holder',$q34, PDO::PARAM_STR, 2500);
$query->bindParam(':c34holder',$c34, PDO::PARAM_STR, 2500);
$query->bindParam(':q35holder',$q35, PDO::PARAM_STR, 2500);
$query->bindParam(':c35holder',$c35, PDO::PARAM_STR, 2500);
$query->bindParam(':q36holder',$q36, PDO::PARAM_STR, 2500);
$query->bindParam(':c36holder',$c36, PDO::PARAM_STR, 2500);
$query->bindParam(':q38holder',$q38, PDO::PARAM_STR, 2500);
$query->bindParam(':q39holder',$q39, PDO::PARAM_STR, 2500);
$query->bindParam(':q40holder',$q40, PDO::PARAM_STR, 2500);
$query->bindParam(':q41holder',$q41, PDO::PARAM_STR, 2500);
$query->bindParam(':q42holder',$q42, PDO::PARAM_STR, 2500);
$query->bindParam(':q43holder',$q43, PDO::PARAM_STR, 2500);
$query->bindParam(':q44holder',$q44, PDO::PARAM_STR, 2500);
$query->bindParam(':q45holder',$q45, PDO::PARAM_STR, 2500);
$query->bindParam(':q46holder',$q46, PDO::PARAM_STR, 2500);
$query->bindParam(':q47holder',$q47, PDO::PARAM_STR, 2500);
$query->bindParam(':q48holder',$q48, PDO::PARAM_STR, 2500);
$query->bindParam(':q49holder',$q49, PDO::PARAM_STR, 2500);
$query->bindParam(':q50holder',$q50, PDO::PARAM_STR, 2500);
$query->bindParam(':q51holder',$q51, PDO::PARAM_STR, 2500);
$query->bindParam(':q52holder',$q52, PDO::PARAM_STR, 2500);
$query->bindParam(':c38holder',$c38, PDO::PARAM_STR, 2500);
$query->bindParam(':c39holder',$c39, PDO::PARAM_STR, 2500);
$query->bindParam(':c40holder',$c40, PDO::PARAM_STR, 2500);
$query->bindParam(':c41holder',$c41, PDO::PARAM_STR, 2500);
$query->bindParam(':c42holder',$c42, PDO::PARAM_STR, 2500);
$query->bindParam(':c43holder',$c43, PDO::PARAM_STR, 2500);
$query->bindParam(':c44holder',$c44, PDO::PARAM_STR, 2500);
$query->bindParam(':c45holder',$c45, PDO::PARAM_STR, 2500);
$query->bindParam(':c46holder',$c46, PDO::PARAM_STR, 2500);
$query->bindParam(':c47holder',$c47, PDO::PARAM_STR, 2500);
$query->bindParam(':c48holder',$c48, PDO::PARAM_STR, 2500);
$query->bindParam(':c49holder',$c49, PDO::PARAM_STR, 2500);
$query->bindParam(':c50holder',$c50, PDO::PARAM_STR, 2500);
$query->bindParam(':c51holder',$c51, PDO::PARAM_STR, 2500);
$query->bindParam(':c52holder',$c52, PDO::PARAM_STR, 2500);
$query->bindParam(':q53holder',$q53, PDO::PARAM_STR, 2500);
$query->bindParam(':c53holder',$c53, PDO::PARAM_STR, 2500);
$query->bindParam(':q54holder',$q54, PDO::PARAM_STR, 2500);
$query->bindParam(':c54holder',$c54, PDO::PARAM_STR, 2500);
$query->bindParam(':q55holder',$q55, PDO::PARAM_STR, 2500);
$query->bindParam(':c55holder',$c55, PDO::PARAM_STR, 2500);
$query->bindParam(':keyfieldholder',$ID, PDO::PARAM_STR, 2500);
$query->bindParam(':auditidholder',$ID, PDO::PARAM_STR, 2500);

$query->execute();

echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Closer Audit Successfully Added.
    </div>";

?>

<center>
    <div class="btn-group">
<a href="/audits/auditor_menu.php"class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Audit Menu</a>
<a href="/audits/CloserAudit.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</a>
<a href="<?php echo $hello_name?>/CallNotes.php" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Create Notes</a>
<a href="/audits/audit_search.php" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</a>
<a href="#" class="btn btn-danger "><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Audit</a>
    </div>
</center>

   </div>
  </div>
</div>

</body>
</html>
