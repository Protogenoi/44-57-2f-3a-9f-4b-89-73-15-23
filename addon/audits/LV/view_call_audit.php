training<?php
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
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $CHECK_USER_LOGIN->CheckAccessLevel();
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        } 
$QUESTION_NUMBER=1;

$AUDITID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);

if(isset($AUDITID)) {

    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT 
                            DATE(adl_audits_date_added) AS adl_audits_date_added, 
                            adl_audits_auditor, 
                            adl_audits_grade, 
                            adl_audits_closer, 
                            adl_audits_agent,
                            adl_audits_ref,
                            adl_audits_date_added
                        FROM 
                            adl_audits 
                        WHERE 
                            adl_audits_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_AUDIT=$database->single();   
    
    if(isset($VIT_AUDIT['adl_audits_date_added'])) {
        
        $VIT_DATE=$VIT_AUDIT['adl_audits_date_added'];
        
    }
    
    if(isset($VIT_AUDIT['adl_audits_auditor'])) {
        
        $VIT_AUDITOR=$VIT_AUDIT['adl_audits_auditor'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_grade'])) {
        
        $VIT_GRADE=$VIT_AUDIT['adl_audits_grade'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_closer'])) {
        
        $VIT_CLOSER=$VIT_AUDIT['adl_audits_closer'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_agent'])) {
        
        $VIT_AGENT=$VIT_AUDIT['adl_audits_agent'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_ref'])) {
        
        $VIT_REF=$VIT_AUDIT['adl_audits_ref'];
        
    }  
    
    if(isset($VIT_AUDIT['adl_audits_date_added'])) {
        
        $VIT_ADDED_DATE=$VIT_AUDIT['adl_audits_date_added'];
        
    }    
    
    $database->query("SELECT 
                            adl_audit_lv_id,
                            adl_audit_lv_od1, 
                            adl_audit_lv_od2, 
                            adl_audit_lv_od3, 
                            adl_audit_lv_od4, 
                            adl_audit_lv_od5, 
                            adl_audit_lv_icn1, 
                            adl_audit_lv_icn2, 
                            adl_audit_lv_icn3, 
                            adl_audit_lv_icn4,
                            adl_audit_lv_icn5, 
                            adl_audit_lv_cd1, 
                            adl_audit_lv_cd2, 
                            adl_audit_lv_cd3, 
                            adl_audit_lv_cd4, 
                            adl_audit_lv_cd5, 
                            adl_audit_lv_cd6, 
                            adl_audit_lv_cd7, 
                            adl_audit_lv_cd8, 
                            adl_audit_lv_con1, 
                            adl_audit_lv_con2,
                            adl_audit_lv_con3,
                            adl_audit_lv_pd1, 
                            adl_audit_lv_pd2, 
                            adl_audit_lv_pd3, 
                            adl_audit_lv_pd4, 
                            adl_audit_lv_pd5, 
                            adl_audit_lv_h1, 
                            adl_audit_lv_h2, 
                            adl_audit_lv_h3, 
                            adl_audit_lv_l1, 
                            adl_audit_lv_l2, 
                            adl_audit_lv_l3, 
                            adl_audit_lv_l4, 
                            adl_audit_lv_l5, 
                            adl_audit_lv_l6, 
                            adl_audit_lv_l7, 
                            adl_audit_lv_l8, 
                            adl_audit_lv_l9, 
                            adl_audit_lv_o1, 
                            adl_audit_lv_pri1, 
                            adl_audit_lv_bd1, 
                            adl_audit_lv_bd2, 
                            adl_audit_lv_bd3, 
                            adl_audit_lv_bd4, 
                            adl_audit_lv_bd5, 
                            adl_audit_lv_dec1, 
                            adl_audit_lv_dec2, 
                            adl_audit_lv_dec3, 
                            adl_audit_lv_dec4, 
                            adl_audit_lv_dec5, 
                            adl_audit_lv_dec6, 
                            adl_audit_lv_dec7, 
                            adl_audit_lv_qc1, 
                            adl_audit_lv_qc2, 
                            adl_audit_lv_qc3, 
                            adl_audit_lv_qc4, 
                            adl_audit_lv_qc5, 
                            adl_audit_lv_qc6, 
                            adl_audit_lv_qc7
  FROM
    adl_audit_lv
  WHERE
    adl_audit_lv_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_Q_AUDIT=$database->single();   
    
    $SCORE = 0;
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_id'])) {
        $AID_FK=$VIT_Q_AUDIT['adl_audit_lv_id'];
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_od1'])) {
        
        $OD_Q1=$VIT_Q_AUDIT['adl_audit_lv_od1'];
        
        if($OD_Q1 == "0") {
            $SCORE ++;
            
        }
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_od2'])) {
        
        $OD_Q2=$VIT_Q_AUDIT['adl_audit_lv_od2'];
        
        if($OD_Q2 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_od3'])) {
        
        $OD_Q3=$VIT_Q_AUDIT['adl_audit_lv_od3'];
        
        if($OD_Q3 == "0") {
            $SCORE ++;
        }        
        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_od4'])) {
        
        $OD_Q4=$VIT_Q_AUDIT['adl_audit_lv_od4'];
        
        if($OD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_od5'])) {
        
        $OD_Q5=$VIT_Q_AUDIT['adl_audit_lv_od5'];
        
        if($OD_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_icn1'])) {
        
        $ICN_Q1=$VIT_Q_AUDIT['adl_audit_lv_icn1'];
        
        if($ICN_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_icn2'])) {
        
        $ICN_Q2=$VIT_Q_AUDIT['adl_audit_lv_icn2'];
        
        if($ICN_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_icn3'])) {
        
        $ICN_Q3=$VIT_Q_AUDIT['adl_audit_lv_icn3'];
        
        if($ICN_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_icn4'])) {
        
        $ICN_Q4=$VIT_Q_AUDIT['adl_audit_lv_icn4'];
        
        if($ICN_Q4 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_icn5'])) {
        
        $ICN_Q5=$VIT_Q_AUDIT['adl_audit_lv_icn5'];
        
        if($ICN_Q5 == "Poor") {
            $SCORE ++;
        }         
        
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd1'])) {
        
        $CD_Q1=$VIT_Q_AUDIT['adl_audit_lv_cd1'];
        
        if($CD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd2'])) {
        
        $CD_Q2=$VIT_Q_AUDIT['adl_audit_lv_cd2'];
        
        if($CD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd3'])) {
        
        $CD_Q3=$VIT_Q_AUDIT['adl_audit_lv_cd3'];
        
        if($CD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd4'])) {
        
        $CD_Q4=$VIT_Q_AUDIT['adl_audit_lv_cd4'];
        
         if($CD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd5'])) {
        
        $CD_Q5=$VIT_Q_AUDIT['adl_audit_lv_cd5'];
        
        if($CD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd6'])) {
        
        $CD_Q6=$VIT_Q_AUDIT['adl_audit_lv_cd6'];
        
         if($CD_Q6 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd7'])) {
        
        $CD_Q7=$VIT_Q_AUDIT['adl_audit_lv_cd7'];
        
        if($CD_Q7 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_cd8'])) {
        
        $CD_Q8=$VIT_Q_AUDIT['adl_audit_lv_cd8'];
        
        if($CD_Q8 == "0") {
            $SCORE ++;
        }         
        
    }        
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_con1'])) {
        
        $CON_Q1=$VIT_Q_AUDIT['adl_audit_lv_con1'];
        
         if($CON_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_con2'])) {
        
        $CON_Q2=$VIT_Q_AUDIT['adl_audit_lv_con2'];
        
          if($CON_Q2 == "0") {
            $SCORE ++;
        }        
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_con3'])) {
        
        $CON_Q3=$VIT_Q_AUDIT['adl_audit_lv_con3'];
        
          if($CON_Q3 == "0") {
            $SCORE ++;
        }        
        
    }         
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pd1'])) {
        
        $PD_Q1=$VIT_Q_AUDIT['adl_audit_lv_pd1'];
        
         if($PD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pd2'])) {
        
        $PD_Q2=$VIT_Q_AUDIT['adl_audit_lv_pd2'];
        
         if($PD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pd3'])) {
        
        $PD_Q3=$VIT_Q_AUDIT['adl_audit_lv_pd3'];
        
         if($PD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pd4'])) {
        
        $PD_Q4=$VIT_Q_AUDIT['adl_audit_lv_pd4'];
        
         if($PD_Q4 == "0") {
            $SCORE ++;
        }         
        
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pd5'])) {
        
        $PD_Q5=$VIT_Q_AUDIT['adl_audit_lv_pd5'];
        
         if($PD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_h1'])) {
        
        $H_Q1=$VIT_Q_AUDIT['adl_audit_lv_h1'];
        
         if($H_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_h2'])) {
        
        $H_Q2=$VIT_Q_AUDIT['adl_audit_lv_h2'];
        
         if($H_Q2 == "0") {
            $SCORE ++;
        }        
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_h3'])) {
        
        $H_Q3=$VIT_Q_AUDIT['adl_audit_lv_h3'];
        
         if($H_Q3 == "0") {
            $SCORE ++;
        }   
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l1'])) {
        
        $L_Q1=$VIT_Q_AUDIT['adl_audit_lv_l1'];
        
         if($L_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l2'])) {
        
        $L_Q2=$VIT_Q_AUDIT['adl_audit_lv_l2'];
        
         if($L_Q2 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l3'])) {
        
        $L_Q3=$VIT_Q_AUDIT['adl_audit_lv_l3'];
        
         if($L_Q3 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l4'])) {
        
        $L_Q4=$VIT_Q_AUDIT['adl_audit_lv_l4'];
        
         if($L_Q4 == "0") {
            $SCORE ++;
        }          
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_l5'])) {
        
        $L_Q5=$VIT_Q_AUDIT['adl_audit_lv_l5'];
        
         if($L_Q5 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l6'])) {
        
        $L_Q6=$VIT_Q_AUDIT['adl_audit_lv_l6'];
        
         if($L_Q6 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l7'])) {
        
        $L_Q7=$VIT_Q_AUDIT['adl_audit_lv_l7'];
        
         if($L_Q7 == "0") {
            $SCORE ++;
        }          
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_l8'])) {
        
        $L_Q8=$VIT_Q_AUDIT['adl_audit_lv_l8'];
        
         if($L_Q8 == "0") {
            $SCORE ++;
        }          
        
    }            
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_l9'])) {
        
        $L_Q9=$VIT_Q_AUDIT['adl_audit_lv_l9'];
        
         if($L_Q9 == "0") {
            $SCORE ++;
        }          
        
    }           
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_o1'])) {
        
        $O_Q1=$VIT_Q_AUDIT['adl_audit_lv_o1'];
        
         if($O_Q1 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_pri1'])) {
        
        $PRI_Q1=$VIT_Q_AUDIT['adl_audit_lv_pri1'];
        
         if($PRI_Q1 == "0") {
            $SCORE ++;
        }          
        
    }     

   if(isset($VIT_Q_AUDIT['adl_audit_lv_bd1'])) {
        
        $BD_Q1=$VIT_Q_AUDIT['adl_audit_lv_bd1'];
        
         if($BD_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_bd2'])) {
        
        $BD_Q2=$VIT_Q_AUDIT['adl_audit_lv_bd2'];
        
         if($BD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_bd3'])) {
        
        $BD_Q3=$VIT_Q_AUDIT['adl_audit_lv_bd3'];
        
         if($BD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_bd4'])) {
        
        $BD_Q4=$VIT_Q_AUDIT['adl_audit_lv_bd4'];
        
         if($BD_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_bd5'])) {
        
        $BD_Q5=$VIT_Q_AUDIT['adl_audit_lv_bd5'];
        
         if($BD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
   if(isset($VIT_Q_AUDIT['adl_audit_lv_dec1'])) {
        
        $DEC_Q1=$VIT_Q_AUDIT['adl_audit_lv_dec1'];
        
          if($DEC_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec2'])) {
        
        $DEC_Q2=$VIT_Q_AUDIT['adl_audit_lv_dec2'];
        
          if($DEC_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec3'])) {
        
        $DEC_Q3=$VIT_Q_AUDIT['adl_audit_lv_dec3'];
        
           if($DEC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec4'])) {
        
        $DEC_Q4=$VIT_Q_AUDIT['adl_audit_lv_dec4'];
        
          if($DEC_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec5'])) {
        
        $DEC_Q5=$VIT_Q_AUDIT['adl_audit_lv_dec5'];
        
           if($DEC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }   
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec6'])) {
        
        $DEC_Q6=$VIT_Q_AUDIT['adl_audit_lv_dec6'];
        
          if($DEC_Q6 == "0") {
            $SCORE ++;
        }         
        
    } 

    if(isset($VIT_Q_AUDIT['adl_audit_lv_dec7'])) {
        
        $DEC_Q7=$VIT_Q_AUDIT['adl_audit_lv_dec7'];
        
          if($DEC_Q7 == "0") {
            $SCORE ++;
        }         
        
    }
   
    
   if(isset($VIT_Q_AUDIT['adl_audit_lv_qc1'])) {
        
        $QC_Q1=$VIT_Q_AUDIT['adl_audit_lv_qc1'];
        
          if($QC_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc2'])) {
        
        $QC_Q2=$VIT_Q_AUDIT['adl_audit_lv_qc2'];
        
           if($QC_Q2 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc3'])) {
        
        $QC_Q3=$VIT_Q_AUDIT['adl_audit_lv_qc3'];
        
          if($QC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc4'])) {
        
        $QC_Q4=$VIT_Q_AUDIT['adl_audit_lv_qc4'];
        
           if($QC_Q4 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc5'])) {
        
        $QC_Q5=$VIT_Q_AUDIT['adl_audit_lv_qc5'];
        
          if($QC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc6'])) {
        
        $QC_Q6=$VIT_Q_AUDIT['adl_audit_lv_qc6'];
        
          if($QC_Q6 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_lv_qc7'])) {
        
        $QC_Q7=$VIT_Q_AUDIT['adl_audit_lv_qc7'];
        
           if($QC_Q7 == "0") {
            $SCORE ++;
        }       
        
    }     

    $database->query("SELECT
                            adl_audit_lv_c_od1, 
                            adl_audit_lv_c_od2, 
                            adl_audit_lv_c_od3, 
                            adl_audit_lv_c_od4, 
                            adl_audit_lv_c_od5, 
                            adl_audit_lv_c_icn1, 
                            adl_audit_lv_c_icn2, 
                            adl_audit_lv_c_icn3, 
                            adl_audit_lv_c_icn4,
                            adl_audit_lv_c_icn5,
                            adl_audit_lv_c_cd1, 
                            adl_audit_lv_c_cd2, 
                            adl_audit_lv_c_cd3, 
                            adl_audit_lv_c_cd4, 
                            adl_audit_lv_c_cd5, 
                            adl_audit_lv_c_cd6, 
                            adl_audit_lv_c_cd7, 
                            adl_audit_lv_c_cd8, 
                            adl_audit_lv_c_con1,
                            adl_audit_lv_c_con2,
                            adl_audit_lv_c_con3, 
                            adl_audit_lv_c_pd1, 
                            adl_audit_lv_c_pd2, 
                            adl_audit_lv_c_pd3, 
                            adl_audit_lv_c_pd4, 
                            adl_audit_lv_c_pd5, 
                            adl_audit_lv_c_h1, 
                            adl_audit_lv_c_h2, 
                            adl_audit_lv_c_h3
                        FROM 
                            adl_audit_lv_c 
                        WHERE 
                            adl_audit_lv_c_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AID_FK);
    $database->execute();
    $VIT_C_AUDIT=$database->single();     
    
   if(isset($VIT_C_AUDIT['adl_audit_lv_c_od1'])) {
        
        $OD_C1=$VIT_C_AUDIT['adl_audit_lv_c_od1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_od2'])) {
        
        $OD_C2=$VIT_C_AUDIT['adl_audit_lv_c_od2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_od3'])) {
        
        $OD_C3=$VIT_C_AUDIT['adl_audit_lv_c_od3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_od4'])) {
        
        $OD_C4=$VIT_C_AUDIT['adl_audit_lv_c_od4'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_od5'])) {
        
        $OD_C5=$VIT_C_AUDIT['adl_audit_lv_c_od5'];
        
    }    
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_icn1'])) {
        
        $ICN_C1=$VIT_C_AUDIT['adl_audit_lv_c_icn1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_icn2'])) {
        
        $ICN_C2=$VIT_C_AUDIT['adl_audit_lv_c_icn2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_icn3'])) {
        
        $ICN_C3=$VIT_C_AUDIT['adl_audit_lv_c_icn3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_icn4'])) {
        
        $ICN_C4=$VIT_C_AUDIT['adl_audit_lv_c_icn4'];
        
    }
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_icn5'])) {
        
        $ICN_C5=$VIT_C_AUDIT['adl_audit_lv_c_icn5'];
        
    }    

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd1'])) {
        
        $CD_C1=$VIT_C_AUDIT['adl_audit_lv_c_cd1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd2'])) {
        
        $CD_C2=$VIT_C_AUDIT['adl_audit_lv_c_cd2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd3'])) {
        
        $CD_C3=$VIT_C_AUDIT['adl_audit_lv_c_cd3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd4'])) {
        
        $CD_C4=$VIT_C_AUDIT['adl_audit_lv_c_cd4'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd5'])) {
        
        $CD_C5=$VIT_C_AUDIT['adl_audit_lv_c_cd5'];
        
    }    
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd6'])) {
        
        $CD_C6=$VIT_C_AUDIT['adl_audit_lv_c_cd6'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd7'])) {
        
        $CD_C7=$VIT_C_AUDIT['adl_audit_lv_c_cd7'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_cd8'])) {
        
        $CD_C8=$VIT_C_AUDIT['adl_audit_lv_c_cd8'];
        
    }
    
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_con1'])) {
        
        $CON_C1=$VIT_C_AUDIT['adl_audit_lv_c_con1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_con2'])) {
        
        $CON_C2=$VIT_C_AUDIT['adl_audit_lv_c_con2'];
        
    }
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_con3'])) {
        
        $CON_C3=$VIT_C_AUDIT['adl_audit_lv_c_con3'];
        
    }   
    
     if(isset($VIT_C_AUDIT['adl_audit_lv_c_pd1'])) {
        
        $PD_C1=$VIT_C_AUDIT['adl_audit_lv_c_pd1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_pd2'])) {
        
        $PD_C2=$VIT_C_AUDIT['adl_audit_lv_c_pd2'];
        
    }
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_pd3'])) {
        
        $PD_C3=$VIT_C_AUDIT['adl_audit_lv_c_pd3'];
        
    }   
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_pd4'])) {
        
        $PD_C4=$VIT_C_AUDIT['adl_audit_lv_c_pd4'];
        
    } 

    if(isset($VIT_C_AUDIT['adl_audit_lv_c_pd5'])) {
        
        $PD_C5=$VIT_C_AUDIT['adl_audit_lv_c_pd5'];
        
    } 
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_h1'])) {
        
        $H_C1=$VIT_C_AUDIT['adl_audit_lv_c_h1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_h2'])) {
        
        $H_C2=$VIT_C_AUDIT['adl_audit_lv_c_h2'];
        
    }
    
    if(isset($VIT_C_AUDIT['adl_audit_lv_c_h3'])) {
        
        $H_C3=$VIT_C_AUDIT['adl_audit_lv_c_h3'];
        
    }      

     
    
$database->query("SELECT
                        adl_audit_lv_ce_l1, 
                        adl_audit_lv_ce_l2,
                        adl_audit_lv_ce_l3, 
                        adl_audit_lv_ce_l4, 
                        adl_audit_lv_ce_l5, 
                        adl_audit_lv_ce_l6, 
                        adl_audit_lv_ce_l7, 
                        adl_audit_lv_ce_l8, 
                        adl_audit_lv_ce_l9, 
                        adl_audit_lv_ce_o1, 
                        adl_audit_lv_ce_pri1, 
                        adl_audit_lv_ce_bd1, 
                        adl_audit_lv_ce_bd2, 
                        adl_audit_lv_ce_bd3, 
                        adl_audit_lv_ce_bd4, 
                        adl_audit_lv_ce_bd5, 
                        adl_audit_lv_ce_dec1, 
                        adl_audit_lv_ce_dec2, 
                        adl_audit_lv_ce_dec3, 
                        adl_audit_lv_ce_dec4, 
                        adl_audit_lv_ce_dec5, 
                        adl_audit_lv_ce_dec6, 
                        adl_audit_lv_ce_dec7, 
                        adl_audit_lv_ce_qc1, 
                        adl_audit_lv_ce_qc2, 
                        adl_audit_lv_ce_qc3, 
                        adl_audit_lv_ce_qc4, 
                        adl_audit_lv_ce_qc5, 
                        adl_audit_lv_ce_qc6, 
                        adl_audit_lv_ce_qc7
  FROM
    adl_audit_lv_ce
  WHERE
    adl_audit_lv_ce_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AID_FK);
    $database->execute();
    $VIT_CE_AUDIT=$database->single();   
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l1'])) {
        
        $L_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_l1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l2'])) {
        
        $L_C2=$VIT_CE_AUDIT['adl_audit_lv_ce_l2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l3'])) {
        
        $L_C3=$VIT_CE_AUDIT['adl_audit_lv_ce_l3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l4'])) {
        
        $L_C4=$VIT_CE_AUDIT['adl_audit_lv_ce_l4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l5'])) {
        
        $L_C5=$VIT_CE_AUDIT['adl_audit_lv_ce_l5'];
        
    }    
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l6'])) {
        
        $L_C6=$VIT_CE_AUDIT['adl_audit_lv_ce_l6'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l7'])) {
        
        $L_C7=$VIT_CE_AUDIT['adl_audit_lv_ce_l7'];
        
    } 

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l8'])) {
        
        $L_C8=$VIT_CE_AUDIT['adl_audit_lv_ce_l8'];
        
    } 

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_l9'])) {
        
        $L_C9=$VIT_CE_AUDIT['adl_audit_lv_ce_l9'];
        
    }     
    
if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_o1'])) {
        
        $O_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_o1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_pri1'])) {
        
        $PRI_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_pri1'];
        
    }        
    
   if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_bd1'])) {
        
        $BD_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_bd1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_bd2'])) {
        
        $BD_C2=$VIT_CE_AUDIT['adl_audit_lv_ce_bd2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_bd3'])) {
        
        $BD_C3=$VIT_CE_AUDIT['adl_audit_lv_ce_bd3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_bd4'])) {
        
        $BD_C4=$VIT_CE_AUDIT['adl_audit_lv_ce_bd4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_bd5'])) {
        
        $BD_C5=$VIT_CE_AUDIT['adl_audit_lv_ce_bd5'];
        
    }    
    
   if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec1'])) {
        
        $DEC_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_dec1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec2'])) {
        
        $DEC_C2=$VIT_CE_AUDIT['adl_audit_lv_ce_dec2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec3'])) {
        
        $DEC_C3=$VIT_CE_AUDIT['adl_audit_lv_ce_dec3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec4'])) {
        
        $DEC_C4=$VIT_CE_AUDIT['adl_audit_lv_ce_dec4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec5'])) {
        
        $DEC_C5=$VIT_CE_AUDIT['adl_audit_lv_ce_dec5'];
        
    }   
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec6'])) {
        
        $DEC_C6=$VIT_CE_AUDIT['adl_audit_lv_ce_dec6'];
        
    } 

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_dec7'])) {
        
        $DEC_C7=$VIT_CE_AUDIT['adl_audit_lv_ce_dec7'];
        
    }     
    
   if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc1'])) {
        
        $QC_C1=$VIT_CE_AUDIT['adl_audit_lv_ce_qc1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc2'])) {
        
        $QC_C2=$VIT_CE_AUDIT['adl_audit_lv_ce_qc2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc3'])) {
        
        $QC_C3=$VIT_CE_AUDIT['adl_audit_lv_ce_qc3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc4'])) {
        
        $QC_C4=$VIT_CE_AUDIT['adl_audit_lv_ce_qc4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc5'])) {
        
        $QC_C5=$VIT_CE_AUDIT['adl_audit_lv_ce_qc5'];
        
    }    
    
    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc6'])) {
        
        $QC_C6=$VIT_CE_AUDIT['adl_audit_lv_ce_qc6'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_lv_ce_qc7'])) {
        
        $QC_C7=$VIT_CE_AUDIT['adl_audit_lv_ce_qc7'];
        
    } 
    
    $database->endTransaction();  
 
    $TOTAL= 60 - $SCORE;
    
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | View LV Call Audit</title>
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
</head>
<body>
    
<div class="container">
       <div class="wrapper col4">
            <table id='users'>
                <thead>

                    <tr>
                        <td colspan=2><b>LV Call Audit ID: <?php echo $AUDITID ?></b></td>
                    </tr>

                    <tr>

                        <?php
                        
                        if ($VIT_GRADE == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>$VIT_GRADE | ($TOTAL/59)</b></td>";
                        } else if ($VIT_GRADE == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>$VIT_GRADE | ($TOTAL/59)</b></td>";
                        } else if ($VIT_GRADE == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>$VIT_GRADE | ($TOTAL/59)</b></td>";
                        }
                        ?>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php echo $VIT_AUDITOR; ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php echo $VIT_CLOSER; if(isset($VIT_AGENT)) { echo " - $VIT_AGENT"; } ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php echo $VIT_ADDED_DATE; ?></td>
                    </tr>

                    <tr>
                        <td>Plan Number</td>
                        <td><?php echo $VIT_REF; ?></td>
                    </tr>

                </thead>
            </table>
           
           <h1><b>Opening Declaration</b></h1>

            <p>
                <label for="q1">Q<?php $i=0; $i++; echo $i; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label><br>
                <input type="radio" name="q1" value="Yes" onclick="return false" <?php if(isset($OD_Q1)) { if ($OD_Q1 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q1" value="No" onclick="return false" <?php if(isset($OD_Q1)) { if ($OD_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php if(isset($OD_C1)) { echo $OD_C1; } ?>
            </div>
            </p>

            <p>
                <label for="q2">Q<?php $i++; echo $i; ?>. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label><br>
                <input type="radio" name="q2" value="Yes" onclick="return false" <?php if(isset($OD_Q2)) { if ($OD_Q2 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q2" value="No" onclick="return false" <?php if(isset($OD_Q2)) { if ($OD_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($OD_C2)) { echo $OD_C2; } ?>
            </div>
            </p>

            <p>
                <label for="q3">Q<?php $i++; echo $i; ?>. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label><br>
                <input type="radio" name="q3" value="Yes" onclick="return false" <?php if(isset($OD_Q3)) { if ($OD_Q3 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q3" value="No" onclick="return false" <?php if(isset($OD_Q3)) { if ($OD_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($OD_C3)) { echo $OD_C3; } ?>
            </div>
            </p>

            <p>
                <label for="q4">Q<?php $i++; echo $i; ?>. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label><br>


                <input type="radio" name="q4" value="Yes" onclick="return false" <?php if(isset($OD_Q4)) {  if ($OD_Q4 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q4" value="No" onclick="return false" <?php if(isset($OD_Q4)) { if ($OD_Q4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($OD_C4)) { echo $OD_C4; } ?>
            </div>
            </p>

            <p>
                <label for="q5">Q<?php $i++; echo $i; ?>. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>

                <input type="radio" name="q5" value="Yes" onclick="return false" <?php if(isset($OD_Q5)) {  if ($OD_Q5 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q5" value="No" onclick="return false" <?php if(isset($OD_Q5)) {  if ($OD_Q5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($OD_C5)) { echo $OD_C5; } ?>
            </div>
            </p>  
            
<h3 class="panel-title">Identifying Clients Needs</h3>

<p>
    <label for="ICN1">Q<?php $i++; echo $i; ?>. Did the closer check the customers existing policy details?</label><br>
<input type="radio" name="ICN1" <?php if (isset($ICN_Q1) && $ICN_Q1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN1();" value="1" id="yesCheckICN1">Yes
<input type="radio" name="ICN1" <?php if (isset($ICN_Q1) && $ICN_Q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN1();" value="0" id="noCheckICN1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($ICN_C1)) { echo $ICN_C1; } ?></div>

<p>
<label for="ICN2">Q<?php $i++; echo $i; ?>. Did the closer offer additional benefit or even make the customer aware of the benefits/extra's of the new policy?</label><br>
<input type="radio" name="ICN2" <?php if (isset($ICN_Q2) && $ICN_Q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN2();" value="1" id="yesCheckICN2">Yes
<input type="radio" name="ICN2" <?php if (isset($ICN_Q2) && $ICN_Q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN2();" value="0" id="noCheckICN2"><label for="No">No</label>
<input type="radio" name="ICN2" <?php if (isset($ICN_Q2) && $ICN_Q2=="N/A") { echo "checked"; } ?> value="N/A" >N/A
</p>

<div class="phpcomments"><?php if(isset($ICN_C2)) { echo $ICN_C2; } ?></div>

<p>
<label for="ICN3">Q<?php $i++; echo $i; ?>. Did the closer ensure that the customer was provided with a policy that met their needs (more cover, cheaper premium, extension of years etc...)?</label><br>
<input type="radio" name="ICN3" <?php if (isset($ICN_Q3) && $ICN_Q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN3();" value="1" id="yesCheckICN3">Yes
<input type="radio" name="ICN3" <?php if (isset($ICN_Q3) && $ICN_Q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN3();" value="0" id="noCheckICN3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($ICN_C3)) { echo $ICN_C3; } ?></div>

<p>
<label for="ICN4">Q<?php $i++; echo $i; ?>. Did the closer confirm that this policy would be set up with LV?</label><br>
<input type="radio" name="ICN4" <?php if (isset($ICN_Q4) && $ICN_Q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN4();" value="1" id="yesCheckICN4">Yes
<input type="radio" name="ICN4" <?php if (isset($ICN_Q4) && $ICN_Q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICN4();" value="0" id="noCheckICN4"><label for="No">No</label>
</p>
<div class="phpcomments"><?php if(isset($ICN_C4)) { echo $ICN_C4; } ?></div>

<p>
<label for="ICN5">Q<?php $i++; echo $i; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label><br>
<select class="form-control" name="IC5">
  <option value="0" <?php if(isset($ICN_Q5)) { if($ICN_Q5=='N/A') { echo "selected"; } } ?>>Select...</option>
  <option value="1" <?php if(isset($ICN_Q5)) { if($ICN_Q5=='More than sufficient') { echo "selected"; } } ?>>More than sufficient</option>
  <option value="2" <?php if(isset($ICN_Q5)) { if($ICN_Q5=='Sufficient') { echo "selected"; } } ?>>Sufficient</option>
  <option value="3" <?php if(isset($ICN_Q5)) { if($ICN_Q5=='Adequate') { echo "selected"; } } ?>>Adequate</option>
  <option value="5" <?php if(isset($ICN_Q5)) { if($ICN_Q5=='Poor') { echo "selected"; } } ?>>Poor</option>
</select></p>
<div class="phpcomments"><?php if(isset($ICN_C5)) { echo $ICN_C5; } ?></div>
      

<h3 class="panel-title">Customer Details</h3>

<p>
    <label for="E1">Q<?php $i++; echo $i; ?>. Did the closer ask customer titles?</label><br>
<input type="radio" name="E1" <?php if (isset($CD_Q1) && $CD_Q1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="1" id="yesCheckET1">Yes
<input type="radio" name="E1" <?php if (isset($CD_Q1) && $CD_Q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="0" id="noCheckET1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C1)) { echo $CD_C1; } ?></div>


<p>
<label for="E2">Q<?php $i++; echo $i; ?>. Did the closer phonetically check names?</label><br>
<input type="radio" name="E2" <?php if (isset($CD_Q2) && $CD_Q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="1" id="yesCheckET2">Yes
<input type="radio" name="E2" <?php if (isset($CD_Q2) && $CD_Q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="0" id="noCheckET2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C2)) { echo $CD_C2; } ?></div>


<p>
<label for="E3">Q<?php $i++; echo $i; ?>. Did the closer input the correct gender?</label><br>
<input type="radio" name="E3" <?php if (isset($CD_Q3) && $CD_Q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="1" id="yesCheckET3">Yes
<input type="radio" name="E3" <?php if (isset($CD_Q3) && $CD_Q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="0" id="noCheckET3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C3)) { echo $CD_C3; } ?></div>


<p>
<label for="E4">Q<?php $i++; echo $i; ?>. Did the closer ask and confirm the customers DOB?</label><br>
<input type="radio" name="E4" <?php if (isset($CD_Q4) && $CD_Q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="1" id="yesCheckET4">Yes
<input type="radio" name="E4" <?php if (isset($CD_Q4) && $CD_Q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="0" id="noCheckET4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C4)) { echo $CD_C4; } ?></div>


<p>
<label for="E5">Q<?php $i++; echo $i; ?>. Did the closer ask the customers smoking question?</label><br>
<input type="radio" name="E5" <?php if (isset($CD_Q5) && $CD_Q5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E5" <?php if (isset($CD_Q5) && $CD_Q5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C5)) { echo $CD_C5; } ?></div>

<p>
<label for="E6">Q<?php $i++; echo $i; ?>. Did the closer ask the customers occupation?</label><br>
<input type="radio" name="E6" <?php if (isset($CD_Q6) && $CD_Q6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E6" <?php if (isset($CD_Q6) && $CD_Q6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C6)) { echo $CD_C6; } ?></div>


<p>
<label for="E7">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer was a UK resident?</label><br>
<input type="radio" name="E7" <?php if (isset($CD_Q7) && $CD_Q7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E7" <?php if (isset($CD_Q7) && $CD_Q7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C7)) { echo $CD_C7; } ?></div>


<p>
<label for="E8">Q<?php $i++; echo $i; ?>. Did the closer confirm single or joint policy?</label><br>
<input type="radio" name="E8" <?php if (isset($CD_Q8) && $CD_Q8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E8" <?php if (isset($CD_Q8) && $CD_Q8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($CD_C8)) { echo $CD_C8; } ?></div>

        
            
<h3 class="panel-title">Contact Details</h3>   

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Did the closer confirm the customers address?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($CON_Q1)) {  if ($CON_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($CON_Q1)) {  if ($CON_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($CON_C1)) { echo $CON_C1; } ?>
            </div>    
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Did the closer get the correct email?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($CON_Q2)) {  if ($CON_Q2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($CON_Q2)) {  if ($CON_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($CON_C2)) { echo $CON_C2; } ?>
            </div>     
</p>

<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Did the closer put the correct marital status in?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($CON_Q3)) {  if ($CON_Q3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($CON_Q3)) {  if ($CON_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($CON_C3)) { echo $CON_C3; } ?>
            </div>     
</p>

<h3 class="panel-title">Personal Details</h3>   

<p>
    <label for="PD1">Q<?php $i++; echo $i; ?>. Did the closer ask the customers 'Height and Weight' and did they record the answers correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q1)) {  if ($PD_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PD_Q1)) {  if ($PD_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($PD_C1)) { echo $PD_C1; } ?>
            </div>    
</p>

<p>
    <label for="PD1">Q<?php $i++; echo $i; ?>. Did the closer ask the customers 'Smoking Status' and did they record the answer correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q2)) {  if ($PD_Q2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PD_Q2)) {  if ($PD_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($PD_C2)) { echo $PD_C2; } ?>
            </div>     
</p>

<p>
    <label for="PD1">Q<?php $i++; echo $i; ?>. Did the closer ask the customer what they had smoked and how many per day in the last 12 months?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q3)) {  if ($PD_Q3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PD_Q3)) {  if ($PD_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q3)) {  if ($PD_Q3 == "N/A") { echo "checked"; } } ?> >N/A
    
            <div class="phpcomments">
                <?php if(isset($PD_C3)) { echo $PD_C3; } ?>
            </div>     
</p>

<p>
    <label for="PD1">Q<?php $i++; echo $i; ?>. Did the closer confirm the customers main job?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q4)) {  if ($PD_Q4 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PD_Q4)) {  if ($PD_Q4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($PD_C4)) { echo $PD_C4; } ?>
            </div>     
</p>

<p>
    <label for="PD1">Q<?php $i++; echo $i; ?>. Did the closer ask the customer's family history and did they record the answered correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PD_Q5)) {  if ($PD_Q5 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PD_Q5)) {  if ($PD_Q5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($PD_C5)) { echo $PD_C5; } ?>
            </div>     
</p>

<h3 class="panel-title">Health</h3>   

<p>
    <label for="H1">Q<?php $i++; echo $i; ?>. Did the closer ask the 'Any condition in the last 5 year' health question and did they record the answers correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($H_Q1)) {  if ($H_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($H_Q1)) {  if ($H_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($H_C1)) { echo $H_C1; } ?>
            </div>    
</p>

<p>
    <label for="H2">Q<?php $i++; echo $i; ?>. Did the closer ask all the 'Have you ever had or do you currently have' health questions and did the closer record the answers correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($H_Q2)) {  if ($H_Q2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($H_Q2)) {  if ($H_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($H_C2)) { echo $H_C2; } ?>
            </div>    
</p>

<p>
    <label for="H3">Q<?php $i++; echo $i; ?>. Did the closer ask all the "any condition in the last 2 years" health questions and did the closer record the answers correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($H_Q3)) {  if ($H_Q3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($H_Q3)) {  if ($H_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($H_C3)) { echo $H_C3; } ?>
            </div>    
</p>

<h3 class="panel-title">Lifestyle</h3>   

<p>
    <label for="L1">Q<?php $i++; echo $i; ?>. Did the closer ask the customer if they intend to partake in any physical hobby or sport?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q1)) {  if ($L_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q1)) {  if ($L_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C1)) { echo $L_C1; } ?>
            </div>    
</p>

<p>
    <label for="L2">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer rides a motorbike, scooter or moped on the road?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q2)) {  if ($L_Q2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q2)) {  if ($L_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C2)) { echo $L_C2; } ?>
            </div>    
</p>

<p>
    <label for="L3">Q<?php $i++; echo $i; ?>. Did the closer ask if customer has been banned from driving for any reason in the last 5 years?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q3)) {  if ($L_Q3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q3)) {  if ($L_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C3)) { echo $L_C3; } ?>
            </div>    
</p>

<p>
    <label for="L4">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer has lived, worked or travelled to the listed areas during the last 5 years?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q4)) {  if ($L_Q4 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q4)) {  if ($L_Q4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C4)) { echo $L_C4; } ?>
            </div>    
</p>

<p>
    <label for="L5">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer intends to travel outside the UK or EU?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q5)) {  if ($L_Q5 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q5)) {  if ($L_Q5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C5)) { echo $L_C5; } ?>
            </div>    
</p>

<p>
    <label for="L6">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer had any existing life cover exceeding £1m or £500k Critical illness?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q6)) {  if ($L_Q6 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q6)) {  if ($L_Q6 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C6)) { echo $L_C6; } ?>
            </div>    
</p>

<p>
    <label for="L7">Q<?php $i++; echo $i; ?>. Did the closer ask the customer how many alcoholic drinks does the customer consume per week and was the answer recorded correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q7)) {  if ($L_Q7 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q7)) {  if ($L_Q7 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C7)) { echo $L_C7; } ?>
            </div>    
</p>

<p>
    <label for="L8">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer has been advised to reduce alcohol consumption?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q8)) {  if ($L_Q8 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q8)) {  if ($L_Q8 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C8)) { echo $L_C8; } ?>
            </div>    
</p>

<p>
    <label for="L9">Q<?php $i++; echo $i; ?>. Did the closer ask if the customer has taken any drugs in the last 10 years?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($L_Q9)) {  if ($L_Q9 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($L_Q9)) {  if ($L_Q9 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($L_C9)) { echo $L_C9; } ?>
            </div>    
</p>

<h3 class="panel-title">Occupation</h3>   

<p>
    <label for="O1">Q<?php $i++; echo $i; ?>. Did the closer ask if the customers is involved in any hazardous duties listed?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($O_Q1)) {  if ($O_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($O_Q1)) {  if ($O_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($O_C1)) { echo $O_C1; } ?>
            </div>    
</p>

<h3 class="panel-title">Price</h3>   

<p>
    <label for="PRI1">Q<?php $i++; echo $i; ?>. Did the closer ask the customer's family history and did they record the answers correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($PRI_Q1)) {  if ($PRI_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($PRI_Q1)) {  if ($PRI_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($PRI_C1)) { echo $PRI_C1; } ?>
            </div>    
</p>

<h3 class="panel-title">Bank Details</h3>   

<p>
    <label for="BD1">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($BD_Q1)) {  if ($BD_Q1 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($BD_Q1)) {  if ($BD_Q1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($BD_C1)) { echo $BD_C1; } ?>
            </div>    
</p>

<p>
    <label for="BD2">Q<?php $i++; echo $i; ?>. Did the CLOSER offer to read the direct debit guarantee?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($BD_Q2)) {  if ($BD_Q2 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($BD_Q2)) {  if ($BD_Q2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($BD_C2)) { echo $BD_C2; } ?>
            </div>    
</p>

<p>
    <label for="BD3">Q<?php $i++; echo $i; ?>. Did the CLOSER offer a preferred premium collection date?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($BD_Q3)) {  if ($BD_Q3 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($BD_Q3)) {  if ($BD_Q3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($BD_C3)) { echo $BD_C3; } ?>
            </div>    
</p>

<p>
    <label for="BD4">Q<?php $i++; echo $i; ?>. Did the CLOSER record the bank details correctly?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($BD_Q4)) {  if ($BD_Q4 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($BD_Q4)) {  if ($BD_Q4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($BD_C4)) { echo $BD_C4; } ?>
            </div>    
</p>

<p>
    <label for="BD5">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label><br>
    <input type="radio" onclick="return false" <?php if(isset($BD_Q5)) {  if ($BD_Q5 == "1") { echo "checked"; } } ?> >Yes
    <input type="radio" onclick="return false" <?php if(isset($BD_Q5)) {  if ($BD_Q5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>
    
            <div class="phpcomments">
                <?php if(isset($BD_C5)) { echo $BD_C5; } ?>
            </div>    
</p>

<h3 class="panel-title">Consolidation Declaration</h3>

<p>
    <label for="CDE1">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label><br>
<input type="radio" name="CDE1" <?php if (isset($DEC_Q1) && $DEC_Q1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="1" id="yesCheckCDET1">Yes
<input type="radio" name="CDE1" <?php if (isset($DEC_Q1) && $DEC_Q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="0" id="noCheckCDET1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($DEC_C1)) { echo $DEC_C1; } ?></div>



<p>
<label for="CDE2">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label><br>
<input type="radio" name="CDE2" <?php if (isset($DEC_Q2) && $DEC_Q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="1" id="yesCheckCDET2">Yes
<input type="radio" name="CDE2" <?php if (isset($DEC_Q2) && $DEC_Q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="0" id="noCheckCDET2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($DEC_C2)) { echo $DEC_C2; } ?></div>


<p>
<label for="CDE3">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label><br>
<input type="radio" name="CDE3" <?php if (isset($DEC_Q3) && $DEC_Q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="1" id="yesCheckCDET3">Yes
<input type="radio" name="CDE3" <?php if (isset($DEC_Q3) && $DEC_Q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="0" id="noCheckCDET3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($DEC_C3)) { echo $DEC_C3; } ?></div>


<p>
<label for="CDE4">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>
<input type="radio" name="CDE4" <?php if (isset($DEC_Q4) && $DEC_Q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="1" id="yesCheckCDET4">Yes
<input type="radio" name="CDE4" <?php if (isset($DEC_Q4) && $DEC_Q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="0" id="noCheckCDET4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($DEC_C4)) { echo $DEC_C4; } ?></div>

<p>
<label for="CDE5">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label><br>
<input type="radio" name="CDE5" <?php if (isset($DEC_Q5) && $DEC_Q5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="1" id="yesCheckCDET5">Yes
<input type="radio" name="CDE5" <?php if (isset($DEC_Q5) && $DEC_Q5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="0" id="noCheckCDET5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($DEC_C5)) { echo $DEC_C5; } ?></div>



<p>
<label for="CDE6">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but LV will write to them with a more specific date?</label><br>
<input type="radio" name="CDE6" <?php if (isset($DEC_Q6) && $DEC_Q6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="1" id="yesCheckCDET6">Yes
<input type="radio" name="CDE6" <?php if (isset($DEC_Q6) && $DEC_Q6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="0" id="noCheckCDET6"><label for="No">No</label>

</p>

<div class="phpcomments"><?php if(isset($DEC_C6)) { echo $DEC_C6; } ?></div>


<p>
<label for="CDE7">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label><br>
<input type="radio" name="CDE7" <?php if (isset($DEC_Q7) && $DEC_Q7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="1" id="yesCheckCDET7">Yes
<input type="radio" name="CDE7" <?php if (isset($DEC_Q7) && $DEC_Q7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="0" id="noCheckCDET7"><label for="No">No</label>
<input type="radio" name="CDE7" <?php if (isset($DEC_Q7) && $DEC_Q7=="N/A") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="N/A" id="yesCheckCDET7">N/A
</p>

<div class="phpcomments"><?php if(isset($DEC_C7)) { echo $DEC_C7; } ?></div>


 <h3 class="panel-title">Quality Control</h3>
 
 <p>
     <label for="QC1">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with LV with client information?</label><br>
<input type="radio" name="QC1" <?php if (isset($QC_Q1) && $QC_Q1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="1" id="yesCheckQCT1">Yes
<input type="radio" name="QC1" <?php if (isset($QC_Q1) && $QC_Q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="0" id="noCheckQCT1"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C1)) { echo $QC_C1; } ?></div>


<p>
<label for="QC2">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label><br>
<input type="radio" name="QC2" <?php if (isset($QC_Q2) && $QC_Q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="1" id="yesCheckQCT2">Yes
<input type="radio" name="QC2" <?php if (isset($QC_Q2) && $QC_Q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="0" id="noCheckQCT2"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C2)) { echo $QC_C2; } ?></div>


<p>
<label for="QC3">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label><br>
<input type="radio" name="QC3" <?php if (isset($QC_Q3) && $QC_Q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="1" id="yesCheckQCT3">Yes
<input type="radio" name="QC3" <?php if (isset($QC_Q3) && $QC_Q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="0" id="noCheckQCT3"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C3)) { echo $QC_C3; } ?></div>


<p>
<label for="QC4">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label><br>
<input type="radio" name="QC4" <?php if (isset($QC_Q4) && $QC_Q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="1" id="yesCheckQCT4">Yes
<input type="radio" name="QC4" <?php if (isset($QC_Q4) && $QC_Q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="0" id="noCheckQCT4"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C4)) { echo $QC_C4; } ?></div>


<p>
<label for="QC5">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label><br>
<input type="radio" name="QC5" <?php if (isset($QC_Q5) && $QC_Q5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="1" id="yesCheckQCT5">Yes
<input type="radio" name="QC5" <?php if (isset($QC_Q5) && $QC_Q5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="0" id="noCheckQCT5"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C5)) { echo $QC_C5; } ?></div>


<p>
<label for="QC6">Q<?php $i++; echo $i; ?>. Closer provided contact details for <?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>?</label><br>
<input type="radio" name="QC6" <?php if (isset($QC_Q6) && $QC_Q6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="1" id="yesCheckQCT6">Yes
<input type="radio" name="QC6" <?php if (isset($QC_Q6) && $QC_Q6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="0" id="noCheckQCT6"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C6)) { echo $QC_C6; } ?></div>


<p>
<label for="QC7">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label><br>
<input type="radio" name="QC7" <?php if (isset($QC_Q7) && $QC_Q7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="1" id="yesCheckQCT7">Yes
<input type="radio" name="QC7" <?php if (isset($QC_Q7) && $QC_Q7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="0" id="noCheckQCT7"><label for="No">No</label>
</p>

<div class="phpcomments"><?php if(isset($QC_C7)) { echo $QC_C7; } ?></div>



       </div>
</div>    

</body>
</html>