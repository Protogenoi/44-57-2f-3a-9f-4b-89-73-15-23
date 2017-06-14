<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../classes/database_class.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
    
            if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
         $query = $pdo->prepare("SELECT compliance_uploads_id, compliance_uploads_category, compliance_uploads_date, compliance_uploads_company, compliance_uploads_location, compliance_uploads_title, compliance_uploads_uploaded_by FROM compliance_uploads ORDER BY compliance_uploads_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
    }
    
    else {

        $query = $pdo->prepare("SELECT compliance_uploads_id, compliance_uploads_category, compliance_uploads_date, compliance_uploads_company, compliance_uploads_location, compliance_uploads_title, compliance_uploads_uploaded_by FROM compliance_uploads WHERE compliance_uploads_company=:COMPANY OR compliance_uploads_company='N/A' ORDER BY compliance_uploads_date DESC");
        $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
        
}

}
?>
  