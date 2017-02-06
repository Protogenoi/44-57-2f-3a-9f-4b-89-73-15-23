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
     if($EXECUTE=='7') {


        $query = $pdo->prepare("select int_network.inv_id, int_network.mac, ip, int_network.hostname, inventory.asset_name, inventory.fault, inventory.updated_date, inventory.manufactorer FROM int_network JOIN inventory on inventory.inv_id = int_network.inv_id ORDER BY inventory.updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }   
    
    }
    
    ?>