<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


if ($_SERVER["REQUEST_METHOD"] == "GET") {

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$FFcompleted= filter_input(INPUT_GET, 'FFcomplete', FILTER_SANITIZE_NUMBER_INT); 
}

include('../../includes/PDOcon.php');

$factfind= filter_input(INPUT_GET, 'factfind', FILTER_SANITIZE_SPECIAL_CHARS);
$page2= filter_input(INPUT_GET, 'page2', FILTER_SANITIZE_SPECIAL_CHARS);
$page3= filter_input(INPUT_GET, 'page3', FILTER_SANITIZE_SPECIAL_CHARS);
$page4= filter_input(INPUT_GET, 'page4', FILTER_SANITIZE_SPECIAL_CHARS);
$page5= filter_input(INPUT_GET, 'page5', FILTER_SANITIZE_SPECIAL_CHARS);
$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$NAMENAME= filter_input(INPUT_POST, 'NAMENAME', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($FFcompleted)) {
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    $clientn= filter_input(INPUT_GET, 'clientn', FILTER_SANITIZE_SPECIAL_CHARS);

    if($FFcompleted=='1') {

        
        $stage2 = $pdo->prepare("UPDATE pension_stages set complete='Yes', updated_by=:hello WHERE client_id=:stageid AND task='Fact Find'");
        $stage2->bindParam(':stageid',$search, PDO::PARAM_INT);
        $stage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $stage2->execute()or die(print_r($stage2->errorInfo(), true));  
        
        $notedata= "Stage 2 Fact Find";
$messagedata="Marked as complete for Stage 2";


$updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$updatenote->bindParam(':recipientholder',$clientn, PDO::PARAM_STR, 500);
$updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  

    $stage2complete = $pdo->prepare("SELECT count(complete) AS complete from pension_stages where complete='Yes' AND stage='2' and client_id=:client");
    $stage2complete->bindParam(':client',$search, PDO::PARAM_INT);
    $stage2complete->execute();
    $stage2completeresults=$stage2complete->fetch(PDO::FETCH_ASSOC);

    $stage2check=$stage2completeresults['complete'];
    
    if($stage2check >=5) {
        
        $updatestage2 = $pdo->prepare("UPDATE pension_stages set stage_complete='Y', updated_by=:hello WHERE client_id=:id AND stage='2'");
        $updatestage2->bindParam(':id',$search, PDO::PARAM_INT);
        $updatestage2->bindParam(':hello',$hello_name, PDO::PARAM_STR, 100);
        $updatestage2->execute()or die(print_r($updatestage2->errorInfo(), true));   
        
    }

        
        header('Location: ../ViewPensionClient.php?FactFindCom=Yes&search='.$search); die;
    }
    
    
}

if(isset($factfind)) {
    
    
    $name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $p1q1= filter_input(INPUT_POST, 'p1q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q2= filter_input(INPUT_POST, 'p1q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q3= filter_input(INPUT_POST, 'p1q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q4= filter_input(INPUT_POST, 'p1q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q5= filter_input(INPUT_POST, 'p1q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q6= filter_input(INPUT_POST, 'p1q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q7= filter_input(INPUT_POST, 'p1q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q8= filter_input(INPUT_POST, 'p1q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q9= filter_input(INPUT_POST, 'p1q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q10= filter_input(INPUT_POST, 'p1q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q11= filter_input(INPUT_POST, 'p1q11', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $p1q12= filter_input(INPUT_POST, 'p1q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q13= filter_input(INPUT_POST, 'p1q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q14= filter_input(INPUT_POST, 'p1q14', FILTER_SANITIZE_SPECIAL_CHARS);

    
    $p1q15= filter_input(INPUT_POST, 'p1q15', FILTER_SANITIZE_NUMBER_INT);
    $p1q16= filter_input(INPUT_POST, 'p1q16', FILTER_SANITIZE_NUMBER_INT);
    $p1q17= filter_input(INPUT_POST, 'p1q17', FILTER_SANITIZE_NUMBER_INT);
    
    $dupcheck = "Select factfind_id from factfind_page1 where client_id='$search'";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['factfind_id'];  
    }
        echo "UPDATE <br>dupe $dupeclientid<br>$search - $name <br>$p1q1 - $p1q2 - $p1q3 - $p1q4 - $p1q5 - $p1q6 - $p1q7 - $p1q8 - $p1q9 - $p1q10 - $p1q11 -$p1q12 - $p1q13 - $p1q14 -$p1q15 - $p1q16 - $p1q17";

    $query = $pdo->prepare("UPDATE factfind_page1 set client_name=:name, p1q1=:p1q1, p1q2=:p1q2, p1q3=:p1q3, p1q4=:p1q4, p1q5=:p1q5, p1q6=:p1q6, p1q7=:p1q7, p1q8=:p1q8, p1q9=:p1q9, p1q10=:p1q10, p1q11=:p1q11, p1q12=:p1q12, p1q13=:p1q13, p1q14=:p1q14, p1q15=:p1q15, p1q16=:p1q16, p1q17=:p1q17 WHERE factfind_id=:dupe");

    $query->bindParam(':dupe', $dupeclientid, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q2', $p1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q3', $p1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q4', $p1q4, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q5', $p1q5, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q6', $p1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q7', $p1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q8', $p1q8, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q9', $p1q9, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q10', $p1q10, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q11', $p1q11, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q12', $p1q12, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q13', $p1q13, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q14', $p1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q15', $p1q15, PDO::PARAM_INT);
    $query->bindParam(':p1q16', $p1q16, PDO::PARAM_INT);
    $query->bindParam(':p1q17', $p1q17, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    
    $last_id = $pdo->lastInsertId();

$notedata= "Stage 2 Fact Find";
$messagedata="Page 1 Updated";


$updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$updatenote->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
$updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  
    
    
    header('Location: ../AddFactFind.php?FactFind=updatedd&search='.$search); die;
}
    

    echo "$search - $name <br>$p1q1 - $p1q2 - $p1q3 - $p1q4 - $p1q5 - $p1q6 - $p1q7 - $p1q8 - $p1q9 - $p1q10 - $p1q11 -$p1q12 - $p1q13 - $p1q14 -$p1q15 - $p1q16 - $p1q17";
    
    $query = $pdo->prepare("INSERT INTO factfind_page1 set client_id=:clientid, client_name=:name, p1q1=:p1q1, p1q2=:p1q2, p1q3=:p1q3, p1q4=:p1q4, p1q5=:p1q5, p1q6=:p1q6, p1q7=:p1q7, p1q8=:p1q8, p1q9=:p1q9, p1q10=:p1q10, p1q11=:p1q11, p1q12=:p1q12, p1q13=:p1q13, p1q14=:p1q14, p1q15=:p1q15, p1q16=:p1q16, p1q17=:p1q17");

    $query->bindParam(':clientid', $search, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q2', $p1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q3', $p1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q4', $p1q4, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q5', $p1q5, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q6', $p1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q7', $p1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q8', $p1q8, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q9', $p1q9, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q10', $p1q10, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q11', $p1q11, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q12', $p1q12, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q13', $p1q13, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q14', $p1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q15', $p1q15, PDO::PARAM_INT);
    $query->bindParam(':p1q16', $p1q16, PDO::PARAM_INT);
    $query->bindParam(':p1q17', $p1q17, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    
    $notedata= "Stage 2 Fact Find";
    $messagedata="Page 1 Added";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$name, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=y&search='.$search); die;
    
}

if(isset($page2)) {
    
    $p2q1= filter_input(INPUT_POST, 'p2q1', FILTER_SANITIZE_NUMBER_INT);
    $p2q2= filter_input(INPUT_POST, 'p2q2', FILTER_SANITIZE_NUMBER_INT);
    $p2q3= filter_input(INPUT_POST, 'p2q3', FILTER_SANITIZE_NUMBER_INT);
    $p2q4= filter_input(INPUT_POST, 'p2q4', FILTER_SANITIZE_NUMBER_INT);
    $p2q5= filter_input(INPUT_POST, 'p2q5', FILTER_SANITIZE_NUMBER_INT);
    $p2q6= filter_input(INPUT_POST, 'p2q6', FILTER_SANITIZE_NUMBER_INT);
    $p2q7= filter_input(INPUT_POST, 'p2q7', FILTER_SANITIZE_NUMBER_INT);
    $p2q8= filter_input(INPUT_POST, 'p2q8', FILTER_SANITIZE_NUMBER_INT);
    $p2q9= filter_input(INPUT_POST, 'p2q9', FILTER_SANITIZE_NUMBER_INT);
    $p2q10= filter_input(INPUT_POST, 'p2q10', FILTER_SANITIZE_NUMBER_INT);
    $p2q11= filter_input(INPUT_POST, 'p2q11', FILTER_SANITIZE_NUMBER_INT);
    $p2q12= filter_input(INPUT_POST, 'p2q12', FILTER_SANITIZE_NUMBER_INT);
    $p2q13= filter_input(INPUT_POST, 'p2q13', FILTER_SANITIZE_NUMBER_INT);
    $p2q14= filter_input(INPUT_POST, 'p2q14', FILTER_SANITIZE_NUMBER_INT);
    $p2q15= filter_input(INPUT_POST, 'p2q15', FILTER_SANITIZE_NUMBER_INT);
    $p2q16= filter_input(INPUT_POST, 'p2q16', FILTER_SANITIZE_NUMBER_INT);
    $p2q17= filter_input(INPUT_POST, 'p2q17', FILTER_SANITIZE_NUMBER_INT);
    
    $p2q18= filter_input(INPUT_POST, 'p2q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q19= filter_input(INPUT_POST, 'p2q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20= filter_input(INPUT_POST, 'p2q20', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q21= filter_input(INPUT_POST, 'p2q21', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22= filter_input(INPUT_POST, 'p2q22', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q23= filter_input(INPUT_POST, 'p2q23', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q24= filter_input(INPUT_POST, 'p2q24', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q25= filter_input(INPUT_POST, 'p2q25', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q26= filter_input(INPUT_POST, 'p2q26', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q27= filter_input(INPUT_POST, 'p2q27', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q28= filter_input(INPUT_POST, 'p2q28', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q29= filter_input(INPUT_POST, 'p2q29', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $factfind_id= filter_input(INPUT_POST, 'factfindid', FILTER_SANITIZE_SPECIAL_CHARS);
    
$dupcheck2 = "Select factfind_id from factfind_page2 where factfind_id='$factfind_id'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['factfind_id'];  
    }
    
        $query = $pdo->prepare("UPDATE factfind_page2 set p2q1=:p2q1, p2q2=:p2q2, p2q3=:p2q3, p2q4=:p2q4, p2q5=:p2q5, p2q6=:p2q6, p2q7=:p2q7, p2q8=:p2q8, p2q9=:p2q9, p2q10=:p2q10, p2q11=:p2q11, p2q12=:p2q12, p2q13=:p2q13, p2q14=:p2q14, p2q15=:p2q15, p2q16=:p2q16, p2q17=:p2q17, p2q18=:p2q18, p2q19=:p2q19, p2q20=:p2q20, p2q21=:p2q21, p2q22=:p2q22, p2q23=:p2q23, p2q24=:p2q24, p2q25=:p2q25, p2q26=:p2q26, p2q27=:p2q27, p2q28=:p2q28, p2q29=:p2q29 WHERE factfind_id=:factfindid");

    $query->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
   
    $query->bindParam(':p2q1', $p2q1, PDO::PARAM_INT);
    $query->bindParam(':p2q2', $p2q2, PDO::PARAM_INT);
    $query->bindParam(':p2q3', $p2q3, PDO::PARAM_INT);
    $query->bindParam(':p2q4', $p2q4, PDO::PARAM_INT);
    $query->bindParam(':p2q5', $p2q5, PDO::PARAM_INT);
    $query->bindParam(':p2q6', $p2q6, PDO::PARAM_INT);
    $query->bindParam(':p2q7', $p2q7, PDO::PARAM_INT);
    $query->bindParam(':p2q8', $p2q8, PDO::PARAM_INT);
    $query->bindParam(':p2q9', $p2q9, PDO::PARAM_INT);
    $query->bindParam(':p2q10', $p2q10, PDO::PARAM_INT);
    $query->bindParam(':p2q11', $p2q11, PDO::PARAM_INT);
    $query->bindParam(':p2q12', $p2q12, PDO::PARAM_INT);
    $query->bindParam(':p2q13', $p2q13, PDO::PARAM_INT);
    $query->bindParam(':p2q14', $p2q14, PDO::PARAM_INT);
    $query->bindParam(':p2q15', $p2q15, PDO::PARAM_INT);
    $query->bindParam(':p2q16', $p2q16, PDO::PARAM_INT);
    $query->bindParam(':p2q17', $p2q17, PDO::PARAM_INT);
    $query->bindParam(':p2q18', $p2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q19', $p2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20', $p2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q21', $p2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22', $p2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q23', $p2q23, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q24', $p2q24, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q25', $p2q25, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q26', $p2q26, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q27', $p2q27, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q28', $p2q28, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q29', $p2q29, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $notedata= "Stage 2 Fact Find";
$messagedata="Page 2 Updated";


$updatenote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$updatenote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$updatenote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$updatenote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$updatenote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$updatenote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$updatenote->execute()or die(print_r($updatenote->errorInfo(), true));  

    
    header('Location: ../AddFactFind.php?FactFind=updated&search='.$search); die;
    
    
    }
    
        echo "$search<br>$factfind_id<br>$p2q1 - $p2q2 - $p2q3 - $p2q4 - $p2q5 - $p2q6 - $p2q7 - $p2q8 - $p2q9 - $p2q10 - $p2q11 -$p2q12 - $p2q13 - $p2q14 -$p2q15 - $p2q16 - $p2q17 - $p2q18 - $p2q19 - $p2q20 - $p2q21 - $p2q22 - $p2q23 - $p2q24 - $p2q25 - $p2q26 - $p2q27 - $p2q28 - $p2q29";

    
    $query = $pdo->prepare("INSERT INTO factfind_page2 set factfind_id=:factfindid, p2q1=:p2q1, p2q2=:p2q2, p2q3=:p2q3, p2q4=:p2q4, p2q5=:p2q5, p2q6=:p2q6, p2q7=:p2q7, p2q8=:p2q8, p2q9=:p2q9, p2q10=:p2q10, p2q11=:p2q11, p2q12=:p2q12, p2q13=:p2q13, p2q14=:p2q14, p2q15=:p2q15, p2q16=:p2q16, p2q17=:p2q17, p2q18=:p2q18, p2q19=:p2q19, p2q20=:p2q20, p2q21=:p2q21, p2q22=:p2q22, p2q23=:p2q23, p2q24=:p2q24, p2q25=:p2q25, p2q26=:p2q26, p2q27=:p2q27, p2q28=:p2q28, p2q29=:p2q29");

    $query->bindParam(':factfindid', $factfind_id, PDO::PARAM_INT);
   
    $query->bindParam(':p2q1', $p2q1, PDO::PARAM_INT);
    $query->bindParam(':p2q2', $p2q2, PDO::PARAM_INT);
    $query->bindParam(':p2q3', $p2q3, PDO::PARAM_INT);
    $query->bindParam(':p2q4', $p2q4, PDO::PARAM_INT);
    $query->bindParam(':p2q5', $p2q5, PDO::PARAM_INT);
    $query->bindParam(':p2q6', $p2q6, PDO::PARAM_INT);
    $query->bindParam(':p2q7', $p2q7, PDO::PARAM_INT);
    $query->bindParam(':p2q8', $p2q8, PDO::PARAM_INT);
    $query->bindParam(':p2q9', $p2q9, PDO::PARAM_INT);
    $query->bindParam(':p2q10', $p2q10, PDO::PARAM_INT);
    $query->bindParam(':p2q11', $p2q11, PDO::PARAM_INT);
    $query->bindParam(':p2q12', $p2q12, PDO::PARAM_INT);
    $query->bindParam(':p2q13', $p2q13, PDO::PARAM_INT);
    $query->bindParam(':p2q14', $p2q14, PDO::PARAM_INT);
    $query->bindParam(':p2q15', $p2q15, PDO::PARAM_INT);
    $query->bindParam(':p2q16', $p2q16, PDO::PARAM_INT);
    $query->bindParam(':p2q17', $p2q17, PDO::PARAM_INT);
    
    $query->bindParam(':p2q18', $p2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q19', $p2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20', $p2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q21', $p2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22', $p2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q23', $p2q23, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q24', $p2q24, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q25', $p2q25, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q26', $p2q26, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q27', $p2q27, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q28', $p2q28, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q29', $p2q29, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
        $notedata= "Stage 2 Fact Find";
    $messagedata="Page 2 Added";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
  header('Location: ../AddFactFind.php?FactFind=y&search='.$search); die;
    
}

if(isset($page3)) {
    
    $p3q1= filter_input(INPUT_POST, 'p3q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q2= filter_input(INPUT_POST, 'p3q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q3= filter_input(INPUT_POST, 'p3q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q4= filter_input(INPUT_POST, 'p3q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q5= filter_input(INPUT_POST, 'p3q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q6= filter_input(INPUT_POST, 'p3q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q7= filter_input(INPUT_POST, 'p3q7', FILTER_SANITIZE_NUMBER_INT);
    $p3q8= filter_input(INPUT_POST, 'p3q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q9= filter_input(INPUT_POST, 'p3q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q10= filter_input(INPUT_POST, 'p3q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q11= filter_input(INPUT_POST, 'p3q11', FILTER_SANITIZE_NUMBER_INT);
    $p3q12= filter_input(INPUT_POST, 'p3q12', FILTER_SANITIZE_NUMBER_INT);
    $p3q13= filter_input(INPUT_POST, 'p3q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q14= filter_input(INPUT_POST, 'p3q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q15= filter_input(INPUT_POST, 'p3q15', FILTER_SANITIZE_NUMBER_INT);
    $p3q16= filter_input(INPUT_POST, 'p3q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q17= filter_input(INPUT_POST, 'p3q17', FILTER_SANITIZE_NUMBER_INT);
    $p3q18= filter_input(INPUT_POST, 'p3q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q19= filter_input(INPUT_POST, 'p3q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q20= filter_input(INPUT_POST, 'p3q20', FILTER_SANITIZE_NUMBER_INT);
    $p3q21= filter_input(INPUT_POST, 'p3q21', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q22= filter_input(INPUT_POST, 'p3q22', FILTER_SANITIZE_NUMBER_INT);
    $p3q23= filter_input(INPUT_POST, 'p3q23', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q24= filter_input(INPUT_POST, 'p3q24', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q25= filter_input(INPUT_POST, 'p3q25', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q26= filter_input(INPUT_POST, 'p3q26', FILTER_SANITIZE_SPECIAL_CHARS);
    $p3q27= filter_input(INPUT_POST, 'p3q27', FILTER_SANITIZE_SPECIAL_CHARS);

    
    $factfind_id2= filter_input(INPUT_POST, 'factfindid', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $dupcheck2 = "Select factfind_id from factfind_page3 where factfind_id='$factfind_id2'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['factfind_id'];  
    }
    
        $page3 = $pdo->prepare("UPDATE factfind_page3 set p3q1=:p3q1, p3q2=:p3q2, p3q3=:p3q3, p3q4=:p3q4, p3q5=:p3q5, p3q6=:p3q6, p3q7=:p3q7, p3q8=:p3q8, p3q9=:p3q9, p3q10=:p3q10, p3q11=:p3q11, p3q12=:p3q12, p3q13=:p3q13, p3q14=:p3q14, p3q15=:p3q15, p3q16=:p3q16, p3q17=:p3q17, p3q18=:p3q18, p3q19=:p3q19, p3q20=:p3q20, p3q21=:p3q21, p3q22=:p3q22, p3q23=:p3q23, p3q24=:p3q24, p3q25=:p3q25, p3q26=:p3q26, p3q27=:p3q27 WHERE factfind_id=:factfindid");

    $page3->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
    
    $page3->bindParam(':p3q1', $p3q1, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q2', $p3q2, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q3', $p3q3, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q4', $p3q4, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q5', $p3q5, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q6', $p3q6, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q7', $p3q7, PDO::PARAM_INT);
    $page3->bindParam(':p3q8', $p3q8, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q9', $p3q9, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q10', $p3q10, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q11', $p3q11, PDO::PARAM_INT);
    $page3->bindParam(':p3q12', $p3q12, PDO::PARAM_INT);
    $page3->bindParam(':p3q13', $p3q13, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q14', $p3q14, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q15', $p3q15, PDO::PARAM_INT);
    $page3->bindParam(':p3q16', $p3q16, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q17', $p3q17, PDO::PARAM_INT);
    $page3->bindParam(':p3q18', $p3q18, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q19', $p3q19, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q20', $p3q20, PDO::PARAM_INT);
    $page3->bindParam(':p3q21', $p3q21, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q22', $p3q22, PDO::PARAM_INT);
    $page3->bindParam(':p3q23', $p3q23, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q24', $p3q24, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q25', $p3q25, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q26', $p3q26, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q27', $p3q27, PDO::PARAM_STR, 300);
    $page3->execute()or die(print_r($page3->errorInfo(), true));
    
            $notedata= "Stage 3 Fact Find";
    $messagedata="Page 3 Updated";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=updated&search='.$search); die;
    
}
    
        echo "$search<br>$factfind_id2<br>1 $p3q1 - 2 $p3q2 - 3 $p3q3 - 4 $p3q4 - 5 $p3q5 - 6 $p3q6 - 7 $p3q7 - 8 $p3q8 - 9 $p3q9 - 10 $p3q10 - 11 $p3q11 - 12 $p3q12 -  13 $p3q13 - 14 $p3q14 - 15 $p3q15 - 16 $p3q16 - 17 $p3q17 - 18 $p3q18 - 19 $p3q19 - 20 $p3q20 - 21 $p3q21 - 22 $p3q22 - 23 $p3q23 - 24 $p3q24 - 25 $p3q25 - 26 $p3q26 - 27 $p3q27";

    
    $page3 = $pdo->prepare("INSERT INTO factfind_page3 set factfind_id=:factfindid, p3q1=:p3q1, p3q2=:p3q2, p3q3=:p3q3, p3q4=:p3q4, p3q5=:p3q5, p3q6=:p3q6, p3q7=:p3q7, p3q8=:p3q8, p3q9=:p3q9, p3q10=:p3q10, p3q11=:p3q11, p3q12=:p3q12, p3q13=:p3q13, p3q14=:p3q14, p3q15=:p3q15, p3q16=:p3q16, p3q17=:p3q17, p3q18=:p3q18, p3q19=:p3q19, p3q20=:p3q20, p3q21=:p3q21, p3q22=:p3q22, p3q23=:p3q23, p3q24=:p3q24, p3q25=:p3q25, p3q26=:p3q26, p3q27=:p3q27");

    $page3->bindParam(':factfindid', $factfind_id2, PDO::PARAM_INT);
    

    $page3->bindParam(':p3q1', $p3q1, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q2', $p3q2, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q3', $p3q3, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q4', $p3q4, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q5', $p3q5, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q6', $p3q6, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q7', $p3q7, PDO::PARAM_INT);
    $page3->bindParam(':p3q8', $p3q8, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q9', $p3q9, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q10', $p3q10, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q11', $p3q11, PDO::PARAM_INT);
    $page3->bindParam(':p3q12', $p3q12, PDO::PARAM_INT);
    $page3->bindParam(':p3q13', $p3q13, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q14', $p3q14, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q15', $p3q15, PDO::PARAM_INT);
    $page3->bindParam(':p3q16', $p3q16, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q17', $p3q17, PDO::PARAM_INT);
    $page3->bindParam(':p3q18', $p3q18, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q19', $p3q19, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q20', $p3q20, PDO::PARAM_INT);
    $page3->bindParam(':p3q21', $p3q21, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q22', $p3q22, PDO::PARAM_INT);
    $page3->bindParam(':p3q23', $p3q23, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q24', $p3q24, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q25', $p3q25, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q26', $p3q26, PDO::PARAM_STR, 300);
    $page3->bindParam(':p3q27', $p3q27, PDO::PARAM_STR, 300);
    $page3->execute()or die(print_r($page3->errorInfo(), true));
    
            $notedata= "Stage 3 Fact Find";
    $messagedata="Page 3 Added";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=y&search='.$search); die;
    
}

if(isset($page4)) {

    $p4q1= filter_input(INPUT_POST, 'p4q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q2= filter_input(INPUT_POST, 'p4q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q3= filter_input(INPUT_POST, 'p4q3', FILTER_SANITIZE_NUMBER_INT);
    $p4q4= filter_input(INPUT_POST, 'p4q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q5= filter_input(INPUT_POST, 'p4q5', FILTER_SANITIZE_NUMBER_INT);
    $p4q6= filter_input(INPUT_POST, 'p4q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q7= filter_input(INPUT_POST, 'p4q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q8= filter_input(INPUT_POST, 'p4q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q9= filter_input(INPUT_POST, 'p4q9', FILTER_SANITIZE_NUMBER_INT);
    $p4q10= filter_input(INPUT_POST, 'p4q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q11= filter_input(INPUT_POST, 'p4q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q12= filter_input(INPUT_POST, 'p4q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q13= filter_input(INPUT_POST, 'p4q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q14= filter_input(INPUT_POST, 'p4q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q15= filter_input(INPUT_POST, 'p4q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q16= filter_input(INPUT_POST, 'p4q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q17= filter_input(INPUT_POST, 'p4q17', FILTER_SANITIZE_SPECIAL_CHARS);
    $p4q18= filter_input(INPUT_POST, 'p4q18', FILTER_SANITIZE_SPECIAL_CHARS);


    
    $factfind_id2= filter_input(INPUT_POST, 'factfindid', FILTER_SANITIZE_SPECIAL_CHARS);
    
        $dupcheck2 = "Select factfind_id from factfind_page4 where factfind_id='$factfind_id2'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['factfind_id'];  
    }
    
        $page4 = $pdo->prepare("UPDATE factfind_page4 SET p4q1=:p4q1, p4q2=:p4q2, p4q3=:p4q3, p4q4=:p4q4, p4q5=:p4q5, p4q6=:p4q6, p4q7=:p4q7, p4q8=:p4q8, p4q9=:p4q9, p4q10=:p4q10, p4q11=:p4q11, p4q12=:p4q12, p4q13=:p4q13, p4q14=:p4q14, p4q15=:p4q15, p4q16=:p4q16, p4q17=:p4q17, p4q18=:p4q18 WHERE factfind_id=:factfindid");

    $page4->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
    $page4->bindParam(':p4q1', $p4q1, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q2', $p4q2, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q3', $p4q3, PDO::PARAM_INT);
    $page4->bindParam(':p4q4', $p4q4, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q5', $p4q5, PDO::PARAM_INT);
    $page4->bindParam(':p4q6', $p4q6, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q7', $p4q7, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q8', $p4q8, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q9', $p4q9, PDO::PARAM_INT);
    $page4->bindParam(':p4q10', $p4q10, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q11', $p4q11, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q12', $p4q12, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q13', $p4q13, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q14', $p4q14, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q15', $p4q15, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q16', $p4q16, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q17', $p4q17, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q18', $p4q18, PDO::PARAM_STR, 300);

    $page4->execute()or die(print_r($page4->errorInfo(), true));
    
            $notedata= "Stage 4 Fact Find";
    $messagedata="Page 4 Updated";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=updated&search='.$search); die;
    
}
    
        echo "$factfind_id2<br>$p4q1 - $p4q2 - $p4q3 - $p4q4 - $p4q5 - $p4q6 - $p4q7 - $p4q8 - $p4q9 - $p4q10 - $p4q11 - $p4q12 -  $p4q13 - $p4q14 - $p4q15 - $p4q16 - $p4q17 - $p4q18";

        echo "<br>$factfind_id2<br>$p4q19 - $p4q20 - $p4q21 - $p4q22 - $p4q23 - $p4q24 - $p4q25 - $p4q26 - $p4q27 - $p4q28 - $p4q29 - $p4q30 -  $p4q31 - $p4q32 - $p4q33 - $p4q34 - $p4q35 - $p4q36";
        
    
    $page4 = $pdo->prepare("INSERT INTO factfind_page4 set factfind_id=:factfindid, p4q1=:p4q1, p4q2=:p4q2, p4q3=:p4q3, p4q4=:p4q4, p4q5=:p4q5, p4q6=:p4q6, p4q7=:p4q7, p4q8=:p4q8, p4q9=:p4q9, p4q10=:p4q10, p4q11=:p4q11, p4q12=:p4q12, p4q13=:p4q13, p4q14=:p4q14, p4q15=:p4q15, p4q16=:p4q16, p4q17=:p4q17, p4q18=:p4q18");

    $page4->bindParam(':factfindid', $factfind_id2, PDO::PARAM_INT);
    

    $page4->bindParam(':p4q1', $p4q1, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q2', $p4q2, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q3', $p4q3, PDO::PARAM_INT);
    $page4->bindParam(':p4q4', $p4q4, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q5', $p4q5, PDO::PARAM_INT);
    $page4->bindParam(':p4q6', $p4q6, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q7', $p4q7, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q8', $p4q8, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q9', $p4q9, PDO::PARAM_INT);
    $page4->bindParam(':p4q10', $p4q10, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q11', $p4q11, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q12', $p4q12, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q13', $p4q13, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q14', $p4q14, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q15', $p4q15, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q16', $p4q16, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q17', $p4q17, PDO::PARAM_STR, 300);
    $page4->bindParam(':p4q18', $p4q18, PDO::PARAM_STR, 300);

    $page4->execute()or die(print_r($page4->errorInfo(), true));
    
            $notedata= "Stage 4 Fact Find";
    $messagedata="Page 4 Added";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=y&search='.$search); die;
    
}

if(isset($page5)) {

    $p5q1= filter_input(INPUT_POST, 'p5q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q2= filter_input(INPUT_POST, 'p5q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q3= filter_input(INPUT_POST, 'p5q3', FILTER_SANITIZE_NUMBER_INT);
    $p5q4= filter_input(INPUT_POST, 'p5q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q5= filter_input(INPUT_POST, 'p5q5', FILTER_SANITIZE_NUMBER_INT);
    $p5q6= filter_input(INPUT_POST, 'p5q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q7= filter_input(INPUT_POST, 'p5q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q8= filter_input(INPUT_POST, 'p5q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q9= filter_input(INPUT_POST, 'p5q9', FILTER_SANITIZE_NUMBER_INT);
    $p5q10= filter_input(INPUT_POST, 'p5q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q11= filter_input(INPUT_POST, 'p5q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q12= filter_input(INPUT_POST, 'p5q12', FILTER_SANITIZE_SPECIAL_CHARS);

    $p5q13= filter_input(INPUT_POST, 'p5q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q14= filter_input(INPUT_POST, 'p5q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q15= filter_input(INPUT_POST, 'p5q15', FILTER_SANITIZE_NUMBER_INT);
    $p5q16= filter_input(INPUT_POST, 'p5q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q17= filter_input(INPUT_POST, 'p5q17', FILTER_SANITIZE_NUMBER_INT);
    $p5q18= filter_input(INPUT_POST, 'p5q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q19= filter_input(INPUT_POST, 'p5q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q20= filter_input(INPUT_POST, 'p5q20', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q21= filter_input(INPUT_POST, 'p5q21', FILTER_SANITIZE_NUMBER_INT);
    $p5q22= filter_input(INPUT_POST, 'p5q22', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q23= filter_input(INPUT_POST, 'p5q23', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q24= filter_input(INPUT_POST, 'p5q24', FILTER_SANITIZE_SPECIAL_CHARS);

    $p5q25= filter_input(INPUT_POST, 'p5q25', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q26= filter_input(INPUT_POST, 'p5q26', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q27= filter_input(INPUT_POST, 'p5q27', FILTER_SANITIZE_NUMBER_INT);
    $p5q28= filter_input(INPUT_POST, 'p5q28', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q29= filter_input(INPUT_POST, 'p5q29', FILTER_SANITIZE_NUMBER_INT);
    $p5q30= filter_input(INPUT_POST, 'p5q30', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q31= filter_input(INPUT_POST, 'p5q31', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q32= filter_input(INPUT_POST, 'p5q32', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q33= filter_input(INPUT_POST, 'p5q33', FILTER_SANITIZE_NUMBER_INT);
    $p5q34= filter_input(INPUT_POST, 'p5q34', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q35= filter_input(INPUT_POST, 'p5q35', FILTER_SANITIZE_SPECIAL_CHARS);
    $p5q36= filter_input(INPUT_POST, 'p5q36', FILTER_SANITIZE_SPECIAL_CHARS);


    
    $factfind_id2= filter_input(INPUT_POST, 'factfindid', FILTER_SANITIZE_SPECIAL_CHARS);
    
            $dupcheck2 = "Select factfind_id from factfind_page5 where factfind_id='$factfind_id2'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['factfind_id'];  
    }
    
    $page5 = $pdo->prepare("UPDATE factfind_page5 set p5q1=:p5q1, p5q2=:p5q2, p5q3=:p5q3, p5q4=:p5q4, p5q5=:p5q5, p5q6=:p5q6, p5q7=:p5q7, p5q8=:p5q8, p5q9=:p5q9, p5q10=:p5q10, p5q11=:p5q11, p5q12=:p5q12, p5q13=:p5q13, p5q14=:p5q14, p5q15=:p5q15, p5q16=:p5q16, p5q17=:p5q17, p5q18=:p5q18, p5q19=:p5q19, p5q20=:p5q20, p5q21=:p5q21, p5q22=:p5q22, p5q23=:p5q23, p5q24=:p5q24, p5q25=:p5q25, p5q26=:p5q26, p5q27=:p5q27, p5q28=:p5q28, p5q29=:p5q29, p5q30=:p5q30, p5q31=:p5q31, p5q32=:p5q32, p5q33=:p5q33, p5q34=:p5q34, p5q35=:p5q35, p5q36=:p5q36 WHERE factfind_id=:factfindid");

    
    $page5->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
    $page5->bindParam(':p5q1', $p5q1, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q2', $p5q2, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q3', $p5q3, PDO::PARAM_INT);
    $page5->bindParam(':p5q4', $p5q4, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q5', $p5q5, PDO::PARAM_INT);
    $page5->bindParam(':p5q6', $p5q6, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q7', $p5q7, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q8', $p5q8, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q9', $p5q9, PDO::PARAM_INT);
    $page5->bindParam(':p5q10', $p5q10, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q11', $p5q11, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q12', $p5q12, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q13', $p5q13, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q14', $p5q14, PDO::PARAM_STR, 300); 
    $page5->bindParam(':p5q15', $p5q15, PDO::PARAM_INT);
    $page5->bindParam(':p5q16', $p5q16, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q17', $p5q17, PDO::PARAM_INT);
    $page5->bindParam(':p5q18', $p5q18, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q19', $p5q19, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q20', $p5q20, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q21', $p5q21, PDO::PARAM_INT);
    $page5->bindParam(':p5q22', $p5q22, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q23', $p5q23, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q24', $p5q24, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q25', $p5q25, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q26', $p5q26, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q27', $p5q27, PDO::PARAM_INT);
    $page5->bindParam(':p5q28', $p5q28, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q29', $p5q29, PDO::PARAM_INT);
    $page5->bindParam(':p5q30', $p5q30, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q31', $p5q31, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q32', $p5q32, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q33', $p5q33, PDO::PARAM_INT);
    $page5->bindParam(':p5q34', $p5q34, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q35', $p5q35, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q36', $p5q36, PDO::PARAM_STR, 300);
    $page5->execute()or die(print_r($page5->errorInfo(), true));
    
            $notedata= "Stage 5 Fact Find";
    $messagedata="Page 5 Updated";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=updated&search='.$search); die;
    
}
    
    
        echo "$factfind_id2<br>$p5q1 - $p5q2 - $p5q3 - $p5q4 - $p5q5 - $p5q6 - $p5q7 - $p5q8 - $p5q9 - $p5q10 - $p5q11 - $p5q12";

        echo "<br>$p5q13 - $p5q14 - $p5q15 - $p5q16 - $p5q17 - $p5q18 - $p5q19 - $p5q20 - $p5q21 - $p5q22 - $p5q23 - $p5q24";

        echo "<br>$p5q25 - $p5q26 - $p5q27 - $p5q28 - $p5q29 - $p5q30 -  $p5q31 - $p5q32 - $p5q33 - $p5q34 - $p5q35 - $p5q36";
    
    $page5 = $pdo->prepare("INSERT INTO factfind_page5 set factfind_id=:factfindid, p5q1=:p5q1, p5q2=:p5q2, p5q3=:p5q3, p5q4=:p5q4, p5q5=:p5q5, p5q6=:p5q6, p5q7=:p5q7, p5q8=:p5q8, p5q9=:p5q9, p5q10=:p5q10, p5q11=:p5q11, p5q12=:p5q12, p5q13=:p5q13, p5q14=:p5q14, p5q15=:p5q15, p5q16=:p5q16, p5q17=:p5q17, p5q18=:p5q18, p5q19=:p5q19, p5q20=:p5q20, p5q21=:p5q21, p5q22=:p5q22, p5q23=:p5q23, p5q24=:p5q24, p5q25=:p5q25, p5q26=:p5q26, p5q27=:p5q27, p5q28=:p5q28, p5q29=:p5q29, p5q30=:p5q30, p5q31=:p5q31, p5q32=:p5q32, p5q33=:p5q33, p5q34=:p5q34, p5q35=:p5q35, p5q36=:p5q36");

    
    $page5->bindParam(':factfindid', $factfind_id2, PDO::PARAM_INT);
    

    $page5->bindParam(':p5q1', $p5q1, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q2', $p5q2, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q3', $p5q3, PDO::PARAM_INT);
    $page5->bindParam(':p5q4', $p5q4, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q5', $p5q5, PDO::PARAM_INT);
    $page5->bindParam(':p5q6', $p5q6, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q7', $p5q7, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q8', $p5q8, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q9', $p5q9, PDO::PARAM_INT);
    $page5->bindParam(':p5q10', $p5q10, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q11', $p5q11, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q12', $p5q12, PDO::PARAM_STR, 300);
    
    $page5->bindParam(':p5q13', $p5q13, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q14', $p5q14, PDO::PARAM_STR, 300); 
    $page5->bindParam(':p5q15', $p5q15, PDO::PARAM_INT);
    $page5->bindParam(':p5q16', $p5q16, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q17', $p5q17, PDO::PARAM_INT);
    $page5->bindParam(':p5q18', $p5q18, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q19', $p5q19, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q20', $p5q20, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q21', $p5q21, PDO::PARAM_INT);
    $page5->bindParam(':p5q22', $p5q22, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q23', $p5q23, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q24', $p5q24, PDO::PARAM_STR, 300);
    
    $page5->bindParam(':p5q25', $p5q25, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q26', $p5q26, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q27', $p5q27, PDO::PARAM_INT);
    $page5->bindParam(':p5q28', $p5q28, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q29', $p5q29, PDO::PARAM_INT);
    $page5->bindParam(':p5q30', $p5q30, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q31', $p5q31, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q32', $p5q32, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q33', $p5q33, PDO::PARAM_INT);
    $page5->bindParam(':p5q34', $p5q34, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q35', $p5q35, PDO::PARAM_STR, 300);
    $page5->bindParam(':p5q36', $p5q36, PDO::PARAM_STR, 300);

    $page5->execute()or die(print_r($page5->errorInfo(), true));
    
            $notedata= "Stage 5 Fact Find";
    $messagedata="Page 5 Added";


$INSERTnote = $pdo->prepare("INSERT INTO pension_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$INSERTnote->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$INSERTnote->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERTnote->bindParam(':recipientholder',$NAMENAME, PDO::PARAM_STR, 500);
$INSERTnote->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$INSERTnote->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$INSERTnote->execute()or die(print_r($INSERTnote->errorInfo(), true));  
    
    header('Location: ../AddFactFind.php?FactFind=y&search='.$search); die;
    
}

?>