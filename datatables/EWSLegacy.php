<?php

include('../includes/PDOcon.php');


$LegacyMaster= filter_input(INPUT_GET, 'LegacyMaster', FILTER_SANITIZE_NUMBER_INT);

if(isset($LegacyMaster)) {
    
    if($LegacyMaster=='1') {   
        
        $sql = "SELECT
assura_ews_data.provider_created,
assura_ews_data.policy_number,
assura_ews_data.created_date,
assura_ews_data.commisson_status,
assura_ews_data.product,
assura_ews_data.gender,
CONCAT (assura_ews_data.title, ' ', assura_ews_data.first, ' ' , assura_ews_data.last) AS Name,
assura_ews_data.life_sum_assured,
assura_ews_data.life_term,
assura_ews_data.premium,
assura_ews_data.term_assurance_type,
assura_ews_data.cic_sum_assured,
assura_ews_data.cic_term,
assura_ews_data.phi_sum_assured,
assura_ews_data.phi_age_until,
assura_ews_data.phi_term,
assura_ews_data.fib_sum_assured,
assura_ews_data.fib_age_until,
assura_ews_data.fib_term,
assura_ews_data.premium2,
assura_ews_data.status,
assura_ews_data.description,
assura_ews_data.product_cat,
assura_ews_data.provider2,
assura_ews_data.commission_type,
assura_ews_data.color_status,
assura_ews_data.ews_status,
assura_client_policy.policy_number AS cppol,
assura_client_policy.id AS reference,
assura_client_details.client_id
	FROM assura_ews_data
	LEFT JOIN assura_client_policy 
	ON assura_ews_data.policy_number=assura_client_policy.policy_number
	LEFT JOIN assura_client_details 
	ON assura_client_policy.ref_id=assura_client_details.client_id";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        

       
    }
    
    
    if($LegacyMaster=='2') {   
        
        $sql = "SELECT
assura_ews_data.provider_created,
assura_ews_data.policy_number,
assura_ews_data.created_date,
assura_ews_data.commisson_status,
assura_ews_data.product,
assura_ews_data.gender,
CONCAT (assura_ews_data.title, ' ', assura_ews_data.first, ' ' , assura_ews_data.last) AS Name,
assura_ews_data.life_sum_assured,
assura_ews_data.life_term,
assura_ews_data.premium,
assura_ews_data.term_assurance_type,
assura_ews_data.cic_sum_assured,
assura_ews_data.cic_term,
assura_ews_data.phi_sum_assured,
assura_ews_data.phi_age_until,
assura_ews_data.phi_term,
assura_ews_data.fib_sum_assured,
assura_ews_data.fib_age_until,
assura_ews_data.fib_term,
assura_ews_data.premium2,
assura_ews_data.status,
assura_ews_data.description,
assura_ews_data.product_cat,
assura_ews_data.provider2,
assura_ews_data.commission_type,
assura_ews_data.color_status,
assura_ews_data.ews_status,
assura_client_policy.policy_number AS cppol,
assura_client_policy.id AS reference,
assura_client_details.client_id
	FROM assura_ews_data
	LEFT JOIN assura_client_policy 
	ON assura_ews_data.policy_number=assura_client_policy.policy_number
	LEFT JOIN assura_client_details 
	ON assura_client_policy.ref_id=assura_client_details.client_id
	WHERE assura_ews_data.ews_status ='NEW' OR assura_ews_data.ews_status ='Callback' OR assura_ews_data.ews_status ='No Answer'";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }
    
    if($LegacyMaster=='3') { 
        
                $sql = "SELECT
assura_ews_data.provider_created,
assura_ews_data.policy_number,
assura_ews_data.created_date,
assura_ews_data.commisson_status,
assura_ews_data.product,
assura_ews_data.gender,
CONCAT (assura_ews_data.title, ' ', assura_ews_data.first, ' ' , assura_ews_data.last) AS Name,
assura_ews_data.life_sum_assured,
assura_ews_data.life_term,
assura_ews_data.premium,
assura_ews_data.term_assurance_type,
assura_ews_data.cic_sum_assured,
assura_ews_data.cic_term,
assura_ews_data.phi_sum_assured,
assura_ews_data.phi_age_until,
assura_ews_data.phi_term,
assura_ews_data.fib_sum_assured,
assura_ews_data.fib_age_until,
assura_ews_data.fib_term,
assura_ews_data.premium2,
assura_ews_data.status,
assura_ews_data.description,
assura_ews_data.product_cat,
assura_ews_data.provider2,
assura_ews_data.commission_type,
assura_ews_data.color_status,
assura_ews_data.ews_status,
assura_client_policy.policy_number AS cppol,
assura_client_policy.id AS reference,
assura_client_details.client_id
	FROM assura_ews_data
	LEFT JOIN assura_client_policy 
	ON assura_ews_data.policy_number=assura_client_policy.policy_number
	LEFT JOIN assura_client_details 
	ON assura_client_policy.ref_id=assura_client_details.client_id
	WHERE assura_ews_data.ews_status !='NEW' ";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }
    
}
        

?>



