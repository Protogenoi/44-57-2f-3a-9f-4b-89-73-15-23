<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/Access_Levels.php');

if (in_array($hello_name,$Level_10_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true)) {
    
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    
    include('../../classes/database_class.php');
    
    if($EXECUTE=='1') {
        
    $REF= filter_input(INPUT_POST, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);  
    $DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $YEAR= filter_input(INPUT_GET, 'YEAR', FILTER_SANITIZE_SPECIAL_CHARS);    
    $MONTH= filter_input(INPUT_GET, 'MONTH', FILTER_SANITIZE_SPECIAL_CHARS);     

    $database = new Database();
    $database->beginTransaction();
    
    $database->query("INSERT into lead_rag set employee_id=:REF, month=:month, year=:year, date=:date, updated_by=:hello");
    $database->bind(':REF',$REF);
    $database->bind(':date',$DATE);
    $database->bind(':year',$YEAR);
    $database->bind(':month',$MONTH);
    $database->bind(':hello',$hello_name);
    $database->execute(); 
    $lastid =  $database->lastInsertId();
    
    $database->query("INSERT INTO employee_register set employee_id=:REF, lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$lastid);
    $database->execute(); 
    $database->endTransaction();
            
    header('Location: ../Reports/RAG.php?RETURN=AgentAdded&MONTH='.$MONTH.'&YEAR='.$YEAR.'&DATE='.$DATE.'&REF='.$REF); die;
    
    }
    
    if($EXECUTE=='2') {
      
    $REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);  
    $DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $YEAR= filter_input(INPUT_GET, 'YEAR', FILTER_SANITIZE_SPECIAL_CHARS);    
    $MONTH= filter_input(INPUT_GET, 'MONTH', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $SALES= filter_input(INPUT_POST, 'SALES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CANCELS= filter_input(INPUT_POST, 'CANCELS', FILTER_SANITIZE_SPECIAL_CHARS);
    $LEADS= filter_input(INPUT_POST, 'LEADS', FILTER_SANITIZE_SPECIAL_CHARS); 
    $HOURS= filter_input(INPUT_POST, 'HOURS', FILTER_SANITIZE_SPECIAL_CHARS);
    $MINUS= filter_input(INPUT_POST, 'MINUS', FILTER_SANITIZE_SPECIAL_CHARS);
    $REGISTER= filter_input(INPUT_POST, 'REGISTER', FILTER_SANITIZE_SPECIAL_CHARS);
    $LEAD_RAG_ID= filter_input(INPUT_GET, 'LEADRAG', FILTER_SANITIZE_SPECIAL_CHARS);
   
    $database = new Database();
    $database->beginTransaction();
    
    $database->query("UPDATE lead_rag set cancels=:cancels, hours=:hours, minus=:minus, updated_by=:hello WHERE employee_id=:REF AND date=:date");
    $database->bind(':REF',$REF);
    $database->bind(':cancels',$CANCELS);
    $database->bind(':hours',$HOURS);
    $database->bind(':minus',$MINUS);
    $database->bind(':date',$DATE);
    $database->bind(':hello',$hello_name);
    $database->execute();
    
    if(isset($REGISTER)){
        if($REGISTER=='1') {
            
        $database->query("UPDATE employee_register set bank='0', worked='1', holiday='0', sick='0', awol='0', authorised='0', training='0' WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);
    $database->execute(); 
        }
        
        if($REGISTER=='2') {
            
         $database->query("UPDATE employee_register set bank='0', holiday='1', worked='0', sick='0', awol='0', authorised='0', training='0' WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);
    $database->execute(); 
        }
        if($REGISTER=='3') {
            
         $database->query("UPDATE employee_register set bank='0', sick='1', worked='0', holiday='0', awol='0', authorised='0', training='0' WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);
    $database->execute(); 
        }
        if($REGISTER=='4') {
            
         $database->query("UPDATE employee_register set bank='0', awol='1', worked='0', holiday='0', sick='0', authorised='0', training='0' WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);  
$database->execute();     
        }
        if($REGISTER=='5') {
            
         $database->query("UPDATE employee_register set bank='0', authorised='1', worked='0', holiday='0', sick='0', awol='0', training='0' WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);
    $database->execute(); 
        }
        if($REGISTER=='6') {
            
        $database->query("UPDATE employee_register set bank='0', training='1', worked='0', holiday='0', sick='0', awol='0', authorised='0', WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);   
$database->execute();     
        }
                if($REGISTER=='7') {
            
        $database->query("UPDATE employee_register set bank='1', training='0', worked='0', holiday='0', sick='0', awol='0', authorised='0', WHERE employee_id=:REF AND lead_rag_id=:lead_id");
    $database->bind(':REF',$REF);
    $database->bind(':lead_id',$LEAD_RAG_ID);   
$database->execute();     
        }
        
    }

    
    
    $database->endTransaction();
            
    header('Location: ../Reports/RAG.php?RETURN=RAGUPDATED&MONTH='.$MONTH.'&YEAR='.$YEAR.'&DATE='.$DATE.'&REF='.$REF); die;
    
    }
       
}

} else {
 header('Location: ../../CRMmain'); die;
}
?>