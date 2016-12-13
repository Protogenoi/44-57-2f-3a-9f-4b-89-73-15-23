<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    

    $assign= filter_input(INPUT_GET, 'assign', FILTER_SANITIZE_NUMBER_INT);
    
    if(isset($assign)) {
        if($assign=='1') {
            
 
            include('../../includes/ADL_PDO_CON.php');
            
            $assigned= filter_input(INPUT_POST, 'assigned', FILTER_SANITIZE_SPECIAL_CHARS);
            $taskid= filter_input(INPUT_POST, 'taskid', FILTER_SANITIZE_NUMBER_INT);
            
            $query = $pdo->prepare("UPDATE Client_Tasks set Assigned=:assigned where id =:id");
            $query->bindParam(':assigned', $assigned, PDO::PARAM_STR);
            $query->bindParam(':id', $taskid, PDO::PARAM_INT);
            $query->execute()or die(print_r($query->errorInfo(), true));
            if ($query->rowCount()>=1) { 
                
                
                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../Reports/Tasks.php?taskassigned=y&assignto='.$assigned); die;
                        }
                        }
                        }
                
                if ($query->rowCount()<=0) { 
                    
                    if(isset($fferror)) {
                        if($fferror=='0') {
                            header('Location: ../Reports/Tasks.php?taskassigned=failed'); die;
                            }
                            }
                            }
                            
                        }
                        
                        }
                
                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../../CRMmain.php'); die;
                        }
                        }
                ?>

