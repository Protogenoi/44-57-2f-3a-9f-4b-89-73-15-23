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
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);  

if(isset($EXECUTE)) {
    if($EXECUTE=='EDIT') {
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
                                            lv_questions_extra_cd5,
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
    if(isset($VIT_CM_AUDIT['lv_questions_extra_cd5'])) {
       $VIT_CM_CD5=$VIT_CM_AUDIT['lv_questions_extra_cd5']; 
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
                            lv_comments_od1,                                            
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
        $VIT_C_H1=$VIT_C_COM_AUDIT['lv_comments_h1'];
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
    if(isset($VIT_C_COM_AUDIT['lv_comments_l5'])) {
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
                                            lv_comments_extra_cd5,
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
    if(isset($VIT_CE_AUDIT['lv_comments_extra_cd5'])) {
       $VIT_CE_CD5=$VIT_CE_AUDIT['lv_comments_extra_cd5']; 
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

$QUESTION_NUMBER=1;
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Edit LV Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/audit_layout.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
    <script>
        function textAreaAdjust(o) {
         o.style.height = "1px";
         o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>

<?php require_once(__DIR__ . '/../../../app/Holidays.php'); ?>
</head>
<body>

<?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>    
    
       <div class="container">

        <form action="php/Audit.php?EXECUTE=2&AID=<?php if(isset($AUDITID)) { echo $AUDITID; }?>" method="POST" id="AUDIT_FORM" name="AUDIT_FORM" autocomplete="off">

            <fieldset>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> LV Closer Call Audit</h3>
                    </div>

                    <div class="panel-body">
                        <p>
                        <div class='form-group'>
                            <label for="closer">Closer:</label>
                                    <input type='text' id='CLOSER' name='CLOSER' class="form-control" value="<?php if(isset($VIT_CLOSER)) { echo $VIT_CLOSER; } ?>" style="width: 520px" required>
                                    <script>var options = {
                                            url: "/../../../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#CLOSER").easyAutocomplete(options);</script>

                            </select>
                        </div>

                        <label for="POLICY">Reference ID</label>
                        <input type="text" class="form-control" name="PLAN_NUMBER" style="width: 520px" value="<?php if(isset($VIT_PLAN_NUMBER)) { echo $VIT_PLAN_NUMBER; } ?>" >

                        </p>

                        <p>
                        <div class="form-group">
                            <label for='GRADE'>Grade:</label>
                            <select class="form-control" name="GRADE" required>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Saved') { echo "selected"; } ?> value="SAVED">Incomplete Audit (SAVE)</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Amber') { echo "selected"; } ?> value="Amber">Amber</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Red') { echo "selected"; } ?> value="Red">Red</option>
                            </select>
                        </div>
                        </p>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Opening Declaration</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <label for="OD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
                            <input type="radio" name="OD_Q1" <?php if(isset($VIT_OD1)) { if ($VIT_OD1 == "1") { echo "checked"; } } ?> value="1" id="yesCheckOD_C1" required >Yes
                            <input type="radio" name="OD_Q1" <?php if(isset($VIT_OD1)) { if ($VIT_OD1 == "0") { echo "checked"; } } ?> value="0" id="noCheckOD_C1">No
                        </p>

                            <textarea class="form-control"id="OD_C1" name="OD_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_OD1)) { echo $VIT_C_OD1; } ?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                       
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#OD_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q2" <?php if(isset($VIT_OD2)) { if ($VIT_OD2 == "1") { echo "checked"; } } ?> value="1" id="yesCheckOD_C2" required >Yes
                            <input type="radio" name="OD_Q2" <?php if(isset($VIT_OD2)) { if ($VIT_OD2 == "0") { echo "checked"; } } ?> value="0" id="noCheckOD_C2">No
                        </p>

                            <textarea class="form-control"id="OD_C2" name="OD_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_OD2)) { echo $VIT_C_OD2; } ?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#OD_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
                            <input type="radio" name="OD_Q3" <?php if (isset($VIT_OD3) && $VIT_OD3 == "1") { echo "checked"; } ?> value="1" id="yesCheckOD_C3" required >Yes
                            <input type="radio" name="OD_Q3" <?php if (isset($VIT_OD3) && $VIT_OD3 == "0") { echo "checked"; } ?> value="0" id="noCheckOD_C3">No
                        </p>

                            <textarea class="form-control"id="OD_C3" name="OD_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_OD3)) { echo $VIT_C_OD3; } ?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#OD_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER provide the name and details of the firm who is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q4"  <?php if (isset($VIT_OD4) && $VIT_OD4 == "1") { echo "checked"; } ?> value="1" id="yesCheckOD_C4" required >Yes
                            <input type="radio" name="OD_Q4" <?php if (isset($VIT_OD4) && $VIT_OD4 == "0") { echo "checked"; } ?> value="0" id="noCheckOD_C4">No
                        </p>

                            <textarea class="form-control"id="OD_C4" name="OD_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_OD4)) { echo $VIT_C_OD4; } ?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>

                        <script>
                            $(document).ready(function () {
                                $('#characterLeft4').text('500 characters left');
                                $('#OD_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft4').text('You have reached the limit');
                                        $('#characterLeft4').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft4').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft4').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
                            <input type="radio" name="OD_Q5" <?php if (isset($VIT_OD5) && $VIT_OD5 == "1") { echo "checked"; } ?> value="1" id="yesCheckOD_C5" required >Yes
                            <input type="radio" name="OD_Q5" <?php if (isset($VIT_OD5) && $VIT_OD5 == "0") { echo "checked"; } ?> value="0" id="noCheckOD_C5">No
                        </p>

                            <textarea class="form-control"id="OD_C5" name="OD_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_OD5)) { echo $VIT_C_OD5; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#OD_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="CI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients titles and names recorded correctly?</label>
                            <input type="radio" name="CI_Q1" <?php if (isset($VIT_CI1) && $VIT_CI1 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C1" required >Yes
                            <input type="radio" name="CI_Q1" <?php if (isset($VIT_CI1) && $VIT_CI1 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C1">No
                        </p>

                            <textarea class="form-control"id="CI_C1" name="CI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI1)) { echo $VIT_C_CI1; } ?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft6').text('500 characters left');
                                $('#CI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft6').text('You have reached the limit');
                                        $('#characterLeft6').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft6').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft6').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients gender accurately recorded?</label>
                            <input type="radio" name="CI_Q2" <?php if (isset($VIT_CI2) && $VIT_CI2 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C2" required >Yes
                            <input type="radio" name="CI_Q2" <?php if (isset($VIT_CI2) && $VIT_CI2 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C2">No
                        </p>

                            <textarea class="form-control"id="CI_C2" name="CI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI2)) { echo $VIT_C_CI2; } ?></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft7').text('500 characters left');
                                $('#CI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft7').text('You have reached the limit');
                                        $('#characterLeft7').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft7').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft7').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CI_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients date of birth accurately recorded?</label>
                            <input type="radio" name="CI_Q3" <?php if (isset($VIT_CI3) && $VIT_CI3 == "1") { echo "checked"; } ?> value="1" id="yesCheck" required >Yes
                            <input type="radio" name="CI_Q3" <?php if (isset($VIT_CI3) && $VIT_CI3 == "0") { echo "checked";} ?> value="0" id="noCheck">No
                        </p>
                            <textarea class="form-control"id="CI_C3" name="CI_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI3)) { echo $VIT_C_CI3; } ?></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft8').text('500 characters left');
                                $('#CI_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft8').text('You have reached the limit');
                                        $('#characterLeft8').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft8').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft8').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CI_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients smoking status recorded correctly?</label>
                            <input type="radio" name="CI_Q4" <?php if (isset($VIT_CI4) && $VIT_CI4 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C4" required >Yes
                            <input type="radio" name="CI_Q4" <?php if (isset($VIT_CI4) && $VIT_CI4 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C4">No
                        </p>
                            <textarea class="form-control"id="CI_C4" name="CI_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI4)) { echo $VIT_C_CI4; } ?></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft9').text('500 characters left');
                                $('#CI_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft9').text('You have reached the limit');
                                        $('#characterLeft9').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft9').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft9').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="CI_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients occupation recorded correctly?</label>
                            <input type="radio" name="CI_Q5" <?php if (isset($VIT_CI5) && $VIT_CI5 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C5" required >Yes
                            <input type="radio" name="CI_Q5" <?php if (isset($VIT_CI5) && $VIT_CI5 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C5">No
                        </p>

                            <textarea class="form-control"id="CI_C5" name="CI_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI5)) { echo $VIT_C_CI5; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft11').text('500 characters left');
                                $('#CI_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft11').text('You have reached the limit');
                                        $('#characterLeft11').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft11').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft11').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="CI_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question asked and recorded correctly about their living status in the UK?</label>
                            <input type="radio" name="CI_Q6" <?php if (isset($VIT_CI6) && $VIT_CI6 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C6" required >Yes
                            <input type="radio" name="CI_Q6" <?php if (isset($VIT_CI6) && $VIT_CI6 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C6">No
                        </p>

                            <textarea class="form-control"id="CI_C6" name="CI_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI6)) { echo $VIT_C_CI6; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft11').text('500 characters left');
                                $('#CI_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft11').text('You have reached the limit');
                                        $('#characterLeft11').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft11').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft11').removeClass('red');
                                    }
                                });
                            });
                        </script> 
                        
  <p>
                            <label for="CI_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm the policy was a single or a joint application?</label>
                            <input type="radio" name="CI_Q7" <?php if (isset($VIT_CI7) && $VIT_CI7 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C7" required >Yes
                            <input type="radio" name="CI_Q7" <?php if (isset($VIT_CI7) && $VIT_CI7 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C7">No
                        </p>

                            <textarea class="form-control"id="CI_C7" name="CI_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI7)) { echo $VIT_C_CI7; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft11').text('500 characters left');
                                $('#CI_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft11').text('You have reached the limit');
                                        $('#characterLeft11').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft11').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft11').removeClass('red');
                                    }
                                });
                            });
                        </script>                        
                      
                            <label for="CI_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have your natural parents, brothers, sisters had any of the ..[conditions] before the age of 60?" asked and recorded correctly?</label>
                            <input type="radio" name="CI_Q8" <?php if (isset($VIT_CI8) && $VIT_CI8 == "1") { echo "checked"; } ?> value="1" id="yesCheckCI_C8" required >Yes
                            <input type="radio" name="CI_Q8" <?php if (isset($VIT_CI8) && $VIT_CI8 == "0") { echo "checked"; } ?> value="0" id="noCheckCI_C8">No
                        </p>

                            <textarea class="form-control"id="CI_C8" name="CI_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_CI8)) { echo $VIT_C_CI8; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft11').text('500 characters left');
                                $('#CI_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft11').text('You have reached the limit');
                                        $('#characterLeft11').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft11').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft11').removeClass('red');
                                    }
                                });
                            });
                        </script>                           
                        
                    </div>
                </div>                
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Health</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="H_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for health condition in the last 5 years asked and recorded correctly?</label>
                            <input type="radio" name="H_Q1" <?php if (isset($VIT_H1) && $VIT_H1 == "1") { echo "checked"; } ?> value="1" id="yesCheckH_C1" required >Yes
                            <input type="radio" name="H_Q1" <?php if(isset($VIT_H1)) {  if ($VIT_H1 == "0") { echo "checked"; } } ?> value="0" id="noCheckH_C1">No
                        </p>

                            <textarea class="form-control"id="H_C1" name="H_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_H1)) { echo $VIT_C_H1; } ?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#H_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="H_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for other health conditions in the last 2 years asked and recorded correctly?</label>
                            <input type="radio" name="H_Q2" <?php if (isset($VIT_H2) && $VIT_H2 == "1") { echo "checked"; } ?> value="1" id="yesCheckH_C2" required >Yes
                            <input type="radio" name="H_Q2" <?php if (isset($VIT_H2) && $VIT_H2 == "0") { echo "checked"; } ?> value="0" id="noCheckH_C2">No
                        </p>

                            <textarea class="form-control"id="H_C2" name="H_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_H2)) { echo $VIT_C_H2; } ?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#H_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="H_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for other health conditions in the last 3 months asked and recorded correctly?</label>
                            <input type="radio" name="H_Q3" <?php if (isset($VIT_H3) && $VIT_H3 == "1") { echo "checked"; } ?> value="1" id="yesCheckH_C3" required >Yes
                            <input type="radio" name="H_Q3" <?php if (isset($VIT_H3) && $VIT_H3 == "0") { echo "checked"; } ?> value="0" id="noCheckH_C3">No
                        </p>

                            <textarea class="form-control"id="H_C3" name="H_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_H3)) { echo $VIT_C_H3; } ?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>

                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#H_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>                    
                        
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Life Style</h3>
                    </div>
                    <div class="panel-body">

                        <p>
                            <label for="L_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question about hazardous pastimes/activities (motorbike/aviation/motor sport) asked and recorded correctly?</label>
                            <input type="radio" name="L_Q1" <?php if (isset($VIT_L1) && $VIT_L1 == "1") { echo "checked"; } ?> value="1" id="yesCheckL_C1" required >Yes
                            <input type="radio" name="L_Q1" <?php if (isset($VIT_L1) && $VIT_L1 == "0") { echo "checked"; } ?> value="0" id="noCheckL_C1">No
                        </p>

                            <textarea class="form-control"id="L_C1" name="L_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L1)) { echo $VIT_C_L1; } ?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#L_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="L_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have you been banned from driving or convicted of dangerous or careless driving the last 5 years?" asked and recorded correctly?</label>
                            <input type="radio" name="L_Q2" 
<?php if (isset($VIT_L2) && $VIT_L2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C2" required >Yes
                            <input type="radio" name="L_Q2"
<?php if (isset($VIT_L2) && $VIT_L2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C2">No
                        </p>

                            <textarea class="form-control"id="L_C2" name="L_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L2)) { echo $VIT_C_L2; } ?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#L_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="L_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "In the last 5 years have you lived, worked or travelled outside of the UK or European Union?" asked and recorded correctly?</label>
                            <input type="radio" name="L_Q3" 
<?php if (isset($VIT_L3) && $VIT_L3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C3" required >Yes
                            <input type="radio" name="L_Q3"
<?php if (isset($VIT_L3) && $VIT_L3 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C3">No
                        </p>

                            <textarea class="form-control"id="L_C3" name="L_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L3)) { echo $VIT_C_L3; } ?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#L_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="L_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "...will the total amount of cover ..exceed £1m life cover or £500k CIC" asked recorded correctly?</label>
                            <input type="radio" name="L_Q4" 
<?php if (isset($VIT_L4) && $VIT_L4 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C4" required >Yes
                            <input type="radio" name="L_Q4"
<?php if (isset($VIT_L4) && $VIT_L4 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C4">No
                        </p>

                            <textarea class="form-control"id="L_C4" name="L_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L4)) { echo $VIT_C_L4; } ?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft4').text('500 characters left');
                                $('#L_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft4').text('You have reached the limit');
                                        $('#characterLeft4').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft4').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft4').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="L_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Was the alcohol questions asked and recorded correctly?</label>
                            <input type="radio" name="L_Q5" 
<?php if (isset($VIT_L5) && $VIT_L5 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C5" required >Yes
                            <input type="radio" name="L_Q5"
<?php if (isset($VIT_L5) && $VIT_L5 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C5">No
                        </p>

                            <textarea class="form-control"id="L_C5" name="L_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L5)) { echo $VIT_C_L5; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#L_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
   
<p>
                            <label for="L_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "..advised to reduce or stop your alcohol consumption.." asked and recorded correctly?</label>
                            <input type="radio" name="L_Q6" 
<?php if (isset($VIT_L6) && $VIT_L6 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C6" required >Yes
                            <input type="radio" name="L_Q6"
<?php if (isset($VIT_L6) && $VIT_L6 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C6">No
                        </p>

                            <textarea class="form-control"id="L_C6" name="L_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L6)) { echo $VIT_C_L6; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#L_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                     
<p>
                            <label for="L_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have you used recreational drugs in the last 10 years" asked and recorded correctly?</label>
                            <input type="radio" name="L_Q7" 
<?php if (isset($VIT_L7) && $VIT_L7 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C7" required >Yes
                            <input type="radio" name="L_Q7"
<?php if (isset($VIT_L7) && $VIT_L7 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C7">No
                        </p>
                            <textarea class="form-control"id="L_C7" name="L_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L7)) { echo $VIT_C_L7; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#L_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>           
 <p>
                            <label for="L_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Does you job involve any of the following duties or working environments?" asked and recorded correctly?</label>
                            <input type="radio" name="L_Q8" 
<?php if (isset($VIT_L8) && $VIT_L8 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckL_C8" required >Yes
                            <input type="radio" name="L_Q8"
<?php if (isset($VIT_L8) && $VIT_L8 == "0") {
    echo "checked";
} ?> value="0" id="noCheckL_C8">No
                        </p>

                            <textarea class="form-control"id="L_C8" name="L_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_L8)) { echo $VIT_C_L8; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#L_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>                        
                        
                    </div>
                </div>
                
                
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Identifying Clients Needs</h3>
                    </div>
                        <div class="panel-body">
                            
                        <p>
                            <label for="ICN_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER check all details of what the client has with their existing life insurance policy?</label>
                            <input type="radio" name="ICN_Q1" 
                                   <?php if (isset($VIT_ICN1) && $VIT_ICN1 == "1") {
                                       echo "checked";
                                   } ?> value="1" id="yesCheckICN_C1" required >Yes
                            <input type="radio" name="ICN_Q1"
<?php if (isset($VIT_ICN1) && $VIT_ICN1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckICN_C1">No
                        </p>

                            <textarea class="form-control"id="ICN_C1" name="ICN_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_ICN1)) { echo $VIT_C_ICN1; } ?></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft12').text('500 characters left');
                                $('#ICN_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft12').text('You have reached the limit');
                                        $('#characterLeft12').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft12').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft12').removeClass('red');
                                    }
                                });
                            });
                        </script>
                  
                        <p>
                            <label for="ICN_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER mention waiver, indexation, or TPD?</label>
                            <input type="radio" name="ICN_Q2" <?php if (isset($VIT_ICN2) && $VIT_ICN2 == "1") { echo "checked"; } ?> value="1" id="yesCheckICN_C2" required >Yes
                            <input type="radio" name="ICN_Q2" <?php if (isset($VIT_ICN2) && $VIT_ICN2 == "0") { echo "checked"; } ?> value="0" id="noCheckICN_C2">No
                            <input type="radio" name="ICN_Q2" <?php if (isset($VIT_ICN2) && $VIT_ICN2 == 'N/A') { echo "checked"; } ?> value="N/A" >N/A
                        </p>

                            <textarea class="form-control"id="ICN_C2" name="ICN_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_ICN2)) { echo $VIT_C_ICN2; } ?></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft13').text('500 characters left');
                                $('#ICN_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft13').text('You have reached the limit');
                                        $('#characterLeft13').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft13').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft13').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="ICN_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
                            <input type="radio" name="ICN_Q3" 
<?php if (isset($VIT_ICN3) && $VIT_ICN3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckICN_C3" required >Yes
                            <input type="radio" name="ICN_Q3"
<?php if (isset($VIT_ICN3) && $VIT_ICN3 == "0") {
    echo "checked";
} ?> value="0" id="noCheckICN_C3">No
                        </p>

                            <textarea class="form-control"id="ICN_C3" name="ICN_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_ICN3)) { echo $VIT_C_ICN3; } ?></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft14').text('500 characters left');
                                $('#ICN_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft14').text('You have reached the limit');
                                        $('#characterLeft14').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft14').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft14').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="ICN_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label>
                            <select class="form-control" name="ICN_Q4" onclick="javascript:yesnoCheckICN_C4();">
                                <option value="N/A">Select...</option>
                                <option value="More than sufficient" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='More than sufficient') { echo "selected"; } } ?>>More than sufficient</option>
                                <option value="Sufficient" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Sufficient') { echo "selected"; } } ?>>Sufficient</option>
                                <option value="Adaquate" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Adaquate') { echo "selected"; } } ?>>Adequate</option>
                                <option value="Poor" <?php if(isset($VIT_ICN4)) { if($VIT_ICN4=='Poor') { echo "selected"; } } ?> onclick="javascript:yesnoCheckICN_C4a();" id="yesCheckICN_C4">Poor</option>
                            </select>
                        </p>

                            <textarea class="form-control"id="ICN_C4" name="ICN_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_ICN4)) { echo $VIT_C_ICN4; } ?></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft15').text('500 characters left');
                                $('#ICN_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft15').text('You have reached the limit');
                                        $('#characterLeft15').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft15').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft15').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="ICN_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed this policy will be set up with LV?</label>
                            <input type="radio" name="ICN_Q5" 
<?php if (isset($VIT_ICN5) && $VIT_ICN5 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckICN_C5" required >Yes
                            <input type="radio" name="ICN_Q5"
<?php if (isset($VIT_ICN5) && $VIT_ICN5 == "0") {
    echo "checked";
} ?> value="0" id="noCheckICN_C5">No
                        </p>

                            <textarea class="form-control"id="ICN_C5" name="ICN_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_C_ICN5)) { echo $VIT_C_ICN5; } ?></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft16').text('500 characters left');
                                $('#ICN_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft16').text('You have reached the limit');
                                        $('#characterLeft16').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft16').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft16').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Eligibility</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="E_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Important customer information declaration?</label>
                            <input type="radio" name="E_Q1" 
<?php if (isset($VIT_CM_E1) && $VIT_CM_E1 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckE_C1" required >Yes
                            <input type="radio" name="E_Q1"
<?php if (isset($VIT_CM_E1) && $VIT_CM_E1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckE_C1">No
                        </p>

                            <textarea class="form-control"id="E_C1" name="E_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_E1)) { echo $VIT_CE_E1; } ?></textarea><span class="help-block"><p id="characterLeft19" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft19').text('500 characters left');
                                $('#E_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft19').text('You have reached the limit');
                                        $('#characterLeft19').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft19').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft19').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="E_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients contact details recorded correctly?</label>
                            <input type="radio" name="E_Q2" 
<?php if (isset($VIT_CM_E2) && $VIT_CM_E2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckE_C2" required >Yes
                            <input type="radio" name="E_Q2"
<?php if (isset($VIT_CM_E2) && $VIT_CM_E2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckE_C2">No
                        </p>

                            <textarea class="form-control"id="E_C2" name="E_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_E2)) { echo $VIT_CE_E2; } ?></textarea><span class="help-block"><p id="characterLeft18" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft18').text('500 characters left');
                                $('#E_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft18').text('You have reached the limit');
                                        $('#characterLeft18').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft18').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft18').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="E_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients address details recorded correctly?</label>
                            <input type="radio" name="E_Q3" 
<?php if (isset($VIT_CM_E3) && $VIT_CM_E3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckE_C3" required >Yes
                            <input type="radio" name="E_Q3"
<?php if (isset($VIT_CM_E3) && $VIT_CM_E3 == "0") {
    echo "checked";
} ?> value="0" id="noCheckE_C3">No
                        </p>

                            <textarea class="form-control"id="E_C3" name="E_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_E3)) { echo $VIT_CE_E3; } ?></textarea><span class="help-block"><p id="characterLeft17" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft17').text('500 characters left');
                                $('#E_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft17').text('You have reached the limit');
                                        $('#characterLeft17').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft17').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft17').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="E_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Were all doctors details recorded correctly?</label>
                            <input type="radio" name="E_Q4" 
<?php if (isset($VIT_CM_E4) && $VIT_CM_E4 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckE_C4" required >Yes
                            <input type="radio" name="E_Q4"
<?php if (isset($VIT_CM_E4) && $VIT_CM_E4 == "0") {
    echo "checked";
} ?> value="0" id="noCheckE_C4">No
                            <input type="radio" name="E_Q4"
<?php if (isset($VIT_CM_E4) && $VIT_CM_E4 == "N/A") {
    echo "checked";
} ?> value="N/A" id="noCheckE_C4">N/A                            
                        </p>

                            <textarea class="form-control"id="E_C4" name="E_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_E4)) { echo $VIT_CE_E4; } ?></textarea><span class="help-block"><p id="characterLeft20" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft20').text('500 characters left');
                                $('#E_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft20').text('You have reached the limit');
                                        $('#characterLeft20').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft20').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft20').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p
                            
                       <p>
                            <label for="E_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Were term for term details recorded correctly?</label>
                            <select class="form-control" name="E_Q5" >
                                <option value="N/A">Select...</option>
                                <option value="Client provided details" <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Client provided details') { echo "selected"; } ?>>Client Provided Details</option>
                                <option value="Client failed to provide details" <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Client failed to provide details') { echo "selected"; } ?>>Client failed to provide details</option>
                                <option value="Not existing LV customer" <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Not existing LV customer') { echo "selected"; } ?>>Not existing legal and general customer</option>
                                <option value="Obtained from Term4Term service" <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Obtained from Term4Term service') { echo "selected"; } ?>>Obtained from Term4Term service</option>
                                <option value="Existing LV Policy, no attempt to get policy number" <?php if(isset($VIT_CM_E5) && $VIT_CM_E5=='Existing LV Policy, no attempt to get policy number') { echo "selected"; } ?>>Existing LV Policy, no attempt to get policy number</option>
                            </select>
                        </p>

                        <textarea class="form-control"id="E_C5" name="E_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_E5)) { echo $VIT_CE_E5; } ?></textarea><span class="help-block"><p id="characterLeft32" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft32').text('500 characters left');
                                $('#E_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft32').text('You have reached the limit');
                                        $('#characterLeft32').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft32').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft32').removeClass('red');
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Declarations of Insurance</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="DI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Customer declaration read out?</label>
                            <input type="radio" name="DI_Q1" 
<?php if (isset($VIT_CM_DI1) && $VIT_CM_DI1 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckDI_C1" required >Yes
                            <input type="radio" name="DI_Q1"
<?php if (isset($VIT_CM_DI1) && $VIT_CM_DI1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckDI_C1">No
                        </p>

                        <textarea class="form-control"id="DI_C1" name="DI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_DI1)) { echo $VIT_CE_DI1; } ?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft34').text('500 characters left');
                                $('#DI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft34').text('You have reached the limit');
                                        $('#characterLeft34').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft34').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft34').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="DI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. If appropriate did the CLOSER confirm the exclusions on the policy?</label>
                            <input type="radio" name="DI_Q2" 
<?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckDI_C2" required >Yes
                            <input type="radio" name="DI_Q2"
<?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckDI_C2">No
                            <input type="radio" name="DI_Q2" 
<?php if (isset($VIT_CM_DI2) && $VIT_CM_DI2 == "N/A") {
    echo "checked";
} ?> value="N/A" >N/A
                        </p>

                            <textarea class="form-control"id="DI_C2" name="DI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_DI2)) { echo $VIT_CE_DI2; } ?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft35').text('500 characters left');
                                $('#DI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft35').text('You have reached the limit');
                                        $('#characterLeft35').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft35').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft35').removeClass('red');
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="PI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients policy start date accurately recorded?</label>
                            <input type="radio" name="PI_Q1" 
                                   <?php if (isset($VIT_CM_PI1) && $VIT_CM_PI1 == "1") {
                                       echo "checked";
                                   } ?> value="1" id="yesCheckPI_C1" required >Yes
                            <input type="radio" name="PI_Q1"
<?php if (isset($VIT_CM_PI1) && $VIT_CM_PI1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckPI_C1">No
                        </p>

                            <textarea class="form-control"id="PI_C1" name="PI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_PI1)) { echo $VIT_CE_PI1; } ?></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft36').text('500 characters left');
                                $('#PI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft36').text('You have reached the limit');
                                        $('#characterLeft36').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft36').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft36').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="PI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer to read the direct debit guarantee?</label>
                            <input type="radio" name="PI_Q2" 
<?php if (isset($VIT_CM_PI2) && $VIT_CM_PI2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckPI_C2" required >Yes
                            <input type="radio" name="PI_Q2"
<?php if (isset($VIT_CM_PI2) && $VIT_CM_PI2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckPI_C2">No
                        </p>

                            <textarea class="form-control"id="PI_C2" name="PI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_PI2)) { echo $VIT_CE_PI2; } ?></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft37').text('500 characters left');
                                $('#PI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft37').text('You have reached the limit');
                                        $('#characterLeft37').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft37').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft37').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="PI_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer a preferred premium collection date?</label>
                            <input type="radio" name="PI_Q3" 
<?php if (isset($VIT_CM_PI3) && $VIT_CM_PI3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckPI_C3" required >Yes
                            <input type="radio" name="PI_Q3"
                                   <?php if (isset($VIT_CM_PI3) && $VIT_CM_PI3 == "0") {
                                       echo "checked";
                                   } ?> value="0" id="noCheckPI_C3">No
                        </p>

                            <textarea class="form-control"id="PI_C3" name="PI_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_PI3)) { echo $VIT_CE_PI3; } ?></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft38').text('500 characters left');
                                $('#PI_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft38').text('You have reached the limit');
                                        $('#characterLeft38').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft38').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft38').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="PI_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER record the bank details correctly?</label>
                            <input type="radio" name="PI_Q4" 
<?php if (isset($VIT_CM_PI4) && $VIT_CM_PI4 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckPI_C4" required >Yes
                            <input type="radio" name="PI_Q4"
                                   <?php if (isset($VIT_CM_PI4) && $VIT_CM_PI4 == "0") {
                                       echo "checked";
                                   } ?> value="0" id="noCheckPI_C4">No
                        </p>

                            <textarea class="form-control"id="PI_C4" name="PI_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_PI4)) { echo $VIT_CE_PI4; } ?></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft39').text('500 characters left');
                                $('#PI_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft39').text('You have reached the limit');
                                        $('#characterLeft39').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft39').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft39').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="PI_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did they have consent off the premium payer?</label>
                            <input type="radio" name="PI_Q5" 
                                   <?php if (isset($VIT_CM_PI5) && $VIT_CM_PI5 == "1") {
                                       echo "checked";
                                   } ?> value="1" id="yesCheckPI_C5" required >Yes
                            <input type="radio" name="PI_Q5"
<?php if (isset($VIT_CM_PI5) && $VIT_CM_PI5 == "0") {
    echo "checked";
} ?> value="0" id="noCheckPI_C5">No
                        </p>

                            <textarea class="form-control"id="PI_C5" name="PI_C5" rows="1" cols="75" maxlength="1500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_PI5)) { echo $VIT_CE_PI5; } ?></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft40').text('500 characters left');
                                $('#PI_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft40').text('You have reached the limit');
                                        $('#characterLeft40').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft40').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft40').removeClass('red');
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Consolidation Declaration</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="CD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                            <input type="radio" name="CD_Q1" 
<?php if (isset($VIT_CM_CD1) && $VIT_CM_CD1 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckCD_C1" required >Yes
                            <input type="radio" name="CD_Q1"
<?php if (isset($VIT_CM_CD1) && $VIT_CM_CD1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C1">No
                        </p>

                            <textarea class="form-control"id="CD_C1" name="CD_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD1)) { echo $VIT_CE_CD1; } ?></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft41').text('500 characters left');
                                $('#CD_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft41').text('You have reached the limit');
                                        $('#characterLeft41').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft41').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft41').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                            <input type="radio" name="CD_Q2" 
<?php if (isset($VIT_CM_CD2) && $VIT_CM_CD2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckCD_C2" required >Yes
                            <input type="radio" name="CD_Q2"
<?php if (isset($VIT_CM_CD2) && $VIT_CM_CD2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C2">No
                        </p>

                            <textarea class="form-control"id="CD_C2" name="CD_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD2)) { echo $VIT_CE_CD2; } ?></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft42').text('500 characters left');
                                $('#CD_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft42').text('You have reached the limit');
                                        $('#characterLeft42').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft42').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft42').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Like mentioned earlier did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                            <input type="radio" name="CD_Q3" 
<?php if (isset($VIT_CM_CD3) && $VIT_CM_CD3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckCD_C3" required >Yes
                            <input type="radio" name="CD_Q3"
<?php if (isset($VIT_CM_CD3) && $VIT_CM_CD3 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C3">No
                        </p>

                            <textarea class="form-control"id="CD_C3" name="CD_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD3)) { echo $VIT_CE_CD3; } ?></textarea><span class="help-block"><p id="characterLeft43" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft43').text('500 characters left');
                                $('#CD_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft43').text('You have reached the limit');
                                        $('#characterLeft43').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft43').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft43').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
                            <input type="radio" name="CD_Q4" 
<?php if (isset($VIT_CM_CD4) && $VIT_CM_CD4 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckCD_C4" required >Yes
                            <input type="radio" name="CD_Q4"
<?php if (isset($VIT_CM_CD4) && $VIT_CM_CD4 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C4">No
                        </p>

                            <textarea class="form-control"id="CD_C4" name="CD_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD4)) { echo $VIT_CE_CD4; } ?></textarea><span class="help-block"><p id="characterLeft44" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft44').text('500 characters left');
                                $('#CD_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft44').text('You have reached the limit');
                                        $('#characterLeft44').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft44').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft44').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the check your details procedure?</label>
                            <input type="radio" name="CD_Q5" 
<?php if (isset($VIT_CM_CD5) && $VIT_CM_CD5 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckCD_C5" required >Yes
                            <input type="radio" name="CD_Q5"
<?php if (isset($VIT_CM_CD5) && $VIT_CM_CD5 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C5">No
                        </p>

                            <textarea class="form-control"id="CD_C5" name="CD_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD5)) { echo $VIT_CE_CD5; } ?></textarea><span class="help-block"><p id="characterLeft46" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft46').text('500 characters left');
                                $('#CD_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft46').text('You have reached the limit');
                                        $('#characterLeft46').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft46').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft46').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but LV will write to them with a more specific date?</label>
                            <input type="radio" name="CD_Q6" 
<?php if (isset($VIT_CM_CD6) && $VIT_CM_CD6 == "1") {
    echo "checked";
} ?>  value="1" id="yesCheckCD_C6" required >Yes
                            <input type="radio" name="CD_Q6"
<?php if (isset($VIT_CM_CD6) && $VIT_CM_CD6 == "0") {
    echo "checked";
} ?>  value="0" id="noCheckCD_C6">No

                        </p>

                            <textarea class="form-control"id="CD_C6" name="CD_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD6)) { echo $VIT_CE_CD6; } ?></textarea><span class="help-block"><p id="characterLeft47" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft47').text('500 characters left');
                                $('#CD_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft47').text('You have reached the limit');
                                        $('#characterLeft47').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft47').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft47').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="CD_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm to the customer to cancel any existing direct debit?</label>
                            <input type="radio" name="CD_Q7" 
<?php if (isset($VIT_CM_CD7) && $VIT_CM_CD7 == "1") {
    echo "checked";
} ?>  value="1" id="yesCheckCD_C7" required >Yes
                            <input type="radio" name="CD_Q7"
<?php if (isset($VIT_CM_CD7) && $VIT_CM_CD7 == "0") {
    echo "checked";
} ?> value="0" id="noCheckCD_C7">No
                            <input type="radio" name="CD_Q7" 
                                   <?php if (isset($VIT_CM_CD7) && $VIT_CM_CD7 == "N/A") {
                                       echo "checked";
                                   } ?> value="N/A" id="yesCheckCD_C7">N/A
                        </p>

                            <textarea class="form-control"id="CD_C7" name="CD_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_CD7)) { echo $VIT_CE_CD7; } ?></textarea><span class="help-block"><p id="characterLeft48" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft48').text('500 characters left');
                                $('#CD_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft48').text('You have reached the limit');
                                        $('#characterLeft48').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft48').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft48').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Quality Control</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="QC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with LV with client information?</label>
                            <input type="radio" name="QC_Q1" 
<?php if (isset($VIT_CM_QC1) && $VIT_CM_QC1 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_Q2" required >Yes
                            <input type="radio" name="QC_Q1"
<?php if (isset($VIT_CM_QC1) && $VIT_CM_QC1 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_Q2">No
                        </p>

                            <textarea class="form-control"id="QC_C1" name="QC_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC1)) { echo $VIT_CE_QC1; } ?></textarea><span class="help-block"><p id="characterLeft49" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft49').text('500 characters left');
                                $('#QC_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft49').text('You have reached the limit');
                                        $('#characterLeft49').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft49').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft49').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed length of policy in years with client confirmation?</label>
                            <input type="radio" name="QC_Q2" 
<?php if (isset($VIT_CM_QC2) && $VIT_CM_QC2 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C2" required >Yes
                            <input type="radio" name="QC_Q2"
<?php if (isset($VIT_CM_QC2) && $VIT_CM_QC2 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C2">No
                        </p>

                            <textarea class="form-control"id="QC_C2" name="QC_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC2)) { echo $VIT_CE_QC2; } ?></textarea><span class="help-block"><p id="characterLeft50" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft50').text('500 characters left');
                                $('#QC_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft50').text('You have reached the limit');
                                        $('#characterLeft50').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft50').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft50').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
                            <input type="radio" name="QC_Q3" 
<?php if (isset($VIT_CM_QC3) && $VIT_CM_QC3 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C3" required >Yes
                            <input type="radio" name="QC_Q3"
<?php if (isset($VIT_CM_QC3) && $VIT_CM_QC3 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C3">No
                        </p>

                            <textarea class="form-control"id="QC_C3" name="QC_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC3)) { echo $VIT_CE_QC3; } ?></textarea><span class="help-block"><p id="characterLeft51" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft51').text('500 characters left');
                                $('#QC_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft51').text('You have reached the limit');
                                        $('#characterLeft51').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft51').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft51').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="QC_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
                            <input type="radio" name="QC_Q4" 
<?php if (isset($VIT_CM_QC4) && $VIT_CM_QC4 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C4" required >Yes
                            <input type="radio" name="QC_Q4"
<?php if (isset($VIT_CM_QC4) && $VIT_CM_QC4 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C4">No
                        </p>

                            <textarea class="form-control"id="QC_C4" name="QC_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC4)) { echo $VIT_CE_QC4; } ?></textarea><span class="help-block"><p id="characterLeft52" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft52').text('500 characters left');
                                $('#QC_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft52').text('You have reached the limit');
                                        $('#characterLeft52').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft52').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft52').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="QC_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
                            <input type="radio" name="QC_Q5" 
<?php if (isset($VIT_CM_QC5) && $VIT_CM_QC5 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C5" required >Yes
                            <input type="radio" name="QC_Q5"
<?php if (isset($VIT_CM_QC5) && $VIT_CM_QC5 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C5">No
                        </p>

                            <textarea class="form-control"id="QC_C5" name="QC_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC5)) { echo $VIT_CE_QC5; } ?></textarea><span class="help-block"><p id="characterLeft53" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft53').text('500 characters left');
                                $('#QC_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft53').text('You have reached the limit');
                                        $('#characterLeft53').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft53').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft53').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="QC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer provided contact details for <?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>?</label>
                            <input type="radio" name="QC_Q6" 
<?php if (isset($VIT_CM_QC6) && $VIT_CM_QC6 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C6" required >Yes
                            <input type="radio" name="QC_Q6"
<?php if (isset($VIT_CM_QC6) && $VIT_CM_QC6 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C6">No
                        </p>

                            <textarea class="form-control"id="QC_C6" name="QC_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC6)) { echo $VIT_CE_QC6; } ?></textarea><span class="help-block"><p id="characterLeft54" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft54').text('500 characters left');
                                $('#QC_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft54').text('You have reached the limit');
                                        $('#characterLeft54').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft54').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft54').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="QC_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
                            <input type="radio" name="QC_Q7" 
<?php if (isset($VIT_CM_QC7) && $VIT_CM_QC7 == "1") {
    echo "checked";
} ?> value="1" id="yesCheckQC_C7" required >Yes
                            <input type="radio" name="QC_Q7"
<?php if (isset($VIT_CM_QC7) && $VIT_CM_QC7 == "0") {
    echo "checked";
} ?> value="0" id="noCheckQC_C7">No
                        </p>

                            <textarea class="form-control"id="QC_C7" name="QC_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"><?php if(isset($VIT_CE_QC7)) { echo $VIT_CE_QC7; } ?></textarea><span class="help-block"><p id="characterLeft55" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft55').text('500 characters left');
                                $('#QC_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft55').text('You have reached the limit');
                                        $('#characterLeft55').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft55').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft55').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                </div>
                <br>
                
                <center>
                    <button type="submit" value="submit"  class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Submit Audit</button>
                </center>
        </form>

        
</div>  
    <script>
    document.querySelector('#AUDIT_FORM').addEventListener('submit', function (e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "LV audit",
            text: "Update vitality audit?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: 'Complete!',
                            text: 'LV audit updated!',
                            type: 'success'
                        }, function () {
                            form.submit();
                        });

                    } else {
                        swal("Cancelled", "No Changes have been submitted", "error");
                    }
                });
    });

</script>
</body>
</html>