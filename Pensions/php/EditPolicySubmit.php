<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../includes/ADL_PDO_CON.php');

$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

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
    
    $policy_id= filter_input(INPUT_POST, 'policy_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $dupeck = $pdo->prepare("SELECT policy_number from pension_policy where policy_number=:pol AND client_id !=:id");
$dupeck->bindParam(':pol',$penpol, PDO::PARAM_STR);
$dupeck->bindParam(':id',$search, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol="$row[policy_number] DUPE";  
         
    $query = $pdo->prepare("SELECT policy_number AS orig_policy FROM pension_policy WHERE id=:origpolholder");
$query->bindParam(':origpolholder',$policyunid, PDO::PARAM_INT);
$query->execute(); 
$origdetails=$query->fetch(PDO::FETCH_ASSOC);

$oname=$origdetails['orig_policy'];

    $addquery = $pdo->prepare("UPDATE pension_policy SET client_name=:clientname, provider=:provider, policy_number=:policy, type=:type, drawing=:drawing, duration=:duration, statements=:statements, contribution=:contribution, value=:value, status=:status, updated_by=:hello WHERE policy_id=:policy_id");
    
    $addquery->bindParam(':policy_id',$policy_id, PDO::PARAM_STR, 255);
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
          
        $notedata= "Policy Number Updated";
        $messagedata="Policy number updated $dupepol duplicate of $penpol";
        
        $queryNote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $queryNote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $queryNote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $queryNote->bindParam(':recipientholder',$penclient, PDO::PARAM_STR, 500);
        $queryNote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
        $queryNote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $queryNote->execute(); 
        
        if(isset($fferror)) {
    if($fferror=='0') {
     
header('Location: ../ViewClient.php?policyadded=y&search='.$search.'&dupepolicy='.$dupepol.'&origpolicy='.$penpol); die;     
    }
}
         
     }

$query = $pdo->prepare("SELECT policy_number AS orig_policy FROM pension_policy WHERE policy_id=:origpolholder");
$query->bindParam(':origpolholder',$policyunid, PDO::PARAM_INT);
$query->execute(); 
$origdetails=$query->fetch(PDO::FETCH_ASSOC);

$oname=$origdetails['orig_policy'];

    $addquery = $pdo->prepare("UPDATE pension_policy SET client_name=:clientname, provider=:provider, policy_number=:policy, type=:type, drawing=:drawing, duration=:duration, statements=:statements, contribution=:contribution, value=:value, status=:status, updated_by=:hello WHERE policy_id=:policy_id");
    
    $addquery->bindParam(':policy_id',$policy_id, PDO::PARAM_STR, 255);
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

$query = $pdo->prepare("UPDATE client_notes set client_name=:clientnameholder WHERE client_id=:clientidholder AND policy_number=:policynumberholder ");
$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':policynumberholder',$penpol, PDO::PARAM_INT);
$query->bindParam(':clientnameholder',$clientnamedata2, PDO::PARAM_STR, 500);
$query->execute(); 

$changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($changereason)){

    if ($changereason =='Incorrect Policy Number') {
                ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
     
        
$notedata= "Policy Number Updated";
$clientnamedata= $policyunid ." - ". $penpol;
$messagedata=$oname ." changed to ". $penpol;

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$query = $pdo->prepare("UPDATE client_notes set policy_number=:newpolicyholdercn WHERE client_id=:clientidholdercn AND policy_number=:oldpolicynumberholdercn ");
$query->bindParam(':clientidholdercn',$search, PDO::PARAM_INT);
$query->bindParam(':newpolicyholdercn',$penpol, PDO::PARAM_INT);
$query->bindParam(':oldpolicynumberholdercn',$oname, PDO::PARAM_STR, 500);
$query->execute(); 

    }
        
$clientnamedata= $policyunid ." - ". $penpol;   
$notedata= "Policy Details Updated";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
$query->execute();    
    
}

if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../ViewClient.php?policyedited=y&search='.$search); die;

    }
}

?>