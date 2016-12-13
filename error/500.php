<!DOCTYPE html>
<html lang="en">
<title>ADL | 500 Internal Server Error</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php include('../includes/navbar.php'); ?>
<?php include('../includes/adlfunctions.php'); ?>

<div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">500
                    <small>Internal Server Error</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../CRMmain.php">Home</a>
                    </li>
                    <li class="active">500</li>
                </ol>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="jumbotron">
<h1><span class="glyphicon glyphicon-fire red"></span> 500</h1>

<p>Report this immediately to Michael.


            <center>
                <p>Info Logged<br><?php echo $_SERVER['REMOTE_ADDR'] ?><br>
<?php loggedhostnameip();?> 
<br>
<?php
date_default_timezone_set("Europe/London");
echo date('m/d/y h:i a', time());
?> 
</p>
</center>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
