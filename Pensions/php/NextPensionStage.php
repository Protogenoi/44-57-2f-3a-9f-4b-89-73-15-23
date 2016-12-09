<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out();
}

include('../../includes/PDOcon.php');
    
    $policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    $stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($stage)) {

    
    if($stage=='1') {

        $stage1complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', active_stage='N' WHERE client_id =:id AND stage='1'");
        $stage1complate->bindParam(':id', $search, PDO::PARAM_INT);
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
        
        $riskprofile = $pdo->prepare("INSERT INTO pension_stages set complete='Yes', stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
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
        
      header('Location: ../ViewPensionClient.php?Stage=2&search='.$search); die;
        
    }
    

    
    if($stage=='2') {
        
        
        $stage2complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes', active_stage='N' WHERE client_id =:clientid AND stage='2'");
        $stage2complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage2complate->execute()or die(print_r($stage2complate->errorInfo(), true));
        
        $setstage3="3";
        $setstage3task1="Chase LOA";
        $setstage3task2="Confirmation of docs received";
              
        $stage3task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage3task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage3task->bindParam(':stage', $setstage3, PDO::PARAM_INT);
        $stage3task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage3task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage3task->bindParam(':task', $setstage3task1, PDO::PARAM_STR, 100);
        $stage3task->execute()or die(print_r($stage3task->errorInfo(), true));
        
        $stage3task2 = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage3task2->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage3task2->bindParam(':stage', $setstage3, PDO::PARAM_INT);
        $stage3task2->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage3task2->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage3task2->bindParam(':task', $setstage3task2, PDO::PARAM_STR, 100);
        $stage3task2->execute()or die(print_r($stage3task2->errorInfo(), true));
        
       header('Location: ../ViewPensionClient.php?Stage=3&search='.$search); die;
        
    }
    
    
        if($stage=='3') {
            
        $stage3complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes', active_stage='N' WHERE client_id =:clientid AND stage='3'");
        $stage3complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage3complate->execute()or die(print_r($stage3complate->errorInfo(), true));
        
        $setstage4="4";
        $setstage4task1="Ceeding Report";
        
        $stage4task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage4task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4task->bindParam(':stage', $setstage4, PDO::PARAM_INT);
        $stage4task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage4task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage4task->bindParam(':task', $setstage4task1, PDO::PARAM_STR, 100);
        $stage4task->execute()or die(print_r($stage4task->errorInfo(), true));
        
        $setstage4a="4";
        $setstage4atask1="Selecta Pension";
        
        $stage4atask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage4atask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4atask->bindParam(':stage', $setstage4a, PDO::PARAM_INT);
        $stage4atask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage4atask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage4atask->bindParam(':task', $setstage4atask1, PDO::PARAM_STR, 100);
        $stage4atask->execute()or die(print_r($stage4atask->errorInfo(), true));
        
        header('Location: ../ViewPensionClient.php?Stage=4&search='.$search); die;
        
        
    }
    
        if($stage=='4') {
        
        $stage4complate = $pdo->prepare("UPDATE pension_stages set stage_complete ='Y', complete='Yes', active_stage='N' WHERE client_id =:clientid'");
    
        $stage4complate->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage4complate->execute()or die(print_r($stage4complate->errorInfo(), true));
        
        $setstage5="5";
        $setstage5task1="Pension Review";
        
        $stage5task = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5task->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5task->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5task->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5task->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5task->bindParam(':task', $setstage5task1, PDO::PARAM_STR, 100);
        $stage5task->execute()or die(print_r($stage5task->errorInfo(), true));

        $setstage5atask1="IFA Call";
        
        $stage5atask = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5atask->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5atask->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5atask->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5atask->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5atask->bindParam(':task', $setstage5atask1, PDO::PARAM_STR, 100);
        $stage5atask->execute()or die(print_r($stage5task->errorInfo(), true));
        
        $setstagebtask12="Create Synaptics";
        
        $stage5task2 = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5task2->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5task2->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5task2->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5task2->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5task2->bindParam(':task', $setstagebtask12, PDO::PARAM_STR, 100);
        $stage5task2->execute()or die(print_r($stage5task->errorInfo(), true));
        
        $setstage5task3="Summary Report";
        
        $stage5task3 = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5task3->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5task3->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5task3->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5task3->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5task3->bindParam(':task', $setstage5task3, PDO::PARAM_STR, 100);
        $stage5task3->execute()or die(print_r($stage5task->errorInfo(), true));
        
        $setstage5task4="Send Synaptics to Client";
        
        $stage5task4 = $pdo->prepare("INSERT INTO pension_stages set stage=:stage, added_by=:hello, task=:task, policy_id=:policy, client_id=:clientid");
    
        $stage5task4->bindParam(':clientid', $search, PDO::PARAM_INT);
        $stage5task4->bindParam(':stage', $setstage5, PDO::PARAM_INT);
        $stage5task4->bindParam(':policy', $policyID, PDO::PARAM_INT);
        $stage5task4->bindParam(':hello', $hello_name, PDO::PARAM_STR, 100);
        $stage5task4->bindParam(':task', $setstage5task4, PDO::PARAM_STR, 100);
        $stage5task4->execute()or die(print_r($stage5task->errorInfo(), true));


        header('Location: ../ViewPensionClient.php?Stage=5&search='.$search); die;
        
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

        header('Location: ../ViewPensionClient.php?Stage=6&search='.$search); die;
        
    }
    
}
    
    


        ?>
   