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

$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {

$hello_name=$USER;
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
    
     if($EXECUTE=='6') {

     if(in_array($USER, $EWS_SEARCH_ACCESS,true)) {

$query = $pdo->prepare("SELECT 
    ews_data.client_name AS Name,
    ' ' AS Name2,
    client_policy.insurer AS company,
    ews_data.post_code AS post_code,
    ews_data.date_added AS submitted_date,
    client_policy.client_id AS client_id
FROM
    ews_data
        LEFT JOIN
    client_policy ON client_policy.policy_number = ews_data.policy_number");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
    }   
    
    else {
        
$query = $pdo->prepare("SELECT
                             company,
                             submitted_date, 
                             client_id, 
                             CONCAT(title, ' ', first_name, ' ', last_name) AS Name, 
                             CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, 
                             post_code 
                        FROM 
                            client_details 
                        ORDER BY 
                            client_id DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }
        
        }    
    
   if($EXECUTE=='8') {
       
$query = $pdo->prepare("SELECT 
    client_id,
    client_name,
    sale_date,
    application_number,
    policy_number,
    type,
    insurer,
    submitted_by,
    commission,
    CommissionType,
    PolicyStatus,
    submitted_date
FROM
    client_policy
WHERE
    DATE(submitted_date) >= '2013-01-01'");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));  

echo json_encode($results);
       
   }   

   if($EXECUTE=='9') {
       if(in_array($USER, $AUDIT_SEARCH_ACCESS,true)) {
           
           $YEAR= date('Y');
           $ALL_YEAR= "2011-01-01";
       
       $query = $pdo->prepare("SELECT
               company,submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code 
               FROM client_details 
               WHERE DATE(submitted_date) >=:YEAR 
               ORDER BY client_id DESC");
       $query->bindParam(':YEAR', $ALL_YEAR, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
       
   }   
   
   }
  
   if($EXECUTE==10) {
       
       $DATEFROM= filter_input(INPUT_GET, 'DATEFROM', FILTER_SANITIZE_SPECIAL_CHARS);
       $DATETO= filter_input(INPUT_GET, 'DATETO', FILTER_SANITIZE_SPECIAL_CHARS);
       $CLOSER= filter_input(INPUT_GET, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
       
       $CLOSER_LIKE="%$CLOSER%";
       
$query = $pdo->prepare("SELECT 
    client_id,
    client_name,
    sale_date,
    submitted_date,
    application_number,
    policy_number,
    insurer,
    submitted_by,
    commission,
    closer,
    lead,
    PolicyStatus
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :DATEFROM AND :DATETO AND closer LIKE :CLOSER");
    $query->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR, 100);
    $query->bindParam(':DATETO', $DATETO, PDO::PARAM_STR, 100);
    $query->bindParam(':CLOSER', $CLOSER_LIKE, PDO::PARAM_STR, 100);
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));  

echo json_encode($results);       
       
   }
            
        }            
            
}

} else {

    header('Location: /../../../../CRMmain.php');
    die;
    
}
?>

