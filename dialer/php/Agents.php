<?php

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AID = filter_input(INPUT_GET, 'AID', FILTER_SANITIZE_NUMBER_INT);

if (isset($EXECUTE)) {
    
            include('../../includes/ADL_PDO_CON.php');
    
    if ($EXECUTE == '1') {

        $DELETE = $pdo->prepare("DELETE FROM dialer_agents WHERE dialer_agents_id=:AID");
        $DELETE->bindParam(':AID', $AID, PDO::PARAM_INT);
        $DELETE->execute()or die(print_r($DELETE->errorInfo(), true));

         header('Location: /dialer/Agents.php?RETURN=DELETED'); die;
        
    }

    if ($EXECUTE == '2') {
        
        $NAME = filter_input(INPUT_POST, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);
        $TYPE = filter_input(INPUT_POST, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $INSERT = $pdo->prepare("INSERT INTO dialer_agents set dialer_agents_name=:NAME, dialer_agents_group=:TYPE");
        $INSERT->bindParam(':NAME', $NAME, PDO::PARAM_STR);
        $INSERT->bindParam(':TYPE', $TYPE, PDO::PARAM_STR);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));

         header('Location: /dialer/Agents.php?RETURN=ADDED'); die;
        
    }
} 

header('Location: ../../CRMmain.php'); die;
?>