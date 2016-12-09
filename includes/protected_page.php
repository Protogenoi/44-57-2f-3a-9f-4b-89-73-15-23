<title>The Review Bureau | Login Success</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
</head>
<body id="top">
<div class="wrapper col1">
  <div id="header">
    <div class="fl_left">
      <h1><a href="#">The Review Bureau</a></h1>
      <p>Login Success</p>
    </div>

<br class="clear" />
  </div>
</div>

<!-- ####################################################################################################### -->
<?php include('includes/nav.php'); ?>
<!-- ####################################################################################################### -->

<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>

<div class="wrapper col4">
  <div class="container">
    <div class="content">

<?php if (login_check($mysqli) == true) : ?>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>

            <p>
                This is an example protected page.  To access this page, users
                must be logged in.  At some stage, we'll also check the role of
                the user, so pages will be able to determine the type of user
                authorised to access the page.
            </p>
            <p>Return to <a href="index.php">login page</a></p>


 <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>

    </div>
    <br class="clear" />
  </div>
</div>



<!-- ####################################################################################################### -->
<?php include('includes/footer.php'); ?>
<!-- ####################################################################################################### --> 
<br class="clear" />
</body>
</html>
