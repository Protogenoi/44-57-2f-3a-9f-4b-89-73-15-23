<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../../includes/Access_Levels.php');
        if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

include('../../../includes/adlfunctions.php');
include('../../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($QRY)) {
        $action= filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
        include('../../../classes/database_class.php');
        if($QRY=='WOL') {

    $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);        
    $closer2= filter_input(INPUT_POST, 'closer2', FILTER_SANITIZE_SPECIAL_CHARS); 
    $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS); 
    $grade= filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);             
            
    $c1= filter_input(INPUT_POST, 'c1', FILTER_SANITIZE_SPECIAL_CHARS);
    $c2= filter_input(INPUT_POST, 'c2', FILTER_SANITIZE_SPECIAL_CHARS);
    $c3= filter_input(INPUT_POST, 'c3', FILTER_SANITIZE_SPECIAL_CHARS);
    $c4= filter_input(INPUT_POST, 'c4', FILTER_SANITIZE_SPECIAL_CHARS);
    $c5= filter_input(INPUT_POST, 'c5', FILTER_SANITIZE_SPECIAL_CHARS);
    $c6= filter_input(INPUT_POST, 'c6', FILTER_SANITIZE_SPECIAL_CHARS);
    $c7= filter_input(INPUT_POST, 'c7', FILTER_SANITIZE_SPECIAL_CHARS);
    $c8= filter_input(INPUT_POST, 'c8', FILTER_SANITIZE_SPECIAL_CHARS);
    $c9= filter_input(INPUT_POST, 'c9', FILTER_SANITIZE_SPECIAL_CHARS);
    $c10= filter_input(INPUT_POST, 'c10', FILTER_SANITIZE_SPECIAL_CHARS);
    $c11= filter_input(INPUT_POST, 'c11', FILTER_SANITIZE_SPECIAL_CHARS);
    $c12= filter_input(INPUT_POST, 'c12', FILTER_SANITIZE_SPECIAL_CHARS);
    $c13= filter_input(INPUT_POST, 'c13', FILTER_SANITIZE_SPECIAL_CHARS);
    $c14= filter_input(INPUT_POST, 'c14', FILTER_SANITIZE_SPECIAL_CHARS);
    $c15= filter_input(INPUT_POST, 'c15', FILTER_SANITIZE_SPECIAL_CHARS);
    $c16= filter_input(INPUT_POST, 'c16', FILTER_SANITIZE_SPECIAL_CHARS);
    $c17= filter_input(INPUT_POST, 'c17', FILTER_SANITIZE_SPECIAL_CHARS);
    $c18= filter_input(INPUT_POST, 'c18', FILTER_SANITIZE_SPECIAL_CHARS);
    $c19= filter_input(INPUT_POST, 'c19', FILTER_SANITIZE_SPECIAL_CHARS);
    $c20= filter_input(INPUT_POST, 'c20', FILTER_SANITIZE_SPECIAL_CHARS);
    $c21= filter_input(INPUT_POST, 'c21', FILTER_SANITIZE_SPECIAL_CHARS);
    $c22= filter_input(INPUT_POST, 'c22', FILTER_SANITIZE_SPECIAL_CHARS);
    $c23= filter_input(INPUT_POST, 'c23', FILTER_SANITIZE_SPECIAL_CHARS);
    $c24= filter_input(INPUT_POST, 'c24', FILTER_SANITIZE_SPECIAL_CHARS);
    $c25= filter_input(INPUT_POST, 'c25', FILTER_SANITIZE_SPECIAL_CHARS);
    $c26= filter_input(INPUT_POST, 'c26', FILTER_SANITIZE_SPECIAL_CHARS);
    $c27= filter_input(INPUT_POST, 'c27', FILTER_SANITIZE_SPECIAL_CHARS);
    $c28= filter_input(INPUT_POST, 'c28', FILTER_SANITIZE_SPECIAL_CHARS);
    $c29= filter_input(INPUT_POST, 'c29', FILTER_SANITIZE_SPECIAL_CHARS);
    $c30= filter_input(INPUT_POST, 'c30', FILTER_SANITIZE_SPECIAL_CHARS);
    $c31= filter_input(INPUT_POST, 'c31', FILTER_SANITIZE_SPECIAL_CHARS);
    $c32= filter_input(INPUT_POST, 'c32', FILTER_SANITIZE_SPECIAL_CHARS);
    $c33= filter_input(INPUT_POST, 'c33', FILTER_SANITIZE_SPECIAL_CHARS);
    $c34= filter_input(INPUT_POST, 'c34', FILTER_SANITIZE_SPECIAL_CHARS);
    $c35= filter_input(INPUT_POST, 'c35', FILTER_SANITIZE_SPECIAL_CHARS);
    $c36= filter_input(INPUT_POST, 'c36', FILTER_SANITIZE_SPECIAL_CHARS);   
    
$q1= filter_input(INPUT_POST, 'q1', FILTER_SANITIZE_NUMBER_INT);
    if(!isset($q1)) {
        $q1='9';
    }
    $q2= filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q2)) {
        $q2='9';
    }
    $q3= filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q3)) {
        $q3='9';
    }
    $q4= filter_input(INPUT_POST, 'q4', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q4)) {
        $q4='9';
    }
    $q5= filter_input(INPUT_POST, 'q5', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q5)) {
        $q5='9';
    }
    $q6= filter_input(INPUT_POST, 'q6', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q6)) {
        $q6='9';
    }
    $q7= filter_input(INPUT_POST, 'q7', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q7)) {
        $q7='9';
    }
    $q8= filter_input(INPUT_POST, 'q8', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q8)) {
        $q8='9';
    }
    $q9= filter_input(INPUT_POST, 'q9', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q9)) {
        $q9='9';
    }
    $q10= filter_input(INPUT_POST, 'q10', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q10)) {
        $q10='9';
    }
    $q11= filter_input(INPUT_POST, 'q11', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q11)) {
        $q11='9';
    }
    $q12= filter_input(INPUT_POST, 'q12', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q12)) {
        $q12='9';
    }
    $q13= filter_input(INPUT_POST, 'q13', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q13)) {
        $q13='9';
    }
    $q14= filter_input(INPUT_POST, 'q14', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q14)) {
        $q14='9';
    }
    $q15= filter_input(INPUT_POST, 'q15', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q15)) {
        $q15='9';
    }
    $q16= filter_input(INPUT_POST, 'q16', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q16)) {
        $q16='9';
    }
    $q17= filter_input(INPUT_POST, 'q17', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q17)) {
        $q17='9';
    }
    $q18= filter_input(INPUT_POST, 'q18', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q18)) {
        $q18='9';
    }
    $q19= filter_input(INPUT_POST, 'q19', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q19)) {
        $q19='9';
    }
    $q20= filter_input(INPUT_POST, 'q20', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q20)) {
        $q20='9';
    }
    $q21= filter_input(INPUT_POST, 'q21', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q21)) {
        $q21='9';
    }
    $q22= filter_input(INPUT_POST, 'q22', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q22)) {
        $q22='9';
    }
    $q23= filter_input(INPUT_POST, 'q23', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q23)) {
        $q23='9';
    }
    $q24= filter_input(INPUT_POST, 'q24', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q24)) {
        $q24='9';
    }
    $q25= filter_input(INPUT_POST, 'q25', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q25)) {
        $q25='9';
    }
    $q26= filter_input(INPUT_POST, 'q26', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q26)) {
        $q26='9';
    }
    $q27= filter_input(INPUT_POST, 'q27', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q27)) {
        $q27='9';
    }
    $q28= filter_input(INPUT_POST, 'q28', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q28)) {
        $q28='9';
    }
    $q29= filter_input(INPUT_POST, 'q29', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q29)) {
        $q29='9';
    }
    $q30= filter_input(INPUT_POST, 'q30', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q30)) {
        $q30='9';
    }
    $q31= filter_input(INPUT_POST, 'q31', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q31)) {
        $q31='9';
    }
    $q32= filter_input(INPUT_POST, 'q32', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q32)) {
        $q32='9';
    }
    $q33= filter_input(INPUT_POST, 'q33', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q33)) {
        $q33='9';
    }
    $q34= filter_input(INPUT_POST, 'q34', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q34)) {
        $q34='9';
    }
    $q35= filter_input(INPUT_POST, 'q35', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q35)) {
        $q35='9';
    }
    $q36= filter_input(INPUT_POST, 'q36', FILTER_SANITIZE_NUMBER_INT);
        if(!isset($q36)) {
        $q36='9';
    }    
            
            if($action=='Add') {
                
        $database = new Database(); 
        $database->beginTransaction();
        
       $database->query("INSERT INTO audit_wol set closer=:closer, closer2=:closer2, policy_number=:policy, grade=:grade, added_by=:hello");
       $database->bind(':closer', $closer);
       $database->bind(':closer2', $closer2);
       $database->bind(':policy', $policy_number);
       $database->bind(':grade', $grade);
       $database->bind(':hello', $hello_name);
       $database->execute();
       $lastid =  $database->lastInsertId();
    
       $database->query("INSERT INTO audit_wol_comments set wol_id=:id, c1=:c1, c2=:c2, c3=:c3, c4=:c4, c5=:c5, c6=:c6, c7=:c7, c8=:c8, c9=:c9, c10=:c10, c11=:c11, c12=:c12, c13=:c13, c14=:c14, c15=:c15, c16=:c16, c17=:c17, c18=:c18, c19=:c19, c20=:c20, c21=:c21, c22=:c22, c23=:c23, c24=:c24, c25=:c25, c26=:c26, c27=:c27, c28=:c28, c29=:c29, c30=:c30, c31=:c31, c32=:c32, c33=:c33, c34=:c34, c35=:c35, c36=:c36");
       $database->bind(':id', $lastid);
       $database->bind(':c1', $c1);
       $database->bind(':c2', $c2);
       $database->bind(':c3', $c3);
       $database->bind(':c4', $c4);
       $database->bind(':c5', $c5);
       $database->bind(':c6', $c6);
       $database->bind(':c7', $c7);
       $database->bind(':c8', $c8);
       $database->bind(':c9', $c9);
       $database->bind(':c10', $c10);
       $database->bind(':c11', $c11);
       $database->bind(':c12', $c12);
       $database->bind(':c13', $c13);
       $database->bind(':c14', $c14);
       $database->bind(':c15', $c15);
       $database->bind(':c16', $c16);
       $database->bind(':c17', $c17);
       $database->bind(':c18', $c18);
       $database->bind(':c19', $c19);
       $database->bind(':c20', $c20);
       $database->bind(':c21', $c21);
       $database->bind(':c22', $c22);
       $database->bind(':c23', $c23);
       $database->bind(':c24', $c24);
       $database->bind(':c25', $c25);
       $database->bind(':c26', $c26);
       $database->bind(':c27', $c27);
       $database->bind(':c28', $c28);
       $database->bind(':c29', $c29);
       $database->bind(':c30', $c30);
       $database->bind(':c31', $c31);
       $database->bind(':c32', $c32);
       $database->bind(':c33', $c33);
       $database->bind(':c34', $c34);
       $database->bind(':c35', $c35);
       $database->bind(':c36', $c36);
       $database->execute();

       $database->query("INSERT INTO audit_wol_questions set wol_id=:id, q1=:q1, q2=:q2, q3=:q3, q4=:q4, q5=:q5, q6=:q6, q7=:q7, q8=:q8, q9=:q9, q10=:q10, q11=:q11, q12=:q12, q13=:q13, q14=:q14, q15=:q15, q16=:q16, q17=:q17, q18=:q18, q19=:q19, q20=:q20, q21=:q21, q22=:q22, q23=:q23, q24=:q34, q25=:q25, q26=:q26, q27=:q27, q28=:q28, q29=:q29, q30=:q30, q31=:q31, q32=:q32, q33=:q33, q34=:q34, q35=:q35, q36=:q36");
       $database->bind(':id', $lastid);
       $database->bind(':q1', $q1);
       $database->bind(':q2', $q2);
       $database->bind(':q3', $q3);
       $database->bind(':q4', $q4);
       $database->bind(':q5', $q5);
       $database->bind(':q6', $q6);
       $database->bind(':q7', $q7);
       $database->bind(':q8', $q8);
       $database->bind(':q9', $q9);
       $database->bind(':q10', $q10);
       $database->bind(':q11', $q11);
       $database->bind(':q12', $q12);
       $database->bind(':q13', $q13);
       $database->bind(':q14', $q14);
       $database->bind(':q15', $q15);
       $database->bind(':q16', $q16);
       $database->bind(':q17', $q17);
       $database->bind(':q18', $q18);
       $database->bind(':q19', $q19);
       $database->bind(':q20', $q20);
       $database->bind(':q21', $q21);
       $database->bind(':q22', $q22);
       $database->bind(':q23', $q23);
       $database->bind(':q24', $q24);
       $database->bind(':q25', $q25);
       $database->bind(':q26', $q26);
       $database->bind(':q27', $q27);
       $database->bind(':q28', $q28);
       $database->bind(':q29', $q29);
       $database->bind(':q30', $q30);
       $database->bind(':q31', $q31);
       $database->bind(':q32', $q32);
       $database->bind(':q33', $q33);
       $database->bind(':q34', $q34);
       $database->bind(':q35', $q35);
       $database->bind(':q36', $q36);
       $database->execute();  
       
       $database->endTransaction();
       
            }

            if($action=='Edit') {
                $WOLID= filter_input(INPUT_GET, 'WOLID', FILTER_SANITIZE_NUMBER_INT);
                
                $database = new Database(); 
                $database->beginTransaction();
                
                $database->query("UPDATE audit_wol set closer=:closer, closer2=:closer2, policy_number=:policy, grade=:grade, updated_by=:hello WHERE wol_id=:id");
                $database->bind(':id', $WOLID);
                $database->bind(':closer', $closer);
                $database->bind(':closer2', $closer2);
                $database->bind(':policy', $policy_number);
                $database->bind(':grade', $grade);
                $database->bind(':hello', $hello_name);
                $database->execute();
                
                $database->query("UPDATE audit_wol_comments set c1=:c1, c2=:c2, c3=:c3, c4=:c4, c5=:c5, c6=:c6, c7=:c7, c8=:c8, c9=:c9, c10=:c10, c11=:c11, c12=:c12, c13=:c13, c14=:c14, c15=:c15, c16=:c16, c17=:c17, c18=:c18, c19=:c19, c20=:c20, c21=:c21, c22=:c22, c23=:c23, c24=:c24, c25=:c25, c26=:c26, c27=:c27, c28=:c28, c29=:c29, c30=:c30, c31=:c31, c32=:c32, c33=:c33, c34=:c34, c35=:c35, c36=:c36 WHERE wol_id=:id");
                $database->bind(':id', $WOLID);
                $database->bind(':c1', $c1);
                $database->bind(':c2', $c2);
                $database->bind(':c3', $c3);
                $database->bind(':c4', $c4);
                $database->bind(':c5', $c5);
                $database->bind(':c6', $c6);
                $database->bind(':c7', $c7);
                $database->bind(':c8', $c8);
                $database->bind(':c9', $c9);
                $database->bind(':c10', $c10);
                $database->bind(':c11', $c11);
                $database->bind(':c12', $c12);
                $database->bind(':c13', $c13);
                $database->bind(':c14', $c14);
                $database->bind(':c15', $c15);
                $database->bind(':c16', $c16);
                $database->bind(':c17', $c17);
                $database->bind(':c18', $c18);
                $database->bind(':c19', $c19);
                $database->bind(':c20', $c20);
                $database->bind(':c21', $c21);
                $database->bind(':c22', $c22);
                $database->bind(':c23', $c23);
                $database->bind(':c24', $c24);
                $database->bind(':c25', $c25);
                $database->bind(':c26', $c26);
                $database->bind(':c27', $c27);
                $database->bind(':c28', $c28);
                $database->bind(':c29', $c29);
                $database->bind(':c30', $c30);
                $database->bind(':c31', $c31);
                $database->bind(':c32', $c32);
                $database->bind(':c33', $c33);
                $database->bind(':c34', $c34);
                $database->bind(':c35', $c35);
                $database->bind(':c36', $c36);
                $database->execute();
                
                $database->query("UPDATE audit_wol_questions set q1=:q1, q2=:q2, q3=:q3, q4=:q4, q5=:q5, q6=:q6, q7=:q7, q8=:q8, q9=:q9, q10=:q10, q11=:q11, q12=:q12, q13=:q13, q14=:q14, q15=:q15, q16=:q16, q17=:q17, q18=:q18, q19=:q19, q20=:q20, q21=:q21, q22=:q22, q23=:q23, q24=:q34, q25=:q25, q26=:q26, q27=:q27, q28=:q28, q29=:q29, q30=:q30, q31=:q31, q32=:q32, q33=:q33, q34=:q34, q35=:q35, q36=:q36 WHERE wol_id=:id");
                $database->bind(':id', $WOLID);
                $database->bind(':q1', $q1);
                $database->bind(':q2', $q2);
                $database->bind(':q3', $q3);
                $database->bind(':q4', $q4);
                $database->bind(':q5', $q5);
                $database->bind(':q6', $q6);
                $database->bind(':q7', $q7);
                $database->bind(':q8', $q8);
                $database->bind(':q9', $q9);
                $database->bind(':q10', $q10);
                $database->bind(':q11', $q11);
                $database->bind(':q12', $q12);
                $database->bind(':q13', $q13);
                $database->bind(':q14', $q14);
                $database->bind(':q15', $q15);
                $database->bind(':q16', $q16);
                $database->bind(':q17', $q17);
                $database->bind(':q18', $q18);
                $database->bind(':q19', $q19);
                $database->bind(':q20', $q20);
                $database->bind(':q21', $q21);
                $database->bind(':q22', $q22);
                $database->bind(':q23', $q23);
                $database->bind(':q24', $q24);
                $database->bind(':q25', $q25);
                $database->bind(':q26', $q26);
                $database->bind(':q27', $q27);
                $database->bind(':q28', $q28);
                $database->bind(':q29', $q29);
                $database->bind(':q30', $q30);
                $database->bind(':q31', $q31);
                $database->bind(':q32', $q32);
                $database->bind(':q33', $q33);
                $database->bind(':q34', $q34);
                $database->bind(':q35', $q35);
                $database->bind(':q36', $q36);
                $database->execute(); 
                
                $database->endTransaction(); 
                
            }
            }
            }
            ?>