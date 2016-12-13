<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/ADL_PDO_CON.php');

$AssignTasks= filter_input(INPUT_GET, 'AssignTasks', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($AssignTasks)) {
    if($AssignTasks=='1') {
    
$taskname= filter_input(INPUT_POST, 'tasknames', FILTER_SANITIZE_SPECIAL_CHARS);
$taskuser= filter_input(INPUT_POST, 'taskuser', FILTER_SANITIZE_SPECIAL_CHARS);

$dupe = $pdo->prepare("SELECT Task FROM Set_Client_Tasks WHERE Task=:task");
    
        $dupe->bindParam(':task', $taskname, PDO::PARAM_STR);
        $dupe->execute()or die(print_r($dupe->errorInfo(), true));
        if ($dupe->rowCount()<=0) {
            
            


$insert = $pdo->prepare("INSERT INTO Set_Client_Tasks set Assigned=:assign, Task=:task");
    
        $insert->bindParam(':task', $taskname, PDO::PARAM_STR);
        $insert->bindParam(':assign', $taskuser, PDO::PARAM_STR);
        $insert->execute()or die(print_r($insert->errorInfo(), true));
        if ($insert->rowCount()>=1) {
            
            if(isset($fferror)) {
                if($fferror=='0') {
                    header('Location: /admin/Admindash.php?TaskAssigned=y&AssignTasks=y&TaskAssignedTo='.$taskuser.'&TASKUPDATED='.$taskname); die;
                    }
                    }
            
        }
        
        }
        
        elseif ($dupe->rowCount()>=1) {
            
            $update = $pdo->prepare("UPDATE Set_Client_Tasks set Assigned=:assign WHERE Task=:task");
            $update->bindParam(':task', $taskname, PDO::PARAM_STR);
            $update->bindParam(':assign', $taskuser, PDO::PARAM_STR);
            $update->execute()or die(print_r($update->errorInfo(), true));
            
            if(isset($fferror)) {
                if($fferror=='0') {
                    header('Location: /admin/Admindash.php?TaskAssigned=y&AssignTasks=y&TaskAssignedTo='.$taskuser.'&TASKUPDATED='.$taskname); die;
                    }
                    }
        
        
        }

 
    

    }

}

else {

        if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: /admin/Admindash.php?TaskAssigned=failed&AssignTasks=y'); die;
    }
        }


}


