<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
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

if ($ffaudits == '0') {
    header('Location: /../../CRMmain.php');
    die;
}

if (!in_array($hello_name, $Level_3_Access, true)) {
    header('Location: /../../CRMmain.php');
    die;
}

$AID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE) && $EXECUTE=='VIEW' && isset($AID)) {
    
    require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
    require_once(__DIR__ . '/../../classes/database_class.php');
    
    $SELECT1 = $pdo->prepare("SELECT 
    aviva_audit_grade, aviva_audit_policy, aviva_audit_closer, aviva_audit_added_by, aviva_audit_added_date
FROM
    aviva_audit
WHERE
    aviva_audit_id =:AID");
    $SELECT1->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT1->execute();
    $data1 = $SELECT1->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data1['aviva_audit_grade'])) {
        $GRADE=$data1['aviva_audit_grade'];
    }
    
    if(isset($data1['aviva_audit_policy'])) {
        $POLICY=$data1['aviva_audit_policy'];
    }
    if(isset($data1['aviva_audit_closer'])) {
        $CLOSER=$data1['aviva_audit_closer'];
    }
    if(isset($data1['aviva_audit_added_by'])) {
        $AUDITOR=$data1['aviva_audit_added_by'];
    }
    if(isset($data1['aviva_audit_added_date'])) {
        $DATE_ADDED=$data1['aviva_audit_added_date'];
    }     
    
    $SELECT2 = $pdo->prepare("SELECT 
    aviva_ques_od1, aviva_ques_od2, aviva_ques_od3, aviva_ques_od4, aviva_ques_od5, aviva_ques_ci1, aviva_ques_ci2, aviva_ques_ci3, aviva_ques_ci4, aviva_ques_ci5, aviva_ques_ci6, aviva_ques_icn1, aviva_ques_icn2, aviva_ques_icn3, aviva_ques_icn4, aviva_ques_icn5, aviva_ques_icn6
FROM
    aviva_ques
WHERE
    aviva_ques_id_fk =:AID");
    $SELECT2->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT2->execute();
    $data2 = $SELECT2->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data2['aviva_ques_od1'])) {
        $Q_OD1=$data2['aviva_ques_od1'];
    }
    if(isset($data2['aviva_ques_od2'])) {
        $Q_OD2=$data2['aviva_ques_od2'];
    }
    if(isset($data2['aviva_ques_od3'])) {
        $Q_OD3=$data2['aviva_ques_od3'];
    } 
    if(isset($data2['aviva_ques_od4'])) {
        $Q_OD4=$data2['aviva_ques_od4'];
    }
    if(isset($data2['aviva_ques_od5'])) {
        $Q_OD5=$data2['aviva_ques_od5'];
    }  

    if(isset($data2['aviva_ques_ci1'])) {
        $Q_CI1=$data2['aviva_ques_ci1'];
    }
    if(isset($data2['aviva_ques_ci2'])) {
        $Q_CI2=$data2['aviva_ques_ci2'];
    } 
    if(isset($data2['aviva_ques_ci3'])) {
        $Q_CI3=$data2['aviva_ques_ci3'];
    } 
    if(isset($data2['aviva_ques_ci4'])) {
        $Q_CI4=$data2['aviva_ques_ci4'];
    } 
    if(isset($data2['aviva_ques_ci5'])) {
         $Q_CI5=$data2['aviva_ques_ci5'];
    } 
    if(isset($data2['aviva_ques_ci6'])) {
        $Q_CI6=$data2['aviva_ques_ci6'];
    }  

    if(isset($data2['aviva_ques_icn1'])) {
        $Q_ICN1=$data2['aviva_ques_icn1'];
    }
    if(isset($data2['aviva_ques_icn2'])) {
        $Q_ICN2=$data2['aviva_ques_icn2'];
    } 
    if(isset($data2['aviva_ques_icn3'])) {
        $Q_ICN3=$data2['aviva_ques_icn3'];
    } 
    if(isset($data2['aviva_ques_icn4'])) {
        $Q_ICN4=$data2['aviva_ques_icn4'];
    } 
    if(isset($data2['aviva_ques_icn5'])) {
        $Q_ICN5=$data2['aviva_ques_icn5'];
    } 
    if(isset($data2['aviva_ques_icn6'])) {
        $Q_ICN6=$data2['aviva_ques_icn6'];
    }     

    $SELECT3 = $pdo->prepare("SELECT 
    aviva_comms_od1, aviva_comms_od2, aviva_comms_od3, aviva_comms_od4, aviva_comms_od5, aviva_comms_ci1, aviva_comms_ci2, aviva_comms_ci3, aviva_comms_ci4, aviva_comms_ci5, aviva_comms_ci6, aviva_comms_icn1, aviva_comms_icn2, aviva_comms_icn3, aviva_comms_icn4, aviva_comms_icn5, aviva_comms_icn6
FROM
    aviva_comms
WHERE
    aviva_comms_id_fk =:AID");
    $SELECT3->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT3->execute();
    $data3 = $SELECT3->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data3['aviva_comms_od1'])) {
        $T_OD1=$data3['aviva_comms_od1'];
    }
    if(isset($data3['aviva_comms_od2'])) {
        $T_OD2=$data3['aviva_comms_od2'];
    }
    if(isset($data3['aviva_comms_od3'])) {
        $T_OD3=$data3['aviva_comms_od3'];
    } 
    if(isset($data3['aviva_comms_od4'])) {
        $T_OD4=$data3['aviva_comms_od4'];
    }
    if(isset($data3['aviva_comms_od5'])) {
        $T_OD5=$data3['aviva_comms_od5'];
    }  

    if(isset($data3['aviva_comms_ci1'])) {
        $T_CI1=$data3['aviva_comms_ci1'];
    }
    if(isset($data3['aviva_comms_ci2'])) {
        $T_CI2=$data3['aviva_comms_ci2'];
    } 
    if(isset($data3['aviva_comms_ci3'])) {
        $T_CI3=$data3['aviva_comms_ci3'];
    } 
    if(isset($data3['aviva_comms_ci4'])) {
        $T_CI4=$data3['aviva_comms_ci4'];
    } 
    if(isset($data3['aviva_comms_ci5'])) {
         $T_CI5=$data3['aviva_comms_ci5'];
    } 
    if(isset($data3['aviva_comms_ci6'])) {
        $T_CI6=$data3['aviva_comms_ci6'];
    }  

    if(isset($data3['aviva_comms_icn1'])) {
        $T_ICN1=$data3['aviva_comms_icn1'];
    }
    if(isset($data3['aviva_comms_icn2'])) {
        $T_ICN2=$data3['aviva_comms_icn2'];
    } 
    if(isset($data3['aviva_comms_icn3'])) {
        $T_ICN3=$data3['aviva_comms_icn3'];
    } 
    if(isset($data3['aviva_comms_icn4'])) {
        $T_ICN4=$data3['aviva_comms_icn4'];
    } 
    if(isset($data3['aviva_comms_icn5'])) {
        $T_ICN5=$data3['aviva_comms_icn5'];
    } 
    if(isset($data3['aviva_comms_icn6'])) {
        $T_ICN6=$data3['aviva_comms_icn6'];
    }      

    $SELECT4 = $pdo->prepare("SELECT 
    aviva_ques_2_e1, aviva_ques_2_e2, aviva_ques_2_e3, aviva_ques_2_e4, aviva_ques_2_e5, aviva_ques_2_e6, aviva_ques_2_e7, aviva_ques_2_e8, aviva_ques_2_e9, aviva_ques_2_e10, aviva_ques_2_e11, aviva_ques_2_e12, aviva_ques_2_e13, aviva_ques_2_e14
FROM
    aviva_ques_2
WHERE
    aviva_ques_2_id_fk =:AID");
    $SELECT4->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT4->execute();
    $data4 = $SELECT4->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data4['aviva_ques_2_e1'])) {
        $Q_E1=$data4['aviva_ques_2_e1'];
    } 
    if(isset($data4['aviva_ques_2_e2'])) {
        $Q_E2=$data4['aviva_ques_2_e2'];
    }
    if(isset($data4['aviva_ques_2_e3'])) {
        $Q_E3=$data4['aviva_ques_2_e3'];
    }   
    if(isset($data4['aviva_ques_2_e4'])) {
        $Q_E4=$data4['aviva_ques_2_e4'];
    }   
    if(isset($data4['aviva_ques_2_e5'])) {
        $Q_E5=$data4['aviva_ques_2_e5'];
    }   
    if(isset($data4['aviva_ques_2_e6'])) {
        $Q_E6=$data4['aviva_ques_2_e6'];
    }   
    if(isset($data4['aviva_ques_2_e7'])) {
        $Q_E7=$data4['aviva_ques_2_e7'];
    }   
    if(isset($data4['aviva_ques_2_e8'])) {
        $Q_E8=$data4['aviva_ques_2_e8'];
    }   
    if(isset($data4['aviva_ques_2_e9'])) {
        $Q_E9=$data4['aviva_ques_2_e9'];
    }   
    if(isset($data4['aviva_ques_2_e10'])) {
        $Q_E10=$data4['aviva_ques_2_e10'];
    }   
    if(isset($data4['aviva_ques_2_e11'])) {
        $Q_E11=$data4['aviva_ques_2_e11'];
    }   
    if(isset($data4['aviva_ques_2_e12'])) {
        $Q_E12=$data4['aviva_ques_2_e12'];
    }   
    if(isset($data4['aviva_ques_2_e13'])) {
        $Q_E13=$data4['aviva_ques_2_e13'];
    }   
    if(isset($data4['aviva_ques_2_e14'])) {
        $Q_E14=$data4['aviva_ques_2_e14'];
    }   
    if(isset($data4['aviva_ques_2_e15'])) {
        $Q_E15=$data4['aviva_ques_2_e15'];
    }   
    if(isset($data4['aviva_ques_2_e16'])) {
        $Q_E16=$data4['aviva_ques_2_e16'];
    }   

    $SELECT5 = $pdo->prepare("SELECT 
     aviva_comms_2_e1, aviva_comms_2_e2, aviva_comms_2_e3, aviva_comms_2_e4, aviva_comms_2_e5, aviva_comms_2_e6, aviva_comms_2_e7, aviva_comms_2_e8, aviva_comms_2_e9, aviva_comms_2_e10, aviva_comms_2_e11, aviva_comms_2_e12, aviva_comms_2_e13, aviva_comms_2_e14
FROM
    aviva_comms_2
WHERE
    aviva_comms_2_id_fk =:AID");
    $SELECT5->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT5->execute();
    $data5 = $SELECT5->fetch(PDO::FETCH_ASSOC);  

    if(isset($data5['aviva_comms_2_e1'])) {
        $T_E1=$data5['aviva_comms_2_e1'];
    } 
    if(isset($data5['aviva_comms_2_e2'])) {
        $T_E2=$data5['aviva_comms_2_e2'];
    }
    if(isset($data5['aviva_comms_2_e3'])) {
        $T_E3=$data5['aviva_comms_2_e3'];
    }   
    if(isset($data5['aviva_comms_2_e4'])) {
        $T_E4=$data5['aviva_comms_2_e4'];
    }   
    if(isset($data5['aviva_comms_2_e5'])) {
        $T_E5=$data5['aviva_comms_2_e5'];
    }   
    if(isset($data5['aviva_comms_2_e6'])) {
        $T_E6=$data5['aviva_comms_2_e6'];
    }   
    if(isset($data5['aviva_comms_2_e7'])) {
        $T_E7=$data5['aviva_comms_2_e7'];
    }   
    if(isset($data5['aviva_comms_2_e8'])) {
        $T_E8=$data5['aviva_comms_2_e8'];
    }   
    if(isset($data5['aviva_comms_2_e9'])) {
        $T_E9=$data5['aviva_comms_2_e9'];
    }   
    if(isset($data5['aviva_comms_2_e10'])) {
        $T_E10=$data5['aviva_comms_2_e10'];
    }   
    if(isset($data5['aviva_comms_2_e11'])) {
        $T_E11=$data5['aviva_comms_2_e11'];
    }   
    if(isset($data5['aviva_comms_2_e12'])) {
        $T_E12=$data5['aviva_comms_2_e12'];
    }   
    if(isset($data5['aviva_comms_2_e13'])) {
        $T_E13=$data5['aviva_comms_2_e13'];
    }   
    if(isset($data5['aviva_comms_2_e14'])) {
        $T_E14=$data5['aviva_comms_2_e14'];
    }   
    if(isset($data5['aviva_comms_2_e15'])) {
        $T_E15=$data5['aviva_comms_2_e15'];
    }   
    if(isset($data5['aviva_comms_2_e16'])) {
        $T_E16=$data5['aviva_comms_2_e16'];
    }     

        $SELECT6 = $pdo->prepare("SELECT 
    aviva_ques_3_di1, aviva_ques_3_di2, aviva_ques_3_pi1, aviva_ques_3_pi2, aviva_ques_3_pi3, aviva_ques_3_pi4, aviva_ques_3_pi5, aviva_ques_3_cd1, aviva_ques_3_cd2, aviva_ques_3_cd3, aviva_ques_3_cd4, aviva_ques_3_cd5, aviva_ques_3_cd6, aviva_ques_3_cd7, aviva_ques_3_cd8, aviva_ques_3_qc1, aviva_ques_3_qc2, aviva_ques_3_qc3, aviva_ques_3_qc4, aviva_ques_3_qc5, aviva_ques_3_qc6, aviva_ques_3_qc7
FROM
    aviva_ques_3
WHERE
    aviva_ques_3_id_fk =:AID");
    $SELECT6->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT6->execute();
    $data6 = $SELECT6->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data6['aviva_ques_3_di1'])) {
        $Q_DI1=$data6['aviva_ques_3_di1'];
    }  
    if(isset($data6['aviva_ques_3_di2'])) {
        $Q_DI2=$data6['aviva_ques_3_di2'];
    } 
    
    if(isset($data6['aviva_ques_3_pi1'])) {
        $Q_PI1=$data6['aviva_ques_3_pi1'];
    }
    if(isset($data6['aviva_ques_3_pi2'])) {
        $Q_PI2=$data6['aviva_ques_3_pi2'];
    } 
    if(isset($data6['aviva_ques_3_pi3'])) {
        $Q_PI3=$data6['aviva_ques_3_pi3'];
    } 
    if(isset($data6['aviva_ques_3_pi4'])) {
        $Q_PI4=$data6['aviva_ques_3_pi4'];
    } 
    if(isset($data6['aviva_ques_3_pi5'])) {
        $Q_PI5=$data6['aviva_ques_3_pi5'];
    }    

    if(isset($data6['aviva_ques_3_cd1'])) {
        $Q_CD1=$data6['aviva_ques_3_cd1'];
    }  
    if(isset($data6['aviva_ques_3_cd2'])) {
        $Q_CD2=$data6['aviva_ques_3_cd2'];
    } 
    if(isset($data6['aviva_ques_3_cd3'])) {
        $Q_CD3=$data6['aviva_ques_3_cd3'];
    } 
    if(isset($data6['aviva_ques_3_cd4'])) {
        $Q_CD4=$data6['aviva_ques_3_cd4'];
    } 
    if(isset($data6['aviva_ques_3_cd5'])) {
        $Q_CD5=$data6['aviva_ques_3_cd5'];
    } 
    if(isset($data6['aviva_ques_3_cd6'])) {
        $Q_CD6=$data6['aviva_ques_3_cd6'];
    } 
    if(isset($data6['aviva_ques_3_cd7'])) {
        $Q_CD7=$data6['aviva_ques_3_cd6'];
    } 
    if(isset($data6['aviva_ques_3_cd8'])) {
        $Q_CD8=$data6['aviva_ques_3_cd8'];
    }  
    
    if(isset($data6['aviva_ques_3_qc1'])) {
        $Q_QC1=$data6['aviva_ques_3_qc1'];
    } 
    if(isset($data6['aviva_ques_3_qc2'])) {
        $Q_QC2=$data6['aviva_ques_3_qc2'];
    } 
    if(isset($data6['aviva_ques_3_qc3'])) {
        $Q_QC3=$data6['aviva_ques_3_qc3'];
    } 
    if(isset($data6['aviva_ques_3_qc4'])) {
        $Q_QC4=$data6['aviva_ques_3_qc4'];
    } 
    if(isset($data6['aviva_ques_3_qc5'])) {
        $Q_QC5=$data6['aviva_ques_3_qc5'];
    } 
    if(isset($data6['aviva_ques_3_qc6'])) {
        $Q_QC6=$data6['aviva_ques_3_qc6'];
    } 
    if(isset($data6['aviva_ques_3_qc7'])) {
        $Q_QC7=$data6['aviva_ques_3_qc7'];
    }
    
        $SELECT7 = $pdo->prepare("SELECT 
    aviva_comms_3_di1, aviva_comms_3_di2, aviva_comms_3_pi1, aviva_comms_3_pi2, aviva_comms_3_pi3, aviva_comms_3_pi4, aviva_comms_3_pi5, aviva_comms_3_cd1, aviva_comms_3_cd2, aviva_comms_3_cd3, aviva_comms_3_cd4, aviva_comms_3_cd5, aviva_comms_3_cd6, aviva_comms_3_cd7, aviva_comms_3_cd8, aviva_comms_3_qc1, aviva_comms_3_qc2, aviva_comms_3_qc3, aviva_comms_3_qc4, aviva_comms_3_qc5, aviva_comms_3_qc6, aviva_comms_3_qc7
FROM
    aviva_comms_3
WHERE
    aviva_comms_3_id_fk =:AID");
    $SELECT7->bindParam(':AID', $AID, PDO::PARAM_INT);
    $SELECT7->execute();
    $data7 = $SELECT7->fetch(PDO::FETCH_ASSOC);  
    
    if(isset($data7['aviva_comms_3_di1'])) {
        $T_DI1=$data7['aviva_comms_3_di1'];
    }  
    if(isset($data7['aviva_comms_3_di2'])) {
        $T_DI2=$data7['aviva_comms_3_di2'];
    } 
    
    if(isset($data7['aviva_comms_3_pi1'])) {
        $T_PI1=$data7['aviva_comms_3_pi1'];
    }
    if(isset($data7['aviva_comms_3_pi2'])) {
        $T_PI2=$data7['aviva_comms_3_pi2'];
    } 
    if(isset($data7['aviva_comms_3_pi3'])) {
        $T_PI3=$data7['aviva_comms_3_pi3'];
    } 
    if(isset($data7['aviva_comms_3_pi4'])) {
        $T_PI4=$data7['aviva_comms_3_pi4'];
    } 
    if(isset($data7['aviva_comms_3_pi5'])) {
        $T_PI5=$data7['aviva_comms_3_pi5'];
    }    

    if(isset($data7['aviva_comms_3_cd1'])) {
        $T_CD1=$data7['aviva_comms_3_cd1'];
    }  
    if(isset($data7['aviva_comms_3_cd2'])) {
        $T_CD2=$data7['aviva_comms_3_cd2'];
    } 
    if(isset($data7['aviva_comms_3_cd3'])) {
        $T_CD3=$data7['aviva_comms_3_cd3'];
    } 
    if(isset($data7['aviva_comms_3_cd4'])) {
        $T_CD4=$data7['aviva_comms_3_cd4'];
    } 
    if(isset($data7['aviva_comms_3_cd5'])) {
        $T_CD5=$data7['aviva_comms_3_cd5'];
    } 
    if(isset($data7['aviva_comms_3_cd6'])) {
        $T_CD6=$data7['aviva_comms_3_cd6'];
    } 
    if(isset($data7['aviva_comms_3_cd7'])) {
        $T_CD7=$data7['aviva_comms_3_cd7'];
    } 
    if(isset($data7['aviva_comms_3_cd8'])) {
        $T_CD8=$data7['aviva_comms_3_cd8'];
    }  
    
    if(isset($data7['aviva_comms_3_qc1'])) {
        $T_QC1=$data7['aviva_comms_3_qc1'];
    } 
    if(isset($data7['aviva_comms_3_qc2'])) {
        $T_QC2=$data7['aviva_comms_3_qc2'];
    } 
    if(isset($data7['aviva_comms_3_qc3'])) {
        $T_QC3=$data7['aviva_comms_3_qc3'];
    } 
    if(isset($data7['aviva_comms_3_qc4'])) {
        $T_QC4=$data7['aviva_comms_3_qc4'];
    } 
    if(isset($data7['aviva_comms_3_qc5'])) {
        $T_QC5=$data7['aviva_comms_3_qc5'];
    } 
    if(isset($data7['aviva_comms_3_qc6'])) {
        $T_QC6=$data7['aviva_comms_3_qc6'];
    } 
    if(isset($data7['aviva_comms_3_qc7'])) {
        $T_QC7=$data7['aviva_comms_3_qc7'];
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
    <title>ADL | View Closer Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/styles/viewlayout.css" type="text/css" />
</head>
<body>

    <div class="container">
        <div class="wrapper col4">
            <table id='users'>
                <thead>

                    <tr>
                        <td colspan=2><b>Aviva Call Audit ID: <?php if(isset($AID)) { echo $AID; } ?></b></td>
                    </tr>

                    <tr>
                        <?php
                        if ($GRADE == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>" . $GRADE . "</b></td>";
                        } else if ($GRADE == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>" . $GRADE . "</b></td>";
                        } else if ($GRADE == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>" . $GRADE . "</b></td>";
                        }
                        ?>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php if(isset($AUDITOR)) { echo $AUDITOR; } ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php if(isset($CLOSER)) { echo $CLOSER; } ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php if(isset($DATE_ADDED)) { echo $DATE_ADDED; } ?></td>
                    </tr>

                    <tr>
                        <td>Policy Number</td>
                        <td><?php if(isset($POLICY)) { echo $POLICY; } ?></td>
                    </tr>

                </thead>
            </table>

            <h1><b>Opening Declaration</b></h1>
            
                                <?php
                                $OD_NUM=1;
                                ?>

            <p>
                <label for="q1"><?php echo $OD_NUM++; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label><br>
                <?php if(isset($Q_OD1)) { if($Q_OD1=='1') { echo "Yes"; } if($Q_OD1=='0') { echo "No"; } } ?>


            <div class="phpcomments">
                <?php if(isset($T_OD1)) { echo $T_OD1; } ?>
            </div>
            </p>

            <p>
                <label for="q2"><?php echo $OD_NUM++; ?>. Was the customer informed that general insurance is regulated by the FCA?</label><br>
                <?php if(isset($Q_OD2)) { if($Q_OD2=='1') { echo "Yes"; } if($Q_OD2=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_OD2)) { echo $T_OD2; } ?>
            </div>
            </p>

            <p>
                <label for="q3"><?php echo $OD_NUM++; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label><br>
                <?php if(isset($Q_OD3)) { if($Q_OD3=='1') { echo "Yes"; } if($Q_OD3=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_OD3)) { echo $T_OD3; } ?>
            </div>
            </p>

            <p>
                <label for="q4"><?php echo $OD_NUM++; ?>. Did the closer provide the name and details of the firm who is regulated by the FCA?</label><br>
                <?php if(isset($Q_OD4)) { if($Q_OD4=='1') { echo "Yes"; } if($Q_OD4=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_OD4)) { echo $T_OD4; } ?>
            </div>
            </p>

            <p>
                <label for="q5"><?php echo $OD_NUM++; ?>. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label><br>
            <?php if(isset($Q_OD5)) { if($Q_OD5=='1') { echo "Yes"; } if($Q_OD5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
               <?php if(isset($T_OD5)) { echo $T_OD5; } ?>
            </div>
            </p>
            
                                <?php
                                $CI_NUM=1;
                                ?>            

            <h1><b>Customer Information</b></h1>

            <p>
                <label for="q6"><?php echo $CI_NUM++; ?>. Were all clients titles and names recorded correctly?</label><br>
            <?php if(isset($Q_CI1)) { if($Q_CI1=='1') { echo "Yes"; } if($Q_CI1=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CI1)) { echo $T_CI1; } ?>
            </div>
            </p>

            <label for="q7"><?php echo $CI_NUM++; ?>. Was the clients gender accurately recorded?</label><br>
            <?php if(isset($Q_CI2)) { if($Q_CI2=='1') { echo "Yes"; } if($Q_CI2=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_CI2)) { echo $T_CI2; } ?>
            </div>
            </p>
            <p>
                <label for="q8"><?php echo $CI_NUM++; ?>. Was the clients date of birth accurately recorded?</label><br>
            <?php if(isset($Q_CI3)) { if($Q_CI3=='1') { echo "Yes"; } if($Q_CI3=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_CI3)) { echo $T_CI3; } ?>
            </div>
            </p>
            </p>

            <p>
                <label for="q9"><?php echo $CI_NUM++; ?>. Was the clients smoking status recorded correctly?</label><br>
            <?php if(isset($Q_CI4)) { if($Q_CI4=='1') { echo "Yes"; } if($Q_CI4=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_CI4)) { echo $T_CI4; } ?>
            </div>
            </p>

            <p>
                <label for="q10"><?php echo $CI_NUM++; ?>. Was the clients employment status recorded correctly?</label><br>
            <?php if(isset($Q_CI5)) { if($Q_CI5=='1') { echo "Yes"; } if($Q_CI5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CI5)) { echo $T_CI5; } ?>
            </div>
            </p>
            </p>

            <p>
                <label for="q11"><?php echo $CI_NUM++; ?>. Did the closer confirm the policy was a single or a joint application?</label><br>
            <?php if(isset($Q_CI6)) { if($Q_CI6=='1') { echo "Yes"; } if($Q_CI6=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CI6)) { echo $T_CI6; } ?>
            </div>


            <h1><b>Identifying Clients Needs</b></h1>
            
                                <?php
                                $ICN_NUM=1;
                                ?>            

            <p>
                <label for="q12"><?php echo $ICN_NUM++; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label><br>
                <?php if(isset($Q_ICN1)) { if($Q_ICN1=='1') { echo "Yes"; } if($Q_ICN1=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_ICN1)) { echo $T_ICN1; } ?>
            </div>
            </p>

            <p>
                <label for="q53"><?php echo $ICN_NUM++; ?>. Did the closer mention waiver, indexation, or TPD?</label><br>
            <?php if(isset($Q_ICN2)) { if($Q_ICN2=='1') { echo "Yes"; } if($Q_ICN2=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_ICN2)) { echo $T_ICN2; } ?>
            </div>
            </p>

            <p>
                <label for="q13"><?php echo $ICN_NUM++; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label><br>
                        <?php if(isset($Q_ICN3)) { if($Q_ICN3=='1') { echo "Yes"; } if($Q_ICN3=='0') { echo "No"; } } ?>

            
            <div class="phpcomments">
                <?php if(isset($T_ICN3)) { echo $T_ICN3; } ?>
            </div>
            </p>

            <p>
                <label for="q14"><?php echo $ICN_NUM++; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label><br>
                            <?php if(isset($Q_ICN4)) { if($Q_ICN4=='1') { echo "More than sufficient"; } if($Q_ICN4=='2') { echo "Sufficient"; } if($Q_ICN4=='3') { echo "Sufficient"; } if($Q_ICN4=='4') { echo "Poor"; } } ?>


            <div class="phpcomments">
                <?php if(isset($T_ICN4)) { echo $T_ICN4; } ?>
            </div>
            </p>

            <p>
                <label for="q15"><?php echo $ICN_NUM++; ?>. Closer confirmed this policy will be set up with Aviva?</label><br>
            <?php if(isset($Q_ICN5)) { if($Q_ICN5=='1') { echo "Yes"; } if($Q_ICN5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_ICN5)) { echo $T_ICN5; } ?>
            </div>
            </p>

            <h1><b>Eligibility</b></h1>
            
                                <?php
                                $E_NUM=1;
                                ?>            

            <p>
                <label for="q55"><?php echo $E_NUM++; ?>. Important customer information declaration?</label><br>
            <?php if(isset($Q_E1)) { if($Q_E1=='1') { echo "Yes"; } if($Q_E1=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E1)) { echo $T_E1; } ?>
            </div>
            </p>

            <p>
                <label for="q17"><?php echo $E_NUM++; ?>. Were all clients contact details recorded correctly?</label><br>
            <?php if(isset($Q_E2)) { if($Q_E2=='1') { echo "Yes"; } if($Q_E2=='0') { echo "No"; } } ?>
                
                
            <div class="phpcomments">
                <?php if(isset($T_E2)) { echo $T_E2; } ?>
            </div>
            </p>



            <p>
                <label for="q16"><?php echo $E_NUM++; ?>. Were all clients address details recorded correctly?</label><br>
            <?php if(isset($Q_E3)) { if($Q_E3=='1') { echo "Yes"; } if($Q_E3=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E3)) { echo $T_E3; } ?>
            </div>
            </p>

            <p>
                <label for="q31"><?php echo $E_NUM++; ?>. Were all doctors details recorded correctly?</label><br>
            <?php if(isset($Q_E4)) { if($Q_E4=='1') { echo "Yes"; } if($Q_E4=='0') { echo "No"; } } ?>
                
                
            <div class="phpcomments">
                <?php if(isset($T_E4)) { echo $T_E4; } ?>
            </div>
            </p>

            <p>
                <label for="q18"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label><br>
            <?php if(isset($Q_E4)) { if($Q_E4=='1') { echo "Yes"; } if($Q_E4=='0') { echo "No"; } } ?>
                
                
            <div class="phpcomments">
                <?php if(isset($T_E5)) { echo $T_E5; } ?>
            </div>
            </p>

            <p>
                <label for="q19"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the hazardous activities questions?</label><br>
            <?php if(isset($Q_E6)) { if($Q_E6=='1') { echo "Yes"; } if($Q_E6=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E6)) { echo $T_E6; } ?>
            </div>
            </p>

            <p>
                <label for="q20"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the height and weight details correctly?</label><br>
            <?php if(isset($Q_E7)) { if($Q_E7=='1') { echo "Yes"; } if($Q_E7=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E7)) { echo $T_E7; } ?>
            </div>
            </p>

            <p>
                <label for="q21"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the smoking details correctly?</label><br>
            <?php if(isset($Q_E8)) { if($Q_E8=='1') { echo "Yes"; } if($Q_E8=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E8)) { echo $T_E8; } ?>
            </div>
            </p>

            <p>
                <label for="q22"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the drug use details correctly?</label><br>
        <?php if(isset($Q_E9)) { if($Q_E9=='1') { echo "Yes"; } if($Q_E9=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E9)) { echo $T_E9; } ?>
            </div>
            </p>

            <p>
                <label for="q23"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the alcohol consumption details correctly?</label><br>
            <?php if(isset($Q_E10)) { if($Q_E10=='1') { echo "Yes"; } if($Q_E10=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E10)) { echo $T_E10; } ?>
            </div>
            </p>

            <p>
                <label for="q24"><?php echo $E_NUM++; ?>. Were all health questions asked and recorded correctly?</label><br>
            <?php if(isset($Q_E11)) { if($Q_E11=='1') { echo "Yes"; } if($Q_E11=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E11)) { echo $T_E11; } ?>
            </div>
            </p>

            <p>
                <label for="q25"><?php echo $E_NUM++; ?>. Were all health in the last two years questions asked and recorded correctly?</label><br>
            <?php if(isset($Q_E12)) { if($Q_E12=='1') { echo "Yes"; } if($Q_E12=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E12)) { echo $T_E12; } ?>
            </div>
            </p>

            <p>
                <label for="q26"><?php echo $E_NUM++; ?>. Were all health continued questions asked and recorded correctly?</label><br>
            <?php if(isset($Q_E11)) { if($Q_E11=='1') { echo "Yes"; } if($Q_E11=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_E13)) { echo $T_E13; } ?>
            </div>
            </p>

            <p>
                <label for="q27"><?php echo $E_NUM++; ?>. Were all family history questions asked and recorded correctly?</label><br>
            <?php if(isset($Q_E14)) { if($Q_E14=='1') { echo "Yes"; } if($Q_E14=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
              <?php if(isset($T_E14)) { echo $T_E14; } ?>
            </div>
            </p>


            <h1><b>Declarations of Insurance</b></h1>
            
                                <?php
                                $DI_NUM=1;
                                ?>             

            <p>
                <label for="q30"><?php echo $DI_NUM++; ?>. Customer declaration read out?</label><br>
            <?php if(isset($Q_DI1)) { if($Q_DI1=='1') { echo "Yes"; } if($Q_DI1=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
               <?php if(isset($T_DI1)) { echo $T_DI1; } ?>
            </div>
            </p>


            <p>
                <label for="q54"><?php echo $DI_NUM++; ?>. If appropriate did the closer confirm the exclusions on the policy?</label><br>
            <?php if(isset($Q_DI2)) { if($Q_DI2=='1') { echo "Yes"; } if($Q_DI2=='0') { echo "No"; } if($Q_DI2=='2') { echo "N/A"; } } ?>

            <div class="phpcomments">
                 <?php if(isset($T_DI2)) { echo $T_DI2; } ?>
            </div>
            </p>

            <h1><b>Payment Information</b></h1>
            
                                <?php
                                $PI_NUM=1;
                                ?>                

            <p>
                <label for="q32"><?php echo $PI_NUM++; ?>. Was the clients policy start date accurately recorded?</label><br>
            <?php if(isset($Q_PI1)) { if($Q_PI1=='1') { echo "Yes"; } if($Q_PI1=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_PI1)) { echo $T_PI1; } ?>
            </div>
            </p>
            <p>
                <label for="q33"><?php echo $PI_NUM++; ?>. Did the closer offer to read the direct debit guarantee?</label><br>
            <?php if(isset($Q_PI2)) { if($Q_PI2=='1') { echo "Yes"; } if($Q_PI2=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_PI2)) { echo $T_PI2; } ?>
            </div>
            </p>

            <p>
                <label for="q34"><?php echo $PI_NUM++; ?>. Did the closer offer a preferred premium collection date?</label><br>
            <?php if(isset($Q_PI3)) { if($Q_PI3=='1') { echo "Yes"; } if($Q_PI3=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_PI3)) { echo $T_PI3; } ?>
            </div>
            </p>

            <p>
                <label for="q35"><?php echo $PI_NUM++; ?>. Did the closer record the bank details correctly?</label><br>
            <?php if(isset($Q_PI4)) { if($Q_PI4=='1') { echo "Yes"; } if($Q_PI4=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_PI4)) { echo $T_PI4; } ?>
            </div>
            </p>

            <p>
                <label for="q36"><?php echo $PI_NUM++; ?>. Did they have consent off the premium payer?</label><br>
            <?php if(isset($Q_PI5)) { if($Q_PI5=='1') { echo "Yes"; } if($Q_PI5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_PI5)) { echo $T_PI5; } ?>
            </div>
            </p>
            </p>

            <h1><b>Consolidation Declaration</b></h1>
            
                                <?php
                                $CD_NUM=1;
                                ?>              

            <p>
                <label for="q38"><?php echo $CD_NUM++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label><br>
        <?php if(isset($Q_CD1)) { if($Q_CD1=='1') { echo "Yes"; } if($Q_CD1=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD1)) { echo $T_CD1; } ?>
            </div>
            </p>

            <p>
                <label for="q39"><?php echo $CD_NUM++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label><br>
        <?php if(isset($Q_CD2)) { if($Q_CD2=='1') { echo "Yes"; } if($Q_CD2=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD2)) { echo $T_CD2; } ?>
            </div>
            </p>

            <p>
                <label for="q40"><?php echo $CD_NUM++; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label><br>
        <?php if(isset($Q_CD3)) { if($Q_CD3=='1') { echo "Yes"; } if($Q_CD3=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD3)) { echo $T_CD3; } ?>
            </div>
            </p>

            <p>
                <label for="q41"><?php echo $CD_NUM++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>
        <?php if(isset($Q_CD4)) { if($Q_CD4=='1') { echo "Yes"; } if($Q_CD4=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
               <?php if(isset($T_CD4)) { echo $T_CD4; } ?>
            </div>
            </p>

            <p>
                <label for="q42"><?php echo $CD_NUM++; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Aviva?</label><br>
            <?php if(isset($Q_CD5)) { if($Q_CD5=='1') { echo "Yes"; } if($Q_CD5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD5)) { echo $T_CD5; } ?>
            </div>
            </p>

            <p>
                <label for="q43"><?php echo $CD_NUM++; ?>. Closer confirmed the check your details procedure?</label><br>
                <?php if(isset($Q_CD6)) { if($Q_CD6=='1') { echo "Yes"; } if($Q_CD6=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD6)) { echo $T_CD6; } ?>
            </div>
            </p>

            <p>
                <label for="q44"><?php echo $CD_NUM++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Aviva will write to them with a more specific date?</label><br>
        <?php if(isset($Q_CD7)) { if($Q_CD7=='1') { echo "Yes"; } if($Q_CD7=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_CD7)) { echo $T_CD7; } ?>
            </div>
            </p>

            <p>
                <label for="q45"><?php echo $CD_NUM++; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label><br>
        <?php if(isset($Q_CD8)) { if($Q_CD8=='1') { echo "Yes"; } if($Q_CD8=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
               <?php if(isset($T_CD8)) { echo $T_CD8; } ?>
            </div>
            </p>

            <h1><b>Quality Control</b></h1>
            
                                <?php
                                $QC_NUM=1;
                                ?>              

            <p>
                <label for="q46"><?php echo $QC_NUM++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Aviva with client information?</label><br>
            <?php if(isset($Q_QC1)) { if($Q_QC1=='1') { echo "Yes"; } if($Q_QC1=='0') { echo "No"; } } ?>

            <div class="phpcomments">
                <?php if(isset($T_QC1)) { echo $T_QC1; } ?>
            </div>
            </p>

            <p>
                <label for="q47"><?php echo $QC_NUM++; ?>. Closer confirmed length of policy in years with client confirmation?</label><br>
        <?php if(isset($Q_QC2)) { if($Q_QC2=='1') { echo "Yes"; } if($Q_QC2=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC2)) { echo $T_QC2; } ?>
            </div>
            </p>
            <p>
                <label for="q48"><?php echo $QC_NUM++; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label><br>
        <?php if(isset($Q_QC3)) { if($Q_QC3=='1') { echo "Yes"; } if($Q_QC3=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC3)) { echo $T_QC3; } ?>
            </div>
            </p>

            <p>
                <label for="q49"><?php echo $QC_NUM++; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label><br>
        <?php if(isset($Q_QC4)) { if($Q_QC4=='1') { echo "Yes"; } if($Q_QC4=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC4)) { echo $T_QC4; } ?>
            </div>
            </p>

            <p>
                <label for="q50"><?php echo $QC_NUM++; ?>. Did the customer give their explicit consent for the policy to be set up?</label><br>
        <?php if(isset($Q_QC5)) { if($Q_QC5=='1') { echo "Yes"; } if($Q_QC5=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC5)) { echo $T_QC5; } ?>
            </div>
            </p>

            <p>
                <label for="q51"><?php echo $QC_NUM++; ?>. Closer provided contact details for Bluestone Protect?</label><br>
        <?php if(isset($Q_QC6)) { if($Q_QC6=='1') { echo "Yes"; } if($Q_QC6=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC6)) { echo $T_QC6; } ?>
            </div>
            </p>

            <p>
                <label for="q52"><?php echo $QC_NUM++; ?>.  Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label><br>
        <?php if(isset($Q_QC7)) { if($Q_QC7=='1') { echo "Yes"; } if($Q_QC7=='0') { echo "No"; } } ?>
                
            <div class="phpcomments">
                <?php if(isset($T_QC7)) { echo $T_QC7; } ?>
            </div>
            </p>

            </form>
            </fieldset>


        </div>
    </div>

    <script src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script> 
</body>
</html>
