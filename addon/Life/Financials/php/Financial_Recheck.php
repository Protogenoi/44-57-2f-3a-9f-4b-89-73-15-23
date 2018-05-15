<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/adl_features.php');

require_once(__DIR__ . '/../../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}  

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);    
$RECHECK= filter_input(INPUT_GET, 'RECHECK', FILTER_SANITIZE_SPECIAL_CHARS);
$INSURER= filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);  
$AMOUNT= filter_input(INPUT_GET, 'AMOUNT', FILTER_SANITIZE_SPECIAL_CHARS);


$INSURER_ARRAY=array('LG','One Family','Royal London','Aviva','Vitality','LV');

if(!in_array($INSURER, $INSURER_ARRAY)) {
    
    if(isset($datefrom)) {
        header('Location: /addon/Life/Financials/Financial.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;
        
    } else {
        header('Location: /addon/Life/Financials/Financial.php?INVALID'); die;
        
    }
    
}

if(isset($EXECUTE) && $EXECUTE==10) {
    if($INSURER=='LG') {
        
        $i=0;
        
            $Icheck = $pdo->prepare("SELECT id, policy_number, payment_amount FROM financial_statistics_nomatch");
            $Icheck->execute();
            if ($Icheck->rowCount() >= 1) {  
            while ($result=$Icheck->fetch(PDO::FETCH_ASSOC)){ 
            
            $POL_NUM=$result['policy_number'];
            $FID=$result['id'];
            $AMOUNT=$result['payment_amount'];
                    
                $SELECT_Q = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $SELECT_Q->bindParam(':polhold', $POL_NUM, PDO::PARAM_STR);
                $SELECT_Q->execute();
                $result=$SELECT_Q->fetch(PDO::FETCH_ASSOC);   
                if ($SELECT_Q->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];     
                    
                    $note="Financial Uploaded";
                    
                    if($AMOUNT >= 0) {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($AMOUNT < 0) {
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus=:policystatus, edited=:sent WHERE id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':policystatus', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }
                    
                }
            }
           
                                        header('Location: /addon/Life/Financials/Financials.php?UPDATED='.$i); die;    

        
    }   
    
    if($INSURER=='LV') {
        
        $i=0;
        
            $Icheck = $pdo->prepare("SELECT lv_financial_nomatch_id, lv_financial_nomatch_policy_number, lv_financial_nomatch_indemnity FROM lv_financial_nomatch");
            $Icheck->execute();
            if ($Icheck->rowCount() >= 1) {  
            while ($result=$Icheck->fetch(PDO::FETCH_ASSOC)){ 
            
            $POL_NUM=$result['lv_financial_nomatch_policy_number'];
            $FID=$result['lv_financial_nomatch_id'];
            $AMOUNT=$result['lv_financial_nomatch_indemnity'];
            
            
            
            if(strlen($POLICY_NUMBER_CHECK) > 7) {
            $POLICY_NUMBER_CHECK=substr($POL_NUM, 0, -6);
            
            }
            
            else {
                $POLICY_NUMBER_CHECK =$POL_NUM;
            }
                    
                $SELECT_Q = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $SELECT_Q->bindParam(':polhold', $POLICY_NUMBER_CHECK, PDO::PARAM_STR);
                $SELECT_Q->execute();
                $result=$SELECT_Q->fetch(PDO::FETCH_ASSOC);   
                if ($SELECT_Q->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];     
                    
                    $note="LV Financial Uploaded";
                    
                    if($AMOUNT >= 0) {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($AMOUNT < 0) {
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus=:policystatus, edited=:sent WHERE id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':policystatus', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM lv_financial_nomatch WHERE lv_financial_nomatch_policy_number=:pol AND lv_financial_nomatch_id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $POL_NUM, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }
                    
                }
            }
           
                                        header('Location: /addon/Life/Financials/Financial.php?UPDATED='.$i); die;    

        
    }  
    
    if($INSURER=='One Family') {
        
        $i=0;
        
            $Icheck = $pdo->prepare("SELECT one_family_financial_nomatch_id, one_family_financial_nomatch_transaction_type, one_family_financial_nomatch_policy_id, one_family_financial_nomatch_commission_amount FROM one_family_financial_nomatch");
            $Icheck->execute();
            if ($Icheck->rowCount() >= 1) {  
            while ($result=$Icheck->fetch(PDO::FETCH_ASSOC)){ 
            
            $POL_NUM=$result['one_family_financial_nomatch_policy_id'];
            $FID=$result['one_family_financial_nomatch_id'];
            $AMOUNT=$result['one_family_financial_nomatch_commission_amount'];
            $TYPE=$result['one_family_financial_nomatch_transaction_type'];
                    
                $SELECT_Q = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $SELECT_Q->bindParam(':polhold', $POL_NUM, PDO::PARAM_STR);
                $SELECT_Q->execute();
                $result=$SELECT_Q->fetch(PDO::FETCH_ASSOC);   
                if ($SELECT_Q->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];     
                    
                    $note="One Family Financial Uploaded";
                    
                    if($TYPE == 'BACS_OUT') {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($TYPE == 'INTCOMCB') {
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus=:policystatus, edited=:sent WHERE id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':policystatus', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM one_family_financial_nomatch WHERE one_family_financial_nomatch_policy_id=:pol AND one_family_financial_nomatch_id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }
                    
                }
            }
           
                                        header('Location: /addon/Life/Financials/Financial.php?UPDATED='.$i); die;    

        
    }   
    
    if($INSURER=='Vitality') {
        
        $i=0;
        
            $Icheck = $pdo->prepare("SELECT vitality_financial_nomatch_id, vitality_financial_nomatch_policy_number, vitality_financial_nomatch_amount FROM vitality_financial_nomatch");
            $Icheck->execute();
            if ($Icheck->rowCount() >= 1) {  
            while ($result=$Icheck->fetch(PDO::FETCH_ASSOC)){ 
            
            $POL_NUM=$result['vitality_financial_nomatch_policy_number'];
            $FID=$result['vitality_financial_nomatch_id'];
            $AMOUNT=$result['vitality_financial_nomatch_amount'];
                    
                $SELECT_Q = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $SELECT_Q->bindParam(':polhold', $POL_NUM, PDO::PARAM_STR);
                $SELECT_Q->execute();
                $result=$SELECT_Q->fetch(PDO::FETCH_ASSOC);   
                if ($SELECT_Q->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];     
                    
                    $note="Vitality Financial Uploaded";
                    
                    if($AMOUNT >= 0) {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($AMOUNT < 0) {
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus=:policystatus, edited=:sent WHERE id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':policystatus', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM vitality_financial_nomatch WHERE vitality_financial_nomatch_policy_number=:pol AND vitality_financial_nomatch_id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }
                
                $NEW_VITAL = $pdo->prepare("
                    SELECT
                        adl_policy_id, 
                        adl_policy_client_id_fk, 
                        adl_policy_ref, 
                        adl_policy_status 
                    FROM 
                        adl_policy 
                    WHERE 
                        adl_policy_ref = :polhold");
                $NEW_VITAL->bindParam(':polhold', $POL_NUM, PDO::PARAM_STR);
                $NEW_VITAL->execute();
                $row=$NEW_VITAL->fetch(PDO::FETCH_ASSOC);   
                if ($NEW_VITAL->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$row['adl_policy_client_id_fk'];
                    $PID=$row['adl_policy_id'];
                    $policynumber=$row['adl_policy_ref'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$row['adl_policy_status'];     
                    
                    $note="Vitality Financial Uploaded";
                    
                    if($AMOUNT >= 0) {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($AMOUNT < 0) {
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE adl_policy set adl_policy_status=:STATUS, adl_policy_updated_by=:EDIT WHERE adl_policy_id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':EDIT', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':STATUS', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM vitality_financial_nomatch WHERE vitality_financial_nomatch_policy_number=:pol AND vitality_financial_nomatch_id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }                
                    
                }
            }
           
                                        header('Location: /addon/Life/Financials/Financial.php?UPDATED='.$i); die;    

        
    } 
    
     if($INSURER=='Royal London') {
        
        $i=0;
        
            $Icheck = $pdo->prepare("SELECT royal_london_financial_nomatch_id, royal_london_financial_nomatch_plan_number, royal_london_financial_nomatch_commission_credit_amount, royal_london_financial_nomatch_commission_debits_amount FROM royal_london_financial_nomatch");
            $Icheck->execute();
            if ($Icheck->rowCount() >= 1) {  
            while ($result=$Icheck->fetch(PDO::FETCH_ASSOC)){ 
            
            $POL_NUM=$result['royal_london_financial_nomatch_plan_number'];
            $FID=$result['royal_london_financial_nomatch_id'];
            $CREDIT=$result['royal_london_financial_nomatch_commission_credit_amount'];
            $DEBITS=$result['royal_london_financial_nomatch_commission_debits_amount'];
                    
                $SELECT_Q = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $SELECT_Q->bindParam(':polhold', $POL_NUM, PDO::PARAM_STR);
                $SELECT_Q->execute();
                $result=$SELECT_Q->fetch(PDO::FETCH_ASSOC);   
                if ($SELECT_Q->rowCount() >= 1) {  
                    
                    $i++;
                
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];     
                    
                    $note="Royal London Financial Uploaded";
                    
                    if($CREDIT > $DEBITS) {  
                    
                    $message="COMM (Status changed from $polstat to Live)";
                    $POL_STATUS='Live';
                    
                    } elseif($DEBITS > $CREDIT) { 
                        
                        $message="COMM (Status changed from $polstat to Clawback)";
                        $POL_STATUS='Clawback';
                        
                    } else {
                        
                        $message="ERROR";
                        $POL_STATUS='ERROR';                        
                        
                    }
                        
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus=:policystatus, edited=:sent WHERE id=:PID");
                    $update->bindParam(':PID', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->bindParam(':policystatus', $POL_STATUS, PDO::PARAM_STR, 50);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM royal_london_financial_nomatch WHERE royal_london_financial_nomatch_plan_number=:pol AND royal_london_financial_nomatch_id=:ID LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':ID', $FID, PDO::PARAM_INT);
                       $delete->execute();  
                       
                }
                    
                }
            }
           
                                        header('Location: /addon/Life/Financials/Financial.php?UPDATED='.$i); die;    

        
    }    
    
    }

if(isset($INSURER)) {
    if(isset($RECHECK)) {
        
$datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);  
$dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$commdate= filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);   
$finpn= filter_input(INPUT_GET, 'finpolicynumber', FILTER_SANITIZE_SPECIAL_CHARS);
$iddd= filter_input(INPUT_GET, 'iddd', FILTER_SANITIZE_SPECIAL_CHARS);
            
        if($RECHECK=='y') {
            if($INSURER=='LG') {
            
            $paytype= filter_input(INPUT_GET, 'paytype', FILTER_SANITIZE_SPECIAL_CHARS);
            
                
            if($paytype=='I') {
                
                $Icheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $Icheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                $Icheck->execute();
                $result=$Icheck->fetch(PDO::FETCH_ASSOC);
                    
                if ($Icheck->rowCount() >= 1) {  
                    
                    $clientid=$result['client_id'];
                    $polid=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($polid)";
                    $polstat=$result['policystatus'];
                        
                    $note="Financial Uploaded";
                    $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                               header('Location: /addon/Life/Financials/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: /addon/Life/Financials/Financials.php?RECHECK=y'); die;    
                           }
                       }
                           
                    header('Location: /addon/Life/Financials/Financial_Reports.php?RECHECK=y'); die; 
                        
                }
                    
                }
     
                if($paytype=='R') {
                    
                    $Rcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                    $Rcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                    $Rcheck->execute();
                    $result=$Rcheck->fetch(PDO::FETCH_ASSOC);
                        
                    if ($Rcheck->rowCount() >= 1) {
                        
                        $clientid=$result['client_id'];
                        $polid=$result['id'];
                        $policynumber=$result['policy_number'];
                        $ref= "$policynumber ($polid)";
                        $polstat=$result['policystatus'];
                            
                        $note="Financial Uploaded";
                        $message="COMM (Status changed from $polstat to Live)";
                            
                        $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                        $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                        $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                        $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                        $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                        $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $insert->execute();
                            
                        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $update->execute();
                            
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: /addon/Life/Financials/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: /addon/Life/Financials/Financials.php?RECHECK=y'); die;    
                           }
                       }
                           
                        header('Location: /addon/Life/Financials/Financial_Reports.php?RECHECK=y'); die; 
                            
                    }
                        
                    }
                        
                    if($paytype=='X') {
                        
                        $Xcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                        $Xcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                        $Xcheck->execute();
                        $result=$Xcheck->fetch(PDO::FETCH_ASSOC);
                            
                        if ($Xcheck->rowCount() >= 1) {
                            
                            $clientid=$result['client_id'];
                            $polid=$result['id'];
                            $policynumber=$result['policy_number'];
                            $ref= "$policynumber ($polid)";
                            $polstat=$result['policystatus'];
                                
                            $note="Financial Uploaded";
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                                
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                           
                       if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: /addon/Life/Financials/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: /addon/Life/Financials/Financials.php?RECHECK=y'); die;    
                           }
                       }
                       
                            header('Location: /addon/Life/Financials/Financial_Reports.php?RECHECK=y'); die; 
                                
                        }
                            
                        }
                        
                                               if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: /addon/Life/Financials/Financials.php?RECHECK=n&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: /addon/Life/Financials/Financials.php?RECHECK=n'); die;    
                           }
                       }
                        
                          header('Location: /addon/Life/Financials/Financial_Reports.php?RECHECK=n'); die;  
                        }
                        
                 if($INSURER=='OneFamily' || 'RoyalLondon' || 'Aviva' || 'Vitality') {
                  
            if($AMOUNT>='0') {
                
                $Icheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number =:pol");
                $Icheck->bindParam(':pol', $finpn, PDO::PARAM_STR);
                $Icheck->execute();
                $result=$Icheck->fetch(PDO::FETCH_ASSOC);
                    
                if ($Icheck->rowCount() >= 1) {  
                    
                    $clientid=$result['client_id'];
                    $polid=$result['id'];
                    $policynumber=$result['policy_number'];
                    $ref= "$policynumber ($polid)";
                    $polstat=$result['policystatus'];
                        
                    $note="$INSURER Financial Uploaded";
                    $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                       if($INSURER=='OneFamily') {
                       $delete = $pdo->prepare("DELETE FROM wol_nomatch WHERE wol_nomatch_policy=:pol AND wol_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }
                       if($INSURER=='Vitality') {
                       $delete = $pdo->prepare("DELETE FROM vitality_nomatch WHERE vitality_nomatch_policy=:pol AND vitality_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='RoyalLondon') {
                       $delete = $pdo->prepare("DELETE FROM royal_london_nomatch WHERE royal_london_nomatch_policy=:pol AND royal_london_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='Aviva') {
                       $delete = $pdo->prepare("DELETE FROM aviva_nomatch WHERE aviva_nomatch_policy=:pol AND aviva_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                               header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=y'); die;    
                           }
                       }
                           
                    header('Location: /addon/Life/Financials/Financial/'.$INSURER.'.php?RECHECK=y'); die; 
                        
                }
                    
                }
                        
                    if($AMOUNT<'0') {
                        
                        $Xcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                        $Xcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                        $Xcheck->execute();
                        $result=$Xcheck->fetch(PDO::FETCH_ASSOC);
                            
                        if ($Xcheck->rowCount() >= 1) {
                            
                            $clientid=$result['client_id'];
                            $polid=$result['id'];
                            $policynumber=$result['policy_number'];
                            $ref= "$policynumber ($polid)";
                            $polstat=$result['policystatus'];
                                
                            $note="$INSURER Financial Uploaded";
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                            
                       if($INSURER=='OneFamily') {
                       $delete = $pdo->prepare("DELETE FROM wol_nomatch WHERE wol_nomatch_policy=:pol AND wol_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }
                       if($INSURER=='Vitality') {
                       $delete = $pdo->prepare("DELETE FROM vitality_nomatch WHERE vitality_nomatch_policy=:pol AND vitality_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='RoyalLondon') {
                       $delete = $pdo->prepare("DELETE FROM royal_london_nomatch WHERE royal_london_nomatch_policy=:pol AND royal_london_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='Aviva') {
                       $delete = $pdo->prepare("DELETE FROM aviva_nomatch WHERE aviva_nomatch_policy=:pol AND aviva_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       
                                                             

                       if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                                   header('Location: /addon/Life/Financials/'.$INSURER.'.php?INSURER='.$INSURER.'&RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;   
                               }
                               header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=y&INSURER='.$INSURER); die;    
                               }
                               }             
                               header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=y&INSURER='.$INSURER); die;                                
                        }
                        
                        }
                        
                        if(isset($EXECUTE)) {
                            if($EXECUTE='1') {
                                if(isset($datefrom)) {
                                       header('Location: /addon/Life/Financials/'.$INSURER.'.php?INSURER='.$INSURER.'RECHECK=n&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;
                                       
                               }
                            header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=n&INSURER='.$INSURER); die;    
                           }
                       }
                        
                          header('Location: /addon/Life/Financials/'.$INSURER.'.php?RECHECK=n&INSURER='.$INSURER); die;                       
                     
                 }       
                            
                        }
    }
}
                        ?>