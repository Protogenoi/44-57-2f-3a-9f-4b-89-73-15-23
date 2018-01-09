<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

require_once(__DIR__ . '/../../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../../includes/adlfunctions.php');


if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();

        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
                    
if(isset($EXECUTE)) {
        $file="export";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    
    
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $commdate= filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);
    
if($EXECUTE=='1') {

                        $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT financial_statistics_history.payment_amount, client_policy.application_number ,client_policy.policy_number ,client_policy.sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
FROM financial_statistics_history 
JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
JOIN client_details on client_policy.client_id = client_details.client_id
WHERE client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto) AND DATE(financial_statistics_history.insert_date) =:commdate");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['payment_amount'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
                    }
                    echo $output;
                    exit;
}


if($EXECUTE=='2') {
                   $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT financial_statistics_history.payment_amount, client_policy.application_number ,client_policy.policy_number , CONCAT(DATE(client_policy.sale_date), ' | ', DATE(financial_statistics_history.insert_date)) AS sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
JOIN client_details on client_policy.client_id = client_details.client_id
WHERE client_policy.policy_number IN(select client_policy.policy_number from client_policy) AND DATE(financial_statistics_history.insert_date) =:commdate");
                    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['payment_amount'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
                    }
                    echo $output;
                    exit;
}

if($EXECUTE=='3') {

                        $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT financial_statistics_history.payment_amount, client_policy.application_number ,client_policy.policy_number ,client_policy.sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
FROM financial_statistics_history 
JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
JOIN client_details on client_policy.client_id = client_details.client_id
WHERE client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['payment_amount'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
                    }
                    echo $output;
                    exit;
} 

if($EXECUTE=='4') {
 
   
                        $output = "Policy Number, Client, COMM Amount\n";
                    $query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.policy_number, financial_statistics_history.policy_name from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount >= 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
                    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR);

                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['policy_number'].",".$rs['policy_name'].",".$rs['payment_amount']."\n";
                        
                    }
                    echo $output;
                    exit;
} 

if($EXECUTE=='5') {
     
                    $output = "Policy Number, Client, COMM Amount\n";
                    $query = $pdo->prepare("select financial_statistics_history.payment_amount, client_policy.policy_number, financial_statistics_history.policy_name from financial_statistics_history LEFT JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.payment_amount < 0 AND DATE(financial_statistics_history.insert_date) =:commdate AND client_policy.insurer ='Legal and General'");
                    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['policy_number'].",".$rs['policy_name'].",".$rs['payment_amount']."\n";
                        
                    }
                    echo $output;
                    exit;
} 

if($EXECUTE=='6') {
   
                    $output = "Sale Date, Policy, Client, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select DATE(client_policy.submitted_date) AS sale_date, client_policy.policystatus, client_policy.client_name, client_policy.policy_number, client_policy.commission
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.submitted_date) between :datefrom AND :dateto AND client_policy.insurer='Legal and General' AND client_policy.policystatus ='Awaiting' ORDER BY DATE(client_policy.submitted_date)");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['sale_date'].",".$rs['policy_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
} 

if($EXECUTE=='7') {

                    $output = "Sale Date, Policy, Client, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select DATE(client_policy.sale_date) AS sale_date, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.policy_number NOT IN(select financial_statistics_history.policy from financial_statistics_history) AND client_policy.insurer='Legal and General' AND client_policy.policystatus NOT like '%CANCELLED%' AND client_policy.policystatus NOT IN ('Live Awaiting Policy Number','Awaiting Policy Number','Clawback','SUBMITTED-NOT-LIVE','DECLINED') AND client_policy.policy_number NOT like '%DU%' AND client_policy.policy_number NOT like '%tbc%'");
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 100);
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 100);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['sale_date'].",".$rs['policy_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
}

if($EXECUTE=='ADL_UNPAID') {
    
                        $output = "Sale Date, Policy Number, Client Name, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select client_policy.policystatus, client_policy.client_name, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE
FROM
    client_policy
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN '2017-01-01' AND :dateto
        AND client_policy.policy_number NOT IN (SELECT 
            financial_statistics_history.policy
        FROM
            financial_statistics_history)
        AND client_policy.insurer = 'Legal and General'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Awaiting' , 'Clawback',
        'SUBMITTED-NOT-LIVE',
        'CANCELLED',
        'DECLINED')");
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 20);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['SALE_DATE'].",".$rs['policy_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
    
}

if($EXECUTE=='ADL_AWAITING') {
    
                        $output = "Submitted Date, Policy Number, AN, Client Name, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select client_policy.policystatus, client_policy.client_name, client_policy.application_number, client_policy.policy_number, client_policy.commission, DATE(client_policy.submitted_date) AS SALE_DATE
FROM
    client_policy
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(client_policy.submitted_date) BETWEEN :datefrom AND :dateto
        AND client_policy.insurer = 'Legal and General'
        AND client_policy.policystatus = 'Awaiting'");
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 20);
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 20);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['SALE_DATE'].",".$rs['policy_number'].",".$rs['application_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
    
}

if($EXECUTE=='ADL_NETGROSS') {
    
                        $output = "Sale Date, Policy Number, Client Name, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select client_policy.policystatus, client_policy.client_name, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Legal and General'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'DECLINED','On hold','Awaiting')");
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 20);
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 20);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['SALE_DATE'].",".$rs['policy_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
    
}

if($EXECUTE=='ADL_TOTALGROSS') {
    
                        $output = "Sale Date, Submitted Date, Policy Number, Client Name, ADL Amount, ADL Status\n";
                    $query = $pdo->prepare("select client_policy.policystatus, client_policy.client_name, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, DATE(client_policy.submitted_date) AS SUB_DATE
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Legal and General'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Legal and General'
        AND policystatus = 'Awaiting'");
    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR, 20);
    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR, 20);
    $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR, 20);
    $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR, 20);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['SALE_DATE'].",".$rs['SUB_DATE'].",".$rs['policy_number'].",".$rs['client_name'].",".$rs['commission'].",".$rs['policystatus']."\n";
                        
                    }
                    echo $output;
                    exit;
    
}

}
?>