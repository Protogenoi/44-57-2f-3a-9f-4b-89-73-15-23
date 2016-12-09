<?php

session_start();

if(!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {

require ('includes/login_functions.inc.php');

redirect_user();
}

$hello_name=$_SESSION['login'];
?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | CRM</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.css">

</script>
</head>
<body>

<?php include('includes/navbar.php'); ?>
<?php include('includes/adlfunctions.php'); ?>


<?php logged_in_as($hello_name);?> 


<script src="/js/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
