<?php

include('../includes/ADL_MYSQL_CON.php');

    $sql = 'SELECT id, date_submitted, lead_gen_name, total, score, auditor, grade, edited, date_edited from lead_gen_audit ';
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>



