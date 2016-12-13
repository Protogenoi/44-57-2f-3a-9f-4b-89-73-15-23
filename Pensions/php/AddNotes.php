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

include('../includes/ADL_PDO_CON.php');

$ViewClientNotes= filter_input(INPUT_GET, 'ViewClientNotes', FILTER_SANITIZE_NUMBER_INT);

if(isset($ViewClientNotes)) { 
  
        if($ViewClientNotes=='1') {
        echo "TRUE";
        $keyfielddata= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
        $recipientdata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $messagedata= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        $notetypedata="Client Note";
        
        $query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':clientidholder',$keyfielddata, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
            if(isset($fferror)) {
    if($fferror=='0') {
        
        header('Location: /Pensions/ViewClient.php?clientnotesadded&search='.$keyfielddata.'#menu4'); die;
    }
            }
        
    }
    
    }
        if(isset($fferror)) {
    if($fferror=='0') {

#header('Location: ../../CRMmain.php?AddNote=failed'); die;
    }
        }
?>
