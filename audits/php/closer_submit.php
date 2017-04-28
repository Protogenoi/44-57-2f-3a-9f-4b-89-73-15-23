<?php 
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_MYSQLI_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits == '0') {

    header('Location: /../../CRMmain.php?FeatureDisabled');
    die;
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../../CRMmain.php');
    die;
}

 $GRADE = filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);

    $q1 = filter_input(INPUT_POST, 'q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $q2 = filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $q3 = filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $q4 = filter_input(INPUT_POST, 'q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $q5 = filter_input(INPUT_POST, 'q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $q6 = filter_input(INPUT_POST, 'q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $q7 = filter_input(INPUT_POST, 'q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $q8 = filter_input(INPUT_POST, 'q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $q9 = filter_input(INPUT_POST, 'q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $q10 = filter_input(INPUT_POST, 'q10', FILTER_SANITIZE_SPECIAL_CHARS);

    $q11 = filter_input(INPUT_POST, 'q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $q12 = filter_input(INPUT_POST, 'q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $q13 = filter_input(INPUT_POST, 'q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $q14 = filter_input(INPUT_POST, 'q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $q15 = filter_input(INPUT_POST, 'q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $q16 = filter_input(INPUT_POST, 'q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $q17 = filter_input(INPUT_POST, 'q17', FILTER_SANITIZE_SPECIAL_CHARS);
    $q18 = filter_input(INPUT_POST, 'q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $q19 = filter_input(INPUT_POST, 'q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $q20 = filter_input(INPUT_POST, 'q20', FILTER_SANITIZE_SPECIAL_CHARS);

    $q21 = filter_input(INPUT_POST, 'q21', FILTER_SANITIZE_SPECIAL_CHARS);
    $q22 = filter_input(INPUT_POST, 'q22', FILTER_SANITIZE_SPECIAL_CHARS);
    $q23 = filter_input(INPUT_POST, 'q23', FILTER_SANITIZE_SPECIAL_CHARS);
    $q24 = filter_input(INPUT_POST, 'q24', FILTER_SANITIZE_SPECIAL_CHARS);
    $q25 = filter_input(INPUT_POST, 'q25', FILTER_SANITIZE_SPECIAL_CHARS);
    $q26 = filter_input(INPUT_POST, 'q26', FILTER_SANITIZE_SPECIAL_CHARS);
    $q27 = filter_input(INPUT_POST, 'q27', FILTER_SANITIZE_SPECIAL_CHARS);
    $q28 = filter_input(INPUT_POST, 'q28', FILTER_SANITIZE_SPECIAL_CHARS);
    $q29 = filter_input(INPUT_POST, 'q29', FILTER_SANITIZE_SPECIAL_CHARS);
    $q30 = filter_input(INPUT_POST, 'q30', FILTER_SANITIZE_SPECIAL_CHARS);

    $q31 = filter_input(INPUT_POST, 'q31', FILTER_SANITIZE_SPECIAL_CHARS);
    $q32 = filter_input(INPUT_POST, 'q32', FILTER_SANITIZE_SPECIAL_CHARS);
    $q33 = filter_input(INPUT_POST, 'q33', FILTER_SANITIZE_SPECIAL_CHARS);
    $q34 = filter_input(INPUT_POST, 'q34', FILTER_SANITIZE_SPECIAL_CHARS);
    $q35 = filter_input(INPUT_POST, 'q35', FILTER_SANITIZE_SPECIAL_CHARS);
    $q36 = filter_input(INPUT_POST, 'q36', FILTER_SANITIZE_SPECIAL_CHARS);
    $q38 = filter_input(INPUT_POST, 'q38', FILTER_SANITIZE_SPECIAL_CHARS);
    $q39 = filter_input(INPUT_POST, 'q39', FILTER_SANITIZE_SPECIAL_CHARS);
    $q40 = filter_input(INPUT_POST, 'q40', FILTER_SANITIZE_SPECIAL_CHARS);
    $q41 = filter_input(INPUT_POST, 'q41', FILTER_SANITIZE_SPECIAL_CHARS);

    $q42 = filter_input(INPUT_POST, 'q42', FILTER_SANITIZE_SPECIAL_CHARS);
    $q43 = filter_input(INPUT_POST, 'q43', FILTER_SANITIZE_SPECIAL_CHARS);
    $q44 = filter_input(INPUT_POST, 'q44', FILTER_SANITIZE_SPECIAL_CHARS);
    $q45 = filter_input(INPUT_POST, 'q45', FILTER_SANITIZE_SPECIAL_CHARS);
    $q46 = filter_input(INPUT_POST, 'q46', FILTER_SANITIZE_SPECIAL_CHARS);
    $q47 = filter_input(INPUT_POST, 'q47', FILTER_SANITIZE_SPECIAL_CHARS);
    $q48 = filter_input(INPUT_POST, 'q48', FILTER_SANITIZE_SPECIAL_CHARS);
    $q49 = filter_input(INPUT_POST, 'q49', FILTER_SANITIZE_SPECIAL_CHARS);
    $q50 = filter_input(INPUT_POST, 'q50', FILTER_SANITIZE_SPECIAL_CHARS);
    $q51 = filter_input(INPUT_POST, 'q51', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $q52 = filter_input(INPUT_POST, 'q52', FILTER_SANITIZE_SPECIAL_CHARS);
    $q53 = filter_input(INPUT_POST, 'q53', FILTER_SANITIZE_SPECIAL_CHARS);
    $q54 = filter_input(INPUT_POST, 'q54', FILTER_SANITIZE_SPECIAL_CHARS);
    $q55 = filter_input(INPUT_POST, 'q55', FILTER_SANITIZE_SPECIAL_CHARS);

$totalCorrect = 0;

if ($q1 =="Yes") { $totalCorrect++; }
if ($q2 =="Yes") { $totalCorrect++; }
if ($q3 =="Yes") { $totalCorrect++; }
if ($q4 =="Yes") { $totalCorrect++; }
if ($q5 =="Yes") { $totalCorrect++; }
if ($q6 =="Yes") { $totalCorrect++; }
if ($q7 =="Yes") { $totalCorrect++; }
if ($q8 =="Yes") { $totalCorrect++; }
if ($q9 =="Yes") { $totalCorrect++; }
if ($q10 =="Yes") { $totalCorrect++; }
if ($q11 =="Yes") { $totalCorrect++; }
if ($q12 =="Yes") { $totalCorrect++; }
if ($q13 =="Yes") { $totalCorrect++; }
if ($q14 =="More than sufficient") { $totalCorrect++; }
if ($q14 =="Sufficient") { $totalCorrect++; }
if ($q14 =="Adaquate") { $totalCorrect++; }
if ($q15 =="Yes") { $totalCorrect++; }
if ($q16 =="Yes") { $totalCorrect++; }
if ($q17 =="Yes") { $totalCorrect++; }
if ($q18 =="Yes") { $totalCorrect++; }
if ($q55 =="Yes") { $totalCorrect++; }
if ($q19 =="Yes") { $totalCorrect++; }
if ($q20 =="Yes") { $totalCorrect++; }
if ($q21 =="Yes") { $totalCorrect++; }
if ($q22 =="Yes") { $totalCorrect++; }
if ($q23 =="Yes") { $totalCorrect++; }
if ($q24 =="Yes") { $totalCorrect++; }
if ($q25 =="Yes") { $totalCorrect++; }
if ($q26 =="Yes") { $totalCorrect++; }
if ($q27 =="Yes") { $totalCorrect++; }
if ($q28 =="Yes") { $totalCorrect++; }
if ($q29 =="Client provided details") { $totalCorrect++; }
if ($q29 =="Client failed to provided details") { $totalCorrect++; }
if ($q29 =="Not existing L&G customer") { $totalCorrect++; }
if ($q29 =="Obtained from Term4Term service") { $totalCorrect++; }
if ($q29 =="Client failed to provide details") { $totalCorrect++; }
if ($q30 =="Yes") { $totalCorrect++; }
if ($q31 =="Yes") { $totalCorrect++; }
if ($q32 =="Yes") { $totalCorrect++; }
if ($q33 =="Yes") { $totalCorrect++; }
if ($q34 =="Yes") { $totalCorrect++; }
if ($q35 =="Yes") { $totalCorrect++; }
if ($q36 =="Yes") { $totalCorrect++; }
if ($q38 =="Yes") { $totalCorrect++; }
if ($q39 =="Yes") { $totalCorrect++; }
if ($q40 =="Yes") { $totalCorrect++; }
if ($q41 =="Yes") { $totalCorrect++; }
if ($q42 =="Yes") { $totalCorrect++; }
if ($q43 =="Yes") { $totalCorrect++; }
if ($q44 =="Yes") { $totalCorrect++; }
if ($q45 =="Yes") { $totalCorrect++; }
if ($q45 =="N/A") { $totalCorrect++; }
if ($q46 =="Yes") { $totalCorrect++; }
if ($q46 =="N/A") { $totalCorrect++; }
if ($q47 =="Yes") { $totalCorrect++; }
if ($q48 =="Yes") { $totalCorrect++; }
if ($q49 =="Yes") { $totalCorrect++; }
if ($q50 =="Yes") { $totalCorrect++; }
if ($q51 =="Yes") { $totalCorrect++; }
if ($q52 =="Yes") { $totalCorrect++; }
if ($q53 =="Yes") { $totalCorrect++; }
if ($q53 =="N/A") { $totalCorrect++; }
if ($q54 =="Yes") { $totalCorrect++; }
if ($q54 =="N/A") { $totalCorrect++; }

$total = 54;
$percentage = $totalCorrect/$total * 100;

$totalincorrect = 0;

if ($q1 =="No") { $totalincorrect++; }
if ($q2 =="No") { $totalincorrect++; }
if ($q3 =="No") { $totalincorrect++; }
if ($q4 =="No") { $totalincorrect++; }
if ($q5 =="No") { $totalincorrect++; }
if ($q6 =="No") { $totalincorrect++; }
if ($q7 =="No") { $totalincorrect++; }
if ($q8 =="No") { $totalincorrect++; }
if ($q9 =="No") { $totalincorrect++; }
if ($q10 =="No") { $totalincorrect++; }
if ($q11 =="No") { $totalincorrect++; }
if ($q12 =="No") { $totalincorrect++; }
if ($q13 =="No") { $totalincorrect++; }
if ($q15 =="No") { $totalincorrect++; }
if ($q16 =="No") { $totalincorrect++; }
if ($q17 =="No") { $totalincorrect++; }
if ($q18 =="No") { $totalincorrect++; }
if ($q55 =="No") { $totalincorrect++; }
if ($q19 =="No") { $totalincorrect++; }
if ($q20 =="No") { $totalincorrect++; }
if ($q21 =="No") { $totalincorrect++; }
if ($q22 =="No") { $totalincorrect++; }
if ($q23 =="No") { $totalincorrect++; }
if ($q24 =="No") { $totalincorrect++; }
if ($q25 =="No") { $totalincorrect++; }
if ($q26 =="No") { $totalincorrect++; }
if ($q27 =="No") { $totalincorrect++; }
if ($q28 =="No") { $totalincorrect++; }
if ($q29 =="Existing L&G Policy, no attempt to get policy number") { $totalincorrect++; }
if ($q34 =="No") { $totalincorrect++; }

$total2 = 29;
$percentage2 = $totalincorrect/$total2 * 100;
$totalincorrect;

$AN_NUMBER= filter_input(INPUT_POST, 'annumber', FILTER_SANITIZE_SPECIAL_CHARS);

$annumber=preg_replace('/\s+/', '', $AN_NUMBER);

    $c1 = filter_input(INPUT_POST, 'c1', FILTER_SANITIZE_SPECIAL_CHARS);
    $c2 = filter_input(INPUT_POST, 'c2', FILTER_SANITIZE_SPECIAL_CHARS);
    $c3 = filter_input(INPUT_POST, 'c3', FILTER_SANITIZE_SPECIAL_CHARS);
    $c4 = filter_input(INPUT_POST, 'c4', FILTER_SANITIZE_SPECIAL_CHARS);
    $c5 = filter_input(INPUT_POST, 'c5', FILTER_SANITIZE_SPECIAL_CHARS);
    $c6 = filter_input(INPUT_POST, 'c6', FILTER_SANITIZE_SPECIAL_CHARS);
    $c7 = filter_input(INPUT_POST, 'c7', FILTER_SANITIZE_SPECIAL_CHARS);
    $c8 = filter_input(INPUT_POST, 'c8', FILTER_SANITIZE_SPECIAL_CHARS);
    $c9 = filter_input(INPUT_POST, 'c9', FILTER_SANITIZE_SPECIAL_CHARS);
    $c10 = filter_input(INPUT_POST, 'c10', FILTER_SANITIZE_SPECIAL_CHARS);

    $c11 = filter_input(INPUT_POST, 'c11', FILTER_SANITIZE_SPECIAL_CHARS);
    $c12 = filter_input(INPUT_POST, 'c12', FILTER_SANITIZE_SPECIAL_CHARS);
    $c13 = filter_input(INPUT_POST, 'c13', FILTER_SANITIZE_SPECIAL_CHARS);
    $c14 = filter_input(INPUT_POST, 'c14', FILTER_SANITIZE_SPECIAL_CHARS);
    $c15 = filter_input(INPUT_POST, 'c15', FILTER_SANITIZE_SPECIAL_CHARS);
    $c16 = filter_input(INPUT_POST, 'c16', FILTER_SANITIZE_SPECIAL_CHARS);
    $c17 = filter_input(INPUT_POST, 'c17', FILTER_SANITIZE_SPECIAL_CHARS);
    $c18 = filter_input(INPUT_POST, 'c18', FILTER_SANITIZE_SPECIAL_CHARS);
    $c19 = filter_input(INPUT_POST, 'c19', FILTER_SANITIZE_SPECIAL_CHARS);
    $c20 = filter_input(INPUT_POST, 'c20', FILTER_SANITIZE_SPECIAL_CHARS);

    $c21 = filter_input(INPUT_POST, 'c21', FILTER_SANITIZE_SPECIAL_CHARS);
    $c22 = filter_input(INPUT_POST, 'c22', FILTER_SANITIZE_SPECIAL_CHARS);
    $c23 = filter_input(INPUT_POST, 'c23', FILTER_SANITIZE_SPECIAL_CHARS);
    $c24 = filter_input(INPUT_POST, 'c24', FILTER_SANITIZE_SPECIAL_CHARS);
    $c25 = filter_input(INPUT_POST, 'c25', FILTER_SANITIZE_SPECIAL_CHARS);
    $c26 = filter_input(INPUT_POST, 'c26', FILTER_SANITIZE_SPECIAL_CHARS);
    $c27 = filter_input(INPUT_POST, 'c27', FILTER_SANITIZE_SPECIAL_CHARS);
    $c28 = filter_input(INPUT_POST, 'c28', FILTER_SANITIZE_SPECIAL_CHARS);
    $c29 = filter_input(INPUT_POST, 'c29', FILTER_SANITIZE_SPECIAL_CHARS);
    $c30 = filter_input(INPUT_POST, 'c30', FILTER_SANITIZE_SPECIAL_CHARS);

    $c31 = filter_input(INPUT_POST, 'c31', FILTER_SANITIZE_SPECIAL_CHARS);
    $c32 = filter_input(INPUT_POST, 'c32', FILTER_SANITIZE_SPECIAL_CHARS);
    $c33 = filter_input(INPUT_POST, 'c33', FILTER_SANITIZE_SPECIAL_CHARS);
    $c34 = filter_input(INPUT_POST, 'c34', FILTER_SANITIZE_SPECIAL_CHARS);
    $c35 = filter_input(INPUT_POST, 'c35', FILTER_SANITIZE_SPECIAL_CHARS);
    $c36 = filter_input(INPUT_POST, 'c36', FILTER_SANITIZE_SPECIAL_CHARS);
    $c38 = filter_input(INPUT_POST, 'c38', FILTER_SANITIZE_SPECIAL_CHARS);
    $c39 = filter_input(INPUT_POST, 'c39', FILTER_SANITIZE_SPECIAL_CHARS);
    $c40 = filter_input(INPUT_POST, 'c40', FILTER_SANITIZE_SPECIAL_CHARS);
    $c41 = filter_input(INPUT_POST, 'c41', FILTER_SANITIZE_SPECIAL_CHARS);

    $c42 = filter_input(INPUT_POST, 'c42', FILTER_SANITIZE_SPECIAL_CHARS);
    $c43 = filter_input(INPUT_POST, 'c43', FILTER_SANITIZE_SPECIAL_CHARS);
    $c44 = filter_input(INPUT_POST, 'c44', FILTER_SANITIZE_SPECIAL_CHARS);
    $c45 = filter_input(INPUT_POST, 'c45', FILTER_SANITIZE_SPECIAL_CHARS);
    $c46 = filter_input(INPUT_POST, 'c46', FILTER_SANITIZE_SPECIAL_CHARS);
    $c47 = filter_input(INPUT_POST, 'c47', FILTER_SANITIZE_SPECIAL_CHARS);
    $c48 = filter_input(INPUT_POST, 'c48', FILTER_SANITIZE_SPECIAL_CHARS);
    $c49 = filter_input(INPUT_POST, 'c49', FILTER_SANITIZE_SPECIAL_CHARS);
    $c50 = filter_input(INPUT_POST, 'c50', FILTER_SANITIZE_SPECIAL_CHARS);
    $c51 = filter_input(INPUT_POST, 'c51', FILTER_SANITIZE_SPECIAL_CHARS);

    $c52 = filter_input(INPUT_POST, 'c52', FILTER_SANITIZE_SPECIAL_CHARS);
    $c53 = filter_input(INPUT_POST, 'c53', FILTER_SANITIZE_SPECIAL_CHARS);
    $c54 = filter_input(INPUT_POST, 'c54', FILTER_SANITIZE_SPECIAL_CHARS);
    $c55 = filter_input(INPUT_POST, 'c55', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $full_name2 = filter_input(INPUT_POST, 'full_name2', FILTER_SANITIZE_SPECIAL_CHARS);
    $policy_id = filter_input(INPUT_POST, 'policy_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $agree = filter_input(INPUT_POST, 'agree', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "INSERT INTO closer_audits SET an_number='$annumber', total='$totalCorrect', cal_grade='$percentage2', score='$percentage2', closer='$full_name', closer2='$full_name2', auditor='$hello_name', policy_number='$policy_id', grade='$GRADE', q1='$q1', c1='$c1', q2='$q2', c2='$c2', q3='$q3', c3='$c3', q4='$q4', c4='$c4', q5='$q5', c5='$c5', q6='$q6', c6='$c6', q7='$q7', c7='$c7', q8='$q8', c8='$c8', q9='$q9', c9='$c9', q10='$q10', c10='$c10', q11='$q11', c11='$c11', q12='$q12', c12='$c12', q13='$q13', c13='$c13', q14='$q14', c14='$c14', q15='$q15', c15='$c15', q16='$q16', c16='$c16', q17='$q17', c17='$c17', q18='$q18', c18='$c18', q19='$q19', c19='$c19', q20='$q20', c20='$c20', q21='$q21', c21='$c21', q22='$q22', c22='$c22', q23='$q23', c23='$c23', q24='$q24', c24='$c24', q25='$q25', c25='$c25', q26='$q26', c26='$c26', q27='$q27', c27='$c27', q28='$q28', c28='$c28', q29='$q29', c29='$c29', q30='$q30', c30='$c30', q31='$q31', c31='$c31', q32='$q32', c32='$c32', q33='$q33', c33='$c33', q34='$q34', c34='$c34', q35='$q35', c35='$c35', q36='$q36', c36='$c36', q38='$q38', c38='$c38', q39='$q39', c39='$c39', q40='$q40', c40='$c40', q41='$q41', c41='$c41', q42='$q42', c42='$c42', q43='$q43', c43='$c43', q44='$q44', c44='$c44', q45='$q45', c45='$c45', q46='$q46', c46='$c46', q47='$q47', c47='$c47', q48='$q48', c48='$c48', q49='$q49', c49='$c49', q50='$q50', c50='$c50', q51='$q51', c51='$c51', q52='$q52', c52='$c52', q53='$q53', c53='$c53', q54='$q54', c54='$c54', q55='$q55', c55='$c55', agree='$agree'";

if (mysqli_query($conn, $sql)) {

    
    header('Location: ../auditor_menu.php?RETURN=ADDED&grade=' . $GRADE . '&TotalCorrect=' . $totalCorrect);
    
} else {

   header('Location: ../auditor_menu.php?RETURN=FAILED');
}


?>


