<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT client_details.client_id, client_policy.client_name, client_details.email, client_details.phone_number, client_details.alt_number, client_details.email2, client_details.address1, client_details.address2, client_details.town, client_details.post_code, client_details.submitted_by, client_policy.policy_number, financial_statisics.id, financial_statisics.comm_date, financial_statisics.sale_date, financial_statisics.policy_number, financial_statisics.sales_person, financial_statisics.processor, financial_statisics.trans_type, financial_statisics.source, financial_statisics.target, financial_statisics.deduction, financial_statisics.payment FROM financial_statisics
LEFT JOIN client_policy 
ON client_policy.policy_number = financial_statisics.policy_number
LEFT JOIN client_details
ON client_details.client_id = client_policy.client_id ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


 //create an array
    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows)

?>

