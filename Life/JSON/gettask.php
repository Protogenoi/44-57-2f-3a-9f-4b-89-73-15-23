<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$agent= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);

include('../../includes/ADL_MYSQLI_CON.php');

if(isset($agent)) {

$sql="SELECT Client_Tasks.id, Client_Tasks.client_id, DATE(Client_Tasks.date_added) AS date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) as deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0' and assigned='$agent'";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);

}

else {

$sql="SELECT Client_Tasks.id, Client_Tasks.assigned, Client_Tasks.client_id, Client_Tasks.date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) AS deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0'";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);    
    
}

?>
