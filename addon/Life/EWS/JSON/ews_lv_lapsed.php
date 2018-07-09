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
            adl_ews_lv_lapsed_event_date, 
            adl_ews_lv_lapsed_event_des, 
            adl_ews_lv_lapsed_completion_date, 
            adl_ews_lv_lapsed_inforce_mths, 
            adl_ews_lv_lapsed_policy_number, 
            adl_ews_lv_lapsed_title, 
            adl_ews_lv_lapsed_forenames, 
            adl_ews_lv_lapsed_surname, 
            adl_ews_lv_lapsed_postcode, 
            adl_ews_lv_lapsed_home_num, 
            adl_ews_lv_lapsed_mob_num, 
            adl_ews_lv_lapsed_ape, 
            adl_ews_lv_lapsed_total_mth_prem, 
            adl_ews_lv_lapsed_comm_amount_idem, 
            adl_ews_lv_lapsed_comm_cb_period_mths, 
            adl_ews_lv_lapsed_comm_type, 
            adl_ews_lv_lapsed_seller_fca_num, 
            adl_ews_lv_lapsed_seller_firm_name, 
            adl_ews_lv_lapsed_seller_num, 
            adl_ews_lv_lapsed_seller_name,
            adl_ews_lv_lapsed_seller_bid, 
            adl_ews_lv_lapsed_seller_nid, 
            adl_ews_lv_lapsed_report_run_date,
            client_policy.client_id
        FROM
            adl_ews_lv_lapsed
        LEFT JOIN
            client_policy
        ON
            client_policy.policy_number = adl_ews_lv_lapsed.adl_ews_lv_lapsed_policy_number");
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