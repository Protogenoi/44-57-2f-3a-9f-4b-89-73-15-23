<?php 

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
    
    
$Stage= filter_input(INPUT_GET, 'Stage', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$Task= filter_input(INPUT_GET, 'Task', FILTER_SANITIZE_SPECIAL_CHARS);
    
if(isset($Stage)) {
    
    include('../../includes/PDOcon.php');
    include('../../includes/uploaddb.php');
    
    if($Stage=='3') {
        
    $loain= filter_input(INPUT_POST, 'loain', FILTER_SANITIZE_SPECIAL_CHARS);   
    
    
      if($Task=='Received LOA') {
          
        $file = $search."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $folder="../../uploads/";
        
        $uploadtype="Stage 3 Confirmation of docs received";
        $new_size = $file_size/1024;  
        $new_file_name = strtolower($file);
        $final_file=str_replace("'","",$new_file_name);
        
        if(move_uploaded_file($file_loc,$folder.$final_file)) {
            
            $sql="INSERT INTO tbl_uploads(file,type,size, uploadtype) VALUES('$final_file','$file_type','$new_size', '$uploadtype')";
            
        }
        
        mysqli_query($GLOBALS["___mysqli_ston"], $sql);  
        
        $ref= "Upload"; 
        
        $query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':recipientholder',$ref, PDO::PARAM_STR, 500);
        $query->bindParam(':noteholder',$uploadtype, PDO::PARAM_STR, 255);
        $query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
        $query->execute();
        
        $stage3 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE client_id=:id AND task='Confirmation of docs received'");
        $stage3->bindParam(':id',$search, PDO::PARAM_INT);
        $stage3->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $stage3->execute()or die(print_r($stage3->errorInfo(), true)); 
        
        $notedata= "Stage 3 Confirmation of docs received";
        $messagedata="Marked as complete";
        
        $updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $updatenote->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
        $updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
        $updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  
        
    $stage3complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='3' and client_id=:client");
    $stage3complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage3complete->execute();
    $stage3completeresults=$stage3complete->fetch(PDO::FETCH_ASSOC);

    $stage3check=$stage3completeresults['complete'];
    
    if($stage3check >=2) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='3'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }
        
        header('Location: ../ViewPensionClient.php?StageDone=3&ResultDone=Stage 3 Confirmation of docs received as complete&search='.$search); die;
        
    
    }
        
if($loain=='Yes') {

    
        $stage3 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE client_id=:id AND task='Chase LOA'");
        $stage3->bindParam(':id',$search, PDO::PARAM_INT);
        $stage3->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $stage3->execute()or die(print_r($stage3->errorInfo(), true)); 
        
        $notedata= "Stage 3 Chase LOA";
        $messagedata="Marked as complete";
        
        $updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $updatenote->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
        $updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
        $updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  
        
    $stage3complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='3' and client_id=:client");
    $stage3complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage3complete->execute();
    $stage3completeresults=$stage3complete->fetch(PDO::FETCH_ASSOC);

    $stage3check=$stage3completeresults['complete'];
    
    if($stage3check >=2) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='3'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }
        
        header('Location: ../ViewPensionClient.php?StageDone=3&ResultDone=Stage 3 Chase LOA marked as complete&search='.$search); die;
    
    }
    
    
    
  if($loain=='No') {
      
        $stage3 = $pdo->prepare("UPDATE pension_stages set complete='No', stage_complete='N', updated_by=:hello WHERE client_id=:stageid AND task='Chase LOA'");
        $stage3->bindParam(':stageid',$search, PDO::PARAM_INT);
        $stage3->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $stage3->execute()or die(print_r($stage1->errorInfo(), true)); 
        
        $notedata= "Stage 3 Chase LOA";
        $messagedata="Marked as Incomplete";
        
        $updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
        $updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
        $updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
        $updatenote->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
        $updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
        $updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
        $updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  
        
    $stage3complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='No' AND stage='3' and client_id=:client");
    $stage3complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage3complete->execute();
    $stage3completeresults=$stage3complete->fetch(PDO::FETCH_ASSOC);

    $stage3check=$stage3completeresults['complete'];
    
    if($stage3check >=2) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='N', updated_by=:hello WHERE client_id=:id AND stage='3'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }
        
    header('Location: ../ViewPensionClient.php?StageDone=3&ResultDone=Stage 3 Chase LOA marked as incomplete&search='.$search); die;
      
      
      
  }  
  
  header('Location: ../ViewPensionClient.php?StageDone=3&ResultDone=No changes were made&search='.$search); die;
    }     
}
    
    
    
    
header('Location: ../../CRMmain.php'); die;
    
    
    
    
    
?>