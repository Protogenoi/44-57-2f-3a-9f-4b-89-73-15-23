<?php

$agent= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);

include('../../includes/ADL_MYSQLI_CON.php');

if(isset($agent)) {

    #$sql = "select taskcheck.cyd, taskcheck.cancelled_dd, taskcheck.new_dd, taskcheck.tps, taskcheck.trust, taskcheck.upsells ,client_details.client_id, client_details.submitted_date, CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2,' ',client_details.last_name2) AS NAME2 from client_details LEFT JOIN taskcheck on taskcheck.client_id = client_details.client_id";
    #$sql = "select taskcheck.cyd, taskcheck.cancelled_dd, taskcheck.new_dd, taskcheck.tps, taskcheck.trust, taskcheck.upsells ,client_details.client_id, client_details.submitted_date, CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2,' ',client_details.last_name2) AS NAME2 from client_details LEFT JOIN taskcheck on taskcheck.client_id = client_details.client_id WHERE client_details.client_id NOT IN (SELECT client_id from taskcheck)";
$sql="SELECT Client_Tasks.id, Client_Tasks.assigned, Client_Tasks.client_id, Client_Tasks.date_added, Client_Tasks.Task, DATE(Client_Tasks.deadline) as deadline, CURDATE() as today, CONCAT(client_details.title, ' ', client_details.last_name) AS name from Client_Tasks JOIN client_details on Client_Tasks.client_id = client_details.client_id where complete='0' and assigned='$agent'";

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
