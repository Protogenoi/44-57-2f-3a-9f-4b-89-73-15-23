<?php 

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/ADL_PDO_CON.php');


      $updatesms= filter_input(INPUT_GET, 'updatesms', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($updatesms =='y') {


$message= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("UPDATE sms_templates SET title=:titleholder, message=:messageholder WHERE id =:idholder ");

$query->bindParam(':idholder',$id, PDO::PARAM_INT);
$query->bindParam(':messageholder',$message, PDO::PARAM_STR, 2500);
$query->bindParam(':titleholder',$title, PDO::PARAM_STR, 2500);
$query->execute()or die(print_r($query->errorInfo(), true));
                        if(isset($fferror)) {
    if($fferror=='0') {
    
    header('Location: ../admin/Admindash.php?SMS=y&SMSupdated=y'); die;
    }
                        }
    }  
    
    
else {
    if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?SMS=y&SMSupdated=fail'); die;
    }
                        }
}


?>
