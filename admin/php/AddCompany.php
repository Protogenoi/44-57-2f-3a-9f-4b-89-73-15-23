<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } 
    }

include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($EXECUTE)) {
    if($EXECUTE=='1') {
    
$PRO_ID= filter_input(INPUT_POST, 'PRO_ID', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_PERCENT= filter_input(INPUT_POST, 'PRO_PERCENT', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_COMPANY= filter_input(INPUT_POST, 'PRO_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_ACTIVE= filter_input(INPUT_POST, 'PRO_ACTIVE', FILTER_SANITIZE_SPECIAL_CHARS);



$dupcheck = "Select insurance_company_id from insurance_company WHERE insurance_company_id=$PRO_ID";
$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {

    $UPDATE = $pdo->prepare("UPDATE insurance_company set insurance_company_name=:insurance_company_name, insurance_company_active=:insurance_company_active, insurance_company_added_by=:insurance_company_added_by, insurance_company_percent=:insurance_company_percent WHERE insurance_company_id=:insurance_company_id");
        $UPDATE->bindParam(':insurance_company_id', $PRO_ID, PDO::PARAM_INT);
        $UPDATE->bindParam(':insurance_company_percent', $PRO_PERCENT, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':insurance_company_name', $PRO_COMPANY, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':insurance_company_active', $PRO_ACTIVE, PDO::PARAM_INT);
        $UPDATE->bindParam(':insurance_company_added_by', $hello_name, PDO::PARAM_STR, 500);
        $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));
}

if ($duperaw->num_rows <= 0) {
    
    $INSERT = $pdo->prepare("INSERT INTO insurance_company set insurance_company_name=:insurance_company_name, insurance_company_active=:insurance_company_active, insurance_company_added_by=:insurance_company_added_by, insurance_company_percent=:insurance_company_percent");
        $INSERT->bindParam(':insurance_company_percent', $PRO_PERCENT, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':insurance_company_name', $PRO_COMPANY, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':insurance_company_active', $PRO_ACTIVE, PDO::PARAM_INT);
        $INSERT->bindParam(':insurance_company_added_by', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
        
}

if(isset($fferror)) {
    if($fferror=='0') {       
    header('Location: ../../admin/Admindash.php?RETURN=UPDATED&provider=y'); die;
    }
                    }
}
} else {
if(isset($fferror)) {
    if($fferror=='0') {       
    header('Location: ../../admin/Admindash.php?RETURN=FAIL&provider=y'); die;
    }
                    }    
    
}
?>

