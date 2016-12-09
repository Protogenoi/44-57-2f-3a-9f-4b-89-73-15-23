<?php

if ($_SERVER['REQUEST_METHOD'] =='POST') {
require ('includes/login_functions.inc.php');
require ('includes/mysqliadl.php');

list ($check, $data) = check_login($dbc, $_POST['username'],$_POST['pass']);

if ($check) { // OK!

session_start();
$_SESSION['id']=$data['id'];
$_SESSION['login']=$data['login'];

$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);


redirect_user('adlmain.php');

} else {
$errors = $data;
}
mysqli_close($dbc);

}
include ('includes/login_page.inc.php');
?>
