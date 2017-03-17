<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } 
    }

include('../../includes/ADL_PDO_CON.php');
include('../../classes/database_class.php'); 

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($EXECUTE)) {
    if($EXECUTE=='1') {
    
$PRO_ID= filter_input(INPUT_POST, 'PRO_ID', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_PERCENT= filter_input(INPUT_POST, 'PRO_PERCENT', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_COMPANY= filter_input(INPUT_POST, 'PRO_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
$PRO_ACTIVE= filter_input(INPUT_POST, 'PRO_ACTIVE', FILTER_SANITIZE_SPECIAL_CHARS);

$database = new Database(); 
            $database->query("Select insurance_company_id from insurance_company WHERE insurance_company_id=:insurance_company_id");
            $database->bind(':insurance_company_id', $PRO_ID);
            $database->execute(); 
            
if ($database->rowCount()>=1) {


$database->query("UPDATE insurance_company set insurance_company_name=:name, insurance_company_active=:active, insurance_company_added_by=:added_by, insurance_company_percent=:percent WHERE insurance_company_id=:id");
        $database->bind(':id', $PRO_ID);
        $database->bind(':percent', $PRO_PERCENT);
        $database->bind(':name', $PRO_COMPANY);
        $database->bind(':active', $PRO_ACTIVE);
        $database->bind(':added_by', $hello_name);
        $database->execute();
        
        if(isset($fferror)) {
    if($fferror=='0') {       
    header('Location: ../../admin/Admindash.php?RETURN=UPDATED&provider=y'); die;
    }
                    }
}

else {
    
    $INSERT = $pdo->prepare("INSERT INTO insurance_company set insurance_company_name=:insurance_company_name, insurance_company_active=:insurance_company_active, insurance_company_added_by=:insurance_company_added_by, insurance_company_percent=:insurance_company_percent");
        $INSERT->bindParam(':insurance_company_percent', $PRO_PERCENT, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':insurance_company_name', $PRO_COMPANY, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':insurance_company_active', $PRO_ACTIVE, PDO::PARAM_INT);
        $INSERT->bindParam(':insurance_company_added_by', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
        
 if(isset($fferror)) {
    if($fferror=='0') {       
    header('Location: ../../admin/Admindash.php?RETURN=UPDATED&provider=y'); die;
    }
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

