<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/PDOcon.php');

          $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
          $page= filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
          $origid_id= filter_input(INPUT_POST, 'origid', FILTER_SANITIZE_SPECIAL_CHARS);

          if(isset($page)) {
              
              if($page=='1') {
    $name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);              
    $p1q1= filter_input(INPUT_POST, 'p1q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q2= filter_input(INPUT_POST, 'p1q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q3= filter_input(INPUT_POST, 'p1q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q4= filter_input(INPUT_POST, 'p1q4', FILTER_SANITIZE_NUMBER_INT);
    $p1q5= filter_input(INPUT_POST, 'p1q5', FILTER_SANITIZE_NUMBER_INT);
    $p1q6= filter_input(INPUT_POST, 'p1q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q6a= filter_input(INPUT_POST, 'p1q6a', FILTER_SANITIZE_NUMBER_INT);
    $p1q7= filter_input(INPUT_POST, 'p1q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q8= filter_input(INPUT_POST, 'p1q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q9= filter_input(INPUT_POST, 'p1q9', FILTER_SANITIZE_NUMBER_INT);
    $p1q10= filter_input(INPUT_POST, 'p1q10', FILTER_SANITIZE_NUMBER_INT);
    $p1q11= filter_input(INPUT_POST, 'p1q11', FILTER_SANITIZE_NUMBER_INT);
    $p1q12= filter_input(INPUT_POST, 'p1q12', FILTER_SANITIZE_NUMBER_INT);
    $p1q13= filter_input(INPUT_POST, 'p1q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q14= filter_input(INPUT_POST, 'p1q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q15= filter_input(INPUT_POST, 'p1q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $p1q16= filter_input(INPUT_POST, 'p1q16', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $dupcheck = "Select clsr_page1_id from client_summary_report_page1 where client_id ='$search'";
    $duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['clsr_page1_id'];  
    }
        echo "UPDATE <br>dupe $dupeclientid<br>$search - $name <br>$p1q1 - $p1q2 - $p1q3 - $p1q4 - $p1q5 - $p1q6 - $p1q6a - $p1q7 - $p1q8 - $p1q9 - $p1q10 - $p1q11 -$p1q12 - $p1q13 - $p1q14 - $p1q15 - $p1q16";

    $query = $pdo->prepare("UPDATE client_summary_report_page1 set client_name=:name, p1q1=:p1q1, p1q2=:p1q2, p1q3=:p1q3, p1q4=:p1q4, p1q5=:p1q5, p1q6=:p1q6, p1q6a=:p1q6a, p1q7=:p1q7, p1q8=:p1q8, p1q9=:p1q9, p1q10=:p1q10, p1q11=:p1q11, p1q12=:p1q12, p1q13=:p1q13, p1q14=:p1q14, p1q15=:p1q15, p1q16=:p1q16 WHERE clsr_page1_id=:dupe");

    $query->bindParam(':dupe', $dupeclientid, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q2', $p1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q3', $p1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q4', $p1q4, PDO::PARAM_INT);
    $query->bindParam(':p1q5', $p1q5, PDO::PARAM_INT);
    $query->bindParam(':p1q6', $p1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q6a', $p1q6a, PDO::PARAM_INT);
    $query->bindParam(':p1q7', $p1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q8', $p1q8, PDO::PARAM_STR, 600);
    $query->bindParam(':p1q9', $p1q9, PDO::PARAM_INT);
    $query->bindParam(':p1q10', $p1q10, PDO::PARAM_INT);
    $query->bindParam(':p1q11', $p1q11, PDO::PARAM_INT);
    $query->bindParam(':p1q12', $p1q12, PDO::PARAM_INT);
    $query->bindParam(':p1q13', $p1q13, PDO::PARAM_STR, 600);
    $query->bindParam(':p1q14', $p1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q15', $p1q15, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q16', $p1q16, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
$clientnamedata= "Stage 5";
$uploadtype="Summary Report Updated";
$final_file="Page 1";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

              

    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=updated&search='.$search); die;  
}

    echo "$search - $name <br>$p1q1 - $p1q2 - $p1q3 - $p1q4 - $p1q5 - $p1q6 - $p1q6a - $p1q7 - $p1q8 - $p1q9 - $p1q10 - $p1q11 -$p1q12 - $p1q13 - $p1q14 - $p1q15 - $p1q16";
    
    $query = $pdo->prepare("INSERT INTO client_summary_report_page1 set client_id=:clientid, client_name=:name, p1q1=:p1q1, p1q2=:p1q2, p1q3=:p1q3, p1q4=:p1q4, p1q5=:p1q5, p1q6=:p1q6, p1q6a=:p1q6a, p1q7=:p1q7, p1q8=:p1q8, p1q9=:p1q9, p1q10=:p1q10, p1q11=:p1q11, p1q12=:p1q12, p1q13=:p1q13, p1q14=:p1q14, p1q15=:p1q15, p1q16=:p1q16");

    $query->bindParam(':clientid', $search, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q1', $p1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q2', $p1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q3', $p1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q4', $p1q4, PDO::PARAM_INT);
    $query->bindParam(':p1q5', $p1q5, PDO::PARAM_INT);
    $query->bindParam(':p1q6', $p1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q6a', $p1q6a, PDO::PARAM_INT);
    $query->bindParam(':p1q7', $p1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q8', $p1q8, PDO::PARAM_STR, 600);
    $query->bindParam(':p1q9', $p1q9, PDO::PARAM_INT);
    $query->bindParam(':p1q10', $p1q10, PDO::PARAM_INT);
    $query->bindParam(':p1q11', $p1q11, PDO::PARAM_INT);
    $query->bindParam(':p1q12', $p1q12, PDO::PARAM_INT);
    $query->bindParam(':p1q13', $p1q13, PDO::PARAM_STR, 600);
    $query->bindParam(':p1q14', $p1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q15', $p1q15, PDO::PARAM_STR, 300);
    $query->bindParam(':p1q16', $p1q16, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
$clientnamedata= "Stage 5";
$uploadtype="Summary Report Added";
$final_file="Page 1";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=y&search='.$search); die;
                  
              }
              
              if($page=='2') {
                  
                  
    $p2q1= filter_input(INPUT_POST, 'p2q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q2= filter_input(INPUT_POST, 'p2q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q3= filter_input(INPUT_POST, 'p2q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q4= filter_input(INPUT_POST, 'p2q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q5= filter_input(INPUT_POST, 'p2q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q6= filter_input(INPUT_POST, 'p2q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q7= filter_input(INPUT_POST, 'p2q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q8= filter_input(INPUT_POST, 'p2q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q9= filter_input(INPUT_POST, 'p2q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q10= filter_input(INPUT_POST, 'p2q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q11= filter_input(INPUT_POST, 'p2q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q12= filter_input(INPUT_POST, 'p2q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q13= filter_input(INPUT_POST, 'p2q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q13b= filter_input(INPUT_POST, 'p2q13b', FILTER_SANITIZE_NUMBER_INT);
    $p2q14= filter_input(INPUT_POST, 'p2q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q15= filter_input(INPUT_POST, 'p2q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q16= filter_input(INPUT_POST, 'p2q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q17= filter_input(INPUT_POST, 'p2q17', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q18= filter_input(INPUT_POST, 'p2q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q19= filter_input(INPUT_POST, 'p2q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20= filter_input(INPUT_POST, 'p2q20', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20a= filter_input(INPUT_POST, 'p2q20a', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20b= filter_input(INPUT_POST, 'p2q20b', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20c= filter_input(INPUT_POST, 'p2q20c', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q20d= filter_input(INPUT_POST, 'p2q20d', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q21= filter_input(INPUT_POST, 'p2q21', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22= filter_input(INPUT_POST, 'p2q22', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22a= filter_input(INPUT_POST, 'p2q22a', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22b= filter_input(INPUT_POST, 'p2q22b', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22c= filter_input(INPUT_POST, 'p2q22c', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22d= filter_input(INPUT_POST, 'p2q22d', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22e= filter_input(INPUT_POST, 'p2q22e', FILTER_SANITIZE_SPECIAL_CHARS);
    $p2q22f= filter_input(INPUT_POST, 'p2q22f', FILTER_SANITIZE_SPECIAL_CHARS);

    
    
    
$dupcheck2 = "Select clsr_page1_id from client_summary_report_page2 where clsr_page1_id ='$origid_id'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['clsr_page1_id'];  
    }
    
    $query = $pdo->prepare("UPDATE client_summary_report_page2 set p2q1=:p2q1, p2q2=:p2q2, p2q3=:p2q3, p2q4=:p2q4, p2q5=:p2q5, p2q6=:p2q6, p2q7=:p2q7, p2q8=:p2q8, p2q9=:p2q9, p2q10=:p2q10, p2q11=:p2q11, p2q12=:p2q12, p2q13=:p2q13, p2q13b=:p2q13b, p2q14=:p2q14, p2q15=:p2q15, p2q16=:p2q16, p2q17=:p2q17, p2q18=:p2q18, p2q19=:p2q19, p2q20=:p2q20, p2q20a=:p2q20a, p2q20b=:p2q20b, p2q20c=:p2q20c, p2q20d=:p2q20d, p2q21=:p2q21, p2q22=:p2q22, p2q22a=:p2q22a, p2q22b=:p2q22b, p2q22c=:p2q22c, p2q22d=:p2q22d, p2q22e=:p2q22e, p2q22f=:p2q22f WHERE clsr_page1_id=:factfindid");

    $query->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
   
    $query->bindParam(':p2q1', $p2q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q2', $p2q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q3', $p2q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q4', $p2q4, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q5', $p2q5, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q6', $p2q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q7', $p2q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q8', $p2q8, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q9', $p2q9, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q10', $p2q10, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q11', $p2q11, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q12', $p2q12, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q13', $p2q13, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q13b', $p2q13b, PDO::PARAM_INT);
    $query->bindParam(':p2q14', $p2q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q15', $p2q15, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q16', $p2q16, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q17', $p2q17, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q18', $p2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q19', $p2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20', $p2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20a', $p2q20a, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20b', $p2q20b, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20c', $p2q20c, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20d', $p2q20d, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q21', $p2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22', $p2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22a', $p2q22a, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22b', $p2q22b, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22c', $p2q22c, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22d', $p2q22d, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22e', $p2q22e, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22f', $p2q22f, PDO::PARAM_STR, 300);

    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $clientnamedata= "Stage 5";
$uploadtype="Summary Report Updated";
$final_file="Page 2";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=updated&search='.$search); die;
    
    
    }
    
        echo "$search<br>$origid_id<br>$p2q1 - $p2q2 - $p2q3 - $p2q4 - $p2q5 - $p2q6 - $p2q7 - $p2q8 - $p2q9 - $p2q10 - $p2q11 -$p2q12 - $p2q13 - $p2q14 -$p2q15 - $p2q16 - $p2q17 - $p2q18 - $p2q19 - $p2q20 - $p2q20a - $p2q20b - $p2q20c - $p2q20d - $p2q21 - $p2q22 - $p2q22a- $p2q22b - $p2q22c - $p2q22d - $p2q22e - $p2q22f";

    
    $query = $pdo->prepare("INSERT INTO client_summary_report_page2 set clsr_page1_id=:factfindid, p2q1=:p2q1, p2q2=:p2q2, p2q3=:p2q3, p2q4=:p2q4, p2q5=:p2q5, p2q6=:p2q6, p2q7=:p2q7, p2q8=:p2q8, p2q9=:p2q9, p2q10=:p2q10, p2q11=:p2q11, p2q12=:p2q12, p2q13=:p2q13, p2q13b=:p2q13b, p2q14=:p2q14, p2q15=:p2q15, p2q16=:p2q16, p2q17=:p2q17, p2q18=:p2q18, p2q19=:p2q19, p2q20=:p2q20, p2q20a=:p2q20a, p2q20b=:p2q20b, p2q20c=:p2q20c, p2q20d=:p2q20d, p2q21=:p2q21, p2q22=:p2q22, p2q22a=:p2q22a, p2q22b=:p2q22b, p2q22c=:p2q22c, p2q22d=:p2q22d, p2q22e=:p2q22e, p2q22f=:p2q22f");

    $query->bindParam(':factfindid', $origid_id, PDO::PARAM_INT);
    $query->bindParam(':p2q1', $p2q1, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q2', $p2q2, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q3', $p2q3, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q4', $p2q4, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q5', $p2q5, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q6', $p2q6, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q7', $p2q7, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q8', $p2q8, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q9', $p2q9, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q10', $p2q10, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q11', $p2q11, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q12', $p2q12, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q13', $p2q13, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q13b', $p2q13b, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q14', $p2q14, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q15', $p2q15, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q16', $p2q16, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q17', $p2q17, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q18', $p2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q19', $p2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20', $p2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20a', $p2q20a, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20b', $p2q20b, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20c', $p2q20c, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q20d', $p2q20d, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q21', $p2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22', $p2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22a', $p2q22a, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22b', $p2q22b, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22c', $p2q22c, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22d', $p2q22d, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22e', $p2q22e, PDO::PARAM_STR, 300);
    $query->bindParam(':p2q22f', $p2q22f, PDO::PARAM_STR, 300);

    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $clientnamedata= "Stage 5";
$uploadtype="Summary Report Added";
$final_file="Page 2";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
    
  header('Location: ../AddClientSummaryReport.php?SummaryReport=y&search='.$search); die;
                  
                  
              }
              
                            if($page=='3') {
    $name= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);              
    $pp1q1= filter_input(INPUT_POST, 'pp1q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q2= filter_input(INPUT_POST, 'pp1q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q3= filter_input(INPUT_POST, 'pp1q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q4= filter_input(INPUT_POST, 'pp1q4', FILTER_SANITIZE_NUMBER_INT);
    $pp1q5= filter_input(INPUT_POST, 'pp1q5', FILTER_SANITIZE_NUMBER_INT);
    $pp1q6= filter_input(INPUT_POST, 'pp1q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q6a= filter_input(INPUT_POST, 'pp1q6a', FILTER_SANITIZE_NUMBER_INT);
    $pp1q7= filter_input(INPUT_POST, 'pp1q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q8= filter_input(INPUT_POST, 'pp1q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q9= filter_input(INPUT_POST, 'pp1q9', FILTER_SANITIZE_NUMBER_INT);
    $pp1q10= filter_input(INPUT_POST, 'pp1q10', FILTER_SANITIZE_NUMBER_INT);
    $pp1q11= filter_input(INPUT_POST, 'pp1q11', FILTER_SANITIZE_NUMBER_INT);
    $pp1q12= filter_input(INPUT_POST, 'pp1q12', FILTER_SANITIZE_NUMBER_INT);
    $pp1q13= filter_input(INPUT_POST, 'pp1q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q14= filter_input(INPUT_POST, 'pp1q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q15= filter_input(INPUT_POST, 'pp1q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp1q16= filter_input(INPUT_POST, 'pp1q16', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $dupcheck = "Select clsr_page1_id from partner_summary_report_page1 where clsr_page1_id ='$origid_id'";
    $duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['clsr_page1_id'];  
    }
        echo "UPDATE <br>dupe $dupeclientid<br>$search - $name <br>$pp1q1 - $pp1q2 - $pp1q3 - $pp1q4 - $pp1q5 - $pp1q6 - $pp1q6a - $pp1q7 - $pp1q8 - $pp1q9 - $pp1q10 - $pp1q11 -$pp1q12 - $pp1q13 - $pp1q14 - $pp1q15 - $pp1q16";

    $query = $pdo->prepare("UPDATE partner_summary_report_page1 set client_name=:name, pp1q1=:pp1q1, pp1q2=:pp1q2, pp1q3=:pp1q3, pp1q4=:pp1q4, pp1q5=:pp1q5, pp1q6=:pp1q6, pp1q6a=:pp1q6a, pp1q7=:pp1q7, pp1q8=:pp1q8, pp1q9=:pp1q9, pp1q10=:pp1q10, pp1q11=:pp1q11, pp1q12=:pp1q12, pp1q13=:pp1q13, pp1q14=:pp1q14, pp1q15=:pp1q15, pp1q16=:pp1q16 WHERE clsr_page1_id=:dupe");

    $query->bindParam(':dupe', $dupeclientid, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q1', $pp1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q1', $pp1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q2', $pp1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q3', $pp1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q4', $pp1q4, PDO::PARAM_INT);
    $query->bindParam(':pp1q5', $pp1q5, PDO::PARAM_INT);
    $query->bindParam(':pp1q6', $pp1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q6a', $pp1q6a, PDO::PARAM_INT);
    $query->bindParam(':pp1q7', $pp1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q8', $pp1q8, PDO::PARAM_STR, 600);
    $query->bindParam(':pp1q9', $pp1q9, PDO::PARAM_INT);
    $query->bindParam(':pp1q10', $pp1q10, PDO::PARAM_INT);
    $query->bindParam(':pp1q11', $pp1q11, PDO::PARAM_INT);
    $query->bindParam(':pp1q12', $pp1q12, PDO::PARAM_INT);
    $query->bindParam(':pp1q13', $pp1q13, PDO::PARAM_STR, 600);
    $query->bindParam(':pp1q14', $pp1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q15', $pp1q15, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q16', $pp1q16, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $clientnamedata= "Stage 5";
$uploadtype="Summary Report Updated";
$final_file="Page 3";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=updated&search='.$search); die;  
}

    echo "$search - $name <br>$pp1q1 - $pp1q2 - $pp1q3 - $pp1q4 - $pp1q5 - $pp1q6 - $pp1q6a - $pp1q7 - $pp1q8 - $pp1q9 - $pp1q10 - $pp1q11 -$pp1q12 - $pp1q13 - $pp1q14 - $pp1q15 - $pp1q16";
    
    $query = $pdo->prepare("INSERT INTO partner_summary_report_page1 set client_id=:clientid, client_name=:name, pp1q1=:pp1q1, pp1q2=:pp1q2, pp1q3=:pp1q3, pp1q4=:pp1q4, pp1q5=:pp1q5, pp1q6=:pp1q6, pp1q6a=:pp1q6a, pp1q7=:pp1q7, pp1q8=:pp1q8, pp1q9=:pp1q9, pp1q10=:pp1q10, pp1q11=:pp1q11, pp1q12=:pp1q12, pp1q13=:pp1q13, pp1q14=:pp1q14, pp1q15=:pp1q15, pp1q16=:pp1q16");

    $query->bindParam(':clientid', $search, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q1', $pp1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q1', $pp1q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q2', $pp1q2, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q3', $pp1q3, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q4', $pp1q4, PDO::PARAM_INT);
    $query->bindParam(':pp1q5', $pp1q5, PDO::PARAM_INT);
    $query->bindParam(':pp1q6', $pp1q6, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q6a', $pp1q6a, PDO::PARAM_INT);
    $query->bindParam(':pp1q7', $pp1q7, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q8', $pp1q8, PDO::PARAM_STR, 600);
    $query->bindParam(':pp1q9', $pp1q9, PDO::PARAM_INT);
    $query->bindParam(':pp1q10', $pp1q10, PDO::PARAM_INT);
    $query->bindParam(':pp1q11', $pp1q11, PDO::PARAM_INT);
    $query->bindParam(':pp1q12', $pp1q12, PDO::PARAM_INT);
    $query->bindParam(':pp1q13', $pp1q13, PDO::PARAM_STR, 600);
    $query->bindParam(':pp1q14', $pp1q14, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q15', $pp1q15, PDO::PARAM_STR, 300);
    $query->bindParam(':pp1q16', $pp1q16, PDO::PARAM_STR, 300);
    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $clientnamedata= "Stage 5";
$uploadtype="Summary Report Added";
$final_file="Page 3";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=y&search='.$search); die;
                  
              }
              
              
                          if($page=='4') {
                  
                  
    $pp2q1= filter_input(INPUT_POST, 'pp2q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q2= filter_input(INPUT_POST, 'pp2q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q3= filter_input(INPUT_POST, 'pp2q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q4= filter_input(INPUT_POST, 'pp2q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q5= filter_input(INPUT_POST, 'pp2q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q6= filter_input(INPUT_POST, 'pp2q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q7= filter_input(INPUT_POST, 'pp2q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q8= filter_input(INPUT_POST, 'pp2q8', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q9= filter_input(INPUT_POST, 'pp2q9', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q10= filter_input(INPUT_POST, 'pp2q10', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q11= filter_input(INPUT_POST, 'pp2q11', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q12= filter_input(INPUT_POST, 'pp2q12', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q13= filter_input(INPUT_POST, 'pp2q13', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q13b= filter_input(INPUT_POST, 'pp2q13b', FILTER_SANITIZE_NUMBER_INT);
    $pp2q14= filter_input(INPUT_POST, 'pp2q14', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q15= filter_input(INPUT_POST, 'pp2q15', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q16= filter_input(INPUT_POST, 'pp2q16', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q17= filter_input(INPUT_POST, 'pp2q17', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q18= filter_input(INPUT_POST, 'pp2q18', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q19= filter_input(INPUT_POST, 'pp2q19', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q20= filter_input(INPUT_POST, 'pp2q20', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q20a= filter_input(INPUT_POST, 'pp2q20a', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q20b= filter_input(INPUT_POST, 'pp2q20b', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q20c= filter_input(INPUT_POST, 'pp2q20c', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q20d= filter_input(INPUT_POST, 'pp2q20d', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q21= filter_input(INPUT_POST, 'pp2q21', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22= filter_input(INPUT_POST, 'pp2q22', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22a= filter_input(INPUT_POST, 'pp2q22a', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22b= filter_input(INPUT_POST, 'pp2q22b', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22c= filter_input(INPUT_POST, 'pp2q22c', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22d= filter_input(INPUT_POST, 'pp2q22d', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22e= filter_input(INPUT_POST, 'pp2q22e', FILTER_SANITIZE_SPECIAL_CHARS);
    $pp2q22f= filter_input(INPUT_POST, 'pp2q22f', FILTER_SANITIZE_SPECIAL_CHARS);

    
    $origid_id= filter_input(INPUT_POST, 'origid', FILTER_SANITIZE_SPECIAL_CHARS);
    
$dupcheck2 = "Select clsr_page1_id from partner_summary_report_page2 where clsr_page1_id ='$origid_id'";

$duperaw2 = $conn->query($dupcheck2);

if ($duperaw2->num_rows >= 1) {
    while($row = $duperaw2->fetch_assoc()) {
        
    $dupeclientid2=$row['clsr_page1_id'];  
    }
    
    $query = $pdo->prepare("UPDATE partner_summary_report_page2 set pp2q1=:pp2q1, pp2q2=:pp2q2, pp2q3=:pp2q3, pp2q4=:pp2q4, pp2q5=:pp2q5, pp2q6=:pp2q6, pp2q7=:pp2q7, pp2q8=:pp2q8, pp2q9=:pp2q9, pp2q10=:pp2q10, pp2q11=:pp2q11, pp2q12=:pp2q12, pp2q13=:pp2q13, pp2q13b=:pp2q13b, pp2q14=:pp2q14, pp2q15=:pp2q15, pp2q16=:pp2q16, pp2q17=:pp2q17, pp2q18=:pp2q18, pp2q19=:pp2q19, pp2q20=:pp2q20, pp2q20a=:pp2q20a, pp2q20b=:pp2q20b, pp2q20c=:pp2q20c, pp2q20d=:pp2q20d, pp2q21=:pp2q21, pp2q22=:pp2q22, pp2q22a=:pp2q22a, pp2q22b=:pp2q22b, pp2q22c=:pp2q22c, pp2q22d=:pp2q22d, pp2q22e=:pp2q22e, pp2q22f=:pp2q22f WHERE clsr_page1_id=:factfindid");

    $query->bindParam(':factfindid', $dupeclientid2, PDO::PARAM_INT);
   
    $query->bindParam(':pp2q1', $pp2q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q2', $pp2q2, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q3', $pp2q3, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q4', $pp2q4, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q5', $pp2q5, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q6', $pp2q6, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q7', $pp2q7, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q8', $pp2q8, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q9', $pp2q9, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q10', $pp2q10, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q11', $pp2q11, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q12', $pp2q12, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q13', $pp2q13, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q13b', $pp2q13b, PDO::PARAM_INT);
    $query->bindParam(':pp2q14', $pp2q14, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q15', $pp2q15, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q16', $pp2q16, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q17', $pp2q17, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q18', $pp2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q19', $pp2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20', $pp2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20a', $pp2q20a, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20b', $pp2q20b, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20c', $pp2q20c, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20d', $pp2q20d, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q21', $pp2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22', $pp2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22a', $pp2q22a, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22b', $pp2q22b, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22c', $pp2q22c, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22d', $pp2q22d, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22e', $pp2q22e, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22f', $pp2q22f, PDO::PARAM_STR, 300);

    $query->execute()or die(print_r($query->errorInfo(), true));
    
    $clientnamedata= "Stage 5";
$uploadtype="Summary Report Updated";
$final_file="Page 4";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();

    
    header('Location: ../AddClientSummaryReport.php?SummaryReport=updated&search='.$search); die;
    
    
    }
    
        echo "$search<br>$origid_id<br>$pp2q1 - $pp2q2 - $pp2q3 - $pp2q4 - $pp2q5 - $pp2q6 - $pp2q7 - $pp2q8 - $pp2q9 - $pp2q10 - $pp2q11 -$pp2q12 - $pp2q13 - $pp2q14 -$pp2q15 - $pp2q16 - $pp2q17 - $pp2q18 - $pp2q19 - $pp2q20 - $pp2q20a - $pp2q20b - $pp2q20c - $pp2q20d - $pp2q21 - $pp2q22 - $pp2q22a- $pp2q22b - $pp2q22c - $pp2q22d - $pp2q22e - $pp2q22f";

    
    $query = $pdo->prepare("INSERT INTO partner_summary_report_page2 set clsr_page1_id=:factfindid, pp2q1=:pp2q1, pp2q2=:pp2q2, pp2q3=:pp2q3, pp2q4=:pp2q4, pp2q5=:pp2q5, pp2q6=:pp2q6, pp2q7=:pp2q7, pp2q8=:pp2q8, pp2q9=:pp2q9, pp2q10=:pp2q10, pp2q11=:pp2q11, pp2q12=:pp2q12, pp2q13=:pp2q13, pp2q13b=:pp2q13b, pp2q14=:pp2q14, pp2q15=:pp2q15, pp2q16=:pp2q16, pp2q17=:pp2q17, pp2q18=:pp2q18, pp2q19=:pp2q19, pp2q20=:pp2q20, pp2q20a=:pp2q20a, pp2q20b=:pp2q20b, pp2q20c=:pp2q20c, pp2q20d=:pp2q20d, pp2q21=:pp2q21, pp2q22=:pp2q22, pp2q22a=:pp2q22a, pp2q22b=:pp2q22b, pp2q22c=:pp2q22c, pp2q22d=:pp2q22d, pp2q22e=:pp2q22e, pp2q22f=:pp2q22f");

    $query->bindParam(':factfindid', $origid_id, PDO::PARAM_INT);
    $query->bindParam(':pp2q1', $pp2q1, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q2', $pp2q2, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q3', $pp2q3, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q4', $pp2q4, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q5', $pp2q5, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q6', $pp2q6, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q7', $pp2q7, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q8', $pp2q8, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q9', $pp2q9, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q10', $pp2q10, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q11', $pp2q11, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q12', $pp2q12, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q13', $pp2q13, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q13b', $pp2q13b, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q14', $pp2q14, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q15', $pp2q15, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q16', $pp2q16, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q17', $pp2q17, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q18', $pp2q18, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q19', $pp2q19, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20', $pp2q20, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20a', $pp2q20a, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20b', $pp2q20b, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20c', $pp2q20c, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q20d', $pp2q20d, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q21', $pp2q21, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22', $pp2q22, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22a', $pp2q22a, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22b', $pp2q22b, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22c', $pp2q22c, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22d', $pp2q22d, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22e', $pp2q22e, PDO::PARAM_STR, 300);
    $query->bindParam(':pp2q22f', $pp2q22f, PDO::PARAM_STR, 300);
$query->execute()or die(print_r($query->errorInfo(), true));

$clientnamedata= "Stage 5";
$uploadtype="Summary Report Added";
$final_file="Page 4";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
    
  header('Location: ../AddClientSummaryReport.php?SummaryReport=y&search='.$search); die;
                  
                  
              }  
              
              
          }
          
          $stage= filter_input(INPUT_GET, 'stage', FILTER_SANITIZE_SPECIAL_CHARS);
          $summarysheet= filter_input(INPUT_POST, 'summarysheet', FILTER_SANITIZE_NUMBER_INT);

if(isset($stage)) {
    if($stage=='5') {
        if($summarysheet=='1') {
            
            $allupdatestage = $pdo->prepare("UPDATE pension_stages set complete ='Yes' WHERE client_id =:clientid AND stage='5' AND task ='Summary Report' ");
            $allupdatestage->bindParam(':clientid', $search, PDO::PARAM_INT);
            $allupdatestage->execute()or die(print_r($allupdatestage->errorInfo(), true));  
            
$clientnamedata= "Stage 5";
$uploadtype="Summary Report";
$final_file="Marked as complete";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
            
            header('Location: ../ViewPensionClient.php?StageMarkedComplete=5&search='.$search); die;
             
        }
        
                if($summarysheet=='0') {
            
            $allupdatestage = $pdo->prepare("UPDATE pension_stages set complete ='No' WHERE client_id =:clientid AND stage='5' AND task ='Summary Report' ");
            $allupdatestage->bindParam(':clientid', $search, PDO::PARAM_INT);
            $allupdatestage->execute()or die(print_r($allupdatestage->errorInfo(), true));  
            
            header('Location: ../ViewPensionClient.php?StageMarkedComplete=5&search='.$search); die;
            
            $clientnamedata= "Stage 5";
$uploadtype="Summary Report";
$final_file="Marked as Incomplete";

$query = $pdo->prepare("INSERT INTO pension_client_note set client_id=:id, client_name=:recipientholder, sent_by=:sent, note_type=:note, message=:messageholder ");

$query->bindParam(':id',$search, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$uploadtype, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$final_file, PDO::PARAM_STR, 2500);
$query->execute();
             
        }
        
        }   
}
          
          header('Location: ../AddClientSummaryReport.php?SummaryReport=fail&search='.$search); die;