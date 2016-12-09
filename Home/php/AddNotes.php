<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }



$ViewClientNotes= filter_input(INPUT_GET, 'ViewClientNotes', FILTER_SANITIZE_NUMBER_INT);

if(isset($ViewClientNotes)) { 
    if($ViewClientNotes=='1') {
        
        include('../../includes/ADL_PDO_CON.php');
        
        $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
        $recipientdata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $messagedata= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
        $notetypedata="Client Note";
        
        $query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':CID',$CID, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $query->execute();
        
            if(isset($fferror)) {
    if($fferror=='0') {
        
        header('Location: ../ViewClient.php?clientnotesadded&CID='.$CID.'#menu4'); die;
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
