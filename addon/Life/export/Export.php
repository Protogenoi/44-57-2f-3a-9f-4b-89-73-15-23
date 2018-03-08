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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');


if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();

        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
                if($COMPANY_ENTITY=='Bluestone Protect') {
                    $simply_biz = "2.5";
                } elseif($COMPANY_ENTITY=='First Priority Group') {
                    $simply_biz = "5.0";
                } else{
                    $simply_biz = "0.0";
                }
    
    $DATE_FROM= filter_input(INPUT_POST, 'DATE_FROM', FILTER_SANITIZE_SPECIAL_CHARS);
    $DATE_TO= filter_input(INPUT_POST, 'DATE_TO', FILTER_SANITIZE_SPECIAL_CHARS);
    $INSURER= filter_input(INPUT_POST, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $file="export";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');       
    
           if($EXECUTE=='1') {
            
         if(isset($INSURER)) {
          if($INSURER == 'One Family') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,Email,Address_1,Address_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    one_family_financial.one_family_financial_commission_amount AS FIN_AMOUNT,
    one_family_financial.one_family_financial_transaction_type, 
    client_policy.application_number,
    client_policy.policy_number AS POLICY_NUMBER,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(one_family_financial.one_family_financial_uploaded_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    one_family_financial ON one_family_financial.one_family_financial_policy_id = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto AND client_policy.insurer='One Family'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2 AND client_policy.insurer='One Family'");
            $query->bindParam(':datefrom', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto', $DATE_TO, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $DATE_TO, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
            $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
            $pipe=$rs['commission']-$ADL_AMOUNT;  
            $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
            $NON_INDEM_COM=$rs['non_indem_com'];

            if(empty($rs['FIN_AMOUNT'])) {
                $rs['FIN_AMOUNT']='NOT PAID';
            }

        if($rs['one_family_financial_transaction_type'] == 'BACS_OUT') {
            
$PAYMENT_AMOUNT=abs($rs['FIN_AMOUNT']);            
            
        }   elseif($rs['one_family_financial_transaction_type'] =='INTCOM') {
            
            $PAYMENT_AMOUNT=$rs['FIN_AMOUNT']." (INTCOM)";
            
        }  
        
elseif($rs['one_family_financial_transaction_type'] =='INTCOMCB') {
            
            $PAYMENT_AMOUNT=$rs['FIN_AMOUNT'];
            
        }       
        else {
            
        $PAYMENT_AMOUNT=$rs['FIN_AMOUNT'];    
            $PAYMENT_AMOUNT='NOT PAID';
        }  
        
            if(empty($rs['FIN_AMOUNT'])) {
                $PAYMENT_AMOUNT='NOT PAID';
            }        
            
                
                $output .= $rs['application_number'].",".$rs['POLICY_NUMBER'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,$PAYMENT_AMOUNT,".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }             
             if($INSURER == 'Vitality') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,Email,Address_1,Address_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    vitality_financial.vitality_financial_amount AS FIN_AMOUNT,
    client_policy.application_number,
    client_policy.policy_number AS POLICY_NUMBER,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(vitality_financial.vitality_financial_uploaded_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto AND client_policy.insurer='Vitality'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2 AND client_policy.insurer='Vitality'");
            $query->bindParam(':datefrom', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto', $DATE_TO, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $DATE_TO, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
            $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
            $pipe=$rs['commission']-$ADL_AMOUNT;  
            $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
            $NON_INDEM_COM=$rs['non_indem_com'];

            if(empty($rs['FIN_AMOUNT'])) {
                $rs['FIN_AMOUNT']='NOT PAID';
            }

                
                $output .= $rs['application_number'].",".$rs['POLICY_NUMBER'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['FIN_AMOUNT'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            } 
            
           if($INSURER == 'LV') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,Email,Address_1,Address_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    lv_financial.lv_financial_indemnity AS FIN_AMOUNT,
    client_policy.application_number,
    client_policy.policy_number AS POLICY_NUMBER,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(lv_financial.lv_financial_uploaded_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    lv_financial ON lv_financial.lv_financial_policy = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto AND client_policy.insurer='LV'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2 AND client_policy.insurer='LV'");
            $query->bindParam(':datefrom', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto', $DATE_TO, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $DATE_TO, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
            $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
            $pipe=$rs['commission']-$ADL_AMOUNT;  
            $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
            $NON_INDEM_COM=$rs['non_indem_com'];

            if(empty($rs['FIN_AMOUNT'])) {
                $rs['FIN_AMOUNT']='NOT PAID';
            }

                
                $output .= $rs['application_number'].",".$rs['POLICY_NUMBER'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['FIN_AMOUNT'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }             
            
            if($INSURER == 'Royal London') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,Email,Address_1,Address_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    royal_london_financial.royal_london_financial_commission_credit_amount AS CREDIT,
    royal_london_financial.royal_london_financial_commission_debits_amount AS DEBITS,
    client_policy.application_number,
    client_policy.policy_number AS POLICY_NUMBER,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(royal_london_financial.royal_london_financial_uploaded_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    royal_london_financial ON royal_london_financial.royal_london_financial_plan_number = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto AND client_policy.insurer='Royal London'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2 AND client_policy.insurer='Royal London'");
            $query->bindParam(':datefrom', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto', $DATE_TO, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $DATE_FROM, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $DATE_TO, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
            $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
            $pipe=$rs['commission']-$ADL_AMOUNT;  
            $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
            $NON_INDEM_COM=$rs['non_indem_com'];

            if(empty($rs['CREDIT'])) {
                $CREDITS='NO CREDITS';
            } else {
                $CREDITS=$rs['CREDIT'];
            }
            if(empty($rs['DEBITS'])) {
                $DEBITS='NO DEBITS';
            }   else {
                $DEBITS=$rs['DEBITS'];
            }         

            $AMOUNT="$CREDITS | $DEBITS";
                
                $output .= $rs['application_number'].",".$rs['POLICY_NUMBER'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$AMOUNT.",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }            
            
            
}           
}
}


if(isset($query)) {
    
                    if($COMPANY_ENTITY=='Bluestone Protect') {
                    $simply_biz = "2.5";
                } elseif($COMPANY_ENTITY=='First Priority Group') {
                    $simply_biz = "5.0";
                } else{
                    $simply_biz = "0.0";
                }
    
    $datefrom= filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
    $dateto= filter_input(INPUT_POST, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $file="export";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    
       
        
        if($query=='LIFE') {
            
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    financial_statistics_history.payment_amount,
    client_policy.application_number,
    client_policy.policy_number,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(financial_statistics_history.insert_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2");
            $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
                 $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
                $pipe=$rs['commission']-$ADL_AMOUNT;  
                $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
                $NON_INDEM_COM=$rs['non_indem_com'];


                
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['payment_amount'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }
                      
    if($query=='BYUSER') {
        
            $USER= filter_input(INPUT_POST, 'USER', FILTER_SANITIZE_SPECIAL_CHARS);

            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    financial_statistics_history.payment_amount,
    client_policy.application_number,
    client_policy.policy_number,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(financial_statistics_history.insert_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    insurer ='Legal and General' AND client_policy.submitted_by=:USER;");
            $query->bindParam(':USER', $USER, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
                 $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
                $pipe=$rs['commission']-$ADL_AMOUNT;  
                $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
                $NON_INDEM_COM=$rs['non_indem_com'];

                
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['payment_amount'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }
            
        if($query=='JUSTLIFE') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    financial_statistics_history.payment_amount,
    client_policy.application_number,
    client_policy.policy_number,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(financial_statistics_history.insert_date) AS insert_date,
    '' AS empty_col,
    client_policy.client_name,
    '' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Legal and General'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Legal and General'
        AND policystatus = 'Awaiting'");
            $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
                 $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
                $pipe=$rs['commission']-$ADL_AMOUNT;  
                $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
                $NON_INDEM_COM=$rs['non_indem_com'];

                
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['payment_amount'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }    
            
          if($query=='OTHER') {
            
            $output = "Application_Number,Policy_Number, Sale_THEN_OLP_Date,COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,Net_Paid,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
    financials.financials_payment,
    client_policy.application_number,
    client_policy.policy_number,
    CONCAT(DATE(client_policy.submitted_date), ' - ',
    DATE(client_policy.sale_date)) as sale_sub,
    client_policy.commission,
    DATE(financials.financials_insert) AS insert_date,
    ' ' AS empty_col,
    client_policy.client_name,
    ' ' AS empty_col,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    '' AS empty_col2,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    financials ON financials.financials_policy = client_policy.policy_number
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer IN ('Royal London','One Family','Engage Mutual','Aviva','Vitality')
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer IN ('Royal London','One Family','Engage Mutual','Aviva','Vitality')
        AND policystatus = 'Awaiting'");
            $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
                $INSURER=$rs['insurer'];             
                
                 $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
                $pipe=$rs['commission']-$ADL_AMOUNT;  
                $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
                $NON_INDEM_COM=$rs['non_indem_com'];

                
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_sub'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['financials_payment'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['empty_col2'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
            }
            echo $output;
            exit;
            }        
            
        if($query=='LIFECOMM') {
            
            $output = "Application_Number,Policy_Number, Sale_Date, COMM Date,Forename,ADL Amount,COMM Amount,Tel,Alt_Tel,DOB,EMail,Address_Line_1,Address_Line_2,Town,Postcode,Premium,Type,Commission,Non-Idem Comm,COMM_NAME,Closer,Status,Insurer,Owner,Company,Date_Added\n";
            $query = $pdo->prepare("SELECT 
	client_policy.application_number,
    client_policy.policy_number,
    DATE(client_policy.sale_date) AS sale_date,
    client_policy.commission,
    financial_statistics_history.payment_amount,
    DATE(financial_statistics_history.insert_date) AS insert_date,
    client_policy.client_name,
    client_details.phone_number,
    client_details.alt_number,
    CONCAT(client_details.dob,
            ' - ',
            client_details.dob2) AS CDOB,
    client_details.email,
    client_details.address1,
    client_details.address2,
    CONCAT(client_details.address3,
            ' ',
            client_details.town) AS TOWN,
    client_details.post_code,
    client_policy.premium,
    client_policy.type,
    client_policy.commission,
    '' AS empty_col,
    financial_statistics_history.Policy_Name AS Policy_Name,
    CONCAT(client_policy.lead,
            '/',
            client_policy.closer) AS AGENTS,
    client_policy.policystatus,
    client_policy.insurer,
    client_policy.submitted_by,
    client_details.company,
    client_details.submitted_date,
    client_policy.non_indem_com
FROM
    client_policy
        LEFT JOIN
    client_details ON client_policy.client_id = client_details.client_id
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
        OR (DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2)
        OR (DATE(financial_statistics_history.insert_date) BETWEEN :datefrom3 AND :dateto3)");
            $query->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
            $query->bindParam(':datefrom3', $datefrom, PDO::PARAM_STR);
            $query->bindParam(':dateto3', $dateto, PDO::PARAM_STR);
            $query->execute();
            $list = $query->fetchAll();
            foreach ($list as $rs) {
                
                 $ADL_AMOUNT = ($simply_biz/100) * $rs['commission'];
                $pipe=$rs['commission']-$ADL_AMOUNT;  
                $ADL_SUM = number_format($pipe, 2, '.', '.' ); 
                $NON_INDEM_COM=$rs['non_indem_com'];
                
                $output .= $rs['application_number'].",".$rs['policy_number'].",".$rs['sale_date'].",".$rs['insert_date'].",".$rs['client_name'].",$ADL_SUM,".$rs['payment_amount'].",".$rs['phone_number'].",".$rs['alt_number'].",".$rs['CDOB'].",".$rs['email'].",".$rs['address1'].",".$rs['address2'].",".$rs['TOWN'].",".$rs['post_code'].",".$rs['premium'].",".$rs['type'].",".$rs['commission'].",".$NON_INDEM_COM.",".$rs['Policy_Name'].",".$rs['AGENTS'].",".$rs['policystatus'].",".$rs['insurer'].",".$rs['submitted_by'].",".$rs['company'].",".$rs['submitted_date']."\n";
                
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
?>