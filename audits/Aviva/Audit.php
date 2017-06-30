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

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$AUDITID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE) && $EXECUTE=='EDIT' && isset($AUDITID)) {
    
    require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
    
    $SELECT1 = $pdo->prepare("SELECT 
    aviva_audit_grade, aviva_audit_policy, aviva_audit_closer
FROM
    aviva_audit
WHERE
    aviva_audit_id =:AID");
    $SELECT1->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    
    $SELECT2 = $pdo->prepare("SELECT 
    aviva_ques_od1, aviva_ques_od2, aviva_ques_od3, aviva_ques_od4, aviva_ques_od5, aviva_ques_ci1, aviva_ques_ci2, aviva_ques_ci3, aviva_ques_ci4, aviva_ques_ci5, aviva_ques_ci6, aviva_ques_icn1, aviva_ques_icn2, aviva_ques_icn3, aviva_ques_icn4, aviva_ques_icn5, aviva_ques_icn6
FROM
    aviva_ques
WHERE
    aviva_ques_id_fk =:AID");
    $SELECT2->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    $SELECT3->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    $SELECT4->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    $SELECT5->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    $SELECT6->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
    $SELECT7->bindParam(':AID', $AUDITID, PDO::PARAM_INT);
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
<html lang="en">
    <title>ADL | Aviva Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layout.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

    <?php require_once(__DIR__ . '/../../php/Holidays.php');?>
</head>
<body>
    <?php require_once(__DIR__ . '/../../includes/NAV.php');?><br>

    <div class="container-fluid">
        <div class="row">
        <div class="col-3"></div>
        
        
        <div class="col-6">

        <div class="card">
            <div class="card-header p-b-0 card-primary">
                <center><h1 class="card-title">
                    <i class="fa fa-headphones" aria-hidden="true"></i>
                    Aviva Call Audit
                    </h1></center>
            </div>
            <div class="card-block">
                
                 <div class="row">
                            <article class="col-12">
                               <center> <h2 class="alert-info">Audit Details</h2></center>
                               <form method="POST" action="php/Audit.php?EXECUTE=<?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "2&AID=$AUDITID"; } else { echo "1"; } ?>">
                                   
                <div class="form-group row">
                    <label for="CLOSER" class="col-2 col-form-label">Closer</label>
                    <div class="col-3">
                        <select class="form-control" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT' && isset($AUDITID)) { } else { ?>id="CLOSER" <?php } ?> name="CLOSER" required>
                            <?php if(isset($EXECUTE) && $EXECUTE=='EDIT' && isset($AUDITID)) { ?>
                             <option value='<?php echo $CLOSER; ?>'><?php echo $CLOSER; ?></option>
<?php if ($companynamere == 'Bluestone Protect') { ?>

                                            <option value="Carys">Carys</option>
                                            <option value="Hayley">Hayley</option>
                                            <option value="James">James</option>
                                            <option value="Kyle">Kyle</option>  
                                            <option value="Mike">Mike</option> 
                                            <option value="Nathan">Nathan</option> 
                                            <option value="Richard">Richard</option>
                                            <option value="Ricky">Ricky</option> 
                                            <option value="Sarah">Sarah</option>
                                            <option value="Stavros">Stavros</option>
                                            <option value="Nicola">Nicola</option>  
                                            <option value="Gavin">Gavin</option>
                                            <option value="Rhys">Rhys</option> 
                                            <option value="David">David</option> 
<?php } if ($companynamere == 'ADL_CUS') { ?>
                                            <option value="Dan Matthews">Dan Matthews</option>
                                            <option value="Joe Rimmell">Joe Rimmell</option>
                                            <option value="Jordan Davies">Jordan Davies</option>
                                            <option value="Matthew Brace">Matthew Brace</option>  
                                            <option value="Sam Morris">Sam Morris</option> 
                                            <option value="Steve Pattin">Steve Pattin</option> 
                                            <option value="James Keen">James Keen</option> 
<?php } ?>                             
                            <?php } else { ?>
                            <option value="">Closer</option>
                            <?php } ?>
                        </select>      
                    </div>
                </div>        <br>                             
             
                <div class="form-group row">
                    <label for="POLICY" class="col-2 col-form-label">Policy:</label>
                    <div class="col-8">
                        <input class="form-control" type="text" id="POLICY" name="POLICY" value="<?php if(isset($POLICY)) { echo $POLICY; } ?>">
                    </div>
                </div> 
             
                <div class="form-group row">
                    <label for="GRADE" class="col-2 col-form-label">Grade</label>
                    <div class="col-3">
                        <select class="form-control" id="GRADE" name="GRADE" required>
                            <option value="">Select Grade</option>
                            <option <?php if(isset($GRADE) && $GRADE=='Green') { echo "selected"; } ?> value="Green">Green</option>
                            <option <?php if(isset($GRADE) && $GRADE=='Red') { echo "selected"; } ?> value="Red">Red</option>
                            <option <?php if(isset($GRADE) && $GRADE=='Amber') { echo "selected"; } ?> value ="Amber">Amber</option>
                        </select>      
                    </div>
                </div>   
                            </article>
                 </div><!--AUDIT DETAILS -->
                
                <div class="row">
                    <article class="col-12">
                                <center><h2 class="alert-info">Opening Declaration</h2></center>
                     
                                <?php
                                $OD_NUM=1;
                                ?>
                                
                <div class="form-group">
                    <label for="OD1"><?php echo $OD_NUM++; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
                    <div class="col-2">    
                    <select class="form-control" id="OD1" name="OD1" onchange="java_script_:showTOD1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_OD1) && $Q_OD1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_OD1) && $Q_OD1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div>  
                                
                                <div id="TOD1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TOD1" class="form-control"><?php if(isset($T_OD1)) { echo $T_OD1; } ?> </textarea>
                                </div>                
                          
                                
                <div class="form-group">
                    <label for="OD2"><?php echo $OD_NUM++; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
                    <div class="col-2">    
                    <select class="form-control" id="OD2" name="OD2" onchange="java_script_:showTOD2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_OD2) && $Q_OD2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_OD2) && $Q_OD2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TOD2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TOD2" class="form-control"> <?php if(isset($T_OD2)) { echo $T_OD2; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="OD3"><?php echo $OD_NUM++; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
                    <div class="col-2">    
                    <select class="form-control" id="OD3" name="OD3" onchange="java_script_:showTOD3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_OD3) && $Q_OD3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_OD3) && $Q_OD3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TOD3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?> onchange="java_script_:show(this.options[this.selectedIndex].value)">
                                    <textarea name="TOD3" class="form-control"> <?php if(isset($T_OD3)) { echo $T_OD3; } ?> </textarea>
                                </div>                                   
                                

                <div class="form-group">
                    <label for="OD4"><?php echo $OD_NUM++; ?>. Did the closer provide the name and details of the firm who is regulated by the FCA?</label>
                    <div class="col-2">    
                    <select class="form-control" id="OD4" name="OD4"  onchange="java_script_:showTOD4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_OD4) && $Q_OD4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_OD4) && $Q_OD4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TOD4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TOD4" class="form-control"> <?php if(isset($T_OD4)) { echo $T_OD4; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="OD5"><?php echo $OD_NUM++; ?>. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
                    <div class="col-2">    
                    <select class="form-control" id="OD5" name="OD5" onchange="java_script_:showTOD5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_OD5) && $Q_OD5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_OD5) && $Q_OD5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>    
                                
                                <div id="TOD5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TOD5" class="form-control"> <?php if(isset($T_OD5)) { echo $T_OD5; } ?> </textarea>
                                </div>                                   
                                
<script>
function showTOD1(select_item) {
    if(select_item === "0") {
        TOD1.style.display='block';
    }
    else {
        TOD1.style.display='none';
    }
}
function showTOD2(select_item) {
    if(select_item === "0") {
        TOD2.style.display='block';
    }
    else {
        TOD2.style.display='none';
    }
}
function showTOD3(select_item) {
    if(select_item === "0") {
        TOD3.style.display='block';
    }
    else {
        TOD3.style.display='none';
    }
}
function showTOD4(select_item) {
    if(select_item === "0") {
        TOD4.style.display='block';
    }
    else {
        TOD4.style.display='none';
    }
}
function showTOD5(select_item) {
    if(select_item === "0") {
        TOD5.style.display='block';
    }
    else {
        TOD5.style.display='none';
    }
}
</script>                                   
                                
                            </article>
 </div><!--Opening Declaration-->
                
                <div class="row">
                            <article class="col-12">
                                <center> <h2 class="alert-info">Customer Information</h2></center>
                     
                                <?php
                                $CI_NUM=1;
                                ?>
                                
                <div class="form-group">
                    <label for="CI1"><?php echo $CI_NUM++; ?>. Were all clients titles and names recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI1" name="CI1" onchange="java_script_:showTCI1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI1) && $Q_CI1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI1) && $Q_CI1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div> 
                                
                                <div id="TCI1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI1" class="form-control"> <?php if(isset($T_CI1)) { echo $T_CI1; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="CI2"><?php echo $CI_NUM++; ?>. Was the clients gender accurately recorded?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI2" name="CI2" onchange="java_script_:showTCI2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI2) && $Q_CI2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI2) && $Q_CI2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                               
                                <div id="TCI2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI2" class="form-control"> <?php if(isset($T_CI2)) { echo $T_CI2; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CI3"><?php echo $CI_NUM++; ?>. Was the clients date of birth accurately recorded?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI3" name="CI3" onchange="java_script_:showTCI3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI3) && $Q_CI3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI3) && $Q_CI3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TCI3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI3" class="form-control"> <?php if(isset($T_CI3)) { echo $T_CI3; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CI4"><?php echo $CI_NUM++; ?>. Was the clients smoking status recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI4" name="CI4" onchange="java_script_:showTCI4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI4) && $Q_CI4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI4) && $Q_CI4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TCI4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI4" class="form-control"> <?php if(isset($T_CI4)) { echo $T_CI4; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CI5"><?php echo $CI_NUM++; ?>. Was the clients employment status recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI5" name="CI5" onchange="java_script_:showTCI5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI5) && $Q_CI5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI5) && $Q_CI5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                 <div id="TCI5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI5" class="form-control"> <?php if(isset($T_CI5)) { echo $T_CI5; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="CI6"><?php echo $CI_NUM++; ?>. Did the closer confirm the policy was a single or a joint application?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CI6" name="CI6" onchange="java_script_:showTCI6(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CI6) && $Q_CI6=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CI6) && $Q_CI6=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>      
                                
                                <div id="TCI6"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCI6" class="form-control"> <?php if(isset($T_CI6)) { echo $T_CI6; } ?> </textarea>
                                </div>                                  
                                
<script>
function showTCI1(select_item) {
    if(select_item === "0") {
        TCI1.style.display='block';
    }
    else {
        TCI1.style.display='none';
    }
}
function showTCI2(select_item) {
    if(select_item === "0") {
        TCI2.style.display='block';
    }
    else {
        TCI2.style.display='none';
    }
}
function showTCI3(select_item) {
    if(select_item === "0") {
        TCI3.style.display='block';
    }
    else {
        TCI3.style.display='none';
    }
}
function showTCI4(select_item) {
    if(select_item === "0") {
        TCI4.style.display='block';
    }
    else {
        TCI4.style.display='none';
    }
}
function showTCI5(select_item) {
    if(select_item === "0") {
        TCI5.style.display='block';
    }
    else {
        TCI5.style.display='none';
    }
}
function showTCI6(select_item) {
    if(select_item === "0") {
        TCI6.style.display='block';
    }
    else {
        TCI6.style.display='none';
    }
}
</script>                                  
                                
                            </article>
                </div>
                                
                
                <div class="row">
                            <article class="col-12">
                                <center> <h2 class="alert-info">Identifying Client Needs</h2></center>
                     
                                <?php
                                $ICN_NUM=1;
                                ?>
                                
                <div class="form-group">
                    <label for="ICN1"><?php echo $ICN_NUM++; ?>. Did the closer check all details of what the client has with their existing life insurance policy?</label>
                    <div class="col-2">    
                    <select class="form-control" id="ICN1" name="ICN1" onchange="java_script_:showTICN1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_ICN1) && $Q_ICN1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_ICN1) && $Q_ICN1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div> 
                                
                                <div id="TICN1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TICN1" class="form-control"> <?php if(isset($T_ICN1)) { echo $T_ICN1; } ?> </textarea>
                                </div>                                     

                <div class="form-group">
                    <label for="ICN2"><?php echo $ICN_NUM++; ?>. Did the closer mention waiver, indexation, or TPD?</label>
                    <div class="col-2">    
                    <select class="form-control" id="ICN2" name="ICN2" onchange="java_script_:showTICN2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_ICN2) && $Q_ICN2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_ICN2) && $Q_ICN2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TICN2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TICN2" class="form-control"> <?php if(isset($T_ICN2)) { echo $T_ICN2; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="ICN3"><?php echo $ICN_NUM++; ?>. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
                    <div class="col-2">    
                    <select class="form-control" id="ICN3" name="ICN3" onchange="java_script_:showTICN3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_ICN3) && $Q_ICN3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_ICN3) && $Q_ICN3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TICN3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TICN3" class="form-control"> <?php if(isset($T_ICN3)) { echo $T_ICN3; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="ICN4"><?php echo $ICN_NUM++; ?>. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label>
                    <div class="col-2">    
                    <select class="form-control" id="ICN4" name="ICN4" onchange="java_script_:showTICN4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_ICN4) && $Q_ICN4=='1') { echo "selected"; } ?> value="1">More than sufficient</option>
                            <option <?php if(isset($Q_ICN4) && $Q_ICN4=='2') { echo "selected"; } ?> value="2">Sufficient</option>
                            <option <?php if(isset($Q_ICN4) && $Q_ICN4=='3') { echo "selected"; } ?> value="3">Adequate</option>
                            <option <?php if(isset($Q_ICN4) && $Q_ICN4=='4') { echo "selected"; } ?> value="4">Poor</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TICN4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TICN4" class="form-control"> <?php if(isset($T_ICN4)) { echo $T_ICN4; } ?> </textarea>
                                </div>                                   

                <div class="form-group">
                    <label for="ICN5"><?php echo $ICN_NUM++; ?>. Closer confirmed this policy will be set up with Aviva?</label>
                    <div class="col-2">    
                    <select class="form-control" id="ICN5" name="ICN5" onchange="java_script_:showTICN5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_ICN5) && $Q_ICN5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_ICN5) && $Q_ICN5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TICN5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TICN5" class="form-control"> <?php if(isset($T_ICN5)) { echo $T_ICN5; } ?> </textarea>
                                </div>                                   
                                
<script>
function showTICN1(select_item) {
    if(select_item === "0") {
        TICN1.style.display='block';
    }
    else {
        TICN1.style.display='none';
    }
}
function showTICN2(select_item) {
    if(select_item === "0") {
        TICN2.style.display='block';
    }
    else {
        TICN2.style.display='none';
    }
}
function showTICN3(select_item) {
    if(select_item === "0") {
        TICN3.style.display='block';
    }
    else {
        TICN3.style.display='none';
    }
}
function showTICN4(select_item) {
    if(select_item === "4") {
        TICN4.style.display='block';
    }
    else {
        TICN4.style.display='none';
    }
}
function showTICN5(select_item) {
    if(select_item === "0") {
        TICN5.style.display='block';
    }
    else {
        TICN5.style.display='none';
    }
}
</script>                                 
                                
                            </article>
                </div><!-- Identifying Client Needs -->

                <div class="row">
                            <article class="col-12">
                                <center> <h2 class="alert-info">Eligibility</h2></center>
                     
                                <?php
                                $E_NUM=1;
                                ?>
                                
                <div class="form-group">
                    <label for="E1"><?php echo $E_NUM++; ?>. Important customer information declaration?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E1" name="E1" onchange="java_script_:showTE1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E1) && $Q_E1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E1) && $Q_E1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div>   
                                
                                <div id="TE1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE1" class="form-control"> <?php if(isset($T_E1)) { echo $T_E1; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E2"><?php echo $E_NUM++; ?>. Were all clients contact details recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E2" name="E2" onchange="java_script_:showTE2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E2) && $Q_E2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E2) && $Q_E2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TE2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE2" class="form-control"> <?php if(isset($T_E2)) { echo $T_E2; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E3"><?php echo $E_NUM++; ?>. Were all clients address details recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E3" name="E3" onchange="java_script_:showTE3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E3) && $Q_E3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E3) && $Q_E3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TE3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE3" class="form-control"> <?php if(isset($T_E3)) { echo $T_E3; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E4"><?php echo $E_NUM++; ?>. Were all doctors details recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E4" name="E4" onchange="java_script_:showTE4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E4) && $Q_E4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E4) && $Q_E4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TE4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE4" class="form-control"> <?php if(isset($T_E4)) { echo $T_E4; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E5"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the work and travel questions correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E5" name="E5" onchange="java_script_:showTE5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E5) && $Q_E5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E5) && $Q_E5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TE5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE5" class="form-control"> <?php if(isset($T_E5)) { echo $T_E5; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E6"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the hazardous activities questions?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E6" name="E6" onchange="java_script_:showTE6(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E6) && $Q_E6=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E6) && $Q_E6=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TE6"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE6" class="form-control"> <?php if(isset($T_E6)) { echo $T_E6; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E7"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the height and weight details correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E7" name="E7" onchange="java_script_:showTE7(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E7) && $Q_E7=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E7) && $Q_E7=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TE7"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE7" class="form-control"> <?php if(isset($T_E7)) { echo $T_E7; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="E8"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the smoking details correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E8" name="E8" onchange="java_script_:showTE8(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E8) && $Q_E8=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E8) && $Q_E8=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>    
                                
                                <div id="TE8"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE8" class="form-control"> <?php if(isset($T_E8)) { echo $T_E8; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E9"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the drug use details correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E9" name="E9" onchange="java_script_:showTE9(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E9) && $Q_E9=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E9) && $Q_E9=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TE9"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE9" class="form-control"> <?php if(isset($T_E9)) { echo $T_E9; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E10"><?php echo $E_NUM++; ?>. Did the closer ask and accurately record the alcohol consumption details correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E10" name="E10" onchange="java_script_:showTE10(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E10) && $Q_E10=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E10) && $Q_E10=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TE10"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE10" class="form-control"> <?php if(isset($T_E10)) { echo $T_E10; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E11"><?php echo $E_NUM++; ?>. Were all health questions asked and recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E11" name="E11" onchange="java_script_:showTE11(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E11) && $Q_E11=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E11) && $Q_E11=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TE11"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE11" class="form-control"> <?php if(isset($T_E11)) { echo $T_E11; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E12"><?php echo $E_NUM++; ?>. Were all health in the last two years questions asked and recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E12" name="E12" onchange="java_script_:showTE12(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E12) && $Q_E12=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E12) && $Q_E12=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 

                                <div id="TE12"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE12" class="form-control"> <?php if(isset($T_E12)) { echo $T_E12; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E13"><?php echo $E_NUM++; ?>. Were all health continued questions asked and recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E13" name="E13" onchange="java_script_:showTE13(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E13) && $Q_E13=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E13) && $Q_E13=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>     
                                
                                <div id="TE13"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE13" class="form-control"> <?php if(isset($T_E13)) { echo $T_E13; } ?> </textarea>
                                </div>                                 
                                
                <div class="form-group">
                    <label for="E14"><?php echo $E_NUM++; ?>. Were all family history questions asked and recorded correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="E14" name="E14" onchange="java_script_:showTE14(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_E14) && $Q_E14=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_E14) && $Q_E14=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TE14"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TE14" class="form-control"> <?php if(isset($T_E14)) { echo $T_E14; } ?> </textarea>
                                </div>  
                                
<script>
function showTE1(select_item) {
    if(select_item === "0") {
        TE1.style.display='block';
    }
    else {
        TE1.style.display='none';
    }
}
function showTE2(select_item) {
    if(select_item === "0") {
        TE2.style.display='block';
    }
    else {
        TE2.style.display='none';
    }
}
function showTE3(select_item) {
    if(select_item === "0") {
        TE3.style.display='block';
    }
    else {
        TE3.style.display='none';
    }
}
function showTE4(select_item) {
    if(select_item === "0") {
        TE4.style.display='block';
    }
    else {
        TE4.style.display='none';
    }
}
function showTE5(select_item) {
    if(select_item === "0") {
        TE5.style.display='block';
    }
    else {
        TE5.style.display='none';
    }
}
function showTE6(select_item) {
    if(select_item === "0") {
        TE6.style.display='block';
    }
    else {
        TE6.style.display='none';
    }
}
function showTE7(select_item) {
    if(select_item === "0") {
        TE7.style.display='block';
    }
    else {
        TE7.style.display='none';
    }
}
function showTE8(select_item) {
    if(select_item === "0") {
        TE8.style.display='block';
    }
    else {
        TE8.style.display='none';
    }
}
function showTE9(select_item) {
    if(select_item === "0") {
        TE9.style.display='block';
    }
    else {
        TE9.style.display='none';
    }
}
function showTE10(select_item) {
    if(select_item === "0") {
        TE10.style.display='block';
    }
    else {
        TE10.style.display='none';
    }
}
function showTE11(select_item) {
    if(select_item === "0") {
        TE11.style.display='block';
    }
    else {
        TE11.style.display='none';
    }
}
function showTE12(select_item) {
    if(select_item === "0") {
        TE12.style.display='block';
    }
    else {
        TE12.style.display='none';
    }
}
function showTE13(select_item) {
    if(select_item === "0") {
        TE13.style.display='block';
    }
    else {
        TE13.style.display='none';
    }
}
function showTE14(select_item) {
    if(select_item === "0") {
        TE14.style.display='block';
    }
    else {
        TE14.style.display='none';
    }
}
</script>                                  
                                
                            </article>
                </div><!--Eligibility-->                
                
                 <div class="row">
                            <article class="col-12">
                                <center><h2 class="alert-info">Declarations of Insurance</h2> </center>
                                
                                <?php
                                $DI_NUM=1;
                                ?>                                
                                
                 <div class="form-group">
                    <label for="DI1"><?php echo $DI_NUM++; ?>. Customer declaration read out?</label>
                    <div class="col-2">    
                    <select class="form-control" id="DI1" name="DI1" onchange="java_script_:showDI1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_DI1) && $Q_DI1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_DI1) && $Q_DI1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div>   
                                
                                <div id="TDI1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TDI1" class="form-control"> <?php if(isset($T_DI1)) { echo $T_DI1; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="DI2"><?php echo $DI_NUM++; ?>. If appropriate did the closer confirm the exclusions on the policy?</label>
                    <div class="col-2">    
                    <select class="form-control" id="DI2" name="DI2" onchange="java_script_:showDI2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_DI2) && $Q_DI2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_DI2) && $Q_DI2=='0') { echo "selected"; } ?> value="0">No</option>
                            <option <?php if(isset($Q_DI2) && $Q_DI2=='2') { echo "selected"; } ?> value="2">N/A</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TDI2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TDI2" class="form-control"> <?php if(isset($T_DI2)) { echo $T_DI2; } ?> </textarea>
                                </div>   

<script>
function showDI1(select_item) {
    if(select_item === "0") {
        TDI1.style.display='block';
    }
    else {
        TDI1.style.display='none';
    }
}
function showDI2(select_item) {
    if(select_item === "0") {
        TDI2.style.display='block';
    }
    else {
        TDI2.style.display='none';
    }
}                                
</script>                                
                            </article>
                     </div><!--Declarations of Insurnace-->                 
                
                 <div class="row">
                            <article class="col-12">
                                <center><h2 class="alert-info">Payment Information</h2> </center>
                                
                                <?php
                                $PI_NUM=1;
                                ?>                                
                                
                 <div class="form-group">
                    <label for="PI1"><?php echo $PI_NUM++; ?>. Was the clients policy start date accurately recorded?</label>
                    <div class="col-2">    
                    <select class="form-control" id="PI1" name="PI1" onchange="java_script_:showPI1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_PI1) && $Q_PI1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_PI1) && $Q_PI1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div> 
                                
                                <div id="TPI1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?> >
                                    <textarea name="TPI1" class="form-control"> <?php if(isset($T_PI1)) { echo $T_PI1; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="PI2"><?php echo $PI_NUM++; ?>. Did the closer offer to read the direct debit guarantee?</label>
                    <div class="col-2">    
                    <select class="form-control" id="PI2" name="PI2" onchange="java_script_:showPI2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_PI2) && $Q_PI2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_PI2) && $Q_PI2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TPI2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TPI2" class="form-control"> <?php if(isset($T_PI2)) { echo $T_PI2; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="PI3"><?php echo $PI_NUM++; ?>. Did the closer offer a preferred premium collection date?</label>
                    <div class="col-2">    
                    <select class="form-control" id="PI3" name="PI3" onchange="java_script_:showPI3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_PI3) && $Q_PI3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_PI3) && $Q_PI3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TPI3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TPI3" class="form-control"> <?php if(isset($T_PI3)) { echo $T_PI3; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="PI4"><?php echo $PI_NUM++; ?>. Did the closer record the bank details correctly?</label>
                    <div class="col-2">    
                    <select class="form-control" id="PI4" name="PI4" onchange="java_script_:showPI4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_PI4) && $Q_PI4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_PI4) && $Q_PI4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TPI4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TPI4" class="form-control"> <?php if(isset($T_PI4)) { echo $T_PI4; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="PI5"><?php echo $PI_NUM++; ?>. Did they have consent off the premium payer?</label>
                    <div class="col-2">    
                    <select class="form-control" id="PI5" name="PI5" onchange="java_script_:showPI5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_PI5) && $Q_PI5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_PI5) && $Q_PI5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TPI5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TPI5" class="form-control"> <?php if(isset($T_PI5)) { echo $T_PI5; } ?> </textarea>
                                </div>                                 

<script>
function showPI1(select_item) {
    if(select_item === "0") {
        TPI1.style.display='block';
    }
    else {
        TPI1.style.display='none';
    }
}
function showPI2(select_item) {
    if(select_item === "0") {
        TPI2.style.display='block';
    }
    else {
        TPI2.style.display='none';
    }
}
function showPI3(select_item) {
    if(select_item === "0") {
        TPI3.style.display='block';
    }
    else {
        TPI3.style.display='none';
    }
}
function showPI4(select_item) {
    if(select_item === "0") {
        TPI4.style.display='block';
    }
    else {
        TPI4.style.display='none';
    }
}
function showPI5(select_item) {
    if(select_item === "0") {
        TPI5.style.display='block';
    }
    else {
        TPI5.style.display='none';
    }
}
</script>
                                
                            </article>
                     </div><!--Payment Information-->                 
                
                 <div class="row">
                            <article class="col-12">
                                <center><h2 class="alert-info">Consolidation Declaration</h2> </center>
                                
                                <?php
                                $CD_NUM=1;
                                ?>                                
                                
                 <div class="form-group">
                    <label for="CD1"><?php echo $CD_NUM++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD1" name="CD1" onchange="java_script_:showTCD1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD1) && $Q_CD1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD1) && $Q_CD1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div>
                                
                                <div id="TCD1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD1" class="form-control"> <?php if(isset($T_CD1)) { echo $T_CD1; } ?> </textarea>
                                </div>                                 

                <div class="form-group">
                    <label for="CD2"><?php echo $CD_NUM++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD2" name="CD2" onchange="java_script_:showTCD2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD2) && $Q_CD2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD2) && $Q_CD2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TCD2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD2" class="form-control"> <?php if(isset($T_CD2)) { echo $T_CD2; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CD3"><?php echo $CD_NUM++; ?>. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD3" name="CD3" onchange="java_script_:showTCD3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD3) && $Q_CD3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD3) && $Q_CD3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div> 
                                
                                <div id="TCD3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD3" class="form-control"> <?php if(isset($T_CD3)) { echo $T_CD3; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CD4"><?php echo $CD_NUM++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD4" name="CD4" onchange="java_script_:showTCD4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD4) && $Q_CD4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD4) && $Q_CD4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TCD4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD4" class="form-control"> <?php if(isset($T_CD4)) { echo $T_CD4; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CD5"><?php echo $CD_NUM++; ?>. Did the closer confirm that the customer will be getting a 'my account' email from Aviva?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD5" name="CD5" onchange="java_script_:showTCD5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>
                                
                                <div id="TCD5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD5" class="form-control"> <?php if(isset($T_CD5)) { echo $T_CD5; } ?> </textarea>
                                </div>                                  
                                
                <div class="form-group">
                    <label for="CD6"><?php echo $CD_NUM++; ?>. Closer confirmed the check your details procedure?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD6" name="CD6" onchange="java_script_:showTCD6(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TCD6"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD6" class="form-control"> <?php if(isset($T_CD6)) { echo $T_CD6; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="CD7"><?php echo $CD_NUM++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Aviva will write to them with a more specific date?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD7" name="CD7" onchange="java_script_:showTCD7(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD5) && $Q_CD5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>      
                                
                                <div id="TCD7"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD7" class="form-control"> <?php if(isset($T_CD7)) { echo $T_CD7; } ?> </textarea>
                                </div>                                  
 
                <div class="form-group">
                    <label for="CD8"><?php echo $CD_NUM++; ?>. Did the closer confirm to the customer to cancel any existing direct debit?</label>
                    <div class="col-2">    
                    <select class="form-control" id="CD8" name="CD8" onchange="java_script_:showTCD8(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_CD8) && $Q_CD8=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_CD8) && $Q_CD8=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>       
 
                                <div id="TCD8"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TCD8" class="form-control"> <?php if(isset($T_CD8)) { echo $T_CD8; } ?> </textarea>
                                </div>                                  

<script>
function showTCD1(select_item) {
    if(select_item === "0") {
        TCD1.style.display='block';
    }
    else {
        TCD1.style.display='none';
    }
}
function showTCD2(select_item) {
    if(select_item === "0") {
        TCD2.style.display='block';
    }
    else {
        TCD2.style.display='none';
    }
}
function showTCD3(select_item) {
    if(select_item === "0") {
        TCD3.style.display='block';
    }
    else {
        TCD3.style.display='none';
    }
}
function showTCD4(select_item) {
    if(select_item === "0") {
        TCD4.style.display='block';
    }
    else {
        TCD4.style.display='none';
    }
}
function showTCD5(select_item) {
    if(select_item === "0") {
        TCD5.style.display='block';
    }
    else {
        TCD5.style.display='none';
    }
}
function showTCD6(select_item) {
    if(select_item === "0") {
        TCD6.style.display='block';
    }
    else {
        TCD6.style.display='none';
    }
}
function showTCD7(select_item) {
    if(select_item === "0") {
        TCD7.style.display='block';
    }
    else {
        TCD7.style.display='none';
    }
}
function showTCD8(select_item) {
    if(select_item === "0") {
        TCD8.style.display='block';
    }
    else {
        TCD8.style.display='none';
    }
}                                
</script>
                            </article>
                     </div><!--Consolidation Declaration-->                
                
                 <div class="row">
                            <article class="col-12">
                                <center>  <h2 class="alert-info">Quality Control</h2> </center>
                                
                                <?php
                                $QC_NUM=1;
                                ?>                                
                                
                 <div class="form-group">
                    <label for="QC1"><?php echo $QC_NUM++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Aviva with client information?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC1" name="QC1" onchange="java_script_:showTQC1(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC1) && $Q_QC1=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC1) && $Q_QC1=='0') { echo "selected"; } ?> value="0">No</option>
                        </select>  
                    </div>
                </div>  
                                
                                <div id="TQC1"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC1" class="form-control"> <?php if(isset($T_QC1)) { echo $T_QC1; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="QC2"><?php echo $QC_NUM++; ?>. Closer confirmed length of policy in years with client confirmation?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC2" name="QC2" onchange="java_script_:showTQC2(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC2) && $Q_QC2=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC2) && $Q_QC2=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TQC2"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC2" class="form-control"> <?php if(isset($T_QC2)) { echo $T_QC2; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="QC3"><?php echo $QC_NUM++; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC3" name="QC3" onchange="java_script_:showTQC3(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC3) && $Q_QC3=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC3) && $Q_QC3=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>   
                                
                                <div id="TQC3"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC3" class="form-control"> <?php if(isset($T_QC3)) { echo $T_QC3; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="QC4"><?php echo $QC_NUM++; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC4" name="QC4" onchange="java_script_:showTQC4(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC4) && $Q_QC4=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC4) && $Q_QC4=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>
                                
                                <div id="TQC4"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC4" class="form-control"> <?php if(isset($T_QC4)) { echo $T_QC4; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="QC5"><?php echo $QC_NUM++; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC5" name="QC5" onchange="java_script_:showTQC5(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC5) && $Q_QC5=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC5) && $Q_QC5=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>
                                
                                <div id="TQC5"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC5" class="form-control"> <?php if(isset($T_QC5)) { echo $T_QC5; } ?> </textarea>
                                </div>                                  
                                
                <div class="form-group">
                    <label for="QC6"><?php echo $QC_NUM++; ?>. Closer provided contact details for Bluestone Protect?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC6" name="QC6" onchange="java_script_:showTQC6(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC6) && $Q_QC6=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC6) && $Q_QC6=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>    
                                
                                <div id="TQC6"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC6" class="form-control"> <?php if(isset($T_QC6)) { echo $T_QC6; } ?> </textarea>
                                </div>                                  

                <div class="form-group">
                    <label for="QC7"><?php echo $QC_NUM++; ?>.  Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
                    <div class="col-2">    
                    <select class="form-control" id="QC7" name="QC7" onchange="java_script_:showTQC7(this.options[this.selectedIndex].value)">
                            <option value=""></option>
                            <option <?php if(isset($Q_QC7) && $Q_QC7=='1') { echo "selected"; } ?> value="1">Yes</option>
                            <option <?php if(isset($Q_QC7) && $Q_QC7=='0') { echo "selected"; } ?> value="0">No</option>
                    </select>
                    </div>
                </div>  
                                
                                <div id="TQC7"class="form-group" <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
                                    <textarea name="TQC7" class="form-control"> <?php if(isset($T_QC7)) { echo $T_QC7; } ?> </textarea>
                                </div>                                  

<script>
function showTQC1(select_item) {
    if(select_item === "0") {
        TQC1.style.display='block';
    }
    else {
        TQC1.style.display='none';
    }
}
function showTQC2(select_item) {
    if(select_item === "0") {
        TQC2.style.display='block';
    }
    else {
        TQC2.style.display='none';
    }
}
function showTQC3(select_item) {
    if(select_item === "0") {
        TQC3.style.display='block';
    }
    else {
        TQC3.style.display='none';
    }
}
function showTQC4(select_item) {
    if(select_item === "0") {
        TQC4.style.display='block';
    }
    else {
        TQC4.style.display='none';
    }
}
function showTQC5(select_item) {
    if(select_item === "0") {
        TQC5.style.display='block';
    }
    else {
        TQC5.style.display='none';
    }
}
function showTQC6(select_item) {
    if(select_item === "0") {
        TQC6.style.display='block';
    }
    else {
        TQC6.style.display='none';
    }
}
function showTQC7(select_item) {
    if(select_item === "0") {
        TQC7.style.display='block';
    }
    else {
        TQC7.style.display='none';
    }
}
</script>
                            </article>
                     </div>
                    <div class="form-group">
                        <?php if(isset($EXECUTE) && $EXECUTE=='EDIT') {  ?>
<button type="submit" class="btn btn-warning form-control">Update Audit</button>                        
                        <?php } else { ?>
<button type="submit" class="btn btn-primary form-control">Finish Audit</button>
                        <?php } ?>
                    </form>  
    </div>
            </div>
        </div>
            
           

    </div>
        </div>
    </div>
    
    <div class="col-3"></div>

    <script src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>    
                                    <script type="text/JavaScript">
                                    var $select = $('#CLOSER');
                                    $.getJSON('/JSON/CloserNames.json', 
                                    function(data){
                                    $select.html('full_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.full_name + '">' + val.full_name + '</option>');
                                    })
                                    });
                                </script>
</body>
</html>