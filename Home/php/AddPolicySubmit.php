<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
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
 * 
*/  

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($query)) {
    include('../../includes/ADL_PDO_CON.php');
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);   
    if($query=='HomeInsurance') {
        $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $sale_date= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $premium= filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
        $type= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
        $commission= filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
        $policystatus= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
        $lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
        $cover= filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($policy_number=='TBC' || $policy_number=='tbc') { 
            $random_id=mt_rand(5, 99);
            $policy_number="$policy_number $random_id";
            
        }
        
        $dupeck = $pdo->prepare("SELECT policy_number from home_policy where policy_number=:pol");
        $dupeck->bindParam(':pol',$policy_number, PDO::PARAM_STR);
        $dupeck->execute(); 
        $row=$dupeck->fetch(PDO::FETCH_ASSOC);
        if ($count = $dupeck->rowCount()>=1) {  
            $dupepol="$row[policy_number] DUPE";       
            
            $insert = $pdo->prepare("INSERT INTO home_policy set client_id=:cid, client_name=:name, sale_date=:sale, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, added_by=:hello, commission=:commission, status=:status, closer=:closer, lead=:lead, cover=:cover");
            $insert->bindParam(':cid',$CID, PDO::PARAM_STR);
            $insert->bindParam(':name',$client_name, PDO::PARAM_STR);
            $insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
            $insert->bindParam(':policy',$dupepol, PDO::PARAM_STR);
            $insert->bindParam(':premium',$premium, PDO::PARAM_STR);
            $insert->bindParam(':type',$type, PDO::PARAM_STR);
            $insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
            $insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
            $insert->bindParam(':commission',$commission, PDO::PARAM_STR);
            $insert->bindParam(':status',$policystatus, PDO::PARAM_STR);
            $insert->bindParam(':closer',$closer, PDO::PARAM_STR);
            $insert->bindParam(':lead',$lead, PDO::PARAM_STR);
            $insert->bindParam(':cover',$cover, PDO::PARAM_STR);
            $insert->execute(); 
            
            $notedata= "Policy Added";
            $messagedata="Policy added $dupepol duplicate of $policy_number";
 
            $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
            $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
            $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
            $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
            $query->execute();
            
            $client_type = $pdo->prepare("UPDATE client_details set client_type='Home' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id',$CID, PDO::PARAM_STR);
            $client_type->execute();
            
            if(isset($fferror)) {
                if($fferror=='0') {   
                    header('Location: ../ViewClient.php?policyadded=y&CID='.$CID.'&dupepolicy='.$dupepol.'&origpolicy='.$policy_number); die;     
                    
                }
                
                }
                
                }
                
                $insert = $pdo->prepare("INSERT INTO home_policy set client_id=:cid, client_name=:name, sale_date=:sale, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, added_by=:hello, commission=:commission, status=:status, closer=:closer, lead=:lead, cover=:cover");
                $insert->bindParam(':cid',$CID, PDO::PARAM_STR);
                $insert->bindParam(':name',$client_name, PDO::PARAM_STR);
                $insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
                $insert->bindParam(':policy',$policy_number, PDO::PARAM_STR);
                $insert->bindParam(':premium',$premium, PDO::PARAM_STR);
                $insert->bindParam(':type',$type, PDO::PARAM_STR);
                $insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
                $insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
                $insert->bindParam(':commission',$commission, PDO::PARAM_STR);
                $insert->bindParam(':status',$policystatus, PDO::PARAM_STR);
                $insert->bindParam(':closer',$closer, PDO::PARAM_STR);
                $insert->bindParam(':lead',$lead, PDO::PARAM_STR);
                $insert->bindParam(':cover',$cover, PDO::PARAM_STR);
                $insert->execute();
                
                $notedata= "Policy Added";
                $messagedata="Policy $policy_number added";
                
                $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
                $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                $query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
                $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
                $query->execute(); 
                
                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../ViewClient.php?policyadded=y&CID='.$CID.'&policy_number='.$policy_number); die;
                        }
                        
                    }
                    
                    }
                    
                    }



if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../ViewClient.php?policyadded=y&CID='.$CID.'&policy_number='.$policy_number); die;
    }
}
?>

