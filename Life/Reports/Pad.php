<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

$OPTION = filter_input(INPUT_GET, 'option', FILTER_SANITIZE_SPECIAL_CHARS);

$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$PAD_ID = filter_input(INPUT_GET, 'PAD_ID', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | PAD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .label-purple {
            background-color: #8e44ad;
        }
        .clockpicker-popover {
            z-index: 999999;
        }
        .ui-datepicker{ z-index:1151 !important; }
    </style>
</head>
<body>
    <?php
    require_once(__DIR__ . '/../../includes/navbar.php');
    ?>
    <br>
    <div class="container">

        <ul class="nav nav-pills">

            <li class="active"><a data-toggle="pill" href="#OVERVIEW">Overview</a></li>
            <li><a data-toggle="pill" href="#POD1">POD 1 Yesterday</a></li>
            <li><a data-toggle="pill" href="#POD2">POD 2 The Day Before Yesterday</a></li>
            <li><a data-toggle="pill" href="#POD3">POD 3 The Day After Tomorrow</a></li>
            <li><a data-toggle="pill" href="#POD4">POD 4</a></li>
            <li><a data-toggle="pill" href="#POD5">POD 5</a></li>
            <li><a data-toggle="pill" href="#POD6">POD 6</a></li>
            <li><a data-toggle="pill" href="#POD7">POD 7</a></li>
            <li><a data-toggle="pill" href="#TRAINING">Training</a></li>
            <li><a data-toggle="pill" href="#CLOSERS">Closers</a></li>
            <li><a data-toggle="pill" href="#ADMIN">Admin</a></li>

            <form action="" method="GET">
                <div class="form-group col-xs-3">
                    <label class="col-md-4 control-label" for="query"></label>
                    <select id="OPTION" name="OPTION" class="form-control" onchange="this.form.submit()" required>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 1') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 1" selected>POD 1</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 2') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 2">POD 2</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 3') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 3">POD 3</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 4') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 4">POD 4</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 5') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 5">POD 5</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'POD 6') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 6">POD 6</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'TRAINING') {
                                echo "selected";
                            }
                        }
                        ?> value="TRAINING">Training</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'CLOSERS') {
                                echo "selected";
                            }
                        }
                        ?> value="CLOSERS">Closers</option>
                        <option <?php
                        if (isset($OPTION)) {
                            if ($OPTION == 'ADMIN') {
                                echo "selected";
                            }
                        }
                        ?> value="Admin">Admin</option>
                    </select>
                </div>
            </form>
        </ul>       
        <div class="tab-content">
            <div id="OVERVIEW" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pad Statistics</h3>
                    </div>
                    <div class="panel-body">


                        <form action=" " method="get">

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($datefrom)) {
                                        echo $datefrom;
                                    }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($dateto)) {
                                        echo $dateto;
                                    }
                                    ?>" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>

                            </fieldset>
                        </form><br><br>
                        <div class="col-md-12">

                            <div class="col-md-4">
                                <?php
                                $stmt = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()");
                                $stmt->execute();
                                $data2 = $stmt->fetch(PDO::FETCH_ASSOC);

                                $stmt_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
GROUP BY pad_statistics_status");
                                $stmt_status->execute();
                                while ($data3 = $stmt_status->fetch(PDO::FETCH_ASSOC)) {
                                    ?> 
                                    <?php echo $data3['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data3['status_count'];
                                }

                                $TOTAL_COMM_ALL = number_format($data2['COMM'], 2);
                                ?>
                                Total: <?php echo "£$TOTAL_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

                                <?php echo "<h3>$Today_DATES</h3>"; ?>
                                <?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Team Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                                <?php
                                if (isset($datefrom)) {
                                    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date=:date AND pad_statistics_group='POD 1'");
                                    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
                                    $TODAY_PAD_CK->execute();
                                    if ($TODAY_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/TeamPAD.php');
                                        $TeamPad = new TeamPadModal($pdo);
                                        $TeamPadList = $TeamPad->getTeamPad($datefrom);
                                        require_once(__DIR__ . '/../views/pad/Team-PAD.php');
                                    }
                                } else {
                                    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date>=CURDATE()");
                                    $Team_PAD_CK->execute();
                                    if ($Team_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/TeamPAD.php');
                                        $TeamPad = new TeamPadModal($pdo);
                                        $TeamPadList = $TeamPad->getTeamPad();
                                        require_once(__DIR__ . '/../views/pad/Team-PAD.php');
                                    }
                                }
                                ?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>
                                <form method="post" action="<?php
                                if (isset($query) && $query == 'Edit') {
                                    echo '../php/Pad.php?query=edit';
                                } else {
                                    echo '../php/Pad.php?query=add';
                                }
                                ?>">
                                    <table id="pad" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Lead</th>
                                                <th>COMM</th>
                                                <th>Closer</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <?php
                                        if (isset($query) && $query == 'Edit') {

                                            $PAD_EDIT = $pdo->prepare("SELECT pad_statistics_group, pad_statistics_id, pad_statistics_lead, pad_statistics_closer, pad_statistics_notes, pad_statistics_status, pad_statistics_col FROM pad_statistics WHERE pad_statistics_id=:id");
                                            $PAD_EDIT->bindParam(':id', $PAD_ID, PDO::PARAM_INT);
                                            $PAD_EDIT->execute();
                                            if ($PAD_EDIT->rowCount() > 0) {
                                                $PAD_EDIT_result = $PAD_EDIT->fetch(PDO::FETCH_ASSOC);

                                                $PAD_group = $PAD_EDIT_result['pad_statistics_group'];
                                                $PAD_id = $PAD_EDIT_result['pad_statistics_id'];
                                                $PAD_lead = $PAD_EDIT_result['pad_statistics_lead'];
                                                $PAD_closer = $PAD_EDIT_result['pad_statistics_closer'];
                                                $PAD_notes = $PAD_EDIT_result['pad_statistics_notes'];
                                                $PAD_status = $PAD_EDIT_result['pad_statistics_status'];
                                                $PAD_our_col = $PAD_EDIT_result['pad_statistics_col'];
                                                ?>

                                                <input type="hidden" value="<?php echo $PAD_id; ?>" name="pad_id">
                                                <td><input size="12" class="form-control" type="text" name="lead" id="provider-json" value="<?php
                                                    if (isset($PAD_lead)) {
                                                        echo $PAD_lead;
                                                    }
                                                    ?>"></td>                      
                                                <td><input size="12" class="form-control" type="text" name="col" value="<?php
                                                    if (isset($PAD_our_col)) {
                                                        echo $PAD_our_col;
                                                    }
                                                    ?>"></td>
                                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php
                                                    if (isset($PAD_closer)) {
                                                        echo $PAD_closer;
                                                    }
                                                    ?>"></td>
                                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php
                                                    if (isset($PAD_notes)) {
                                                        echo $PAD_notes;
                                                    }
                                                    ?>"></td>
                                                <td>                   <select id="group" name="group" class="form-control" required>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 1') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 1" selected>POD 1</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 2') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 2">POD 2</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 3') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 3">POD 3</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 4') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 4">POD 4</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 5') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 5">POD 5</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 6') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 6">POD 6</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Training') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Training">Training</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Closers') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Closers">Closers</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Admin') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Admin">Admin</option>
                                                    </select></td>

                                                <td><select name="status" class="form-control" required>
                                                        <option>Select Status</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'White') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="White">White</option>                              
                                                        <option<?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Green') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Green">Green</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Red') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Red">Red</option>

                                                    </select></td>

                                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                                <td><a href="?query=CloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                                            <td><input size="12" class="form-control" type="text" name="col"></td>
                                            <td><input size="12" class="form-control" type="text" name="closer"></td>
                                            <td><input type="text" class="form-control" name="notes"></td>
                                            <td> <select name="group" class="form-control" required>
                                                    <option value="">Select Team</option>
                                                    <option value="POD 1">POD 1</option>
                                                    <option value="POD 2">POD 2</option>
                                                    <option value="POD 3">POD 3</option>
                                                    <option value="POD 4">POD 4</option>
                                                    <option value="POD 5">POD 5</option>
                                                    <option value="POD 6">POD 6</option>
                                                    <option value="POD 7">POD 7</option>
                                                    <option value="Training">Training</option>
                                                    <option value="Closers">Closers</option>
                                                    <option value="Admin">Admin</option>
                                                </select></td>
                                            <td> <select name="status" class="form-control" required>
                                                    <option value="">Select Status</option>
                                                    <option value="White">White</option>
                                                    <option value="Green">Green</option>
                                                    <option value="Red">Red</option>
                                                </select></td>
                                            <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
                                        <?php } ?>

                                    </table>
                                </form>
                                <?php
                                if (isset($datefrom)) {
                                    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date=:date");
                                    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
                                    $TODAY_PAD_CK->execute();
                                    if ($TODAY_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/TodayPAD.php');
                                        $TodayPad = new TodayPadModal($pdo);
                                        $TodayPadList = $TodayPad->getTodayPad($datefrom);
                                        require_once(__DIR__ . '/../views/pad/Today-PAD.php');
                                    }
                                } else {
                                    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date>=CURDATE()");
                                    $TODAY_PAD_CK->execute();
                                    if ($TODAY_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/TodayPAD.php');
                                        $TodayPad = new TodayPadModal($pdo);
                                        $TodayPadList = $TodayPad->getTodayPad();
                                        require_once(__DIR__ . '/../views/pad/Today-PAD.php');
                                    }
                                }
                                ?>           

                            </div>
                        </div>
                    </div>

                </div>
            </div><!--END OVERVIEW-->

            <div id="POD1" class="tab-pane fade">

                <div class="panel panel-default">
                    <div class="panel-heading">      
                        <h3 class="panel-title">POD 1 Statistics</h3>
                    </div>
                    <div class="panel-body">
                         <div class="col-md-12">

                            <div class="col-md-4">
                                <?php
                                $stmt5 = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-06'");
                                $stmt5->execute();
                                $data5 = $stmt5->fetch(PDO::FETCH_ASSOC);

                                $stmt_status6 = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-06'
GROUP BY pad_statistics_status");
                                $stmt_status6->execute();
                                while ($data6 = $stmt_status6->fetch(PDO::FETCH_ASSOC)) {
                                    ?> 
                                    <?php echo $data6['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data6['status_count'];
                                }

                                $TOTAL_COMM_ALL99 = number_format($data5['COMM'], 2);
                                ?>
                                Total: <?php echo "£$TOTAL_COMM_ALL99"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

                                <?php echo "<h3>Thursday 6th of April 2017</h3>"; ?>
                                <?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

  <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>
                                <form method="post" action="<?php
                                if (isset($query) && $query == 'Edit') {
                                    echo '../php/Pad.php?query=edit';
                                } else {
                                    echo '../php/Pad.php?query=add';
                                }
                                ?>">
                                    <table id="pad" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Lead</th>
                                                <th>COMM</th>
                                                <th>Closer</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <?php
                                        if (isset($query) && $query == 'Edit') {

                                            $PAD_EDIT = $pdo->prepare("SELECT pad_statistics_group, pad_statistics_id, pad_statistics_lead, pad_statistics_closer, pad_statistics_notes, pad_statistics_status, pad_statistics_col FROM pad_statistics WHERE pad_statistics_id=:id");
                                            $PAD_EDIT->bindParam(':id', $PAD_ID, PDO::PARAM_INT);
                                            $PAD_EDIT->execute();
                                            if ($PAD_EDIT->rowCount() > 0) {
                                                $PAD_EDIT_result = $PAD_EDIT->fetch(PDO::FETCH_ASSOC);

                                                $PAD_group = $PAD_EDIT_result['pad_statistics_group'];
                                                $PAD_id = $PAD_EDIT_result['pad_statistics_id'];
                                                $PAD_lead = $PAD_EDIT_result['pad_statistics_lead'];
                                                $PAD_closer = $PAD_EDIT_result['pad_statistics_closer'];
                                                $PAD_notes = $PAD_EDIT_result['pad_statistics_notes'];
                                                $PAD_status = $PAD_EDIT_result['pad_statistics_status'];
                                                $PAD_our_col = $PAD_EDIT_result['pad_statistics_col'];
                                                ?>

                                                <input type="hidden" value="<?php echo $PAD_id; ?>" name="pad_id">
                                                <td><input size="12" class="form-control" type="text" name="lead" id="provider-json" value="<?php
                                                    if (isset($PAD_lead)) {
                                                        echo $PAD_lead;
                                                    }
                                                    ?>"></td>                      
                                                <td><input size="12" class="form-control" type="text" name="col" value="<?php
                                                    if (isset($PAD_our_col)) {
                                                        echo $PAD_our_col;
                                                    }
                                                    ?>"></td>
                                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php
                                                    if (isset($PAD_closer)) {
                                                        echo $PAD_closer;
                                                    }
                                                    ?>"></td>
                                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php
                                                    if (isset($PAD_notes)) {
                                                        echo $PAD_notes;
                                                    }
                                                    ?>"></td>
                                                <td>                   <select id="group" name="group" class="form-control" required>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 1') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 1" selected>POD 1</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 2') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 2">POD 2</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 3') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 3">POD 3</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 4') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 4">POD 4</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 5') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 5">POD 5</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 6') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 6">POD 6</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Training') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Training">Training</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Closers') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Closers">Closers</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Admin') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Admin">Admin</option>
                                                    </select></td>

                                                <td><select name="status" class="form-control" required>
                                                        <option>Select Status</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'White') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="White">White</option>                              
                                                        <option<?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Green') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Green">Green</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Red') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Red">Red</option>

                                                    </select></td>

                                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                                <td><a href="?query=CloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                                            <td><input size="12" class="form-control" type="text" name="col"></td>
                                            <td><input size="12" class="form-control" type="text" name="closer"></td>
                                            <td><input type="text" class="form-control" name="notes"></td>
                                            <td> <select name="group" class="form-control" required>
                                                    <option value="">Select Team</option>
                                                    <option value="POD 1">POD 1</option>
                                                    <option value="POD 2">POD 2</option>
                                                    <option value="POD 3">POD 3</option>
                                                    <option value="POD 4">POD 4</option>
                                                    <option value="POD 5">POD 5</option>
                                                    <option value="POD 6">POD 6</option>
                                                    <option value="POD 7">POD 7</option>
                                                    <option value="Training">Training</option>
                                                    <option value="Closers">Closers</option>
                                                    <option value="Admin">Admin</option>
                                                </select></td>
                                            <td> <select name="status" class="form-control" required>
                                                    <option value="">Select Status</option>
                                                    <option value="White">White</option>
                                                    <option value="Green">Green</option>
                                                    <option value="Red">Red</option>
                                                </select></td>
                                            <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
                                        <?php } ?>

                                    </table>
                                </form>
                                <?php
                          
                                    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date<CURDATE()");
                                    $TODAY_PAD_CK->execute();
                                    if ($TODAY_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/YesterdayPAD.php');
                                        $YesterdayPad = new YesterdayPadModal($pdo);
                                        $YesterdayPadList = $YesterdayPad->getYesterdayPad();
                                        require_once(__DIR__ . '/../views/pad/Yesterday-PAD.php');
                                    }
                           
                                ?>           

                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- END POD 1 -->
 
            <div id="POD2" class="tab-pane fade">

                <div class="panel panel-default">
                    <div class="panel-heading">      
                        <h3 class="panel-title">POD 2 Statistics</h3>
                    </div>
                    <div class="panel-body">
                         <div class="col-md-12">

                            <div class="col-md-4">
                                <?php
                                $stmt6 = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-05'");
                                $stmt6->execute();
                                $data6 = $stmt6->fetch(PDO::FETCH_ASSOC);

                                $stmt_status7 = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-05'
GROUP BY pad_statistics_status");
                                $stmt_status7->execute();
                                while ($data7 = $stmt_status7->fetch(PDO::FETCH_ASSOC)) {
                                    ?> 
                                    <?php echo $data7['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data7['status_count'];
                                }

                                $TOTAL_COMM_ALL5 = number_format($data6['COMM'], 2);
                                ?>
                                Total: <?php echo "£$TOTAL_COMM_ALL5"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

                                <?php echo "<h3>Wednesday 5th of April 2017</h3>"; ?>
                                <?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

  <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>
                                <form method="post" action="<?php
                                if (isset($query) && $query == 'Edit') {
                                    echo '../php/Pad.php?query=edit';
                                } else {
                                    echo '../php/Pad.php?query=add';
                                }
                                ?>">
                                    <table id="pad" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Lead</th>
                                                <th>COMM</th>
                                                <th>Closer</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <?php
                                        if (isset($query) && $query == 'Edit') {

                                            $PAD_EDIT = $pdo->prepare("SELECT pad_statistics_group, pad_statistics_id, pad_statistics_lead, pad_statistics_closer, pad_statistics_notes, pad_statistics_status, pad_statistics_col FROM pad_statistics WHERE pad_statistics_id=:id");
                                            $PAD_EDIT->bindParam(':id', $PAD_ID, PDO::PARAM_INT);
                                            $PAD_EDIT->execute();
                                            if ($PAD_EDIT->rowCount() > 0) {
                                                $PAD_EDIT_result = $PAD_EDIT->fetch(PDO::FETCH_ASSOC);

                                                $PAD_group = $PAD_EDIT_result['pad_statistics_group'];
                                                $PAD_id = $PAD_EDIT_result['pad_statistics_id'];
                                                $PAD_lead = $PAD_EDIT_result['pad_statistics_lead'];
                                                $PAD_closer = $PAD_EDIT_result['pad_statistics_closer'];
                                                $PAD_notes = $PAD_EDIT_result['pad_statistics_notes'];
                                                $PAD_status = $PAD_EDIT_result['pad_statistics_status'];
                                                $PAD_our_col = $PAD_EDIT_result['pad_statistics_col'];
                                                ?>

                                                <input type="hidden" value="<?php echo $PAD_id; ?>" name="pad_id">
                                                <td><input size="12" class="form-control" type="text" name="lead" id="provider-json" value="<?php
                                                    if (isset($PAD_lead)) {
                                                        echo $PAD_lead;
                                                    }
                                                    ?>"></td>                      
                                                <td><input size="12" class="form-control" type="text" name="col" value="<?php
                                                    if (isset($PAD_our_col)) {
                                                        echo $PAD_our_col;
                                                    }
                                                    ?>"></td>
                                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php
                                                    if (isset($PAD_closer)) {
                                                        echo $PAD_closer;
                                                    }
                                                    ?>"></td>
                                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php
                                                    if (isset($PAD_notes)) {
                                                        echo $PAD_notes;
                                                    }
                                                    ?>"></td>
                                                <td>                   <select id="group" name="group" class="form-control" required>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 1') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 1" selected>POD 1</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 2') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 2">POD 2</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 3') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 3">POD 3</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 4') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 4">POD 4</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 5') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 5">POD 5</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'POD 6') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="POD 6">POD 6</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Training') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Training">Training</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Closers') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Closers">Closers</option>
                                                        <option <?php
                                                        if (isset($PAD_group)) {
                                                            if ($PAD_group == 'Admin') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Admin">Admin</option>
                                                    </select></td>

                                                <td><select name="status" class="form-control" required>
                                                        <option>Select Status</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'White') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="White">White</option>                              
                                                        <option<?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Green') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Green">Green</option>
                                                        <option <?php
                                                        if (isset($PAD_status)) {
                                                            if ($PAD_status == 'Red') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="Red">Red</option>

                                                    </select></td>

                                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                                <td><a href="?query=CloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                                            <td><input size="12" class="form-control" type="text" name="col"></td>
                                            <td><input size="12" class="form-control" type="text" name="closer"></td>
                                            <td><input type="text" class="form-control" name="notes"></td>
                                            <td> <select name="group" class="form-control" required>
                                                    <option value="">Select Team</option>
                                                    <option value="POD 1">POD 1</option>
                                                    <option value="POD 2">POD 2</option>
                                                    <option value="POD 3">POD 3</option>
                                                    <option value="POD 4">POD 4</option>
                                                    <option value="POD 5">POD 5</option>
                                                    <option value="POD 6">POD 6</option>
                                                    <option value="POD 7">POD 7</option>
                                                    <option value="Training">Training</option>
                                                    <option value="Closers">Closers</option>
                                                    <option value="Admin">Admin</option>
                                                </select></td>
                                            <td> <select name="status" class="form-control" required>
                                                    <option value="">Select Status</option>
                                                    <option value="White">White</option>
                                                    <option value="Green">Green</option>
                                                    <option value="Red">Red</option>
                                                </select></td>
                                            <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
                                        <?php } ?>

                                    </table>
                                </form>
                                <?php
                          
                                    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date) ='2017-04-05'");
                                    $TODAY_PAD_CK->execute();
                                    if ($TODAY_PAD_CK->rowCount() > 0) {

                                        require_once(__DIR__ . '/../models/pad/DayBeforeYesterdayPAD.php');
                                        $DayBeforeYesterdayPad = new DayBeforeYesterdayPadModal($pdo);
                                        $DayBeforeYesterdayPadList = $DayBeforeYesterdayPad->getDayBeforeYesterdayPad();
                                        require_once(__DIR__ . '/../views/pad/DayBeforeYesterday-PAD.php');
                                    }
                           
                                ?>           

                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- END POD 2 -->            
            
       </div><!--END TAB CONTENT-->
        </div>
        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

</body>
</html>