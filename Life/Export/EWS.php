<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');
include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}

if (!in_array($hello_name,$Level_8_Access, true)) {
    header('Location: ../../CRMmain.php'); die;
}


$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE)) {

$DATEFROM= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$DATETO= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$EWS_DATE= filter_input(INPUT_GET, 'EWS_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
$WARNING= filter_input(INPUT_GET, 'WARNING', FILTER_SANITIZE_SPECIAL_CHARS);

$ALT_WARNING="$WARNING NEW";

    $file="EWS_EXPORT";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    

    if($EXECUTE=='EWS') {
        
                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :DATEFROM AND :DATETO
        AND ews_status_status = :WARNING
        AND warning = :WARNING2');
                    $query->bindParam(':WARNING', $WARNING, PDO::PARAM_STR);
                    $query->bindParam(':WARNING2', $ALT_WARNING, PDO::PARAM_STR);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;         
        
        
    }
    

if($EXECUTE=='ADL') {
    
                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :DATEFROM AND :DATETO
        AND warning = :WARNING');
                    $query->bindParam(':WARNING', $WARNING, PDO::PARAM_STR);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;         
        
        
    }    

    if($EXECUTE=='RAW_EWS') {

                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;        
        
    }    
    
    if($EXECUTE=='UPDATED_EWS') {

                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE AND warning IN("CFO","Lapsed","Bounced DD","Cancelled DD")');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;        
        
    }
    
    if($EXECUTE=='ASSIGNED_RAW_EWS') {
        
           switch ($hello_name) {
               case "Abbie":
                   $ASSIGNED="abbiek";
                   break;
               default:
                   $ASSIGNED=$hello_name;
           }

                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE AND assigned=:ASSIGNED');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->bindParam(':ASSIGNED', $ASSIGNED, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;        
        
    }

if($EXECUTE=='RAW') {
    
                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE AND ews_status_status=:WARNING');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->bindParam(':WARNING', $WARNING, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;     
    
}    

if($EXECUTE=='EWS_CANCELLED') {
    
                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :DATEFROM AND :DATETO AND warning IN ("CFO NEW","Lapsed NEW")');
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;     
    
}  
    
if($EXECUTE=='RAW_CANCELLED') {
    
                        $output = "Date Added, Colour, Policy Number, Client Name, Dob, Post Code, EWS Warning, ADL Warning, Last Premium, Premium, C.B Due, C.B Date, Start Date, Reqs, Our Notes, Assigned\n";
                    $query = $pdo->prepare('SELECT 
                        date_added,
                        ournotes,
    policy_number,
    client_name,
    dob,
    post_code,
    ews_status_status,
    warning,
    last_full_premium_paid,
    net_premium,
    clawback_due,
    clawback_date,
    policy_start_date,
    reqs,
    color_status,
    assigned
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :DATEFROM AND :DATETO AND ews_status_status IN ("CFO","Lapsed")');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                    $DATE_ADDED=filter_var($rs['date_added'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ournotes=filter_var($rs['ournotes'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $POLICY_NUM=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_status_status=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $warning=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $color_status=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ASSIGNED=filter_var($rs['assigned'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $output .= $DATE_ADDED.",".$color_status.",".$POLICY_NUM.",".$client_name.",".$dob.",".$post_code.",".$ews_status_status.",".$warning.",".$last_full_premium_paid.",".$net_premium.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$reqs.",".$ournotes.",".$ASSIGNED."\n";
                        
                    }
                    echo $output;
                    exit;     
    
}   

}
?>
