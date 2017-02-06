<?php

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    include('../../includes/ADL_PDO_CON.php'); 
    if($EXECUTE=='1') {
        
        $query = $pdo->prepare("SELECT updated_date, asset_name, manufactorer, device, fault, fault_reason, inv_id FROM inventory ORDER BY updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }

     if($EXECUTE=='2') {


        $query = $pdo->prepare("select int_computers.inv_id, int_computers.mac, int_computers.ram, int_computers.os, int_computers.hostname, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_computers JOIN inventory on inventory.inv_id = int_computers.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
    
     if($EXECUTE=='3') {


        $query = $pdo->prepare("select int_keyboards.inv_id, int_keyboards.connection_type, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_keyboards JOIN inventory on inventory.inv_id = int_keyboards.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    } 
    
     if($EXECUTE=='4') {


        $query = $pdo->prepare("select int_mice.inv_id, int_mice.connection_type, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_mice JOIN inventory on inventory.inv_id = int_mice.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    } 
    
     if($EXECUTE=='5') {


        $query = $pdo->prepare("select int_headsets.assigned, inventory.inv_id, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_headsets JOIN inventory on inventory.inv_id = int_headsets.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }     

     if($EXECUTE=='6') {


        $query = $pdo->prepare("select int_phones.inv_id, int_phones.mac, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_phones JOIN inventory on inventory.inv_id = int_phones.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }  
    
    
     if($EXECUTE=='7') {


        $query = $pdo->prepare("select int_network.inv_id, int_network.mac, int_network.ip, int_network.hostname, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_network JOIN inventory on inventory.inv_id = int_network.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }   
    
     if($EXECUTE=='8') {


        $query = $pdo->prepare("select int_printers.inv_id, int_printers.mac, int_printers.ip, int_printers.hostname, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_printers JOIN inventory on inventory.inv_id = int_printers.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
    
     if($EXECUTE=='9') {


        $query = $pdo->prepare("select inventory.inv_id, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_monitors JOIN inventory on inventory.inv_id = int_monitors.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }    
    
    }
    
    ?>