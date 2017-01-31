<?php

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) { 
    if($EXECUTE=='1') {
        
        include('../../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT updated_date, asset_name, manufactorer, device, fault, fault_reason, inv_id FROM inventory ORDER BY updated_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
    
    }
    
    ?>