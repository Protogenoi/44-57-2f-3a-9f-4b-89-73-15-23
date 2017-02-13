<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$url= filter_input(INPUT_POST, 'url', FILTER_SANITIZE_SPECIAL_CHARS);
$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$start= filter_input(INPUT_POST, 'start', FILTER_SANITIZE_SPECIAL_CHARS);
$end= filter_input(INPUT_POST, 'end', FILTER_SANITIZE_SPECIAL_CHARS);

include('../includes/ADL_PDO_CON.php');

$sql = "INSERT INTO evenement (title, start, end, url, assigned_to) VALUES (:title, :start, :end, :url, :assigned_to)";
$q = $pdo->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end,  ':url'=>$url, ':assigned_to'=>$hello_name));
?>
