<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
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
$AGENCY = filter_input(INPUT_GET, 'AGENCY', FILTER_SANITIZE_SPECIAL_CHARS);

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
    
    
    if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='Assured Protect and Mortgages';
    }
                if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    $COMPANY='The Review Bureau';
    $hello_name="Michael Owen";
    }

    
    if($EXECUTE=='1') {
        
    $query = $pdo->prepare("SELECT compliance_agents_id FROM compliance_agents WHERE compliance_agents_company=:COMPANY AND compliance_agents_name=:NAME");
    $query->bindParam(':NAME', $hello_name, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['compliance_agents_id'];

        $INSERT = $pdo->prepare("INSERT INTO life_test_two SET life_test_two_id_fk=:FK, life_test_two_company=:COMPANY, life_test_two_advisor=:ADVISOR");
        $INSERT->bindParam(':FK', $ID_FK, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY, PDO::PARAM_STR);
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

        
        header('Location: ../Protection.php?RETURN=ADDED&TEST=TESTTWO');
        
    }
    if($EXECUTE=='2') {
        
    }
}

?>