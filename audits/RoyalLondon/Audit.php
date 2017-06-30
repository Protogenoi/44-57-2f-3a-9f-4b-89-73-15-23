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
    if ($fferror == '0') {
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
    if($EXECUTE=='EDIT') {
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
<html lang="en">
<title>ADL | Royal London Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layout.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>
<?php include('../../php/Holidays.php'); ?>
</head>
<body>

<?php include('../../includes/navbar.php'); 
?>

<div class="container">
    
    <?php if(isset($EXECUTE)) {
        if($EXECUTE=='VIEW') { ?>
         <form action="#" method="POST" autocomplete="off">   
      <?php  }
        elseif($EXECUTE=='EDIT') { ?>
        <form action="php/Audit.php?EXECUTE=EDIT&AUDITID=<?php if(isset($AUDITID)) { echo $AUDITID; } ?>" method="POST" autocomplete="off">     
     <?php   }
    } else { ?>
    
    <form action="php/Audit.php?EXECUTE=NEW" method="POST" autocomplete="off">
    
    <?php } ?>
        
        
<fieldset>   
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Royal London Audit <?php if(isset($RL_ADDED_BY)) { echo " | Audited by $RL_ADDED_BY on $RL_ADDED_DATE"; } ?></h3>
        </div>
        <div class="panel-body">
<p>

<div class='form-group'>
<label for='CLOSER'>Closer:</label>
<select class='form-control' name='CLOSER' id='CLOSER' required> 
    <option value="">Select...</option>
    <?php if($companynamere=='Bluestone Protect') { ?>
    <option value="Carys" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Carys') { echo "selected"; } } ?> >Carys</option>
    <option value="David" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='David') { echo "selected"; } } ?> >David</option>
    <option value="Hayley" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Hayley') { echo "selected"; } } ?> >Hayley</option>
    <option value="James" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='James') { echo "selected"; } } ?> >James</option>
    <option value="Kyle" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Kyle') { echo "selected"; } } ?> >Kyle</option>  
    <option value="Mike" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Mike') { echo "selected"; } } ?> >Mike</option> 
    <option value="Richard" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Richard') { echo "selected"; } } ?>>Richard</option>
    <option value="Sarah" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Sarah') { echo "selected"; } } ?> >Sarah</option>
    <option value="Nicola" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Nicola') { echo "selected"; } } ?> >Nicola</option>  
    <option value="Gavin" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Gavin') { echo "selected"; } } ?> >Gavin</option>
    <?php } ?>
    <?php if($companynamere=='ADL_CUS') { ?>
    <option value="Dan Matthews" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Dan Matthews') { echo "selected"; } } ?> >Dan Matthews</option>
    <option value="Joe Rimmell" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Joe Rimmell') { echo "selected"; } } ?> >Joe Rimmell</option>
    <option value="Jordan Davies" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Jordan Davies') { echo "selected"; } } ?> >Jordan Davies</option>
    <option value="Matthew Brace" <?php if(isset($RL_CLOSER)) { if($RL_CLOSER=='Matthew Brace') { echo "selected"; } } ?> >Matthew Brace</option>  
    <?php } ?>    
</select>
</div>

<div class='form-group'>
<label for='CLOSER2'>Closer (optional):</label>
<select class='form-control' name='CLOSER2' id='CLOSER2' >    
<option value="None">None</option>    
    <?php if($companynamere=='Bluestone Protect') { ?>
    <option value="Carys" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Carys') { echo "selected"; } } ?> >Carys</option>
    <option value="Hayley" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Hayley') { echo "selected"; } } ?> >Hayley</option>
    <option value="James" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='James') { echo "selected"; } } ?> >James</option>
    <option value="Kyle" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Kyle') { echo "selected"; } } ?> >Kyle</option>  
    <option value="Mike" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Mike') { echo "selected"; } } ?> >Mike</option> 
    <option value="Richard" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Richard') { echo "selected"; } } ?>>Richard</option>
    <option value="Sarah" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Sarah') { echo "selected"; } } ?> >Sarah</option>
    <option value="Nicola" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Nicola') { echo "selected"; } } ?> >Nicola</option>  
    <option value="Gavin" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Gavin') { echo "selected"; } } ?> >Gavin</option>
    <?php } ?>
    <?php if($companynamere=='ADL_CUS') { ?>
    <option value="Carys" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Dan Matthews') { echo "selected"; } } ?> >Dan Matthews</option>
    <option value="Hayley" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Joe Rimmell') { echo "selected"; } } ?> >Joe Rimmell</option>
    <option value="James" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Jordan Davies') { echo "selected"; } } ?> >Jordan Davies</option>
    <option value="Kyle" <?php if(isset($RL_CLOSER2)) { if($RL_CLOSER2=='Matthew Brace') { echo "selected"; } } ?> >Matthew Brace</option>  
    <?php } ?>  
</select>
</div>

<label for="PLAN_NUMBER">Plan Number</label>
<input type="text" class="form-control" name="PLAN_NUMBER" style="width: 520px" VALUE="<?php if(isset($RL_PLAN_NUMBER)) { echo $RL_PLAN_NUMBER; } ?>" >
</p>

<p>
<div class="form-group">
<label for='GRADE'>Grade:</label>
<select class="form-control" name="GRADE" required>
  <option value="">Select...</option>
  <option <?php if(isset($RL_GRADE)) { if($RL_GRADE=='Save') { echo "selected"; } } ?> value="Save">Incomplete Audit (SAVE)</option>
  <option <?php if(isset($RL_GRADE)) { if($RL_GRADE=='Green') { echo "selected"; } } ?> value="Green">Green</option>
  <option <?php if(isset($RL_GRADE)) { if($RL_GRADE=='Amber') { echo "selected"; } } ?> value="Amber">Amber</option>
  <option <?php if(isset($RL_GRADE)) { if($RL_GRADE=='Red') { echo "selected"; } } ?> value="Red">Red</option>
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
<label for="OD1">Q<?php $i=0; $i++; echo $i; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
<input type="radio" name="OD1" 
<?php if (isset($RL_OD1) && $RL_OD1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT1();" value="1" id="yesCheckODT1">Yes
<input type="radio" name="OD1"
<?php if (isset($RL_OD1) && $RL_OD1=="0") { echo "checked"; }?> onclick="javascript:yesnoCheckODT1();" value="0" id="noCheckODT1">No
</p>

<div id="ifYesODT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ODT1" name="ODT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ODT1)) { echo $RL_CM_ODT1; } ?></textarea><span class="help-block"><p id="ODTchars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ODTchars').text('400 characters left');
    $('#ODT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ODTchars').text('You have reached the limit');
            $('#ODTchars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ODTchars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ODTchars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT1() {
    if (document.getElementById('yesCheckODT1').checked) {
        document.getElementById('ifYesODT1').style.display = 'none';
    }
    else document.getElementById('ifYesODT1').style.display = 'block';

}
</script>

<p>
<label for="OD2">Q<?php $i++; echo $i; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
<input type="radio" name="OD2" <?php if (isset($RL_OD2) && $RL_OD2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT2();" value="1" id="yesCheckODT2">Yes
<input type="radio" name="OD2" <?php if (isset($RL_OD2) && $RL_OD2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT2();" value="0" id="noCheckODT2">No
</p>

<div id="ifYesODT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ODT2" name="ODT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ODT2)) { echo $RL_CM_ODT2; } ?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft2').text('400 characters left');
    $('#ODT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft2').text('You have reached the limit');
            $('#characterLeft2').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft2').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft2').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT2() {
    if (document.getElementById('yesCheckODT2').checked) {
        document.getElementById('ifYesODT2').style.display = 'none';
    }
    else document.getElementById('ifYesODT2').style.display = 'block';

}

</script>

<p>
<label for="OD3">Q<?php $i++; echo $i; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
<input type="radio" name="OD3" <?php if (isset($RL_OD3) && $RL_OD3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT3();" value="1" id="yesCheckODT3">Yes
<input type="radio" name="OD3" <?php if (isset($RL_OD3) && $RL_OD3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT3();" value="0" id="noCheckODT3">No
</p>

<div id="ifYesODT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ODT3" name="ODT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ODT3)) { echo $RL_CM_ODT3; } ?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft3').text('400 characters left');
    $('#ODT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft3').text('You have reached the limit');
            $('#characterLeft3').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft3').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft3').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT3() {
    if (document.getElementById('yesCheckODT3').checked) {
        document.getElementById('ifYesODT3').style.display = 'none';
    }
    else document.getElementById('ifYesODT3').style.display = 'block';

}

</script>

<p>
<label for="OD4">Q<?php $i++; echo $i; ?>. Did the closer provide the name and details of the firm who is regulated by the FCA?</label>
<input type="radio" name="OD4" 
<?php if (isset($RL_OD4) && $RL_OD4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT4();"
value="1" id="yesCheckODT4">Yes
<input type="radio" name="OD4"
<?php if (isset($RL_OD4) && $RL_OD4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT4();"
value="0" id="noCheckODT4">No
</p>

<div id="ifYesODT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ODT4" name="ODT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ODT4)) { echo $RL_CM_ODT4; } ?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft4').text('400 characters left');
    $('#ODT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft4').text('You have reached the limit');
            $('#characterLeft4').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft4').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft4').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT4() {
    if (document.getElementById('yesCheckODT4').checked) {
        document.getElementById('ifYesODT4').style.display = 'none';
    }
    else document.getElementById('ifYesODT4').style.display = 'block';

}

</script>

<p>
<label for="OD5">Q<?php $i++; echo $i; ?>. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
<input type="radio" name="OD5" 
<?php if (isset($RL_OD5) && $RL_OD5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT5();"
value="1" id="yesCheckODT5">Yes
<input type="radio" name="OD5"
<?php if (isset($RL_OD5) && $RL_OD5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckODT5();"
value="0" id="noCheckODT5">No
</p>

<div id="ifYesODT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ODT5" name="ODT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ODT5)) { echo $RL_CM_ODT5; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft5').text('400 characters left');
    $('#ODT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft5').text('You have reached the limit');
            $('#characterLeft5').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft5').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft5').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckODT5() {
    if (document.getElementById('yesCheckODT5').checked) {
        document.getElementById('ifYesODT5').style.display = 'none';
    }
    else document.getElementById('ifYesODT5').style.display = 'block';

}

</script>
</div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
    </div>
    <div class="panel-body">

<p>
<label for="CI1">Q<?php $i++; echo $i; ?>. Was the clients gender accurately recorded?</label>
<input type="radio" name="CI1" <?php if (isset($RL_CI1) && $RL_CI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT1();" value="1" id="yesCheckCIT1">Yes
<input type="radio" name="CI1" <?php if (isset($RL_CI1) && $RL_CI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT1();" value="0" id="noCheckCIT1">No
</p>

<div id="ifYesCIT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT1" name="CIT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT1)) { echo $RL_CM_CIT1; } ?></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft7').text('400 characters left');
    $('#CIT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft7').text('You have reached the limit');
            $('#characterLeft7').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft7').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft7').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT1() {
    if (document.getElementById('yesCheckCIT1').checked) {
        document.getElementById('ifYesCIT1').style.display = 'none';
    }
    else document.getElementById('ifYesCIT1').style.display = 'block';

}

</script>

<p>
<label for="CI2">Q<?php $i++; echo $i; ?>. Was the clients date of birth accurately recorded?</label>
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();" <?php if (isset($RL_CI2) && $RL_CI2=="1") { echo "checked"; } ?> value="1" id="yesCheck">Yes 
<input type="radio" name="CI2" onclick="javascript:yesnoCheck();" <?php if (isset($RL_CI2) && $RL_CI2=="0") { echo "checked"; } ?> value="0" id="noCheck">No
</p>
<div id="ifYes" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT2" name="CIT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT2)) { echo $RL_CM_CIT2; } ?></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft8').text('400 characters left');
    $('#CIT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft8').text('You have reached the limit');
            $('#characterLeft8').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft8').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft8').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';

}

</script>

<p>
<label for="CI3">Q<?php $i++; echo $i; ?>. Was the clients smoking status recorded correctly?</label>
<input type="radio" name="CI3" 
<?php if (isset($RL_CI3) && $RL_CI3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT3();" value="1" id="yesCheckCIT3">Yes <input type="radio" name="CI3"
<?php if (isset($RL_CI3) && $RL_CI3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT3();" value="0" id="noCheckCIT3">No
</p>

<div id="ifYesCIT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT3" name="CIT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT3)) { echo $RL_CM_CIT3; } ?></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft9').text('400 characters left');
    $('#CIT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft9').text('You have reached the limit');
            $('#characterLeft9').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft9').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft9').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT3() {
    if (document.getElementById('yesCheckCIT3').checked) {
        document.getElementById('ifYesCIT3').style.display = 'none';
    }
    else document.getElementById('ifYesCIT3').style.display = 'block';

}

</script>

<p>
<label for="CI4">Q<?php $i++; echo $i; ?>. Was the clients employment status recorded correctly?</label>
<input type="radio" name="CI4" <?php if (isset($RL_CI4) && $RL_CI4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT4();" value="1" id="yesCheckCIT4">Yes
<input type="radio" name="CI4" <?php if (isset($RL_CI4) && $RL_CI4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT4();" value="0" id="noCheckCIT4">No
</p>

<div id="ifYesCIT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT4" name="CIT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT4)) { echo $RL_CM_CIT4; } ?></textarea><span class="help-block"><p id="characterLeft10" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft10').text('400 characters left');
    $('#CIT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft10').text('You have reached the limit');
            $('#characterLeft10').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft10').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft10').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT4() {
    if (document.getElementById('yesCheckCIT4').checked) {
        document.getElementById('ifYesCIT4').style.display = 'none';
    }
    else document.getElementById('ifYesCIT4').style.display = 'block';

}

</script>

<p>
<label for="CI5">Q<?php $i++; echo $i; ?>. Did the closer confirm the policy was a single or a joint application?</label>
<input type="radio" name="CI5" <?php if (isset($RL_CI5) && $RL_CI5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT5();" value="1" id="yesCheckCIT5">Yes
<input type="radio" name="CI5" <?php if (isset($RL_CI5) && $RL_CI5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT5();" value="0" id="noCheckCIT5">No
</p>

<div id="ifYesCIT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT5" name="CIT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT5)) { echo $RL_CM_CIT5; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft11').text('400 characters left');
    $('#CIT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft11').text('You have reached the limit');
            $('#characterLeft11').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft11').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft11').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT5() {
    if (document.getElementById('yesCheckCIT5').checked) {
        document.getElementById('ifYesCIT5').style.display = 'none';
    }
    else document.getElementById('ifYesCIT5').style.display = 'block';

}

</script>

<p>
<label for="CI6">Q<?php $i++; echo $i; ?>. Was the clients country of residence recorded correctly?</label>
<input type="radio" name="CI6" <?php if (isset($RL_CI6) && $RL_CI6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT6();" value="1" id="yesCheckCIT6">Yes
<input type="radio" name="CI6" <?php if (isset($RL_CI6) && $RL_CI6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT6();" value="0" id="noCheckCIT6">No
</p>

<div id="ifYesCIT6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT6" name="CIT6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT6)) { echo $RL_CM_CIT6; } ?></textarea><span class="help-block"><p id="characterLeft112" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft112').text('400 characters left');
    $('#CIT6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft112').text('You have reached the limit');
            $('#characterLeft112').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft112').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft112').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT6() {
    if (document.getElementById('yesCheckCIT6').checked) {
        document.getElementById('ifYesCIT6').style.display = 'none';
    }
    else document.getElementById('ifYesCIT6').style.display = 'block';

}

</script>

<p>
<label for="CI7">Q<?php $i++; echo $i; ?>. Was the clients occupation recorded correctly?</label>
<input type="radio" name="CI7" <?php if (isset($RL_CI7) && $RL_CI7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT7();" value="1" id="yesCheckCIT7">Yes
<input type="radio" name="CI7" <?php if (isset($RL_CI7) && $RL_CI7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT7();" value="0" id="noCheckCIT7">No
</p>

<div id="ifYesCIT7" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT7" name="CIT7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT7)) { echo $RL_CM_CIT7; } ?></textarea><span class="help-block"><p id="characterLeft113" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft113').text('400 characters left');
    $('#CIT7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft113').text('You have reached the limit');
            $('#characterLeft113').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft113').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft113').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT7() {
    if (document.getElementById('yesCheckCIT7').checked) {
        document.getElementById('ifYesCIT7').style.display = 'none';
    }
    else document.getElementById('ifYesCIT7').style.display = 'block';

}

</script>

<p>
<label for="CI8">Q<?php $i++; echo $i; ?>. Was the clients salary recorded correctly?</label>
<input type="radio" name="CI8" <?php if (isset($RL_CI8) && $RL_CI8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT8();" value="1" id="yesCheckCIT8">Yes
<input type="radio" name="CI8" <?php if (isset($RL_CI8) && $RL_CI8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCIT8();" value="0" id="noCheckCIT8">No
</p>

<div id="ifYesCIT8" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CIT8" name="CIT8" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CIT8)) { echo $RL_CM_CIT8; } ?></textarea><span class="help-block"><p id="characterLeft114" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft114').text('400 characters left');
    $('#CIT8').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft114').text('You have reached the limit');
            $('#characterLeft114').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft114').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft114').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCIT8() {
    if (document.getElementById('yesCheckCIT8').checked) {
        document.getElementById('ifYesCIT8').style.display = 'none';
    }
    else document.getElementById('ifYesCIT8').style.display = 'block';

}

</script>

</div>
</div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Identifying Clients Needs</h3>
    </div>
    <div class="panel-body">
<p>
<label for="IC1">Q<?php $i++; echo $i; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label>
<input type="radio" name="IC1" <?php if (isset($RL_IC1) && $RL_IC1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT1();" value="1" id="yesCheckICT1">Yes
<input type="radio" name="IC1" <?php if (isset($RL_IC1) && $RL_IC1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT1();" value="0" id="noCheckICT1">No
</p>

<div id="ifYesICT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ICT1" name="ICT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ICT1)) { echo $RL_CM_ICT1; } ?></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft12').text('400 characters left');
    $('#ICT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft12').text('You have reached the limit');
            $('#characterLeft12').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft12').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft12').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT1() {
    if (document.getElementById('yesCheckICT1').checked) {
        document.getElementById('ifYesICT1').style.display = 'none';
    }
    else document.getElementById('ifYesICT1').style.display = 'block';

}

</script>

<p>
<label for="IC2">Q<?php $i++; echo $i; ?>. Did the closer mention waiver, indexation, or TPD?</label>
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT2();" value="1" id="yesCheckICT2">Yes
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT2();" value="0" id="noCheckICT2">No
<input type="radio" name="IC2" <?php if (isset($RL_IC2) && $RL_IC2=="3") { echo "checked"; } ?> value="3" >N/A
</p>

<div id="ifYesICT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ICT2" name="ICT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ICT2)) { echo $RL_CM_ICT2; } ?></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft13').text('400 characters left');
    $('#ICT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft13').text('You have reached the limit');
            $('#characterLeft13').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft13').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft13').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT2() {
    if (document.getElementById('yesCheckICT2').checked) {
        document.getElementById('ifYesICT2').style.display = 'none';
    }
    else document.getElementById('ifYesICT2').style.display = 'block';

}

</script>

<p>
<label for="IC3">Q<?php $i++; echo $i; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
<input type="radio" name="IC3" <?php if (isset($RL_IC3) && $RL_IC3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT3();" value="1" id="yesCheckICT3">Yes
<input type="radio" name="IC3" <?php if (isset($RL_IC3) && $RL_IC3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT3();" value="0" id="noCheckICT3">No
</p>

<div id="ifYesICT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ICT3" name="ICT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ICT3)) { echo $RL_CM_ICT3; } ?></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft14').text('400 characters left');
    $('#ICT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft14').text('You have reached the limit');
            $('#characterLeft14').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft14').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft14').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT3() {
    if (document.getElementById('yesCheckICT3').checked) {
        document.getElementById('ifYesICT3').style.display = 'none';
    }
    else document.getElementById('ifYesICT3').style.display = 'block';

}

</script>

<p>
<label for="IC4">Q<?php $i++; echo $i; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label>
<select class="form-control" name="IC4" onclick="javascript:yesnoCheckICT4();">
  <option value="0" <?php if(isset($RL_IC4)) { if($RL_IC4=='0') { echo "selected"; } } ?>>Select...</option>
  <option value="1" <?php if(isset($RL_IC4)) { if($RL_IC4=='1') { echo "selected"; } } ?>>More than sufficient</option>
  <option value="2" <?php if(isset($RL_IC4)) { if($RL_IC4=='2') { echo "selected"; } } ?>>Sufficient</option>
  <option value="3" <?php if(isset($RL_IC4)) { if($RL_IC4=='3') { echo "selected"; } } ?>>Adequate</option>
  <option value="4" <?php if(isset($RL_IC4)) { if($RL_IC4=='4') { echo "selected"; } } ?> onclick="javascript:yesnoCheckICT4a();" id="yesCheckICT4">Poor</option>
</select>
</p>
<div id="ifYesICT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ICT4" name="ICT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ICT4)) { echo $RL_CM_ICT4; } ?></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft15').text('400 characters left');
    $('#ICT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft15').text('You have reached the limit');
            $('#characterLeft15').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft15').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft15').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckICT4() {
    if (document.getElementById('yesCheckICT4').checked) {
        document.getElementById('ifYesICT4').style.display = 'none';
    }
    else document.getElementById('ifYesICT4').style.display = 'block';

}

</script>
<script type="text/javascript">

function yesnoCheckICT4a() {
    if (document.getElementById('yesCheckICT4').checked) {
        document.getElementById('ifYesICT4').style.display = 'none';
    }
    else document.getElementById('ifYesICT4').style.display = 'block';

}

</script>

<p>
<label for="IC5">Q<?php $i++; echo $i; ?>. Closer confirmed this policy will be set up with Royal London?</label>
<input type="radio" name="IC5" <?php if (isset($RL_IC5) && $RL_IC5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT5();" value="1" id="yesCheckICT5">Yes
<input type="radio" name="IC5" <?php if (isset($RL_IC5) && $RL_IC5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckICT5();" value="0" id="noCheckICT5">No
</p>

<div id="ifYesICT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ICT5" name="ICT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_ICT5)) { echo $RL_CM_ICT5; } ?></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft16').text('400 characters left');
    $('#ICT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft16').text('You have reached the limit');
            $('#characterLeft16').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft16').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft16').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">
function yesnoCheckICT5() {
    if (document.getElementById('yesCheckICT5').checked) {
        document.getElementById('ifYesICT5').style.display = 'none';
    }
    else document.getElementById('ifYesICT5').style.display = 'block';

}
</script>
</div>
</div>    
    
 <div class="panel panel-info">
     <div class="panel-heading">
         <h3 class="panel-title">Contact Details</h3>
     </div>
     <div class="panel-body">

<p>
<label for="CD1">Q<?php $i++; echo $i; ?>. Were all clients titles and names recorded correctly?</label>
<input type="radio" name="CD1" <?php if (isset($RL_CD1) && $RL_CD1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT1();" value="1" id="yesCheckCDT1">Yes
<input type="radio" name="CD1" <?php if (isset($RL_CD1) && $RL_CD1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT1();" value="0" id="noCheckCDT1">No
</p>

<div id="ifYesCDT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDT1" name="CDT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CDT1)) { echo $RL_CM_CDT1; } ?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft6').text('400 characters left');
    $('#CDT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT1() {
    if (document.getElementById('yesCheckCDT1').checked) {
        document.getElementById('ifYesCDT1').style.display = 'none';
    }
    else document.getElementById('ifYesCDT1').style.display = 'block';

}

</script>

<p>
<label for="CD2">Q<?php $i++; echo $i; ?>. Was the clients marital status recorded correctly?</label>
<input type="radio" name="CD2" <?php if (isset($RL_CD2) && $RL_CD2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT2();" value="1" id="yesCheckCDT2">Yes
<input type="radio" name="CD2" <?php if (isset($RL_CD2) && $RL_CD2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT2();" value="0" id="noCheckCDT2">No
</p>

<div id="ifYesCDT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDT2" name="CDT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CDT2)) { echo $RL_CM_CDT2; } ?></textarea><span class="help-block"><p id="CDT2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#CDT2chars').text('400 characters left');
    $('#CDT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#CDT2chars').text('You have reached the limit');
            $('#CDT2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#CDT2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#CDT2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT2() {
    if (document.getElementById('yesCheckCDT2').checked) {
        document.getElementById('ifYesCDT2').style.display = 'none';
    }
    else document.getElementById('ifYesCDT2').style.display = 'block';

}
</script>  

<p>
<label for="CD3">Q<?php $i++; echo $i; ?>. Was the clients address recored correctly?</label>
<input type="radio" name="CD3" <?php if (isset($RL_CD3) && $RL_CD3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT3();" value="1" id="yesCheckCDT3">Yes
<input type="radio" name="CD3" <?php if (isset($RL_CD3) && $RL_CD3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT3();" value="0" id="noCheckCDT3">No
</p>

<div id="ifYesCDT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDT3" name="CDT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CDT3)) { echo $RL_CM_CDT3; } ?></textarea><span class="help-block"><p id="CDT3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#CDT3chars').text('400 characters left');
    $('#CDT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#CDT3chars').text('You have reached the limit');
            $('#CDT3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#CDT3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#CDT3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT3() {
    if (document.getElementById('yesCheckCDT3').checked) {
        document.getElementById('ifYesCDT3').style.display = 'none';
    }
    else document.getElementById('ifYesCDT3').style.display = 'block';

}
</script>  

<p>
<label for="CD4">Q<?php $i++; echo $i; ?>. Was clients phone number(s) recorded correctly?</label>
<input type="radio" name="CD4" <?php if(isset($RL_CD4) && $RL_CD4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT4();" value="1" id="yesCheckCDT4">Yes
<input type="radio" name="CD4" <?php if(isset($RL_CD4) && $RL_CD4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT4();" value="0" id="noCheckCDT4">No
</p>

<div id="ifYesCDT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDT4" name="CDT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CDT4)) { echo $RL_CM_CDT4; } ?></textarea><span class="help-block"><p id="CDT4chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#CDT4chars').text('400 characters left');
    $('#CDT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#CDT4chars').text('You have reached the limit');
            $('#CDT4chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#CDT4chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#CDT4chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT4() {
    if (document.getElementById('yesCheckCDT4').checked) {
        document.getElementById('ifYesCDT4').style.display = 'none';
    }
    else document.getElementById('ifYesCDT4').style.display = 'block';

}
</script>

<p>
<label for="CD5">Q<?php $i++; echo $i; ?>. Was the clients email address recorded correctly?</label>
<input type="radio" name="CD5" <?php if(isset($RL_CD5) && $RL_CD5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT5();" value="1" id="yesCheckCDT5">Yes
<input type="radio" name="CD5" <?php if(isset($RL_CD5) && $RL_CD5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDT5();" value="0" id="noCheckCDT5">No
</p>

<div id="ifYesCDT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDT5" name="CDT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_CDT5)) { echo $RL_CM_CDT5; } ?></textarea><span class="help-block"><p id="CDT5chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#CDT5chars').text('400 characters left');
    $('#CDT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#CDT5chars').text('You have reached the limit');
            $('#CDT5chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#CDT5chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#CDT5chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDT5() {
    if (document.getElementById('yesCheckCDT5').checked) {
        document.getElementById('ifYesCDT5').style.display = 'none';
    }
    else document.getElementById('ifYesCDT5').style.display = 'block';

}
</script>
         
     </div>
 </div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Declarations of Insurance</h3>
    </div>
    <div class="panel-body">

<p>
<label for="DO1">Q<?php $i++; echo $i; ?>. Confirmed that we comply with the Data Protection Act, and are happy for their personal to be passed over the phone?</label>
<input type="radio" name="DO1" <?php if (isset($RL_DO1) && $RL_DO1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT1();" value="1" id="yesCheckDOT1">Yes
<input type="radio" name="DO1" <?php if (isset($RL_DO1) && $RL_DO1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT1();" value="0" id="noCheckDOT1">No
</p>
<div id="ifYesDOT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT1" name="DOT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT1)) { echo $RL_CM_DOT1; } ?></textarea><span class="help-block"><p id="DOT1chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT1chars').text('400 characters left');
    $('#DOT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT1chars').text('You have reached the limit');
            $('#DOT1chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT1chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT1chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT1() {
    if (document.getElementById('yesCheckDOT1').checked) {
        document.getElementById('ifYesDOT1').style.display = 'none';
    }
    else document.getElementById('ifYesDOT1').style.display = 'block';

}

</script>        
           
<p>
<label for="DO2">Q<?php $i++; echo $i; ?>. The impact of misrepresentation declaration read out?</label>
<input type="radio" name="DO2" <?php if (isset($RL_DO2) && $RL_DO2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT2();" value="1" id="yesCheckDOT2">Yes
<input type="radio" name="DO2" <?php if (isset($RL_DO2) && $RL_DO2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT2();" value="0" id="noCheckDOT2">No
</p>

<div id="ifYesDOT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT2" name="DOT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT2)) { echo $RL_CM_DOT2; } ?></textarea><span class="help-block"><p id="DOT2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT2chars').text('400 characters left');
    $('#DOT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT2chars').text('You have reached the limit');
            $('#DOT2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT2() {
    if (document.getElementById('yesCheckDOT2').checked) {
        document.getElementById('ifYesDOT2').style.display = 'none';
    }
    else document.getElementById('ifYesDOT2').style.display = 'block';

}

</script>

<p>
<label for="DO3">Q<?php $i++; echo $i; ?>. If appropriate did the closer confirm the exclusions on the policy?</label>
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT3();" value="1" id="yesCheckDOT3">Yes
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT3();" value="0" id="noCheckDOT3">No
<input type="radio" name="DO3" <?php if (isset($RL_DO3) && $RL_DO3=="3") { echo "checked"; } ?> value="3" >N/A
</p>

<div id="ifYesDOT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT3" name="DOT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT3)) { echo $RL_CM_DOT3; } ?></textarea><span class="help-block"><p id="DOT3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT3chars').text('400 characters left');
    $('#DOT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT3chars').text('You have reached the limit');
            $('#DOT3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT3() {
    if (document.getElementById('yesCheckDOT3').checked) {
        document.getElementById('ifYesDOT3').style.display = 'none';
    }
    else document.getElementById('ifYesDOT3').style.display = 'block';

}

</script>

<p>
<label for="DO4">Q<?php $i++; echo $i; ?>. Client informed that Royal London may request a copy of their medical reports up to six months after the cover has started?</label>
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT4();" value="1" id="yesCheckDOT4">Yes
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT4();" value="0" id="noCheckDOT4">No
<input type="radio" name="DO4" <?php if (isset($RL_DO4) && $RL_DO4=="2") { echo "checked"; } ?> value="2" >N/A
</p>

<div id="ifYesDOT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT4" name="DOT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT4)) { echo $RL_CM_DOT4; } ?></textarea><span class="help-block"><p id="DOT4chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT4chars').text('400 characters left');
    $('#DOT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT4chars').text('You have reached the limit');
            $('#DOT4chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT4chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT4chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT4() {
    if (document.getElementById('yesCheckDOT4').checked) {
        document.getElementById('ifYesDOT4').style.display = 'none';
    }
    else document.getElementById('ifYesDOT4').style.display = 'block';

}
</script>

<p>
<label for="DO5">Q<?php $i++; echo $i; ?>. Did the closer ask the client to read out the Access to Medical Reports Act 1988 (or to send a copy)?</label>
<input type="radio" name="DO5" <?php if (isset($RL_DO5) && $RL_DO5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT5();" value="1" id="yesCheckDOT5">Yes
<input type="radio" name="DO5" <?php if (isset($RL_DO5) && $RL_DO5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT5();" value="0" id="noCheckDOT5">No
</p>

<div id="ifYesDOT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT5" name="DOT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT5)) { echo $RL_CM_DOT5; } ?></textarea><span class="help-block"><p id="DOT5chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT5chars').text('400 characters left');
    $('#DOT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT5chars').text('You have reached the limit');
            $('#DOT5chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT5chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT5chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT5() {
    if (document.getElementById('yesCheckDOT5').checked) {
        document.getElementById('ifYesDOT5').style.display = 'none';
    }
    else document.getElementById('ifYesDOT5').style.display = 'block';

}
</script>

<p>
<label for="DO6">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had any existing plans or an application with Royal London?</label>
<input type="radio" name="DO6" <?php if (isset($RL_DO6) && $RL_DO6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT6();" value="1" id="yesCheckDOT6">Yes
<input type="radio" name="DO6" <?php if (isset($RL_DO6) && $RL_DO6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT6();" value="0" id="noCheckDOT6">No
</p>

<div id="ifYesDOT6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT6" name="DOT6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT6)) { echo $RL_CM_DOT6; } ?></textarea><span class="help-block"><p id="DOT6chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT6chars').text('400 characters left');
    $('#DOT6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT6chars').text('You have reached the limit');
            $('#DOT6chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT6chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT6chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT6() {
    if (document.getElementById('yesCheckDOT6').checked) {
        document.getElementById('ifYesDOT6').style.display = 'none';
    }
    else document.getElementById('ifYesDOT6').style.display = 'block';

}
</script>

<p>
<label for="DO7">Q<?php $i++; echo $i; ?>. Did the closer ask the client if they had an application on your life deferred or declined?</label>
<input type="radio" name="DO7" <?php if (isset($RL_DO7) && $RL_DO7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT7();" value="1" id="yesCheckDOT7">Yes
<input type="radio" name="DO7" <?php if (isset($RL_DO7) && $RL_DO7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT7();" value="0" id="noCheckDOT7">No
</p>

<div id="ifYesDOT7" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT7" name="DOT7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT7)) { echo $RL_CM_DOT7; } ?></textarea><span class="help-block"><p id="DOT7chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT7chars').text('400 characters left');
    $('#DOT7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT7chars').text('You have reached the limit');
            $('#DOT7chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT7chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT7chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT7() {
    if (document.getElementById('yesCheckDOT7').checked) {
        document.getElementById('ifYesDOT7').style.display = 'none';
    }
    else document.getElementById('ifYesDOT7').style.display = 'block';

}
</script>

<p>
<label for="DO8">Q<?php $i++; echo $i; ?>. Did the closer ask the client if the total amount of cover that they have applied for, added to the amount that they already have, across all insurance companies exceed £1,000,000 life cover or £400,000 CIC?</label>
<input type="radio" name="DO8" <?php if (isset($RL_DO8) && $RL_DO8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT8();" value="1" id="yesCheckDOT8">Yes
<input type="radio" name="DO8" <?php if (isset($RL_DO8) && $RL_DO8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckDOT8();" value="0" id="noCheckDOT8">No
</p>

<div id="ifYesDOT8" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="DOT8" name="DOT8" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_DOT8)) { echo $RL_CM_DOT8; } ?></textarea><span class="help-block"><p id="DOT8chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#DOT8chars').text('400 characters left');
    $('#DOT8').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#DOT8chars').text('You have reached the limit');
            $('#DOT8chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#DOT8chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#DOT8chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckDOT8() {
    if (document.getElementById('yesCheckDOT8').checked) {
        document.getElementById('ifYesDOT8').style.display = 'none';
    }
    else document.getElementById('ifYesDOT8').style.display = 'block';

}
</script>

</div>
</div>    
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Life Style</h3>
    </div>
    <div class="panel-body">
        
<p>
<label for="LS1">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the height and weight details correctly?</label>
<input type="radio" name="LS1" <?php if (isset($RL_LS1) && $RL_LS1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST1();" value="1" id="yesCheckLST1">Yes
<input type="radio" name="LS1" <?php if (isset($RL_LS1) && $RL_LS1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST1();" value="0" id="noCheckLST1">No
</p>

<div id="ifYesLST1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST1" name="LST1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST1)) { echo $RL_CM_LST1; } ?></textarea><span class="help-block"><p id="LST1chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST1chars').text('400 characters left');
    $('#LST1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST1chars').text('You have reached the limit');
            $('#LST1chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST1chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST1chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST1() {
    if (document.getElementById('yesCheckLST1').checked) {
        document.getElementById('ifYesLST1').style.display = 'none';
    }
    else document.getElementById('ifYesLST1').style.display = 'block';

}

</script>

<p>
<label for="LS2">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the clients clothe measurements?</label>
<input type="radio" name="LS2" <?php if (isset($RL_LS2) && $RL_LS2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST2();" value="1" id="yesCheckLST2">Yes
<input type="radio" name="LS2" <?php if (isset($RL_LS2) && $RL_LS2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST2();" value="0" id="noCheckLST2">No
</p>

<div id="ifYesLST2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST2" name="LST2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST2)) { echo $RL_CM_LST2; } ?></textarea><span class="help-block"><p id="LST2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST2chars').text('400 characters left');
    $('#LST2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST2chars').text('You have reached the limit');
            $('#LST2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST2() {
    if (document.getElementById('yesCheckLST2').checked) {
        document.getElementById('ifYesLST2').style.display = 'none';
    }
    else document.getElementById('ifYesLST2').style.display = 'block';

}

</script>

<p>
<label for="LS3">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the smoking details correctly?</label>
<input type="radio" name="LS3" <?php if (isset($RL_LS3) && $RL_LS3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST3();" value="1" id="yesCheckLST3">Yes
<input type="radio" name="LS3" <?php if (isset($RL_LS3) && $RL_LS3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST3();" value="0" id="noCheckLST3">No
</p>

<div id="ifYesLST3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST3" name="LST3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST3)) { echo $RL_CM_LST3; } ?></textarea><span class="help-block"><p id="LST3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST3chars').text('400 characters left');
    $('#LST3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST3chars').text('You have reached the limit');
            $('#LST3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST3() {
    if (document.getElementById('yesCheckLST3').checked) {
        document.getElementById('ifYesLST3').style.display = 'none';
    }
    else document.getElementById('ifYesLST3').style.display = 'block';

}

</script>

<p>
<label for="LS4">Q<?php $i++; echo $i; ?>. Was the client asked how many units of alcohol they drink in a week?</label>
<input type="radio" name="LS4" <?php if (isset($RL_LS4) && $RL_LS4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST4();" value="1" id="yesCheckLST4">Yes
<input type="radio" name="LS4" <?php if (isset($RL_LS4) && $RL_LS4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST4();" value="0" id="noCheckLST4">No
</p>

<div id="ifYesLST4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST4" name="LST4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST4)) { echo $RL_CM_LST4; } ?></textarea><span class="help-block"><p id="LST4chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST4chars').text('400 characters left');
    $('#LST4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST4chars').text('You have reached the limit');
            $('#LST4chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST4chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST4chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST4() {
    if (document.getElementById('yesCheckLST4').checked) {
        document.getElementById('ifYesLST4').style.display = 'none';
    }
    else document.getElementById('ifYesLST4').style.display = 'block';

}

</script>

<p>
<label for="LS5">Q<?php $i++; echo $i; ?>. Did the closer ask if they have been disqualified from driving in the last 5 years?</label>
<input type="radio" name="LS5" <?php if (isset($RL_LS5) && $RL_LS5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST5();" value="1" id="yesCheckLST5">Yes
<input type="radio" name="LS5" <?php if (isset($RL_LS5) && $RL_LS5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST5();" value="0" id="noCheckLST5">No
</p>

<div id="ifYesLST5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST5" name="LST5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST5)) { echo $RL_CM_LST5; } ?></textarea><span class="help-block"><p id="LST5chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST5chars').text('400 characters left');
    $('#LST5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST5chars').text('You have reached the limit');
            $('#LST5chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST5chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST5chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST5() {
    if (document.getElementById('yesCheckLST5').checked) {
        document.getElementById('ifYesLST5').style.display = 'none';
    }
    else document.getElementById('ifYesLST5').style.display = 'block';

}

</script>

<p>
<label for="LS6">Q<?php $i++; echo $i; ?>. Did the closer ask if the client has used recreational drugs in the last 10 years?</label>
<input type="radio" name="LS6" <?php if (isset($RL_LS6) && $RL_LS6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST6();" value="1" id="yesCheckLST6">Yes
<input type="radio" name="LS6" <?php if (isset($RL_LS6) && $RL_LS6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST6();" value="0" id="noCheckLST6">No
</p>

<div id="ifYesLST6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST6" name="LST6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST6)) { echo $RL_CM_LST6; } ?></textarea><span class="help-block"><p id="LST6chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST6chars').text('400 characters left');
    $('#LST6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST6chars').text('You have reached the limit');
            $('#LST6chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST6chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST6chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST6() {
    if (document.getElementById('yesCheckLST6').checked) {
        document.getElementById('ifYesLST6').style.display = 'none';
    }
    else document.getElementById('ifYesLST6').style.display = 'block';

}

</script>

<p>
<label for="LS7">Q<?php $i++; echo $i; ?>. Did the closer check if the client had undertaken any of the listed activities?</label>
<input type="radio" name="LS7" <?php if (isset($RL_LS7) && $RL_LS7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST7();" value="1" id="yesCheckLST7">Yes
<input type="radio" name="LS7" <?php if (isset($RL_LS7) && $RL_LS7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckLST7();" value="0" id="noCheckLST7">No
</p>

<div id="ifYesLST7" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="LST7" name="LST7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CM_LST7)) { echo $RL_CM_LST7; } ?></textarea><span class="help-block"><p id="LST7chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#LST7chars').text('400 characters left');
    $('#LST7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#LST7chars').text('You have reached the limit');
            $('#LST7chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#LST7chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#LST7chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckLST7() {
    if (document.getElementById('yesCheckLST7').checked) {
        document.getElementById('ifYesLST7').style.display = 'none';
    }
    else document.getElementById('ifYesLST7').style.display = 'block';

}

</script>

    </div>    
</div> 
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Occupation and Travel</h3>
    </div>
    <div class="panel-body">

<p>
<label for="OT1">Q<?php $i++; echo $i; ?>. Was the client asked if their job involves manual work or driving?</label>
<input type="radio" name="OT1" <?php if (isset($RL_OT1) && $RL_OT1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT1();" value="1" id="yesCheckOTT1">Yes
<input type="radio" name="OT1" <?php if (isset($RL_OT1) && $RL_OT1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT1();" value="0" id="noCheckOTT1">No
</p>

<div id="ifYesOTT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="OTT1" name="OTT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_OTT1)) { echo $RL_CEM_OTT1; } ?></textarea><span class="help-block"><p id="OTT1chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#OTT1chars').text('400 characters left');
    $('#OTT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#OTT1chars').text('You have reached the limit');
            $('#OTT1chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#OTT1chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#OTT1chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT1() {
    if (document.getElementById('yesCheckOTT1').checked) {
        document.getElementById('ifYesOTT1').style.display = 'none';
    }
    else document.getElementById('ifYesOTT1').style.display = 'block';

}

</script>  

<p>
<label for="OT2">Q<?php $i++; echo $i; ?>. Was the client asked if they undertake in any of the listed hazardous activities?</label>
<input type="radio" name="OT2" <?php if (isset($RL_OT2) && $RL_OT2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT2();" value="1" id="yesCheckOTT2">Yes
<input type="radio" name="OT2" <?php if (isset($RL_OT2) && $RL_OT2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT2();" value="0" id="noCheckOTT2">No
</p>

<div id="ifYesOTT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="OTT2" name="OTT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_OTT2)) { echo $RL_CEM_OTT2; } ?></textarea><span class="help-block"><p id="OTT2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#OTT2chars').text('400 characters left');
    $('#OTT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#OTT2chars').text('You have reached the limit');
            $('#OTT2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#OTT2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#OTT2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT2() {
    if (document.getElementById('yesCheckOTT2').checked) {
        document.getElementById('ifYesOTT2').style.display = 'none';
    }
    else document.getElementById('ifYesOTT2').style.display = 'block';

}

</script>

<p>
<label for="OT3">Q<?php $i++; echo $i; ?>. Was the client asked if they have worked/travelled out the listed countries (in the last 2 years, or do they intend to)?</label>
<input type="radio" name="OT3" <?php if (isset($RL_OT3) && $RL_OT3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT3();" value="1" id="yesCheckOTT3">Yes
<input type="radio" name="OT3" <?php if (isset($RL_OT3) && $RL_OT3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckOTT3();" value="0" id="noCheckOTT3">No
</p>

<div id="ifYesOTT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="OTT3" name="OTT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_OTT3)) { echo $RL_CEM_OTT3; } ?></textarea><span class="help-block"><p id="OTT3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#OTT3chars').text('400 characters left');
    $('#OTT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#OTT3chars').text('You have reached the limit');
            $('#OTT3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#OTT3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#OTT3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckOTT3() {
    if (document.getElementById('yesCheckOTT3').checked) {
        document.getElementById('ifYesOTT3').style.display = 'none';
    }
    else document.getElementById('ifYesOTT3').style.display = 'block';

}

</script>
        
    </div>
</div>        
   
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Health Questions</h3>
        </div>
        <div class="panel-body">
           
<p>
<label for="HQ1">Q<?php $i++; echo $i; ?>. Was the client asked if they have ever had any health problems?</label>
<input type="radio" name="HQ1" <?php if (isset($RL_QE_HQ1) && $RL_QE_HQ1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT1();" value="1" id="yesCheckHQT1">Yes
<input type="radio" name="HQ1" <?php if (isset($RL_QE_HQ1) && $RL_QE_HQ1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT1();" value="0" id="noCheckHQT1">No
</p>

<div id="ifYesHQT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT1" name="HQT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT1)) { echo $RL_CEM_HQT1; } ?></textarea><span class="help-block"><p id="HQT1chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT1chars').text('400 characters left');
    $('#HQT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT1chars').text('You have reached the limit');
            $('#HQT1chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT1chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT1chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT1() {
    if (document.getElementById('yesCheckHQT1').checked) {
        document.getElementById('ifYesHQT1').style.display = 'none';
    }
    else document.getElementById('ifYesHQT1').style.display = 'block';

}

</script>

<p>
<label for="HQ2">Q<?php $i++; echo $i; ?>. Were all health in the last 5 years questions asked and recorded correctly?</label>
<input type="radio" name="HQ2" <?php if (isset($RL_QE_HQ2) && $RL_QE_HQ2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT2();" value="1" id="yesCheckHQT2">Yes
<input type="radio" name="HQ2" <?php if (isset($RL_QE_HQ2) && $RL_QE_HQ2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT2();" value="0" id="noCheckHQT2">No
</p>

<div id="ifYesHQT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT2" name="HQT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT2)) { echo $RL_CEM_HQT2; } ?></textarea><span class="help-block"><p id="HQT2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT2chars').text('400 characters left');
    $('#HQT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT2chars').text('You have reached the limit');
            $('#HQT2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT2() {
    if (document.getElementById('yesCheckHQT2').checked) {
        document.getElementById('ifYesHQT2').style.display = 'none';
    }
    else document.getElementById('ifYesHQT2').style.display = 'block';

}

</script>

<p>
<label for="HQ3">Q<?php $i++; echo $i; ?>. Were all health in the last 3 years questions asked and recorded correctly?</label>
<input type="radio" name="HQ3" <?php if (isset($RL_QE_HQ3) && $RL_QE_HQ3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT3();" value="1" id="yesCheckHQT3">Yes
<input type="radio" name="HQ3" <?php if (isset($RL_QE_HQ3) && $RL_QE_HQ3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT3();" value="0" id="noCheckHQT3">No
</p>

<div id="ifYesHQT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT3" name="HQT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT3)) { echo $RL_CEM_HQT3; } ?></textarea><span class="help-block"><p id="HQT3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT3chars').text('400 characters left');
    $('#HQT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT3chars').text('You have reached the limit');
            $('#HQT3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT3() {
    if (document.getElementById('yesCheckHQT3').checked) {
        document.getElementById('ifYesHQT3').style.display = 'none';
    }
    else document.getElementById('ifYesHQT3').style.display = 'block';

}

</script>

<p>
<label for="HQ4">Q<?php $i++; echo $i; ?>. Was the client asked if their family have any medical history?</label>
<input type="radio" name="HQ4" <?php if (isset($RL_QE_HQ4) && $RL_QE_HQ4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT4();" value="1" id="yesCheckHQT4">Yes
<input type="radio" name="HQ4" <?php if (isset($RL_QE_HQ4) && $RL_QE_HQ4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT4();" value="0" id="noCheckHQT4">No
</p>

<div id="ifYesHQT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT4" name="HQT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT4)) { echo $RL_CEM_HQT4; } ?></textarea><span class="help-block"><p id="HQT4chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT4chars').text('400 characters left');
    $('#HQT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT4chars').text('You have reached the limit');
            $('#HQT4chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT4chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT4chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT4() {
    if (document.getElementById('yesCheckHQT4').checked) {
        document.getElementById('ifYesHQT4').style.display = 'none';
    }
    else document.getElementById('ifYesHQT4').style.display = 'block';

}

</script>    

<p>
<label for="HQ5">Q<?php $i++; echo $i; ?>. If appropriate, did the closer confirm any exclusions on the policy?</label>
<input type="radio" name="HQ5" <?php if (isset($RL_QE_HQ5) && $RL_QE_HQ5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT5();" value="1" id="yesCheckHQT5">Yes
<input type="radio" name="HQ5" <?php if (isset($RL_QE_HQ5) && $RL_QE_HQ5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT5();" value="0" id="noCheckHQT5">No
</p>

<div id="ifYesHQT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT5" name="HQT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT5)) { echo $RL_CEM_HQT5; } ?></textarea><span class="help-block"><p id="HQT5chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT5chars').text('400 characters left');
    $('#HQT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT5chars').text('You have reached the limit');
            $('#HQT5chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT5chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT5chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT5() {
    if (document.getElementById('yesCheckHQT5').checked) {
        document.getElementById('ifYesHQT5').style.display = 'none';
    }
    else document.getElementById('ifYesHQT5').style.display = 'block';

}

</script>  

<p>
<label for="HQ6">Q<?php $i++; echo $i; ?>. Were all of the health questions recorded correctly?</label>
<input type="radio" name="HQ6" <?php if (isset($RL_QE_HQ6) && $RL_QE_HQ6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT6();" value="1" id="yesCheckHQT6">Yes
<input type="radio" name="HQ6" <?php if (isset($RL_QE_HQ6) && $RL_QE_HQ6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckHQT6();" value="0" id="noCheckHQT6">No
</p>

<div id="ifYesHQT6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="HQT6" name="HQT6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_HQT6)) { echo $RL_CEM_HQT6; } ?></textarea><span class="help-block"><p id="HQT6chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#HQT6chars').text('400 characters left');
    $('#HQT6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#HQT6chars').text('You have reached the limit');
            $('#HQT6chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#HQT6chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#HQT6chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckHQT6() {
    if (document.getElementById('yesCheckHQT6').checked) {
        document.getElementById('ifYesHQT6').style.display = 'none';
    }
    else document.getElementById('ifYesHQT6').style.display = 'block';

}

</script>  
            
        </div>
    </div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Eligibility</h3>
    </div>
    <div class="panel-body">
<p>
<label for="E1">Q<?php $i++; echo $i; ?>. Important customer information declaration?</label>
<input type="radio" name="E1" <?php if (isset($RL_QE_E1) && $RL_QE_E1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="1" id="yesCheckET1">Yes
<input type="radio" name="E1" <?php if (isset($RL_QE_E1) && $RL_QE_E1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET1();" value="0" id="noCheckET1">No
</p>

<div id="ifYesET1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ET1" name="ET1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET1)) { echo $RL_CEM_ET1; } ?></textarea><span class="help-block"><p id="ET1chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ET1chars').text('400 characters left');
    $('#ET1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET1chars').text('You have reached the limit');
            $('#ET1chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET1chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET1chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET1() {
    if (document.getElementById('yesCheckET1').checked) {
        document.getElementById('ifYesET1').style.display = 'none';
    }
    else document.getElementById('ifYesET1').style.display = 'block';

}

</script>

<p>
<label for="E2">Q<?php $i++; echo $i; ?>. Were all clients contact details recorded correctly?</label>
<input type="radio" name="E2" <?php if (isset($RL_QE_E2) && $RL_QE_E2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="1" id="yesCheckET2">Yes
<input type="radio" name="E2" <?php if (isset($RL_QE_E2) && $RL_QE_E2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET2();" value="0" id="noCheckET2">No
</p>

<div id="ifYesET2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ET2" name="ET2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET2)) { echo $RL_CEM_ET2; } ?></textarea><span class="help-block"><p id="ET2chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ET2chars').text('400 characters left');
    $('#ET2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET2chars').text('You have reached the limit');
            $('#ET2chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET2chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET2chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET2() {
    if (document.getElementById('yesCheckET2').checked) {
        document.getElementById('ifYesET2').style.display = 'none';
    }
    else document.getElementById('ifYesET2').style.display = 'block';

}

</script>

<p>
<label for="E3">Q<?php $i++; echo $i; ?>. Were all clients address details recorded correctly?</label>
<input type="radio" name="E3" <?php if (isset($RL_QE_E3) && $RL_QE_E3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="1" id="yesCheckET3">Yes
<input type="radio" name="E3" <?php if (isset($RL_QE_E3) && $RL_QE_E3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET3();" value="0" id="noCheckET3">No
</p>

<div id="ifYesET3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ET3" name="ET3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET3)) { echo $RL_CEM_ET3; } ?></textarea><span class="help-block"><p id="ET3chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ET3chars').text('400 characters left');
    $('#ET3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET3chars').text('You have reached the limit');
            $('#ET3chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET3chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET3chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET3() {
    if (document.getElementById('yesCheckET3').checked) {
        document.getElementById('ifYesET3').style.display = 'none';
    }
    else document.getElementById('ifYesET3').style.display = 'block';

}

</script>

<p>
<label for="E4">Q<?php $i++; echo $i; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label>
<input type="radio" name="E4" <?php if (isset($RL_QE_E4) && $RL_QE_E4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="1" id="yesCheckET4">Yes
<input type="radio" name="E4" <?php if (isset($RL_QE_E4) && $RL_QE_E4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET4();" value="0" id="noCheckET4">No
</p>

<div id="ifYesET4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ET4" name="ET4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET4)) { echo $RL_CEM_ET4; } ?></textarea><span class="help-block"><p id="ET4chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ET4chars').text('400 characters left');
    $('#ET4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET4chars').text('You have reached the limit');
            $('#ET4chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET4chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET4chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET4() {
    if (document.getElementById('yesCheckET4').checked) {
        document.getElementById('ifYesET4').style.display = 'none';
    }
    else document.getElementById('ifYesET4').style.display = 'block';

}

</script>

<p>
<label for="E5">Q<?php $i++; echo $i; ?>. Were all family history questions asked and recorded correctly?</label>
<input type="radio" name="E5" <?php if (isset($RL_QE_E5) && $RL_QE_E5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="1" id="yesCheckET5">Yes
<input type="radio" name="E5" <?php if (isset($RL_QE_E5) && $RL_QE_E5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckET5();" value="0" id="noCheckET5">No
</p>

<div id="ifYesET5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="ET5" name="ET5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET5)) { echo $RL_CEM_ET5; } ?></textarea><span class="help-block"><p id="ET5chars" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#ET5chars').text('400 characters left');
    $('#ET5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET5chars').text('You have reached the limit');
            $('#ET5chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET5chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET5chars').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckET5() {
    if (document.getElementById('yesCheckET5').checked) {
        document.getElementById('ifYesET5').style.display = 'none';
    }
    else document.getElementById('ifYesET5').style.display = 'block';

}

</script>

<p>
<label for="E6">Q<?php $i++; echo $i; ?>. Were term for term details recorded correctly?</label>
<select class="form-control" name="E6" >
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='0') { echo "selected"; } ?> value="0">Select...</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='1') { echo "selected"; } ?> value="1">Client Provided Details</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='2') { echo "selected"; } ?> value="2">Client failed to provide details</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='3') { echo "selected"; } ?> value="3">Not existing Royal London customer</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='4') { echo "selected"; } ?> value="4">Obtained from Term4Term service</option>
  <option <?php if(isset($RL_QE_E6) && $RL_QE_E6=='5') { echo "selected"; } ?> value="5">Existing Royal London Policy, no attempt to get policy number</option>
</select>
</p>

<textarea class="form-control"id="ET6" name="ET6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_ET6)) { echo $RL_CEM_ET6; } ?></textarea><span class="help-block"><p id="ET6chars" class="help-block ">You have reached the limit</p></span>
<script>
$(document).ready(function(){ 
    $('#ET6chars').text('400 characters left');
    $('#ET6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#ET6chars').text('You have reached the limit');
            $('#ET6chars').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#ET6chars').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#ET6chars').removeClass('red');            
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
<label for="PI1">Q<?php $i++; echo $i; ?>. Was the clients policy start date accurately recorded?</label>
<input type="radio" name="PI1" <?php if (isset($RL_QE_PI1) && $RL_QE_PI1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="1" id="yesCheckPIT1">Yes
<input type="radio" name="PI1" <?php if (isset($RL_QE_PI1) && $RL_QE_PI1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT1();" value="0" id="noCheckPIT1">No
</p>

<div id="ifYesPIT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="PIT1" name="PIT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_PIT1)) { echo $RL_CEM_PIT1; } ?></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft36').text('400 characters left');
    $('#PIT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft36').text('You have reached the limit');
            $('#characterLeft36').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft36').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft36').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT1() {
    if (document.getElementById('yesCheckPIT1').checked) {
        document.getElementById('ifYesPIT1').style.display = 'none';
    }
    else document.getElementById('ifYesPIT1').style.display = 'block';

}

</script>

<p>
<label for="PI2">Q<?php $i++; echo $i; ?>. Did the closer offer to read the direct debit guarantee?</label>
<input type="radio" name="PI2" <?php if (isset($RL_QE_PI2) && $RL_QE_PI2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="1" id="yesCheckPIT2">Yes
<input type="radio" name="PI2" <?php if (isset($RL_QE_PI2) && $RL_QE_PI2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT2();" value="0" id="noCheckPIT2">No
</p>

<div id="ifYesPIT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="PIT2" name="PIT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_PIT2)) { echo $RL_CEM_PIT2; } ?></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft37').text('400 characters left');
    $('#PIT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft37').text('You have reached the limit');
            $('#characterLeft37').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft37').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft37').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT2() {
    if (document.getElementById('yesCheckPIT2').checked) {
        document.getElementById('ifYesPIT2').style.display = 'none';
    }
    else document.getElementById('ifYesPIT2').style.display = 'block';

}

</script>

<p>
<label for="PI3">Q<?php $i++; echo $i; ?>. Did the closer offer a preferred premium collection date?</label>
<input type="radio" name="PI3" <?php if (isset($RL_QE_PI3) && $RL_QE_PI3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="1" id="yesCheckPIT3">Yes
<input type="radio" name="PI3" <?php if (isset($RL_QE_PI3) && $RL_QE_PI3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT3();" value="0" id="noCheckPIT3">No
</p>

<div id="ifYesPIT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="PIT3" name="PIT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_PIT3)) { echo $RL_CEM_PIT3; } ?></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft38').text('400 characters left');
    $('#PIT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft38').text('You have reached the limit');
            $('#characterLeft38').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft38').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft38').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT3() {
    if (document.getElementById('yesCheckPIT3').checked) {
        document.getElementById('ifYesPIT3').style.display = 'none';
    }
    else document.getElementById('ifYesPIT3').style.display = 'block';

}

</script>

<p>
<label for="PI4">Q<?php $i++; echo $i; ?>. Did the closer record the bank details correctly?</label>
<input type="radio" name="PI4" <?php if (isset($RL_QE_PI4) && $RL_QE_PI4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="1" id="yesCheckPIT4">Yes
<input type="radio" name="PI4" <?php if (isset($RL_QE_PI4) && $RL_QE_PI4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT4();" value="0" id="noCheckPIT4">No
</p>

<div id="ifYesPIT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="PIT4" name="PIT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_PIT4)) { echo $RL_CEM_PIT4; } ?></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft39').text('400 characters left');
    $('#PIT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft39').text('You have reached the limit');
            $('#characterLeft39').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft39').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft39').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT4() {
    if (document.getElementById('yesCheckPIT4').checked) {
        document.getElementById('ifYesPIT4').style.display = 'none';
    }
    else document.getElementById('ifYesPIT4').style.display = 'block';

}

</script>

<p>
<label for="PI5">Q<?php $i++; echo $i; ?>. Did they have consent off the premium payer?</label>
<input type="radio" name="PI5" <?php if (isset($RL_QE_PI5) && $RL_QE_PI5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="1" id="yesCheckPIT5">Yes
<input type="radio" name="PI5" <?php if (isset($RL_QE_PI5) && $RL_QE_PI5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckPIT5();" value="0" id="noCheckPIT5">No
</p>

<div id="ifYesPIT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="PIT5" name="PIT5" rows="1" cols="75" maxlength="1400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_PIT5)) { echo $RL_CEM_PIT5; } ?></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft40').text('400 characters left');
    $('#PIT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft40').text('You have reached the limit');
            $('#characterLeft40').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft40').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft40').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckPIT5() {
    if (document.getElementById('yesCheckPIT5').checked) {
        document.getElementById('ifYesPIT5').style.display = 'none';
    }
    else document.getElementById('ifYesPIT5').style.display = 'block';

}

</script>

</div>
</div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Consolidation Declaration</h3>
        </div>
        <div class="panel-body">
            
<p>
<label for="CDE1">Q<?php $i++; echo $i; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
<input type="radio" name="CDE1" <?php if (isset($RL_QE_CDE1) && $RL_QE_CDE1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="1" id="yesCheckCDET1">Yes
<input type="radio" name="CDE1" <?php if (isset($RL_QE_CDE1) && $RL_QE_CDE1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET1();" value="0" id="noCheckCDET1">No
</p>

<div id="ifYesCDET1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET1" name="CDET1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET1)) { echo $RL_CEM_CDET1; } ?></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft41').text('400 characters left');
    $('#CDET1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft41').text('You have reached the limit');
            $('#characterLeft41').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft41').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft41').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET1() {
    if (document.getElementById('yesCheckCDET1').checked) {
        document.getElementById('ifYesCDET1').style.display = 'none';
    }
    else document.getElementById('ifYesCDET1').style.display = 'block';

}

</script>


<p>
<label for="CDE2">Q<?php $i++; echo $i; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
<input type="radio" name="CDE2" <?php if (isset($RL_QE_CDE2) && $RL_QE_CDE2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="1" id="yesCheckCDET2">Yes
<input type="radio" name="CDE2" <?php if (isset($RL_QE_CDE2) && $RL_QE_CDE2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET2();" value="0" id="noCheckCDET2">No
</p>

<div id="ifYesCDET2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET2" name="CDET2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET2)) { echo $RL_CEM_CDET2; } ?></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft42').text('400 characters left');
    $('#CDET2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft42').text('You have reached the limit');
            $('#characterLeft42').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft42').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft42').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET2() {
    if (document.getElementById('yesCheckCDET2').checked) {
        document.getElementById('ifYesCDET2').style.display = 'none';
    }
    else document.getElementById('ifYesCDET2').style.display = 'block';

}

</script>

<p>
<label for="CDE3">Q<?php $i++; echo $i; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
<input type="radio" name="CDE3" <?php if (isset($RL_QE_CDE3) && $RL_QE_CDE3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="1" id="yesCheckCDET3">Yes
<input type="radio" name="CDE3" <?php if (isset($RL_QE_CDE3) && $RL_QE_CDE3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET3();" value="0" id="noCheckCDET3">No
</p>

<div id="ifYesCDET3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET3" name="CDET3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET3)) { echo $RL_CEM_CDET3; } ?></textarea><span class="help-block"><p id="characterLeft43" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft43').text('400 characters left');
    $('#CDET3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft43').text('You have reached the limit');
            $('#characterLeft43').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft43').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft43').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET3() {
    if (document.getElementById('yesCheckCDET3').checked) {
        document.getElementById('ifYesCDET3').style.display = 'none';
    }
    else document.getElementById('ifYesCDET3').style.display = 'block';

}

</script>

<p>
<label for="CDE4">Q<?php $i++; echo $i; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
<input type="radio" name="CDE4" <?php if (isset($RL_QE_CDE4) && $RL_QE_CDE4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="1" id="yesCheckCDET4">Yes
<input type="radio" name="CDE4" <?php if (isset($RL_QE_CDE4) && $RL_QE_CDE4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET4();" value="0" id="noCheckCDET4">No
</p>

<div id="ifYesCDET4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET4" name="CDET4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET4)) { echo $RL_CEM_CDET4; } ?></textarea><span class="help-block"><p id="characterLeft44" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft44').text('400 characters left');
    $('#CDET4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft44').text('You have reached the limit');
            $('#characterLeft44').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft44').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft44').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET4() {
    if (document.getElementById('yesCheckCDET4').checked) {
        document.getElementById('ifYesCDET4').style.display = 'none';
    }
    else document.getElementById('ifYesCDET4').style.display = 'block';

}

</script>

<p>
<label for="CDE5">Q<?php $i++; echo $i; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Royal London?</label>
<input type="radio" name="CDE5"  <?php if (isset($RL_QE_CDE5) && $RL_QE_CDE5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="1" id="yesCheckCDET5">Yes
<input type="radio" name="CDE5" <?php if (isset($RL_QE_CDE5) && $RL_QE_CDE5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET5();" value="0" id="noCheckCDET5">No
</p>

<div id="ifYesCDET5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET5" name="CDET5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET5)) { echo $RL_CEM_CDET5; } ?></textarea><span class="help-block"><p id="characterLeft45" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft45').text('400 characters left');
    $('#CDET5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft45').text('You have reached the limit');
            $('#characterLeft45').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft45').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft45').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET5() {
    if (document.getElementById('yesCheckCDET5').checked) {
        document.getElementById('ifYesCDET5').style.display = 'none';
    }
    else document.getElementById('ifYesCDET5').style.display = 'block';

}

</script>

<p>
<label for="CDE6">Q<?php $i++; echo $i; ?>. Closer confirmed the check your details procedure?</label>
<input type="radio" name="CDE6" <?php if (isset($RL_QE_CDE6) && $RL_QE_CDE6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="1" id="yesCheckCDET6">Yes
<input type="radio" name="CDE6" <?php if (isset($RL_QE_CDE6) && $RL_QE_CDE6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET6();" value="0" id="noCheckCDET6">No
</p>

<div id="ifYesCDET6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET6" name="CDET6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET6)) { echo $RL_CEM_CDET6; } ?></textarea><span class="help-block"><p id="characterLeft46" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft46').text('400 characters left');
    $('#CDET6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft46').text('You have reached the limit');
            $('#characterLeft46').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft46').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft46').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET6() {
    if (document.getElementById('yesCheckCDET6').checked) {
        document.getElementById('ifYesCDET6').style.display = 'none';
    }
    else document.getElementById('ifYesCDET6').style.display = 'block';

}

</script>

<p>
<label for="CDE7">Q<?php $i++; echo $i; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Royal London will write to them with a more specific date?</label>
<input type="radio" name="CDE7" <?php if (isset($RL_QE_CDE7) && $RL_QE_CDE7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="1" id="yesCheckCDET7">Yes
<input type="radio" name="CDE7" <?php if (isset($RL_QE_CDE7) && $RL_QE_CDE7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET7();" value="0" id="noCheckCDET7">No

</p>

<div id="ifYesCDET7" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET7" name="CDET7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET7)) { echo $RL_CEM_CDET7; } ?></textarea><span class="help-block"><p id="characterLeft47" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft47').text('400 characters left');
    $('#CDET7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft47').text('You have reached the limit');
            $('#characterLeft47').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft47').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft47').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET7() {
    if (document.getElementById('yesCheckCDET7').checked) {
        document.getElementById('ifYesCDET7').style.display = 'none';
    }
    else document.getElementById('ifYesCDET7').style.display = 'block';

}

</script>

<p>
<label for="CDE8">Q<?php $i++; echo $i; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label>
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="1" id="yesCheckCDET8">Yes
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="0" id="noCheckCDET8">No
<input type="radio" name="CDE8" <?php if (isset($RL_QE_CDE8) && $RL_QE_CDE8=="3") { echo "checked"; } ?> onclick="javascript:yesnoCheckCDET8();" value="3" id="yesCheckCDET8">N/A
</p>

<div id="ifYesCDET8" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="CDET8" name="CDET8" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_CDET8)) { echo $RL_CEM_CDET8; } ?></textarea><span class="help-block"><p id="characterLeft48" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft48').text('400 characters left');
    $('#CDET8').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft48').text('You have reached the limit');
            $('#characterLeft48').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft48').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft48').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckCDET8() {
    if (document.getElementById('yesCheckCDET8').checked) {
        document.getElementById('ifYesCDET8').style.display = 'none';
    }
    else document.getElementById('ifYesCDET8').style.display = 'block';

}

</script>

</div>
</div>
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Quality Control</h3>
        </div>
        <div class="panel-body">
            
<p>
<label for="QC1">Q<?php $i++; echo $i; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Royal London with client information?</label>
<input type="radio" name="QC1" <?php if (isset($RL_QE_QC1) && $RL_QE_QC1=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="1" id="yesCheckQCT1">Yes
<input type="radio" name="QC1" <?php if (isset($RL_QE_QC1) && $RL_QE_QC1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT1();" value="0" id="noCheckQCT1">No
</p>

<div id="ifYesQCT1" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT1" name="QCT1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT1)) { echo $RL_CEM_QCT1; } ?></textarea><span class="help-block"><p id="characterLeft49" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft49').text('400 characters left');
    $('#QCT1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft49').text('You have reached the limit');
            $('#characterLeft49').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft49').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft49').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT1() {
    if (document.getElementById('yesCheckQCT1').checked) {
        document.getElementById('ifYesQCT1').style.display = 'none';
    }
    else document.getElementById('ifYesQCT1').style.display = 'block';

}

</script>

<p>
<label for="QC2">Q<?php $i++; echo $i; ?>. Closer confirmed length of policy in years with client confirmation?</label>
<input type="radio" name="QC2" <?php if (isset($RL_QE_QC2) && $RL_QE_QC2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="1" id="yesCheckQCT2">Yes
<input type="radio" name="QC2" <?php if (isset($RL_QE_QC2) && $RL_QE_QC2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT2();" value="0" id="noCheckQCT2">No
</p>

<div id="ifYesQCT2" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT2" name="QCT2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT2)) { echo $RL_CEM_QCT2; } ?></textarea><span class="help-block"><p id="characterLeft50" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft50').text('400 characters left');
    $('#QCT2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft50').text('You have reached the limit');
            $('#characterLeft50').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft50').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft50').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT2() {
    if (document.getElementById('yesCheckQCT2').checked) {
        document.getElementById('ifYesQCT2').style.display = 'none';
    }
    else document.getElementById('ifYesQCT2').style.display = 'block';

}

</script>

<p>
<label for="QC3">Q<?php $i++; echo $i; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
<input type="radio" name="QC3" <?php if (isset($RL_QE_QC3) && $RL_QE_QC3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="1" id="yesCheckQCT3">Yes
<input type="radio" name="QC3" <?php if (isset($RL_QE_QC3) && $RL_QE_QC3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT3();" value="0" id="noCheckQCT3">No
</p>

<div id="ifYesQCT3" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT3" name="QCT3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT3)) { echo $RL_CEM_QCT3; } ?></textarea><span class="help-block"><p id="characterLeft51" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft51').text('400 characters left');
    $('#QCT3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft51').text('You have reached the limit');
            $('#characterLeft51').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft51').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft51').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT3() {
    if (document.getElementById('yesCheckQCT3').checked) {
        document.getElementById('ifYesQCT3').style.display = 'none';
    }
    else document.getElementById('ifYesQCT3').style.display = 'block';

}

</script>

<p>
<label for="QC4">Q<?php $i++; echo $i; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
<input type="radio" name="QC4" <?php if (isset($RL_QE_QC4) && $RL_QE_QC4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="1" id="yesCheckQCT4">Yes
<input type="radio" name="QC4" <?php if (isset($RL_QE_QC4) && $RL_QE_QC4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT4();" value="0" id="noCheckQCT4">No
</p>

<div id="ifYesQCT4" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT4" name="QCT4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT4)) { echo $RL_CEM_QCT4; } ?></textarea><span class="help-block"><p id="characterLeft52" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft52').text('400 characters left');
    $('#QCT4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft52').text('You have reached the limit');
            $('#characterLeft52').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft52').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft52').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT4() {
    if (document.getElementById('yesCheckQCT4').checked) {
        document.getElementById('ifYesQCT4').style.display = 'none';
    }
    else document.getElementById('ifYesQCT4').style.display = 'block';

}

</script>

<p>
<label for="QC5">Q<?php $i++; echo $i; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
<input type="radio" name="QC5" <?php if (isset($RL_QE_QC5) && $RL_QE_QC5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="1" id="yesCheckQCT5">Yes
<input type="radio" name="QC5" <?php if (isset($RL_QE_QC5) && $RL_QE_QC5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT5();" value="0" id="noCheckQCT5">No
</p>

<div id="ifYesQCT5" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT5" name="QCT5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT5)) { echo $RL_CEM_QCT5; } ?></textarea><span class="help-block"><p id="characterLeft53" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft53').text('400 characters left');
    $('#QCT5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft53').text('You have reached the limit');
            $('#characterLeft53').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft53').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft53').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT5() {
    if (document.getElementById('yesCheckQCT5').checked) {
        document.getElementById('ifYesQCT5').style.display = 'none';
    }
    else document.getElementById('ifYesQCT5').style.display = 'block';

}

</script>

<p>
<label for="QC6">Q<?php $i++; echo $i; ?>. Closer provided contact details for Bluestone Protect?</label>
<input type="radio" name="QC6" <?php if (isset($RL_QE_QC6) && $RL_QE_QC6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="1" id="yesCheckQCT6">Yes
<input type="radio" name="QC6" <?php if (isset($RL_QE_QC6) && $RL_QE_QC6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT6();" value="0" id="noCheckQCT6">No
</p>

<div id="ifYesQCT6" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT6" name="QCT6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT6)) { echo $RL_CEM_QCT6; } ?></textarea><span class="help-block"><p id="characterLeft54" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft54').text('400 characters left');
    $('#QCT6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft54').text('You have reached the limit');
            $('#characterLeft54').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft54').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft54').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT6() {
    if (document.getElementById('yesCheckQCT6').checked) {
        document.getElementById('ifYesQCT6').style.display = 'none';
    }
    else document.getElementById('ifYesQCT6').style.display = 'block';

}

</script>

<p>
<label for="QC7">Q<?php $i++; echo $i; ?>. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
<input type="radio" name="QC7" <?php if (isset($RL_QE_QC7) && $RL_QE_QC7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="1" id="yesCheckQCT7">Yes
<input type="radio" name="QC7" <?php if (isset($RL_QE_QC7) && $RL_QE_QC7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQCT7();" value="0" id="noCheckQCT7">No
</p>

<div id="ifYesQCT7" style='display: <?php if(isset($EXECUTE) && $EXECUTE=='VIEW' || $EXECUTE=='EDIT') { echo "block"; }  else  {  echo "none" ;  } ?> '>
<textarea class="form-control"id="QCT7" name="QCT7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($RL_CEM_QCT7)) { echo $RL_CEM_QCT7; } ?></textarea><span class="help-block"><p id="characterLeft55" class="help-block ">You have reached the limit</p></span>
</div>
<script>
$(document).ready(function(){ 
    $('#characterLeft55').text('400 characters left');
    $('#QCT7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft55').text('You have reached the limit');
            $('#characterLeft55').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft55').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft55').removeClass('red');            
        }
    });    
});
</script>
<script type="text/javascript">

function yesnoCheckQCT7() {
    if (document.getElementById('yesCheckQCT7').checked) {
        document.getElementById('ifYesQCT7').style.display = 'none';
    }
    else document.getElementById('ifYesQCT7').style.display = 'block';

}

</script>

</div>
</div>

<br>

<?php if(isset($EXECUTE)) {
    if($EXECUTE=='EDIT') { ?>
<center>
     <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Update Audit</button>
     </center>
<?php    }
if($EXECUTE=='EDIT') {
} } else {?>

<center>
    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Submit Audit</button>
</center>
     
<?php } ?>
</form>
    </div>
</body>
</html>