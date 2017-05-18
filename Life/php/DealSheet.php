<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($ffdealsheets) && $ffdealsheets=='0') {
    header('Location: ../../CRMmain.php?Feature=NotEnabled'); die;
}

include('../../includes/Access_Levels.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../../classes/database_class.php');

$dealsheet= filter_input(INPUT_GET, 'dealsheet', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($dealsheet)) {
    
    $deal_id= filter_input(INPUT_GET, 'deal_id', FILTER_SANITIZE_NUMBER_INT);
    
    $deal_date= filter_input(INPUT_POST, 'deal_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $agent= filter_input(INPUT_POST, 'agent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $forename= filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $surname= filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $dob_day= filter_input(INPUT_POST, 'dob_day', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_month= filter_input(INPUT_POST, 'dob_month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_year= filter_input(INPUT_POST, 'dob_year', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $dob = "$dob_year $dob_month $dob_day";
    
    $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $forename2= filter_input(INPUT_POST, 'forename2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $surname2= filter_input(INPUT_POST, 'surname2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $dob_day2= filter_input(INPUT_POST, 'dob_day2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_month2= filter_input(INPUT_POST, 'dob_month2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_year2= filter_input(INPUT_POST, 'dob_year2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $dob2 = "$dob_year2 $dob_month2 $dob_day2";
    
    $postcode= filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mobile= filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $home= filter_input(INPUT_POST, 'home', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $MORTGAGE_TYPE= filter_input(INPUT_POST, 'MORTGAGE_TYPE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $MORTGAGE_REASON= filter_input(INPUT_POST, 'MORTGAGE_REASON', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $MORTGAGE_DATE= filter_input(INPUT_POST, 'MORTGAGE_CB_DATE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $MORTGAGE_TIME= filter_input(INPUT_POST, 'MORTGAGE_CB_TIME', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $q1a= filter_input(INPUT_POST, 'q1a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q1b= filter_input(INPUT_POST, 'q1b', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q1c= filter_input(INPUT_POST, 'q1c', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q1d= filter_input(INPUT_POST, 'q1d', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q2a= filter_input(INPUT_POST, 'q2a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q3a= filter_input(INPUT_POST, 'q3a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q4a= filter_input(INPUT_POST, 'q4a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q4b= filter_input(INPUT_POST, 'q4b', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q4c= filter_input(INPUT_POST, 'q4c', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q4d= filter_input(INPUT_POST, 'q4d', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q4e= filter_input(INPUT_POST, 'q4e', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q5a= filter_input(INPUT_POST, 'q5a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q6a= filter_input(INPUT_POST, 'q6a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q6b= filter_input(INPUT_POST, 'q6b', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q7a= filter_input(INPUT_POST, 'q7a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comments= filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $callback= filter_input(INPUT_POST, 'callback', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if($closer=='CALLBACK') {
        
     $database = new Database(); 
        $database->beginTransaction();

            
            $database->query("INSERT INTO dealsheet_prt1 set status='CALLBACK', agent=:agent, closer=:closer, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email");
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);

            $database->execute(); 
            $lastid =  $database->lastInsertId();
            
            $database->query("INSERT INTO dealsheet_prt2 set deal_id=:deal_id, q1a=:q1a, q1b=:q1b, q1c=:q1c, q1d=:q1d, q2a=:q2a, q3a=:q3a, q4a=:q4a, q4b=:q4b, q4c=:q4c, q4d=:q4d, q4e=:q4e, q5a=:q5a, q6a=:q6a, q6b=:q6b, q7a=:q7a, comments=:comments, callback=:callback");
            $database->bind(':deal_id',$lastid);
            $database->bind(':q1a',$q1a);
            $database->bind(':q1b',$q1b);
            $database->bind(':q1c',$q1c);
            $database->bind(':q1d',$q1d);
            $database->bind(':q2a',$q2a);
            $database->bind(':q3a',$q3a);
            $database->bind(':q4a',$q4a);
            $database->bind(':q4b',$q4b);
            $database->bind(':q4c',$q4c);
            $database->bind(':q4d',$q4d);
            $database->bind(':q4e',$q4e);
            $database->bind(':q5a',$q5a);
            $database->bind(':q6a',$q6a);
            $database->bind(':q6b',$q6b);
            $database->bind(':q7a',$q7a);
            $database->bind(':comments',$comments);
            $database->bind(':callback',$callback);

            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../LifeDealSheet.php?RESULT='.$lastid); die;    
        
        
    }
    
    if($dealsheet=='NEW') {
        
        $database = new Database(); 
        $database->beginTransaction();

            
            $database->query("INSERT INTO dealsheet_prt1 set status='CLOSER', agent=:agent, closer=:closer, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email");
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);

            $database->execute(); 
            $lastid =  $database->lastInsertId();
            
            $database->query("INSERT INTO dealsheet_prt2 set deal_id=:deal_id, q1a=:q1a, q1b=:q1b, q1c=:q1c, q1d=:q1d, q2a=:q2a, q3a=:q3a, q4a=:q4a, q4b=:q4b, q4c=:q4c, q4d=:q4d, q4e=:q4e, q5a=:q5a, q6a=:q6a, q6b=:q6b, q7a=:q7a, comments=:comments, callback=:callback");
            $database->bind(':deal_id',$lastid);
            $database->bind(':q1a',$q1a);
            $database->bind(':q1b',$q1b);
            $database->bind(':q1c',$q1c);
            $database->bind(':q1d',$q1d);
            $database->bind(':q2a',$q2a);
            $database->bind(':q3a',$q3a);
            $database->bind(':q4a',$q4a);
            $database->bind(':q4b',$q4b);
            $database->bind(':q4c',$q4c);
            $database->bind(':q4d',$q4d);
            $database->bind(':q4e',$q4e);
            $database->bind(':q5a',$q5a);
            $database->bind(':q6a',$q6a);
            $database->bind(':q6b',$q6b);
            $database->bind(':q7a',$q7a);
            $database->bind(':comments',$comments);
            $database->bind(':callback',$callback);

            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../LifeDealSheet.php?RESULT='.$lastid); die;
        
        
    }
    
        if($dealsheet=='CLOSERRESEND') {
        
    $deal_id= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);
        
    $exist_pol= filter_input(INPUT_POST, 'exist_pol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $closer_date= filter_input(INPUT_POST, 'closer_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fee= filter_input(INPUT_POST, 'fee', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total= filter_input(INPUT_POST, 'total', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $years= filter_input(INPUT_POST, 'years', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $month= filter_input(INPUT_POST, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comm_after= filter_input(INPUT_POST, 'comm_after', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sac= filter_input(INPUT_POST, 'sac', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $chk_post= filter_input(INPUT_POST, 'chk_postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_dob= filter_input(INPUT_POST, 'chk_dob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_mob= filter_input(INPUT_POST, 'chk_mob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_home= filter_input(INPUT_POST, 'chk_home', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_email= filter_input(INPUT_POST, 'chk_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $pol_1_num= filter_input(INPUT_POST, 'pol_1_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_pre= filter_input(INPUT_POST, 'pol_1_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_com= filter_input(INPUT_POST, 'pol_1_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_cov= filter_input(INPUT_POST, 'pol_1_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_yr= filter_input(INPUT_POST, 'pol_1_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_type= filter_input(INPUT_POST, 'pol_1_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_soj= filter_input(INPUT_POST, 'pol_1_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_2_num= filter_input(INPUT_POST, 'pol_2_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_pre= filter_input(INPUT_POST, 'pol_2_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_com= filter_input(INPUT_POST, 'pol_2_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_cov= filter_input(INPUT_POST, 'pol_2_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_yr= filter_input(INPUT_POST, 'pol_2_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_type= filter_input(INPUT_POST, 'pol_2_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_soj= filter_input(INPUT_POST, 'pol_2_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_3_num= filter_input(INPUT_POST, 'pol_3_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_pre= filter_input(INPUT_POST, 'pol_3_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_com= filter_input(INPUT_POST, 'pol_3_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_cov= filter_input(INPUT_POST, 'pol_3_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_yr= filter_input(INPUT_POST, 'pol_3_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_type= filter_input(INPUT_POST, 'pol_3_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_soj= filter_input(INPUT_POST, 'pol_3_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_4_num= filter_input(INPUT_POST, 'pol_4_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_pre= filter_input(INPUT_POST, 'pol_4_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_com= filter_input(INPUT_POST, 'pol_4_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_cov= filter_input(INPUT_POST, 'pol_4_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_yr= filter_input(INPUT_POST, 'pol_4_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_type= filter_input(INPUT_POST, 'pol_4_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_soj= filter_input(INPUT_POST, 'pol_4_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $CLOSER_STATUS='CLOSER';
    
    $database = new Database(); 
    $database->beginTransaction();
            
            $database->query("UPDATE dealsheet_prt1 set status=:qa, agent=:agent, closer=:closer, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email WHERE deal_id=:deal_id");
            $database->bind(':qa',$CLOSER_STATUS);
            $database->bind(':deal_id',$deal_id);
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);
            $database->execute(); 
            
            $database->query("UPDATE dealsheet_prt2 set deal_id=:deal_id, q1a=:q1a, q1b=:q1b, q1c=:q1c, q1d=:q1d, q2a=:q2a, q3a=:q3a, q4a=:q4a, q4b=:q4b, q4c=:q4c, q4d=:q4d, q4e=:q4e, q5a=:q5a, q6a=:q6a, q6b=:q6b, q7a=:q7a, comments=:comments, callback=:callback WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->bind(':q1a',$q1a);
            $database->bind(':q1b',$q1b);
            $database->bind(':q1c',$q1c);
            $database->bind(':q1d',$q1d);
            $database->bind(':q2a',$q2a);
            $database->bind(':q3a',$q3a);
            $database->bind(':q4a',$q4a);
            $database->bind(':q4b',$q4b);
            $database->bind(':q4c',$q4c);
            $database->bind(':q4d',$q4d);
            $database->bind(':q4e',$q4e);
            $database->bind(':q5a',$q5a);
            $database->bind(':q6a',$q6a);
            $database->bind(':q6b',$q6b);
            $database->bind(':q7a',$q7a);
            $database->bind(':comments',$comments);
            $database->bind(':callback',$callback);
            $database->execute(); 
            
            
            $database->query("SELECT deal_id FROM dealsheet_prt3 WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
                        $database->query("UPDATE dealsheet_prt3 set exist_pol=:exist_pol,
pol_num_1=:pol_num_1,
pol_num_1_pre=:pol_num_1_pre,
pol_num_1_com=:pol_num_1_com,
pol_num_1_cov=:pol_num_1_cov,
pol_num_1_yr=:pol_num_1_yr,
pol_num_1_type=:pol_num_1_type,
pol_num_1_soj=:pol_num_1_soj,
pol_num_2=:pol_num_2,
pol_num_2_pre=:pol_num_2_pre,
pol_num_2_com=:pol_num_2_com,
pol_num_2_cov=:pol_num_2_cov,
pol_num_2_yr=:pol_num_2_yr,
pol_num_2_type=:pol_num_2_type,
pol_num_2_soj=:pol_num_2_soj,
pol_num_3=:pol_num_3,
pol_num_3_pre=:pol_num_3_pre,
pol_num_3_com=:pol_num_3_com,
pol_num_3_cov=:pol_num_3_cov,
pol_num_3_yr=:pol_num_3_yr,
pol_num_3_type=:pol_num_3_type,
pol_num_3_soj=:pol_num_3_soj,
pol_num_4=:pol_num_4,
pol_num_4_pre=:pol_num_4_pre,
pol_num_4_com=:pol_num_4_com,
pol_num_4_cov=:pol_num_4_cov,
pol_num_4_yr=:pol_num_4_yr,
pol_num_4_type=:pol_num_4_type,
pol_num_4_soj=:pol_num_4_soj,
chk_post=:chk_post,
chk_dob=:chk_dob,
chk_mob=:chk_mob,
chk_home=:chk_home,
chk_email=:chk_email,
fee=:fee,
total=:total,
years=:years,
month=:month,
comm_after=:comm_after,
sac=:sac,
date=:date
WHERE deal_id=:deal_id");
            
$database->bind(':exist_pol',$exist_pol);
$database->bind(':pol_num_1',$pol_1_num);
$database->bind(':pol_num_1_pre',$pol_1_pre);
$database->bind(':pol_num_1_com',$pol_1_com);
$database->bind(':pol_num_1_cov',$pol_1_cov);
$database->bind(':pol_num_1_yr',$pol_1_yr);
$database->bind(':pol_num_1_type',$pol_1_type);
$database->bind(':pol_num_1_soj',$pol_1_soj);
$database->bind(':pol_num_2',$pol_2_num);
$database->bind(':pol_num_2_pre',$pol_2_pre);
$database->bind(':pol_num_2_com',$pol_2_com);
$database->bind(':pol_num_2_cov',$pol_2_cov);
$database->bind(':pol_num_2_yr',$pol_2_yr);
$database->bind(':pol_num_2_type',$pol_2_type);
$database->bind(':pol_num_2_soj',$pol_2_soj);
$database->bind(':pol_num_3',$pol_3_num);
$database->bind(':pol_num_3_pre',$pol_3_pre);
$database->bind(':pol_num_3_com',$pol_3_com);
$database->bind(':pol_num_3_cov',$pol_3_cov);
$database->bind(':pol_num_3_yr',$pol_3_yr);
$database->bind(':pol_num_3_type',$pol_3_type);
$database->bind(':pol_num_3_soj',$pol_3_soj);
$database->bind(':pol_num_4',$pol_4_num);
$database->bind(':pol_num_4_pre',$pol_4_pre);
$database->bind(':pol_num_4_com',$pol_4_com);
$database->bind(':pol_num_4_cov',$pol_4_cov);
$database->bind(':pol_num_4_yr',$pol_4_yr);
$database->bind(':pol_num_4_type',$pol_4_type);
$database->bind(':pol_num_4_soj',$pol_4_soj);
$database->bind(':chk_post',$chk_post);
$database->bind(':chk_dob',$chk_dob);
$database->bind(':chk_mob',$chk_mob);
$database->bind(':chk_home',$chk_home);
$database->bind(':chk_email',$chk_email);
$database->bind(':fee',$fee);
$database->bind(':total',$total);
$database->bind(':years',$years);
$database->bind(':month',$month);
$database->bind(':comm_after',$comm_after);
$database->bind(':sac',$sac);
$database->bind(':date',$closer_date);
$database->bind(':deal_id',$deal_id);
$database->execute();     
                
                
            }
            
            else {
            
            $database->query("INSERT dealsheet_prt3 set exist_pol=:exist_pol,
pol_num_1=:pol_num_1,
pol_num_1_pre=:pol_num_1_pre,
pol_num_1_com=:pol_num_1_com,
pol_num_1_cov=:pol_num_1_cov,
pol_num_1_yr=:pol_num_1_yr,
pol_num_1_type=:pol_num_1_type,
pol_num_1_soj=:pol_num_1_soj,
pol_num_2=:pol_num_2,
pol_num_2_pre=:pol_num_2_pre,
pol_num_2_com=:pol_num_2_com,
pol_num_2_cov=:pol_num_2_cov,
pol_num_2_yr=:pol_num_2_yr,
pol_num_2_type=:pol_num_2_type,
pol_num_2_soj=:pol_num_2_soj,
pol_num_3=:pol_num_3,
pol_num_3_pre=:pol_num_3_pre,
pol_num_3_com=:pol_num_3_com,
pol_num_3_cov=:pol_num_3_cov,
pol_num_3_yr=:pol_num_3_yr,
pol_num_3_type=:pol_num_3_type,
pol_num_3_soj=:pol_num_3_soj,
pol_num_4=:pol_num_4,
pol_num_4_pre=:pol_num_4_pre,
pol_num_4_com=:pol_num_4_com,
pol_num_4_cov=:pol_num_4_cov,
pol_num_4_yr=:pol_num_4_yr,
pol_num_4_type=:pol_num_4_type,
pol_num_4_soj=:pol_num_4_soj,
chk_post=:chk_post,
chk_dob=:chk_dob,
chk_mob=:chk_mob,
chk_home=:chk_home,
chk_email=:chk_email,
fee=:fee,
total=:total,
years=:years,
month=:month,
comm_after=:comm_after,
sac=:sac,
date=:date,
deal_id=:deal_id");
            
$database->bind(':exist_pol',$exist_pol);
$database->bind(':pol_num_1',$pol_1_num);
$database->bind(':pol_num_1_pre',$pol_1_pre);
$database->bind(':pol_num_1_com',$pol_1_com);
$database->bind(':pol_num_1_cov',$pol_1_cov);
$database->bind(':pol_num_1_yr',$pol_1_yr);
$database->bind(':pol_num_1_type',$pol_1_type);
$database->bind(':pol_num_1_soj',$pol_1_soj);
$database->bind(':pol_num_2',$pol_2_num);
$database->bind(':pol_num_2_pre',$pol_2_pre);
$database->bind(':pol_num_2_com',$pol_2_com);
$database->bind(':pol_num_2_cov',$pol_2_cov);
$database->bind(':pol_num_2_yr',$pol_2_yr);
$database->bind(':pol_num_2_type',$pol_2_type);
$database->bind(':pol_num_2_soj',$pol_2_soj);
$database->bind(':pol_num_3',$pol_3_num);
$database->bind(':pol_num_3_pre',$pol_3_pre);
$database->bind(':pol_num_3_com',$pol_3_com);
$database->bind(':pol_num_3_cov',$pol_3_cov);
$database->bind(':pol_num_3_yr',$pol_3_yr);
$database->bind(':pol_num_3_type',$pol_3_type);
$database->bind(':pol_num_3_soj',$pol_3_soj);
$database->bind(':pol_num_4',$pol_4_num);
$database->bind(':pol_num_4_pre',$pol_4_pre);
$database->bind(':pol_num_4_com',$pol_4_com);
$database->bind(':pol_num_4_cov',$pol_4_cov);
$database->bind(':pol_num_4_yr',$pol_4_yr);
$database->bind(':pol_num_4_type',$pol_4_type);
$database->bind(':pol_num_4_soj',$pol_4_soj);
$database->bind(':chk_post',$chk_post);
$database->bind(':chk_dob',$chk_dob);
$database->bind(':chk_mob',$chk_mob);
$database->bind(':chk_home',$chk_home);
$database->bind(':chk_email',$chk_email);
$database->bind(':fee',$fee);
$database->bind(':total',$total);
$database->bind(':years',$years);
$database->bind(':month',$month);
$database->bind(':comm_after',$comm_after);
$database->bind(':sac',$sac);
$database->bind(':date',$closer_date);
$database->bind(':deal_id',$deal_id);
$database->execute(); 
            
            
            }
            
            
            /*   PART 4 */
            
            $database->query("SELECT deal_id FROM dealsheet_prt4 WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
                $database->query("UPDATE dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time WHERE deal_id=:deal_id");    
                $database->bind(':exist_pol',$MORTGAGE_TYPE);
                $database->bind(':pol_num_1',$MORTGAGE_REASON);
                $database->bind(':pol_num_1_pre',$MORTGAGE_DATE);
                $database->bind(':pol_num_1_com',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();     
                
                
            }
            
            else {
            
                $database->query("INSERT dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time, deal_id=:deal_id");    
                $database->bind(':exist_pol',$MORTGAGE_TYPE);
                $database->bind(':pol_num_1',$MORTGAGE_REASON);
                $database->bind(':pol_num_1_pre',$MORTGAGE_DATE);
                $database->bind(':pol_num_1_com',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();    
            
            }            
   
            
            $lastid =  $database->lastInsertId();
            
            $database->endTransaction();
        
            header('Location: ../LifeDealSheet.php?query=CloserDealSheets&RESULT='.$deal_id); die;
        
    }
    
    if($dealsheet=='CLOSER') {
        
    $deal_id= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);
        
    $exist_pol= filter_input(INPUT_POST, 'exist_pol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $closer_date= filter_input(INPUT_POST, 'closer_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fee= filter_input(INPUT_POST, 'fee', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total= filter_input(INPUT_POST, 'total', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $years= filter_input(INPUT_POST, 'years', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $month= filter_input(INPUT_POST, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comm_after= filter_input(INPUT_POST, 'comm_after', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sac= filter_input(INPUT_POST, 'sac', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $chk_post= filter_input(INPUT_POST, 'chk_postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_dob= filter_input(INPUT_POST, 'chk_dob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_mob= filter_input(INPUT_POST, 'chk_mob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_home= filter_input(INPUT_POST, 'chk_home', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_email= filter_input(INPUT_POST, 'chk_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $pol_1_num= filter_input(INPUT_POST, 'pol_1_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_pre= filter_input(INPUT_POST, 'pol_1_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_com= filter_input(INPUT_POST, 'pol_1_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_cov= filter_input(INPUT_POST, 'pol_1_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_yr= filter_input(INPUT_POST, 'pol_1_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_type= filter_input(INPUT_POST, 'pol_1_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_soj= filter_input(INPUT_POST, 'pol_1_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_2_num= filter_input(INPUT_POST, 'pol_2_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_pre= filter_input(INPUT_POST, 'pol_2_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_com= filter_input(INPUT_POST, 'pol_2_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_cov= filter_input(INPUT_POST, 'pol_2_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_yr= filter_input(INPUT_POST, 'pol_2_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_type= filter_input(INPUT_POST, 'pol_2_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_soj= filter_input(INPUT_POST, 'pol_2_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_3_num= filter_input(INPUT_POST, 'pol_3_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_pre= filter_input(INPUT_POST, 'pol_3_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_com= filter_input(INPUT_POST, 'pol_3_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_cov= filter_input(INPUT_POST, 'pol_3_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_yr= filter_input(INPUT_POST, 'pol_3_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_type= filter_input(INPUT_POST, 'pol_3_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_soj= filter_input(INPUT_POST, 'pol_3_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_4_num= filter_input(INPUT_POST, 'pol_4_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_pre= filter_input(INPUT_POST, 'pol_4_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_com= filter_input(INPUT_POST, 'pol_4_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_cov= filter_input(INPUT_POST, 'pol_4_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_yr= filter_input(INPUT_POST, 'pol_4_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_type= filter_input(INPUT_POST, 'pol_4_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_soj= filter_input(INPUT_POST, 'pol_4_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);    
    
    if($closer=='CLOSER CALLBACK') {
        
        $CLOSER_STATUS='CALLBACK';
        
    }
    
    else {
       
        $CLOSER_STATUS='QA';
        
    }
    
     $database = new Database(); 
        $database->beginTransaction();
            
            $database->query("UPDATE dealsheet_prt1 set status=:qa, agent=:agent, closer=:closer, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email WHERE deal_id=:deal_id");
            $database->bind(':qa',$CLOSER_STATUS);
            $database->bind(':deal_id',$deal_id);
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);
            $database->execute(); 
            
            $database->query("UPDATE dealsheet_prt2 set deal_id=:deal_id, q1a=:q1a, q1b=:q1b, q1c=:q1c, q1d=:q1d, q2a=:q2a, q3a=:q3a, q4a=:q4a, q4b=:q4b, q4c=:q4c, q4d=:q4d, q4e=:q4e, q5a=:q5a, q6a=:q6a, q6b=:q6b, q7a=:q7a, comments=:comments, callback=:callback WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->bind(':q1a',$q1a);
            $database->bind(':q1b',$q1b);
            $database->bind(':q1c',$q1c);
            $database->bind(':q1d',$q1d);
            $database->bind(':q2a',$q2a);
            $database->bind(':q3a',$q3a);
            $database->bind(':q4a',$q4a);
            $database->bind(':q4b',$q4b);
            $database->bind(':q4c',$q4c);
            $database->bind(':q4d',$q4d);
            $database->bind(':q4e',$q4e);
            $database->bind(':q5a',$q5a);
            $database->bind(':q6a',$q6a);
            $database->bind(':q6b',$q6b);
            $database->bind(':q7a',$q7a);
            $database->bind(':comments',$comments);
            $database->bind(':callback',$callback);
            $database->execute(); 
            
            
            $database->query("SELECT deal_id FROM dealsheet_prt3 WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
                        $database->query("UPDATE dealsheet_prt3 set exist_pol=:exist_pol,
pol_num_1=:pol_num_1,
pol_num_1_pre=:pol_num_1_pre,
pol_num_1_com=:pol_num_1_com,
pol_num_1_cov=:pol_num_1_cov,
pol_num_1_yr=:pol_num_1_yr,
pol_num_1_type=:pol_num_1_type,
pol_num_1_soj=:pol_num_1_soj,
pol_num_2=:pol_num_2,
pol_num_2_pre=:pol_num_2_pre,
pol_num_2_com=:pol_num_2_com,
pol_num_2_cov=:pol_num_2_cov,
pol_num_2_yr=:pol_num_2_yr,
pol_num_2_type=:pol_num_2_type,
pol_num_2_soj=:pol_num_2_soj,
pol_num_3=:pol_num_3,
pol_num_3_pre=:pol_num_3_pre,
pol_num_3_com=:pol_num_3_com,
pol_num_3_cov=:pol_num_3_cov,
pol_num_3_yr=:pol_num_3_yr,
pol_num_3_type=:pol_num_3_type,
pol_num_3_soj=:pol_num_3_soj,
pol_num_4=:pol_num_4,
pol_num_4_pre=:pol_num_4_pre,
pol_num_4_com=:pol_num_4_com,
pol_num_4_cov=:pol_num_4_cov,
pol_num_4_yr=:pol_num_4_yr,
pol_num_4_type=:pol_num_4_type,
pol_num_4_soj=:pol_num_4_soj,
chk_post=:chk_post,
chk_dob=:chk_dob,
chk_mob=:chk_mob,
chk_home=:chk_home,
chk_email=:chk_email,
fee=:fee,
total=:total,
years=:years,
month=:month,
comm_after=:comm_after,
sac=:sac,
date=:date
WHERE deal_id=:deal_id");
            
$database->bind(':exist_pol',$exist_pol);
$database->bind(':pol_num_1',$pol_1_num);
$database->bind(':pol_num_1_pre',$pol_1_pre);
$database->bind(':pol_num_1_com',$pol_1_com);
$database->bind(':pol_num_1_cov',$pol_1_cov);
$database->bind(':pol_num_1_yr',$pol_1_yr);
$database->bind(':pol_num_1_type',$pol_1_type);
$database->bind(':pol_num_1_soj',$pol_1_soj);
$database->bind(':pol_num_2',$pol_2_num);
$database->bind(':pol_num_2_pre',$pol_2_pre);
$database->bind(':pol_num_2_com',$pol_2_com);
$database->bind(':pol_num_2_cov',$pol_2_cov);
$database->bind(':pol_num_2_yr',$pol_2_yr);
$database->bind(':pol_num_2_type',$pol_2_type);
$database->bind(':pol_num_2_soj',$pol_2_soj);
$database->bind(':pol_num_3',$pol_3_num);
$database->bind(':pol_num_3_pre',$pol_3_pre);
$database->bind(':pol_num_3_com',$pol_3_com);
$database->bind(':pol_num_3_cov',$pol_3_cov);
$database->bind(':pol_num_3_yr',$pol_3_yr);
$database->bind(':pol_num_3_type',$pol_3_type);
$database->bind(':pol_num_3_soj',$pol_3_soj);
$database->bind(':pol_num_4',$pol_4_num);
$database->bind(':pol_num_4_pre',$pol_4_pre);
$database->bind(':pol_num_4_com',$pol_4_com);
$database->bind(':pol_num_4_cov',$pol_4_cov);
$database->bind(':pol_num_4_yr',$pol_4_yr);
$database->bind(':pol_num_4_type',$pol_4_type);
$database->bind(':pol_num_4_soj',$pol_4_soj);
$database->bind(':chk_post',$chk_post);
$database->bind(':chk_dob',$chk_dob);
$database->bind(':chk_mob',$chk_mob);
$database->bind(':chk_home',$chk_home);
$database->bind(':chk_email',$chk_email);
$database->bind(':fee',$fee);
$database->bind(':total',$total);
$database->bind(':years',$years);
$database->bind(':month',$month);
$database->bind(':comm_after',$comm_after);
$database->bind(':sac',$sac);
$database->bind(':date',$closer_date);
$database->bind(':deal_id',$deal_id);
$database->execute();     
                
                
            }
            
            else {
            
            $database->query("INSERT dealsheet_prt3 set exist_pol=:exist_pol,
pol_num_1=:pol_num_1,
pol_num_1_pre=:pol_num_1_pre,
pol_num_1_com=:pol_num_1_com,
pol_num_1_cov=:pol_num_1_cov,
pol_num_1_yr=:pol_num_1_yr,
pol_num_1_type=:pol_num_1_type,
pol_num_1_soj=:pol_num_1_soj,
pol_num_2=:pol_num_2,
pol_num_2_pre=:pol_num_2_pre,
pol_num_2_com=:pol_num_2_com,
pol_num_2_cov=:pol_num_2_cov,
pol_num_2_yr=:pol_num_2_yr,
pol_num_2_type=:pol_num_2_type,
pol_num_2_soj=:pol_num_2_soj,
pol_num_3=:pol_num_3,
pol_num_3_pre=:pol_num_3_pre,
pol_num_3_com=:pol_num_3_com,
pol_num_3_cov=:pol_num_3_cov,
pol_num_3_yr=:pol_num_3_yr,
pol_num_3_type=:pol_num_3_type,
pol_num_3_soj=:pol_num_3_soj,
pol_num_4=:pol_num_4,
pol_num_4_pre=:pol_num_4_pre,
pol_num_4_com=:pol_num_4_com,
pol_num_4_cov=:pol_num_4_cov,
pol_num_4_yr=:pol_num_4_yr,
pol_num_4_type=:pol_num_4_type,
pol_num_4_soj=:pol_num_4_soj,
chk_post=:chk_post,
chk_dob=:chk_dob,
chk_mob=:chk_mob,
chk_home=:chk_home,
chk_email=:chk_email,
fee=:fee,
total=:total,
years=:years,
month=:month,
comm_after=:comm_after,
sac=:sac,
date=:date,
deal_id=:deal_id");
            
$database->bind(':exist_pol',$exist_pol);
$database->bind(':pol_num_1',$pol_1_num);
$database->bind(':pol_num_1_pre',$pol_1_pre);
$database->bind(':pol_num_1_com',$pol_1_com);
$database->bind(':pol_num_1_cov',$pol_1_cov);
$database->bind(':pol_num_1_yr',$pol_1_yr);
$database->bind(':pol_num_1_type',$pol_1_type);
$database->bind(':pol_num_1_soj',$pol_1_soj);
$database->bind(':pol_num_2',$pol_2_num);
$database->bind(':pol_num_2_pre',$pol_2_pre);
$database->bind(':pol_num_2_com',$pol_2_com);
$database->bind(':pol_num_2_cov',$pol_2_cov);
$database->bind(':pol_num_2_yr',$pol_2_yr);
$database->bind(':pol_num_2_type',$pol_2_type);
$database->bind(':pol_num_2_soj',$pol_2_soj);
$database->bind(':pol_num_3',$pol_3_num);
$database->bind(':pol_num_3_pre',$pol_3_pre);
$database->bind(':pol_num_3_com',$pol_3_com);
$database->bind(':pol_num_3_cov',$pol_3_cov);
$database->bind(':pol_num_3_yr',$pol_3_yr);
$database->bind(':pol_num_3_type',$pol_3_type);
$database->bind(':pol_num_3_soj',$pol_3_soj);
$database->bind(':pol_num_4',$pol_4_num);
$database->bind(':pol_num_4_pre',$pol_4_pre);
$database->bind(':pol_num_4_com',$pol_4_com);
$database->bind(':pol_num_4_cov',$pol_4_cov);
$database->bind(':pol_num_4_yr',$pol_4_yr);
$database->bind(':pol_num_4_type',$pol_4_type);
$database->bind(':pol_num_4_soj',$pol_4_soj);
$database->bind(':chk_post',$chk_post);
$database->bind(':chk_dob',$chk_dob);
$database->bind(':chk_mob',$chk_mob);
$database->bind(':chk_home',$chk_home);
$database->bind(':chk_email',$chk_email);
$database->bind(':fee',$fee);
$database->bind(':total',$total);
$database->bind(':years',$years);
$database->bind(':month',$month);
$database->bind(':comm_after',$comm_after);
$database->bind(':sac',$sac);
$database->bind(':date',$closer_date);
$database->bind(':deal_id',$deal_id);
$database->execute(); 
            
            
            }
            
 /*   PART 4 */
            
            $database->query("SELECT deal_id FROM dealsheet_prt4 WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
                $database->query("UPDATE dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time WHERE deal_id=:deal_id");    
                $database->bind(':type',$MORTGAGE_TYPE);
                $database->bind(':reason',$MORTGAGE_REASON);
                $database->bind(':date',$MORTGAGE_DATE);
                $database->bind(':time',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();     
                
                
            }
            
            else {
            
                $database->query("INSERT dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time, deal_id=:deal_id");    
                $database->bind(':type',$MORTGAGE_TYPE);
                $database->bind(':reason',$MORTGAGE_REASON);
                $database->bind(':date',$MORTGAGE_DATE);
                $database->bind(':time',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();    
            
            }                
   
            
            $lastid =  $database->lastInsertId();
            
            $database->endTransaction();
        
            header('Location: ../LifeDealSheet.php?query=CloserDealSheets&RESULT='.$deal_id); die;
        
    }
    
    if($dealsheet=='CALLBACK') {
        
    }
    
    if($dealsheet=='QA') {
        
    $deal_id= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);
        
    $exist_pol= filter_input(INPUT_POST, 'exist_pol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $closer_date= filter_input(INPUT_POST, 'closer_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fee= filter_input(INPUT_POST, 'fee', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total= filter_input(INPUT_POST, 'total', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $years= filter_input(INPUT_POST, 'years', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $month= filter_input(INPUT_POST, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comm_after= filter_input(INPUT_POST, 'comm_after', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sac= filter_input(INPUT_POST, 'sac', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $chk_post= filter_input(INPUT_POST, 'chk_postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_dob= filter_input(INPUT_POST, 'chk_dob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_mob= filter_input(INPUT_POST, 'chk_mob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_home= filter_input(INPUT_POST, 'chk_home', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $chk_email= filter_input(INPUT_POST, 'chk_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $pol_1_num= filter_input(INPUT_POST, 'pol_1_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_pre= filter_input(INPUT_POST, 'pol_1_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_com= filter_input(INPUT_POST, 'pol_1_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_cov= filter_input(INPUT_POST, 'pol_1_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_yr= filter_input(INPUT_POST, 'pol_1_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_type= filter_input(INPUT_POST, 'pol_1_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_soj= filter_input(INPUT_POST, 'pol_1_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_2_num= filter_input(INPUT_POST, 'pol_2_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_pre= filter_input(INPUT_POST, 'pol_2_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_com= filter_input(INPUT_POST, 'pol_2_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_cov= filter_input(INPUT_POST, 'pol_2_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_yr= filter_input(INPUT_POST, 'pol_2_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_type= filter_input(INPUT_POST, 'pol_2_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_soj= filter_input(INPUT_POST, 'pol_2_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_3_num= filter_input(INPUT_POST, 'pol_3_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_pre= filter_input(INPUT_POST, 'pol_3_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_com= filter_input(INPUT_POST, 'pol_3_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_cov= filter_input(INPUT_POST, 'pol_3_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_yr= filter_input(INPUT_POST, 'pol_3_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_type= filter_input(INPUT_POST, 'pol_3_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_soj= filter_input(INPUT_POST, 'pol_3_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_4_num= filter_input(INPUT_POST, 'pol_4_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_pre= filter_input(INPUT_POST, 'pol_4_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_com= filter_input(INPUT_POST, 'pol_4_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_cov= filter_input(INPUT_POST, 'pol_4_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_yr= filter_input(INPUT_POST, 'pol_4_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_type= filter_input(INPUT_POST, 'pol_4_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_soj= filter_input(INPUT_POST, 'pol_4_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);    
    
    
     $database = new Database(); 
        $database->beginTransaction();
            
            $database->query("UPDATE dealsheet_prt1 set status='COMPLETE', agent=:agent, closer=:closer, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);
            $database->execute(); 
            
            $database->query("UPDATE dealsheet_prt2 set deal_id=:deal_id, q1a=:q1a, q1b=:q1b, q1c=:q1c, q1d=:q1d, q2a=:q2a, q3a=:q3a, q4a=:q4a, q4b=:q4b, q4c=:q4c, q4d=:q4d, q4e=:q4e, q5a=:q5a, q6a=:q6a, q6b=:q6b, q7a=:q7a, comments=:comments, callback=:callback WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->bind(':q1a',$q1a);
            $database->bind(':q1b',$q1b);
            $database->bind(':q1c',$q1c);
            $database->bind(':q1d',$q1d);
            $database->bind(':q2a',$q2a);
            $database->bind(':q3a',$q3a);
            $database->bind(':q4a',$q4a);
            $database->bind(':q4b',$q4b);
            $database->bind(':q4c',$q4c);
            $database->bind(':q4d',$q4d);
            $database->bind(':q4e',$q4e);
            $database->bind(':q5a',$q5a);
            $database->bind(':q6a',$q6a);
            $database->bind(':q6b',$q6b);
            $database->bind(':q7a',$q7a);
            $database->bind(':comments',$comments);
            $database->bind(':callback',$callback);
            $database->execute(); 
            
                 
                        $database->query("UPDATE dealsheet_prt3 set exist_pol=:exist_pol,
pol_num_1=:pol_num_1,
pol_num_1_pre=:pol_num_1_pre,
pol_num_1_com=:pol_num_1_com,
pol_num_1_cov=:pol_num_1_cov,
pol_num_1_yr=:pol_num_1_yr,
pol_num_1_type=:pol_num_1_type,
pol_num_1_soj=:pol_num_1_soj,
pol_num_2=:pol_num_2,
pol_num_2_pre=:pol_num_2_pre,
pol_num_2_com=:pol_num_2_com,
pol_num_2_cov=:pol_num_2_cov,
pol_num_2_yr=:pol_num_2_yr,
pol_num_2_type=:pol_num_2_type,
pol_num_2_soj=:pol_num_2_soj,
pol_num_3=:pol_num_3,
pol_num_3_pre=:pol_num_3_pre,
pol_num_3_com=:pol_num_3_com,
pol_num_3_cov=:pol_num_3_cov,
pol_num_3_yr=:pol_num_3_yr,
pol_num_3_type=:pol_num_3_type,
pol_num_3_soj=:pol_num_3_soj,
pol_num_4=:pol_num_4,
pol_num_4_pre=:pol_num_4_pre,
pol_num_4_com=:pol_num_4_com,
pol_num_4_cov=:pol_num_4_cov,
pol_num_4_yr=:pol_num_4_yr,
pol_num_4_type=:pol_num_4_type,
pol_num_4_soj=:pol_num_4_soj,
chk_post=:chk_post,
chk_dob=:chk_dob,
chk_mob=:chk_mob,
chk_home=:chk_home,
chk_email=:chk_email,
fee=:fee,
total=:total,
years=:years,
month=:month,
comm_after=:comm_after,
sac=:sac,
date=:date
WHERE deal_id=:deal_id");
            
$database->bind(':exist_pol',$exist_pol);
$database->bind(':pol_num_1',$pol_1_num);
$database->bind(':pol_num_1_pre',$pol_1_pre);
$database->bind(':pol_num_1_com',$pol_1_com);
$database->bind(':pol_num_1_cov',$pol_1_cov);
$database->bind(':pol_num_1_yr',$pol_1_yr);
$database->bind(':pol_num_1_type',$pol_1_type);
$database->bind(':pol_num_1_soj',$pol_1_soj);
$database->bind(':pol_num_2',$pol_2_num);
$database->bind(':pol_num_2_pre',$pol_2_pre);
$database->bind(':pol_num_2_com',$pol_2_com);
$database->bind(':pol_num_2_cov',$pol_2_cov);
$database->bind(':pol_num_2_yr',$pol_2_yr);
$database->bind(':pol_num_2_type',$pol_2_type);
$database->bind(':pol_num_2_soj',$pol_2_soj);
$database->bind(':pol_num_3',$pol_3_num);
$database->bind(':pol_num_3_pre',$pol_3_pre);
$database->bind(':pol_num_3_com',$pol_3_com);
$database->bind(':pol_num_3_cov',$pol_3_cov);
$database->bind(':pol_num_3_yr',$pol_3_yr);
$database->bind(':pol_num_3_type',$pol_3_type);
$database->bind(':pol_num_3_soj',$pol_3_soj);
$database->bind(':pol_num_4',$pol_4_num);
$database->bind(':pol_num_4_pre',$pol_4_pre);
$database->bind(':pol_num_4_com',$pol_4_com);
$database->bind(':pol_num_4_cov',$pol_4_cov);
$database->bind(':pol_num_4_yr',$pol_4_yr);
$database->bind(':pol_num_4_type',$pol_4_type);
$database->bind(':pol_num_4_soj',$pol_4_soj);
$database->bind(':chk_post',$chk_post);
$database->bind(':chk_dob',$chk_dob);
$database->bind(':chk_mob',$chk_mob);
$database->bind(':chk_home',$chk_home);
$database->bind(':chk_email',$chk_email);
$database->bind(':fee',$fee);
$database->bind(':total',$total);
$database->bind(':years',$years);
$database->bind(':month',$month);
$database->bind(':comm_after',$comm_after);
$database->bind(':sac',$sac);
$database->bind(':date',$closer_date);
$database->bind(':deal_id',$deal_id);
$database->execute();     

 /*   PART 4 */
            
            $database->query("SELECT deal_id FROM dealsheet_prt4 WHERE deal_id=:deal_id");
            $database->bind(':deal_id',$deal_id);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
                $database->query("UPDATE dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time WHERE deal_id=:deal_id");    
                $database->bind(':type',$MORTGAGE_TYPE);
                $database->bind(':reason',$MORTGAGE_REASON);
                $database->bind(':date',$MORTGAGE_DATE);
                $database->bind(':time',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();     
                
                
            }
            
            else {
            
                $database->query("INSERT dealsheet_prt4 SET type=:type, reason=:reason, cb_date=:date, cb_time=:time, deal_id=:deal_id");    
                $database->bind(':type',$MORTGAGE_TYPE);
                $database->bind(':reason',$MORTGAGE_REASON);
                $database->bind(':date',$MORTGAGE_DATE);
                $database->bind(':time',$MORTGAGE_TIME);
                $database->bind(':deal_id',$deal_id);
                $database->execute();    
            
            }    
            
            $lastid =  $database->lastInsertId();
            
            $database->endTransaction();
        
            header('Location: ../LifeDealSheet.php?query=QADealSheets&RESULT='.$deal_id); die;
        
    }

    
if (in_array($hello_name,$Agent_Access, true)) {
    
    
    
}

if (in_array($hello_name,$Closer_Access, true)) {
    
    
    
}


if($dealsheet=='ADL') {

$database = new Database(); 
        $database->beginTransaction();
        
        if($pol_1_soj=='S') {
            $soj="Single";
        $client_name="$title $first_name $lastname";
        } elseif($pol_1_soj=='J') {
            $soj="Joint";
         $client_name="$title $first_name $lastname and $title2 $first_name2 $lastname2";   
        } else {
            $soj="Single";
         $client_name="$title $first_name $lastname";   
        }
            
            $database->query("INSERT INTO client_details set dealsheet_id=:dealid, title=:title, forename=:forename, surname=:surname, dob=:dob, title2=:title2, forename2=:forename2, surname2=:surname2, dob2=:dob2, postcode=:postcode, mobile=:mobile, home=:home, email=:email");
            $database->bind(':deal_id',$deal_id);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':postcode',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);
            $database->execute();
            $lastid =  $database->lastInsertId();
            
            $database->query("INSERT INTO client_policy set policystatus='NEW ADL', lead=:agent, closer=:closer, client_name=:clientname, client_id=:id, submitted_by=:hello, soj=:soj, premium=:premium, commission=:comm, covera=:cover, polterm=:polterm, type=:type ");
            $database->bind(':id',$lastid);
            $database->bind(':clientname',$client_name);
            $database->bind(':agent',$agent);
            $database->bind(':closer',$closer);
            $database->bind(':hello',$hello_name);
            $database->bind(':soj',$soj);
            $database->bind(':premium',$pol_num_1_pre);
            $database->bind(':comm',$pol_1_com);
            $database->bind(':cover',$pol_1_cov);
            $database->bind(':polterm',$pol_1_yr);
            $database->bind(':type',$pol_1_type);
            $database->execute(); 

            
            $database->endTransaction();
        
            header('Location: ../LifeDealSheet.php?query=ADL&RESULT='.$deal_id); die;
    
}

}
?>