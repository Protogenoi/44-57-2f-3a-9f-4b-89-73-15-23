<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$my_access = new Access_user(false);


// $my_access->language = "de"; // use this selector to get messages in other languages
if (isset($_GET['activate']) && isset($_GET['ident'])) { // this two variables are required for activating/updating the account/password
	$my_access->auto_activation = true; // use this (true/false) to stop the automatic activation
	$my_access->activate_account($_GET['activate'], $_GET['ident']); // the activation method 
}
if (isset($_GET['validate']) && isset($_GET['id'])) { // this two variables are required for activating/updating the new e-mail address
	$my_access->validate_email($_GET['validate'], $_GET['id']); // the validation method 
}
if (isset($_POST['Submit'])) {
	$my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; // use a cookie to remember the login
	$my_access->count_visit = false; // if this is true then the last visitdate is saved in the database (field extra info)
	$my_access->login_user($_POST['login'], $_POST['password']); // call the login method
} 
$error = $my_access->the_msg; 
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Login</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="../../styles/login.css" type="text/css" />


</head>
<body id="top">

  <section class="container">
    <div class="login">
<p><img src="../../img/rblogonew.png"></p>
<h1>CRM Login | 
<a href="AuditLogin.php">Audit Login</a></h1>
<br>

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">



<p><input type="text" name="login" size="20" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $my_access->user; ?>" placeholder="Username"></p>

<p><input type="password" name="password" size="8" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password"></p>

<p class="remember_me">
  <label for="remember">
  <input type="checkbox" name="remember" value="yes"<?php echo ($my_access->is_cookie == true) ? " checked" : ""; ?>>
Automatic login?
</label>
</p>

<p class="submit"><input type="submit" name="Submit" value="Login"></p>
</form>

</div>
  </section>
 
  




</body>
</html>
