<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adlfunctions.php');
include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$deletesubmit= filter_input(INPUT_GET, 'deletefile', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($deletesubmit)){
    
    if($deletesubmit=='1') {
    
        include('../includes/ADL_PDO_CON.php');
        
    $locationvarplaceholder= filter_input(INPUT_POST, 'file', FILTER_SANITIZE_SPECIAL_CHARS);
    $idvarplaceholder= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
    
    $query = $pdo->prepare("DELETE FROM tbl_uploads where id = :id");
    unlink("../uploads/$locationvarplaceholder");
    $query->bindParam(':id', $idvarplaceholder, PDO::PARAM_INT);
    $query->execute();
    
    if ($count = $query->rowCount()>0) {      
        
                if(isset($fferror)) {
    if($fferror=='0') {
        
          header('Location: ../Life/ViewClient.php?DeleteUpload=1&search='.$search. '&count='.$count.'&file='.$locationvarplaceholder.'#menu2'); die;
    }
                }

    }
    
    else {
        if(isset($fferror)) {
            if($fferror=='0') {
                header('Location: ../Life/ViewClient.php?DeleteUpload=0&search='.$search.'#menu2'); die;
    }
                }
    }
    
    }
    
    }
    
    if(isset($fferror)) {
            if($fferror=='0') {
    
    header('Location: ../CRMmain.php'); die;
            }
    }
    ?>