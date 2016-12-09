<?php

session_start();

if(!isset($_SESSION['id'])) {

require ('includes/login_functions.inc.php');

redirect_user();

}

else {

$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '', time()-3600, '/', '', '',0, 0);

}

?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Logout</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
</head>
<body>

<?php include('includes/navbar.php'); ?>
<?php include('includes/adlfunctions.php'); ?>

<div class="container">

<div class="notice notice-success" role="alert"><strong>Success!</strong> You are now logged out!</div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
