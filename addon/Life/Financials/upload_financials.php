<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if($fffinancials=='0') {
    header('Location: /../../../../CRMmain.php?FEATURE=FINANCIALS');
}

        $ADL_PAGE_TITLE = "Financial Uploads";
        require_once(__DIR__ . '/../../../app/core/head.php'); 
        
        ?> 
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />   
</head>
<body>

    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">

        <?php
        $EXECUTE = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!isset($EXECUTE)) {
            $EXECUTE = 'Life';
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
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'Life') {
                echo "selected";
            }
        } ?> value="Life">Legal & General Financials</option>
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'Home') {
                echo "selected";
            }
        } ?> value="Home">Home Financials</option>
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'Vitality') {
                echo "selected";
            }
        } ?> value="Vitality">Vitality Financials</option>
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'Aviva') {
                echo "selected";
            }
        } ?> value="Aviva">Aviva Financials</option>
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'WOL') {
                echo "selected";
            }
        } ?> value="WOL">One Family Financials</option>
                            <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'RoyalLondon') {
                echo "selected";
            }
        } ?> value="RoyalLondon">Royal London Financials</option>
             <option <?php if (isset($EXECUTE)) {
            if ($EXECUTE == 'LV') {
                echo "selected";
            }
        } ?> value="LV">LV Financials</option>                


                        </select>
                    </div>
                </fieldset>
            </form>

            <form id="upload" id="upload" class="form-horizontal" method="post" enctype="multipart/form-data" action="/Life/php/FinFileUpload.php?<?php if (isset($EXECUTE)) {
            echo "query=$EXECUTE";
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
                            <button id="" name="" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> <?php if (isset($EXECUTE)) {
                echo "$EXECUTE";
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

                    if (isset($EXECUTE)) {

                        switch ($EXECUTE) {
                            case "Life":
                                $TYPE = "Financial Comms";
                                break;
                            case "Home":
                                $TYPE = "Home Financials";
                                break;
                            case "Vitality":
                                $TYPE = "Vitality Financials";
                                break;
                            case "WOL":
                                $TYPE = "WOL Financials";
                                break;
                            case "Aviva":
                                $TYPE = "Aviva Financials";
                                break;
                            case "RoyalLondon":
                                $TYPE = "Royal London Financials";
                                break;
                            case "LV":
                                $TYPE = "LV Financials";    
                                break;
                            default:
                                $TYPE = "Financial Comms";
                        }

                        $filesloaded = $pdo->prepare("select DATE(added_date) as added_date, file, uploadtype from tbl_uploads where uploadtype=:type ORDER BY id DESC LIMIT 4");
                        $filesloaded->bindParam(':type', $TYPE, PDO::PARAM_STR);
                    } else {
                        $filesloaded = $pdo->prepare("select DATE(added_date) as added_date, file, uploadtype from tbl_uploads where uploadtype='Financial Comms' ORDER BY id DESC LIMIT 4");
                    }
                    ?>

                    <span class="label label-primary"><?php if (isset($EXECUTE)) {
                echo $TYPE;
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

                            if (isset($EXECUTE)) {
                                if ($EXECUTE == 'Life') {
 ?>  
                                        <a class="list-group-item" href="/Life/FinUploads/LANDG/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file (NEW)"; ?></a>
                                    <?php 
                                }
                                if ($EXECUTE == 'Home') {
                                    ?>
                                    <a class="list-group-item" href="/Life/FinUploads/Home/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($EXECUTE == 'Vitality') {
                                    ?>
                                    <a class="list-group-item" href="/Life/FinUploads/Vitality/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($EXECUTE == 'Aviva') {
                                    ?>
                                    <a class="list-group-item" href="/Life/FinUploads/Aviva/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php }
                                if ($EXECUTE == 'WOL') {
                                    ?>
                                    <a class="list-group-item" href="/Life/FinUploads/WOL/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                    <?php }
                    if ($EXECUTE == 'RoyalLondon') {
                        ?>
                                    <a class="list-group-item" href="/Life/FinUploads/RoyalLondon/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                    <?php
                    }
                    if ($EXECUTE == 'LV') {
                        ?>
                                    <a class="list-group-item" href="/Life/FinUploads/LV/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                    <?php
                    }                    
                } else {
                    ?>

                                <a class="list-group-item" href="/Life/FinUploads/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                <?php
                }
            }
        } else {
            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No uploads found</div>";
        }
        ?>

                    </table>

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
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
</body>
</html>
