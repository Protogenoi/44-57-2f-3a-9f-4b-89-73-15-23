<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/Access_Levels.php');
if (!in_array($hello_name,$Level_10_Access, true)) {
    header('Location: /CRMmain.php?AccessDenied'); die;
    
}

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/ADL_PDO_CON.php');

$DeleteLifePolicy= filter_input(INPUT_GET, 'DeleteLifePolicy', FILTER_SANITIZE_SPECIAL_CHARS);
$home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
 
  if(isset($home)){
     $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
     $PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
     
     $delete = $pdo->prepare("DELETE FROM home_policy WHERE id=:PID AND client_id=:CID LIMIT 1");
     $delete->bindParam(':PID',$PID, PDO::PARAM_INT);
     $delete->bindParam(':CID',$CID, PDO::PARAM_INT);
     $delete->execute();
     
     if(isset($fferror)) {
         if($fferror=='0') {
             header('Location: ../Home/ViewClient.php?deletedpolicy=y&CID='.$CID); die;
             
         }
         
         }
         
         }

if(isset($DeleteLifePolicy)) {
    if($DeleteLifePolicy=='1') {

$policyID= filter_input(INPUT_POST, 'deletepolicyID', FILTER_SANITIZE_NUMBER_INT);
$client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);

$delete = $pdo->prepare("DELETE FROM client_policy WHERE id=:id limit 1 ");
$delete->bindParam(':id',$policyID, PDO::PARAM_INT);
$delete->execute();
   
        
        
        $subject= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $ref= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
 
        $notes= "Policy $subject ($policyID)";
        $notetypedata= "Policy Deleted";
        
        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$ref, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$notes, PDO::PARAM_STR, 2500);
        $query->execute();
        
        
        if(isset($fferror)) {
    if($fferror=='0') {
        
        header('Location: ../Life/ViewClient.php?deletedpolicy=y&search='.$client_id); die;
        
    }
    
        }
        
    }
}

        if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../CRMmain.php?AccessDenied'); die;

    }
        }

?>
