<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
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

if (!in_array($hello_name, $Level_10_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Upload</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .container2{
            margin: 20px;
            margin-right:35px;
        }
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
</head>
<body>
    <?php require_once(__DIR__ . '/includes/navbar.php'); ?>

    <br>
    <div class="container2">

        <?php
        if (!empty($_GET[success])) {
            echo "<div class=\"notice notice-success fade in\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
            <strong>Success!</strong> File Uploaded to Database.
            </div><br><br>";
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-hdd"></span> Upload data</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload EWS data</h3>
                                <form action="/upload/ewsupload.php" method="post" enctype="multipart/form-data" name="form1" id="form1" target="POPUPW" onsubmit="POPUPW = window.open('about:blank', 'POPUPW', 'width=1024,height=700');">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>
                                <form action="/export/ewstemp.php" method="post"><br>
                                    <button type="submit" class="btn btn-info "><span class="glyphicon glyphicon-save"></span> Template</button>
                                </form>
                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload financial data</h3>
                                <form action="/upload/finrupload.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>

                                <form action="/export/finreporttemp.php" method="post"><br>
                                    <button type="submit" class="btn btn-info "><span class="glyphicon glyphicon-save"></span> Template</button>
                                </form>
                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload Client data</h3>
                                <form action="/upload/clientpolup.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>

                                <form action="/export/clientdetailstemp.php" method="post"><br>
                                    <button type="submit" class="btn btn-info "><span class="glyphicon glyphicon-save"></span> Template</button>
                                </form>
                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload PBA Client data</h3>
                                <form action="/upload/PBAclientup.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />

                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>

                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload PBA Details</h3>
                                <form action="/upload/PBAdetails.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />

                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>

                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload Client Notes data</h3>
                                <form action="/upload/clientnotesup.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>
                            </div>

                            <div class="col-xs-6 col-md-6">
                                <h3>Upload Legacy Client data</h3>
                                <form action="/upload/legclientpolup.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>

                            </div>
                            <div class="col-xs-6 col-md-6">
                                <h3>Upload Legacy Policy data</h3>
                                <form action="/upload/legpolup.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <h3>Upload Legacy EWS</h3>
                                <form action="/upload/ewslegupload.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <input name="csv" type="file" id="csv" />
                                    <input type="hidden" name="Processor" value="<?php echo $hello_name ?>"><br>
                                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="notice notice-success fade in">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
                        <strong>Success!</strong> File Uploaded to Database.
                    </div>

                <?php } else if (isset($_GET['fail'])) {
                    ?>
                    <div class="notice notice-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> File Upload Failed.
                    </div>

                    <?php
                } else {
                    
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
