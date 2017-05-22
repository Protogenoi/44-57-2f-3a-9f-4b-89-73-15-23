<!DOCTYPE html>
<html lang="en">
<title>ADL | 404 Not Found</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php include('../includes/navbar.php'); ?>
<?php include('../includes/adlfunctions.php'); ?>

 <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">404
                    <small>Page Not Found</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../CRMmain.php">Home</a>
                    </li>
                    <li class="active">404</li>
                </ol>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="jumbotron">
<h1><span class="glyphicon glyphicon-search"></span> 404</h1>

<p>The page you're looking for could not be found. Here are some helpful links to get you back on track:</p>

<ul>
                        <li>
                            <a href="../CRMmain.php">CRM</a>
                        </li>
                        <li>
                            <a href="../main_menu.php">Audits</a>
                        </li>
                        <li>
                            <a href="//bureau.bluetelecoms.com">Dialer</a>
                        </li>
                        <li>
                            <a href="//review_bureau.com">Review Bureau</a>
                        </li>
</ul>

<?php logged_hostnameip();?> 

        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
