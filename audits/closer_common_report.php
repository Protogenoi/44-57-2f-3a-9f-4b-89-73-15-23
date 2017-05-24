<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_MYSQLI_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /CRMmain.php'); die;
    }



if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}


//Q1

$name= filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_POST, 'datefrom', FILTER_SANITIZE_NUMBER_INT);
$dateto = filter_input(INPUT_POST, 'dateto', FILTER_SANITIZE_NUMBER_INT);

$result = $mysqli->query("select q1, count(q1) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q1");

  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q1', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q1']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq1 = json_encode($table);

?>
<!--Q2--> 
<?php


$result = $mysqli->query("select q2, count(q2) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q2");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q2', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q2']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq2 = json_encode($table);

?>
<!--Q3-->  
<?php

$result = $mysqli->query("select q3, count(q3) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q3");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q3', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q3']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq3 = json_encode($table);

?>
<!--Q4-->
<?php

$result = $mysqli->query("select q4, count(q4) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q4");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q4', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q4']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq4 = json_encode($table);

?>
<!--Q5-->
<?php

$result = $mysqli->query("select q5, count(q5) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q5");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q5', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q5']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq5 = json_encode($table);

?>
<!--Q6--> 
<?php

$result = $mysqli->query("select q6, count(q6) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q6");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q6', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q6']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq6 = json_encode($table);

?>
<!--Q7--> 
<?php

$result = $mysqli->query("select q7, count(q7) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q7");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q7', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q7']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq7 = json_encode($table);

?>  
<!--Q8--> 
<?php

$result = $mysqli->query("select q8, count(q8) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q8");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q8', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q8']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq8 = json_encode($table);

?> 
<!--Q9--> 
<?php

$result = $mysqli->query("select q9, count(q9) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q9");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q9', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q9']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq9 = json_encode($table);

?> 
<!--Q10--> 
<?php

$result = $mysqli->query("select q10, count(q10) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q10");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q10', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q10']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq10 = json_encode($table);

?>
<!--Q11--> 
<?php

$result = $mysqli->query("select q11, count(q11) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q11");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q11', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q11']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq11 = json_encode($table);

?>      
<!--Q12--> 
<?php

$result = $mysqli->query("select q12, count(q12) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q12");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q12', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q12']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq12 = json_encode($table);

?>
<!--Q13(q53)--> 
<?php

$result = $mysqli->query("select q53, count(q53) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q53");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q13', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q53']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq13 = json_encode($table);
?>
<!--Q14--> 
<?php

$result = $mysqli->query("select q13, count(q13) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q13");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q14', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q13']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq14 = json_encode($table);

?>
<!--Q15--> 
<?php

$result = $mysqli->query("select q14, count(q14) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q14");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q15', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q14']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq15 = json_encode($table);

?>     
<!--Q16--> 
<?php

$result = $mysqli->query("select q15, count(q15) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q15");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q16', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q15']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq16 = json_encode($table);

?>        
<!--Q17--> 
<?php

$result = $mysqli->query("select q16, count(q16) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q16");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q17', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q16']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq17 = json_encode($table);

?>
<!--Q18--> 
<?php

$result = $mysqli->query("select q17, count(q17) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q17");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q18', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q17']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq18 = json_encode($table);

?>     
<!--Q19(Q55)--> 
<?php

$result = $mysqli->query("select q55, count(q55) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q55");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q19', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q55']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq19 = json_encode($table);

?>

<!--Q20-->  
<?php

$result = $mysqli->query("select q31, count(q31) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q31");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q21', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q31']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq20 = json_encode($table);

?>
      
<!--Q21--> 
<?php

$result = $mysqli->query("select q18, count(q18) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q18");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q22', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q18']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq21 = json_encode($table);

?>
<!--Q22--> 
<?php

$result = $mysqli->query("select q19, count(q19) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q19");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q23', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q19']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq22 = json_encode($table);

?>         
<!--Q23--> 
<?php

$result = $mysqli->query("select q20, count(q20) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q20");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q24', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q20']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq23 = json_encode($table);

?>     
<!--Q24--> 
<?php

$result = $mysqli->query("select q21, count(q21) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q21");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q25', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q21']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq24 = json_encode($table);

?>   
<!--Q25--> 
<?php

$result = $mysqli->query("select q22, count(q22) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q22");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q26', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q22']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq25 = json_encode($table);

?> 
<!--Q26--> 
<?php

$result = $mysqli->query("select q23, count(q23) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q23");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q27', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q23']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq26 = json_encode($table);

?> 
<!--Q27--> 
<?php

$result = $mysqli->query("select q24, count(q24) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q24");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q28', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q24']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq27 = json_encode($table);

?> 

<!--Q28--> 
<?php

$result = $mysqli->query("select q25, count(q25) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q25");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q29', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q25']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq28 = json_encode($table);

?> 

<!--Q29--> 
<?php

$result = $mysqli->query("select q26, count(q26) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q26");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q30', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q26']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq29 = json_encode($table);

?> 

<!--Q30--> 
<?php

$result = $mysqli->query("select q27, count(q27) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q27");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q31', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q27']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq30 = json_encode($table);

?>
<!--Q31--> 
<?php

$result = $mysqli->query("select q28, count(q28) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q28");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q32', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q28']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq31 = json_encode($table);

?> 
<!--Q32--> 
<?php

$result = $mysqli->query("select q29, count(q29) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q29");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q33', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q29']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq32 = json_encode($table);

?>
<!--Q33--> 
<?php

$result = $mysqli->query("select q30, count(q30) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q30");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q33', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q30']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq33 = json_encode($table);

?>
<!--Q34(Q54)--> 
<?php

$result = $mysqli->query("select q54, count(q54) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59' group by q54");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q20', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q54']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq34 = json_encode($table);

?>
<!--Q35--> 
<?php

$result = $mysqli->query("select q32, count(q32) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q32");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q35', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q32']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq35 = json_encode($table);

?>
<!--Q36--> 
<?php

$result = $mysqli->query("select q33, count(q33) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q33");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q36', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q33']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq36 = json_encode($table);

?>
<!--Q37--> 
<?php

$result = $mysqli->query("select q34, count(q34) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q34");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q37', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q34']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq37 = json_encode($table);

?>
<!--Q38--> 
<?php

$result = $mysqli->query("select q35, count(q35) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q35");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q38', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q35']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq38 = json_encode($table);

?>
<!--Q39--> 
<?php

$result = $mysqli->query("select q36, count(q36) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q36");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q39', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q36']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq39 = json_encode($table);

?>
<!--Q37
<?php

$result = $mysqli->query("select q37, count(q37) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q37");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q37', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q37']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTable36 = json_encode($table);

?>
--> 
<!--Q40--> 
<?php

$result = $mysqli->query("select q38, count(q38) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q38");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q40', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q38']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq40 = json_encode($table);

?>
<!--Q41--> 
<?php

$result = $mysqli->query("select q39, count(q39) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q39");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q41', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q39']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq41 = json_encode($table);

?>
<!--Q42--> 
<?php

$result = $mysqli->query("select q40, count(q40) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q40");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q42', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q40']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq42 = json_encode($table);

?>
<!--Q43--> 
<?php

$result = $mysqli->query("select q41, count(q41) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q41");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q43', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q41']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq43 = json_encode($table);

?>
<!--Q44--> 
<?php

$result = $mysqli->query("select q42, count(q42) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q42");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q44', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q42']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq44 = json_encode($table);

?>
<!--Q45--> 
<?php

$result = $mysqli->query("select q43, count(q43) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q43");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q45', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q43']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq45 = json_encode($table);

?>

<!--Q46--> 
<?php

$result = $mysqli->query("select q44, count(q44) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q44");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q46', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q44']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq46 = json_encode($table);

?>
<!--Q47--> 
<?php

$result = $mysqli->query("select q45, count(q45) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q45");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q47', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q45']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq47 = json_encode($table);

?>
<!--Q48--> 
<?php

$result = $mysqli->query("select q46, count(q46) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q46");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q48', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q46']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq48 = json_encode($table);

?>
<!--Q49--> 
<?php

$result = $mysqli->query("select q47, count(q47) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q47");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q49', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q47']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq49 = json_encode($table);

?>
<!--Q50--> 
<?php

$result = $mysqli->query("select q48, count(q48) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q48");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q50', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q48']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq50 = json_encode($table);

?>
<!--Q51--> 
<?php

$result = $mysqli->query("select q49, count(q49) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q49");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q51', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q49']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq51 = json_encode($table);

?>
<!--Q52--> 
<?php

$result = $mysqli->query("select q50, count(q50) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q50");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q52', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q50']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq52 = json_encode($table);

?>
<!--Q53--> 
<?php

$result = $mysqli->query("select q51, count(q51) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q51");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q53', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q51']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq53 = json_encode($table);

?>
<!--Q54--> 
<?php

$result = $mysqli->query("select q52, count(q52) as Alert from closer_audits where closer ='$name' and date_submitted between '$datefrom 00:00:00' and '$dateto 23:59:59'  group by q52");


  $rows = array();
  $table = array();
  $table['cols'] = array(

    array('label' => ' ', 'type' => 'string'),
    array('label' => 'Q54', 'type' => 'number')
);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['q52']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $rows[] = array('c' => $temp);
	  
    }

$table['rows'] = $rows;

$jsonTableq54 = json_encode($table);

?>

<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Closer Audit Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script type="text/javascript" language="javascript" src="../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="../EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
</head>


<?php require_once(__DIR__ . '/../includes/navbar.php');
?>

  <div class="container">

<fieldset>

	<form method="post">
          
	
                
                  
  <label for="fname">Lead Gen<input id="fname" name='fname' required placeholder="Lead Gen" value="<?php if(isset($name)) { echo "$name";}?>" type="text"></label>
<script>var options = {
	url: "../JSON/CloserNames.json",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#fname").easyAutocomplete(options);</script> 
                
                
<label for="datefrom">Start Date<input id="datefrom" type="text" name="datefrom" placeholder="YYYY-MM-DD" value="<?php echo $datefrom;?>"> </label>
<label for="dateto">End Date<input id="dateto" type="text" name="dateto" placeholder="YYYY-MM-DD" value="<?php echo $dateto;?>"> </label>
<button type="submit" class="btn btn-info" value="Go"><span class="glyphicon glyphicon-search"></span></button>
	</form>
	</fieldset>
<br>

<center>
<a href="audit_profiles.php">
<button type="button" class="btn btn-warning "><span class="glyphicon glyphicon-user"></span> Audit Profiles</button>
</a>
<a href="auditor_menu.php">
<button type="button" class="btn btn-success "><span class="glyphicon glyphicon-folder-close"></span> Closer Audits</button>
</a>
<a href="audit_search.php">
<button type="button" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</button>
</a>
<a href="closer_reports.php">
<button type="button" class="btn btn-primary "><span class="glyphicon glyphicon-question-sign"></span> Closer Grades</button>
</a>
</center>

<br>
<br>
<?php if(isset($datefrom)&& ($dateto) && ($name)) {
echo '<div class="col-md-4">
<div id="q1_chart"></div>
<div id="q4_chart"></div>
<div id="q7_chart"></div>
<div id="q10_chart"></div>
<div id="q53_chart"></div>
<div id="q15_chart"></div>
<div id="q55_chart"></div>
<div id="q19_chart"></div>
<div id="q22_chart"></div>
<div id="q25_chart"></div>
<div id="q28_chart"></div>
<div id="q54_chart"></div>
<div id="q34_chart"></div>
<div id="q38_chart"></div>
<div id="q41_chart"></div>
<div id="q44_chart"></div>
<div id="q47_chart"></div>
<div id="q50_chart"></div>
</div>

<div class="col-md-4">
<div id="q2_chart"></div>
<div id="q5_chart"></div>
<div id="q8_chart"></div>
<div id="q11_chart"></div>
<div id="q13_chart"></div>
<div id="q16_chart"></div>
<div id="q31_chart"></div>
<div id="q20_chart"></div>
<div id="q23_chart"></div>
<div id="q26_chart"></div>
<div id="q29_chart"></div>
<div id="q32_chart"></div>
<div id="q35_chart"></div>
<div id="q39_chart"></div>
<div id="q42_chart"></div>
<div id="q45_chart"></div>
<div id="q48_chart"></div>
<div id="q51_chart"></div>

</div>

<div class="col-md-4">
<div id="q3_chart"></div>
<div id="q6_chart"></div>
<div id="q9_chart"></div>
<div id="q12_chart"></div>
<div id="q14_chart"></div>
<div id="q17_chart"></div>
<div id="q18_chart"></div>
<div id="q21_chart"></div>
<div id="q24_chart"></div>
<div id="q27_chart"></div>
<div id="q30_chart"></div>
<div id="q33_chart"></div>
<div id="q36_chart"></div>
<div id="q40_chart"></div>
<div id="q43_chart"></div>
<div id="q46_chart"></div>
<div id="q49_chart"></div>
<div id="q52_chart"></div>'; }?>
</div>


<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<!--Q1-->    
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq1?>);

        var options = {
                    title: 'Q1. Calls are recorded',
                    chart: {

        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q1_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q2-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq2?>);

        var options = {
                    title: 'Q2. Regulated by the FCA',
            chart: {

        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q2_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q3-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq3?>);

        var options = {
                    title: 'Q3. Abbreviated/full script?',
            chart: {

        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q3_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q4-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq4?>);

        var options = {
                    title: 'Q4. Company details & FCA regulated?',
            chart: {

        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q4_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q5-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq5?>);

        var options = {
                    title: 'Q5. Unabled offer advice or personal opinion?',
             chart: {

        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q5_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q6-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq6?>);

        var options = {
                    title: 'Q6. Clients details recorded correctly?',
            chart: {

        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q6_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q7-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq7?>);

        var options = {
                    title: 'Q7. Gender recorded correctly?',
                        chart: {

        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q7_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q8-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq8?>);

        var options = {
                    title: 'Q8. DOB correct?',
            chart: {

        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q8_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q9-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq9?>);

        var options = {
                    title: 'Q9. Smoker status recorded correctly?',
            chart: {

        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q9_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q10-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq10?>);

        var options = {
                  title: 'Q10. Employment status correct?',  
            chart: {

        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q10_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q11-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq11?>);

        var options = {
          title: 'Q11. Confirmed the policy was a single or joint?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q11_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q12-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq12?>);

        var options = {
                    title: 'Q12. Any existing insurance?',
            chart: {

        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q12_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q13(q53)-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq13?>);

        var options = {
                    title: 'Q13. Waiver, indexation, or TPD?',
            chart: {

        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q53_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q14-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq14?>);

        var options = {
          title: 'Q14. Policy that met thier needs?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q13_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q15-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq15?>);

        var options = {
          title: 'Q15. Sufficient amount of features?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q14_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q16-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq16?>);

        var options = {
          title: 'Q16. Confirmed policy is with L&G?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q15_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q17-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq17?>);

        var options = {
          title: 'Q17. Client address correct?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q16_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q18-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq18?>);

        var options = {
          title: 'Q18. Client contact details correct?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q17_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q19(Q55)-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq19?>);

        var options = {
           title: 'Q19. Customer information declaration?',
            chart: {
         
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q55_chart'));

        chart.draw(data, options);
      }
    </script>

<!--Q20(Q31)-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq34?>);

        var options = {
          title: 'Q20. Doctor details recorded correctly?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q31_chart'));

        chart.draw(data, options);
      }
    </script>


<!--Q21-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq20?>);

        var options = {
          title: 'Q21. Work & travel questions correct?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q18_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q22-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq21?>);

        var options = {
          title: 'Q22. Hazardous activities asked & correct?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q19_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q23-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq22?>);

        var options = {
          title: 'Q23. Height & weight recorded correctly?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q20_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q24-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq23?>);

        var options = {
             title: 'Q24. Asked smoking details?',
            chart: {
       
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q21_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q25-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq24?>);

        var options = {
          title: 'Q25. Asked & drug details correct?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q22_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q26-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq25?>);

        var options = {
          title: 'Q26. Alcohol details correct?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q23_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q27-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq26?>);

        var options = {
          title: 'Q27. All health questions asked & correct?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q24_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q28-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq27?>);

        var options = {
          title: 'Q28. Health in the last 5 years asked & correct?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q25_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q29-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq28?>);

        var options = {
          title: 'Q29. Health in the last 2 years correct?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q26_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q30-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq29?>);

        var options = {
          title: 'Q30. All health continued questions correct?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q27_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q31-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq30?>);

        var options = {
          title: 'Q31. Family questions asked and correct?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q28_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q32-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq31?>);

        var options = {
          title: 'Q32. Term For Term correct?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q29_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q33-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq32?>);

        var options = {
          title: 'Q33. Customer declaration read out?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q30_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q34(q54)-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq33?>);

        var options = {
          title: 'Q34. Confirmed any exclusions on the policy?',
            chart: {

        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q54_chart'));

        chart.draw(data, options);
      }
    </script>

<!--Q35-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq35?>);

        var options = {
          title: 'Q35. Start date recorded correctly?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q32_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q36-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq36?>);

        var options = {
          title: 'Q36. Offered to read the DB guarantee?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q33_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q37-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq37?>);

        var options = {
                title: 'Q37. Preferred premium collection date?',
            chart: {
    
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q34_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q38-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq38?>);

        var options = {
           title: 'Q38. Bank details correct?',
            chart: {
         
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q35_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q39-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq39?>);

        var options = {
          title: 'Q39. Have consent off the premium payer?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q36_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q40-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq40?>);

        var options = {
          title: 'Q40. Confirmed rights to cancel/refund?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q38_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q41-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq41?>);

        var options = {
           title: 'Q41. After 30 days no refund/value?',
            chart: {
         
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q39_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q42-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq42?>);

        var options = {
          title: 'Q42. "This is an information based service?"',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q40_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q43-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq43?>);

        var options = {
          title: 'Q43. Key Facts Email?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q41_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q44-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq44?>);

        var options = {
          title: 'Q44. Documents sent out in 4-5 days from L&G?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q42_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q45-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq45?>);

        var options = {
          title: 'Q45. Confirmed check your details?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q43_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q46-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq46?>);

        var options = {
          title: 'Q46. Confirmed aprox DB date?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q44_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q47-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq47?>);

        var options = {
          title: 'Q47. Cancel any existing policy?',
            chart: {
          
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q45_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q48-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq48?>);

        var options = {
          title: 'Q48. Policy type & provider confirmed?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q46_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q49-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq49?>);

        var options = {
          title: 'Q49. Confirmed length of policy in years?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q47_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q50-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq50?>);

        var options = {
          title: 'Q50. Confirmed amount of cover?',
            chart: {
          
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q48_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q51-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq51?>);

        var options = {
           title: 'Q51. Confirmed client understood everything?',
            chart: {
         
        },
			colors: ['purple']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q49_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q52-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq52?>);

        var options = {
          title: 'Q52. Customer gave explicit consent?',
            chart: {
          
        },
			colors: ['red']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q50_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q53-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq53?>);

        var options = {
          title: 'Q53. Provided contact details?',
            chart: {
          
        },
			colors: ['blue']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q51_chart'));

        chart.draw(data, options);
      }
    </script>
<!--Q54-->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTableq54?>);

        var options = {
           title: 'Q54. Non-advised sale?',
            chart: {
         
        },
			colors: ['orange']
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('q52_chart'));

        chart.draw(data, options);
      }
    </script>


  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datefrom" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script> 

</html>
