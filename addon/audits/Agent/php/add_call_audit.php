<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
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

    $AGENT = filter_input(INPUT_POST, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);
    $REFERENCE = filter_input(INPUT_POST, 'REFERENCE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CLOSER="Lead";

    $INSURER='Lead';
    
    $SQ1 = filter_input(INPUT_POST, 'SQ1', FILTER_SANITIZE_SPECIAL_CHARS);
    $SQ2 = filter_input(INPUT_POST, 'SQ2', FILTER_SANITIZE_SPECIAL_CHARS);
    $SQ3 = filter_input(INPUT_POST, 'SQ3', FILTER_SANITIZE_SPECIAL_CHARS);
    $SQ4 = filter_input(INPUT_POST, 'SQ4', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $Q1TEXT = filter_input(INPUT_POST, 'Q1TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q2TEXT = filter_input(INPUT_POST, 'Q2TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q3TEXT = filter_input(INPUT_POST, 'Q3TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q4TEXT = filter_input(INPUT_POST, 'Q4TEXT', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $S2AQ1 = filter_input(INPUT_POST, 'S2AQ1', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ2 = filter_input(INPUT_POST, 'S2AQ2', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ3 = filter_input(INPUT_POST, 'S2AQ3', FILTER_SANITIZE_SPECIAL_CHARS);      
    $S2AQ4 = filter_input(INPUT_POST, 'S2AQ4', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ5 = filter_input(INPUT_POST, 'S2AQ5', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ6 = filter_input(INPUT_POST, 'S2AQ6', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ7 = filter_input(INPUT_POST, 'S2AQ7', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ8 = filter_input(INPUT_POST, 'S2AQ8', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ9 = filter_input(INPUT_POST, 'S2AQ9', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ10 = filter_input(INPUT_POST, 'S2AQ10', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AQ11 = filter_input(INPUT_POST, 'S2AQ11', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $S2AC1 = filter_input(INPUT_POST, 'S2AC1', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC2 = filter_input(INPUT_POST, 'S2AC2', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC3 = filter_input(INPUT_POST, 'S2AC3', FILTER_SANITIZE_SPECIAL_CHARS);      
    $S2AC4 = filter_input(INPUT_POST, 'S2AC4', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC5 = filter_input(INPUT_POST, 'S2AC5', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC6 = filter_input(INPUT_POST, 'S2AC6', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC7 = filter_input(INPUT_POST, 'S2AC7', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC8 = filter_input(INPUT_POST, 'S2AC8', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC9 = filter_input(INPUT_POST, 'S2AC9', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC10 = filter_input(INPUT_POST, 'S2AC10', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2AC11 = filter_input(INPUT_POST, 'S2AC11', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $S2BQ1 = filter_input(INPUT_POST, 'S2BQ1', FILTER_SANITIZE_SPECIAL_CHARS);
    $S2BQ2 = filter_input(INPUT_POST, 'Q2S2BQ2', FILTER_SANITIZE_SPECIAL_CHARS);    

    $Q1S4Q1n = filter_input(INPUT_POST, 'Q1S4Q1n', FILTER_SANITIZE_SPECIAL_CHARS);
    $Q1S4C1n = filter_input(INPUT_POST, 'Q1S4C1n', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $Q1S3Q1 = filter_input(INPUT_POST, 'Q1S3Q1', FILTER_SANITIZE_SPECIAL_CHARS);   
    
    $OUT_OF=19;
    $CORRECT=0;
    
    if($SQ1 == "Yes") {
        $CORRECT++;
    } else {
        $AUTO_RED=1;
    }
    if($SQ2 == "Yes") {
        $CORRECT++;
    } else {
        $AUTO_RED=1;
    }
    if($SQ3 == "Yes") {
        $CORRECT++;
    } else {
        $AUTO_RED=1;
    }
    if($SQ4 == "Yes") {
        $CORRECT++;
    } else {
        $AUTO_RED=1;
    } 
    
    if($S2AQ1 == "Yes") {
        $CORRECT++;
    }
    if($S2AQ2 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ3 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ4 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ5 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ6 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ7 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ8 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ9 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ10 == "Yes") {
        $CORRECT++;
    } 
    if($S2AQ11 == "Yes") {
        $CORRECT++;
    } 
    if($S2BQ1 == "Yes") {
        $CORRECT++;
    } 
    if($S2BQ2 == "Yes") {
        $CORRECT++;
    } 
    if($Q1S4Q1n == "Yes") {
        $CORRECT++;
    } else {
        $AUTO_RED=1;
    }
    if($Q1S3Q1 == "Yes") {
        $CORRECT++;
    }     

    if(isset($CORRECT)) {
        if($CORRECT >= 17) {
            $GRADE="Green";
        } elseif($CORRECT >= 13 && $CORRECT < 17) {
            $GRADE="Amber";
        } else {
            $GRADE="Red";
        }
    }
    
    if(isset($AUTO_RED) && $AUTO_RED == 1) {
        $GRADE = "Red";
    }    

    $VITALITY_AUDIT_QRY = $pdo->prepare("INSERT INTO 
                                            adl_audits
                                        SET 
                                            adl_audits_auditor=:HELLO,
                                            adl_audits_grade=:GRADE,
                                            adl_audits_agent=:AGENT,
                                            adl_audits_closer=:CLOSER,
                                            adl_audits_ref=:PLAN,
                                            adl_audits_insurer=:INSURER");
    $VITALITY_AUDIT_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':GRADE', $GRADE, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':AGENT', $AGENT, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':PLAN', $REFERENCE, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->bindParam(':INSURER', $INSURER, PDO::PARAM_STR, 100);
    $VITALITY_AUDIT_QRY->execute()or die(print_r($VITALITY_AUDIT_QRY->errorInfo(), true));
    $LAST_AUDITID = $pdo->lastInsertId();  
    
    if(isset($LAST_AUDITID)) {        

     $VITALITY_QUES_QRY = $pdo->prepare("INSERT INTO 
                                            adl_audit_lead
                                        SET 
                                        adl_audit_lead_id_fk=:ID,
                                        adl_audit_lead_ref=:REF,
                                        adl_audit_lead_sec_1=:SQ1,
                                        adl_audit_lead_sec_2=:SQ2,
                                        adl_audit_lead_sec_3=:SQ3,
                                        adl_audit_lead_sec_4=:SQ4,
                                        adl_audit_lead_sec_c1=:Q1TEXT,
                                        adl_audit_lead_sec_c2=:Q2TEXT,
                                        adl_audit_lead_sec_c3=:Q3TEXT,
                                        adl_audit_lead_sec_c4=:Q4TEXT,
                                        adl_audit_lead_qua_a_1=:S2AQ1,
                                        adl_audit_lead_qua_a_2=:S2AQ2,
                                        adl_audit_lead_qua_a_3=:S2AQ3,
                                        adl_audit_lead_qua_a_4=:S2AQ4,
                                        adl_audit_lead_qua_a_5=:S2AQ5,
                                        adl_audit_lead_qua_a_6=:S2AQ6,
                                        adl_audit_lead_qua_a_7=:S2AQ7,
                                        adl_audit_lead_qua_a_8=:S2AQ8,
                                        adl_audit_lead_qua_a_9=:S2AQ9,
                                        adl_audit_lead_qua_a_10=:S2AQ10,
                                        adl_audit_lead_qua_a_11=:S2AQ11,
                                        adl_audit_lead_qua_b_1=:S2BQ1,
                                        adl_audit_lead_qua_b_2=:S2BQ2,
                                        adl_audit_lead_qua_sec3_1=:Q1S4Q1n,
                                        adl_audit_lead_qua_sec3_c_1=:Q1S4C1n,
                                        adl_audit_lead_qua_sec4_1=:Q1S3Q1");
    $VITALITY_QUES_QRY->bindParam(':ID', $LAST_AUDITID, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':REF', $REFERENCE, PDO::PARAM_INT);
    $VITALITY_QUES_QRY->bindParam(':SQ1', $SQ1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':SQ2', $SQ2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':SQ3', $SQ3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':SQ4', $SQ4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':Q1TEXT', $Q1TEXT, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':Q2TEXT', $Q2TEXT, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':Q3TEXT', $Q3TEXT, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':Q4TEXT', $Q4TEXT, PDO::PARAM_STR); 
    $VITALITY_QUES_QRY->bindParam(':S2AQ1', $S2AQ1, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ2', $S2AQ2, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ3', $S2AQ3, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ4', $S2AQ4, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ5', $S2AQ5, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ6', $S2AQ6, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ7', $S2AQ7, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ8', $S2AQ8, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ9', $S2AQ9, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ10', $S2AQ10, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2AQ11', $S2AQ11, PDO::PARAM_STR);
    $VITALITY_QUES_QRY->bindParam(':S2BQ1', $S2BQ1, PDO::PARAM_STR); 
    $VITALITY_QUES_QRY->bindParam(':S2BQ2', $S2BQ2, PDO::PARAM_STR); 
    $VITALITY_QUES_QRY->bindParam(':Q1S4Q1n', $Q1S4Q1n, PDO::PARAM_STR); 
    $VITALITY_QUES_QRY->bindParam(':Q1S4C1n', $Q1S4C1n, PDO::PARAM_STR); 
    $VITALITY_QUES_QRY->bindParam(':Q1S3Q1', $Q1S3Q1, PDO::PARAM_STR);
    $LAST_AUDITID = $pdo->lastInsertId();  
    $VITALITY_QUES_QRY->execute()or die(print_r($VITALITY_QUES_QRY->errorInfo(), true));  
    
                        $query = $pdo->prepare("SELECT 
                            client_id
                        FROM 
                            client_details 
                        WHERE 
                            phone_number=:REF");
                        $query->bindParam(':REF', $REFERENCE, PDO::PARAM_INT);
                        $query->execute();
                        $row = $query->fetch(PDO::FETCH_ASSOC);
                        if ($query->rowCount() > 0) {    
    
    if(isset($row['client_id'])) {
        
        $CID=$row['client_id'];
        
    }      

        $MSG = "$INSURER audit ($LAST_AUDITID) submitted.";

        $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name='ADL Alert', sent_by=:SENT, note_type='Audit Submitted', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':MSG', $MSG, PDO::PARAM_STR, 2500);
        $query->execute();                
        
    }    
        
    }
    
 

    if ($LAST_AUDITID >= '1') {
        header('Location: ../../search_audits.php?RETURN=ADDED&GRADE=' . $GRADE.'&INSURER='.$INSURER);
        die;
    } else {
        header('Location: ../../search_audits.php?RETURN=AuditEditFailed&Error');
        die;
    }
}

}
?>