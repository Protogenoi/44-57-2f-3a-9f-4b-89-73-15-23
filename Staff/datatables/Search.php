<?php

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) { 
    if($EXECUTE=='1') {
        
        include('../../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT employee_details.employee_id, CONCAT(employee_details.firstname,' ', employee_details.lastname) AS NAME, employee_contact.mob, employee_contact.tel, employee_details.position FROM employee_details JOIN employee_contact ON employee_details.employee_id = employee_contact.employee_id ORDER BY employee_details.added_date DESC");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($results);
        
    }
    
    }
    
    ?>