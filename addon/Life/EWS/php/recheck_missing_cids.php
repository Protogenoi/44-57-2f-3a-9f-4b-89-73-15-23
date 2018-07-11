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
    
    $i= 0;

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT
                                adl_ews_ref,
                                adl_ews_id,
                                adl_ews_insurer
                            FROM 
                                adl_ews 
                            WHERE 
                                adl_ews_client_id IS NULL");
                    $CHK_ADL_WARNINGS->execute()or die(print_r($CHK_ADL_WARNINGS->errorInfo(), true));                   
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
                        while ($result=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC)){ 
                        
                        $POL_NUM=$result['adl_ews_ref'];
                        $EID=$result['adl_ews_id'];
                        $INSURER=$result['adl_ews_insurer'];
                        
                        if(isset($INSURER) && $INSURER == 'LV') {
                            $POL_NUM= substr($POL_NUM,1,7);
                        }
                        
                $SELECT = $pdo->prepare("SELECT client_id FROM client_policy WHERE policy_number =:POLICY");
                $SELECT->bindParam(':POLICY', $POL_NUM, PDO::PARAM_STR);
                $SELECT->execute();
                $row=$SELECT->fetch(PDO::FETCH_ASSOC);   
                
                $CID=$row['client_id'];
                
                if ($SELECT->rowCount() >= 1) {  
                    
                    $i++;
                    
                $UPDATE = $pdo->prepare("UPDATE
                                                adl_ews
                                        SET 
                                            adl_ews_client_id=:CID 
                                        WHERE 
                                            adl_ews_id =:EID");
                $UPDATE->bindParam(':EID', $EID, PDO::PARAM_STR);
                $UPDATE->bindParam(':CID', $CID, PDO::PARAM_INT);
                $UPDATE->execute();    
         
                
                }
                        
                        }
                        
                        }

 header('Location: /../../../../addon/Life/EWS/adl_ews.php?UPDATE='.$i); die;   
                        
                        }