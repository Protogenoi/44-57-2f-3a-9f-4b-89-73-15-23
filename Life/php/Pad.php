<?php 
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    $query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if(isset($query)) {
        
        $pad_group= filter_input(INPUT_POST, 'group', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        $pad_id= filter_input(INPUT_POST, 'pad_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $year= filter_input(INPUT_POST, 'year', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $col= filter_input(INPUT_POST, 'col', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $year="2017";
        if($query=='add') {

            
            $INSERT = $pdo->prepare("INSERT INTO pad_statistics SET pad_statistics_group=:group, pad_statistics_lead=:lead, pad_statistics_closer=:closer, pad_statistics_notes=:notes, pad_statistics_status=:status, pad_statistics_year=:year, pad_statistics_col=:col, pad_statistics_added_by=:hello");
            $INSERT->bindParam(':group', $pad_group, PDO::PARAM_STR); 
            $INSERT->bindParam(':lead', $lead, PDO::PARAM_STR); 
            $INSERT->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $INSERT->bindParam(':notes', $notes, PDO::PARAM_STR); 
            $INSERT->bindParam(':status', $status, PDO::PARAM_STR); 
            $INSERT->bindParam(':year', $year, PDO::PARAM_STR); 
            $INSERT->bindParam(':col', $col, PDO::PARAM_STR);
            $INSERT->bindParam(':hello', $hello_name, PDO::PARAM_STR); 
            $INSERT->execute();
            
            header('Location: ../../../Life/Reports/Pad.php?result=ADDED'); die;
            
        }     
                
        if($query=='edit') {
            
            
            $UPDATE = $pdo->prepare("UPDATE pad_statistics SET pad_statistics_group=:group, pad_statistics_lead=:lead, pad_statistics_closer=:closer, pad_statistics_notes=:notes, pad_statistics_status=:status, pad_statistics_year=:year, pad_statistics_col=:col, pad_statistics_updated_by=:hello WHERE pad_statistics_id=:id");
            $UPDATE->bindParam(':group', $pad_group, PDO::PARAM_STR); 
            $UPDATE->bindParam(':id', $pad_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':lead', $lead, PDO::PARAM_STR); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':notes', $notes, PDO::PARAM_STR); 
            $UPDATE->bindParam(':status', $status, PDO::PARAM_STR); 
            $UPDATE->bindParam(':year', $year, PDO::PARAM_STR); 
            $UPDATE->bindParam(':col', $col, PDO::PARAM_STR);
            $UPDATE->bindParam(':hello', $hello_name, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            header('Location: ../../../Life/Reports/Pad.php?result=UPDATED'); die;
            
        }
        
        if($query=='Edit') {
            
            
            $UPDATE = $pdo->prepare("UPDATE pad_statistics SET pad_statistics_group=:group, pad_statistics_lead=:lead, pad_statistics_closer=:closer, pad_statistics_notes=:notes, pad_statistics_status=:status, pad_statistics_year=:year, pad_statistics_col=:col, pad_statistics_updated_by=:hello WHERE pad_statistics_id=:id");
            $UPDATE->bindParam(':group', $pad_group, PDO::PARAM_STR); 
            $UPDATE->bindParam(':id', $pad_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':lead', $lead, PDO::PARAM_STR); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':notes', $notes, PDO::PARAM_STR); 
            $UPDATE->bindParam(':status', $status, PDO::PARAM_STR); 
            $UPDATE->bindParam(':year', $year, PDO::PARAM_STR); 
            $UPDATE->bindParam(':col', $col, PDO::PARAM_STR);
            $UPDATE->bindParam(':hello', $hello_name, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            header('Location: ../../../Life/Reports/Pad.php?result=UPDATED'); die;
            
        }        
        
        if($query=='Delete') {
            
            $pad_id= filter_input(INPUT_GET, 'pad_id', FILTER_SANITIZE_NUMBER_INT);  
            
            $DELETE = $pdo->prepare("DELETE FROM pad_statistics WHERE pad_statistics_id=:id LIMIT 1");
            $DELETE->bindParam(':id', $pad_id, PDO::PARAM_INT); 
            $DELETE->execute();
            
            header('Location: ../../../Life/Reports/Pad.php?result=DELETED'); die;
            
        }        
        
        if($query=='Alledit') {
            
            $UPDATE = $pdo->prepare("UPDATE closer_pads set col=:col, lead_up=:up,  closer=:closer, lead=:lead, notes=:notes, status=:status, year=:year, our_premium=:added_by, comments=:comments, sale=:sale WHERE pad_id=:id");
            $UPDATE->bindParam(':id', $pad_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':lead', $lead, PDO::PARAM_STR); 
            $UPDATE->bindParam(':notes', $notes, PDO::PARAM_STR); 
            $UPDATE->bindParam(':status', $status, PDO::PARAM_STR); 
            $UPDATE->bindParam(':year', $year, PDO::PARAM_STR); 
            $UPDATE->bindParam(':up', $LEAD_UP, PDO::PARAM_STR);
            $UPDATE->bindParam(':added_by', $added_by, PDO::PARAM_STR); 
            $UPDATE->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $UPDATE->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $UPDATE->bindParam(':col', $MTG, PDO::PARAM_STR); 
            $UPDATE->execute();
            
            header('Location: ../../../Life/Reports/Pad.php?result=UPDATED'); die;
            
        }        
        
        }
        
        header('Location: ../../../Life/Reports/Pad.php?query=ERROR'); die;
        
        ?>