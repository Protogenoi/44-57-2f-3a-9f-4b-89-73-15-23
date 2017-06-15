<?php

include('../includes/ADL_MYSQLI_CON.php');


$EWS= filter_input(INPUT_GET, 'EWS', FILTER_SANITIZE_NUMBER_INT);

if(isset($EWS)) {
    
    if($EWS=='1') {   
        
        $sql = "SELECT 
 ews_data_history.policy_number
, ews_data_history.id
, ews_data_history.dob
, ews_data_history.address1
, ews_data_history.address2
, ews_data_history.post_code
, ews_data_history.policy_type
, ews_data_history.warning
, ews_data_history.last_full_premium_paid
, ews_data_history.net_premium
, ews_data_history.premium_os
, ews_data_history.clawback_due
, DATE_FORMAT(ews_data_history.clawback_date, '%y-%M') AS clawback_date
, ews_data_history.policy_start_date
, ews_data_history.off_risk_date
, ews_data_history.reqs
, ews_data_history.date_added
, ews_data_history.ews_status_status
, ews_data_history.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id
, ews_data_history.color_status
, client_policy.closer
, client_policy.lead
	FROM ews_data_history 
	LEFT JOIN client_policy 
	ON ews_data_history.policy_number=client_policy.policy_number 
	LEFT JOIN financial_statisics
	ON financial_statisics.policy_number=ews_data_history.policy_number";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
    }
    
    if($EWS=='2') {  
        
            $sql = "SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.address1
, ews_data.address2
, ews_data.address3
, ews_data.address4
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.ournotes
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, ews_data.color_status
, ews_data.updated_date
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }
    
    if($EWS=='3') {  
        
        $sql = "SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.dob
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.ournotes
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, ews_data.ews_status_status
, ews_data.color_status
, client_policy.closer
, client_policy.lead
	FROM ews_data 
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number 
	WHERE color_status IN('Purple','Red','Green','Orange','Grey')";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
    }
    
     if($EWS=='4') {   
        
        $sql = "SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.dob
, ews_data.address1
, ews_data.address2
, ews_data.address3
, ews_data.address4
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.ournotes
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, ews_data.color_status
, client_policy.closer
, client_policy.lead
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
    }
    
    
      if($EWS=='5') {  
          
          $clwdate= filter_input(INPUT_GET, 'clwdate', FILTER_SANITIZE_SPECIAL_CHARS);
          
          if(empty($clwdate)) {
              $clwdate=date("M-y");
          }
        
            $sql = "SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.dob
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.ournotes
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, ews_data.color_status
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number
	WHERE ews_data.warning IN ('CANCELLED DD','BOUNCED DD','WILL CANCEL','RE_INSATED') 
        AND color_status IN ('black', 'blue')
        AND ews_data.off_risk_date ='$clwdate'
	";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }  
    
        if($EWS=='6') {  
            
            $clwdate= filter_input(INPUT_GET, 'clwdate', FILTER_SANITIZE_SPECIAL_CHARS);
                      if(empty($clwdate)) {
              $clwdate=date("M-y");
          }
        
            $sql = "SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.dob
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.ournotes
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, ews_data.color_status
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number
	WHERE ews_data.warning IN ('CFO','LAPSED','WILL REDRAW','CANCEL')
	AND  ews_data.off_risk_date ='$clwdate'
        AND ews_data.color_status IN ('black', 'blue')";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }
    
    
    }
