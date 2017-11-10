<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../../classes/database_class.php');
    require_once(__DIR__ . '../../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {

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

                        $output = "    master_agent_no,agent_no, policy_number,client_name,    dob,    address1,    address2,    address3,    address4,    post_code,    policy_type,    warning,    last_full_premium_paid,    net_premium,    premium_os,    clawback_due,    clawback_date,    policy_start_date,    off_risk_date,    seller_name,    frn,reqs\n";
                    $query = $pdo->prepare('SELECT 
                            master_agent_no,
    agent_no,
    policy_number,
    client_name,
    dob,
    address1,
    address2,
    address3,
    address4,
    post_code,
    policy_type,
    ews_status_status,
    last_full_premium_paid,
    net_premium,
    premium_os,
    clawback_due,
    clawback_date,
    policy_start_date,
    off_risk_date,
    seller_name,
    frn,
    reqs
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE');
                    $query->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                        
                    $master_agent_no=filter_var($rs['master_agent_no'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $agent_no=filter_var($rs['agent_no'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $policy_number=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address1=filter_var($rs['address1'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address2=filter_var($rs['address2'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address3=filter_var($rs['address3'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address4=filter_var($rs['address4'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_type=filter_var($rs['policy_type'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_warning_warning=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $premium_os=filter_var($rs['premium_os'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $off_risk_date=filter_var($rs['off_risk_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $seller_name=filter_var($rs['seller_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $frn=filter_var($rs['frn'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        
                        $output .= $master_agent_no.",".$agent_no.",".$policy_number.",".$client_name.",".$dob.",".$address1.",".$address2.",".$address3.",".$address4.",".$post_code.",".$policy_type.",".$ews_warning_warning.",".$last_full_premium_paid.",".$net_premium.",".$premium_os.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$off_risk_date.",".$seller_name.",".$frn.",".$reqs."\n";
                        
                    }
                    echo $output;
                    exit;        
        
    }    
    
if($EXECUTE=='RAW_EWS_DATES') {

                        $output = "    master_agent_no,agent_no, policy_number,client_name,    dob,    address1,    address2,    address3,    address4,    post_code,    policy_type,    warning,    last_full_premium_paid,    net_premium,    premium_os,    clawback_due,    clawback_date,    policy_start_date,    off_risk_date,    seller_name,    frn,reqs,adl id,adl warning, colour\n";
                    $query = $pdo->prepare('SELECT 
                            master_agent_no,
    agent_no,
    policy_number,
    client_name,
    dob,
    address1,
    address2,
    address3,
    address4,
    post_code,
    policy_type,
    ews_status_status,
    last_full_premium_paid,
    net_premium,
    premium_os,
    clawback_due,
    clawback_date,
    policy_start_date,
    off_risk_date,
    seller_name,
    frn,
    reqs,
    warning,
    id,
    color_status
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :DATEFROM AND :DATETO');
                    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
                    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        
                        
                    $master_agent_no=filter_var($rs['master_agent_no'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $agent_no=filter_var($rs['agent_no'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $policy_number=filter_var($rs['policy_number'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $client_name=filter_var($rs['client_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $dob=filter_var($rs['dob'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address1=filter_var($rs['address1'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address2=filter_var($rs['address2'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address3=filter_var($rs['address3'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $address4=filter_var($rs['address4'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $post_code=filter_var($rs['post_code'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $policy_type=filter_var($rs['policy_type'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ews_warning_warning=filter_var($rs['ews_status_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $last_full_premium_paid=filter_var($rs['last_full_premium_paid'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $net_premium=filter_var($rs['net_premium'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $premium_os=filter_var($rs['premium_os'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_due=filter_var($rs['clawback_due'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $clawback_date=filter_var($rs['clawback_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $policy_start_date=filter_var($rs['policy_start_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $off_risk_date=filter_var($rs['off_risk_date'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $seller_name=filter_var($rs['seller_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $frn=filter_var($rs['frn'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $reqs=filter_var($rs['reqs'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        $ADL_ID=filter_var($rs['id'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ADL_WARNING=filter_var($rs['warning'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $ADL_COLOUR=filter_var($rs['color_status'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        
                        
                        $output .= $master_agent_no.",".$agent_no.",".$policy_number.",".$client_name.",".$dob.",".$address1.",".$address2.",".$address3.",".$address4.",".$post_code.",".$policy_type.",".$ews_warning_warning.",".$last_full_premium_paid.",".$net_premium.",".$premium_os.",".$clawback_due.",".$clawback_date.",".$policy_start_date.",".$off_risk_date.",".$seller_name.",".$frn.",".$reqs.",".$ADL_WARNING.",".$ADL_ID.",".$ADL_COLOUR."\n";
                        
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
}

} else {

    header('Location: /../../CRMmain.php');
    die;
    
}   
?>
