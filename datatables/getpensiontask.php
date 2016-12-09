<?php

include('../includes/PDOcon.php');

    $sql = "SELECT pension_workflow.client_id, CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, pension_workflow.step, pension_workflow.task, CONCAT(pension_workflow.apptime, ' ', pension_workflow.appdate) AS appdatetime, pension_workflow.date_edited from pension_workflow LEFT JOIN client_details ON pension_workflow.client_id = client_details.client_id WHERE pension_workflow.complete ='N'";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>
