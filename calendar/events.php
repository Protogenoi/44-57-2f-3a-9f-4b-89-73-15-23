<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
$json = array();

if(isset($hello_name)) {

include('../includes/ADL_PDO_CON.php');

$requete = "SELECT * FROM evenement where assigned_to='$hello_name' ORDER BY id";
$resultat = $pdo->query($requete) or die(print_r($pdo->errorInfo()));
echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

}

?>
