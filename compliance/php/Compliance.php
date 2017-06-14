<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../classes/database_class.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$COMID = filter_input(INPUT_GET, 'COMID', FILTER_SANITIZE_NUMBER_INT);
$TITLE = filter_input(INPUT_GET, 'TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
$MSG = filter_input(INPUT_POST, 'MSG', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE)) {

    $QRY = $pdo->prepare("SELECT employee_id FROM employee_details WHERE CONCAT(firstname, ' ', lastname)='Hayden Williams'");
    $QRY->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $QRY->execute();
    $data1 = $QRY->fetch(PDO::FETCH_ASSOC); 
    
    $ID_FK=$data1['employee_id'];
    
    $query = $pdo->prepare("SELECT employee_id FROM employee_details WHERE CONCAT(firstname, ' ', lastname)=:NAME AND company=:COMPANY");
    $query->bindParam(':NAME', $hello_name, PDO::PARAM_STR);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC); 
    
    $EID_FK=$data2['employee_id'];    
    
    if($EXECUTE=='1') {
       
            $changereason="Confirmed that they have read and understood $TITLE";
            $database = new Database();
            $database->query("INSERT INTO employee_timeline set note_type='Doc Read', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute();
            
            $database->query("INSERT INTO employee_timeline set note_type='Doc Read', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$EID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute();   
            
            header('Location: ../Compliance.php?RETURN=DOCREAD');  
        
    }
    if($EXECUTE=='2') {
        
        $MESSAGE="Question raised about $TITLE | Sent to Hayden Williams";
        
            $database = new Database();
            $database->query("INSERT INTO employee_timeline set note_type='Doc Question', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$ID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$MESSAGE); 
            $database->execute();
            
            
            $database->query("INSERT INTO employee_timeline set note_type='Doc Question', message=:change, added_by=:hello, employee_id=:REF");
            $database->bind(':REF',$EID_FK);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$MESSAGE); 
            $database->execute();      
            
        $database->query("INSERT INTO messenger SET messenger_to='Hayden Williams', messenger_msg=:MSG, messenger_sent_by=:HELLO, messenger_company='HWIFS'");
        $database->bind(':MSG', $MSG);
        $database->bind(':HELLO',$hello_name);
        $database->execute();              
        
     header('Location: ../Compliance.php?RETURN=MSGSENT');   
    }
}

?>