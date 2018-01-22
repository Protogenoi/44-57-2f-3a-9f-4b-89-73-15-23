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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);  

if(isset($EXECUTE)) {
    if($EXECUTE=='VIEW') {
        $AUDITID= filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);
        
    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT 
                            DATE(lv_audit_added_date) AS lv_audit_added_date, 
                            lv_audit_auditor, 
                            lv_audit_grade, 
                            lv_audit_closer, 
                            lv_audit_ref
                        FROM 
                            lv_audit 
                        WHERE 
                            lv_audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_AUDIT=$database->single(); 
    
    if(isset($VIT_AUDIT['lv_audit_auditor'])) {
        $VIT_ADDED_BY=$VIT_AUDIT['lv_audit_auditor'];
    }
     if(isset($VIT_AUDIT['lv_audit_added_date'])) {
        $VIT_ADDED_DATE=$VIT_AUDIT['lv_audit_added_date'];
    }   
    if(isset($VIT_AUDIT['lv_audit_grade'])) {
        $VIT_GRADE=$VIT_AUDIT['lv_audit_grade'];
    }
    if(isset($VIT_AUDIT['lv_audit_closer'])) {
       $VIT_CLOSER=$VIT_AUDIT['lv_audit_closer'];
    } 
    if(isset($VIT_AUDIT['lv_audit_ref'])) {
       $VIT_PLAN_NUMBER=$VIT_AUDIT['lv_audit_ref']; 
    }     
    
    $database->query("SELECT
                                            lv_questions_od1,
                                            lv_questions_od2, 
                                            lv_questions_od3,
                                            lv_questions_od4,
                                            lv_questions_od5,
                                            lv_questions_ci1,
                                            lv_questions_ci2,
                                            lv_questions_ci3,
                                            lv_questions_ci4,
                                            lv_questions_ci5,
                                            lv_questions_ci6,
                                            lv_questions_ci7,
                                            lv_questions_ci8,
                                            lv_questions_h1,
                                            lv_questions_h2,
                                            lv_questions_h3,
                                            lv_questions_l1,
                                            lv_questions_l2,
                                            lv_questions_l3,
                                            lv_questions_l4,
                                            lv_questions_l5,
                                            lv_questions_l6,
                                            lv_questions_l7,
                                            lv_questions_l8,
                                            lv_questions_icn1,
                                            lv_questions_icn2,
                                            lv_questions_icn3,
                                            lv_questions_icn4,
                                            lv_questions_icn5
                        FROM 
                            lv_questions 
                        WHERE 
                            lv_questions_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_QS_AUDIT=$database->single(); 
    
    if(isset($VIT_QS_AUDIT['lv_questions_od1'])) {
        $VIT_OD1=$VIT_QS_AUDIT['lv_questions_od1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_od2'])) {
        $VIT_OD2=$VIT_QS_AUDIT['lv_questions_od2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_od3'])) {
        $VIT_OD3=$VIT_QS_AUDIT['lv_questions_od3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_od4'])) {
       $VIT_OD4=$VIT_QS_AUDIT['lv_questions_od4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_od5'])) {
       $VIT_OD5=$VIT_QS_AUDIT['lv_questions_od5']; 
    }
    
     if(isset($VIT_QS_AUDIT['lv_questions_ci1'])) {
        $VIT_CI1=$VIT_QS_AUDIT['lv_questions_ci1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_ci2'])) {
        $VIT_CI2=$VIT_QS_AUDIT['lv_questions_ci2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_ci3'])) {
        $VIT_CI3=$VIT_QS_AUDIT['lv_questions_ci3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_ci4'])) {
       $VIT_CI4=$VIT_QS_AUDIT['lv_questions_ci4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_ci5'])) {
       $VIT_CI5=$VIT_QS_AUDIT['lv_questions_ci5']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci6'])) {
       $VIT_CI6=$VIT_QS_AUDIT['lv_questions_ci6']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci7'])) {
       $VIT_CI7=$VIT_QS_AUDIT['lv_questions_ci7']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci5'])) {
       $VIT_CI8=$VIT_QS_AUDIT['lv_questions_ci8']; 
    }    
    
    
    if(isset($VIT_QS_AUDIT['lv_questions_h1'])) {
        $VIT_H1=$VIT_QS_AUDIT['lv_questions_h1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_h2'])) {
        $VIT_H2=$VIT_QS_AUDIT['lv_questions_h2'];
    }  
     if(isset($VIT_QS_AUDIT['lv_questions_h3'])) {
        $VIT_H3=$VIT_QS_AUDIT['lv_questions_h3'];
    }      
    
    if(isset($VIT_QS_AUDIT['lv_questions_l1'])) {
        $VIT_L1=$VIT_QS_AUDIT['lv_questions_l1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_l2'])) {
        $VIT_L2=$VIT_QS_AUDIT['lv_questions_l2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_l3'])) {
        $VIT_L3=$VIT_QS_AUDIT['lv_questions_l3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_l4'])) {
       $VIT_L4=$VIT_QS_AUDIT['lv_questions_l4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_l5'])) {
       $VIT_L5=$VIT_QS_AUDIT['lv_questions_l5']; 
    }
    if(isset($VIT_QS_AUDIT['lv_questions_l6'])) {
       $VIT_L6=$VIT_QS_AUDIT['lv_questions_l6']; 
    }
    if(isset($VIT_QS_AUDIT['lv_questions_l7'])) {
       $VIT_L7=$VIT_QS_AUDIT['lv_questions_l7']; 
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_l8'])) {
       $VIT_L8=$VIT_QS_AUDIT['lv_questions_l8']; 
    }       
    
     if(isset($VIT_QS_AUDIT['lv_questions_ci1'])) {
        $VIT_CI1=$VIT_QS_AUDIT['lv_questions_ci1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_ci2'])) {
        $VIT_CI2=$VIT_QS_AUDIT['lv_questions_ci2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_ci3'])) {
        $VIT_CI3=$VIT_QS_AUDIT['lv_questions_ci3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_ci4'])) {
       $VIT_CI4=$VIT_QS_AUDIT['lv_questions_ci4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_ci5'])) {
       $VIT_CI5=$VIT_QS_AUDIT['lv_questions_ci5']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci6'])) {
       $VIT_CI6=$VIT_QS_AUDIT['lv_questions_ci6']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci7'])) {
       $VIT_CI7=$VIT_QS_AUDIT['lv_questions_ci7']; 
    }  
    if(isset($VIT_QS_AUDIT['lv_questions_ci5'])) {
       $VIT_CI8=$VIT_QS_AUDIT['lv_questions_ci8']; 
    }     
    
    
    if(isset($VIT_QS_AUDIT['lv_questions_p1'])) {
        $VIT_P1=$VIT_QS_AUDIT['lv_questions_p1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_p2'])) {
        $VIT_P2=$VIT_QS_AUDIT['lv_questions_p2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_p3'])) {
        $VIT_P3=$VIT_QS_AUDIT['lv_questions_p3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_p4'])) {
       $VIT_P4=$VIT_QS_AUDIT['lv_questions_p4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_p5'])) {
       $VIT_P5=$VIT_QS_AUDIT['lv_questions_p5']; 
    } 
    if(isset($VIT_QS_AUDIT['lv_questions_p6'])) {
        $VIT_P6=$VIT_QS_AUDIT['lv_questions_p6'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_p7'])) {
       $VIT_P7=$VIT_QS_AUDIT['lv_questions_p7'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_p8'])) {
       $VIT_P8=$VIT_QS_AUDIT['lv_questions_p8']; 
    }     

     if(isset($VIT_QS_AUDIT['lv_questions_icn1'])) {
        $VIT_ICN1=$VIT_QS_AUDIT['lv_questions_icn1'];
    }
     if(isset($VIT_QS_AUDIT['lv_questions_icn2'])) {
        $VIT_ICN2=$VIT_QS_AUDIT['lv_questions_icn2'];
    }   
    if(isset($VIT_QS_AUDIT['lv_questions_icn3'])) {
        $VIT_ICN3=$VIT_QS_AUDIT['lv_questions_icn3'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_icn4'])) {
       $VIT_ICN4=$VIT_QS_AUDIT['lv_questions_icn4'];
    }
    if(isset($VIT_QS_AUDIT['lv_questions_icn5'])) {
       $VIT_ICN5=$VIT_QS_AUDIT['lv_questions_icn5']; 
    }

    
$database->query("SELECT
                                            lv_questions_extra_e1,
                                            lv_questions_extra_e2,
                                            lv_questions_extra_e3,
                                            lv_questions_extra_e4,
                                            lv_questions_extra_e5,
                                            lv_questions_extra_di1,
                                            lv_questions_extra_di2,
                                            lv_questions_extra_pi1,
                                            lv_questions_extra_pi2,
                                            lv_questions_extra_pi3,
                                            lv_questions_extra_pi4,
                                            lv_questions_extra_pi5,
                                            lv_questions_extra_cd1,
                                            lv_questions_extra_cd2,
                                            lv_questions_extra_cd3,
                                            lv_questions_extra_cd4,
                                            lv_questions_extra_cd6,
                                            lv_questions_extra_cd7,
                                            lv_questions_extra_qc1,
                                            lv_questions_extra_qc2,
                                            lv_questions_extra_qc3,
                                            lv_questions_extra_qc4,
                                            lv_questions_extra_qc5,
                                            lv_questions_extra_qc6,
                                            lv_questions_extra_qc7
                    FROM 
                        lv_questions_extra
                    WHERE
                        lv_questions_extra_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_CM_AUDIT=$database->single(); 
       
    
    if(isset($VIT_CM_AUDIT['lv_questions_extra_e1'])) {
       $VIT_CM_E1=$VIT_CM_AUDIT['lv_questions_extra_e1']; 
    } 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_e2'])) {
       $VIT_CM_E2=$VIT_CM_AUDIT['lv_questions_extra_e2']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_e3'])) {
       $VIT_CM_E3=$VIT_CM_AUDIT['lv_questions_extra_e3']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_e4'])) {
       $VIT_CM_E4=$VIT_CM_AUDIT['lv_questions_extra_e4']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_e5'])) {
       $VIT_CM_E5=$VIT_CM_AUDIT['lv_questions_extra_e5']; 
    }
 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_di1'])) {
       $VIT_CM_DI1=$VIT_CM_AUDIT['lv_questions_extra_di1']; 
    } 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_di2'])) {
       $VIT_CM_DI2=$VIT_CM_AUDIT['lv_questions_extra_di2']; 
    }      
    
   if(isset($VIT_CM_AUDIT['lv_questions_extra_pi1'])) {
       $VIT_CM_PI1=$VIT_CM_AUDIT['lv_questions_extra_pi1']; 
    } 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_pi2'])) {
       $VIT_CM_PI2=$VIT_CM_AUDIT['lv_questions_extra_pi2']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_pi3'])) {
       $VIT_CM_PI3=$VIT_CM_AUDIT['lv_questions_extra_pi3']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_pi4'])) {
       $VIT_CM_PI4=$VIT_CM_AUDIT['lv_questions_extra_pi4']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_pi5'])) {
       $VIT_CM_PI5=$VIT_CM_AUDIT['lv_questions_extra_pi5']; 
    }  
    
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd1'])) {
       $VIT_CM_CD1=$VIT_CM_AUDIT['lv_questions_extra_cd1']; 
    } 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd2'])) {
       $VIT_CM_CD2=$VIT_CM_AUDIT['lv_questions_extra_cd2']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd3'])) {
       $VIT_CM_CD3=$VIT_CM_AUDIT['lv_questions_extra_cd3']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd4'])) {
       $VIT_CM_CD4=$VIT_CM_AUDIT['lv_questions_extra_cd4']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd6'])) {
       $VIT_CM_CD6=$VIT_CM_AUDIT['lv_questions_extra_cd6']; 
    }
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd7'])) {
       $VIT_CM_CD7=$VIT_CM_AUDIT['lv_questions_extra_cd7']; 
    } 

    
 if(isset($VIT_CM_AUDIT['lv_questions_extra_qc1'])) {
       $VIT_CM_QC1=$VIT_CM_AUDIT['lv_questions_extra_qc1']; 
    } 
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc2'])) {
       $VIT_CM_QC2=$VIT_CM_AUDIT['lv_questions_extra_qc2']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc3'])) {
       $VIT_CM_QC3=$VIT_CM_AUDIT['lv_questions_extra_qc3']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc4'])) {
       $VIT_CM_QC4=$VIT_CM_AUDIT['lv_questions_extra_qc4']; 
    }  
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc5'])) {
       $VIT_CM_QC5=$VIT_CM_AUDIT['lv_questions_extra_qc5']; 
    }
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc6'])) {
       $VIT_CM_QC6=$VIT_CM_AUDIT['lv_questions_extra_qc6']; 
    }
    if(isset($VIT_CM_AUDIT['lv_questions_extra_qc7'])) {
       $VIT_CM_QC7=$VIT_CM_AUDIT['lv_questions_extra_qc7']; 
    }    
    
    $database->query("SELECT
                            lv_comments_od1                                            
                            lv_comments_od2, 
                                            lv_comments_od3,
                                            lv_comments_od4,
                                            lv_comments_od5,
                                            lv_comments_ci1,
                                            lv_comments_ci2,
                                            lv_comments_ci3,
                                            lv_comments_ci4,
                                            lv_comments_ci5,
                                            lv_comments_ci6,
                                            lv_comments_ci7,
                                            lv_comments_ci8,
                                            lv_comments_h1,
                                            lv_comments_h2,
                                            lv_comments_h3,
                                            lv_comments_l1,
                                            lv_comments_l2,
                                            lv_comments_l3,
                                            lv_comments_l4,
                                            lv_comments_l5,
                                            lv_comments_l6,
                                            lv_comments_l7,
                                            lv_comments_l8,
                                            lv_comments_icn1,
                                            lv_comments_icn2,
                                            lv_comments_icn3,
                                            lv_comments_icn4,
                                            lv_comments_icn5
                        FROM 
                            lv_comments 
                        WHERE 
                            lv_comments_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_C_COM_AUDIT=$database->single(); 
    
    if(isset($VIT_C_COM_AUDIT['lv_comments_od1'])) {
        $VIT_C_OD1=$VIT_C_COM_AUDIT['lv_comments_od1'];
    }
     if(isset($VIT_C_COM_AUDIT['lv_comments_od2'])) {
        $VIT_C_OD2=$VIT_C_COM_AUDIT['lv_comments_od2'];
    }   
    if(isset($VIT_C_COM_AUDIT['lv_comments_od3'])) {
        $VIT_C_OD3=$VIT_C_COM_AUDIT['lv_comments_od3'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_od4'])) {
       $VIT_C_OD4=$VIT_C_COM_AUDIT['lv_comments_od4'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_od5'])) {
       $VIT_C_OD5=$VIT_C_COM_AUDIT['lv_comments_od5']; 
    }
    
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci1'])) {
        $VIT_C_CI1=$VIT_C_COM_AUDIT['lv_comments_ci1'];
    }
     if(isset($VIT_C_COM_AUDIT['lv_comments_ci2'])) {
        $VIT_C_CI2=$VIT_C_COM_AUDIT['lv_comments_ci2'];
    }   
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci3'])) {
        $VIT_C_CI3=$VIT_C_COM_AUDIT['lv_comments_ci3'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci4'])) {
       $VIT_C_CI4=$VIT_C_COM_AUDIT['lv_comments_ci4'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci5'])) {
       $VIT_C_CI5=$VIT_C_COM_AUDIT['lv_comments_ci5']; 
    } 
     if(isset($VIT_C_COM_AUDIT['lv_comments_ci6'])) {
        $VIT_C_CI6=$VIT_C_COM_AUDIT['lv_comments_ci6'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci7'])) {
       $VIT_C_CI7=$VIT_C_COM_AUDIT['lv_comments_ci7'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_ci8'])) {
       $VIT_C_CI8=$VIT_C_COM_AUDIT['lv_comments_ci8']; 
    } 
    
    if(isset($VIT_C_COM_AUDIT['lv_comments_h1'])) {
        $VIT_C_PH1=$VIT_C_COM_AUDIT['lv_comments_h1'];
    }
     if(isset($VIT_C_COM_AUDIT['lv_comments_h2'])) {
        $VIT_C_H2=$VIT_C_COM_AUDIT['lv_comments_h2'];
    }  
     if(isset($VIT_C_COM_AUDIT['lv_comments_h3'])) {
        $VIT_C_H3=$VIT_C_COM_AUDIT['lv_comments_h3'];
    }      
    
    
    if(isset($VIT_C_COM_AUDIT['lv_comments_l1'])) {
        $VIT_C_L1=$VIT_C_COM_AUDIT['lv_comments_l1'];
    }
     if(isset($VIT_C_COM_AUDIT['lv_comments_l2'])) {
        $VIT_C_L2=$VIT_C_COM_AUDIT['lv_comments_l2'];
    }   
    if(isset($VIT_C_COM_AUDIT['lv_comments_l3'])) {
        $VIT_C_L3=$VIT_C_COM_AUDIT['lv_comments_l3'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_l4'])) {
       $VIT_C_L4=$VIT_C_COM_AUDIT['lv_comments_l4'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_pl'])) {
       $VIT_C_L5=$VIT_C_COM_AUDIT['lv_comments_l5']; 
    } 
    if(isset($VIT_C_COM_AUDIT['lv_comments_l6'])) {
        $VIT_C_L6=$VIT_C_COM_AUDIT['lv_comments_l6'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_l7'])) {
       $VIT_C_L7=$VIT_C_COM_AUDIT['lv_comments_l7'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_l8'])) {
       $VIT_C_L8=$VIT_C_COM_AUDIT['lv_comments_l8']; 
    }       
    
     if(isset($VIT_C_COM_AUDIT['lv_comments_icn1'])) {
        $VIT_C_ICN1=$VIT_C_COM_AUDIT['lv_comments_icn1'];
    }
     if(isset($VIT_C_COM_AUDIT['lv_comments_icn2'])) {
        $VIT_C_ICN2=$VIT_C_COM_AUDIT['lv_comments_icn2'];
    }   
    if(isset($VIT_C_COM_AUDIT['lv_comments_icn3'])) {
        $VIT_C_ICN3=$VIT_C_COM_AUDIT['lv_comments_icn3'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_icn4'])) {
       $VIT_C_ICN4=$VIT_C_COM_AUDIT['lv_comments_icn4'];
    }
    if(isset($VIT_C_COM_AUDIT['lv_comments_icn5'])) {
       $VIT_C_ICN5=$VIT_C_COM_AUDIT['lv_comments_icn5']; 
    }    
    
$database->query("SELECT 
                        lv_comments_extra_e1,
                                            lv_comments_extra_e2,
                                            lv_comments_extra_e3,
                                            lv_comments_extra_e4,
                                            lv_comments_extra_e5,
                                            lv_comments_extra_di1,
                                            lv_comments_extra_di2,
                                            lv_comments_extra_pi1,
                                            lv_comments_extra_pi2,
                                            lv_comments_extra_pi3,
                                            lv_comments_extra_pi4,
                                            lv_comments_extra_pi5,
                                            lv_comments_extra_cd1,
                                            lv_comments_extra_cd2,
                                            lv_comments_extra_cd3,
                                            lv_comments_extra_cd4,
                                            lv_comments_extra_cd6,
                                            lv_comments_extra_cd7,
                                            lv_comments_extra_qc1,
                                            lv_comments_extra_qc2,
                                            lv_comments_extra_qc3,
                                            lv_comments_extra_qc4,
                                            lv_comments_extra_qc5,
                                            lv_comments_extra_qc6,
                                            lv_comments_extra_qc7
                    FROM 
                        lv_comments_extra
                    WHERE
                        lv_comments_extra_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_CE_AUDIT=$database->single(); 
       
    
    if(isset($VIT_CE_AUDIT['lv_comments_extra_e1'])) {
       $VIT_CE_E1=$VIT_CE_AUDIT['lv_comments_extra_e1']; 
    } 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_e2'])) {
       $VIT_CE_E2=$VIT_CE_AUDIT['lv_comments_extra_e2']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_e3'])) {
       $VIT_CE_E3=$VIT_CE_AUDIT['lv_comments_extra_e3']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_e4'])) {
       $VIT_CE_E4=$VIT_CE_AUDIT['lv_comments_extra_e4']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_e5'])) {
       $VIT_CE_E5=$VIT_CE_AUDIT['lv_comments_extra_e5']; 
    }
 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_di1'])) {
       $VIT_CE_DI1=$VIT_CE_AUDIT['lv_comments_extra_di1']; 
    } 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_di2'])) {
       $VIT_CE_DI2=$VIT_CE_AUDIT['lv_comments_extra_di2']; 
    }      
    
   if(isset($VIT_CE_AUDIT['lv_comments_extra_pi1'])) {
       $VIT_CE_PI1=$VIT_CE_AUDIT['lv_comments_extra_pi1']; 
    } 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_pi2'])) {
       $VIT_CE_PI2=$VIT_CE_AUDIT['lv_comments_extra_pi2']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_pi3'])) {
       $VIT_CE_PI3=$VIT_CE_AUDIT['lv_comments_extra_pi3']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_pi4'])) {
       $VIT_CE_PI4=$VIT_CE_AUDIT['lv_comments_extra_pi4']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_pi5'])) {
       $VIT_CE_PI5=$VIT_CE_AUDIT['lv_comments_extra_pi5']; 
    }  
    
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd1'])) {
       $VIT_CE_CD1=$VIT_CE_AUDIT['lv_comments_extra_cd1']; 
    } 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd2'])) {
       $VIT_CE_CD2=$VIT_CE_AUDIT['lv_comments_extra_cd2']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd3'])) {
       $VIT_CE_CD3=$VIT_CE_AUDIT['lv_comments_extra_cd3']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd4'])) {
       $VIT_CE_CD4=$VIT_CE_AUDIT['lv_comments_extra_cd4']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd6'])) {
       $VIT_CE_CD6=$VIT_CE_AUDIT['lv_comments_extra_cd6']; 
    }
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd7'])) {
       $VIT_CE_CD7=$VIT_CE_AUDIT['lv_comments_extra_cd7']; 
    } 

    
 if(isset($VIT_CE_AUDIT['lv_comments_extra_qc1'])) {
       $VIT_CE_QC1=$VIT_CE_AUDIT['lv_comments_extra_qc1']; 
    } 
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc2'])) {
       $VIT_CE_QC2=$VIT_CE_AUDIT['lv_comments_extra_qc2']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc3'])) {
       $VIT_CE_QC3=$VIT_CE_AUDIT['lv_comments_extra_qc3']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc4'])) {
       $VIT_CE_QC4=$VIT_CE_AUDIT['lv_comments_extra_qc4']; 
    }  
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc5'])) {
       $VIT_CE_QC5=$VIT_CE_AUDIT['lv_comments_extra_qc5']; 
    }
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc6'])) {
       $VIT_CE_QC6=$VIT_CE_AUDIT['lv_comments_extra_qc6']; 
    }
    if(isset($VIT_CE_AUDIT['lv_comments_extra_qc7'])) {
       $VIT_CE_QC7=$VIT_CE_AUDIT['lv_comments_extra_qc7']; 
    }    
    
      $database->endTransaction();  
    }
}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | View Vitality Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/resources/templates/ADL/audit_view.css" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/js/jquery-1.4.min.js"></script>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <script>
        function toggle(id) {
            if (document.getElementById(id).style.display === 'none') {
                document.getElementById(id).style.display = 'block';
            } else {
                document.getElementById(id).style.display = 'none';
            }
        }
    </script>
    <script type="text/javascript">

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'none';
            } else
                document.getElementById('ifYes').style.display = 'block';

        }

    </script>
</head>
<body>
    <div class="container">
       <div class="wrapper col4">
            <table id='users'>
                <thead>

                    <tr>
                        <td colspan=2><b>Vitality Call Audit ID: <?php echo $AUDITID ?></b></td>
                    </tr>

                    <tr>

                        <?php
                        
                        if ($VIT_GRADE == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>$VIT_GRADE</b></td>";
                        } else if ($VIT_GRADE == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>$VIT_GRADE</b></td>";
                        } else if ($VIT_GRADE == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>$VIT_GRADE</b></td>";
                        }
                        ?>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php echo $VIT_ADDED_BY; ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php echo $VIT_CLOSER; if(isset($VIT_CLOSER2) && $VIT_CLOSER2 !="None") { echo " - $VIT_CLOSER2"; } ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php echo $VIT_ADDED_DATE; ?></td>
                    </tr>

                    <tr>
                        <td>Plan Number</td>
                        <td><?php echo $VIT_PLAN_NUMBER; ?></td>
                    </tr>

                </thead>
            </table>
           
           <h1><b>Opening Declaration</b></h1>

            <p>
                <label for="q1">Q<?php $i=0; $i++; echo $i; ?>. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?</label><br>
                <input type="radio" name="q1" value="Yes" onclick="return false" <?php if(isset($VIT_OD1)) { if ($VIT_OD1 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q1" value="No" onclick="return false" <?php if(isset($VIT_OD1)) { if ($VIT_OD1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php if(isset($VIT_C_OD1)) { echo $VIT_C_OD1; } ?>
            </div>
            </p>

            <p>
                <label for="q2">Q<?php $i++; echo $i; ?>. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label><br>
                <input type="radio" name="q2" value="Yes" onclick="return false" <?php if(isset($VIT_OD2)) { if ($VIT_OD2 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q2" value="No" onclick="return false" <?php if(isset($VIT_OD2)) { if ($VIT_OD2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($VIT_C_OD2)) { echo $VIT_C_OD2; } ?>
            </div>
            </p>

            <p>
                <label for="q3">Q<?php $i++; echo $i; ?>. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label><br>
                <input type="radio" name="q3" value="Yes" onclick="return false" <?php if(isset($VIT_OD3)) { if ($VIT_OD3 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q3" value="No" onclick="return false" <?php if(isset($VIT_OD3)) { if ($VIT_OD3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($VIT_C_OD3)) { echo $VIT_C_OD3; } ?>
            </div>
            </p>

            <p>
                <label for="q4">Q<?php $i++; echo $i; ?>. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label><br>


                <input type="radio" name="q4" value="Yes" onclick="return false" <?php if(isset($VIT_OD4)) {  if ($VIT_OD4 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q4" value="No" onclick="return false" <?php if(isset($VIT_OD4)) { if ($VIT_OD4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($VIT_C_OD4)) { echo $VIT_C_OD4; } ?>
            </div>
            </p>

            <p>
                <label for="q5">Q<?php $i++; echo $i; ?>. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>

                <input type="radio" name="q5" value="Yes" onclick="return false" <?php if(isset($VIT_OD5)) {  if ($VIT_OD5 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q5" value="No" onclick="return false" <?php if(isset($VIT_OD5)) {  if ($VIT_OD5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($VIT_C_OD5)) { echo $VIT_C_OD5; } ?>
            </div>
            </p>  
            
<h3 class="panel-title">Customer Information</h3>   

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Were all clients titles and names recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI1)) {  if ($VIT_CI1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI1)) {  if ($VIT_CI1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI1)) { echo $VIT_C_CI1; } ?>
            </div>    
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients gender accurately recorded?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI2)) {  if ($VIT_CI2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI2)) {  if ($VIT_CI2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI2)) { echo $VIT_C_CI2; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients date of birth accurately recorded?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI3)) {  if ($VIT_CI3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI3)) {  if ($VIT_CI3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI3)) { echo $VIT_C_CI3; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients smoking status recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI4)) {  if ($VIT_CI4 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI4)) {  if ($VIT_CI4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI4)) { echo $VIT_C_CI4; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients occupation recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI5)) {  if ($VIT_CI5 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI5)) {  if ($VIT_CI5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI5)) { echo $VIT_C_CI5; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the question asked and recorded correctly about their living status in the UK?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI6)) {  if ($VIT_CI6 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI6)) {  if ($VIT_CI6 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI6)) { echo $VIT_C_CI6; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Did the CLOSER confirm the policy was a single or a joint application?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI7)) {  if ($VIT_CI7 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI7)) {  if ($VIT_CI7 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_CI7)) { echo $VIT_C_CI7; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the question "Have your natural parents, brothers, sisters had any of the ..[conditions] before the age of 60?" asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI8)) {  if ($VIT_CI8 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_CI8)) {  if ($VIT_CI8 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
             <div class="phpcomments">
                <?php if(isset($VIT_C_CI8)) { echo $VIT_C_CI8; } ?>
            </div>    
</p>  


<h3 class="panel-title">Health</h3>

<p>
    <label for="H1">Q<?php $i++; echo $i; ?>. Was the question for health condition in the last 5 years asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_H1)) {  if ($VIT_H1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_H1)) {  if ($VIT_H1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_H1)) { echo $VIT_C_H1; } ?>
            </div>    
</p>

<p>
    <label for="H1">Q<?php $i++; echo $i; ?>. Was the question for other health conditions in the last 2 years asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_H2)) {  if ($VIT_H2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_H2)) {  if ($VIT_H2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_H2)) { echo $VIT_C_H2; } ?>
            </div>     
</p>

<p>
    <label for="H1">Q<?php $i++; echo $i; ?>. Was the question for other health conditions in the last 3 months asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_H3)) {  if ($VIT_H3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_H3)) {  if ($VIT_H3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_H3)) { echo $VIT_C_H3; } ?>
            </div>     
</p>

            
             <h3 class="panel-title">Life Style</h3>
             
<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question about hazardous pastimes/activities (motorbike/aviation/motor sport) asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L1)) {  if ($VIT_L1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L1)) {  if ($VIT_L1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L1)) { echo $VIT_C_L1; } ?>
            </div>    
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "Have you been banned from driving or convicted of dangerous or careless driving the last 5 years?" asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L2)) {  if ($VIT_L2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L2)) {  if ($VIT_L2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L2)) { echo $VIT_C_L2; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "In the last 5 years have you lived, worked or travelled outside of the UK or European Union?" asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L3)) {  if ($VIT_L3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L3)) {  if ($VIT_L3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L3)) { echo $VIT_C_L3; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "...will the total amount of cover ..exceed £1m life cover or £500k CIC" asked recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L4)) {  if ($VIT_L4 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L4)) {  if ($VIT_L4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L4)) { echo $VIT_C_L4; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the alcohol questions asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L5)) {  if ($VIT_L5 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L5)) {  if ($VIT_L5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L5)) { echo $VIT_C_L5; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "..advised to reduce or stop your alcohol consumption.." asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L6)) {  if ($VIT_L6 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L6)) {  if ($VIT_L6 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L6)) { echo $VIT_C_L6; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "Have you used recreational drugs in the last 10 years" asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L7)) {  if ($VIT_L7 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L7)) {  if ($VIT_L7 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L7)) { echo $VIT_C_L7; } ?>
            </div>     
</p>

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Was the question "Does you job involve any of the following duties or working environments?" asked and recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($VIT_L8)) {  if ($VIT_L8 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($VIT_L8)) {  if ($VIT_L8 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($VIT_C_L8)) { echo $VIT_C_L8; } ?>
            </div>     
</p>

<h3 class="panel-title">Identifying Clients Needs</h3>

<p>
    <label for="ICN1">Q<?php $i++; echo $i; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label><br>
<input type="radio" name="ICN1" <?php if (isset($VIT_ICN1) && $VIT_ICN1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN1();" value="1" id="yesCheckICN1">Yes
<input type="radio" name="ICN1" <?php if (isset($VIT_ICN1) && $VIT_ICN1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN1();" value="0" id="noCheckICN1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_C_ICN1)) { echo $VIT_C_ICN1; } ?></div>

<p>
<label for="ICN2">Q<?php $i++; echo $i; ?>. Did the closer mention waiver, indexation, or TPD?</label><br>
<input type="radio" name="ICN2" <?php if (isset($VIT_ICN2) && $VIT_ICN2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN2();" value="1" id="yesCheckICN2">Yes
<input type="radio" name="ICN2" <?php if (isset($VIT_ICN2) && $VIT_ICN2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN2();" value="0" id="noCheckICN2"><label for="No">No</label>
<input type="radio" name="ICN2" <?php if (isset($VIT_ICN2) && $VIT_ICN2=="N/A") { echo "checked"; } ?> value="N/A" >N/A
</p>

<div class="phpcomments"><?php if(isset($VIT_C_ICN2)) { echo $VIT_C_ICN2; } ?></div>

<p>
<label for="ICN3">Q<?php $i++; echo $i; ?>. Did the lv_audit_closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label><br>
<input type="radio" name="ICN3" <?php if (isset($VIT_ICN3) && $VIT_ICN3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN3();" value="1" id="yesCheckICN3">Yes
<input type="radio" name="ICN3" <?php if (isset($VIT_ICN3) && $VIT_ICN3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN3();" value="0" id="noCheckICN3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_C_ICN3)) { echo $VIT_C_ICN3; } ?></div>

<p>
<label for="ICN4">Q<?php $i++; echo $i; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label><br>
<select class="form-control" name="ICN4" onclick="javascript:yesnoCheckICN4();">
  <option value="0" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='0') { echo "selected"; } } ?>>Select...</option>
  <option value="1" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='More than sufficient') { echo "selected"; } } ?>>More than sufficient</option>
  <option value="2" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Sufficient') { echo "selected"; } } ?>>Sufficient</option>
  <option value="3" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Adequate') { echo "selected"; } } ?>>Adequate</option>
  <option value="4" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Poor') { echo "selected"; } } ?> onclick="javascript:yesnoCheckICN4a();" id="yesCheckICN4">Poor</option>
</select>
</p>
<div class="phpcomments"><?php if(isset($VIT_C_ICN4)) { echo $VIT_C_ICN4; } ?></div>



<p>
<label for="ICN5">Q<?php $i++; echo $i; ?>. Closer confirmed this policy will be set up with Vitality?</label><br>
<input type="radio" name="ICN5" <?php if (isset($VIT_ICN5) && $VIT_ICN5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN5();" value="1" id="yesCheckICN5">Yes
<input type="radio" name="ICN5" <?php if (isset($VIT_ICN5) && $VIT_ICN5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN5();" value="0" id="noCheckICN5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_C_ICN5)) { echo $VIT_C_ICN5; } ?></div>

<h3 class="panel-title">Eligibility</h3>

<p>
    <label for="E1">Q<?php $i++; echo $i; ?>. Important customer information declaration?</label><br>
<input type="radio" name="E1" <?php if (isset($VIT_CM_E1) && $VIT_CM_E1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="1" id="yesCheckET1">Yes
<input type="radio" name="E1" <?php if (isset($VIT_CM_E1) && $VIT_CM_E1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="0" id="noCheckET1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_E1)) { echo $VIT_CE_E1; } ?></div>


<p>
<label for="E2">Q<?php $i++; echo $i; ?>. Were all clients contact details recorded correctly?</label><br>
<input type="radio" name="E2" <?php if (isset($VIT_CM_E2) && $VIT_CM_E2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="1" id="yesCheckET2">Yes
<input type="radio" name="E2" <?php if (isset($VIT_CM_E2) && $VIT_CM_E2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="0" id="noCheckET2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_E2)) { echo $VIT_CE_E2; } ?></div>


<p>
<label for="E3">Q<?php $i++; echo $i; ?>. Were all clients address details recorded correctly?</label><br>
<input type="radio" name="E3" <?php if (isset($VIT_CM_E3) && $VIT_CM_E3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="1" id="yesCheckET3">Yes
<input type="radio" name="E3" <?php if (isset($VIT_CM_E3) && $VIT_CM_E3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="0" id="noCheckET3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_E3)) { echo $VIT_CE_E3; } ?></div>


<p>
<label for="E4">Q<?php $i++; echo $i; ?>. Were all the doctors details recorded correctly?</label><br>
<input type="radio" name="E4" <?php if (isset($VIT_CM_E4) && $VIT_CM_E4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="1" id="yesCheckET4">Yes
<input type="radio" name="E4" <?php if (isset($VIT_CM_E4) && $VIT_CM_E4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="0" id="noCheckET4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_E4)) { echo $VIT_CE_E4; } ?></div>

<p>
<label for="E5">Q<?php $i++; echo "$i"; ?>. Were term for term details recorded correctly?</label><br>
<select class="form-control" name="E5" >
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='0') { echo "selected"; } ?> value="0">Select...</option>
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Client provided details') { echo "selected"; } ?> value="1">Client Provided Details</option>
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Client failed to provide details') { echo "selected"; } ?> value="2">Client failed to provide details</option>
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Not existing Vitality customer') { echo "selected"; } ?> value="3"><label for="No">No</label>Not existing Vitality customer</option>
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Obtained from Term4Term service') { echo "selected"; } ?> value="4">Obtained from Term4Term service</option>
  <option <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Existing Vitality Policy, no attempt to get policy number') { echo "selected"; } ?> value="5">Existing Vitality Policy, no attempt to get policy number</option>
</select>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_E5)) { echo $VIT_CE_E5; } ?></div>

<h3 class="panel-title">Declarations of Insurance</h3>

<p>
    <label for="DI1">Q<?php $i++; echo $i; ?>. Customer declaration read out?</label><br>
<input type="radio" name="DI1" <?php if (isset($VIT_CM_DI1) && $VIT_CM_DI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDIT1();" value="1" id="yesCheckDIT1">Yes
<input type="radio" name="DI1" <?php if (isset($VIT_CM_DI1) && $VIT_CM_DI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDIT1();" value="0" id="noCheckDIT1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_DI1)) { echo $VIT_CE_DI1; } ?></div>


<p>
<label for="DI2">Q<?php $i++; echo $i; ?>. If appropriate did the CLOSER confirm the exclusions on the policy?</label><br>
<input type="radio" name="DI2" <?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDIT2();" value="1" id="yesCheckDIT2">Yes
<input type="radio" name="DI2" <?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDIT2();" value="0" id="noCheckDIT2"><label for="No">No</label>
<input type="radio" name="DI2" <?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2=="N/A") { echo "checked"; } ?> onclick="javascript:yesnoCheckDIT2();" value="N/A" id="noCheckDIT2">N/A
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_DI2)) { echo $VIT_CE_DI2; } ?></div>



<h3 class="panel-title">Payment Information</h3>

<p>
    <label for="PI1">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label><br>
<input type="radio" name="PI1" <?php if (isset($VIT_CM_PI1) && $VIT_CM_PI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="1" id="yesCheckPIT1">Yes
<input type="radio" name="PI1" <?php if (isset($VIT_CM_PI1) && $VIT_CM_PI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="0" id="noCheckPIT1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_PI1)) { echo $VIT_CE_PI1; } ?></div>


<p>
<label for="PI2">Q<?php $i++; echo $i; ?>. Did the closer offer to read the direct debit guarantee?</label><br>
<input type="radio" name="PI2" <?php if (isset($VIT_CM_PI2) && $VIT_CM_PI2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="1" id="yesCheckPIT2">Yes
<input type="radio" name="PI2" <?php if (isset($VIT_CM_PI2) && $VIT_CM_PI2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="0" id="noCheckPIT2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_PI2)) { echo $VIT_CE_PI2; } ?></div>


<p>
<label for="PI3">Q<?php $i++; echo $i; ?>. Did the closer offer a preferred premium collection date?</label><br>
<input type="radio" name="PI3" <?php if (isset($VIT_CM_PI3) && $VIT_CM_PI3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="1" id="yesCheckPIT3">Yes
<input type="radio" name="PI3" <?php if (isset($VIT_CM_PI3) && $VIT_CM_PI3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="0" id="noCheckPIT3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_PI3)) { echo $VIT_CE_PI3; } ?></div>


<p>
<label for="PI4">Q<?php $i++; echo $i; ?>. Did the closer record the bank details correctly?</label><br>
<input type="radio" name="PI4" <?php if (isset($VIT_CM_PI4) && $VIT_CM_PI4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="1" id="yesCheckPIT4">Yes
<input type="radio" name="PI4" <?php if (isset($VIT_CM_PI4) && $VIT_CM_PI4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="0" id="noCheckPIT4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_PI4)) { echo $VIT_CE_PI4; } ?></div>


<p>
<label for="PI5">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label><br>
<input type="radio" name="PI5" <?php if (isset($VIT_CM_PI5) && $VIT_CM_PI5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="1" id="yesCheckPIT5">Yes
<input type="radio" name="PI5" <?php if (isset($VIT_CM_PI5) && $VIT_CM_PI5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="0" id="noCheckPIT5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_PI5)) { echo $VIT_CE_PI5; } ?></div>





<h3 class="panel-title">Consolidation Declaration</h3>

<p>
    <label for="CDE1">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label><br>
<input type="radio" name="CDE1" <?php if (isset($VIT_CM_CD1) && $VIT_CM_CD1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="1" id="yesCheckCDET1">Yes
<input type="radio" name="CDE1" <?php if (isset($VIT_CM_CD1) && $VIT_CM_CD1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="0" id="noCheckCDET1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD1)) { echo $VIT_CE_CD1; } ?></div>



<p>
<label for="CDE2">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label><br>
<input type="radio" name="CDE2" <?php if (isset($VIT_CM_CD2) && $VIT_CM_CD2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="1" id="yesCheckCDET2">Yes
<input type="radio" name="CDE2" <?php if (isset($VIT_CM_CD2) && $VIT_CM_CD2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="0" id="noCheckCDET2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD2)) { echo $VIT_CE_CD2; } ?></div>


<p>
<label for="CDE3">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label><br>
<input type="radio" name="CDE3" <?php if (isset($VIT_CM_CD3) && $VIT_CM_CD3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="1" id="yesCheckCDET3">Yes
<input type="radio" name="CDE3" <?php if (isset($VIT_CM_CD3) && $VIT_CM_CD3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="0" id="noCheckCDET3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD3)) { echo $VIT_CE_CD3; } ?></div>


<p>
<label for="CDE4">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>
<input type="radio" name="CDE4" <?php if (isset($VIT_CM_CD4) && $VIT_CM_CD4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="1" id="yesCheckCDET4">Yes
<input type="radio" name="CDE4" <?php if (isset($VIT_CM_CD4) && $VIT_CM_CD4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="0" id="noCheckCDET4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD4)) { echo $VIT_CE_CD4; } ?></div>

<p>
<label for="CDE6">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label><br>
<input type="radio" name="CDE6" <?php if (isset($VIT_CM_CD6) && $VIT_CM_CD6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="1" id="yesCheckCDET6">Yes
<input type="radio" name="CDE6" <?php if (isset($VIT_CM_CD6) && $VIT_CM_CD6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="0" id="noCheckCDET6"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD6)) { echo $VIT_CE_CD6; } ?></div>



<p>
<label for="CDE7">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Vitality will write to them with a more specific date?</label><br>
<input type="radio" name="CDE7" <?php if (isset($VIT_CM_CD7) && $VIT_CM_CD7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="1" id="yesCheckCDET7">Yes
<input type="radio" name="CDE7" <?php if (isset($VIT_CM_CD7) && $VIT_CM_CD7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="0" id="noCheckCDET7"><label for="No">No</label>

</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD7)) { echo $VIT_CE_CD7; } ?></div>


<p>
<label for="CDE8">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label><br>
<input type="radio" name="CDE8" <?php if (isset($VIT_CM_CD8) && $VIT_CM_CD8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="1" id="yesCheckCDET8">Yes
<input type="radio" name="CDE8" <?php if (isset($VIT_CM_CD8) && $VIT_CM_CD8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="0" id="noCheckCDET8"><label for="No">No</label>
<input type="radio" name="CDE8" <?php if (isset($VIT_CM_CD8) && $VIT_CM_CD8=="N/A") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="N/A" id="yesCheckCDET8">N/A
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_CD8)) { echo $VIT_CE_CD8; } ?></div>

 <h3 class="panel-title">Quality Control</h3>
 
 <p>
     <label for="QC1">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Vitality with client information?</label><br>
<input type="radio" name="QC1" <?php if (isset($VIT_CM_QC1) && $VIT_CM_QC1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="1" id="yesCheckQCT1">Yes
<input type="radio" name="QC1" <?php if (isset($VIT_CM_QC1) && $VIT_CM_QC1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="0" id="noCheckQCT1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC1)) { echo $VIT_CE_QC1; } ?></div>


<p>
<label for="QC2">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label><br>
<input type="radio" name="QC2" <?php if (isset($VIT_CM_QC2) && $VIT_CM_QC2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="1" id="yesCheckQCT2">Yes
<input type="radio" name="QC2" <?php if (isset($VIT_CM_QC2) && $VIT_CM_QC2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="0" id="noCheckQCT2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC2)) { echo $VIT_CE_QC2; } ?></div>


<p>
<label for="QC3">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label><br>
<input type="radio" name="QC3" <?php if (isset($VIT_CM_QC3) && $VIT_CM_QC3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="1" id="yesCheckQCT3">Yes
<input type="radio" name="QC3" <?php if (isset($VIT_CM_QC3) && $VIT_CM_QC3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="0" id="noCheckQCT3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC3)) { echo $VIT_CE_QC3; } ?></div>


<p>
<label for="QC4">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label><br>
<input type="radio" name="QC4" <?php if (isset($VIT_CM_QC4) && $VIT_CM_QC4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="1" id="yesCheckQCT4">Yes
<input type="radio" name="QC4" <?php if (isset($VIT_CM_QC4) && $VIT_CM_QC4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="0" id="noCheckQCT4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC4)) { echo $VIT_CE_QC4; } ?></div>


<p>
<label for="QC5">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label><br>
<input type="radio" name="QC5" <?php if (isset($VIT_CM_QC5) && $VIT_CM_QC5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="1" id="yesCheckQCT5">Yes
<input type="radio" name="QC5" <?php if (isset($VIT_CM_QC5) && $VIT_CM_QC5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="0" id="noCheckQCT5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC5)) { echo $VIT_CE_QC5; } ?></div>


<p>
<label for="QC6">Q<?php $i++; echo $i; ?>. Closer provided contact details for First Priority Group?</label><br>
<input type="radio" name="QC6" <?php if (isset($VIT_CM_QC6) && $VIT_CM_QC6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="1" id="yesCheckQCT6">Yes
<input type="radio" name="QC6" <?php if (isset($VIT_CM_QC6) && $VIT_CM_QC6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="0" id="noCheckQCT6"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC6)) { echo $VIT_CE_QC6; } ?></div>


<p>
<label for="QC7">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label><br>
<input type="radio" name="QC7" <?php if (isset($VIT_CM_QC7) && $VIT_CM_QC7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="1" id="yesCheckQCT7">Yes
<input type="radio" name="QC7" <?php if (isset($VIT_CM_QC7) && $VIT_CM_QC7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="0" id="noCheckQCT7"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($VIT_CE_QC7)) { echo $VIT_CE_QC7; } ?></div>



       </div>
</div>
    
</html>