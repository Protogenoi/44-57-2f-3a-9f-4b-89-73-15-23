<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);   
     
    if(isset($EXECUTE)) { 
        
    $CLOSER= filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $POLICY= filter_input(INPUT_POST, 'POLICY', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE= filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);        

    $Q_OD1= filter_input(INPUT_POST, 'OD1', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_OD1)) {
        $Q_OD1='9';
    }
    
    $Q_OD2= filter_input(INPUT_POST, 'OD2', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_OD2)) {
        $Q_OD2='9';
    }    
    
    $Q_OD3= filter_input(INPUT_POST, 'OD3', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_OD3)) {
        $Q_OD3='9';
    }
    
    $Q_OD4= filter_input(INPUT_POST, 'OD4', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_OD4)) {
        $Q_OD4='9';
    }    
    
    $Q_OD5= filter_input(INPUT_POST, 'OD5', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_OD5)) {
        $Q_OD5='9';
    }    
    
    $Q_CI1= filter_input(INPUT_POST, 'CI1', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_CI1)) {
        $Q_CI1='9';
    }    
    
    $Q_CI2= filter_input(INPUT_POST, 'CI2', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_CI2)) {
        $Q_CI2='9';
    }  
    
    $Q_CI3= filter_input(INPUT_POST, 'CI3', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_CI3)) {
        $Q_CI3='9';
    }     
    
    $Q_CI4= filter_input(INPUT_POST, 'CI4', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_CI4)) {
        $Q_CI4='9';
    }    
    
    $Q_CI5= filter_input(INPUT_POST, 'CI5', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_CI5)) {
        $Q_CI5='9';
    }

    $Q_CI6= filter_input(INPUT_POST, 'CI6', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_CI6)) {
        $Q_CI6='9';
    }       

    $Q_ICN1= filter_input(INPUT_POST, 'ICN1', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_ICN1)) {
        $Q_ICN1='9';
    }       
    
    $Q_ICN2= filter_input(INPUT_POST, 'ICN2', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_ICN2)) {
        $Q_ICN2='9';
    }       
    
    $Q_ICN3= filter_input(INPUT_POST, 'ICN3', FILTER_SANITIZE_NUMBER_INT);
 
    if(!is_numeric($Q_ICN3)) {
        $Q_ICN3='9';
    }       
    
    $Q_ICN4= filter_input(INPUT_POST, 'ICN4', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_ICN4)) {
        $Q_ICN4='9';
    }       
    
    $Q_ICN5= filter_input(INPUT_POST, 'ICN5', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_ICN5)) {
        $Q_ICN5='9';
    }  
    
    $Q_ICN6= filter_input(INPUT_POST, 'ICN6', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_ICN6)) {
        $Q_ICN6='9';
    }  

    $T_OD1= filter_input(INPUT_POST, 'TOD1', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_OD2= filter_input(INPUT_POST, 'TOD2', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_OD3= filter_input(INPUT_POST, 'TOD3', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_OD4= filter_input(INPUT_POST, 'TOD4', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_OD5= filter_input(INPUT_POST, 'TOD5', FILTER_SANITIZE_SPECIAL_CHARS);  
    
    $T_CI1= filter_input(INPUT_POST, 'TCI1', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_CI2= filter_input(INPUT_POST, 'TCI2', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_CI3= filter_input(INPUT_POST, 'TCI3', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_CI4= filter_input(INPUT_POST, 'TCI4', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_CI5= filter_input(INPUT_POST, 'TCI5', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_CI6= filter_input(INPUT_POST, 'TCI6', FILTER_SANITIZE_SPECIAL_CHARS);  

    $T_ICN1= filter_input(INPUT_POST, 'TICN1', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_ICN2= filter_input(INPUT_POST, 'TICN2', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_ICN3= filter_input(INPUT_POST, 'TICN3', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_ICN4= filter_input(INPUT_POST, 'TICN4', FILTER_SANITIZE_SPECIAL_CHARS);  
    $T_ICN5= filter_input(INPUT_POST, 'TICN5', FILTER_SANITIZE_SPECIAL_CHARS);  
    
    $Q_E1= filter_input(INPUT_POST, 'E1', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_E1)) {
        $Q_E1='9';
    }  
    
    $Q_E2= filter_input(INPUT_POST, 'E2', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_E2)) {
        $Q_E2='9';
    } 
    
    $Q_E3= filter_input(INPUT_POST, 'E3', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_E3)) {
        $Q_E3='9';
    }    
    
    $Q_E4= filter_input(INPUT_POST, 'E4', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_E4)) {
        $Q_E4='9';
    }    
    
    $Q_E5= filter_input(INPUT_POST, 'E5', FILTER_SANITIZE_NUMBER_INT);

    if(!is_numeric($Q_E5)) {
        $Q_E5='9';
    }    
    
    $Q_E6= filter_input(INPUT_POST, 'E6', FILTER_SANITIZE_NUMBER_INT);
    
    if(!is_numeric($Q_E6)) {
        $Q_E6='9';
    }    
    
    $Q_E7= filter_input(INPUT_POST, 'E7', FILTER_SANITIZE_NUMBER_INT); 

    if(!is_numeric($Q_E7)) {
        $Q_E7='9';
    }    
    
    $Q_E8= filter_input(INPUT_POST, 'E8', FILTER_SANITIZE_NUMBER_INT); 
  
    if(!is_numeric($Q_E8)) {
        $Q_E8='9';
    }    
    
    $Q_E9= filter_input(INPUT_POST, 'E9', FILTER_SANITIZE_NUMBER_INT); 

    if(!is_numeric($Q_E9)) {
        $Q_E9='9';
    }    
    
    $Q_E10= filter_input(INPUT_POST, 'E10', FILTER_SANITIZE_NUMBER_INT); 
    
    if(!is_numeric($Q_E10)) {
        $Q_E10='9';
    }  
    
    $Q_E11= filter_input(INPUT_POST, 'E11', FILTER_SANITIZE_NUMBER_INT); 
    
    if(!is_numeric($Q_E11)) {
        $Q_E11='9';
    }    
    
    $Q_E12= filter_input(INPUT_POST, 'E12', FILTER_SANITIZE_NUMBER_INT); 

    if(!is_numeric($Q_E12)) {
        $Q_E12='9';
    }    
    
    $Q_E13= filter_input(INPUT_POST, 'E13', FILTER_SANITIZE_NUMBER_INT); 
    
    if(!is_numeric($Q_E13)) {
        $Q_E13='9';
    }    
    
    $Q_E14= filter_input(INPUT_POST, 'E14', FILTER_SANITIZE_NUMBER_INT); 
    
    if(!is_numeric($Q_E14)) {
        $Q_E14='9';
    } 
    
    $T_E1= filter_input(INPUT_POST, 'TE1', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_E2= filter_input(INPUT_POST, 'TE2', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_E3= filter_input(INPUT_POST, 'TE3', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_E4= filter_input(INPUT_POST, 'TE4', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_E5= filter_input(INPUT_POST, 'TE5', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_E6= filter_input(INPUT_POST, 'TE6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E7= filter_input(INPUT_POST, 'TE7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E8= filter_input(INPUT_POST, 'TE8', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E9= filter_input(INPUT_POST, 'TE9', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E10= filter_input(INPUT_POST, 'TE10', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E11= filter_input(INPUT_POST, 'TE11', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E12= filter_input(INPUT_POST, 'TE12', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E13= filter_input(INPUT_POST, 'TE13', FILTER_SANITIZE_SPECIAL_CHARS); 
    $T_E14= filter_input(INPUT_POST, 'TE14', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $Q_DI1= filter_input(INPUT_POST, 'DI1', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_DI1)) {
        $Q_DI1='9';
    }     
    
    $Q_DI2= filter_input(INPUT_POST, 'DI2', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    if(!is_numeric($Q_DI2)) {
        $Q_DI2='9';
    }    
    
    $Q_PI1= filter_input(INPUT_POST, 'PI1', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_PI1)) {
        $Q_PI1='9';
    }      

    $Q_PI2= filter_input(INPUT_POST, 'PI2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_PI2)) {
        $Q_PI2='9';
    } 
    
    $Q_PI3= filter_input(INPUT_POST, 'PI3', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_PI3)) {
        $Q_PI3='9';
    }     
    
    $Q_PI4= filter_input(INPUT_POST, 'PI4', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_PI4)) {
        $Q_PI4='9';
    } 
    
    $Q_PI5= filter_input(INPUT_POST, 'PI5', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    if(!is_numeric($Q_PI5)) {
        $Q_PI5='9';
    }     
    

    $Q_CD1= filter_input(INPUT_POST, 'CD1', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD1)) {
        $Q_CD1='9';
    }  
    
    $Q_CD2= filter_input(INPUT_POST, 'CD2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD2)) {
        $Q_CD2='9';
    }  
    
    $Q_CD3= filter_input(INPUT_POST, 'CD3', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD3)) {
        $Q_CD3='9';
    }    
    
    $Q_CD4= filter_input(INPUT_POST, 'CD4', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD4)) {
        $Q_CD4='9';
    }      
    
    $Q_CD5= filter_input(INPUT_POST, 'CD5', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_CD5)) {
        $Q_CD5='9';
    }      
    
    $Q_CD6= filter_input(INPUT_POST, 'CD6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD6)) {
        $Q_CD6='9';
    }      
    
    $Q_CD7= filter_input(INPUT_POST, 'CD7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD7)) {
        $Q_CD7='9';
    }      
    
    $Q_CD8= filter_input(INPUT_POST, 'CD8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_CD8)) {
        $Q_CD8='9';
    }      

    $Q_QC1= filter_input(INPUT_POST, 'QC1', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_QC1)) {
        $Q_QC1='9';
    }    
    
    $Q_QC2= filter_input(INPUT_POST, 'QC2', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_QC2)) {
        $Q_QC2='9';
    }       
    
    $Q_QC3= filter_input(INPUT_POST, 'QC3', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_QC3)) {
        $Q_QC3='9';
    }     
    
    $Q_QC4= filter_input(INPUT_POST, 'QC4', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_QC4)) {
        $Q_QC4='9';
    }   
    
    $Q_QC5= filter_input(INPUT_POST, 'QC5', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!is_numeric($Q_QC5)) {
        $Q_QC5='9';
    }       
    
    $Q_QC6= filter_input(INPUT_POST, 'QC6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_QC6)) {
        $Q_QC6='9';
    }      
    
    $Q_QC7= filter_input(INPUT_POST, 'QC7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!is_numeric($Q_QC7)) {
        $Q_QC7='9';
    }      
    
    $T_DI1= filter_input(INPUT_POST, 'TDI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_DI2= filter_input(INPUT_POST, 'TDI2', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $T_PI1= filter_input(INPUT_POST, 'TPI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_PI2= filter_input(INPUT_POST, 'TPI2', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_PI3= filter_input(INPUT_POST, 'TPI3', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_PI4= filter_input(INPUT_POST, 'TPI4', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_PI5= filter_input(INPUT_POST, 'TPI5', FILTER_SANITIZE_SPECIAL_CHARS);    

    $T_CD1= filter_input(INPUT_POST, 'TCD1', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD2= filter_input(INPUT_POST, 'TCD2', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD3= filter_input(INPUT_POST, 'TCD3', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD4= filter_input(INPUT_POST, 'TCD4', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD5= filter_input(INPUT_POST, 'TCD5', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD6= filter_input(INPUT_POST, 'TCD6', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD7= filter_input(INPUT_POST, 'TCD7', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_CD8= filter_input(INPUT_POST, 'TCD8', FILTER_SANITIZE_SPECIAL_CHARS);

    $T_QC1= filter_input(INPUT_POST, 'TQC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC2= filter_input(INPUT_POST, 'TQC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC3= filter_input(INPUT_POST, 'TQC3', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC4= filter_input(INPUT_POST, 'TQC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC5= filter_input(INPUT_POST, 'TQC5', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC6= filter_input(INPUT_POST, 'TQC6', FILTER_SANITIZE_SPECIAL_CHARS);
    $T_QC7= filter_input(INPUT_POST, 'TQC7', FILTER_SANITIZE_SPECIAL_CHARS);            
        
        if($EXECUTE=='1') {

    $AVIVA_AUDIT_QRY = $pdo->prepare("INSERT INTO aviva_audit SET aviva_audit_grade=:GRADE, aviva_audit_added_by=:HELLO, aviva_audit_policy=:POLICY, aviva_audit_closer=:CLOSER");
    $AVIVA_AUDIT_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
    $AVIVA_AUDIT_QRY->bindParam(':GRADE', $GRADE, PDO::PARAM_STR);
    $AVIVA_AUDIT_QRY->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR);
    $AVIVA_AUDIT_QRY->bindParam(':POLICY', $POLICY, PDO::PARAM_STR);
    $AVIVA_AUDIT_QRY->execute()or die(print_r($AVIVA_AUDIT_QRY->errorInfo(), true));
    $LAST_AUDITID = $pdo->lastInsertId();    
    
    if(isset($LAST_AUDITID)) {  
    
    $AVIVA_INSERT_1 = $pdo->prepare("INSERT INTO aviva_ques SET
 aviva_ques_id_fk=:FK,
 aviva_ques_od1=:OD1,
 aviva_ques_od2=:OD2,
 aviva_ques_od3=:OD3,
 aviva_ques_od4=:OD4,
 aviva_ques_od5=:OD5,
 aviva_ques_ci1=:CI1,
 aviva_ques_ci2=:CI2,
 aviva_ques_ci3=:CI3,
 aviva_ques_ci4=:CI4,
 aviva_ques_ci5=:CI5,
 aviva_ques_ci6=:CI6,
 aviva_ques_icn1=:ICN1,
 aviva_ques_icn2=:ICN2,
 aviva_ques_icn3=:ICN3,
 aviva_ques_icn4=:ICN4,
 aviva_ques_icn5=:ICN5,
 aviva_ques_icn6=:ICN6");
    $AVIVA_INSERT_1->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':OD1', $Q_OD1, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':OD2', $Q_OD2, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':OD3', $Q_OD3, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':OD4', $Q_OD4, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':OD5', $Q_OD5, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI1', $Q_CI1, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI2', $Q_CI2, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI3', $Q_CI3, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI4', $Q_CI4, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI5', $Q_CI5, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':CI6', $Q_CI6, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN1', $Q_ICN1, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN2', $Q_ICN2, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN3', $Q_ICN3, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN4', $Q_ICN4, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN5', $Q_ICN5, PDO::PARAM_INT);
    $AVIVA_INSERT_1->bindParam(':ICN6', $Q_ICN6, PDO::PARAM_INT);    
    $AVIVA_INSERT_1->execute()or die(print_r($AVIVA_INSERT_1->errorInfo(), true));   

    $AVIVA_INSERT_2 = $pdo->prepare("INSERT INTO aviva_comms SET
 aviva_comms_id_fk=:FK,
 aviva_comms_od1=:OD1,
 aviva_comms_od2=:OD2,
 aviva_comms_od3=:OD3,
 aviva_comms_od4=:OD4,
 aviva_comms_od5=:OD5,
 aviva_comms_ci1=:CI1,
 aviva_comms_ci2=:CI2,
 aviva_comms_ci3=:CI3,
 aviva_comms_ci4=:CI4,
 aviva_comms_ci5=:CI5,
 aviva_comms_ci6=:CI6,
 aviva_comms_icn1=:ICN1,
 aviva_comms_icn2=:ICN2,
 aviva_comms_icn3=:ICN3,
 aviva_comms_icn4=:ICN4,
 aviva_comms_icn5=:ICN5,
 aviva_comms_icn6=:ICN6");
    $AVIVA_INSERT_2->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_2->bindParam(':OD1', $T_OD1, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':OD2', $T_OD2, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':OD3', $T_OD3, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':OD4', $T_OD4, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':OD5', $T_OD5, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI1', $T_CI1, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI2', $T_CI2, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI3', $T_CI3, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI4', $T_CI4, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI5', $T_CI5, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':CI6', $T_CI6, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN1', $T_ICN1, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN2', $T_ICN2, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN3', $T_ICN3, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN4', $T_ICN4, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN5', $T_ICN5, PDO::PARAM_STR);
    $AVIVA_INSERT_2->bindParam(':ICN6', $T_ICN6, PDO::PARAM_STR);    
    $AVIVA_INSERT_2->execute()or die(print_r($AVIVA_INSERT_2->errorInfo(), true)); 
    
    $AVIVA_INSERT_3 = $pdo->prepare("INSERT INTO aviva_ques_2 SET
 aviva_ques_2_id_fk=:FK,
 aviva_ques_2_e1=:E1,
 aviva_ques_2_e2=:E2,
 aviva_ques_2_e3=:E3,
 aviva_ques_2_e4=:E4,
 aviva_ques_2_e5=:E5,
 aviva_ques_2_e6=:E6,
 aviva_ques_2_e7=:E7,
 aviva_ques_2_e8=:E8,
 aviva_ques_2_e9=:E9,
 aviva_ques_2_e10=:E10,
 aviva_ques_2_e11=:E11,
 aviva_ques_2_e12=:E12,
 aviva_ques_2_e13=:E13,
 aviva_ques_2_e14=:E14");
    $AVIVA_INSERT_3->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E1', $Q_E1, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E2', $Q_E2, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E3', $Q_E3, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E4', $Q_E4, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E5', $Q_E5, PDO::PARAM_INT);
    $AVIVA_INSERT_3->bindParam(':E6', $Q_E6, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E7', $Q_E7, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E8', $Q_E8, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E9', $Q_E9, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E10', $Q_E10, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E11', $Q_E11, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E12', $Q_E12, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E13', $Q_E13, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->bindParam(':E14', $Q_E14, PDO::PARAM_INT); 
    $AVIVA_INSERT_3->execute()or die(print_r($AVIVA_INSERT_3->errorInfo(), true));  
    
    $AVIVA_INSERT_4 = $pdo->prepare("INSERT INTO aviva_comms_2 SET
 aviva_comms_2_id_fk=:FK,
 aviva_comms_2_e1=:E1,
 aviva_comms_2_e2=:E2,
 aviva_comms_2_e3=:E3,
 aviva_comms_2_e4=:E4,
 aviva_comms_2_e5=:E5,
 aviva_comms_2_e6=:E6,
 aviva_comms_2_e7=:E7,
 aviva_comms_2_e8=:E8,
 aviva_comms_2_e9=:E9,
 aviva_comms_2_e10=:E10,
 aviva_comms_2_e11=:E11,
 aviva_comms_2_e12=:E12,
 aviva_comms_2_e13=:E13,
 aviva_comms_2_e14=:E14");
    $AVIVA_INSERT_4->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_4->bindParam(':E1', $T_E1, PDO::PARAM_STR);
    $AVIVA_INSERT_4->bindParam(':E2', $T_E2, PDO::PARAM_STR);
    $AVIVA_INSERT_4->bindParam(':E3', $T_E3, PDO::PARAM_STR);
    $AVIVA_INSERT_4->bindParam(':E4', $T_E4, PDO::PARAM_STR);
    $AVIVA_INSERT_4->bindParam(':E5', $T_E5, PDO::PARAM_STR);
    $AVIVA_INSERT_4->bindParam(':E6', $T_E6, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E7', $T_E7, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E8', $T_E8, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E9', $T_E9, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E10', $T_E10, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E11', $T_E11, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E12', $T_E12, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E13', $T_E13, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->bindParam(':E14', $T_E14, PDO::PARAM_STR); 
    $AVIVA_INSERT_4->execute()or die(print_r($AVIVA_INSERT_4->errorInfo(), true));     

    $AVIVA_INSERT_5 = $pdo->prepare("INSERT INTO aviva_ques_3 SET
 aviva_ques_3_id_fk=:FK,
 aviva_ques_3_di1=:DI1,
 aviva_ques_3_di2=:DI2,
 aviva_ques_3_pi1=:PI1,
 aviva_ques_3_pi2=:PI2,
 aviva_ques_3_pi3=:PI3,
 aviva_ques_3_pi4=:PI4,
 aviva_ques_3_pi5=:PI5,
 aviva_ques_3_cd1=:CD1,
 aviva_ques_3_cd2=:CD2,
 aviva_ques_3_cd3=:CD3,
 aviva_ques_3_cd4=:CD4,
 aviva_ques_3_cd5=:CD5,
 aviva_ques_3_cd6=:CD6,
 aviva_ques_3_cd7=:CD7,
 aviva_ques_3_cd8=:CD8,
 aviva_ques_3_qc1=:QC1,
 aviva_ques_3_qc2=:QC2,
 aviva_ques_3_qc3=:QC3,
 aviva_ques_3_qc4=:QC4,
 aviva_ques_3_qc5=:QC5,
 aviva_ques_3_qc6=:QC6,
 aviva_ques_3_qc7=:QC7");
    $AVIVA_INSERT_5->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':DI1', $Q_DI1, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':DI2', $Q_DI2, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':PI1', $Q_PI1, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':PI2', $Q_PI2, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':PI3', $Q_PI3, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':PI4', $Q_PI4, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':PI5', $Q_PI5, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD1', $Q_CD1, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD2', $Q_CD2, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD3', $Q_CD3, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD4', $Q_CD4, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD5', $Q_CD5, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':CD6', $Q_CD6, PDO::PARAM_INT);  
    $AVIVA_INSERT_5->bindParam(':CD7', $Q_CD7, PDO::PARAM_INT);  
    $AVIVA_INSERT_5->bindParam(':CD8', $Q_CD8, PDO::PARAM_INT);  
    $AVIVA_INSERT_5->bindParam(':QC1', $Q_QC1, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':QC2', $Q_QC2, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':QC3', $Q_QC3, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':QC4', $Q_QC4, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':QC5', $Q_QC5, PDO::PARAM_INT);
    $AVIVA_INSERT_5->bindParam(':QC6', $Q_QC6, PDO::PARAM_INT);  
    $AVIVA_INSERT_5->bindParam(':QC7', $Q_QC7, PDO::PARAM_INT);      
    $AVIVA_INSERT_5->execute()or die(print_r($AVIVA_INSERT_5->errorInfo(), true));   
    
    $AVIVA_INSERT_6 = $pdo->prepare("INSERT INTO aviva_comms_3 SET
 aviva_comms_3_id_fk=:FK,
 aviva_comms_3_di1=:DI1,
 aviva_comms_3_di2=:DI2,
 aviva_comms_3_pi1=:PI1,
 aviva_comms_3_pi2=:PI2,
 aviva_comms_3_pi3=:PI3,
 aviva_comms_3_pi4=:PI4,
 aviva_comms_3_pi5=:PI5,
 aviva_comms_3_cd1=:CD1,
 aviva_comms_3_cd2=:CD2,
 aviva_comms_3_cd3=:CD3,
 aviva_comms_3_cd4=:CD4,
 aviva_comms_3_cd5=:CD5,
 aviva_comms_3_cd6=:CD6,
 aviva_comms_3_cd7=:CD7,
 aviva_comms_3_cd8=:CD8,
 aviva_comms_3_qc1=:QC1,
 aviva_comms_3_qc2=:QC2,
 aviva_comms_3_qc3=:QC3,
 aviva_comms_3_qc4=:QC4,
 aviva_comms_3_qc5=:QC5,
 aviva_comms_3_qc6=:QC6,
 aviva_comms_3_qc7=:QC7");
    $AVIVA_INSERT_6->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $AVIVA_INSERT_6->bindParam(':DI1', $T_DI1, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':DI2', $T_DI2, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':PI1', $T_PI1, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':PI2', $T_PI2, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':PI3', $T_PI3, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':PI4', $T_PI4, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':PI5', $T_PI5, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD1', $T_CD1, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD2', $T_CD2, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD3', $T_CD3, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD4', $T_CD4, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD5', $T_CD5, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':CD6', $T_CD6, PDO::PARAM_STR);  
    $AVIVA_INSERT_6->bindParam(':CD7', $T_CD7, PDO::PARAM_STR);  
    $AVIVA_INSERT_6->bindParam(':CD8', $T_CD8, PDO::PARAM_STR);  
    $AVIVA_INSERT_6->bindParam(':QC1', $T_QC1, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':QC2', $T_QC2, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':QC3', $T_QC3, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':QC4', $T_QC4, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':QC5', $T_QC5, PDO::PARAM_STR);
    $AVIVA_INSERT_6->bindParam(':QC6', $T_QC6, PDO::PARAM_STR);  
    $AVIVA_INSERT_6->bindParam(':QC7', $T_QC7, PDO::PARAM_STR);      
    $AVIVA_INSERT_6->execute()or die(print_r($AVIVA_INSERT_6->errorInfo(), true));    

    header('Location: ../Menu.php?RETURN=ADDED&GRADE='.$GRADE); die;
      
        }
    }
    
        if($EXECUTE=='2') {

    $AID= filter_input(INPUT_GET, 'AID', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $AVIVA_AUDIT_QRY = $pdo->prepare("SELECT aviva_audit_id from aviva_audit WHERE aviva_audit_id=:AID");
    $AVIVA_AUDIT_QRY->bindParam(':AID', $AID, PDO::PARAM_INT);
    $AVIVA_AUDIT_QRY->execute()or die(print_r($AVIVA_AUDIT_QRY->errorInfo(), true));
    $CHK_AID = $AVIVA_AUDIT_QRY->fetch(PDO::FETCH_ASSOC); 
  
    
    if(isset($CHK_AID['aviva_audit_id'])) {   

    $AVIVA_UPDATE = $pdo->prepare("UPDATE 
        aviva_audit 
            SET
                aviva_audit_grade=:GRADE, aviva_audit_updated_by=:HELLO, aviva_audit_closer=:CLOSER, aviva_audit_policy=:POLICY
            WHERE
                aviva_audit_id=:AID");
    $AVIVA_UPDATE->bindParam(':AID', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
    $AVIVA_UPDATE->bindParam(':GRADE', $GRADE, PDO::PARAM_STR);
    $AVIVA_UPDATE->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR);
    $AVIVA_UPDATE->bindParam(':POLICY', $POLICY, PDO::PARAM_STR);
    $AVIVA_UPDATE->execute()or die(print_r($AVIVA_UPDATE->errorInfo(), true));        
    
    $AVIVA_UPDATE_1 = $pdo->prepare("UPDATE aviva_ques SET
    aviva_ques_od1=:OD1,
    aviva_ques_od2=:OD2,
    aviva_ques_od3=:OD3,
    aviva_ques_od4=:OD4,
    aviva_ques_od5=:OD5,
    aviva_ques_ci1=:CI1,
    aviva_ques_ci2=:CI2,
    aviva_ques_ci3=:CI3,
    aviva_ques_ci4=:CI4,
    aviva_ques_ci5=:CI5,
    aviva_ques_ci6=:CI6,
    aviva_ques_icn1=:ICN1,
    aviva_ques_icn2=:ICN2,
    aviva_ques_icn3=:ICN3,
    aviva_ques_icn4=:ICN4,
    aviva_ques_icn5=:ICN5,
    aviva_ques_icn6=:ICN6
 WHERE
     aviva_ques_id_fk=:FK");
    $AVIVA_UPDATE_1->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':OD1', $Q_OD1, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':OD2', $Q_OD2, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':OD3', $Q_OD3, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':OD4', $Q_OD4, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':OD5', $Q_OD5, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI1', $Q_CI1, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI2', $Q_CI2, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI3', $Q_CI3, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI4', $Q_CI4, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI5', $Q_CI5, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':CI6', $Q_CI6, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN1', $Q_ICN1, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN2', $Q_ICN2, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN3', $Q_ICN3, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN4', $Q_ICN4, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN5', $Q_ICN5, PDO::PARAM_INT);
    $AVIVA_UPDATE_1->bindParam(':ICN6', $Q_ICN6, PDO::PARAM_INT);    
    $AVIVA_UPDATE_1->execute()or die(print_r($AVIVA_UPDATE_1->errorInfo(), true));  

    $AVIVA_UPDATE_2 = $pdo->prepare("UPDATE aviva_comms SET
 aviva_comms_od1=:OD1,
 aviva_comms_od2=:OD2,
 aviva_comms_od3=:OD3,
 aviva_comms_od4=:OD4,
 aviva_comms_od5=:OD5,
 aviva_comms_ci1=:CI1,
 aviva_comms_ci2=:CI2,
 aviva_comms_ci3=:CI3,
 aviva_comms_ci4=:CI4,
 aviva_comms_ci5=:CI5,
 aviva_comms_ci6=:CI6,
 aviva_comms_icn1=:ICN1,
 aviva_comms_icn2=:ICN2,
 aviva_comms_icn3=:ICN3,
 aviva_comms_icn4=:ICN4,
 aviva_comms_icn5=:ICN5,
 aviva_comms_icn6=:ICN6
 WHERE 
    aviva_comms_id_fk=:FK");
    $AVIVA_UPDATE_2->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_2->bindParam(':OD1', $T_OD1, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':OD2', $T_OD2, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':OD3', $T_OD3, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':OD4', $T_OD4, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':OD5', $T_OD5, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI1', $T_CI1, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI2', $T_CI2, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI3', $T_CI3, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI4', $T_CI4, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI5', $T_CI5, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':CI6', $T_CI6, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN1', $T_ICN1, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN2', $T_ICN2, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN3', $T_ICN3, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN4', $T_ICN4, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN5', $T_ICN5, PDO::PARAM_STR);
    $AVIVA_UPDATE_2->bindParam(':ICN6', $T_ICN6, PDO::PARAM_STR);    
    $AVIVA_UPDATE_2->execute()or die(print_r($AVIVA_UPDATE_2->errorInfo(), true));  
    
    $AVIVA_UPDATE_3 = $pdo->prepare("UPDATE aviva_ques_2 SET
 aviva_ques_2_e1=:E1,
 aviva_ques_2_e2=:E2,
 aviva_ques_2_e3=:E3,
 aviva_ques_2_e4=:E4,
 aviva_ques_2_e5=:E5,
 aviva_ques_2_e6=:E6,
 aviva_ques_2_e7=:E7,
 aviva_ques_2_e8=:E8,
 aviva_ques_2_e9=:E9,
 aviva_ques_2_e10=:E10,
 aviva_ques_2_e11=:E11,
 aviva_ques_2_e12=:E12,
 aviva_ques_2_e13=:E13,
 aviva_ques_2_e14=:E14
 WHERE
    aviva_ques_2_id_fk=:FK");
    $AVIVA_UPDATE_3->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E1', $Q_E1, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E2', $Q_E2, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E3', $Q_E3, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E4', $Q_E4, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E5', $Q_E5, PDO::PARAM_INT);
    $AVIVA_UPDATE_3->bindParam(':E6', $Q_E6, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E7', $Q_E7, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E8', $Q_E8, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E9', $Q_E9, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E10', $Q_E10, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E11', $Q_E11, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E12', $Q_E12, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E13', $Q_E13, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->bindParam(':E14', $Q_E14, PDO::PARAM_INT); 
    $AVIVA_UPDATE_3->execute()or die(print_r($AVIVA_UPDATE_3->errorInfo(), true)); 
    
    $AVIVA_UPDATE_4 = $pdo->prepare("UPDATE aviva_comms_2 SET
 aviva_comms_2_e1=:E1,
 aviva_comms_2_e2=:E2,
 aviva_comms_2_e3=:E3,
 aviva_comms_2_e4=:E4,
 aviva_comms_2_e5=:E5,
 aviva_comms_2_e6=:E6,
 aviva_comms_2_e7=:E7,
 aviva_comms_2_e8=:E8,
 aviva_comms_2_e9=:E9,
 aviva_comms_2_e10=:E10,
 aviva_comms_2_e11=:E11,
 aviva_comms_2_e12=:E12,
 aviva_comms_2_e13=:E13,
 aviva_comms_2_e14=:E14
 WHERE
    aviva_comms_2_id_fk=:FK");
    $AVIVA_UPDATE_4->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_4->bindParam(':E1', $T_E1, PDO::PARAM_STR);
    $AVIVA_UPDATE_4->bindParam(':E2', $T_E2, PDO::PARAM_STR);
    $AVIVA_UPDATE_4->bindParam(':E3', $T_E3, PDO::PARAM_STR);
    $AVIVA_UPDATE_4->bindParam(':E4', $T_E4, PDO::PARAM_STR);
    $AVIVA_UPDATE_4->bindParam(':E5', $T_E5, PDO::PARAM_STR);
    $AVIVA_UPDATE_4->bindParam(':E6', $T_E6, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E7', $T_E7, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E8', $T_E8, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E9', $T_E9, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E10', $T_E10, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E11', $T_E11, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E12', $T_E12, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E13', $T_E13, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->bindParam(':E14', $T_E14, PDO::PARAM_STR); 
    $AVIVA_UPDATE_4->execute()or die(print_r($AVIVA_UPDATE_4->errorInfo(), true));            

    $AVIVA_UPDATE_5 = $pdo->prepare("UPDATE aviva_ques_3 SET
 aviva_ques_3_di1=:DI1,
 aviva_ques_3_di2=:DI2,
 aviva_ques_3_pi1=:PI1,
 aviva_ques_3_pi2=:PI2,
 aviva_ques_3_pi3=:PI3,
 aviva_ques_3_pi4=:PI4,
 aviva_ques_3_pi5=:PI5,
 aviva_ques_3_cd1=:CD1,
 aviva_ques_3_cd2=:CD2,
 aviva_ques_3_cd3=:CD3,
 aviva_ques_3_cd4=:CD4,
 aviva_ques_3_cd5=:CD5,
 aviva_ques_3_cd6=:CD6,
 aviva_ques_3_cd7=:CD7,
 aviva_ques_3_cd8=:CD8,
 aviva_ques_3_qc1=:QC1,
 aviva_ques_3_qc2=:QC2,
 aviva_ques_3_qc3=:QC3,
 aviva_ques_3_qc4=:QC4,
 aviva_ques_3_qc5=:QC5,
 aviva_ques_3_qc6=:QC6,
 aviva_ques_3_qc7=:QC7
 WHERE
    aviva_ques_3_id_fk=:FK");
    $AVIVA_UPDATE_5->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':DI1', $Q_DI1, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':DI2', $Q_DI2, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':PI1', $Q_PI1, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':PI2', $Q_PI2, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':PI3', $Q_PI3, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':PI4', $Q_PI4, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':PI5', $Q_PI5, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD1', $Q_CD1, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD2', $Q_CD2, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD3', $Q_CD3, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD4', $Q_CD4, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD5', $Q_CD5, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':CD6', $Q_CD6, PDO::PARAM_INT);  
    $AVIVA_UPDATE_5->bindParam(':CD7', $Q_CD7, PDO::PARAM_INT);  
    $AVIVA_UPDATE_5->bindParam(':CD8', $Q_CD8, PDO::PARAM_INT);  
    $AVIVA_UPDATE_5->bindParam(':QC1', $Q_QC1, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':QC2', $Q_QC2, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':QC3', $Q_QC3, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':QC4', $Q_QC4, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':QC5', $Q_QC5, PDO::PARAM_INT);
    $AVIVA_UPDATE_5->bindParam(':QC6', $Q_QC6, PDO::PARAM_INT);  
    $AVIVA_UPDATE_5->bindParam(':QC7', $Q_QC7, PDO::PARAM_INT);      
    $AVIVA_UPDATE_5->execute()or die(print_r($AVIVA_UPDATE_5->errorInfo(), true)); 
    
    $AVIVA_UPDATE_6 = $pdo->prepare("UPDATE aviva_comms_3 SET
 aviva_comms_3_di1=:DI1,
 aviva_comms_3_di2=:DI2,
 aviva_comms_3_pi1=:PI1,
 aviva_comms_3_pi2=:PI2,
 aviva_comms_3_pi3=:PI3,
 aviva_comms_3_pi4=:PI4,
 aviva_comms_3_pi5=:PI5,
 aviva_comms_3_cd1=:CD1,
 aviva_comms_3_cd2=:CD2,
 aviva_comms_3_cd3=:CD3,
 aviva_comms_3_cd4=:CD4,
 aviva_comms_3_cd5=:CD5,
 aviva_comms_3_cd6=:CD6,
 aviva_comms_3_cd7=:CD7,
 aviva_comms_3_cd8=:CD8,
 aviva_comms_3_qc1=:QC1,
 aviva_comms_3_qc2=:QC2,
 aviva_comms_3_qc3=:QC3,
 aviva_comms_3_qc4=:QC4,
 aviva_comms_3_qc5=:QC5,
 aviva_comms_3_qc6=:QC6,
 aviva_comms_3_qc7=:QC7
 WHERE
    aviva_comms_3_id_fk=:FK");
    $AVIVA_UPDATE_6->bindParam(':FK', $AID, PDO::PARAM_INT);
    $AVIVA_UPDATE_6->bindParam(':DI1', $T_DI1, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':DI2', $T_DI2, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':PI1', $T_PI1, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':PI2', $T_PI2, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':PI3', $T_PI3, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':PI4', $T_PI4, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':PI5', $T_PI5, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD1', $T_CD1, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD2', $T_CD2, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD3', $T_CD3, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD4', $T_CD4, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD5', $T_CD5, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':CD6', $T_CD6, PDO::PARAM_STR);  
    $AVIVA_UPDATE_6->bindParam(':CD7', $T_CD7, PDO::PARAM_STR);  
    $AVIVA_UPDATE_6->bindParam(':CD8', $T_CD8, PDO::PARAM_STR);  
    $AVIVA_UPDATE_6->bindParam(':QC1', $T_QC1, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':QC2', $T_QC2, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':QC3', $T_QC3, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':QC4', $T_QC4, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':QC5', $T_QC5, PDO::PARAM_STR);
    $AVIVA_UPDATE_6->bindParam(':QC6', $T_QC6, PDO::PARAM_STR);  
    $AVIVA_UPDATE_6->bindParam(':QC7', $T_QC7, PDO::PARAM_STR);      
    $AVIVA_UPDATE_6->execute()or die(print_r($AVIVA_UPDATE_6->errorInfo(), true));    

    
    header('Location: ../Menu.php?RETURN=UPDATED&GRADE='.$GRADE); die;
    

            
        } else {
            header('Location: ../Menu.php?RETURN=NOTFOUND'); die;
        }
    }    
    
    }
        header('Location: ../Menu.php?RETURN=ERROR'); die;
        
        ?>