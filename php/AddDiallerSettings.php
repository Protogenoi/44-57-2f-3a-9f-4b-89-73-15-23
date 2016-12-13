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

$datavar= filter_input(INPUT_GET, 'data', FILTER_SANITIZE_SPECIAL_CHARS);
$telvar= filter_input(INPUT_GET, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($datavar)) {
    
$dbsqlpass= filter_input(INPUT_POST, 'dbsqlpass', FILTER_SANITIZE_SPECIAL_CHARS);
$dbsqluser= filter_input(INPUT_POST, 'dbsqluser', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserverpass= filter_input(INPUT_POST, 'dbserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserveruser= filter_input(INPUT_POST, 'dbserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserverurl= filter_input(INPUT_POST, 'dbserverurl', FILTER_SANITIZE_SPECIAL_CHARS);

$servertype="Database";
    
    $query = $pdo->prepare("INSERT INTO vicidial_accounts set url=:urlholder, added_by=:helloholder, servertype=:typeholder, username=:userholder, password=:passholder, sqlpass=:sqlpassholder, sqluser=:sqluserholder");
    
        $query->bindParam(':sqlpassholder', $dbsqlpass, PDO::PARAM_STR, 500);
        $query->bindParam(':sqluserholder', $dbsqluser, PDO::PARAM_STR, 500);
        $query->bindParam(':passholder', $dbserverpass, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder', $dbserveruser, PDO::PARAM_STR, 500);
        $query->bindParam(':urlholder', $dbserverurl, PDO::PARAM_STR, 500);
        $query->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
        $query->bindParam(':typeholder', $servertype, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
    
                    if(isset($fferror)) {
    if($fferror=='0') {
        
    header('Location: ../admin/Admindash.php?vicidialaccount=database&Vicidial=y'); die;
    }
                    }
}

if (isset($telvar)) {
    
    
$telserverpass= filter_input(INPUT_POST, 'telserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
$telserveruser= filter_input(INPUT_POST, 'telserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
$telserverurl= filter_input(INPUT_POST, 'telserverurl', FILTER_SANITIZE_SPECIAL_CHARS);

$servertype2="Telephony";
   
    $query = $pdo->prepare("INSERT INTO vicidial_accounts set url=:urlholder2, added_by=:helloholder2, servertype=:typeholder2, username=:userholder2, password=:passholder2");
    
        $query->bindParam(':passholder2', $telserverpass, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder2', $telserveruser, PDO::PARAM_STR, 500);
        $query->bindParam(':urlholder2', $telserverurl, PDO::PARAM_STR, 500);
        $query->bindParam(':helloholder2', $hello_name, PDO::PARAM_STR, 500);
        $query->bindParam(':typeholder2', $servertype2, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
        
        
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?vicidialaccount=telephony&Vicidial=y'); die;
    }
                }
}

else {
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?vicidialaccount=failed&Vicidial=y'); die;
    }
                }
}


?>

