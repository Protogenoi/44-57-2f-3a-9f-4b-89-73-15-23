<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
// List of events
 $json = array();

 // Query that retrieves events
 $requete = "SELECT * FROM evenement where assigned_to='$hello_name' ORDER BY id";

 // Execute the query
 $resultat = $pdo->query($requete) or die(print_r($pdo->errorInfo()));

 // sending the encoded result to success page
 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

?>
