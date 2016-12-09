<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT submitted_date, id, agent, auditor, grade from Audit_LeadGen ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>



