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
            adl_ews_lv_dd_date_added,
            adl_ews_lv_dd_collection_date, 
            adl_ews_lv_dd_event_des, 
            adl_ews_lv_dd_reject_reason, 
            adl_ews_lv_dd_completion_date, 
            adl_ews_lv_dd_inforce_mths, 
            adl_ews_lv_dd_policy_number, 
            adl_ews_lv_dd_policy_type, 
            adl_ews_lv_dd_title, 
            adl_ews_lv_dd_fornames, 
            adl_ews_lv_dd_surnames, 
            adl_ews_lv_dd_postcode, 
            adl_ews_lv_dd_home_num, 
            adl_ews_lv_dd_mob_num, 
            adl_ews_lv_dd_ape, 
            adl_ews_lv_dd_total_prem_amount, 
            adl_ews_lv_dd_out_bal_amount, 
            adl_ews_lv_dd_comm_unearned_amount,
            adl_ews_lv_dd_comm_cb_period_mths, 
            adl_ews_lv_dd_seller_fca_num, 
            adl_ews_lv_dd_seller_firm_name, 
            adl_ews_lv_dd_seller_num, 
            adl_ews_lv_dd_seller_name, 
            adl_ews_lv_dd_seller_bid, 
            adl_ews_lv_dd_seller_nid, 
            adl_ews_lv_dd_report_run_date,
            client_policy.client_id
        FROM
            adl_ews_lv_dd
        JOIN
            adl_ews
        ON adl_ews_id = adl_ews_lv_dd_id_fk            
        LEFT JOIN
            client_policy
        ON
            client_policy.policy_number = adl_ews.adl_ews_modified_ref");
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