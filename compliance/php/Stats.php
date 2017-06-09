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
    
    $STAT_ADVISOR = filter_input(INPUT_POST, 'STAT_ADVISOR', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_SALES = filter_input(INPUT_POST, 'STAT_SALES', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_STANDARD = filter_input(INPUT_POST, 'STAT_STANDARD', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_CIC = filter_input(INPUT_POST, 'STAT_CIC', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_CFO = filter_input(INPUT_POST, 'STAT_CFO', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_LAP = filter_input(INPUT_POST, 'STAT_LAP', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_CR = filter_input(INPUT_POST, 'STAT_CR', FILTER_SANITIZE_SPECIAL_CHARS);
    $STAT_ID = filter_input(INPUT_GET, 'STAT_ID', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $YEAR=date('Y');
    $MONTH=date('M');
    
    if($EXECUTE=='1') {
            
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND CONCAT(firstname, ' ', lastname)=:NAME");
    $query->bindParam(':NAME', $STAT_ADVISOR, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];          
    
    $DUPE = $pdo->prepare("SELECT compliance_sale_stats_id_fk
        FROM compliance_sale_stats
        WHERE 
        compliance_sale_stats_id_fk=:FK
        AND
        compliance_sale_stats_year=:YEAR
        AND
        compliance_sale_stats_month=:MONTH");
    $DUPE->bindParam(':FK', $ID_FK, PDO::PARAM_INT);
    $DUPE->bindParam(':YEAR', $YEAR, PDO::PARAM_STR);
    $DUPE->bindParam(':MONTH', $MONTH, PDO::PARAM_STR);
    $DUPE->execute();

           if ($DUPE->rowCount()>=1) {
      header('Location: ../Stats.php?RETURN=STATSDUPE');    
           
       } else {
    

        $INSERT = $pdo->prepare("INSERT INTO compliance_sale_stats
            SET 
            compliance_sale_stats_id_fk=:FK,
            compliance_sale_stats_sales=:SALES,
            compliance_sale_stats_standard_pols=:STAND,
            compliance_sale_stats_cic_pols=:CIC,
            compliance_sale_stats_cfo_pols=:CFO,
            compliance_sale_stats_lapsed_pols=:LAPSED,
            compliance_sale_stats_cancel_rate=:RATE,
            compliance_sale_stats_advisor=:ADVISOR,
            compliance_sale_stats_added_by=:HELLO,
            compliance_sale_stats_company=:COMPANY,
            compliance_sale_stats_year=:YEAR,
            compliance_sale_stats_month=:MONTH");
        $INSERT->bindParam(':FK', $ID_FK, PDO::PARAM_STR);
        $INSERT->bindParam(':SALES', $STAT_SALES, PDO::PARAM_STR);
        $INSERT->bindParam(':STAND', $STAT_STANDARD, PDO::PARAM_STR);
        $INSERT->bindParam(':CIC', $STAT_CIC, PDO::PARAM_STR);
        $INSERT->bindParam(':CFO', $STAT_CFO, PDO::PARAM_STR);
        $INSERT->bindParam(':LAPSED', $STAT_LAP, PDO::PARAM_STR);
        $INSERT->bindParam(':RATE', $STAT_CR, PDO::PARAM_STR);
        $INSERT->bindParam(':ADVISOR', $STAT_ADVISOR, PDO::PARAM_STR);
        $INSERT->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':YEAR', $YEAR, PDO::PARAM_STR);
        $INSERT->bindParam(':MONTH', $MONTH, PDO::PARAM_STR);
        $INSERT->execute();
        
       header('Location: ../Stats.php?RETURN=STATS');
        
       }
        
    }
    
    if($EXECUTE=='2') {
            
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE company=:COMPANY AND employee_id=:ID");
    $query->bindParam(':ID', $STAT_ID, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];           

        $INSERT = $pdo->prepare("UPDATE compliance_sale_stats
            SET 
            compliance_sale_stats_sales=:SALES,
            compliance_sale_stats_standard_pols=:STAND,
            compliance_sale_stats_cic_pols=:CIC,
            compliance_sale_stats_cfo_pols=:CFO,
            compliance_sale_stats_lapsed_pols=:LAPSED,
            compliance_sale_stats_cancel_rate=:RATE,
            compliance_sale_stats_updated_by=:HELLO,
            compliance_sale_stats_year=:YEAR,
            compliance_sale_stats_month=:MONTH
            WHERE 
            compliance_sale_stats_id=:ID
            AND
            compliance_sale_stats_company=:COMPANY");
        $INSERT->bindParam(':ID', $STAT_ID, PDO::PARAM_STR);
        $INSERT->bindParam(':SALES', $STAT_SALES, PDO::PARAM_STR);
        $INSERT->bindParam(':STAND', $STAT_STANDARD, PDO::PARAM_STR);
        $INSERT->bindParam(':CIC', $STAT_CIC, PDO::PARAM_STR);
        $INSERT->bindParam(':CFO', $STAT_CFO, PDO::PARAM_STR);
        $INSERT->bindParam(':LAPSED', $STAT_LAP, PDO::PARAM_STR);
        $INSERT->bindParam(':RATE', $STAT_CR, PDO::PARAM_STR);
        $INSERT->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':YEAR', $YEAR, PDO::PARAM_STR);
        $INSERT->bindParam(':MONTH', $MONTH, PDO::PARAM_STR);
        $INSERT->execute();
        
        header('Location: ../Stats.php?RETURN=STATSUPDATED');
        
    }    

}

?>