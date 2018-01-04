<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENT= filter_input(INPUT_GET, 'agent', FILTER_SANITIZE_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if(isset($EXECUTE)) {
    if($EXECUTE == 1) {

$query = $pdo->prepare("select Task, COUNT(Complete) As Completed FROM Client_Tasks WHERE complete='0' and assigned=:agent GROUP BY Task");
$query->bindParam(':agent', $AGENT, PDO::PARAM_STR, 12);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

header("content-type:application/json");
echo $json=json_encode($results);

}

elseif ($EXECUTE == 2) {

$query = $pdo->prepare("select Task, COUNT(Complete) As Completed FROM Client_Tasks WHERE complete='0' GROUP BY Task");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

header("content-type:application/json");
echo $json=json_encode($results);    
    
}

}
?>
