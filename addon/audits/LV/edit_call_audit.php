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
                            adl_audits_ref
                        FROM 
                            adl_audits 
                        WHERE 
                            adl_audits_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $LV_AUDIT=$database->single();   
    
    if(isset($LV_AUDIT['adl_audits_date_added'])) {
        
        $LV_DATE=$LV_AUDIT['adl_audits_date_added'];
        
    }
    
    if(isset($LV_AUDIT['adl_audits_auditor'])) {
        
        $LV_AUDITOR=$LV_AUDIT['adl_audits_auditor'];
        
    }

    if(isset($LV_AUDIT['adl_audits_grade'])) {
        
        $LV_GRADE=$LV_AUDIT['adl_audits_grade'];
        
    }

    if(isset($LV_AUDIT['adl_audits_closer'])) {
        
        $LV_CLOSER=$LV_AUDIT['adl_audits_closer'];
        
    }

    if(isset($LV_AUDIT['adl_audits_agent'])) {
        
        $LV_AGENT=$LV_AUDIT['adl_audits_agent'];
        
    }

    if(isset($LV_AUDIT['adl_audits_ref'])) {
        
        $LV_REF=$LV_AUDIT['adl_audits_ref'];
        
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
    $LV_Q_AUDIT=$database->single();   
    
    $SCORE = 0;
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_id'])) {
        $AID_FK=$LV_Q_AUDIT['adl_audit_lv_id'];
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_od1'])) {
        
        $OD_Q1=$LV_Q_AUDIT['adl_audit_lv_od1'];
        
        if($OD_Q1 == "0") {
            $SCORE ++;
            
        }
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_od2'])) {
        
        $OD_Q2=$LV_Q_AUDIT['adl_audit_lv_od2'];
        
        if($OD_Q2 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_od3'])) {
        
        $OD_Q3=$LV_Q_AUDIT['adl_audit_lv_od3'];
        
        if($OD_Q3 == "0") {
            $SCORE ++;
        }        
        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_od4'])) {
        
        $OD_Q4=$LV_Q_AUDIT['adl_audit_lv_od4'];
        
        if($OD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_od5'])) {
        
        $OD_Q5=$LV_Q_AUDIT['adl_audit_lv_od5'];
        
        if($OD_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_icn1'])) {
        
        $ICN_Q1=$LV_Q_AUDIT['adl_audit_lv_icn1'];
        
        if($ICN_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_icn2'])) {
        
        $ICN_Q2=$LV_Q_AUDIT['adl_audit_lv_icn2'];
        
        if($ICN_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_icn3'])) {
        
        $ICN_Q3=$LV_Q_AUDIT['adl_audit_lv_icn3'];
        
        if($ICN_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_icn4'])) {
        
        $ICN_Q4=$LV_Q_AUDIT['adl_audit_lv_icn4'];
        
        if($ICN_Q4 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_icn5'])) {
        
        $ICN_Q5=$LV_Q_AUDIT['adl_audit_lv_icn5'];
        
        if($ICN_Q5 == "Poor") {
            $SCORE ++;
        }         
        
    }    

    if(isset($LV_Q_AUDIT['adl_audit_lv_cd1'])) {
        
        $CD_Q1=$LV_Q_AUDIT['adl_audit_lv_cd1'];
        
        if($CD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_cd2'])) {
        
        $CD_Q2=$LV_Q_AUDIT['adl_audit_lv_cd2'];
        
        if($CD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_cd3'])) {
        
        $CD_Q3=$LV_Q_AUDIT['adl_audit_lv_cd3'];
        
        if($CD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_cd4'])) {
        
        $CD_Q4=$LV_Q_AUDIT['adl_audit_lv_cd4'];
        
         if($CD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_cd5'])) {
        
        $CD_Q5=$LV_Q_AUDIT['adl_audit_lv_cd5'];
        
        if($CD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_cd6'])) {
        
        $CD_Q6=$LV_Q_AUDIT['adl_audit_lv_cd6'];
        
         if($CD_Q6 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_cd7'])) {
        
        $CD_Q7=$LV_Q_AUDIT['adl_audit_lv_cd7'];
        
        if($CD_Q7 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_cd8'])) {
        
        $CD_Q8=$LV_Q_AUDIT['adl_audit_lv_cd8'];
        
        if($CD_Q8 == "0") {
            $SCORE ++;
        }         
        
    }        
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_con1'])) {
        
        $CON_Q1=$LV_Q_AUDIT['adl_audit_lv_con1'];
        
         if($CON_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_con2'])) {
        
        $CON_Q2=$LV_Q_AUDIT['adl_audit_lv_con2'];
        
          if($CON_Q2 == "0") {
            $SCORE ++;
        }        
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_con3'])) {
        
        $CON_Q3=$LV_Q_AUDIT['adl_audit_lv_con3'];
        
          if($CON_Q3 == "0") {
            $SCORE ++;
        }        
        
    }         
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pd1'])) {
        
        $PD_Q1=$LV_Q_AUDIT['adl_audit_lv_pd1'];
        
         if($PD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pd2'])) {
        
        $PD_Q2=$LV_Q_AUDIT['adl_audit_lv_pd2'];
        
         if($PD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pd3'])) {
        
        $PD_Q3=$LV_Q_AUDIT['adl_audit_lv_pd3'];
        
         if($PD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pd4'])) {
        
        $PD_Q4=$LV_Q_AUDIT['adl_audit_lv_pd4'];
        
         if($PD_Q4 == "0") {
            $SCORE ++;
        }         
        
    }     
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pd5'])) {
        
        $PD_Q5=$LV_Q_AUDIT['adl_audit_lv_pd5'];
        
         if($PD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }     
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_h1'])) {
        
        $H_Q1=$LV_Q_AUDIT['adl_audit_lv_h1'];
        
         if($H_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_h2'])) {
        
        $H_Q2=$LV_Q_AUDIT['adl_audit_lv_h2'];
        
         if($H_Q2 == "0") {
            $SCORE ++;
        }        
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_h3'])) {
        
        $H_Q3=$LV_Q_AUDIT['adl_audit_lv_h3'];
        
         if($H_Q3 == "0") {
            $SCORE ++;
        }   
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l1'])) {
        
        $L_Q1=$LV_Q_AUDIT['adl_audit_lv_l1'];
        
         if($L_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l2'])) {
        
        $L_Q2=$LV_Q_AUDIT['adl_audit_lv_l2'];
        
         if($L_Q2 == "0") {
            $SCORE ++;
        }         
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l3'])) {
        
        $L_Q3=$LV_Q_AUDIT['adl_audit_lv_l3'];
        
         if($L_Q3 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l4'])) {
        
        $L_Q4=$LV_Q_AUDIT['adl_audit_lv_l4'];
        
         if($L_Q4 == "0") {
            $SCORE ++;
        }          
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_l5'])) {
        
        $L_Q5=$LV_Q_AUDIT['adl_audit_lv_l5'];
        
         if($L_Q5 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l6'])) {
        
        $L_Q6=$LV_Q_AUDIT['adl_audit_lv_l6'];
        
         if($L_Q6 == "0") {
            $SCORE ++;
        }          
        
    }
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l7'])) {
        
        $L_Q7=$LV_Q_AUDIT['adl_audit_lv_l7'];
        
         if($L_Q7 == "0") {
            $SCORE ++;
        }          
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_l8'])) {
        
        $L_Q8=$LV_Q_AUDIT['adl_audit_lv_l8'];
        
         if($L_Q8 == "0") {
            $SCORE ++;
        }          
        
    }            
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_l9'])) {
        
        $L_Q9=$LV_Q_AUDIT['adl_audit_lv_l9'];
        
         if($L_Q9 == "0") {
            $SCORE ++;
        }          
        
    }           
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_o1'])) {
        
        $O_Q1=$LV_Q_AUDIT['adl_audit_lv_o1'];
        
         if($O_Q1 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_pri1'])) {
        
        $PRI_Q1=$LV_Q_AUDIT['adl_audit_lv_pri1'];
        
         if($PRI_Q1 == "0") {
            $SCORE ++;
        }          
        
    }     

   if(isset($LV_Q_AUDIT['adl_audit_lv_bd1'])) {
        
        $BD_Q1=$LV_Q_AUDIT['adl_audit_lv_bd1'];
        
         if($BD_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_bd2'])) {
        
        $BD_Q2=$LV_Q_AUDIT['adl_audit_lv_bd2'];
        
         if($BD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_bd3'])) {
        
        $BD_Q3=$LV_Q_AUDIT['adl_audit_lv_bd3'];
        
         if($BD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_bd4'])) {
        
        $BD_Q4=$LV_Q_AUDIT['adl_audit_lv_bd4'];
        
         if($BD_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_bd5'])) {
        
        $BD_Q5=$LV_Q_AUDIT['adl_audit_lv_bd5'];
        
         if($BD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
   if(isset($LV_Q_AUDIT['adl_audit_lv_dec1'])) {
        
        $DEC_Q1=$LV_Q_AUDIT['adl_audit_lv_dec1'];
        
          if($DEC_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_dec2'])) {
        
        $DEC_Q2=$LV_Q_AUDIT['adl_audit_lv_dec2'];
        
          if($DEC_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_dec3'])) {
        
        $DEC_Q3=$LV_Q_AUDIT['adl_audit_lv_dec3'];
        
           if($DEC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_dec4'])) {
        
        $DEC_Q4=$LV_Q_AUDIT['adl_audit_lv_dec4'];
        
          if($DEC_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_dec5'])) {
        
        $DEC_Q5=$LV_Q_AUDIT['adl_audit_lv_dec5'];
        
           if($DEC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }   
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_dec6'])) {
        
        $DEC_Q6=$LV_Q_AUDIT['adl_audit_lv_dec6'];
        
          if($DEC_Q6 == "0") {
            $SCORE ++;
        }         
        
    } 

    if(isset($LV_Q_AUDIT['adl_audit_lv_dec7'])) {
        
        $DEC_Q7=$LV_Q_AUDIT['adl_audit_lv_dec7'];
        
          if($DEC_Q7 == "0") {
            $SCORE ++;
        }         
        
    }
   
    
   if(isset($LV_Q_AUDIT['adl_audit_lv_qc1'])) {
        
        $QC_Q1=$LV_Q_AUDIT['adl_audit_lv_qc1'];
        
          if($QC_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_qc2'])) {
        
        $QC_Q2=$LV_Q_AUDIT['adl_audit_lv_qc2'];
        
           if($QC_Q2 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_qc3'])) {
        
        $QC_Q3=$LV_Q_AUDIT['adl_audit_lv_qc3'];
        
          if($QC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_qc4'])) {
        
        $QC_Q4=$LV_Q_AUDIT['adl_audit_lv_qc4'];
        
           if($QC_Q4 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_qc5'])) {
        
        $QC_Q5=$LV_Q_AUDIT['adl_audit_lv_qc5'];
        
          if($QC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($LV_Q_AUDIT['adl_audit_lv_qc6'])) {
        
        $QC_Q6=$LV_Q_AUDIT['adl_audit_lv_qc6'];
        
          if($QC_Q6 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($LV_Q_AUDIT['adl_audit_lv_qc7'])) {
        
        $QC_Q7=$LV_Q_AUDIT['adl_audit_lv_qc7'];
        
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
    $LV_C_AUDIT=$database->single();     
    
   if(isset($LV_C_AUDIT['adl_audit_lv_c_od1'])) {
        
        $OD_C1=$LV_C_AUDIT['adl_audit_lv_c_od1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_od2'])) {
        
        $OD_C2=$LV_C_AUDIT['adl_audit_lv_c_od2'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_od3'])) {
        
        $OD_C3=$LV_C_AUDIT['adl_audit_lv_c_od3'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_od4'])) {
        
        $OD_C4=$LV_C_AUDIT['adl_audit_lv_c_od4'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_od5'])) {
        
        $OD_C5=$LV_C_AUDIT['adl_audit_lv_c_od5'];
        
    }    
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_icn1'])) {
        
        $ICN_C1=$LV_C_AUDIT['adl_audit_lv_c_icn1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_icn2'])) {
        
        $ICN_C2=$LV_C_AUDIT['adl_audit_lv_c_icn2'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_icn3'])) {
        
        $ICN_C3=$LV_C_AUDIT['adl_audit_lv_c_icn3'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_icn4'])) {
        
        $ICN_C4=$LV_C_AUDIT['adl_audit_lv_c_icn4'];
        
    }
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_icn5'])) {
        
        $ICN_C5=$LV_C_AUDIT['adl_audit_lv_c_icn5'];
        
    }    

    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd1'])) {
        
        $CD_C1=$LV_C_AUDIT['adl_audit_lv_c_cd1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd2'])) {
        
        $CD_C2=$LV_C_AUDIT['adl_audit_lv_c_cd2'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd3'])) {
        
        $CD_C3=$LV_C_AUDIT['adl_audit_lv_c_cd3'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd4'])) {
        
        $CD_C4=$LV_C_AUDIT['adl_audit_lv_c_cd4'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd5'])) {
        
        $CD_C5=$LV_C_AUDIT['adl_audit_lv_c_cd5'];
        
    }    
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd6'])) {
        
        $CD_C6=$LV_C_AUDIT['adl_audit_lv_c_cd6'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd7'])) {
        
        $CD_C7=$LV_C_AUDIT['adl_audit_lv_c_cd7'];
        
    }

    if(isset($LV_C_AUDIT['adl_audit_lv_c_cd8'])) {
        
        $CD_C8=$LV_C_AUDIT['adl_audit_lv_c_cd8'];
        
    }
    
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_con1'])) {
        
        $CON_C1=$LV_C_AUDIT['adl_audit_lv_c_con1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_con2'])) {
        
        $CON_C2=$LV_C_AUDIT['adl_audit_lv_c_con2'];
        
    }
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_con3'])) {
        
        $CON_C3=$LV_C_AUDIT['adl_audit_lv_c_con3'];
        
    }   
    
     if(isset($LV_C_AUDIT['adl_audit_lv_c_pd1'])) {
        
        $PD_C1=$LV_C_AUDIT['adl_audit_lv_c_pd1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_pd2'])) {
        
        $PD_C2=$LV_C_AUDIT['adl_audit_lv_c_pd2'];
        
    }
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_pd3'])) {
        
        $PD_C3=$LV_C_AUDIT['adl_audit_lv_c_pd3'];
        
    }   
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_pd4'])) {
        
        $PD_C4=$LV_C_AUDIT['adl_audit_lv_c_pd4'];
        
    } 

    if(isset($LV_C_AUDIT['adl_audit_lv_c_pd5'])) {
        
        $PD_C5=$LV_C_AUDIT['adl_audit_lv_c_pd5'];
        
    } 
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_h1'])) {
        
        $H_C1=$LV_C_AUDIT['adl_audit_lv_c_h1'];
        
    }  
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_h2'])) {
        
        $H_C2=$LV_C_AUDIT['adl_audit_lv_c_h2'];
        
    }
    
    if(isset($LV_C_AUDIT['adl_audit_lv_c_h3'])) {
        
        $H_C3=$LV_C_AUDIT['adl_audit_lv_c_h3'];
        
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
    $LV_CE_AUDIT=$database->single();   
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l1'])) {
        
        $L_C1=$LV_CE_AUDIT['adl_audit_lv_ce_l1'];
        
    }  
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l2'])) {
        
        $L_C2=$LV_CE_AUDIT['adl_audit_lv_ce_l2'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l3'])) {
        
        $L_C3=$LV_CE_AUDIT['adl_audit_lv_ce_l3'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l4'])) {
        
        $L_C4=$LV_CE_AUDIT['adl_audit_lv_ce_l4'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l5'])) {
        
        $L_C5=$LV_CE_AUDIT['adl_audit_lv_ce_l5'];
        
    }    
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l6'])) {
        
        $L_C6=$LV_CE_AUDIT['adl_audit_lv_ce_l6'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l7'])) {
        
        $L_C7=$LV_CE_AUDIT['adl_audit_lv_ce_l7'];
        
    } 

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l8'])) {
        
        $L_C8=$LV_CE_AUDIT['adl_audit_lv_ce_l8'];
        
    } 

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_l9'])) {
        
        $L_C9=$LV_CE_AUDIT['adl_audit_lv_ce_l9'];
        
    }     
    
if(isset($LV_CE_AUDIT['adl_audit_lv_ce_o1'])) {
        
        $O_C1=$LV_CE_AUDIT['adl_audit_lv_ce_o1'];
        
    }  
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_pri1'])) {
        
        $PRI_C1=$LV_CE_AUDIT['adl_audit_lv_ce_pri1'];
        
    }        
    
   if(isset($LV_CE_AUDIT['adl_audit_lv_ce_bd1'])) {
        
        $BD_C1=$LV_CE_AUDIT['adl_audit_lv_ce_bd1'];
        
    }  
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_bd2'])) {
        
        $BD_C2=$LV_CE_AUDIT['adl_audit_lv_ce_bd2'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_bd3'])) {
        
        $BD_C3=$LV_CE_AUDIT['adl_audit_lv_ce_bd3'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_bd4'])) {
        
        $BD_C4=$LV_CE_AUDIT['adl_audit_lv_ce_bd4'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_bd5'])) {
        
        $BD_C5=$LV_CE_AUDIT['adl_audit_lv_ce_bd5'];
        
    }    
    
   if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec1'])) {
        
        $DEC_C1=$LV_CE_AUDIT['adl_audit_lv_ce_dec1'];
        
    }  
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec2'])) {
        
        $DEC_C2=$LV_CE_AUDIT['adl_audit_lv_ce_dec2'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec3'])) {
        
        $DEC_C3=$LV_CE_AUDIT['adl_audit_lv_ce_dec3'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec4'])) {
        
        $DEC_C4=$LV_CE_AUDIT['adl_audit_lv_ce_dec4'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec5'])) {
        
        $DEC_C5=$LV_CE_AUDIT['adl_audit_lv_ce_dec5'];
        
    }   
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec6'])) {
        
        $DEC_C6=$LV_CE_AUDIT['adl_audit_lv_ce_dec6'];
        
    } 

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_dec7'])) {
        
        $DEC_C7=$LV_CE_AUDIT['adl_audit_lv_ce_dec7'];
        
    }     
    
   if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc1'])) {
        
        $QC_C1=$LV_CE_AUDIT['adl_audit_lv_ce_qc1'];
        
    }  
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc2'])) {
        
        $QC_C2=$LV_CE_AUDIT['adl_audit_lv_ce_qc2'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc3'])) {
        
        $QC_C3=$LV_CE_AUDIT['adl_audit_lv_ce_qc3'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc4'])) {
        
        $QC_C4=$LV_CE_AUDIT['adl_audit_lv_ce_qc4'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc5'])) {
        
        $QC_C5=$LV_CE_AUDIT['adl_audit_lv_ce_qc5'];
        
    }    
    
    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc6'])) {
        
        $QC_C6=$LV_CE_AUDIT['adl_audit_lv_ce_qc6'];
        
    }

    if(isset($LV_CE_AUDIT['adl_audit_lv_ce_qc7'])) {
        
        $QC_C7=$LV_CE_AUDIT['adl_audit_lv_ce_qc7'];
        
    } 
    
    $database->endTransaction();   
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | LV Call Audit</title>
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
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script>
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <?php require_once(__DIR__ . '/../../../app/Holidays.php'); ?>

</head>
<body>
    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">

        <form action="php/edit_call_audit.php?EXECUTE=1&AID=<?php echo $AUDITID; ?>&AIDFK=<?php echo $AID_FK; ?>" method="POST" id="AUDIT_FORM" name="AUDIT_FORM" autocomplete="off">

            <fieldset>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Edit LV Closer Call Audit</h3>
                    </div>

                    <div class="panel-body">
                        <p>
                            <label for="CLOSER">Closer</label>
                            <input type="text" class="form-control" name="CLOSER" id="CLOSER" style="width: 520px" value="<?php if(isset($LV_CLOSER)) { echo $LV_CLOSER; } ?>">
                        
<script>var options = {
                                            url: "/../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#CLOSER").easyAutocomplete(options);</script>                        
                        
                        <label for="AGENT">Agent</label>
                        <input type="text" class="form-control" name="AGENT" id="AGENT" style="width: 520px" value="<?php if(isset($LV_AGENT)) { echo $LV_AGENT; } ?>">
                        
    <script>var options = {
                                                            url: "/../../app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };
                                                        $("#AGENT").easyAutocomplete(options);</script>                         

                        <label for="POLICY">Reference</label>
                        <input type="text" class="form-control" name="REFERENCE" style="width: 520px" value="<?php if(isset($LV_REF)) { echo $LV_REF; } ?>">

                        </p>

                        <p>
                        <div class="form-group">
                            <label for='GRADE'>Grade:</label>
                            <select class="form-control" name="GRADE" required>
                                <option <?php if(isset($LV_GRADE) && $LV_GRADE == 'SAVED') { echo "selected"; } ?> value="SAVED">Incomplete Audit (SAVE)</option>
                                <option <?php if(isset($LV_GRADE) && $LV_GRADE == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                                <option <?php if(isset($LV_GRADE) && $LV_GRADE == 'Amber') { echo "selected"; } ?> value="Amber">Amber</option>
                                <option <?php if(isset($LV_GRADE) && $LV_GRADE == 'Red')   { echo "selected"; } ?> value="Red">Red</option>
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
                            <label for="OD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer made aware that calls are recorded for training and quality purposes?</label>
                            <input type="radio" name="OD_Q1" 
                                   <?php if (isset($OD_Q1) && $OD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="1" id="yesCheckOD_C1" required >Yes
                            <input type="radio" name="OD_Q1"
<?php if (isset($OD_Q1) && $OD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="0" id="noCheckOD_C1">No
                        </p>

                        <div id="ifYesOD_C1" >
                            <textarea class="form-control"id="OD_C1" name="OD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($OD_C1)) { echo $OD_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q2" 
<?php if (isset($OD_Q2) && $OD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C2();"
                                   value="1" id="yesCheckOD_C2" required >Yes
                            <input type="radio" name="OD_Q2"
<?php if (isset($OD_Q2) && $OD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C2();"
                                   value="0" id="noCheckOD_C2">No
                        </p>

                        <div id="ifYesOD_C2" >
                            <textarea class="form-control"id="OD_C2" name="OD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($OD_C2)) { echo $OD_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="OD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
                            <input type="radio" name="OD_Q3" 
<?php if (isset($OD_Q3) && $OD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C3();"
                                   value="1" id="yesCheckOD_C3" required >Yes
                            <input type="radio" name="OD_Q3"
<?php if (isset($OD_Q3) && $OD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C3();"
                                   value="0" id="noCheckOD_C3">No
                        </p>

                        <div id="ifYesOD_C3" >
                            <textarea class="form-control"id="OD_C3" name="OD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($OD_C3)) { echo $OD_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER provide the name and details of the firm who is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q4" 
<?php if (isset($OD_Q4) && $OD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C4();"
                                   value="1" id="yesCheckOD_C4" required >Yes
                            <input type="radio" name="OD_Q4"
<?php if (isset($OD_Q4) && $OD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C4();"
                                   value="0" id="noCheckOD_C4">No
                        </p>

                        <div id="ifYesOD_C4" >
                            <textarea class="form-control"id="OD_C4" name="OD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($OD_C4)) { echo $OD_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="OD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
                            <input type="radio" name="OD_Q5" 
<?php if (isset($OD_Q5) && $OD_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C5();"
                                   value="1" id="yesCheckOD_C5" required >Yes
                            <input type="radio" name="OD_Q5"
<?php if (isset($OD_Q5) && $OD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C5();"
                                   value="0" id="noCheckOD_C5">No
                        </p>

                        <div id="ifYesOD_C5" >
                            <textarea class="form-control"id="OD_C5" name="OD_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($OD_C5)) { echo $OD_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="ICN_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer check the customers existing policy details?</label>
                            <input type="radio" name="ICN_Q1" 
                                   <?php if (isset($ICN_Q1) && $ICN_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="1" id="yesCheckICN_C1" required >Yes
                            <input type="radio" name="ICN_Q1"
<?php if (isset($ICN_Q1) && $ICN_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="0" id="noCheckICN_C1">No
<input type="radio" name="ICN_Q1" 
                                   <?php if (isset($ICN_Q1) && $ICN_Q1 == "N/A") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="1" id="yesCheckICN_C1" required >N/A                            
                        </p>

                        <div id="ifYesICN_C1" >
                            <textarea class="form-control"id="ICN_C1" name="ICN_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($ICN_C1)) { echo $ICN_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>



                        <p>
                            <label for="ICN_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer offer additional benefit or even make the customer aware of the benefits/extra's of the new policy?</label>
                            <input type="radio" name="ICN_Q2" 
                                   <?php if (isset($ICN_Q2) && $ICN_Q2 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C2();"
                                   value="1" id="yesCheckICN_C2" required >Yes
                            <input type="radio" name="ICN_Q2"
<?php if (isset($ICN_Q2) && $ICN_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C2();"
                                   value="0" id="noCheckICN_C2">No
                            <input type="radio" name="ICN_Q2" 
<?php if (isset($ICN_Q2) && $ICN_Q2 == "N/A") {
    echo "checked";
} ?>
                                   value="N/A" >N/A
                        </p>

                        <div id="ifYesICN_C2" >
                            <textarea class="form-control"id="ICN_C2" name="ICN_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($ICN_C2)) { echo $ICN_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>


                        <p>
                            <label for="ICN_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ensure that the customer was provided with a policy that met their needs (more cover, cheaper premium, extension of years etc...)?</label>
                            <input type="radio" name="ICN_Q3" 
<?php if (isset($ICN_Q3) && $ICN_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="1" id="yesCheckICN_C3" required >Yes
                            <input type="radio" name="ICN_Q3"
<?php if (isset($ICN_Q3) && $ICN_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="0" id="noCheckICN_C3">No
                        </p>

                        <div id="ifYesICN_C3" >
                            <textarea class="form-control"id="ICN_C3" name="ICN_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($ICN_C3)) { echo $ICN_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="ICN_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm that this policy would be set up with LV?</label>
                            <input type="radio" name="ICN_Q4" 
<?php if (isset($ICN_Q4) && $ICN_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C4();"
                                   value="1" id="yesCheckICN_C4" required >Yes
                            <input type="radio" name="ICN_Q4"
<?php if (isset($ICN_Q4) && $ICN_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C4();"
                                   value="0" id="noCheckICN_C4">No
                        </p>

                        <div id="ifYesICN_C4" >
                            <textarea class="form-control"id="ICN_C4" name="ICN_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($ICN_C4)) { echo $ICN_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
 <p>
                            <label for="ICN_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label>
                            <select class="form-control" name="ICN_Q5" onclick="javascript:yesnoCheckICN_C5();">
                                <option value="N/A">Select...</option>
                                <option value="More than sufficient" <?php if(isset($ICN_Q5) && $ICN_Q5 == 'More than sufficient') { echo "selected"; } ?> >More than sufficient</option>
                                <option value="Sufficient" <?php if(isset($ICN_Q5) && $ICN_Q5 == 'Sufficient') { echo "selected"; } ?> >Sufficient</option>
                                <option value="Adequate" <?php if(isset($ICN_Q5) && $ICN_Q5 == 'Adequate') { echo "selected"; } ?> >Adequate</option>
                                <option value="Poor" <?php if(isset($ICN_Q5) && $ICN_Q5 == 'Poor') { echo "selected"; } ?>  onclick="javascript:yesnoCheckICN_C5a();" id="yesCheckICN_C5">Poor</option>
                            </select>
                        </p>

                        <div id="ifYesICN_C5" >
                            <textarea class="form-control"id="ICN_C5" name="ICN_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($ICN_C5)) { echo $ICN_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>                        
                        
                    </div>
                </div>               
                
  <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Details</h3>
                    </div>
                    <div class="panel-body">

                        <p>
                            <label for="CD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask customer titles?</label>
                            <input type="radio" name="CD_Q1" 
                                   <?php if (isset($CD_Q1) && $CD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="1" id="yesCheckCD_C1" required >Yes
                            <input type="radio" name="CD_Q1"
<?php if (isset($CD_Q1) && $CD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="0" id="noCheckCD_C1">No
                        </p>

                        <div id="ifYesCD_C1" >
                            <textarea class="form-control"id="CD_C1" name="CD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C1)) { echo $CD_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer phonetically check names?</label>
                            <input type="radio" name="CD_Q2" 
<?php if (isset($CD_Q2) && $CD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="1" id="yesCheckCD_C2" required >Yes
                            <input type="radio" name="CD_Q2"
<?php if (isset($CD_Q2) && $CD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="0" id="noCheckCD_C2">No
                        </p>

                        <div id="ifYesCD_C2" >
                            <textarea class="form-control"id="CD_C2" name="CD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C2)) { echo $CD_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer input the correct gender?</label>
                            <input type="radio" name="CD_Q3" 
<?php if (isset($CD_Q3) && $CD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="1" id="yesCheckCD_C3" required >Yes
                            <input type="radio" name="CD_Q3"
<?php if (isset($CD_Q3) && $CD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="0" id="noCheckCD_C3">No
                        </p>

                        <div id="ifYesCD_C3" >
                            <textarea class="form-control"id="CD_C3" name="CD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C3)) { echo $CD_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask and confirm the customers DOB?</label>
                            <input type="radio" name="CD_Q4" 
<?php if (isset($CD_Q4) && $CD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="1" id="yesCheckCD_C4" required >Yes
                            <input type="radio" name="CD_Q4"
<?php if (isset($CD_Q4) && $CD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="0" id="noCheckCD_C4">No
                        </p>

                        <div id="ifYesCD_C4" >
                            <textarea class="form-control"id="CD_C4" name="CD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C4)) { echo $CD_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="CD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers smoking question?</label>
                            <input type="radio" name="CD_Q5" 
<?php if (isset($CD_Q5) && $CD_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C5();"
                                   value="1" id="yesCheckCD_C5" required >Yes
                            <input type="radio" name="CD_Q5"
<?php if (isset($CD_Q5) && $CD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C5();"
                                   value="0" id="noCheckCD_C5">No
                        </p>

                        <div id="ifYesCD_C5" >
                            <textarea class="form-control"id="CD_C5" name="CD_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C5)) { echo $CD_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
              
<p>
                            <label for="CD_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers occupation?</label>
                            <input type="radio" name="CD_Q6" 
<?php if (isset($CD_Q6) && $CD_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="1" id="yesCheckCD_C6" required >Yes
                            <input type="radio" name="CD_Q6"
<?php if (isset($CD_Q6) && $CD_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="0" id="noCheckCD_C6">No
                        </p>

                        <div id="ifYesCD_C6" >
                            <textarea class="form-control"id="CD_C6" name="CD_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C6)) { echo $CD_C6; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>                  
<p>
                            <label for="CD_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer was a UK resident?</label>
                            <input type="radio" name="CD_Q7" 
<?php if (isset($CD_Q7) && $CD_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="1" id="yesCheckCD_C7" required >Yes
                            <input type="radio" name="CD_Q7"
<?php if (isset($CD_Q7) && $CD_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="0" id="noCheckCD_C7">No
                        </p>

                        <div id="ifYesCD_C7" >
                            <textarea class="form-control"id="CD_C7" name="CD_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C7)) { echo $CD_C7; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>  
                                             
 <p>
                            <label for="CD_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm single or joint policy?</label>
                            <input type="radio" name="CD_Q8" 
<?php if (isset($CD_Q8) && $CD_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="1" id="yesCheckCD_C8" required >Yes
                            <input type="radio" name="CD_Q8"
<?php if (isset($CD_Q8) && $CD_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="0" id="noCheckCD_C8">No
                        </p>

                        <div id="ifYesCD_C8" >
                            <textarea class="form-control"id="CD_C8" name="CD_C8" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C8)) { echo $CD_C8; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C8').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                                          
                        
                    </div>
                </div>  
                
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Contact details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="CON_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm the customers address?</label>
                            <input type="radio" name="CON_Q1" 
<?php if (isset($CON_Q1) && $CON_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCON_C1();"
                                   value="1" id="yesCheckCON_C1" required >Yes
                            <input type="radio" name="CON_Q1"
<?php if (isset($CON_Q1) && $CON_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCON_C1();"
                                   value="0" id="noCheckCON_C1">No
                        </p>

                        <div id="ifYesCON_C1" >
                            <textarea class="form-control"id="CON_C1" name="CON_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CON_C1)) { echo $CON_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CON_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="CON_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer get the correct email?</label>
                            <input type="radio" name="CON_Q2" 
<?php if (isset($CON_Q2) && $CON_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCON_C2();"
                                   value="1" id="yesCheckCON_C2" required >Yes
                            <input type="radio" name="CON_Q2"
<?php if (isset($CON_Q2) && $CON_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCON_C2();"
                                   value="0" id="noCheckCON_C2">No
                        </p>

                        <div id="ifYesCON_C2" >
                            <textarea class="form-control"id="CON_C2" name="CON_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CON_C2)) { echo $CON_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CON_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>


                        <p>
                            <label for="CON_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer put the correct marital status in?</label>
                            <input type="radio" name="CON_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($CON_Q3) && $CON_Q3 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck" required >Yes
                            <input type="radio" name="CON_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($CON_Q3) && $CON_Q3 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" >
                            <textarea class="form-control"id="CON_C3" name="CON_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CON_C3)) { echo $CON_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CON_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>   
                
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Personal Details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="PD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers 'Height and Weight' and did they record the answers correctly?</label>
                            <input type="radio" name="PD_Q1" 
<?php if (isset($PD_Q1) && $PD_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C1();"
                                   value="1" id="yesCheckPD_C1" required >Yes
                            <input type="radio" name="PD_Q1"
<?php if (isset($PD_Q1) && $PD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C1();"
                                   value="0" id="noCheckPD_C1">No
                        </p>

                        <div id="ifYesPD_C1" >
                            <textarea class="form-control"id="PD_C1" name="PD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PD_C1)) { echo $PD_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#PD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="PD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers 'Smoking Status' and did they record the answer correctly?</label>
                            <input type="radio" name="PD_Q2" 
<?php if (isset($PD_Q2) && $PD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C2();"
                                   value="1" id="yesCheckPD_C2" required >Yes
                            <input type="radio" name="PD_Q2"
<?php if (isset($PD_Q2) && $PD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C2();"
                                   value="0" id="noCheckPD_C2">No
                        </p>

                        <div id="ifYesPD_C2" >
                            <textarea class="form-control"id="PD_C2" name="PD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PD_C2)) { echo $PD_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#PD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>


                        <p>
                            <label for="PD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer what they had smoked and how many per day in the last 12 months?</label>
                            <input type="radio" name="PD_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($PD_Q3) && $PD_Q3 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck" required >Yes
                            <input type="radio" name="PD_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($PD_Q3) && $PD_Q3 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" >
                            <textarea class="form-control"id="PD_C3" name="PD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PD_C3)) { echo $PD_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#PD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
 <p>
                            <label for="PD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm the customers main job?</label>
                            <input type="radio" name="PD_Q4" onclick="javascript:yesnoCheck<?php echo $QUESTION_NUMBER; ?>();"
<?php if (isset($PD_Q4) && $PD_Q4 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck" required >Yes
                            <input type="radio" name="PD_Q4" onclick="javascript:yesnoCheck<?php echo $QUESTION_NUMBER; ?>();"
<?php if (isset($PD_Q4) && $PD_Q4 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" >
                            <textarea class="form-control"id="PD_C4" name="PD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PD_C4)) { echo $PD_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#PD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

 <p>
                            <label for="PD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer's family history and did they record the answered correctly?</label>
                            <input type="radio" name="PD_Q5" onclick="javascript:yesnoCheck<?php echo $QUESTION_NUMBER; ?>();"
<?php if (isset($PD_Q5) && $PD_Q5 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck" required >Yes
                            <input type="radio" name="PD_Q5" onclick="javascript:yesnoCheck<?php echo $QUESTION_NUMBER; ?>();"
<?php if (isset($PD_Q5) && $PD_Q5 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" >
                            <textarea class="form-control"id="PD_C5" name="PD_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PD_C5)) { echo $PD_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#PD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="H_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the 'Any condition in the last 5 year' health question and did they record the answers correctly?</label>
                            <input type="radio" name="H_Q1" 
<?php if (isset($H_Q1) && $H_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C1();"
                                   value="1" id="yesCheckH_C1" required >Yes
                            <input type="radio" name="H_Q1"
<?php if (isset($H_Q1) && $H_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C1();"
                                   value="0" id="noCheckH_C1">No
                        </p>

                        <div id="ifYesH_C1" >
                            <textarea class="form-control"id="H_C1" name="H_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($H_C1)) { echo $H_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="H_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask all the 'Have you ever had or do you currently have' health questions and did the closer record the answers correctly?</label>
                            <input type="radio" name="H_Q2" 
<?php if (isset($H_Q2) && $H_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C2();"
                                   value="1" id="yesCheckH_C2" required >Yes
                            <input type="radio" name="H_Q2"
<?php if (isset($H_Q2) && $H_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C2();"
                                   value="0" id="noCheckH_C2">No
                            
                        </p>

                        <div id="ifYesH_C2" >
                            <textarea class="form-control"id="H_C2" name="H_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($H_C2)) { echo $H_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="H_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask all the "any condition in the last 2 years" health questions and did the closer record the answers correctly?</label>
                            <input type="radio" name="H_Q3" 
<?php if (isset($H_Q3) && $H_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C3();"
                                   value="1" id="yesCheckH_C3" required >Yes
                            <input type="radio" name="H_Q3"
<?php if (isset($H_Q3) && $H_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C3();"
                                   value="0" id="noCheckH_C3">No
                            
                        </p>

                        <div id="ifYesH_C3" >
                            <textarea class="form-control"id="H_C3" name="H_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($H_C3)) { echo $H_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>                   
                        
                    </div>
                </div>                      
                
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lifestyle</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="L_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they intend to partake in any physical hobby or sport?</label>
                            <input type="radio" name="L_Q1" 
<?php if (isset($L_Q1) && $L_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C1();"
                                   value="1" id="yesCheckL_C1" required >Yes
                            <input type="radio" name="L_Q1"
<?php if (isset($L_Q1) && $L_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C1();"
                                   value="0" id="noCheckL_C1">No
                        </p>

                        <div id="ifYesL_C1" >
                            <textarea class="form-control"id="L_C1" name="L_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C1)) { echo $L_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="L_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer rides a motorbike, scooter or moped on the road?</label>
                            <input type="radio" name="L_Q2" <?php if (isset($L_Q2) && $L_Q2 == 1 ) { echo "checked"; } ?> value="1" required >Yes
                            <input type="radio" name="L_Q2" <?php if (isset($L_Q2) && $L_Q2 == 0 ) { echo "checked"; } ?> value="0" >No
                        </p>

                        <div id="ifYesL_C2" >
                            <textarea class="form-control"id="L_C2" name="L_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C2)) { echo $L_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                        <p>
                            <label for="L_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if customer has been banned from driving for any reason in the last 5 years?</label>
                            <input type="radio" name="L_Q3" <?php if (isset($L_Q3) && $L_Q3 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C3" required >Yes
                            <input type="radio" name="L_Q3" <?php if (isset($L_Q3) && $L_Q3 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C3">No
                        </p>

                        <div id="ifYesL_C3" >
                            <textarea class="form-control"id="L_C3" name="L_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C3)) { echo $L_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>    
                        
   <p>
                            <label for="L_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has lived, worked or travelled to the listed areas during the last 5 years?</label>
                            <input type="radio" name="L_Q4" <?php if (isset($L_Q4) && $L_Q4 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C4" required >Yes
                            <input type="radio" name="L_Q4" <?php if (isset($L_Q4) && $L_Q4 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C4">No
                        </p>

                        <div id="ifYesL_C4" >
                            <textarea class="form-control"id="L_C4" name="L_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C4)) { echo $L_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>   

<p>
                            <label for="L_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer intends to travel outside the UK or EU?</label>
                            <input type="radio" name="L_Q5" <?php if (isset($L_Q5) && $L_Q5 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C5" required >Yes
                            <input type="radio" name="L_Q5" <?php if (isset($L_Q5) && $L_Q5 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C5">No
                        </p>

                        <div id="ifYesL_C5" >
                            <textarea class="form-control"id="L_C5" name="L_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C5)) { echo $L_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>      
                        
<p>
                            <label for="L_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer had any existing life cover exceeding £1m or £500k Critical illness?</label>
                            <input type="radio" name="L_Q6" <?php if (isset($L_Q6) && $L_Q6 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C6" required >Yes
                            <input type="radio" name="L_Q6" <?php if (isset($L_Q6) && $L_Q6 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C6">No
                            <input type="radio" name="L_Q6" <?php if (isset($L_Q6) && $L_Q6 == "N/A") { echo "checked"; } ?> value="N/A" >N/A
                        </p>

                        <div id="ifYesL_C6" >
                            <textarea class="form-control"id="L_C6" name="L_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C6)) { echo $L_C6; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>      
                        
 <p>
                            <label for="L_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer how many alcoholic drinks does the customer consume per week and was the answer recorded correctly?</label>
                            <input type="radio" name="L_Q7" <?php if (isset($L_Q7) && $L_Q7 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C7" required >Yes
                            <input type="radio" name="L_Q7" <?php if (isset($L_Q7) && $L_Q7 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C7">No
                        </p>

                        <div id="ifYesL_C7" >
                            <textarea class="form-control"id="L_C7" name="L_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C7)) { echo $L_C7; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>                        
                        
 <p>
                            <label for="L_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has been advised to reduce alcohol consumption?</label>
                            <input type="radio" name="L_Q8" <?php if (isset($L_Q8) && $L_Q8 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C8" required >Yes
                            <input type="radio" name="L_Q8" <?php if (isset($L_Q8) && $L_Q8 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C8">No
                        </p>

                        <div id="ifYesL_C8" >
                            <textarea class="form-control"id="L_C8" name="L_C8" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C8)) { echo $L_C8; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C8').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>  
                        
                <label for="L_Q9">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has taken any drugs in the last 10 years?</label>
                            <input type="radio" name="L_Q9" <?php if (isset($L_Q9) && $L_Q9 == 1) { echo "checked"; } ?> value="1" id="yesCheckL_C9" required >Yes
                            <input type="radio" name="L_Q9" <?php if (isset($L_Q9) && $L_Q9 == 0 ) { echo "checked"; } ?> value="0" id="noCheckL_C9">No
                        </p>

                        <div id="ifYesL_C9" >
                            <textarea class="form-control"id="L_C9" name="L_C9" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($L_C9)) { echo $L_C9; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C9').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>             
                        
                    </div>
                </div>   

 <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Occupation</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="O_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customers is involved in any hazardous duties listed?</label>
                            <input type="radio" name="O_Q1" 
                                   <?php if (isset($O_Q1) && $O_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckO_C1();"
                                   value="1" id="yesCheckO_C1" required >Yes
                            <input type="radio" name="O_Q1"
<?php if (isset($O_Q1) && $O_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C1();"
                                   value="0" id="noCheckO_C1">No
                        </p>

                        <div id="ifYesO_C1" >
                            <textarea class="form-control"id="O_C1" name="O_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($O_C1)) { echo $O_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#O_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                       
                    </div>
                </div>                    
                
 <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Price</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="PRI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer's family history and did they record the answers correctly?</label>
                            <input type="radio" name="PRI_Q1" 
<?php if (isset($PRI_Q1) && $PRI_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPRI_C1();"
                                   value="1" id="yesCheckPRI_C1" required >Yes
                            <input type="radio" name="PRI_Q1"
<?php if (isset($PRI_Q1) && $PRI_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPRI_C1();"
                                   value="0" id="noCheckPRI_C1">No
                        </p>

                        <div id="ifYesPRI_C1" >
                            <textarea class="form-control"id="PRI_C1" name="PRI_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($PRI_C1)) { echo $PRI_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_33" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_34').text('1000 characters left');
                                $('#PRI_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_34').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_34').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_34').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_34').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                </div>  

<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bank details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="BD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients policy start date accurately recorded?</label>
                            <input type="radio" name="BD_Q1" 
                                   <?php if (isset($BD_Q1) && $BD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C1();"
                                   value="1" id="yesCheckBD_C1" required >Yes
                            <input type="radio" name="BD_Q1"
<?php if (isset($BD_Q1) && $BD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C1();"
                                   value="0" id="noCheckBD_C1">No
                        </p>

                        <div id="ifYesBD_C1" >
                            <textarea class="form-control"id="BD_C1" name="BD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($BD_C1)) { echo $BD_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="BD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer to read the direct debit guarantee?</label>
                            <input type="radio" name="BD_Q2" 
<?php if (isset($BD_Q2) && $BD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C2();"
                                   value="1" id="yesCheckBD_C2" required >Yes
                            <input type="radio" name="BD_Q2"
<?php if (isset($BD_Q2) && $BD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C2();"
                                   value="0" id="noCheckBD_C2">No
                        </p>

                        <div id="ifYesBD_C2" >
                            <textarea class="form-control"id="BD_C2" name="BD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($BD_C2)) { echo $BD_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="BD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer a preferred premium collection date?</label>
                            <input type="radio" name="BD_Q3" 
<?php if (isset($BD_Q3) && $BD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C3();"
                                   value="1" id="yesCheckBD_C3" required >Yes
                            <input type="radio" name="BD_Q3"
                                   <?php if (isset($BD_Q3) && $BD_Q3 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C3();"
                                   value="0" id="noCheckBD_C3">No
                        </p>

                        <div id="ifYesBD_C3" >
                            <textarea class="form-control"id="BD_C3" name="BD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($BD_C3)) { echo $BD_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="BD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER record the bank details correctly?</label>
                            <input type="radio" name="BD_Q4" 
<?php if (isset($BD_Q4) && $BD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C4();"
                                   value="1" id="yesCheckBD_C4" required >Yes
                            <input type="radio" name="BD_Q4"
                                   <?php if (isset($BD_Q4) && $BD_Q4 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C4();"
                                   value="0" id="noCheckBD_C4">No
                        </p>

                        <div id="ifYesBD_C4" >
                            <textarea class="form-control"id="BD_C4" name="BD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($BD_C4)) { echo $BD_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <p>
                            <label for="BD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did they have consent off the premium payer?</label>
                            <input type="radio" name="BD_Q5" 
                                   <?php if (isset($BD_Q5) && $BD_Q5 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C5();"
                                   value="1" id="yesCheckBD_C5" required >Yes
                            <input type="radio" name="BD_Q5"
<?php if (isset($BD_Q5) && $BD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C5();"
                                   value="0" id="noCheckBD_C5">No
                        </p>

                        <div id="ifYesBD_C5" >
                            <textarea class="form-control"id="BD_C5" name="BD_C5" rows="1" cols="75" maxlength="11000" onkeyup="textAreaAdjust(this)"><?php if(isset($BD_C5)) { echo $BD_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="DEC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                            <input type="radio" name="DEC_Q1" 
<?php if (isset($DEC_Q1) && $DEC_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C1();"
                                   value="1" id="yesCheckDEC_C1" required >Yes
                            <input type="radio" name="DEC_Q1"
<?php if (isset($DEC_Q1) && $DEC_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C1();"
                                   value="0" id="noCheckDEC_C1">No
                        </p>

                        <div id="ifYesDEC_C1" >
                            <textarea class="form-control"id="DEC_C1" name="DEC_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C1)) { echo $DEC_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>


                        <p>
                            <label for="DEC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                            <input type="radio" name="DEC_Q2" 
<?php if (isset($DEC_Q2) && $DEC_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C2();"
                                   value="1" id="yesCheckDEC_C2" required >Yes
                            <input type="radio" name="DEC_Q2"
<?php if (isset($DEC_Q2) && $DEC_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C2();"
                                   value="0" id="noCheckDEC_C2">No
                        </p>

                        <div id="ifYesDEC_C2" >
                            <textarea class="form-control"id="DEC_C2" name="DEC_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C2)) { echo $DEC_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="DEC_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Like mentioned earlier did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                            <input type="radio" name="DEC_Q3" 
<?php if (isset($DEC_Q3) && $DEC_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C3();"
                                   value="1" id="yesCheckDEC_C3" required >Yes
                            <input type="radio" name="DEC_Q3"
<?php if (isset($DEC_Q3) && $DEC_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C3();"
                                   value="0" id="noCheckDEC_C3">No
                        </p>

                        <div id="ifYesDEC_C3" >
                            <textarea class="form-control"id="DEC_C3" name="DEC_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C3)) { echo $DEC_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="DEC_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
                            <input type="radio" name="DEC_Q4" 
<?php if (isset($DEC_Q4) && $DEC_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C4();"
                                   value="1" id="yesCheckDEC_C4" required >Yes
                            <input type="radio" name="DEC_Q4"
<?php if (isset($DEC_Q4) && $DEC_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C4();"
                                   value="0" id="noCheckDEC_C4">No
                        </p>

                        <div id="ifYesDEC_C4" >
                            <textarea class="form-control"id="DEC_C4" name="DEC_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C4)) { echo $DEC_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="DEC_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the check your details procedure?</label>
                            <input type="radio" name="DEC_Q5" 
<?php if (isset($DEC_Q5) && $DEC_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C5();"
                                   value="1" id="yesCheckDEC_C5" required >Yes
                            <input type="radio" name="DEC_Q5"
<?php if (isset($DEC_Q5) && $DEC_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C5();"
                                   value="0" id="noCheckDEC_C5">No
                        </p>

                        <div id="ifYesDEC_C5" >
                            <textarea class="form-control"id="DEC_C5" name="DEC_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C5)) { echo $DEC_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="DEC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but LV will write to them with a more specific date?</label>
                            <input type="radio" name="DEC_Q6" 
<?php if (isset($DEC_Q6) && $DEC_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C6();"
                                   value="1" id="yesCheckDEC_C6" required >Yes
                            <input type="radio" name="DEC_Q6"
<?php if (isset($DEC_Q6) && $DEC_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C6();"
                                   value="0" id="noCheckDEC_C6">No

                        </p>

                        <div id="ifYesDEC_C6" >
                            <textarea class="form-control"id="DEC_C6" name="DEC_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C6)) { echo $DEC_C6; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_47').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="DEC_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm to the customer to cancel any existing direct debit?</label>
                            <input type="radio" name="DEC_Q7" 
<?php if (isset($DEC_Q7) && $DEC_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="1" id="yesCheckDEC_C7" required >Yes
                            <input type="radio" name="DEC_Q7"
<?php if (isset($DEC_Q7) && $DEC_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="0" id="noCheckDEC_C7">No
                            <input type="radio" name="DEC_Q7" 
                                   <?php if (isset($DEC_Q7) && $DEC_Q7 == "N/A") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="N/A" id="yesCheckDEC_C7">N/A
                        </p>

                        <div id="ifYesDEC_C7" >
                            <textarea class="form-control"id="DEC_C7" name="DEC_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($DEC_C7)) { echo $DEC_C7; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
<?php if (isset($QC_Q1) && $QC_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_Q2();"
                                   value="1" id="yesCheckQC_Q2" required >Yes
                            <input type="radio" name="QC_Q1"
<?php if (isset($QC_Q1) && $QC_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_Q2();"
                                   value="0" id="noCheckQC_Q2">No
                        </p>

                        <div id="ifYesQC_C1" >
                            <textarea class="form-control"id="QC_C1" name="QC_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C1)) { echo $QC_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed length of policy in years with client confirmation?</label>
                            <input type="radio" name="QC_Q2" 
<?php if (isset($QC_Q2) && $QC_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C2();"
                                   value="1" id="yesCheckQC_C2" required >Yes
                            <input type="radio" name="QC_Q2"
<?php if (isset($QC_Q2) && $QC_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C2();"
                                   value="0" id="noCheckQC_C2">No
                        </p>

                        <div id="ifYesQC_C2" >
                            <textarea class="form-control"id="QC_C2" name="QC_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C2)) { echo $QC_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
                            <input type="radio" name="QC_Q3" 
<?php if (isset($QC_Q3) && $QC_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C3();"
                                   value="1" id="yesCheckQC_C3" required >Yes
                            <input type="radio" name="QC_Q3"
<?php if (isset($QC_Q3) && $QC_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C3();"
                                   value="0" id="noCheckQC_C3">No
                        </p>

                        <div id="ifYesQC_C3" >
                            <textarea class="form-control"id="QC_C3" name="QC_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C3)) { echo $QC_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
                            <input type="radio" name="QC_Q4" 
<?php if (isset($QC_Q4) && $QC_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C4();"
                                   value="1" id="yesCheckQC_C4" required >Yes
                            <input type="radio" name="QC_Q4"
<?php if (isset($QC_Q4) && $QC_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C4();"
                                   value="0" id="noCheckQC_C4">No
                        </p>

                        <div id="ifYesQC_C4" >
                            <textarea class="form-control"id="QC_C4" name="QC_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C4)) { echo $QC_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
                            <input type="radio" name="QC_Q5" 
<?php if (isset($QC_Q5) && $QC_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C5();"
                                   value="1" id="yesCheckQC_C5" required >Yes
                            <input type="radio" name="QC_Q5"
<?php if (isset($QC_Q5) && $QC_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C5();"
                                   value="0" id="noCheckQC_C5">No
                        </p>

                        <div id="ifYesQC_C5" >
                            <textarea class="form-control"id="QC_C5" name="QC_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C5)) { echo $QC_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer provided contact details for <?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>?</label>
                            <input type="radio" name="QC_Q6" 
<?php if (isset($QC_Q6) && $QC_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="1" id="yesCheckQC_C6" required >Yes
                            <input type="radio" name="QC_Q6"
<?php if (isset($QC_Q6) && $QC_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="0" id="noCheckQC_C6">No
                        </p>

                        <div id="ifYesQC_C6" >
                            <textarea class="form-control"id="QC_C6" name="QC_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C6)) { echo $QC_C6; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>

                        <p>
                            <label for="QC_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
                            <input type="radio" name="QC_Q7" 
<?php if (isset($QC_Q7) && $QC_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C7();"
                                   value="1" id="yesCheckQC_C7" required >Yes
                            <input type="radio" name="QC_Q7"
<?php if (isset($QC_Q7) && $QC_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C7();"
                                   value="0" id="noCheckQC_C7">No
                        </p>

                        <div id="ifYesQC_C7" >
                            <textarea class="form-control"id="QC_C7" name="QC_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($QC_C7)) { echo $QC_C7; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
            title: "Update LV audit?",
            text: "Save and update LV audit!",
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