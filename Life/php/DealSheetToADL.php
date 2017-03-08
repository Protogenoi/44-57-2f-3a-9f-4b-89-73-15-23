<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($ffdealsheets) && $ffdealsheets=='0') {
     header('Location: ../../CRMmain.php?Feature=NotEnabled'); die;
}

include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;
}

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$QRY= filter_input(INPUT_GET, 'QRY', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($QRY)) {
    $deal_id= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);
    $custtype= filter_input(INPUT_POST, 'custtype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    include('../../classes/database_class.php');
    include('../../includes/ADL_PDO_CON.php'); 
    if($QRY=='upload') {
        
        $database = new Database(); 
        
        //UPDATE
    
    $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $forename= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $surname= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $dob_day= filter_input(INPUT_POST, 'dob_day', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_month= filter_input(INPUT_POST, 'dob_month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_year= filter_input(INPUT_POST, 'dob_year', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    
    $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $forename2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $surname2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $dob_day2= filter_input(INPUT_POST, 'dob_day2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_month2= filter_input(INPUT_POST, 'dob_month2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dob_year2= filter_input(INPUT_POST, 'dob_year2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   
    $mobile= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $home= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $postcode= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);      

    $sale_date= filter_input(INPUT_POST, 'sale_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $insurer= filter_input(INPUT_POST, 'insurer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $agent= filter_input(INPUT_POST, 'agent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_1_an= filter_input(INPUT_POST, 'pol_1_an', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_num= filter_input(INPUT_POST, 'pol_num_1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    echo "company $pol_1_num";
    
    $pol_1_pre= filter_input(INPUT_POST, 'pol_num_1_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_com= filter_input(INPUT_POST, 'pol_num_1_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_cov= filter_input(INPUT_POST, 'pol_num_1_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_yr= filter_input(INPUT_POST, 'pol_num_1_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_type= filter_input(INPUT_POST, 'pol_num_1_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_soj= filter_input(INPUT_POST, 'pol_num_1_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_drip= filter_input(INPUT_POST, 'pol_num_1_drip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_CommissionType= filter_input(INPUT_POST, 'pol_num_1_CommissionType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_1_comm_term= filter_input(INPUT_POST, 'pol_num_1_comm_term', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_1_pol_status= filter_input(INPUT_POST, 'pol_num_1_pol_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_1_client_name= filter_input(INPUT_POST, 'pol_1_client_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_2_an= filter_input(INPUT_POST, 'pol_2_an', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_num= filter_input(INPUT_POST, 'pol_num_2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_pre= filter_input(INPUT_POST, 'pol_num_2_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_com= filter_input(INPUT_POST, 'pol_num_2_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_cov= filter_input(INPUT_POST, 'pol_num_2_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_yr= filter_input(INPUT_POST, 'pol_num_2_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_type= filter_input(INPUT_POST, 'pol_num_2_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_soj= filter_input(INPUT_POST, 'pol_num_2_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_drip= filter_input(INPUT_POST, 'pol_num_2_drip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_CommissionType= filter_input(INPUT_POST, 'pol_num_2_CommissionType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_2_comm_term= filter_input(INPUT_POST, 'pol_num_2_comm_term', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_2_pol_status= filter_input(INPUT_POST, 'pol_num_2_pol_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_2_client_name= filter_input(INPUT_POST, 'pol_2_client_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_3_an= filter_input(INPUT_POST, 'pol_3_an', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_num= filter_input(INPUT_POST, 'pol_num_3', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_pre= filter_input(INPUT_POST, 'pol_num_3_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_com= filter_input(INPUT_POST, 'pol_num_3_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_cov= filter_input(INPUT_POST, 'pol_num_3_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_yr= filter_input(INPUT_POST, 'pol_num_3_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_type= filter_input(INPUT_POST, 'pol_num_3_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_soj= filter_input(INPUT_POST, 'pol_num_3_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_drip= filter_input(INPUT_POST, 'pol_num_3_drip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_CommissionType= filter_input(INPUT_POST, 'pol_num_3_CommissionType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_3_comm_term= filter_input(INPUT_POST, 'pol_num_3_comm_term', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_3_pol_status= filter_input(INPUT_POST, 'pol_num_3_pol_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_3_client_name= filter_input(INPUT_POST, 'pol_3_client_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $pol_4_an= filter_input(INPUT_POST, 'pol_4_an', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_num= filter_input(INPUT_POST, 'pol_num_4', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_pre= filter_input(INPUT_POST, 'pol_num_4_pre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_com= filter_input(INPUT_POST, 'pol_num_4_com', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_cov= filter_input(INPUT_POST, 'pol_num_4_cov', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_yr= filter_input(INPUT_POST, 'pol_num_4_yr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_type= filter_input(INPUT_POST, 'pol_num_4_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_soj= filter_input(INPUT_POST, 'pol_num_4_soj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_drip= filter_input(INPUT_POST, 'pol_num_4_drip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_CommissionType= filter_input(INPUT_POST, 'pol_num_4_CommissionType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_4_comm_term= filter_input(INPUT_POST, 'pol_num_4_comm_term', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_num_4_pol_status= filter_input(INPUT_POST, 'pol_num_4_pol_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pol_4_client_name= filter_input(INPUT_POST, 'pol_4_client_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $DEAL_STATUS='SENT TO ADL';  
    
    $database->beginTransaction();
            
            $database->query("INSERT INTO client_details set title=:title, first_name=:forename, last_name=:surname, dob=:dob, email=:email, title2=:title2, first_name2=:forename2, last_name2=:surname2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, company=:company, dealsheet_id=:dealid, phone_number=:mobile, alt_number=:home");
            $database->bind(':dealid',$deal_id);
            $database->bind(':title',$title);
            $database->bind(':forename',$forename);
            $database->bind(':surname',$surname);
            $database->bind(':dob',$dob);
            $database->bind(':title2',$title2);
            $database->bind(':forename2',$forename2);
            $database->bind(':surname2',$surname2);
            $database->bind(':dob2',$dob2);
            $database->bind(':post',$postcode);
            $database->bind(':mobile',$mobile);
            $database->bind(':home',$home);
            $database->bind(':email',$email);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$address1);
            $database->bind(':add2',$address2);
            $database->bind(':add3',$address3);
            $database->bind(':town',$town);
            $database->bind(':hello',$hello_name);
            $database->bind(':company',$custtype);
            $database->execute();    
            $lastid =  $database->lastInsertId();
            
            $database->query("UPDATE dealsheet_prt1 set status=:qa WHERE deal_id=:dealid");
            $database->bind(':qa',$DEAL_STATUS);
            $database->bind(':dealid',$deal_id);
            $database->execute();
            
            if($custtype=='Life' || $custtype=='The Review Bureau' || $custtype=='Assura' || $custtype=='TRB Vitality') {
                
                $notedata= "Client Added";
                $custtypenamedata= $title ." ". $forename ." ". $surname;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
                $database->bind(':CID',$lastid);
                $database->bind(':sent',$hello_name);
                $database->bind(':recipient',$custtypenamedata);
                $database->bind(':note',$notedata);
                $database->bind(':message',$messagedata);
                $database->execute();
                
                $weekarray=array('Mon','Tue','Wed','Thu','Fri');
                $today=date("D"); // check Day Mon - Sun
                $date=date("Y-m-d",strtotime($today)); // Convert day to date
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='CYD'");
                $database->execute();
                $assignCYDd=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='24 48'");
                $database->execute();
                $assign24d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='5 day'");
                $database->execute();
                $assign5d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
                $database->execute();
                $assign18d=$database->single();
                
                $assignCYD=$assignCYDd['Assigned'];
                $assign24=$assign24d['Assigned'];
                $assign5=$assign5d['Assigned'];
                $assign18=$assign18d['Assigned'];
                
                $taskCYD="CYD";
                $next = date("D", strtotime("+91 day")); // Add 2 to Day
                
                if($next =="Sat") { //Check if Weekend
                $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+93 day")); //Add extra 2 Days if Sat Weekend
                $deadlineCYD=$SkipWeekEndDayCYD;
                
                }
                
                if($next=="Sun") {
                    $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+92 day"));
                    $deadlineCYD=$SkipWeekEndDayCYD;
                    
                }
                
                if (in_array($next,$weekarray,true)){
                    $WeekDayCYD = date("Y-m-d", strtotime("+91 day"));
                    $deadlineCYD=$WeekDayCYD;
                    
                } 
                
                $date_added= date("Y-m-d H:i:s");
                $task24="24 48";
                
                $next24 = date("D", strtotime("+2 day")); 
                if($next24 =="Sat") { 
                    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+4 day")); 
                    $deadline24=$SkipWeekEndDay24;
                    
                }

if($next24=="Sun") { 

    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+3 day")); 

    $deadline24=$SkipWeekEndDay24;

}


if (in_array($next24,$weekarray,true)){

$WeekDay24 = date("Y-m-d", strtotime("+2 day"));

    $deadline24=$WeekDay24;

} 




$task5="5 day";


$next5 = date("D", strtotime("+5 day")); // Add 2 to Day

if($next5 =="Sat") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+7 day")); //Add extra 2 Days if Sat Weekend

    $deadline5=$SkipWeekEndDay5;

}

if($next5=="Sun") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+6 day")); //Add extra 1 day if Sunday

    $deadline5=$SkipWeekEndDay5;

}


if (in_array($next5,$weekarray,true)){

$WeekDay5 = date("Y-m-d", strtotime("+5 day"));

    $deadline5=$WeekDay5;

} 


$task18="18 day";


$next18 = date("D", strtotime("+18 day")); // Add 2 to Day

if($next18 =="Sat") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+20 day")); //Add extra 2 Days if Sat Weekend

    $deadline18=$SkipWeekEndDay18;

}

if($next18=="Sun") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+19 day")); //Add extra 1 day if Sunday

    $deadline18=$SkipWeekEndDay18;

}


if (in_array($next18,$weekarray,true)){

$WeekDay18 = date("Y-m-d", strtotime("+18 day"));

    $deadline18=$WeekDay18;

} 

        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assignCYD, PDO::PARAM_STR);
        $database->bind(':task', $taskCYD, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadlineCYD, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign24, PDO::PARAM_STR);
        $database->bind(':task', $task24, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline24, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign5, PDO::PARAM_STR);
        $database->bind(':task', $task5, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline5, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign18, PDO::PARAM_STR);
        $database->bind(':task', $task18, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline18, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute(); 
        
        $database->endTransaction(); 
} 

 if(isset($pol_1_num)) { 
            
$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$pol_1_num, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol_1="$row[policy_number] DUPE";        
        
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_1_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_1_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol_1, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_1_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_1_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_1_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_1_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_1_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_1_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_1_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_1_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_1_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_1_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy added $dupepol_1 duplicate of $pol_1_num";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$custtypenamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$lastid, PDO::PARAM_INT);
$client_type->execute(); 
  
 }  //END OF DUPE CHECK 
 
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_1_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_1_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$pol_1_num, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_1_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_1_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_1_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_1_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_1_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_1_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_1_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_1_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_1_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_1_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy $pol_1_num added";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$pol_1_client_name, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 
            
        }
        
        if(isset($pol_2_num)) { 

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$pol_2_num, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol_2="$row[policy_number] DUPE";        
        
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_2_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_2_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol_2, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_2_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_2_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_2_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_2_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_2_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_2_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_2_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_2_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_2_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_2_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy added $dupepol_2 duplicate of $pol_2_num";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$custtypenamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$lastid, PDO::PARAM_INT);
$client_type->execute(); 
  
 }  //END OF DUPE CHECK 
 
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_2_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_2_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$pol_2_num, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_2_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_2_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_2_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_2_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_2_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_2_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_2_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_2_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_2_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_2_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy $pol_2_num added";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$pol_2_client_name, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 
            
        }
        
        if(isset($pol_3_num)) { 
           
$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$pol_3_num, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol_3="$row[policy_number] DUPE";        
        
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_3_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_3_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol_3, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_3_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_3_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_3_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_3_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_3_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_3_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_3_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_3_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_3_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_3_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy added $dupepol_3 duplicate of $pol_3_num";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$custtypenamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$lastid, PDO::PARAM_INT);
$client_type->execute(); 
  
 }  //END OF DUPE CHECK 
 
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_3_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_3_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$pol_3_num, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_3_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_3_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_3_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_3_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_3_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_3_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_3_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_3_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_3_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_3_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy $pol_3_num added";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$pol_3_client_name, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute();             
            
        }
        
        if(isset($pol_4_num)) { 

$dupeck = $pdo->prepare("SELECT policy_number from client_policy where policy_number=:pol");
$dupeck->bindParam(':pol',$pol_4_num, PDO::PARAM_STR);
$dupeck->execute(); 
  $row=$dupeck->fetch(PDO::FETCH_ASSOC);
     if ($count = $dupeck->rowCount()>=1) {  
         $dupepol_4="$row[policy_number] DUPE";        
        
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_4_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_4_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$dupepol_4, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_4_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_4_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_4_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_4_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_4_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_4_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_4_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_4_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_4_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_4_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy added $dupepol_4 duplicate of $pol_4_num";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$custtypenamedata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 

$client_type = $pdo->prepare("UPDATE client_details set client_type='Life' WHERE client_id =:client_id");
$client_type->bindParam(':client_id',$lastid, PDO::PARAM_INT);
$client_type->execute(); 
  
 }  //END OF DUPE CHECK 
 
$insert = $pdo->prepare("INSERT INTO client_policy set submitted_date = CURDATE(), client_id=:cid, client_name=:name, sale_date=:sale, application_number=:an_num, policy_number=:policy, premium=:premium, type=:type, insurer=:insurer, submitted_by=:hello, commission=:commission, CommissionType=:CommissionType, PolicyStatus=:PolicyStatus, comm_term=:comm_term, drip=:drip, soj=:soj, closer=:closer, lead=:lead, covera=:covera, polterm=:polterm");
$insert->bindParam(':cid',$lastid, PDO::PARAM_STR);
$insert->bindParam(':name',$pol_4_client_name, PDO::PARAM_STR);
$insert->bindParam(':sale',$sale_date, PDO::PARAM_STR);
$insert->bindParam(':an_num',$pol_4_an, PDO::PARAM_STR);
$insert->bindParam(':policy',$pol_4_num, PDO::PARAM_STR);
$insert->bindParam(':premium',$pol_4_pre, PDO::PARAM_STR);
$insert->bindParam(':type',$pol_4_type, PDO::PARAM_STR);
$insert->bindParam(':insurer',$insurer, PDO::PARAM_STR);
$insert->bindParam(':hello',$hello_name, PDO::PARAM_STR);
$insert->bindParam(':commission',$pol_4_com, PDO::PARAM_STR);
$insert->bindParam(':CommissionType',$pol_4_CommissionType, PDO::PARAM_STR);
$insert->bindParam(':PolicyStatus',$pol_num_4_pol_status, PDO::PARAM_STR);
$insert->bindParam(':comm_term',$pol_num_4_comm_term, PDO::PARAM_STR);
$insert->bindParam(':drip',$pol_4_drip, PDO::PARAM_STR);
$insert->bindParam(':soj',$pol_4_soj, PDO::PARAM_STR);
$insert->bindParam(':closer',$closer, PDO::PARAM_STR);
$insert->bindParam(':lead',$agent, PDO::PARAM_STR);
$insert->bindParam(':covera',$pol_4_cov, PDO::PARAM_STR);
$insert->bindParam(':polterm',$pol_4_yr, PDO::PARAM_STR);
$insert->execute();     

$notedata= "Policy Added";
$messagedata="Policy $pol_4_num added";

$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipient, sent_by=:sent, note_type=:note, message=:message ");
$query->bindParam(':CID',$lastid, PDO::PARAM_INT);
$query->bindParam(':sent',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$pol_4_client_name, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute(); 
            
        }
        
        //RESELECT
 
        
      
        
if(isset($fferror)) {
    if($fferror=='0') {

        if(isset($pol_1_num) && ($pol_2_num) && ($pol_3_num) && ($pol_4_num)) {
         header('Location: ../ViewClient.php?policyadded=y&search='.$lastid.'&policy_1='.$pol_1_num.'&policy_2='.$pol_2_num.'&policy_3='.$pol_3_num.'&policy_4='.$pol_4_num); die;           
        }
        
                if(isset($pol_1_num) && ($pol_2_num) && ($pol_3_num)) {
        header('Location: ../ViewClient.php?policyadded=y&search='.$lastid.'&policy_1='.$pol_1_num.'&policy_2='.$pol_2_num.'&policy_3='.$pol_3_num); die;     
        }
        
                        if(isset($pol_1_num) && ($pol_2_num)) {
        header('Location: ../ViewClient.php?policyadded=y&search='.$lastid.'&policy_1='.$pol_1_num.'&policy_2='.$pol_2_num); die;    
        }
        
                        if(isset($pol_1_num) && ($pol_2_num) && ($pol_3_num)) {
         header('Location: ../ViewClient.php?policyadded=y&search='.$lastid.'&policy_1='.$pol_1_num); die;   
        }
        
header('Location: ViewClient.php?policyadded=y&search='.$lastid.'&policy_1='.$pol_1_num); die;
    }
}        
    }
}

if(!isset($QRY)) {
    header('Location: /CRMmain.php?AccessDenied'); die;
}
    
    ?>

