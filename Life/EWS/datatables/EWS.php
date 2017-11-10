<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

include('../../../includes/user_tracking.php'); 


$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../../classes/database_class.php');
    require_once(__DIR__ . '../../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {



include('../../../includes/adl_features.php');
include('../../../includes/Access_Levels.php');
include('../../../includes/ADL_PDO_CON.php');


$EWS= filter_input(INPUT_GET, 'EWS', FILTER_SANITIZE_NUMBER_INT);

if(isset($EWS)) {
    if($EWS=='1') {


        $query = $pdo->prepare("SELECT 
    ews.master_agent_no,
    ews.agent_no,
    ews.policy_number,
    ews.client_name,
    STR_TO_DATE(ews.dob, '%d/%m/%Y') AS dob,
    ews.address1,
    ews.address2,
    ews.address3,
    ews.address4,
    ews.post_code,
    ews.policy_type,
    ews.warning,
    STR_TO_DATE(ews.last_full_premium_paid, '%d/%m/%Y') AS last_full_premium_paid,
    ews.net_premium,
    ews.premium_os,
    ews.clawback_due,
    STR_TO_DATE(ews.clawback_date, '%M-%Y') AS clawback_date,
    STR_TO_DATE(ews.policy_start_date, '%d/%m/%Y') AS policy_start_date,
    STR_TO_DATE(ews.off_risk_date, '%M-%Y') AS off_risk_date,    
    ews.seller_name,
    ews.frn,
    ews.reqs,
    ews.ews_status_status,
    ews.date_added,
    ews.processor,
    ews.ournotes,
    ews.color_status,
    ews.updated_date,
    ews.assigned,
    client_policy.client_id
FROM
    ews
LEFT JOIN
    client_policy
ON
client_policy.policy_number = ews.policy_number");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData'] = $query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }    
    
    
    }
    
}

} else {

    header('Location: /../../CRMmain.php');
    die;
    
}    
