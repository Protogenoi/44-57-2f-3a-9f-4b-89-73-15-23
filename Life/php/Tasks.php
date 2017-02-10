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
   
include('../../includes/ADL_PDO_CON.php');

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
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $SELECTquery = $pdo->prepare("SELECT Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks WHERE client_id=:cid");
    $SELECTquery->bindParam(':cid', $search, PDO::PARAM_INT); 
    $SELECTquery->execute();
    $result=$SELECTquery->fetch(PDO::FETCH_ASSOC);
    
    $VAR1=$result['Upsells'];
    $VAR2=$result['PitchTrust'];
    $VAR3=$result['PitchTPS'];
    $VAR4=$result['RemindDD'];
    $VAR5=$result['CYDReturned'];
    $VAR6=$result['DocsArrived'];
    $VAR7=$result['HappyPol'];
    
    $ORIGVAR1=$result['Upsells'];
    $ORIGVAR2=$result['PitchTrust'];
    $ORIGVAR3=$result['PitchTPS'];
    $ORIGVAR4=$result['RemindDD'];
    $ORIGVAR5=$result['CYDReturned'];
    $ORIGVAR6=$result['DocsArrived'];
    $ORIGVAR7=$result['HappyPol'];
    
    
    if($VAR1 != $Upsells) {
        
        $VAR1="| Upsells - $Upsells |";
        
    }
    
    else {
        
        unset($VAR1);
        
    }
    
        if($VAR2 != $PitchTrust) {
            
            $VAR2="|Pitch Trust - $PitchTrust |";
        
    }
    
    else {
        
        unset($VAR2);
        
    }
    
        if($VAR3 != $PitchTPS) {
            
            $VAR3="| Pitch TPS - $PitchTPS |";
        
    }
    
        else {
        
        unset($VAR3);
        
    }
    
        if($VAR4 != $RemindDD) {
            
            $VAR4="| Remind/Cancel Old/New DD - $RemindDD |";
        
    }
    
        else {
        
        unset($VAR4);
        
    }
    
        if($VAR5 != $CYDReturned) {
            $VAR5="| CYD Returned? - $CYDReturned |";
            $CYDnotes=$VAR5;
            
        }
        else {
            unset($VAR5);            
            $CYDnotes="No changes";
            
        }
    
    
        if($VAR6 != $DocsArrived) {
            
            $VAR6="| Docs Emailed? - $DocsArrived |";
        
    }
    
        else {
        
        unset($VAR6);
        
    }
    
        if($VAR7 != $HappyPol) {
            
            $VAR7= "| Happy with Policy - $HappyPol |";
        
    }
    
        else {
        
        unset($VAR7);
        
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
        
    if($option=='24 48') {
    
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task IN('5 day','24 48','CYD')");
        $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
        $complete->execute();           
    }    
    
        if($option =='5 day') {
    
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task IN('5 day','24 48','CYD')");
        $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
        $complete->execute();    
        
    } 
        
   if($option !='5 day' || $option !='24 48') { 
        
        $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task=:Taskoption");        
        $complete->bindParam(':Taskoption', $option, PDO::PARAM_STR);
        $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
        $complete->execute();
        
   }
   
   if($CYDReturned=='Yes complete with Legal and General' || $CYDReturned=='Yes Legal and General not received' || $CYDReturned=='No') {
   
       $complete = $pdo->prepare("UPDATE Client_Tasks set complete='1' WHERE client_id=:cid AND Task='CYD'");
       $complete->bindParam(':cid', $search, PDO::PARAM_INT); 
       $complete->execute(); 
       
       if($CYDnotes!="No changes") {
       
        $notetypedata= "Task CYD";
        $recept="Task Updated";
                
        $noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:hello_name, note_type=:noteholder, message=:messageholder ");
        $noteinsert->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $noteinsert->bindParam(':hello_name',$hello_name, PDO::PARAM_STR, 100);
        $noteinsert->bindParam(':recipientholder',$recept, PDO::PARAM_STR, 500);
        $noteinsert->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
        $noteinsert->bindParam(':messageholder',$CYDnotes, PDO::PARAM_STR, 2500);
        $noteinsert->execute();
        
   }
   
   }
        $notetypedata= "Task $option";
        $recept="Task Updated";
  
        
            if($ORIGVAR1 ==$Upsells && $ORIGVAR2 ==$PitchTrust && $ORIGVAR3 ==$PitchTPS && $ORIGVAR4 ==$RemindDD && $ORIGVAR5 ==$CYDReturned && $ORIGVAR6 ==$DocsArrived && $ORIGVAR7 ==$HappyPol) {
        
        $notes="No changes";
    }
    
    else {
        
        $notes="$VAR1 $VAR2 $VAR3 $VAR4 $VAR5 $VAR6 $VAR7";
        
    }
    
$noteinsert = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:hello_name, note_type=:noteholder, message=:messageholder ");
$noteinsert->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$noteinsert->bindParam(':hello_name',$hello_name, PDO::PARAM_STR, 100);
$noteinsert->bindParam(':recipientholder',$recept, PDO::PARAM_STR, 500);
$noteinsert->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$noteinsert->bindParam(':messageholder',$notes, PDO::PARAM_STR, 2500);
$noteinsert->execute();


      header('Location: ../Reports/Tasks.php?REF='.$search.'&TaskSelect='.$option); die;  
  
        
    
    }


         #header('Location: ../CRMmain.php'); die; 
         