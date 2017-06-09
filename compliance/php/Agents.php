<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
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

if(isset($EXECUTE)) {
    
    $AGENT_NAME = filter_input(INPUT_POST, 'AGENT_NAME', FILTER_SANITIZE_SPECIAL_CHARS);
    $AGENT_ROLE = filter_input(INPUT_POST, 'AGENT_ROLE', FILTER_SANITIZE_SPECIAL_CHARS);

    if($EXECUTE=='1') {
        
        $INSERT = $pdo->prepare("INSERT INTO compliance_agents SET compliance_agents_name=:NAME, compliance_agents_role=:ROLE, compliance_agents_company=:COMPANY");
        $INSERT->bindParam(':ROLE', $AGENT_ROLE, PDO::PARAM_STR);
        $INSERT->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
        $INSERT->bindParam(':NAME', $AGENT_NAME, PDO::PARAM_STR);
        $INSERT->execute();
        
        header('Location: ../Agents.php?RETURN=AGENTADDED');
        
    }

}

?>