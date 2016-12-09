<?php

    include('../../includes/PDOcon.php');

    $AuditType= filter_input(INPUT_GET, 'AuditType', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($AuditType)) {
    
    if($AuditType=='NewLeadGen') {   
    
    $sql = 'SELECT submitted_date, id, agent, auditor, grade, an_number from Audit_LeadGen';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);

    }
    
   

    if($AuditType=='OldLeadGen') {  
    
    $sql = 'SELECT id, date_submitted, lead_gen_name, total, score, auditor, grade, edited, date_edited from lead_gen_audit ';
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);

    }
    
        if($AuditType=='Closer') {  
    
    $sql = 'SELECT an_number, policy_number, id, date_submitted, closer, total, score, auditor, grade, edited, date_edited from closer_audits ';
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



