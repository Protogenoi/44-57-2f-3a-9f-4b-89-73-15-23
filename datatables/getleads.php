<?php
include('../includes/PDOcon.php');

    $sql = "select agent_name, leads from client_notes group by date";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>

