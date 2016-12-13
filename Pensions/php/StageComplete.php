<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    $stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_NUMBER_INT);
    $policy_id= filter_input(INPUT_GET, 'policy_id', FILTER_SANITIZE_NUMBER_INT);
    $complete= filter_input(INPUT_GET, 'complete', FILTER_SANITIZE_NUMBER_INT);
    
    if(isset($stage)) {
        if($stage=='1') {
            include('../../classes/database_class.php');
            include('../../includes/adlfunctions.php');  
            
            $database = new Database(); 
           
            if($complete=='1') {
            
            $database->query("UPDATE pension_stages set updated_by=:hello, active_stage='N' where client_id=:cid AND stage='1'");
            $database->bind(':cid',$search);
            $database->bind(':hello',$hello_name);
            $database->execute(); 
                   
            $notedata= "Stage Complete";
            $clientnamedata= "Stage 1";
            $messagedata="Stage 1 completed";
            
            $database->query("INSERT INTO pension_client_note set client_id=:clientid, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $database->bind(':clientid',$search);
            $database->bind(':sentbyholder',$hello_name);
            $database->bind(':recipientholder',$clientnamedata);
            $database->bind(':noteholder',$notedata);
            $database->bind(':messageholder',$messagedata);
            $database->execute(); 
            
            $stage1stage="1.1";
            $stage1task1="Check all documents are complete";
            $stage1task2="Upload pension statement/policy number";
            $stage1task3="Policy has a National Insurance (NI) number";
            $stage1task4="Letter of Authority (LoA) uploaded";
            $stage1task5="Upload Dealsheet";
            $stage1task6="Upload Terms of Business (ToB)";
            $stage1task7="Upload Proof of ID";
            $stage1task8="Upload Proof of Address";

$stage1 = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1->bindParam(':task',$stage1task1, PDO::PARAM_STR, 2500);
$stage1->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

$stage1a = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1a->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1a->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1a->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1a->bindParam(':task',$stage1task2, PDO::PARAM_STR, 2500);
$stage1a->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1a->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1b = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1b->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1b->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1b->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1b->bindParam(':task',$stage1task3, PDO::PARAM_STR, 2500);
$stage1b->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1b->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1c = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1c->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1c->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1c->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1c->bindParam(':task',$stage1task4, PDO::PARAM_STR, 2500);
$stage1c->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1c->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1d = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1d->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1d->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1d->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1d->bindParam(':task',$stage1task5, PDO::PARAM_STR, 2500);
$stage1d->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1d->execute()or die(print_r($stage1a->errorInfo(), true)); 

$stage1d = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1d->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1d->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1d->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1d->bindParam(':task',$stage1task6, PDO::PARAM_STR, 2500);
$stage1d->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1d->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1d = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1d->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1d->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1d->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1d->bindParam(':task',$stage1task7, PDO::PARAM_STR, 2500);
$stage1d->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1d->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1d = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1d->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1d->bindParam(':clientid',$search, PDO::PARAM_INT);
$stage1d->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1d->bindParam(':task',$stage1task8, PDO::PARAM_STR, 2500);
$stage1d->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1d->execute()or die(print_r($stage1a->errorInfo(), true));  


$messagedata2="Stage 1.1 Tasks Added";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$penclient, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata2, PDO::PARAM_STR, 2500);
$query->execute(); 


            header('Location: ../ViewClient.php?StageComplete=Stage 1&search='.$search); die;
            
            }
 
    }
    
    }

?>