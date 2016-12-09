<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

$report= filter_input(INPUT_GET, 'report', FILTER_SANITIZE_NUMBER_INT);

if(isset($report)) {
    include('../../includes/ADL_MYSQLI_CON.php');   
    if($report=='1') {
        
        $sql="SELECT submitted_update, updated_by, submitted_date, added_by, client_id, CONCAT(first_name, ' ',last_name) AS client_name from pension_clients WHERE active='0'";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
    
    }

    }
?>
