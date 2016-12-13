<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$emailsignature= filter_input(INPUT_GET, 'emailsignature', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($emailsignature)) {
    
$emailid= filter_input(INPUT_POST, 'emailid', FILTER_SANITIZE_SPECIAL_CHARS);
$sig= filter_input(INPUT_POST, 'editor_contents', FILTER_SANITIZE_SPECIAL_CHARS);
$uploadtype= filter_input(INPUT_POST, 'logo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$dupcheck = "Select email_id from email_signatures WHERE email_id='$emailid'";
$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupechecked=$row['email_id'];  
    
    }
 

     $query = $pdo->prepare("UPDATE email_signatures set sig=:sighold, added_by=:uphold, logo=:logohold where email_id=:emailidhold");
    
        $query->bindParam(':emailidhold', $emailid, PDO::PARAM_INT);
        $query->bindParam(':sighold', $sig, PDO::PARAM_STR, 5000);
        $query->bindParam(':logohold', $uploadtype, PDO::PARAM_STR, 500);
        $query->bindParam(':uphold', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));

echo "<p>$emailid - $sig - $uploadtype- $dupechecked</p>";
   header('Location: ../bootstrap-wysiwyg-master/Notestest.php?Emails=y&signature=updated'); die;

    }

    
    $query = $pdo->prepare("INSERT INTO email_signatures set email_id=:emailidhold, sig=:sighold, added_by=:uphold, logo=:logohold");
    
        $query->bindParam(':emailidhold', $emailid, PDO::PARAM_INT);
        $query->bindParam(':sighold', $sig, PDO::PARAM_STR, 5000);
        $query->bindParam(':logohold', $uploadtype, PDO::PARAM_STR, 500);
        $query->bindParam(':uphold', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));

        
        
   header('Location: ../bootstrap-wysiwyg-master/Notestest.php?Emails=y&signature=y'); die;
    
}

else {
    
    header('Location: ../bootstrap-wysiwyg-master/Notestest.php?Emails=y&signature=failed'); die;
    
}




