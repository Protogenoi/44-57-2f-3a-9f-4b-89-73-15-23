<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if($fffinancials=='0') {
    header('Location: /../../CRMmain.php?FEATURE=FINANCIALS');
}

if ($companynamere == 'The Review Bureau') {

    $Level_2_Access = array("Michael", "Matt", "leighton", "Jade");
    if (!in_array($hello_name, $Level_2_Access, true)) {

        header('Location: /../../CRMmain.php?AccessDenied');
        die;
    }
}

if ($companynamere == 'ADL_CUS') {
    $Level_2_Access = array("Michael", "Dean", "Andrew", "Helen", "David");
    if (!in_array($hello_name, $Level_2_Access, true)) {

        header('Location: /../../CRMmain.php?AccessDenied');
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Financial Uploads</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php
    if ($hello_name != 'Jade') {
        require_once(__DIR__ . '/../../includes/navbar.php');
    }
    ?>

    <div class="container">

        <?php
        $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!isset($query)) {
            $query = 'Life';
        }

        $uploaded = filter_input(INPUT_GET, 'uploaded', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($uploaded)) {
            if (($uploaded == '1')) {

                echo "<div class='notice notice-success' role='alert'><strong><i class='fa fa-upload fa-lg'></i> Success:</strong> Your file has been uploaded</div>";
            }

            if (($uploaded == '0')) {

                $Reason = filter_input(INPUT_GET, 'Reason', FILTER_SANITIZE_SPECIAL_CHARS);

                echo "<div class='notice notice-danger' role='alert'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Error:</strong> File has not been uploaded</div>";
            }

            if (isset($Reason)) {

                echo "<div class='notice notice-warning' role='alert'><strong><i class='fa fa-exclamation-circle fa-lg'></i> Warning:</strong> File type is not supported. <br><br>A number of spreadsheet filetypes are supported, if you keep having trouble upload as a .csv </div>";
            }
        }
        ?>

        <div class="row">

            <form action="" method="GET">
                <fieldset>
                    <legend>File upload</legend>                    

                    <div class="form-group col-xs-2">
                        <label class="col-xs-2 control-label" for="query"></label>
                        <select id="query" name="query" class="form-control" onchange="this.form.submit()" required>

                            <option value="">Select...</option>
                            <option <?php if (isset($query)) {
            if ($query == 'Life') {
                echo "selected";
            }
        } ?> value="Life">Legal & General Financials</option>
                            <option <?php if (isset($query)) {
            if ($query == 'Home') {
                echo "selected";
            }
        } ?> value="Home">Home Financials</option>
                            <option <?php if (isset($query)) {
            if ($query == 'Vitality') {
                echo "selected";
            }
        } ?> value="Vitality">Vitality Financials</option>
                            <option <?php if (isset($query)) {
            if ($query == 'Aviva') {
                echo "selected";
            }
        } ?> value="Aviva">Aviva Financials</option>
                            <option <?php if (isset($query)) {
            if ($query == 'WOL') {
                echo "selected";
            }
        } ?> value="WOL">One Family Financials</option>
                            <option <?php if (isset($query)) {
            if ($query == 'RoyalLondon') {
                echo "selected";
            }
        } ?> value="RoyalLondon">Royal London Financials</option>


                        </select>
                    </div>
                </fieldset>
            </form>

            <form id="upload" id="upload" class="form-horizontal" method="post" enctype="multipart/form-data" action="../php/FinFileUpload.php?<?php if (isset($query)) {
            echo "query=$query";
        } else {
            echo "query=Life";
        } ?>"> 
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">Select file..</label>
                        <div class="col-md-3">
                            <input id="file" name="file" class="input-file btn-defalt" type="file">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for=""></label>
                        <div class="col-md-3">
                            <button id="" name="" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> <?php if (isset($query)) {
                echo "$query";
            } else {
                echo $companynamere;
            } ?> Upload</button>
                        </div>
                    </div>

                </fieldset>
            </form>


        </div>

        <div class="row">

            <?php
            if (in_array($hello_name, $Level_10_Access, true)) {
                try {

                    if (isset($query)) {

                        switch ($query) {
                            case "Life":
                                $type = "Financial Comms";
                                break;
                            case "Home":
                                $type = "Home Financials";
                                break;
                            case "Vitality":
                                $type = "Vitality Financials";
                                break;
                            case "WOL":
                                $type = "WOL Financials";
                                break;
                            case "Aviva":
                                $type = "Aviva Financials";
                                break;
                            case "RoyalLondon":
                                $type = "Royal London Financials";
                                break;
                            default:
                                $type = "Financial Comms";
                        }

                        $filesloaded = $pdo->prepare("select DATE(added_date) as added_date, file, uploadtype from tbl_uploads where uploadtype=:type ORDER BY id DESC LIMIT 4");
                        $filesloaded->bindParam(':type', $type, PDO::PARAM_STR);
                    } else {
                        $filesloaded = $pdo->prepare("select DATE(added_date) as added_date, file, uploadtype from tbl_uploads where uploadtype='Financial Comms' ORDER BY id DESC LIMIT 4");
                    }
                    ?>

                    <span class="label label-primary"><?php if (isset($query)) {
                echo "$query";
            } else {
                echo $companynamere;
            } ?> Uploads</span>

                    <?php
                    $filesloaded->execute();
                    if ($filesloaded->rowCount() > 0) {
                        while ($row = $filesloaded->fetch(PDO::FETCH_ASSOC)) {

                            $file = $row['file'];
                            $uploadtype = $row['uploadtype'];
                            $added_dates = $row['added_date'];

                            if (isset($query)) {
                                if ($query == 'Life') {

                                    if ($added_dates < "2017-03-14") {
                                        ?>
                                        <a class="list-group-item" href="../FinUploads/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file (OLD)"; ?></a>
                                    <?php } else { ?>  
                                        <a class="list-group-item" href="../FinUploads/LANDG/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file (NEW)"; ?></a>

                                    <?php }
                                }
                                if ($query == 'Home') {
                                    ?>
                                    <a class="list-group-item" href="../FinUploads/Home/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($query == 'Vitality') {
                                    ?>
                                    <a class="list-group-item" href="../FinUploads/Vitality/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($query == 'Aviva') {
                                    ?>
                                    <a class="list-group-item" href="../FinUploads/Aviva/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($query == 'WOL') {
                                    ?>
                                    <a class="list-group-item" href="../FinUploads/WOL/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                    <?php }
                    if ($query == 'RoyalLondon') {
                        ?>
                                    <a class="list-group-item" href="../FinUploads/RoyalLondon/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                    <?php
                    }
                } else {
                    ?>

                                <a class="list-group-item" href="../FinUploads/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                <?php
                }
            }
        } else {
            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No uploads found</div>";
        }
        ?>

                    </table>

    <?php
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>

        </div>

    </div>
    <script>
        document.querySelector('#upload').addEventListener('submit', function (e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Upload File?",
                text: "Confirm to upload file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: 'Uploading!',
                                text: 'File uploading!',
                                type: 'success'
                            }, function () {
                                form.submit();
                            });

                        } else {
                            swal("Cancelled", "File was not uploaded", "error");
                        }
                    });
        });

    </script>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/js/sweet-alert.min.js"></script>
</body>
</html>
