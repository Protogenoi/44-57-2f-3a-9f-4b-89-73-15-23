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
            
            $i=0;
 

    do {
        
        if(isset($data[0])){
            $NAME=filter_var($data[0],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[1])){
            $POLICY=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $STATUS=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $REPORTED_DATE=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $INFO=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
            
        $INSURER='Aviva';
          
            if(isset($data[0])) {  // CHECK THERE IS DATA

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT 
    adl_ews_id,
    adl_ews_client_id,
    adl_ews_client_name,
    adl_ews_orig_status,
    adl_ews_ref,
    adl_ews_aviva_reported_date
FROM
    adl_ews
        JOIN
    adl_ews_aviva ON adl_ews_aviva_id_fk = adl_ews_id
WHERE
    adl_ews_client_name =:NAME
        AND adl_ews_orig_status = :STATUS
        AND adl_ews_ref =:REF
        AND adl_ews_insurer =:INSURER
        AND adl_ews_aviva_reported_date =:REPORT");
                    $CHK_ADL_WARNINGS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':REF',$POLICY, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->bindParam(':REPORT',$REPORTED_DATE, PDO::PARAM_STR);
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

    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':CID', $CID, PDO::PARAM_INT);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':message', $messageEWS, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR);
    $INSERT_TIMELINE->execute();

        }

    } //END OF UPDATES
    
    if ($CHK_ADL_WARNINGS->rowCount() <= 0) { // INSERT THE REST
        
        $i++;
        
    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy where policy_number=:POL_NUM');
    $SELECT_CID->bindParam(':POL_NUM', $policy_number, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC);
    
    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];        
        
                $UPDATE_EWS = $pdo->prepare('
                                            INSERT INTO
                                                adl_ews 
                                            SET 
                                                adl_ews_ref=:POLICY, 
                                                adl_ews_client_id=:CID,
                                                adl_ews_client_name=:NAME, 
                                                adl_ews_orig_status=:STATUS, 
                                                adl_ews_insurer=:INSURER, 
                                                adl_ews_added_by=:WHO
                                            ');     
                $UPDATE_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':CID',$CID, PDO::PARAM_INT);
                $UPDATE_EWS->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':WHO',$hello_name, PDO::PARAM_STR);          
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));     
                
                $LID = $pdo->lastInsertId();
                
                $INSERT_MASTER = $pdo->prepare('
                                            INSERT INTO
                                                adl_ews_master 
                                            SET 
                                                adl_ews_master_ref=:POLICY, 
                                                adl_ews_master_client_id=:CID,
                                                adl_ews_master_client_name=:NAME, 
                                                adl_ews_master_orig_status=:STATUS, 
                                                adl_ews_master_insurer=:INSURER, 
                                                adl_ews_master_added_by=:WHO
                                            ');     
                $INSERT_MASTER->bindParam(':POLICY',$POLICY, PDO::PARAM_STR);
                $INSERT_MASTER->bindParam(':CID',$CID, PDO::PARAM_INT);
                $INSERT_MASTER->bindParam(':NAME',$NAME, PDO::PARAM_STR);
                $INSERT_MASTER->bindParam(':STATUS',$STATUS, PDO::PARAM_STR);
                $INSERT_MASTER->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
                $INSERT_MASTER->bindParam(':WHO',$hello_name, PDO::PARAM_STR);          
                $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true));                   
        
        $INSERT_EWS = $pdo->prepare('INSERT INTO adl_ews_aviva 
            SET 
            adl_ews_aviva_id_fk=:LID,
            adl_ews_aviva_client_name=:CLIENT, 
            adl_ews_aviva_policy_number=:POLICY, 
            adl_ews_aviva_description=:DESC, 
            adl_ews_aviva_reported_date=:DATE, 
            adl_ews_aviva_more_info=:INFO');     
        $INSERT_EWS->bindParam(':LID',$LID, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':CLIENT',$NAME, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':POLICY',$POLICY, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':DESC',$STATUS, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':DATE',$REPORTED_DATE, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':INFO',$INFO, PDO::PARAM_STR);
        $INSERT_EWS->execute()or die(print_r($INSERT_EWS->errorInfo(), true)); 
             
    //INSERT INTO CLIENT TIMELINE

    if ($SELECT_CID->rowCount() >= 1) {
    
    $note="$INSURER EWS Uploaded";
    $ref= "$POL_NUMBER ($PID)";
    $MESSAGE = "$POLICY is now $STATUS";

    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':CID', $CID, PDO::PARAM_INT);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->bindParam(':message', $MESSAGE, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR, 100);
    $INSERT_TIMELINE->execute();

}

    }  
            
        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));

 header('Location: /../../../../addon/Life/EWS/adl_ews.php?UPLOADED='.$i); die;       
    
}
}