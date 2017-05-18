<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {    
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../../includes/ADL_PDO_CON.php');
    
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($CID)) {
        
        $PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_SPECIAL_CHARS);
        $client_name=filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $sale_date=filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $policy_number=filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $premium=filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
        $type=filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $insurer=filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
        $commission=filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
        $status=filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $closer=filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
        $lead=filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
        $cover=filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_SPECIAL_CHARS);
        $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $dupeck = $pdo->prepare("SELECT policy_number from home_policy where policy_number=:pol AND client_id !=:id");
        $dupeck->bindParam(':pol',$policy_number, PDO::PARAM_STR);
        $dupeck->bindParam(':id',$CID, PDO::PARAM_STR);
        $dupeck->execute(); 
        $row=$dupeck->fetch(PDO::FETCH_ASSOC);
        if ($count = $dupeck->rowCount()>=1) {  
            $dupepol="$row[policy_number] DUPE";
            
            $query = $pdo->prepare("SELECT policy_number AS orig_policy FROM home_policy WHERE id=:origpolholder");
            $query->bindParam(':origpolholder',$PID, PDO::PARAM_INT);
            $query->execute(); 
            $origdetails=$query->fetch(PDO::FETCH_ASSOC);
            
            $oname=$origdetails['orig_policy'];
            
            $update = $pdo->prepare("UPDATE home_policy SET cover=:cover, client_name=:client_name, sale_date=:sale_date, policy_number=:policy_number, premium=:premium, type=:type, insurer=:insurer, commission=:commission, status=:status, edited=:edited, closer=:closer, lead=:lead WHERE id=:origpolholder");
            $update->bindParam(':origpolholder',$PID, PDO::PARAM_INT);
            $update->bindParam(':cover',$cover, PDO::PARAM_INT);
            $update->bindParam(':client_name',$client_name, PDO::PARAM_STR);
            $update->bindParam(':sale_date',$sale_date, PDO::PARAM_STR);
            $update->bindParam(':policy_number',$dupepol, PDO::PARAM_STR);
            $update->bindParam(':premium',$premium, PDO::PARAM_INT);
            $update->bindParam(':type',$type, PDO::PARAM_STR);
            $update->bindParam(':insurer',$insurer, PDO::PARAM_STR);
            $update->bindParam(':commission',$commission, PDO::PARAM_INT);
            $update->bindParam(':status',$status, PDO::PARAM_STR);
            $update->bindParam(':edited',$hello_name, PDO::PARAM_STR);
            $update->bindParam(':closer',$closer, PDO::PARAM_STR);
            $update->bindParam(':lead',$lead, PDO::PARAM_STR);
            $update->bindParam(':origpolholder',$PID, PDO::PARAM_INT);
            
            $clientnamedata2= $client_name;
            
            $notedata= "Policy Number Updated";
            $messagedata="Policy number updated $dupepol duplicate of $policy_number";
            
            $queryNote = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $queryNote->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
            $queryNote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
            $queryNote->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
            $queryNote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
            $queryNote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
            $queryNote->execute();

            
            if(isset($fferror)) {
                if($fferror=='0') {  
                    header('Location: ../ViewClient.php?policyadded=y&CID='.$CID.'&dupepolicy='.$dupepol.'&origpolicy='.$policy_number); die;
                    
                }
                
                }
                
                }
                
                $query = $pdo->prepare("SELECT policy_number AS orig_policy FROM home_policy WHERE id=:origpolholder");
                $query->bindParam(':origpolholder',$PID, PDO::PARAM_INT);
                $query->execute(); 
                $origdetails=$query->fetch(PDO::FETCH_ASSOC);
                
                $oname=$origdetails['orig_policy'];
                
                $update = $pdo->prepare("UPDATE home_policy set client_name=:name, sale_date=:sale, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, updated_by=:hello, commission=:commission, status=:status, closer=:closer, lead=:lead, cover=:cover WHERE client_id=:CID AND id=:PID");
                $update->bindParam(':PID',$PID, PDO::PARAM_STR);
                $update->bindParam(':CID',$CID, PDO::PARAM_STR);
                $update->bindParam(':name',$client_name, PDO::PARAM_STR);
                $update->bindParam(':sale',$sale_date, PDO::PARAM_STR);
                $update->bindParam(':policy',$policy_number, PDO::PARAM_STR);
                $update->bindParam(':premium',$premium, PDO::PARAM_STR);
                $update->bindParam(':type',$type, PDO::PARAM_STR);
                $update->bindParam(':insurer',$insurer, PDO::PARAM_STR);
                $update->bindParam(':hello',$hello_name, PDO::PARAM_STR);
                $update->bindParam(':commission',$commission, PDO::PARAM_STR);
                $update->bindParam(':status',$status, PDO::PARAM_STR);
                $update->bindParam(':closer',$closer, PDO::PARAM_STR);
                $update->bindParam(':lead',$lead, PDO::PARAM_STR);
                $update->bindParam(':cover',$cover, PDO::PARAM_STR);
                $update->execute();
                
                $clientnamedata2= $client_name; 

                
                if(isset($changereason)){
                    if ($changereason =='Incorrect Policy Number') {
                                              
                        $notedata= "Policy Number Updated";
                        $clientnamedata= $PID ." - ". $policy_number;
                        $messagedata=$oname ." changed to ". $policy_number;
                        
                        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                        $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
                        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                        $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
                        $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                        $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
                        $query->execute();
                        
                    }
                    
                    $clientnamedata= $PID ." - ". $policy_number;
                    $notedata= "Policy Details Updated";
                    
                    $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                    $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
                    $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                    $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
                    $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                    $query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
                    $query->execute();
                    
                    }
                    
                    if(isset($fferror)) {
                        if($fferror=='0') {
                            header('Location: ../ViewClient.php?policyedited=y&CID='.$CID); die;
                            }
                            
                        }
                        
                        }
                        
                        if(isset($fferror)) {
                            if($fferror=='0') {
                                header('Location: ../../CRMmain.php?NoAccess'); die;
                                }
                                
                            }
?>