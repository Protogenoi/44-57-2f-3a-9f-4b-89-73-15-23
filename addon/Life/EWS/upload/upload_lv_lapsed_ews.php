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
            
            $fileup = $date."-".$hello_name."-LV_EWS";
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
            
            $i=0;
 

    do {
        
        if(isset($data[0])){
            $EVENT_DATE=filter_var($data[0],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }        
        
        if(isset($data[1])){
            $EVENT_DES=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $COMPLETION_DATE=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $IN_FORCE_MTHS=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $POLICY=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[5])){
            $TITLE=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        } else{
            $TITLE = "";
        }
        if(isset($data[6])){
            $FORENAME=filter_var($data[6],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }  else {
            $FORENAME ="";
        }
        if(isset($data[7])){
            $SURNAME=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        } else {
            $SURNAME ="";
        }        
        if(isset($data[8])){
            $POSTCODE=filter_var($data[8],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }  
        if(isset($data[9])){
            $HOME_NUM=filter_var($data[9],FILTER_SANITIZE_NUMBER_INT); 
        }         
        if(isset($data[10])){
            $MOB_NUM=filter_var($data[10],FILTER_SANITIZE_NUMBER_INT); 
        }    
        if(isset($data[11])){
            $APE=filter_var($data[11],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }   
        if(isset($data[12])){
            $MONTHLY_PREM=filter_var($data[12],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
        if(isset($data[13])){
            $COMM_AMOUNT_INDEM=filter_var($data[13],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }       
        if(isset($data[14])){
            $COMM_CB=filter_var($data[14],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }     
        if(isset($data[15])){
            $COMM_TYPE=filter_var($data[15],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }         
        if(isset($data[16])){
            $SELLER_FCA_NUMBER=filter_var($data[16],FILTER_SANITIZE_NUMBER_INT); 
        }  
        if(isset($data[17])){
            $SELLER_FIRM_NAME=filter_var($data[17],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }   
        if(isset($data[18])){
            $SELLER_NUMBER=filter_var($data[18],FILTER_SANITIZE_NUMBER_INT); 
        }      
        if(isset($data[19])){
            $SELLER_NAME=filter_var($data[19],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }           
        if(isset($data[20])){
            $BID=filter_var($data[20],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }               
        if(isset($data[21])){
            $NID=filter_var($data[21],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }  
        if(isset($data[22])){
            $REPORT_RUN_DATE=filter_var($data[22],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }          
        
        $TRIMMED_POLICY= substr($POLICY,1,7);
        
        $INSURER='LV';
        
        $NAME = $TITLE. ' ' . $FORENAME. ' ' . $SURNAME;
        $STATUS = "Lapsed";
          
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
                            JOIN 
                                adl_ews_lv_lapsed 
                            ON
                                adl_ews_lv_lapsed_id_fk = adl_ews_id
                            WHERE 
                                adl_ews_client_name=:NAME
                            AND    
                                adl_ews_orig_status=:STATUS
                            AND 
                                adl_ews_status = 'NEW'
                            AND
                                adl_ews_ref=:REF
                            AND    
                                adl_ews_insurer=:INSURER
                            AND
                                adl_ews_lv_lapsed_event_date=:EVENT_DATE 
                            AND 
                                adl_ews_lv_lapsed_event_des=:EVENT_DES 
                            AND 
                                adl_ews_lv_lapsed_completion_date=:COMP_DATE 
                            AND 
                                adl_ews_lv_lapsed_inforce_mths=:INFORCE 
                            AND
                                adl_ews_lv_lapsed_postcode=:POSTCODE 
                            AND
                                adl_ews_lv_lapsed_home_num=:HOME 
                            AND
                                adl_ews_lv_lapsed_mob_num=:MOB 
                            AND 
                                adl_ews_lv_lapsed_ape=:APE 
                            AND 
                                adl_ews_lv_lapsed_total_mth_prem=:TOT_MTH_PREM 
                            AND 
                                adl_ews_lv_lapsed_comm_amount_idem=:COMM_AMOUNT_INDEM 
                            AND 
                                adl_ews_lv_lapsed_comm_cb_period_mths=:CB_COMM 
                            AND 
                                adl_ews_lv_lapsed_comm_type=:COMM_TYPE
                            AND 
                                adl_ews_lv_lapsed_report_run_date=:RUN_DATE");
                    $CHK_ADL_WARNINGS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':REF',$POLICY, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':EVENT_DATE',$EVENT_DATE, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':EVENT_DES',$EVENT_DES, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':COMP_DATE',$COMPLETION_DATE, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':INFORCE',$IN_FORCE_MTHS, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':POSTCODE',$POSTCODE, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':HOME',$HOME_NUM, PDO::PARAM_INT);
                    $CHK_ADL_WARNINGS->bindParam(':MOB',$MOB_NUM, PDO::PARAM_INT);
                    $CHK_ADL_WARNINGS->bindParam(':APE',$APE, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':TOT_MTH_PREM',$MONTHLY_PREM, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':COMM_AMOUNT_INDEM',$COMM_AMOUNT_INDEM, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':CB_COMM',$COMM_CB, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':COMM_TYPE',$COMM_TYPE, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':RUN_DATE',$REPORT_RUN_DATE, PDO::PARAM_STR);                   
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
                                                adl_ews_updated_by=:WHO,
                                                adl_ews_updated_date = CURRENT_TIMESTAMP
                                            WHERE 
                                                adl_ews_id=:EID
                                            ');     
                $UPDATE_EWS->bindParam(':EID',$EID, PDO::PARAM_INT);
                $UPDATE_EWS->bindParam(':WHO',$hello_name, PDO::PARAM_STR);              
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));          
        
//MATCH POLICY TO ADL TO GET CLIENT ID        

    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy where policy_number=:POL_NUM');
    $SELECT_CID->bindParam(':POL_NUM', $TRIMMED_POLICY, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC); 
    if ($SELECT_CID->rowCount() >= 1) {

    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];
    
    $note="LV EWS Uploaded";
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
        
        $i++;
        
                $UPDATE_EWS = $pdo->prepare('
                                            INSERT INTO
                                                adl_ews 
                                            SET 
                                                adl_ews_ref=:POLICY, 
                                                adl_ews_modified_ref=:MOD_POLICY, 
                                                adl_ews_client_id=:CID,
                                                adl_ews_client_name=:NAME, 
                                                adl_ews_orig_status=:STATUS, 
                                                adl_ews_insurer=:INSURER, 
                                                adl_ews_added_by=:WHO
                                            ');     
                $UPDATE_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':MOD_POLICY',$TRIMMED_POLICY, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':CID',$CID, PDO::PARAM_INT);
                $UPDATE_EWS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':WHO',$hello_name, PDO::PARAM_STR);          
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));     
                
                $LID = $pdo->lastInsertId();
        
        $INSERT_EWS = $pdo->prepare('INSERT INTO adl_ews_lv_lapsed
            SET 
                adl_ews_lv_lapsed_id_fk=:LID,
                adl_ews_lv_lapsed_event_date=:EVENT_DATE, 
                adl_ews_lv_lapsed_event_des=:EVENT_DES, 
                adl_ews_lv_lapsed_completion_date=:COMP_DATE, 
                adl_ews_lv_lapsed_inforce_mths=:INFORCE, 
                adl_ews_lv_lapsed_policy_number=:POLICY, 
                adl_ews_lv_lapsed_title=:TITLE, 
                adl_ews_lv_lapsed_forenames=:FORENAME,
                adl_ews_lv_lapsed_surname=:SURNAME, 
                adl_ews_lv_lapsed_postcode=:POSTCODE,
                adl_ews_lv_lapsed_home_num=:HOME,
                adl_ews_lv_lapsed_mob_num=:MOB, 
                adl_ews_lv_lapsed_ape=:APE, 
                adl_ews_lv_lapsed_total_mth_prem=:TOT_MTH_PREM, 
                adl_ews_lv_lapsed_comm_amount_idem=:COMM_AMOUNT_INDEM, 
                adl_ews_lv_lapsed_comm_cb_period_mths=:CB_COMM, 
                adl_ews_lv_lapsed_comm_type=:COMM_TYPE, 
                adl_ews_lv_lapsed_seller_fca_num=:FCA_NUMBER, 
                adl_ews_lv_lapsed_seller_firm_name=:FIRM_NAME, 
                adl_ews_lv_lapsed_seller_num=:SELLER_NUM, 
                adl_ews_lv_lapsed_seller_name=:SELLER_NAME,
                adl_ews_lv_lapsed_seller_bid=:BID, 
                adl_ews_lv_lapsed_seller_nid=:NID, 
                adl_ews_lv_lapsed_report_run_date=:RUN_DATE');     
        $INSERT_EWS->bindParam(':LID',$LID, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':EVENT_DATE',$EVENT_DATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':EVENT_DES',$EVENT_DES, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':COMP_DATE',$COMPLETION_DATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':INFORCE',$IN_FORCE_MTHS, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':TITLE',$TITLE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':FORENAME',$FORENAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':SURNAME',$SURNAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':POSTCODE',$POSTCODE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':HOME',$HOME_NUM, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':MOB',$MOB_NUM, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':APE',$APE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':TOT_MTH_PREM',$MONTHLY_PREM, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':COMM_AMOUNT_INDEM',$COMM_AMOUNT_INDEM, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':CB_COMM',$COMM_CB, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':COMM_TYPE',$COMM_TYPE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':FCA_NUMBER',$SELLER_FCA_NUMBER, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':FIRM_NAME',$SELLER_FIRM_NAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':SELLER_NUM',$SELLER_NUMBER, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':SELLER_NAME',$SELLER_NAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':BID',$BID, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':NID',$NID, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':RUN_DATE',$REPORT_RUN_DATE, PDO::PARAM_STR);       
        $INSERT_EWS->execute()or die(print_r($INSERT_EWS->errorInfo(), true)); 
             
    //INSERT INTO CLIENT TIMELINE
        
    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy WHERE policy_number=:POLICY');
    $SELECT_CID->bindParam(':POLICY', $TRIMMED_POLICY, PDO::PARAM_STR);
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

 header('Location: /../../../../addon/Life/EWS/adl_ews.php?UPLOADED='.$i); die;       
    
}
}