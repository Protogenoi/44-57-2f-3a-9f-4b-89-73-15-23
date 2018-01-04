<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENT= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($AGENT)) {
    
    $query = $pdo->prepare("SELECT Client_Tasks.assigned, Client_Tasks.id, Client_Tasks.client_id, DATE(Client_Tasks.date_added) AS date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) as deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0' and assigned=:AGENT");
    $query->bindParam(':AGENT', $AGENT, PDO::PARAM_STR);
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);

}

else {
    
    $query = $pdo->prepare("SELECT Client_Tasks.assigned, Client_Tasks.id, Client_Tasks.client_id, DATE(Client_Tasks.date_added) AS date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) as deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0'");
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results); 
    
}

?>