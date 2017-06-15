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
    
 
    $Q2 = filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q3 = filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q15 = filter_input(INPUT_POST, 'q15', FILTER_SANITIZE_SPECIAL_CHARS);
    
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
        
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND CONCAT(firstname, ' ', lastname)=:NAME");
    $query->bindParam(':NAME', $hello_name, PDO::PARAM_STR);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];

        $INSERT = $pdo->prepare("INSERT INTO life_test_two SET life_test_two_id_fk=:FK, life_test_two_company=:COMPANY, life_test_two_advisor=:ADVISOR");
        $INSERT->bindParam(':FK', $ID_FK, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':ADVISOR', $hello_name, PDO::PARAM_STR);
        $INSERT->execute();
        
        $LAST_ID = $pdo->lastInsertId();
        
        $INSERT_QUES = $pdo->prepare("INSERT INTO life_test_two_qa SET life_test_two_qa_id_fk=:ID, life_test_two_qa_q2=:Q2, life_test_two_qa_q3=:Q3, life_test_two_qa_q15=:Q15, life_test_two_qa_c1=:C1, life_test_two_qa_c2=:C2, life_test_two_qa_c3=:C3, life_test_two_qa_c4=:C4, life_test_two_qa_c5=:C5, life_test_two_qa_c6=:C6, life_test_two_qa_c7=:C7, life_test_two_qa_c8=:C8, life_test_two_qa_c9=:C9, life_test_two_qa_c10=:C10, life_test_two_qa_c11=:C11, life_test_two_qa_c12=:C12, life_test_two_qa_c13=:C13, life_test_two_qa_c14=:C14, life_test_two_qa_c15=:C15");
        $INSERT_QUES->bindParam(':ID', $LAST_ID, PDO::PARAM_INT);
        $INSERT_QUES->bindParam(':Q2', $Q2, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q3', $Q3, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':Q15', $Q15, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C1', $C1, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C2', $C2, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C3', $C3, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C4', $C4, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C5', $C5, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C6', $C6, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C7', $C7, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C8', $C8, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C9', $C9, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C10', $C10, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C11', $C11, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C12', $C12, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C13', $C13, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C14', $C14, PDO::PARAM_STR);
        $INSERT_QUES->bindParam(':C15', $C15, PDO::PARAM_STR);
        $INSERT_QUES->execute();
        
            $changereason="Took Protection Test | Awaiting to be marked";
            $database = new Database();
            $database->query("INSERT INTO employee_timeline set note_type='Took Test', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 

        
        header('Location: ../Protection.php?RETURN=ADDED&TEST=TESTTWO');
        
    }
    if($EXECUTE=='2') {
        
        $TID = filter_input(INPUT_GET, 'TID', FILTER_SANITIZE_NUMBER_INT);
        $PROTECTION_MARK = filter_input(INPUT_POST, 'PROTECTION_MARK', FILTER_SANITIZE_NUMBER_INT);
        $NAME = filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);
        
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND CONCAT(firstname, ' ', lastname)=:NAME");
    $query->bindParam(':NAME', $NAME, PDO::PARAM_STR);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];        
    
    $AUD_ID = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND CONCAT(firstname, ' ', lastname)=:NAME");
    $AUD_ID->bindParam(':NAME', $hello_name, PDO::PARAM_STR);
    $AUD_ID->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $AUD_ID->execute();
    $data2 = $AUD_ID->fetch(PDO::FETCH_ASSOC); 
    
    $AUDI_ID_FK=$data2['employee_id'];   

        $GRADE_PERCENT = $PROTECTION_MARK/15 * 100;
        
if($GRADE_PERCENT>=60) {
    $GRADE='Green';
    }
    if($GRADE_PERCENT>=30 && $GRADE_PERCENT<60) {
        $GRADE='Amber';
        }
        if($GRADE_PERCENT<30) {
            $GRADE='Red';
            }        
        
        
        $INSERT = $pdo->prepare("UPDATE life_test_two SET life_test_two_mark=:MARK, life_test_two_grade=:GRADE, life_test_two_auditor=:AUDITOR WHERE life_test_two_id=:FK AND life_test_two_company=:COMPANY");
        $INSERT->bindParam(':FK', $TID, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':AUDITOR', $hello_name, PDO::PARAM_STR);
        $INSERT->bindParam(':MARK', $PROTECTION_MARK, PDO::PARAM_STR);
        $INSERT->bindParam(':GRADE', $GRADE, PDO::PARAM_STR);
        $INSERT->execute();        
        
            $changereason="Protection Test | Marked $PROTECTION_MARK/15 | GRADE: $GRADE";
            $database = new Database();
            $database->query("INSERT INTO employee_timeline set note_type='Test Marked', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute();
            
            $NOTE="Protection Test | Marked $PROTECTION_MARK/15 | GRADE: $GRADE for $NAME";

            $database->query("INSERT INTO employee_timeline set note_type='Test Marked', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$AUDI_ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$NOTE); 
            $database->execute();                
        
       header('Location: ../Protection.php?RETURN=ADDED&TEST=TESTTWOMARKED');     
        
    }
}

?>