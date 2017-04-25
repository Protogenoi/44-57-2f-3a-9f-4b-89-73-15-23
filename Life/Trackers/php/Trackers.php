<?php 
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


if ($ffdealsheets == '0') {
    header('Location: /../../../CRMmain.php?Feature=NotEnabled');
    die;
}
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
    $TYPE= filter_input(INPUT_GET, 'TYPE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if(isset($EXECUTE)){
            
        $tracker_id= filter_input(INPUT_POST, 'tracker_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $agent= filter_input(INPUT_POST, 'agent_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $client= filter_input(INPUT_POST, 'client', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone= filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $curprem= filter_input(INPUT_POST, 'current_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ourprem= filter_input(INPUT_POST, 'our_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $comments= filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sale= filter_input(INPUT_POST, 'sale', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dec= filter_input(INPUT_POST, 'dec', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        
        $MTG= filter_input(INPUT_POST, 'MTG', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $LEAD_UP= filter_input(INPUT_POST, 'LEAD_UP', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($EXECUTE=='1') {
                $TID= filter_input(INPUT_GET, 'TID', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                $UPSELL_STATUS= filter_input(INPUT_POST, 'UPSELLS_STATUS', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                $UPSELL_NOTES= filter_input(INPUT_POST, 'UPSELLS_NOTES', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

                
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set upsell_status=:STATUS, upsell_notes=:NOTES, upsell_agent=:AGENT WHERE tracker_id=:ID");
            $UPDATE->bindParam(':ID', $TID, PDO::PARAM_INT); 
            $UPDATE->bindParam(':AGENT', $hello_name, PDO::PARAM_STR); 
            $UPDATE->bindParam(':NOTES', $UPSELL_NOTES, PDO::PARAM_STR); 
            $UPDATE->bindParam(':STATUS', $UPSELL_STATUS, PDO::PARAM_STR); 
            $UPDATE->execute();
            
           header('Location: ../Trackers.php?query=DEFAULT&result=UPDATED'); die;
            }
            if($EXECUTE=='2') {
                
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set mtg=:mtg, lead_up=:up, agent=:agent, client=:client, phone=:phone, current_premium=:curprem, our_premium=:ourprem, comments=:comments, sale=:sale WHERE tracker_id=:id AND closer=:closer");
            $UPDATE->bindParam(':id', $tracker_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':agent', $agent, PDO::PARAM_STR); 
            $UPDATE->bindParam(':client', $client, PDO::PARAM_STR); 
            $UPDATE->bindParam(':phone', $phone, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curprem', $curprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':up', $LEAD_UP, PDO::PARAM_STR);
            $UPDATE->bindParam(':ourprem', $ourprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $UPDATE->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $UPDATE->bindParam(':mtg', $MTG, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            if(isset($TYPE)) {
                if($TYPE=='CLOSER'){
                    header('Location: /Life/Trackers/Closers.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
                if($TYPE=='AGENT') {
                    header('Location: /Life/Trackers/Agent.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
                if($TYPE=='UPSELL') {
                    header('Location: /Life/Trackers/Upsell.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
            }
            
   
                
            }
        }
        
       header('Location: ../../CRMmain.php'); die;
        
        ?>