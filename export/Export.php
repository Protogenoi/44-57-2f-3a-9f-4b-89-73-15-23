<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

    include('../includes/Access_Levels.php');
    if (!in_array($hello_name,$Level_10_Access, true)) {
        header('Location: ../CRMmain.php?AccessDenied'); die;
        
    }

$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($query)) {
    include('../includes/ADL_PDO_CON.php');
    
    $datefrom= filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $dateto= filter_input(INPUT_POST, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $file="export";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    
    
    if($query=='HOME') {
        $output = "Application Number, policy_number,sale_date, title, client_name, Surname, phone_number,alt_number,dob,email,address,address2,town,post,premium,type,commission, Paid to HWIFS, Net Paid, lead/closer,status,insurer,added_by,company,added_date\n";
        $query = $pdo->prepare("SELECT '' AS empty_col, home_policy.policy_number, home_policy.sale_date, '' AS empty_col, home_policy.client_name, '' AS empty_col, client_details.phone_number,  client_details.alt_number, CONCAT(client_details.dob,' - ',client_details.dob2) AS dob, client_details.email, client_details.address1, client_details.address2, CONCAT(client_details.address3, ' ', client_details.town) AS address3, client_details.post_code, home_policy.premium, home_policy.type, home_policy.commission, '' AS empty_col, '' AS empty_col, CONCAT(home_policy.lead, '/', home_policy.closer) AS agents, home_policy.status, home_policy.insurer, home_policy.added_by, client_details.company, client_details.submitted_date FROM home_policy LEFT JOIN client_details ON home_policy.client_id=client_details.client_id WHERE DATE(home_policy.sale_date) between :datefrom and :dateto OR (DATE(home_policy.added_date) between :datefrom2 and :dateto2) AND client_details.company ='TRB Home Insurance'");
        $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
        $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
        $query->execute();
        
        $list = $query->fetchAll();
        foreach ($list as $rs) {
            $output .= $rs['empty_col'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['empty_col'].",".$rs['client_name'].",".$rs['empty_col'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['dob'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['address3'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['empty_col'].",".$rs['empty_col'].",".$rs['agents'].",".$rs['status'].",".$rs['insurer'].",".$rs['added_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
            
        }
        echo $output;
        exit;
        
        }
        
        if($query=='LIFE') {
            $output = "Application_Number,Policy_Number,Sale_Date,Title,Forename,Surname,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Paid_to_HWIFS,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT client_policy.application_number, client_policy.policy_number, client_policy.sale_date, '' AS empty_col , client_policy.client_name, '' AS empty_col , client_details.phone_number,  client_details.alt_number, CONCAT(client_details.dob,' - ',client_details.dob2) AS CDOB, client_details.email, client_details.address1, client_details.address2, CONCAT(client_details.address3, ' ', client_details.town) AS TOWN, client_details.post_code, client_policy.premium, client_policy.type, client_policy.commission,'' AS empty_col ,'' AS empty_col2 , CONCAT(client_policy.lead, '/', client_policy.closer) AS AGENTS, client_policy.policystatus, client_policy.insurer, client_policy.submitted_by, client_details.company, client_details.submitted_date FROM  client_policy LEFT JOIN client_details ON client_policy.client_id=client_details.client_id WHERE DATE(client_policy.sale_date) between :datefrom and :dateto OR (DATE(client_policy.submitted_date) between :datefrom2 and :dateto2) AND client_details.company ='The Review Bureau'");
            $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
            $query->execute();
            
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['empty_col'].",".$rs['client_name'].",".$rs['empty_col'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['empty_col'].",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            
            }
            
            if($query=='VITALITYLIFE') {
                $output = "Application_Number,Policy_Number,Sale_Date,Title,Forename,Surname,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Paid_to_HWIFS,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
                $query = $pdo->prepare("SELECT client_policy.application_number, client_policy.policy_number, client_policy.sale_date, '' AS empty_col , client_policy.client_name, '' AS empty_col , client_details.phone_number,  client_details.alt_number, CONCAT(client_details.dob,' - ',client_details.dob2) AS CDOB, client_details.email, client_details.address1, client_details.address2, CONCAT(client_details.address3, ' ', client_details.town) AS TOWN, client_details.post_code, client_policy.premium, client_policy.type, client_policy.commission,'' AS empty_col ,'' AS empty_col2 , CONCAT(client_policy.lead, '/', client_policy.closer) AS AGENTS, client_policy.policystatus, client_policy.insurer, client_policy.submitted_by, client_details.company, client_details.submitted_date FROM client_policy LEFT JOIN client_details ON client_policy.client_id=client_details.client_id WHERE DATE(client_policy.sale_date) between :datefrom and :dateto OR (DATE(client_policy.submitted_date) between :datefrom2 and :dateto2) AND client_details.company ='TRB Vitality'");
                $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
                $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
                $query->execute();
                
                $list = $query->fetchAll();
                foreach ($list as $rs) {
                    $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['empty_col'].",".$rs['client_name'].",".$rs['empty_col'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['empty_col'].",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                    
                }
                echo $output;
                exit;
                
                } 
                
                if($query=='LIFEFINANCIALS') {
                    $output = "insert_date, Transmission Date,Transmission Time,Payment Date,Master Agency No,FRN Number,Sub Agency No,Policy Type,Policy,Broker Ref,Reason Code,Party,Policy Name,Initial,Product Description,Payment Type,Payment_Amount,Payment_Currency,Payment Basis,Payment Code,Payment Due Date,Premium Type,Premium Amount,Premium_Currency, Premium Frequency,Payment Reason,Scheme Number,Scheme Name\n";
                    $query = $pdo->prepare("SELECT insert_date,Transmission_Date,Transmission_Time,Payment_Date,Master_Agency_No,FRN_Number,Sub_Agency_No,Policy_Type,Policy,Broker_Ref,Reason_Code,Party,Policy_Name,Initial,Product_Description,Payment_Type,Payment_Amount,Payment_Currency,Premium_Currency, Payment_Basis,Payment_Code,Payment_Due_Date,Premium_Type,Premium_Amount,Premium_Frequency,Payment_Reason,Scheme_Number,Scheme_Name FROM financial_statistics_history WHERE DATE(insert_date) between :datefrom and :dateto");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['insert_date'].",".$rs['Transmission_Date'].",".$rs['Transmission_Time'].",".$rs['Payment_Date'].",".$rs['Master_Agency_No'].",".$rs['FRN_Number'].",".$rs['Sub_Agency_No'].",".$rs['Policy_Type'].",".$rs['Policy'].",".$rs['Broker_Ref'].",".$rs['Reason_Code'].",".$rs['Party'].",".$rs['Policy_Name'].",".$rs['Initial'].",".$rs['Product_Description'].",".$rs['Payment_Type'].",".$rs['Payment_Amount'].",".$rs['Premium_Currency'].",".$rs['Payment_Currency'].",".$rs['Payment_Basis'].",".$rs['Payment_Code'].",".$rs['Payment_Due_Date'].",".$rs['Premium_Type'].",".$rs['Premium_Amount'].",".$rs['Premium_Frequency'].",".$rs['Payment_Reason'].",".$rs['Scheme_Number'].",".$rs['Scheme_Name']."\n";
                        
                    }
                    echo $output;
                    exit;
                    
                    } 
                    
                    }
                    
if(isset($EXECUTE)) {
        $file="export";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    
    include('../includes/ADL_PDO_CON.php');
    
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $commdate= filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);
    
if($EXECUTE=='1') {

                        $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT client_policy.application_number ,client_policy.policy_number ,client_policy.sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
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
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['title'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
                    }
                    echo $output;
                    exit;
}


if($EXECUTE=='2') {
                        $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT client_policy.application_number ,client_policy.policy_number ,client_policy.sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
FROM financial_statistics_history 
LEFT JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
LEFT JOIN client_details on client_policy.client_id = client_details.client_id
WHERE DATE(financial_statistics_history.insert_date) =:commdate");
                    $query->bindParam(':commdate', $commdate, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['title'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
                    }
                    echo $output;
                    exit;
}

if($EXECUTE=='3') {

                        $output = "Application Number, Policy Number, Sale Date, Title, Forename, Surname, Tel, Alt Tel, DOB, Email, Address Line 1, Address Line 2, Town, Postcode, Premium, Type, Commission, Paid to HWIFS, Net Paid, Closer, Status, Insurer, Owner, Company, Date Added\n";
                    $query = $pdo->prepare("SELECT client_policy.application_number ,client_policy.policy_number ,client_policy.sale_date ,'' AS title, client_policy.client_name, '' AS forename, client_details.phone_number ,client_details.alt_number ,CONCAT(client_details.dob, '-',client_details.dob2) AS DOB ,client_details.email ,client_details.address1 ,client_details.address2 ,client_details.town ,client_details.post_code ,client_policy.premium ,client_policy.type ,client_policy.commission ,'' AS HWIFS ,'' AS net , CONCAT(client_policy.closer, '-',client_policy.lead) AS CLOSER ,client_policy.policystatus ,client_policy.insurer ,client_policy.submitted_by ,client_details.company ,client_policy.submitted_date
FROM financial_statistics_history 
JOIN client_policy ON financial_statistics_history.policy=client_policy.policy_number 
JOIN client_details on client_policy.client_id = client_details.client_id
WHERE client_policy.policy_number IN(select client_policy.policy_number from client_policy WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto)");
                    $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
                    $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                    $query->execute();
                    
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                        $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['title'].",".$rs['client_name'].",".$rs['forename'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['DOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['town'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$rs['HWIFS'].",".$rs['net'].",".$rs['CLOSER'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                        
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
                    $query = $pdo->prepare("select DATE(client_policy.sale_date) AS sale_date, client_policy.policystatus, client_policy.client_name, client_policy.policy_number, client_policy.commission
FROM client_policy
LEFT JOIN financial_statistics_history ON financial_statistics_history.policy=client_policy.policy_number 
WHERE DATE(client_policy.sale_date) between :datefrom AND :dateto AND client_policy.insurer='Legal and General' AND client_policy.policystatus IN ('Awaiting Policy Number','Live Awaiting Policy Number') ORDER BY DATE(client_policy.sale_date)");
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
                    $query = $pdo->prepare("select DATE(client_policy.sale_date) AS SALE_DATE, client_policy.policystatus, client_policy.client_name, client_policy.id AS PID, client_policy.client_id AS CID, client_policy.policy_number, client_policy.commission, DATE(client_policy.sale_date) AS SALE_DATE, financial_statistics_history.policy, financial_statistics_history.payment_amount, DATE(financial_statistics_history.insert_date) AS COMM_DATE 
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

}
?>
