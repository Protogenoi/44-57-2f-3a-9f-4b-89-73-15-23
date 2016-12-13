<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/ADL_PDO_CON.php');
$annumber= filter_input(INPUT_POST, 'annumber', FILTER_SANITIZE_SPECIAL_CHARS);

$annumber=preg_replace('/\s+/', '', $annumber);

$newedit= filter_input(INPUT_GET, 'newedit', FILTER_SANITIZE_SPECIAL_CHARS);
    $agent= filter_input(INPUT_POST, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);
    $sq1= filter_input(INPUT_POST, 'sq1', FILTER_SANITIZE_SPECIAL_CHARS);
    $sq2= filter_input(INPUT_POST, 'sq2', FILTER_SANITIZE_SPECIAL_CHARS);
    $sq3= filter_input(INPUT_POST, 'sq3', FILTER_SANITIZE_SPECIAL_CHARS);
    $sq4= filter_input(INPUT_POST, 'sq4', FILTER_SANITIZE_SPECIAL_CHARS);
    $sq5= filter_input(INPUT_POST, 'sq5', FILTER_SANITIZE_SPECIAL_CHARS);    
    $s2aq1= filter_input(INPUT_POST, 's2aq1', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq2= filter_input(INPUT_POST, 's2aq2', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq3= filter_input(INPUT_POST, 's2aq3', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq4= filter_input(INPUT_POST, 's2aq4', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq5= filter_input(INPUT_POST, 's2aq5', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq6= filter_input(INPUT_POST, 's2aq6', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq7= filter_input(INPUT_POST, 's2aq7', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq8= filter_input(INPUT_POST, 's2aq8', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq9= filter_input(INPUT_POST, 's2aq9', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq10= filter_input(INPUT_POST, 's2aq10', FILTER_SANITIZE_SPECIAL_CHARS);
    $s2aq11= filter_input(INPUT_POST, 's2aq11', FILTER_SANITIZE_SPECIAL_CHARS);    
    $s2bq1= filter_input(INPUT_POST, 's2bq1', FILTER_SANITIZE_SPECIAL_CHARS);
    $q1s2bc1= filter_input(INPUT_POST, 'q1s2bc1', FILTER_SANITIZE_SPECIAL_CHARS);    
    $q2s2bq2= filter_input(INPUT_POST, 'q2s2bq2', FILTER_SANITIZE_SPECIAL_CHARS);
    $q2s2bc2= filter_input(INPUT_POST, 'q2s2bc2', FILTER_SANITIZE_SPECIAL_CHARS);    
    $q1s3q1= filter_input(INPUT_POST, 'q1s3q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $q1s3c1= filter_input(INPUT_POST, 'q1s3c1', FILTER_SANITIZE_SPECIAL_CHARS);    
    $grade= filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);
    $newauditedit= filter_input(INPUT_POST, 'editidsent', FILTER_SANITIZE_SPECIAL_CHARS);    
    $q1s4q1n= filter_input(INPUT_POST, 'q1s4q1n', FILTER_SANITIZE_SPECIAL_CHARS);
    $q1s4c1n= filter_input(INPUT_POST, 'q1s4c1n', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $q1TEXT= filter_input(INPUT_POST, 'q1TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q2TEXT= filter_input(INPUT_POST, 'q2TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q3TEXT= filter_input(INPUT_POST, 'q3TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q4TEXT= filter_input(INPUT_POST, 'q4TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q5TEXT= filter_input(INPUT_POST, 'q5TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q6TEXT= filter_input(INPUT_POST, 'q6TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q7TEXT= filter_input(INPUT_POST, 'q7TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q8TEXT= filter_input(INPUT_POST, 'q8TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q9TEXT= filter_input(INPUT_POST, 'q9TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q10TEXT= filter_input(INPUT_POST, 'q10TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q11TEXT= filter_input(INPUT_POST, 'q11TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q12TEXT= filter_input(INPUT_POST, 'q12TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q13TEXT= filter_input(INPUT_POST, 'q13TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q14TEXT= filter_input(INPUT_POST, 'q14TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $q15TEXT= filter_input(INPUT_POST, 'q15TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    
if ($newedit =='y') {
    
    $totalCorrect = 0;

if ($sq1 =="Yes") { $totalCorrect++; }
if ($sq2 =="Yes") { $totalCorrect++; }
if ($sq3 =="Yes") { $totalCorrect++; }
if ($sq4 =="Yes") { $totalCorrect++; }
if ($s2aq1 =="Yes") { $totalCorrect++; }

       

    
        $query = $pdo->prepare("UPDATE Audit_LeadGen set an_number=:annumber, sq5=:sq5holder, q1s4q1n=:q1s4q1nholder, q1s4c1n=:q1s4c1nholder, agent=:agentholder, sq1=:sq1holder, sq2=:sq2holder, sq3=:sq3holder, sq4=:sq4holder, s2aq1=:s2aq1holder, s2aq2=:s2aq2holder, s2aq3=:s2aq3holder, s2aq4=:s2aq4holder, s2aq5=:s2aq5holder, s2aq6=:s2aq6holder, s2aq7=:s2aq7holder, s2aq8=:s2aq8holder, s2aq9=:s2aq9holder, s2aq10=:s2aq10holder, s2aq11=:s2aq11holder, s2bq1=:s2bq1holder, q1s2bc1=:q1s2bc1holder, q2s2bq2=:q2s2bq2holder, q2s2bc2=:q2s2bc2holder, q1s3q1=:q1s3q1holder, q1s3c1=:q1s3c1holder, total=:totalholder, grade=:gradeholder, edited=:helloholder where id =:newauditeditholder ");
        $query->bindParam(':agentholder', $agent, PDO::PARAM_STR, 100);
        $query->bindParam(':totalholder', $totalCorrect, PDO::PARAM_INT);
        $query->bindParam(':newauditeditholder', $newauditedit, PDO::PARAM_INT);
        $query->bindParam(':annumber', $annumber, PDO::PARAM_STR, 100);
        $query->bindParam(':q1s4q1nholder', $q1s4q1n, PDO::PARAM_STR, 3);
        $query->bindParam(':q1s4c1nholder', $q1s4c1n, PDO::PARAM_STR, 2500);  
        $query->bindParam(':gradeholder', $grade, PDO::PARAM_STR, 3);
        $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 15);
        $query->bindParam(':sq1holder', $sq1, PDO::PARAM_STR, 3);
    	$query->bindParam(':sq2holder', $sq2, PDO::PARAM_STR, 3);
    	$query->bindParam(':sq3holder', $sq3, PDO::PARAM_STR, 3);
        $query->bindParam(':sq4holder', $sq4, PDO::PARAM_STR, 3);
        $query->bindParam(':sq5holder', $sq5, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq1holder', $s2aq1, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq2holder', $s2aq2, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq3holder', $s2aq3, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq4holder', $s2aq4, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq5holder', $s2aq5, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq6holder', $s2aq6, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq7holder', $s2aq7, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq8holder', $s2aq8, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq9holder', $s2aq9, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq10holder', $s2aq10, PDO::PARAM_STR, 3);
        $query->bindParam(':s2aq11holder', $s2aq11, PDO::PARAM_STR, 3);
   	$query->bindParam(':s2bq1holder', $s2bq1, PDO::PARAM_STR, 3);
	$query->bindParam(':q1s2bc1holder', $q1s2bc1, PDO::PARAM_STR, 2500);
    	$query->bindParam(':q2s2bq2holder', $q2s2bq2, PDO::PARAM_STR, 3);
	$query->bindParam(':q2s2bc2holder', $q2s2bc2, PDO::PARAM_STR, 2500);
    	$query->bindParam(':q1s3q1holder', $q1s3q1, PDO::PARAM_STR, 3);
    	$query->bindParam(':q1s3c1holder', $q1s3c1, PDO::PARAM_STR, 2500);
        $query->execute()or die(print_r($query->errorInfo(), true));
        
        $QUES = $pdo->prepare("UPDATE Audit_LeadGen_Comments set q1=:q1, q2=:q2, q3=:q3, q4=:q4, q5=:q5, q6=:q6, q7=:q7, q8=:q8, q9=:q9, q10=:q10, q11=:q11, q12=:q12, q13=:q13, q14=:q14, q15=:q15 WHERE audit_id=:last");
    
        $QUES->bindParam(':q1', $q1TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q2', $q2TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q3', $q3TEXT, PDO::PARAM_STR, 450);        
        $QUES->bindParam(':q4', $q4TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q5', $q5TEXT, PDO::PARAM_STR, 450);        
        $QUES->bindParam(':q6', $q6TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q7', $q7TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q8', $q8TEXT, PDO::PARAM_STR, 450);
    	$QUES->bindParam(':q9', $q9TEXT, PDO::PARAM_STR, 450);
    	$QUES->bindParam(':q10', $q10TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q11', $q11TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q12', $q12TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q13', $q13TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q14', $q14TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':q15', $q15TEXT, PDO::PARAM_STR, 450);
        $QUES->bindParam(':last', $newauditedit, PDO::PARAM_INT);
        $QUES->execute()or die(print_r($QUES->errorInfo(), true));
    
   header('Location: ../lead_gen_reports.php?auditedit=y&step=New&grade='.$grade); die;

    
}

else
{




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

$query = $pdo->prepare("UPDATE lead_gen_audit SET 
total= :totalholder
, lead_gen_name= :leadgenholder
, lead_gen_name2= :leadgen2holder
, cal_grade= :calgradeholder
, score= :scoreholder
, edited= :editedholder
, grade= :gradeholder
, c1= :c1holder
, call_opening= :callopeningholder
 , c2= :c2holder
 , full_info= :full_infoholder
 , c3= :c3holder
 , obj_handled= :obj_handledholder
 , c4= :c4holder
 , rapport= :rapportholder
 , c5= :c5holder
 , dealsheet_questions= :dealsheet_questionsholder
 , c6= :c6holder
 , brad_compl= :brad_complholder
 , c7= :c7holder
 , date_edited=CURRENT_TIMESTAMP 
 WHERE ID = :keyfieldholder 
 OR ID = :auditidholder");

$query->bindParam(':totalholder', $totalCorrect, PDO::PARAM_STR);
$query->bindParam(':leadgenholder', $lead_gen_name, PDO::PARAM_STR);
$query->bindParam(':leadgen2holder', $lead_gen_name2, PDO::PARAM_STR);
$query->bindParam(':calgradeholder', $percentage2, PDO::PARAM_STR);
$query->bindParam(':scoreholder', $percentage, PDO::PARAM_STR);
$query->bindParam(':editedholder', $edited_by, PDO::PARAM_STR);
$query->bindParam(':gradeholder', $grade, PDO::PARAM_STR);
$query->bindParam(':c1holder', $c1, PDO::PARAM_STR);
$query->bindParam(':callopeningholder', $call_opening, PDO::PARAM_STR);
$query->bindParam(':c2holder', $c2, PDO::PARAM_STR);
$query->bindParam(':full_infoholder', $full_info, PDO::PARAM_STR);
$query->bindParam(':c3holder', $c3, PDO::PARAM_STR);
$query->bindParam(':obj_handledholder', $obj_handled, PDO::PARAM_STR);
$query->bindParam(':c4holder', $c4, PDO::PARAM_STR);
$query->bindParam(':rapportholder', $rapport, PDO::PARAM_STR);
$query->bindParam(':c5holder', $c5, PDO::PARAM_STR);
$query->bindParam(':dealsheet_questionsholder', $dealsheet_questions, PDO::PARAM_STR);
$query->bindParam(':c6holder', $c6, PDO::PARAM_STR);
$query->bindParam(':brad_complholder', $brad_compl, PDO::PARAM_STR);
$query->bindParam(':c7holder', $c7, PDO::PARAM_STR);
$query->bindParam(':keyfieldholder', $keyfield, PDO::PARAM_STR);
$query->bindParam(':auditidholder', $auditid, PDO::PARAM_STR);
$query->execute();

echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Lead Gen Audit Successfully Added.
    </div>";

}
?>