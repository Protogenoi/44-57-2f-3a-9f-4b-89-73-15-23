<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$AddPension= filter_input(INPUT_GET, 'AddPension', FILTER_SANITIZE_SPECIAL_CHARS);
$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$addmorepolicy= filter_input(INPUT_POST, 'addmorepolicy', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($query)) {
    include('../includes/ADL_PDO_CON.php');
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);   
    if($query=='HomeInsurance') {
        $policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $sale_date= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $premium= filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
        $type= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
        $commission= filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
        $policystatus= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
        $lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
        $cover= filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($policy_number=='TBC' || $policy_number=='tbc') { 
            $random_id=mt_rand(5, 99);
            $policy_number="$policy_number $random_id";
            
        }
        
        $dupeck = $pdo->prepare("SELECT policy_number from home_policy where policy_number=:pol");
        $dupeck->bindParam(':pol',$policy_number, PDO::PARAM_STR);
        $dupeck->execute(); 
        $row=$dupeck->fetch(PDO::FETCH_ASSOC);
        if ($count = $dupeck->rowCount()>=1) {  
            $dupepol="$row[policy_number] DUPE";       
            
            $insert = $pdo->prepare("INSERT INTO home_policy set client_id=:cid, client_name=:name, sale_date=:sale, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, added_by=:hello, commission=:commission, status=:status, closer=:closer, lead=:lead, cover=:cover");
            $insert->bindParam(':cid',$CID, PDO::PARAM_STR);
            $insert->bindParam(':name',$client_name, PDO::PARAM_STR);
            $insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
            $insert->bindParam(':policy',$dupepol, PDO::PARAM_STR);
            $insert->bindParam(':premium',$premium, PDO::PARAM_STR);
            $insert->bindParam(':type',$type, PDO::PARAM_STR);
            $insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
            $insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
            $insert->bindParam(':commission',$commission, PDO::PARAM_STR);
            $insert->bindParam(':status',$policystatus, PDO::PARAM_STR);
            $insert->bindParam(':closer',$closer, PDO::PARAM_STR);
            $insert->bindParam(':lead',$lead, PDO::PARAM_STR);
            $insert->bindParam(':cover',$cover, PDO::PARAM_STR);
            $insert->execute(); 
            
            $notedata= "Policy Added";
            $messagedata="Policy added $dupepol duplicate of $policy_number";
 
            $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
            $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
            $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
            $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
            $query->execute();
            
            $client_type = $pdo->prepare("UPDATE client_details set client_type='Home' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id',$client_id, PDO::PARAM_STR);
            $client_type->execute();
            
            if(isset($fferror)) {
                if($fferror=='0') {   
                    header('Location: ../Home/ViewClient.php?policyadded=y&search='.$CID.'&dupepolicy='.$dupepol.'&origpolicy='.$policy_number); die;     
                    
                }
                
                }
                
                }
                
                $insert = $pdo->prepare("INSERT INTO home_policy set client_id=:cid, client_name=:name, sale_date=:sale, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, added_by=:hello, commission=:commission, status=:status, closer=:closer, lead=:lead, cover=:cover");
                $insert->bindParam(':cid',$CID, PDO::PARAM_STR);
                $insert->bindParam(':name',$client_name, PDO::PARAM_STR);
                $insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
                $insert->bindParam(':policy',$policy_number, PDO::PARAM_STR);
                $insert->bindParam(':premium',$premium, PDO::PARAM_STR);
                $insert->bindParam(':type',$type, PDO::PARAM_STR);
                $insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
                $insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
                $insert->bindParam(':commission',$commission, PDO::PARAM_STR);
                $insert->bindParam(':status',$policystatus, PDO::PARAM_STR);
                $insert->bindParam(':closer',$closer, PDO::PARAM_STR);
                $insert->bindParam(':lead',$lead, PDO::PARAM_STR);
                $insert->bindParam(':cover',$cover, PDO::PARAM_STR);
                $insert->execute();
                
                $notedata= "Policy Added";
                $messagedata="Policy $policy_number added";
                
                $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
                $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                $query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
                $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
                $query->execute(); 
                
                if(isset($fferror)) {
                    if($fferror=='0') {
                        header('Location: ../Home/ViewClient.php?policyadded=y&search='.$CID.'&policy_number='.$policy_number); die;
                        }
                        
                    }
                    
                    }
                    
                    }

include('../includes/ADL_PDO_CON.php');

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

header('Location: ../Pensions/ViewClient.php?policyadded=y&Stage=1&search='.$penclientid); die;
    }
}
    
}

if(isset($addmorepolicy)){
       
$custtype= filter_input(INPUT_POST, 'custtype', FILTER_SANITIZE_SPECIAL_CHARS);
$policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
$client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_SPECIAL_CHARS);
$client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$sale_date= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
$application_number= filter_input(INPUT_POST, 'application_number', FILTER_SANITIZE_SPECIAL_CHARS);
$premium= filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
$type= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
$commission= filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
$CommissionType= filter_input(INPUT_POST, 'CommissionType', FILTER_SANITIZE_SPECIAL_CHARS);
$PolicyStatus= filter_input(INPUT_POST, 'PolicyStatus', FILTER_SANITIZE_SPECIAL_CHARS);
$comm_term= filter_input(INPUT_POST, 'comm_term', FILTER_SANITIZE_SPECIAL_CHARS);
$drip= filter_input(INPUT_POST, 'drip', FILTER_SANITIZE_SPECIAL_CHARS);
$soj= filter_input(INPUT_POST, 'soj', FILTER_SANITIZE_SPECIAL_CHARS);
$closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$covera= filter_input(INPUT_POST, 'covera', FILTER_SANITIZE_SPECIAL_CHARS);
$polterm= filter_input(INPUT_POST, 'polterm', FILTER_SANITIZE_SPECIAL_CHARS);

$date2=date("Y-m-d G:i:s");

if($policy_number=='TBC' || $policy_number=='tbc') {
    
	$random_id=mt_rand(5, 99);
    $policy_number="$policy_number $random_id";
    
}

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$policy_number, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol="$row[policy_number] DUPE";        
           
         echo "duepde $dupepol";
         
$insert = $pdo->prepare("INSERT INTO client_policy set 
client_id=:cid,
 client_name=:name,
 sale_date=:sale,
 application_number=:an_num,
 policy_number=:policy,
 premium=:premium,
 type=:type,
 insurer=:insurer,
 submitted_by=:hello,
 edited=:helloed,
 commission=:commission,
 CommissionType=:CommissionType,
 PolicyStatus=:PolicyStatus,
 comm_term=:comm_term,
 drip=:drip,
 submitted_date=:date,
 soj=:soj,
 closer=:closer,
 lead=:lead,
 covera=:covera,
 polterm=:polterm");
$insert->bindParam(':cid',$client_id, PDO::PARAM_STR);
$insert->bindParam(':name',$client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$application_number, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol, PDO::PARAM_STR);
$insert->bindParam(':premium',$premium, PDO::PARAM_STR);
$insert->bindParam(':type',$type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':helloed',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$commission, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$PolicyStatus, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$drip, PDO::PARAM_STR);
$insert->bindParam(':date',$date2, PDO::PARAM_STR);
$insert->bindParam(':soj',$soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$lead, PDO::PARAM_STR);
$insert->bindParam(':covera',$covera, PDO::PARAM_STR);
$insert->bindParam(':polterm',$polterm, PDO::PARAM_STR);
$insert->execute();     


$notedata= "Policy Added";
$messagedata="Policy added $dupepol duplicate of $policy_number";
$clientnamedata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$client_id, PDO::PARAM_STR);
$client_type->execute(); 
  
if(isset($fferror)) {
    if($fferror=='0') {
     
header('Location: ../Life/ViewClient.php?policyadded=y&search='.$client_id.'&dupepolicy='.$dupepol.'&origpolicy='.$policy_number); die;     
    }
}
 }

$insert = $pdo->prepare("INSERT INTO client_policy set client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$client_id, PDO::PARAM_STR);
$insert->bindParam(':name',$client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$application_number, PDO::PARAM_STR);
$insert->bindParam(':policy',$policy_number, PDO::PARAM_STR);
$insert->bindParam(':premium',$premium, PDO::PARAM_STR);
$insert->bindParam(':type',$type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':helloed',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$commission, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$PolicyStatus, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$drip, PDO::PARAM_STR);
$insert->bindParam(':date',$date2, PDO::PARAM_STR);
$insert->bindParam(':soj',$soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$lead, PDO::PARAM_STR);
$insert->bindParam(':covera',$covera, PDO::PARAM_STR);
$insert->bindParam(':polterm',$polterm, PDO::PARAM_STR);
$insert->execute();  

    
$notedata= "Policy Added";
$messagedata="Policy $policy_number added";
$clientid= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$clientnamedata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$clientid, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 


}

else {

$policy_number= filter_input(INPUT_POST, 'policy_number', FILTER_SANITIZE_SPECIAL_CHARS);
$client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_SPECIAL_CHARS);
$client_name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$sale_date= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_SPECIAL_CHARS);
$application_number= filter_input(INPUT_POST, 'application_number', FILTER_SANITIZE_SPECIAL_CHARS);
$premium= filter_input(INPUT_POST, 'premium', FILTER_SANITIZE_SPECIAL_CHARS);
$type= filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_SPECIAL_CHARS);
$commission= filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_SPECIAL_CHARS);
$CommissionType= filter_input(INPUT_POST, 'CommissionType', FILTER_SANITIZE_SPECIAL_CHARS);
$PolicyStatus= filter_input(INPUT_POST, 'PolicyStatus', FILTER_SANITIZE_SPECIAL_CHARS);
$comm_term= filter_input(INPUT_POST, 'comm_term', FILTER_SANITIZE_SPECIAL_CHARS);
$drip= filter_input(INPUT_POST, 'drip', FILTER_SANITIZE_SPECIAL_CHARS);
$soj= filter_input(INPUT_POST, 'soj', FILTER_SANITIZE_SPECIAL_CHARS);
$closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$covera= filter_input(INPUT_POST, 'covera', FILTER_SANITIZE_SPECIAL_CHARS);
$polterm= filter_input(INPUT_POST, 'polterm', FILTER_SANITIZE_SPECIAL_CHARS);

$date2=date("Y-m-d G:i:s");

if($policy_number=='TBC' || $policy_number=='tbc') {
    
	$random_id=mt_rand(5, 99);
    $policy_number="$policy_number $random_id";
    
}

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$policy_number, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol="$row[policy_number] DUPE";        
           
         echo "duepde $dupepol";
         
$insert = $pdo->prepare("INSERT INTO client_policy set client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$client_id, PDO::PARAM_STR);
$insert->bindParam(':name',$client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$application_number, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol, PDO::PARAM_STR);
$insert->bindParam(':premium',$premium, PDO::PARAM_STR);
$insert->bindParam(':type',$type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':helloed',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$commission, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$PolicyStatus, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$drip, PDO::PARAM_STR);
$insert->bindParam(':date',$date2, PDO::PARAM_STR);
$insert->bindParam(':soj',$soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$lead, PDO::PARAM_STR);
$insert->bindParam(':covera',$covera, PDO::PARAM_STR);
$insert->bindParam(':polterm',$polterm, PDO::PARAM_STR);
$insert->execute();     


$notedata= "Policy Added";
$messagedata="Policy added $dupepol duplicate of $policy_number";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$client_id, PDO::PARAM_STR);
$client_type->execute(); 
  
if(isset($fferror)) {
    if($fferror=='0') {
     
header('Location: ../Life/ViewClient.php?policyadded=y&search='.$client_id.'&dupepolicy='.$dupepol.'&origpolicy='.$policy_number); die;     
    }
}
 }

$insert = $pdo->prepare("INSERT INTO client_policy set client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, edited=:helloed, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, submitted_date=:date, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$client_id, PDO::PARAM_STR);
$insert->bindParam(':name',$client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$application_number, PDO::PARAM_STR);
$insert->bindParam(':policy',$policy_number, PDO::PARAM_STR);
$insert->bindParam(':premium',$premium, PDO::PARAM_STR);
$insert->bindParam(':type',$type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':helloed',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$commission, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$PolicyStatus, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$drip, PDO::PARAM_STR);
$insert->bindParam(':date',$date2, PDO::PARAM_STR);
$insert->bindParam(':soj',$soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$lead, PDO::PARAM_STR);
$insert->bindParam(':covera',$covera, PDO::PARAM_STR);
$insert->bindParam(':polterm',$polterm, PDO::PARAM_STR);
$insert->execute();    

$notedata= "Policy Added";
$messagedata="Policy $policy_number added";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$client_name, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 
    
}

if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../Life/ViewClient.php?policyadded=y&search='.$client_id.'&policy_number='.$policy_number); die;
    }
}
?>

