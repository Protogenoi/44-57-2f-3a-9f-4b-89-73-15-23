<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENT= filter_input(INPUT_GET, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($EXECUTE)) {
    if($EXECUTE== 1) {
        if(isset($AGENT)) {
    
    $query = $pdo->prepare("SELECT 
    Client_Tasks.assigned,
    Client_Tasks.id,
    Client_Tasks.client_id,
    DATE(Client_Tasks.date_added) AS date_added,
    Client_Tasks.Task,
    DATE(Client_Tasks.deadline) AS deadline,
    CURDATE() AS today,
    CONCAT(client_details.title,
            ' ',
            client_details.last_name) AS name
FROM
    Client_Tasks
        JOIN
    client_details ON Client_Tasks.client_id = client_details.client_id
WHERE
    complete = '0' AND assigned = :AGENT");
    $query->bindParam(':AGENT', $AGENT, PDO::PARAM_STR);
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);

}

    }

elseif($EXECUTE == 2) {
    
    $query = $pdo->prepare("SELECT Client_Tasks.assigned, Client_Tasks.id, Client_Tasks.client_id, DATE(Client_Tasks.date_added) AS date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) as deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0'");
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results); 
    
}

    if($EXECUTE== 3) {
        if(isset($AGENT)) {
    
    $query = $pdo->prepare("SELECT 
    life_tasks.life_tasks_assigned,
    life_tasks.life_tasks_id,
    life_tasks.life_tasks_client_id,
    DATE(life_tasks.life_tasks_added_date) AS date_added,
    life_tasks.life_tasks_task,
    DATE(life_tasks.life_tasks_deadline) AS deadline,
    CURDATE() AS today,
    CONCAT(client_details.title,
            ' ',
            client_details.last_name) AS name
FROM
    life_tasks
        JOIN
    client_details ON life_tasks.life_tasks_client_id = client_details.client_id
WHERE
    life_tasks_complete = '0' AND life_tasks_assigned = :AGENT");
    $query->bindParam(':AGENT', $AGENT, PDO::PARAM_STR);
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);

} else {
    
    $query = $pdo->prepare("SELECT 
    life_tasks.life_tasks_assigned,
    life_tasks.life_tasks_id,
    life_tasks.life_tasks_client_id,
    DATE(life_tasks.life_tasks_added_date) AS date_added,
    life_tasks.life_tasks_task,
    DATE(life_tasks.life_tasks_deadline) AS deadline,
    CURDATE() AS today,
    CONCAT(client_details.title,
            ' ',
            client_details.last_name) AS name
FROM
    life_tasks
        JOIN
    client_details ON life_tasks.life_tasks_client_id = client_details.client_id
WHERE
    life_tasks_complete = '0'");
    $query->execute()or die(print_r($query->errorInfo(), true));
    json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($results);  
    
}

    }

}
?>