<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>Emails</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/includes/navbar.php'); ?>

    <div class="container">

        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">

                    <?php if ($ffkeyfactsemail == '1') { ?>
                        <li>
                            <a href="email/KeyFactsEmail.php">
                                <span class="ca-icon"><i class="fa fa-envelope"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Closers<br/></h2>
                                    <h3 class="ca-sub">Key Facts Email</h3>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    if ($ffgenemail == '1') {
                        ?>                       
                        <li>
                            <a href="email/GenericEmail.php">
                                <span class="ca-icon"><i class="fa fa-envelope-o"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Generic<br/></h2>
                                    <h3 class="ca-sub">Emails</h3>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    if ($ffintemails == '1') {
                        ?>
                        <li>
                            <a href="email/InternalEmail.php">
                                <span class="ca-icon"><i class="fa fa-envelope"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Internal<br/>Emails</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
