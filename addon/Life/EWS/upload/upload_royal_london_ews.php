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

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

require_once(BASE_URL.'/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_FULL_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');
require_once(BASE_URL.'/classes/database_class.php');
require_once(BASE_URL.'/includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(BASE_URL.'/classes/database_class.php');
    require_once(BASE_URL.'/class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 8) {
            
        header('Location: '.BASE_URL.'/index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($EXECUTE) && $EXECUTE==1) {
    if ($_FILES["csv"]["size"] > 0) {
    
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-AVIVA_EWS";
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder=BASE_URL."/addon/Life/EWS/uploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {

                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype='EWS Upload NEW'");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->execute(); 
                
            }
 

    do {
        
        if(isset($data[0])){
            $IFA_ID=filter_var($data[0],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[1])){
            $IFA_NAME=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $RI_NAME=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $POLICY=filter_var($data[3],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[4])){
            $PRODUCT=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        if(isset($data[5])){
            $PLAN_START_DATE=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        } 
        if(isset($data[6])){
            $NAME=filter_var($data[6],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }  
        if(isset($data[7])){
            $ARREARS_START_DATE=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        } 
        if(isset($data[8])){
            $FORMATTED_PLAN_PREMIUM = str_replace("£","",$data[8]);
            $PLAN_PREMIUM=filter_var($FORMATTED_PLAN_PREMIUM,FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }  
        if(isset($data[9])){
            $FORMATTED_ARREARS_AMOUNT = str_replace("£","",$data[9]);
            $ARREARS_AMOUNT=filter_var($FORMATTED_ARREARS_AMOUNT,FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
        if(isset($data[10])){
            $PREMS_MISSED=filter_var($data[10],FILTER_SANITIZE_NUMBER_INT); 
        }  
        if(isset($data[11])){
            $DAYS_IN_ARREARS=filter_var($data[11],FILTER_SANITIZE_NUMBER_INT); 
        }         
        if(isset($data[12])){
            $DAYS_TO_LAPSE=filter_var($data[12],FILTER_SANITIZE_NUMBER_INT); 
        }    
        if(isset($data[13])){
            $STATUS=filter_var($data[13],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }   
        if(isset($data[14])){
            $DD_MANDATE=filter_var($data[14],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
        if(isset($data[15])){
            $NEXT_DD=filter_var($data[15],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }       
        if(isset($data[16])){
            $PAYMENT_DAY=filter_var($data[16],FILTER_SANITIZE_NUMBER_INT); 
        }     
        if(isset($data[17])){
            $FORMATTED_TOTAL_COMM = str_replace("£","",$data[17]);
            $TOTAL_COMM=filter_var($FORMATTED_TOTAL_COMM,FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
        if(isset($data[18])){
            $IEP=filter_var($data[18],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
            
        $INSURER='Royal London';
          
            if(isset($data[0])) {  // CHECK THERE IS DATA

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT
                                adl_ews_id, 
                                adl_ews_client_id, 
                                adl_ews_client_name, 
                                adl_ews_orig_status, 
                                adl_ews_ref 
                            FROM 
                                adl_ews 
                            WHERE 
                                adl_ews_client_name=:NAME
                            AND    
                                adl_ews_orig_status=:STATUS
                            AND
                                adl_ews_ref=:REF
                            AND    
                                adl_ews_insurer=:INSURER");
                    $CHK_ADL_WARNINGS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':REF',$POLICY, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->execute()or die(print_r($CHK_ADL_WARNINGS->errorInfo(), true)); 
                    $row=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC);
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
                        
                        $ORIG_WARNING=$row['adl_ews_orig_status'];
                        $ORIG_POL_NUM=$row['adl_ews_ref'];
                        $ORIG_CID=$row['adl_ews_client_id'];
                        $EID=$row['adl_ews_id'];

//UPDATE EWS UPDATED DATE
                
                $UPDATE_EWS = $pdo->prepare('
                                            UPDATE
                                                adl_ews 
                                            SET 
                                                adl_ews_updated_by=:WHO
                                            WHERE 
                                                adl_ews_id=:EID
                                            ');     
                $UPDATE_EWS->bindParam(':EID',$EID, PDO::PARAM_INT);
                $UPDATE_EWS->bindParam(':WHO',$hello_name, PDO::PARAM_STR);          
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));          
        
//MATCH POLICY TO ADL TO GET CLIENT ID        

    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy where policy_number=:POL_NUM');
    $SELECT_CID->bindParam(':POL_NUM', $policy_number, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC); 
    if ($SELECT_CID->rowCount() >= 1) {

    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];
    
    $note="Aviva EWS Uploaded";
    $ref= "$POL_NUMBER ($PID)";
    $messageEWS="$STATUS already on as $ORIG_WARNING";
    
//INSERT NOTE INTO CLIENT TIMELINE    
    /*
    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':CID', $CID, PDO::PARAM_INT);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':message', $messageEWS, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR);
    $INSERT_TIMELINE->execute();
    */
        }

    } //END OF UPDATES
    
    if ($CHK_ADL_WARNINGS->rowCount() <= 0) { // INSERT THE REST
        
                $UPDATE_EWS = $pdo->prepare('
                                            INSERT INTO
                                                adl_ews 
                                            SET 
                                                adl_ews_ref=:POLICY, 
                                                adl_ews_client_name=:NAME, 
                                                adl_ews_orig_status=:STATUS, 
                                                adl_ews_status=:NEW, 
                                                adl_ews_insurer=:INSURER, 
                                                adl_ews_added_by=:WHO
                                            ');     
                $UPDATE_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':NEW',$ADL_STATUS, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':WHO',$hello_name, PDO::PARAM_STR);          
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));     
                
                $LID = $pdo->lastInsertId();
        
        $INSERT_EWS = $pdo->prepare('INSERT INTO adl_ews_royal_london 
            SET 
            adl_ews_royal_london_id_fk=:LID,
            adl_ews_royal_london_ifa_id=:IFA_ID, 
            adl_ews_royal_london_ifa_name=:IFA_NAME, 
            adl_ews_royal_london_ri_name=:RI_NAME, 
            adl_ews_royal_london_policyno=:POLICY, 
            adl_ews_royal_london_product=:PRODUCT, 
            adl_ews_royal_london_plan_start_date=:START_DATE, 
            adl_ews_royal_london_payer_name=:CLIENT, 
            adl_ews_royal_london_arrears_start_date=:ARREARS_START, 
            adl_ews_royal_london_plan_premium=:PLAN_PREM, 
            adl_ews_royal_london_arrears_amount=:ARREARS_AMOUNT, 
            adl_ews_royal_london_prems_missed=:PREM_MISSED, 
            adl_ews_royal_london_days_in_arrears=:DAYS_ARREARS, 
            adl_ews_royal_london_days_to_lapse=:DAYS_LAPSED, 
            adl_ews_royal_london_bacs_rejection_reason=:BACS, 
            adl_ews_royal_london_dd_mandate_status=:DD_MANDATE, 
            adl_ews_royal_london_next_dd=:NEXT_DD, 
            adl_ews_royal_london_payment_day=:PAY_DAY, 
            adl_ews_royal_london_total_commission_liability=:COMM_LIABILITY, 
            adl_ews_royal_london_within_iep=:IEP');     
        $INSERT_EWS->bindParam(':LID',$LID, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':IFA_ID',$IFA_ID, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':IFA_NAME',$IFA_NAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':RI_NAME',$RI_NAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':PRODUCT',$PRODUCT, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':START_DATE',$PLAN_START_DATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':CLIENT',$CLIENT, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ARREARS_START',$ARREARS_START_DATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':PLAN_PREM',$PLAN_PREMIUM, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ARREARS_AMOUNT',$ARREARS_AMOUNT, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':PREM_MISSED',$PREMS_MISSED, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':DAYS_ARREARS',$DAYS_IN_ARREARS, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':DAYS_LAPSED',$DAYS_TO_LAPSE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':BACS',$STATUS, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':DD_MANDATE',$DD_MANDATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':NEXT_DD',$NEXT_DD, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':PAY_DAY',$PAYMENT_DAY, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':COMM_LIABILITY',$TOTAL_COMM, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':IEP',$IEP, PDO::PARAM_STR);
        $INSERT_EWS->execute()or die(print_r($INSERT_EWS->errorInfo(), true)); 
             
    //INSERT INTO CLIENT TIMELINE
        
    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy WHERE policy_number=:POLICY');
    $SELECT_CID->bindParam(':POLICY', $POLICY, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC);
    if ($SELECT_CID->rowCount() >= 1) {

    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];
    
    $note="Aviva EWS Uploaded";
    $ref= "$POL_NUMBER ($PID)";
    /*
    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':CID', $CID, PDO::PARAM_INT);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->bindParam(':message', $STATUS, PDO::PARAM_STR, 500);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->execute();
    */
}

    }  
            
        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));

 header('Location: /../../../../addon/Life/EWS/adl_ews.php?RETURN=UPLOADED'); die;       
    
}
}