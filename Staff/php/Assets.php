<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain'); die;

}
    
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    $REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
    include('../../classes/database_class.php');
    
    if($EXECUTE=='1') {
    
    $DEVICE= filter_input(INPUT_POST, 'DEVICE', FILTER_SANITIZE_SPECIAL_CHARS); 
    $ASSET_NAME= filter_input(INPUT_POST, 'ASSET_NAME', FILTER_SANITIZE_SPECIAL_CHARS);
    $MANUFACTURER= filter_input(INPUT_POST, 'MANUFACTURER', FILTER_SANITIZE_SPECIAL_CHARS);    
        
            $database = new Database();
            $database->beginTransaction();
            
            $database->query("INSERT INTO inventory set asset_name=:asset, manufactorer=:manu, added_by=:hello, device=:device");
            $database->bind(':manu',$MANUFACTURER);
            $database->bind(':asset',$ASSET_NAME);
            $database->bind(':hello',$hello_name);
            $database->bind(':device',$DEVICE);
            $database->execute(); 
            $lastid =  $database->lastInsertId();
    
            $changereason="Added asset ($ASSET_NAME) to inventory";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETADDED&ASSETID='.$lastid.'&DEVICE='.$DEVICE); die;

    }
    
    if($EXECUTE=='2') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS); 
    $MAC= filter_input(INPUT_POST, 'MAC', FILTER_SANITIZE_SPECIAL_CHARS); 
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $OS= filter_input(INPUT_POST, 'OS', FILTER_SANITIZE_SPECIAL_CHARS);
    $RAM= filter_input(INPUT_POST, 'RAM', FILTER_SANITIZE_SPECIAL_CHARS);   
    $HOSTNAME= filter_input(INPUT_POST, 'HOSTNAME', FILTER_SANITIZE_SPECIAL_CHARS); 
        
            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_computers set mac=:mac, os=:os, ram=:ram, hostname=:hostname, notes=:notes, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':mac',$MAC);
            $database->bind(':os',$OS);
            $database->bind(':ram',$RAM);
            $database->bind(':hostname',$HOSTNAME);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }
        if($EXECUTE=='3') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CONNECTION= filter_input(INPUT_POST, 'CONNECTION', FILTER_SANITIZE_SPECIAL_CHARS);   

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_keyboards set connection_type=:conn, notes=:notes, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':conn',$CONNECTION);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }

        if($EXECUTE=='4') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $CONNECTION= filter_input(INPUT_POST, 'CONNECTION', FILTER_SANITIZE_SPECIAL_CHARS);   

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_mice set connection_type=:conn, notes=:notes, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':conn',$CONNECTION);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }

        if($EXECUTE=='5') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_headsets set notes=:notes, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }   
    
        if($EXECUTE=='6') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $MAC= filter_input(INPUT_POST, 'MAC', FILTER_SANITIZE_SPECIAL_CHARS); 

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_phones set notes=:notes, mac=:mac, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':mac',$MAC);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    } 
    
        if($EXECUTE=='7') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $MAC= filter_input(INPUT_POST, 'MAC', FILTER_SANITIZE_SPECIAL_CHARS); 
    $IP= filter_input(INPUT_POST, 'IP', FILTER_SANITIZE_SPECIAL_CHARS); 
    $HOSTNAME= filter_input(INPUT_POST, 'HOSTNAME', FILTER_SANITIZE_SPECIAL_CHARS); 

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_network set ip=:ip, hostname=:host, notes=:notes, mac=:mac, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':mac',$MAC);
            $database->bind(':host',$HOSTNAME);
            $database->bind(':ip',$IP);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }   
    
        if($EXECUTE=='8') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 
    $MAC= filter_input(INPUT_POST, 'MAC', FILTER_SANITIZE_SPECIAL_CHARS); 
    $IP= filter_input(INPUT_POST, 'IP', FILTER_SANITIZE_SPECIAL_CHARS); 
    $HOSTNAME= filter_input(INPUT_POST, 'HOSTNAME', FILTER_SANITIZE_SPECIAL_CHARS); 

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_printers set ip=:ip, hostname=:host, notes=:notes, mac=:mac, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->bind(':mac',$MAC);
            $database->bind(':host',$HOSTNAME);
            $database->bind(':ip',$IP);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }  
    
        if($EXECUTE=='9') {
        
    $ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);  
    $NOTES= filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_SPECIAL_CHARS); 

            $database = new Database();
            $database->beginTransaction();
            
            $database->query("UPDATE inventory set updated_by=:hello WHERE inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':hello',$hello_name);
            $database->execute();
            
            $database->query("INSERT INTO int_monitors set notes=:notes, inv_id=:id ");
            $database->bind(':id',$ASSETID);
            $database->bind(':notes',$NOTES);
            $database->execute(); 
    
            $changereason="Asset details added ($ASSETID)";
            $REF='1';
            
            $database->query("INSERT INTO employee_timeline set note_type='Inventory Updated', message=:change, added_by=:hello, added_date=CURDATE() , employee_id=:REF");
            $database->bind(':REF',$REF);
            $database->bind(':hello',$hello_name);    
            $database->bind(':change',$changereason); 
            $database->execute(); 
            
            $database->endTransaction();
            
            header('Location: ../Assets/Assets.php?RETURN=ASSETDETAILSADDED&ASSETID='.$ASSETID); die;

    }     
    
}
            
?>