<?php 
require($_SERVER['DOCUMENT_ROOT']."/classes/access_user/db_config.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Logout</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style type="text/css">
	.loginnote{
		margin: 20px;
	}
</style>
</head>
<body id="top">


<!-- ####################################################################################################### -->
<?php include('includes/navbar.php'); ?>
<!-- ####################################################################################################### -->


<!--<a href="/<?php echo $_SERVER['PHP_SELF']; ?>?action=log_out">Log out</a>-->
<div class="loginnote">
 <div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Logged out!</strong><a href="<?php echo LOGIN_PAGE; ?>"> Login (again)</a>.<br>
    </div>
</div>


</body>
</html>
