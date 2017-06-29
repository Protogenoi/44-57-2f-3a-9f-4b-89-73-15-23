<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/Access_Levels.php');

if (in_array($hello_name,$Level_10_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true)) {

            if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='Bluestone Protect';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='Assured Protect and Mortgages';
    }  
     if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
         $COMPANY=filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
     }
        
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    $HOL_REF= filter_input(INPUT_GET, 'HOL_REF', FILTER_SANITIZE_SPECIAL_CHARS);
    $REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
    include('../../classes/database_class.php');
    
    if($EXECUTE=='1') {
      
    $change= filter_input(INPUT_POST, 'change', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $start_date= filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS);    
    $position= filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);     
    $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstname= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname= filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS); 
    $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);

    $ni_num= filter_input(INPUT_POST, 'ni_num', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_provided= filter_input(INPUT_POST, 'id_provided', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_details= filter_input(INPUT_POST, 'id_details', FILTER_SANITIZE_SPECIAL_CHARS);

    $database = new Database();
    $database->beginTransaction();
    
    $database->query("UPDATE employee_details set company=:COMPANY, updated_by=:hello,  ni_num=:ni, id_provided=:pro, id_details=:details, position=:position, start_date=:start, title=:title, firstname=:firstname, lastname=:lastname, dob=:dob WHERE employee_id=:REF");
    $database->bind(':COMPANY',$COMPANY);
    $database->bind(':title',$title);
    $database->bind(':REF',$REF);
    $database->bind(':firstname',$firstname);
    $database->bind(':hello',$hello_name);
    $database->bind(':lastname',$lastname);
    $database->bind(':start',$start_date);
    $database->bind(':dob',$dob);  
    $database->bind(':position',$position);
    $database->bind(':ni',$ni_num);
    $database->bind(':pro',$id_provided);
    $database->bind(':details',$id_details);
    $database->execute(); 

 
    
    $mob= filter_input(INPUT_POST, 'mob', FILTER_SANITIZE_SPECIAL_CHARS);
    $tel= filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $add1= filter_input(INPUT_POST, 'add1', FILTER_SANITIZE_SPECIAL_CHARS);
    $add2= filter_input(INPUT_POST, 'add2', FILTER_SANITIZE_SPECIAL_CHARS);
    $add3= filter_input(INPUT_POST, 'add3', FILTER_SANITIZE_SPECIAL_CHARS);
    $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
    $postal= filter_input(INPUT_POST, 'postal', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $database->query("UPDATE employee_contact set mob=:mob, tel=:tel, email=:email, add1=:add1, add2=:add2, add3=:add3, town=:town, postal=:postal WHERE employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':mob',$mob);
            $database->bind(':tel',$tel);
            $database->bind(':email',$email);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':postal',$postal);           
            $database->execute();
            
            $contact_name= filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_num= filter_input(INPUT_POST, 'contact_num', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_relationship= filter_input(INPUT_POST, 'contact_relationship', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_address= filter_input(INPUT_POST, 'contact_address', FILTER_SANITIZE_SPECIAL_CHARS);
            $medical= filter_input(INPUT_POST, 'medical', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $database->query("UPDATE employee_emergency set contact_name=:name, contact_num=:num, contact_relationship=:real, contact_address=:add, medical=:medical WHERE employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':name',$contact_name);
            $database->bind(':num',$contact_num);
            $database->bind(':real',$contact_relationship);
            $database->bind(':add',$contact_address);
            $database->bind(':medical',$medical);         
            $database->execute(); 
            
            $changereason="Employee details updated ($change)";
            
            $database->query("INSERT INTO employee_timeline set note_type='Employee Edited', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            
           header('Location: ../ViewEmployee.php?RETURN=ClientEdit&REF='.$REF); die;
    
    }
    
    if($EXECUTE=='2') {
        
    $start_date= filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS);    
    $position= filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);     
    $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstname= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname= filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS); 
    $day= filter_input(INPUT_POST, 'day', FILTER_SANITIZE_SPECIAL_CHARS);
    $month= filter_input(INPUT_POST, 'month', FILTER_SANITIZE_SPECIAL_CHARS);
    $year= filter_input(INPUT_POST, 'year', FILTER_SANITIZE_SPECIAL_CHARS);
    $dob="$year-$month-$day";
    $ni_num= filter_input(INPUT_POST, 'ni_num', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_provided= filter_input(INPUT_POST, 'id_provided', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_details= filter_input(INPUT_POST, 'id_details', FILTER_SANITIZE_SPECIAL_CHARS);

    $database = new Database();
    $database->beginTransaction();
     
    $database->query("INSERT INTO employee_details set company=:COMPANY, added_by=:hello, added_date= CURDATE(), ni_num=:ni, id_provided=:pro, id_details=:details, position=:position, start_date=:start, title=:title, firstname=:firstname, lastname=:lastname, dob=:dob");
    $database->bind(':COMPANY',$COMPANY);
    $database->bind(':title',$title);
    $database->bind(':firstname',$firstname);
    $database->bind(':hello',$hello_name);
    $database->bind(':lastname',$lastname);
    $database->bind(':start',$start_date);
    $database->bind(':dob',$dob);  
    $database->bind(':position',$position);
    $database->bind(':ni',$ni_num);
    $database->bind(':pro',$id_provided);
    $database->bind(':details',$id_details);
    $database->execute(); 
    $lastid =  $database->lastInsertId();

    
    $mob= filter_input(INPUT_POST, 'mob', FILTER_SANITIZE_SPECIAL_CHARS);
    $tel= filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $add1= filter_input(INPUT_POST, 'add1', FILTER_SANITIZE_SPECIAL_CHARS);
    $add2= filter_input(INPUT_POST, 'add2', FILTER_SANITIZE_SPECIAL_CHARS);
    $add3= filter_input(INPUT_POST, 'add3', FILTER_SANITIZE_SPECIAL_CHARS);
    $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
    $postal= filter_input(INPUT_POST, 'postal', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $database->query("INSERT INTO employee_contact set mob=:mob, tel=:tel, email=:email, add1=:add1, add2=:add2, add3=:add3, town=:town, postal=:postal, employee_id=:REF");
            $database->bind(':REF',$lastid);
            $database->bind(':mob',$mob);
            $database->bind(':tel',$tel);
            $database->bind(':email',$email);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':postal',$postal);           
            $database->execute();
            
            $contact_name= filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_num= filter_input(INPUT_POST, 'contact_num', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_relationship= filter_input(INPUT_POST, 'contact_relationship', FILTER_SANITIZE_SPECIAL_CHARS);
            $contact_address= filter_input(INPUT_POST, 'contact_address', FILTER_SANITIZE_SPECIAL_CHARS);
            $medical= filter_input(INPUT_POST, 'medical', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $database->query("INSERT INTO employee_emergency set contact_name=:name, contact_num=:num, contact_relationship=:real, contact_address=:add, medical=:medical, employee_id=:REF");
            $database->bind(':REF',$lastid);
            $database->bind(':name',$contact_name);
            $database->bind(':num',$contact_num);
            $database->bind(':real',$contact_relationship);
            $database->bind(':add',$contact_address);
            $database->bind(':medical',$medical);         
            $database->execute(); 
            
            $database->query("INSERT INTO employee_timeline set note_type='Employee Added', message='Employee details added', added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$lastid);
            $database->bind(':hello',$hello_name);         
            $database->execute(); 
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=ClientAdded&REF='.$lastid); die;
    
    }
    
     if($EXECUTE=='3') {
      
    $change= filter_input(INPUT_POST, 'change', FILTER_SANITIZE_SPECIAL_CHARS);
    $finish_date= filter_input(INPUT_POST, 'finish_date', FILTER_SANITIZE_SPECIAL_CHARS);     

    $database = new Database();
    $database->beginTransaction();
    
    $database->query("UPDATE employee_details set updated_by=:hello, end_date=:end, employed='0' WHERE employee_id=:REF");
    $database->bind(':REF',$REF);
    $database->bind(':end',$finish_date);
    $database->bind(':hello',$hello_name);
    $database->execute();
    
    $changereason="$finish_date - Employee no longer working at the company ($change)";
            
            $database->query("INSERT INTO employee_timeline set note_type='Employee Left', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=ClientFired&REF='.$REF); die;
    
    }
    
         if($EXECUTE=='5') {

    $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);     

    $database = new Database();
    $database->beginTransaction();
    
    $change="Employee rehired ($notes)";
    
    $database->query("UPDATE employee_details set updated_by=:hello, employed='1' WHERE employee_id=:REF");
    $database->bind(':REF',$REF);
    $database->bind(':hello',$hello_name);
    $database->execute();
            
            $database->query("INSERT INTO employee_timeline set note_type='Note Added', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$change); 
            $database->execute(); 
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=ClientHired&REF='.$REF); die;
    
    }

         if($EXECUTE=='6') {

    $HOL_START= filter_input(INPUT_POST, 'HOL_START', FILTER_SANITIZE_SPECIAL_CHARS);    
    $HOL_END= filter_input(INPUT_POST, 'HOL_END', FILTER_SANITIZE_SPECIAL_CHARS);  
    $HOL_REASON= filter_input(INPUT_POST, 'HOL_REASON', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NAME= filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);

    $database = new Database();
    $database->beginTransaction();
    
            $database->query("SELECT hol_id from employee_holidays WHERE start between :start AND :end");
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->execute(); 
            
             if ($database->rowCount()>=1) {
                
            $database->endTransaction();
            
            header('Location: ../ViewEmployee.php?RETURN=ALREADYBOOKED&REF='.$REF.'&HOL_START='.$HOL_START.'&HOL_END='.$HOL_END.'&HOL_REASON='.$HOL_REASON.'#Menu5'); die;   
                
            }
            
$date1 = new DateTime($HOL_START);
$date2 = new DateTime($HOL_END);

$HOL_DAYS = $date2->diff($date1)->format("%a")+1; 

if($HOL_DAYS>1) {
    $DAYS="days";
}
else {
    $DAYS="day";
}

    $change="Days booked $HOL_START - $HOL_END ($HOL_DAYS $DAYS | $HOL_REASON)";
            
            $database->query("INSERT INTO employee_timeline set note_type='Holiday Booked', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$change);              
            $database->execute();



    $HOL_REASON_NAME="$NAME ($HOL_REASON)";        
            
            $database->query("INSERT INTO employee_holidays set days=:days, added_by=:who, start=:start, end=:end, title=:title, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':title',$HOL_REASON_NAME);
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->bind(':days',$HOL_DAYS);
            $database->bind(':who',$hello_name);
            $database->execute();             
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=HOLBOOKED&REF='.$REF); die;
    
    }  
    
         if($EXECUTE=='7') {

    $HOL_START= filter_input(INPUT_GET, 'HOL_START', FILTER_SANITIZE_SPECIAL_CHARS);    
    $HOL_END= filter_input(INPUT_GET, 'HOL_END', FILTER_SANITIZE_SPECIAL_CHARS);  
    $HOL_REASON= filter_input(INPUT_GET, 'HOL_REASON', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NAME= filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);

    $database = new Database();
    $database->beginTransaction();
    
$date1 = new DateTime($HOL_START);
$date2 = new DateTime($HOL_END);

$HOL_DAYS = $date2->diff($date1)->format("%a")+1; 

if($HOL_DAYS>1) {
    $DAYS="days";
}
else {
    $DAYS="day";
}
        
    $change="Days re-booked $HOL_START - $HOL_END ($HOL_DAYS $DAYS | $HOL_REASON)";
            
            $database->query("INSERT INTO employee_timeline set note_type='Holiday Booked', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$change);              
            $database->execute();

    $HOL_REASON_NAME="$NAME ($HOL_DAYS day(s) | $HOL_REASON)";        
            
    if(isset($HOL_REF)) {

            $database->query("UPDATE employee_holidays set days=:days, updated_by=:who, start=:start, end=:end, title=:title WHERE hol_id=:HOL AND employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':days',$HOL_DAYS);
            $database->bind(':HOL',$HOL_REF);
            $database->bind(':title',$HOL_REASON_NAME);
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->bind(':who',$hello_name);
            $database->execute();          
        
    }
    
    else {
    
            $database->query("INSERT INTO employee_holidays set days=:days, added_by=:who, start=:start, end=:end, title=:title, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':days',$HOL_DAYS);
            $database->bind(':title',$HOL_REASON_NAME);
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->bind(':who',$hello_name);
            $database->execute();             
    }
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=HOLBOOKED&REF='.$REF); die;
    
    }      

         if($EXECUTE=='8') {

    $HOL_START= filter_input(INPUT_POST, 'HOL_START', FILTER_SANITIZE_SPECIAL_CHARS);    
    $HOL_END= filter_input(INPUT_POST, 'HOL_END', FILTER_SANITIZE_SPECIAL_CHARS);  
    $HOL_REASON= filter_input(INPUT_POST, 'HOL_REASON', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NAME= filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $database = new Database();
    $database->beginTransaction();
    
            $database->query("SELECT hol_id from employee_holidays WHERE start between :start AND :end");
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->execute(); 
            
             if ($database->rowCount()>=1) {
                
            $database->endTransaction();
            
            header('Location: ../ViewEmployee.php?RETURN=ALREADYBOOKED&REF='.$REF.'&HOL_REF='.$HOL_REF.'&HOL_START='.$HOL_START.'&HOL_END='.$HOL_END.'&HOL_REASON='.$HOL_REASON.'#Menu5'); die;   
                
            }
            
$date1 = new DateTime($HOL_START);
$date2 = new DateTime($HOL_END);

$HOL_DAYS = $date2->diff($date1)->format("%a")+1;  

if($HOL_DAYS>1) {
    $DAYS="days";
}
else {
    $DAYS="day";
}
    
    $change="Days booked $HOL_START - $HOL_END ($HOL_DAYS $DAYS | $HOL_REASON)";
            
            $database->query("INSERT INTO employee_timeline set note_type='Holiday Booked', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$change);              
            $database->execute();

    $HOL_REASON_NAME="$NAME ($HOL_REASON)";        
            
            $database->query("UPDATE employee_holidays set days=:days, updated_by=:who, start=:start, end=:end, title=:title WHERE hol_id=:HOL AND employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':days',$HOL_DAYS);
            $database->bind(':HOL',$HOL_REF);
            $database->bind(':title',$HOL_REASON_NAME);
            $database->bind(':start',$HOL_START);    
            $database->bind(':end',$HOL_END); 
            $database->bind(':who',$hello_name);
            $database->execute();             
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=HOLBOOKED&REF='.$REF); die;
    
    }  

         if($EXECUTE=='9') {

    $notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);     

    $database = new Database();
    $database->beginTransaction();
    
    $database->query("UPDATE employee_details set updated_by=:hello, employed='1' WHERE employee_id=:REF");
    $database->bind(':REF',$REF);
    $database->bind(':hello',$hello_name);
    $database->execute();
            
            $database->query("INSERT INTO employee_timeline set note_type='Note Added', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$notes); 
            $database->execute(); 
            
            $database->endTransaction();
            
           header('Location: ../ViewEmployee.php?RETURN=ClientHired&REF='.$REF); die;
    
    }    
    
}


} else {
 header('Location: ../../CRMmain'); die;
}

?>