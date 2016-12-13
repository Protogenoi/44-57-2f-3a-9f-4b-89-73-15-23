<?php

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/ADL_PDO_CON.php');

$agent= filter_input(INPUT_POST, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);
$annumber= filter_input(INPUT_POST, 'annumber', FILTER_SANITIZE_SPECIAL_CHARS);

$annumber=preg_replace('/\s+/', '', $annumber);

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


$totalCorrect = 0;

if ($sq1 =="Yes") { $totalCorrect++; }
if ($sq2 =="Yes") { $totalCorrect++; }
if ($sq3 =="Yes") { $totalCorrect++; }
if ($sq4 =="Yes") { $totalCorrect++; }
if ($s2aq1 =="Yes") { $totalCorrect++; }

if ($s2aq2 == "No" || $s2aq3 == "No" || $s2aq4 =="No" || $s2aq5=="No" || $s2aq6=="No" || $s2aq7=="No" || $s2aq8=="No" || $s2aq9=="No" || $s2aq10=="No" || $s2aq11=="No" || $s2bq1=="No" || $q2s2bq2=="No" || $q1s3q1=="No" || $q1s4q1n=="No") {
    
    $grade='Red';
    
        $query = $pdo->prepare("INSERT INTO Audit_LeadGen set an_number=:annumber, sq5=:sq5holder, q1s4q1n=:q1s4q1nholder, q1s4c1n=:q1s4c1nholder, agent=:agentholder, sq1=:sq1holder, sq2=:sq2holder, sq3=:sq3holder, sq4=:sq4holder, s2aq1=:s2aq1holder, s2aq2=:s2aq2holder, s2aq3=:s2aq3holder, s2aq4=:s2aq4holder, s2aq5=:s2aq5holder, s2aq6=:s2aq6holder, s2aq7=:s2aq7holder, s2aq8=:s2aq8holder, s2aq9=:s2aq9holder, s2aq10=:s2aq10holder, s2aq11=:s2aq11holder, s2bq1=:s2bq1holder, q1s2bc1=:q1s2bc1holder, q2s2bq2=:q2s2bq2holder, q2s2bc2=:q2s2bc2holder, q1s3q1=:q1s3q1holder, q1s3c1=:q1s3c1holder, total=:totalholder, grade=:gradeholder, auditor=:helloholder ");
    
        $query->bindParam(':agentholder', $agent, PDO::PARAM_STR, 100);
        $query->bindParam(':annumber', $annumber, PDO::PARAM_STR, 100);
        $query->bindParam(':totalholder', $totalCorrect, PDO::PARAM_INT);        
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
    $last_id = $pdo->lastInsertId();

        $QUES = $pdo->prepare("INSERT INTO Audit_LeadGen_Comments set audit_id=:last, q1=:q1, q2=:q2, q3=:q3, q4=:q4, q5=:q5, q6=:q6, q7=:q7, q8=:q8, q9=:q9, q10=:q10, q11=:q11, q12=:q12, q13=:q13, q14=:q14, q15=:q15 ");
    
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
        $QUES->bindParam(':last', $last_id, PDO::PARAM_INT);
        $QUES->execute()or die(print_r($QUES->errorInfo(), true));
    
   header('Location: ../lead_gen_reports.php?audit=y&grade=Red&step=New'); die;
    
}

elseif ($sq1 == "No" || $sq2 == "No" || $sq3 =="No" || $sq4=="No" || $sq5=="No" )
    {
    
    $grade='Amber';
    
        $query = $pdo->prepare("INSERT INTO Audit_LeadGen set an_number=:annumber, sq5=:sq5holder, q1s4q1n=:q1s4q1nholder, q1s4c1n=:q1s4c1nholder, agent=:agentholder, sq1=:sq1holder, sq2=:sq2holder, sq3=:sq3holder, sq4=:sq4holder, s2aq1=:s2aq1holder, s2aq2=:s2aq2holder, s2aq3=:s2aq3holder, s2aq4=:s2aq4holder, s2aq5=:s2aq5holder, s2aq6=:s2aq6holder, s2aq7=:s2aq7holder, s2aq8=:s2aq8holder, s2aq9=:s2aq9holder, s2aq10=:s2aq10holder, s2aq11=:s2aq11holder, s2bq1=:s2bq1holder, q1s2bc1=:q1s2bc1holder, q2s2bq2=:q2s2bq2holder, q2s2bc2=:q2s2bc2holder, q1s3q1=:q1s3q1holder, q1s3c1=:q1s3c1holder, total=:totalholder, grade=:gradeholder, auditor=:helloholder ");
    
        $query->bindParam(':agentholder', $agent, PDO::PARAM_STR, 100);
        $query->bindParam(':annumber', $annumber, PDO::PARAM_STR, 100);
        $query->bindParam(':totalholder', $totalCorrect, PDO::PARAM_INT);        
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
        $last_id = $pdo->lastInsertId();
    
        $QUES = $pdo->prepare("INSERT INTO Audit_LeadGen_Comments set audit_id=:last, q1=:q1, q2=:q2, q3=:q3, q4=:q4, q5=:q5, q6=:q6, q7=:q7, q8=:q8, q9=:q9, q10=:q10, q11=:q11, q12=:q12, q13=:q13, q14=:q14, q15=:q15 ");
    
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
        $QUES->bindParam(':last', $last_id, PDO::PARAM_STR, 450);
        $QUES->execute()or die(print_r($QUES->errorInfo(), true));
    
    header('Location: ../lead_gen_reports.php?audit=y&grade=Amber&step=New'); die;
    
    }

else
{
        $grade='Green';
    
        $query = $pdo->prepare("INSERT INTO Audit_LeadGen set an_number=:annumber, sq5=:sq5holder, q1s4q1n=:q1s4q1nholder, q1s4c1n=:q1s4c1nholder, agent=:agentholder, sq1=:sq1holder, sq2=:sq2holder, sq3=:sq3holder, sq4=:sq4holder, s2aq1=:s2aq1holder, s2aq2=:s2aq2holder, s2aq3=:s2aq3holder, s2aq4=:s2aq4holder, s2aq5=:s2aq5holder, s2aq6=:s2aq6holder, s2aq7=:s2aq7holder, s2aq8=:s2aq8holder, s2aq9=:s2aq9holder, s2aq10=:s2aq10holder, s2aq11=:s2aq11holder, s2bq1=:s2bq1holder, q1s2bc1=:q1s2bc1holder, q2s2bq2=:q2s2bq2holder, q2s2bc2=:q2s2bc2holder, q1s3q1=:q1s3q1holder, q1s3c1=:q1s3c1holder, total=:totalholder, grade=:gradeholder, auditor=:helloholder ");
    
        $query->bindParam(':agentholder', $agent, PDO::PARAM_STR, 100);
        $query->bindParam(':annumber', $annumber, PDO::PARAM_STR, 100);
        $query->bindParam(':totalholder', $totalCorrect, PDO::PARAM_INT);
        
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
    
   header('Location: ../lead_gen_reports.php?audit=y&grade=Green&step=New'); die;
}