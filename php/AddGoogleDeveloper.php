<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

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

$add= filter_input(INPUT_GET, 'add', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($add)) {
     

$googleapi= filter_input(INPUT_POST, 'googleapi', FILTER_SANITIZE_SPECIAL_CHARS);
$googletrackingid= filter_input(INPUT_POST, 'googletrackingid', FILTER_SANITIZE_SPECIAL_CHARS);

$dupcheck = "Select id from google_dev";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }

    $query = $pdo->prepare("UPDATE google_dev set tracking_id=:trackingidhold, api=:apihold, updated_by=:userholder WHERE id =:iddupe");
    
        $query->bindParam(':iddupe', $dupeclientid, PDO::PARAM_INT);
        $query->bindParam(':trackingidhold', $googletrackingid, PDO::PARAM_STR, 500);
        $query->bindParam(':apihold', $googleapi, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));

                    if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?Google=y&google=updated'); die;
    }
                    }
    }
    
    $query = $pdo->prepare("INSERT INTO google_dev set tracking_id=:trackingidhold, api=:apihold, added_by=:userholder");
    
        $query->bindParam(':trackingidhold', $googletrackingid, PDO::PARAM_STR, 500);
        $query->bindParam(':apihold', $googleapi, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
    
        
                    if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?Google=y&google=y'); die;
    }
                    }
}

else {
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?Google=y&google=failed'); die;
    }
                }
}




