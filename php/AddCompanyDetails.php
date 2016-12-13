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

$company= filter_input(INPUT_GET, 'company', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($company)) {
    
$companyname= filter_input(INPUT_POST, 'companyname', FILTER_SANITIZE_SPECIAL_CHARS);
$contactname= filter_input(INPUT_POST, 'contactname', FILTER_SANITIZE_SPECIAL_CHARS);
$companynum= filter_input(INPUT_POST, 'companynum', FILTER_SANITIZE_SPECIAL_CHARS);
$companyip= filter_input(INPUT_POST, 'companyip', FILTER_SANITIZE_SPECIAL_CHARS);

$dupcheck = "Select id from company_details";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
 
    $query = $pdo->prepare("UPDATE company_details set company_name=:companyholder, contact_person=:personholder, ip_address=:ipholder, contact_number=:numholder, added_by=:userholder WHERE id =:iddupe");
    
        $query->bindParam(':iddupe', $dupeclientid, PDO::PARAM_INT);
        $query->bindParam(':companyholder', $companyname, PDO::PARAM_STR, 500);
        $query->bindParam(':personholder', $contactname, PDO::PARAM_STR, 500);
        $query->bindParam(':numholder', $companynum, PDO::PARAM_STR, 500);
        $query->bindParam(':ipholder', $companyip, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));

            if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?companydetails=y&company=y'); die;
    }
            }
    }

    
    $query = $pdo->prepare("INSERT INTO company_details set company_name=:companyholder, contact_person=:personholder, ip_address=:ipholder, contact_number=:numholder, added_by=:userholder");
    
        $query->bindParam(':companyholder', $companyname, PDO::PARAM_STR, 500);
        $query->bindParam(':personholder', $contactname, PDO::PARAM_STR, 500);
        $query->bindParam(':numholder', $companynum, PDO::PARAM_STR, 500);
        $query->bindParam(':ipholder', $companyip, PDO::PARAM_STR, 500);
        $query->bindParam(':userholder', $hello_name, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
    
            if(isset($fferror)) {
    if($fferror=='0') {
        
    header('Location: ../admin/Admindash.php?companydetails=y&company=y'); die;
    }
            }
}

else {
        if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../admin/Admindash.php?companydetails=failed&company=y'); die;
    }
        }
}




