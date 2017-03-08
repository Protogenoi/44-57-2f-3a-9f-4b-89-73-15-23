<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');

if($companynamere=='The Review Bureau' || $companynamere=='ADL_CUS') {

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;
}
}

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

    $Modify= filter_input(INPUT_GET, 'Modify', FILTER_SANITIZE_NUMBER_INT);
    
    if(isset($Modify)) {
        
        include('../../includes/ADL_PDO_CON.php');
        
        if($Modify=='1') {
            
                       
            $ewsid= filter_input(INPUT_POST, 'ewsid', FILTER_SANITIZE_NUMBER_INT);

            $query = $pdo->prepare("SELECT id FROM ews_data where id =:id");
            $query->bindParam(':id', $ewsid, PDO::PARAM_INT);
            $query->execute()or die(print_r($query->errorInfo(), true));
            if ($query->rowCount()>=1) {  

                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../Reports/EWSModify.php?RecordExists=1&EWSID='.$ewsid); die;
                        }
                        }
                        }
                
                if ($query->rowCount()<=0) { 
                    
                    if(isset($fferror)) {
                        if($fferror=='0') {
                            header('Location: ../Reports/EWSModify.php?RecordExists=0'); die;
                            }
                            }
                            }
            
        }
        
        if($Modify=='2') {

                    ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
            
         $ewsid= filter_input(INPUT_GET, 'ewsid', FILTER_SANITIZE_NUMBER_INT);
         
         $master_agent_no= filter_input(INPUT_POST, 'master_agent_no', FILTER_SANITIZE_SPECIAL_CHARS);
         $agent_no= filter_input(INPUT_POST, 'agent_no', FILTER_SANITIZE_SPECIAL_CHARS);
         $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
         $client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
         $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
         $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
         $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
         $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
         $address4= filter_input(INPUT_POST, 'address4', FILTER_SANITIZE_SPECIAL_CHARS);
         $post_code= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
         $policy_type= filter_input(INPUT_POST, 'policy_type', FILTER_SANITIZE_SPECIAL_CHARS);
         $warning= filter_input(INPUT_POST, 'warning', FILTER_SANITIZE_SPECIAL_CHARS);
         $last_full_premium_paid= filter_input(INPUT_POST, 'last_full_premium_paid', FILTER_SANITIZE_SPECIAL_CHARS);
         $net_premium= filter_input(INPUT_POST, 'net_premium', FILTER_SANITIZE_SPECIAL_CHARS);
         $premium_os= filter_input(INPUT_POST, 'premium_os', FILTER_SANITIZE_SPECIAL_CHARS);
         $clawback_due= filter_input(INPUT_POST, 'clawback_due', FILTER_SANITIZE_SPECIAL_CHARS);
         $clawback_date= filter_input(INPUT_POST, 'clawback_date', FILTER_SANITIZE_SPECIAL_CHARS);
         $policy_start_date= filter_input(INPUT_POST, 'policy_start_date', FILTER_SANITIZE_SPECIAL_CHARS);
         $off_risk_date= filter_input(INPUT_POST, 'off_risk_date', FILTER_SANITIZE_SPECIAL_CHARS);
         $seller_name= filter_input(INPUT_POST, 'seller_name', FILTER_SANITIZE_SPECIAL_CHARS);
         $frn= filter_input(INPUT_POST, 'frn', FILTER_SANITIZE_SPECIAL_CHARS);
         $reqs= filter_input(INPUT_POST, 'reqs', FILTER_SANITIZE_SPECIAL_CHARS);
         $ews_status_status= filter_input(INPUT_POST, 'ews_status_status', FILTER_SANITIZE_SPECIAL_CHARS);
         $ournotes= filter_input(INPUT_POST, 'ournotes', FILTER_SANITIZE_SPECIAL_CHARS);
         $color_status= filter_input(INPUT_POST, 'color_status', FILTER_SANITIZE_SPECIAL_CHARS);
         
         $update = $pdo->prepare("UPDATE ews_data SET master_agent_no=:master_agent_no, agent_no=:agent_no, policy_number=:policy_number, client_name=:client_name, dob=:dob, address1=:address1, address2=:address2, address3=:address3, address4=:address4, post_code=:post_code, policy_type=:policy_type, warning=:warning, last_full_premium_paid=:last_full_premium_paid, net_premium=:net_premium, premium_os=:premium_os, clawback_due=:clawback_due, clawback_date=:clawback_date, policy_start_date=:policy_start_date, off_risk_date=:off_risk_date, seller_name=:seller_name, frn=:frn, reqs=:reqs, ews_status_status=:ews_status_status, ournotes=:ournotes, color_status=:color_status WHERE id =:id LIMIT 1");
         $update->bindParam(':id', $ewsid, PDO::PARAM_INT);
         $update->bindParam(':master_agent_no', $master_agent_no, PDO::PARAM_STR);
         $update->bindParam(':agent_no', $agent_no, PDO::PARAM_STR);
         $update->bindParam(':policy_number', $policy_number, PDO::PARAM_STR);
         $update->bindParam(':client_name', $client_name, PDO::PARAM_STR);
         $update->bindParam(':dob', $dob, PDO::PARAM_STR);
         $update->bindParam(':address1', $address1, PDO::PARAM_STR);
         $update->bindParam(':address2', $address2, PDO::PARAM_STR);
         $update->bindParam(':address3', $address3, PDO::PARAM_STR);
         $update->bindParam(':address4', $address4, PDO::PARAM_STR);
         $update->bindParam(':post_code', $post_code, PDO::PARAM_STR);
         $update->bindParam(':policy_type', $policy_type, PDO::PARAM_STR);
         $update->bindParam(':warning', $warning, PDO::PARAM_STR);
         $update->bindParam(':last_full_premium_paid', $last_full_premium_paid, PDO::PARAM_STR);
         $update->bindParam(':net_premium', $net_premium, PDO::PARAM_STR);
         $update->bindParam(':premium_os', $premium_os, PDO::PARAM_STR);
         $update->bindParam(':clawback_due', $clawback_due, PDO::PARAM_STR);
         $update->bindParam(':clawback_date', $clawback_date, PDO::PARAM_STR);
         $update->bindParam(':policy_start_date', $policy_start_date, PDO::PARAM_STR);
         $update->bindParam(':off_risk_date', $off_risk_date, PDO::PARAM_STR);
         $update->bindParam(':seller_name', $seller_name, PDO::PARAM_STR);
         $update->bindParam(':frn', $frn, PDO::PARAM_STR);
         $update->bindParam(':reqs', $reqs, PDO::PARAM_STR);
         $update->bindParam(':ews_status_status', $ews_status_status, PDO::PARAM_STR);
         $update->bindParam(':ournotes', $ournotes, PDO::PARAM_STR);
         $update->bindParam(':color_status', $color_status, PDO::PARAM_STR);
         $update->execute()or die(print_r($update->errorInfo(), true));
            if ($update->rowCount()>=1) {  

                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../Reports/EWSModify.php?RecordUpdated=1&EWSID='.$ewsid); die;
                        }
                        }
                        }
                
                if ($update->rowCount()<=0) { 
                    
                    if(isset($fferror)) {
                        if($fferror=='0') {
                            header('Location: ../Reports/EWSModify.php?RecordUpdated=0'); die;
                            }
                            }
                            }
         
            
        }
        
        
    }
    
    
    ?>