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
include('../../includes/ADL_MYSQLI_CON.php');

$datavar= filter_input(INPUT_GET, 'data', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($datavar)) {

    $dbserverpass= filter_input(INPUT_POST, 'dbserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
    $dbserveruser= filter_input(INPUT_POST, 'dbserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
    $dbserverurl= filter_input(INPUT_POST, 'dbserverurl', FILTER_SANITIZE_SPECIAL_CHARS);
$servertype="Web";

$dupcheck = "Select id from connex_accounts";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {

     $UPDATE = $pdo->prepare("UPDATE connex_accounts set url=:url, added_by=:hello, servertype=:type, username=:user, password=:pass");
        $UPDATE->bindParam(':pass', $dbserverpass, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':user', $dbserveruser, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':url', $dbserverurl, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':hello', $hello_name, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':type', $servertype, PDO::PARAM_STR, 500);
        $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));   
}
if ($duperaw->num_rows <= 0) {
    
    $INSERT = $pdo->prepare("INSERT INTO connex_accounts set url=:url, added_by=:hello, servertype=:type, username=:user, password=:pass");
        $INSERT->bindParam(':pass', $dbserverpass, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':user', $dbserveruser, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':url', $dbserverurl, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':hello', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':type', $servertype, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
        
}
    
                    if(isset($fferror)) {
    if($fferror=='0') {
        
    header('Location: ../../admin/Admindash.php?connexaccount=database&Connex=y'); die;
    }
                    }
}


else {
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../../admin/Admindash.php?connexaccount=failed&Connex=y'); die;
    }
                }
}


?>

