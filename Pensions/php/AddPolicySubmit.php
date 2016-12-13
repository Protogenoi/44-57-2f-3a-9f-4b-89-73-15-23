<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
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

$AddPension= filter_input(INPUT_GET, 'AddPension', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($AddPension)) {
    
    $penclientid= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $penclient= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $penpro= filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_SPECIAL_CHARS);
    $penpol= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
    $type= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $drawing= filter_input(INPUT_POST, 'drawing', FILTER_SANITIZE_SPECIAL_CHARS);
    $duration= filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_SPECIAL_CHARS);
    $statements= filter_input(INPUT_POST, 'statements', FILTER_SANITIZE_SPECIAL_CHARS);
    $contribution= filter_input(INPUT_POST, 'contribution', FILTER_SANITIZE_SPECIAL_CHARS);
    $penvalue= filter_input(INPUT_POST, 'value', FILTER_SANITIZE_SPECIAL_CHARS);
    $status= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $addquery = $pdo->prepare("INSERT INTO pension_policy SET client_id=:client, client_name=:clientname, provider=:provider, policy_number=:policy, type=:type, drawing=:drawing, duration=:duration, statements=:statements, contribution=:contribution, value=:value, status=:status, added_by=:hello");
    
    $addquery->bindParam(':client',$penclientid, PDO::PARAM_STR, 255);
    $addquery->bindParam(':clientname',$penclient, PDO::PARAM_STR, 255);
    $addquery->bindParam(':provider',$penpro, PDO::PARAM_STR, 255);
    $addquery->bindParam(':policy',$penpol, PDO::PARAM_STR, 255);
    $addquery->bindParam(':type',$type, PDO::PARAM_STR, 255);
    $addquery->bindParam(':drawing',$drawing, PDO::PARAM_STR, 255);
    $addquery->bindParam(':duration',$duration, PDO::PARAM_STR, 255);
    $addquery->bindParam(':statements',$statements, PDO::PARAM_STR, 255);
    $addquery->bindParam(':contribution',$contribution, PDO::PARAM_STR, 255);
    $addquery->bindParam(':value',$penvalue, PDO::PARAM_STR, 255);
    $addquery->bindParam(':status',$status, PDO::PARAM_STR, 255);
    $addquery->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
    $addquery->execute()or die(print_r($addquery->errorInfo(), true)); 
    
    $last_id = $pdo->lastInsertId();
    
    $policy_id=$last_id; 
    $notedata= "CRM Alert";
    $messagedata="Policy added";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$penclientid, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$penclient, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

    if($AddPension=='y') {

            $stage1stage="1";
            $stage1task1="Send Welcome Email";
            $stage1task2="Quickdox appointment";
            $stage1task3="Confirm Quickdox appointment";
            $stage1task4="Pack Collected";
            $stage1task5="Upload Dealsheet";

$stage1 = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1->bindParam(':clientid',$penclientid, PDO::PARAM_INT);
$stage1->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1->bindParam(':task',$stage1task1, PDO::PARAM_STR, 2500);
$stage1->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1->execute()or die(print_r($stage1->errorInfo(), true));  

$stage1a = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1a->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1a->bindParam(':clientid',$penclientid, PDO::PARAM_INT);
$stage1a->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1a->bindParam(':task',$stage1task2, PDO::PARAM_STR, 2500);
$stage1a->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1a->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1b = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1b->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1b->bindParam(':clientid',$penclientid, PDO::PARAM_INT);
$stage1b->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1b->bindParam(':task',$stage1task3, PDO::PARAM_STR, 2500);
$stage1b->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1b->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1c = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1c->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1c->bindParam(':clientid',$penclientid, PDO::PARAM_INT);
$stage1c->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1c->bindParam(':task',$stage1task4, PDO::PARAM_STR, 2500);
$stage1c->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1c->execute()or die(print_r($stage1a->errorInfo(), true));  

$stage1d = $pdo->prepare("INSERT INTO pension_stages set policy_id=:pol_id, client_id=:clientid, stage=:stage, task=:task, added_by=:addedby");

$stage1d->bindParam(':pol_id',$policy_id, PDO::PARAM_INT);
$stage1d->bindParam(':clientid',$penclientid, PDO::PARAM_INT);
$stage1d->bindParam(':stage',$stage1stage, PDO::PARAM_STR, 500);
$stage1d->bindParam(':task',$stage1task5, PDO::PARAM_STR, 2500);
$stage1d->bindParam(':addedby',$hello_name, PDO::PARAM_STR, 100);
$stage1d->execute()or die(print_r($stage1a->errorInfo(), true));  

$messagedata2="Stage 1 Tasks Added";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$penclientid, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$penclient, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata2, PDO::PARAM_STR, 2500);
$query->execute(); 

    if(isset($fferror)) {
        if($fferror=='0') {
            header('Location: ../ViewClient.php?policyadded=y&Stage=1&search='.$penclientid); die;
            }
            
        }

    }
    
    if(isset($fferror)) {
        if($fferror=='0') {
            header('Location: ../ViewClient.php?policyadded=y&search='.$penclientid); die;
            }
            
        }
        
        }
?>

