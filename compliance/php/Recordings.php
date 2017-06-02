<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../classes/database_class.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    $GRADE = filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
    $STATUS = filter_input(INPUT_POST, 'STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
    $RID_COMMENTS = filter_input(INPUT_POST, 'RID_COMMENTS', FILTER_SANITIZE_SPECIAL_CHARS);
    $RID = filter_input(INPUT_GET, 'RID', FILTER_SANITIZE_NUMBER_INT);
    
    if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='Assured Protect and Mortgages';
    }

    
    if($EXECUTE=='1') {


        $UPDATE = $pdo->prepare("UPDATE compliance_recordings SET compliance_recordings_audited_by=:AUDIT, compliance_recordings_audited_date=CURRENT_TIMESTAMP, compliance_recordings_grade=:GRADE, compliance_recordings_comments=:NOTES, compliance_recordings_status=:STATUS WHERE compliance_recordings_id=:RID AND compliance_recordings_company=:COMPANY");
        $UPDATE->bindParam(':RID', $RID, PDO::PARAM_STR);
        $UPDATE->bindParam(':AUDIT', $hello_name, PDO::PARAM_STR);
        $UPDATE->bindParam(':GRADE', $GRADE, PDO::PARAM_STR);
        $UPDATE->bindParam(':COMPANY', $COMPANY, PDO::PARAM_STR);
        $UPDATE->bindParam(':NOTES', $RID_COMMENTS, PDO::PARAM_STR);
        $UPDATE->bindParam(':STATUS', $STATUS, PDO::PARAM_STR);
        $UPDATE->execute();

        
        header('Location: ../Recordings.php?RETURN=RECUPDATED');
        
    }

}

?>