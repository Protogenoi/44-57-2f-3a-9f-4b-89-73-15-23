<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../classes/database_class.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    $Q1 = filter_input(INPUT_POST, 'q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q2 = filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q3 = filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q4 = filter_input(INPUT_POST, 'q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q5 = filter_input(INPUT_POST, 'q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q6 = filter_input(INPUT_POST, 'q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q7 = filter_input(INPUT_POST, 'q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q8 = filter_input(INPUT_POST, 'q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q9 = filter_input(INPUT_POST, 'q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q10 = filter_input(INPUT_POST, 'q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q11 = filter_input(INPUT_POST, 'q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q12 = filter_input(INPUT_POST, 'q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q13 = filter_input(INPUT_POST, 'q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q14 = filter_input(INPUT_POST, 'q14', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $C1 = filter_input(INPUT_POST, 'c1', FILTER_SANITIZE_SPECIAL_CHARS);
    $C2 = filter_input(INPUT_POST, 'c2', FILTER_SANITIZE_SPECIAL_CHARS);
    $C3 = filter_input(INPUT_POST, 'c3', FILTER_SANITIZE_SPECIAL_CHARS);
    $C4 = filter_input(INPUT_POST, 'c4', FILTER_SANITIZE_SPECIAL_CHARS);
    $C5 = filter_input(INPUT_POST, 'c5', FILTER_SANITIZE_SPECIAL_CHARS);
    $C6 = filter_input(INPUT_POST, 'c6', FILTER_SANITIZE_SPECIAL_CHARS);
    $C7 = filter_input(INPUT_POST, 'c7', FILTER_SANITIZE_SPECIAL_CHARS);
    $C8 = filter_input(INPUT_POST, 'c8', FILTER_SANITIZE_SPECIAL_CHARS);
    $C9 = filter_input(INPUT_POST, 'c9', FILTER_SANITIZE_SPECIAL_CHARS);
    $C10 = filter_input(INPUT_POST, 'c10', FILTER_SANITIZE_SPECIAL_CHARS);
    $C11 = filter_input(INPUT_POST, 'c11', FILTER_SANITIZE_SPECIAL_CHARS);
    $C12 = filter_input(INPUT_POST, 'c12', FILTER_SANITIZE_SPECIAL_CHARS);
    $C13 = filter_input(INPUT_POST, 'c13', FILTER_SANITIZE_SPECIAL_CHARS);
    $C14 = filter_input(INPUT_POST, 'c14', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($EXECUTE=='1') {
        
        $MARK=0;
        
if ($Q1 =="D") { $MARK++; }
if ($Q2 =="B") { $MARK++; }
if ($Q3 =="A") { $MARK++; }
if ($Q4 =="C") { $MARK++; }
if ($Q5 =="A") { $MARK++; }
if ($Q6 =="D") { $MARK++; }
if ($Q7 =="C") { $MARK++; }
if ($Q8 =="B") { $MARK++; }
if ($Q9 =="C") { $MARK++; }
if ($Q10 =="D") { $MARK++; }
if ($Q11 =="B") { $MARK++; }
if ($Q12 =="C") { $MARK++; }
if ($Q13 =="D") { $MARK++; }
if ($Q14 =="D") { $MARK++; }

$GRADE_PERCENT = $MARK/12 * 100;

if($GRADE_PERCENT>=60) {
    $GRADE='Green';
    }
    if($GRADE_PERCENT>=30 && $GRADE_PERCENT<60) {
        $GRADE='Amber';
        }
        if($GRADE_PERCENT<30) {
            $GRADE='Red';
            }
      
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND CONCAT(firstname, ' ', lastname)=:NAME");           
    $query->bindParam(':NAME', $hello_name, PDO::PARAM_STR);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];           

        $INSERT = $pdo->prepare("INSERT INTO life_test_one SET life_test_one_id_fk=:FK, life_test_one_company=:COMPANY, life_test_one_advisor=:ADVISOR, life_test_one_grade=:GRADE, life_test_one_mark=:MARK");
        $INSERT->bindParam(':FK', $ID_FK, PDO::PARAM_STR);
        $INSERT->bindParam(':MARK', $MARK, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':GRADE', $GRADE, PDO::PARAM_STR);
        $INSERT->bindParam(':ADVISOR', $hello_name, PDO::PARAM_STR);
        $INSERT->execute();
        
        $LAST_ID = $pdo->lastInsertId();
        
        $INSERT_QUES = $pdo->prepare("INSERT INTO life_test_one_questions SET life_test_one_questions_id_fk=:ID, life_test_one_questions_q1=:Q1, life_test_one_questions_q2=:Q2, life_test_one_questions_q3=:Q3, life_test_one_questions_q4=:Q4, life_test_one_questions_q5=:Q5, life_test_one_questions_q6=:Q6, life_test_one_questions_q7=:Q7, life_test_one_questions_q8=:Q8, life_test_one_questions_q9=:Q9, life_test_one_questions_q10=:Q10, life_test_one_questions_q11=:Q11, life_test_one_questions_q12=:Q12, life_test_one_questions_q13=:Q13, life_test_one_questions_q14=:Q14");
        $INSERT_QUES->bindParam(':ID', $LAST_ID, PDO::PARAM_INT);
        $INSERT_QUES->bindParam(':Q1', $Q1, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q2', $Q2, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q3', $Q3, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q4', $Q4, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q5', $Q5, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q6', $Q6, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q7', $Q7, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q8', $Q8, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q9', $Q9, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q10', $Q10, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q11', $Q11, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q12', $Q12, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q13', $Q13, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q14', $Q14, PDO::PARAM_STR);
        $INSERT_QUES->execute();
        
        $INSERT_COM = $pdo->prepare("INSERT INTO life_test_one_comments SET life_test_one_comments_id_fk=:ID, life_test_one_comments_c1=:C1, life_test_one_comments_c2=:C2, life_test_one_comments_c3=:C3, life_test_one_comments_c4=:C4, life_test_one_comments_c5=:C5, life_test_one_comments_c6=:C6, life_test_one_comments_c7=:C7, life_test_one_comments_c8=:C8, life_test_one_comments_c9=:C9, life_test_one_comments_c10=:C10, life_test_one_comments_c11=:C11, life_test_one_comments_c12=:C12, life_test_one_comments_c13=:C13, life_test_one_comments_c14=:C14");
        $INSERT_COM->bindParam(':ID', $LAST_ID, PDO::PARAM_INT);
        $INSERT_COM->bindParam(':C1', $C1, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C2', $C2, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C3', $C3, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C4', $C4, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C5', $C5, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C6', $C6, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C7', $C7, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C8', $C8, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C9', $C9, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C10', $C10, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C11', $C11, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C12', $C12, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C13', $C13, PDO::PARAM_STR);
        $INSERT_COM->bindParam(':C14', $C14, PDO::PARAM_STR);
        $INSERT_COM->execute();
        
        $changereason="Took Insurance Test | Grade: $GRADE | Mark: $MARK/14";
            $database = new Database();
            $database->query("INSERT INTO employee_timeline set note_type='Took Test', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
        
        header('Location: ../Life.php?RETURN=ADDED&TEST=TESTONE&GRADE='.$GRADE.'&MARK='.$MARK);
        
    }
    if($EXECUTE=='2') {
        
    }
}

?>