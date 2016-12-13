<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

include('../includes/ADL_PDO_CON.php');

$sql = "UPDATE evenement SET title=?, start=?, end=? WHERE id=?";
$q = $pdo->prepare($sql);
$q->execute(array($title,$start,$end,$id));
?>
