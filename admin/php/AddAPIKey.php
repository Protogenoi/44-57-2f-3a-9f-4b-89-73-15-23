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
    
    
    $AddType= filter_input(INPUT_GET, 'AddType', FILTER_SANITIZE_SPECIAL_CHARS);
    
    
    if(isset($AddType)) {
        
        
        if($AddType=='PostCode') {
            
            $PostCodeAPI= filter_input(INPUT_POST, 'PostCodeAPI', FILTER_SANITIZE_SPECIAL_CHARS);

    include('../../classes/database_class.php');     
    
    
            $database = new Database(); 
            
            
            $database->query("SELECT id from api_keys WHERE type='PostCode'");
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
            $database->query("UPDATE api_keys SET api_key=:key, updated_by=:hello WHERE type='PostCode'");
            $database->bind(':key',$PostCodeAPI);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
            
            header('Location: /admin/Admindash.php?PostCode=y&PostCodeMSG=1'); die; 
                
            }
            
            else {
            
            $database->query("INSERT INTO api_keys SET api_key=:key, added_by=:hello, type='PostCode'");
            $database->bind(':key',$PostCodeAPI);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
            
           
            
            header('Location: /admin/Admindash.php?PostCode=y&PostCodeMSG=2'); die; 
            
            }
            
        header('Location: /admin/Admindash.php?PostCode=y&PostCodeMSG=3'); die;     
            
        }
        
        
    }