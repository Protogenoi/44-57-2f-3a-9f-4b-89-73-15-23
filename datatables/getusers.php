<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT id, login, pw, real_name, extra_info, access_level, active from users ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>



