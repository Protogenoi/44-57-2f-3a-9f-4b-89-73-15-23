<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
       
        
$adduser= filter_input(INPUT_GET, 'adduser', FILTER_SANITIZE_NUMBER_INT);

if(empty($adduser)) {

header('Location: ../../CRMmain.php'); die;

}



if (isset($adduser)) {
    
    include('../../includes/ADL_PDO_CON.php');
    
    if($adduser=='1') {
        
$password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$confirm= filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_SPECIAL_CHARS);

$login= filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
$name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$info= filter_input(INPUT_POST, 'info', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$msg=array("Passwords dont match","Email address already exists","Login already exists","Password too short","Password must include at least one number","Password must include at least one letter");

function validationcheck($password,$confirm,$email,$msg,$pdo,$login) {
    
   if($password != $confirm) { 
       
       $checklogin = $pdo->prepare("SELECT login FROM users WHERE login=:login");
       $checklogin->bindParam(':login',$login, PDO::PARAM_STR, 255);
       $checklogin->execute()or die(print_r($checklogin->errorInfo(), true));    
       if ($count = $checklogin->rowCount()>=1) {
           
       header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[0].','.$msg[2]); die;     
           
       }
              
       $checkemail = $pdo->prepare("SELECT email FROM users WHERE email=:email");
       $checkemail->bindParam(':email',$email, PDO::PARAM_STR, 255);
       $checkemail->execute()or die(print_r($checkemail->errorInfo(), true));    
       if ($count = $checkemail->rowCount()>=1) {

      header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[0].','.$msg[1]); die;  
        
    }
   
    header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[0]); die;
}

if($password==$confirm) {
    

    function passcheck_email($password,$msg) {
    
     if (strlen($password) < 8) {
            
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[1].','.$msg[3]); die; 
    }

    if (!preg_match("#[0-9]+#", $password)) {
        
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[1].','.$msg[4]); die;
    }

    if (!preg_match("#[a-zA-Z]+#", $password)) {
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[1].','.$msg[5]); die;
    }     
    
    
}

        function passcheck_login($password,$msg) {
    
     if (strlen($password) < 8) {
            
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[2].','.$msg[3]); die; 
    }

    if (!preg_match("#[0-9]+#", $password)) {
        
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[2].','.$msg[4]); die;
    }

    if (!preg_match("#[a-zA-Z]+#", $password)) {
        header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[2].','.$msg[5]); die;
    }     
    
    
}

   
        $checkemail = $pdo->prepare("SELECT email FROM users WHERE email=:email");
       $checkemail->bindParam(':email',$email, PDO::PARAM_STR, 255);
       $checkemail->execute()or die(print_r($checkemail->errorInfo(), true));    
       if ($count = $checkemail->rowCount()>=1) {
           
           passcheck_email($password,$msg);
           
           header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[1]); die;  
        
    }
    
       $checklogin = $pdo->prepare("SELECT login FROM users WHERE login=:login");
       $checklogin->bindParam(':login',$login, PDO::PARAM_STR, 255);
       $checklogin->execute()or die(print_r($checklogin->errorInfo(), true));    
       if ($count = $checklogin->rowCount()>=1) {
           
           passcheck_login($password,$msg);  
           
           header('Location: /admin/Admindash.php?users=y&adduser=0&message='.$msg[2]); die;     
           
       }
    
    
}

}


function adduser($pdo,$password,$login,$name,$info,$email) {
       
$hasspassword=md5($password);

$adduser = $pdo->prepare("INSERT INTO users set login=:login, pw=:password, real_name=:name, extra_info=:info, email=:email");
$adduser->bindParam(':login',$login, PDO::PARAM_STR, 255);
$adduser->bindParam(':password',$hasspassword, PDO::PARAM_STR, 255);
$adduser->bindParam(':name',$name, PDO::PARAM_STR, 255);
$adduser->bindParam(':info',$info, PDO::PARAM_STR, 255);
$adduser->bindParam(':email',$email, PDO::PARAM_STR, 255);
$adduser->execute()or die(print_r($adduser->errorInfo(), true)); 
                
        header('Location: /admin/Admindash.php?users=y&adduser=1&user='.$login); die;
        
    }
    
    
validationcheck($password,$confirm,$email,$msg,$pdo,$login);
adduser($pdo,$password,$login,$name,$info,$email);

} 
}

?>
