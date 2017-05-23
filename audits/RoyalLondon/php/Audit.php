<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);   
     
    if(isset($EXECUTE)) { 
        include('../../../includes/ADL_PDO_CON.php');
        if($EXECUTE=='EDIT') {
            
$AUDITID= filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);

    $CLOSER= filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $CLOSER2= filter_input(INPUT_POST, 'CLOSER2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PLAN_NUMBER= filter_input(INPUT_POST, 'PLAN_NUMBER', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE= filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);

    $RL_AUDIT_QRY = $pdo->prepare("UPDATE RoyalLondon_Audit set updated_by=:hello, grade=:grade, closer=:closer, closer2=:closer2, plan_number=:plan_number WHERE audit_id=:AUDITID");
    $RL_AUDIT_QRY->bindParam(':AUDITID', $AUDITID, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':grade', $GRADE, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':closer', $CLOSER, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':closer2', $CLOSER2, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':plan_number', $PLAN_NUMBER, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->execute()or die(print_r($RL_AUDIT_QRY->errorInfo(), true));
    
    if(isset($AUDITID)) {

    $OD1= filter_input(INPUT_POST, 'OD1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD2= filter_input(INPUT_POST, 'OD2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD3= filter_input(INPUT_POST, 'OD3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD4= filter_input(INPUT_POST, 'OD4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD5= filter_input(INPUT_POST, 'OD5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI1= filter_input(INPUT_POST, 'CI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI2= filter_input(INPUT_POST, 'CI2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI3= filter_input(INPUT_POST, 'CI3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI4= filter_input(INPUT_POST, 'CI4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI5= filter_input(INPUT_POST, 'CI5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI6= filter_input(INPUT_POST, 'CI6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI7= filter_input(INPUT_POST, 'CI7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI8= filter_input(INPUT_POST, 'CI8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $IC1= filter_input(INPUT_POST, 'IC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC2= filter_input(INPUT_POST, 'IC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC3= filter_input(INPUT_POST, 'IC3', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC4= filter_input(INPUT_POST, 'IC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC5= filter_input(INPUT_POST, 'IC5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD1= filter_input(INPUT_POST, 'CD1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD2= filter_input(INPUT_POST, 'CD2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD3= filter_input(INPUT_POST, 'CD3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD4= filter_input(INPUT_POST, 'CD4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD5= filter_input(INPUT_POST, 'CD5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DO1= filter_input(INPUT_POST, 'DO1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO2= filter_input(INPUT_POST, 'DO2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO3= filter_input(INPUT_POST, 'DO3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO4= filter_input(INPUT_POST, 'DO4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO5= filter_input(INPUT_POST, 'DO5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO6= filter_input(INPUT_POST, 'DO6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO7= filter_input(INPUT_POST, 'DO7', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO8= filter_input(INPUT_POST, 'DO8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $LS1= filter_input(INPUT_POST, 'LS1', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS2= filter_input(INPUT_POST, 'LS2', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS3= filter_input(INPUT_POST, 'LS3', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS4= filter_input(INPUT_POST, 'LS4', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS5= filter_input(INPUT_POST, 'LS5', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS6= filter_input(INPUT_POST, 'LS6', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS7= filter_input(INPUT_POST, 'LS7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OT1= filter_input(INPUT_POST, 'OT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OT2= filter_input(INPUT_POST, 'OT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OT3= filter_input(INPUT_POST, 'OT3', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ODT1= filter_input(INPUT_POST, 'ODT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT2= filter_input(INPUT_POST, 'ODT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT3= filter_input(INPUT_POST, 'ODT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT4= filter_input(INPUT_POST, 'ODT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT5= filter_input(INPUT_POST, 'ODT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CIT1= filter_input(INPUT_POST, 'CIT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT2= filter_input(INPUT_POST, 'CIT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT3= filter_input(INPUT_POST, 'CIT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT4= filter_input(INPUT_POST, 'CIT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT5= filter_input(INPUT_POST, 'CIT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT6= filter_input(INPUT_POST, 'CIT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT7= filter_input(INPUT_POST, 'CIT7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT8= filter_input(INPUT_POST, 'CIT8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICT1= filter_input(INPUT_POST, 'ICT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT2= filter_input(INPUT_POST, 'ICT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT3= filter_input(INPUT_POST, 'ICT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT4= filter_input(INPUT_POST, 'ICT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT5= filter_input(INPUT_POST, 'ICT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDT1= filter_input(INPUT_POST, 'CDT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT2= filter_input(INPUT_POST, 'CDT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT3= filter_input(INPUT_POST, 'CDT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT4= filter_input(INPUT_POST, 'CDT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT5= filter_input(INPUT_POST, 'CDT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DOT1= filter_input(INPUT_POST, 'DOT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT2= filter_input(INPUT_POST, 'DOT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT3= filter_input(INPUT_POST, 'DOT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT4= filter_input(INPUT_POST, 'DOT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT5= filter_input(INPUT_POST, 'DOT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT6= filter_input(INPUT_POST, 'DOT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT7= filter_input(INPUT_POST, 'DOT7', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT8= filter_input(INPUT_POST, 'DOT8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $LST1= filter_input(INPUT_POST, 'LST1', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST2= filter_input(INPUT_POST, 'LST2', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST3= filter_input(INPUT_POST, 'LST3', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST4= filter_input(INPUT_POST, 'LST4', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST5= filter_input(INPUT_POST, 'LST5', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST6= filter_input(INPUT_POST, 'LST6', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST7= filter_input(INPUT_POST, 'LST7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OTT1= filter_input(INPUT_POST, 'OTT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTT2= filter_input(INPUT_POST, 'OTT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTT3= filter_input(INPUT_POST, 'OTT3', FILTER_SANITIZE_SPECIAL_CHARS);    

    $RL_QS = $pdo->prepare("UPDATE RoyalLondon_Questions set OD1=:OD1, OD2=:OD2, OD3=:OD3, OD4=:OD4, OD5=:OD5, CI1=:CI1, CI2=:CI2, CI3=:CI3, CI4=:CI4, CI5=:CI5, CI6=:CI6, CI7=:CI7, CI8=:CI8, IC1=:IC1, IC2=:IC2, IC3=:IC3, IC4=:IC4, IC5=:IC5, CD1=:CD1, CD2=:CD2, CD3=:CD3, CD4=:CD4, CD5=:CD5, DO1=:DO1, DO2=:DO2, DO3=:DO3, DO4=:DO4, DO5=:DO5, DO6=:DO6, DO7=:DO7, DO8=:DO8, LS1=:LS1, LS2=:LS2, LS3=:LS3, LS4=:LS4, LS5=:LS5, LS6=:LS6, LS7=:LS7, OT1=:OT1, OT2=:OT2, OT3=:OT3 WHERE fk_audit_id=:fk_audit_id");
    $RL_QS->bindParam(':fk_audit_id', $AUDITID, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD1', $OD1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD2', $OD2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD3', $OD3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD4', $OD4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD5', $OD5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI1', $CI1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI2', $CI2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI3', $CI3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI4', $CI4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI5', $CI5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI6', $CI6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI7', $CI7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI8', $CI8, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC1', $IC1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC2', $IC2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC3', $IC3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC4', $IC4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC5', $IC5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD1', $CD1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD2', $CD2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD3', $CD3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD4', $CD4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD5', $CD5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO1', $DO1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO2', $DO2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO3', $DO3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO4', $DO4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO5', $DO5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO6', $DO6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO7', $DO7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO8', $DO8, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS1', $LS1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS2', $LS2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS3', $LS3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS4', $LS4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS5', $LS5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS6', $LS6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS7', $LS7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT1', $OT1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT2', $OT2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT3', $OT3, PDO::PARAM_STR, 100);
    $RL_QS->execute()or die(print_r($RL_QS->errorInfo(), true));

    $RL_COM = $pdo->prepare("UPDATE RoyalLondon_Comments set ODT1=:ODT1, ODT2=:ODT2, ODT3=:ODT3, ODT4=:ODT4, ODT5=:ODT5, CIT1=:CIT1, CIT2=:CIT2, CIT3=:CIT3, CIT4=:CIT4, CIT5=:CIT5, CIT6=:CIT6, CIT7=:CIT7, CIT8=:CIT8, ICT1=:ICT1, ICT2=:ICT2, ICT3=:ICT3, ICT4=:ICT4, ICT5=:ICT5, CDT1=:CDT1, CDT2=:CDT2, CDT3=:CDT3, CDT4=:CDT4, CDT5=:CDT5, DOT1=:DOT1, DOT2=:DOT2, DOT3=:DOT3, DOT4=:DOT4, DOT5=:DOT5, DOT6=:DOT6, DOT7=:DOT7, DOT8=:DOT8, LST1=:LST1, LST2=:LST2, LST3=:LST3, LST4=:LST4, LST5=:LST5, LST6=:LST6, LST7=:LST7 WHERE fk_audit_id=:fk_audit_id");
    $RL_COM->bindParam(':fk_audit_id', $AUDITID, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT1', $ODT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT2', $ODT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT3', $ODT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT4', $ODT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT5', $ODT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT1', $CIT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT2', $CIT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT3', $CIT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT4', $CIT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT5', $CIT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT6', $CIT6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT7', $CIT7, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT8', $CIT8, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT1', $ICT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT2', $ICT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT3', $ICT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT4', $ICT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT5', $ICT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT1', $CDT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT2', $CDT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT3', $CDT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT4', $CDT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT5', $CDT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT1', $DOT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT2', $DOT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT3', $DOT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT4', $DOT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT5', $DOT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT6', $DOT6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT7', $DOT7, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT8', $DOT8, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST1', $LST1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST2', $LST2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST3', $LST3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST4', $LST4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST5', $LST5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST6', $LST6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST7', $LST7, PDO::PARAM_STR, 100);
    $RL_COM->execute()or die(print_r($RL_COM->errorInfo(), true));
    
    $HQ1= filter_input(INPUT_POST, 'HQ1', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ2= filter_input(INPUT_POST, 'HQ2', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ3= filter_input(INPUT_POST, 'HQ3', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ4= filter_input(INPUT_POST, 'HQ4', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ5= filter_input(INPUT_POST, 'HQ5', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ6= filter_input(INPUT_POST, 'HQ6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $HQT1= filter_input(INPUT_POST, 'HQT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT2= filter_input(INPUT_POST, 'HQT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT3= filter_input(INPUT_POST, 'HQT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT4= filter_input(INPUT_POST, 'HQT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT5= filter_input(INPUT_POST, 'HQT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT6= filter_input(INPUT_POST, 'HQT6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $E1= filter_input(INPUT_POST, 'E1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E2= filter_input(INPUT_POST, 'E2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E3= filter_input(INPUT_POST, 'E3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E4= filter_input(INPUT_POST, 'E4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E5= filter_input(INPUT_POST, 'E5', FILTER_SANITIZE_SPECIAL_CHARS);
    $E6= filter_input(INPUT_POST, 'E6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ET1= filter_input(INPUT_POST, 'ET1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET2= filter_input(INPUT_POST, 'ET2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET3= filter_input(INPUT_POST, 'ET3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET4= filter_input(INPUT_POST, 'ET4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET5= filter_input(INPUT_POST, 'ET5', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET6= filter_input(INPUT_POST, 'ET6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI1= filter_input(INPUT_POST, 'PI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI2= filter_input(INPUT_POST, 'PI2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI3= filter_input(INPUT_POST, 'PI3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI4= filter_input(INPUT_POST, 'PI4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI5= filter_input(INPUT_POST, 'PI5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PIT1= filter_input(INPUT_POST, 'PIT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT2= filter_input(INPUT_POST, 'PIT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT3= filter_input(INPUT_POST, 'PIT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT4= filter_input(INPUT_POST, 'PIT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT5= filter_input(INPUT_POST, 'PIT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDE1= filter_input(INPUT_POST, 'CDE1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE2= filter_input(INPUT_POST, 'CDE2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE3= filter_input(INPUT_POST, 'CDE3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE4= filter_input(INPUT_POST, 'CDE4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE5= filter_input(INPUT_POST, 'CDE5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE6= filter_input(INPUT_POST, 'CDE6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE7= filter_input(INPUT_POST, 'CDE7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE8= filter_input(INPUT_POST, 'CDE8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDET1= filter_input(INPUT_POST, 'CDET1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET2= filter_input(INPUT_POST, 'CDET2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET3= filter_input(INPUT_POST, 'CDET3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET4= filter_input(INPUT_POST, 'CDET4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET5= filter_input(INPUT_POST, 'CDET5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET6= filter_input(INPUT_POST, 'CDET6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET7= filter_input(INPUT_POST, 'CDET7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET8= filter_input(INPUT_POST, 'CDET8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC1= filter_input(INPUT_POST, 'QC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC2= filter_input(INPUT_POST, 'QC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC3= filter_input(INPUT_POST, 'QC3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC4= filter_input(INPUT_POST, 'QC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC5= filter_input(INPUT_POST, 'QC5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC6= filter_input(INPUT_POST, 'QC6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC7= filter_input(INPUT_POST, 'QC7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QCT1= filter_input(INPUT_POST, 'QCT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT2= filter_input(INPUT_POST, 'QCT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT3= filter_input(INPUT_POST, 'QCT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT4= filter_input(INPUT_POST, 'QCT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT5= filter_input(INPUT_POST, 'QCT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT6= filter_input(INPUT_POST, 'QCT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT7= filter_input(INPUT_POST, 'QCT7', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $RL_QS_EX = $pdo->prepare("UPDATE RoyalLondon_Questions_Extra set HQ1=:HQ1, HQ2=:HQ2, HQ3=:HQ3, HQ4=:HQ4, HQ5=:HQ5, HQ6=:HQ6, E1=:E1, E2=:E2, E3=:E3, E4=:E4, E5=:E5, E6=:E6, PI1=:PI1, PI2=:PI2, PI3=:PI3, PI4=:PI4, PI5=:PI5, CDE1=:CDE1, CDE2=:CDE2, CDE3=:CDE3, CDE4=:CDE4, CDE5=:CDE5, CDE6=:CDE6, CDE7=:CDE7, CDE8=:CDE8, QC1=:QC1, QC2=:QC2, QC3=:QC3, QC4=:QC4, QC5=:QC5, QC6=:QC6, QC7=:QC7 WHERE fk_audit_id=:fk_audit_id");
    $RL_QS_EX->bindParam(':fk_audit_id',$AUDITID,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ1',$HQ1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ2',$HQ2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ3',$HQ3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ4',$HQ4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ5',$HQ5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ6',$HQ6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E1',$E1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E2',$E2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E3',$E3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E4',$E4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E5',$E5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E6',$E6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI1',$PI1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI2',$PI2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI3',$PI3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI4',$PI4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI5',$PI5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE1',$CDE1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE2',$CDE2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE3',$CDE3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE4',$CDE4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE5',$CDE5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE6',$CDE6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE7',$CDE7,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE8',$CDE8,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC1',$QC1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC2',$QC2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC3',$QC3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC4',$QC4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC5',$QC5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC6',$QC6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC7',$QC7,PDO::PARAM_STR,100);
    $RL_QS_EX->execute()or die(print_r($RL_QS_EX->errorInfo(), true)); 
    
    $RL_COM_ETX = $pdo->prepare("UPDATE RoyalLondon_Comments_Extra set OTT1=:OTT1, OTT2=:OTT2, OTT3=:OTT3, HQT1=:HQT1, HQT2=:HQT2, HQT3=:HQT3, HQT4=:HQT4, HQT5=:HQT5, HQT6=:HQT6, ET1=:ET1, ET2=:ET2, ET3=:ET3, ET4=:ET4, ET5=:ET5, ET6=:ET6, PIT1=:PIT1, PIT2=:PIT2, PIT3=:PIT3, PIT4=:PIT4, PIT5=:PIT5, CDET1=:CDET1, CDET2=:CDET2, CDET3=:CDET3, CDET4=:CDET4, CDET5=:CDET5, CDET6=:CDET6, CDET7=:CDET7, CDET8=:CDET8, QCT1=:QCT1, QCT2=:QCT2, QCT3=:QCT3, QCT4=:QCT4, QCT5=:QCT5, QCT6=:QCT6, QCT7=:QCT7 WHERE fk_audit_id=:fk_audit_id");
    $RL_COM_ETX->bindParam(':fk_audit_id',$AUDITID,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':OTT1', $OTT1, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':OTT2', $OTT2, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':OTT3', $OTT3, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':HQT1',$HQT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT2',$HQT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT3',$HQT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT4',$HQT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT5',$HQT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT6',$HQT6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET1',$ET1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET2',$ET2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET3',$ET3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET4',$ET4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET5',$ET5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET6',$ET6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT1',$PIT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT2',$PIT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT3',$PIT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT4',$PIT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT5',$PIT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET1',$CDET1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET2',$CDET2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET3',$CDET3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET4',$CDET4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET5',$CDET5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET6',$CDET6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET7',$CDET7,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET8',$CDET8,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT1',$QCT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT2',$QCT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT3',$QCT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT4',$QCT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT5',$QCT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT6',$QCT6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT7',$QCT7,PDO::PARAM_STR,100);
    $RL_COM_ETX->execute()or die(print_r($RL_COM_ETX->errorInfo(), true)); 
    
    header('Location: ../Menu.php?RETURN=UPDATED'); die;
    
    }
            
        }
        if($EXECUTE=='NEW') {
 
    
    $CLOSER= filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $CLOSER2= filter_input(INPUT_POST, 'CLOSER2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PLAN_NUMBER= filter_input(INPUT_POST, 'PLAN_NUMBER', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE= filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);

    $RL_AUDIT_QRY = $pdo->prepare("INSERT INTO RoyalLondon_Audit set added_by=:hello, grade=:grade, closer=:closer, closer2=:closer2, plan_number=:plan_number");
    $RL_AUDIT_QRY->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':grade', $GRADE, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':closer', $CLOSER, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':closer2', $CLOSER2, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->bindParam(':plan_number', $PLAN_NUMBER, PDO::PARAM_STR, 100);
    $RL_AUDIT_QRY->execute()or die(print_r($RL_AUDIT_QRY->errorInfo(), true));
    $LAST_AUDITID = $pdo->lastInsertId();    
    
    if(isset($LAST_AUDITID)) {

    $OD1= filter_input(INPUT_POST, 'OD1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD2= filter_input(INPUT_POST, 'OD2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD3= filter_input(INPUT_POST, 'OD3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD4= filter_input(INPUT_POST, 'OD4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD5= filter_input(INPUT_POST, 'OD5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI1= filter_input(INPUT_POST, 'CI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI2= filter_input(INPUT_POST, 'CI2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI3= filter_input(INPUT_POST, 'CI3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI4= filter_input(INPUT_POST, 'CI4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI5= filter_input(INPUT_POST, 'CI5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI6= filter_input(INPUT_POST, 'CI6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI7= filter_input(INPUT_POST, 'CI7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI8= filter_input(INPUT_POST, 'CI8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $IC1= filter_input(INPUT_POST, 'IC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC2= filter_input(INPUT_POST, 'IC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC3= filter_input(INPUT_POST, 'IC3', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC4= filter_input(INPUT_POST, 'IC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $IC5= filter_input(INPUT_POST, 'IC5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD1= filter_input(INPUT_POST, 'CD1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD2= filter_input(INPUT_POST, 'CD2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD3= filter_input(INPUT_POST, 'CD3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD4= filter_input(INPUT_POST, 'CD4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD5= filter_input(INPUT_POST, 'CD5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DO1= filter_input(INPUT_POST, 'DO1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO2= filter_input(INPUT_POST, 'DO2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO3= filter_input(INPUT_POST, 'DO3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO4= filter_input(INPUT_POST, 'DO4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO5= filter_input(INPUT_POST, 'DO5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO6= filter_input(INPUT_POST, 'DO6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO7= filter_input(INPUT_POST, 'DO7', FILTER_SANITIZE_SPECIAL_CHARS);
    $DO8= filter_input(INPUT_POST, 'DO8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $LS1= filter_input(INPUT_POST, 'LS1', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS2= filter_input(INPUT_POST, 'LS2', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS3= filter_input(INPUT_POST, 'LS3', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS4= filter_input(INPUT_POST, 'LS4', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS5= filter_input(INPUT_POST, 'LS5', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS6= filter_input(INPUT_POST, 'LS6', FILTER_SANITIZE_SPECIAL_CHARS);
    $LS7= filter_input(INPUT_POST, 'LS7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OT1= filter_input(INPUT_POST, 'OT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OT2= filter_input(INPUT_POST, 'OT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OT3= filter_input(INPUT_POST, 'OT3', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ODT1= filter_input(INPUT_POST, 'ODT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT2= filter_input(INPUT_POST, 'ODT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT3= filter_input(INPUT_POST, 'ODT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT4= filter_input(INPUT_POST, 'ODT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ODT5= filter_input(INPUT_POST, 'ODT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CIT1= filter_input(INPUT_POST, 'CIT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT2= filter_input(INPUT_POST, 'CIT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT3= filter_input(INPUT_POST, 'CIT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT4= filter_input(INPUT_POST, 'CIT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT5= filter_input(INPUT_POST, 'CIT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT6= filter_input(INPUT_POST, 'CIT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT7= filter_input(INPUT_POST, 'CIT7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CIT8= filter_input(INPUT_POST, 'CIT8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICT1= filter_input(INPUT_POST, 'ICT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT2= filter_input(INPUT_POST, 'ICT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT3= filter_input(INPUT_POST, 'ICT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT4= filter_input(INPUT_POST, 'ICT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICT5= filter_input(INPUT_POST, 'ICT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDT1= filter_input(INPUT_POST, 'CDT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT2= filter_input(INPUT_POST, 'CDT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT3= filter_input(INPUT_POST, 'CDT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT4= filter_input(INPUT_POST, 'CDT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDT5= filter_input(INPUT_POST, 'CDT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DOT1= filter_input(INPUT_POST, 'DOT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT2= filter_input(INPUT_POST, 'DOT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT3= filter_input(INPUT_POST, 'DOT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT4= filter_input(INPUT_POST, 'DOT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT5= filter_input(INPUT_POST, 'DOT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT6= filter_input(INPUT_POST, 'DOT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT7= filter_input(INPUT_POST, 'DOT7', FILTER_SANITIZE_SPECIAL_CHARS);
    $DOT8= filter_input(INPUT_POST, 'DOT8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $LST1= filter_input(INPUT_POST, 'LST1', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST2= filter_input(INPUT_POST, 'LST2', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST3= filter_input(INPUT_POST, 'LST3', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST4= filter_input(INPUT_POST, 'LST4', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST5= filter_input(INPUT_POST, 'LST5', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST6= filter_input(INPUT_POST, 'LST6', FILTER_SANITIZE_SPECIAL_CHARS);
    $LST7= filter_input(INPUT_POST, 'LST7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OTT1= filter_input(INPUT_POST, 'OTT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTT2= filter_input(INPUT_POST, 'OTT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTT3= filter_input(INPUT_POST, 'OTT3', FILTER_SANITIZE_SPECIAL_CHARS);    

    $RL_QS = $pdo->prepare("INSERT INTO RoyalLondon_Questions set fk_audit_id=:fk_audit_id, OD1=:OD1, OD2=:OD2, OD3=:OD3, OD4=:OD4, OD5=:OD5, CI1=:CI1, CI2=:CI2, CI3=:CI3, CI4=:CI4, CI5=:CI5, CI6=:CI6, CI7=:CI7, CI8=:CI8, IC1=:IC1, IC2=:IC2, IC3=:IC3, IC4=:IC4, IC5=:IC5, CD1=:CD1, CD2=:CD2, CD3=:CD3, CD4=:CD4, CD5=:CD5, DO1=:DO1, DO2=:DO2, DO3=:DO3, DO4=:DO4, DO5=:DO5, DO6=:DO6, DO7=:DO7, DO8=:DO8, LS1=:LS1, LS2=:LS2, LS3=:LS3, LS4=:LS4, LS5=:LS5, LS6=:LS6, LS7=:LS7, OT1=:OT1, OT2=:OT2, OT3=:OT3");
    $RL_QS->bindParam(':fk_audit_id', $LAST_AUDITID, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD1', $OD1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD2', $OD2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD3', $OD3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD4', $OD4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OD5', $OD5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI1', $CI1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI2', $CI2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI3', $CI3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI4', $CI4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI5', $CI5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI6', $CI6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI7', $CI7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CI8', $CI8, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC1', $IC1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC2', $IC2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC3', $IC3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC4', $IC4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':IC5', $IC5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD1', $CD1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD2', $CD2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD3', $CD3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD4', $CD4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':CD5', $CD5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO1', $DO1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO2', $DO2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO3', $DO3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO4', $DO4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO5', $DO5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO6', $DO6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO7', $DO7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':DO8', $DO8, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS1', $LS1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS2', $LS2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS3', $LS3, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS4', $LS4, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS5', $LS5, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS6', $LS6, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':LS7', $LS7, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT1', $OT1, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT2', $OT2, PDO::PARAM_STR, 100);
    $RL_QS->bindParam(':OT3', $OT3, PDO::PARAM_STR, 100);
    $RL_QS->execute()or die(print_r($RL_QS->errorInfo(), true));

    $RL_COM = $pdo->prepare("INSERT INTO RoyalLondon_Comments set fk_audit_id=:fk_audit_id, ODT1=:ODT1, ODT2=:ODT2, ODT3=:ODT3, ODT4=:ODT4, ODT5=:ODT5, CIT1=:CIT1, CIT2=:CIT2, CIT3=:CIT3, CIT4=:CIT4, CIT5=:CIT5, CIT6=:CIT6, CIT7=:CIT7, CIT8=:CIT8, ICT1=:ICT1, ICT2=:ICT2, ICT3=:ICT3, ICT4=:ICT4, ICT5=:ICT5, CDT1=:CDT1, CDT2=:CDT2, CDT3=:CDT3, CDT4=:CDT4, CDT5=:CDT5, DOT1=:DOT1, DOT2=:DOT2, DOT3=:DOT3, DOT4=:DOT4, DOT5=:DOT5, DOT6=:DOT6, DOT7=:DOT7, DOT8=:DOT8, LST1=:LST1, LST2=:LST2, LST3=:LST3, LST4=:LST4, LST5=:LST5, LST6=:LST6, LST7=:LST7");
    $RL_COM->bindParam(':fk_audit_id', $LAST_AUDITID, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT1', $ODT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT2', $ODT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT3', $ODT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT4', $ODT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ODT5', $ODT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT1', $CIT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT2', $CIT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT3', $CIT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT4', $CIT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT5', $CIT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT6', $CIT6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT7', $CIT7, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CIT8', $CIT8, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT1', $ICT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT2', $ICT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT3', $ICT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT4', $ICT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':ICT5', $ICT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT1', $CDT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT2', $CDT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT3', $CDT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT4', $CDT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':CDT5', $CDT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT1', $DOT1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT2', $DOT2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT3', $DOT3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT4', $DOT4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT5', $DOT5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT6', $DOT6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT7', $DOT7, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':DOT8', $DOT8, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST1', $LST1, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST2', $LST2, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST3', $LST3, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST4', $LST4, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST5', $LST5, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST6', $LST6, PDO::PARAM_STR, 100);
    $RL_COM->bindParam(':LST7', $LST7, PDO::PARAM_STR, 100);
    $RL_COM->execute()or die(print_r($RL_COM->errorInfo(), true));
    
    $HQ1= filter_input(INPUT_POST, 'HQ1', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ2= filter_input(INPUT_POST, 'HQ2', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ3= filter_input(INPUT_POST, 'HQ3', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ4= filter_input(INPUT_POST, 'HQ4', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ5= filter_input(INPUT_POST, 'HQ5', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQ6= filter_input(INPUT_POST, 'HQ6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $HQT1= filter_input(INPUT_POST, 'HQT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT2= filter_input(INPUT_POST, 'HQT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT3= filter_input(INPUT_POST, 'HQT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT4= filter_input(INPUT_POST, 'HQT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT5= filter_input(INPUT_POST, 'HQT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $HQT6= filter_input(INPUT_POST, 'HQT6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $E1= filter_input(INPUT_POST, 'E1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E2= filter_input(INPUT_POST, 'E2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E3= filter_input(INPUT_POST, 'E3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E4= filter_input(INPUT_POST, 'E4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E5= filter_input(INPUT_POST, 'E5', FILTER_SANITIZE_SPECIAL_CHARS);
    $E6= filter_input(INPUT_POST, 'E6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ET1= filter_input(INPUT_POST, 'ET1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET2= filter_input(INPUT_POST, 'ET2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET3= filter_input(INPUT_POST, 'ET3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET4= filter_input(INPUT_POST, 'ET4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET5= filter_input(INPUT_POST, 'ET5', FILTER_SANITIZE_SPECIAL_CHARS);
    $ET6= filter_input(INPUT_POST, 'ET6', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI1= filter_input(INPUT_POST, 'PI1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI2= filter_input(INPUT_POST, 'PI2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI3= filter_input(INPUT_POST, 'PI3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI4= filter_input(INPUT_POST, 'PI4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI5= filter_input(INPUT_POST, 'PI5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PIT1= filter_input(INPUT_POST, 'PIT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT2= filter_input(INPUT_POST, 'PIT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT3= filter_input(INPUT_POST, 'PIT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT4= filter_input(INPUT_POST, 'PIT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PIT5= filter_input(INPUT_POST, 'PIT5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDE1= filter_input(INPUT_POST, 'CDE1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE2= filter_input(INPUT_POST, 'CDE2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE3= filter_input(INPUT_POST, 'CDE3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE4= filter_input(INPUT_POST, 'CDE4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE5= filter_input(INPUT_POST, 'CDE5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE6= filter_input(INPUT_POST, 'CDE6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE7= filter_input(INPUT_POST, 'CDE7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDE8= filter_input(INPUT_POST, 'CDE8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CDET1= filter_input(INPUT_POST, 'CDET1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET2= filter_input(INPUT_POST, 'CDET2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET3= filter_input(INPUT_POST, 'CDET3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET4= filter_input(INPUT_POST, 'CDET4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET5= filter_input(INPUT_POST, 'CDET5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET6= filter_input(INPUT_POST, 'CDET6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET7= filter_input(INPUT_POST, 'CDET7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CDET8= filter_input(INPUT_POST, 'CDET8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC1= filter_input(INPUT_POST, 'QC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC2= filter_input(INPUT_POST, 'QC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC3= filter_input(INPUT_POST, 'QC3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC4= filter_input(INPUT_POST, 'QC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC5= filter_input(INPUT_POST, 'QC5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC6= filter_input(INPUT_POST, 'QC6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC7= filter_input(INPUT_POST, 'QC7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QCT1= filter_input(INPUT_POST, 'QCT1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT2= filter_input(INPUT_POST, 'QCT2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT3= filter_input(INPUT_POST, 'QCT3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT4= filter_input(INPUT_POST, 'QCT4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT5= filter_input(INPUT_POST, 'QCT5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT6= filter_input(INPUT_POST, 'QCT6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QCT7= filter_input(INPUT_POST, 'QCT7', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $RL_QS_EX = $pdo->prepare("INSERT INTO RoyalLondon_Questions_Extra set fk_audit_id=:fk_audit_id, HQ1=:HQ1, HQ2=:HQ2, HQ3=:HQ3, HQ4=:HQ4, HQ5=:HQ5, HQ6=:HQ6, E1=:E1, E2=:E2, E3=:E3, E4=:E4, E5=:E5, E6=:E6, PI1=:PI1, PI2=:PI2, PI3=:PI3, PI4=:PI4, PI5=:PI5, CDE1=:CDE1, CDE2=:CDE2, CDE3=:CDE3, CDE4=:CDE4, CDE5=:CDE5, CDE6=:CDE6, CDE7=:CDE7, CDE8=:CDE8, QC1=:QC1, QC2=:QC2, QC3=:QC3, QC4=:QC4, QC5=:QC5, QC6=:QC6, QC7=:QC7");
    $RL_QS_EX->bindParam(':fk_audit_id',$LAST_AUDITID,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ1',$HQ1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ2',$HQ2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ3',$HQ3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ4',$HQ4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ5',$HQ5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':HQ6',$HQ6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E1',$E1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E2',$E2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E3',$E3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E4',$E4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E5',$E5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':E6',$E6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI1',$PI1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI2',$PI2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI3',$PI3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI4',$PI4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':PI5',$PI5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE1',$CDE1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE2',$CDE2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE3',$CDE3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE4',$CDE4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE5',$CDE5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE6',$CDE6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE7',$CDE7,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':CDE8',$CDE8,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC1',$QC1,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC2',$QC2,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC3',$QC3,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC4',$QC4,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC5',$QC5,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC6',$QC6,PDO::PARAM_STR,100);
    $RL_QS_EX->bindParam(':QC7',$QC7,PDO::PARAM_STR,100);
    $RL_QS_EX->execute()or die(print_r($RL_QS_EX->errorInfo(), true)); 
    
    $RL_COM_ETX = $pdo->prepare("INSERT INTO RoyalLondon_Comments_Extra set fk_audit_id=:fk_audit_id, OTT1=:OTT1, OTT2=:OTT2, OTT3=:OTT3, HQT1=:HQT1, HQT2=:HQT2, HQT3=:HQT3, HQT4=:HQT4, HQT5=:HQT5, HQT6=:HQT6, ET1=:ET1, ET2=:ET2, ET3=:ET3, ET4=:ET4, ET5=:ET5, ET6=:ET6, PIT1=:PIT1, PIT2=:PIT2, PIT3=:PIT3, PIT4=:PIT4, PIT5=:PIT5, CDET1=:CDET1, CDET2=:CDET2, CDET3=:CDET3, CDET4=:CDET4, CDET5=:CDET5, CDET6=:CDET6, CDET7=:CDET7, CDET8=:CDET8, QCT1=:QCT1, QCT2=:QCT2, QCT3=:QCT3, QCT4=:QCT4, QCT5=:QCT5, QCT6=:QCT6, QCT7=:QCT7");
    $RL_COM_ETX->bindParam(':fk_audit_id',$LAST_AUDITID,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':OTT1', $OTT1, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':OTT2', $OTT2, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':OTT3', $OTT3, PDO::PARAM_STR, 100);
    $RL_COM_ETX->bindParam(':HQT1',$HQT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT2',$HQT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT3',$HQT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT4',$HQT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT5',$HQT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':HQT6',$HQT6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET1',$ET1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET2',$ET2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET3',$ET3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET4',$ET4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET5',$ET5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':ET6',$ET6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT1',$PIT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT2',$PIT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT3',$PIT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT4',$PIT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':PIT5',$PIT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET1',$CDET1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET2',$CDET2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET3',$CDET3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET4',$CDET4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET5',$CDET5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET6',$CDET6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET7',$CDET7,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':CDET8',$CDET8,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT1',$QCT1,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT2',$QCT2,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT3',$QCT3,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT4',$QCT4,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT5',$QCT5,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT6',$QCT6,PDO::PARAM_STR,100);
    $RL_COM_ETX->bindParam(':QCT7',$QCT7,PDO::PARAM_STR,100);
    $RL_COM_ETX->execute()or die(print_r($RL_COM_ETX->errorInfo(), true)); 
    
    header('Location: ../Menu.php?RETURN=ADDED'); die;
    
    }
    
        }
        
    }
        
        header('Location: ../Menu.php?RETURN=ERROR'); die;