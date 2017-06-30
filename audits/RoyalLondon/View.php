<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php'); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /../../CRMmain.php'); die;
    }

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /../../CRMmain.php'); die;

}

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);  

if(isset($EXECUTE)) {
    if($EXECUTE=='VIEW') {
        $AUDITID= filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);
        require_once(__DIR__ . '/../../classes/database_class.php');
        
    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT DATE(added_date) AS added_date, added_by, grade, closer, closer2, plan_number FROM RoyalLondon_Audit WHERE audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $RL_AUDIT=$database->single(); 
    
    if(isset($RL_AUDIT['added_by'])) {
        $RL_ADDED_BY=$RL_AUDIT['added_by'];
    }
     if(isset($RL_AUDIT['added_date'])) {
        $RL_ADDED_DATE=$RL_AUDIT['added_date'];
    }   
    if(isset($RL_AUDIT['grade'])) {
        $RL_GRADE=$RL_AUDIT['grade'];
    }
    if(isset($RL_AUDIT['closer'])) {
       $RL_CLOSER=$RL_AUDIT['closer'];
    }
    if(isset($RL_AUDIT['closer2'])) {
       $RL_CLOSER2=$RL_AUDIT['closer2']; 
    }    
    if(isset($RL_AUDIT['plan_number'])) {
       $RL_PLAN_NUMBER=$RL_AUDIT['plan_number']; 
    }     
    
    $database->query("SELECT OD1, OD2, OD3, OD4, OD5, CI1, CI2, CI3, CI4, CI5, CI6, CI7, CI8, IC1, IC2, IC3, IC4, IC5, CD1, CD2, CD3, CD4, CD5, DO1, DO2, DO3, DO4, DO5, DO6, DO7, DO8, LS1, LS2, LS3, LS4, LS5, LS6, LS7, OT1, OT2, OT3 FROM RoyalLondon_Questions WHERE fk_audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $RL_QS_AUDIT=$database->single(); 
    
    if(isset($RL_QS_AUDIT['OD1'])) {
        $RL_OD1=$RL_QS_AUDIT['OD1'];
    }
     if(isset($RL_QS_AUDIT['OD2'])) {
        $RL_OD2=$RL_QS_AUDIT['OD2'];
    }   
    if(isset($RL_QS_AUDIT['OD3'])) {
        $RL_OD3=$RL_QS_AUDIT['OD3'];
    }
    if(isset($RL_QS_AUDIT['OD4'])) {
       $RL_OD4=$RL_QS_AUDIT['OD4'];
    }
    if(isset($RL_QS_AUDIT['OD5'])) {
       $RL_OD5=$RL_QS_AUDIT['OD5']; 
    }    
    if(isset($RL_QS_AUDIT['CI1'])) {
       $RL_CI1=$RL_QS_AUDIT['CI1']; 
    } 
    if(isset($RL_QS_AUDIT['CI2'])) {
       $RL_CI2=$RL_QS_AUDIT['CI2']; 
    }  
    if(isset($RL_QS_AUDIT['CI3'])) {
       $RL_CI3=$RL_QS_AUDIT['CI3']; 
    }  
    if(isset($RL_QS_AUDIT['CI4'])) {
       $RL_CI4=$RL_QS_AUDIT['CI4']; 
    }  
    if(isset($RL_QS_AUDIT['CI5'])) {
       $RL_CI5=$RL_QS_AUDIT['CI5']; 
    }
    if(isset($RL_QS_AUDIT['CI6'])) {
       $RL_CI6=$RL_QS_AUDIT['CI6']; 
    }
    if(isset($RL_QS_AUDIT['CI7'])) {
       $RL_CI7=$RL_QS_AUDIT['CI7']; 
    } 
    if(isset($RL_QS_AUDIT['CI8'])) {
       $RL_CI8=$RL_QS_AUDIT['CI8']; 
    } 
    if(isset($RL_QS_AUDIT['IC1'])) {
       $RL_IC1=$RL_QS_AUDIT['IC1']; 
    } 
    if(isset($RL_QS_AUDIT['IC2'])) {
       $RL_IC2=$RL_QS_AUDIT['IC2']; 
    }  
    if(isset($RL_QS_AUDIT['IC3'])) {
       $RL_IC3=$RL_QS_AUDIT['IC3']; 
    }  
    if(isset($RL_QS_AUDIT['IC4'])) {
       $RL_IC4=$RL_QS_AUDIT['IC4']; 
    }  
    if(isset($RL_QS_AUDIT['IC5'])) {
       $RL_IC5=$RL_QS_AUDIT['IC5']; 
    }  
    if(isset($RL_QS_AUDIT['CD1'])) {
       $RL_CD1=$RL_QS_AUDIT['CD1']; 
    } 
    if(isset($RL_QS_AUDIT['CD2'])) {
       $RL_CD2=$RL_QS_AUDIT['CD2']; 
    }  
    if(isset($RL_QS_AUDIT['CD3'])) {
       $RL_CD3=$RL_QS_AUDIT['CD3']; 
    }  
    if(isset($RL_QS_AUDIT['CD4'])) {
       $RL_CD4=$RL_QS_AUDIT['CD4']; 
    }  
    if(isset($RL_QS_AUDIT['CD5'])) {
       $RL_CD5=$RL_QS_AUDIT['CD5']; 
    }
    if(isset($RL_QS_AUDIT['DO1'])) {
       $RL_DO1=$RL_QS_AUDIT['DO1']; 
    } 
    if(isset($RL_QS_AUDIT['DO2'])) {
       $RL_DO2=$RL_QS_AUDIT['DO2']; 
    }  
    if(isset($RL_QS_AUDIT['DO3'])) {
       $RL_DO3=$RL_QS_AUDIT['DO3']; 
    }  
    if(isset($RL_QS_AUDIT['DO4'])) {
       $RL_DO4=$RL_QS_AUDIT['DO4']; 
    }  
    if(isset($RL_QS_AUDIT['DO5'])) {
       $RL_DO5=$RL_QS_AUDIT['DO5']; 
    }
    if(isset($RL_QS_AUDIT['DO6'])) {
       $RL_DO6=$RL_QS_AUDIT['DO6']; 
    }  
    if(isset($RL_QS_AUDIT['DO7'])) {
       $RL_DO7=$RL_QS_AUDIT['DO7']; 
    }  
    if(isset($RL_QS_AUDIT['DO8'])) {
       $RL_DO8=$RL_QS_AUDIT['DO8']; 
    }      
    if(isset($RL_QS_AUDIT['LS1'])) {
       $RL_LS1=$RL_QS_AUDIT['LS1']; 
    } 
    if(isset($RL_QS_AUDIT['LS2'])) {
       $RL_LS2=$RL_QS_AUDIT['LS2']; 
    }  
    if(isset($RL_QS_AUDIT['LS3'])) {
       $RL_LS3=$RL_QS_AUDIT['LS3']; 
    }  
    if(isset($RL_QS_AUDIT['LS4'])) {
       $RL_LS4=$RL_QS_AUDIT['LS4']; 
    }  
    if(isset($RL_QS_AUDIT['LS5'])) {
       $RL_LS5=$RL_QS_AUDIT['LS5']; 
    } 
    if(isset($RL_QS_AUDIT['LS6'])) {
       $RL_LS6=$RL_QS_AUDIT['LS6']; 
    }  
    if(isset($RL_QS_AUDIT['LS7'])) {
       $RL_LS7=$RL_QS_AUDIT['LS7']; 
    }  
    if(isset($RL_QS_AUDIT['OT1'])) {
       $RL_OT1=$RL_QS_AUDIT['OT1']; 
    } 
    if(isset($RL_QS_AUDIT['OT2'])) {
       $RL_OT2=$RL_QS_AUDIT['OT2']; 
    }  
    if(isset($RL_QS_AUDIT['OT3'])) {
       $RL_OT3=$RL_QS_AUDIT['OT3']; 
    }  
    
$database->query("SELECT ODT1, ODT2, ODT3, ODT4, ODT5, CIT1, CIT2, CIT3, CIT4, CIT5, CIT6, CIT7, CIT8, ICT1, ICT2, ICT3, ICT4, ICT5, CDT1, CDT2, CDT3, CDT4, CDT5, DOT1, DOT2, DOT3, DOT4, DOT5, DOT6, DOT7, DOT8, LST1, LST2, LST3, LST4, LST5, LST6, LST7 FROM RoyalLondon_Comments WHERE fk_audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $RL_CM_AUDIT=$database->single(); 
    
    if(isset($RL_CM_AUDIT['ODT1'])) {
        $RL_CM_ODT1=$RL_CM_AUDIT['ODT1'];
    }
     if(isset($RL_CM_AUDIT['ODT2'])) {
        $RL_CM_ODT2=$RL_CM_AUDIT['ODT2'];
    }   
    if(isset($RL_CM_AUDIT['ODT3'])) {
        $RL_CM_ODT3=$RL_CM_AUDIT['ODT3'];
    }
    if(isset($RL_CM_AUDIT['ODT4'])) {
       $RL_CM_ODT4=$RL_CM_AUDIT['ODT4'];
    }
    if(isset($RL_CM_AUDIT['ODT5'])) {
       $RL_CM_ODT5=$RL_CM_AUDIT['ODT5']; 
    }    
    if(isset($RL_CM_AUDIT['CIT1'])) {
       $RL_CM_CIT1=$RL_CM_AUDIT['CIT1']; 
    } 
    if(isset($RL_CM_AUDIT['CIT2'])) {
       $RL_CM_CIT2=$RL_CM_AUDIT['CIT2']; 
    }  
    if(isset($RL_CM_AUDIT['CIT3'])) {
       $RL_CM_CIT3=$RL_CM_AUDIT['CIT3']; 
    }  
    if(isset($RL_CM_AUDIT['CIT4'])) {
       $RL_CM_CIT4=$RL_CM_AUDIT['CIT4']; 
    }  
    if(isset($RL_CM_AUDIT['CIT5'])) {
       $RL_CM_CIT5=$RL_CM_AUDIT['CIT5']; 
    }
    if(isset($RL_CM_AUDIT['CIT6'])) {
       $RL_CM_CIT6=$RL_CM_AUDIT['CIT6']; 
    }
    if(isset($RL_CM_AUDIT['CIT7'])) {
       $RL_CM_CIT7=$RL_CM_AUDIT['CIT7']; 
    } 
    if(isset($RL_CM_AUDIT['CIT8'])) {
       $RL_CM_CIT8=$RL_CM_AUDIT['CIT8']; 
    } 
    if(isset($RL_CM_AUDIT['ICT1'])) {
       $RL_CM_ICT1=$RL_CM_AUDIT['ICT1']; 
    } 
    if(isset($RL_CM_AUDIT['ICT2'])) {
       $RL_CM_ICT2=$RL_CM_AUDIT['ICT2']; 
    }  
    if(isset($RL_CM_AUDIT['ICT3'])) {
       $RL_CM_ICT3=$RL_CM_AUDIT['ICT3']; 
    }  
    if(isset($RL_CM_AUDIT['ICT4'])) {
       $RL_CM_ICT4=$RL_CM_AUDIT['ICT4']; 
    }  
    if(isset($RL_CM_AUDIT['ICT5'])) {
       $RL_CM_ICT5=$RL_CM_AUDIT['ICT5']; 
    }  
    if(isset($RL_CM_AUDIT['CDT1'])) {
       $RL_CM_CDT1=$RL_CM_AUDIT['CDT1']; 
    } 
    if(isset($RL_CM_AUDIT['CDT2'])) {
       $RL_CM_CDT2=$RL_CM_AUDIT['CDT2']; 
    }  
    if(isset($RL_CM_AUDIT['CDT3'])) {
       $RL_CM_CDT3=$RL_CM_AUDIT['CDT3']; 
    }  
    if(isset($RL_CM_AUDIT['CDT4'])) {
       $RL_CM_CDT4=$RL_CM_AUDIT['CDT4']; 
    }  
    if(isset($RL_CM_AUDIT['CDT5'])) {
       $RL_CM_CDT5=$RL_CM_AUDIT['CDT5']; 
    }
    if(isset($RL_CM_AUDIT['DOT1'])) {
       $RL_CM_DOT1=$RL_CM_AUDIT['DOT1']; 
    } 
    if(isset($RL_CM_AUDIT['DOT2'])) {
       $RL_CM_DOT2=$RL_CM_AUDIT['DOT2']; 
    }  
    if(isset($RL_CM_AUDIT['DOT3'])) {
       $RL_CM_DOT3=$RL_CM_AUDIT['DOT3']; 
    }  
    if(isset($RL_CM_AUDIT['DOT4'])) {
       $RL_CM_DOT4=$RL_CM_AUDIT['DOT4']; 
    }  
    if(isset($RL_CM_AUDIT['DOT5'])) {
       $RL_CM_DOT5=$RL_CM_AUDIT['DOT5']; 
    }
    if(isset($RL_CM_AUDIT['DOT6'])) {
       $RL_CM_DOT6=$RL_CM_AUDIT['DOT6']; 
    }  
    if(isset($RL_CM_AUDIT['DOT7'])) {
       $RL_CM_DOT7=$RL_CM_AUDIT['DOT7']; 
    }  
    if(isset($RL_CM_AUDIT['DOT8'])) {
       $RL_CM_DOT8=$RL_CM_AUDIT['DOT8']; 
    }      
    if(isset($RL_CM_AUDIT['LST1'])) {
       $RL_CM_LST1=$RL_CM_AUDIT['LST1']; 
    } 
    if(isset($RL_CM_AUDIT['LST2'])) {
       $RL_CM_LST2=$RL_CM_AUDIT['LST2']; 
    }  
    if(isset($RL_CM_AUDIT['LST3'])) {
       $RL_CM_LST3=$RL_CM_AUDIT['LST3']; 
    }  
    if(isset($RL_CM_AUDIT['LST4'])) {
       $RL_CM_LST4=$RL_CM_AUDIT['LST4']; 
    }  
    if(isset($RL_CM_AUDIT['LST5'])) {
       $RL_CM_LST5=$RL_CM_AUDIT['LST5']; 
    } 
    if(isset($RL_CM_AUDIT['LST6'])) {
       $RL_CM_LST6=$RL_CM_AUDIT['LST6']; 
    }  
    if(isset($RL_CM_AUDIT['LST7'])) {
       $RL_CM_LST7=$RL_CM_AUDIT['LST7']; 
    }    

    $database->query("SELECT HQ1, HQ2, HQ3, HQ4, HQ5, HQ6, E1, E2, E3, E4, E5, E6, PI1, PI2, PI3, PI4, PI5, CDE1, CDE2, CDE3, CDE4, CDE5, CDE6, CDE7, CDE8, QC1, QC2, QC3, QC4, QC5, QC6, QC7 FROM RoyalLondon_Questions_Extra WHERE fk_audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $RL_QS_EX_AUDIT=$database->single(); 
    
    if(isset($RL_QS_EX_AUDIT['HQ1'])) {
        $RL_QE_HQ1=$RL_QS_EX_AUDIT['HQ1'];
    }
     if(isset($RL_QS_EX_AUDIT['HQ2'])) {
        $RL_QE_HQ2=$RL_QS_EX_AUDIT['HQ2'];
    }   
    if(isset($RL_QS_EX_AUDIT['HQ3'])) {
        $RL_QE_HQ3=$RL_QS_EX_AUDIT['HQ3'];
    }
    if(isset($RL_QS_EX_AUDIT['HQ4'])) {
       $RL_QE_HQ4=$RL_QS_EX_AUDIT['HQ4'];
    }
    if(isset($RL_QS_EX_AUDIT['HQ5'])) {
       $RL_QE_HQ5=$RL_QS_EX_AUDIT['HQ5']; 
    }    
    if(isset($RL_QS_EX_AUDIT['HQ6'])) {
       $RL_QE_HQ6=$RL_QS_EX_AUDIT['HQ6']; 
    } 
    if(isset($RL_QS_EX_AUDIT['E1'])) {
       $RL_QE_E1=$RL_QS_EX_AUDIT['E1']; 
    }  
    if(isset($RL_QS_EX_AUDIT['E2'])) {
       $RL_QE_E2=$RL_QS_EX_AUDIT['E2']; 
    }  
    if(isset($RL_QS_EX_AUDIT['E3'])) {
       $RL_QE_E3=$RL_QS_EX_AUDIT['E3']; 
    }  
    if(isset($RL_QS_EX_AUDIT['E4'])) {
       $RL_QE_E4=$RL_QS_EX_AUDIT['E4']; 
    }
    if(isset($RL_QS_EX_AUDIT['E5'])) {
       $RL_QE_E5=$RL_QS_EX_AUDIT['E5']; 
    }
    if(isset($RL_QS_EX_AUDIT['E6'])) {
       $RL_QE_E6=$RL_QS_EX_AUDIT['E6']; 
    } 
    if(isset($RL_QS_EX_AUDIT['PI1'])) {
       $RL_QE_PI1=$RL_QS_EX_AUDIT['PI1']; 
    } 
    if(isset($RL_QS_EX_AUDIT['PI2'])) {
       $RL_QE_PI2=$RL_QS_EX_AUDIT['PI2']; 
    } 
    if(isset($RL_QS_EX_AUDIT['PI3'])) {
       $RL_QE_PI3=$RL_QS_EX_AUDIT['PI3']; 
    }  
    if(isset($RL_QS_EX_AUDIT['PI4'])) {
       $RL_QE_PI4=$RL_QS_EX_AUDIT['PI4']; 
    }  
    if(isset($RL_QS_EX_AUDIT['PI5'])) {
       $RL_QE_PI5=$RL_QS_EX_AUDIT['PI5']; 
    }  
    if(isset($RL_QS_EX_AUDIT['CDE1'])) {
       $RL_QE_CDE1=$RL_QS_EX_AUDIT['CDE1']; 
    }  
    if(isset($RL_QS_EX_AUDIT['CDE2'])) {
       $RL_QE_CDE2=$RL_QS_EX_AUDIT['CDE2']; 
    } 
    if(isset($RL_QS_EX_AUDIT['CDE3'])) {
       $RL_QE_CDE3=$RL_QS_EX_AUDIT['CDE3']; 
    }  
    if(isset($RL_QS_EX_AUDIT['CDE4'])) {
       $RL_QE_CDE4=$RL_QS_EX_AUDIT['CDE4']; 
    }  
    if(isset($RL_QS_EX_AUDIT['CDE5'])) {
       $RL_QE_CDE5=$RL_QS_EX_AUDIT['CDE5']; 
    }  
    if(isset($RL_QS_EX_AUDIT['CDE6'])) {
       $RL_QE_CDE6=$RL_QS_EX_AUDIT['CDE6']; 
    }
    if(isset($RL_QS_EX_AUDIT['CDE7'])) {
       $RL_QE_CDE7=$RL_QS_EX_AUDIT['CDE7']; 
    } 
    if(isset($RL_QS_EX_AUDIT['CDE8'])) {
       $RL_QE_CDE8=$RL_QS_EX_AUDIT['CDE8']; 
    }  
    if(isset($RL_QS_EX_AUDIT['QC1'])) {
       $RL_QE_QC1=$RL_QS_EX_AUDIT['QC1']; 
    }
    if(isset($RL_QS_EX_AUDIT['QC2'])) {
       $RL_QE_QC2=$RL_QS_EX_AUDIT['QC2']; 
    }  
    if(isset($RL_QS_EX_AUDIT['QC3'])) {
       $RL_QE_QC3=$RL_QS_EX_AUDIT['QC3']; 
    }  
    if(isset($RL_QS_EX_AUDIT['QC4'])) {
       $RL_QE_QC4=$RL_QS_EX_AUDIT['QC4']; 
    }  
    if(isset($RL_QS_EX_AUDIT['QC5'])) {
       $RL_QE_QC5=$RL_QS_EX_AUDIT['QC5']; 
    }
    if(isset($RL_QS_EX_AUDIT['QC6'])) {
       $RL_QE_QC6=$RL_QS_EX_AUDIT['QC6']; 
    }  
    if(isset($RL_QS_EX_AUDIT['QC7'])) {
       $RL_QE_QC7=$RL_QS_EX_AUDIT['QC7']; 
    }  
    
    $database->query("SELECT OTT1, OTT2, OTT3, HQT1, HQT2, HQT3, HQT4, HQT5, HQT6, ET1, ET2, ET3, ET4, ET5, ET6, PIT1, PIT2, PIT3, PIT4, PIT5, CDET1, CDET2, CDET3, CDET4, CDET5, CDET6, CDET7, CDET8, QCT1, QCT2, QCT3, QCT4, QCT5, QCT6, QCT7 FROM RoyalLondon_Comments_Extra WHERE fk_audit_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $RL_CM_EX_AUDIT=$database->single(); 
    
    if(isset($RL_CM_EX_AUDIT['OTT1'])) {
        $RL_CEM_OTT1=$RL_CM_EX_AUDIT['OTT1'];
    }
     if(isset($RL_CM_EX_AUDIT['OTT2'])) {
        $RL_CEM_OTT2=$RL_CM_EX_AUDIT['OTT2'];
    }   
    if(isset($RL_CM_EX_AUDIT['OTT3'])) {
        $RL_CEM_OTT3=$RL_CM_EX_AUDIT['OTT3'];
    }    
    if(isset($RL_CM_EX_AUDIT['HQT1'])) {
        $RL_CEM_HQT1=$RL_CM_EX_AUDIT['HQT1'];
    }
     if(isset($RL_CM_EX_AUDIT['HQT2'])) {
        $RL_CEM_HQT2=$RL_CM_EX_AUDIT['HQT2'];
    }   
    if(isset($RL_CM_EX_AUDIT['HQT3'])) {
        $RL_CEM_HQT3=$RL_CM_EX_AUDIT['HQT3'];
    }
    if(isset($RL_CM_EX_AUDIT['HQT4'])) {
       $RL_CEM_HQT4=$RL_CM_EX_AUDIT['HQT4'];
    }
    if(isset($RL_CM_EX_AUDIT['HQT5'])) {
       $RL_CEM_HQT5=$RL_CM_EX_AUDIT['HQT5']; 
    }    
    if(isset($RL_CM_EX_AUDIT['HQT6'])) {
       $RL_CEM_HQT6=$RL_CM_EX_AUDIT['HQT6']; 
    } 
    if(isset($RL_CM_EX_AUDIT['ET1'])) {
       $RL_CEM_ET1=$RL_CM_EX_AUDIT['ET1']; 
    }  
    if(isset($RL_CM_EX_AUDIT['ET2'])) {
       $RL_CEM_ET2=$RL_CM_EX_AUDIT['ET2']; 
    }  
    if(isset($RL_CM_EX_AUDIT['ET3'])) {
       $RL_CEM_ET3=$RL_CM_EX_AUDIT['ET3']; 
    }  
    if(isset($RL_CM_EX_AUDIT['ET4'])) {
       $RL_CEM_ET4=$RL_CM_EX_AUDIT['ET4']; 
    }
    if(isset($RL_CM_EX_AUDIT['ET5'])) {
       $RL_CEM_ET5=$RL_CM_EX_AUDIT['ET5']; 
    }
    if(isset($RL_CM_EX_AUDIT['ET6'])) {
       $RL_CEM_ET6=$RL_CM_EX_AUDIT['ET6']; 
    } 
    if(isset($RL_CM_EX_AUDIT['PIT1'])) {
       $RL_CEM_PIT1=$RL_CM_EX_AUDIT['PIT1']; 
    } 
    if(isset($RL_CM_EX_AUDIT['PIT2'])) {
       $RL_CEM_PIT2=$RL_CM_EX_AUDIT['PIT2']; 
    } 
    if(isset($RL_CM_EX_AUDIT['PIT3'])) {
       $RL_CEM_PIT3=$RL_CM_EX_AUDIT['PIT3']; 
    }  
    if(isset($RL_CM_EX_AUDIT['PIT4'])) {
       $RL_CEM_PIT4=$RL_CM_EX_AUDIT['PIT4']; 
    }  
    if(isset($RL_CM_EX_AUDIT['PIT5'])) {
       $RL_CEM_PIT5=$RL_CM_EX_AUDIT['PIT5']; 
    }  
    if(isset($RL_CM_EX_AUDIT['CDET1'])) {
       $RL_CEM_CDET1=$RL_CM_EX_AUDIT['CDET1']; 
    }  
    if(isset($RL_CM_EX_AUDIT['CDET2'])) {
       $RL_CEM_CDET2=$RL_CM_EX_AUDIT['CDET2']; 
    } 
    if(isset($RL_CM_EX_AUDIT['CDET3'])) {
       $RL_CEM_CDET3=$RL_CM_EX_AUDIT['CDET3']; 
    }  
    if(isset($RL_CM_EX_AUDIT['CDET4'])) {
       $RL_CEM_CDET4=$RL_CM_EX_AUDIT['CDET4']; 
    }  
    if(isset($RL_CM_EX_AUDIT['CDET5'])) {
       $RL_CEM_CDET5=$RL_CM_EX_AUDIT['CDET5']; 
    }  
    if(isset($RL_CM_EX_AUDIT['CDET6'])) {
       $RL_CEM_CDET6=$RL_CM_EX_AUDIT['CDET6']; 
    }
    if(isset($RL_CM_EX_AUDIT['CDET7'])) {
       $RL_CEM_CDET7=$RL_CM_EX_AUDIT['CDET7']; 
    } 
    if(isset($RL_CM_EX_AUDIT['CDET8'])) {
       $RL_CEM_CDET8=$RL_CM_EX_AUDIT['CDET8']; 
    }  
    if(isset($RL_CM_EX_AUDIT['QCT1'])) {
       $RL_CEM_QCT1=$RL_CM_EX_AUDIT['QCT1']; 
    }
    if(isset($RL_CM_EX_AUDIT['QCT2'])) {
       $RL_CEM_QCT2=$RL_CM_EX_AUDIT['QCT2']; 
    }  
    if(isset($RL_CM_EX_AUDIT['QCT3'])) {
       $RL_CEM_QCT3=$RL_CM_EX_AUDIT['QCT3']; 
    }  
    if(isset($RL_CM_EX_AUDIT['QCT4'])) {
       $RL_CEM_QCT4=$RL_CM_EX_AUDIT['QCT4']; 
    }  
    if(isset($RL_CM_EX_AUDIT['QCT5'])) {
       $RL_CEM_QCT5=$RL_CM_EX_AUDIT['QCT5']; 
    }
    if(isset($RL_CM_EX_AUDIT['QCT6'])) {
       $RL_CEM_QCT6=$RL_CM_EX_AUDIT['QCT6']; 
    }  
    if(isset($RL_CM_EX_AUDIT['QCT7'])) {
       $RL_CEM_QCT7=$RL_CM_EX_AUDIT['QCT7']; 
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
    <title>ADL | View Royal London Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/styles/viewlayout.css" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/js/jquery-1.4.min.js"></script>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <script>
        function toggle(id) {
            if (document.getElementById(id).style.display == 'none') {
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
                        <td colspan=2><b>Royal London Call Audit ID: <?php echo $AUDITID ?></b></td>
                    </tr>

                    <tr>

                        <?php
                        
                        if ($RL_GRADE == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>$RL_GRADE</b></td>";
                        } else if ($RL_GRADE == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>$RL_GRADE</b></td>";
                        } else if ($RL_GRADE == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>$RL_GRADE</b></td>";
                        }
                        ?>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php echo $RL_ADDED_BY; ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php echo $RL_CLOSER; if(isset($RL_CLOSER2) && $RL_CLOSER2 !="None") { echo " - $RL_CLOSER2"; } ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php echo $RL_ADDED_DATE; ?></td>
                    </tr>

                    <tr>
                        <td>Plan Number</td>
                        <td><?php echo $RL_PLAN_NUMBER; ?></td>
                    </tr>

                </thead>
            </table>
           
           <h1><b>Opening Declaration</b></h1>

            <p>
                <label for="q1">Q<?php $i=0; $i++; echo $i; ?>. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?</label><br>
                <input type="radio" name="q1" value="Yes" onclick="return false"onclick="return false"<?php if(isset($RL_OD1)) { if ($RL_OD1 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q1" value="No" onclick="return false"onclick="return false"<?php if(isset($RL_OD1)) { if ($RL_OD1 == "0") { echo "checked"; } } ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php if(isset($RL_CM_ODT1)) { echo $RL_CM_ODT1; } ?>
            </div>
            </p>

            <p>
                <label for="q2">Q<?php $i++; echo $i; ?>. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label><br>
                <input type="radio" name="q2" value="Yes" onclick="return false"onclick="return false"<?php if(isset($RL_OD2)) { if ($RL_OD2 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q2" value="No" onclick="return false"onclick="return false"<?php if(isset($RL_OD2)) { if ($RL_OD2 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($RL_CM_ODT2)) { echo $RL_CM_ODT2; } ?>
            </div>
            </p>

            <p>
                <label for="q3">Q<?php $i++; echo $i; ?>. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label><br>
                <input type="radio" name="q3" value="Yes" onclick="return false"onclick="return false"<?php if(isset($RL_OD3)) { if ($RL_OD3 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q3" value="No" onclick="return false"onclick="return false"<?php if(isset($RL_OD3)) { if ($RL_OD3 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($RL_CM_ODT3)) { echo $RL_CM_ODT3; } ?>
            </div>
            </p>

            <p>
                <label for="q4">Q<?php $i++; echo $i; ?>. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label><br>


                <input type="radio" name="q4" value="Yes" onclick="return false"onclick="return false"<?php if(isset($RL_OD4)) {  if ($RL_OD4 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q4" value="No" onclick="return false"onclick="return false"<?php if(isset($RL_OD4)) { if ($RL_OD4 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($RL_CM_ODT4)) { echo $RL_CM_ODT4; } ?>
            </div>
            </p>

            <p>
                <label for="q5">Q<?php $i++; echo $i; ?>. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>

                <input type="radio" name="q5" value="Yes" onclick="return false"onclick="return false"<?php if(isset($RL_OD5)) {  if ($RL_OD5 == "1") { echo "checked"; } } ?> >Yes
                <input type="radio" name="q5" value="No" onclick="return false"onclick="return false"<?php if(isset($RL_OD5)) {  if ($RL_OD5 == "0") { echo "checked"; } } ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php if(isset($RL_CM_ODT5)) { echo $RL_CM_ODT5; } ?>
            </div>
            </p>   
            
             <h3 class="panel-title">Customer Information</h3>
             
<p>
    <label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients gender accurately recorded?</label><br>
<input type="radio" name="CI1" <?php if (isset($RL_CI1) && $RL_CI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT1();" value="1" id="yesCheckCIT1">Yes
<input type="radio" name="CI1" <?php if (isset($RL_CI1) && $RL_CI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT1();" value="0" id="noCheckCIT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT1)) { echo $RL_CM_CIT1; } ?></div>



<p>
<label for="CI2">Q<?php $i++; echo $i; ?>. Was the clients date of birth accurately recorded?</label><br>
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();" <?php if (isset($RL_CI2) && $RL_CI2=="1") { echo "checked"; } ?> value="1" id="yesCheck">Yes 
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();" <?php if (isset($RL_CI2) && $RL_CI2=="0") { echo "checked"; } ?> value="0" id="noCheck">No
</p>
<div class="phpcomments"><?php if(isset($RL_CM_CIT2)) { echo $RL_CM_CIT2; } ?></div>


<p>
<label for="CI3">Q<?php $i++; echo $i; ?>. Was the clients smoking status recorded correctly?</label><br>
<input type="radio" name="CI3" 
<?php if (isset($RL_CI3) && $RL_CI3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT3();" value="1" id="yesCheckCIT3">Yes <input type="radio" name="CI3"
<?php if (isset($RL_CI3) && $RL_CI3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT3();" value="0" id="noCheckCIT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT3)) { echo $RL_CM_CIT3; } ?></div>


<p>
<label for="CI4">Q<?php $i++; echo $i; ?>. Was the clients employment status recorded correctly?</label><br>
<input type="radio" name="CI4" <?php if (isset($RL_CI4) && $RL_CI4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT4();" value="1" id="yesCheckCIT4">Yes
<input type="radio" name="CI4" <?php if (isset($RL_CI4) && $RL_CI4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT4();" value="0" id="noCheckCIT4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT4)) { echo $RL_CM_CIT4; } ?></div>

<p>
<label for="CI5">Q<?php $i++; echo $i; ?>. Did the closer confirm the policy was a single or a joint application?</label><br>
<input type="radio" name="CI5" <?php if (isset($RL_CI5) && $RL_CI5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT5();" value="1" id="yesCheckCIT5">Yes
<input type="radio" name="CI5" <?php if (isset($RL_CI5) && $RL_CI5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT5();" value="0" id="noCheckCIT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT5)) { echo $RL_CM_CIT5; } ?></div>

<p>
<label for="CI6">Q<?php $i++; echo $i; ?>. Was the clients country of residence recorded correctly?</label><br>
<input type="radio" name="CI6" <?php if (isset($RL_CI6) && $RL_CI6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT6();" value="1" id="yesCheckCIT6">Yes
<input type="radio" name="CI6" <?php if (isset($RL_CI6) && $RL_CI6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT6();" value="0" id="noCheckCIT6">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT6)) { echo $RL_CM_CIT6; } ?></div>

<p>
<label for="CI7">Q<?php $i++; echo $i; ?>. Was the clients occupation recorded correctly?</label><br>
<input type="radio" name="CI7" <?php if (isset($RL_CI7) && $RL_CI7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT7();" value="1" id="yesCheckCIT7">Yes
<input type="radio" name="CI7" <?php if (isset($RL_CI7) && $RL_CI7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT7();" value="0" id="noCheckCIT7">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT7)) { echo $RL_CM_CIT7; } ?></div>

<p>
<label for="CI8">Q<?php $i++; echo $i; ?>. Was the clients salary recorded correctly?</label><br>
<input type="radio" name="CI8" <?php if (isset($RL_CI8) && $RL_CI8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT8();" value="1" id="yesCheckCIT8">Yes
<input type="radio" name="CI8" <?php if (isset($RL_CI8) && $RL_CI8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT8();" value="0" id="noCheckCIT8">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CIT8)) { echo $RL_CM_CIT8; } ?></div>

<h3 class="panel-title">Identifying Clients Needs</h3>

<p>
    <label for="IC1">Q<?php $i++; echo $i; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label><br>
<input type="radio" name="IC1" <?php if (isset($RL_IC1) && $RL_IC1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT1();" value="1" id="yesCheckICT1">Yes
<input type="radio" name="IC1" <?php if (isset($RL_IC1) && $RL_IC1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT1();" value="0" id="noCheckICT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_ICT1)) { echo $RL_CM_ICT1; } ?></div>

<p>
<label for="IC2">Q<?php $i++; echo $i; ?>. Did the closer mention waiver, indexation, or TPD?</label><br>
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT2();" value="1" id="yesCheckICT2">Yes
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT2();" value="0" id="noCheckICT2">No
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="3") { echo "checked"; } ?> value="3" >N/A
</p>

<div class="phpcomments"><?php if(isset($RL_CM_ICT2)) { echo $RL_CM_ICT2; } ?></div>

<p>
<label for="IC3">Q<?php $i++; echo $i; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label><br>
<input type="radio" name="IC3" <?php if (isset($RL_IC3) && $RL_IC3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT3();" value="1" id="yesCheckICT3">Yes
<input type="radio" name="IC3" <?php if (isset($RL_IC3) && $RL_IC3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT3();" value="0" id="noCheckICT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_ICT3)) { echo $RL_CM_ICT3; } ?></div>

<p>
<label for="IC4">Q<?php $i++; echo $i; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label><br>
<select class="form-control" name="IC4" onclick="javascript:yesnoCheckICT4();">
  <option value="0" <?php if(isset($RL_IC4)) { if($RL_IC4=='0') { echo "selected"; } } ?>>Select...</option>
  <option value="1" <?php if(isset($RL_IC4)) { if($RL_IC4=='1') { echo "selected"; } } ?>>More than sufficient</option>
  <option value="2" <?php if(isset($RL_IC4)) { if($RL_IC4=='2') { echo "selected"; } } ?>>Sufficient</option>
  <option value="3" <?php if(isset($RL_IC4)) { if($RL_IC4=='3') { echo "selected"; } } ?>>Adequate</option>
  <option value="4" <?php if(isset($RL_IC4)) { if($RL_IC4=='4') { echo "selected"; } } ?> onclick="javascript:yesnoCheckICT4a();" id="yesCheckICT4">Poor</option>
</select>
</p>
<div class="phpcomments"><?php if(isset($RL_CM_ICT4)) { echo $RL_CM_ICT4; } ?></div>



<p>
<label for="IC5">Q<?php $i++; echo $i; ?>. Closer confirmed this policy will be set up with Royal London?</label><br>
<input type="radio" name="IC5" <?php if (isset($RL_IC5) && $RL_IC5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT5();" value="1" id="yesCheckICT5">Yes
<input type="radio" name="IC5" <?php if (isset($RL_IC5) && $RL_IC5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT5();" value="0" id="noCheckICT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_ICT5)) { echo $RL_CM_ICT5; } ?></div>

<h3 class="panel-title">Contact Details</h3>

<p>
    <label for="CD1">Q<?php $i++; echo $i; ?>. Were all clients titles and names recorded correctly?</label><br>
<input type="radio" name="CD1" <?php if (isset($RL_CD1) && $RL_CD1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT1();" value="1" id="yesCheckCDT1">Yes
<input type="radio" name="CD1" <?php if (isset($RL_CD1) && $RL_CD1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT1();" value="0" id="noCheckCDT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CDT1)) { echo $RL_CM_CDT1; } ?></div>


<p>
<label for="CD2">Q<?php $i++; echo $i; ?>. Was the clients marital status recorded correctly?</label><br>
<input type="radio" name="CD2" <?php if (isset($RL_CD2) && $RL_CD2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT2();" value="1" id="yesCheckCDT2">Yes
<input type="radio" name="CD2" <?php if (isset($RL_CD2) && $RL_CD2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT2();" value="0" id="noCheckCDT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CDT2)) { echo $RL_CM_CDT2; } ?></div>

</script>  

<p>
<label for="CD3">Q<?php $i++; echo $i; ?>. Was the clients address recored correctly?</label><br>
<input type="radio" name="CD3" <?php if (isset($RL_CD3) && $RL_CD3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT3();" value="1" id="yesCheckCDT3">Yes
<input type="radio" name="CD3" <?php if (isset($RL_CD3) && $RL_CD3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT3();" value="0" id="noCheckCDT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CDT3)) { echo $RL_CM_CDT3; } ?></div>



<p>
<label for="CD4">Q<?php $i++; echo $i; ?>. Was clients phone number(s) recorded correctly?</label><br>
<input type="radio" name="CD4" <?php if(isset($RL_CD4) && $RL_CD4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT4();" value="1" id="yesCheckCDT4">Yes
<input type="radio" name="CD4" <?php if(isset($RL_CD4) && $RL_CD4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT4();" value="0" id="noCheckCDT4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CDT4)) { echo $RL_CM_CDT4; } ?></div>


<p>
<label for="CD5">Q<?php $i++; echo $i; ?>. Was the clients email address recorded correctly?</label><br>
<input type="radio" name="CD5" <?php if(isset($RL_CD5) && $RL_CD5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT5();" value="1" id="yesCheckCDT5">Yes
<input type="radio" name="CD5" <?php if(isset($RL_CD5) && $RL_CD5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT5();" value="0" id="noCheckCDT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_CDT5)) { echo $RL_CM_CDT5; } ?></div>

<h3 class="panel-title">Declarations of Insurance</h3>

<p>
    <label for="DO1">Q<?php $i++; echo $i; ?>. Confirmed that we comply with the Data Protection Act, and are happy for their personal to be passed over the phone?</label><br>
<input type="radio" name="DO1" <?php if (isset($RL_DO1) && $RL_DO1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT1();" value="1" id="yesCheckDOT1">Yes
<input type="radio" name="DO1" <?php if (isset($RL_DO1) && $RL_DO1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT1();" value="0" id="noCheckDOT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT1)) { echo $RL_CM_DOT1; } ?></div>
       
           
<p>
<label for="DO2">Q<?php $i++; echo $i; ?>. The impact of misrepresentation declaration read out?</label><br>
<input type="radio" name="DO2" <?php if (isset($RL_DO2) && $RL_DO2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT2();" value="1" id="yesCheckDOT2">Yes
<input type="radio" name="DO2" <?php if (isset($RL_DO2) && $RL_DO2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT2();" value="0" id="noCheckDOT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT2)) { echo $RL_CM_DOT2; } ?></div>


<p>
<label for="DO3">Q<?php $i++; echo $i; ?>. If appropriate did the closer confirm the exclusions on the policy?</label><br>
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT3();" value="1" id="yesCheckDOT3">Yes
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT3();" value="0" id="noCheckDOT3">No
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="3") { echo "checked"; } ?> value="3" >N/A
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT3)) { echo $RL_CM_DOT3; } ?></div>


<p>
<label for="DO4">Q<?php $i++; echo $i; ?>. Client informed that Royal London may request a copy of their medical reports up to six months after the cover has started?</label><br>
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT4();" value="1" id="yesCheckDOT4">Yes
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT4();" value="0" id="noCheckDOT4">No
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="2") { echo "checked"; } ?> value="2" >N/A
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT4)) { echo $RL_CM_DOT4; } ?></div>


<p>
<label for="DO5">Q<?php $i++; echo $i; ?>. Did the closer ask the client to read out the Access to Medical Reports Act 1988 (or to send a copy)?</label><br>
<input type="radio" name="DO5" <?php if (isset($RL_DO5) && $RL_DO5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT5();" value="1" id="yesCheckDOT5">Yes
<input type="radio" name="DO5" <?php if (isset($RL_DO5) && $RL_DO5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT5();" value="0" id="noCheckDOT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT5)) { echo $RL_CM_DOT5; } ?></div>


<p>
<label for="DO6">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had any existing plans or an application with Royal London?</label><br>
<input type="radio" name="DO6" <?php if (isset($RL_DO6) && $RL_DO6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT6();" value="1" id="yesCheckDOT6">Yes
<input type="radio" name="DO6" <?php if (isset($RL_DO6) && $RL_DO6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT6();" value="0" id="noCheckDOT6">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT6)) { echo $RL_CM_DOT6; } ?></div>


<p>
<label for="DO7">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had an application on your life deferred or declined?</label><br>
<input type="radio" name="DO7" <?php if (isset($RL_DO7) && $RL_DO7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT7();" value="1" id="yesCheckDOT7">Yes
<input type="radio" name="DO7" <?php if (isset($RL_DO7) && $RL_DO7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT7();" value="0" id="noCheckDOT7">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT7)) { echo $RL_CM_DOT7; } ?></div>


<p>
<label for="DO8">Q<?php $i++; echo $i; ?>. Did the closer ask the client if the total amount of cover that they have applied for, added to the amount that they already have, across all insurance companies exceed £1,000,000 life cover or £400,000 CIC?</label><br>
<input type="radio" name="DO8" <?php if (isset($RL_DO8) && $RL_DO8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT8();" value="1" id="yesCheckDOT8">Yes
<input type="radio" name="DO8" <?php if (isset($RL_DO8) && $RL_DO8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT8();" value="0" id="noCheckDOT8">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_DOT8)) { echo $RL_CM_DOT8; } ?></div>

<h3 class="panel-title">Life Style</h3>

<p>
    <label for="LS1">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the height and weight details correctly?</label><br>
<input type="radio" name="LS1" <?php if (isset($RL_LS1) && $RL_LS1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST1();" value="1" id="yesCheckLST1">Yes
<input type="radio" name="LS1" <?php if (isset($RL_LS1) && $RL_LS1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST1();" value="0" id="noCheckLST1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST1)) { echo $RL_CM_LST1; } ?></div>


<p>
<label for="LS2">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the clients clothe measurements?</label><br>
<input type="radio" name="LS2" <?php if (isset($RL_LS2) && $RL_LS2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST2();" value="1" id="yesCheckLST2">Yes
<input type="radio" name="LS2" <?php if (isset($RL_LS2) && $RL_LS2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST2();" value="0" id="noCheckLST2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST2)) { echo $RL_CM_LST2; } ?></div>



<p>
<label for="LS3">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the smoking details correctly?</label><br>
<input type="radio" name="LS3" <?php if (isset($RL_LS3) && $RL_LS3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST3();" value="1" id="yesCheckLST3">Yes
<input type="radio" name="LS3" <?php if (isset($RL_LS3) && $RL_LS3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST3();" value="0" id="noCheckLST3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST3)) { echo $RL_CM_LST3; } ?></div>


<p>
<label for="LS4">Q<?php $i++; echo $i; ?>. Was the client asked how many units of alcohol they drink in a week?</label><br>
<input type="radio" name="LS4" <?php if (isset($RL_LS4) && $RL_LS4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST4();" value="1" id="yesCheckLST4">Yes
<input type="radio" name="LS4" <?php if (isset($RL_LS4) && $RL_LS4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST4();" value="0" id="noCheckLST4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST4)) { echo $RL_CM_LST4; } ?></div>


<p>
<label for="LS5">Q<?php $i++; echo $i; ?>. Did the closer ask if they have been disqualified from driving in the last 5 years?</label><br>
<input type="radio" name="LS5" <?php if (isset($RL_LS5) && $RL_LS5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST5();" value="1" id="yesCheckLST5">Yes
<input type="radio" name="LS5" <?php if (isset($RL_LS5) && $RL_LS5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST5();" value="0" id="noCheckLST5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST5)) { echo $RL_CM_LST5; } ?></div>


<p>
<label for="LS6">Q<?php $i++; echo $i; ?>. Did the closer ask if the client has used recreational drugs in the last 10 years?</label><br>
<input type="radio" name="LS6" <?php if (isset($RL_LS6) && $RL_LS6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST6();" value="1" id="yesCheckLST6">Yes
<input type="radio" name="LS6" <?php if (isset($RL_LS6) && $RL_LS6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST6();" value="0" id="noCheckLST6">No
</p>

<div id="ifYesLST6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<div class="phpcomments"><?php if(isset($RL_CM_LST6)) { echo $RL_CM_LST6; } ?></div>



<p>
<label for="LS7">Q<?php $i++; echo $i; ?>. Did the closer check if the client had undertaken any of the listed activities?</label><br>
<input type="radio" name="LS7" <?php if (isset($RL_LS7) && $RL_LS7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST7();" value="1" id="yesCheckLST7">Yes
<input type="radio" name="LS7" <?php if (isset($RL_LS7) && $RL_LS7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST7();" value="0" id="noCheckLST7">No
</p>

<div class="phpcomments"><?php if(isset($RL_CM_LST7)) { echo $RL_CM_LST7; } ?></div>

<h3 class="panel-title">Occupation and Travel</h3>

<p>
    <label for="OT1">Q<?php $i++; echo $i; ?>. Was the client asked if their job involves manual work or driving?</label><br>
<input type="radio" name="OT1" <?php if (isset($RL_OT1) && $RL_OT1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT1();" value="1" id="yesCheckOTT1">Yes
<input type="radio" name="OT1" <?php if (isset($RL_OT1) && $RL_OT1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT1();" value="0" id="noCheckOTT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_OTT1)) { echo $RL_CEM_OTT1; } ?></div>


<p>
<label for="OT2">Q<?php $i++; echo $i; ?>. Was the client asked if they undertake in any of the listed hazardous activities?</label><br>
<input type="radio" name="OT2" <?php if (isset($RL_OT2) && $RL_OT2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT2();" value="1" id="yesCheckOTT2">Yes
<input type="radio" name="OT2" <?php if (isset($RL_OT2) && $RL_OT2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT2();" value="0" id="noCheckOTT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_OTT2)) { echo $RL_CEM_OTT2; } ?></div>


<p>
<label for="OT3">Q<?php $i++; echo $i; ?>. Was the client asked if they have worked/travelled out the listed countries (in the last 2 years, or do they intend to)?</label><br>
<input type="radio" name="OT3" <?php if (isset($RL_OT3) && $RL_OT3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT3();" value="1" id="yesCheckOTT3">Yes
<input type="radio" name="OT3" <?php if (isset($RL_OT3) && $RL_OT3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT3();" value="0" id="noCheckOTT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_OTT3)) { echo $RL_CEM_OTT3; } ?></div>

<h3 class="panel-title">Health Questions</h3>

<p>
    <label for="HQ1">Q<?php $i++; echo $i; ?>. Was the client asked if they have ever had any health problems?</label><br>
<input type="radio" name="HQ1" <?php if (isset($RL_QE_HQ1) && $RL_QE_HQ1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT1();" value="1" id="yesCheckHQT1">Yes
<input type="radio" name="HQ1" <?php if (isset($RL_QE_HQ1) && $RL_QE_HQ1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT1();" value="0" id="noCheckHQT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT1)) { echo $RL_CEM_HQT1; } ?></div>


<p>
<label for="HQ2">Q<?php $i++; echo $i; ?>. Were all health in the last 5 years questions asked and recorded correctly?</label><br>
<input type="radio" name="HQ2" <?php if (isset($RL_QE_HQ2) && $RL_QE_HQ2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT2();" value="1" id="yesCheckHQT2">Yes
<input type="radio" name="HQ2" <?php if (isset($RL_QE_HQ2) && $RL_QE_HQ2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT2();" value="0" id="noCheckHQT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT2)) { echo $RL_CEM_HQT2; } ?></div>


<p>
<label for="HQ3">Q<?php $i++; echo $i; ?>. Were all health in the last 3 years questions asked and recorded correctly?</label><br>
<input type="radio" name="HQ3" <?php if (isset($RL_QE_HQ3) && $RL_QE_HQ3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT3();" value="1" id="yesCheckHQT3">Yes
<input type="radio" name="HQ3" <?php if (isset($RL_QE_HQ3) && $RL_QE_HQ3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT3();" value="0" id="noCheckHQT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT3)) { echo $RL_CEM_HQT3; } ?></div>

</script>

<p>
<label for="HQ4">Q<?php $i++; echo $i; ?>. Was the client asked if their family have any medical history?</label><br>
<input type="radio" name="HQ4" <?php if (isset($RL_QE_HQ4) && $RL_QE_HQ4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT4();" value="1" id="yesCheckHQT4">Yes
<input type="radio" name="HQ4" <?php if (isset($RL_QE_HQ4) && $RL_QE_HQ4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT4();" value="0" id="noCheckHQT4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT4)) { echo $RL_CEM_HQT4; } ?></div>
  

<p>
<label for="HQ5">Q<?php $i++; echo $i; ?>. If appropriate, did the closer confirm any exclusions on the policy?</label><br>
<input type="radio" name="HQ5" <?php if (isset($RL_QE_HQ5) && $RL_QE_HQ5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT5();" value="1" id="yesCheckHQT5">Yes
<input type="radio" name="HQ5" <?php if (isset($RL_QE_HQ5) && $RL_QE_HQ5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT5();" value="0" id="noCheckHQT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT5)) { echo $RL_CEM_HQT5; } ?></div>
 

<p>
<label for="HQ6">Q<?php $i++; echo $i; ?>. Were all of the health questions recorded correctly?</label><br>
<input type="radio" name="HQ6" <?php if (isset($RL_QE_HQ6) && $RL_QE_HQ6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT6();" value="1" id="yesCheckHQT6">Yes
<input type="radio" name="HQ6" <?php if (isset($RL_QE_HQ6) && $RL_QE_HQ6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT6();" value="0" id="noCheckHQT6">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_HQT6)) { echo $RL_CEM_HQT6; } ?></div>

<h3 class="panel-title">Eligibility</h3>

<p>
    <label for="E1">Q<?php $i++; echo $i; ?>. Important customer information declaration?</label><br>
<input type="radio" name="E1" <?php if (isset($RL_QE_E1) && $RL_QE_E1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="1" id="yesCheckET1">Yes
<input type="radio" name="E1" <?php if (isset($RL_QE_E1) && $RL_QE_E1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="0" id="noCheckET1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET1)) { echo $RL_CEM_ET1; } ?></div>


<p>
<label for="E2">Q<?php $i++; echo $i; ?>. Were all clients contact details recorded correctly?</label><br>
<input type="radio" name="E2" <?php if (isset($RL_QE_E2) && $RL_QE_E2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="1" id="yesCheckET2">Yes
<input type="radio" name="E2" <?php if (isset($RL_QE_E2) && $RL_QE_E2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="0" id="noCheckET2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET2)) { echo $RL_CEM_ET2; } ?></div>


<p>
<label for="E3">Q<?php $i++; echo $i; ?>. Were all clients address details recorded correctly?</label><br>
<input type="radio" name="E3" <?php if (isset($RL_QE_E3) && $RL_QE_E3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="1" id="yesCheckET3">Yes
<input type="radio" name="E3" <?php if (isset($RL_QE_E3) && $RL_QE_E3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="0" id="noCheckET3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET3)) { echo $RL_CEM_ET3; } ?></div>


<p>
<label for="E4">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label><br>
<input type="radio" name="E4" <?php if (isset($RL_QE_E4) && $RL_QE_E4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="1" id="yesCheckET4">Yes
<input type="radio" name="E4" <?php if (isset($RL_QE_E4) && $RL_QE_E4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="0" id="noCheckET4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET4)) { echo $RL_CEM_ET4; } ?></div>


<p>
<label for="E5">Q<?php $i++; echo $i; ?>. Were all family history questions asked and recorded correctly?</label><br>
<input type="radio" name="E5" <?php if (isset($RL_QE_E5) && $RL_QE_E5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E5" <?php if (isset($RL_QE_E5) && $RL_QE_E5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET5)) { echo $RL_CEM_ET5; } ?></div>


<p>
<label for="E6">Q<?php $i++; echo $i; ?>. Were term for term details recorded correctly?</label><br>
<select class="form-control" name="E6" >
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='0') { echo "selected"; } ?> value="0">Select...</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='1') { echo "selected"; } ?> value="1">Client Provided Details</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='2') { echo "selected"; } ?> value="2">Client failed to provide details</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='3') { echo "selected"; } ?> value="3">Not existing Royal London customer</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='4') { echo "selected"; } ?> value="4">Obtained from Term4Term service</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='5') { echo "selected"; } ?> value="5">Existing Royal London Policy, no attempt to get policy number</option>
</select>
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_ET6)) { echo $RL_CEM_ET6; } ?></div>

<h3 class="panel-title">Payment Information</h3>

<p>
    <label for="PI1">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label><br>
<input type="radio" name="PI1" <?php if (isset($RL_QE_PI1) && $RL_QE_PI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="1" id="yesCheckPIT1">Yes
<input type="radio" name="PI1" <?php if (isset($RL_QE_PI1) && $RL_QE_PI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="0" id="noCheckPIT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_PIT1)) { echo $RL_CEM_PIT1; } ?></div>


<p>
<label for="PI2">Q<?php $i++; echo $i; ?>. Did the closer offer to read the direct debit guarantee?</label><br>
<input type="radio" name="PI2" <?php if (isset($RL_QE_PI2) && $RL_QE_PI2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="1" id="yesCheckPIT2">Yes
<input type="radio" name="PI2" <?php if (isset($RL_QE_PI2) && $RL_QE_PI2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="0" id="noCheckPIT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_PIT2)) { echo $RL_CEM_PIT2; } ?></div>


<p>
<label for="PI3">Q<?php $i++; echo $i; ?>. Did the closer offer a preferred premium collection date?</label><br>
<input type="radio" name="PI3" <?php if (isset($RL_QE_PI3) && $RL_QE_PI3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="1" id="yesCheckPIT3">Yes
<input type="radio" name="PI3" <?php if (isset($RL_QE_PI3) && $RL_QE_PI3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="0" id="noCheckPIT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_PIT3)) { echo $RL_CEM_PIT3; } ?></div>


<p>
<label for="PI4">Q<?php $i++; echo $i; ?>. Did the closer record the bank details correctly?</label><br>
<input type="radio" name="PI4" <?php if (isset($RL_QE_PI4) && $RL_QE_PI4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="1" id="yesCheckPIT4">Yes
<input type="radio" name="PI4" <?php if (isset($RL_QE_PI4) && $RL_QE_PI4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="0" id="noCheckPIT4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_PIT4)) { echo $RL_CEM_PIT4; } ?></div>


<p>
<label for="PI5">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label><br>
<input type="radio" name="PI5" <?php if (isset($RL_QE_PI5) && $RL_QE_PI5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="1" id="yesCheckPIT5">Yes
<input type="radio" name="PI5" <?php if (isset($RL_QE_PI5) && $RL_QE_PI5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="0" id="noCheckPIT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_PIT5)) { echo $RL_CEM_PIT5; } ?></div>

<h3 class="panel-title">Consolidation Declaration</h3>

<p>
    <label for="CDE1">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label><br>
<input type="radio" name="CDE1" <?php if (isset($RL_QE_CDE1) && $RL_QE_CDE1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="1" id="yesCheckCDET1">Yes
<input type="radio" name="CDE1" <?php if (isset($RL_QE_CDE1) && $RL_QE_CDE1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="0" id="noCheckCDET1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET1)) { echo $RL_CEM_CDET1; } ?></div>



<p>
<label for="CDE2">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label><br>
<input type="radio" name="CDE2" <?php if (isset($RL_QE_CDE2) && $RL_QE_CDE2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="1" id="yesCheckCDET2">Yes
<input type="radio" name="CDE2" <?php if (isset($RL_QE_CDE2) && $RL_QE_CDE2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="0" id="noCheckCDET2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET2)) { echo $RL_CEM_CDET2; } ?></div>


<p>
<label for="CDE3">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label><br>
<input type="radio" name="CDE3" <?php if (isset($RL_QE_CDE3) && $RL_QE_CDE3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="1" id="yesCheckCDET3">Yes
<input type="radio" name="CDE3" <?php if (isset($RL_QE_CDE3) && $RL_QE_CDE3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="0" id="noCheckCDET3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET3)) { echo $RL_CEM_CDET3; } ?></div>


<p>
<label for="CDE4">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>
<input type="radio" name="CDE4" <?php if (isset($RL_QE_CDE4) && $RL_QE_CDE4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="1" id="yesCheckCDET4">Yes
<input type="radio" name="CDE4" <?php if (isset($RL_QE_CDE4) && $RL_QE_CDE4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="0" id="noCheckCDET4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET4)) { echo $RL_CEM_CDET4; } ?></div>


<p>
<label for="CDE5">Q<?php $i++; echo $i; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Royal London?</label><br>
<input type="radio" name="CDE5"  <?php if (isset($RL_QE_CDE5) && $RL_QE_CDE5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="1" id="yesCheckCDET5">Yes
<input type="radio" name="CDE5" <?php if (isset($RL_QE_CDE5) && $RL_QE_CDE5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="0" id="noCheckCDET5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET5)) { echo $RL_CEM_CDET5; } ?></div>


<p>
<label for="CDE6">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label><br>
<input type="radio" name="CDE6" <?php if (isset($RL_QE_CDE6) && $RL_QE_CDE6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="1" id="yesCheckCDET6">Yes
<input type="radio" name="CDE6" <?php if (isset($RL_QE_CDE6) && $RL_QE_CDE6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="0" id="noCheckCDET6">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET6)) { echo $RL_CEM_CDET6; } ?></div>



<p>
<label for="CDE7">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Royal London will write to them with a more specific date?</label><br>
<input type="radio" name="CDE7" <?php if (isset($RL_QE_CDE7) && $RL_QE_CDE7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="1" id="yesCheckCDET7">Yes
<input type="radio" name="CDE7" <?php if (isset($RL_QE_CDE7) && $RL_QE_CDE7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="0" id="noCheckCDET7">No

</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET7)) { echo $RL_CEM_CDET7; } ?></div>


<p>
<label for="CDE8">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label><br>
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="1" id="yesCheckCDET8">Yes
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="0" id="noCheckCDET8">No
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="3") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="3" id="yesCheckCDET8">N/A
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_CDET8)) { echo $RL_CEM_CDET8; } ?></div>

 <h3 class="panel-title">Quality Control</h3>
 
 <p>
     <label for="QC1">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Royal London with client information?</label><br>
<input type="radio" name="QC1" <?php if (isset($RL_QE_QC1) && $RL_QE_QC1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="1" id="yesCheckQCT1">Yes
<input type="radio" name="QC1" <?php if (isset($RL_QE_QC1) && $RL_QE_QC1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="0" id="noCheckQCT1">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT1)) { echo $RL_CEM_QCT1; } ?></div>


<p>
<label for="QC2">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label><br>
<input type="radio" name="QC2" <?php if (isset($RL_QE_QC2) && $RL_QE_QC2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="1" id="yesCheckQCT2">Yes
<input type="radio" name="QC2" <?php if (isset($RL_QE_QC2) && $RL_QE_QC2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="0" id="noCheckQCT2">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT2)) { echo $RL_CEM_QCT2; } ?></div>


<p>
<label for="QC3">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label><br>
<input type="radio" name="QC3" <?php if (isset($RL_QE_QC3) && $RL_QE_QC3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="1" id="yesCheckQCT3">Yes
<input type="radio" name="QC3" <?php if (isset($RL_QE_QC3) && $RL_QE_QC3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="0" id="noCheckQCT3">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT3)) { echo $RL_CEM_QCT3; } ?></div>


<p>
<label for="QC4">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label><br>
<input type="radio" name="QC4" <?php if (isset($RL_QE_QC4) && $RL_QE_QC4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="1" id="yesCheckQCT4">Yes
<input type="radio" name="QC4" <?php if (isset($RL_QE_QC4) && $RL_QE_QC4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="0" id="noCheckQCT4">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT4)) { echo $RL_CEM_QCT4; } ?></div>


<p>
<label for="QC5">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label><br>
<input type="radio" name="QC5" <?php if (isset($RL_QE_QC5) && $RL_QE_QC5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="1" id="yesCheckQCT5">Yes
<input type="radio" name="QC5" <?php if (isset($RL_QE_QC5) && $RL_QE_QC5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="0" id="noCheckQCT5">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT5)) { echo $RL_CEM_QCT5; } ?></div>


<p>
<label for="QC6">Q<?php $i++; echo $i; ?>. Closer provided contact details for Bluestone Protect?</label><br>
<input type="radio" name="QC6" <?php if (isset($RL_QE_QC6) && $RL_QE_QC6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="1" id="yesCheckQCT6">Yes
<input type="radio" name="QC6" <?php if (isset($RL_QE_QC6) && $RL_QE_QC6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="0" id="noCheckQCT6">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT6)) { echo $RL_CEM_QCT6; } ?></div>


<p>
<label for="QC7">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label><br>
<input type="radio" name="QC7" <?php if (isset($RL_QE_QC7) && $RL_QE_QC7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="1" id="yesCheckQCT7">Yes
<input type="radio" name="QC7" <?php if (isset($RL_QE_QC7) && $RL_QE_QC7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="0" id="noCheckQCT7">No
</p>

<div class="phpcomments"><?php if(isset($RL_CEM_QCT7)) { echo $RL_CEM_QCT7; } ?></div>



       </div>
</div>
    
</html>
