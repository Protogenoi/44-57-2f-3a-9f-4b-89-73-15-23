<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../../includes/ADL_PDO_CON.php');
    
    $query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if(isset($query)) {
        
        $tracker_id= filter_input(INPUT_POST, 'tracker_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $agent= filter_input(INPUT_POST, 'agent_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $client= filter_input(INPUT_POST, 'client', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone= filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $curprem= filter_input(INPUT_POST, 'current_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $curcover= filter_input(INPUT_POST, 'current_cover', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ourprem= filter_input(INPUT_POST, 'our_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $comments= filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sale= filter_input(INPUT_POST, 'sale', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pension= filter_input(INPUT_POST, 'pension', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if($query=='add') {
            
            $INSERT = $pdo->prepare("insert into closer_trackers set current_cover=:curcover, agent=:agent, closer=:closer, client=:client, phone=:phone, current_premium=:curprem, our_premium=:ourprem, comments=:comments, pension=:pension, sale=:sale");
            $INSERT->bindParam(':agent', $agent, PDO::PARAM_STR); 
            $INSERT->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $INSERT->bindParam(':client', $client, PDO::PARAM_STR); 
            $INSERT->bindParam(':phone', $phone, PDO::PARAM_STR); 
            $INSERT->bindParam(':curprem', $curprem, PDO::PARAM_STR); 
            $INSERT->bindParam(':curcover', $curcover, PDO::PARAM_STR);
            $INSERT->bindParam(':ourprem', $ourprem, PDO::PARAM_STR); 
            $INSERT->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $INSERT->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $INSERT->bindParam(':pension', $pension, PDO::PARAM_STR); 
            $INSERT->execute();
            
            header('Location: ../LifeDealSheet.php?query=CloserTrackers&result=ADDED'); die;
            
        }     
                
        if($query=='edit') {
            
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set current_cover=:curcover, agent=:agent, client=:client, phone=:phone, current_premium=:curprem, our_premium=:ourprem, comments=:comments, pension=:pension, sale=:sale WHERE tracker_id=:id AND closer=:closer");
            $UPDATE->bindParam(':id', $tracker_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':agent', $agent, PDO::PARAM_STR); 
            $UPDATE->bindParam(':client', $client, PDO::PARAM_STR); 
            $UPDATE->bindParam(':phone', $phone, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curprem', $curprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curcover', $curcover, PDO::PARAM_STR);
            $UPDATE->bindParam(':ourprem', $ourprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $UPDATE->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $UPDATE->bindParam(':pension', $pension, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            header('Location: ../LifeDealSheet.php?query=CloserTrackers&result=UPDATED'); die;
            
        }
        
        if($query=='Alledit') {
            
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set current_cover=:curcover, closer=:closer, agent=:agent, client=:client, phone=:phone, current_premium=:curprem, our_premium=:ourprem, comments=:comments, pension=:pension, sale=:sale WHERE tracker_id=:id");
            $UPDATE->bindParam(':id', $tracker_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':agent', $agent, PDO::PARAM_STR); 
            $UPDATE->bindParam(':client', $client, PDO::PARAM_STR); 
            $UPDATE->bindParam(':phone', $phone, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curprem', $curprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curcover', $curcover, PDO::PARAM_STR);
            $UPDATE->bindParam(':ourprem', $ourprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $UPDATE->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $UPDATE->bindParam(':pension', $pension, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            header('Location: ../LifeDealSheet.php?query=AllCloserTrackers&result=UPDATED'); die;
            
        }        
        
        }
        
        header('Location: ../../CRMmain.php'); die;
        
        ?>