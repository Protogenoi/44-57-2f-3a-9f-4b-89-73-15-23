<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/ADL_PDO_CON.php');

$emailsignature= filter_input(INPUT_GET, 'emailsignature', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($emailsignature)) {
    
$emailid= filter_input(INPUT_POST, 'emailid', FILTER_SANITIZE_SPECIAL_CHARS);
$sig= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$dupeck = $pdo->prepare("Select email_id from email_signatures WHERE email_id=:email");
$dupeck->bindParam(':email',$emailid, PDO::PARAM_INT);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupechecked=$row['email_id'];

     $query = $pdo->prepare("UPDATE email_signatures set sig=:sighold, added_by=:uphold where email_id=:emailidhold");    
        $query->bindParam(':emailidhold', $emailid, PDO::PARAM_INT);
        $query->bindParam(':sighold', $sig, PDO::PARAM_STR, 5000);
        $query->bindParam(':uphold', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));


   header('Location: ../Admindash.php?Emails=y&signature=updated'); die;

    }
    
    $query = $pdo->prepare("INSERT INTO email_signatures set email_id=:emailidhold, sig=:sighold, added_by=:uphold");
    $query->bindParam(':emailidhold', $emailid, PDO::PARAM_INT);
    $query->bindParam(':sighold', $sig, PDO::PARAM_STR, 5000);
    $query->bindParam(':uphold', $hello_name, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
        
   header('Location: ../Admindash.php?Emails=y&signature=y'); die;
    
}

else {
    
    header('Location: ../Admindash.php?Emails=y&signature=failed'); die;
    
}