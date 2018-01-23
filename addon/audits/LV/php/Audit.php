<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

require_once(__DIR__ . '/../../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../../includes/adlfunctions.php');

require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if (isset($EXECUTE)) {
    if($EXECUTE=="1") {
        
    $CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $PLAN_NUMBER = filter_input(INPUT_POST, 'PLAN_NUMBER', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE = filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $GRADE_ARRAY=array("Red","Amber","Green","Saved");
    
    if(isset($GRADE) && !in_array($GRADE,$GRADE_ARRAY)) {
        $GRADE="Saved";
    } 
    
    $VITALITY_AUDIT_QRY = $pdo->prepare("INSERT INTO 
                                            lv_audit
                                        SET 
                                            lv_audit_auditor=:HELLO,
                                            lv_audit_grade=:GRADE, 
                                            lv_audit_closer=:CLOSER, 
                                            lv_audit_ref=:PLAN");
    $VITALITY_AUDIT_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':GRADE', $GRADE, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':PLAN', $PLAN_NUMBER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->execute()or die(print_r($VITALITY_AUDIT_QRY->errorInfo(), true));
    $LAST_AUDITID = $pdo->lastInsertId();  
    
    if(isset($LAST_AUDITID)) {
        
    $OD_Q1 = filter_input(INPUT_POST, 'OD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q2 = filter_input(INPUT_POST, 'OD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q3 = filter_input(INPUT_POST, 'OD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q4 = filter_input(INPUT_POST, 'OD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q5 = filter_input(INPUT_POST, 'OD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI_Q1 = filter_input(INPUT_POST, 'CI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q2 = filter_input(INPUT_POST, 'CI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q3 = filter_input(INPUT_POST, 'CI_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q4 = filter_input(INPUT_POST, 'CI_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q5 = filter_input(INPUT_POST, 'CI_Q5', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q6 = filter_input(INPUT_POST, 'CI_Q6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q7 = filter_input(INPUT_POST, 'CI_Q7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q8 = filter_input(INPUT_POST, 'CI_Q8', FILTER_SANITIZE_SPECIAL_CHARS); 
   
    $H_Q1 = filter_input(INPUT_POST, 'H_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q2 = filter_input(INPUT_POST, 'H_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q3 = filter_input(INPUT_POST, 'H_Q3', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $L_Q1 = filter_input(INPUT_POST, 'L_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q2 = filter_input(INPUT_POST, 'L_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q3 = filter_input(INPUT_POST, 'L_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q4 = filter_input(INPUT_POST, 'L_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q5 = filter_input(INPUT_POST, 'L_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q6 = filter_input(INPUT_POST, 'L_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q7 = filter_input(INPUT_POST, 'L_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q8 = filter_input(INPUT_POST, 'L_Q8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_Q1 = filter_input(INPUT_POST, 'ICN_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q2 = filter_input(INPUT_POST, 'ICN_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q3 = filter_input(INPUT_POST, 'ICN_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q4 = filter_input(INPUT_POST, 'ICN_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q5 = filter_input(INPUT_POST, 'ICN_Q5', FILTER_SANITIZE_SPECIAL_CHARS);      
   
    
     $VITALITY_QUES_QRY = $pdo->prepare("INSERT INTO 
                                            lv_questions
                                        SET 
                                            lv_questions_id_fk=:FK,
                                            lv_questions_od1=:OD1, 
                                            lv_questions_od2=:OD2, 
                                            lv_questions_od3=:OD3,
                                            lv_questions_od4=:OD4,
                                            lv_questions_od5=:OD5,
                                            lv_questions_ci1=:CI1,
                                            lv_questions_ci2=:CI2,
                                            lv_questions_ci3=:CI3,
                                            lv_questions_ci4=:CI4,
                                            lv_questions_ci5=:CI5,
                                            lv_questions_ci6=:CI6,
                                            lv_questions_ci7=:CI7,
                                            lv_questions_ci8=:CI8,
                                            lv_questions_h1=:H1,
                                            lv_questions_h2=:H2,
                                            lv_questions_h3=:H3,
                                            lv_questions_l1=:L1,
                                            lv_questions_l2=:L2,
                                            lv_questions_l3=:L3,
                                            lv_questions_l4=:L4,
                                            lv_questions_l5=:L5,
                                            lv_questions_l6=:L6,
                                            lv_questions_l7=:L7,
                                            lv_questions_l8=:L8,
                                            lv_questions_icn1=:ICN1,
                                            lv_questions_icn2=:ICN2,
                                            lv_questions_icn3=:ICN3,
                                            lv_questions_icn4=:ICN4,
                                            lv_questions_icn5=:ICN5
                                            ");
    $VITALITY_QUES_QRY->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD1', $OD_Q1, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD2', $OD_Q2, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD3', $OD_Q3, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD4', $OD_Q4, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD5', $OD_Q5, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI1', $CI_Q1, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI2', $CI_Q2, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI3', $CI_Q3, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI4', $CI_Q4, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI5', $CI_Q5, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI6', $CI_Q6, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI7', $CI_Q7, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI8', $CI_Q8, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':CI8', $CI_Q8, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':H1', $H_Q1, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':H2', $H_Q2, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':H3', $H_Q3, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L1', $L_Q1, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L2', $L_Q2, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L3', $L_Q3, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L4', $L_Q4, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L5', $L_Q5, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L6', $L_Q6, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L7', $L_Q7, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':L8', $L_Q8, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':ICN1', $ICN_Q1, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':ICN2', $ICN_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN3', $ICN_Q3, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':ICN4', $ICN_Q4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN5', $ICN_Q5, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->execute()or die(print_r($VITALITY_QUES_QRY->errorInfo(), true));     
    
    $E_Q1 = filter_input(INPUT_POST, 'E_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q2 = filter_input(INPUT_POST, 'E_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q3 = filter_input(INPUT_POST, 'E_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q4 = filter_input(INPUT_POST, 'E_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q5 = filter_input(INPUT_POST, 'E_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DI_Q1 = filter_input(INPUT_POST, 'DI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DI_Q2 = filter_input(INPUT_POST, 'DI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI_Q1 = filter_input(INPUT_POST, 'PI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q2 = filter_input(INPUT_POST, 'PI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q3 = filter_input(INPUT_POST, 'PI_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q4 = filter_input(INPUT_POST, 'PI_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q5 = filter_input(INPUT_POST, 'PI_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD_Q1 = filter_input(INPUT_POST, 'CD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q2 = filter_input(INPUT_POST, 'CD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q3 = filter_input(INPUT_POST, 'CD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q4 = filter_input(INPUT_POST, 'CD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q5 = filter_input(INPUT_POST, 'CD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q6 = filter_input(INPUT_POST, 'CD_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q7 = filter_input(INPUT_POST, 'CD_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC_Q1 = filter_input(INPUT_POST, 'QC_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q2 = filter_input(INPUT_POST, 'QC_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q3 = filter_input(INPUT_POST, 'QC_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q4 = filter_input(INPUT_POST, 'QC_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q5 = filter_input(INPUT_POST, 'QC_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q6 = filter_input(INPUT_POST, 'QC_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q7 = filter_input(INPUT_POST, 'QC_Q7', FILTER_SANITIZE_SPECIAL_CHARS);   
    
     $VITALITY_Q_EXTRA_QRY = $pdo->prepare("INSERT INTO 
                                            lv_questions_extra
                                        SET 
                                            lv_questions_extra_id_fk=:FK,
                                            lv_questions_extra_e1=:E1,
                                            lv_questions_extra_e2=:E2,
                                            lv_questions_extra_e3=:E3,
                                            lv_questions_extra_e4=:E4,
                                            lv_questions_extra_e5=:E5,
                                            lv_questions_extra_di1=:DI1,
                                            lv_questions_extra_di2=:DI2,
                                            lv_questions_extra_pi1=:PI1,
                                            lv_questions_extra_pi2=:PI2,
                                            lv_questions_extra_pi3=:PI3,
                                            lv_questions_extra_pi4=:PI4,
                                            lv_questions_extra_pi5=:PI5,
                                            lv_questions_extra_cd1=:CD1,
                                            lv_questions_extra_cd2=:CD2,
                                            lv_questions_extra_cd3=:CD3,
                                            lv_questions_extra_cd4=:CD4,
                                            lv_questions_extra_cd5=:CD5,
                                            lv_questions_extra_cd6=:CD6,
                                            lv_questions_extra_cd7=:CD7,
                                            lv_questions_extra_qc1=:QC1,
                                            lv_questions_extra_qc2=:QC2,
                                            lv_questions_extra_qc3=:QC3,
                                            lv_questions_extra_qc4=:QC4,
                                            lv_questions_extra_qc5=:QC5,
                                            lv_questions_extra_qc6=:QC6,
                                            lv_questions_extra_qc7=:QC7
                                            ");
    $VITALITY_Q_EXTRA_QRY->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E1', $E_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E2', $E_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E3', $E_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E4', $E_Q4, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E5', $E_Q5, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':DI1', $DI_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':DI2', $DI_Q2, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI1', $PI_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI2', $PI_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI3', $PI_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI4', $PI_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI5', $PI_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD1', $CD_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD2', $CD_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD3', $CD_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD4', $CD_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD5', $CD_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD6', $CD_Q6, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD7', $CD_Q7, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC1', $QC_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC2', $QC_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC3', $QC_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC4', $QC_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC5', $QC_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC6', $QC_Q6, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC7', $QC_Q7, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->execute()or die(print_r($VITALITY_Q_EXTRA_QRY->errorInfo(), true));    
    
    $OD_C1 = filter_input(INPUT_POST, 'OD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C2 = filter_input(INPUT_POST, 'OD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C3 = filter_input(INPUT_POST, 'OD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C4 = filter_input(INPUT_POST, 'OD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C5 = filter_input(INPUT_POST, 'OD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI_C1 = filter_input(INPUT_POST, 'CI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C2 = filter_input(INPUT_POST, 'CI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C3 = filter_input(INPUT_POST, 'CI_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C4 = filter_input(INPUT_POST, 'CI_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C5 = filter_input(INPUT_POST, 'CI_C5', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C6 = filter_input(INPUT_POST, 'CI_C6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C7 = filter_input(INPUT_POST, 'CI_C7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C8 = filter_input(INPUT_POST, 'CI_C8', FILTER_SANITIZE_SPECIAL_CHARS); 
   
    $H_C1 = filter_input(INPUT_POST, 'H_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C2 = filter_input(INPUT_POST, 'H_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C3 = filter_input(INPUT_POST, 'H_C3', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $L_C1 = filter_input(INPUT_POST, 'L_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C2 = filter_input(INPUT_POST, 'L_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C3 = filter_input(INPUT_POST, 'L_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C4 = filter_input(INPUT_POST, 'L_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C5 = filter_input(INPUT_POST, 'L_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C6 = filter_input(INPUT_POST, 'L_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C7 = filter_input(INPUT_POST, 'L_C7', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C8 = filter_input(INPUT_POST, 'L_C8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_C1 = filter_input(INPUT_POST, 'ICN_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C2 = filter_input(INPUT_POST, 'ICN_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C3 = filter_input(INPUT_POST, 'ICN_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C4 = filter_input(INPUT_POST, 'ICN_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C5 = filter_input(INPUT_POST, 'ICN_C5', FILTER_SANITIZE_SPECIAL_CHARS); 

$VITALITY_COMMS_QRY = $pdo->prepare("INSERT INTO 
                                            lv_comments
                                        SET 
                                            lv_comments_id_fk=:FK,
                                            lv_comments_od1=:OD1, 
                                            lv_comments_od2=:OD2, 
                                            lv_comments_od3=:OD3,
                                            lv_comments_od4=:OD4,
                                            lv_comments_od5=:OD5,
                                            lv_comments_ci1=:CI1,
                                            lv_comments_ci2=:CI2,
                                            lv_comments_ci3=:CI3,
                                            lv_comments_ci4=:CI4,
                                            lv_comments_ci5=:CI5,
                                            lv_comments_ci6=:CI6,
                                            lv_comments_ci7=:CI7,
                                            lv_comments_ci8=:CI8,
                                            lv_comments_h1=:H1,
                                            lv_comments_h2=:H2,
                                            lv_comments_h3=:H3,
                                            lv_comments_l1=:L1,
                                            lv_comments_l2=:L2,
                                            lv_comments_l3=:L3,
                                            lv_comments_l4=:L4,
                                            lv_comments_l5=:L5,
                                            lv_comments_l6=:L6,
                                            lv_comments_l7=:L7,
                                            lv_comments_l8=:L8,
                                            lv_comments_icn1=:ICN1,
                                            lv_comments_icn2=:ICN2,
                                            lv_comments_icn3=:ICN3,
                                            lv_comments_icn4=:ICN4,
                                            lv_comments_icn5=:ICN5
                                            ");
    $VITALITY_COMMS_QRY->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD1', $OD_C1, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD2', $OD_C2, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD3', $OD_C3, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD4', $OD_C4, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD5', $OD_C5, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI1', $CI_C1, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI2', $CI_C2, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI3', $CI_C3, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI4', $CI_C4, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI5', $CI_C5, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI6', $CI_C6, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI7', $CI_C7, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI8', $CI_C8, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':CI8', $CI_C8, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':H1', $H_C1, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':H2', $H_C2, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':H3', $H_C3, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L1', $L_C1, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L2', $L_C2, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L3', $L_C3, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L4', $L_C4, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L5', $L_C5, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L6', $L_C6, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L7', $L_C7, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':L8', $L_C8, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':ICN1', $ICN_C1, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':ICN2', $ICN_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN3', $ICN_C3, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':ICN4', $ICN_C4, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN5', $ICN_C5, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->execute()or die(print_r($VITALITY_COMMS_QRY->errorInfo(), true)); 
    
    $E_C1 = filter_input(INPUT_POST, 'E_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C2 = filter_input(INPUT_POST, 'E_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C3 = filter_input(INPUT_POST, 'E_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C4 = filter_input(INPUT_POST, 'E_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C5 = filter_input(INPUT_POST, 'E_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DI_C1 = filter_input(INPUT_POST, 'DI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DI_C2 = filter_input(INPUT_POST, 'DI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI_C1 = filter_input(INPUT_POST, 'PI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C2 = filter_input(INPUT_POST, 'PI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C3 = filter_input(INPUT_POST, 'PI_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C4 = filter_input(INPUT_POST, 'PI_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C5 = filter_input(INPUT_POST, 'PI_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD_C1 = filter_input(INPUT_POST, 'CD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C2 = filter_input(INPUT_POST, 'CD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C3 = filter_input(INPUT_POST, 'CD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C4 = filter_input(INPUT_POST, 'CD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C5 = filter_input(INPUT_POST, 'CD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C6 = filter_input(INPUT_POST, 'CD_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C7 = filter_input(INPUT_POST, 'CD_C7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC_C1 = filter_input(INPUT_POST, 'QC_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C2 = filter_input(INPUT_POST, 'QC_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C3 = filter_input(INPUT_POST, 'QC_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C4 = filter_input(INPUT_POST, 'QC_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C5 = filter_input(INPUT_POST, 'QC_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C6 = filter_input(INPUT_POST, 'QC_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C7 = filter_input(INPUT_POST, 'QC_C7', FILTER_SANITIZE_SPECIAL_CHARS);    
    
     $VITALITY_C_EXTRA_QRY = $pdo->prepare("INSERT INTO 
                                            lv_comments_extra
                                        SET 
                                            lv_comments_extra_id_fk=:FK,
                                            lv_comments_extra_e1=:E1,
                                            lv_comments_extra_e2=:E2,
                                            lv_comments_extra_e3=:E3,
                                            lv_comments_extra_e4=:E4,
                                            lv_comments_extra_e5=:E5,
                                            lv_comments_extra_di1=:DI1,
                                            lv_comments_extra_di2=:DI2,
                                            lv_comments_extra_pi1=:PI1,
                                            lv_comments_extra_pi2=:PI2,
                                            lv_comments_extra_pi3=:PI3,
                                            lv_comments_extra_pi4=:PI4,
                                            lv_comments_extra_pi5=:PI5,
                                            lv_comments_extra_cd1=:CD1,
                                            lv_comments_extra_cd2=:CD2,
                                            lv_comments_extra_cd3=:CD3,
                                            lv_comments_extra_cd4=:CD4,
                                            lv_comments_extra_cd5=:CD5,
                                            lv_comments_extra_cd6=:CD6,
                                            lv_comments_extra_cd7=:CD7,
                                            lv_comments_extra_qc1=:QC1,
                                            lv_comments_extra_qc2=:QC2,
                                            lv_comments_extra_qc3=:QC3,
                                            lv_comments_extra_qc4=:QC4,
                                            lv_comments_extra_qc5=:QC5,
                                            lv_comments_extra_qc6=:QC6,
                                            lv_comments_extra_qc7=:QC7
                                            ");
    $VITALITY_C_EXTRA_QRY->bindParam(':FK', $LAST_AUDITID, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':E1', $E_C1, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':E2', $E_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':E3', $E_C3, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':E4', $E_C4, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':E5', $E_C5, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':DI1', $DI_C1, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':DI2', $DI_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI1', $PI_C1, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI2', $PI_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI3', $PI_C3, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI4', $PI_C4, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI5', $PI_C5, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD1', $CD_C1, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD2', $CD_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD3', $CD_C3, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD4', $CD_C4, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD5', $CD_C5, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD6', $CD_C6, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD7', $CD_C7, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC1', $QC_C1, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC2', $QC_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC3', $QC_C3, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC4', $QC_C4, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC5', $QC_C5, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC6', $QC_C6, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC7', $QC_C7, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->execute()or die(print_r($VITALITY_C_EXTRA_QRY->errorInfo(), true));    
        
    }
    
 

    if ($LAST_AUDITID >= '1') {
        header('Location: ../Menu.php?RETURN=ADDED&grade=' . $GRADE);
        die;
    } else {
        header('Location: ../Menu.php?RETURN=AuditEditFailed&Error');
        die;
    }
}
    if($EXECUTE=="2") {
        
    $CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $PLAN_NUMBER = filter_input(INPUT_POST, 'PLAN_NUMBER', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE = filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
    $AID = filter_input(INPUT_GET, 'AID', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $GRADE_ARRAY=array("Red","Amber","Green","Saved");
    
    if(isset($GRADE) && !in_array($GRADE,$GRADE_ARRAY)) {
        $GRADE="Saved";
    } 
    
    $VITALITY_AUDIT_QRY = $pdo->prepare("UPDATE 
                                            lv_audit
                                        SET 
                                            lv_audit_updated_by=:HELLO,
                                            lv_audit_grade=:GRADE, 
                                            lv_audit_closer=:CLOSER, 
                                            lv_audit_ref=:PLAN
                                        WHERE
                                        lv_audit_id=:AID");
    $VITALITY_AUDIT_QRY->bindParam(':AID', $AID, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':GRADE', $GRADE, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':PLAN', $PLAN_NUMBER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->execute()or die(print_r($VITALITY_AUDIT_QRY->errorInfo(), true));

    $OD_Q1 = filter_input(INPUT_POST, 'OD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q2 = filter_input(INPUT_POST, 'OD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q3 = filter_input(INPUT_POST, 'OD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q4 = filter_input(INPUT_POST, 'OD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q5 = filter_input(INPUT_POST, 'OD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI_Q1 = filter_input(INPUT_POST, 'CI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q2 = filter_input(INPUT_POST, 'CI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q3 = filter_input(INPUT_POST, 'CI_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q4 = filter_input(INPUT_POST, 'CI_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_Q5 = filter_input(INPUT_POST, 'CI_Q5', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q6 = filter_input(INPUT_POST, 'CI_Q6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q7 = filter_input(INPUT_POST, 'CI_Q7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_Q8 = filter_input(INPUT_POST, 'CI_Q8', FILTER_SANITIZE_SPECIAL_CHARS); 
   
    $H_Q1 = filter_input(INPUT_POST, 'H_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q2 = filter_input(INPUT_POST, 'H_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q3 = filter_input(INPUT_POST, 'H_Q3', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $L_Q1 = filter_input(INPUT_POST, 'L_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q2 = filter_input(INPUT_POST, 'L_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q3 = filter_input(INPUT_POST, 'L_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q4 = filter_input(INPUT_POST, 'L_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q5 = filter_input(INPUT_POST, 'L_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q6 = filter_input(INPUT_POST, 'L_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q7 = filter_input(INPUT_POST, 'L_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q8 = filter_input(INPUT_POST, 'L_Q8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_Q1 = filter_input(INPUT_POST, 'ICN_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q2 = filter_input(INPUT_POST, 'ICN_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q3 = filter_input(INPUT_POST, 'ICN_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q4 = filter_input(INPUT_POST, 'ICN_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q5 = filter_input(INPUT_POST, 'ICN_Q5', FILTER_SANITIZE_SPECIAL_CHARS);      
   
    
     $VITALITY_QUES_QRY = $pdo->prepare("UPDATE 
                                            lv_questions
                                        SET 
                                            lv_questions_od1=:OD1, 
                                            lv_questions_od2=:OD2, 
                                            lv_questions_od3=:OD3,
                                            lv_questions_od4=:OD4,
                                            lv_questions_od5=:OD5,
                                            lv_questions_ci1=:CI1,
                                            lv_questions_ci2=:CI2,
                                            lv_questions_ci3=:CI3,
                                            lv_questions_ci4=:CI4,
                                            lv_questions_ci5=:CI5,
                                            lv_questions_ci6=:CI6,
                                            lv_questions_ci7=:CI7,
                                            lv_questions_ci8=:CI8,
                                            lv_questions_h1=:H1,
                                            lv_questions_h2=:H2,
                                            lv_questions_h3=:H3,
                                            lv_questions_l1=:L1,
                                            lv_questions_l2=:L2,
                                            lv_questions_l3=:L3,
                                            lv_questions_l4=:L4,
                                            lv_questions_l5=:L5,
                                            lv_questions_l6=:L6,
                                            lv_questions_l7=:L7,
                                            lv_questions_l8=:L8,
                                            lv_questions_icn1=:ICN1,
                                            lv_questions_icn2=:ICN2,
                                            lv_questions_icn3=:ICN3,
                                            lv_questions_icn4=:ICN4,
                                            lv_questions_icn5=:ICN5
                                        WHERE
                                            lv_questions_id_fk=:FK
                                            ");
    $VITALITY_QUES_QRY->bindParam(':FK', $AID, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':OD1', $OD_Q1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':OD2', $OD_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':OD3', $OD_Q3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':OD4', $OD_Q4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':OD5', $OD_Q5, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI1', $CI_Q1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI2', $CI_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI3', $CI_Q3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI4', $CI_Q4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI5', $CI_Q5, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI6', $CI_Q6, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI7', $CI_Q7, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI8', $CI_Q8, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':CI8', $CI_Q8, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':H1', $H_Q1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':H2', $H_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':H3', $H_Q3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L1', $L_Q1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L2', $L_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L3', $L_Q3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L4', $L_Q4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L5', $L_Q5, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L6', $L_Q6, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L7', $L_Q7, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':L8', $L_Q8, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN1', $ICN_Q1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN2', $ICN_Q2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN3', $ICN_Q3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN4', $ICN_Q4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':ICN5', $ICN_Q5, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->execute()or die(print_r($VITALITY_QUES_QRY->errorInfo(), true));     
    
    $E_Q1 = filter_input(INPUT_POST, 'E_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q2 = filter_input(INPUT_POST, 'E_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q3 = filter_input(INPUT_POST, 'E_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q4 = filter_input(INPUT_POST, 'E_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_Q5 = filter_input(INPUT_POST, 'E_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DI_Q1 = filter_input(INPUT_POST, 'DI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DI_Q2 = filter_input(INPUT_POST, 'DI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI_Q1 = filter_input(INPUT_POST, 'PI_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q2 = filter_input(INPUT_POST, 'PI_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q3 = filter_input(INPUT_POST, 'PI_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q4 = filter_input(INPUT_POST, 'PI_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_Q5 = filter_input(INPUT_POST, 'PI_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD_Q1 = filter_input(INPUT_POST, 'CD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q2 = filter_input(INPUT_POST, 'CD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q3 = filter_input(INPUT_POST, 'CD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q4 = filter_input(INPUT_POST, 'CD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q5 = filter_input(INPUT_POST, 'CD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q6 = filter_input(INPUT_POST, 'CD_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q7 = filter_input(INPUT_POST, 'CD_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC_Q1 = filter_input(INPUT_POST, 'QC_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q2 = filter_input(INPUT_POST, 'QC_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q3 = filter_input(INPUT_POST, 'QC_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q4 = filter_input(INPUT_POST, 'QC_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q5 = filter_input(INPUT_POST, 'QC_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q6 = filter_input(INPUT_POST, 'QC_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q7 = filter_input(INPUT_POST, 'QC_Q7', FILTER_SANITIZE_SPECIAL_CHARS);   
    
     $VITALITY_Q_EXTRA_QRY = $pdo->prepare("UPDATE 
                                            lv_questions_extra
                                        SET
                                            lv_questions_extra_e1=:E1,
                                            lv_questions_extra_e2=:E2,
                                            lv_questions_extra_e3=:E3,
                                            lv_questions_extra_e4=:E4,
                                            lv_questions_extra_e5=:E5,
                                            lv_questions_extra_di1=:DI1,
                                            lv_questions_extra_di2=:DI2,
                                            lv_questions_extra_pi1=:PI1,
                                            lv_questions_extra_pi2=:PI2,
                                            lv_questions_extra_pi3=:PI3,
                                            lv_questions_extra_pi4=:PI4,
                                            lv_questions_extra_pi5=:PI5,
                                            lv_questions_extra_cd1=:CD1,
                                            lv_questions_extra_cd2=:CD2,
                                            lv_questions_extra_cd3=:CD3,
                                            lv_questions_extra_cd4=:CD4,
                                            lv_questions_extra_cd5=:CD5,
                                            lv_questions_extra_cd6=:CD6,
                                            lv_questions_extra_cd7=:CD7,
                                            lv_questions_extra_qc1=:QC1,
                                            lv_questions_extra_qc2=:QC2,
                                            lv_questions_extra_qc3=:QC3,
                                            lv_questions_extra_qc4=:QC4,
                                            lv_questions_extra_qc5=:QC5,
                                            lv_questions_extra_qc6=:QC6,
                                            lv_questions_extra_qc7=:QC7
                                        WHERE
                                            lv_questions_extra_id_fk=:FK
                                            ");
    $VITALITY_Q_EXTRA_QRY->bindParam(':FK', $AID, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E1', $E_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E2', $E_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E3', $E_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E4', $E_Q4, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':E5', $E_Q5, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':DI1', $DI_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':DI2', $DI_Q2, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI1', $PI_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI2', $PI_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI3', $PI_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI4', $PI_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':PI5', $PI_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD1', $CD_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD2', $CD_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD3', $CD_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD4', $CD_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD5', $CD_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD6', $CD_Q6, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':CD7', $CD_Q7, PDO::PARAM_STR);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC1', $QC_Q1, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC2', $QC_Q2, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC3', $QC_Q3, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC4', $QC_Q4, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC5', $QC_Q5, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC6', $QC_Q6, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->bindParam(':QC7', $QC_Q7, PDO::PARAM_INT);
    $VITALITY_Q_EXTRA_QRY->execute()or die(print_r($VITALITY_Q_EXTRA_QRY->errorInfo(), true));    
    
    $OD_C1 = filter_input(INPUT_POST, 'OD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C2 = filter_input(INPUT_POST, 'OD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C3 = filter_input(INPUT_POST, 'OD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C4 = filter_input(INPUT_POST, 'OD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C5 = filter_input(INPUT_POST, 'OD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CI_C1 = filter_input(INPUT_POST, 'CI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C2 = filter_input(INPUT_POST, 'CI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C3 = filter_input(INPUT_POST, 'CI_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C4 = filter_input(INPUT_POST, 'CI_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CI_C5 = filter_input(INPUT_POST, 'CI_C5', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C6 = filter_input(INPUT_POST, 'CI_C6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C7 = filter_input(INPUT_POST, 'CI_C7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CI_C8 = filter_input(INPUT_POST, 'CI_C8', FILTER_SANITIZE_SPECIAL_CHARS); 
   
    $H_C1 = filter_input(INPUT_POST, 'H_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C2 = filter_input(INPUT_POST, 'H_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C3 = filter_input(INPUT_POST, 'H_C3', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $L_C1 = filter_input(INPUT_POST, 'L_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C2 = filter_input(INPUT_POST, 'L_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C3 = filter_input(INPUT_POST, 'L_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C4 = filter_input(INPUT_POST, 'L_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C5 = filter_input(INPUT_POST, 'L_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C6 = filter_input(INPUT_POST, 'L_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C7 = filter_input(INPUT_POST, 'L_C7', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C8 = filter_input(INPUT_POST, 'L_C8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_C1 = filter_input(INPUT_POST, 'ICN_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C2 = filter_input(INPUT_POST, 'ICN_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C3 = filter_input(INPUT_POST, 'ICN_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C4 = filter_input(INPUT_POST, 'ICN_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C5 = filter_input(INPUT_POST, 'ICN_C5', FILTER_SANITIZE_SPECIAL_CHARS); 

$VITALITY_COMMS_QRY = $pdo->prepare("UPDATE
                                            lv_comments
                                        SET
                                            lv_comments_od1=:OD1, 
                                            lv_comments_od2=:OD2, 
                                            lv_comments_od3=:OD3,
                                            lv_comments_od4=:OD4,
                                            lv_comments_od5=:OD5,
                                            lv_comments_ci1=:CI1,
                                            lv_comments_ci2=:CI2,
                                            lv_comments_ci3=:CI3,
                                            lv_comments_ci4=:CI4,
                                            lv_comments_ci5=:CI5,
                                            lv_comments_ci6=:CI6,
                                            lv_comments_ci7=:CI7,
                                            lv_comments_ci8=:CI8,
                                            lv_comments_h1=:H1,
                                            lv_comments_h2=:H2,
                                            lv_comments_h3=:H3,
                                            lv_comments_l1=:L1,
                                            lv_comments_l2=:L2,
                                            lv_comments_l3=:L3,
                                            lv_comments_l4=:L4,
                                            lv_comments_l5=:L5,
                                            lv_comments_l6=:L6,
                                            lv_comments_l7=:L7,
                                            lv_comments_l8=:L8,
                                            lv_comments_icn1=:ICN1,
                                            lv_comments_icn2=:ICN2,
                                            lv_comments_icn3=:ICN3,
                                            lv_comments_icn4=:ICN4,
                                            lv_comments_icn5=:ICN5
                                        WHERE
                                        lv_comments_id_fk=:FK
                                            ");
    $VITALITY_COMMS_QRY->bindParam(':FK', $AID, PDO::PARAM_INT);
    $VITALITY_COMMS_QRY->bindParam(':OD1', $OD_C1, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':OD2', $OD_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':OD3', $OD_C3, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':OD4', $OD_C4, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':OD5', $OD_C5, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI1', $CI_C1, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI2', $CI_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI3', $CI_C3, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI4', $CI_C4, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI5', $CI_C5, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI6', $CI_C6, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI7', $CI_C7, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI8', $CI_C8, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':CI8', $CI_C8, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':H1', $H_C1, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':H2', $H_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':H3', $H_C3, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L1', $L_C1, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L2', $L_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L3', $L_C3, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L4', $L_C4, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L5', $L_C5, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L6', $L_C6, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L7', $L_C7, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':L8', $L_C8, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN1', $ICN_C1, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN2', $ICN_C2, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN3', $ICN_C3, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN4', $ICN_C4, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->bindParam(':ICN5', $ICN_C5, PDO::PARAM_STR);
    $VITALITY_COMMS_QRY->execute()or die(print_r($VITALITY_COMMS_QRY->errorInfo(), true)); 
    
    $E_C1 = filter_input(INPUT_POST, 'E_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C2 = filter_input(INPUT_POST, 'E_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C3 = filter_input(INPUT_POST, 'E_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C4 = filter_input(INPUT_POST, 'E_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $E_C5 = filter_input(INPUT_POST, 'E_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DI_C1 = filter_input(INPUT_POST, 'DI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DI_C2 = filter_input(INPUT_POST, 'DI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $PI_C1 = filter_input(INPUT_POST, 'PI_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C2 = filter_input(INPUT_POST, 'PI_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C3 = filter_input(INPUT_POST, 'PI_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C4 = filter_input(INPUT_POST, 'PI_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $PI_C5 = filter_input(INPUT_POST, 'PI_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD_C1 = filter_input(INPUT_POST, 'CD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C2 = filter_input(INPUT_POST, 'CD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C3 = filter_input(INPUT_POST, 'CD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C4 = filter_input(INPUT_POST, 'CD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C5 = filter_input(INPUT_POST, 'CD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C6 = filter_input(INPUT_POST, 'CD_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C7 = filter_input(INPUT_POST, 'CD_C7', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $QC_C1 = filter_input(INPUT_POST, 'QC_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C2 = filter_input(INPUT_POST, 'QC_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C3 = filter_input(INPUT_POST, 'QC_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C4 = filter_input(INPUT_POST, 'QC_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C5 = filter_input(INPUT_POST, 'QC_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C6 = filter_input(INPUT_POST, 'QC_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C7 = filter_input(INPUT_POST, 'QC_C7', FILTER_SANITIZE_SPECIAL_CHARS);    
    
     $VITALITY_C_EXTRA_QRY = $pdo->prepare("UPDATE
                                            lv_comments_extra
                                        SET
                                            lv_comments_extra_e1=:E1,
                                            lv_comments_extra_e2=:E2,
                                            lv_comments_extra_e3=:E3,
                                            lv_comments_extra_e4=:E4,
                                            lv_comments_extra_e5=:E5,
                                            lv_comments_extra_di1=:DI1,
                                            lv_comments_extra_di2=:DI2,
                                            lv_comments_extra_pi1=:PI1,
                                            lv_comments_extra_pi2=:PI2,
                                            lv_comments_extra_pi3=:PI3,
                                            lv_comments_extra_pi4=:PI4,
                                            lv_comments_extra_pi5=:PI5,
                                            lv_comments_extra_cd1=:CD1,
                                            lv_comments_extra_cd2=:CD2,
                                            lv_comments_extra_cd3=:CD3,
                                            lv_comments_extra_cd4=:CD4,
                                            lv_comments_extra_cd5=:CD5,
                                            lv_comments_extra_cd6=:CD6,
                                            lv_comments_extra_cd7=:CD7,
                                            lv_comments_extra_qc1=:QC1,
                                            lv_comments_extra_qc2=:QC2,
                                            lv_comments_extra_qc3=:QC3,
                                            lv_comments_extra_qc4=:QC4,
                                            lv_comments_extra_qc5=:QC5,
                                            lv_comments_extra_qc6=:QC6,
                                            lv_comments_extra_qc7=:QC7
                                        WHERE
                                        lv_comments_extra_id_fk=:FK
                                            ");
    $VITALITY_C_EXTRA_QRY->bindParam(':FK', $AID, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':E1', $E_C1, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':E2', $E_C2, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':E3', $E_C3, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':E4', $E_C4, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':E5', $E_C5, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':DI1', $DI_C1, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':DI2', $DI_C2, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI1', $PI_C1, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI2', $PI_C2, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI3', $PI_C3, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI4', $PI_C4, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':PI5', $PI_C5, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD1', $CD_C1, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD2', $CD_C2, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD3', $CD_C3, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD4', $CD_C4, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD5', $CD_C5, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD6', $CD_C6, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':CD7', $CD_C7, PDO::PARAM_STR);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC1', $QC_C1, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC2', $QC_C2, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC3', $QC_C3, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC4', $QC_C4, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC5', $QC_C5, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC6', $QC_C6, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->bindParam(':QC7', $QC_C7, PDO::PARAM_INT);
    $VITALITY_C_EXTRA_QRY->execute()or die(print_r($VITALITY_C_EXTRA_QRY->errorInfo(), true));     


    if ($AID >= '1') {
        header('Location: ../Menu.php?RETURN=UPDATED&grade=' . $GRADE);
        die;
    } else {
        header('Location: ../Menu.php?RETURN=AuditEditFailed&Error');
        die;
    }
}
}
?>