<?php
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        include('../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT 
    CONCAT(firstname, ' ', lastname) AS full_name
FROM
    employee_details
WHERE
    position = 'Life Lead Gen'
        AND company = 'The Review Bureau'
        AND employed = '1'
ORDER BY full_name");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));

        echo json_encode($results);
        
}

}
  
?>