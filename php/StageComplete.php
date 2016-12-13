<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_SPECIAL_CHARS);
$search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$summarysheet= filter_input(INPUT_POST, 'summarysheet', FILTER_SANITIZE_NUMBER_INT);

if(isset($stage)) {
    if($stage=='5') {
        if($summarysheet=='1') {
            
            $allupdatestage = $pdo->prepare("UPDATE pension_stages set complete ='Yes' WHERE client_id =:clientid AND stage='5' AND task ='Report Summary' ");
            $allupdatestage->bindParam(':clientid', $search, PDO::PARAM_INT);
            $allupdatestage->execute()or die(print_r($allupdatestage->errorInfo(), true));  
            
            header('Location: ../ViewClient.php?StageMarkedComplete=5&search='.$search); die;
             
        }
        
                if($summarysheet=='0') {
            
            $allupdatestage = $pdo->prepare("UPDATE pension_stages set complete ='No' WHERE client_id =:clientid AND stage='5' AND task ='Report Summary' ");
            $allupdatestage->bindParam(':clientid', $search, PDO::PARAM_INT);
            $allupdatestage->execute()or die(print_r($allupdatestage->errorInfo(), true));  
            
            header('Location: ../ViewClient.php?StageMarkedComplete=5&search='.$search); die;
             
        }
        
        }   
        
        }  
        
        ?>