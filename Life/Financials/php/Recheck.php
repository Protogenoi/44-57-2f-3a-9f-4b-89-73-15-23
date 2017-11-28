<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);    
$BRID= filter_input(INPUT_GET, 'BRID', FILTER_SANITIZE_SPECIAL_CHARS);  
$AMOUNT= filter_input(INPUT_GET, 'AMOUNT', FILTER_SANITIZE_SPECIAL_CHARS);
$POLICY= filter_input(INPUT_GET, 'POLICY', FILTER_SANITIZE_SPECIAL_CHARS);

$INSURER= filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($EXECUTE)) {
        
                $CHK_CLIENT = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $CHK_CLIENT->bindParam(':polhold', $POLICY, PDO::PARAM_STR);
                $CHK_CLIENT->execute();
                $result=$CHK_CLIENT->fetch(PDO::FETCH_ASSOC);
                    
                if ($CHK_CLIENT->rowCount() >= 1) {  
                    
                            $CID=$result['client_id'];
                            $polid=$result['id'];
                            $policynumber=$result['policy_number'];
                            $PID= "$policynumber ($polid)";
                            $polstat=$result['policystatus'];
                                
                            $note="Financial Uploaded";                    
                
            if($AMOUNT >= 0) {
                
                    $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':clientid', $CID, PDO::PARAM_INT);
                    $insert->bindParam(':ref', $PID, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                    $delete = $pdo->prepare("DELETE FROM financials_nomatch WHERE bedrock_id=:BRID LIMIT 1");
                    $delete->bindParam(':BRID', $BRID, PDO::PARAM_INT);
                    $delete->execute();
  
                }
                        
                    if($AMOUNT < 0) {
                            
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':clientid', $CID, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $PID, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                                
                       $delete = $pdo->prepare("DELETE FROM financials_nomatch WHERE bedrock_id=:BRID  LIMIT 1");
                       $delete->bindParam(':BRID', $BRID, PDO::PARAM_INT);
                       $delete->execute();
               
                        }

                    if(isset($INSURER)) {
                        if($INSURER=='Aviva') {
                        header('Location: ../Aviva.php?RECHECK=y'); die;     
                        }
                        if($INSURER=='RoyalLondon') {
                         header('Location: ../RoyalLondon.php?RECHECK=y'); die;    
                        }
                        if($INSURER=='WOL') {
                        header('Location: ../OneFamily.php?RECHECK=y'); die;     
                        }
                        if($INSURER=='Vitality') {
                        header('Location: ../Vitality.php?RECHECK=y'); die;     
                        }
                    }                        
                        
 
                        } else {
                            header('Location: ../Aviva.php?RECHECK=n'); die;  
                        }
                 
}
                        ?>