<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENT= filter_input(INPUT_GET, 'AGENT', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($EXECUTE)) {
    if($EXECUTE == 1 ) {
        if(isset($AGENT)) {

$query = $pdo->prepare("SELECT 
    adl_workflows_name AS task, COUNT(adl_workflows_complete) AS Completed
FROM
    adl_workflows
WHERE
    adl_workflows_complete = '0'
AND
    adl_workflows_assigned=:AGENT
GROUP BY adl_workflows_name");
$query->bindParam(':AGENT', $AGENT, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

header("content-type:application/json");
echo $json=json_encode($results);  

}

else {
    
$query = $pdo->prepare("SELECT 
    adl_workflows_name AS task, COUNT(adl_workflows_complete) AS Completed
FROM
    adl_workflows
WHERE
    adl_workflows_complete = '0'
GROUP BY adl_workflows_name");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

header("content-type:application/json");
echo $json=json_encode($results);     
    
}

    }

}
?>