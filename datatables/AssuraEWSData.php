<?php

include('../includes/ADL_MYSQLI_CON.php');


$EWS= filter_input(INPUT_GET, 'EWS', FILTER_SANITIZE_NUMBER_INT);

if(isset($EWS)) {
    
    if($EWS=='1') {   
        
        $sql = "SELECT 
assura_ews_data_history.master_agent_no
, assura_ews_data_history.agent_no
, assura_ews_data_history.policy_number
, assura_ews_data_history.id
, assura_ews_data_history.dob
, assura_ews_data_history.address1
, assura_ews_data_history.address2
, assura_ews_data_history.address3
, assura_ews_data_history.address4
, assura_ews_data_history.post_code
, assura_ews_data_history.policy_type
, assura_ews_data_history.warning
, assura_ews_data_history.last_full_premium_paid
, assura_ews_data_history.net_premium
, assura_ews_data_history.premium_os
, assura_ews_data_history.clawback_due
, DATE_FORMAT(assura_ews_data_history.clawback_date, '%y-%M') AS clawback_date
, assura_ews_data_history.policy_start_date
, assura_ews_data_history.off_risk_date
, assura_ews_data_history.seller_name
, assura_ews_data_history.reqs
, assura_ews_data_history.date_added
, assura_ews_data_history.Processor
, assura_ews_data_history.ews_status_status
, assura_ews_data_history.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id
, assura_ews_data_history.color_status
, assura_ews_data_history.ournotes
, client_policy.closer
, client_policy.lead
	FROM assura_ews_data_history 
	LEFT JOIN client_policy 
	ON assura_ews_data_history.policy_number=client_policy.policy_number 
	LEFT JOIN financial_statisics
	ON financial_statisics.policy_number=assura_ews_data_history.policy_number
	WHERE financial_statisics.trans_type = 'COMM' or financial_statisics.trans_type is null";
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
assura_ews_data.policy_number
, assura_ews_data.id
, assura_ews_data.dob
, assura_ews_data.address1
, assura_ews_data.address2
, assura_ews_data.address3
, assura_ews_data.address4
, assura_ews_data.post_code
, assura_ews_data.policy_type
, assura_ews_data.warning
, assura_ews_data.last_full_premium_paid
, assura_ews_data.net_premium
, assura_ews_data.premium_os
, assura_ews_data.clawback_due
, assura_ews_data.clawback_date
, assura_ews_data.policy_start_date
, assura_ews_data.off_risk_date
, assura_ews_data.reqs
, assura_ews_data.ournotes
, assura_ews_data.date_added
, assura_ews_data.Processor
, assura_ews_data.ews_status_status
, assura_ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, assura_ews_data.color_status
	FROM assura_ews_data
	LEFT JOIN client_policy 
	ON assura_ews_data.policy_number=client_policy.policy_number
	WHERE color_status IN ('black', 'blue', ' ')";
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
assura_ews_data.policy_number
, assura_ews_data.id
, assura_ews_data.dob
, assura_ews_data.post_code
, assura_ews_data.policy_type
, assura_ews_data.warning
, assura_ews_data.last_full_premium_paid
, assura_ews_data.net_premium
, assura_ews_data.premium_os
, assura_ews_data.clawback_due
, assura_ews_data.clawback_date
, assura_ews_data.policy_start_date
, assura_ews_data.off_risk_date
, assura_ews_data.reqs
, assura_ews_data.ournotes
, assura_ews_data.date_added
, assura_ews_data.Processor
, assura_ews_data.ews_status_status
, assura_ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, assura_ews_data.ews_status_status
, assura_ews_data.color_status
, client_policy.closer
, client_policy.lead
	FROM assura_ews_data 
	LEFT JOIN client_policy 
	ON assura_ews_data.policy_number=client_policy.policy_number 
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
assura_ews_data.policy_number
, assura_ews_data.id
, assura_ews_data.dob
, assura_ews_data.address1
, assura_ews_data.address2
, assura_ews_data.address3
, assura_ews_data.address4
, assura_ews_data.post_code
, assura_ews_data.policy_type
, assura_ews_data.warning
, assura_ews_data.last_full_premium_paid
, assura_ews_data.net_premium
, assura_ews_data.premium_os
, assura_ews_data.clawback_due
, assura_ews_data.clawback_date
, assura_ews_data.policy_start_date
, assura_ews_data.off_risk_date
, assura_ews_data.reqs
, assura_ews_data.ournotes
, assura_ews_data.date_added
, assura_ews_data.Processor
, assura_ews_data.ews_status_status
, assura_ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, assura_ews_data.color_status
, client_policy.closer
, client_policy.lead
	FROM assura_ews_data
	LEFT JOIN client_policy 
	ON assura_ews_data.policy_number=client_policy.policy_number";
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
assura_ews_data.policy_number
, assura_ews_data.id
, assura_ews_data.dob
, assura_ews_data.post_code
, assura_ews_data.policy_type
, assura_ews_data.warning
, assura_ews_data.last_full_premium_paid
, assura_ews_data.net_premium
, assura_ews_data.premium_os
, assura_ews_data.clawback_due
, assura_ews_data.clawback_date
, assura_ews_data.policy_start_date
, assura_ews_data.off_risk_date
, assura_ews_data.reqs
, assura_ews_data.ournotes
, assura_ews_data.date_added
, assura_ews_data.Processor
, assura_ews_data.ews_status_status
, assura_ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, assura_ews_data.color_status
	FROM assura_ews_data
	LEFT JOIN client_policy 
	ON assura_ews_data.policy_number=client_policy.policy_number
	WHERE assura_ews_data.warning IN ('CANCELLED DD','BOUNCED DD','WILL CANCEL','RE_INSATED') 
        AND color_status IN ('black', 'blue')
        AND assura_ews_data.off_risk_date ='$clwdate'
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
assura_ews_data.policy_number
, assura_ews_data.id
, assura_ews_data.dob
, assura_ews_data.post_code
, assura_ews_data.policy_type
, assura_ews_data.warning
, assura_ews_data.last_full_premium_paid
, assura_ews_data.net_premium
, assura_ews_data.premium_os
, assura_ews_data.clawback_due
, assura_ews_data.clawback_date
, assura_ews_data.policy_start_date
, assura_ews_data.off_risk_date
, assura_ews_data.reqs
, assura_ews_data.ournotes
, assura_ews_data.date_added
, assura_ews_data.Processor
, assura_ews_data.ews_status_status
, assura_ews_data.client_name
, client_policy.policy_number AS cppol
, client_policy.client_id 
, client_policy.closer
, client_policy.lead
, assura_ews_data.color_status
	FROM assura_ews_data
	LEFT JOIN client_policy 
	ON assura_ews_data.policy_number=client_policy.policy_number
	WHERE assura_ews_data.warning IN ('CFO','LAPSED','WILL REDRAW','CANCEL')
	AND  assura_ews_data.off_risk_date ='$clwdate'
        AND assura_ews_data.color_status IN ('black', 'blue')";
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
        
    }
    
    
    }
