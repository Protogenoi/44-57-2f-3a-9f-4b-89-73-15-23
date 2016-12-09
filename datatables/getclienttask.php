<?php

include('../includes/PDOcon.php');

    $sql = "select ews_data.ews_status_status, client_notes.completed_by, client_notes.policy_number, client_notes.id, client_notes.cyd, client_notes.cancelled_dd, client_notes.new_dd, client_notes.tps, client_notes.trust, client_notes.upsells, client_notes.client_id, client_notes.client_name, client_notes.complete, client_notes.subject, client_notes.priority, client_notes.status, client_notes.notes, client_notes.submitted_date, client_notes.deadline, client_notes.assigned, CURDATE() as today from client_notes 
LEFT JOIN ews_data
ON client_notes.policy_number=ews_data.policy_number
where client_notes.complete NOT IN ('Y') ";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


 //create an array
    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>

