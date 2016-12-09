<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/ADL_PDO_CON.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_FILES["csv"]["size"] > 0) {

    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");

    do {
        
        $cid= filter_var($data[0], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pid= filter_var($data[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name= filter_var($data[2], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $note= filter_var($data[3], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message= filter_var($data[4], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sent= filter_var($data[5], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date= filter_var($data[6], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
 
        
        if ($data[0]) {
            
$ewsdata = $pdo->prepare("INSERT INTO client_note set client_id=:cid, policy_id=:pid, client_name=:name, note_type=:note, message=:message, sent_by=:sent, date_sent=:date");     


        $ewsdata->bindParam(':cid',$cid, PDO::PARAM_INT);
        $ewsdata->bindParam(':pid',$pid, PDO::PARAM_INT);
        $ewsdata->bindParam(':name',$name, PDO::PARAM_STR);
        $ewsdata->bindParam(':note',$note, PDO::PARAM_STR);
        $ewsdata->bindParam(':message',$message, PDO::PARAM_STR);
        $ewsdata->bindParam(':sent',$sent, PDO::PARAM_STR);
        $ewsdata->bindParam(':date',$date, PDO::PARAM_STR);
            $ewsdata->execute()or die(print_r($ewsdata->errorInfo(), true)); 
            $count = $ewsdata->rowCount();
        }
    } while ($data = fgetcsv($handle,2500,",","'"));

header('Location: ../Upload.php?success=1&rows='.$count); die;

}

?>