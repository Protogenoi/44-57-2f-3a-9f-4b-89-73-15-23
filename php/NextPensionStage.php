<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');
    
    $policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    $stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($stage)) {

    
    if($stage=='1') {
        
        
        $stage1complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes' WHERE client_id =:clientid AND stage='1'");
    
        $stage1complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage1complate->execute()or die(print_r($stage1complate->errorInfo(), true));
        
        $setstage2="2";
        $setstage2task1="Fact Find";
        $setstage2task2="Attitude to risk";
        $setstage2task3="Thank you call";
        $setstage2task4="Book FF RP";
        $setstage2task5="Download attitude to risk to CRM";
        
        echo"$search<br>$policyID<br>$hello_name<br>$setstage2<br>$setstage2task1<br>$setstage2task2";
        
        $factfindtask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $factfindtask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $factfindtask->bindParam(':stage', $setstage2, PDO::PARAM_INT);
        $factfindtask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $factfindtask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $factfindtask->bindParam(':task', $setstage2task1, PDO::PARAM_STR, 100);
        $factfindtask->execute()or die(print_r($factfindtask->errorInfo(), true));
        
        $riskprofile = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $riskprofile->bindParam(':clientid', $search, PDO::PARAM_INT);
        $riskprofile->bindParam(':stage', $setstage2, PDO::PARAM_INT);
        $riskprofile->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $riskprofile->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $riskprofile->bindParam(':task', $setstage2task2, PDO::PARAM_STR, 100);
        $riskprofile->execute()or die(print_r($riskprofile->errorInfo(), true));
        
        $thankcall = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $thankcall->bindParam(':clientid', $search, PDO::PARAM_INT);
        $thankcall->bindParam(':stage', $setstage2, PDO::PARAM_INT);
        $thankcall->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $thankcall->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $thankcall->bindParam(':task', $setstage2task3, PDO::PARAM_STR, 100);
        $thankcall->execute()or die(print_r($thankcall->errorInfo(), true));
        
        $book = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $book->bindParam(':clientid', $search, PDO::PARAM_INT);
        $book->bindParam(':stage', $setstage2, PDO::PARAM_INT);
        $book->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $book->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $book->bindParam(':task', $setstage2task4, PDO::PARAM_STR, 100);
        $book->execute()or die(print_r($book->errorInfo(), true));
        
        $download = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $download->bindParam(':clientid', $search, PDO::PARAM_INT);
        $download->bindParam(':stage', $setstage2, PDO::PARAM_INT);
        $download->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $download->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $download->bindParam(':task', $setstage2task5, PDO::PARAM_STR, 100);
        $download->execute()or die(print_r($download->errorInfo(), true));
        
        header('Location: ../ViewClient.php?Stage=2&search='.$search); die;
        
    }
    

    
    if($stage=='2') {
        
        
        $stage2complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes' WHERE client_id =:clientid AND task='Attitude to risk' OR task='Fact Find'");
    
        $stage2complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage2complate->execute()or die(print_r($stage2complate->errorInfo(), true));
        
        $setstage3="3";
        $setstage3task1="Awaiting Report";
        
        echo"$search<br>$policyID<br>$hello_name<br>$setstage3<br>$setstage3task1";
        
        $stage3task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage3task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage3task->bindParam(':stage', $setstage3, PDO::PARAM_INT);
        $stage3task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage3task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage3task->bindParam(':task', $setstage3task1, PDO::PARAM_STR, 100);
        $stage3task->execute()or die(print_r($stage3task->errorInfo(), true));
        
        $setstage4="4";
        $setstage4task1="Research and prep";
        
        $stage4task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage4task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4task->bindParam(':stage', $setstage4, PDO::PARAM_INT);
        $stage4task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage4task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage4task->bindParam(':task', $setstage4task1, PDO::PARAM_STR, 100);
        $stage4task->execute()or die(print_r($stage4task->errorInfo(), true));
        
        $setstage4a="4";
        $setstage4atask1="Soft Close";
        
        $stage4atask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage4atask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4atask->bindParam(':stage', $setstage4a, PDO::PARAM_INT);
        $stage4atask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage4atask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage4atask->bindParam(':task', $setstage4atask1, PDO::PARAM_STR, 100);
        $stage4atask->execute()or die(print_r($stage4atask->errorInfo(), true));
        
        $setstage4b="4";
        $setstage4btask1="Selecta Pension";
        
        $stage4btask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage4btask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4btask->bindParam(':stage', $setstage4b, PDO::PARAM_INT);
        $stage4btask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage4btask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage4btask->bindParam(':task', $setstage4btask1, PDO::PARAM_STR, 100);
        $stage4btask->execute()or die(print_r($stage4btask->errorInfo(), true));
        

        
        
        
        header('Location: ../ViewClient.php?Stage=4&search='.$search); die;
        
    }
    
        if($stage=='4') {
        
        $stage4complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes' WHERE client_id =:clientid AND task='Research and prep' OR task ='Soft Close' OR task ='Selecta Pension'");
    
        $stage4complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4complate->execute()or die(print_r($stage4complate->errorInfo(), true));
        
        $setstage5="5";
        $setstage5task1="Report Summary";
        
        $stage5task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5task->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5task->bindParam(':task', $setstage5task1, PDO::PARAM_STR, 100);
        $stage5task->execute()or die(print_r($stage5task->errorInfo(), true));

        $setstage5atask1="Summary Sheet";
        
        $stage5atask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5atask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5atask->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5atask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5atask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5atask->bindParam(':task', $setstage5atask1, PDO::PARAM_STR, 100);
        $stage5atask->execute()or die(print_r($stage5task->errorInfo(), true));
        
        $setstage5btask1="Book in IFA Call";
        
        $stage5btask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5btask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5btask->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5btask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5btask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5btask->bindParam(':task', $setstage5btask1, PDO::PARAM_STR, 100);
        $stage5btask->execute()or die(print_r($stage5task->errorInfo(), true));

        header('Location: ../ViewClient.php?Stage=5&search='.$search); die;
        
    }
    
            if($stage=='5') {
        
        $stage5complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes' WHERE client_id =:clientid AND task='Report Summary' OR task ='Summary Sheet' OR task ='Book in IFA Call'");
        $stage5complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5complate->execute()or die(print_r($stage5complate->errorInfo(), true));
        
        $setstage6="6";
        $setstage6atask1="Upload Selecta Pension Part 2";
        
        $stage6atask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
        $stage6atask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage6atask->bindParam(':stage', $setstage6, PDO::PARAM_INT);
        $stage6atask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage6atask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage6atask->bindParam(':task', $setstage6atask1, PDO::PARAM_STR, 100);
        $stage6atask->execute()or die(print_r($stage6atask->errorInfo(), true));

        header('Location: ../ViewClient.php?Stage=6&search='.$search); die;
        
    }
    
}
    
    


        ?>
   