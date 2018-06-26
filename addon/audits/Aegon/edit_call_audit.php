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
        adl_audit_aegon_id,
        adl_audit_aegon_od1, 
        adl_audit_aegon_od2, 
        adl_audit_aegon_od3, 
        adl_audit_aegon_od4, 
        adl_audit_aegon_od5, 
        adl_audit_aegon_icn1, 
        adl_audit_aegon_icn2, 
        adl_audit_aegon_icn3, 
        adl_audit_aegon_icn4, 
        adl_audit_aegon_icn5, 
        adl_audit_aegon_cd1, 
        adl_audit_aegon_cd2, 
        adl_audit_aegon_cd3, 
        adl_audit_aegon_cd4, 
        adl_audit_aegon_cd5, 
        adl_audit_aegon_cd6, 
        adl_audit_aegon_cd7, 
        adl_audit_aegon_cd8, 
        adl_audit_aegon_cd9, 
        adl_audit_aegon_cd10, 
        adl_audit_aegon_pd1, 
        adl_audit_aegon_pd2, 
        adl_audit_aegon_pd3, 
        adl_audit_aegon_pd4, 
        adl_audit_aegon_pd5, 
        adl_audit_aegon_md1, 
        adl_audit_aegon_md2, 
        adl_audit_aegon_md3, 
        adl_audit_aegon_md4, 
        adl_audit_aegon_h1, 
        adl_audit_aegon_h2, 
        adl_audit_aegon_h3, 
        adl_audit_aegon_h4, 
        adl_audit_aegon_h5, 
        adl_audit_aegon_d1, 
        adl_audit_aegon_d2, 
        adl_audit_aegon_d3, 
        adl_audit_aegon_d4, 
        adl_audit_aegon_bd1, 
        adl_audit_aegon_bd2, 
        adl_audit_aegon_bd3, 
        adl_audit_aegon_bd4, 
        adl_audit_aegon_bd5, 
        adl_audit_aegon_dec1, 
        adl_audit_aegon_dec2, 
        adl_audit_aegon_dec3, 
        adl_audit_aegon_dec4, 
        adl_audit_aegon_dec5, 
        adl_audit_aegon_dec6, 
        adl_audit_aegon_dec7, 
        adl_audit_aegon_qc1, 
        adl_audit_aegon_qc2, 
        adl_audit_aegon_qc3, 
        adl_audit_aegon_qc4, 
        adl_audit_aegon_qc5, 
        adl_audit_aegon_qc6, 
        adl_audit_aegon_qc7
  FROM
    adl_audit_aegon
  WHERE
    adl_audit_aegon_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_Q_AUDIT=$database->single();   
    
    $SCORE = 0;
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_id'])) {
        $AID_FK=$VIT_Q_AUDIT['adl_audit_aegon_id'];
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_od1'])) {
        
        $OD_Q1=$VIT_Q_AUDIT['adl_audit_aegon_od1'];
        
        if($OD_Q1 == "0") {
            $SCORE ++;
            
        }
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_od2'])) {
        
        $OD_Q2=$VIT_Q_AUDIT['adl_audit_aegon_od2'];
        
        if($OD_Q2 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_od3'])) {
        
        $OD_Q3=$VIT_Q_AUDIT['adl_audit_aegon_od3'];
        
        if($OD_Q3 == "0") {
            $SCORE ++;
        }        
        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_od4'])) {
        
        $OD_Q4=$VIT_Q_AUDIT['adl_audit_aegon_od4'];
        
        if($OD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_od5'])) {
        
        $OD_Q5=$VIT_Q_AUDIT['adl_audit_aegon_od5'];
        
        if($OD_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_icn1'])) {
        
        $ICN_Q1=$VIT_Q_AUDIT['adl_audit_aegon_icn1'];
        
        if($ICN_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_icn2'])) {
        
        $ICN_Q2=$VIT_Q_AUDIT['adl_audit_aegon_icn2'];
        
        if($ICN_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_icn3'])) {
        
        $ICN_Q3=$VIT_Q_AUDIT['adl_audit_aegon_icn3'];
        
        if($ICN_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_icn4'])) {
        
        $ICN_Q4=$VIT_Q_AUDIT['adl_audit_aegon_icn4'];
        
        if($ICN_Q4 == "Poor") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_icn5'])) {
        
        $ICN_Q5=$VIT_Q_AUDIT['adl_audit_aegon_icn5'];
        
        if($ICN_Q5 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd1'])) {
        
        $CD_Q1=$VIT_Q_AUDIT['adl_audit_aegon_cd1'];
        
        if($CD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd2'])) {
        
        $CD_Q2=$VIT_Q_AUDIT['adl_audit_aegon_cd2'];
        
        if($CD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd3'])) {
        
        $CD_Q3=$VIT_Q_AUDIT['adl_audit_aegon_cd3'];
        
        if($CD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd4'])) {
        
        $CD_Q4=$VIT_Q_AUDIT['adl_audit_aegon_cd4'];
        
         if($CD_Q4 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd5'])) {
        
        $CD_Q5=$VIT_Q_AUDIT['adl_audit_aegon_cd5'];
        
        if($CD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd6'])) {
        
        $CD_Q6=$VIT_Q_AUDIT['adl_audit_aegon_cd6'];
        
         if($CD_Q6 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd7'])) {
        
        $CD_Q7=$VIT_Q_AUDIT['adl_audit_aegon_cd7'];
        
        if($CD_Q7 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd8'])) {
        
        $CD_Q8=$VIT_Q_AUDIT['adl_audit_aegon_cd8'];
        
        if($CD_Q8 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd9'])) {
        
        $CD_Q9=$VIT_Q_AUDIT['adl_audit_aegon_cd9'];
        
         if($CD_Q9 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_cd10'])) {
        
        $CD_Q10=$VIT_Q_AUDIT['adl_audit_aegon_cd10'];
        
        if($CD_Q10 == "0") {
            $SCORE ++;
        }         
        
    }    
    
    //
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_pd1'])) {
        
        $PD_Q1=$VIT_Q_AUDIT['adl_audit_aegon_pd1'];
        
        if($PD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_pd2'])) {
        
        $PD_Q2=$VIT_Q_AUDIT['adl_audit_aegon_pd2'];
        
        if($PD_Q2 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_pd3'])) {
        
        $PD_Q3=$VIT_Q_AUDIT['adl_audit_aegon_pd3'];
        
        if($PD_Q3 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_pd4'])) {
        
        $PD_Q4=$VIT_Q_AUDIT['adl_audit_aegon_pd4'];
        
        if($PD_Q4 == "0") {
            $SCORE ++;
        }          
        
    }  

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_pd5'])) {
        
        $PD_Q5=$VIT_Q_AUDIT['adl_audit_aegon_pd5'];
        
        if($PD_Q5 == "0") {
            $SCORE ++;
        }          
        
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_md1'])) {
        
        $MD_Q1=$VIT_Q_AUDIT['adl_audit_aegon_md1'];
        
        if($MD_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_md2'])) {
        
        $MD_Q2=$VIT_Q_AUDIT['adl_audit_aegon_md2'];
        
        if($MD_Q2 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_md3'])) {
        
        $MD_Q3=$VIT_Q_AUDIT['adl_audit_aegon_md3'];
        
        if($MD_Q3 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_md4'])) {
        
        $MD_Q4=$VIT_Q_AUDIT['adl_audit_aegon_md4'];
        
        if($MD_Q4 == "0") {
            $SCORE ++;
        }          
        
    }   
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_h1'])) {
        
        $H_Q1=$VIT_Q_AUDIT['adl_audit_aegon_h1'];
        
        if($H_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_h2'])) {
        
        $H_Q2=$VIT_Q_AUDIT['adl_audit_aegon_h2'];
        
        if($H_Q2 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_h3'])) {
        
        $H_Q3=$VIT_Q_AUDIT['adl_audit_aegon_h3'];
        
        if($H_Q3 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_h4'])) {
        
        $H_Q4=$VIT_Q_AUDIT['adl_audit_aegon_h4'];
        
        if($H_Q4 == "0") {
            $SCORE ++;
        }          
        
    }  

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_h5'])) {
        
        $H_Q5=$VIT_Q_AUDIT['adl_audit_aegon_h5'];
        
        if($H_Q5 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_d1'])) {
        
        $D_Q1=$VIT_Q_AUDIT['adl_audit_aegon_d1'];
        
        if($D_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_d2'])) {
        
        $D_Q2=$VIT_Q_AUDIT['adl_audit_aegon_d2'];
        
        if($D_Q2 == "0") {
            $SCORE ++;
        }          
        
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_d3'])) {
        
        $D_Q3=$VIT_Q_AUDIT['adl_audit_aegon_d3'];
        
        if($D_Q3 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_d4'])) {
        
        $D_Q4=$VIT_Q_AUDIT['adl_audit_aegon_d4'];
        
        if($D_Q4 == "0") {
            $SCORE ++;
        }          
        
    }  
    
    
    //
    
   if(isset($VIT_Q_AUDIT['adl_audit_aegon_bd1'])) {
        
        $BD_Q1=$VIT_Q_AUDIT['adl_audit_aegon_bd1'];
        
         if($BD_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_bd2'])) {
        
        $BD_Q2=$VIT_Q_AUDIT['adl_audit_aegon_bd2'];
        
         if($BD_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_bd3'])) {
        
        $BD_Q3=$VIT_Q_AUDIT['adl_audit_aegon_bd3'];
        
         if($BD_Q3 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_bd4'])) {
        
        $BD_Q4=$VIT_Q_AUDIT['adl_audit_aegon_bd4'];
        
         if($BD_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_bd5'])) {
        
        $BD_Q5=$VIT_Q_AUDIT['adl_audit_aegon_bd5'];
        
         if($BD_Q5 == "0") {
            $SCORE ++;
        }         
        
    }    
    
   if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec1'])) {
        
        $DEC_Q1=$VIT_Q_AUDIT['adl_audit_aegon_dec1'];
        
          if($DEC_Q1 == "0") {
            $SCORE ++;
        }        
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec2'])) {
        
        $DEC_Q2=$VIT_Q_AUDIT['adl_audit_aegon_dec2'];
        
          if($DEC_Q2 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec3'])) {
        
        $DEC_Q3=$VIT_Q_AUDIT['adl_audit_aegon_dec3'];
        
           if($DEC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec4'])) {
        
        $DEC_Q4=$VIT_Q_AUDIT['adl_audit_aegon_dec4'];
        
          if($DEC_Q4 == "0") {
            $SCORE ++;
        }         
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec5'])) {
        
        $DEC_Q5=$VIT_Q_AUDIT['adl_audit_aegon_dec5'];
        
           if($DEC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }   
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec6'])) {
        
        $DEC_Q6=$VIT_Q_AUDIT['adl_audit_aegon_dec6'];
        
          if($DEC_Q6 == "0") {
            $SCORE ++;
        }         
        
    } 

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_dec7'])) {
        
        $DEC_Q7=$VIT_Q_AUDIT['adl_audit_aegon_dec7'];
        
          if($DEC_Q7 == "0") {
            $SCORE ++;
        }         
        
    }     
    
   if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc1'])) {
        
        $QC_Q1=$VIT_Q_AUDIT['adl_audit_aegon_qc1'];
        
          if($QC_Q1 == "0") {
            $SCORE ++;
        }         
        
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc2'])) {
        
        $QC_Q2=$VIT_Q_AUDIT['adl_audit_aegon_qc2'];
        
           if($QC_Q2 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc3'])) {
        
        $QC_Q3=$VIT_Q_AUDIT['adl_audit_aegon_qc3'];
        
          if($QC_Q3 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc4'])) {
        
        $QC_Q4=$VIT_Q_AUDIT['adl_audit_aegon_qc4'];
        
           if($QC_Q4 == "0") {
            $SCORE ++;
        }       
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc5'])) {
        
        $QC_Q5=$VIT_Q_AUDIT['adl_audit_aegon_qc5'];
        
          if($QC_Q5 == "0") {
            $SCORE ++;
        }        
        
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc6'])) {
        
        $QC_Q6=$VIT_Q_AUDIT['adl_audit_aegon_qc6'];
        
          if($QC_Q6 == "0") {
            $SCORE ++;
        }        
        
    }

    if(isset($VIT_Q_AUDIT['adl_audit_aegon_qc7'])) {
        
        $QC_Q7=$VIT_Q_AUDIT['adl_audit_aegon_qc7'];
        
           if($QC_Q7 == "0") {
            $SCORE ++;
        }       
        
    }     

    $database->query("SELECT
        adl_audit_aegon_c_od1, 
        adl_audit_aegon_c_od2, 
        adl_audit_aegon_c_od3, 
        adl_audit_aegon_c_od4, 
        adl_audit_aegon_c_od5, 
        adl_audit_aegon_c_icn1, 
        adl_audit_aegon_c_icn2, 
        adl_audit_aegon_c_icn3, 
        adl_audit_aegon_c_icn4, 
        adl_audit_aegon_c_icn5, 
        adl_audit_aegon_c_cd1, 
        adl_audit_aegon_c_cd2,
        adl_audit_aegon_c_cd3, 
        adl_audit_aegon_c_cd4, 
        adl_audit_aegon_c_cd5,
        adl_audit_aegon_c_cd6,
        adl_audit_aegon_c_cd7, 
        adl_audit_aegon_c_cd8, 
        adl_audit_aegon_c_cd9, 
        adl_audit_aegon_c_cd10, 
        adl_audit_aegon_c_pd1, 
        adl_audit_aegon_c_pd2, 
        adl_audit_aegon_c_pd3, 
        adl_audit_aegon_c_pd4, 
        adl_audit_aegon_c_pd5, 
        adl_audit_aegon_c_md1, 
        adl_audit_aegon_c_md2, 
        adl_audit_aegon_c_md3, 
        adl_audit_aegon_c_md4        
                        FROM 
                            adl_audit_aegon_c 
                        WHERE 
                            adl_audit_aegon_c_id_fk=:AUDITID");
    $database->bind(':AUDITID', $AID_FK);
    $database->execute();
    $VIT_C_AUDIT=$database->single();     
    
   if(isset($VIT_C_AUDIT['adl_audit_aegon_c_od1'])) {
        
        $OD_C1=$VIT_C_AUDIT['adl_audit_aegon_c_od1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_od2'])) {
        
        $OD_C2=$VIT_C_AUDIT['adl_audit_aegon_c_od2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_od3'])) {
        
        $OD_C3=$VIT_C_AUDIT['adl_audit_aegon_c_od3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_od4'])) {
        
        $OD_C4=$VIT_C_AUDIT['adl_audit_aegon_c_od4'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_od5'])) {
        
        $OD_C5=$VIT_C_AUDIT['adl_audit_aegon_c_od5'];
        
    }    
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_icn1'])) {
        
        $ICN_C1=$VIT_C_AUDIT['adl_audit_aegon_c_icn1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_icn2'])) {
        
        $ICN_C2=$VIT_C_AUDIT['adl_audit_aegon_c_icn2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_icn3'])) {
        
        $ICN_C3=$VIT_C_AUDIT['adl_audit_aegon_c_icn3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_icn4'])) {
        
        $ICN_C4=$VIT_C_AUDIT['adl_audit_aegon_c_icn4'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_icn5'])) {
        
        $ICN_C5=$VIT_C_AUDIT['adl_audit_aegon_c_icn5'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd1'])) {
        
        $CD_C1=$VIT_C_AUDIT['adl_audit_aegon_c_cd1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd2'])) {
        
        $CD_C2=$VIT_C_AUDIT['adl_audit_aegon_c_cd2'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd3'])) {
        
        $CD_C3=$VIT_C_AUDIT['adl_audit_aegon_c_cd3'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd4'])) {
        
        $CD_C4=$VIT_C_AUDIT['adl_audit_aegon_c_cd4'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd5'])) {
        
        $CD_C5=$VIT_C_AUDIT['adl_audit_aegon_c_cd5'];
        
    }    
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd6'])) {
        
        $CD_C6=$VIT_C_AUDIT['adl_audit_aegon_c_cd6'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd7'])) {
        
        $CD_C7=$VIT_C_AUDIT['adl_audit_aegon_c_cd7'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd8'])) {
        
        $CD_C8=$VIT_C_AUDIT['adl_audit_aegon_c_cd8'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd9'])) {
        
        $CD_C9=$VIT_C_AUDIT['adl_audit_aegon_c_cd9'];
        
    }

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_cd10'])) {
        
        $CD_C10=$VIT_C_AUDIT['adl_audit_aegon_c_cd10'];
        
    }   
    
 //   
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_pd1'])) {
        
        $PD_C1=$VIT_C_AUDIT['adl_audit_aegon_c_pd1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_pd2'])) {
        
        $PD_C2=$VIT_C_AUDIT['adl_audit_aegon_c_pd2'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_pd3'])) {
        
        $PD_C3=$VIT_C_AUDIT['adl_audit_aegon_c_pd3'];
        
    }  

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_pd4'])) {
        
        $PD_C4=$VIT_C_AUDIT['adl_audit_aegon_c_pd4'];
        
    }  

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_pd5'])) {
        
        $PD_C5=$VIT_C_AUDIT['adl_audit_aegon_c_pd5'];
        
    }      

 if(isset($VIT_C_AUDIT['adl_audit_aegon_c_md1'])) {
        
        $MD_C1=$VIT_C_AUDIT['adl_audit_aegon_c_md1'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_md2'])) {
        
        $MD_C2=$VIT_C_AUDIT['adl_audit_aegon_c_md2'];
        
    }  
    
    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_md3'])) {
        
        $MD_C3=$VIT_C_AUDIT['adl_audit_aegon_c_md3'];
        
    }  

    if(isset($VIT_C_AUDIT['adl_audit_aegon_c_md4'])) {
        
        $MD_C4=$VIT_C_AUDIT['adl_audit_aegon_c_md4'];
        
    }  
    
 //   
    
$database->query("SELECT
    adl_audit_aegon_ce_h1, 
    adl_audit_aegon_ce_h2, 
    adl_audit_aegon_ce_h3, 
    adl_audit_aegon_ce_h4, 
    adl_audit_aegon_ce_h5, 
    adl_audit_aegon_ce_d1, 
    adl_audit_aegon_ce_d2, 
    adl_audit_aegon_ce_d3, 
    adl_audit_aegon_ce_d4, 
    adl_audit_aegon_ce_bd1, 
    adl_audit_aegon_ce_bd2, 
    adl_audit_aegon_ce_bd3, 
    adl_audit_aegon_ce_bd4, 
    adl_audit_aegon_ce_bd5, 
    adl_audit_aegon_ce_dec1, 
    adl_audit_aegon_ce_dec2, 
    adl_audit_aegon_ce_dec3, 
    adl_audit_aegon_ce_dec4, 
    adl_audit_aegon_ce_dec5, 
    adl_audit_aegon_ce_dec6, 
    adl_audit_aegon_ce_dec7, 
    adl_audit_aegon_ce_qc1, 
    adl_audit_aegon_ce_qc2, 
    adl_audit_aegon_ce_qc3, 
    adl_audit_aegon_ce_qc4, 
    adl_audit_aegon_ce_qc5, 
    adl_audit_aegon_ce_qc6, 
    adl_audit_aegon_ce_qc7
  FROM
    adl_audit_aegon_ce
  WHERE
    adl_audit_aegon_ce_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AID_FK);
    $database->execute();
    $VIT_CE_AUDIT=$database->single();   
    
if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_h1'])) {
        
        $H_C1=$VIT_CE_AUDIT['adl_audit_aegon_ce_h1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_h2'])) {
        
        $H_C2=$VIT_CE_AUDIT['adl_audit_aegon_ce_h2'];
        
    }
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_h3'])) {
        
        $H_C3=$VIT_CE_AUDIT['adl_audit_aegon_ce_h3'];
        
    }   

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_h4'])) {
        
        $H_C4=$VIT_CE_AUDIT['adl_audit_aegon_ce_h4'];
        
    }   

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_h5'])) {
        
        $H_C5=$VIT_CE_AUDIT['adl_audit_aegon_ce_h5'];
        
    } 
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_d1'])) {
        
        $D_C1=$VIT_CE_AUDIT['adl_audit_aegon_ce_d1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_d2'])) {
        
        $D_C2=$VIT_CE_AUDIT['adl_audit_aegon_ce_d2'];
        
    }
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_d3'])) {
        
        $D_C3=$VIT_CE_AUDIT['adl_audit_aegon_ce_d3'];
        
    }   

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_d4'])) {
        
        $D_C4=$VIT_CE_AUDIT['adl_audit_aegon_ce_d4'];
        
    }     
    
   if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_bd1'])) {
        
        $BD_C1=$VIT_CE_AUDIT['adl_audit_aegon_ce_bd1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_bd2'])) {
        
        $BD_C2=$VIT_CE_AUDIT['adl_audit_aegon_ce_bd2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_bd3'])) {
        
        $BD_C3=$VIT_CE_AUDIT['adl_audit_aegon_ce_bd3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_bd4'])) {
        
        $BD_C4=$VIT_CE_AUDIT['adl_audit_aegon_ce_bd4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_bd5'])) {
        
        $BD_C5=$VIT_CE_AUDIT['adl_audit_aegon_ce_bd5'];
        
    }    
    
   if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec1'])) {
        
        $DEC_C1=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec2'])) {
        
        $DEC_C2=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec3'])) {
        
        $DEC_C3=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec4'])) {
        
        $DEC_C4=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec5'])) {
        
        $DEC_C5=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec5'];
        
    }   
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec6'])) {
        
        $DEC_C6=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec6'];
        
    } 

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_dec7'])) {
        
        $DEC_C7=$VIT_CE_AUDIT['adl_audit_aegon_ce_dec7'];
        
    }     
    
   if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc1'])) {
        
        $QC_C1=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc1'];
        
    }  
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc2'])) {
        
        $QC_C2=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc2'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc3'])) {
        
        $QC_C3=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc3'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc4'])) {
        
        $QC_C4=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc4'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc5'])) {
        
        $QC_C5=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc5'];
        
    }    
    
    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc6'])) {
        
        $QC_C6=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc6'];
        
    }

    if(isset($VIT_CE_AUDIT['adl_audit_aegon_ce_qc7'])) {
        
        $QC_C7=$VIT_CE_AUDIT['adl_audit_aegon_ce_qc7'];
        
    } 
    
    $database->endTransaction();  
 
    $TOTAL= 57 - $SCORE;
    
    
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Aegon Call Audit</title>
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
                        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Edit Aegon Closer Call Audit</h3>
                    </div>

                    <div class="panel-body">
                        <p>
                            <label for="CLOSER">Closer</label>
                            <input type="text" class="form-control" name="CLOSER" id="CLOSER" style="width: 520px" value="<?php if(isset($VIT_CLOSER)) { echo $VIT_CLOSER; } ?>">
                        
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
                        <input type="text" class="form-control" name="AGENT" id="AGENT" style="width: 520px" value="<?php if(isset($VIT_AGENT)) { echo $VIT_AGENT; } ?>">
                        
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
                        <input type="text" class="form-control" name="REFERENCE" style="width: 520px" value="<?php if(isset($VIT_REF)) { echo $VIT_REF; } ?>">

                        </p>

                        <p>
                        <div class="form-group">
                            <label for='GRADE'>Grade:</label>
                            <select class="form-control" name="GRADE" required>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'SAVED') { echo "selected"; } ?> value="SAVED">Incomplete Audit (SAVE)</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Amber') { echo "selected"; } ?> value="Amber">Amber</option>
                                <option <?php if(isset($VIT_GRADE) && $VIT_GRADE == 'Red')   { echo "selected"; } ?> value="Red">Red</option>
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
                            <label for="ICN_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER check all details of what the client has with their existing life insurance policy?</label>
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
                            <label for="ICN_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER mention waiver, indexation, or TPD?</label>
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
                            <label for="ICN_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
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
                            <label for="ICN_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label>
                            <select class="form-control" name="ICN_Q4" onclick="javascript:yesnoCheckICN_C4();" required>
                                <option value="N/A">Select...</option>
                                <option <?php if(isset($ICN_Q4) && $ICN_Q4 == 'More than sufficient') { echo "selected"; } ?> value="More than sufficient">More than sufficient</option>
                                <option <?php if(isset($ICN_Q4) && $ICN_Q4 == 'Sufficient') { echo "selected"; } ?> value="Sufficient">Sufficient</option>
                                <option <?php if(isset($ICN_Q4) && $ICN_Q4 == 'Adaquate') { echo "selected"; } ?> value="Adaquate">Adequate</option>
                                <option <?php if(isset($ICN_Q4) && $ICN_Q4 == 'Poor') { echo "selected"; } ?> value="Poor" onclick="javascript:yesnoCheckICN_C4a();" id="yesCheckICN_C4">Poor</option>
                            </select>
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
                            <label for="ICN_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed this policy will be set up with Aegon?</label>
                            <input type="radio" name="ICN_Q5" 
<?php if (isset($ICN_Q5) && $ICN_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C5();"
                                   value="1" id="yesCheckICN_C5" required >Yes
                            <input type="radio" name="ICN_Q5"
<?php if (isset($ICN_Q5) && $ICN_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C5();"
                                   value="0" id="noCheckICN_C5">No
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
                            <label for="CD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask and confirm customers DOB?</label>
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
                            <label for="CD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer get the customers email correct?</label>
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
                            <label for="CD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers martial status?</label>
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
                            <label for="CD_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm the customers address?</label>
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
                            <label for="CD_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer the smoking question?</label>
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
                            <label for="CD_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer how much alcohol they drink per week?</label>
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
                        
<p>
                            <label for="CD_Q9">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer was a UK resident?</label>
                            <input type="radio" name="CD_Q9" 
<?php if (isset($CD_Q9) && $CD_Q9 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C9();"
                                   value="1" id="yesCheckCD_C9" required >Yes
                            <input type="radio" name="CD_Q9"
<?php if (isset($CD_Q9) && $CD_Q9 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C9();"
                                   value="0" id="noCheckCD_C9">No
                        </p>

                        <div id="ifYesCD_C9" >
                            <textarea class="form-control"id="CD_C9" name="CD_C9" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C9)) { echo $CD_C9; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C9').keydown(function () {
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
                            <label for="CD_Q10">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers occupation?</label>
                            <input type="radio" name="CD_Q10" 
<?php if (isset($CD_Q10) && $CD_Q10 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C10();"
                                   value="1" id="yesCheckCD_C10" required >Yes
                            <input type="radio" name="CD_Q10"
<?php if (isset($CD_Q10) && $CD_Q10 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C10();"
                                   value="0" id="noCheckCD_C10">No
                        </p>

                        <div id="ifYesCD_C10" >
                            <textarea class="form-control"id="CD_C10" name="CD_C10" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($CD_C10)) { echo $CD_C10; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C10').keydown(function () {
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
                        <h3 class="panel-title">Personal details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="PD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers employment basis?</label>
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
                            <label for="PD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers total yearly earnings?</label>
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
                            <label for="PD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask in the next 12 months does the customer intend to live, work or travel abroad, or have they done so in the past five years?</label>
                            <input type="radio" name="PD_Q3" 
<?php if (isset($PD_Q3) && $PD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C3();"
                                   value="1" id="yesCheckPD_C3" required >Yes
                            <input type="radio" name="PD_Q3"
<?php if (isset($PD_Q3) && $PD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C3();"
                                   value="0" id="noCheckPD_C3">No
                        </p>

                        <div id="ifYesPD_C3" >
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
                            <label for="PD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they intend to take part in any hazardous activity?</label>
                            <input type="radio" name="PD_Q4" 
<?php if (isset($PD_Q4) && $PD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C4();"
                                   value="1" id="yesCheckPD_C4" required >Yes
                            <input type="radio" name="PD_Q4"
<?php if (isset($PD_Q4) && $PD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C4();"
                                   value="0" id="noCheckPD_C4">No
                        </p>

                        <div id="ifYesPD_C4" >
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
                            <label for="PD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if the total amount of protection under all their existing policies, together with this application any any pending or concurrent applications, exceed £800k for life cover or £500k critical illness or total permanent disability?</label>
                            <input type="radio" name="PD_Q5" 
<?php if (isset($PD_Q5) && $PD_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C5();"
                                   value="1" id="yesCheckPD_C5" required >Yes
                            <input type="radio" name="PD_Q5"
<?php if (isset($PD_Q5) && $PD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPD_C5();"
                                   value="0" id="noCheckPD_C5">No
                        </p>

                        <div id="ifYesPD_C5" >
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
                        <h3 class="panel-title">Medical details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="MD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customers height and weight asked and recorded correctly?</label>
                            <input type="radio" name="MD_Q1" 
<?php if (isset($MD_Q1) && $MD_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C1();"
                                   value="1" id="yesCheckMD_C1" required >Yes
                            <input type="radio" name="MD_Q1"
<?php if (isset($MD_Q1) && $MD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C1();"
                                   value="0" id="noCheckMD_C1">No
                        </p>

                        <div id="ifYesMD_C1" >
                            <textarea class="form-control"id="MD_C1" name="MD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($MD_C1)) { echo $MD_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#MD_C1').keydown(function () {
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
                            <label for="MD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers the average amount they have smoked or used a day over the year?</label>
                            <input type="radio" name="MD_Q2" 
<?php if (isset($MD_Q2) && $MD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C2();"
                                   value="1" id="yesCheckMD_C2" required >Yes
                            <input type="radio" name="MD_Q2"
<?php if (isset($MD_Q2) && $MD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C2();"
                                   value="0" id="noCheckMD_C2">No
                        </p>

                        <div id="ifYesMD_C2" >
                            <textarea class="form-control"id="MD_C2" name="MD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($MD_C2)) { echo $MD_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#MD_C2').keydown(function () {
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
                            <label for="MD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer how much alcohol they drink a week?</label>
                            <input type="radio" name="MD_Q3" 
<?php if (isset($MD_Q3) && $MD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C3();"
                                   value="1" id="yesCheckMD_C3" required >Yes
                            <input type="radio" name="MD_Q3"
<?php if (isset($MD_Q3) && $MD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C3();"
                                   value="0" id="noCheckMD_C3">No
                        </p>

                        <div id="ifYesMD_C3" >
                            <textarea class="form-control"id="MD_C3" name="MD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($MD_C3)) { echo $MD_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#MD_C3').keydown(function () {
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
                            <label for="MD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they have ever been advised to reduce or stop their alcohol consumption by a doctor, nurse or other medical profession?</label>
                            <input type="radio" name="MD_Q4" 
<?php if (isset($MD_Q4) && $MD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C4();"
                                   value="1" id="yesCheckMD_C4" required >Yes
                            <input type="radio" name="MD_Q4"
<?php if (isset($MD_Q4) && $MD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckMD_C4();"
                                   value="0" id="noCheckMD_C4">No
                        </p>

                        <div id="ifYesMD_C4" >
                            <textarea class="form-control"id="MD_C4" name="MD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($MD_C4)) { echo $MD_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#MD_C4').keydown(function () {
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
                            <label for="H_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Were all the health questions asked and recorded correctly?</label>
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
                            <label for="H_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Were all the health questions - ever had, asked and recorded correctly?</label>
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
                            <label for="H_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Were all the health questions - last five years, asked and recorded correctly?</label>
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
                        
  <p>
                            <label for="H_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Were all the health questions - continued, asked and recorded correctly?</label>
                            <input type="radio" name="H_Q4" 
<?php if (isset($H_Q4) && $H_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C4();"
                                   value="1" id="yesCheckH_C4" required >Yes
                            <input type="radio" name="H_Q4"
<?php if (isset($H_Q4) && $H_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C4();"
                                   value="0" id="noCheckH_C4">No
                        </p>

                        <div id="ifYesH_C4" >
                            <textarea class="form-control"id="H_C4" name="H_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($H_C4)) { echo $H_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C4').keydown(function () {
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
                            <label for="H_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Were all the family history questions asked and recorded correctly?</label>
                            <input type="radio" name="H_Q5" 
<?php if (isset($H_Q5) && $H_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C5();"
                                   value="1" id="yesCheckH_C5" required >Yes
                            <input type="radio" name="H_Q5"
<?php if (isset($H_Q5) && $H_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C5();"
                                   value="0" id="noCheckH_C5">No
                        </p>

                        <div id="ifYesH_C5" >
                            <textarea class="form-control"id="H_C5" name="H_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($H_C5)) { echo $H_C5; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C5').keydown(function () {
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
                        <h3 class="panel-title">Decision</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="D_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. If appropriate did the closer confirm the exclusions on the policy?</label>
                            <input type="radio" name="D_Q1" 
<?php if (isset($D_Q1) && $D_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C1();"
                                   value="1" id="yesCheckD_C1" required >Yes
                            <input type="radio" name="D_Q1"
<?php if (isset($D_Q1) && $D_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C1();"
                                   value="0" id="noCheckD_C1">No
                        </p>

                        <div id="ifYesD_C1" >
                            <textarea class="form-control"id="D_C1" name="D_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($D_C1)) { echo $D_C1; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#D_C1').keydown(function () {
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
                            <label for="D_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Were all of the doctor details asked and recorded correctly?</label>
                            <input type="radio" name="D_Q2" 
<?php if (isset($D_Q2) && $D_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C2();"
                                   value="1" id="yesCheckD_C2" required >Yes
                            <input type="radio" name="D_Q2"
<?php if (isset($D_Q2) && $D_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C2();"
                                   value="0" id="noCheckD_C2">No
                        </p>

                        <div id="ifYesD_C2" >
                            <textarea class="form-control"id="D_C2" name="D_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($D_C2)) { echo $D_C2; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#D_C2').keydown(function () {
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
                            <label for="D_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they have been registered with their current doctor for more than 12 months?</label>
                            <input type="radio" name="D_Q3" 
<?php if (isset($D_Q3) && $D_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C3();"
                                   value="1" id="yesCheckD_C3" required >Yes
                            <input type="radio" name="D_Q3"
<?php if (isset($D_Q3) && $D_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C3();"
                                   value="0" id="noCheckD_C3">No
                        </p>

                        <div id="ifYesD_C3" >
                            <textarea class="form-control"id="D_C3" name="D_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($D_C3)) { echo $D_C3; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#D_C3').keydown(function () {
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
                            <label for="D_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they want to see any medical report before it's supplied to Aegon?</label>
                            <input type="radio" name="D_Q4" 
<?php if (isset($D_Q4) && $D_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C4();"
                                   value="1" id="yesCheckD_C4" required >Yes
                            <input type="radio" name="D_Q4"
<?php if (isset($D_Q4) && $D_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckD_C4();"
                                   value="0" id="noCheckD_C4">No
                        </p>

                        <div id="ifYesD_C4" >
                            <textarea class="form-control"id="D_C4" name="D_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php if(isset($D_C4)) { echo $D_C4; } ?></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#D_C4').keydown(function () {
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
                            <label for="DEC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Aegon will write to them with a more specific date?</label>
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
                            <label for="QC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Aegon with client information?</label>
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
            title: "Update Aegon audit?",
            text: "Save and update vitality audit!",
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
                            text: 'Aegon audit updated!',
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