<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 


$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '/../../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {



require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE == 1 ) {

        $query = $pdo->prepare("SELECT
            adl_ews_royal_london_id, 
            adl_ews_royal_london_id_fk, 
            adl_ews_royal_london_ifa_id, 
            adl_ews_royal_london_ifa_name,
            adl_ews_royal_london_ri_name, 
            adl_ews_royal_london_policyno, 
            adl_ews_royal_london_product, 
            adl_ews_royal_london_plan_start_date, 
            adl_ews_royal_london_payer_name, 
            adl_ews_royal_london_arrears_start_date, 
            adl_ews_royal_london_plan_premium, 
            adl_ews_royal_london_arrears_amount, 
            adl_ews_royal_london_prems_missed, 
            adl_ews_royal_london_days_in_arrears, 
            adl_ews_royal_london_days_to_lapse, 
            adl_ews_royal_london_bacs_rejection_reason, 
            adl_ews_royal_london_dd_mandate_status, 
            adl_ews_royal_london_next_dd, 
            adl_ews_royal_london_payment_day, 
            adl_ews_royal_london_total_commission_liability, 
            adl_ews_royal_london_within_iep
        FROM
            adl_ews_royal_london
        LEFT JOIN
            client_policy
        ON
            client_policy.policy_number = adl_ews_royal_london.adl_ews_royal_london_policyno");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData'] = $query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
}

} 

} else {
                header('Location: /../../../../CRMmain.php');
    die;
        }