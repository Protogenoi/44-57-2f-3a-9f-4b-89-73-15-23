<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT client_details.client_id, client_details.email, client_details.phone_number, client_details.alt_number, client_details.email2, client_details.address1, client_details.address2, client_details.town, client_details.post_code, client_details.submitted_by, client_details.submitted_date, client_policy.sale_date, client_policy.policy_number, client_policy.application_number, client_policy.premium, client_policy.type, client_policy.commission, client_policy.PolicyStatus, client_policy.insurer, client_policy.client_name FROM client_details LEFT JOIN client_policy ON client_details.client_id = client_policy.client_id ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


 //create an array
    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>

