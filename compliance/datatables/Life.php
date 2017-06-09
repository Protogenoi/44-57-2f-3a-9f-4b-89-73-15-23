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
         $query = $pdo->prepare("SELECT life_test_one_company, life_test_one_advisor, life_test_one_mark, life_test_one_grade, life_test_one_added_date, life_test_one_id FROM life_test_one ORDER BY life_test_one_added_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
    }
    
    else {

        $query = $pdo->prepare("SELECT life_test_one_company, life_test_one_advisor, life_test_one_mark, life_test_one_grade, life_test_one_added_date, life_test_one_id FROM life_test_one WHERE life_test_one_company=:COMPANY ORDER BY life_test_one_added_date DESC");
        $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
        
}

}
?>
  