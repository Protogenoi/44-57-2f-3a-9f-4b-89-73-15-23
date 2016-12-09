<?php

include('../includes/PDOcon.php');

    $sql = 'SELECT client_details.client_id , client_policy.client_name, client_details.email, client_details.phone_number, client_details.alt_number, client_details.email2, client_details.address1, client_details.address2, client_details.town, client_details.post_code, client_details.submitted_by, client_policy.policy_number, financial_statistics_history.id, financial_statistics_history.comm_date, financial_statistics_history.sale_date, financial_statistics_history.policy_number, financial_statistics_history.sales_person, financial_statistics_history.processor, financial_statistics_history.trans_type, financial_statistics_history.source, financial_statistics_history.target, financial_statistics_history.deduction, financial_statistics_history.payment FROM financial_statistics_history
LEFT JOIN client_policy 
ON client_policy.policy_number = financial_statistics_history.policy_number
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

