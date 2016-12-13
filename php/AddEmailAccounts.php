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

include('../includes/ADL_PDO_CON.php');
include('../includes/ADL_MYSQLI_CON.php');

$emailaccount= filter_input(INPUT_POST, 'emailaccount', FILTER_SANITIZE_SPECIAL_CHARS);
$displayname= filter_input(INPUT_POST, 'displayname', FILTER_SANITIZE_SPECIAL_CHARS);
$emailtype= filter_input(INPUT_POST, 'emailtype', FILTER_SANITIZE_SPECIAL_CHARS);
$pop= filter_input(INPUT_POST, 'pop', FILTER_SANITIZE_SPECIAL_CHARS);
$popport= filter_input(INPUT_POST, 'popport', FILTER_SANITIZE_SPECIAL_CHARS);
$imap= filter_input(INPUT_POST, 'imap', FILTER_SANITIZE_SPECIAL_CHARS);
$imapport= filter_input(INPUT_POST, 'imapport', FILTER_SANITIZE_SPECIAL_CHARS);
$smtp= filter_input(INPUT_POST, 'smtp', FILTER_SANITIZE_SPECIAL_CHARS);
$smtpport= filter_input(INPUT_POST, 'smtpport', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);


$emailfrom= filter_input(INPUT_POST, 'emailfrom', FILTER_SANITIZE_SPECIAL_CHARS);
$emailreply= filter_input(INPUT_POST, 'emailreply', FILTER_SANITIZE_SPECIAL_CHARS);
$emailbcc= filter_input(INPUT_POST, 'emailbcc', FILTER_SANITIZE_SPECIAL_CHARS);
$emailsubject= filter_input(INPUT_POST, 'emailsubject', FILTER_SANITIZE_SPECIAL_CHARS);

if ($emailaccount =="account1") {
    
    $dupcheck = "Select id from email_accounts where emailaccount='account1'";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
    
        $query = $pdo->prepare("UPDATE email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder where emailaccount='account1'");
    
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	$query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
        $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
        $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
        $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
        $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
        $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
        $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
        
                                    if(isset($fferror)) {
    if($fferror=='0') {
        
        header('Location: ../admin/Admindash.php?emailaccount=account1&Emails=y'); die;
    }
                                    }
}

else {
    
    $query = $pdo->prepare("INSERT INTO email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, emailaccount=:emailaccountholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder");
    
        $query->bindParam(':emailaccountholder', $emailaccount, PDO::PARAM_STR, 500);
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
   

    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    
    header('Location: ../admin/Admindash.php?emailaccount=account1&Emails=y'); die;
    }
                                }
}

}

if ($emailaccount =="account2") {
    
        $dupcheck = "Select id from email_accounts where emailaccount='account2'";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
    
        $query = $pdo->prepare("UPDATE email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder where emailaccount='account2'");
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    
   header('Location: ../admin/Admindash.php?emailaccount=account2&Emails=y'); die;
    }
                                }
}
    else {
    $query = $pdo->prepare("INSERT INTO email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, emailaccount=:emailaccountholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder");
    
        $query->bindParam(':emailaccountholder', $emailaccount, PDO::PARAM_STR, 500);
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
   header('Location: ../admin/Admindash.php?emailaccount=account2&Emails=y'); die;
    }
                                }
}

}

if ($emailaccount =="account3") {
    
            $dupcheck = "Select id from email_accounts where emailaccount='account3'";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
    
        $query = $pdo->prepare("UPDATE email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder where emailaccount='account3'");
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?emailaccount=account3&Emails=y'); die;
    }
                                }
}

else {
    
    $query = $pdo->prepare("INSERT INTO email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, emailaccount=:emailaccountholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder");
    
        $query->bindParam(':emailaccountholder', $emailaccount, PDO::PARAM_STR, 500);
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?emailaccount=account3&Emails=y'); die;
    }
                                }
}

}

if ($emailaccount =="account4") {
    
                $dupcheck = "Select id from email_accounts where emailaccount='account4'";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
    
        $query = $pdo->prepare("UPDATE email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder where emailaccount='account4'");
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?emailaccount=account4&Emails=y'); die;
    }
                                }
}

else {
    
    $query = $pdo->prepare("INSERT INTO email_accounts set emailfrom=:emailfromholder, emailreply=:emailreplyholder, emailsubject=:emailsubjectholder, emailbcc=:emailbccholder, emailaccount=:emailaccountholder, displayname=:displaynameholder, emailtype=:emailtypeholder, pop=:popholder, popport=:popportholder, imap=:imapholder, imapport=:imapportholder, smtp=:smtpholder, smtpport=:smtpportholder, email=:emailholder, password=:passwordholder, added_by=:helloholder");
    
        $query->bindParam(':emailaccountholder', $emailaccount, PDO::PARAM_STR, 500);
        $query->bindParam(':displaynameholder', $displayname, PDO::PARAM_STR, 500);
        $query->bindParam(':emailtypeholder', $emailtype, PDO::PARAM_STR, 500);
        $query->bindParam(':popholder', $pop, PDO::PARAM_STR, 500);
        $query->bindParam(':popportholder', $popport, PDO::PARAM_STR, 500);
        $query->bindParam(':imapholder', $imap, PDO::PARAM_STR, 500);
        $query->bindParam(':imapportholder', $imapport, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpholder', $smtp, PDO::PARAM_STR, 500);
    	$query->bindParam(':smtpportholder', $smtpport, PDO::PARAM_STR, 500);
   	 $query->bindParam(':emailholder', $email, PDO::PARAM_STR, 500);
         $query->bindParam(':passwordholder', $password, PDO::PARAM_STR, 2500);
         $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
         $query->bindParam(':emailfromholder', $emailfrom, PDO::PARAM_STR, 500);
         $query->bindParam(':emailreplyholder', $emailreply, PDO::PARAM_STR, 500);
         $query->bindParam(':emailbccholder', $emailbcc, PDO::PARAM_STR, 500);
         $query->bindParam(':emailsubjectholder', $emailsubject, PDO::PARAM_STR, 500);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
                                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?emailaccount=account4&Emails=y'); die;
    }
                                }
}
}


                               if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?emailaccount=failed&Emails=y'); die;
    
    }
                               }
                               
                               ?>