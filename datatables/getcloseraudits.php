<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT policy_number, id, date_submitted, closer, total, score, auditor, grade, edited, date_edited from closer_audits ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>



