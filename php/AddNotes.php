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

include('../includes/ADL_PDO_CON.php');

$ViewPolicyNotes= filter_input(INPUT_GET, 'ViewPolicyNotes', FILTER_SANITIZE_NUMBER_INT);
$ViewClientNotes= filter_input(INPUT_GET, 'ViewClientNotes', FILTER_SANITIZE_NUMBER_INT);

if(isset($ViewPolicyNotes)) { if($ViewPolicyNotes=='1') {

$search= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
$client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

$notetypedata= "Policy Note";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$policy_number, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$notes, PDO::PARAM_STR, 2500);
$query->execute();

    if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../Life/ViewClient.php?search='.$search); die;
    }
    }

}
}

if(isset($ViewClientNotes)) { 
    if($ViewClientNotes=='1') {
        
        $keyfielddata= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
        $recipientdata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $messagedata= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        $notetypedata="Client Note";
        
        $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':clientidholder',$keyfielddata, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
            if(isset($fferror)) {
    if($fferror=='0') {
        
        header('Location: ../Life/ViewClient.php?clientnotesadded&search='.$keyfielddata.'#menu4'); die;
    }
            }
        
    }
    
    }
        if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../CRMmain.php?Clientadded=failed'); die;
    }
        }
?>
