<?php
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        include('../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT dialer_agents_name as full_name from dialer_agents WHERE dialer_agents_group='Agent' ORDER BY dialer_agents_name");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));

        echo json_encode($results);
        
}

}
  
?>