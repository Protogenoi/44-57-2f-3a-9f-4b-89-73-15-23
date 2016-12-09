<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$add= filter_input(INPUT_GET, 'add', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($add)) {


$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$initials= filter_input(INPUT_POST, 'initials', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
$address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
$address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
$address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
$town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
$post_code= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
$num1= filter_input(INPUT_POST, 'number1', FILTER_SANITIZE_SPECIAL_CHARS);
$num2= filter_input(INPUT_POST, 'number2', FILTER_SANITIZE_SPECIAL_CHARS);
$num3= filter_input(INPUT_POST, 'number3', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$initials2= filter_input(INPUT_POST, 'initials2', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
$ni_num= filter_input(INPUT_POST, 'ni_num', FILTER_SANITIZE_SPECIAL_CHARS);
$ni_num2= filter_input(INPUT_POST, 'ni_num2', FILTER_SANITIZE_SPECIAL_CHARS);

$addquery = $pdo->prepare("INSERT INTO pension_clients SET ni_num=:ninum, ni_num2=:ninum2, title=:title, first_name=:first, initials=:initials, last_name=:last, dob=:dob, title2=:titlehold, first_name2=:firsthold, initials2=:initialshold, last_name2=:lasthold, dob2=:dobhold, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, number1=:num1, number2=:num2, number3=:num3, email=:email, added_by=:hello");

$addquery->bindParam(':title',$title, PDO::PARAM_STR, 255);
$addquery->bindParam(':first',$first_name, PDO::PARAM_STR, 255);
$addquery->bindParam(':initials',$initials, PDO::PARAM_STR, 255);
$addquery->bindParam(':last',$last_name, PDO::PARAM_STR, 255);
$addquery->bindParam(':dob',$dob, PDO::PARAM_STR, 255);
$addquery->bindParam(':add1',$address1, PDO::PARAM_STR, 255);
$addquery->bindParam(':add2',$address2, PDO::PARAM_STR, 255);
$addquery->bindParam(':add3',$address3, PDO::PARAM_STR, 255);
$addquery->bindParam(':town',$town, PDO::PARAM_STR, 255);
$addquery->bindParam(':post',$post_code, PDO::PARAM_STR, 255);
$addquery->bindParam(':num1',$num1, PDO::PARAM_STR, 255);
$addquery->bindParam(':num2',$num2, PDO::PARAM_STR, 255);
$addquery->bindParam(':num3',$num3, PDO::PARAM_STR, 255);
$addquery->bindParam(':email',$email, PDO::PARAM_STR, 255);
$addquery->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
$addquery->bindParam(':titlehold',$title2, PDO::PARAM_STR, 255);
$addquery->bindParam(':firsthold',$first_name2, PDO::PARAM_STR, 255);
$addquery->bindParam(':initialshold',$initials2, PDO::PARAM_STR, 255);
$addquery->bindParam(':lasthold',$last_name2, PDO::PARAM_STR, 255);
$addquery->bindParam(':dobhold',$dob2, PDO::PARAM_STR, 255);
$addquery->bindParam(':ninum',$ni_num, PDO::PARAM_STR, 255);
$addquery->bindParam(':ninum2',$ni_num2, PDO::PARAM_STR, 255);
$addquery->execute()or die(print_r($addquery->errorInfo(), true)); 
$last_id = $pdo->lastInsertId();

$clientiddata = $last_id;
$notedata= "CRM Alert";
$clientnamedata= $title ." ". $first_name ." ". $last_name;
$messagedata="Client Uploaded";


$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$clientiddata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute()or die(print_r($query->errorInfo(), true));  

header('Location: ../Pensions/ViewPensionClient.php?Clientadded=y&search='.$last_id); die;
    
}

header('Location: ../CRMmain.php?Clientadded=failed'); die;
    
?>            