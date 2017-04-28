<?php

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if (isset($EXECUTE)) {

    if ($EXECUTE == '1') {

        include('../../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT dialer_agents_name, dialer_agents_id, dialer_agents_group from dialer_agents");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results['aaData'] = $query->fetchAll(PDO::FETCH_ASSOC));

        echo json_encode($results);
    }
} else {

header('Location: ../../CRMmain.php'); die;

}
?>