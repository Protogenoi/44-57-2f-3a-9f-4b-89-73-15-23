<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$id= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($id)) {

include('../includes/ADL_PDO_CON.php');

$sql = "DELETE FROM evenement WHERE id=?";
$q = $pdo->prepare($sql);
$q->execute(array($id));

}

?>
