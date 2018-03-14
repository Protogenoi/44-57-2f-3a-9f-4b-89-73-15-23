<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENT= filter_input(INPUT_GET, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($EXECUTE)) {
    if($EXECUTE == 1) {
        
        if(isset($AGENT)) {
    
    $query = $pdo->prepare("SELECT 
    adl_workflows_assigned,
    adl_workflows_client_id_fk,
    DATE(adl_workflows_added_date) AS date_added,
    adl_workflows_name,
    DATE(adl_workflows_deadline) AS deadline,
    CURDATE() AS today,
    CONCAT(client_details.title,
            ' ',
            client_details.last_name) AS name
FROM
    adl_workflows
        JOIN
    client_details ON adl_workflows.adl_workflows_client_id_fk = client_details.client_id
WHERE
    adl_workflows_complete = '0'
AND
    adl_workflows_assigned=:AGENT");
    $query->bindParam(':AGENT', $AGENT, PDO::PARAM_STR);
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);

} else {
    
    $query = $pdo->prepare("SELECT 
    adl_workflows_assigned,
    adl_workflows_client_id_fk,
    DATE(adl_workflows_added_date) AS date_added,
    adl_workflows_name,
    DATE(adl_workflows_deadline) AS deadline,
    CURDATE() AS today,
    CONCAT(client_details.title,
            ' ',
            client_details.last_name) AS name
FROM
    adl_workflows
        JOIN
    client_details ON adl_workflows.adl_workflows_client_id_fk = client_details.client_id
WHERE
    adl_workflows_complete = '0'");
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);  
    
}

    }

}
?>