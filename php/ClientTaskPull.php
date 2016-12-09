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

        
include('../includes/ADL_PDO_CON.php');

$option= filter_input(INPUT_POST, 'Taskoption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($option)) {

    $HappyPol= filter_input(INPUT_POST, 'HappyPol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $DocsArrived= filter_input(INPUT_POST, 'DocsArrived', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $CYDReturned= filter_input(INPUT_POST, 'CYDReturned', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $RemindDD= filter_input(INPUT_POST, 'RemindDD', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $PitchTPS= filter_input(INPUT_POST, 'PitchTPS', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $PitchTrust= filter_input(INPUT_POST, 'PitchTrust', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Upsells= filter_input(INPUT_POST, 'Upsells', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
    
    $SELECTquery = $pdo->prepare("SELECT Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks WHERE client_id=:cid");
    $SELECTquery->bindParam(':cid', $search, PDO::PARAM_INT); 
    $SELECTquery->execute();
    
    $VAR1=$SELECTquery['Upsells'];
    $VAR2=$SELECTquery['PitchTrust'];
    $VAR3=$SELECTquery['PitchTPS'];
    $VAR4=$SELECTquery['RemindDD'];
    $VAR5=$SELECTquery['CYDReturned'];
    $VAR6=$SELECTquery['DocsArrived'];
    $VAR7=$SELECTquery['HappyPol'];
       
    
    if($VAR1 != $Upsells) {
        
        $VAR1="Upsells - $Upsells";
        
    }
    
        if($VAR2 != $PitchTrust) {
            
            $VAR2="Pitch Trust - $PitchTrust";
        
    }
    
        if($VAR3 != $PitchTPS) {
            
            $VAR3="Pitch TPS - $PitchTPS";
        
    }
    
        if($VAR4 != $RemindDD) {
            
            $VAR4="Remind/Cancel Old/New DD - $RemindDD";
        
    }
    
        if($VAR5 != $CYDReturned) {
            
            $VAR5="CYD Returned? - $CYDReturned";
        
    }
    
    
        if($VAR6 != $DocsArrived) {
            
            $VAR6="Docs Emailed? - $DocsArrived";
        
    }
    
        if($VAR7 != $HappyPol) {
            
            $VAR7= "Happy with Policy - $HappyPol";
        
    }
    
    

        $query = $pdo->prepare("UPDATE Client_Tasks set Upsells=:Upsells, PitchTrust=:PitchTrust, PitchTPS=:PitchTPS, RemindDD=:RemindDD, CYDReturned=:CYDReturned, DocsArrived=:DocsArrived, HappyPol=:HappyPol WHERE client_id=:cid");
        
        $query->bindParam(':HappyPol', $HappyPol, PDO::PARAM_STR);
        $query->bindParam(':DocsArrived', $DocsArrived, PDO::PARAM_STR);
        $query->bindParam(':CYDReturned', $CYDReturned, PDO::PARAM_STR);
        $query->bindParam(':RemindDD', $RemindDD, PDO::PARAM_STR);
        $query->bindParam(':PitchTPS', $PitchTPS, PDO::PARAM_STR);
        $query->bindParam(':PitchTrust', $PitchTrust, PDO::PARAM_STR);
        $query->bindParam(':Upsells', $Upsells, PDO::PARAM_STR);
        $query->bindParam(':cid', $search, PDO::PARAM_INT); 
        $query->execute();
        
    if($option=='24 48' || $option ='5 day') {
    
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task IN('5 day','24 48','CYD')");
        $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
        $complete->execute();    
        
    }    
        
   else {
        
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task=:Taskoption");        
        $complete->bindParam(':Taskoption', $option, PDO::PARAM_STR);
        $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
        $complete->execute();
        
   }

        $notetypedata= "Tasks $option";
        $recept="Task Updated";
        $notes="$option $VAR1 $VAR2 $VAR3 $VAR4 $VAR5 $VAR6 $VAR7";

$noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$noteinsert->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$noteinsert->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$noteinsert->bindParam(':recipientholder',$recept, PDO::PARAM_STR, 500);
$noteinsert->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$noteinsert->bindParam(':messageholder',$notes, PDO::PARAM_STR, 2500);
$noteinsert->execute();

        header('Location: ../Life/ViewClient.php?search='.$search.'&TaskSelect='.$option.'#menu4'); die;
        
    
    }


         header('Location: /CRMmain.php'); die; 
         